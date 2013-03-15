<?php
/**
 * Object (Outside Scope) Utilities.
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
		 * Object (Outside Scope) Utilities.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 */
		class objects_os // Keep this out of scope.
		{
			/**
			 * Plugin/framework instance.
			 *
			 * @var framework Plugin/framework instance.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $plugin; // Defaults to a NULL value.

			/**
			 * Constructor.
			 *
			 * @param object|array $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or an explicit ``$___instance_config`` object/array will suffice also.
			 *
			 * @throws \exception If there is a missing and/or invalid ``$___instance_config``.
			 */
			public function __construct($___instance_config)
				{
					if($___instance_config instanceof framework)
						$plugin_root_ns = (string)strstr(get_class($___instance_config), '\\', TRUE);
					else if(is_object($___instance_config) && !empty($___instance_config->plugin_root_ns))
						$plugin_root_ns = (string)$___instance_config->plugin_root_ns;
					else if(is_array($___instance_config) && !empty($___instance_config['plugin_root_ns']))
						$plugin_root_ns = (string)$___instance_config['plugin_root_ns'];

					if(empty($plugin_root_ns) || !isset($GLOBALS[$plugin_root_ns]) || !($GLOBALS[$plugin_root_ns] instanceof framework))
						throw new \exception(sprintf(static::i18n('Invalid `$___instance_config` to constructor: `%1$s`'),
						                             print_r($___instance_config, TRUE))
						);
					$this->plugin = $GLOBALS[$plugin_root_ns];
				}

			/**
			 * Array of visible default properties for a given object (including static properties).
			 *
			 * @param string|object $class_object A class name (including any namespace prefixes), or an object instance.
			 *
			 * @return array Visible default properties (including static properties).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $foo = 'ut_foo_empty_class';
			 *    ($foo) === array()
			 *
			 * @assert $foo = '\\websharks_core_v000000_dev\\ut_foo_class_with_public_properties_methods';
			 *    ($foo) === array('public' => 'public', 'public_static' => 'public-static')
			 *
			 * @assert $foo = '\\websharks_core_v000000_dev\\ut_foo_class_with_public_protected_private_properties_methods';
			 *    ($foo) === array('public' => 'public', 'public_static' => 'public-static')
			 *
			 * @assert $foo = new ut_foo_empty_class();
			 *    ($foo) === array()
			 *
			 * @assert $foo = new ut_foo_class_with_public_properties_methods();
			 *    ($foo) === array('public' => 'public', 'public_static' => 'public-static')
			 *
			 * @assert $foo = new ut_foo_class_with_public_protected_private_properties_methods();
			 *    ($foo) === array('public' => 'public', 'public_static' => 'public-static')
			 */
			public function get_all_visible_default_properties($class_object)
				{
					$this->plugin->check_arg_types(array('string:!empty', 'object'), func_get_args());

					if(is_object($class_object))
						$class_name = get_class($class_object);
					else $class_name = $class_object;

					if(is_array($get_class_vars = get_class_vars($class_name)))
						return $get_class_vars;

					return array(); // Default return value.
				}

			/**
			 * Array of visible non-static properties for an object instance.
			 *
			 * @param object $object An object instance is required for this routine.
			 *
			 * @return array Visible non-static properties.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $foo = new ut_foo_empty_class();
			 *    ($foo) === array()
			 *
			 * @assert $foo = new ut_foo_class_with_public_properties_methods();
			 *    ($foo) === array('public' => 'public')
			 *
			 * @assert $foo = new ut_foo_class_with_public_protected_private_properties_methods();
			 *    ($foo) === array('public' => 'public')
			 */
			public function get_non_static_visible_properties($object)
				{
					$this->plugin->check_arg_types('object', func_get_args());

					if(is_array($get_object_vars = get_object_vars($object)))
						return $get_object_vars;

					return array(); // Default return value.
				}

			/**
			 * Array of visible object methods (including static methods).
			 *
			 * @param string|object $class_object A class name (including any namespace prefixes), or an object instance.
			 *
			 * @return array Visible object methods (including static methods).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $foo = '\\websharks_core_v000000_dev\\ut_foo_empty_class';
			 *    ($foo) === array()
			 *
			 * @assert $foo = '\\websharks_core_v000000_dev\\ut_foo_class_with_public_properties_methods';
			 *    ($foo) === array('public_method', 'public_static_method')
			 *
			 * @assert $foo = '\\websharks_core_v000000_dev\\ut_foo_class_with_public_protected_private_properties_methods';
			 *    ($foo) === array('public_method', 'public_static_method')
			 *
			 * @assert $foo = new ut_foo_empty_class();
			 *    ($foo) === array()
			 *
			 * @assert $foo = new ut_foo_class_with_public_properties_methods();
			 *    ($foo) === array('public_method', 'public_static_method')
			 *
			 * @assert $foo = new ut_foo_class_with_public_protected_private_properties_methods();
			 *    ($foo) === array('public_method', 'public_static_method')
			 */
			public function get_all_visible_methods($class_object)
				{
					$this->plugin->check_arg_types(array('string:!empty', 'object'), func_get_args());

					if(is_array($get_class_methods = get_class_methods($class_object)))
						return $get_class_methods;

					return array(); // Default return value.
				}

			/**
			 * Checks if variable is an object, and is NOT ass empty.
			 *
			 * @note PHP does NOT consider any object ``empty()``, so we have an additional layer of functionality here.
			 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
			 *
			 * @param mixed $var Any variable (by reference, no NOTICE).
			 *
			 * @return boolean TRUE if it's an object, and it's NOT ass empty, else FALSE.
			 *
			 * @assert $foo = new ut_foo_empty_class();
			 *    ($foo) === FALSE
			 *
			 * @assert $foo = new ut_foo_class_with_public_properties_methods();
			 *    ($foo) === TRUE
			 *
			 * @assert $foo = new ut_foo_class_with_protected_private_properties_methods();
			 *    ($foo) === FALSE
			 *
			 * @assert $foo = new ut_foo_class_with_public_protected_private_properties_methods();
			 *    ($foo) === TRUE
			 */
			public function is_not_ass_empty(&$var)
				{
					if(is_object($var) && !empty($var))
						{
							if($this->get_all_visible_default_properties($var)
							   || $this->get_non_static_visible_properties($var)
							   || $this->get_all_visible_methods($var)
							) return TRUE;
						}
					return FALSE;
				}

			/**
			 * Same as ``$this->is_not_ass_empty()``, but this allows an expression.
			 *
			 * @param mixed $var A variable (or an expression).
			 *
			 * @return boolean See ``$this->is_not_ass_empty()`` for further details.
			 */
			public function ¤is_not_ass_empty($var)
				{
					if(is_object($var) && !empty($var))
						{
							if($this->get_all_visible_default_properties($var)
							   || $this->get_non_static_visible_properties($var)
							   || $this->get_all_visible_methods($var)
							) return TRUE;
						}
					return FALSE;
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
	}