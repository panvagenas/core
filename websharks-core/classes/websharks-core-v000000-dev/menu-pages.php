<?php
/**
 * Menu Page Utilities.
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
	 * Menu Page Utilities.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class menu_pages extends framework
	{
		/**
		 * Handles WordPress® `admin_menu` hook.
		 *
		 * @extenders Should be overridden by class extenders, if a plugin has menu pages.
		 *
		 * @attaches-to WordPress® `admin_menu` hook.
		 * @hook-priority Default is fine.
		 *
		 * @return null Nothing.
		 *
		 * @assert () === NULL
		 */
		public function admin_menu()
		{
		}

		/**
		 * Handles WordPress® `network_admin_menu` hook.
		 *
		 * @extenders Should be overridden by class extenders, if a plugin has menu pages.
		 *
		 * @attaches-to WordPress® `network_admin_menu` hook.
		 * @hook-priority Default is fine.
		 *
		 * @return null Nothing.
		 *
		 * @assert () === NULL
		 */
		public function network_admin_menu()
		{
		}

		/**
		 * Is this an administrative page for the current plugin?
		 *
		 * @param string|array $slug_s Optional. By default, we simply check to see if this is an administrative page for the current plugin.
		 *    If this is a string (NOT empty), we'll also check if it's a specific page (for the current plugin), matching: ``$slug_s``.
		 *    If this is an array, we'll check if it's any page (for the current plugin), in the array of: ``$slug_s``.
		 *    If this is an array, the array can also contain wildcard patterns (optional).
		 *
		 * @note The value of ``$slug_s``, whether it be a string or an array, should attempt to match ONLY the page slug itself, and NOT the full prefixed value.
		 *    Each page name for the current plugin is dynamically prefixed with ``$this->___instance_config->plugin_root_ns_stub.'__[page_slug]``.
		 *    The prefix should be excluded from ``$slug_s`` values. In other words, we're only testing for `[page_slug]` here.
		 *
		 * @return string|boolean A string with the `[page slug]` value, if this an administrative page for the current plugin;
		 *    matching a possible ``$slug_s`` string|array value. Otherwise, this returns FALSE by default.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert () === FALSE
		 */
		public function is_plugin_page($slug_s = array())
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			if(is_admin() && ($current_page = $this->©vars->_GET('page')) && $this->©string->is_not_empty($current_page))
			{
				if(preg_match('/^'.preg_quote($this->___instance_config->plugin_root_ns_stub, '/').'(?:__(?P<slug>.+))?$/', $current_page, $_page))
				{
					$this->©string->is_not_empty_or($_page['slug'], $this->___instance_config->plugin_root_ns_stub, TRUE);

					if(!$slug_s) // Not looking for anything in particular?
						return $_page['slug'];

					else if(is_string($slug_s) && $_page['slug'] === $slug_s)
						return $_page['slug'];

					else if(is_array($slug_s) && $this->©string->in_wildcard_patterns($_page['slug'], $slug_s))
						return $_page['slug'];
				}
				unset($_page); // Housekeeping.
			}
			return FALSE; // Default return value.
		}

		/**
		 * Adds an array of menu page configurations.
		 *
		 * @param array $menu_pages An array of menu page configurations.
		 *
		 * @return null Nothing. Simply adds each of the menu pages defined in the configuration array.
		 *
		 * @throws exception If invalid types are passed through the arguments list.
		 * @throws exception If the array of ``$menu_pages`` is empty, or contains an invalid configuration set.
		 *
		 * @wp-admin-assert // This assertion is difficult to test, because it requires administrative privileges (and the admin files must also be loaded).
		 * $menu_pages = array(array('doc_title' => 'Doc Page', 'menu_title' => 'Menu Title', 'cap_required' => 'install_plugins', 'icon' => 'about:blank', 'displayer' => array($this->object, '__return_false')));
		 *    ($menu_pages) === NULL
		 *
		 * @assert $menu_pages = array(array('doc_title' => 'Doc Page'));
		 *    ($menu_pages) throws exception
		 *
		 * @assert $menu_pages = array();
		 *    ($menu_pages) throws exception
		 */
		public function add($menu_pages)
		{
			$this->check_arg_types('array:!empty', func_get_args());

			foreach($menu_pages as $_slug => $_menu_page) // Add each of these menu pages.
			{
				if($this->©string->is_not_empty($_slug) && is_array($_menu_page)
				   && $this->©strings->are_not_empty($_menu_page['doc_title'], $_menu_page['menu_title'], $_menu_page['cap_required'])
				   && $this->©array->is_not_empty($_menu_page['displayer'])
				) // Have everything we need? Else throw an exception.
				{
					if($this->©string->is_not_empty($_menu_page['is_under'])) // A sub-menu page?
					{
						// This looks for a preceding triple `___`, in the ``$_slug``.
						// We use this to indicate an identical slug/key, which should be used again, for a sub-menu page.
						// This makes it possible to add a duplicate menu page, as a sub-item, which represents the main menu.
						// If this is NOT done explicitly, WordPress® does it automatically, using the main menu title.
						if(strpos($_slug, '___') === 0)
							$_slug = (string)substr($_slug, 3);
						else $_slug = $_menu_page['is_under'].'__'.$_slug;

						add_submenu_page($_menu_page['is_under'], $_menu_page['doc_title'], $_menu_page['menu_title'], $_menu_page['cap_required'], $_slug, $_menu_page['displayer']);
					}
					else add_menu_page($_menu_page['doc_title'], $_menu_page['menu_title'], $_menu_page['cap_required'], $_slug, $_menu_page['displayer'], $this->©string->isset_or($_menu_page['icon'], ''));
				}
				else throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_menu_page_config', get_defined_vars(),
					sprintf($this->__('Invalid menu page configuration: %1$s'), $this->©var->dump($_menu_page))
				);
			}
			unset($_slug, $_menu_page); // A little housekeeping.
		}

		/**
		 * Builds a URL leading to a menu page, for the current plugin.
		 *
		 * @param string $slug Optional slug.
		 *    A slug indicating a specific page we need to build a URL to.
		 *    If empty, the URL will lead to the main plugin page.
		 *
		 * @param string $content_panel_slug Optional panel slug.
		 *    A specific content panel slug to display upon reaching the menu page.
		 *
		 * @param string $sidebar_panel_slug Optional panel slug.
		 *    A specific sidebar panel slug to display upon reaching the menu page.
		 *
		 * @return string A full URL leading to a menu page, for the current plugin.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert () matches '/\?page\=websharks_core$/'
		 * @assert ('slug') matches '/\?page\=websharks_core__slug$/'
		 * @assert ('slug', 'content_panel') matches '/\?page\=websharks_core__slug#\!content_panel_slug\=content_panel$/'
		 * @assert ('slug', '', 'sidebar_panel') matches '/\?page\=websharks_core__slug#\!sidebar_panel_slug\=sidebar_panel$/'
		 * @assert ('slug', 'content_panel', 'sidebar_panel') matches '/\?page\=websharks_core__slug#\!content_panel_slug\=content_panel&sidebar_panel_slug\=sidebar_panel$/'
		 */
		public function url($slug = '', $content_panel_slug = '', $sidebar_panel_slug = '')
		{
			$this->check_arg_types('string', 'string', 'string', func_get_args());

			$page_arg = array('page' => $this->___instance_config->plugin_root_ns_stub.(($slug) ? '__'.$slug : ''));
			$url      = add_query_arg(urlencode_deep($page_arg), $this->©url->to_wp_admin_uri('/admin.php'));

			if($content_panel_slug) // A specific content panel slug?
				$url = $this->©url->add_query_hash('content_panel_slug', $content_panel_slug, $url);

			if($sidebar_panel_slug) // A specific sidebar panel slug?
				$url = $this->©url->add_query_hash('sidebar_panel_slug', $sidebar_panel_slug, $url);

			return $url;
		}

		/**
		 * Updates the administrative theme for all menu pages.
		 *
		 * @param string $new_theme The new theme that's been selected for use.
		 *
		 * @return null Nothing. Simply updates the administrative theme for all menu pages.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ®update_theme($new_theme)
		{
			$this->check_arg_types('string', func_get_args());

			$this->©options->update(array('menu_pages.theme' => $new_theme));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}

		/**
		 * Updates current options with one or more new option values.
		 *
		 * @note It's fine to force an update by calling this method without any arguments.
		 *
		 * @param array $new_options Optional. An associative array of option values to update, with each of their new values.
		 *    This array does NOT need to contain all of the current options. Only those which should be updated.
		 *
		 * @return null Nothing. Simply updates current options with one or more new option values.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert $options = array('menu_pages.theme' => 'jquery-ui-theme-default');
		 *    ($options) === NULL
		 */
		public function ®update_options($new_options = array())
		{
			$this->check_arg_types('array', func_get_args());

			$this->©options->update($new_options, TRUE);

			$this->©notice->enqueue( // Displays in plugin pages only.
				array('notice'   => $this->__('<p>Options saved successfully.</p>'),
				      'on_pages' => array($this->___instance_config->plugin_root_ns_stub.'*')));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}
	}
}