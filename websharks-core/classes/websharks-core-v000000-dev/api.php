<?php
/**
 * Base API Class.
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
		 * Base API Class.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 */
		class api // Stand-alone class.
		{
			/**
			 * Handles overload properties (dynamic classes).
			 *
			 * @param string $dyn_class A dynamic class object name
			 *    (w/o the `©` prefix) — simplifying usage.
			 *
			 * @return framework A singleton class instance.
			 */
			public function __get($dyn_class)
				{
					return $GLOBALS[get_class()]->{'©'.$dyn_class};
				}

			/**
			 * Handles overload methods (dynamic classes).
			 *
			 * @param string $dyn_class A dynamic class object name
			 *    (w/o the `©` prefix) — simplifying usage.
			 *
			 * @param array  $args Optional. Any arguments that should be
			 *    passed into the dynamic class constructor.
			 *
			 * @return framework A new dynamic class instance.
			 */
			public function __call($dyn_class, $args = array())
				{
					return call_user_func_array(array($GLOBALS[get_class()], '©'.$dyn_class), $args);
				}

			/**
			 * Handles overload methods (dynamic classes).
			 *
			 * @param string $dyn_class A dynamic class object name
			 *    (w/o the `©` prefix) — simplifying usage.
			 *
			 * @param array  $args Optional. If arguments are passed through,
			 *    a new dynamic class instance will be instantiated.
			 *
			 * @return framework A singleton class object instance.
			 *    (or a new dynamic class instance; if there are arguments).
			 */
			public static function __callStatic($dyn_class, $args = array())
				{
					if(!empty($args)) // Instantiate new class instance w/ arguments.
						return call_user_func_array(array($GLOBALS[get_called_class()], '©'.$dyn_class), $args);

					return $GLOBALS[get_called_class()]->{'©'.$dyn_class}; // Singleton.
				}
		}
	}