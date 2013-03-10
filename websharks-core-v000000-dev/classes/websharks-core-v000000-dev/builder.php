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
			 * @var boolean Update core directory junction?
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $update_core_jctn = FALSE;

			/**
			 * @var boolean Build from a specific core version?
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $build_from_core_v = '';

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
			 * @param null|string|boolean $update_core_jctn Defaults to a value of NULL; which defaults to TRUE (for the core itself).
			 *    If this is set to a string|boolean value; that value will be used explicitly (e.g. there will be no auto-detection whatsoever).
			 *    This core directory junction is what all WebSharks™ Core projects use in development. Update the junction to use this new build?
			 *    This is ONLY applicable to core builds. If building the core; this parameter decides if we update the core directory junction.
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
			public function __construct($___instance_config, $plugin_dir = '', $plugin_name = '', $plugin_ns = '', $distros_dir = '', $downloads_dir = '', $version = '', $requires_at_least_php_v = '', $tested_up_to_php_v = '', $requires_at_least_wp_v = '', $tested_up_to_wp_v = '', $use_core_phar = NULL, $update_core_jctn = NULL, $build_from_core_v = '')
				{
					parent::__construct($___instance_config);

					// Check arguments expected by this constructor.

					$this->check_arg_types('', 'string', 'string', 'string', 'string', 'string', array('integer', 'string'), 'string', 'string', 'string', 'string', array('null', 'string', 'boolean'), array('null', 'string', 'boolean'), 'string', func_get_args());

					// Set property value ``$this->can_build``, upon class construction.

					if(PHP_SAPI !== 'cli')
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

							$this->update_core_jctn = (!$this->plugin_dir) ? TRUE : FALSE;

							if(!$this->plugin_dir && is_bool($update_core_jctn))
								$this->update_core_jctn = $update_core_jctn;
							else if(!$this->plugin_dir && is_string($update_core_jctn) && strlen($update_core_jctn))
								$this->update_core_jctn = $this->©string->is_true($update_core_jctn);

							$this->build_from_core_v = ($build_from_core_v) ? $build_from_core_v : $this->___instance_config->core_ns_v_with_dashes;

							if($this->plugin_dir && !is_dir($this->plugin_dir))
								throw $this->©exception(
									__METHOD__.'#nonexistent_plugin_dir', get_defined_vars(),
									sprintf($this->i18n('Nonexistent plugin directory: `%1$s`.'), $this->plugin_dir)
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

							if($this->build_from_core_v !== $this->___instance_config->core_ns_v_with_dashes)
								throw $this->©exception(
									__METHOD__.'#invalid_build_from_core_v', get_defined_vars(),
									sprintf($this->i18n('Building from incorrect core version: `%1$s`.'), $this->build_from_core_v).
									sprintf($this->i18n(' This is version `%1$s` of the WebSharks™ Core.'), $this->___instance_config->core_ns_v_with_dashes)
								);

							if(($successes = $this->build()))
								$this->successes = $successes;

							else throw $this->©exception(
								__METHOD__.'#build_failure', NULL,
								$this->i18n('Failure. Unable to build.')
							);
						}
					else throw $this->©exception(
						__METHOD__.'#cannot_build', NULL,
						$this->i18n('Security check. Unable to build.')
					);
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

					if($this->plugin_dir) // Building a plugin.
						{
							// Validate core directory.

							if(!is_readable($this->core_dir))
								throw $this->©exception(
									__METHOD__.'#core_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with core directory: `%1$s`.'), $this->core_dir)
								);

							// Validate core `.gitignore` file.

							if(!file_exists(dirname($this->core_dir).'/.gitignore'))
								throw $this->©exception(
									__METHOD__.'#nonexistent_core_gitignore_file', get_defined_vars(),
									sprintf($this->i18n('Invalid core directory. Missing `.gitignore` file: `%1$s`.'), dirname($this->core_dir).'/.gitignore')
								);

							// Validate plugin pro directory.

							if(!is_readable($this->plugin_dir) || !is_writable($this->plugin_dir))
								throw $this->©exception(
									__METHOD__.'#plugin_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin directory: `%1$s`.'), $this->plugin_dir)
								);

							// WebSharks™ Core replication.

							$_replication  = $this->©replicate($this->plugin_dir, TRUE, 0, array('.gitignore' => dirname($this->core_dir).'/.gitignore'));
							$_new_core_dir = $_replication->to_dir; // We'll need this below.
							unset($_replication); // Housekeeping.

							/*
							 * Now: we MUST add this new core directory to version control; for TWO important reasons.
							 *
							 *    1. When we build a plugin (e.g. replicate into a plugin directory); if this directory were left untracked;
							 *       it would be excluded automatically when we attempt to copy files from this directory into the distro directory.
							 *
							 *       To clarify this point further... Replicating this new core into a plugin directory would result in no core directory in the distro;
							 *       because all of these files would be untracked; and thus excluded by `git ls-files --others --directory`.
							 *       See: {@link \websharks_core_v000000_dev\dirs\copy_to()} for further details on this.
							 *
							 *    2. Related to #1. If this new core directory were left untracked; there would be no way for `git ls-files --others --directory`
							 *          to provide a distro copy routine with the data it needs to properly identify which files inside this new core directory
							 *          should be excluded. In fact, it would simply exclude them all; because they would all be untracked (see point #1).
							 *
							 *       To clarify THIS point further though... after this new core directory is added to version control
							 *       we will expect to receive the following from `git ls-files --others --directory`.
							 *
							 *       `websharks-core-v[new version]/._dev-utilities/`
							 *
							 *       ...and so on, for any exclusions that occur as a result of `.gitignore`.
							 *       If the new directory were untracked; we would NOT have this critical information.
							 *
							 *       NOTE: Since the core is replicated into the plugin directory w/ `.gitignore` exclusions applied already;
							 *          this point is somewhat moot. However, it's NOT a bad idea to have this redundancy in place.
							 *          After all, this is the procedure that one would expect; and redundancy can be a good thing :-)
							 *
							 *    NOTE: We use `git add --intent-to-add <pattern>`.
							 *       Records only the fact that the path will be added later.
							 *       An entry for the path is placed in the index with no content.
							 *    See: {@link http://git-scm.com/docs/git-add}
							 */
							$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_dir.'/'), dirname($this->plugin_dir));

							$successes->add(__METHOD__.'#new_core_dir_replication_into_plugin_dir', get_defined_vars(),
							                sprintf($this->i18n('The WebSharks™ Core has been temporarily replicated into this plugin directory: `%1$s`.'), $_new_core_dir).
							                $this->i18n(' This directory has also been added to the list of GIT-tracked files in this repo (but only temporarily).').
							                sprintf($this->i18n(' Every file in the entire plugin directory has now been updated to use `v%1$s` of the WebSharks™ Core.'), $this->___instance_config->core_ns_v_with_dashes)
							);

							// Copy WebSharks™ Core stub into the main plugin directory.

							$_core_stub                  = $this->core_dir.'/stub.php';
							$_new_core_stub              = $this->plugin_dir.'/'.$this->___instance_config->core_ns_with_dashes.'.php';
							$_old_core_stub_glob_pattern = $this->plugin_dir.'/'.$this->___instance_config->core_ns_stub_with_dashes.'-v[0-9]*.php';

							if(!file_exists($_core_stub))
								throw $this->©exception(
									__METHOD__.'#unable_to_find_core_stub', get_defined_vars(),
									sprintf($this->i18n('Unable to find core stub: `%1$s`.'), $_core_stub)
								);
							else if(!is_integer($this->©file->unlink_glob($_old_core_stub_glob_pattern)))
								throw $this->©exception(
									__METHOD__.'#unable_to_delete_old_core_stub_glob_pattern', get_defined_vars(),
									sprintf($this->i18n('Unable to delete old core stub glob pattern: `%1$s`.'), $_old_core_stub_glob_pattern)
								);
							else if(!copy($_core_stub, $_new_core_stub))
								throw $this->©exception(
									__METHOD__.'#unable_to_copy_core_stub_into_plugin_dir', get_defined_vars(),
									sprintf($this->i18n('Unable to copy core stub into plugin directory: `%1$s`.'), $_new_core_stub)
								);
							$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_stub), dirname($this->plugin_dir));

							$successes->add(__METHOD__.'#new_core_stub_added_to_plugin_dir', get_defined_vars(),
							                sprintf($this->i18n('The WebSharks™ Core stub has been added to the plugin directory: `%1$s`.'), $_new_core_stub).
							                $this->i18n(' This file has also been added to the list of GIT-tracked files in this repo.')
							);
							unset($_core_stub, $_new_core_stub, $_old_core_stub_glob_pattern);

							// Bundle the WebSharks™ Core PHP Archive stub; instead of the full directory?

							if($this->use_core_phar) // Optional (this is only applicable to plugins).
								{
									$_core_phar_stub                  = dirname($this->core_dir).'/'.$this->___instance_config->core_ns_with_dashes.'.phar.php';
									$_new_core_phar_stub              = $this->plugin_dir.'/'.$this->___instance_config->core_ns_with_dashes.'.php';
									$_old_core_phar_stub_glob_pattern = $this->plugin_dir.'/'.$this->___instance_config->core_ns_stub_with_dashes.'-v[0-9]*.php';
									$_plugin_dir_htaccess_file        = $this->plugin_dir.'/.htaccess';

									if(!file_exists($_core_phar_stub))
										throw $this->©exception(
											__METHOD__.'#unable_to_find_core_phar_stub', get_defined_vars(),
											sprintf($this->i18n('Unable to find core PHAR stub: `%1$s`.'), $_core_phar_stub)
										);
									else if(!file_exists($_plugin_dir_htaccess_file)
									        || !is_readable($_plugin_dir_htaccess_file)
									        || FALSE === strpos(file_get_contents($_plugin_dir_htaccess_file), 'AcceptPathInfo')
									) throw $this->©exception(
											__METHOD__.'#unable_to_find_valid_htaccess_file_in_plugin_dir', get_defined_vars(),
											sprintf($this->i18n('Unable to find a valid `.htaccess` file here: `%1$s`.'), $_plugin_dir_htaccess_file).
											$this->i18n(' This file MUST exist; and it MUST contain: `AcceptPathInfo` for webPhar compatibility.')
										);
									else if(!is_integer($this->©file->unlink_glob($_old_core_phar_stub_glob_pattern)))
										throw $this->©exception(
											__METHOD__.'#unable_to_delete_old_core_phar_stub_glob_pattern', get_defined_vars(),
											sprintf($this->i18n('Unable to delete old core PHAR stub glob pattern: `%1$s`.'), $_old_core_phar_stub_glob_pattern)
										);
									else if(!copy($_core_phar_stub, $_new_core_phar_stub))
										throw $this->©exception(
											__METHOD__.'#unable_to_copy_core_phar_stub_into_plugin_dir', get_defined_vars(),
											sprintf($this->i18n('Unable to copy `%1$s` into `%2$s`.'), $_core_phar_stub, $_new_core_phar_stub)
										);
									$this->©command->git('rm -r --cached '.escapeshellarg($_new_core_dir.'/'), dirname($this->plugin_dir));
									$this->©command->git('rm -r --cached '.escapeshellarg($_old_core_phar_stub_glob_pattern), dirname($this->plugin_dir));
									$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_phar_stub), dirname($this->plugin_dir));

									$successes->add(__METHOD__.'#new_core_phar_stub_added_to_plugin_dir', get_defined_vars(),
									                sprintf($this->i18n('The WebSharks™ Core PHAR stub for `v%1$s`; has been copied to: `%2$s`.'), $this->___instance_config->core_ns_v_with_dashes, $_new_core_phar_stub).
									                $this->i18n(' This file (a compressed PHP Archive); has been added to the list of GIT-tracked files in this repo. The original stub file was deleted; and removed from GIT-tracked files in this repo.').
									                sprintf($this->i18n(' The original full WebSharks™ Core directory has also been removed from the list of GIT-tracked files in this repo: `%1$s`.'), $_new_core_dir)
									);
									unset($_core_phar_stub, $_new_core_phar_stub, $_old_core_phar_stub_glob_pattern, $_plugin_dir_htaccess_file);
								}

							// Update various plugin files w/ version numbers and other requirements.

							$_plugin_file           = $this->plugin_dir.'/'.basename($this->plugin_dir).'.php';
							$_plugin_readme_file    = $this->plugin_dir.'/readme.txt';
							$_plugin_framework_file = $this->plugin_dir.'/classes/'.str_replace('_', '-', $this->plugin_ns).'/framework.php';

							if(!file_exists($_plugin_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_plugin_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent plugin file: `%1$s`.'), $_plugin_file)
								);
							else if(!is_readable($_plugin_file) || !is_writable($_plugin_file))
								throw $this->©exception(
									__METHOD__.'#plugin_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin file: `%1$s`.'), $_plugin_file)
								);

							if(!file_exists($_plugin_readme_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_plugin_readme_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent plugin `readme.txt` file: `%1$s`.'), $_plugin_readme_file)
								);
							else if(!is_readable($_plugin_readme_file) || !is_writable($_plugin_readme_file))
								throw $this->©exception(
									__METHOD__.'#plugin_readme_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin `readme.txt` file: `%1$s`.'), $_plugin_readme_file)
								);

							if(!file_exists($_plugin_framework_file))
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
							                sprintf($this->i18n(' Uses WebSharks™ Core: `v%1$s`.'), $this->___instance_config->core_ns_v_with_dashes).
							                sprintf($this->i18n(' Plugin requires at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
							                sprintf($this->i18n(' Plugin tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v)
							);
							unset($_plugin_file, $_plugin_framework_file, $_plugin_readme_file, $_replacements);
							unset($_plugin_file_contents, $_plugin_framework_file_contents, $_plugin_readme_file_contents);

							// Validate distros/downloads directory.

							if(!is_readable($this->distros_dir) || !is_writable($this->distros_dir))
								throw $this->©exception(
									__METHOD__.'#distros_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with distros directory: `%1$s`.'), $this->distros_dir)
								);
							else if(!is_readable($this->downloads_dir) || !is_writable($this->downloads_dir))
								throw $this->©exception(
									__METHOD__.'#downloads_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with downloads directory: `%1$s`.'), $this->downloads_dir)
								);

							// Copy distribution files into the distros directory.

							$_plugin_gitignore_file = dirname($this->plugin_dir).'/.gitignore';
							$_plugin_distro_dir     = $this->distros_dir.'/'.basename($this->plugin_dir);

							if(!file_exists($_plugin_gitignore_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_plugin_gitignore_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent plugin `.gitignore` file: `%1$s`.'), $_plugin_gitignore_file)
								);
							else if(is_dir($_plugin_distro_dir) && !$this->©dir->empty_and_remove($_plugin_distro_dir))
								throw $this->©exception(
									__METHOD__.'#existing_plugin_distro_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with existing plugin distro directory: `%1$s`.'), $_plugin_distro_dir)
								);

							if(!$this->©dir->copy_to($this->plugin_dir, $_plugin_distro_dir, array('.gitignore' => $_plugin_gitignore_file), TRUE))
								throw $this->©exception(
									__METHOD__.'#plugin_distro_dir_copy_failure', get_defined_vars(),
									sprintf($this->i18n('Unable to copy plugin dir into distro directory: `%1$s`.'), $_plugin_distro_dir)
								);

							$successes->add(__METHOD__.'#plugin_distro_files', get_defined_vars(),
							                sprintf($this->i18n('Plugin distro files copied to: `%1$s`.'), $_plugin_distro_dir)
							);
							unset($_plugin_gitignore_file); // Housekeeping.

							// Generate plugin distro directory checksum.

							$_plugin_distro_dir_checksum = $this->©dir->checksum($_plugin_distro_dir, TRUE);

							$successes->add(__METHOD__.'#plugin_distro_dir_checksum', get_defined_vars(),
							                sprintf($this->i18n('Plugin distro directory checksum file updated to: `%1$s`.'), $_plugin_distro_dir_checksum)
							);
							unset($_plugin_distro_dir_checksum); // Housekeeping.

							// Create ZIP archives.

							$_plugin_download_zip   = $this->downloads_dir.'/'.basename($this->plugin_dir).'.zip';
							$_plugin_download_v_zip = $this->downloads_dir.'/'.basename($this->plugin_dir).'-v'.$this->version.'.zip';

							if(file_exists($_plugin_download_zip) && (!is_writable($_plugin_download_zip) || !unlink($_plugin_download_zip)))
								throw $this->©exception(
									__METHOD__.'#existing_plugin_download_zip_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with existing plugin downloads ZIP: `%1$s`.'), $_plugin_download_zip)
								);
							else if(file_exists($_plugin_download_v_zip) && (!is_writable($_plugin_download_v_zip) || !unlink($_plugin_download_v_zip)))
								throw $this->©exception(
									__METHOD__.'#existing_plugin_download_v_zip_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with existing plugin downloads version ZIP: `%1$s`.'), $_plugin_download_v_zip)
								);

							if(!$this->©dir->zip_to($_plugin_distro_dir, $_plugin_download_zip))
								throw $this->©exception(
									__METHOD__.'#plugin_distro_dir_zip_failure', get_defined_vars(),
									sprintf($this->i18n('Unable to ZIP plugin distro dir into downloads directory: `%1$s`.'), $_plugin_download_zip)
								);
							else if(!copy($_plugin_download_zip, $_plugin_download_v_zip))
								throw $this->©exception(
									__METHOD__.'#plugin_download_v_zip_copy_failure', get_defined_vars(),
									sprintf($this->i18n('Unable to copy plugin ZIP into a version ZIP file: `%1$s`.'), $_plugin_download_v_zip)
								);

							$successes->add(__METHOD__.'#plugin_distro_zips', get_defined_vars(),
							                sprintf($this->i18n('Plugin distro zipped into: `%1$s`.'), $_plugin_download_zip).
							                sprintf($this->i18n(' And copied into this version: `%1$s`.'), $_plugin_download_v_zip)
							);
							unset($_plugin_distro_dir, $_plugin_download_zip, $_plugin_download_v_zip); // Housekeeping.

							// Handle a possible pro add-on directory.

							if($this->plugin_pro_dir) // Is there a pro directory also?
								{
									// Validate plugin pro directory.

									if(!is_readable($this->plugin_pro_dir) || !is_writable($this->plugin_pro_dir))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_dir_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with plugin pro directory: `%1$s`.'), $this->plugin_pro_dir)
										);

									// WebSharks™ Core replication here too.
									// This way all pro files are updated also.

									$_replication      = $this->©replicate($this->plugin_pro_dir, TRUE, 0, array('.gitignore' => dirname($this->core_dir).'/.gitignore'));
									$_new_pro_core_dir = $_replication->to_dir; // We'll need this below.

									$successes->add(__METHOD__.'#new_pro_core_dir_replication', get_defined_vars(),
									                sprintf($this->i18n('The WebSharks™ Core has been temporarily replicated into this plugin pro directory: `%1$s`.'), $_new_pro_core_dir).
									                sprintf($this->i18n(' Every file in the entire plugin pro directory has now been updated to use version `%1$s` of the WebSharks™ Core.'), $this->___instance_config->core_ns_v_with_dashes)
									);

									// Remove temporary core from the plugin pro development directory now.

									if(!$this->©dir->empty_and_remove($_new_pro_core_dir))
										throw $this->©exception(
											__METHOD__.'#new_pro_core_dir_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues during removal of new temporary pro core directory: `%1$s`.'), $_new_pro_core_dir)
										);
									$successes->add(__METHOD__.'#new_pro_core_dir_deletion', get_defined_vars(),
									                sprintf($this->i18n('The temporary WebSharks™ Core has been deleted from the plugin pro directory: `%1$s`.'), $_new_pro_core_dir)
									);
									unset($_replication, $_new_pro_core_dir); // Housekeeping.

									// Update various plugin pro files w/ version numbers and other requirements.

									$_plugin_pro_file        = $this->plugin_pro_dir.'/'.basename($this->plugin_pro_dir).'.php';
									$_plugin_pro_readme_file = $this->plugin_pro_dir.'/readme.txt';
									$_plugin_pro_class_file  = $this->plugin_pro_dir.'/classes/'.str_replace('_', '-', $this->plugin_ns).'/pro.php';

									if(!file_exists($_plugin_pro_file))
										throw $this->©exception(
											__METHOD__.'#nonexistent_plugin_pro_file', get_defined_vars(),
											sprintf($this->i18n('Nonexistent plugin pro file: `%1$s`.'), $_plugin_pro_file)
										);
									else if(!is_readable($_plugin_pro_file) || !is_writable($_plugin_pro_file))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_file_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with plugin pro file: `%1$s`.'), $_plugin_pro_file)
										);

									if(!file_exists($_plugin_pro_readme_file))
										throw $this->©exception(
											__METHOD__.'#nonexistent_plugin_pro_readme_file', get_defined_vars(),
											sprintf($this->i18n('Nonexistent plugin pro `readme.txt` file: `%1$s`.'), $_plugin_pro_readme_file)
										);
									else if(!is_readable($_plugin_pro_readme_file) || !is_writable($_plugin_pro_readme_file))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_readme_file_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with plugin pro `readme.txt` file: `%1$s`.'), $_plugin_pro_readme_file)
										);

									if(!file_exists($_plugin_pro_class_file))
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
									                sprintf($this->i18n(' Uses WebSharks™ Core: `v%1$s`.'), $this->___instance_config->core_ns_v_with_dashes).
									                sprintf($this->i18n(' Pro add-on requires at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
									                sprintf($this->i18n(' Pro add-on tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v)
									);
									unset($_plugin_pro_file, $_plugin_pro_class_file, $_plugin_pro_readme_file, $_replacements);
									unset($_plugin_pro_file_contents, $_plugin_pro_class_file_contents, $_plugin_pro_readme_file_contents);

									// Copy distribution files into the distros directory.

									$_plugin_pro_gitignore_file = dirname($this->plugin_pro_dir).'/.gitignore';
									$_plugin_pro_distro_dir     = $this->distros_dir.'/'.basename($this->plugin_pro_dir);

									if(!file_exists($_plugin_pro_gitignore_file))
										throw $this->©exception(
											__METHOD__.'#nonexistent_plugin_pro_gitignore_file', get_defined_vars(),
											sprintf($this->i18n('Nonexistent plugin pro `.gitignore` file: `%1$s`.'), $_plugin_pro_gitignore_file)
										);
									else if(is_dir($_plugin_pro_distro_dir) && !$this->©dir->empty_and_remove($_plugin_pro_distro_dir))
										throw $this->©exception(
											__METHOD__.'#existing_plugin_pro_distro_dir_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with existing plugin pro distro directory: `%1$s`.'), $_plugin_pro_distro_dir)
										);

									if(!$this->©dir->copy_to($this->plugin_pro_dir, $_plugin_pro_distro_dir, array('.gitignore' => $_plugin_pro_gitignore_file), TRUE))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_distro_dir_copy_failure', get_defined_vars(),
											sprintf($this->i18n('Unable to copy plugin pro dir into distro directory: `%1$s`.'), $_plugin_pro_distro_dir)
										);

									$successes->add(__METHOD__.'#plugin_pro_distro_files', get_defined_vars(),
									                sprintf($this->i18n('Plugin pro distro files copied to: `%1$s`.'), $_plugin_pro_distro_dir)
									);
									unset($_plugin_pro_gitignore_file); // Housekeeping.

									// Generate plugin distro directory checksum.

									$_plugin_pro_distro_dir_checksum = $this->©dir->checksum($_plugin_pro_distro_dir, TRUE);

									$successes->add(__METHOD__.'#plugin_pro_distro_dir_checksum', get_defined_vars(),
									                sprintf($this->i18n('Plugin pro distro directory checksum file updated to: `%1$s`.'), $_plugin_pro_distro_dir_checksum)
									);
									unset($_plugin_pro_distro_dir_checksum); // Housekeeping.

									// Create ZIP archives.

									$_plugin_pro_download_zip   = $this->downloads_dir.'/'.basename($this->plugin_pro_dir).'.zip';
									$_plugin_pro_download_v_zip = $this->downloads_dir.'/'.basename($this->plugin_pro_dir).'-v'.$this->version.'.zip';

									if(file_exists($_plugin_pro_download_zip) && (!is_writable($_plugin_pro_download_zip) || !unlink($_plugin_pro_download_zip)))
										throw $this->©exception(
											__METHOD__.'#existing_plugin_pro_download_zip_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with existing plugin pro downloads ZIP: `%1$s`.'), $_plugin_pro_download_zip)
										);
									else if(file_exists($_plugin_pro_download_v_zip) && (!is_writable($_plugin_pro_download_v_zip) || !unlink($_plugin_pro_download_v_zip)))
										throw $this->©exception(
											__METHOD__.'#existing_plugin_pro_download_v_zip_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with existing plugin pro downloads version ZIP: `%1$s`.'), $_plugin_pro_download_v_zip)
										);

									if(!$this->©dir->zip_to($_plugin_pro_distro_dir, $_plugin_pro_download_zip))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_distro_dir_zip_failure', get_defined_vars(),
											sprintf($this->i18n('Unable to ZIP plugin pro distro dir into downloads directory: `%1$s`.'), $_plugin_pro_download_zip)
										);
									else if(!copy($_plugin_pro_download_zip, $_plugin_pro_download_v_zip))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_download_v_zip_copy_failure', get_defined_vars(),
											sprintf($this->i18n('Unable to copy plugin pro ZIP into a version ZIP file: `%1$s`.'), $_plugin_pro_download_v_zip)
										);

									$successes->add(__METHOD__.'#plugin_pro_distro_zips', get_defined_vars(),
									                sprintf($this->i18n('Plugin pro distro zipped into: `%1$s`.'), $_plugin_pro_download_zip).
									                sprintf($this->i18n(' And copied into this version: `%1$s`.'), $_plugin_pro_download_v_zip)
									);
									unset($_plugin_pro_distro_dir, $_plugin_pro_download_zip, $_plugin_pro_download_v_zip);
								}

							// Handle a possible extras directory.

							if($this->plugin_extras_dir) // Is there an extras directory also?
								{
									// Validate plugin extras directory.

									if(!is_readable($this->plugin_extras_dir) || !is_writable($this->plugin_extras_dir))
										throw $this->©exception(
											__METHOD__.'#plugin_extras_dir_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with plugin extras directory: `%1$s`.'), $this->plugin_extras_dir)
										);

									// WebSharks™ Core replication here too.
									// This way all extra files are updated also.

									$_replication         = $this->©replicate($this->plugin_extras_dir, TRUE, 0, array('.gitignore' => dirname($this->core_dir).'/.gitignore'));
									$_new_extras_core_dir = $_replication->to_dir; // We'll need this below.

									$successes->add(__METHOD__.'#new_extras_core_dir_replication', get_defined_vars(),
									                sprintf($this->i18n('The WebSharks™ Core has been temporarily replicated into this plugin extras directory: `%1$s`.'), $_new_extras_core_dir).
									                sprintf($this->i18n(' Every file in the entire plugin extras directory has now been updated to use version `%1$s` of the WebSharks™ Core.'), $this->___instance_config->core_ns_v_with_dashes)
									);
									// Remove temporary core from the plugin extras development directory now.

									if(!$this->©dir->empty_and_remove($_new_extras_core_dir))
										throw $this->©exception(
											__METHOD__.'#new_extras_core_dir_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues during removal of new temporary extras core directory: `%1$s`.'), $_new_extras_core_dir)
										);
									$successes->add(__METHOD__.'#new_extras_core_dir_deletion', get_defined_vars(),
									                sprintf($this->i18n('The temporary WebSharks™ Core has been deleted from the plugin extras directory: `%1$s`.'), $_new_extras_core_dir)
									);
									unset($_replication, $_new_extras_core_dir); // Housekeeping.

									// Update various extra files w/ version numbers and other requirements.

									$_new_core_deps_x_file           = $_new_core_dir.'/classes/'.$this->___instance_config->core_ns_with_dashes.'/deps-x.php';
									$_new_server_scanner_file        = $_old_server_scanner_file = $this->plugin_extras_dir.'/'.basename($this->plugin_dir).'-server-scanner.php';
									$_new_server_scanner_plugin_dirs = basename($this->plugin_dir).(($this->plugin_pro_dir) ? ','.basename($this->plugin_pro_dir) : '');

									if(!file_exists($_new_core_deps_x_file))
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

									if(file_exists($_old_server_scanner_file) && (!is_writable($_old_server_scanner_file) || !unlink($_old_server_scanner_file)))
										throw $this->©exception(
											__METHOD__.'#old_server_scanner_file_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with old server scanner file: `%1$s`.'), $_new_server_scanner_file)
										);

									$_new_core_deps_x_file_contents = $this->regex_replace('php_code__deps_x__define_stand_alone_plugin_name', $this->plugin_name, $_new_core_deps_x_file_contents);
									$_new_core_deps_x_file_contents = $this->regex_replace('php_code__deps_x__define_stand_alone_plugin_dir_names', $_new_server_scanner_plugin_dirs, $_new_core_deps_x_file_contents);
									$_new_core_deps_x_file_contents = $this->regex_replace('php_code__deps_x__declare_stand_alone_class_name', '_stand_alone', $_new_core_deps_x_file_contents);

									if(!file_put_contents($_new_server_scanner_file, $_new_core_deps_x_file_contents))
										throw $this->©exception(
											__METHOD__.'#new_server_scanner_file_write_error', get_defined_vars(),
											$this->i18n('Unable to write the new plugin server scanner file.')
										);
									$this->©command->git('add --intent-to-add '.escapeshellarg($_new_server_scanner_file), dirname($this->plugin_dir));

									$successes->add(__METHOD__.'#plugin_extra_file_updates', get_defined_vars(),
									                $this->i18n('Plugin extra files updated with versions/requirements/etc.').
									                sprintf($this->i18n(' Extras version: `%1$s`.'), $this->version).
									                sprintf($this->i18n(' Extras require at least PHP version: `%1$s`.'), $this->requires_at_least_php_v).
									                sprintf($this->i18n(' Extras tested up to PHP version: `%1$s`.'), $this->tested_up_to_php_v).
									                sprintf($this->i18n(' Extras using WebSharks™ Core: `v%1$s`.'), $this->___instance_config->core_ns_v_with_dashes).
									                sprintf($this->i18n(' Extras require at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
									                sprintf($this->i18n(' Extras tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v).
									                sprintf($this->i18n(' New server scanner file: `%1$s`.'), $_new_server_scanner_file)
									);
									unset($_new_core_deps_x_file, $_new_server_scanner_file, $_old_server_scanner_file, $_new_server_scanner_plugin_dirs);
									unset($_new_core_deps_x_file_contents, $_replacements); // Housekeeping.

									// Copy distribution files into the distros directory.

									$_plugin_extras_distro_dir = $this->distros_dir.'/'.basename($this->plugin_extras_dir);

									if(is_dir($_plugin_extras_distro_dir) && !$this->©dir->empty_and_remove($_plugin_extras_distro_dir))
										throw $this->©exception(
											__METHOD__.'#existing_plugin_extras_distro_dir_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with existing plugin extras distro directory: `%1$s`.'), $_plugin_extras_distro_dir)
										);
									else if(!$this->©dir->copy_to($this->plugin_extras_dir, $_plugin_extras_distro_dir))
										throw $this->©exception(
											__METHOD__.'#plugin_extras_distro_dir_copy_failure', get_defined_vars(),
											sprintf($this->i18n('Unable to copy plugin extras dir into distro directory: `%1$s`.'), $_plugin_extras_distro_dir)
										);

									$successes->add(__METHOD__.'#plugin_extras_distro_files', get_defined_vars(),
									                sprintf($this->i18n('Plugin extras distro files copied to: `%1$s`.'), $_plugin_extras_distro_dir)
									);

									// Generate plugin extras distro directory checksum.

									$_plugin_extras_distro_dir_checksum = $this->©dir->checksum($_plugin_extras_distro_dir, TRUE);

									$successes->add(__METHOD__.'#plugin_extras_distro_dir_checksum', get_defined_vars(),
									                sprintf($this->i18n('Plugin extras distro directory checksum file updated to: `%1$s`.'), $_plugin_extras_distro_dir_checksum)
									);
									unset($_plugin_extras_distro_dir_checksum); // Housekeeping.

									// Create ZIP archives.

									$_plugin_extras_download_zip   = $this->downloads_dir.'/'.basename($this->plugin_extras_dir).'.zip';
									$_plugin_extras_download_v_zip = $this->downloads_dir.'/'.basename($this->plugin_extras_dir).'-v'.$this->version.'.zip';

									if(file_exists($_plugin_extras_download_zip) && (!is_writable($_plugin_extras_download_zip) || !unlink($_plugin_extras_download_zip)))
										throw $this->©exception(
											__METHOD__.'#existing_plugin_extras_download_zip_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with existing plugin extra downloads ZIP: `%1$s`.'), $_plugin_extras_download_zip)
										);
									else if(file_exists($_plugin_extras_download_v_zip) && (!is_writable($_plugin_extras_download_v_zip) || !unlink($_plugin_extras_download_v_zip)))
										throw $this->©exception(
											__METHOD__.'#existing_plugin_extras_download_v_zip_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with existing plugin extra downloads version ZIP: `%1$s`.'), $_plugin_extras_download_v_zip)
										);

									if(!$this->©dir->zip_to($_plugin_extras_distro_dir, $_plugin_extras_download_zip))
										throw $this->©exception(
											__METHOD__.'#plugin_extras_distro_dir_zip_failure', get_defined_vars(),
											sprintf($this->i18n('Unable to ZIP plugin extras distro dir into downloads directory: `%1$s`.'), $_plugin_extras_download_zip)
										);
									else if(!copy($_plugin_extras_download_zip, $_plugin_extras_download_v_zip))
										throw $this->©exception(
											__METHOD__.'#plugin_extras_download_v_zip_copy_failure', get_defined_vars(),
											sprintf($this->i18n('Unable to copy plugin extras ZIP into a version ZIP file: `%1$s`.'), $_plugin_extras_download_v_zip)
										);

									$successes->add(__METHOD__.'#plugin_extras_distro_zips', get_defined_vars(),
									                sprintf($this->i18n('Plugin extras distro zipped into: `%1$s`.'), $_plugin_extras_download_zip).
									                sprintf($this->i18n(' And copied into this version: `%1$s`.'), $_plugin_extras_download_v_zip)
									);
									unset($_plugin_extras_distro_dir, $_plugin_extras_download_zip, $_plugin_extras_download_v_zip);
								}
							// Remove new temporary core directory from the plugin development directory now.
							// This comes last because we MAY actually ship the full WebSharks™ Core with the main plugin.

							if(!$this->©dir->empty_and_remove($_new_core_dir))
								throw $this->©exception(
									__METHOD__.'#new_core_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues during removal of new temporary core directory: `%1$s`.'), $_new_core_dir)
								);

							if(!$this->use_core_phar) // If using a PHP Archive; the routines above will have already done this.
								// Need to add this check because GIT reports back with a non-zero status; files no longer in cache.
								$this->©command->git('rm -r --cached '.escapeshellarg($_new_core_dir.'/'), dirname($this->plugin_dir));

							$successes->add(__METHOD__.'#new_core_dir_deletion', get_defined_vars(),
							                sprintf($this->i18n(' The temporary WebSharks™ Core directory: `%1$s`; has been deleted from the plugin directory.'), $_new_core_dir).
							                sprintf($this->i18n(' The temporary WebSharks™ Core directory was also removed from the list of GIT-tracked files in this repo: `%1$s`.'), $this->plugin_dir)
							);
							unset($_new_core_dir); // Housekeeping.

							$successes->add(__METHOD__.'#plugin_build_complete', get_defined_vars(), $this->i18n('Plugin build complete!'));
						}

					// Building the WebSharks™ Core.

					else // We will either build a new WebSharks™ Core (or rebuild this one).
						{
							$is_new       = ($this->___instance_config->core_ns_v_with_dashes !== $this->version);
							$ucfirst_core = ($is_new) ? $this->i18n('New core') : $this->i18n('Core');
							$new_space    = ($is_new) ? $this->i18n('new').' ' : '';
							$new_slug     = ($is_new) ? 'new_' : '';

							// Validate core directory.

							if(!is_readable($this->core_dir))
								throw $this->©exception(
									__METHOD__.'#core_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with core directory: `%1$s`.'), $this->core_dir)
								);

							// Validate core `.gitignore` file.

							if(!file_exists(dirname($this->core_dir).'/.gitignore'))
								throw $this->©exception(
									__METHOD__.'#nonexistent_core_gitignore_file', get_defined_vars(),
									sprintf($this->i18n('Invalid core directory. Missing `.gitignore` file: `%1$s`.'), dirname($this->core_dir).'/.gitignore')
								);

							// WebSharks™ Core replication.

							if($is_new) // Replicate WebSharks™ Core into a new directory.
								{
									$_replication   = $this->©replicate('', FALSE, $this->version); // No exclusions.
									$_this_core_dir = $_replication->to_dir; // Need this below.

									$successes->add($_replication->success->get_code().'#'.$new_slug.'core_dir', $_replication->success->get_data(),
									                $_replication->success->get_message()
									);
									unset($_replication); // Housekeeping.
								}
							else $_this_core_dir = $this->core_dir; // Use existing core directory (no replication).

							// Update various core files w/ version numbers and other requirements.

							$_this_core_readme_file    = $_this_core_dir.'/readme.txt';
							$_this_core_framework_file = $_this_core_dir.'/classes/'.$this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->version.'/framework.php';
							$_this_core_deps_x_file    = $_this_core_dir.'/classes/'.$this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->version.'/deps-x.php';

							if(!file_exists($_this_core_readme_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_'.$new_slug.'core_readme_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent %1$score `readme.txt` file: `%2$s`.'), $new_space, $_this_core_readme_file)
								);
							else if(!is_readable($_this_core_readme_file) || !is_writable($_this_core_readme_file))
								throw $this->©exception(
									__METHOD__.'#'.$new_slug.'core_readme_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with %1$score `readme.txt` file: `%2$s`.'), $new_space, $_this_core_readme_file)
								);

							if(!file_exists($_this_core_framework_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_'.$new_slug.'core_framework_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent %1$score `framework.php` file: `%2$s`.'), $new_space, $_this_core_framework_file)
								);
							else if(!is_readable($_this_core_framework_file) || !is_writable($_this_core_framework_file))
								throw $this->©exception(
									__METHOD__.'#'.$new_slug.'core_framework_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with %1$score `framework.php` file: `%2$s`.'), $new_space, $_this_core_framework_file)
								);

							if(!file_exists($_this_core_deps_x_file))
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
							unset($_this_core_readme_file, $_this_core_framework_file, $_this_core_deps_x_file, $_replacements);
							unset($_this_core_readme_file_contents, $_this_core_framework_file_contents, $_this_core_deps_x_file_contents);

							/*
							 * Now: we MUST add this new core directory to version control; for THREE important reasons.
							 *
							 *    1. We may forget to do this by mistake; so let's go ahead and just do it now programmatically.
							 *
							 *    2. If we build a plugin (e.g. replicate into a plugin directory) later; and this directory were left untracked;
							 *       it would be excluded automatically (e.g. if we build a new core; and then immediately we build a plugin with this core).
							 *
							 *       To clarify this point further... Replicating this core into a plugin directory would result in an empty core directory;
							 *       because all of these files would be untracked; and thus excluded by `git ls-files --others --directory`.
							 *       See: {@link \websharks_core_v000000_dev\dirs\copy_to()} for further details on this.
							 *
							 *    3. Related to #2. If this core directory were left untracked; there would be no way for `git ls-files --others --directory`
							 *          to provide a future plugin build with the data it needs to properly identify which files inside this core directory
							 *          should be excluded. In fact, it would simply exclude them all; because they would all be untracked (see point #2).
							 *
							 *       To clarify THIS point further though... after this core directory is added to version control
							 *       we will expect to receive the following from `git ls-files --others --directory`.
							 *
							 *       `websharks-core-v000000-dev/._dev-utilities/`
							 *       `websharks-core-v[version]/._dev-utilities/`
							 *
							 *       ...and so on, for any exclusions that occur as a result of `.gitignore`.
							 *       If the new directory were untracked; we would NOT have this critical information.
							 *
							 *    NOTE: We use `git add --intent-to-add <pattern>`.
							 *       Records only the fact that the path will be added later.
							 *       An entry for the path is placed in the index with no content.
							 *    See: {@link http://git-scm.com/docs/git-add}
							 */
							$this->©command->git('add --intent-to-add '.escapeshellarg($_this_core_dir.'/'), dirname($this->core_dir));

							$successes->add(__METHOD__.'#git_add_'.$new_slug.'core_dir', get_defined_vars(),
							                sprintf($this->i18n('%1$s directory added to version control: `%2$s`.'), $ucfirst_core, $_this_core_dir)
							);

							// Compress the new core directory into a single PHP Archive.

							$_this_core_phar_stub                  = dirname($this->core_dir).'/'.$this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->version.'.phar';
							$_this_core_distro_temp_dir            = $this->©dir->get_sys_temp_dir().'/'.basename($_this_core_dir);
							$_this_core_distro_temp_dir_stub       = $_this_core_distro_temp_dir.'/stub.php';
							$_this_core_distro_temp_dir_htaccess   = $_this_core_distro_temp_dir.'/.htaccess';
							$_this_core_phar_stub_php              = $_this_core_phar_stub.'.php';
							$_this_old_core_phar_stub_glob_pattern = $_this_core_phar_stub.'*';

							if(!$this->©dir->copy_to($_this_core_dir, $_this_core_distro_temp_dir, array('.gitignore' => dirname($this->core_dir).'/.gitignore')))
								throw $this->©exception(
									__METHOD__.'#'.$new_slug.'core_copy_to_distro_temp_dir_failure', get_defined_vars(),
									sprintf($this->i18n('Unable to create a temporary distro directory for the %1$score: `%2$s`.'), $new_space, $_this_core_distro_temp_dir)
								);
							else if(!file_exists($_this_core_distro_temp_dir_htaccess)
							        || !is_readable($_this_core_distro_temp_dir_htaccess)
							        || FALSE === strpos(file_get_contents($_this_core_distro_temp_dir_htaccess), 'AcceptPathInfo')
							) throw $this->©exception(
									__METHOD__.'#unable_to_find_valid_htaccess_file_in_'.$new_slug.'core_distro_temp_dir', get_defined_vars(),
									sprintf($this->i18n('Unable to find a valid `.htaccess` file here: `%1$s`.'), $_this_core_distro_temp_dir_htaccess).
									$this->i18n(' This file MUST exist; and it MUST contain: `AcceptPathInfo` for webPhar compatibility.')
								);
							else if(!is_integer($this->©file->unlink_glob($_this_old_core_phar_stub_glob_pattern)))
								throw $this->©exception(
									__METHOD__.'#unable_to_delete_old_core_phar_stub_glob_pattern', get_defined_vars(),
									sprintf($this->i18n('Unable to delete old core PHAR stub glob pattern: `%1$s`.'), $_this_old_core_phar_stub_glob_pattern)
								);
							else if($this->©dir->phar_to($_this_core_distro_temp_dir, $_this_core_phar_stub, $_this_core_distro_temp_dir_stub) !== $_this_core_phar_stub_php)
								throw $this->©exception(
									__METHOD__.'#unable_to_phar_'.$new_slug.'core_distro_temp_dir_into_'.$new_slug.'core_phar_stub_php', get_defined_vars(),
									sprintf($this->i18n('Unable to PHAR %1$stemporary core distro into: `%2$s`.'), $new_space, $_this_core_phar_stub_php)
								);
							else if(!$this->©dir->empty_and_remove($_this_core_distro_temp_dir))
								throw $this->©exception(
									__METHOD__.'#unable_to_delete_'.$new_slug.'core_distro_temp_dir', get_defined_vars(),
									sprintf($this->i18n('Unable delete %1$stemporary core distro directory: `%2$s`.'), $new_space, $_this_core_distro_temp_dir)
								);
							$this->©command->git('add --intent-to-add '.escapeshellarg($_this_core_phar_stub_php), dirname($this->core_dir));

							$successes->add(__METHOD__.'#'.$new_slug.'core_phar_stub_php_built_for_'.$new_slug.'core_distro_temp_dir', get_defined_vars(),
							                sprintf($this->i18n('A temporary distro copy of the WebSharks™ Core has been compressed into a single PHP Archive file here: `%1$s`.'), $_this_core_phar_stub_php).
							                $this->i18n(' This file has been added to the list of GIT-tracked files in the WebSharks™ Core repo.').
							                $this->i18n(' The temporary distro copy of the WebSharks™ Core was deleted after processing.')
							);
							unset($_this_core_phar_stub, $_this_core_phar_stub_php, $_this_old_core_phar_stub_glob_pattern);
							unset($_this_core_distro_temp_dir, $_this_core_distro_temp_dir_stub, $_this_core_distro_temp_dir_htaccess);

							// Directory junction updates for project development (e.g. for plugins).

							if($this->update_core_jctn) // Update core directory junction?
								{
									$_core_jctn = dirname($this->core_dir).'/'.$this->___instance_config->core_ns_stub_with_dashes;

									$this->©dir->create_win_jctn($_core_jctn, $_this_core_dir);

									$successes->add(__METHOD__.'#updated_core_dir_junction', get_defined_vars(),
									                sprintf($this->i18n('Updating `%1$s` directory junction to: `%2$s`.'), $_core_jctn, $_this_core_dir)
									);
									unset($_core_jctn); // Housekeeping.
								}
							unset($_this_core_dir); // Some final housekeeping.

							$successes->add(__METHOD__.'#'.$new_slug.'core_build_complete', get_defined_vars(),
							                sprintf($this->i18n('%1$s %2$s complete!'), $ucfirst_core, (($is_new) ? $this->i18n('build') : $this->i18n('rebuild')))
							);
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