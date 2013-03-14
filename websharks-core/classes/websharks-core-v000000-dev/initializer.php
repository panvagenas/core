<?php
/**
 * Initializer.
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
		 * Initializer.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class initializer extends framework
		{
			/**
			 * Initialization routines/hooks.
			 *
			 * @attaches-to WordPress® `after_setup_theme` hook.
			 * @hook-priority `1`
			 */
			public function after_setup_theme()
				{
					if(!$this->©plugin->is_active_at_current_version())
						return; // Do NOT go any further here.

					// For plugins that need user initialization.
					if($this->©options->get('users.attach_init_hook'))
						add_action('init', array($this, '©user.init'), 1);

					// Handles no-cache headers/constants.
					add_action('init', array($this, '©no_cache.init'), 1);

					// For plugins that enable this option (only ONE plugin may add this hook).
					if($this->©options->get('php.evaluate') && !isset($this->static['hooks']['php.evaluate']))
						{
							add_action('init', array($this, '©php.init'), 2);
							$this->static['hooks']['php.evaluate'] = TRUE;
						}
					// Handles plugin actions.
					add_action('init', array($this, '©actions.init'), 2);

					// Other hooks on `wp_loaded` (misc routines).
					add_action('wp_loaded', array($this, '©crons.wp_loaded'), 9999);
					add_action('wp_loaded', array($this, '©db_utils.wp_loaded'), 10000);

					// For plugins that enable this option (only ONE plugin may add this hook).
					if($this->©options->get('compressor.enable') && !isset($this->static['hooks']['compressor']))
						{ // @TODO Move this out of the WebSharks™ Core and into it's own plugin.
							add_action('wp_loaded', array($this, '©compressor.wp_loaded'), 10000);
							$this->static['hooks']['compressor'] = TRUE;
						}
					// For plugins that need to authenticate users.
					if($this->©options->get('users.attach_wp_authentication_filter'))
						add_filter('wp_authenticate_user', array($this, '©user_utils.wp_authenticate_user'), 1000, 1);

					// Initializes front-side scripts/styles.
					add_action('wp_print_scripts', array($this, '©scripts.wp_print_scripts'), 9);
					add_action('wp_print_styles', array($this, '©styles.wp_print_styles'), 9);

					// Add support for administrative menu panels.
					add_action('admin_menu', array($this, '©menu_pages.admin_menu'), 10);
					add_action('network_admin_menu', array($this, '©menu_pages.network_admin_menu'), 10);

					// Initializes admin-side scripts/styles.
					add_action('admin_print_scripts', array($this, '©scripts.admin_print_scripts'), 9);
					add_action('admin_print_styles', array($this, '©styles.admin_print_styles'), 9);

					// Records HTTP communication (only ONE plugin needs to add this hook).
					if($this->©env->is_in_wp_debug_mode() && !isset($this->static['hooks']['urls.http_api_debug']))
						{
							add_action('http_api_debug', array($this, '©urls.http_api_debug'), 1000, 5);
							$this->static['hooks']['http_api_debug'] = TRUE;
						}
					// For plugins that enable this option (only ONE plugin needs to add this filter).
					if($this->©options->get('widgets.enable_shortcodes') && !isset($this->static['hooks']['widgets.enable_shortcodes']))
						{
							add_filter('widget_text', 'do_shortcode');
							$this->static['hooks']['widgets.enable_shortcodes'] = TRUE;
						}
					// Add `[if]` shortcodes (only ONE plugin may add these shortcodes).
					if($this->©options->get('shortcodes.if_conditionals.enable') && !isset($this->static['hooks']['shortcodes.if_conditionals']))
						{
							for($_i = 0; $_i <= 3; $_i++) // Allows nested shortcodes with `_`, `__`, `___` prefixes.
								add_shortcode(str_repeat('_', $_i).'if', array($this, '©shortcodes__if_conditionals.do_shortcode'));
							unset($_i); // Housekeeping.

							$this->static['hooks']['shortcodes.if_conditionals'] = TRUE;
						}
					// Handles `update_plugins` array (for pro upgrades).
					add_filter('pre_site_transient_update_plugins', array($this, '©plugins.pre_site_transient_update_plugins'), 11, 1);
				}

			/**
			 * Prepares initializer hooks.
			 */
			public function prepare_hooks()
				{
					// Activation/deactivation (installation class).
					// These MUST be capable of running independently from hooks/filters `after_setup_theme`.
					// For example, activation/deactivation routines should NOT be dependent upon action handlers.
					register_activation_hook($this->___instance_config->plugin_dir_file_basename, array($this, '©installer.activation'));
					register_deactivation_hook($this->___instance_config->plugin_dir_file_basename, array($this, '©installer.deactivation'));

					// Adds support for administrative notices.
					// This MUST be capable of running independently from hooks/filters `after_setup_theme`.
					// For example, administrative notices should NOT be dependent upon action handlers.
					add_action('all_admin_notices', array($this, '©notices.all_admin_notices'), 10);

					// Process hooks in the routine above (when/if possible).
					add_action('after_setup_theme', array($this, 'after_setup_theme'), 1);
				}
		}
	}