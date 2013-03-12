<?php
/**
 * File Utilities.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120329
 */
namespace websharks_core_v000000_dev
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		/**
		 * File Utilities.
		 *
		 * @package WebSharks\Core
		 * @since 120329
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class files extends framework
		{
			/**
			 * Get abbreviated byte notation for a particular file.
			 *
			 * @param string $file Location of a file.
			 *
			 * @return string If file exists, an abbreviated byte notation — else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (dirname(__FILE__).'/files.php') === '5.51 kbs'
			 */
			public function size_abbr($file)
				{
					$this->check_arg_types('string', func_get_args());

					if($file && is_file($file))
						return $this->bytes_abbr((float)filesize($file));

					return '';
				}

			/**
			 * Abbreviated byte notation for file sizes.
			 *
			 * @param float     $bytes File size in bytes. A (float) value.
			 *    We need this converted to a (float), so it's possible to deal with numbers beyond that of an integer.
			 * @param integer   $precision Number of decimals to use.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @return string Byte notation.
			 *
			 * @assert ((float)1) === '1 byte'
			 * @assert ((float)2) === '2 bytes'
			 * @assert ((float)1024) === '1 kb'
			 * @assert ((float)2048) === '2 kbs'
			 * @assert ((float)1048576) === '1 MB'
			 * @assert ((float)1073741824) === '1 GB'
			 * @assert ((float)1099511627776) === '1 TB'
			 */
			public function bytes_abbr($bytes, $precision = 2)
				{
					$this->check_arg_types('float', 'integer', func_get_args());

					$precision = ($precision >= 0) ? $precision : 2;
					$units     = array('bytes', 'kbs', 'MB', 'GB', 'TB');

					$bytes = ($bytes > 0) ? $bytes : 0;
					$power = floor(($bytes ? log($bytes) : 0) / log(1024));

					$abbr_bytes = round($bytes / pow(1024, $power), $precision);
					$abbr       = $units[min($power, count($units) - 1)];

					if($abbr_bytes === (float)1 && $abbr === 'bytes')
						$abbr = 'byte'; // Quick fix here.

					else if($abbr_bytes === (float)1 && $abbr === 'kbs')
						$abbr = 'kb'; // Quick fix here.

					return $abbr_bytes.' '.$abbr;
				}

			/**
			 * Converts an abbreviated byte notation into bytes.
			 *
			 * @param string $string A string value in byte notation.
			 *
			 * @return float A float indicating the number of bytes.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('200TB') === (float)(200*1024*1024*1024*1024)
			 * @assert ('2TB') === (float)(2*1024*1024*1024*1024)
			 * @assert ('2GB') === (float)(2*1024*1024*1024)
			 * @assert ('64M') === (float)(64*1024*1024)
			 * @assert ('64MB') === (float)(64*1024*1024)
			 * @assert ('128M') === (float)(128*1024*1024)
			 * @assert ('24 kbs') === (float)(24*1024)
			 * @assert ('24 kb') === (float)(24*1024)
			 * @assert ('12 bytes') === (float)12
			 * @assert ('1 byte') === (float)1
			 */
			public function abbr_bytes($string)
				{
					$this->check_arg_types('string', func_get_args());

					$notation = '/^(?P<value>[0-9\.]+)\s*(?P<modifier>bytes|byte|kbs|kb|k|mb|m|gb|g|tb|t)$/i';

					if(preg_match($notation, $string, $_op))
						{
							$value    = (float)$_op['value'];
							$modifier = strtolower($_op['modifier']);
							unset($_op); // Housekeeping.

							switch($modifier) // Fall through based on modifier.
							{
								case 't': // Multiplied four times.
								case 'tb':
										$value *= 1024;
								case 'g': // Multiplied three times.
								case 'gb':
										$value *= 1024;
								case 'm': // Multiple two times.
								case 'mb':
										$value *= 1024;
								case 'k': // One time only.
								case 'kb':
								case 'kbs':
										$value *= 1024;
							}
							return (float)$value;
						}
					return (float)0;
				}

			/**
			 * Attempts to get `wp-load.php`.
			 *
			 * @param boolean             $check_abspath Defaults to TRUE (recommended).
			 *    If TRUE, first check ABSPATH for `/wp-load.php`.
			 *
			 * @param null|boolean|string $fallback_on_dev_dir Defaults to NULL (recommended).
			 *
			 *    • If NULL — and WordPress® cannot be located anywhere;
			 *       and `___DEV_KEY_OK` is TRUE; automatically fallback on a local development copy.
			 *
			 *    • If TRUE — and WordPress® cannot be located anywhere; automatically fallback on a local development copy.
			 *
			 *    • If NULL|TRUE — we'll look inside: `E:/EasyPHP/wordpress` (a default WebSharks™ Core location).
			 *       If STRING — we'll look inside the directory path defined by the string value.
			 *
			 *    • If FALSE — we will NOT fallback under any circumstance.
			 *
			 * @return string Full server path to `wp-load.php` on success, else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert () === dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))).'/wp-load.php'
			 */
			public function wp_load($check_abspath = TRUE, $fallback_on_dev_dir = NULL)
				{
					$this->check_arg_types('boolean', array('null', 'boolean', 'string'), func_get_args());

					if(!isset($fallback_on_dev_dir))
						$fallback_on_dev_dir = defined('___DEV_KEY_OK');

					$cache_entry = '_'.(integer)$check_abspath;
					if($fallback_on_dev_dir && is_string($fallback_on_dev_dir))
						$cache_entry .= $fallback_on_dev_dir;
					else $cache_entry .= (integer)$fallback_on_dev_dir;

					if(isset($this->static['wp_load'][$cache_entry]))
						return $this->static['wp_load'][$cache_entry];

					if($check_abspath && defined('ABSPATH') && is_file(ABSPATH.'wp-load.php'))
						return ($this->static['wp_load'][$cache_entry] = ABSPATH.'wp-load.php');

					for($_i = 0, $_dirname = dirname(dirname(dirname(__FILE__))); $_i <= 100; $_i++)
						{
							for($_dir = $_dirname, $__i = 0; $__i < $_i; $__i++)
								$_dir = dirname($_dir);

							if(is_file($_dir.'/wp-load.php'))
								return ($this->static['wp_load'][$cache_entry] = $_dir.'/wp-load.php');

							if(!$_dir || $_dir === '.') break;
						}
					unset($_i, $__i, $_dirname, $_dir);

					if($fallback_on_dev_dir) // Fallback on development copy?
						{
							if(is_string($fallback_on_dev_dir))
								$dev_dir = $fallback_on_dev_dir;
							else $dev_dir = 'E:/EasyPHP/wordpress';

							if(is_file($dev_dir.'/wp-load.php'))
								return ($this->static['wp_load'][$cache_entry] = $dev_dir.'/wp-load.php');
						}
					return ($this->static['wp_load'][$cache_entry] = '');
				}

			/**
			 * Archive/rename, if file size is becoming too large.
			 *
			 * @param string $file An absolute file path.
			 *    If file exists, the file MUST be readable/writable.
			 *
			 * @return string A reverberation of ``$file``.
			 *    The ``$file`` string NEVER changes, only the source might be renamed.
			 *    In which case, ``$file`` may no longer exist after this routine.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$file`` exists, but it's NOT readable/writable.
			 * @throws exception If the containing dir is NOT readable/writable.
			 * @throws exception If a PHP ``rename()`` fails.
			 */
			public function maybe_archive($file)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(!is_file($file))
						return $file;

					else if(!is_readable($file) || !is_writable($file))
						throw $this->©exception(
							__METHOD__.'#read_write_issues', get_defined_vars(),
							$this->i18n('Expecting a readable/writable file (permission issues).').
							sprintf($this->i18n(' Got: `%1$s`.'), $file)
						);
					else if(filesize($file) < 1048576 * 2) // Two megabytes.
						return $file;

					$extension    = $this->extension($file);
					$extension    = ($extension) ? '.'.$extension : '';
					$archive_file = dirname($file).'/'.basename($file, $extension).'-archived-'.time().$extension;

					return $this->rename_to($file, $archive_file);
				}

			/**
			 * Copy a file.
			 *
			 * @param string $file Path to file.
			 * @param string $to Path to new copy location.
			 *
			 * @return string New copy location; else an exception is thrown.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$file`` is NOT a string; or is an empty string.
			 * @throws exception If ``$file`` is NOT actually a file.
			 * @throws exception If ``$file`` is NOT readable.
			 * @throws exception If ``$to`` is NOT a string; or is an empty string.
			 * @throws exception If ``$to`` already exists.
			 * @throws exception If ``$to`` parent directory does NOT exist; or is NOT writable.
			 * @throws exception If the underlying call to PHP's ``copy()`` function fails for any reason.
			 *
			 * @note This will NOT copy directories; only a single file.
			 */
			public function copy_to($file, $to)
				{
					$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

					$file = $this->©dir->n_seps($file);
					$to   = $this->©dir->n_seps($to);

					if(!is_file($file))
						throw $this->©exception(
							__METHOD__.'#nonexistent_source', get_defined_vars(),
							sprintf($this->i18n('Unable to copy. Nonexistent source: `%1$s`.'), $file)
						);
					else if(!is_readable($file))
						throw $this->©exception(
							__METHOD__.'#read_write_issues', get_defined_vars(),
							sprintf($this->i18n('Unable to copy this file: `%1$s`.'), $file).
							$this->i18n(' Possible permission issues. This file is not readable.')
						);

					if(file_exists($to))
						throw $this->©exception(
							__METHOD__.'#destination_exists', get_defined_vars(),
							$this->i18n('Destination exists; it MUST first be deleted please.').
							sprintf($this->i18n(' Please check this file: `%1$s`.'), $to)
						);
					else if(!is_dir(dirname($to)))
						throw $this->©exception(
							__METHOD__.'#destination_dir_missing', get_defined_vars(),
							$this->i18n('Destination\'s parent directory does NOT exist yet.').
							sprintf($this->i18n(' Please check this directory: `%1$s`.'), dirname($to))
						);
					else if(!is_writable(dirname($to)))
						throw $this->©exception(
							__METHOD__.'#destination_dir_permissions', get_defined_vars(),
							$this->i18n('Destination\'s directory is not writable.').
							sprintf($this->i18n(' Please check permissions on this directory: `%1$s`.'), dirname($to))
						);

					if(!copy($file, $to))
						throw $this->©exception(
							__METHOD__.'#failure', get_defined_vars(),
							sprintf($this->i18n('Unable to copy this file: `%1$s`; to `%2$s`.'), $file, $to).
							$this->i18n(' Possible permission issues. Please copy this file manually.')
						);
					clearstatcache(); // Make other routines aware.

					return $to; // It's a good day in Eureka!
				}

			/**
			 * Rename a file.
			 *
			 * @param string $file A full file path.
			 * @param string $to A new full file path.
			 *
			 * @return string Path to new location; else an exception is thrown.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$file`` is NOT a string; or is an empty string.
			 * @throws exception If ``$file`` is NOT actually a file.
			 * @throws exception If ``$file`` is NOT a readable/writable file.
			 * @throws exception If ``$to`` is NOT a string; or is an empty string.
			 * @throws exception If ``$to`` already exists.
			 * @throws exception If ``$to`` parent directory does NOT exist; or is NOT writable.
			 * @throws exception If the underlying call to PHP's ``rename()`` function fails for any reason.
			 *
			 * @note This will NOT rename directories; only a single file.
			 */
			public function rename_to($file, $to)
				{
					$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

					$file = $this->©dir->n_seps($file);
					$to   = $this->©dir->n_seps($to);

					if(!is_file($file))
						throw $this->©exception(
							__METHOD__.'#nonexistent_source', get_defined_vars(),
							sprintf($this->i18n('Unable to rename. Nonexistent source: `%1$s`.'), $file)
						);
					else if(!is_readable($file))
						throw $this->©exception(
							__METHOD__.'#read_write_issues', get_defined_vars(),
							sprintf($this->i18n('Unable to rename this file: `%1$s`.'), $file).
							$this->i18n(' Possible permission issues. This file is not readable.')
						);
					else if(!is_writable($file))
						throw $this->©exception(
							__METHOD__.'#read_write_issues', get_defined_vars(),
							sprintf($this->i18n('Unable to rename this file: `%1$s`.'), $file).
							$this->i18n(' Possible permission issues. This file is not writable.')
						);

					if(file_exists($to))
						throw $this->©exception(
							__METHOD__.'#destination_exists', get_defined_vars(),
							$this->i18n('Destination exists; it MUST first be deleted please.').
							sprintf($this->i18n(' Please check this file or directory: `%1$s`.'), $to)
						);
					else if(!is_dir(dirname($to)))
						throw $this->©exception(
							__METHOD__.'#destination_dir_missing', get_defined_vars(),
							$this->i18n('Destination\'s parent directory does NOT exist yet.').
							sprintf($this->i18n(' Please check this directory: `%1$s`.'), dirname($to))
						);
					else if(!is_writable(dirname($to)))
						throw $this->©exception(
							__METHOD__.'#destination_dir_permissions', get_defined_vars(),
							$this->i18n('Destination\'s directory is not writable.').
							sprintf($this->i18n(' Please check permissions on this directory: `%1$s`.'), dirname($to))
						);

					if(!rename($file, $to))
						throw $this->©exception(
							__METHOD__.'#rename_failure', get_defined_vars(),
							sprintf($this->i18n('Rename failure. Could NOT rename: `%1$s`; to: `%2$s`.'), $file, $to)
						);
					clearstatcache(); // Make other routines aware.

					return $to; // It's a good day in Eureka!
				}

			/**
			 * File deletion.
			 *
			 * @param string|array $file Path to file (or an array of file paths).
			 *
			 * @params-variable-length This function accepts a variable-length list of arguments.
			 *    You can pass in any number of file paths for deletion (even string/array mixtures).
			 *
			 * @return boolean TRUE if all files are deleted; else an exception is thrown.
			 *    Also returns TRUE for any files that do NOT even exist.
			 *
			 * @note This will NOT delete directories; only files.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If any ``$file`` is NOT a string|array; or is an empty string|array.
			 * @throws exception If any ``$file`` exists; but it is NOT actually a file.
			 * @throws exception If any ``$file`` is NOT writable.
			 * @throws exception If the underlying call to PHP's ``unlink()`` function fails for any reason.
			 */
			public function unlink($file)
				{
					$this->check_arg_types(array('string:!empty', 'array:!empty'), func_get_args());

					$files = array();
					foreach(func_get_args() as $_file)
						if(is_array($_file)) $files = array_merge($files, $_file);
						else $files[] = $_file;

					$files = array_map(array($this, '©dir.n_seps'), $files);
					$files = array_unique($files);

					foreach($files as $_file)
						{
							if(!$this->©string->is_not_empty($_file))
								throw $this->©exception(
									__METHOD__.'#invalid_file', get_defined_vars(),
									sprintf($this->i18n('Unable to delete this file: `%1$s`.'), $this->©var->dump($_file)).
									$this->i18n(' Each file MUST be represented by a (string) that is NOT empty.')
								);
							else if(!file_exists($_file)) continue; // Already gone.

							else if(!is_file($_file))
								throw $this->©exception(
									__METHOD__.'#invalid_file', get_defined_vars(),
									sprintf($this->i18n('Unable to delete this file path. NOT a file: `%1$s`.'), $_file)
								);
							else if(!is_writable($_file) || !unlink($_file))
								throw $this->©exception(
									__METHOD__.'#read_write_issues', get_defined_vars(),
									sprintf($this->i18n('Unable to delete this file: `%1$s`.'), $_file).
									$this->i18n(' Possible permission issues. Please delete this file manually.')
								);
						}
					unset($_file); // Housekeeping.
					clearstatcache(); // Make other routines aware.

					return TRUE; // Default return value.
				}

			/**
			 * Deletes files from a shell glob pattern.
			 *
			 * @param string|array|boolean $glob A glob pattern; or an array of absolute file paths.
			 *    If this is a string; it must NOT be empty. Arrays CAN be empty however.
			 *    A boolean is also accepted; in case an input ``glob()`` fails.
			 *
			 * @return integer Number of files deleted; else an exception is thrown.
			 *    Files that do NOT even exist; do NOT get counted in this.
			 *    This function may often return a `0` value.
			 *
			 * @note This will NOT delete directories; only files.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$glob`` is an empty string.
			 * @throws exception If unable to delete a file for any reason.
			 */
			public function unlink_glob($glob)
				{
					$this->check_arg_types(array('string:!empty', 'array', 'boolean'), func_get_args());

					$deleted_files = 0; // Initialize.
					if(is_bool($glob)) return $deleted_files; // Ignore.
					$glob = (is_array($glob)) ? $glob : (array)glob($glob);

					foreach($glob as $_dir_file) if($this->©string->is_not_empty($_dir_file) && is_file($_dir_file))
						{
							if(!is_writable($_dir_file) || !unlink($_dir_file))
								throw $this->©exception(
									__METHOD__.'#read_write_issues', get_defined_vars(),
									sprintf($this->i18n('Unable to delete this file: `%1$s`.'), $_dir_file).
									$this->i18n(' Possible permission issues. Please delete this file manually.')
								);
							$deleted_files++;
						}
					clearstatcache(); // Make other routines aware.

					return $deleted_files; // Total deleted files.
				}

			/**
			 * Locates a template file (in one of many possible locations).
			 *
			 * @param string $file Template file name (relative path).
			 *
			 * @return string Absolute path to a template file (w/ the highest precedence).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$file`` is empty (it MUST be passed as a string, NOT empty).
			 * @throws exception If ``$file`` does NOT exist, or is NOT readable.
			 */
			public function template($file)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					foreach(($dirs = $this->©dirs->where_templates_may_reside()) as $_dir)
						if(is_file($path = $_dir.'/'.$file) && is_readable($path))
							return $path;
					unset($_dir); // Housekeeping.

					throw $this->©exception(
						__METHOD__.'#file_missing', get_defined_vars(),
						sprintf($this->i18n('Unable to locate template file: `%1$s`.'), $file)
					);
				}

			/**
			 * Locates a template file (in one of many possible locations).
			 *
			 * @param string $file Template file name (relative path).
			 *
			 * @return string URL to a template file (w/ the highest precedence).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$file`` is empty (it MUST be passed as a string, NOT empty).
			 * @throws exception If ``$file`` does NOT exist, or is NOT readable.
			 */
			public function template_url($file)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					return $this->©url->to_wp_abs_dir_or_file($this->template($file));
				}

			/**
			 * Converts a file path to a CSS class name.
			 *
			 * @param string $file Any file path (usually a relative path).
			 *
			 * @return string A CSS class name.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function to_css_class($file)
				{
					$this->check_arg_types('string', func_get_args());

					$file = $this->©dir->n_seps($file);

					if(($strrpos = strrpos($file, '.')) !== FALSE)
						$class = (string)substr($file, 0, $strrpos);
					else $class = $file;

					$class = str_replace('/', '--', $class);
					$class = preg_replace('/[^a-z0-9\-]/i', '-', $class);
					$class = trim($class, '-');

					return $class;
				}

			/**
			 * Gets a file extension (lowercase).
			 *
			 * @param string $file A file path, or just a file name.
			 *
			 * @return string File extension (lowercase).
			 */
			public function extension($file)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					return strtolower(ltrim((string)strrchr(basename($file), '.'), '.'));
				}
		}
	}