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
if(!class_exists('websharks_core_v000000_dev'))
	{
		/**
		 * Stub: WebSharks™ Core class.
		 *
		 * @note MUST remain PHP v5.2 compatible.
		 *
		 * @package WebSharks\Core
		 * @since 130302
		 */
		class websharks_core_v000000_dev
		{
			/**
			 * A static cache (for all instances).
			 *
			 * @var array A static cache (for all instances).
			 */
			public static $static = array();

			/**
			 * This file is a PHP Archive?
			 *
			 * @return boolean A PHP Archive file?
			 */
			public static function is_phar()
				{
					$is_phar = self::is_phar_var();

					if(!empty($GLOBALS[$is_phar]))
						if($GLOBALS[$is_phar] === __FILE__)
							return TRUE;

					return FALSE;
				}

			/**
			 * Stub file loaded by the PHAR stub?
			 *
			 * @param string $file An absolute file path.
			 *
			 * @return boolean Stub file loaded by the PHAR stub?
			 */
			public static function is_phar_stub($file)
				{
					if(!self::is_phar())
						return FALSE;

					$file      = self::n_dir_seps((string)$file);
					$phar_file = self::n_dir_seps(__FILE__);

					echo $file.'<br />'.$phar_file;

					return ($file === $phar_file.'/stub.php');
				}

			/**
			 * Global PHAR variable for the WebSharks™ Core.
			 *
			 * @return string The PHAR variable for the WebSharks™ Core.
			 */
			public static function is_phar_var()
				{
					return 'is_phar_'.__CLASS__;
				}

			/**
			 * A webPhar instance?
			 *
			 * @return boolean A webPhar instance?
			 */
			public static function is_webphar()
				{
					if(!defined('WPINC') && self::is_phar() && !empty($_SERVER['SCRIPT_FILENAME']))
						if(realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__))
							return TRUE;

					return FALSE;
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

					return self::$static['can_phar'];
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

					$autoload = self::autoload_var();

					if(!isset($GLOBALS[$autoload]) || $GLOBALS[$autoload])
						return TRUE;

					return FALSE;
				}

			/**
			 * Global autoload var for WebSharks™ Core.
			 *
			 * @return string Autoload var for WebSharks™ Core.
			 */
			public static function autoload_var()
				{
					return 'autoload_'.__CLASS__;
				}

			/**
			 * Gets WebSharks™ Core `deps.php` file.
			 *
			 * @return string Absolute path to `deps.php` file.
			 *
			 * @throws exception If unable to locate the WebSharks™ Core `deps.php` file.
			 */
			public static function deps()
				{
					if(self::is_phar() && self::can_phar())
						{
							$phar = 'phar://'.self::n_dir_seps(__FILE__);
							if(is_file($_phar_deps = $phar.'/deps.php'))
								return $_phar_deps;
						}
					if(($_deps = self::locate('/websharks-core/deps.php')))
						return $_deps; // Official location on live sites.

					if(defined('___DEV_KEY_OK') && ($_deps = self::locate('/core/websharks-core/deps.php')))
						return $_deps; // Development copy (for authenticated developers).

					if(self::is_phar() && !self::can_phar() && defined('WPINC'))
						if(($_temp_deps = self::cant_phar_msg_notice_in_ws_wp_temp_deps()))
							return $_temp_deps;

					unset($_phar_deps, $_deps, $_temp_deps); // A little housekeeping.

					if(self::is_phar() && !self::can_phar()) // Be verbose.
						throw new exception(self::cant_phar_msg());

					throw new exception(self::i18n('Unable to locate WebSharks™ Core `deps.php` file.'));
				}

			/**
			 * Gets WebSharks™ Core `framework.php` file.
			 *
			 * @return string Absolute path to `framework.php` file.
			 *
			 * @throws exception If unable to locate the WebSharks™ Core `framework.php` file.
			 */
			public static function framework()
				{
					if(self::is_phar() && self::can_phar())
						{
							$phar = 'phar://'.self::n_dir_seps(__FILE__);
							if(is_file($_phar_framework = $phar.'/framework.php'))
								return $_phar_framework;
						}
					if(($_framework = self::locate('/websharks-core/framework.php')))
						return $_framework; // Official location on live sites.

					if(defined('___DEV_KEY_OK') && ($_framework = self::locate('/core/websharks-core/framework.php')))
						return $_framework; // Development copy (for authenticated developers).

					unset($_phar_framework, $_framework); // A little housekeeping.

					if(self::is_phar() && !self::can_phar()) // Be verbose.
						throw new exception(self::cant_phar_msg());

					throw new exception(self::i18n('Unable to locate WebSharks™ Core `framework.php` file.'));
				}

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
			 *
			 * @throws exception If this is somehow called upon w/o Phar being enabled or even possible.
			 */
			public static function webPhar_rewriter($uri_or_path_info)
				{
					if(!self::is_phar() || !self::can_phar() || !self::is_webphar())
						if(self::is_phar() && !self::can_phar()) // Be verbose.
							throw new exception(self::cant_phar_msg());
						else throw new exception(self::i18n('NOT a webPhar instance.'));

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

					// Normalize directory separators; and force a leading slash on all URIs.
					// Allow trailing slash; it's easier to parse directory indexes this way.

					$internal_uri = self::n_dir_seps($path_info, TRUE);
					$internal_uri = '/'.ltrim($internal_uri, '/');

					// Do NOT allow double dots in a URI value.

					if(strpos($internal_uri, '..') !== FALSE)
						return FALSE; // 403 (forbidden).

					// Current `phar://` file w/stream prefix.

					$phar = 'phar://'.self::n_dir_seps(__FILE__);

					// Handle directory indexes gracefully.

					if(substr($internal_uri, -1) === '/' // A directory explicitly.
					   || !is_file($phar.$internal_uri) // It's NOT a file; assume directory.
					) $internal_uri = rtrim($internal_uri, '\\/').'/index.php';

					// Now, let's make webPhar a little more security-conscious here.

					for($_i = 0, $_dir = dirname($phar.$internal_uri); $_i <= 100; $_i++)
						{
							if($_i > 0) $_dir = dirname($_dir); // Up a directory.
							if(!$_dir || $_dir === '.') break; // Search complete?

							if(strcasecmp(basename($_dir), 'app_data') === 0)
								return FALSE; // Windows®; 403 (forbidden).

							if(is_file($_dir.'/.htaccess')) // Apache™ compatible.
								{
									if(!is_readable($_dir.'/.htaccess'))
										return FALSE; // 403 (forbidden).

									$_htaccess = file_get_contents($_dir.'/.htaccess');
									if(stripos($_htaccess, 'deny from all') !== FALSE)
										return FALSE; // 403 (forbidden).
								}
						}
					unset($_i, $_dir, $_htaccess); // A little housekeeping.

					return $internal_uri; // Final return value (internal URI).
				}

			/**
			 * Attempts to find a readable/writable temporary directory.
			 *
			 * @return string Readable/writable temp directory; else an empty string.
			 */
			public static function get_wp_temp_dir()
				{
					if(!defined('WPINC'))
						return ''; // Not possible.

					if(($wp_temp_dir = get_temp_dir())
					   && ($wp_temp_dir = realpath($wp_temp_dir))
					   && is_readable($wp_temp_dir) && is_writable($wp_temp_dir)
					) return self::n_dir_seps($wp_temp_dir);

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
			 * Attempts to get `/wp-load.php`.
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
			 *    • If NULL|TRUE, we'll look inside: `E:/EasyPHP/wordpress` (a default WebSharks™ Core location).
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
					if(!is_bool($get_last_value) || !is_bool($check_abspath)
					   || !(is_null($fallback) || is_bool($fallback) || is_string($fallback))
					) throw new exception( // Fail here; detected invalid arguments.
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

					if($fallback) // Fallback on dev copy?
						{
							if(is_string($fallback))
								$dev_dir = self::n_dir_seps($fallback);
							else $dev_dir = 'E:/EasyPHP/wordpress';

							if(is_file($_wp_load = $dev_dir.'/wp-load.php'))
								return (self::$static['wp_load'] = $_wp_load);
						}
					unset($_wp_load); // Housekeeping.

					return (self::$static['wp_load'] = ''); // Failure.
				}

			/**
			 * Locates a specific directory/file path.
			 *
			 * @param string $dir_file A specific directory/file path.
			 *
			 * @param string $starting_dir Optional. A specific directory to start searching from.
			 *    Defaults to the directory of this file (e.g. `__DIR__`).
			 *
			 * @return string Directory/file path (if found); else an empty string.
			 *    The search will continue until there are no more directories to search through.
			 *    However, there is an upper limit of 100 directories maximum.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$dir_file`` or ``$starting_dir`` are empty.
			 */
			public static function locate($dir_file, $starting_dir = __DIR__)
				{
					if(!is_string($dir_file) || !$dir_file || !is_string($starting_dir) || !$starting_dir)
						throw new exception( // Fail here; detected invalid arguments.
							sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					$dir_file     = ltrim(self::n_dir_seps($dir_file), '/');
					$starting_dir = self::n_dir_seps($starting_dir);

					for($_i = 0, $_dir = $starting_dir; $_i <= 100; $_i++)
						{
							if($_i > 0) $_dir = dirname($_dir); // Up a directory.
							if(!$_dir || $_dir === '.') break; // Search complete?

							if(is_file($_dir.'/'.$dir_file))
								return $_dir.'/'.$dir_file;
						}
					unset($_i, $_dir); // Housekeeping.

					return ''; // Failure.
				}

			/**
			 * Regarding an inability to locate `/wp-load.php`.
			 *
			 * @return string Error message w/ details about the `/wp-load.php` file.
			 */
			public static function no_wp_msg()
				{
					return self::i18n('Unable to load the WebSharks™ Core. WordPress® (a core dependency) is NOT loaded up yet.'.
					                  ' Please include WordPress® in your scripts using: `include_once \'wp-load.php\';`.');
				}

			/**
			 * Regarding a lack of support for Php Archives.
			 *
			 * @see \websharks_core_v000000_dev\cant_phar_msg_notice_in_ws_wp_temp_deps()
			 *
			 * @return string Error message w/ details about the `Phar` class and PHP v5.3+.
			 */
			public static function cant_phar_msg()
				{
					return self::i18n('Unable to load the WebSharks™ Core. This installation of PHP is missing the `Phar` extension.'.
					                  ' The WebSharks™ Core (and WP plugins powered by it); requires PHP v5.3+ — which has `Phar` built-in.'.
					                  ' Please upgrade to PHP v5.3 (or higher) to get rid of this message.');
				}

			/**
			 * Regarding a lack of support for Php Archives.
			 *
			 * Creates a temporary deps class & returns absolute path to that class file.
			 *    This can ONLY be used if we're within WordPress®; because it attaches
			 *    itself to a WordPress® administrative notice.
			 *
			 * @see \websharks_core_v000000_dev\$ws_wp_temp_deps
			 *
			 * @return string Absolute path to temporary deps; else an empty string if NOT possible.
			 */
			public static function cant_phar_msg_notice_in_ws_wp_temp_deps()
				{
					if(!defined('WPINC') || !self::is_phar() || self::can_phar())
						return ''; // Not possible (or NOT applicable).

					if(($temp_dir = self::get_wp_temp_dir()))
						{
							$temp_deps          = $temp_dir.'/ws-wp-temp-deps.tmp';
							$temp_deps_contents = base64_decode(self::$ws_wp_temp_deps);
							$temp_deps_contents = str_ireplace('websharks_core'.'_v000000_dev', __CLASS__, $temp_deps_contents);
							$temp_deps_contents = str_ireplace('%%notice%%', str_replace("'", "\\'", self::cant_phar_msg()), $temp_deps_contents);

							if(!is_file($temp_deps) || (is_writable($temp_deps) && unlink($temp_deps)))
								if(file_put_contents($temp_deps, $temp_deps_contents))
									return $temp_deps;
						}
					return ''; // Failure.
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

					return (defined('WPINC')) ? _x($string, $context, $core_ns_stub_with_dashes) : $string;
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

					return (defined('WPINC')) ? _x($string, $context, $core_ns_stub_with_dashes) : $string;
				}

			/**
			 * Regarding a lack of support for Php Archives.
			 *
			 * WebSharks™ temporary WP deps class (base64 encoded).
			 *
			 * @see \websharks_core_v000000_dev\cant_phar_msg_notice_in_ws_wp_temp_deps()
			 *
			 * @var string Base64 encoded version of `/includes/ws-wp-temp-deps.php` in WebSharks™ Core.
			 */
			public static $ws_wp_temp_deps = 'PD9waHAKaWYoIWRlZmluZWQoJ1dQSU5DJykpCglleGl0KCdEbyBOT1QgYWNjZXNzIHRoaXMgZmlsZSBkaXJlY3RseTogJy5iYXNlbmFtZShfX0ZJTEVfXykpOwoKaWYoIWNsYXNzX2V4aXN0cygnZGVwc193ZWJzaGFya3NfY29yZV92MDAwMDAwX2RldicpKQoJewoJCWNsYXNzIGRlcHNfd2Vic2hhcmtzX2NvcmVfdjAwMDAwMF9kZXYKCQl7CgkJCXB1YmxpYyBmdW5jdGlvbiBjaGVjaygkcGx1Z2luX25hbWUgPSAnJykKCQkJCXsKCQkJCQlpZighaXNfYWRtaW4oKSB8fCAhY3VycmVudF91c2VyX2NhbignaW5zdGFsbF9wbHVnaW5zJykpCgkJCQkJCXJldHVybiBGQUxTRTsgLy8gTm90aGluZyB0byBkbyBoZXJlLgoKCQkJCQkkbm90aWNlID0gJzxkaXYgY2xhc3M9ImVycm9yIGZhZGUiPic7CgkJCQkJJG5vdGljZSAuPSAnPHA+JzsKCgkJCQkJJG5vdGljZSAuPSAoJHBsdWdpbl9uYW1lKSA/CgkJCQkJCSdSZWdhcmRpbmcgPHN0cm9uZz4nLmVzY19odG1sKCRwbHVnaW5fbmFtZSkuJzo8L3N0cm9uZz4nLgoJCQkJCQknJm5ic3A7Jm5ic3A7Jm5ic3A7JyA6ICcnOwoKCQkJCQkkbm90aWNlIC49ICclJW5vdGljZSUlJzsKCgkJCQkJJG5vdGljZSAuPSAnPC9wPic7CgkJCQkJJG5vdGljZSAuPSAnPC9kaXY+JzsKCgkJCQkJYWRkX2FjdGlvbignYWxsX2FkbWluX25vdGljZXMnLCAvLyBOb3RpZnkgaW4gYWxsIGFkbWluIG5vdGljZXMuCgkJCQkJICAgICAgICAgICBjcmVhdGVfZnVuY3Rpb24oJycsICdlY2hvIFwnJy5zdHJfcmVwbGFjZSgiJyIsICJcXCciLCAkbm90aWNlKS4nXCc7JykpOwoKCQkJCQlyZXR1cm4gRkFMU0U7IC8vIEFsd2F5cyByZXR1cm4gYSBGQUxTRSB2YWx1ZSBpbiB0aGlzIHNjZW5hcmlvLgoJCQkJfQoJCX0KCX0=';
		}
	}
/*
 * A WebSharks™ Core webPhar instance?
 * This serves files straight from the PHP Archive.
 */
if(websharks_core_v000000_dev::is_webphar())
	{
		if(!websharks_core_v000000_dev::can_phar())
			throw new exception(websharks_core_v000000_dev::cant_phar_msg());

		if(websharks_core_v000000_dev::is_phar_stub(__FILE__))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		Phar::webPhar('', '', '', array(), 'websharks_core_v000000_dev::webPhar_rewriter');

		return; // We can stop here.
	}
/*
 * A WebSharks™ Core autoload instance?
 * This is enabled by default (disable w/ a global var).
 */
if(websharks_core_v000000_dev::is_autoload())
	{
		if(!defined('WPINC') && !websharks_core_v000000_dev::wp_load())
			throw new exception(websharks_core_v000000_dev::no_wp_msg());

		if(!defined('WPINC')) // Need to load WordPress?
			include_once websharks_core_v000000_dev::wp_load(TRUE);

		if(!class_exists('\\websharks_core_v000000_dev\\framework'))
			include_once websharks_core_v000000_dev::framework();
	}
unset($GLOBALS[websharks_core_v000000_dev::autoload_var()]);

/*
 * The WebSharks™ Core is in WordPress?
 * If we're in WordPress®; it is NOT direct access.
 */
if(defined('WPINC')) return; // We can stop here.

/*
 * WordPress® did NOT load up in this scenario.
 * By default, we disallow direct file access.
 */
exit('Do NOT access this file directly: '.basename(__FILE__));

/*
 * For a possible `phar://` stream wrapper (do NOT remove this).
 *    The PHAR class wants this w/ all UPPERCASE letters.
 */
__HALT_COMPILER();