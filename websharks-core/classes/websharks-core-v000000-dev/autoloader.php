<?php
/**
 * WebSharks™ Autoloader.
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
		 * WebSharks™ Autoloader.
		 *
		 * @note VERY important for this class NOT to have any external dependencies.
		 *    We rely on this class to load almost all other classes.
		 *    So it CANNOT have dependency on others.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 */
		final class autoloader // Static methods only.
		{
			/**
			 * Root namespaces to autoload for.
			 *
			 * @var array Root namespaces to autoload for.
			 */
			public static $ns_roots = array(__NAMESPACE__);

			/**
			 * Array of directories containing classes.
			 *
			 * @var array Array of directories containing classes.
			 */
			public static $class_dirs = array();

			/**
			 * Handles class autoloading.
			 *
			 * @note Capable of loading classes for any extension of the WebSharks™ Core.
			 *
			 * @param string $ns_class A `namespace\class` to load (the PHP interpreter passes this in).
			 *
			 * @return mixed|null Value from class ``include_once()``; else NULL by default.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 */
			public static function load_ns_class($ns_class)
				{
					if(!is_string($ns_class) || !$ns_class)
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(static::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					$ns_class      = strtolower(trim($ns_class, '\\'));
					$ns_class_file = str_replace(array('\\', '_'), array('/', '-'), $ns_class).'.php';

					if(static::is_handling_class_root_ns($ns_class)) // Handling class namespace?
						{
							foreach(static::$class_dirs as $_classes_dir)
								if(is_file($_classes_dir.'/'.$ns_class_file))
									return include_once $_classes_dir.'/'.$ns_class_file;
							unset($_classes_dir); // Housekeeping.
						}
					return NULL; // Default return value.
				}

			/**
			 * Adds a new `classes` directory.
			 *
			 * @param string $classes_dir Any `classes` directory.
			 *
			 * @note This directory MUST use sub-directories with a `namespace/class` hierarchy (lowercase).
			 *    Nested sub-namespaces are also supported in the same structure (i.e. `/namespace/sub_namespace/class`).
			 *    Underscores in any namespace and/or class should be replaced with dashes in the file structure.
			 *    The entire structure should remain lowercase, even if a namespace/class is NOT lowercase.
			 *
			 * @note It's fine to have mixed caSe in directories leading up to this `classes` directory.
			 *    However, the entire structure inside the `classes` directory should remain lowercase,
			 *    even if a namespace/class is NOT lowercase.
			 *
			 * @return string The ``$classes_dir`` on success, else an empty string.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 * @throws \exception If ``$classes_dir`` is empty, or is NOT a `classes` directory.
			 *
			 * @note Each classes directory is pushed to the top of the stack by this routine.
			 *    This way ``load_ns_class()`` will be autoloading classes from the most recent directory first,
			 *    and then searching down the stack until it finds a match. This makes it possible for pro add-ons and/or other plugins,
			 *    to create classes that will essentially override any that may already exist for a particular plugin.
			 */
			public static function add_classes_dir($classes_dir)
				{
					if(!is_string($classes_dir) || basename($classes_dir) !== 'classes' || !is_dir($classes_dir))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(static::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					if(!in_array($classes_dir, static::$class_dirs, TRUE))
						array_unshift(static::$class_dirs, $classes_dir);

					return $classes_dir; // Useful when debugging.
				}

			/**
			 * Adds a new root namespace.
			 *
			 * @param string $root_ns A root namespace.
			 *
			 * @return string The ``$root_ns`` on success, else an empty string.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 * @throws \exception If ``$root_ns`` is empty, or is NOT a top-level namespace.
			 */
			public static function add_root_ns($root_ns)
				{
					if(!is_string($root_ns) || !$root_ns || strpos($root_ns, '\\') !== FALSE)
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(static::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					$root_ns = strtolower($root_ns);

					if(!in_array($root_ns, static::$ns_roots, TRUE))
						array_unshift(static::$ns_roots, $root_ns);

					return $root_ns; // Useful when debugging.
				}

			/**
			 * Handling autoloads for a given namespace?
			 *
			 * @param string $path A namespace or class path (or just a single top-level namespace).
			 *
			 * @return bool TRUE if we ARE autoloading for ``$path``, else FALSE.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 */
			public static function is_handling_class_root_ns($path)
				{
					if(!is_string($path))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(static::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					if(!$path) return FALSE;

					$path    = strtolower(trim($path, '\\'));
					$root_ns = ($root_ns = strstr($path, '\\', TRUE)) ? $root_ns : $path;

					if(in_array($root_ns, static::$ns_roots, TRUE))
						return TRUE; // Yes.

					return FALSE; // Default return value.
				}

			/**
			 * Handles core translations (context: admin-side).
			 *
			 * @return string {@inheritdoc}
			 *
			 * @see \websharks_core_v000000_dev::i18n()
			 * @inheritdoc \websharks_core_v000000_dev::i18n()
			 */
			public static function i18n() // Arguments are NOT listed here.
				{
					return call_user_func_array('\\'.__NAMESPACE__.'::i18n', func_get_args());
				}

			/**
			 * Handles core translations (context: front-side).
			 *
			 * @return string {@inheritdoc}
			 *
			 * @see \websharks_core_v000000_dev::translate()
			 * @inheritdoc \websharks_core_v000000_dev::translate()
			 */
			public static function translate() // Arguments are NOT listed here.
				{
					return call_user_func_array('\\'.__NAMESPACE__.'::translate', func_get_args());
				}
		}

		/*
		 * Register autoloader.
		 */
		autoloader::add_root_ns(__NAMESPACE__);
		autoloader::add_classes_dir(dirname(dirname(__FILE__)));
		spl_autoload_register('\\'.__NAMESPACE__.'\\autoloader::load_ns_class');

		/*
		 * Easier access for those who don't care about the version.
		 */
		if(!class_exists('\\websharks_core_autoloader'))
			class_alias('\\'.__NAMESPACE__.'\\autoloader', 'websharks_core_autoloader');
	}
