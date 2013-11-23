<?php
/**
 * Notice Utilities.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace websharks_core_v000000_dev
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		/**
		 * Notice Utilities.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class notices extends framework
		{
			/**
			 * Enqueues an administrative notice.
			 *
			 * @param string|array $notice The notice itself (i.e. a string message).
			 *    Or, an array with notice configuration parameters.
			 *
			 * @return boolean TRUE if the notice was enqueued, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function enqueue($notice)
				{
					$this->check_arg_types(array('string', 'array'), func_get_args());

					// Force array.
					if(!is_array($notice))
						$notice = array('notice' => $notice);

					// Check for empty notices.
					if(!$this->©string->is_not_empty($notice['notice']))
						return FALSE; // Nothing to enqueue.

					// Gather notices/dismissals.
					if(!is_array($notices = get_option($this->___instance_config->plugin_root_ns_stub.'__notices')))
						update_option($this->___instance_config->plugin_root_ns_stub.'__notices', ($notices = array()));

					if(!is_array($dismissals = get_option($this->___instance_config->plugin_root_ns_stub.'__notice__dismissals')))
						add_option($this->___instance_config->plugin_root_ns_stub.'__notice__dismissals', ($dismissals = array()), '', 'no');

					// Standardize & add to array of enqueued notices.
					$notice = $this->standardize($notice);

					// This notice is already enqueued?
					if(isset($notices[$notice['checksum']]))
						return FALSE; // Nothing more to do here.

					// Enqueue this notice, ONLY if we're NOT allowing dismissals.
					// Or, if we ARE allowing dismissals, but this has NOT been dismissed yet.
					if(!$notice['allow_dismissals'] || !in_array($notice['checksum'], $dismissals, TRUE))
						{
							$notices[$notice['checksum']] = $notice;
							update_option($this->___instance_config->plugin_root_ns_stub.'__notices', $notices);
							return TRUE;
						}
					return FALSE; // Default return value.
				}

			/**
			 * Displays an administrative notice.
			 *
			 * @param string|array $notice The notice itself (i.e. a string message).
			 *    Or, an array with notice configuration parameters.
			 *
			 * @return boolean TRUE if the notice is displayed, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function display($notice)
				{
					$this->check_arg_types(array('string', 'array'), func_get_args());

					// Not in an administrative area?
					if(!is_admin()) return FALSE; // Do NOT display.

					// Force array.
					if(!is_array($notice))
						$notice = array('notice' => $notice);

					// Check for empty notices.
					if(!$this->©string->is_not_empty($notice['notice']))
						return FALSE; // Nothing to display.

					// Standardize this notice.
					$notice = $this->standardize($notice);

					if($notice['with_prefix']) // Adding a prefix?
						{
							$icon = ''; // Default. Assume we are NOT displaying an icon.

							if($notice['with_prefix_icon']) // An icon?
								$icon = '<span class="ui-icon ui-icon-'.esc_attr($notice['with_prefix_icon']).'"'.
								        ' style="display:none;"'. // Hide until CSS forces it to display.
								        '>'.
								        '</span>';

							if(stripos($notice['notice'], '<p>') === 0)
								$notice['notice'] = $this->©string->ireplace_once('<p>', '<p>'.$icon.'<strong>['.$this->___instance_config->plugin_name.' '.$this->i18n('says...').']</strong> ', $notice['notice']);
							else $notice['notice'] = '<p>'.$icon.'<strong>['.$this->___instance_config->plugin_name.' '.$this->i18n('says...').']</strong></p>'.$notice['notice'];
						}
					if($notice['allow_dismissals']) // Allowing dismissals?
						{
							if(!is_array($dismissals = get_option($this->___instance_config->plugin_root_ns_stub.'__notice__dismissals')))
								add_option($this->___instance_config->plugin_root_ns_stub.'__notice__dismissals', ($dismissals = array()), '', 'no');

							if(in_array($notice['checksum'], $dismissals, TRUE))
								return FALSE; // Already dismissed this notice.

							$dismiss = array($this->___instance_config->plugin_root_ns_stub.'__notice__dismiss' => $notice['checksum']);
							$dismiss = add_query_arg(urlencode_deep($dismiss), $this->©url->current_uri());

							$notice['notice'] .= ' [ <a href="'.$dismiss.'">'.$this->i18n('dismiss this message').'</a> ]';
						}
					$classes[] = $this->___instance_config->core_ns_stub_with_dashes;
					$classes[] = $this->___instance_config->plugin_root_ns_stub_with_dashes;

					if(!in_array(($current_menu_pages_theme = $this->©options->get('menu_pages.theme')), array_keys($this->©styles->jquery_ui_themes()), TRUE))
						$current_menu_pages_theme = $this->©options->get('menu_pages.theme', TRUE);

					$classes[] = 'ui'; // This enables WebSharks™ UI styles overall.
					$classes[] = str_replace('jquery-ui-theme-', 'ui-theme-', $current_menu_pages_theme);

					echo '<div class="'.esc_attr(implode(' ', $classes)).'">'.

					     '<div class="notice fade '.(($notice['error']) ? 'error' : 'updated').
					     ' ui-widget ui-state-'.(($notice['error']) ? 'error' : 'highlight').' ui-corner-all"'.
					     '>'. // With WordPress® styles (and also with WebSharks™ UI theme styles).

					     $notice['notice']. // HTML markup.

					     '<div class="clear"></div>'.
					     '</div>'.

					     '</div>';

					return TRUE; // Notice displayed indicator.
				}

			/**
			 * Handles `all_admin_notices` hook in WordPress®.
			 *
			 * Runs through all notices in the queue, and displays those which should be displayed.
			 *
			 * @note Notices are removed from the queue by this routine (automatically).
			 *
			 * @return boolean TRUE if any notices are displayed, else FALSE.
			 *
			 * @attaches-to `all_admin_notices` action hook.
			 * @hook-priority Default is fine.
			 */
			public function all_admin_notices()
				{
					// Not in an administrative area?
					if(!is_admin()) return FALSE; // Do NOT process.

					// Establish current area/page.
					$current_area = $this->©env->admin_area();
					$current_page = $this->©env->admin_page();

					// Gather notices/dismissals.
					if(!is_array($notices = get_option($this->___instance_config->plugin_root_ns_stub.'__notices')))
						update_option($this->___instance_config->plugin_root_ns_stub.'__notices', ($notices = array()));

					if(!is_array($dismissals = get_option($this->___instance_config->plugin_root_ns_stub.'__notice__dismissals')))
						add_option($this->___instance_config->plugin_root_ns_stub.'__notice__dismissals', ($dismissals = array()), '', 'no');

					// Possible dismissal via query string.
					$current_dismissal = $this->©vars->_REQUEST($this->___instance_config->plugin_root_ns_stub.'__notice__dismiss');

					// Initialize a few variables.
					$notices_require_update = $dismissals_require_update = $notices_displayed = FALSE;

					// Process the notice queue now.
					foreach($notices as $_checksum => $_notice) // Here we check on several things.
						{
							if(empty($_notice['in_areas']) || $this->©string->in_wildcard_patterns($current_area, $_notice['in_areas']))
								if(empty($_notice['on_pages']) || $this->©string->in_wildcard_patterns($current_page, $_notice['on_pages']))
									if(empty($_notice['on_time']) || strtotime('now') >= $_notice['on_time'])
										{
											$_has_been_dismissed = FALSE; // Initialize FALSE value.

											if($_notice['allow_dismissals']) // Allow dismissals?
												{
													if(in_array($_notice['checksum'], $dismissals, TRUE))
														$_has_been_dismissed = TRUE;

													else if($current_dismissal === $_notice['checksum'])
														$_has_been_dismissed = TRUE; // Dismissing right now.
												}
											if(!empty($_notice['notice']) && !$_has_been_dismissed) // Should display?
												{
													if($this->display($_notice)) // Did display?
														$notices_displayed = TRUE;
												}
											if(!$_notice['allow_dismissals'] || $_has_been_dismissed) // Dismiss?
												{
													unset($notices[$_checksum]);
													$notices_require_update = TRUE;

													if($_has_been_dismissed)
														{
															$dismissals_require_update = TRUE;
															$dismissals[]              = $_notice['checksum'];
														}
												}
										}
						}
					unset($_checksum, $_notice, $_has_been_dismissed); // Housekeeping.

					if($notices_require_update)
						update_option($this->___instance_config->plugin_root_ns_stub.'__notices', $notices);

					if($dismissals_require_update)
						update_option($this->___instance_config->plugin_root_ns_stub.'__notice__dismissals', array_unique($dismissals));

					return ($notices_displayed) ? TRUE : FALSE;
				}

			/**
			 * Standardizes a notice configuration array.
			 *
			 * @param array $notice An array of notice configuration parameters.
			 *
			 * @return array Standardized array of notice configuration parameters.
			 */
			public function standardize($notice)
				{
					$this->check_arg_types('array', func_get_args());

					$default_notice     = array(
						'notice'           => '',
						'error'            => FALSE,
						'on_pages'         => array(),
						'in_areas'         => array(),
						'on_time'          => 0,
						'with_prefix'      => TRUE,
						'with_prefix_icon' => !empty($notice['error']) ? 'alert' : 'info',
						'allow_dismissals' => FALSE,
						'checksum'         => '' // Determined below.
					);
					$notice             = $this->check_extension_arg_types(
					                           'string', 'boolean', 'array', 'array', 'integer', 'boolean', 'string', 'boolean', 'string',
					                           $default_notice, $notice
					);
					$notice             = $this->©array->ksort_deep($notice, SORT_STRING);
					$notice['checksum'] = md5(serialize($notice));

					return $notice; // Standardized now.
				}

			/**
			 * Adds data/procedures associated with this class.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen; and this method returns FALSE.
			 *
			 * @return boolean TRUE if successfully installed, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert () === FALSE
			 * @assert (TRUE) === TRUE
			 */
			public function activation_install($confirmation = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					if(!$confirmation)
						return FALSE; // Added security.

					return TRUE; // Nothing here (at least for now).
				}

			/**
			 * Removes data/procedures associated with this class.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen; and this method returns FALSE.
			 *
			 * @return boolean TRUE if successfully uninstalled, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert () === FALSE
			 * @assert (TRUE) === TRUE
			 */
			public function deactivation_uninstall($confirmation = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					if(!$confirmation)
						return FALSE; // Added security.

					delete_option($this->___instance_config->plugin_root_ns_stub.'__notices');
					delete_option($this->___instance_config->plugin_root_ns_stub.'__notice__dismissals');

					return TRUE;
				}
		}
	}