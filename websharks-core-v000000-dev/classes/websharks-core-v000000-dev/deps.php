<?php
/**
 * Dependency Utilities.
 *
 * @note MUST remain PHP v5.2 compatible.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

if(!class_exists('deps_websharks_core_v000000_dev'))
	{
		/**
		 * Dependency Utilities.
		 *
		 * @note MUST remain PHP v5.2 compatible.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 */
		class deps_websharks_core_v000000_dev
		{
			/**
			 * Checks if all dependencies can be satisfied.
			 * Also runs a deep scan to identify common problems/conflicts/issues.
			 * Also returns details regarding tests that passed successfully.
			 *
			 * @note This docBlock originates in file `deps-x.php`.
			 *    We maintain the master in `deps-x.php`, and it's copied into `deps.php`.
			 *    Also replicates into `[...-]stand-alone.php`, or any stand-alone file loaded as class:
			 *    ``deps_x_stand_alone_websharks_core_v000000_dev``.
			 *
			 * @param string  $plugin_name If empty, defaults to a generic value.
			 *    Name of the plugin that's checking dependencies;
			 *    e.g. the plugin that called this routine.
			 *
			 * @param string  $plugin_dir_names If empty, defaults to a generic value.
			 *    Name of one or more (comma-delimited) plugin directories associated with dependency scans;
			 *    e.g. directories associated with the plugin that called this routine.
			 *
			 * @param boolean $report_notices TRUE by default.
			 *    If FALSE, do NOT report any notices.
			 *
			 * @param boolean $report_warnings TRUE by default.
			 *    If FALSE, do NOT report warnings.
			 *
			 * @param boolean $check_last_ok TRUE by default. Avoids a re-scan if at all possible.
			 *    If ``$check_last_ok`` is FALSE, it will always force a new full scan.
			 *    Automatically disabled when running in a stand-alone file as class:
			 *    ``deps_x_stand_alone_websharks_core_v000000_dev``.
			 *
			 * @param boolean $maybe_display_wp_admin_notices TRUE by default. Applies only when running within WordPress.
			 *    If there are issues, we'll automatically enqueue administrative notices to alert the site owner.
			 *    Automatically disabled when running in a stand-alone file as class:
			 *    ``deps_x_stand_alone_websharks_core_v000000_dev``.
			 *
			 * @return boolean|array TRUE if no `issues`.
			 *    If there ARE `issues`, this returns a multidimensional array (which is NEVER empty).
			 *    A possible FALSE return value (initially), if an auto-fix is being requested by the site owner.
			 *    A possible FALSE return value, if invalid types are passed through arguments list.
			 *
			 * @auto-fix A possible FALSE return value, if an auto-fix is being requested (at least, initially).
			 *    If an auto-fix is requested, we check to see if WordPress® is loaded up, and if the `init` hook has been fired yet.
			 *    If it has NOT been fired yet, we return FALSE (initially). Then we run this routine again on the `init` hook, with a priority of `1`.
			 *    This allows auto-fix routines to check permissions, and perform other important tasks; with the use of all WordPress® functionality.
			 *
			 * @note The return value of this function depends heavily on the parameters used to call upon it.
			 *    If it's called with ``$check_last_ok = TRUE`` (the default), there's a good chance it will simply return TRUE.
			 *    That is, if we check a last OK time, and it's valid — a re-scan will NOT be processed; and there are no `issues` to report.
			 *
			 * @note This routine also deals with administrative notices in WordPress®.
			 * @note This routine also deals with auto-fix routines in WordPress®.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('WebSharks™ Core') === TRUE
			 */
			public static function check($plugin_name = '', $plugin_dir_names = '', $report_notices = TRUE, $report_warnings = TRUE, $check_last_ok = TRUE, $maybe_display_wp_admin_notices = TRUE)
				{
					// Let's check all argument value types. These MUST be passed in properly, else we throw an exception.

					if(is_string($plugin_name) && is_string($plugin_dir_names) && is_bool($report_notices) && is_bool($report_warnings) && is_bool($check_last_ok) && is_bool($maybe_display_wp_admin_notices))
						{
							// Look for possible filtration against this routine.

							if(apply_filters('websharks_core__deps__check_disable', FALSE))
								return TRUE; // Return now (DISABLED).

							// Define some important variables.

							$php_version = PHP_VERSION; // Installed PHP version.
							global $wp_version; // Global made available by WordPress®.

							// Has a full scan succeeded in the past?
							// If so, is a re-scan necessary? Or is everything still OK?

							if($check_last_ok
							   && is_array($last_ok = get_option('websharks_core__deps__last_ok'))
							   && isset($last_ok['websharks_core_v000000_dev'], $last_ok['time'], $last_ok['php_version'], $last_ok['wp_version'])
							   && $last_ok['time'] >= strtotime('-24 hours') && $last_ok['php_version'] === $php_version && $last_ok['wp_version'] === $wp_version
							) // Return TRUE. A re-scan is NOT necessary; everything is still OK.
								return TRUE;

							// Else we need to run a full scan now.

							if(!class_exists('deps_x_websharks_core_v000000_dev'))
								include_once dirname(__FILE__).'/deps-x.php';

							$x             = new deps_x_websharks_core_v000000_dev();
							$check_last_ok = FALSE; // We just checked this above. No reason to check again.
							return $x->check($plugin_name, $plugin_dir_names, $report_notices, $report_warnings, $check_last_ok, $maybe_display_wp_admin_notices);
						}
					else throw new exception( // Detected invalid arguments.
						sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
					);
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
			public static function deactivation_uninstall($confirmation = FALSE)
				{
					if(is_bool($confirmation)) // Valid/boolean?
						{
							if($confirmation) // Do we have confirmation?
								{
									delete_option('websharks_core__deps__last_ok');
									delete_option('websharks_core__deps__notice__dismissals');

									if(!class_exists('deps_x_websharks_core_v000000_dev'))
										include_once dirname(__FILE__).'/deps-x.php';

									$x = new deps_x_websharks_core_v000000_dev();
									return $x->deactivation_uninstall($confirmation);
								}
							return FALSE; // Default return value.
						}
					else throw new exception( // Detected invalid arguments.
						sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
					);
				}

			/**
			 * Handles core translations for this class (context: admin-side).
			 *
			 * @param string  $string String to translate.
			 *
			 * @param string  $other_contextuals Optional. Other contextual slugs relevant to this translation.
			 *    Contextual slugs normally follow the standard of being written with dashes.
			 *
			 * @return string Translated string.
			 */
			public static function i18n($string, $other_contextuals = '')
				{
					$core_ns_stub_with_dashes = 'websharks-core'; // Core namespace stub w/ dashes.
					$string                   = (string)$string; // Typecasting this to a string value.
					$other_contextuals        = (string)$other_contextuals; // Typecasting this to a string value.
					$context                  = $core_ns_stub_with_dashes.'--admin-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

					return _x($string, $context, $core_ns_stub_with_dashes);
				}

			/**
			 * Handles core translations for this class (context: front-side).
			 *
			 * @param string  $string String to translate.
			 *
			 * @param string  $other_contextuals Optional. Other contextual slugs relevant to this translation.
			 *    Contextual slugs normally follow the standard of being written with dashes.
			 *
			 * @return string Translated string.
			 */
			public static function translate($string, $other_contextuals = '')
				{
					$core_ns_stub_with_dashes = 'websharks-core'; // Core namespace stub w/ dashes.
					$string                   = (string)$string; // Typecasting this to a string value.
					$other_contextuals        = (string)$other_contextuals; // Typecasting this to a string value.
					$context                  = $core_ns_stub_with_dashes.'--front-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

					return _x($string, $context, $core_ns_stub_with_dashes);
				}
		}
	}