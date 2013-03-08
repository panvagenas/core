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

					if($file && file_exists($file))
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
			 *    • If NULL — and WordPress® cannot be located anywhere else;
			 *       and `___DEV_KEY_OK` is TRUE; automatically fallback on a local development copy.
			 *
			 *    • If TRUE — and WordPress® cannot be located anywhere else;
			 *       automatically fallback on a local development copy.
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
			public function get_wp_load($check_abspath = TRUE, $fallback_on_dev_dir = NULL)
				{
					$this->check_arg_types('boolean', array('null', 'boolean', 'string'), func_get_args());

					if($check_abspath && defined('ABSPATH') && file_exists(ABSPATH.'wp-load.php'))
						return ABSPATH.'wp-load.php';

					for($_i = 0, $_dirname = dirname(__FILE__); $_i <= 100; $_i++)
						{
							for($_dir = $_dirname, $__i = 0; $__i < $_i; $__i++)
								$_dir = dirname($_dir);

							if(file_exists($_dir.'/wp-load.php'))
								return $_dir.'/wp-load.php';

							if(!$_dir || $_dir === '.') break;
						}
					unset($_i, $__i, $_dirname, $_dir);

					if(!isset($fallback_on_dev_dir) && defined('___DEV_KEY_OK'))
						$fallback_on_dev_dir = TRUE;

					if($fallback_on_dev_dir) // Can we fallback in this case?
						{
							if(is_string($fallback_on_dev_dir))
								$dev_dir = $fallback_on_dev_dir;
							else $dev_dir = 'E:/EasyPHP/wordpress';

							if(file_exists($dev_dir.'/wp-load.php'))
								return $dev_dir.'/wp-load.php';
						}
					return ''; // Nadda.
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

					if(!file_exists($file))
						return $file;

					else if(!is_readable($file) || !is_writable($file))
						throw $this->©exception(
							__METHOD__.'#read_write_issues', compact('file'),
							$this->i18n('Expecting a readable/writable file (permission issues).').
							sprintf($this->i18n(' Got: `%1$s`.'), $file)
						);

					else if(filesize($file) > 1048576 * 2) // Two megabytes.
						{
							$path              = pathinfo($file);
							$path['extension'] = (!empty($path['extension'])) ? '.'.$path['extension'] : '';
							$archive_file      = $path['dirname'].'/'.$path['filename'].'-archived-'.time().$path['extension'];

							if(!is_readable($path['dirname']) || !is_writable($path['dirname']))
								throw $this->©exception(
									__METHOD__.'#read_write_issues', compact('file', 'path'),
									$this->i18n('Expecting a readable/writable directory to contain `$file`.').
									sprintf($this->i18n(' Got: `%1$s`.'), $path['dirname'])
								);

							else if(!rename($file, $archive_file))
								throw $this->©exception(
									__METHOD__.'#rename_failure', compact('file', 'path', 'archive_file'),
									$this->i18n('Unable to archive file. PHP `rename()` failure (FALSE return value).')
								);
						}
					return $file; // Reverberate ``$file``.
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
						if(file_exists($path = $_dir.'/'.$file) && is_readable($path))
							return $path;
					unset($_dir); // Housekeeping.

					throw $this->©exception(
						__METHOD__.'#file_missing', compact('file', 'dirs'),
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

					return strtolower(ltrim(strrchr(basename($file), '.'), '.'));
				}
		}
	}