<?php
/**
 * WebSharks™ Core (Build Routines).
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
		 * WebSharks™ Core (Build Routines).
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__], 'unit_test')
		 */
		final class builder extends framework
		{
			/**
			 * @var successes A successes object instance.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $successes; // Defaults to a NULL value.

			/**
			 * @var boolean Defaults to a value of FALSE, for security purposes.
			 * @by-constructor Set by class constructor.
			 */
			public $can_build = FALSE;

			/**
			 * @var string Core dir.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $core_dir = '';

			/**
			 * @var string Plugin dir.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $plugin_dir = '';

			/**
			 * @var string Plugin name.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $plugin_name = '';

			/**
			 * @var string Plugin namespace.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $plugin_ns = '';

			/**
			 * @var string Distros directory.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $distros_dir = '';

			/**
			 * @var string Downloads directory.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $downloads_dir = '';

			/**
			 * @var string Pro plugin dir.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $plugin_pro_dir = '';

			/**
			 * @var string Plugin extras dir.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $plugin_extras_dir = '';

			/**
			 * @var string Version number.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $version = '';

			/**
			 * @var string Requires at least PHP version.
			 * @by-constructor Set dynamically by class constructor.
			 * @note This default value is updated by JasWSInc when it needs to change.
			 */
			public $requires_at_least_php_v = '5.3.1';

			/**
			 * @var string Tested up to PHP version.
			 * @by-constructor Set dynamically by class constructor.
			 * @note This default value is updated by JasWSInc when it needs to change.
			 */
			public $tested_up_to_php_v = '5.4.12';

			/**
			 * @var string Requires at least WordPress® version.
			 * @by-constructor Set dynamically by class constructor.
			 * @note This default value is updated by JasWSInc when it needs to change.
			 */
			public $requires_at_least_wp_v = '3.5.1';

			/**
			 * @var string Tested up to WordPress® version.
			 * @by-constructor Set dynamically by class constructor.
			 * @note This default value is updated by JasWSInc when it needs to change.
			 */
			public $tested_up_to_wp_v = '3.6-alpha';

			/**
			 * @var boolean Compile core into a PHAR file?
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $use_core_phar = FALSE;

			/**
			 * @var boolean Build from a specific core version?
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $build_from_core_v = '';

			/**
			 * @var boolean Current GIT branches (when we start).
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $starting_git_branches = array('core' => '', 'plugin' => '', 'plugin_pro' => '');

			/**
			 * Constructor (initiates build).
			 *
			 * @param object|array        $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or a new ``$___instance_config`` array.
			 *
			 * @param string              $plugin_dir Optional. Defaults to an empty string. If supplied, the core will be replicated into this directory.
			 *    If this is NOT supplied (or it's empty); the core will be replicated into a sub-directory of it's current parent location.
			 *    This also impacts checksums and other build routines. If there is no ``$plugin_dir``; some routines are skipped over;
			 *    instead we focus on building the core itself. If there is no ``$plugin_dir``; we build the core and NOT a plugin.
			 *
			 * @param string              $plugin_name Defaults to an empty string. Required only if ``$plugin_dir`` is passed also.
			 * @param string              $plugin_ns Defaults to an empty string. Required only if ``$plugin_dir`` is passed also.
			 * @param string              $distros_dir Optional. Defaults to an empty string. Required only if ``$plugin_dir`` is passed also.
			 * @param string              $downloads_dir Optional. Defaults to an empty string. Required only if ``$plugin_dir`` is passed also.
			 *
			 * @param integer|string      $version Optional. Defaults to a value of ``$this->©date->i18n_utc('ymd')``.
			 *    Must be valid. See: {@link \websharks_core_v000000_dev\strings\regex_valid_ws_version}
			 *
			 * @param string              $requires_at_least_php_v Optional. Defaults to the oldest version tested by the WebSharks™ Core.
			 *    All of these MUST be valid. See: {@link \websharks_core_v000000_dev\strings\regex_valid_version}
			 * @param string              $tested_up_to_php_v Optional. Defaults to the newest version tested by the WebSharks™ Core.
			 * @param string              $requires_at_least_wp_v Optional. Defaults to the oldest version tested by the WebSharks™ Core.
			 * @param string              $tested_up_to_wp_v Optional. Defaults to the newest version tested by the WebSharks™ Core.
			 *
			 * @param null|string|boolean $use_core_phar Defaults to a value of NULL. If ``$plugin_dir`` is set; NULL defaults to TRUE (for plugins).
			 *    If this is set to a string|boolean value; that value will be used explicitly (e.g. there will be no auto-detection whatsoever).
			 *    This is ONLY applicable to plugin builds. If building the core itself; this parameter is ignored completely.
			 *    For compatibility with command-line operations; a string value that is considered TRUE or FALSE; is acceptable.
			 *    For details on this behavior, please see: {@link \websharks_core_v000000_dev\strings\is_true()}.
			 *
			 * @param string              $build_from_core_v Optional. This is partially ignored here. It is handled mostly by `/._builder.php`.
			 *    However, what DO still use it here (if it's passed in); to some extent. If this is passed in, we will verify the current core version.
			 *    If ``$build_from_core_v`` is passed in, but it does NOT match this version of the core; an exception will be thrown.
			 *
			 * @note Instantiation of this class will initiate the build routine (so please be VERY careful).
			 *    Property ``$successes`` will contain messages indicating the final result status of the build procedure.
			 *    If there is a failure an exception is thrown by this class. We either succeed completely; or throw an exception.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If unable to build according to ``$this->can_build`` property value.
			 * @throws exception If any parameter values are invalid; based on extensive validation in this class.
			 * @throws exception If a build fails for any reason. See: ``build()`` method for further details.
			 */
			public function __construct($___instance_config, $plugin_dir = '', $plugin_name = '', $plugin_ns = '', $distros_dir = '', $downloads_dir = '',
			                            $version = '', $requires_at_least_php_v = '', $tested_up_to_php_v = '', $requires_at_least_wp_v = '', $tested_up_to_wp_v = '',
			                            $use_core_phar = NULL, $build_from_core_v = '')
				{
					parent::__construct($___instance_config);

					// Check arguments expected by this constructor.

					$this->check_arg_types('', 'string', 'string', 'string', 'string', 'string',
					                       array('integer', 'string'), 'string', 'string', 'string', 'string',
					                       array('null', 'string', 'boolean'), 'string', func_get_args());

					// Set property value ``$this->can_build``, upon class construction.

					if(!$this->©env->is_cli())
						$this->can_build = FALSE; // Not the command line.

					else if(!defined('___BUILDER') || !___BUILDER)
						$this->can_build = FALSE; // Not a builder interface.

					else if(!defined('___REPLICATOR') || !___REPLICATOR)
						$this->can_build = FALSE; // Not a replicator interface.

					else if($this->___instance_config->plugin_root_ns !== $this->___instance_config->core_ns)
						$this->can_build = FALSE; // Current instance is NOT the core itself.

					else // TRUE (we CAN build here).
						$this->can_build = TRUE;

					// Instantiation of this class will initiate the build routine here.

					if($this->can_build) // Security check. We CAN build?
						{
							$this->core_dir      = $this->©dir->n_seps(dirname(dirname(dirname(__FILE__))));
							$this->plugin_dir    = ($plugin_dir) ? $this->©dir->n_seps($plugin_dir) : '';
							$this->plugin_name   = ($plugin_name) ? $plugin_name : '';
							$this->plugin_ns     = ($plugin_ns) ? $plugin_ns : '';
							$this->distros_dir   = ($distros_dir) ? $this->©dir->n_seps($distros_dir) : '';
							$this->downloads_dir = ($downloads_dir) ? $this->©dir->n_seps($downloads_dir) : '';

							$this->version                 = ($version) ? (string)$version : $this->©date->i18n_utc('ymd');
							$this->requires_at_least_php_v = ($requires_at_least_php_v) ? $requires_at_least_php_v : $this->requires_at_least_php_v;
							$this->tested_up_to_php_v      = ($tested_up_to_php_v) ? $tested_up_to_php_v : $this->tested_up_to_php_v;
							$this->requires_at_least_wp_v  = ($requires_at_least_wp_v) ? $requires_at_least_wp_v : $this->requires_at_least_wp_v;
							$this->tested_up_to_wp_v       = ($tested_up_to_wp_v) ? $tested_up_to_wp_v : $this->tested_up_to_wp_v;

							$this->use_core_phar = ($this->plugin_dir) ? TRUE : FALSE;
							if($this->plugin_dir && is_bool($use_core_phar))
								$this->use_core_phar = $use_core_phar;
							else if($this->plugin_dir && is_string($use_core_phar) && strlen($use_core_phar))
								$this->use_core_phar = $this->©string->is_true($use_core_phar);

							$this->build_from_core_v = ($build_from_core_v) ? $build_from_core_v : $this->___instance_config->core_version;

							if(!is_dir($this->core_dir))
								throw $this->©exception(
									__METHOD__.'#nonexistent_core_dir', get_defined_vars(),
									sprintf($this->i18n('Nonexistent core directory: `%1$s`.'), $this->core_dir)
								);
							else if(!is_readable($this->core_dir) || !is_writable($this->core_dir))
								throw $this->©exception(
									__METHOD__.'#plugin_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with core directory: `%1$s`.'), $this->core_dir)
								);
							else if(!is_file(dirname($this->core_dir).'/.gitignore'))
								throw $this->©exception(
									__METHOD__.'#core_dir_gitignore', get_defined_vars(),
									sprintf($this->i18n('Core directory is missing this file: `%1$s`.'), dirname($this->core_dir).'/.gitignore')
								);

							if($this->plugin_dir && !is_dir($this->plugin_dir))
								throw $this->©exception(
									__METHOD__.'#nonexistent_plugin_dir', get_defined_vars(),
									sprintf($this->i18n('Nonexistent plugin directory: `%1$s`.'), $this->plugin_dir)
								);
							else if($this->plugin_dir && (!is_readable($this->plugin_dir) || !is_writable($this->plugin_dir)))
								throw $this->©exception(
									__METHOD__.'#plugin_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin directory: `%1$s`.'), $this->plugin_dir)
								);
							else if($this->plugin_dir && !is_file(dirname($this->plugin_dir).'/.gitignore'))
								throw $this->©exception(
									__METHOD__.'#plugin_dir_gitignore', get_defined_vars(),
									sprintf($this->i18n('Plugin directory is missing this file: `%1$s`.'), dirname($this->plugin_dir).'/.gitignore')
								);
							else if($this->plugin_dir && !$this->plugin_name)
								throw $this->©exception(
									__METHOD__.'#missing_plugin_name', get_defined_vars(),
									sprintf($this->i18n('Missing plugin name for: `%1$s`.'), $this->plugin_dir)
								);
							else if($this->plugin_dir && !$this->plugin_ns)
								throw $this->©exception(
									__METHOD__.'#missing_plugin_ns', get_defined_vars(),
									sprintf($this->i18n('Missing plugin namespace for: `%1$s`.'), $this->plugin_dir)
								);
							else if($this->plugin_dir && (!$this->distros_dir || !is_dir($this->distros_dir)))
								throw $this->©exception(
									__METHOD__.'#nonexistent_distros_dir', get_defined_vars(),
									sprintf($this->i18n('Nonexistent distros directory: `%1$s`.'), $this->distros_dir)
								);
							else if($this->plugin_dir && (!$this->downloads_dir || !is_dir($this->downloads_dir)))
								throw $this->©exception(
									__METHOD__.'#nonexistent_downloads_dir', get_defined_vars(),
									sprintf($this->i18n('Nonexistent downloads directory: `%1$s`.'), $this->downloads_dir)
								);
							else if($this->plugin_dir && (!is_readable($this->distros_dir) || !is_writable($this->distros_dir)))
								throw $this->©exception(
									__METHOD__.'#distros_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with distros directory: `%1$s`.'), $this->distros_dir)
								);
							else if($this->plugin_dir && (!is_readable($this->downloads_dir) || !is_writable($this->downloads_dir)))
								throw $this->©exception(
									__METHOD__.'#downloads_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with downloads directory: `%1$s`.'), $this->downloads_dir)
								);

							if($this->plugin_dir) // Let's look for a possible `-pro` add-on project.
								{
									$_plugins_dir              = dirname(dirname($this->plugin_dir));
									$_possible_pro_project_dir = $_plugins_dir.'/'.basename($this->plugin_dir).'-pro';
									$_possible_pro_dir         = $_possible_pro_project_dir.'/'.basename($this->plugin_dir).'-pro';

									// We back up two directories; and look for this to exist as a separate `plugins/` project dir.
									// This is a VERY important step; in order to AVOID using a directory junction from the main plugin directory.
									// Also because we need a `.gitignore` file for the `-pro` project dir so exclusions are handled correctly.

									if(basename($_plugins_dir) === 'plugins' && is_dir($_possible_pro_dir))
										$this->plugin_pro_dir = $_possible_pro_dir;

									unset($_plugins_dir, $_possible_pro_project_dir, $_possible_pro_dir); // Housekeeping.
								}
							if($this->plugin_dir && is_dir($this->plugin_dir.'-extras')) // Let's look for a possible `-extras` directory.
								$this->plugin_extras_dir = $this->plugin_dir.'-extras'; // We expect this to live in the same project directory.

							if($this->plugin_dir && $this->plugin_pro_dir && (!is_readable($this->plugin_pro_dir) || !is_writable($this->plugin_pro_dir)))
								throw $this->©exception(
									__METHOD__.'#plugin_pro_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin pro directory: `%1$s`.'), $this->plugin_pro_dir)
								);
							else if($this->plugin_dir && $this->plugin_pro_dir && !is_file($this->plugin_pro_dir.'/.gitignore'))
								throw $this->©exception(
									__METHOD__.'#plugin_pro_dir_gitignore', get_defined_vars(),
									sprintf($this->i18n('Plugin pro directory is missing this file: `%1$s`.'), $this->plugin_pro_dir.'/.gitignore')
								);

							if($this->plugin_dir && $this->plugin_extras_dir && (!is_readable($this->plugin_extras_dir) || !is_writable($this->plugin_extras_dir)))
								throw $this->©exception(
									__METHOD__.'#plugin_extras_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin extras directory: `%1$s`.'), $this->plugin_extras_dir)
								);

							if(!preg_match($this->©string->regex_valid_ws_version, $this->version))
								throw $this->©exception(
									__METHOD__.'#invalid_version', get_defined_vars(),
									sprintf($this->i18n('Invalid WebSharks™ version string: `%1$s`.'), $this->version)
								);
							else if(!preg_match($this->©string->regex_valid_version, $this->requires_at_least_php_v))
								throw $this->©exception(
									__METHOD__.'#invalid_requires_at_least_php_v', get_defined_vars(),
									sprintf($this->i18n('Invalid `Requires at least` PHP version string: `%1$s`.'), $this->requires_at_least_php_v)
								);
							else if(!preg_match($this->©string->regex_valid_version, $this->tested_up_to_php_v))
								throw $this->©exception(
									__METHOD__.'#invalid_tested_up_to_php_v', get_defined_vars(),
									sprintf($this->i18n('Invalid `Tested up to` PHP version string: `%1$s`.'), $this->tested_up_to_php_v)
								);
							else if(!preg_match($this->©string->regex_valid_version, $this->requires_at_least_wp_v))
								throw $this->©exception(
									__METHOD__.'#invalid_requires_at_least_wp_v', get_defined_vars(),
									sprintf($this->i18n('Invalid `Requires at least` version string: `%1$s`.'), $this->requires_at_least_wp_v)
								);
							else if(!preg_match($this->©string->regex_valid_version, $this->tested_up_to_wp_v))
								throw $this->©exception(
									__METHOD__.'#invalid_tested_up_to_wp_v', get_defined_vars(),
									sprintf($this->i18n('Invalid `Tested up to` version string: `%1$s`.'), $this->tested_up_to_wp_v)
								);

							if($this->build_from_core_v !== $this->___instance_config->core_version)
								throw $this->©exception(
									__METHOD__.'#invalid_build_from_core_v', get_defined_vars(),
									sprintf($this->i18n('Building from incorrect core version: `%1$s`.'), $this->build_from_core_v).
									sprintf($this->i18n(' This is version `%1$s` of the WebSharks™ Core.'), $this->___instance_config->core_version)
								);

							$this->starting_git_branches['core'] = // WebSharks™ Core.
								$this->©command->git_current_branch(dirname($this->core_dir));

							if($this->plugin_dir) // For plugin directory repo (if building a plugin).
								$this->starting_git_branches['plugin'] = $this->©command->git_current_branch(dirname($this->plugin_dir));

							if($this->plugin_dir && $this->plugin_pro_dir) // Pro plugin's pro add-on repo (if building a plugin).
								$this->starting_git_branches['plugin_pro'] = $this->©command->git_current_branch(dirname($this->plugin_pro_dir));

							if(($successes = $this->build())) $this->successes = $successes;

							else throw $this->©exception(__METHOD__.'#build_failure', NULL, $this->i18n('Failure. Unable to build (unknown error).'));
						}
					else throw $this->©exception(__METHOD__.'#cannot_build', NULL, $this->i18n('Security check. Unable to build (not allowed here).'));
				}

			/**
			 * Handles plugin builds.
			 *
			 * @return successes Returns an instance of successes; else throws an exception on any type of failure.
			 *
			 * @throws exception If unable to update files in the plugin directory(s).
			 */
			protected function build() // Handles plugin builds.
				{
					$this->©env->prep_for_cli_dev_procedure();

					$successes = $this->©successes(
						__METHOD__.'#start_time', get_defined_vars(),
						sprintf($this->i18n('Start time: %1$s.'), $this->©env->time_details())
					);

					$successes->add(__METHOD__.'#starting_branch_core', get_defined_vars(),
					                sprintf($this->i18n('Building from WebSharks™ Core GIT branch: `%1$s`; version: `%2$s`.'),
					                        $this->starting_git_branches['core'], $this->___instance_config->core_version)
					);

					if($this->plugin_dir) // Building a plugin.
						{
							// Create a restore point by committing all new and/or changed files.

							$this->©command->git('add --all', dirname($this->plugin_dir));
							$this->©command->git('commit --all --allow-empty --message '.escapeshellarg($this->i18n('Auto-commit; before building.')), dirname($this->plugin_dir));

							$successes->add(__METHOD__.'#before_building_plugin', get_defined_vars(),
							                sprintf($this->i18n('All existing files (new and/or changed) on the starting GIT branch: `%1$s`;'.
							                                    ' have been added to the list of GIT-tracked files in this plugin repo.'), $this->starting_git_branches['plugin']).
							                $this->i18n(' A commit has been processed for all changes to the existing file structure (before new branch creation).')
							);

							// Create a new GIT branch for this version (and switch to this new branch).

							$this->©command->git('checkout -b '.escapeshellarg($this->version), dirname($this->plugin_dir));
							// An exception is thrown if the branch already exists. GIT returns a non-zero status.

							$successes->add(__METHOD__.'#new_branch_before_building_plugin', get_defined_vars(),
							                sprintf($this->i18n(' A new GIT branch has been created for plugin version: `%1$s`.'), $this->version)
							);

							// WebSharks™ Core replication.

							$_new_core_dir = $this->plugin_dir.'/'.$this->___instance_config->core_ns_stub_with_dashes;

							$this->©dir->empty_and_remove($_new_core_dir); // In case it already exists (we need to remove it first).
							$this->©command->git('rm -r --cached --ignore-unmatch '.escapeshellarg($_new_core_dir.'/'), dirname($this->plugin_dir));

							$_replication = $this->©replicate($this->plugin_dir, TRUE, 0, array('.gitignore' => dirname($this->core_dir).'/.gitignore'));
							$this->©dir->rename_to($_replication->to_dir, $_new_core_dir);
							unset($_replication); // Housekeeping.

							$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_dir.'/'), dirname($this->plugin_dir));

							$successes->add(__METHOD__.'#new_core_dir_replication_into_plugin_dir', get_defined_vars(),
							                sprintf($this->i18n('The WebSharks™ Core has been temporarily replicated into this plugin directory: `%1$s`.'), $_new_core_dir).
							                $this->i18n(' This directory has also been added to the list of GIT-tracked files in this plugin repo (but only temporarily).').
							                sprintf($this->i18n(' Every file in the entire plugin directory has now been updated to use `v%1$s` of the WebSharks™ Core.'), $this->___instance_config->core_version)
							);

							// Copy WebSharks™ Core stub into the main plugin directory.

							$_core_stub     = $this->core_dir.'/stub.php';
							$_new_core_stub = $this->plugin_dir.'/'.$this->___instance_config->core_ns_stub_with_dashes.'.php';

							$this->©file->unlink($_new_core_stub); // In case it already exists (we need to remove it first).
							$this->©command->git('rm --cached --ignore-unmatch '.escapeshellarg($_new_core_stub), dirname($this->plugin_dir));

							$this->©file->copy_to($_core_stub, $_new_core_stub);
							$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_stub), dirname($this->plugin_dir));

							$successes->add(__METHOD__.'#new_core_stub_added_to_plugin_dir', get_defined_vars(),
							                sprintf($this->i18n('The WebSharks™ Core stub has been added to the plugin directory: `%1$s`.'), $_new_core_stub).
							                $this->i18n(' This file has also been added to the list of GIT-tracked files in this plugin repo.')
							);
							unset($_core_stub, $_new_core_stub);

							// Bundle the WebSharks™ Core PHP Archive stub; instead of the full directory?

							if($this->use_core_phar) // Optional (this is only applicable to plugins).
								{
									$_core_phar_stub           = dirname($this->core_dir).'/'.$this->___instance_config->core_ns_stub_with_dashes.'.phar.php';
									$_new_core_phar_stub       = $this->plugin_dir.'/'.$this->___instance_config->core_ns_stub_with_dashes.'.php';
									$_plugin_dir_htaccess_file = $this->plugin_dir.'/.htaccess';

									$this->©file->unlink($_new_core_phar_stub); // In case it already exists (we need to remove it first).
									$this->©command->git('rm --cached --ignore-unmatch '.escapeshellarg($_new_core_phar_stub), dirname($this->plugin_dir));

									if(!is_file($_plugin_dir_htaccess_file)
									   || !is_readable($_plugin_dir_htaccess_file)
									   || FALSE === strpos(file_get_contents($_plugin_dir_htaccess_file), 'AcceptPathInfo')
									) throw $this->©exception(
										__METHOD__.'#unable_to_find_valid_htaccess_file_in_plugin_dir', get_defined_vars(),
										sprintf($this->i18n('Unable to find a valid `.htaccess` file here: `%1$s`.'), $_plugin_dir_htaccess_file).
										$this->i18n(' This file MUST exist; and it MUST contain: `AcceptPathInfo` for webPhar compatibility.')
									);

									$this->©file->copy_to($_core_phar_stub, $_new_core_phar_stub);
									$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_phar_stub), dirname($this->plugin_dir));
									$this->©command->git('rm -r --cached '.escapeshellarg($_new_core_dir.'/'), dirname($this->plugin_dir));

									$successes->add(__METHOD__.'#new_core_phar_stub_added_to_plugin_dir', get_defined_vars(),
									                sprintf($this->i18n('The WebSharks™ Core PHAR stub for `v%1$s`; has been copied to: `%2$s`.'), $this->___instance_config->core_version, $_new_core_phar_stub).
									                $this->i18n(' This file (a compressed PHP Archive); has been added to the list of GIT-tracked files in this plugin repo. The original stub file has been replaced by this PHAR file.').
									                sprintf($this->i18n(' The original full WebSharks™ Core directory has been removed from the list of GIT-tracked files in this repo: `%1$s`. It will be excluded from the final distro.'), $_new_core_dir)
									);
									unset($_core_phar_stub, $_new_core_phar_stub, $_plugin_dir_htaccess_file);
								}

							// Update various plugin files w/ version numbers and other requirements.

							$_plugin_file           = $this->plugin_dir.'/plugin.php';
							$_plugin_readme_file    = $this->plugin_dir.'/readme.txt';
							$_plugin_framework_file = $this->plugin_dir.'/classes/'.str_replace('_', '-', $this->plugin_ns).'/framework.php';

							if(!is_file($_plugin_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_plugin_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent plugin file: `%1$s`.'), $_plugin_file)
								);
							else if(!is_readable($_plugin_file) || !is_writable($_plugin_file))
								throw $this->©exception(
									__METHOD__.'#plugin_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin file: `%1$s`.'), $_plugin_file)
								);

							if(!is_file($_plugin_readme_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_plugin_readme_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent plugin `readme.txt` file: `%1$s`.'), $_plugin_readme_file)
								);
							else if(!is_readable($_plugin_readme_file) || !is_writable($_plugin_readme_file))
								throw $this->©exception(
									__METHOD__.'#plugin_readme_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin `readme.txt` file: `%1$s`.'), $_plugin_readme_file)
								);

							if(!is_file($_plugin_framework_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_plugin_framework_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent plugin `framework.php` file: `%1$s`.'), $_plugin_framework_file)
								);
							else if(!is_readable($_plugin_framework_file) || !is_writable($_plugin_framework_file))
								throw $this->©exception(
									__METHOD__.'#plugin_framework_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin `framework.php` file: `%1$s`.'), $_plugin_framework_file)
								);

							$_plugin_file_contents           = file_get_contents($_plugin_file);
							$_plugin_readme_file_contents    = file_get_contents($_plugin_readme_file);
							$_plugin_framework_file_contents = file_get_contents($_plugin_framework_file);

							$_plugin_file_contents           = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_plugin_file_contents);
							$_plugin_readme_file_contents    = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_plugin_readme_file_contents);
							$_plugin_framework_file_contents = $this->regex_replace('php_code__quoted_string_with_version_marker', $this->version, $_plugin_framework_file_contents);

							$_plugin_file_contents        = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_v, $_plugin_file_contents);
							$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_v, $_plugin_readme_file_contents);

							$_plugin_file_contents        = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_v, $_plugin_file_contents);
							$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_v, $_plugin_readme_file_contents);

							$_plugin_file_contents        = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_v, $_plugin_file_contents);
							$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_v, $_plugin_readme_file_contents);

							$_plugin_file_contents        = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_v, $_plugin_file_contents);
							$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_v, $_plugin_readme_file_contents);

							if(!file_put_contents($_plugin_file, $_plugin_file_contents))
								throw $this->©exception(
									__METHOD__.'#plugin_file_write_error', get_defined_vars(),
									$this->i18n('Unable to write (update) the plugin file.')
								);
							else if(!file_put_contents($_plugin_readme_file, $_plugin_readme_file_contents))
								throw $this->©exception(
									__METHOD__.'#plugin_readme_file_write_error', get_defined_vars(),
									$this->i18n('Unable to write (update) the plugin `readme.txt` file.')
								);
							else if(!file_put_contents($_plugin_framework_file, $_plugin_framework_file_contents))
								throw $this->©exception(
									__METHOD__.'#plugin_framework_file_write_error', get_defined_vars(),
									$this->i18n('Unable to write (update) the plugin `framework.php` file.')
								);

							$successes->add(__METHOD__.'#plugin_file_updates', get_defined_vars(),
							                $this->i18n('Plugin files updated with versions/requirements.').
							                sprintf($this->i18n(' Plugin version: `%1$s`.'), $this->version).
							                sprintf($this->i18n(' Plugin requires at least PHP version: `%1$s`.'), $this->requires_at_least_php_v).
							                sprintf($this->i18n(' Tested up to PHP version: `%1$s`.'), $this->tested_up_to_php_v).
							                sprintf($this->i18n(' Uses WebSharks™ Core: `v%1$s`.'), $this->___instance_config->core_version).
							                sprintf($this->i18n(' Plugin requires at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
							                sprintf($this->i18n(' Plugin tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v)
							);
							unset($_plugin_file, $_plugin_framework_file, $_plugin_readme_file);
							unset($_plugin_file_contents, $_plugin_framework_file_contents, $_plugin_readme_file_contents);

							// Copy distribution files into the distros directory.

							$_plugin_distro_dir = $this->distros_dir.'/'.basename($this->plugin_dir);

							$this->©dir->empty_and_remove($_plugin_distro_dir);
							$this->©dir->copy_to($this->plugin_dir, $_plugin_distro_dir, array('.gitignore' => dirname($this->plugin_dir).'/.gitignore'), TRUE);

							$successes->add(__METHOD__.'#plugin_distro_files', get_defined_vars(),
							                sprintf($this->i18n('Plugin distro files copied to: `%1$s`.'), $_plugin_distro_dir)
							);

							// Generate plugin distro directory checksum.

							$_plugin_distro_dir_checksum = $this->©dir->checksum($_plugin_distro_dir, TRUE);

							$successes->add(__METHOD__.'#plugin_distro_dir_checksum', get_defined_vars(),
							                sprintf($this->i18n('Plugin distro directory checksum file updated to: `%1$s`.'), $_plugin_distro_dir_checksum)
							);
							unset($_plugin_distro_dir_checksum); // Housekeeping.

							// Create ZIP archives.

							$_plugin_download_zip   = $this->downloads_dir.'/'.basename($this->plugin_dir).'.zip';
							$_plugin_download_v_zip = $this->downloads_dir.'/'.basename($this->plugin_dir).'-v'.$this->version.'.zip';

							$this->©file->unlink($_plugin_download_zip, $_plugin_download_v_zip);
							$this->©dir->zip_to($_plugin_distro_dir, $_plugin_download_zip);
							$this->©file->copy_to($_plugin_download_zip, $_plugin_download_v_zip);

							$successes->add(__METHOD__.'#plugin_distro_zips', get_defined_vars(),
							                sprintf($this->i18n('Plugin distro zipped into: `%1$s`.'), $_plugin_download_zip).
							                sprintf($this->i18n(' And copied into this version: `%1$s`.'), $_plugin_download_v_zip)
							);
							unset($_plugin_distro_dir, $_plugin_download_zip, $_plugin_download_v_zip); // Housekeeping.

							// Handle a possible pro add-on directory.

							if($this->plugin_pro_dir) // Is there a pro directory also?
								{
									// Create a restore point by committing all new and/or changed files.

									$this->©command->git('add --all', dirname($this->plugin_pro_dir));
									$this->©command->git('commit --all --allow-empty --message '.escapeshellarg($this->i18n('Auto-commit; before building.')), dirname($this->plugin_pro_dir));

									$successes->add(__METHOD__.'#before_building_plugin_pro', get_defined_vars(),
									                sprintf($this->i18n('All existing files (new and/or changed) on the starting GIT branch: `%1$s`;'.
									                                    ' have been added to the list of GIT-tracked files in this plugin\'s pro repo.'), $this->starting_git_branches['plugin_pro']).
									                $this->i18n(' A commit has been processed for all changes to the existing file structure (before new branch creation).')
									);

									// Create a new GIT branch for this version (and switch to this new branch).

									$this->©command->git('checkout -b '.escapeshellarg($this->version), dirname($this->plugin_pro_dir));
									// An exception is thrown if the branch already exists. GIT returns a non-zero status.

									$successes->add(__METHOD__.'#new_branch_before_building_plugin_pro', get_defined_vars(),
									                sprintf($this->i18n(' A new GIT branch has been created for plugin pro version: `%1$s`.'), $this->version)
									);

									// WebSharks™ Core replication.

									$_new_pro_core_dir = $this->plugin_pro_dir.'/'.$this->___instance_config->core_ns_stub_with_dashes;

									$this->©dir->empty_and_remove($_new_pro_core_dir); // In case it already exists (we need to remove it first).
									$this->©command->git('rm -r --cached --ignore-unmatch '.escapeshellarg($_new_pro_core_dir.'/'), dirname($this->plugin_pro_dir));

									$_replication = $this->©replicate($this->plugin_pro_dir, TRUE, 0, array('.gitignore' => dirname($this->core_dir).'/.gitignore'));
									$this->©dir->rename_to($_replication->to_dir, $_new_pro_core_dir);
									unset($_replication); // Housekeeping.

									$this->©dir->empty_and_remove($_new_pro_core_dir);

									$successes->add(__METHOD__.'#new_core_dir_replication_into_plugin_pro_dir', get_defined_vars(),
									                sprintf($this->i18n('The WebSharks™ Core has been temporarily replicated into this plugin pro directory: `%1$s`.'), $_new_pro_core_dir).
									                sprintf($this->i18n(' Every file in the entire plugin pro directory has now been updated to use `v%1$s` of the WebSharks™ Core.'), $this->___instance_config->core_version).
									                sprintf($this->i18n(' The temporary WebSharks™ Core has been deleted from the plugin pro directory: `%1$s`.'), $_new_pro_core_dir)
									);
									unset($_new_pro_core_dir); // Housekeeping.

									// Update various plugin pro files w/ version numbers and other requirements.

									$_plugin_pro_file        = $this->plugin_pro_dir.'/plugin.php';
									$_plugin_pro_readme_file = $this->plugin_pro_dir.'/readme.txt';
									$_plugin_pro_class_file  = $this->plugin_pro_dir.'/classes/'.str_replace('_', '-', $this->plugin_ns).'/pro.php';

									if(!is_file($_plugin_pro_file))
										throw $this->©exception(
											__METHOD__.'#nonexistent_plugin_pro_file', get_defined_vars(),
											sprintf($this->i18n('Nonexistent plugin pro file: `%1$s`.'), $_plugin_pro_file)
										);
									else if(!is_readable($_plugin_pro_file) || !is_writable($_plugin_pro_file))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_file_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with plugin pro file: `%1$s`.'), $_plugin_pro_file)
										);

									if(!is_file($_plugin_pro_readme_file))
										throw $this->©exception(
											__METHOD__.'#nonexistent_plugin_pro_readme_file', get_defined_vars(),
											sprintf($this->i18n('Nonexistent plugin pro `readme.txt` file: `%1$s`.'), $_plugin_pro_readme_file)
										);
									else if(!is_readable($_plugin_pro_readme_file) || !is_writable($_plugin_pro_readme_file))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_readme_file_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with plugin pro `readme.txt` file: `%1$s`.'), $_plugin_pro_readme_file)
										);

									if(!is_file($_plugin_pro_class_file))
										throw $this->©exception(
											__METHOD__.'#nonexistent_plugin_pro_class_file', get_defined_vars(),
											sprintf($this->i18n('Nonexistent plugin `pro.php` class file: `%1$s`.'), $_plugin_pro_class_file)
										);
									else if(!is_readable($_plugin_pro_class_file) || !is_writable($_plugin_pro_class_file))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_class_file_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with plugin `pro.php` class file: `%1$s`.'), $_plugin_pro_class_file)
										);

									$_plugin_pro_file_contents        = file_get_contents($_plugin_pro_file);
									$_plugin_pro_readme_file_contents = file_get_contents($_plugin_pro_readme_file);
									$_plugin_pro_class_file_contents  = file_get_contents($_plugin_pro_class_file);

									$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_plugin_pro_file_contents);
									$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_plugin_pro_readme_file_contents);
									$_plugin_pro_class_file_contents  = $this->regex_replace('php_code__quoted_string_with_version_marker', $this->version, $_plugin_pro_class_file_contents);

									$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_v, $_plugin_pro_file_contents);
									$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_v, $_plugin_pro_readme_file_contents);

									$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_v, $_plugin_pro_file_contents);
									$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_v, $_plugin_pro_readme_file_contents);

									$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_v, $_plugin_pro_file_contents);
									$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_v, $_plugin_pro_readme_file_contents);

									$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_v, $_plugin_pro_file_contents);
									$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_v, $_plugin_pro_readme_file_contents);

									if(!file_put_contents($_plugin_pro_file, $_plugin_pro_file_contents))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_file_write_error', get_defined_vars(),
											$this->i18n('Unable to write (update) the plugin pro file.')
										);
									else if(!file_put_contents($_plugin_pro_readme_file, $_plugin_pro_readme_file_contents))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_readme_file_write_error', get_defined_vars(),
											$this->i18n('Unable to write (update) the plugin pro `readme.txt` file.')
										);
									else if(!file_put_contents($_plugin_pro_class_file, $_plugin_pro_class_file_contents))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_class_file_write_error', get_defined_vars(),
											$this->i18n('Unable to write (update) the plugin `pro.php` class file.')
										);

									$successes->add(__METHOD__.'#plugin_pro_file_updates', get_defined_vars(),
									                $this->i18n('Plugin pro files updated with versions/requirements.').
									                sprintf($this->i18n(' Plugin pro version: `%1$s`.'), $this->version).
									                sprintf($this->i18n(' Pro add-on requires at least PHP version: `%1$s`.'), $this->requires_at_least_php_v).
									                sprintf($this->i18n(' Pro add-on tested up to PHP version: `%1$s`.'), $this->tested_up_to_php_v).
									                sprintf($this->i18n(' Uses WebSharks™ Core: `v%1$s`.'), $this->___instance_config->core_version).
									                sprintf($this->i18n(' Pro add-on requires at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
									                sprintf($this->i18n(' Pro add-on tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v)
									);
									unset($_plugin_pro_file, $_plugin_pro_class_file, $_plugin_pro_readme_file);
									unset($_plugin_pro_file_contents, $_plugin_pro_class_file_contents, $_plugin_pro_readme_file_contents);

									// Copy distribution files into the distros directory.

									$_plugin_pro_distro_dir = $this->distros_dir.'/'.basename($this->plugin_pro_dir);

									$this->©dir->empty_and_remove($_plugin_pro_distro_dir);
									$this->©dir->copy_to($this->plugin_pro_dir, $_plugin_pro_distro_dir, array('.gitignore' => dirname($this->plugin_pro_dir).'/.gitignore'), TRUE);

									$successes->add(__METHOD__.'#plugin_pro_distro_files', get_defined_vars(),
									                sprintf($this->i18n('Plugin pro distro files copied to: `%1$s`.'), $_plugin_pro_distro_dir)
									);

									// Generate plugin distro directory checksum.

									$_plugin_pro_distro_dir_checksum = $this->©dir->checksum($_plugin_pro_distro_dir, TRUE);

									$successes->add(__METHOD__.'#plugin_pro_distro_dir_checksum', get_defined_vars(),
									                sprintf($this->i18n('Plugin pro distro directory checksum file updated to: `%1$s`.'), $_plugin_pro_distro_dir_checksum)
									);
									unset($_plugin_pro_distro_dir_checksum); // Housekeeping.

									// Create ZIP archives.

									$_plugin_pro_download_zip   = $this->downloads_dir.'/'.basename($this->plugin_pro_dir).'.zip';
									$_plugin_pro_download_v_zip = $this->downloads_dir.'/'.basename($this->plugin_pro_dir).'-v'.$this->version.'.zip';

									$this->©file->unlink($_plugin_pro_download_zip, $_plugin_pro_download_zip);
									$this->©dir->zip_to($_plugin_pro_distro_dir, $_plugin_pro_download_zip);
									$this->©file->copy_to($_plugin_pro_download_zip, $_plugin_pro_download_v_zip);

									$successes->add(__METHOD__.'#plugin_pro_distro_zips', get_defined_vars(),
									                sprintf($this->i18n('Plugin pro distro zipped into: `%1$s`.'), $_plugin_pro_download_zip).
									                sprintf($this->i18n(' And copied into this version: `%1$s`.'), $_plugin_pro_download_v_zip)
									);
									unset($_plugin_pro_distro_dir, $_plugin_pro_download_zip, $_plugin_pro_download_v_zip); // Housekeeping.
								}

							// Handle a possible extras directory.
							// The routines below assume that we are NOT GIT-tracking the extras directory.
							// A plugin extras directory should NOT be GIT-tracked. These are EXTRAS.

							if($this->plugin_extras_dir) // Is there an extras directory also?
								{
									// WebSharks™ Core replication.

									$_new_extras_core_dir = $this->plugin_extras_dir.'/'.$this->___instance_config->core_ns_stub_with_dashes;

									$this->©dir->empty_and_remove($_new_extras_core_dir); // In case it already exists (we need to remove it first).

									$_replication = $this->©replicate($this->plugin_extras_dir, TRUE, 0, array('.gitignore' => dirname($this->core_dir).'/.gitignore'));
									$this->©dir->rename_to($_replication->to_dir, $_new_extras_core_dir);
									unset($_replication); // Housekeeping.

									$this->©dir->empty_and_remove($_new_extras_core_dir);

									$successes->add(__METHOD__.'#new_core_dir_replication_into_plugin_extras_dir', get_defined_vars(),
									                sprintf($this->i18n('The WebSharks™ Core has been temporarily replicated into this plugin extras directory: `%1$s`.'), $_new_extras_core_dir).
									                sprintf($this->i18n(' Every file in the entire plugin extras directory has now been updated to use `v%1$s` of the WebSharks™ Core.'), $this->___instance_config->core_version).
									                sprintf($this->i18n(' The temporary WebSharks™ Core has been deleted from the plugin extras directory: `%1$s`.'), $_new_extras_core_dir)
									);
									unset($_new_extras_core_dir); // Housekeeping.

									// Update various extra files w/ version numbers and other requirements.

									$_new_core_deps_x_file           = $_new_core_dir.'/classes/'.$this->___instance_config->core_ns_with_dashes.'/deps-x.php';
									$_new_server_scanner_file        = $this->plugin_extras_dir.'/'.basename($this->plugin_dir).'-server-scanner.php';
									$_new_server_scanner_plugin_dirs = basename($this->plugin_dir).(($this->plugin_pro_dir) ? ','.basename($this->plugin_pro_dir) : '');

									$this->©file->unlink($_new_server_scanner_file); // In case it already exists.

									if(!is_file($_new_core_deps_x_file))
										throw $this->©exception(
											__METHOD__.'#nonexistent_new_core_deps_x_file', get_defined_vars(),
											sprintf($this->i18n('Nonexistent new core `deps-x.php` file: `%1$s`.'), $_new_core_deps_x_file)
										);
									else if(!is_readable($_new_core_deps_x_file))
										throw $this->©exception(
											__METHOD__.'#new_core_deps_x_file_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with new core `deps-x.php` file: `%1$s`.'), $_new_core_deps_x_file)
										);

									$_new_core_deps_x_file_contents = file_get_contents($_new_core_deps_x_file);
									$_new_core_deps_x_file_contents = $this->regex_replace('php_code__deps_x__define_stand_alone_plugin_name', $this->plugin_name, $_new_core_deps_x_file_contents);
									$_new_core_deps_x_file_contents = $this->regex_replace('php_code__deps_x__define_stand_alone_plugin_dir_names', $_new_server_scanner_plugin_dirs, $_new_core_deps_x_file_contents);
									$_new_core_deps_x_file_contents = $this->regex_replace('php_code__deps_x__declare_stand_alone_class_name', '_stand_alone', $_new_core_deps_x_file_contents);

									if(!file_put_contents($_new_server_scanner_file, $_new_core_deps_x_file_contents))
										throw $this->©exception(
											__METHOD__.'#new_server_scanner_file_write_error', get_defined_vars(),
											$this->i18n('Unable to write the new plugin server scanner file.')
										);

									$successes->add(__METHOD__.'#plugin_extra_file_updates', get_defined_vars(),
									                $this->i18n('Plugin extra files updated with versions/requirements/etc.').
									                sprintf($this->i18n(' Extras version: `%1$s`.'), $this->version).
									                sprintf($this->i18n(' Extras require at least PHP version: `%1$s`.'), $this->requires_at_least_php_v).
									                sprintf($this->i18n(' Extras tested up to PHP version: `%1$s`.'), $this->tested_up_to_php_v).
									                sprintf($this->i18n(' Extras using WebSharks™ Core: `v%1$s`.'), $this->___instance_config->core_version).
									                sprintf($this->i18n(' Extras require at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
									                sprintf($this->i18n(' Extras tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v).
									                sprintf($this->i18n(' New server scanner file: `%1$s`.'), $_new_server_scanner_file)
									);
									unset($_new_core_deps_x_file, $_new_server_scanner_file, $_new_server_scanner_plugin_dirs);
									unset($_new_core_deps_x_file_contents); // Housekeeping.

									// Copy distribution files into the distros directory.

									$_plugin_extras_distro_dir = $this->distros_dir.'/'.basename($this->plugin_extras_dir);

									$this->©dir->empty_and_remove($_plugin_extras_distro_dir);
									$this->©dir->copy_to($this->plugin_extras_dir, $_plugin_extras_distro_dir);

									$successes->add(__METHOD__.'#plugin_extras_distro_files', get_defined_vars(),
									                sprintf($this->i18n('Plugin extras distro files copied to: `%1$s`.'), $_plugin_extras_distro_dir)
									);

									// Create ZIP archives.

									$_plugin_extras_download_zip   = $this->downloads_dir.'/'.basename($this->plugin_extras_dir).'.zip';
									$_plugin_extras_download_v_zip = $this->downloads_dir.'/'.basename($this->plugin_extras_dir).'-v'.$this->version.'.zip';

									$this->©file->unlink($_plugin_extras_download_zip, $_plugin_extras_download_v_zip);
									$this->©dir->zip_to($_plugin_extras_distro_dir, $_plugin_extras_download_zip);
									$this->©file->copy_to($_plugin_extras_download_zip, $_plugin_extras_download_v_zip);

									$successes->add(__METHOD__.'#plugin_extras_distro_zips', get_defined_vars(),
									                sprintf($this->i18n('Plugin extras distro zipped into: `%1$s`.'), $_plugin_extras_download_zip).
									                sprintf($this->i18n(' And copied into this version: `%1$s`.'), $_plugin_extras_download_v_zip)
									);
									unset($_plugin_extras_distro_dir, $_plugin_extras_download_zip, $_plugin_extras_download_v_zip);
								}
							// Remove new temporary core directory from the plugin development directory now.
							// This comes last because we MAY actually ship the full WebSharks™ Core with the main plugin.
							// However, it will have already been copied into the distro directory now; so we can delete it from the repo.
							$this->©dir->empty_and_remove($_new_core_dir);

							if(!$this->use_core_phar) // If using a PHP Archive; the routines above will have already done this.
								// Need to add this check because GIT reports back with a non-zero status; files no longer in cache.
								$this->©command->git('rm -r --cached '.escapeshellarg($_new_core_dir.'/'), dirname($this->plugin_dir));
							// And then we do this AGAIN; just for good measure. This time with the `--ignore-unmatch` flag to prevent exceptions.
							$this->©command->git('rm -r --cached --ignore-unmatch '.escapeshellarg($_new_core_dir.'/'), dirname($this->plugin_dir));

							$successes->add(__METHOD__.'#new_core_dir_deletion', get_defined_vars(),
							                sprintf($this->i18n(' The temporary WebSharks™ Core directory: `%1$s`; has been deleted from the plugin directory.'), $_new_core_dir).
							                sprintf($this->i18n(' The temporary WebSharks™ Core directory was also removed from the list of GIT-tracked files in this repo: `%1$s`.'), $this->plugin_dir)
							);
							unset($_new_core_dir); // Final housekeeping.

							$successes->add(__METHOD__.'#plugin_build_complete', get_defined_vars(), $this->i18n('Plugin build complete!'));
						}

					// Building the WebSharks™ Core.

					else // We will either build a new WebSharks™ Core (or rebuild this one).
						{
							$is_new       = ($this->___instance_config->core_version !== $this->version);
							$building     = ($is_new) ? $this->i18n('building') : $this->i18n('rebuilding');
							$build        = ($is_new) ? $this->i18n('build') : $this->i18n('rebuild');
							$ucfirst_core = ($is_new) ? $this->i18n('New core') : $this->i18n('Core');
							$new_space    = ($is_new) ? $this->i18n('new').' ' : '';
							$new_slug     = ($is_new) ? 'new_' : '';

							// Create a restore point by committing all new and/or changed files.

							$this->©command->git('add --all', dirname($this->core_dir));
							$this->©command->git('commit --all --allow-empty --message '.escapeshellarg(sprintf($this->i18n('Auto-commit; before %1$s %2$score.'), $building, $new_space)), dirname($this->core_dir));

							$successes->add(__METHOD__.'#before_building_'.$new_slug.'core', get_defined_vars(),
							                sprintf($this->i18n('All existing files (new and/or changed) on the starting GIT branch: `%1$s`;'.
							                                    ' have been added to the list of GIT-tracked files in the WebSharks™ Core repo.'), $this->starting_git_branches['core']).
							                sprintf($this->i18n(' A commit has been processed for all changes to the existing file structure%1$s.'),
								                (($is_new) ? ' '.$this->i18n('(before new branch creation occurs)') : ''))
							);

							// WebSharks™ Core replication.
							// Create a new GIT branch for this version (and switch to this new branch).
							// Only if we ARE building a new version of the core.

							if($is_new) // Replicate WebSharks™ Core into a new directory.
								{
									$this->©command->git('checkout -b '.escapeshellarg($this->version), dirname($this->core_dir));
									// An exception is thrown if the branch already exists. GIT returns a non-zero status.

									$successes->add(__METHOD__.'#branch_new_core_dir', get_defined_vars(),
									                sprintf($this->i18n(' A new GIT branch has been created for core version: `%1$s`.'), $this->version)
									);

									$_replication   = $this->©replicate('', FALSE, $this->version); // No exclusions.
									$_this_core_dir = $_replication->to_dir; // Need this below.

									$this->©command->git('add --intent-to-add '.escapeshellarg($_this_core_dir), dirname($this->core_dir));

									$successes->add(__METHOD__.'#new_core_dir_replication', get_defined_vars(),
									                sprintf($this->i18n('The WebSharks™ Core has been temporarily replicated into this directory: `%1$s`.'), $_this_core_dir).
									                $this->i18n(' This directory has also been added to the list of GIT-tracked files in the WebSharks™ Core repo (but only temporarily).')
									);
									unset($_replication); // Housekeeping.
								}
							else $_this_core_dir = $this->core_dir; // Use directory as-is.

							// Update various core files w/ version numbers and other requirements.

							$_this_core_readme_file    = $_this_core_dir.'/readme.txt';
							$_this_core_framework_file = $_this_core_dir.'/classes/'.$this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->version.'/framework.php';
							$_this_core_deps_x_file    = $_this_core_dir.'/classes/'.$this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->version.'/deps-x.php';

							if(!is_file($_this_core_readme_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_'.$new_slug.'core_readme_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent %1$score `readme.txt` file: `%2$s`.'), $new_space, $_this_core_readme_file)
								);
							else if(!is_readable($_this_core_readme_file) || !is_writable($_this_core_readme_file))
								throw $this->©exception(
									__METHOD__.'#'.$new_slug.'core_readme_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with %1$score `readme.txt` file: `%2$s`.'), $new_space, $_this_core_readme_file)
								);

							if(!is_file($_this_core_framework_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_'.$new_slug.'core_framework_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent %1$score `framework.php` file: `%2$s`.'), $new_space, $_this_core_framework_file)
								);
							else if(!is_readable($_this_core_framework_file) || !is_writable($_this_core_framework_file))
								throw $this->©exception(
									__METHOD__.'#'.$new_slug.'core_framework_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with %1$score `framework.php` file: `%2$s`.'), $new_space, $_this_core_framework_file)
								);

							if(!is_file($_this_core_deps_x_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_'.$new_slug.'core_deps_x_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent %1$score `deps-x.php` file: `%2$s`.'), $new_space, $_this_core_deps_x_file)
								);
							else if(!is_readable($_this_core_deps_x_file) || !is_writable($_this_core_deps_x_file))
								throw $this->©exception(
									__METHOD__.'#'.$new_slug.'core_deps_x_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with %1$score `deps-x.php` file: `%2$s`.'), $new_space, $_this_core_deps_x_file)
								);

							$_this_core_readme_file_contents    = file_get_contents($_this_core_readme_file);
							$_this_core_framework_file_contents = file_get_contents($_this_core_framework_file);
							$_this_core_deps_x_file_contents    = file_get_contents($_this_core_deps_x_file);

							$_this_core_readme_file_contents    = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_this_core_readme_file_contents);
							$_this_core_framework_file_contents = $this->regex_replace('php_code__quoted_string_with_version_marker', $this->version, $_this_core_framework_file_contents);

							$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_v, $_this_core_readme_file_contents);
							$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_v, $_this_core_readme_file_contents);

							$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_v, $_this_core_readme_file_contents);
							$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_v, $_this_core_readme_file_contents);

							$_this_core_deps_x_file_contents = $this->regex_replace('php_code__quoted_string_with_php_version_required_marker', $this->requires_at_least_php_v, $_this_core_deps_x_file_contents);
							$_this_core_deps_x_file_contents = $this->regex_replace('php_code__quoted_string_with_wp_version_required_marker', $this->requires_at_least_wp_v, $_this_core_deps_x_file_contents);

							if(!file_put_contents($_this_core_readme_file, $_this_core_readme_file_contents))
								throw $this->©exception(
									__METHOD__.'#'.$new_slug.'core_readme_file_write_error', get_defined_vars(),
									sprintf($this->i18n('Unable to write (update) the %1$score `readme.txt` file.'), $new_space)
								);
							else if(!file_put_contents($_this_core_framework_file, $_this_core_framework_file_contents))
								throw $this->©exception(
									__METHOD__.'#'.$new_slug.'core_framework_file_write_error', get_defined_vars(),
									sprintf($this->i18n('Unable to write (update) the %1$score `framework.php` file.'), $new_space)
								);
							else if(!file_put_contents($_this_core_deps_x_file, $_this_core_deps_x_file_contents))
								throw $this->©exception(
									__METHOD__.'#'.$new_slug.'core_deps_x_file_write_error', get_defined_vars(),
									sprintf($this->i18n('Unable to write (update) the %1$score `deps-x.php` file.'), $new_space)
								);

							$successes->add(__METHOD__.'#'.$new_slug.'core_file_updates', get_defined_vars(),
							                sprintf($this->i18n('%1$s files updated with versions/requirements.'), $ucfirst_core).
							                sprintf($this->i18n(' %1$s version: `v%2$s`.'), $ucfirst_core, $this->version).
							                sprintf($this->i18n(' %1$s directory: `%2$s`.'), $ucfirst_core, $_this_core_dir).
							                sprintf($this->i18n(' %1$s requires at least PHP version: `%2$s`.'), $ucfirst_core, $this->requires_at_least_php_v).
							                sprintf($this->i18n(' %1$s tested up to PHP version: `%2$s`.'), $ucfirst_core, $this->tested_up_to_php_v).
							                sprintf($this->i18n(' %1$s requires at least WordPress® version: `%2$s`.'), $ucfirst_core, $this->requires_at_least_wp_v).
							                sprintf($this->i18n(' %1$s tested up to WordPress® version: `%2$s`.'), $ucfirst_core, $this->tested_up_to_wp_v)
							);
							unset($_this_core_readme_file, $_this_core_framework_file, $_this_core_deps_x_file);
							unset($_this_core_readme_file_contents, $_this_core_framework_file_contents, $_this_core_deps_x_file_contents);

							// Compress this core directory into a single PHP Archive.

							$_this_core_phar_stub                = dirname($this->core_dir).'/'.$this->___instance_config->core_ns_stub_with_dashes.'.phar';
							$_this_core_distro_temp_dir          = $this->©dir->get_sys_temp_dir().'/'.$this->___instance_config->core_ns_stub_with_dashes;
							$_this_core_distro_temp_dir_stub     = $_this_core_distro_temp_dir.'/stub.php';
							$_this_core_distro_temp_dir_htaccess = $_this_core_distro_temp_dir.'/.htaccess';

							$this->©dir->empty_and_remove($_this_core_distro_temp_dir); // In case it already exists.
							$this->©dir->copy_to($_this_core_dir, $_this_core_distro_temp_dir, array('.gitignore' => dirname($this->core_dir).'/.gitignore'), TRUE);

							if(!is_file($_this_core_distro_temp_dir_htaccess) || !is_readable($_this_core_distro_temp_dir_htaccess)
							   || FALSE === strpos(file_get_contents($_this_core_distro_temp_dir_htaccess), 'AcceptPathInfo')
							) throw $this->©exception(
								__METHOD__.'#unable_to_find_valid_htaccess_file_in_'.$new_slug.'core_distro_temp_dir', get_defined_vars(),
								sprintf($this->i18n('Unable to find a valid `.htaccess` file here: `%1$s`.'), $_this_core_distro_temp_dir_htaccess).
								$this->i18n(' This file MUST exist; and it MUST contain: `AcceptPathInfo` for webPhar compatibility.')
							);

							$this->©file->unlink($_this_core_phar_stub, $_this_core_phar_stub.'.php');
							$this->©dir->phar_to($_this_core_distro_temp_dir, $_this_core_phar_stub, $_this_core_distro_temp_dir_stub);
							$this->©dir->empty_and_remove($_this_core_distro_temp_dir);

							$this->©command->git('add --intent-to-add '.escapeshellarg($_this_core_phar_stub.'.php'), dirname($this->core_dir));

							$successes->add(__METHOD__.'#'.$new_slug.'core_phar_stub_php_built_for_'.$new_slug.'core_distro_temp_dir', get_defined_vars(),
							                sprintf($this->i18n('A temporary distro copy of the WebSharks™ Core has been compressed into a single PHP Archive file here: `%1$s`.'), $_this_core_phar_stub.'.php').
							                $this->i18n(' This file has been added to the list of GIT-tracked files in the WebSharks™ Core repo.').
							                $this->i18n(' The temporary distro copy of the WebSharks™ Core was deleted after processing.')
							);
							unset($_this_core_phar_stub, $_this_core_distro_temp_dir, $_this_core_distro_temp_dir_stub, $_this_core_distro_temp_dir_htaccess);

							// Handle deletion and rename/replacement from existing core directory; to new core directory.

							if($is_new) // We MUST do this last to avoid SPL autoload issues while we're working here.
								{
									$this->©dir->empty_and_remove($this->core_dir);
									$this->©command->git('rm -r --cached '.escapeshellarg($this->core_dir.'/'), dirname($this->core_dir));
									$this->©command->git('rm -r --cached '.escapeshellarg($_this_core_dir.'/'), dirname($this->core_dir));

									$this->©dir->rename_to($_this_core_dir, ($_this_core_dir = $this->core_dir));
									$this->©command->git('add --intent-to-add '.escapeshellarg($_this_core_dir.'/'), dirname($this->core_dir));

									$successes->add(__METHOD__.'#after_new_core_dir', get_defined_vars(),
									                sprintf($this->i18n('The old core directory has been deleted from this GIT branch: `%1$s`.'), $this->version).
									                sprintf($this->i18n(' The new temporary core directory takes its place. Now with the directory name: `%1$s`'), $_this_core_dir).
									                $this->i18n(' The new core directory has been added to the list of GIT-tracked files in the WebSharks™ Core repo.')
									);
								}
							unset($_this_core_dir); // Final housekeeping.

							$successes->add(__METHOD__.'#'.$new_slug.'core_build_complete',
							                get_defined_vars(), sprintf($this->i18n('%1$s %2$s complete!'), $ucfirst_core, $build));
						}
					$successes->add(__METHOD__.'#finish_time', get_defined_vars(),
					                sprintf($this->i18n('Finish time: %1$s.'), $this->©env->time_details())
					);
					return $successes; // Return all successes now.
				}

			/**
			 * Handles replacements in regex patterns.
			 *
			 * @param string $pattern_name A regex pattern name.
			 *    See: {@link \websharks_core_v000000_dev\builder\regex()}
			 *
			 * @param string $value The value to insert when handling replacements in the pattern.
			 *
			 * @param string $string The input string to perform replacements on.
			 *
			 * @return string The ``$string`` value after replacements.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If there is no matching pattern name for ``$pattern_name``.
			 * @throws exception If ``$pattern_name`` or ``$string`` are empty. These MUST be NOT-empty strings.
			 * @throws exception If there are NO replacements than can be performed; or the resulting ``$string`` is empty.
			 */
			public function regex_replace($pattern_name, $value, $string)
				{
					$this->check_arg_types('string:!empty', 'string', 'string:!empty', func_get_args());

					$pattern = $this->regex($pattern_name);

					switch($pattern_name)
					{
						case 'plugin_readme__php_requires_at_least_version':
						case 'plugin_readme__php_tested_up_to_version':
						case 'plugin_readme__wp_requires_at_least_version':
						case 'plugin_readme__wp_tested_up_to_version':
						case 'plugin_readme__wp_version_stable_tag':
								$string = preg_replace($pattern, '${1}'.$this->©string->esc_refs($value), $string, -1, $replacements);
								break;

						case 'php_code__deps_x__define_stand_alone_plugin_name':
						case 'php_code__deps_x__define_stand_alone_plugin_dir_names':
								$string = preg_replace($pattern, '${1}'.$this->©string->esc_refs($this->©string->esc_sq($value)).'${3}', $string, -1, $replacements);
								break;

						case 'php_code__deps_x__declare_stand_alone_class_name':
								$string = preg_replace($pattern, '${1}'.$this->©string->esc_refs($value).'${2}', $string, -1, $replacements);
								break;

						case 'php_code__quoted_string_with_version_marker':
						case 'php_code__quoted_string_with_php_version_required_marker':
						case 'php_code__quoted_string_with_wp_version_required_marker':
								$string = preg_replace($pattern, '${1}'.$this->©string->esc_refs($this->©string->esc_sq($value)).'${3}', $string, -1, $replacements);
								break;

						default: // What?
							throw $this->©exception(
								__METHOD__.'#regex_replacement_failure_unexpected_pattern_name', compact('pattern', 'pattern_name'),
								sprintf($this->i18n('Unexpected regex pattern name: `%1$s`.'), $pattern_name)
							);
					}
					if(!$string || empty($replacements))
						throw $this->©exception(
							__METHOD__.'#regex_replacement_failure', compact('pattern', 'pattern_name'),
							sprintf($this->i18n('Failure to match the following pattern name: `%1$s`.'), $pattern_name)
						);
					return $string; // With replacements.
				}

			/**
			 * Returns a frequently used regex pattern (for build routines).
			 *
			 * @param string $matching A regex pattern matching ID.
			 *
			 * @return string A regex pattern.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If there is no matching pattern.
			 */
			public function regex($matching)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					$patterns = array(
						'plugin_readme__php_requires_at_least_version'             => '/^(Requires\s+at\s+least\s+PHP\s+version\:\s*)([0-9a-z\.\-]*)$/im',
						'plugin_readme__php_tested_up_to_version'                  => '/^(Tested\s+up\s+to\s+PHP\s+version\:\s*)([0-9a-z\.\-]*)$/im',
						'plugin_readme__wp_requires_at_least_version'              => '/^(Requires\s+at\s+least(?:\s+WordPress\s+version)?\:\s*)([0-9a-z\.\-]*)$/im',
						'plugin_readme__wp_tested_up_to_version'                   => '/^(Tested\s+up\s+to(?:\s+WordPress\s+version)?\:\s*)([0-9a-z\.\-]*)$/im',
						'plugin_readme__wp_version_stable_tag'                     => '/^((?:Version|Stable\s+tag)\:\s*)([0-9a-z\.\-]*)$/im',

						'php_code__deps_x__define_stand_alone_plugin_name'         => '/(define\s*\(\s*\'___STAND_ALONE__PLUGIN_NAME\'\s*,\s*\')(.*?)(\'\s*\)\s*;\s*#\!stand\-alone\-plugin\-name\!#)/i',
						'php_code__deps_x__define_stand_alone_plugin_dir_names'    => '/(define\s*\(\s*\'___STAND_ALONE__PLUGIN_DIR_NAMES\'\s*,\s*\')([0-9a-z\-]*)(\'\s*\)\s*;\s*#\!stand\-alone\-plugin\-dir\-names\!#)/i',
						'php_code__deps_x__declare_stand_alone_class_name'         => '/(class\s+deps_x_'.ltrim(rtrim($this->©string->regex_valid_ws_core_ns_version, '$/'), '/^').')(\s*#\!stand\-alone\!#)/i',

						'php_code__quoted_string_with_version_marker'              => '/(\')([0-9a-z\.\-]*)(\'\s*[;,]?\s*#\!version\!#)/i',
						'php_code__quoted_string_with_php_version_required_marker' => '/(\')([0-9a-z\.\-]*)(\'\s*[;,]?\s*#\!php\-version\-required\!#)/i',
						'php_code__quoted_string_with_wp_version_required_marker'  => '/(\')([0-9a-z\.\-]*)(\'\s*[;,]?\s*#\!wp\-version\-required\!#)/i'
					);
					if(empty($patterns[$matching]))
						throw $this->©exception(
							__METHOD__.'#unknown_pattern', get_defined_vars(),
							sprintf($this->i18n('No regex pattern matching: `%1$s`.'), $matching)
						);
					return $patterns[$matching];
				}
		}
	}