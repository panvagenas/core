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
			 * @var string Core directory that we're replicating.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $core_dir = '';

			/**
			 * @var string Replicating into this main directory.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $into_dir = '';

			/**
			 * @var string Directory to update files in, after replication is complete.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $update_dir = '';

			/**
			 * @var string Version for replicated core.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $version = '';

			/**
			 * @var array An array of copy-to exclusions during replication.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $exclusions = array();

			/**
			 * @var string Replicating into this new sub-directory of ``$into_dir``.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $new_core_dir = '';

			/**
			 * Constructor (initiates replication).
			 *
			 * @param object|array $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or a new ``$___instance_config`` array.
			 *
			 * @param string       $into_dir Optional. Defaults to an empty string.
			 *    If this is supplied, the core will be replicated into this specific directory.
			 *    Else, the core will be replicated into a sub-directory of its current parent directory.
			 *
			 * @param string       $update_dir Optional. Defaults to an empty string.
			 *    Please use with EXTREME caution; this performs a MASSIVE search/replace routine.
			 *    If TRUE, all files inside ``$update_dir`` will be updated to match the version of the newly replicated core.
			 *    If FALSE, we simply update files in the new core directory; nothing more.
			 *
			 * @param string       $version Optional. Defaults to an empty string.
			 *    By default, the version remains unchanged (e.g. it will NOT be updated by this routine).
			 *    If this is NOT empty, we will replicate the core as a specific version indicated by this value.
			 *
			 * @param array        $exclusions Optional. An array of copy-to exclusions. Defaults to an empty array.
			 *    See: {@link \websharks_core_v000000_dev\dirs::copy_to()} for details about this parameter.
			 *
			 * @note Instantiation of this class will initiate the replication routine (please be VERY careful).
			 *    Property ``$success`` will contain a message indicating the final result status of the replication procedure.
			 *    If there is a failure, an exception is thrown by this class. We either succeed completely; or throw an exception.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If unable to replicate according to ``$this->can_replicate``.
			 * @throws exception See: ``replicate()`` method for further details.
			 */
			public function __construct($___instance_config, $into_dir = '', $update_dir = '', $version = '', $exclusions = array())
				{
					parent::__construct($___instance_config);

					$this->check_arg_types('', 'string', 'string', 'string', 'array', func_get_args());

					if(!$this->©env->is_cli())
						$this->can_replicate = FALSE;

					else if(!$this->©plugin->is_core())
						$this->can_replicate = FALSE;

					else if((!defined('___BUILDER') || !___BUILDER) &&
					        (!defined('___REPLICATOR') || !___REPLICATOR)
					) $this->can_replicate = FALSE;

					else $this->can_replicate = TRUE; // We CAN replicate.

					if(!$this->can_replicate)
						throw $this->©exception(
							__METHOD__.'#cannot_replicate', get_defined_vars(),
							$this->i18n('Security check. Unable to replicate (not allowed here).')
						);

					$this->core_dir   = $this->©dir->n_seps(dirname(dirname(dirname(__FILE__))));
					$this->into_dir   = ($into_dir) ? $this->©dir->n_seps($into_dir) : dirname($this->core_dir);
					$this->version    = ($version) ? $version : $this->___instance_config->core_version;
					$this->exclusions = ($exclusions) ? $exclusions : array();

					$this->new_core_dir = $this->into_dir.'/'.$this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->version;
					$this->update_dir   = ($update_dir) ? $this->©dir->n_seps($update_dir) : $this->new_core_dir;

					if(!is_dir($this->into_dir))
						throw $this->©exception(
							__METHOD__.'#invalid_into_dir', get_defined_vars(),
							sprintf($this->i18n('Invalid directory: `%1$s`.'), $this->into_dir).
							$this->i18n(' This is NOT an existing directory that we can replicate into.')
						);
					else if($this->update_dir !== $this->new_core_dir && !is_dir($this->update_dir))
						throw $this->©exception(
							__METHOD__.'#invalid_update_dir', get_defined_vars(),
							sprintf($this->i18n('Invalid directory: `%1$s`.'), $this->into_dir).
							$this->i18n(' This is NOT an existing directory that we can update files in.')
						);
					else if(!preg_match($this->©string->regex_valid_ws_version, $this->version))
						throw $this->©exception(
							__METHOD__.'#invalid_version', get_defined_vars(),
							sprintf($this->i18n('Invalid WebSharks™ Core version: `%1$s`.'), $this->version)
						);

					$this->success = $this->replicate();
				}

			/**
			 * Handles WebSharks™ Core framework replication.
			 *
			 * @return successes Returns an instance of successes; else throws an exception on any type of failure.
			 *
			 * @throws exception If the replication directory already exists & removal is NOT possible.
			 * @throws exception If unable to copy the current core directory to it's new replicated location.
			 * @throws exception If unable to update files after replication is complete.
			 * @throws exception If unable to complete replication for any reason.
			 */
			protected function replicate()
				{
					if(is_dir($this->new_core_dir)) // Exists?
						{
							if($this->new_core_dir === $this->core_dir)
								throw $this->©exception(
									__METHOD__.'#new_core_dir_exists', get_defined_vars(),
									$this->i18n('The new core directory already exists; and removal is NOT possible.').
									sprintf($this->i18n(' Cannot replicate into self: `%1$s`.'), $this->new_core_dir)
								);
							$this->©dir->empty_and_remove($this->new_core_dir);
						}
					$this->©dir->copy_to($this->core_dir, $this->new_core_dir, $this->exclusions, TRUE);
					$this->update_files_in_dir($this->update_dir); // Now we update files.

					return $this->©success(
						__METHOD__.'#complete', get_defined_vars(),
						$this->i18n('Replication completed successfully.')
					);
				}

			/**
			 * Updates namespace references in directories/files (e.g. a deep search/replace routine).
			 *    This search/replace routine includes both underscored and dashed variations.
			 *    This search/replace routine will ALSO rename directories (if needed).
			 *
			 * @param string $dir Directory to begin our search in (search/replace is a deep recursive scan).
			 *
			 * @note This routine will NOT search/replace inside any past or present core directory.
			 *    With ONE exception, we DO allow search/replace inside the directory containing our newly replicated core.
			 *
			 * @IMPORTANT It is VERY important that `websharks_core_v000000_dev` and/or `websharks-core-v000000-dev`;
			 *    do NOT have any of these characters after them: `[a-z0-9_\-]`; UNLESS they are part the version string.
			 *    Any of these characters appearing after the stub could be subjected to a search/replace routine.
			 *    Including them in word fragments (when NOT part of the version string); causes corruption.
			 *    See also: {@link \websharks_core_v000000_dev\strings::regex_valid_ws_core_version}
			 *    Exception... the following is OK: `websharks_core_v000000_dev->`
			 *
			 * @throws exception If invalid types are passed through arguments list (e.g. if ``$dir`` is NOT a string; or is empty).
			 * @throws exception If ``$dir`` (or any sub-directory) is NOT readable, or CANNOT be opened for any reason.
			 * @throws exception If any file is NOT readable/writable, for any reason.
			 * @throws exception If unable to write search/replace changes to a file.
			 * @throws exception If any recursive failure occurs on a sub-directory.
			 * @throws exception If unable to rename directories (when/if needed), for any reason.
			 * @throws exception If unable to properly search/replace any file, for any reason.
			 * @throws exception If unable to complete the entire search/replace routine for any reason.
			 */
			protected function update_files_in_dir($dir)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					$dir = $this->©dir->n_seps($dir);

					if(!is_dir($dir))
						throw $this->©exception(
							__METHOD__.'#nonexistent_dir', get_defined_vars(),
							sprintf($this->i18n('Non-existent directory: `%1$s`.'), $dir)
						);
					else if(!is_readable($dir))
						throw $this->©exception(
							__METHOD__.'#unreadable_dir', get_defined_vars(),
							$this->i18n('Unable to search a directory; not readable due to permission issues.').
							sprintf($this->i18n(' Need this directory to be readable please: `%1$s`.'), $dir)
						);

					$regex_core_ns_stub_dir_with_dashes       = '/\/'.preg_quote($this->___instance_config->core_ns_stub_with_dashes, '/').'\//';
					$regex_core_ns_v_dir_with_dashes          = '/\/'.ltrim(rtrim($this->©string->regex_valid_ws_core_ns_version_with_dashes, '$/'), '/^').'\//';
					$regex_core_ns_stub_or_v_dir_with_dashes  = '/(?:'.substr($regex_core_ns_stub_dir_with_dashes, 1, -1).'|'.substr($regex_core_ns_v_dir_with_dashes, 1, -1).')/';
					$regex_core_ns_v_dir_basename_with_dashes = $this->©string->regex_valid_ws_core_ns_version_with_dashes;

					// This routine will NOT search/replace inside any past or present WebSharks™ Core directory.
					// With ONE exception, we DO allow search/replace inside the directory containing our newly replicated core.
					if(preg_match($regex_core_ns_stub_or_v_dir_with_dashes, $dir.'/') && stripos($dir.'/', $this->new_core_dir.'/') !== 0)
						return; // Skipping. It's a core directory that's NOT a part of our newly replicated copy.

					// Handle core directories that need to be renamed before processing continues.
					if(preg_match($regex_core_ns_v_dir_basename_with_dashes, basename($dir)) && basename($dir) !== basename($this->new_core_dir))
						$this->©dir->rename_to($dir, ($dir = dirname($dir).'/'.basename($this->new_core_dir)));

					// Perform recursive search/replace routines.

					if(!($_open_dir = opendir($dir)))
						throw $this->©exception(
							__METHOD__.'#opendir_issue', get_defined_vars(),
							$this->i18n('Unable to search a directory; cannot open for some unknown reason.').
							sprintf($this->i18n(' Make this directory readable please: `%1$s`.'), $dir)
						);
					$regex_core_ns_v             = '/'.ltrim(rtrim($this->©string->regex_valid_ws_core_ns_version, '$/'), '/^').'/';
					$regex_core_ns_v_with_dashes = '/'.ltrim(rtrim($this->©string->regex_valid_ws_core_ns_version_with_dashes, '$/'), '/^').'/';

					$new_core_ns_v             = $this->___instance_config->core_ns_stub.'_v'.str_replace('-', '_', $this->version);
					$new_core_ns_v_with_dashes = $this->___instance_config->core_ns_stub_with_dashes.'-v'.$this->version;

					$esc_refs_new_core_ns_v             = $this->©string->esc_refs($new_core_ns_v);
					$esc_refs_new_core_ns_v_with_dashes = $this->©string->esc_refs($new_core_ns_v_with_dashes);

					while(($_dir_file = readdir($_open_dir)) !== FALSE)
						{
							// Bypass directory dots.

							if($_dir_file === '.' || $_dir_file === '..')
								continue; // Ignore directory dots.

							// Expand ``$_dir_file`` now.

							$_dir_file = $dir.'/'.$_dir_file;

							// Deal with directories.

							if(is_dir($_dir_file))
								{
									$this->update_files_in_dir($_dir_file);
									continue; // Done here.
								}
							// Bypass any of these files.

							if($this->©file->has_extension($_dir_file, $this::binary_type))
								continue; // Ignore all binary extensions.
							else if(preg_match('/\.phar\.php$/i', $_dir_file))
								continue; // Ignore PHAR.php files too.

							// This is where the bulk of our search/replace routine takes place.

							if(!is_readable($_dir_file) || !is_writable($_dir_file))
								throw $this->©exception(
									__METHOD__.'#read_write_file_issue', get_defined_vars(),
									$this->i18n('Unable to search a file; cannot read/write due to permission issues.').
									sprintf($this->i18n(' Make this file readable/writable please: `%1$s`.'), $_dir_file)
								);
							else if(!is_string($_file = file_get_contents($_dir_file)))
								throw $this->©exception(
									__METHOD__.'#read_file_contents_issue', get_defined_vars(),
									$this->i18n('Unable to search a file; cannot read file contents for some unknown reason.').
									sprintf($this->i18n(' Make this file readable/writable please: `%1$s`.'), $_dir_file)
								);
							else if(!$_file) continue; // If the file is empty; we can simply continue.

							$_file_contains_core_ns_v             = (preg_match($regex_core_ns_v, $_file)) ? TRUE : FALSE;
							$_file_contains_core_ns_v_with_dashes = (preg_match($regex_core_ns_v_with_dashes, $_file)) ? TRUE : FALSE;

							if(!$_file_contains_core_ns_v && !$_file_contains_core_ns_v_with_dashes)
								continue; // Does NOT contain anything we need to search/replace.

							if($_file_contains_core_ns_v) // Contains normal underscore variation(s)?
								{
									$_file = preg_replace($regex_core_ns_v, $esc_refs_new_core_ns_v, $_file);

									if(!$_file || strpos($_file, $new_core_ns_v) === FALSE)
										throw $this->©exception(
											__METHOD__.'#search_replace_failure', get_defined_vars(),
											sprintf($this->i18n('Unable to properly search/replace file: `%1$s`.'), $_dir_file).
											sprintf($this->i18n('Last PCRE regex error: `%1$s`.'), $this->©string->preg_last_error())
										);
								}
							if($_file_contains_core_ns_v_with_dashes) // Contains dashed variation(s)?
								{
									$_file = preg_replace($regex_core_ns_v_with_dashes, $esc_refs_new_core_ns_v_with_dashes, $_file);

									if(!$_file || strpos($_file, $new_core_ns_v_with_dashes) === FALSE)
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
				}
		}
	}