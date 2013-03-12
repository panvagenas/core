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
			 * Php Archives are possible?
			 *
			 * @return boolean Php Archives are possible?
			 */
			public static function can_phar()
				{
					if(isset(self::$static['can_phar']))
						return self::$static['can_phar'];

					return (self::$static['can_phar'] = extension_loaded('phar'));
				}

			/**
			 * This this file a PHP Archive?
			 *
			 * @return boolean A PHP Archive file?
			 */
			public static function is_phar()
				{
					static $is_phar; #!is-phar!#

					if(isset($is_phar)) return $is_phar;

					else if(isset(self::$static['is_phar']))
						return self::$static['is_phar'];

					if(stripos(basename(__FILE__), '.phar') !== FALSE)
						return (self::$static['is_phar'] = TRUE);

					return (self::$static['is_phar'] = FALSE);
				}

			/**
			 * A webPhar instance?
			 *
			 * @return boolean A webPhar instance?
			 */
			public static function is_webphar()
				{
					if(isset(self::$static['is_webphar']))
						return self::$static['is_webphar'];

					if(!defined('WPINC') && self::is_phar()
					   && basename(__FILE__) !== 'stub.php' // Exclude `stub.php`.
					   // ↑ Exclude `stub.php` in case it's loaded from a PHAR file.
					   && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)
					) return (self::$static['is_webphar'] = TRUE);

					return (self::$static['is_webphar'] = FALSE);
				}

			/**
			 * Autoload WebSharks™ Core?
			 *
			 * @return boolean Autoload WebSharks™ Core?
			 */
			public static function is_autoload()
				{
					if(isset(self::$static['is_autoload']))
						return self::$static['is_autoload'];

					$autoload = self::autoload_var(); // Global autoload flag.

					if(!self::is_webphar() && (!isset($GLOBALS[$autoload]) || $GLOBALS[$autoload]))
						return (self::$static['is_autoload'] = TRUE);

					return (self::$static['is_autoload'] = FALSE);
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
						if(is_file($_phar_deps = 'phar://'.__FILE__.'/deps.php'))
							return $_phar_deps;

					foreach(array('plugin'     => dirname(__FILE__).'/websharks-core/deps.php',
					              'core-dev'   => dirname(dirname(dirname(__FILE__))).'/core/websharks-core/deps.php',
					              'plugin-dev' => dirname(dirname(dirname(dirname(__FILE__)))).'/core/websharks-core/deps.php')
					        as $_key => $_file)
						if((in_array($_key, array('plugin'), TRUE) || defined('___DEV_KEY_OK')) && is_file($_file))
							return $_file;

					if(self::is_phar() && !self::can_phar() && defined('WPINC'))
						if(($_temp_deps = self::cant_phar_msg_notice_in_ws_wp_temp_deps()))
							return $_temp_deps;

					unset($_phar_deps, $_key, $_file, $_temp_deps);

					if(self::is_phar() && !self::can_phar()) // Be verbose.
						throw new exception(self::cant_phar_msg());

					throw new exception(self::i18n('Unable to locate WebSharks™ Core `deps.php` file.'));
				}

			/**
			 * Gets WebSharks™ Core `include.php` file.
			 *
			 * @return string Absolute path to `include.php` file.
			 *
			 * @throws exception If unable to locate the WebSharks™ Core `include.php` file.
			 */
			public static function framework()
				{
					if(self::is_phar() && self::can_phar())
						if(is_file($_phar_include = 'phar://'.__FILE__.'/include.php'))
							return $_phar_include;

					foreach(array('plugin'     => dirname(__FILE__).'/websharks-core/include.php',
					              'core-dev'   => dirname(dirname(dirname(__FILE__))).'/core/websharks-core/include.php',
					              'plugin-dev' => dirname(dirname(dirname(dirname(__FILE__)))).'/core/websharks-core/include.php')
					        as $_key => $_file)
						if((in_array($_key, array('plugin'), TRUE) || defined('___DEV_KEY_OK')) && is_file($_file))
							return $_file;

					unset($_phar_include, $_key, $_file);

					if(self::is_phar() && !self::can_phar()) // Be verbose.
						throw new exception(self::cant_phar_msg());

					throw new exception(self::i18n('Unable to locate WebSharks™ Core `include.php` file.'));
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
					// Allow trailing slash in URIs; it's easier to parse directory indexes this way.

					$internal_uri_value = self::n_dir_seps($path_info, TRUE); // Start w/ path info and clean things up.
					$internal_uri_value = '/'.ltrim($internal_uri_value, '\\/'); // This SHOULD already be the case.

					// Do NOT allow double dots in a URI value.

					if(strpos($internal_uri_value, '..') !== FALSE)
						return FALSE; // 403 (forbidden).

					// Current PHAR file with stream prefix.

					$phar = 'phar://'.__FILE__;

					// Handle directory indexes gracefully.

					if(substr($internal_uri_value, -1) === '/' // A directory explicitly.
					   || !is_file($phar.$internal_uri_value) // It's NOT a file; assume directory.
					) $internal_uri_value = rtrim($internal_uri_value, '\\/').'/index.php';

					// Let's make webPhar a little more security-conscious here.

					for($_i = 0, $_dirname = dirname($phar.$internal_uri_value); $_i <= 100; $_i++)
						{
							for($_dir = $_dirname, $__i = 0; $__i < $_i; $__i++)
								$_dir = dirname($_dir);

							if(!$_dir || $_dir === '.') break;

							if(strcasecmp(basename($_dir), 'app_data') === 0)
								return FALSE; // Windows® 403 (forbidden).

							else if(is_file($_dir.'/.htaccess')) // Apache.
								{
									if(!is_readable($_dir.'/.htaccess'))
										return FALSE; // 403 (forbidden).

									if(stripos(file_get_contents($_dir.'/.htaccess'), 'deny from all') !== FALSE)
										return FALSE; // 403 (forbidden).
								}
						}
					unset($_i, $__i, $_dirname, $_dir);

					// Let's wrap this up now :-)

					return $internal_uri_value;
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

					return ''; // Default return value.
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
					if(is_string($path) && is_bool($allow_trailing_slash))
						{
							if(!strlen($path)) return ''; // Catch empty strings.

							preg_match('/^(?P<scheme>[a-z]+\:\/\/)/i', $path, $_path);
							$path = (!empty($_path['scheme'])) ? str_ireplace($_path['scheme'], '', $path) : $path;

							$path = preg_replace('/\/+/', '/', str_replace(array(DIRECTORY_SEPARATOR, '\\', '/'), '/', $path));
							$path = ($allow_trailing_slash) ? $path : rtrim($path, '/');

							$path = (!empty($_path['scheme'])) ? strtolower($_path['scheme']).$path : $path; // Lowercase.

							return $path; // Normalized now.
						}
					else throw new exception( // Detected invalid arguments.
						sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
					);
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
			public static function wp_load($check_abspath = TRUE, $fallback_on_dev_dir = NULL)
				{
					if(is_bool($check_abspath) && (is_null($fallback_on_dev_dir)
					                               || is_bool($fallback_on_dev_dir) || is_string($fallback_on_dev_dir))
					) // Results from this function are cached statically with these vars.
						{
							if(!isset($fallback_on_dev_dir))
								$fallback_on_dev_dir = defined('___DEV_KEY_OK');

							$cache_entry = '_'.(integer)$check_abspath;
							if($fallback_on_dev_dir && is_string($fallback_on_dev_dir))
								$cache_entry .= $fallback_on_dev_dir;
							else $cache_entry .= (integer)$fallback_on_dev_dir;

							if(isset(self::$static['wp_load'][$cache_entry]))
								return self::$static['wp_load'][$cache_entry];

							if($check_abspath && defined('ABSPATH') && is_file(ABSPATH.'wp-load.php'))
								return (self::$static['wp_load'][$cache_entry] = ABSPATH.'wp-load.php');

							for($_i = 0, $_dirname = dirname(__FILE__); $_i <= 100; $_i++)
								{
									for($_dir = $_dirname, $__i = 0; $__i < $_i; $__i++)
										$_dir = dirname($_dir);

									if(!$_dir || $_dir === '.') break;

									if(is_file($_dir.'/wp-load.php'))
										return (self::$static['wp_load'][$cache_entry] = $_dir.'/wp-load.php');
								}
							unset($_i, $__i, $_dirname, $_dir);

							if($fallback_on_dev_dir) // Fallback on dev copy?
								{
									if(is_string($fallback_on_dev_dir))
										$dev_dir = $fallback_on_dev_dir;
									else $dev_dir = 'E:/EasyPHP/wordpress';

									if(is_file($dev_dir.'/wp-load.php'))
										return (self::$static['wp_load'][$cache_entry] = $dev_dir.'/wp-load.php');
								}
							return (self::$static['wp_load'][$cache_entry] = '');
						}
					else throw new exception( // Detected invalid arguments.
						sprintf(self::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
					);
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
					return ''; // Default return value.
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
/**
 * A WebSharks™ Core webPhar instance?
 */
if(websharks_core_v000000_dev::is_webphar())
	{
		if(!websharks_core_v000000_dev::can_phar())
			throw new exception(websharks_core_v000000_dev::cant_phar_msg());

		Phar::webPhar('', '', '', array(), 'websharks_core_v000000_dev::webPhar_rewriter');

		return; // We can stop here.
	}
/**
 * A WebSharks™ Core autoload instance?
 */
if(websharks_core_v000000_dev::is_autoload())
	{
		if(!defined('WPINC') && !websharks_core_v000000_dev::wp_load())
			throw new exception(websharks_core_v000000_dev::no_wp_msg());

		if(!defined('WPINC')) // Need to load WordPress?
			include_once websharks_core_v000000_dev::wp_load();

		if(!class_exists('\\websharks_core_v000000_dev\\framework'))
			include_once websharks_core_v000000_dev::framework();
	}
/**
 * The WebSharks™ Core is in WordPress?
 */
if(defined('WPINC')) // We can stop here.
	{
		unset($GLOBALS[websharks_core_v000000_dev::autoload_var()]);

		return; // We can stop here.
	}
/**
 * Disallow direct file access in all other cases.
 */
exit('Do NOT access this file directly: '.basename(__FILE__));
/**
 * For a possible `phar://` stream wrapper (do NOT remove this).
 *    The Phar class wants this w/ all UPPERCASE letters.
 */
__HALT_COMPILER();