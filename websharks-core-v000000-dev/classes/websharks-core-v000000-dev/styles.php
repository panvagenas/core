<?php
/**
 * Styles.
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
	 * Styles.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class styles extends framework
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

			if(!did_action('init') && !defined('___UNIT_TEST'))
				throw $this->©exception(
					__METHOD__.'#init', NULL,
					$this->i18n('Doing it wrong (`init` hook has NOT been fired yet).')
				);

			// Add components & register styles (based on context).

			$styles_to_register = array(); // Initialize array of styles to register.

			// Only if core libs have NOT already been registered by another WebSharks™ plugin.
			if(!wp_style_is('ws-core-libs', 'registered')) // Available in all contexts.
				$styles_to_register['ws-core-libs'] = array(
					'url' => $this->©url->to_core_dir_or_file('/client-side/styles/core-libs/?'),
					'ver' => $this->___instance_config->core_ns_with_dashes
				);

			if(is_admin() || $this->©options->get('styles.front_side.load'))
			{
				foreach($this->jquery_ui_themes() as $_theme => $_theme_dir)
					// Only if theme has NOT already been registered by another WebSharks™ plugin.
					if(!wp_style_is($_theme, 'registered')) // Available in all contexts.
						$styles_to_register[$_theme] = array(
							'deps' => array('ws-core-libs'),
							'url'  => $this->©url->to_wp_abs_dir_or_file($_theme_dir.'/ui-theme-min.css'),
							'ver'  => $this->___instance_config->core_ns_with_dashes
						);
				unset($_theme, $_theme_dir); // A little housekeeping.
			}

			if(is_admin() && $this->©menu_page->is_plugin_page()) // For plugin menu pages.
			{
				$this->menu_page_components[] = $this->___instance_config->core_ns_stub_with_dashes.'--menu-pages';

				if(!in_array(($current_menu_pages_theme = $this->©options->get('menu_pages.theme')), array_keys($this->jquery_ui_themes()), TRUE))
					$current_menu_pages_theme = $this->©options->get('menu_pages.theme', TRUE);

				// Only if NOT already registered by another WebSharks™ plugin (it should NOT be).
				if(!wp_style_is($this->___instance_config->core_ns_stub_with_dashes.'--menu-pages', 'registered'))
					$styles_to_register[$this->___instance_config->core_ns_stub_with_dashes.'--menu-pages'] = array(
						'deps' => array($current_menu_pages_theme),
						'url'  => $this->©url->to_core_dir_or_file('/client-side/styles/menu-pages/menu-pages-min.css'),
						'ver'  => $this->___instance_config->core_ns_with_dashes
					);
			}
			if($styles_to_register) $this->register($styles_to_register); // Register styles.
		}

		/**
		 * An array of all jQuery™ UI themes.
		 *
		 * @return array An associative array of all jQuery™ UI themes.
		 *    Array keys are handles; values are absolute theme directory paths.
		 */
		public function jquery_ui_themes()
		{
			if(is_array($cache = $this->©db_cache->get('styles.jquery_ui_themes')))
				return $cache; // Already cached these.

			$themes = array(); // Initialize jQuery™ UI themes array.

			$dirs   = $this->©dirs->where_templates_may_reside();
			$dirs[] = dirname(dirname(dirname(__FILE__))).'/client-side';

			foreach(array_reverse($dirs) as $_dir) // For correct precedence.

				if(is_dir($_themes_dir = $_dir.'/styles/jquery-ui/themes'))
				{
					foreach(scandir($_themes_dir) as $_theme_dir)
					{
						if(strpos($_theme_dir, '.') === 0 || $_theme_dir === 'index.php')
							continue; // Skip all dots and `index.php` files.
						else if(file_exists($_themes_dir.'/'.$_theme_dir.'/ui-theme-min.css'))
							$themes['jquery-ui-theme-'.$_theme_dir] = $_themes_dir.'/'.$_theme_dir;
					}
					unset($_theme_dir); // Housekeeping.
				}
			unset($_dir, $_themes_dir); // Final housekeeping.

			return $this->©db_cache->update('styles.jquery_ui_themes', $themes);
		}

		/**
		 * Plugin components (selective components which apply in the current context).
		 *
		 * @param string|array $others Any other components that we'd like to include in the return value.
		 *    Helpful if we're pulling all current components, along with something else (like a theme).
		 *
		 * @return array Plugin components (selective components which apply in the current context).
		 *    See also ``$this->©plugin->needs_*()``; where filters are implemented via easy-to-use methods.
		 */
		public function contextual_components($others = array())
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$components = array(); // Initialize array.
			$others     = ($others) ? (array)$others : array();

			if(!is_admin() && $this->©options->get('styles.front_side.load'))
				if($this->apply_filters('front_side', (boolean)$this->©options->get('styles.front_side.load_by_default')))
					$components = array_merge($components, $this->front_side_components);

			if(!is_admin() && $this->©options->get('styles.front_side.load'))
				if($this->apply_filters('stand_alone', FALSE)) // Stand-alone is always off by default.
					$components = array_merge($components, $this->stand_alone_components);

			if(is_admin() && $this->©menu_page->is_plugin_page()) // No filters (already loaded selectively).
				$components = array_merge($components, $this->menu_page_components);

			return array_unique(array_merge($components, $others));
		}

		/**
		 * Registers styles with WordPress®.
		 *
		 * @param array $styles An array of styles to register.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If a default style is NOT configured properly.
		 */
		public function register($styles)
		{
			$this->check_arg_types('array', func_get_args());

			foreach($styles as $_handle => $_style)
			{
				if( // Validates?
					!is_array($_style)
					|| !$this->©string->is_not_empty($_style['url'])
				) // This MUST be an array with a `url` string.
					throw $this->©exception(
						__METHOD__.'#url_missing', compact('_handle', '_style'),
						$this->i18n('Invalid style configuration. Missing and/or invalid `url`.')
					);

				// Additional configurations (all optional).
				$_style['deps']  = $this->©array->isset_or($_style['deps'], array());
				$_style['ver']   = $this->©string->isset_or($_style['ver'], '');
				$_style['ver']   = ($_style['ver']) ? $_style['ver'] : NULL;
				$_style['media'] = $this->©string->isset_or($_style['media'], 'all');

				wp_deregister_style($_handle);
				wp_register_style($_handle, $_style['url'], $_style['deps'], $_style['ver'], $_style['media']);
			}
			unset($_handle, $_style);
		}

		/**
		 * Prints stand-alone/front-side styles.
		 *
		 * @attaches-to WordPress® `wp_print_styles` hook.
		 * @hook-priority `9` (before default priority).
		 */
		public function wp_print_styles()
		{
			if(!is_admin()) // Front-side.
				$this->enqueue($this->contextual_components());
		}

		/**
		 * Prints admin styles.
		 *
		 * @attaches-to WordPress® `admin_print_styles` hook.
		 * @hook-priority `9` (before default priority).
		 */
		public function admin_print_styles()
		{
			if(is_admin()) // Admin-side.
				$this->enqueue($this->contextual_components());
		}

		/**
		 * Prints specific styles.
		 *
		 * @param string|array $print A string, or an array of specific handles to print.
		 */
		public function print_styles($print)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$print = (array)$print; // Force an array value.

			global $wp_styles; // Global object reference.

			if(!($wp_styles instanceof \WP_Styles))
				$wp_styles = new \WP_Styles();

			foreach(($print = array_unique($print)) as $_key => $_handle)
				if(!$this->©string->is_not_empty($_handle) || !wp_style_is($_handle, 'registered'))
					unset($print[$_key]); // Remove (NOT a handle, or NOT registered).
			unset($_key, $_handle); // Housekeeping.

			if($print) // Still have something to print?
				$wp_styles->do_items($print);
		}

		/**
		 * Enqueues styles (even if they'll appear in the footer).
		 *
		 * @param string|array $enqueue A string, or an array of specific handles to enqueue.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function enqueue($enqueue)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$enqueue = (array)$enqueue; // Force array value.

			foreach(($enqueue = array_unique($enqueue)) as $_handle)
				if($this->©string->is_not_empty($_handle) && wp_style_is($_handle, 'registered'))
					if(!wp_style_is($_handle, 'queue')) // NOT in the queue?
						wp_enqueue_style($_handle);
			unset($_handle); // Housekeeping.
		}

		/**
		 * Dequeues styles (if it's NOT already too late).
		 *
		 * @param string|array $dequeue A string, or an array of specific handles to dequeue.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function dequeue($dequeue)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$dequeue = (array)$dequeue; // Force array value.

			foreach(($dequeue = array_unique($dequeue)) as $_handle)
				if($this->©string->is_not_empty($_handle) && wp_style_is($_handle, 'registered'))
					if(wp_style_is($_handle, 'queue')) // In the queue?
						wp_dequeue_style($_handle);
			unset($_handle); // Housekeeping.
		}
	}
}