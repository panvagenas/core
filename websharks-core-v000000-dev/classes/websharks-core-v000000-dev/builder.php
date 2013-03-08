<?php
/**
 * WebSharks™ Core Plugin Builder.
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
		 * WebSharks™ Core Plugin Builder.
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
			 * @var string Tested up to WordPress® version.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $tested_up_to_wp_v = '3.6-alpha';

			/**
			 * @var string Requires at least WordPress® version.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $requires_at_least_wp_v = '3.5.1';

			/**
			 * @var string Requires at least PHP version.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $requires_at_least_php_v = '5.3.1';

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
			 * @param string              $tested_up_to_wp_v Optional. Defaults to the newest version tested by the WebSharks™ Core.
			 *    All of these MUST be valid. See: {@link \websharks_core_v000000_dev\strings\regex_valid_version}
			 * @param string              $requires_at_least_wp_v Optional. Defaults to the oldest version tested by the WebSharks™ Core.
			 * @param string              $requires_at_least_php_v Optional. Defaults to the oldest version tested by the WebSharks™ Core.
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
			 * @note Instantiation of this class will initiate the build routine (so please be VERY careful).
			 *    Property ``$successes`` will contain messages indicating the final result status of the build procedure.
			 *    If there is a failure an exception is thrown by this class. We either succeed completely; or throw an exception.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If unable to build, according to ``$this->can_build``.
			 * @throws exception See: ``build()`` method for further details.
			 */
			public function __construct($___instance_config, $plugin_dir = '', $plugin_name = '', $plugin_ns = '', $distros_dir = '', $downloads_dir = '', $version = '', $tested_up_to_wp_v = '', $requires_at_least_wp_v = '', $requires_at_least_php_v = '', $use_core_phar = NULL, $update_core_jctn = NULL)
				{
					parent::__construct($___instance_config);

					// Check arguments expected by this constructor.

					$this->check_arg_types('', 'string', 'string', 'string', 'string', 'string', array('integer', 'string'), 'string', 'string', 'string', array('null', 'string', 'boolean'), array('null', 'string', 'boolean'), func_get_args());

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
							$this->tested_up_to_wp_v       = ($tested_up_to_wp_v) ? $tested_up_to_wp_v : $this->tested_up_to_wp_v;
							$this->requires_at_least_wp_v  = ($requires_at_least_wp_v) ? $requires_at_least_wp_v : $this->requires_at_least_wp_v;
							$this->requires_at_least_php_v = ($requires_at_least_php_v) ? $requires_at_least_php_v : $this->requires_at_least_php_v;

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
							else if(!preg_match($this->©string->regex_valid_version, $this->tested_up_to_wp_v))
								throw $this->©exception(
									__METHOD__.'#invalid_tested_up_to_wp_v', get_defined_vars(),
									sprintf($this->i18n('Invalid `Tested up to` version string: `%1$s`.'), $this->tested_up_to_wp_v)
								);
							else if(!preg_match($this->©string->regex_valid_version, $this->requires_at_least_wp_v))
								throw $this->©exception(
									__METHOD__.'#invalid_requires_at_least_wp_v', get_defined_vars(),
									sprintf($this->i18n('Invalid `Requires at least` version string: `%1$s`.'), $this->requires_at_least_wp_v)
								);
							else if(!preg_match($this->©string->regex_valid_version, $this->requires_at_least_php_v))
								throw $this->©exception(
									__METHOD__.'#invalid_requires_at_least_php_v', get_defined_vars(),
									sprintf($this->i18n('Invalid `Requires at least` PHP version string: `%1$s`.'), $this->requires_at_least_php_v)
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
							// Validate plugin pro directory.

							if(!is_readable($this->plugin_dir) || !is_writable($this->plugin_dir))
								throw $this->©exception(
									__METHOD__.'#plugin_dir_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with plugin directory: `%1$s`.'), $this->plugin_dir)
								);

							// Validate core `.gitignore` file.

							if(!file_exists(dirname($this->core_dir).'/.gitignore'))
								throw $this->©exception(
									__METHOD__.'#nonexistent_core_gitignore_file', get_defined_vars(),
									sprintf($this->i18n('Invalid core directory. Missing `.gitignore` file: `%1$s`.'), dirname($this->core_dir).'/.gitignore')
								);

							// WebSharks™ Core replication.

							$_replication  = $this->©replicate($this->plugin_dir, TRUE, 0,
							                                   array('.gitignore' => dirname($this->core_dir).'/.gitignore'));
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
							                sprintf($this->i18n(' Every file in the entire plugin directory has now been updated to use version `%1$s` of the WebSharks™ Core.'), $this->___instance_config->core_ns_v_with_dashes)
							);

							// Copy WebSharks™ Core stub into the main plugin directory.

							if(!file_exists($_new_core_dir.'/stub.php'))
								throw $this->©exception(
									__METHOD__.'#unable_to_find_stub_in_new_core_dir', get_defined_vars(),
									sprintf($this->i18n('Unable to find a `stub.php` file here: `%1$s`.'), $_new_core_dir.'/stub.php')
								);
							else if(file_exists($this->plugin_dir.'/websharks-core.php') && (!is_writable($this->plugin_dir.'/websharks-core.php') || !unlink($this->plugin_dir.'/websharks-core.php')))
								throw $this->©exception(
									__METHOD__.'#unable_to_delete_existing_core_stub_in_plugin_dir', get_defined_vars(),
									sprintf($this->i18n('Unable to delete existing `websharks-core.php` file: `%1$s`.'), $this->plugin_dir.'/websharks-core.php')
								);
							else if(!copy($_new_core_dir.'/stub.php', $this->plugin_dir.'/websharks-core.php'))
								throw $this->©exception(
									__METHOD__.'#unable_to_copy_new_core_stub_into_plugin_dir', get_defined_vars(),
									sprintf($this->i18n('Unable to copy `stub.php` stub into: `%1$s`.'), $this->plugin_dir.'/websharks-core.php')
								);
							$this->©command->git('add --intent-to-add '.escapeshellarg($this->plugin_dir.'/websharks-core.php'), dirname($this->plugin_dir));

							$successes->add(__METHOD__.'#new_core_stub_copied_into_plugin_dir', get_defined_vars(),
							                sprintf($this->i18n('The WebSharks™ Core stub has been added to the plugin directory: `%1$s`.'), $this->plugin_dir.'/websharks-core.php').
							                $this->i18n(' This file has also been added to the list of GIT-tracked files in this repo.')
							);

							// Bundle the WebSharks™ Core PHP Archive stub; instead of the full directory?

							if($this->use_core_phar) // Optional (this is only applicable to plugins).
								{
									if(!file_exists($this->core_dir.'/core.phar.php'))
										throw $this->©exception(
											__METHOD__.'#unable_to_find_core_phar_stub_in_this_core_dir', get_defined_vars(),
											sprintf($this->i18n('Unable to find a `core.phar.php` file here: `%1$s`.'), $this->core_dir.'/core.phar.php')
										);
									else if(!file_exists($this->plugin_dir.'/.htaccess') || !is_readable($this->plugin_dir.'/.htaccess') || strpos(file_get_contents($this->plugin_dir.'/.htaccess'), 'AcceptPathInfo') === FALSE)
										throw $this->©exception(
											__METHOD__.'#unable_to_find_htaccess_file_in_plugin_dir', get_defined_vars(),
											sprintf($this->i18n('Unable to find a valid `.htaccess` file here: `%1$s`.'), $this->plugin_dir.'/.htaccess').
											$this->i18n(' This file MUST exist; and it MUST contain: `AcceptPathInfo` for webPhar compatibility.')
										);
									else if(file_exists($this->plugin_dir.'/websharks-core.php') && (!is_writable($this->plugin_dir.'/websharks-core.php') || !unlink($this->plugin_dir.'/websharks-core.php')))
										throw $this->©exception(
											__METHOD__.'#unable_to_delete_existing_core_stub_in_plugin_dir', get_defined_vars(),
											sprintf($this->i18n('Unable to delete existing `websharks-core.php` stub: `%1$s`.'), $this->plugin_dir.'/websharks-core.php')
										);
									else if(!copy($this->core_dir.'/core.phar.php', $this->plugin_dir.'/websharks-core.php'))
										throw $this->©exception(
											__METHOD__.'#unable_to_copy_this_core_phar_stub_into_plugin_dir', get_defined_vars(),
											sprintf($this->i18n('Unable to copy `%1$s` into `%2$s`.'), $this->core_dir.'/core.phar.php', $this->plugin_dir.'/websharks-core.php')
										);
									$this->©command->git('rm -r --cached '.escapeshellarg($_new_core_dir.'/'), dirname($this->plugin_dir));

									$successes->add(__METHOD__.'#this_core_phar_stub_copied_into_plugin_dir', get_defined_vars(),
									                sprintf($this->i18n('The WebSharks™ Core PHAR stub for v%1$s; has been copied to: `%2$s`.'), $this->___instance_config->core_ns_v_with_dashes, $this->plugin_dir.'/websharks-core.php').
									                $this->i18n(' This file (now a compressed PHP Archive); has been added (again) to the list of GIT-tracked files in this repo.').
									                sprintf($this->i18n(' The original full WebSharks™ Core directory has now been removed from the list of GIT-tracked files in this repo: `%1$s`.'), $_new_core_dir).
									                $this->i18n(' This ensures it will NOT be copied over into the final distro for this plugin. This PHP Archive file will suffice; just one file :-)')
									);
								}

							// Update various plugin files w/ version numbers and other requirements.

							$_plugin_file           = $this->plugin_dir.'/'.basename($this->plugin_dir).'.php';
							$_plugin_framework_file = $this->plugin_dir.'/classes/'.str_replace('_', '-', $this->plugin_ns).'/framework.php';
							$_plugin_readme_file    = $this->plugin_dir.'/readme.txt';

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

							$_plugin_file_contents           = file_get_contents($_plugin_file);
							$_plugin_framework_file_contents = file_get_contents($_plugin_framework_file);
							$_plugin_readme_file_contents    = file_get_contents($_plugin_readme_file);

							if(!($_plugin_file_contents = preg_replace('/^((?:Version|Stable tag)\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->version), $_plugin_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#plugin_file_version_replacements', get_defined_vars(),
									$this->i18n('Build failure. Unable to replace `Version|Stable tag` in plugin file.')
								);
							else if(!($_plugin_framework_file_contents = preg_replace('/(\')([0-9a-z\.\-]+)(\'\s*[;,]?\s*\/\/\s*\!#version#\!)/i', '${1}'.$this->©string->esc_refs($this->version).'${3}', $_plugin_framework_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#plugin_framework_file_version_replacements', get_defined_vars(),
									$this->i18n('Build failure. Unable to replace `!#version#!` in plugin `framework.php` file.')
								);
							else if(!($_plugin_readme_file_contents = preg_replace('/^((?:Version|Stable tag)\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->version), $_plugin_readme_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#plugin_readme_file_version_replacements', get_defined_vars(),
									$this->i18n('Build failure. Unable to replace `Version|Stable tag` in plugin `readme.txt` file.')
								);

							if(!($_plugin_file_contents = preg_replace('/^(Tested up to\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->tested_up_to_wp_v), $_plugin_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#plugin_file_tested_up_to_wp_v_replacements', get_defined_vars(),
									$this->i18n('Build failure. Unable to replace `Tested up to` version in plugin file.')
								);
							else if(!($_plugin_readme_file_contents = preg_replace('/^(Tested up to\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->tested_up_to_wp_v), $_plugin_readme_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#plugin_readme_file_tested_up_to_wp_v_replacements', get_defined_vars(),
									$this->i18n('Build failure. Unable to replace `Tested up to` version in plugin `readme.txt` file.')
								);

							if(!($_plugin_file_contents = preg_replace('/^(Requires at least\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->requires_at_least_wp_v), $_plugin_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#plugin_file_requires_at_least_wp_v_replacements', get_defined_vars(),
									$this->i18n('Build failure. Unable to replace `Requires at least` version in plugin file.')
								);
							else if(!($_plugin_readme_file_contents = preg_replace('/^(Requires at least\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->requires_at_least_wp_v), $_plugin_readme_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#plugin_readme_file_requires_at_least_wp_v_replacements', get_defined_vars(),
									$this->i18n('Build failure. Unable to replace `Requires at least` version in plugin `readme.txt` file.')
								);

							if(!file_put_contents($_plugin_file, $_plugin_file_contents))
								throw $this->©exception(
									__METHOD__.'#plugin_file_write_error', get_defined_vars(),
									$this->i18n('Build failure. Unable to write (update) the plugin file.')
								);
							else if(!file_put_contents($_plugin_framework_file, $_plugin_framework_file_contents))
								throw $this->©exception(
									__METHOD__.'#plugin_framework_file_write_error', get_defined_vars(),
									$this->i18n('Build failure. Unable to write (update) the plugin `framework.php` file.')
								);
							else if(!file_put_contents($_plugin_readme_file, $_plugin_readme_file_contents))
								throw $this->©exception(
									__METHOD__.'#plugin_readme_file_write_error', get_defined_vars(),
									$this->i18n('Build failure. Unable to write (update) the plugin `readme.txt` file.')
								);

							$successes->add(__METHOD__.'#plugin_file_updates', get_defined_vars(),
							                $this->i18n('Plugin files updated with versions/requirements.').
							                sprintf($this->i18n(' Plugin version: `%1$s`.'), $this->version).
							                sprintf($this->i18n(' Plugin tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v).
							                sprintf($this->i18n(' Plugin requires at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
							                sprintf($this->i18n(' Plugin requires at least PHP version: `%1$s`.'), $this->requires_at_least_php_v).
							                sprintf($this->i18n(' Depends on WebSharks™ Core version: `%1$s`.'), $this->___instance_config->core_ns_v_with_dashes)
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

									$_replication      = $this->©replicate($this->plugin_pro_dir, TRUE, 0,
									                                       array('.gitignore' => dirname($this->core_dir).'/.gitignore'));
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
									$_plugin_pro_class_file  = $this->plugin_pro_dir.'/classes/'.str_replace('_', '-', $this->plugin_ns).'/pro.php';
									$_plugin_pro_readme_file = $this->plugin_pro_dir.'/readme.txt';

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

									$_plugin_pro_file_contents        = file_get_contents($_plugin_pro_file);
									$_plugin_pro_class_file_contents  = file_get_contents($_plugin_pro_class_file);
									$_plugin_pro_readme_file_contents = file_get_contents($_plugin_pro_readme_file);

									if(!($_plugin_pro_file_contents = preg_replace('/^((?:Version|Stable tag)\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->version), $_plugin_pro_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#plugin_pro_file_version_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to replace `Version|Stable tag` in plugin pro file.')
										);
									else if(!($_plugin_pro_class_file_contents = preg_replace('/(\')([0-9a-z\.\-]+)(\'\s*[;,]?\s*\/\/\s*\!#version#\!)/i', '${1}'.$this->©string->esc_refs($this->version).'${3}', $_plugin_pro_class_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#plugin_pro_class_file_version_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to replace `!#version#!` in plugin `pro.php` class file.')
										);
									else if(!($_plugin_pro_readme_file_contents = preg_replace('/^((?:Version|Stable tag)\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->version), $_plugin_pro_readme_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#plugin_pro_readme_file_version_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to replace `Version|Stable tag` in plugin pro `readme.txt` file.')
										);

									if(!($_plugin_pro_file_contents = preg_replace('/^(Tested up to\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->tested_up_to_wp_v), $_plugin_pro_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#plugin_pro_file_tested_up_to_wp_v_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to replace `Tested up to` version in plugin pro file.')
										);
									else if(!($_plugin_pro_readme_file_contents = preg_replace('/^(Tested up to\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->tested_up_to_wp_v), $_plugin_pro_readme_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#plugin_pro_readme_file_tested_up_to_wp_v_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to replace `Tested up to` version in plugin pro `readme.txt` file.')
										);

									if(!($_plugin_pro_file_contents = preg_replace('/^(Requires at least\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->requires_at_least_wp_v), $_plugin_pro_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#plugin_pro_file_requires_at_least_wp_v_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to replace `Requires at least` version in plugin pro file.')
										);
									else if(!($_plugin_pro_readme_file_contents = preg_replace('/^(Requires at least\: )[0-9a-z\.\-]+$/im', '${1}'.$this->©string->esc_refs($this->requires_at_least_wp_v), $_plugin_pro_readme_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#plugin_pro_readme_file_requires_at_least_wp_v_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to replace `Requires at least` version in plugin pro `readme.txt` file.')
										);

									if(!file_put_contents($_plugin_pro_file, $_plugin_pro_file_contents))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_file_write_error', get_defined_vars(),
											$this->i18n('Build failure. Unable to write (update) the plugin pro file.')
										);
									else if(!file_put_contents($_plugin_pro_class_file, $_plugin_pro_class_file_contents))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_class_file_write_error', get_defined_vars(),
											$this->i18n('Build failure. Unable to write (update) the plugin `pro.php` class file.')
										);
									else if(!file_put_contents($_plugin_pro_readme_file, $_plugin_pro_readme_file_contents))
										throw $this->©exception(
											__METHOD__.'#plugin_pro_readme_file_write_error', get_defined_vars(),
											$this->i18n('Build failure. Unable to write (update) the plugin pro `readme.txt` file.')
										);

									$successes->add(__METHOD__.'#plugin_pro_file_updates', get_defined_vars(),
									                $this->i18n('Plugin pro files updated with versions/requirements.').
									                sprintf($this->i18n(' Plugin pro version: `%1$s`.'), $this->version).
									                sprintf($this->i18n(' Pro add-on tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v).
									                sprintf($this->i18n(' Pro add-on requires at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
									                sprintf($this->i18n(' Pro add-on requires at least PHP version: `%1$s`.'), $this->requires_at_least_php_v).
									                sprintf($this->i18n(' Depends on WebSharks™ Core version: `%1$s`.'), $this->___instance_config->core_ns_v_with_dashes)
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

									$_replication         = $this->©replicate($this->plugin_extras_dir, TRUE, 0,
									                                          array('.gitignore' => dirname($this->core_dir).'/.gitignore'));
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

									$_new_core_deps_x_file         = $_new_core_dir.'/classes/'.basename($_new_core_dir).'/deps-x.php';
									$_plugin_server_scanner_file   = $this->plugin_extras_dir.'/'.basename($this->plugin_dir).'-server-scanner.php';
									$_plugin_dirs_commas_delimited = basename($this->plugin_dir).(($this->plugin_pro_dir) ? ','.basename($this->plugin_pro_dir) : '');

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

									if(file_exists($_plugin_server_scanner_file) && (!is_writable($_plugin_server_scanner_file) || !unlink($_plugin_server_scanner_file)))
										throw $this->©exception(
											__METHOD__.'#existing_plugin_server_scanner_file_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with existing plugin server scanner file: `%1$s`.'), $_plugin_server_scanner_file)
										);

									$_new_core_deps_x_file_contents = file_get_contents($_new_core_deps_x_file);

									if(!($_new_core_deps_x_file_contents = preg_replace('/(define\s*\(\s*\'___STAND_ALONE__PLUGIN_NAME\'\s*,\s*\')(.*?)(\')/i', '${1}'.$this->©string->esc_refs($this->©string->esc_sq($this->plugin_name)).'${3}', $_new_core_deps_x_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#new_core_deps_x_file_plugin_name_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to set `___STAND_ALONE__PLUGIN_NAME` in new core `deps-x.php` file.')
										);
									else if(!($_new_core_deps_x_file_contents = preg_replace('/(define\s*\(\s*\'___STAND_ALONE__PLUGIN_DIR_NAMES\'\s*,\s*\')([0-9a-z\-]*)(\')/i', '${1}'.$this->©string->esc_refs($this->©string->esc_sq($_plugin_dirs_commas_delimited)).'${3}', $_new_core_deps_x_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#new_core_deps_x_file_plugin_dir_names_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to set `___STAND_ALONE__PLUGIN_DIR_NAMES` in new core `deps-x.php` file.')
										);
									else if(!($_new_core_deps_x_file_contents = preg_replace('/(class\s+deps_x)(_'.ltrim(rtrim($this->©string->regex_valid_ws_core_ns_version, '$/'), '/^').')/i', '${1}'.'_stand_alone'.'${2}', $_new_core_deps_x_file_contents, -1, $_replacements)) || !$_replacements)
										throw $this->©exception(
											__METHOD__.'#new_core_deps_x_file_stand_alone_replacements', get_defined_vars(),
											$this->i18n('Build failure. Unable to set `_stand_alone` in new core `deps-x.php` file.')
										);

									if(!file_put_contents($_plugin_server_scanner_file, $_new_core_deps_x_file_contents))
										throw $this->©exception(
											__METHOD__.'#plugin_server_scanner_file_write_error', get_defined_vars(),
											$this->i18n('Build failure. Unable to write the plugin server scanner file.')
										);

									$this->©command->git('add --intent-to-add '.escapeshellarg($_plugin_server_scanner_file), dirname($this->plugin_dir));

									$successes->add(__METHOD__.'#plugin_extra_file_updates', get_defined_vars(),
									                $this->i18n('Plugin extra files updated with versions/requirements/etc.').
									                sprintf($this->i18n(' Extras version: `%1$s`.'), $this->version).
									                sprintf($this->i18n(' Extras tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v).
									                sprintf($this->i18n(' Extras require at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
									                sprintf($this->i18n(' Extras require at least PHP version: `%1$s`.'), $this->requires_at_least_php_v).
									                sprintf($this->i18n(' They depend on WebSharks™ Core version: `%1$s`.'), $this->___instance_config->core_ns_v_with_dashes).
									                sprintf($this->i18n(' Plugin server scanner file: `%1$s`.'), $_plugin_server_scanner_file)
									);
									unset($_new_core_deps_x_file, $_plugin_server_scanner_file, $_plugin_dirs_commas_delimited);
									unset($_new_core_deps_x_file_contents, $_replacements); // Housekeeping.

									// Copy distribution files into the distros directory.

									$_plugin_extras_distro_dir = $this->distros_dir.'/'.basename($this->plugin_extras_dir);

									if(is_dir($_plugin_extras_distro_dir) && !$this->©dir->empty_and_remove($_plugin_extras_distro_dir))
										throw $this->©exception(
											__METHOD__.'#existing_plugin_extras_distro_dir_permissions', get_defined_vars(),
											sprintf($this->i18n('Permission issues with existing plugin extras distro directory: `%1$s`.'), $_plugin_extras_distro_dir)
										);

									if(!$this->©dir->copy_to($this->plugin_extras_dir, $_plugin_extras_distro_dir))
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
					else // Building the WebSharks™ Core itself in this case.
						{
							// Validate core directory.

							if(!is_readable($this->core_dir) || !is_writable($this->core_dir))
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

							$_replication  = $this->©replicate('', FALSE, $this->version);
							$_new_core_dir = $_replication->to_dir; // Need this below.

							$successes->add($_replication->success->get_code().'#core_dir', $_replication->success->get_data(),
							                $_replication->success->get_message()
							);
							unset($_replication); // Housekeeping.

							// Update various core files w/ version numbers and other requirements.

							$_new_core_framework_file = $_new_core_dir.'/classes/'.basename($_new_core_dir).'/framework.php';
							$_new_core_deps_x_file    = $_new_core_dir.'/classes/'.basename($_new_core_dir).'/deps-x.php';

							if(!file_exists($_new_core_framework_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_new_core_framework_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent new core `framework.php` file: `%1$s`.'), $_new_core_framework_file)
								);
							else if(!is_readable($_new_core_framework_file) || !is_writable($_new_core_framework_file))
								throw $this->©exception(
									__METHOD__.'#new_core_framework_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with new core `framework.php` file: `%1$s`.'), $_new_core_framework_file)
								);

							if(!file_exists($_new_core_deps_x_file))
								throw $this->©exception(
									__METHOD__.'#nonexistent_new_core_deps_x_file', get_defined_vars(),
									sprintf($this->i18n('Nonexistent new core `deps-x.php` file: `%1$s`.'), $_new_core_deps_x_file)
								);
							else if(!is_readable($_new_core_deps_x_file) || !is_writable($_new_core_deps_x_file))
								throw $this->©exception(
									__METHOD__.'#new_core_deps_x_file_permissions', get_defined_vars(),
									sprintf($this->i18n('Permission issues with new core `deps-x.php` file: `%1$s`.'), $_new_core_deps_x_file)
								);

							$_new_core_framework_file_contents = file_get_contents($_new_core_framework_file);
							$_new_core_deps_x_file_contents    = file_get_contents($_new_core_deps_x_file);

							if(!($_new_core_framework_file_contents = preg_replace('/(\')([0-9a-z\.\-]+)(\'\s*[;,]?\s*\/\/\s*\!#version#\!)/i', '${1}'.$this->©string->esc_refs($this->version).'${3}', $_new_core_framework_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#new_core_framework_file_version_replacements', get_defined_vars(),
									$this->i18n('Unable to replace `!#version#!` in new core `framework.php` file.')
								);

							if(!($_new_core_deps_x_file_contents = preg_replace('/(\')([0-9a-z\.\-]+)(\'\s*[;,]?\s*\/\/\s*\!#requires-php-version#\!)/i', '${1}'.$this->©string->esc_refs($this->requires_at_least_php_v).'${3}', $_new_core_deps_x_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#new_core_deps_x_file_requires_at_least_php_v_replacements', get_defined_vars(),
									$this->i18n('Unable to replace `!#requires-php-version#!` in new core `deps-x.php` file.')
								);

							if(!($_new_core_deps_x_file_contents = preg_replace('/(\')([0-9a-z\.\-]+)(\'\s*[;,]?\s*\/\/\s*\!#requires-wp-version#\!)/i', '${1}'.$this->©string->esc_refs($this->requires_at_least_wp_v).'${3}', $_new_core_deps_x_file_contents, -1, $_replacements)) || !$_replacements)
								throw $this->©exception(
									__METHOD__.'#new_core_deps_x_file_requires_at_least_wp_v_replacements', get_defined_vars(),
									$this->i18n('Unable to replace `!#requires-wp-version#!` in new core `deps-x.php` file.')
								);

							if(!file_put_contents($_new_core_framework_file, $_new_core_framework_file_contents))
								throw $this->©exception(
									__METHOD__.'#new_core_framework_file_write_error', get_defined_vars(),
									$this->i18n('Unable to write (update) the new core `framework.php` file.')
								);
							else if(!file_put_contents($_new_core_deps_x_file, $_new_core_deps_x_file_contents))
								throw $this->©exception(
									__METHOD__.'#new_core_deps_x_file_write_error', get_defined_vars(),
									$this->i18n('Unable to write (update) the new core `deps-x.php` file.')
								);

							$successes->add(__METHOD__.'#new_core_file_updates', get_defined_vars(),
							                $this->i18n('New core files updated with versions/requirements.').
							                sprintf($this->i18n(' New core version: `%1$s`.'), $this->version).
							                sprintf($this->i18n(' New core directory: `%1$s`.'), $_new_core_dir).
							                sprintf($this->i18n(' New core tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_v).
							                sprintf($this->i18n(' New core requires at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_v).
							                sprintf($this->i18n(' New core requires at least PHP version: `%1$s`.'), $this->requires_at_least_php_v)
							);
							unset($_new_core_framework_file, $_new_core_deps_x_file, $_replacements);
							unset($_new_core_framework_file_contents, $_new_core_deps_x_file_contents);

							/*
							 * Now: we MUST add this new core directory to version control; for THREE important reasons.
							 *
							 *    1. We may forget to do this by mistake; so let's go ahead and just do it now programmatically.
							 *
							 *    2. If we build a plugin (e.g. replicate into a plugin directory) later; and this directory were left untracked;
							 *       it would be excluded automatically (e.g. if we build a new core; and then immediately we build a plugin with this core).
							 *
							 *       To clarify this point further... Replicating this new core into a plugin directory would result in an empty core directory;
							 *       because all of these files would be untracked; and thus excluded by `git ls-files --others --directory`.
							 *       See: {@link \websharks_core_v000000_dev\dirs\copy_to()} for further details on this.
							 *
							 *    3. Related to #2. If this new core directory were left untracked; there would be no way for `git ls-files --others --directory`
							 *          to provide a future plugin build with the data it needs to properly identify which files inside this new core directory
							 *          should be excluded. In fact, it would simply exclude them all; because they would all be untracked (see point #2).
							 *
							 *       To clarify THIS point further though... after this new core directory is added to version control
							 *       we will expect to receive the following from `git ls-files --others --directory`.
							 *
							 *       `websharks-core-v000000-dev/._dev-utilities/`
							 *       `websharks-core-v[new version]/._dev-utilities/`
							 *
							 *       ...and so on, for any exclusions that occur as a result of `.gitignore`.
							 *       If the new directory were untracked; we would NOT have this critical information.
							 *
							 *    NOTE: We use `git add --intent-to-add <pattern>`.
							 *       Records only the fact that the path will be added later.
							 *       An entry for the path is placed in the index with no content.
							 *    See: {@link http://git-scm.com/docs/git-add}
							 */
							$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_dir.'/'), dirname($this->core_dir));

							$successes->add(__METHOD__.'#git_add_new_core_dir', get_defined_vars(),
							                sprintf($this->i18n('New core directory added to version control: `%1$s`.'), $_new_core_dir)
							);

							// Compress the new core directory into a single PHP Archive.

							$_new_core_distro_temp_dir = $this->©dir->get_sys_temp_dir().'/'.basename($_new_core_dir);

							if(file_exists($_new_core_dir.'/core.phar'))
								throw $this->©exception(
									__METHOD__.'#new_core_dir_already_contains_phar', get_defined_vars(),
									sprintf($this->i18n('Mishap ~ the new core directory already contains: `%1$s`.'), $_new_core_dir.'/core.phar').
									$this->i18n(' This is unexpected. We\'ve NOT built this file yet. It must have slipped through replication somehow.')
								);
							else if(file_exists($_new_core_dir.'/core.phar.php'))
								throw $this->©exception(
									__METHOD__.'#new_core_dir_already_contains_phar_stub', get_defined_vars(),
									sprintf($this->i18n('Mishap ~ the new core directory already contains: `%1$s`.'), $_new_core_dir.'/core.phar.php').
									$this->i18n(' This is unexpected. We\'ve NOT built this file yet. It must have slipped through replication somehow.')
								);
							else if(!file_exists($_new_core_dir.'/.htaccess') || !is_readable($_new_core_dir.'/.htaccess') || strpos(file_get_contents($_new_core_dir.'/.htaccess'), 'AcceptPathInfo') === FALSE)
								throw $this->©exception(
									__METHOD__.'#unable_to_find_htaccess_file_in_new_core_dir', get_defined_vars(),
									sprintf($this->i18n('Unable to find a valid `.htaccess` file here: `%1$s`.'), $_new_core_dir.'/.htaccess').
									$this->i18n(' This file MUST exist; and it MUST contain: `AcceptPathInfo` for webPhar compatibility.')
								);
							else if(!$this->©dir->copy_to($_new_core_dir, $_new_core_distro_temp_dir, array('.gitignore' => dirname($this->core_dir).'/.gitignore')))
								throw $this->©exception(
									__METHOD__.'#new_core_copy_to_distro_temp_dir_failure', get_defined_vars(),
									sprintf($this->i18n('Unable to create a temporary distro directory for the new core: `%1$s`.'), $_new_core_distro_temp_dir)
								);
							else if($this->©dir->phar_to($_new_core_distro_temp_dir, $_new_core_dir.'/core.phar', $_new_core_distro_temp_dir.'/stub.php') !== $_new_core_dir.'/core.phar.php')
								throw $this->©exception(
									__METHOD__.'#unable_to_phar_new_core_distro_temp_dir_into_new_core_dir_stub', get_defined_vars(),
									sprintf($this->i18n('Unable to PHAR new temporary core distro into: `%1$s`.'), $_new_core_dir.'/core.phar.php')
								);
							else if(!$this->©dir->empty_and_remove($_new_core_distro_temp_dir))
								throw $this->©exception(
									__METHOD__.'#unable_to_delete_new_core_distro_temp_dir', get_defined_vars(),
									sprintf($this->i18n('Unable delete new temporary core distro directory: `%1$s`.'), $_new_core_distro_temp_dir)
								);
							$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_dir.'/core.phar.php'), dirname($this->core_dir));

							$successes->add(__METHOD__.'#new_core_distro_phar_stub_built_for_new_core_dir', get_defined_vars(),
							                sprintf($this->i18n('A temporary distro copy of the WebSharks™ Core has been compressed into a single PHP Archive file here: `%1$s`.'), $_new_core_dir.'/core.phar.php').
							                $this->i18n(' This file has been added to the list of GIT-tracked files in the WebSharks™ Core repo.').
							                $this->i18n(' The temporary distro copy of the WebSharks™ Core was deleted after processing.')
							);

							// Directory junction updates for project development (e.g. for plugins).

							if($this->update_core_jctn) // Update core directory junction?
								{
									$this->©dir->create_win_jctn(dirname($this->core_dir).'/'.$this->___instance_config->core_ns_stub_with_dashes, $_new_core_dir);

									$successes->add(__METHOD__.'#updated_new_core_dir_junction', get_defined_vars(),
									                sprintf($this->i18n('Updating `'.$this->___instance_config->core_ns_stub_with_dashes.'` directory junction to: `%1$s`.'), $_new_core_dir)
									);
								}
							unset($_new_core_dir, $_new_core_distro_temp_dir); // Housekeeping.

							$successes->add(__METHOD__.'#core_build_complete', get_defined_vars(), $this->i18n('Core build complete!'));
						}
					$successes->add(__METHOD__.'#finish_time', get_defined_vars(),
					                sprintf($this->i18n('Finish time: %1$s.'), $this->©env->time_details())
					);
					return $successes; // Return all successes now.
				}
		}
	}