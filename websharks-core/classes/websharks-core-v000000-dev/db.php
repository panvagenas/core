<?php
/**
 * Database.
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
		 * Database.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 *
		 * @augments \wpdb
		 */
		class db extends framework
		{
			/**
			 * @var boolean TRUE if modifying plugin tables.
			 * @see ``$this->is_modifying_plugin_tables()`` for further details.
			 */
			public $is_modifying_plugin_tables = FALSE;

			/**
			 * Are we currently modifying plugin tables?
			 *
			 * @param null|boolean $is_modifying_plugin_tables Defaults to a NULL value.
			 *    If this is set, we'll update the current status of `is_modifying_plugin_tables`.
			 *
			 * @return boolean TRUE if modifying plugin tables, else FALSE by default.
			 */
			public function is_modifying_plugin_tables($is_modifying_plugin_tables = NULL)
				{
					$this->check_arg_types(array('null', 'boolean'), func_get_args());

					if(isset($is_modifying_plugin_tables))
						$this->is_modifying_plugin_tables = $is_modifying_plugin_tables;

					return $this->is_modifying_plugin_tables;
				}

			/**
			 * Checks overload properties (and dynamic singleton class instances).
			 *
			 * @param string $property Name of a valid overload property.
			 *    Or a dynamic class to check on, using the special class `©` prefix.
			 *
			 * @return boolean TRUE if the overload property (or dynamic singleton class instance) is set.
			 *    Otherwise, this will return FALSE by default (i.e. the property is NOT set).
			 */
			public function __isset($property)
				{
					// Bypassing ``is_string()``, ``check_arg_types()`` and NON-empty check here, in favor of typecasting.
					// Benchmark tests show a slight increase in performance this way, and since the PHP interpreter usually calls this, it's pretty safe.
					// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

					$property = (string)$property; // Typecasting this to a string value.

					if(property_exists($GLOBALS['wpdb'], $property))
						return isset($GLOBALS['wpdb']->$property);

					return parent::__isset($property); // Default return value.
				}

			/**
			 * Handles overload properties (and dynamic singleton class instances).
			 *
			 * @param string $property Name of a valid overload property.
			 *    Or a dynamic class to return an instance of, using the special class `©` prefix.
			 *
			 * @return mixed Dynamic property values, or a dynamic object instance; else an exception is thrown.
			 *    Dynamic class instances are defined explicitly in the docBlock above.
			 *    This way IDEs will jive with this dynamic behavior.
			 *
			 * @throws exception If ``$property`` CANNOT be defined in any way.
			 */
			public function __get($property)
				{
					// Bypassing ``is_string()``, ``check_arg_types()`` and NON-empty check here, in favor of typecasting.
					// Benchmark tests show a slight increase in performance this way, and since the PHP interpreter usually calls this, it's pretty safe.
					// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

					$property = (string)$property; // Typecasting this to a string value.

					if(property_exists($GLOBALS['wpdb'], $property))
						return $GLOBALS['wpdb']->$property;

					return parent::__get($property); // Default return value.
				}

			/**
			 * Handles overload methods (and dynamic class instances).
			 *
			 * @param string $method Name of a valid overload method to call upon.
			 *    Or a dynamic class to return an instance of, using the special class `©` prefix.
			 *    Or a dynamic singleton class method to call upon; also using the `©` prefix, along with a `.method_name` suffix.
			 *
			 * @param array  $args An array of arguments to the overload method, or dynamic class object constructor.
			 *    In the case of dynamic objects, it's fine to exclude the first argument, which is handled automatically by this routine.
			 *    That is, the first argument to any extender is always the parent instance (i.e. ``$this``).
			 *
			 * @return mixed Dynamic return values, or a dynamic object instance; else an exception is thrown.
			 *
			 * @throws exception If ``$method`` CANNOT be defined in any way.
			 */
			public function __call($method, $args)
				{
					// Bypassing ``is_string()``, ``check_arg_types()`` and NON-empty check here, in favor of typecasting.
					// Benchmark tests show a slight increase in performance this way, and since the PHP interpreter usually calls this, it's pretty safe.
					// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

					$method = (string)$method; // Typecasting this to a string value.
					$args   = (array)$args; // Typecast these arguments to an array value.

					if(method_exists($GLOBALS['wpdb'], $method)) // In the WordPress® database class?
						{
							if(!in_array($method, array('escape', '_real_escape'), TRUE)
							   && !$this->©plugin->is_active_at_current_version() && !$this->is_modifying_plugin_tables()
								// Stops plugin table queries, when plugin is NOT active at it's current version (on the current blog).
							) // NOTE: We try to catch `escape`, `_real_escape` early, to prevent any unnecessary processing here.
								{
									if(!empty($args[0]) && is_string($args[0])) // Can we inspect this argument?
										{
											$lc_method                        = strtolower($method);
											$plugin_tables_imploded_for_regex = $this->©db_tables->imploded_for_regex();

											if( // In all of these cases, we're looking at a full MySQL query string.
												(in_array($lc_method, array('query', 'get_var', 'get_row', 'get_col', 'get_results'), TRUE)
												 && preg_match('/`(?:'.$plugin_tables_imploded_for_regex.')`/', $args[0]))

												// In all of these cases, we're looking at a specific table name.
												|| (in_array($lc_method, array('insert', 'replace', '_insert_replace_helper', 'update', 'delete'), TRUE)
												    && preg_match('/^(?:'.$plugin_tables_imploded_for_regex.')$/', $args[0]))

											) return NULL; // Nullify. Stops plugin table queries.
										}
								} // Else call upon the WordPress® DB class.
							return call_user_func_array(array($GLOBALS['wpdb'], $method), $args);
						}
					return parent::__call($method, $args); // Default return value.
				}
		}
	}