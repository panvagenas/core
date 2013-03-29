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
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @note This should NOT rely directly or indirectly on any other core class objects.
		 *    Any static properties/methods in the WebSharks™ Core stub will be fine to use though.
		 */
		final class autoloader // Static properties/methods only please.
		{
			/**
			 * Initialized yet?
			 *
			 * @var boolean Initialized yet?
			 */
			protected static $initialized = FALSE;

			/**
			 * Map of special classes.
			 *
			 * @var array Map of special classes.
			 */
			protected static $special_classes_map = array();

			/**
			 * Root namespaces to autoload for.
			 *
			 * @var array Root namespaces to autoload for.
			 */
			protected static $ns_roots = array();

			/**
			 * Core classes directory.
			 *
			 * @var string Core classes directory.
			 */
			protected static $core_classes_dir = '';

			/**
			 * Array of directories containing classes.
			 *
			 * @var array Array of directories containing classes.
			 */
			protected static $class_dirs = array();

			/**
			 * Initializes properties.
			 *
			 * @return boolean Returns the ``$initialized`` property w/ a TRUE value.
			 *
			 * @note Sets all class properties & registers autoload handler.
			 */
			public static function initialize()
				{
					if(static::$initialized)
						return TRUE; // Initialized already.

					$this_dir           = $dirname_x1 = stub::n_dir_seps(dirname(__FILE__));
					$core_classes_dir   = $dirname_x2 = dirname($dirname_x1);
					$stub_dir           = $dirname_x3 = dirname($dirname_x2);
					$this_externals_dir = $this_dir.'/externals';

					static::$special_classes_map = array( // Special classes (and their aliases).
						__NAMESPACE__           => $stub_dir.'/stub.php', 'websharks_core__stub' => $stub_dir.'/stub.php',
						'deps_'.__NAMESPACE__   => $this_dir.'/deps.php', 'websharks_core__deps' => $this_dir.'/deps.php',
						'deps_x_'.__NAMESPACE__ => $this_dir.'/deps-x.php', 'websharks_core__deps_x' => $this_dir.'/deps-x.php',
						'ws_js_minifier'        => $this_externals_dir.'/ws-js-minifier/ws-js-minifier.php',
						'ws_markdown'           => $this_externals_dir.'/ws-markdown/ws-markdown.php'
					);
					static::add_root_ns(__NAMESPACE__);
					static::$core_classes_dir = $core_classes_dir;
					static::add_classes_dir(static::$core_classes_dir);
					static::add_core_ns_class_alias(__CLASS__);

					spl_autoload_register('\\'.__CLASS__.'::load_ns_class');

					return (static::$initialized = TRUE);
				}

			/**
			 * Handles class autoloading.
			 *
			 * @note Capable of loading classes for any portion of the WebSharks™ Core.
			 *    Can also load classes for plugins built on the WebSharks™ Core.
			 *
			 * @note This autoloader also handles WebSharks™ Core class aliases gracefully.
			 *
			 * @param string $ns_class A `namespace\class` to load (the PHP interpreter passes this in).
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 */
			public static function load_ns_class($ns_class)
				{
					if(!is_string($ns_class) || !$ns_class)
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					# Special classes (check this map first).

					if(!empty(static::$special_classes_map[$ns_class]))
						{
							include_once static::$special_classes_map[$ns_class];
							return; // We're all done here.
						}
					# WebSharks™ Core class aliases (these are created dynamically).

					if(strpos($ns_class, 'websharks_core__') === 0)
						{
							$is_core_class_alias       = TRUE; // We need to flag this here.
							$ns_class                  = str_replace(array('websharks_core__', '__'), array(__NAMESPACE__.'__', '\\'), $ns_class);
							$is_handling_class_root_ns = $root_ns = static::is_handling_class_root_ns($ns_class);

							if($is_handling_class_root_ns && class_exists('\\'.$ns_class))
								{ // ↑ The underlying class COULD be available already.

									static::add_core_ns_class_alias($ns_class);
									return; // We're all done here.
								}
						} # Else there are no transformations necessary.
					else $is_handling_class_root_ns = $root_ns = static::is_handling_class_root_ns($ns_class);

					# Only if it's in a namespace (and ONLY if we're handling it's root namespace).

					if($is_handling_class_root_ns && $root_ns) // Search all class directories.
						{
							$ns_class_file = str_replace(array('\\', '_'), array('/', '-'), $ns_class).'.php';

							foreach(static::$class_dirs as $_classes_dir) if(is_file($_classes_dir.'/'.$ns_class_file))
								{
									include_once $_classes_dir.'/'.$ns_class_file;

									if(!empty($is_core_class_alias)) // A core class alias?
										static::add_core_ns_class_alias($ns_class);

									return; // We're all done here.
								}
							unset($_classes_dir); // Housekeeping.
						}
				}

			/**
			 * Adds a new `classes` directory.
			 *
			 * @param string $classes_dir Any `classes` directory.
			 *
			 * @note This directory MUST use sub-directories with a `namespace/class` hierarchy.
			 *    Nested sub-namespaces are also supported in the same structure (i.e. `/namespace/sub_namespace/class`).
			 *    Underscores in any namespace and/or class should be replaced with dashes in the file structure.
			 *
			 * @return string The ``$classes_dir`` on success, else an empty string.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 * @throws \exception If ``$classes_dir`` is empty, or is NOT a `classes` directory.
			 *
			 * @note Each `classes` directory is pushed to the top of the stack by this routine.
			 *    This way ``load_ns_class()`` is looking for class files in the last directory first;
			 *    and then searching up the stack until it finds a matching class file.
			 *
			 *    This makes it possible for pro add-ons and/or other plugins integrated with the core,
			 *    to create classes that will override any that may already exist for a particular plugin.
			 *    For example, a pro add-on MAY wish to override default/free plugin classes.
			 *
			 *    However, the underlying core classes (when called explicitly); may NOT be overwritten.
			 *    We keep the core classes directory ALWAYS at the top of the stack when adding new directories.
			 *
			 * @note A plugin CAN override core classes (for use in that plugin); by extending core classes and placing them into
			 *    the plugin's own `classes` directory. That is NOT handled here though; it is handled with `©` dynamic class instances.
			 *    See: {@link \websharks_core_v000000_dev\framework::__get()}, {@link \websharks_core_v000000_dev\framework::__call()}
			 */
			public static function add_classes_dir($classes_dir)
				{
					if(!is_string($classes_dir) || !is_dir($classes_dir) || basename($classes_dir) !== 'classes')
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					$classes_dir = stub::n_dir_seps($classes_dir); // Normalize for comparison.

					if(!in_array($classes_dir, static::$class_dirs, TRUE))
						{
							array_unshift(static::$class_dirs, $classes_dir);
							static::$class_dirs = array_diff(static::$class_dirs, array(static::$core_classes_dir));
							array_unshift(static::$class_dirs, static::$core_classes_dir);
						}
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
					if(!is_string($root_ns) || !($root_ns = trim($root_ns, '\\')))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					if(!preg_match(stub::$regex_valid_plugin_root_ns, $root_ns))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Root namespace contains invalid chars: `%1$s`.'), $root_ns)
						);
					if(!in_array($root_ns, static::$ns_roots, TRUE))
						static::$ns_roots[] = $root_ns;

					return $root_ns; // Useful when debugging.
				}

			/**
			 * Adds a new core class alias.
			 *
			 * @param string $ns_or_ns_class A class path (including namespace); or ONLY the namespace.
			 *    If this is ONLY the namespace; ``$class_file`` MUST be passed in also.
			 *
			 * @param string $class_file Optional. If passed, ``$ns_or_ns_class`` is assumed to be the namespace only.
			 *
			 * @return boolean TRUE on success; else FALSE on failure (i.e. if alias already exists).
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 * @throws \exception If ``$ns_class`` is empty, or is NOT a valid core class name.
			 * @throws \exception If ``$ns_class`` is in a root namespace we are NOT handling.
			 * @throws \exception If ``$ns_class`` is NOT from this version of the core.
			 * @throws \exception If ``$ns_class`` is NOT already defined.
			 */
			public static function add_core_ns_class_alias($ns_or_ns_class, $class_file = '')
				{
					if(!is_string($ns_or_ns_class) || !($ns_or_ns_class = trim($ns_or_ns_class, '\\')) || !is_string($class_file))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					if($class_file) // Interpret ``$ns_or_ns_class`` as a namespace only.
						$ns_class = $ns_or_ns_class.'\\'.str_replace('-', '_', basename($class_file, '.php'));
					else $ns_class = $ns_or_ns_class; // Presume full class path.

					if(!preg_match(stub::$regex_valid_plugin_ns_class, $ns_class))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Namespace\\class contains invalid chars: `%1$s`.'), $ns_class)
						);
					if(!static::is_handling_class_root_ns($ns_class))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Namespace\\class NOT handled by autoloader: `%1$s`.'), $ns_class)
						);
					if(strpos($ns_class, __NAMESPACE__.'\\') !== 0)
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Namespace\\class is NOT from this core: `%1$s`.'), $ns_class)
						);
					if(!class_exists('\\'.$ns_class))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Namespace\\class does NOT exist yet: `%1$s`.'), $ns_class)
						);
					$alias = str_replace(array(__NAMESPACE__.'\\', '\\'), array('websharks_core\\', '__'), $ns_class);
					if(!class_exists('\\'.$alias)) // Only if it does NOT exist already.
						return class_alias('\\'.$ns_class, $alias);

					return FALSE; // Class alias already exists.
				}

			/**
			 * Handling autoloads for a given namespace?
			 *
			 * @param string $ns_or_ns_class Namespace or namespace\class.
			 *
			 * @return string The root namespace; else an empty string if NOT handling.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 */
			public static function is_handling_class_root_ns($ns_or_ns_class)
				{
					if(!is_string($ns_or_ns_class))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					if(!$ns_or_ns_class || !($root_ns = static::root_ns($ns_or_ns_class)))
						return ''; // Empty; there is no root namespace.

					return (in_array($root_ns, static::$ns_roots, TRUE)) ? $root_ns : '';
				}

			/**
			 * Root namespace.
			 *
			 * @param string $ns_or_ns_class Namespace or namespace\class.
			 *
			 * @return string The root namespace; else an empty string on failure.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 */
			public static function root_ns($ns_or_ns_class)
				{
					if(!is_string($ns_or_ns_class))
						throw new \exception( // Fail here; detected invalid arguments.
							sprintf(stub::i18n('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
						);
					if(!($ns_or_ns_class = trim($ns_or_ns_class, '\\')))
						return ''; // Catch empty values here.

					if(strpos($ns_or_ns_class, '\\') === FALSE || !($root_ns = strstr($ns_or_ns_class, '\\', TRUE)))
						$root_ns = $ns_or_ns_class;

					return $root_ns;
				}
		}

		/*
		 * Initialize the WebSharks™ Core autoloader.
		 */
		autoloader::initialize(); // Also registers the autoloader.
	}
