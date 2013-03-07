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
		class objects_os // Stand-alone. Keep this out of scope.
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
			 *    or a new ``$___instance_config`` array.
			 *
			 * @throws \exception If there is a missing and/or invalid ``$___instance_config``.
			 */
			public function __construct($___instance_config)
				{
					if($___instance_config instanceof framework)
						$___instance_config = $___instance_config->___instance_config;
					$___instance_config = (object)$___instance_config;

					if(!empty($___instance_config->plugin_root_ns)
					   && is_string($___instance_config->plugin_root_ns)
					   && isset($GLOBALS[$___instance_config->plugin_root_ns])
					   && $GLOBALS[$___instance_config->plugin_root_ns] instanceof framework
					) $this->plugin = $GLOBALS[$___instance_config->plugin_root_ns];

					else throw new \exception(
						sprintf(static::i18n('Invalid `$___instance_config` to constructor: `%1$s`'), print_r($___instance_config, TRUE))
					);
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
					if(is_string($class_object) || is_object($class_object))
						{
							if(is_object($class_object))
								$class_name = get_class($class_object);
							else $class_name = $class_object;

							if(is_array($get_class_vars = get_class_vars($class_name)))
								return $get_class_vars;

							return array(); // Default return value.
						}
					else throw $this->plugin->©exception(
						__METHOD__.'#invalid_args', array('args' => func_get_args()),
						$this->plugin->i18n('Expecting argument with string or object instance.')
					);
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
					if(is_object($object)) // Need an object instance here.
						{
							if(is_array($get_object_vars = get_object_vars($object)))
								return $get_object_vars;

							return array(); // Default return value.
						}
					else throw $this->plugin->©exception(
						__METHOD__.'#invalid_args', array('args' => func_get_args()),
						$this->plugin->i18n('Expecting argument with object instance.')
					);
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
					if(is_string($class_object) || is_object($class_object))
						{
							if(is_array($get_class_methods = get_class_methods($class_object)))
								return $get_class_methods;

							return array(); // Default return value.
						}
					else throw $this->plugin->©exception(
						__METHOD__.'#invalid_args', array('args' => func_get_args()),
						$this->plugin->i18n('Expecting argument with string or object instance.')
					);
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

					return _x($string, $context, $core_ns_stub_with_dashes);
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

					return _x($string, $context, $core_ns_stub_with_dashes);
				}
		}
	}