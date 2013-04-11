<?php
/**
 * Stub: WebSharks™ Core.
 *
 * @note MUST remain PHP v5.2 compatible.
 *
 * Copyright: © 2013 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 130302
 */
# -----------------------------------------------------------------------------------------------------------------------------------------
# Only if the WebSharks™ Core stub class does NOT exist yet; (we don't care about WordPress® here yet).
# -----------------------------------------------------------------------------------------------------------------------------------------
if(!class_exists('websharks_core_v000000_dev'))
	{
		# -----------------------------------------------------------------------------------------------------------------------------------
		# WebSharks™ Core stub class definition.
		# -----------------------------------------------------------------------------------------------------------------------------------
		/**
		 * Stub: WebSharks™ Core class.
		 *
		 * @note MUST remain PHP v5.2 compatible.
		 *
		 * @package WebSharks\Core
		 * @since 130302
		 */
		final class websharks_core_v000000_dev // Static properties/methods only please.
		{
			# --------------------------------------------------------------------------------------------------------------------------------
			# Public properties (see also: bottom of this file).
			# --------------------------------------------------------------------------------------------------------------------------------
			# @TODO Go back through the entire WebSharks™ Core and use properties instead of hard-coding these values.

			/**
			 * WebSharks™ Core name.
			 *
			 * @var string WebSharks™ Core name.
			 */
			public static $core_name = 'WebSharks™ Core';

			/**
			 * WebSharks™ Core site.
			 *
			 * @var string WebSharks™ Core site.
			 */
			public static $core_site = 'http://www.websharks-inc.com';

			/**
			 * Local WordPress® development directory.
			 *
			 * @var string Local WordPress® development directory.
			 *
			 * @note For internal/development use only.
			 */
			public static $local_wp_dev_dir = 'E:/EasyPHP/wordpress';

			/**
			 * Local WebSharks™ Core repo directory.
			 *
			 * @var string Local WebSharks™ Core repo directory.
			 *
			 * @note For internal/development use only.
			 */
			public static $local_core_repo_dir = 'E:/WebSharks/core';

			/**
			 * WebSharks™ Core stub.
			 *
			 * @var string WebSharks™ Core stub.
			 */
			public static $core_ns_stub = 'websharks_core';

			/**
			 * WebSharks™ Core stub w/ dashes.
			 *
			 * @var string WebSharks™ Core stub w/ dashes.
			 */
			public static $core_ns_stub_with_dashes = 'websharks-core';

			/**
			 * WebSharks™ Core stub_v.
			 *
			 * @var string WebSharks™ Core stub_v.
			 */
			public static $core_ns_stub_v = 'websharks_core_v';

			/**
			 * WebSharks™ Core stub-v w/ dashes.
			 *
			 * @var string WebSharks™ Core stub-v w/ dashes.
			 */
			public static $core_ns_stub_v_with_dashes = 'websharks-core-v';

			/**
			 * WebSharks™ Core namespace.
			 *
			 * @var string WebSharks™ Core namespace.
			 */
			public static $core_ns = 'websharks_core_v000000_dev';

			/**
			 * WebSharks™ Core namespace w/ prefix.
			 *
			 * @var string WebSharks™ Core namespace w/ prefix.
			 */
			public static $core_ns_prefix = '\\websharks_core_v000000_dev';

			/**
			 * WebSharks™ Core namespace w/ dashes.
			 *
			 * @var string WebSharks™ Core namespace w/ dashes.
			 */
			public static $core_ns_with_dashes = 'websharks-core-v000000-dev';

			/**
			 * WebSharks™ Core namespace version.
			 *
			 * @var string WebSharks™ Core namespace version.
			 *
			 * @by-initializer Set by initializer.
			 */
			public static $core_ns_v = '';

			/**
			 * WebSharks™ Core namespace version w/ dashes.
			 *
			 * @var string WebSharks™ Core namespace version w/ dashes.
			 *
			 * @by-initializer Set by initializer.
			 */
			public static $core_ns_v_with_dashes = '';

			/**
			 * WebSharks™ Core namespace version w/ dashes.
			 *
			 * @var string WebSharks™ Core namespace version w/ dashes.
			 *
			 * @by-initializer Set by initializer.
			 */
			public static $core_version = '';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Protected properties (see also: bottom of this file).
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Initialized yet?
			 *
			 * @var boolean Initialized yet?
			 */
			protected static $initialized = FALSE;

			/**
			 * A static cache (for all instances).
			 *
			 * @var array A static cache (for all instances).
			 */
			protected static $static = array();

			# --------------------------------------------------------------------------------------------------------------------------------
			# Initializes WebSharks™ Core stub (see also: bottom of this file).
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Initializes WebSharks™ Core stub.
			 *
			 * @return boolean Returns the ``$initialized`` property w/ a TRUE value.
			 */
			public static function initialize()
				{
					if(self::$initialized)
						return TRUE; // Initialized already.

					self::$core_ns_v                               = str_replace(self::$core_ns_stub_v, '', self::$core_ns);
					self::$core_ns_v_with_dashes                   = self::$core_version = str_replace('_', '-', self::$core_ns_v);
					self::$regex_valid_core_ns_version             = str_replace('%%self::$core_ns_stub_v%%', preg_quote(self::$core_ns_stub_v, '/'), self::$regex_valid_core_ns_version);
					self::$regex_valid_core_ns_version_with_dashes = str_replace('%%self::$core_ns_stub_v_with_dashes%%', preg_quote(self::$core_ns_stub_v_with_dashes, '/'), self::$regex_valid_core_ns_version_with_dashes);
					/*
					 * Easier access for those who DON'T CARE about the version (PHP v5.3+ only).
					 */
					if(!class_exists(self::$core_ns_stub.'__stub') && function_exists('class_alias') /* PHP v5.3+ only. */)
						class_alias(__CLASS__, self::$core_ns_stub.'__stub');

					return (self::$initialized = TRUE);
				}

			# --------------------------------------------------------------------------------------------------------------------------------
			# Routines related to PHAR/autoload conditionals.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Global PHAR variable for the WebSharks™ Core.
			 *
			 * @return string The PHAR variable for the WebSharks™ Core.
			 */
			public static function is_phar_var()
				{
					return 'is_phar_'.self::$core_ns;
				}

			/**
			 * Global autoload var for the WebSharks™ Core.
			 *
			 * @return string Autoload var for the WebSharks™ Core.
			 */
			public static function autoload_var()
				{
					return 'autoload_'.self::$core_ns;
				}

			/**
			 * This file is a PHP Archive?
			 *
			 * @return string A PHP Archive file?
			 */
			public static function is_phar()
				{
					$is_phar_var = self::is_phar_var();

					if(!empty($GLOBALS[$is_phar_var]) && $GLOBALS[$is_phar_var] === 'phar://'.__FILE__)
						return $GLOBALS[$is_phar_var];

					return '';
				}

			/**
			 * Php Archives are possible?
			 *
			 * @return boolean Php Archives are possible?
			 */
			public static function can_phar()
				{
					if(isset(self::$static['can_phar']))
						return self::$static['can_phar'];

					self::$static['can_phar'] = extension_loaded('phar');

					if(self::$static['can_phar'] && extension_loaded('suhosin'))
						if(stripos(ini_get('suhosin.executor.include.whitelist'), 'phar') === FALSE)
							self::$static['can_phar'] = FALSE;

					return self::$static['can_phar'];
				}

			/**
			 * A webPhar instance?
			 *
			 * @return boolean A webPhar instance?
			 */
			public static function is_webphar()
				{
					if(defined('WPINC'))
						return FALSE;

					$is_phar = $phar = self::is_phar();

					if($is_phar && !empty($_SERVER['SCRIPT_FILENAME']) && is_string($_SERVER['SCRIPT_FILENAME']))
						if(realpath($_SERVER['SCRIPT_FILENAME']) === realpath(substr($phar, 7)))
							return TRUE;

					return FALSE;
				}

			/**
			 * Autoload WebSharks™ Core?
			 *
			 * @return boolean Autoload WebSharks™ Core?
			 */
			public static function is_autoload()
				{
					if(self::is_webphar())
						return FALSE;

					$autoload_var = self::autoload_var();

					if(!isset($GLOBALS[$autoload_var]) || $GLOBALS[$autoload_var])
						return TRUE;

					return FALSE;
				}

			# --------------------------------------------------------------------------------------------------------------------------------
			# Routines that locate WordPress®.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Attempts to locate `/wp-load.php`.
			 *
			 * @param boolean             $get_last_value Defaults to a FALSE value.
			 *    This function stores it's last return value for quicker access on repeated calls.
			 *    If this is TRUE; no search will take place. We simply return the last/previous value.
			 *
			 * @param boolean             $check_abspath Defaults to TRUE (recommended).
			 *    If TRUE, we will first check the `ABSPATH` constant (if defined) for `/wp-load.php`.
			 *
			 * @param null|boolean|string $fallback Defaults to NULL (recommended).
			 *
			 *    • If NULL, and WordPress® cannot be located anywhere else;
			 *       and `___DEV_KEY_OK` is TRUE; automatically fallback on a local development copy.
			 *
			 *    • If TRUE, and WordPress® cannot be located anywhere else;
			 *       automatically fallback on a local development copy.
			 *
			 *    • If NULL|TRUE, we'll look inside: ``self::$local_wp_dev_dir`` (a default WebSharks™ Core location).
			 *       If STRING, we'll look inside the directory path defined by the string value.
			 *
			 *    • If FALSE — we will NOT fallback under any circumstance.
			 *
			 * @return string Full server path to `/wp-load.php` on success, else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public static function wp_load($get_last_value = FALSE, $check_abspath = TRUE, $fallback = NULL)
				{
					if(!is_bool($get_last_value) || !is_bool($check_abspath) || !(is_null($fallback) || is_bool($fallback) || is_string($fallback)))
						throw new exception( // Fail here; detected invalid arguments.
							sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					if($get_last_value && isset(self::$static['wp_load']))
						return self::$static['wp_load'];

					if($check_abspath && defined('ABSPATH') && is_file($_wp_load = ABSPATH.'wp-load.php'))
						return (self::$static['wp_load'] = self::n_dir_seps($_wp_load));

					if(($_wp_load = self::locate('/wp-load.php')))
						return (self::$static['wp_load'] = $_wp_load);

					if(!isset($fallback)) // Auto-detection.
						$fallback = defined('___DEV_KEY_OK');

					if($fallback) // Fallback on local dev copy?
						{
							if(is_string($fallback))
								$dev_dir = self::n_dir_seps($fallback);
							else $dev_dir = self::n_dir_seps(self::$local_wp_dev_dir);

							if(is_file($_wp_load = $dev_dir.'/wp-load.php'))
								return (self::$static['wp_load'] = $_wp_load);
						}
					unset($_wp_load); // Housekeeping.

					return (self::$static['wp_load'] = ''); // Failure.
				}

			# --------------------------------------------------------------------------------------------------------------------------------
			# Routines that locate class files.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Gets WebSharks™ Core `deps.php` class file path.
			 *
			 * @param boolean $enable_display_errors This is TRUE by default.
			 *    If TRUE, we will make sure any exceptions are displayed on-screen.
			 *    We assume (by default); that if dependency utilities CANNOT be loaded up;
			 *    we need to force a display that indicates the reason why.
			 *
			 * @note If we CANNOT load dependency utilities; something MUST be said to a site owner.
			 *    If `error_reporting` hides or log exceptions, this important dependency may never be known.
			 *    Dependency utilities are what we use to address common issues. If they CANNOT be loaded up;
			 *    we have a BIG problem here; and the site owner MUST be made aware of that issue.
			 *
			 * @return string Absolute path to WebSharks™ Core `deps.php` class file.
			 *
			 * @throws exception If unable to locate the WebSharks™ Core `deps.php` class file.
			 */
			public static function deps($enable_display_errors = TRUE)
				{
					if(!is_bool($enable_display_errors))
						throw new exception( // Fail here; detected invalid arguments.
							sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					try // Any exceptions will be re-thrown below.
						{
							return self::locate_core_ns_class_file('deps.php');
						}
					catch(exception $exception) // Now re-throw.
						{
							if($enable_display_errors)
								{
									error_reporting(-1);
									ini_set('display_errors', TRUE);
								}
							throw $exception;
						}
				}

			/**
			 * Gets WebSharks™ Core `framework.php` class file path.
			 *
			 * @return string Absolute path to WebSharks™ Core `framework.php` class file.
			 *
			 * @throws exception If unable to locate the WebSharks™ Core `framework.php` class file.
			 */
			public static function framework()
				{
					return self::locate_core_ns_class_file('framework.php');
				}

			/**
			 * Gets a WebSharks™ Core class file (absolute path).
			 *
			 * @param string $class_file_basename Class file (basename only please).
			 *    Ex: `class.php`; or `sub-namespace/class.php` is OK too.
			 *
			 * @return string Absolute path to the requested ``$class_file_basename``.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$class_file_basename`` is empty; or it is NOT a string value.
			 * @throws exception If unable to locate the WebSharks™ Core ``$class_file_basename``.
			 *
			 * @note It's VERY important that we obtain class file paths for THIS version of the WebSharks™ Core.
			 *    This is accomplished by looking for classes along a path which includes this WebSharks™ Core namespace.
			 */
			public static function locate_core_ns_class_file($class_file_basename)
				{
					if(!is_string($class_file_basename) || !($class_file_basename = trim(self::n_dir_seps($class_file_basename), '/')))
						throw new exception( // Fail here; detected invalid arguments.
							sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					$this_dir                     = self::n_dir_seps(dirname(__FILE__));
					$local_core_repo_dir_basename = basename(self::$local_core_repo_dir);
					$is_phar                      = $this_phar = self::n_dir_seps(self::is_phar());

					$locate_core_dir      = '/'.self::$core_ns_stub_with_dashes;
					$locate_core_phar     = '/'.self::$core_ns_stub_with_dashes.'.php.phar';
					$locate_core_dev_dir  = '/'.$local_core_repo_dir_basename.'/'.self::$core_ns_stub_with_dashes;
					$locate_core_dev_phar = '/'.$local_core_repo_dir_basename.'/'.self::$core_ns_stub_with_dashes.'.php.phar';
					$relative_class_path  = 'classes/'.self::$core_ns_with_dashes.'/'.$class_file_basename;

					if(is_file($class_path = $this_dir.'/'.$relative_class_path))
						return $class_path; // We first check this directory.

					if(($class_path = self::locate($locate_core_dir.'/'.$relative_class_path)))
						return $class_path; // Sitewide (or nearest) WebSharks™ Core.

					if($is_phar && self::can_phar() && is_file($class_path = $this_phar.'/'.$relative_class_path))
						return $class_path; // If this is a PHAR (and PHAR is possible); we can use this archive.

					if(self::can_phar() && ($class_path = self::locate($locate_core_phar.'/'.$relative_class_path, 'phar://')))
						return $class_path; // Sitewide (or nearest) WebSharks™ Core archive (if possible).

					if(defined('___DEV_KEY_OK') && ($class_path = self::locate($locate_core_dev_dir.'/'.$relative_class_path)))
						return $class_path; // Development copy (for authenticated developers).

					if(defined('___DEV_KEY_OK') && ($class_path = self::locate($locate_core_dev_phar.'/'.$relative_class_path, 'phar://')))
						return $class_path; // Development copy (for authenticated developers).

					// Upon failure, we can make an attempt to notify site owners about PHAR compatibility.
					$has_phar = ($is_phar || self::locate($locate_core_phar) || self::locate($locate_core_dev_phar));

					// The error is actually displayed in the WordPress® Dashboard this way :-)
					if($class_file_basename === 'deps.php' && $has_phar && !self::can_phar() && defined('WPINC'))
						if(($class_path = self::cant_phar_msg_notice_in_wp_temp_deps()))
							return $class_path; // Temporary file.

					if($has_phar && !self::can_phar())
						throw new exception(self::cant_phar_msg());

					throw new exception(sprintf(self::i18n('Unable to locate: `%1$s`.'), $locate_core_dir.'/'.$relative_class_path));
				}

			# --------------------------------------------------------------------------------------------------------------------------------
			# Routines that help handle webPhar instances.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * WebSharks™ Core webPhar rewriter.
			 *
			 * @param string $uri_or_path_info Passed in by webPhar.
			 *    The ``$uri`` is either ``$_SERVER['REQUEST_URI']`` or ``$_SERVER['PATH_INFO']``.
			 *    See: {@link http://docs.php.net/manual/en/phar.webphar.php}.
			 *
			 * @note We ignore ``$uri_or_path_info`` from webPhar.
			 *    We determine this on our own; hopefully more effectively.
			 *
			 * @return string|boolean Boolean An internal URI; else FALSE if denying access.
			 *    A FALSE return value causes webPhar to issue a 403 forbidden response.
			 *
			 * @throws exception If this is NOT a PHAR file (which really should NOT happen).
			 * @throws exception If the PHAR extension is not possible for any reason.
			 */
			public static function web_phar_rewriter($uri_or_path_info)
				{
					// Current PHAR file w/stream prefix.

					$is_phar = $phar = self::n_dir_seps(self::is_phar());

					if(!$is_phar) // A couple of quick sanity checks.
						throw new exception(self::i18n('This is NOT a PHAR file.'));
					if(!self::can_phar()) throw new exception(self::cant_phar_msg());

					$phar_dir = dirname($phar); // Need this below.

					// Determine path info.

					if(!empty($_SERVER['PATH_INFO']))
						$path_info = (string)$_SERVER['PATH_INFO'];

					else if(function_exists('apache_lookup_uri') && !empty($_SERVER['REQUEST_URI']))
						{
							$_apache_lookup = apache_lookup_uri((string)$_SERVER['REQUEST_URI']);

							if(!empty($_apache_lookup->path_info))
								$path_info = (string)$_apache_lookup->path_info;

							unset($_apache_lookup); // Housekeeping.
						}
					$path_info = (!empty($path_info)) ? $path_info : '/'.basename(__FILE__);

					// Normalize directory separators; and force a leading slash on all internal URIs.
					// We allow a trailing slash; so it's easier to parse directory indexes.

					$internal_uri = self::n_dir_seps($path_info, TRUE);
					$internal_uri = '/'.ltrim($internal_uri, '/');

					if(substr($internal_uri, -1) === '/') // Directory.
						$internal_uri = rtrim($internal_uri, '\\/').'/index.php';

					$internal_uri_basename  = basename($internal_uri);
					$internal_uri_extension = self::extension($internal_uri);

					// Here we'll try to make webPhar a little more security-conscious.

					if(strpos($internal_uri, '..') !== FALSE)
						return FALSE; // Do NOT allow relative dots; 403 (forbidden).

					if(strpos($internal_uri_basename, '.') === 0)
						return FALSE; // Do NOT serve DOT files; 403 (forbidden).

					if(substr($internal_uri_basename, -1) === '~')
						return FALSE; // Do NOT serve backups; 403 (forbidden).

					for($_i = 0, $_dir = dirname($phar.$internal_uri); $_i <= 100; $_i++)
						{
							if($_i > 0 && $_dir === $phar_dir)
								break; // Search complete now.

							if($_i > 0) $_dir = dirname($_dir);
							if(!$_dir || $_dir === '.' || strcasecmp($_dir, 'phar:') === 0)
								break; // Search complete now.

							// Base directory scans.

							$_dir_basename = basename($_dir);

							if(strpos($_dir_basename, '.') === 0)
								return FALSE; // Dotted; 403 (forbidden).

							if(substr($_dir_basename, -1) === '~')
								return FALSE; // Backup dir; 403 (forbidden).

							// Windows® IIS compatibility.

							if(strcasecmp($_dir_basename, 'app_data') === 0)
								return FALSE; // Private; 403 (forbidden).

							// Apache™ compatibility.

							if(!is_file($_dir.'/.htaccess'))
								continue; // Nothing more to do here.

							if(!is_readable($_dir.'/.htaccess'))
								return FALSE; // Unreadable; 403 (forbidden).

							if(stripos(file_get_contents($_dir.'/.htaccess'), 'deny from all') !== FALSE)
								return FALSE; // Private; 403 (forbidden).
						}
					unset($_i, $_dir, $_dir_basename);

					// Process MIME-type headers.

					$mime_types           = self::mime_types();
					$cacheable_mime_types = self::cacheable_mime_types();

					if($internal_uri_extension && !empty($mime_types[$internal_uri_extension]))
						header('Content-Type: '.$mime_types[$internal_uri_extension]);

					// Handle cacheable MIME-types.

					if(!empty($cacheable_mime_types[$internal_uri_extension]))
						{
							header('Expires: '.gmdate('D, d M Y H:i:s', strtotime('+1 year')).' GMT');
							header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
							header('Cache-Control: max-age='.(86400 * 365));
							header('Pragma: public');
						}
					return $internal_uri; // Final value (internal URI).
				}

			/**
			 * A map of MIME types (for webPhar).
			 *
			 * @return array A map of MIME types (for webPhar).
			 *    With flags for PHP execution & hiliting.
			 *
			 * @note Anything compressable needs to be parsed as PHP;
			 *    so webPhar will decompress it when serving.
			 *
			 * @note Source file extensions (i.e. code sample extensions);
			 *    are marked for automatic syntax hiliting by webPhar.
			 *
			 * @throws exception If PHAR extension not possible.
			 */
			public static function web_phar_mime_types()
				{
					if(isset(self::$static['web_phar_mime_types']))
						return self::$static['web_phar_mime_types'];

					if(!self::can_phar()) // Not possible.
						throw new exception(self::cant_phar_msg());

					$mime_types = self::mime_types();

					foreach(self::compressable_mime_types() as $_extension => $_type)
						$mime_types[$_extension] = Phar::PHP;
					unset($_extension, $_type); // Housekeeping.

					$mime_types['phps'] = Phar::PHPS; // Source file.

					return (self::$static['web_phar_mime_types'] = $mime_types);
				}

			# --------------------------------------------------------------------------------------------------------------------------------
			# MIME-type routines.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Textual MIME types.
			 *
			 * @return array Textual MIME types.
			 *    Those with a `text/` MIME type or `charset=UTF-8` specification.
			 *
			 * @note Some files do NOT have a `text/` MIME type or `charset=UTF-8` specification.
			 *    However, they ARE still textual. Such as: `svg`, `bat`, `sh` files.
			 */
			public static function textual_mime_types()
				{
					if(isset(self::$static['textual_mime_types']))
						return self::$static['textual_mime_types'];

					$other_textual_extensions = array('svg', 'bat', 'sh');

					foreach(($mime_types = self::mime_types()) as $_extension => $_type)
						if(stripos($_type, 'text/') === 0 ||
						   stripos($_type, 'charset=UTF-8') !== FALSE ||
						   in_array($_extension, $other_textual_extensions, TRUE)
						) continue; // It's textual in this case.
						else unset($mime_types[$_extension]);
					unset($_extension, $_type);

					return (self::$static['textual_mime_types'] = $mime_types);
				}

			/**
			 * Compressable MIME types.
			 *
			 * @return array Compressable MIME types.
			 *
			 * @note Any textual MIME type is compressable.
			 */
			public static function compressable_mime_types()
				{
					if(isset(self::$static['compressable_mime_types']))
						return self::$static['compressable_mime_types'];

					$mime_types = self::textual_mime_types();

					return (self::$static['compressable_mime_types'] = $mime_types);
				}

			/**
			 * Binary MIME types.
			 *
			 * @return array Binary MIME types.
			 *
			 * @note Any MIME type which is NOT textual; is considered binary.
			 */
			public static function binary_mime_types()
				{
					if(isset(self::$static['binary_mime_types']))
						return self::$static['binary_mime_types'];

					$mime_types         = self::mime_types();
					$textual_mime_types = self::textual_mime_types();
					$mime_types         = array_diff_assoc($mime_types, $textual_mime_types);

					return (self::$static['binary_mime_types'] = $mime_types);
				}

			/**
			 * Cacheable extensions.
			 *
			 * @return array Those we make cacheable.
			 *
			 * @note Only dynamic files (like PHP scripts) are uncacheable.
			 */
			public static function cacheable_mime_types()
				{
					if(isset(self::$static['cacheable_mime_types']))
						return self::$static['cacheable_mime_types'];

					$mime_types = self::mime_types();
					$m          =& $mime_types; // Shorter reference.

					// Remove dynamic scripts (NOT cacheable).
					unset($m['php'], $m['php4'], $m['php5'], $m['php6']);
					unset($m['asp'], $m['aspx']);
					unset($m['cgi'], $m['pl']);

					return (self::$static['cacheable_mime_types'] = $mime_types);
				}

			/**
			 * A map of MIME types (for headers).
			 *
			 * @return array A map of MIME types (for headers).
			 *
			 * @note This list is grouped logically according to the nature of certain files.
			 *    It is then ordered alphabetically within each group of files.
			 *
			 * @note This should always be synchronized with our `.gitattributes` file.
			 */
			public static function mime_types()
				{
					$utf8 = '; charset=UTF-8';

					if(isset(self::$static['mime_types']))
						return self::$static['mime_types'];

					return (self::$static['mime_types'] = array(

						// Text files.
						'md'              => 'text/plain'.$utf8,
						'txt'             => 'text/plain'.$utf8,

						// Log files.
						'log'             => 'text/plain'.$utf8,

						// Translation files.
						'pot'             => 'text/plain'.$utf8,

						// SQL files.
						'sql'             => 'text/plain'.$utf8,
						'sqlite'          => 'text/plain'.$utf8,

						// Template files.
						'tmpl'            => 'text/plain'.$utf8,
						'tpl'             => 'text/plain'.$utf8,

						// Server config files.
						'admins'          => 'text/plain'.$utf8,
						'cfg'             => 'text/plain'.$utf8,
						'conf'            => 'text/plain'.$utf8,
						'htaccess'        => 'text/plain'.$utf8,
						'htaccess-apache' => 'text/plain'.$utf8,
						'htpasswd'        => 'text/plain'.$utf8,
						'ini'             => 'text/plain'.$utf8,

						// CSS/JavaScript files.
						'css'             => 'text/css'.$utf8,
						'js'              => 'application/x-javascript'.$utf8,
						'json'            => 'application/json'.$utf8,

						// PHP scripts/files.
						'inc'             => 'text/html'.$utf8,
						'php'             => 'text/html'.$utf8,
						'php4'            => 'text/html'.$utf8,
						'php5'            => 'text/html'.$utf8,
						'php6'            => 'text/html'.$utf8,
						'phps'            => 'text/html'.$utf8,
						'x-php'           => 'text/plain'.$utf8,
						'php~'            => 'text/plain'.$utf8,

						// ASP scripts/files.
						'asp'             => 'text/html'.$utf8,
						'aspx'            => 'text/html'.$utf8,

						// Perl scripts/files.
						'cgi'             => 'text/html'.$utf8,
						'pl'              => 'text/html'.$utf8,

						// HTML/XML files.
						'dtd'             => 'application/xml-dtd'.$utf8,
						'hta'             => 'application/hta'.$utf8,
						'htc'             => 'text/x-component'.$utf8,
						'htm'             => 'text/html'.$utf8,
						'html'            => 'text/html'.$utf8,
						'shtml'           => 'text/html'.$utf8,
						'xhtml'           => 'application/xhtml+xml'.$utf8,
						'xml'             => 'text/xml'.$utf8,
						'xsl'             => 'application/xslt+xml'.$utf8,
						'xslt'            => 'application/xslt+xml'.$utf8,
						'xsd'             => 'application/xsd+xml'.$utf8,

						// Document files.
						'csv'             => 'text/csv'.$utf8,
						'doc'             => 'application/msword',
						'docx'            => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
						'odt'             => 'application/vnd.oasis.opendocument.text',
						'pdf'             => 'application/pdf',
						'rtf'             => 'application/rtf',
						'xls'             => 'application/vnd.ms-excel',

						// Image/animation files.
						'ai'              => 'image/vnd.adobe.illustrator',
						'blend'           => 'application/x-blender',
						'bmp'             => 'image/bmp',
						'eps'             => 'image/eps',
						'fla'             => 'application/vnd.adobe.flash',
						'gif'             => 'image/gif',
						'ico'             => 'image/x-icon',
						'jpe'             => 'image/jpeg',
						'jpeg'            => 'image/jpeg',
						'jpg'             => 'image/jpeg',
						'png'             => 'image/png',
						'psd'             => 'image/vnd.adobe.photoshop',
						'pspimage'        => 'image/vnd.corel.psp',
						'svg'             => 'image/svg+xml',
						'swf'             => 'application/x-shockwave-flash',
						'tif'             => 'image/tiff',
						'tiff'            => 'image/tiff',

						// Audio files.
						'mid'             => 'audio/midi',
						'midi'            => 'audio/midi',
						'mp3'             => 'audio/mp3',
						'wav'             => 'audio/wav',
						'wma'             => 'audio/x-ms-wma',

						// Video files.
						'avi'             => 'video/avi',
						'flv'             => 'video/x-flv',
						'ogg'             => 'video/ogg',
						'ogv'             => 'video/ogg',
						'mp4'             => 'video/mp4',
						'mov'             => 'movie/quicktime',
						'mpg'             => 'video/mpeg',
						'mpeg'            => 'video/mpeg',
						'qt'              => 'video/quicktime',
						'webm'            => 'video/webm',
						'wmv'             => 'audio/x-ms-wmv',

						// Font files.
						'eot'             => 'application/vnd.ms-fontobject',
						'otf'             => 'application/x-font-otf',
						'ttf'             => 'application/x-font-ttf',
						'woff'            => 'application/x-font-woff',

						// Archive files.
						'7z'              => 'application/x-7z-compressed',
						'dmg'             => 'application/x-apple-diskimage',
						'gtar'            => 'application/x-gtar',
						'gz'              => 'application/gzip',
						'iso'             => 'application/iso-image',
						'jar'             => 'application/java-archive',
						'phar'            => 'application/php-archive',
						'rar'             => 'application/x-rar-compressed',
						'tar'             => 'application/x-tar',
						'tgz'             => 'application/x-gtar',
						'zip'             => 'application/zip',

						// Other misc files.
						'bat'             => 'application/octet-stream',
						'bin'             => 'application/octet-stream',
						'class'           => 'application/octet-stream',
						'com'             => 'application/octet-stream',
						'dll'             => 'application/octet-stream',
						'exe'             => 'application/octet-stream',
						'sh'              => 'application/octet-stream',
						'so'              => 'application/octet-stream'
					));
				}

			# --------------------------------------------------------------------------------------------------------------------------------
			# Miscellaneous utility routines.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Gets a file extension (lowercase).
			 *
			 * @param string $file A file path, or just a file name.
			 *
			 * @return string File extension (lowercase).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public static function extension($file)
				{
					if(!is_string($file) || !$file)
						throw new exception( // Fail here; detected invalid arguments.
							sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					return strtolower(ltrim((string)strrchr(basename($file), '.'), '.'));
				}

			/**
			 * Attempts to find a readable/writable temporary directory.
			 *
			 * @return string Readable/writable temp directory; else an empty string.
			 */
			public static function get_temp_dir()
				{
					if(defined('WPINC') && ($wp_temp_dir = get_temp_dir())
					   && ($wp_temp_dir = realpath($wp_temp_dir))
					   && is_readable($wp_temp_dir) && is_writable($wp_temp_dir)
					) return self::n_dir_seps($wp_temp_dir);

					if(($sys_temp_dir = sys_get_temp_dir())
					   && ($sys_temp_dir = realpath($sys_temp_dir))
					   && is_readable($sys_temp_dir) && is_writable($sys_temp_dir)
					) return self::n_dir_seps($sys_temp_dir);

					if(($upload_temp_dir = ini_get('upload_tmp_dir'))
					   && ($upload_temp_dir = realpath($upload_temp_dir))
					   && is_readable($upload_temp_dir) && is_writable($upload_temp_dir)
					) return self::n_dir_seps($upload_temp_dir);

					$is_windows = (stripos(PHP_OS, 'win') === 0);

					if($is_windows && (is_dir('C:/Temp') || @mkdir('C:/Temp', 0775))
					   && is_readable('C:/Temp') && is_writable('C:/Temp')
					) return self::n_dir_seps('C:/Temp');

					if(!$is_windows && (is_dir('/tmp') || @mkdir('/tmp', 0775))
					   && is_readable('/tmp') && is_writable('/tmp')
					) return self::n_dir_seps('/tmp');

					return ''; // Failure.
				}

			/**
			 * Normalizes directory separators.
			 *
			 * @param string  $path Directory or file path.
			 *
			 * @param boolean $allow_trailing_slash Defaults to FALSE.
			 *    If TRUE; and ``$path`` contains a trailing slash; we'll leave it there.
			 *
			 * @return string Normalized directory or file path.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public static function n_dir_seps($path, $allow_trailing_slash = FALSE)
				{
					if(!is_string($path) || !is_bool($allow_trailing_slash))
						throw new exception( // Fail here; detected invalid arguments.
							sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					if(!strlen($path)) return ''; // Catch empty strings.

					preg_match('/^(?P<scheme>[a-z]+\:\/\/)/i', $path, $_path);
					$path = (!empty($_path['scheme'])) ? str_ireplace($_path['scheme'], '', $path) : $path;

					$path = preg_replace('/\/+/', '/', str_replace(array(DIRECTORY_SEPARATOR, '\\', '/'), '/', $path));
					$path = ($allow_trailing_slash) ? $path : rtrim($path, '/');

					$path = (!empty($_path['scheme'])) ? strtolower($_path['scheme']).$path : $path; // Lowercase.

					return $path; // Normalized now.
				}

			/**
			 * Locates a specific directory/file path.
			 *
			 * @param string $dir_file A specific directory/file path.
			 *
			 * @param string $starting_dir Optional. A specific directory to start searching from.
			 *    `__DIR__` is NOT PHP v5.2 compatible; so we use a string value and convert it dynamically.
			 *    Defaults to the directory of this file (e.g. `'__DIR__'`).
			 *
			 * @return string Directory/file path (if found); else an empty string.
			 *    The search will continue until there are no more directories to search through.
			 *    However, there is an upper limit of 100 directories maximum.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$dir_file`` or ``$starting_dir`` are empty.
			 */
			public static function locate($dir_file, $starting_dir = '__DIR__')
				{
					if(!is_string($dir_file) || !$dir_file || !is_string($starting_dir) || !$starting_dir)
						throw new exception( // Fail here; detected invalid arguments.
							sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					$dir_file     = ltrim(self::n_dir_seps($dir_file), '/');
					$starting_dir = ($starting_dir === '__DIR__') ? dirname(__FILE__) : $starting_dir;
					$starting_dir = ($starting_dir === 'phar://') ? 'phar://'.dirname(__FILE__) : $starting_dir;
					$starting_dir = self::n_dir_seps($starting_dir);

					for($_i = 0, $_dir = $starting_dir; $_i <= 100; $_i++)
						{
							if($_i > 0) $_dir = dirname($_dir);
							if(!$_dir || $_dir === '.' || strcasecmp($_dir, 'phar:') === 0)
								break; // Search complete now.

							if(is_file($_dir.'/'.$dir_file))
								return $_dir.'/'.$dir_file;
						}
					unset($_i, $_dir); // Housekeeping.

					return ''; // Failure.
				}

			/**
			 * Is the current User-Agent a browser?
			 * This checks only for the most common browser engines.
			 *
			 * @return boolean TRUE if the current User-Agent is a browser, else FALSE.
			 */
			public static function is_browser()
				{
					if(!isset(self::$static['is_browser']))
						{
							self::$static['is_browser'] = FALSE;

							$regex = '/(?:msie|trident|gecko|webkit|presto|konqueror|playstation)[\/\s]+[0-9]/i';

							if(!empty($_SERVER['HTTP_USER_AGENT']) && is_string($_SERVER['HTTP_USER_AGENT']))
								if(preg_match($regex, $_SERVER['HTTP_USER_AGENT']))
									self::$static['is_browser'] = TRUE;
						}
					return self::$static['is_browser'];
				}

			# --------------------------------------------------------------------------------------------------------------------------------
			# Dynamic error messages.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Regarding an inability to locate `/wp-load.php`.
			 *
			 * @param boolean $markdown Defaults to a FALSE value.
			 *    If this is TRUE; we'll parse some basic markdown syntax to
			 *    produce HTML output that is easier to read in a browser.
			 *
			 * @return string Error message w/ details about the `/wp-load.php` file.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public static function no_wp_msg($markdown = FALSE)
				{
					if(!is_bool($markdown))
						throw new exception( // Fail here; detected invalid arguments.
							sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					$msg = sprintf(self::i18n('Unable to load the %1$s. WordPress® (a core dependency) is NOT loaded up yet.'.
					                          ' Please include WordPress® in your scripts using: `require_once \'wp-load.php\';`.'), self::$core_name);

					if($markdown) $msg = nl2br(preg_replace('/`(.*?)`/', '<code>'.'${1}'.'</code>', $msg), TRUE);

					return $msg; // Final message.
				}

			/**
			 * Regarding a lack of support for Php Archives.
			 *
			 * @param boolean $markdown Defaults to a FALSE value.
			 *    If this is TRUE; we'll parse some basic markdown syntax to
			 *    produce HTML output that is easier to read in a browser.
			 *
			 * @see \websharks_core_v000000_dev\cant_phar_msg_notice_in_ws_wp_temp_deps()
			 *
			 * @return string Error message w/ details about the `Phar` class and PHP v5.3+.
			 *    This error message will also include details about Suhosin; when/if applicable.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If an inappropriate call is made (really should NOT happen).
			 */
			public static function cant_phar_msg($markdown = FALSE)
				{
					if(!is_bool($markdown))
						throw new exception( // Fail here; detected invalid arguments.
							sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					if(self::can_phar())
						throw new exception( // Fail here; we should NOT have called this.
							sprintf(self::i18n('Inappropriate call to: `%1$s`'), __METHOD__)
						);
					$msg = sprintf(self::i18n('Unable to load the %1$s. This installation of PHP is missing the `Phar` extension.'.
					                          ' The %1$s (and WordPress® plugins powered by it); requires PHP v5.3+ — which has `Phar` built-in.'.
					                          ' Please upgrade to PHP v5.3 (or higher) to get rid of this message.'), self::$core_name);

					$can_phar              = extension_loaded('phar');
					$suhosin_running       = extension_loaded('suhosin');
					$suhosin_blocking_phar = ($suhosin_running && stripos(ini_get('suhosin.executor.include.whitelist'), 'phar') === FALSE);

					if($suhosin_running && $suhosin_blocking_phar) // Be verbose.
						{
							$verbose = ($can_phar) ? self::i18n('THE PROBLEM') : self::i18n('ALSO');
							$msg .= "\n\n".sprintf(self::i18n('%1$s: On your installation the `Phar` extension needs to be ENABLED by adding'.
							                                  ' the following line to your `php.ini` file: `suhosin.executor.include.whitelist = phar`.'.
							                                  ' If you need assistance, please contact your hosting company about this message.'), $verbose);
						}
					if($markdown) $msg = nl2br(preg_replace('/`(.*?)`/', '<code>'.'${1}'.'</code>', $msg), TRUE);

					return $msg; // Final message.
				}

			/**
			 * Regarding a lack of support for PHP Archives.
			 *
			 * Creates a temporary deps class & returns absolute path to that class file.
			 *    This can ONLY be used if we're within WordPress®; because it attaches
			 *    itself to a WordPress® administrative notice.
			 *
			 * @see \websharks_core_v000000_dev::$wp_temp_deps
			 *
			 * @return string Absolute path to temporary deps; else an empty string if NOT possible.
			 *
			 * @throws exception If an inappropriate call is made (really should NOT happen).
			 */
			public static function cant_phar_msg_notice_in_wp_temp_deps()
				{
					if(!defined('WPINC') || self::can_phar())
						throw new exception( // Fail here; we should NOT have called this.
							sprintf(self::i18n('Inappropriate call to: `%1$s`'), __METHOD__)
						);
					if(($temp_dir = self::get_temp_dir()))
						{
							$temp_deps          = $temp_dir.'/wp-temp-deps.tmp';
							$temp_deps_contents = base64_decode(self::$wp_temp_deps);
							$temp_deps_contents = str_ireplace(self::$core_ns_stub_v.'000000_dev', self::$core_ns, $temp_deps_contents);
							$temp_deps_contents = str_ireplace('%%notice%%', str_replace("'", "\\'", self::cant_phar_msg(TRUE)), $temp_deps_contents);

							if(!is_file($temp_deps) || (is_writable($temp_deps) && unlink($temp_deps)))
								if(file_put_contents($temp_deps, $temp_deps_contents))
									return $temp_deps;
						}
					return ''; // Failure.
				}

			# --------------------------------------------------------------------------------------------------------------------------------
			# Translation routines.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Handles core translations for this class (context: admin-side).
			 *
			 * @param string $string String to translate.
			 *
			 * @param string $other_contextuals Optional. Other contextual slugs relevant to this translation.
			 *    Contextual slugs normally follow the standard of being written with dashes.
			 *
			 * @return string Translated string.
			 */
			public static function i18n($string, $other_contextuals = '')
				{
					$string            = (string)$string; // Typecasting this to a string value.
					$other_contextuals = (string)$other_contextuals; // Typecasting this to a string value.
					$context           = self::$core_ns_stub_with_dashes.'--admin-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

					return (defined('WPINC')) ? _x($string, $context, self::$core_ns_stub_with_dashes) : $string;
				}

			/**
			 * Handles core translations for this class (context: front-side).
			 *
			 * @param string $string String to translate.
			 *
			 * @param string $other_contextuals Optional. Other contextual slugs relevant to this translation.
			 *    Contextual slugs normally follow the standard of being written with dashes.
			 *
			 * @return string Translated string.
			 */
			public static function translate($string, $other_contextuals = '')
				{
					$string            = (string)$string; // Typecasting this to a string value.
					$other_contextuals = (string)$other_contextuals; // Typecasting this to a string value.
					$context           = self::$core_ns_stub_with_dashes.'--front-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

					return (defined('WPINC')) ? _x($string, $context, self::$core_ns_stub_with_dashes) : $string;
				}

			# --------------------------------------------------------------------------------------------------------------------------------
			# Additional properties (see also: top of this file).
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * Regarding a lack of support for Php Archives.
			 *
			 * WebSharks™ temporary WP deps class (base64 encoded).
			 *
			 * @see \websharks_core_v000000_dev\cant_phar_msg_notice_in_ws_wp_temp_deps()
			 *
			 * @var string Base64 encoded version of `/includes/deps.tmp` in WebSharks™ Core.
			 */
			public static $wp_temp_deps = 'PD9waHANCmlmKCFkZWZpbmVkKCdXUElOQycpKQ0KCWV4aXQoJ0RvIE5PVCBhY2Nlc3MgdGhpcyBmaWxlIGRpcmVjdGx5OiAnLmJhc2VuYW1lKF9fRklMRV9fKSk7DQoNCmlmKCFjbGFzc19leGlzdHMoJ2RlcHNfd2Vic2hhcmtzX2NvcmVfdjAwMDAwMF9kZXYnKSkNCgl7DQoJCWZpbmFsIGNsYXNzIGRlcHNfd2Vic2hhcmtzX2NvcmVfdjAwMDAwMF9kZXYNCgkJew0KCQkJcHVibGljIGZ1bmN0aW9uIGNoZWNrKCRwbHVnaW5fbmFtZSA9ICcnKQ0KCQkJCXsNCgkJCQkJaWYoIWlzX2FkbWluKCkgfHwgIWN1cnJlbnRfdXNlcl9jYW4oJ2luc3RhbGxfcGx1Z2lucycpKQ0KCQkJCQkJcmV0dXJuIEZBTFNFOyAvLyBOb3RoaW5nIHRvIGRvIGhlcmUuDQoNCgkJCQkJJG5vdGljZSA9ICc8ZGl2IGNsYXNzPSJlcnJvciBmYWRlIj4nOw0KCQkJCQkkbm90aWNlIC49ICc8cD4nOw0KDQoJCQkJCSRub3RpY2UgLj0gKCRwbHVnaW5fbmFtZSkgPw0KCQkJCQkJJ1JlZ2FyZGluZyA8c3Ryb25nPicuZXNjX2h0bWwoJHBsdWdpbl9uYW1lKS4nOjwvc3Ryb25nPicuDQoJCQkJCQknJm5ic3A7Jm5ic3A7Jm5ic3A7JyA6ICcnOw0KDQoJCQkJCSRub3RpY2UgLj0gJyUlbm90aWNlJSUnOw0KDQoJCQkJCSRub3RpY2UgLj0gJzwvcD4nOw0KCQkJCQkkbm90aWNlIC49ICc8L2Rpdj4nOw0KDQoJCQkJCWFkZF9hY3Rpb24oJ2FsbF9hZG1pbl9ub3RpY2VzJywgLy8gTm90aWZ5IGluIGFsbCBhZG1pbiBub3RpY2VzLg0KCQkJCQkgICAgICAgICAgIGNyZWF0ZV9mdW5jdGlvbignJywgJ2VjaG8gXCcnLnN0cl9yZXBsYWNlKCInIiwgIlxcJyIsICRub3RpY2UpLidcJzsnKSk7DQoNCgkJCQkJcmV0dXJuIEZBTFNFOyAvLyBBbHdheXMgcmV0dXJuIGEgRkFMU0UgdmFsdWUgaW4gdGhpcyBzY2VuYXJpby4NCgkJCQl9DQoJCX0NCgl9';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Regex pattern properties.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * PHP userland validation pattern.
			 *
			 * @var string PHP userland validation pattern.
			 * @see http://php.net/manual/en/userlandnaming.php
			 */
			public static $regex_valid_userland_name = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';

			/**
			 * @var string WebSharks™ Core namespace (w/ version) validation pattern.
			 * @see http://php.net/manual/en/function.version-compare.php
			 *
			 *       1. Lowercase alphanumerics and/or underscores only.
			 *       2. MUST start with: ``self::$core_ns_stub_v``; followed by six digits.
			 *       3. May optionally end with a WebSharks™ Core version suffix.
			 *       4. MUST always end w/ an alphanumeric value.
			 *       5. May NOT contain double underscores.
			 */
			public static $regex_valid_core_ns_version = '/^%%self::$core_ns_stub_v%%[0-9]{6}(?:_(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z]))?$/';

			/**
			 * @var string WebSharks™ Core namespace (w/ version) validation pattern (dashed variation).
			 * @see http://php.net/manual/en/function.version-compare.php
			 *
			 *       1. Lowercase alphanumerics and/or dashes only.
			 *       2. MUST start with: ``self::$core_ns_stub_v_with_dashes``; followed by six digits.
			 *       3. May optionally end with a WebSharks™ Core version suffix.
			 *       4. MUST always end w/ an alphanumeric value.
			 *       5. May NOT contain double dashes.
			 */
			public static $regex_valid_core_ns_version_with_dashes = '/^%%self::$core_ns_stub_v_with_dashes%%[0-9]{6}(?:\-(?:[a-z](?:[a-z0-9]|\-(?!\-))*[a-z0-9]|[a-z]))?$/';

			/**
			 * @var string Plugin root namespace validation pattern.
			 *
			 *       1. Lowercase alphanumerics and/or underscores only.
			 *       2. CANNOT start or end with an underscore.
			 *       3. MUST start with a letter.
			 *       4. No double underscores.
			 */
			public static $regex_valid_plugin_root_ns = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])$/';

			/**
			 * @var string Plugin variable namespace validation pattern.
			 *
			 *       1. Lowercase alphanumerics and/or underscores only.
			 *       2. CANNOT start or end with an underscore.
			 *       3. MUST start with a letter.
			 *       4. No double underscores.
			 */
			public static $regex_valid_plugin_var_ns = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])$/';

			/**
			 * @var string Plugin namespace\class path validation pattern.
			 *
			 *       1. Lowercase alphanumerics, underscores, and/or namespace `\` separators only.
			 *       2. MUST contain at least one namespace path (i.e. it MUST be within a namespace).
			 *       3. A path element CANNOT start or end with an underscore.
			 *       4. Each path element MUST start with a letter.
			 *       5. No double underscores in any path element.
			 */
			public static $regex_valid_plugin_ns_class = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])(?:\\\\(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z]))+$/';

			/**
			 * @var string Plugin version string validation pattern.
			 *    This has additional limitations (but still compatible w/ PHP version strings).
			 * @see http://php.net/manual/en/function.version-compare.php
			 *
			 *       1. Lowercase alphanumerics and/or dashes only.
			 *       2. MUST start with 6 digits (i.e. `YYMMDD` — normally a dated version).
			 *       3. An optional development state is allowed (but it MUST be prefixed w/ a dash).
			 *       4. MUST always end w/ an alphanumeric value.
			 *       5. May NOT contain double dashes.
			 */
			public static $regex_valid_plugin_version = '/^[0-9]{6}(?:\-(?:[a-z](?:[a-z0-9]|\-(?!\-))*[a-z0-9]|[a-z]))?$/';

			/**
			 * @var string PHP version string validation pattern.
			 *    PHP version strings allow a dotted notation also (and caSe is NOT important).
			 * @see http://php.net/manual/en/function.version-compare.php
			 */
			public static $regex_valid_version = '/^(?:[0-9](?:[a-zA-Z0-9]|\.(?!\.))*[a-zA-Z0-9]|[0-9]+)(?:\-(?:[a-zA-Z](?:[a-zA-Z0-9]|\-(?![\-\.])|\.(?![\.\-]))*[a-zA-Z0-9]|[a-zA-Z]))?$/';
		}

		# -----------------------------------------------------------------------------------------------------------------------------------
		# Initialize the WebSharks™ Core stub.
		# -----------------------------------------------------------------------------------------------------------------------------------

		websharks_core_v000000_dev::initialize(); // Also creates class alias.
	}
# -----------------------------------------------------------------------------------------------------------------------------------------
# Inline webPhar handler.
# -----------------------------------------------------------------------------------------------------------------------------------------
/*
 * A WebSharks™ Core webPhar instance?
 * This serves files straight from a PHP Archive.
 */
if(websharks_core_v000000_dev::is_webphar())
	{
		unset($GLOBALS[websharks_core_v000000_dev::autoload_var()]);

		if(!websharks_core_v000000_dev::can_phar())
			throw new exception(websharks_core_v000000_dev::cant_phar_msg());

		Phar::webPhar('websharks-core-v000000-dev', 'index.php', '', websharks_core_v000000_dev::web_phar_mime_types(),
		              'websharks_core_v000000_dev::web_phar_rewriter');

		return; // We can stop here.
	}
# -----------------------------------------------------------------------------------------------------------------------------------------
# Inline autoload handler.
# -----------------------------------------------------------------------------------------------------------------------------------------
/*
 * A WebSharks™ Core autoload instance?
 * On by default (disable w/ global var as necessary).
 */
if(websharks_core_v000000_dev::is_autoload())
	{
		unset($GLOBALS[websharks_core_v000000_dev::autoload_var()]);

		if(!defined('WPINC') && !websharks_core_v000000_dev::wp_load())
			throw new exception(websharks_core_v000000_dev::no_wp_msg());

		if(!defined('WPINC')) // Need to load WordPress?
			require_once websharks_core_v000000_dev::wp_load(TRUE);

		if(!class_exists('deps_websharks_core_v000000_dev'))
			require_once websharks_core_v000000_dev::deps(FALSE);

		if(!class_exists('\\websharks_core_v000000_dev\\framework'))
			require_once websharks_core_v000000_dev::framework();

		return; // We can stop here.
	}
# -----------------------------------------------------------------------------------------------------------------------------------------
# Default inline handlers.
# -----------------------------------------------------------------------------------------------------------------------------------------
/*
 * Always unset WebSharks™ Core autoload var.
 */
unset($GLOBALS[websharks_core_v000000_dev::autoload_var()]);
/*
 * The WebSharks™ Core is in WordPress?
 * If we're in WordPress®; it is NOT direct access.
 */
if(defined('WPINC')) return; // We can stop here.
/*
 * WordPress® is NOT loaded up in this scenario.
 * By default, we disallow direct file access.
 */
exit('Do NOT access this file directly: '.basename(__FILE__));