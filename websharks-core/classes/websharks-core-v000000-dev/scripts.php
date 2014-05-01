<?php
/**
 * Scripts.
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
		 * Scripts.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class scripts extends framework
		{
			/**
			 * @var array Handles for all front-side components.
			 *
			 * @by-constructor Set dynamically by the class constructor.
			 */
			public $front_side_components = array();

			/**
			 * @var array Handles for all stand-alone components.
			 *
			 * @by-constructor Set dynamically by the class constructor.
			 */
			public $stand_alone_components = array();

			/**
			 * @var array Handles for all menu page components.
			 *
			 * @by-constructor Set dynamically by the class constructor.
			 */
			public $menu_page_components = array();

			/**
			 * Constructor.
			 *
			 * @param object|array $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or a new ``$___instance_config`` array.
			 *
			 * @throws exception If this class is instantiated before the `init` action hook.
			 */
			public function __construct($___instance_config)
				{
					parent::__construct($___instance_config);

					if(!did_action('init'))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#init', NULL,
							$this->i18n('Doing it wrong (`init` hook has NOT been fired yet).')
						);
					// Add components & register scripts (based on context).

					$scripts_to_register = array(); // Initialize scripts to register.

					// Only if NOT already registered.
					if(!wp_script_is('jquery-ui-components', 'registered'))
						$scripts_to_register['jquery-ui-components'] = array(
							'deps' => array($this->___instance_config->core_ns_stub_with_dashes),
							'url'  => $this->©url->current_scheme().'//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js',
							'ver'  => $this->___instance_config->core_ns_with_dashes
						);
					// Only if core has NOT already been registered by another WebSharks™ plugin.
					if(!wp_script_is($this->___instance_config->core_ns_stub_with_dashes, 'registered'))
						$scripts_to_register[$this->___instance_config->core_ns_stub_with_dashes] = array(
							'deps'     => array('jquery', 'jquery-ui-components'),
							'url'      => $this->©url->to_core_dir_file('/client-side/scripts/core-libs').'/',
							'ver'      => $this->___instance_config->core_ns_with_dashes,

							'localize' => array( // Array of WebSharks™ Core JavaScript translations.

								'get___instance_config__failure'                     => $this->i18n('Could NOT instance config value for key: `%1$s`.'),
								'get___verifier__failure'                            => $this->i18n('Could NOT verifier for key: `%1$s`.'),
								'get___i18n__failure'                                => $this->i18n('Could NOT get translation string for key: `%1$s`.'),

								'view_source__doc_title'                             => $this->translate('Source'),
								'win_open__turn_off_popup_blockers'                  => $this->translate('Please turn off all popup blockers and try again.'),
								'ajax__invalid_type'                                 => $this->i18n('Invalid `type`. Expecting `$$.___public_type|$$.___protected_type|$$.___private_type`.'),

								'check_arg_types__empty'                             => $this->i18n('empty'),
								'check_arg_types__caller'                            => $this->i18n('caller'),

								'validate_ui_form__required_field'                   => $this->translate('This is a required field.'),
								'validate_ui_form__mismatch_fields'                  => $this->translate('Mismatch (please check these fields).'),
								'validate_ui_form__unique_field'                     => $this->translate('Please try again (this value MUST be unique please).'),

								'validate_ui_form__required_select_at_least_one'     => $this->translate('Please select at least 1 option.'),
								'validate_ui_form__required_select_at_least'         => $this->translate('Please select at least %1$s options.'),

								'validate_ui_form__required_file'                    => $this->translate('A file MUST be selected please.'),
								'validate_ui_form__required_file_at_least_one'       => $this->translate('Please select at least one file.'),
								'validate_ui_form__required_file_at_least'           => $this->translate('Please select at least %1$s files.'),

								'validate_ui_form__required_radio'                   => $this->translate('Please choose one of the available options.'),

								'validate_ui_form__required_checkbox'                => $this->translate('This box MUST be checked please.'),
								'validate_ui_form__required_check_at_least_one'      => $this->translate('Please check at least one box.'),
								'validate_ui_form__required_check_at_least'          => $this->translate('Please check at least %1$s boxes.'),

								'validate_ui_form__validation_description_prefix'    => $this->translate('<strong>REQUIRES:</strong>'),
								'validate_ui_form__or_validation_description_prefix' => $this->translate('<strong>OR:</strong>'),

								'validate_ui_form__check_issues_below'               => $this->translate('<strong>ERROR:</strong> please check the issues below.'),

								'check_arg_types__diff_object_type'                  => $this->i18n('[a different object type]'),
								'check_arg_types__missing_args'                      => $this->i18n('Missing required argument(s); `%1$s` requires `%2$s`, `%3$s` given.'),
								'check_arg_types__invalid_arg'                       => $this->i18n('Argument #%1$s passed to `%2$s` requires `%3$s`, %4$s`%5$s` given.'),

								'password_strength_mismatch_status__empty'           => $this->translate('password strength indicator'),
								'password_strength_mismatch_status__short'           => $this->translate('too short (6 character minimum)'),
								'password_strength_mismatch_status__weak'            => $this->translate('very weak (mix lowercase, uppercase, numbers & symbols)'),
								'password_strength_mismatch_status__good'            => $this->translate('good (reasonably strong)'),
								'password_strength_mismatch_status__strong'          => $this->translate('very strong'),
								'password_strength_mismatch_status__mismatch'        => $this->translate('mismatch')
							)
						);
					if(is_admin() && $this->©menu_page->is_plugin_page()) // For plugin menu pages.
						{
							$this->menu_page_components[] = $this->___instance_config->core_ns_stub_with_dashes.'--menu-pages';

							// Only if NOT already registered by another WebSharks™ plugin (and it should NOT be).
							if(!wp_script_is($this->___instance_config->core_ns_stub_with_dashes.'--menu-pages', 'registered'))
								$scripts_to_register[$this->___instance_config->core_ns_stub_with_dashes.'--menu-pages'] = array(
									'deps'     => array($this->___instance_config->core_ns_stub_with_dashes),
									'url'      => $this->©url->to_core_dir_file('/client-side/scripts/menu-pages/menu-pages.min.js'),
									'ver'      => $this->___instance_config->core_ns_with_dashes,

									'localize' => array( // WebSharks™ Core translations.

										'ready__docs__button_label'  => $this->i18n('Docs'),
										'ready__docs__dialog_title'  => $this->i18n('Documentation'),

										'ready__video__button_label' => $this->i18n('Video'),
										'ready__video__dialog_title' => $this->i18n('YouTube® Video Playlist'),
									)
								);
						}
					// Add jQuery™ (if loading via Google® instead of WordPress®).
					if(!is_admin() && $this->©options->get('scripts.front_side.load_jquery_via_google'))
						$scripts_to_register['jquery'] = array(
							'url' => $this->©url->current_scheme().'://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'
						);
					// Add jQuery™ (if loading via Google® instead of WordPress®).
					if(is_admin() && $this->©options->get('scripts.admin_side.load_jquery_via_google'))
						$scripts_to_register['jquery'] = array(
							'url' => $this->©url->current_scheme().'://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'
						);
					// Register scripts (if there are any to register).
					if($scripts_to_register) $this->register($scripts_to_register);

					// Add core inline data (i.e. inline JavaScript code) — for core libs.
					$this->add_data($this->___instance_config->core_ns_stub_with_dashes, $this->build_instance_config_for_core_inline_data());
					$this->add_data($this->___instance_config->core_ns_stub_with_dashes, $this->build_verifiers_for_core_inline_data());

					// Add core inline data (i.e. inline JavaScript code) — for menu pages.
					if(is_admin() && $this->©menu_page->is_plugin_page()) // For plugin menu pages.
						$this->add_data($this->___instance_config->core_ns_stub_with_dashes.'--menu-pages', $this->build_menu_page_inline_data());
				}

			/**
			 * Builds instance config for core inline data.
			 *
			 * @return string Instance config for core inline data.
			 */
			public function build_instance_config_for_core_inline_data()
				{
					if(isset($this->cache[__FUNCTION__])) return $this->cache[__FUNCTION__];

					$data = 'var $'.$this->___instance_config->plugin_root_ns_stub.'___instance_config = {';

					$data .= $this->©object->to_js($this->___instance_config, FALSE).','; // Include all properties.

					// Some additional JavaScript instance config properties. These require additional server-side processing.

					$data .= "'wp_load_url':'".$this->©string->esc_js_sq($this->©url->to_wp_abs_dir_file($this->©file->wp_load()))."',";
					$data .= "'core_dir_url':'".$this->©string->esc_js_sq($this->©url->to_core_dir_file())."',";

					$data .= "'plugin_dir_url':'".$this->©string->esc_js_sq($this->©url->to_plugin_dir_file())."',";
					$data .= "'plugin_data_dir_url':'".$this->©string->esc_js_sq($this->©url->to_plugin_data_dir_file())."',";
					$data .= "'plugin_pro_dir_url':'".$this->©string->esc_js_sq($this->©url->to_plugin_pro_dir_file())."',";

					$data .= "'has_pro':".(($this->©plugin->has_pro()) ? 'true' : 'false').",";

					$data = rtrim($data, ',').'};'; // Trim and close curly bracket.

					$data .= 'var $'.$this->___instance_config->core_ns_stub.'__current_plugin___instance_config = '.
					         '$'.$this->___instance_config->plugin_root_ns_stub.'___instance_config;';

					return ($this->cache[__FUNCTION__] = $data);
				}

			/**
			 * Builds verifiers for core inline data.
			 *
			 * @return string Verifiers for core inline data.
			 */
			public function build_verifiers_for_core_inline_data()
				{
					if(isset($this->cache[__FUNCTION__])) return $this->cache[__FUNCTION__];

					$data = 'var $'.$this->___instance_config->plugin_root_ns_stub.'___verifiers = {';

					if(is_admin() && ($current_menu_page_class = $current_menu_page_slug = $this->©menu_pages->is_plugin_page()))
						{
							$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages.®update_theme', $this::private_type).',';
							$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages__'.$current_menu_page_class.'.®update_content_panels_order', $this::private_type).',';
							$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages__'.$current_menu_page_class.'.®update_content_panels_state', $this::private_type).',';
							$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages__'.$current_menu_page_class.'.®update_sidebar_panels_order', $this::private_type).',';
							$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages__'.$current_menu_page_class.'.®update_sidebar_panels_state', $this::private_type).',';
						}
					$data .= $this->build_additional_verifiers_for_core_inline_data(); // Make this easy for class extenders.

					$data = rtrim($data, ',').'};'; // Trim and close curly bracket.

					$data .= 'var $'.$this->___instance_config->core_ns_stub.'__current_plugin___verifiers = '.
					         '$'.$this->___instance_config->plugin_root_ns_stub.'___verifiers;';

					return ($this->cache[__FUNCTION__] = $data);
				}

			/**
			 * Builds additional verifiers for inline data.
			 *
			 * @extenders Can be overridden by class extenders that need additional verifiers.
			 *
			 * @return string Additional verifiers for inline data.
			 */
			public function build_additional_verifiers_for_core_inline_data()
				{
					if(isset($this->cache[__FUNCTION__]))
						return $this->cache[__FUNCTION__];

					return ($this->cache[__FUNCTION__] = '');
				}

			/**
			 * Builds front-side inline data.
			 *
			 * @return string Front-side inline data.
			 */
			public function build_front_side_inline_data()
				{
					if(isset($this->cache[__FUNCTION__]))
						return $this->cache[__FUNCTION__];

					return ($this->cache[__FUNCTION__] = '');
				}

			/**
			 * Builds stand-alone inline data.
			 *
			 * @return string Stand-alone inline data.
			 */
			public function build_stand_alone_inline_data()
				{
					if(isset($this->cache[__FUNCTION__]))
						return $this->cache[__FUNCTION__];

					return ($this->cache[__FUNCTION__] = '');
				}

			/**
			 * Builds menu page inline data.
			 *
			 * @return string Menu page inline data.
			 */
			public function build_menu_page_inline_data()
				{
					if(isset($this->cache[__FUNCTION__]))
						return $this->cache[__FUNCTION__];

					return ($this->cache[__FUNCTION__] = '');
				}

			/**
			 * Plugin components (selective components which apply in the current context).
			 *
			 * @param string|array $others Any other components that we'd like to include in the return value.
			 *    Helpful if we're pulling all current components, along with something else.
			 *
			 * @return array Plugin components (selective components which apply in the current context).
			 *    See also ``$this->©plugin->needs_*()``; where filters are implemented via easy-to-use methods.
			 */
			public function contextual_components($others = array())
				{
					$this->check_arg_types(array('string', 'array'), func_get_args());

					$components = array(); // Initialize array.
					$others     = ($others) ? (array)$others : array();

					if(!is_admin() && $this->©options->get('scripts.front_side.load'))
						if($this->apply_filters('front_side', (boolean)$this->©options->get('scripts.front_side.load_by_default')))
							$components = array_merge($components, $this->front_side_components);

					if(!is_admin() && $this->©options->get('scripts.front_side.load'))
						if($this->apply_filters('stand_alone', FALSE)) // Stand-alone is always off by default.
							$components = array_merge($components, $this->stand_alone_components);

					if(is_admin() && $this->©menu_page->is_plugin_page()) // No filters (already loaded selectively).
						$components = array_merge($components, $this->menu_page_components);

					return array_unique(array_merge($components, $others));
				}

			/**
			 * Registers scripts with WordPress®.
			 *
			 * @param array $scripts An array of scripts to register.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If a default script is NOT configured properly.
			 */
			public function register($scripts)
				{
					$this->check_arg_types('array', func_get_args());

					foreach($scripts as $_handle => $_script)
						{
							if(!is_array($_script) // Validates?
							   || !$this->©string->is_not_empty($_script['url'])
							) // This MUST be an array with a `url` string.
								throw $this->©exception(
									$this->method(__FUNCTION__).'#url_missing', get_defined_vars(),
									$this->i18n('Invalid script configuration. Missing and/or invalid `url`.').
									' '.sprintf($this->i18n('Problematic script handle: `%1$s`.'), $_handle)
								);

							// Additional configurations (all optional).
							$_script['deps']      = $this->©array->isset_or($_script['deps'], array());
							$_script['ver']       = $this->©string->isset_or($_script['ver'], '');
							$_script['ver']       = ($_script['ver']) ? $_script['ver'] : NULL;
							$_script['in_footer'] = $this->©boolean->isset_or($_script['in_footer'], FALSE);

							// Filter for site owners needing specific scripts in the footer.
							$_script['in_footer'] = $this->apply_filters('in_footer', $_script['in_footer'], $_handle);

							wp_deregister_script($_handle);
							wp_register_script($_handle, $_script['url'], $_script['deps'], $_script['ver'], $_script['in_footer']);

							if($this->©array->is_not_empty($_script['localize'])) // Translation data?
								wp_localize_script($_handle, '$'.$this->©string->with_underscores($_handle).'___i18n', $_script['localize']);

							if($this->©string->is_not_empty($_script['data'])) // Additional inline data?
								$this->add_data($_handle, $_script['data']); // WordPress® is currently lacking this feature.
						}
					unset($_handle, $_script);
				}

			/**
			 * Prints stand-alone/front-side scripts.
			 *
			 * @attaches-to WordPress® `wp_print_scripts` hook.
			 * @hook-priority `9` (before default priority).
			 */
			public function wp_print_scripts()
				{
					if(!is_admin()) // Front-side.
						$this->enqueue($this->contextual_components());
				}

			/**
			 * Print admin scripts.
			 *
			 * @attaches-to WordPress® `admin_print_scripts` hook.
			 * @hook-priority `9` (before default priority).
			 */
			public function admin_print_scripts()
				{
					if(is_admin()) // Admin-side.
						$this->enqueue($this->contextual_components());
				}

			/**
			 * Prints specific scripts.
			 *
			 * @param string|array $components A string, or an array of specific components to print.
			 */
			public function print_scripts($components)
				{
					$this->check_arg_types(array('string', 'array'), func_get_args());

					$components = (array)$components; // Force an array value.

					global $wp_scripts; // Global object reference.

					if(!($wp_scripts instanceof \WP_Scripts))
						$wp_scripts = new \WP_Scripts();

					foreach(($components = array_unique($components)) as $_key => $_handle)
						if(!$this->©string->is_not_empty($_handle) || !wp_script_is($_handle, 'registered'))
							unset($components[$_key]); // Remove (NOT a handle, or NOT registered).
					unset($_key, $_handle); // Housekeeping.

					if($components) // Still have something to print?
						$wp_scripts->do_items($components);
				}

			/**
			 * Enqueues scripts (even if they'll appear in the footer).
			 *
			 * @param string|array $components A string, or an array of specific components to enqueue.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function enqueue($components)
				{
					$this->check_arg_types(array('string', 'array'), func_get_args());

					$components = (array)$components; // Force array value.

					foreach(($components = array_unique($components)) as $_handle)
						if($this->©string->is_not_empty($_handle) && wp_script_is($_handle, 'registered'))
							if(!wp_script_is($_handle, 'queue')) // NOT in the queue?
								wp_enqueue_script($_handle);
					unset($_handle); // Housekeeping.
				}

			/**
			 * Dequeues scripts (if it's NOT already too late).
			 *
			 * @param string|array $components A string, or an array of specific components to dequeue.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function dequeue($components)
				{
					$this->check_arg_types(array('string', 'array'), func_get_args());

					$components = (array)$components; // Force array value.

					foreach(($components = array_unique($components)) as $_handle)
						if($this->©string->is_not_empty($_handle) && wp_script_is($_handle, 'registered'))
							if(wp_script_is($_handle, 'queue')) // In the queue?
								wp_dequeue_script($_handle);
					unset($_handle); // Housekeeping.
				}

			/**
			 * Adds script data to registered components.
			 *
			 * @note This method implements the ability to add additional inline data to specific scripts.
			 *    As of v3.4, WordPress® is still lacking functions to interact w/ this feature.
			 *    Therefore, we'll need to access ``$wp_scripts`` directly.
			 *
			 * @param string|array $components A string, or an array of specific components that need ``$data`` (i.e. inline JavaScript code).
			 *
			 * @param string       $data The data (i.e. inline JavaScript code) that is needed by ``$components``.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function add_data($components, $data)
				{
					$this->check_arg_types(array('string', 'array'), 'string', func_get_args());

					$components = (array)$components; // Force array value.

					global $wp_scripts; // Global object reference.

					if(!($wp_scripts instanceof \WP_Scripts))
						$wp_scripts = new \WP_Scripts();

					foreach(($components = array_unique($components)) as $_handle)
						if($this->©string->is_not_empty($_handle) && wp_script_is($_handle, 'registered'))
							{
								$existing_data = $wp_scripts->get_data($_handle, 'data');
								$wp_scripts->add_data($_handle, 'data', trim($existing_data."\n".$data));
							}
				}
		}
	}