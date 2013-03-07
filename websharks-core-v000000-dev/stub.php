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
		class websharks_core_v000000_dev // Stand-alone stub class.
		{
			/**
			 * @var boolean Is Php Archive?
			 */
			public static $is_phar = FALSE; // !#is-phar#!

			/**
			 * This this file a PHP Archive?
			 *
			 * @return boolean TRUE if this is a PHP Archive file.
			 */
			public static function is_phar()
				{
					if(self::$is_phar)
						return self::$is_phar;

					else if(stripos(basename(__FILE__), '.phar') !== FALSE)
						return (self::$is_phar = TRUE);

					return self::$is_phar;
				}

			/**
			 * Php Archives are possible?
			 *
			 * @return boolean Php Archives are possible?
			 */
			public static function can_phar()
				{
					return (class_exists('Phar') || extension_loaded('Phar'));
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
						if(file_exists($_phar_deps = 'phar://'.__FILE__.'/deps.php'))
							return $_phar_deps;

					foreach(array('plugin'     => dirname(__FILE__).'/websharks-core-v000000-dev/deps.php',
					              'core-dev'   => dirname(dirname(dirname(__FILE__))).'/core/websharks-core-v000000-dev/deps.php',
					              'plugin-dev' => dirname(dirname(dirname(dirname(__FILE__)))).'/core/websharks-core-v000000-dev/deps.php')
					        as $_key => $_file)
						if((in_array($_key, array('plugin'), TRUE) || defined('___DEV_KEY_OK')) && file_exists($_file))
							return $_file;

					if(self::is_phar() && !self::can_phar() && defined('WPINC'))
						if(($_temp_deps = self::cant_phar_msg_notice_in_ws_wp_temp_deps()))
							return $_temp_deps;

					unset($_phar_deps, $_key, $_file, $_temp_deps);

					if(self::is_phar() && !self::can_phar()) // Be verbose.
						throw new exception(self::cant_phar_msg());

					throw new exception('Unable to locate WebSharks™ Core `deps.php` file.');
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
						if(file_exists($_phar_include = 'phar://'.__FILE__.'/include.php'))
							return $_phar_include;

					foreach(array('plugin'     => dirname(__FILE__).'/websharks-core-v000000-dev/include.php',
					              'core-dev'   => dirname(dirname(dirname(__FILE__))).'/core/websharks-core-v000000-dev/include.php',
					              'plugin-dev' => dirname(dirname(dirname(dirname(__FILE__)))).'/core/websharks-core-v000000-dev/include.php')
					        as $_key => $_file)
						if((in_array($_key, array('plugin'), TRUE) || defined('___DEV_KEY_OK')) && file_exists($_file))
							return $_file;

					unset($_phar_include, $_key, $_file);

					if(self::is_phar() && !self::can_phar()) // Be verbose.
						throw new exception(self::cant_phar_msg());

					throw new exception('Unable to locate WebSharks™ Core `include.php` file.');
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
					if(!self::is_phar() || !self::can_phar())
						throw new exception(self::cant_phar_msg());

					// Determine path info.

					if(!empty($_SERVER['PATH_INFO']))
						$path_info = (string)$_SERVER['PATH_INFO'];

					else if(function_exists('apache_lookup_uri') && !empty($_SERVER['REQUEST_URI']))
						{
							$_apache_lookup = apache_lookup_uri((string)$_SERVER['REQUEST_URI']);

							if(!empty($_apache_lookup['path_info']))
								$path_info = (string)$_apache_lookup['path_info'];
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

							if(strcasecmp(basename($_dir), 'app_data') === 0)
								return FALSE; // 403 (forbidden) response.

							else if(file_exists($_dir.'/.htaccess'))
								if(stripos(file_get_contents($_dir.'/.htaccess'), 'deny from all') !== FALSE)
									return FALSE; // 403 (forbidden).

							if(!$_dir || $_dir === '.') break;
						}
					unset($_i, $__i, $_dirname, $_dir);

					// Let's wrap this up now :-)

					return $internal_uri_value; // Rewritten.
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
			 */
			public static function n_dir_seps($path, $allow_trailing_slash = FALSE)
				{
					$path = (string)$path;

					preg_match('/^(?P<scheme>[a-z]+\:\/\/)/i', $path, $_path);
					$path = (!empty($_path['scheme'])) ? str_ireplace($_path['scheme'], '', $path) : $path;

					$path = preg_replace('/\/+/', '/', str_replace(array(DIRECTORY_SEPARATOR, '\\', '/'), '/', $path));
					$path = ($allow_trailing_slash) ? $path : rtrim($path, '/');

					$path = (!empty($_path['scheme'])) ? strtolower($_path['scheme']).$path : $path; // Lowercase.

					return $path; // Normalized now.
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
					return 'Unable to load the WebSharks™ Core. This installation of PHP is missing the `Phar` extension.'.
					       ' The WebSharks™ Core (and WP plugins powered by it); requires PHP v5.3+ — which has `Phar` built-in.'.
					       ' Please upgrade to PHP v5.3 (or higher) to get rid of this message.';
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
							$temp_deps_contents = str_ireplace('%%notice%%', str_replace("'", "\\'", self::cant_phar_msg()), $temp_deps_contents);

							if(!file_exists($temp_deps) || (is_writable($temp_deps) && unlink($temp_deps)))
								if(file_put_contents($temp_deps, $temp_deps_contents))
									return $temp_deps;
						}
					return ''; // Default return value.
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
 * WebSharks™ Core is in WordPress?
 * We can stop here; simply an include.
 */
if(defined('WPINC')) return; // Stop here.

/**
 * A stand-alone WebSharks™ Core webPhar instance?
 * If this is an archive; and we're NOT in WordPress®.
 */
if(websharks_core_v000000_dev::is_phar() && !defined('WPINC'))
	{
		if(!websharks_core_v000000_dev::can_phar()) // Be verbose.
			throw new exception(websharks_core_v000000_dev::cant_phar_msg());

		Phar::webPhar('', '', '', array(), 'websharks_core_v000000_dev::webPhar_rewriter');

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