<?php
/**
 * WebSharks™ Core Replicator.
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
		 * WebSharks™ Core Replicator.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__], 'unit_test')
		 */
		final class replicator extends framework
		{
			/**
			 * @var successes A successes object instance.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $success; // Defaults to a NULL value.

			/**
			 * @var boolean Defaults to a value of FALSE, for security purposes.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $can_replicate = FALSE;

			/**
			 * @var string Core directory being replicated.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $core_dir = '';

			/**
			 * @var string Plugin directory.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $plugin_dir = '';

			/**
			 * @var boolean Updating plugin directory?
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $updating_plugin_dir = FALSE;

			/**
			 * @var string Version for replication.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $to_version = '';

			/**
			 * @var string Replicating to this directory.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $to_dir = '';

			/**
			 * @var array An array of copy-to exclusions.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $to_exclusions = array();

			/**
			 * Constructor (initiates replication).
			 *
			 * @param object|array        $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or a new ``$___instance_config`` array.
			 *
			 * @param string              $plugin_dir Optional. Defaults to an empty string. If supplied, the core will be replicated into this directory.
			 *    If this is NOT supplied (or it's empty); the core will be replicated into a sub-directory of it's current parent location.
			 *    If ``$update_plugin_dir`` is TRUE, we need this directory.
			 *
			 * @param boolean             $update_plugin_dir Optional. Defaults to FALSE. Please use with caution (see description that follows).
			 *    If TRUE, all plugin files will be updated to match the newly replicated core. This way all files which depend on the core are updated automatically;
			 *    so they'll use the new version we're replicating into. Please use with extreme caution; this performs a MASSIVE search/replace routine.
			 *    If ``$update_plugin_dir`` is TRUE, we need a value for ``$plugin_dir``; else this is simply ignored silently.
			 *
			 * @param integer|string      $version Optional. Defaults to an empty string. Set this to an un-empty value if updating the version.
			 *    If this is an empty value, the version remains unchanged (e.g. it will NOT be updated by this routine).
			 *
			 * @param array               $exclusions Optional. An array of copy-to exclusions. Defaults to an empty array.
			 *    See: {@link \websharks_core_v000000_dev\dirs\copy_to()} for details about this parameter.
			 *
			 * @note Instantiation of this class will initiate the replication routine (so please be VERY careful).
			 *    Property ``$success`` will contain a message indicating the final result status of the replication procedure.
			 *    If there is a failure an exception is thrown by this class. We either succeed completely; or throw an exception.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If unable to replicate according to ``$this->can_replicate``.
			 * @throws exception See: ``replicate()`` method for further details.
			 */
			public function __construct($___instance_config, $plugin_dir = '', $update_plugin_dir = FALSE, $version = '', $exclusions = array())
				{
					parent::__construct($___instance_config);

					// Check remaining arguments (i.e. those expected by this constructor).

					$this->check_arg_types('', 'string', 'boolean', array('integer', 'string'), 'array', func_get_args());

					// Set property value ``$this->can_replicate``, upon class construction.

					if(!$this->©env->is_cli())
						$this->can_replicate = FALSE; // Not the command line.

					else if(!defined('___REPLICATOR') || !___REPLICATOR)
						$this->can_replicate = FALSE; // Not a replicator interface.

					else if($this->___instance_config->plugin_root_ns !== $this->___instance_config->core_ns)
						$this->can_replicate = FALSE; // Current instance is NOT the core itself.

					else // TRUE (we CAN replicate here).
						$this->can_replicate = TRUE;

					// Instantiation of this class will initiate the replication routine here.

					if(!$this->can_replicate) // Security check. We CAN replicate?
						throw $this->©exception(
							__METHOD__.'#cannot_replicate', get_defined_vars(),
							$this->i18n('Security check. Unable to replicate.')
						);

					$this->core_dir            = $this->©dir->n_seps(dirname(dirname(dirname(__FILE__))));
					$this->plugin_dir          = ($plugin_dir) ? $this->©dir->n_seps($plugin_dir) : '';
					$this->updating_plugin_dir = ($this->plugin_dir && $update_plugin_dir) ? TRUE : FALSE;
					$this->to_version          = ($version) ? (string)$version : $this->___instance_config->core_version;
					$this->to_exclusions       = ($exclusions) ? $exclusions : array();

					if(!preg_match($this->©string->regex_valid_ws_version, $this->to_version))
						throw $this->©exception(
							__METHOD__.'#invalid_version', get_defined_vars(),
							sprintf($this->i18n('Invalid WebSharks™ version string: `%1$s`.'), $this->to_version)
						);

					if($this->plugin_dir)
						$this->to_dir = $this->plugin_dir.'/'.$this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->to_version;
					else $this->to_dir = dirname($this->core_dir).'/'.$this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->to_version;

					if(($success = $this->replicate()))
						$this->success = $success;

					else throw $this->©exception(
						__METHOD__.'#replication_failure', NULL,
						$this->i18n('Failure. Unable to replicate.')
					);
				}

			/**
			 * Handles WebSharks™ Core framework replication.
			 *
			 * @return successes Returns an instance of successes; else throws an exception on any type of failure.
			 *
			 * @throws exception If the replication directory already exists & removal is NOT possible.
			 * @throws exception If unable to copy the current core directory to it's new replicated location.
			 * @throws exception If unable to update files in the newly replicated directory (we always do this).
			 * @throws exception If unable to update plugin files (when/if this is being requested).
			 * @throws exception See: ``update_files_in_dir()`` method for further details.
			 */
			protected function replicate() // Handles WebSharks™ Core framework replication.
				{
					$this->©env->prep_for_cli_dev_procedure();

					if(is_dir($this->to_dir) // Careful here that we do NOT remove the existing core directory under any circumstance.
					   && ($this->to_dir === $this->core_dir || !is_writable($this->to_dir) || !$this->©dir->empty_and_remove($this->to_dir))
					) // ``$this->to_dir`` already exists; and we were UNABLE to remove it successfully.
						throw $this->©exception(
							__METHOD__.'#to_dir_exists', get_defined_vars(),
							$this->i18n('This directory already exists; and removal was NOT possible.').
							sprintf($this->i18n(' Please check: `%1$s`.'), $this->to_dir)
						);

					if(!$this->©dir->copy_to($this->core_dir, $this->to_dir, $this->to_exclusions, TRUE))
						throw $this->©exception(
							__METHOD__.'#unable_to_copy_core_dir_to_dir', get_defined_vars(),
							sprintf($this->i18n('Unable to copy: `%1$s`, to: `%2$s`.'), $this->core_dir, $this->to_dir)
						);

					if(!$this->update_files_in_dir($this->to_dir))
						throw $this->©exception(
							__METHOD__.'#unable_to_update_to_dir', get_defined_vars(),
							sprintf($this->i18n('Unable to update core files in: `%1$s`.'), $this->to_dir)
						);

					if($this->plugin_dir && $this->updating_plugin_dir)
						{
							if(!$this->update_files_in_dir($this->plugin_dir))
								throw $this->©exception(
									__METHOD__.'#unable_to_update_plugin_dir', get_defined_vars(),
									sprintf($this->i18n('Unable to update plugin files in: `%1$s`.'), $this->plugin_dir)
								);
							return $this->©success(
								__METHOD__.'#complete_w/update_including_plugin_files', get_defined_vars(),
								$this->i18n('Replication completed successfully. Updated all plugin files.')
							);
						}
					return $this->©success(
						__METHOD__.'#complete_w/update', get_defined_vars(),
						$this->i18n('Replication completed successfully.')
					);
				}

			/**
			 * Updates namespace references in directories/files (e.g. a deep search/replace routine).
			 *    This search/replace routine includes both underscored and dashed variations.
			 *    This search/replace routine will ALSO rename directories (if needed).
			 *
			 * @param string  $dir Directory to begin our search in (search/replace is a deep recursive scan).
			 *
			 * @return boolean TRUE if the search/replace operation completes fully and successfully.
			 *    Otherwise, an exception is thrown for any type of failure.
			 *
			 * @note This routine will NOT search/replace inside any past or present core directory.
			 *    With ONE exception, we DO allow search/replace inside the directory containing our newly replicated core.
			 *
			 * @IMPORTANT It is VERY important that `websharks_core_v000000_dev` and/or `websharks-core-v000000-dev`;
			 *    do NOT have any of these characters after them: `[a-z0-9_\-]`; UNLESS they are part the version string.
			 *    Any of these characters appearing after the stub could be subjected to a search/replace routine.
			 *    Including them in word fragments (when NOT part of the version string); causes corruption.
			 *    See also: {@link \websharks_core_v000000_dev\strings\regex_valid_ws_core_version}
			 *    Exception... the following is OK: `websharks_core_v000000_dev->`
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$dir`` is empty or is non-existent for any reason.
			 * @throws exception If ``$dir`` (or any sub-directory) is NOT readable, or CANNOT be opened for any reason.
			 * @throws exception If any file is NOT readable/writable, for any reason.
			 * @throws exception If unable to write search/replace changes to a file.
			 * @throws exception If any recursive failure occurs on a sub-directory.
			 * @throws exception If unable to rename directories (when/if needed), for any reason.
			 * @throws exception If unable to properly search/replace any file, for any reason.
			 */
			protected function update_files_in_dir($dir)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(!($dir = $this->©dir->n_seps($dir)) || !is_dir($dir))
						throw $this->©exception(
							__METHOD__.'#nonexistent_dir', get_defined_vars(),
							sprintf($this->i18n('Non-existent `$dir` argument value: `%1$s`.'), $dir)
						);

					$new_core_ns_v             = $this->___instance_config->core_ns_stub.'_v'.str_replace('-', '_', $this->to_version);
					$new_core_ns_v_with_dashes = $this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->to_version;

					$regex_core_ns_v                          = '/'.ltrim(rtrim($this->©string->regex_valid_ws_core_ns_version, '$/'), '/^').'/';
					$regex_core_ns_v_with_dashes              = '/'.ltrim(rtrim($this->©string->regex_valid_ws_core_ns_version_with_dashes, '$/'), '/^').'/';
					$regex_core_ns_v_dir_with_dashes          = '/\/'.ltrim(rtrim($this->©string->regex_valid_ws_core_ns_version_with_dashes, '$/'), '/^').'\//';
					$regex_core_ns_v_dir_basename_with_dashes = $this->©string->regex_valid_ws_core_ns_version_with_dashes;

					// This routine will NOT search/replace inside any past or present core directory.
					// With ONE exception, we DO allow search/replace inside the directory containing our newly replicated core.
					if(preg_match($regex_core_ns_v_dir_with_dashes, $dir.'/') && stripos($dir.'/', $this->to_dir.'/') !== 0)
						return TRUE; // Skipping. It's a core directory that's NOT a part of our newly replicated copy.

					// Validate directory permissions.

					if(!is_readable($dir))
						throw $this->©exception(
							__METHOD__.'#read_write_issues', get_defined_vars(),
							$this->i18n('Unable to search a directory; not readable due to permission issues.').
							sprintf($this->i18n(' Need this directory to be readable please: `%1$s`.'), $dir)
						);

					// Handle core directories that need to be renamed before processing continues.

					if(preg_match($regex_core_ns_v_dir_basename_with_dashes, basename($dir)) && basename($dir) !== basename($this->to_dir))
						{
							if(!rename($dir, dirname($dir).'/'.basename($this->to_dir)))
								throw $this->©exception(
									__METHOD__.'#rename_failure', get_defined_vars(),
									$this->i18n('Unable to rename a directory for some unknown reason.').
									sprintf($this->i18n(' Please check this directory: `%1$s`.'), $dir)
								);
							$dir = dirname($dir).'/'.basename($this->to_dir); // Rename ``$dir` variable too.
							clearstatcache(); // The original ``is_dir($dir)`` is no longer valid after a rename here.
						}

					// Perform recursive search/replace routines.

					if(!($_open_dir = opendir($dir)))
						throw $this->©exception(
							__METHOD__.'#read_write_issues', get_defined_vars(),
							$this->i18n('Unable to search a directory; cannot open for some unknown reason.').
							sprintf($this->i18n(' Make this directory readable please: `%1$s`.'), $dir)
						);
					while(($_dir_file = readdir($_open_dir)) !== FALSE) // Recursive search/replace.
						{
							if($_dir_file === '.' || $_dir_file === '..')
								continue; // Ignore directory dots.

							$_dir_file = $dir.'/'.$_dir_file; // Expand ``$_dir_file`` to a full directory path now.

							// Deal with directories.

							if(is_dir($_dir_file)) // Directory recursion. Throw exception on any failure.
								{
									if(!$this->update_files_in_dir($_dir_file))
										throw $this->©exception(
											__METHOD__.'#recursion_failure', get_defined_vars(),
											sprintf($this->i18n('Recursion failure in directory: `%1$s`.'), $_dir_file)
										);
									continue; // Continue; this directory is now done.
								}

							// Deal with files. This is where the bulk of our search/replace routine takes place.

							if(!is_readable($_dir_file) || !is_writable($_dir_file) || !is_string($_file = file_get_contents($_dir_file)))
								throw $this->©exception(
									__METHOD__.'#read_write_issues', get_defined_vars(),
									$this->i18n('Unable to search a file; cannot read/write due to permission issues.').
									sprintf($this->i18n(' Make this file readable/writable please: `%1$s`.'), $_dir_file)
								);

							if(!$_file) continue; // If the file is empty; we can simply continue.

							$_file_contains_core_ns_v             = (preg_match($regex_core_ns_v, $_file)) ? TRUE : FALSE;
							$_file_contains_core_ns_v_with_dashes = (preg_match($regex_core_ns_v_with_dashes, $_file)) ? TRUE : FALSE;

							if(!$_file_contains_core_ns_v && !$_file_contains_core_ns_v_with_dashes)
								continue; // Does NOT contain anything we need to search/replace.

							if($_file_contains_core_ns_v) // Contains normal underscore variation(s)?
								{
									$_file = preg_replace($regex_core_ns_v, $this->©string->esc_refs($new_core_ns_v), $_file);

									if(!$_file || stripos($_file, $new_core_ns_v) === FALSE)
										throw $this->©exception(
											__METHOD__.'#search_replace_failure', get_defined_vars(),
											sprintf($this->i18n('Unable to properly search/replace file: `%1$s`.'), $_dir_file).
											sprintf($this->i18n('Last PCRE regex error: `%1$s`.'), $this->©string->preg_last_error())
										);
								}
							if($_file_contains_core_ns_v_with_dashes) // Contains dashed variation(s)?
								{
									$_file = preg_replace($regex_core_ns_v_with_dashes, $this->©string->esc_refs($new_core_ns_v_with_dashes), $_file);

									if(!$_file || stripos($_file, $new_core_ns_v_with_dashes) === FALSE)
										throw $this->©exception(
											__METHOD__.'#search_replace_failure', get_defined_vars(),
											sprintf($this->i18n('Unable to properly search/replace file: `%1$s`.'), $_dir_file).
											sprintf($this->i18n('Last PCRE regex error: `%1$s`.'), $this->©string->preg_last_error())
										);
								}
							if(!file_put_contents($_dir_file, $_file))
								throw $this->©exception(
									__METHOD__.'#read_write_issues', get_defined_vars(),
									$this->i18n('Unable to properly search/replace file due to permission issues.').
									sprintf($this->i18n(' Make this file readable/writable please: `%1$s`.'), $_dir_file)
								);
						}
					closedir($_open_dir); // Close directory.
					unset($_dir_file, $_file); // A little housekeeping here.
					unset($_file_contains_core_ns_v, $_file_contains_core_ns_v_with_dashes);

					return TRUE; // All done. Nothing more to do here.
				}
		}
	}