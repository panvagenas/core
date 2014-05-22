<?php
/**
 * Menu Page (Base Class).
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace websharks_core_v000000_dev\menu_pages
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page (Base Class).
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class menu_page extends \websharks_core_v000000_dev\framework
	{
		/**
		 * @var string Slug for this menu page.
		 *
		 * @by-constructor Set dynamically by the class constructor.
		 *    This is always set to the base name of the class.
		 */
		public $slug = '';

		/**
		 * @var string Heading/title for this menu page.
		 *
		 * @extenders Should be overridden by class extenders.
		 */
		public $heading_title = '';

		/**
		 * @var string Sub-heading/description for this menu page.
		 *
		 * @extenders Should be overridden by class extenders.
		 */
		public $sub_heading_description = '';

		/**
		 * @var array Array of content panels for this menu page.
		 *
		 * @note Constructed dynamically, by adding panels via ``add_content_panel()``.
		 */
		public $content_panels = array();

		/**
		 * @var array Array of sidebar panels for this menu page.
		 *
		 * @note Constructed dynamically, by adding panels via ``add_sidebar_panel()``.
		 */
		public $sidebar_panels = array();

		/**
		 * @var boolean Should sidebar panels share a global order?
		 *
		 * @extenders Can be overridden by class extenders.
		 */
		public $sidebar_panels_share_global_order = TRUE;

		/**
		 * @var boolean Should sidebar panels share a global state?
		 *
		 * @extenders Can be overridden by class extenders.
		 */
		public $sidebar_panels_share_global_state = TRUE;

		/**
		 * @var boolean Defaults to FALSE. Does this menu page update options?
		 *    When TRUE, each menu page is wrapped with a form tag that calls `©menu_pages.®update_options`.
		 *    In addition, ``$this->option_fields`` will be populated, for easy access to a `©form_fields` instance.
		 *    In addition, each menu page will have a `Save All Options` button.
		 *
		 * @note This comes in handy, when a menu page is dedicated to updating options.
		 *    Making it possible for a site owner to update all options (i.e. from all panels), in one shot.
		 *    The `Save All Options` button at the bottom will facilitate this.
		 *
		 * @extenders Can easily be overridden by class extenders.
		 */
		public $updates_options = FALSE;

		/**
		 * @var null|\websharks_core_v000000_dev\form_fields Instance of form fields class, for option updates.
		 *
		 * @by-constructor Set dynamically by the class constructor.
		 *    Set only if ``$updates_options`` is TRUE.
		 */
		public $option_fields; // Defaults to a NULL value.

		/**
		 * Constructor.
		 *
		 * @param object|array $___instance_config Required at all times.
		 *    A parent object instance, which contains the parent's ``$___instance_config``,
		 *    or a new ``$___instance_config`` array.
		 */
		public function __construct($___instance_config)
		{
			parent::__construct($___instance_config);

			$this->slug = $this->___instance_config->ns_class_basename;

			$this->©db_cache->purge(); // Purge DB cache.
			// A menu page indicates data may change in some way.

			// Creates a ``©form_fields`` instance (for menu pages that update options).
			// A single class instance can be used by ALL panels loaded into the menu page.

			if($this->updates_options) // Does this menu page update options?
			{
				$this->option_fields = $this->©form_fields(
					array(
						'for_call'           => '©menu_pages.®update_options',
						'name_prefix'        => $this->©action->input_name_for_call_arg(1),
						'use_update_markers' => TRUE
					)
				);
			}
		}

		/**
		 * Displays HTML markup for this menu page.
		 *
		 * @attaches-to WordPress® `add_menu_page` or `add_submenu_page` handlers.
		 * @hook-priority Irrelevant. This is handled internally by WordPress®.
		 *
		 * @return null Nothing.
		 */
		public function display()
		{
			$this->display_notices();

			$this->display_header();

			$this->display_content_header();
			$this->display_content_panels();
			$this->display_content_footer();

			$this->display_sidebar_header();
			$this->display_sidebar_panels();
			$this->display_sidebar_footer();

			$this->display_footer();
		}

		/**
		 * Adds HTML markup for a menu page panel.
		 *
		 * @param panels\panel $panel A panel object instance.
		 *
		 * @param boolean      $sidebar Defaults to FALSE (by default, we assume this is a content panel).
		 *    Set this to TRUE, to indicate the addition of a panel for the sidebar.
		 *
		 * @param boolean      $active Defaults to FALSE. TRUE if this is an active panel (e.g. it should be open by default).
		 *
		 * @return null Nothing. Simply adds to the array of ``$this->(content|sidebar)_panels``.
		 *
		 * @throws \websharks_core_v000000_dev\exception If invalid types are passed through arguments list.
		 * @throws \websharks_core_v000000_dev\exception If ``$panel->slug`` or ``$panel->heading_title`` are empty.
		 */
		public function add_panel($panel, $sidebar = FALSE, $active = FALSE)
		{
			$this->check_arg_types($this->___instance_config->core_ns_prefix.'\\menu_pages\\panels\\panel',
			                       'boolean', 'boolean', func_get_args());
			// Validation.
			if(empty($panel->slug))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#slug_missing', get_defined_vars(),
					$this->__('Panel `slug` is empty. Check panel configuration.')
				);
			if(empty($panel->heading_title))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#heading_title_missing', get_defined_vars(),
					$this->__('Panel has no `heading_title`. Check panel configuration.')
				);
			// Exclusion?
			if($this->apply_filters('exclude_panel_by_slug', FALSE, $panel->slug))
				return; // Filters can exclude panels.

			if($sidebar) // This panel is for the sidebar?
			{
				$panel_index = ($this->sidebar_panels) ? count($this->sidebar_panels) - 1 : 0;

				$states                  = $this->get_sidebar_panel_states();
				$active_by_default_class = ( // Should this panel be active by default?
					($active && !in_array($panel->slug, $states['inactive'], TRUE))
					|| in_array($panel->slug, $states['active'], TRUE)
				) ? ' active-by-default' : '';
			}
			else // Otherwise, this is a content panel (default functionality).
			{
				$panel_index = ($this->content_panels) ? count($this->content_panels) - 1 : 0;

				$states                  = $this->get_content_panel_states();
				$active_by_default_class = ( // Should this panel be active by default?
					($active && !in_array($panel->slug, $states['inactive'], TRUE))
					|| in_array($panel->slug, $states['active'], TRUE)
				) ? ' active-by-default' : '';
			}
			// Common classes/attributes.
			$common_classes = array('panel', 'panel--'.esc_attr($this->©string->with_dashes($panel->slug)).esc_attr($active_by_default_class));
			$common_attrs   = 'data-panel-slug="'.esc_attr($panel->slug).'" data-panel-index="'.esc_attr($panel_index).'"';

			// Wrapper and container divs.
			$markup = '<div class="'.esc_attr(implode(' ', $common_classes)).' wrapper" '.$common_attrs.'>';
			$markup .= '<div class="'.esc_attr(implode(' ', $common_classes)).' container" '.$common_attrs.'>';

			// Header for this panel.
			$markup .= '<h3 class="'.esc_attr(implode(' ', $common_classes)).' heading-title" '.$common_attrs.'>'.
			           '<a class="'.esc_attr(implode(' ', $common_classes)).' heading-title-a" '.$common_attrs.' href="#'.esc_attr($panel->slug).'" name="'.esc_attr($panel->slug).'">'.
			           $panel->heading_title.
			           '</a>'.
			           '</h3>';

			// Content for this panel.
			$markup .= '<div class="'.esc_attr(implode(' ', $common_classes)).' content" '.$common_attrs.'>';

			// Additional docs (optional).
			if($panel->documentation)
				$markup .= '<div class="'.esc_attr(implode(' ', $common_classes)).' docs" '.$common_attrs.'>'.
				           $panel->documentation.
				           '<div class="clear"></div>'.
				           '</div>';

			// YouTube® video playlist (optional).
			if($panel->yt_playlist)
				$markup .= '<div class="'.esc_attr(implode(' ', $common_classes)).' video" '.$common_attrs.'>'.
				           $this->©video->yt_playlist_iframe_tag(
					           $panel->yt_playlist,
					           (($sidebar) ? array('height' => '152px') : array()),
					           array_merge($common_classes, array('video')),
					           $common_attrs
				           ).
				           '<div class="clear"></div>'.
				           '</div>';

			// Panel content body.
			$markup .= $panel->content_body;

			// Panel footer.
			$markup .= '<div class="clear"></div>';
			$markup .= '</div>';
			$markup .= '</div>';
			$markup .= '</div>';

			if($sidebar) // Add markup.
				$this->sidebar_panels[$panel->slug] = $markup;
			else $this->content_panels[$panel->slug] = $markup;
		}

		/**
		 * Adds HTML markup for a menu page content panel.
		 *
		 * @param panels\panel $panel A panel object instance.
		 *
		 * @param boolean      $active Defaults to FALSE. TRUE if this is an active panel (e.g. it should be open by default).
		 *
		 * @return null Nothing. Simply adds to the array of ``$this->content_panels``.
		 *
		 * @throws \websharks_core_v000000_dev\exception If invalid types are passed through arguments list.
		 * @throws \websharks_core_v000000_dev\exception If ``$panel_slug``, ``$panel_heading_title`` or ``$panel_content_body`` are empty.
		 *
		 * @alias See ``add_panel()`` for further details.
		 */
		public function add_content_panel($panel, $active = FALSE)
		{
			return $this->add_panel($panel, FALSE, $active);
		}

		/**
		 * Adds HTML markup for a menu page sidebar panel.
		 *
		 * @param panels\panel $panel A panel object instance.
		 *
		 * @param boolean      $active Defaults to FALSE. TRUE if this is an active panel (e.g. it should be open by default).
		 *
		 * @return null Nothing. Simply adds to the array of ``$this->sidebar_panels``.
		 *
		 * @throws \websharks_core_v000000_dev\exception If invalid types are passed through arguments list.
		 * @throws \websharks_core_v000000_dev\exception If ``$panel_slug``, ``$panel_heading_title`` or ``$panel_content_body`` are empty.
		 *
		 * @alias See ``add_panel()`` for further details.
		 */
		public function add_sidebar_panel($panel, $active = FALSE)
		{
			return $this->add_panel($panel, TRUE, $active);
		}

		/**
		 * Displays HTML markup for notices, for this menu page.
		 *
		 * @extenders Can be overridden by class extenders (e.g. by each menu page),
		 *    so that custom notices could be displayed in certain cases.
		 *
		 * @return null Nothing.
		 */
		public function display_notices()
		{
		}

		/**
		 * Displays HTML markup for a menu page header.
		 *
		 * @return null Nothing.
		 */
		public function display_header()
		{
			$classes[] = $this->___instance_config->core_ns_stub_with_dashes;
			$classes[] = $this->___instance_config->plugin_root_ns_stub_with_dashes;

			if(!in_array(($current_menu_pages_theme = $this->©options->get('menu_pages.theme')), array_keys($this->©styles->jquery_ui_themes()), TRUE))
				$current_menu_pages_theme = $this->©options->get('menu_pages.theme', TRUE);

			$classes[] = 'ui'; // This enables WebSharks™ UI styles overall.
			$classes[] = str_replace('jquery-ui-theme-', 'ui-theme-', $current_menu_pages_theme);

			$classes[] = $this->___instance_config->core_ns_stub_with_dashes.'--menu-page';
			$classes[] = $this->___instance_config->plugin_root_ns_stub_with_dashes.'--menu-page';

			$classes[] = $this->___instance_config->core_ns_stub_with_dashes.'--menu-page--'.$this->©string->with_dashes($this->slug);
			$classes[] = $this->___instance_config->plugin_root_ns_stub_with_dashes.'--menu-page--'.$this->©string->with_dashes($this->slug);

			echo '<div class="'.esc_attr(implode(' ', $classes)).'">';
			echo '<div class="menu-page wrapper">';
			echo '<div class="menu-page container">';

			echo '<div class="menu-page controls">';
			$this->display_header_controls();
			echo '<div class="clear"></div>';
			echo '</div>';

			echo '<h1 class="menu-page heading-title">['.$this->___instance_config->plugin_name.'] '.$this->heading_title.'</h1>';
			echo '<div class="menu-page sub-heading-description">'.$this->sub_heading_description.'</div>';
		}

		/**
		 * Displays HTML markup for controls in a menu page header.
		 *
		 * @return null Nothing.
		 */
		public function display_header_controls()
		{
			echo '<button class="controls toggle-all-content-panels">'.
			     $this->__('Toggle All Control Panels').
			     '</button>';

			echo '<button class="controls choose-theme">'.
			     $this->__('Choose Admin Theme').
			     '</button>';

			echo '<form method="POST" class="controls update-theme">';
			echo $this->©action->hidden_inputs_for_call('©menu_pages.®update_theme', $this::private_type);
			echo '<input type="hidden" name="'.esc_attr($this->©action->input_name_for_call_arg(1)).'" class="theme" />';

			$current_theme = $this->©options->get('menu_pages.theme');

			echo '<ul class="controls theme-options">';
			foreach($this->©styles->jquery_ui_themes() as $_theme => $_theme_dir)
				echo '<li'.(($_theme === $current_theme) ? ' class="current"' : '').' data-theme="'.esc_attr($_theme).'">'.
				     esc_html(ucwords(str_replace(array('jquery-ui-theme-', '-'), array('', ' '), $_theme))).
				     '</li>';
			unset($_theme, $_theme_dir);
			echo '</ul>';

			echo '</form>';
		}

		/**
		 * Displays HTML markup for a menu page footer.
		 *
		 * @return null Nothing.
		 */
		public function display_footer()
		{
			echo '<div class="clear"></div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}

		/**
		 * Displays HTML markup for a menu page content header.
		 *
		 * @return null Nothing.
		 */
		public function display_content_header()
		{
			echo '<div class="content wrapper">';
			echo '<div class="content container">';

			$this->display_before_content_panels();

			echo '<div class="content panels">';
		}

		/**
		 * Displays HTML markup before content panels, for this menu page.
		 *
		 * @return null Nothing.
		 */
		public function display_before_content_panels()
		{
			if($this->updates_options)
			{
				echo '<form method="POST" class="update-options ui-form">';
				echo $this->©action->hidden_inputs_for_call('©menu_pages.®update_options', $this::private_type);
			}
		}

		/**
		 * Displays HTML markup producing content panels for this menu page.
		 *
		 * @extenders Should be overridden by class extenders (e.g. by each menu page),
		 *    so that custom content panels can be displayed by this routine.
		 *
		 * @return null Nothing.
		 */
		public function display_content_panels()
		{
			$this->display_content_panels_in_order();
		}

		/**
		 * Displays HTML markup producing content panels for this menu page (in order).
		 *
		 * @extenders Should be called upon by class extenders (e.g. by each menu page),
		 *    so that custom content panels can be displayed by this routine.
		 *
		 * @return null Nothing.
		 */
		public function display_content_panels_in_order()
		{
			$content_panels_in_order_by_slug = $this->get_content_panel_order();
			$panel_slugs_displayed           = array();

			foreach($content_panels_in_order_by_slug as $_panel_slug)
			{
				if(!in_array($_panel_slug, $panel_slugs_displayed, TRUE))
					if($this->©string->is_not_empty($this->content_panels[$_panel_slug]))
					{
						$panel_slugs_displayed[] = $_panel_slug;
						echo $this->content_panels[$_panel_slug];
					}
			}
			unset($_panel_slug); // Housekeeping.

			foreach($this->content_panels as $_panel_slug => $_panel_markup)
			{
				if(!in_array($_panel_slug, $panel_slugs_displayed, TRUE))
					if($this->©string->is_not_empty($_panel_markup))
					{
						$panel_slugs_displayed[] = $_panel_slug;
						echo $_panel_markup;
					}
			}
			unset($_panel_slug, $_panel_markup); // Housekeeping.
		}

		/**
		 * Updates the order of content panels, for this menu page.
		 *
		 * @param array $new_order An array of content panel slugs for this menu page, in a specific order.
		 *
		 * @return null Nothing. Simply updates the order of content panels, for this menu page.
		 *
		 * @throws \websharks_core_v000000_dev\exception If invalid types are passed through arguments list.
		 */
		public function ®update_content_panels_order($new_order)
		{
			$this->check_arg_types('array', func_get_args());

			$order = $this->©options->get('menu_pages.panels.order');

			$order[$this->slug]['content_panels'] = $new_order;

			$this->©options->update(array('menu_pages.panels.order' => $order));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}

		/**
		 * Gets order for content panels in this menu page.
		 *
		 * @return array Array of content panel slug, in a specific order.
		 *    Possible for this to return empty arrays, if panels currently have only a default order.
		 */
		public function get_content_panel_order()
		{
			$order = $this->©options->get('menu_pages.panels.order');

			return $this->©array->isset_or($order[$this->slug]['content_panels'], array());
		}

		/**
		 * Updates the state of content panels, for this menu page.
		 *
		 * @param array $new_active An array of content panel slugs for this menu page, which are active.
		 *
		 * @param array $new_inactive An array of content panel slugs for this menu page, which are inactive.
		 *
		 * @return null Nothing. Simply updates the state of content panels, for this menu page.
		 *
		 * @throws \websharks_core_v000000_dev\exception If invalid types are passed through arguments list.
		 */
		public function ®update_content_panels_state($new_active, $new_inactive)
		{
			$this->check_arg_types('array', 'array', func_get_args());

			$state = $this->©options->get('menu_pages.panels.state');

			$state[$this->slug]['content_panels']['active']   = array_diff($new_active, $new_inactive);
			$state[$this->slug]['content_panels']['inactive'] = array_diff($new_inactive, $new_active);

			$this->©options->update(array('menu_pages.panels.state' => $state));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}

		/**
		 * Gets active/inactive states, for content panels in this menu page.
		 *
		 * @return array Two array elements, `active` and `inactive`, both arrays containing panel slugs.
		 *    Possible for this to return empty arrays, if panels currently have only a default state.
		 */
		public function get_content_panel_states()
		{
			$state = $this->©options->get('menu_pages.panels.state');
			$state = $this->©array->isset_or($state[$this->slug]['content_panels'], array());

			return array(
				'active'   => $this->©array->isset_or($state['active'], array()),
				'inactive' => $this->©array->isset_or($state['inactive'], array())
			);
		}

		/**
		 * Displays HTML markup after content panels, for this menu page.
		 *
		 * @return null Nothing.
		 */
		public function display_after_content_panels()
		{
			if($this->updates_options)
			{
				$form_fields = $this->option_fields;

				echo $form_fields->construct_field_markup(
					$form_fields->¤value($this->__('Save All Options')),
					array(
						'type'                => 'submit',
						'name'                => 'update_options',
						'div_wrapper_classes' => 'form-submit update-options'
					)
				);
				echo '</form>';
			}
		}

		/**
		 * Displays HTML markup for a menu page content footer.
		 *
		 * @return null Nothing.
		 */
		public function display_content_footer()
		{
			echo '<div class="clear"></div>';
			echo '</div>';

			$this->display_after_content_panels();

			echo '</div>';
			echo '</div>';
		}

		/**
		 * Displays HTML markup for a menu page sidebar header.
		 *
		 * @return null Nothing.
		 */
		public function display_sidebar_header()
		{
			echo '<div class="sidebar wrapper">';
			echo '<div class="sidebar container">';

			$this->display_before_sidebar_panels();

			echo '<div class="sidebar panels">';
		}

		/**
		 * Displays HTML markup before sidebar panels, for this menu page.
		 *
		 * @return null Nothing.
		 */
		public function display_before_sidebar_panels()
		{
		}

		/**
		 * Displays HTML markup producing sidebar panels for this menu page.
		 *
		 * @extenders Should be overridden by class extenders (e.g. by each menu page),
		 *    so that custom sidebar panels can be displayed by this routine.
		 *
		 * @return null Nothing.
		 */
		public function display_sidebar_panels()
		{
			$this->display_sidebar_panels_in_order();
		}

		/**
		 * Displays HTML markup producing sidebar panels for this menu page (in order).
		 *
		 * @extenders Should be called upon by class extenders (e.g. by each menu page),
		 *    so that custom sidebar panels can be displayed by this routine.
		 *
		 * @return null Nothing.
		 */
		public function display_sidebar_panels_in_order()
		{
			$sidebar_panels_in_order_by_slug = $this->get_sidebar_panel_order();
			$panel_slugs_displayed           = array();

			foreach($sidebar_panels_in_order_by_slug as $_panel_slug)
			{
				if(!in_array($_panel_slug, $panel_slugs_displayed, TRUE))
					if($this->©string->is_not_empty($this->sidebar_panels[$_panel_slug]))
					{
						$panel_slugs_displayed[] = $_panel_slug;
						echo $this->sidebar_panels[$_panel_slug];
					}
			}
			unset($_panel_slug); // Housekeeping.

			foreach($this->sidebar_panels as $_panel_slug => $_panel_markup)
			{
				if(!in_array($_panel_slug, $panel_slugs_displayed, TRUE))
					if($this->©string->is_not_empty($_panel_markup))
					{
						$panel_slugs_displayed[] = $_panel_slug;
						echo $_panel_markup;
					}
			}
			unset($_panel_slug, $_panel_markup); // Housekeeping.
		}

		/**
		 * Updates the order of sidebar panels, for this menu page.
		 *
		 * @param array $new_order An array of sidebar panel slugs for this menu page, in a specific order.
		 *
		 * @return null Nothing. Simply updates the order of sidebar panels, for this menu page.
		 *
		 * @throws \websharks_core_v000000_dev\exception If invalid types are passed through arguments list.
		 */
		public function ®update_sidebar_panels_order($new_order)
		{
			$this->check_arg_types('array', func_get_args());

			$order = $this->©options->get('menu_pages.panels.order');

			$global_order = $this->©array->isset_or($order['global']['sidebar_panels'], array());

			// Reverse prepend each slug in the new order.
			foreach(array_reverse($new_order) as $_panel_slug)
				array_unshift($global_order, $_panel_slug);
			unset($_panel_slug); // Housekeeping.

			// Reduce to a unique set of values.
			$global_order = array_unique($global_order);

			$order[$this->slug]['sidebar_panels'] = $new_order;
			$order['global']['sidebar_panels']    = $global_order;

			$this->©options->update(array('menu_pages.panels.order' => $order));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}

		/**
		 * Gets order for sidebar panels in this menu page.
		 *
		 * @return array Array of sidebar panel slug, in a specific order.
		 *    Possible for this to return empty arrays, if panels currently have only a default order.
		 */
		public function get_sidebar_panel_order()
		{
			$order = $this->©options->get('menu_pages.panels.order');

			if($this->sidebar_panels_share_global_order)
				return $this->©array->isset_or($order['global']['sidebar_panels'], array());
			else return $this->©array->isset_or($order[$this->slug]['sidebar_panels'], array());
		}

		/**
		 * Updates the state of sidebar panels, for this menu page.
		 *
		 * @param array $new_active An array of sidebar panel slugs for this menu page, which are active.
		 *
		 * @param array $new_inactive An array of sidebar panel slugs for this menu page, which are inactive.
		 *
		 * @return null Nothing. Simply updates the state of sidebar panels, for this menu page.
		 *
		 * @throws \websharks_core_v000000_dev\exception If invalid types are passed through arguments list.
		 */
		public function ®update_sidebar_panels_state($new_active, $new_inactive)
		{
			$this->check_arg_types('array', 'array', func_get_args());

			$state = $this->©options->get('menu_pages.panels.state');

			$global_active = $this->©array->isset_or($state['global']['sidebar_panels']['active'], array());
			$global_active = array_unique(array_merge($global_active, $new_active));
			$global_active = array_diff($global_active, $new_inactive);

			$global_inactive = $this->©array->isset_or($state['global']['sidebar_panels']['inactive'], array());
			$global_inactive = array_unique(array_merge($global_inactive, $new_inactive));
			$global_inactive = array_diff($global_inactive, $new_active);

			$state[$this->slug]['sidebar_panels']['active'] = array_diff($new_active, $new_inactive);
			$state['global']['sidebar_panels']['active']    = array_diff($global_active, $global_inactive);

			$state[$this->slug]['sidebar_panels']['inactive'] = array_diff($new_inactive, $new_active);
			$state['global']['sidebar_panels']['inactive']    = array_diff($global_inactive, $global_active);

			$this->©options->update(array('menu_pages.panels.state' => $state));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}

		/**
		 * Gets active/inactive states, for sidebar panels in this menu page.
		 *
		 * @return array Two array elements, `active` and `inactive`, both arrays containing panel slugs.
		 *    Possible for this to return empty arrays, if panels currently have only a default state.
		 */
		public function get_sidebar_panel_states()
		{
			$state = $this->©options->get('menu_pages.panels.state');

			if($this->sidebar_panels_share_global_state)
				$state = $this->©array->isset_or($state['global']['sidebar_panels'], array());
			else $state = $this->©array->isset_or($state[$this->slug]['sidebar_panels'], array());

			return array(
				'active'   => $this->©array->isset_or($state['active'], array()),
				'inactive' => $this->©array->isset_or($state['inactive'], array())
			);
		}

		/**
		 * Displays HTML markup after sidebar panels, for this menu page.
		 *
		 * @return null Nothing.
		 */
		public function display_after_sidebar_panels()
		{
		}

		/**
		 * Displays HTML markup for a menu page sidebar footer.
		 *
		 * @return null Nothing.
		 */
		public function display_sidebar_footer()
		{
			echo '<div class="clear"></div>';
			echo '</div>';

			$this->display_after_sidebar_panels();

			echo '</div>';
			echo '</div>';
		}
	}
}