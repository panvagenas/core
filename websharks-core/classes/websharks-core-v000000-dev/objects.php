<?php
/**
 * Object Utilities.
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
		 * Object Utilities.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class objects extends framework
		{
			/**
			 * Short version of ``(isset() && is_object())``.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @param mixed $var A variable by reference (no NOTICE).
			 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
			 *
			 * @return boolean TRUE if the variable ``(isset() && is_object())``, else FALSE.
			 *
			 * @assert $string = '';
			 *    ($string) === FALSE
			 *
			 * @assert $integer = 1;
			 *    ($integer) === FALSE
			 *
			 * @assert $obj = new \stdClass();
			 *    ($obj) === TRUE
			 *
			 * @assert $array = array();
			 *    ($array) === FALSE
			 *
			 * @assert ($foo) === FALSE
			 */
			public function is(&$var)
				{
					if(isset($var) && is_object($var))
						return TRUE;

					return FALSE;
				}

			/**
			 * Same as ``$this->is()``, but this allows an expression.
			 *
			 * @param mixed $var A variable (or an expression).
			 *
			 * @return boolean See ``$this->is()`` for further details.
			 */
			public function ¤is($var)
				{
					if(isset($var) && is_object($var))
						return TRUE;

					return FALSE;
				}

			/**
			 * Short version of ``(!empty() && is_object() && NOT ass empty)``.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @param mixed $var A variable by reference (no NOTICE).
			 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
			 *
			 * @return boolean TRUE if the variable is ``(!empty() && is_object() && NOT ass empty)``, else FALSE.
			 *
			 * @note PHP does NOT consider any object ``empty()``, so we have an additional layer of functionality here.
			 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
			 *
			 * @assert $string = '';
			 *    ($string) === FALSE
			 *
			 * @assert $string = '1';
			 *    ($string) === FALSE
			 *
			 * @assert $integer = 1;
			 *    ($integer) === FALSE
			 *
			 * @assert $array = array();
			 *    ($array) === FALSE
			 *
			 * @assert $obj = new \stdClass();
			 *    ($obj) === FALSE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello';
			 *    ($obj) === TRUE
			 *
			 * @assert $array = array(1);
			 *    ($array) === FALSE
			 *
			 * @assert ($foo) === FALSE
			 */
			public function is_not_ass_empty(&$var)
				{
					if($this->©object_os->is_not_ass_empty($var))
						return TRUE;

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
					if($this->©object_os->¤is_not_ass_empty($var))
						return TRUE;

					return FALSE;
				}

			/**
			 * Short version of ``if(isset() && is_object()){} else{}``.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @param mixed   $var A variable by reference (no NOTICE).
			 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
			 *
			 * @param mixed   $or Defaults to ``stdClass``. This is the return value if ``$var`` is NOT set, or is NOT an object.
			 *
			 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of ``$var`` will be set (via reference) to the return value.
			 *
			 * @return object|mixed Value of ``$var``, if ``(isset() && is_object())``.
			 *    Else returns ``$or`` (which could be any mixed data type — defaults to ``stdClass``).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $a = 'a';
			 *    ($a) !== 'a'
			 * @assert $a = FALSE;
			 *    ($a, new \stdClass) !== FALSE
			 * @assert $_0 = 0;
			 *    ($_0, new \stdClass) !== 0
			 * @assert $obj = new \stdClass();
			 *    ($obj, new \stdClass) === $obj
			 * @assert $empty_array = array();
			 *    ($empty_array, new \stdClass) !== array()
			 * @assert $array = array('2');
			 *    ($array, new \stdClass) !== array('2')
			 *
			 * @assert ($foo, new \stdClass) !== NULL
			 */
			public function isset_or(&$var, $or = NULL, $set_var = FALSE)
				{
					if(isset($var) && is_object($var))
						return $var;

					$or = (func_num_args() >= 2) ? $or : new \stdClass();

					if($set_var)
						return ($var = $or);

					return $or;
				}

			/**
			 * Same as ``$this->isset_or()``, but this allows an expression.
			 *
			 * @param mixed $var A variable (or an expression).
			 *
			 * @param mixed $or This is the return value if ``$var`` is NOT set, or is NOT an object.
			 *
			 * @note This does NOT support the ``$set_var`` parameter, because ``$var`` is NOT by reference here.
			 *
			 * @return object|mixed See ``$this->isset_or()`` for further details.
			 */
			public function ¤isset_or($var, $or = NULL)
				{
					if(isset($var) && is_object($var))
						return $var;

					$or = (func_num_args() >= 2) ? $or : new \stdClass();

					return $or;
				}

			/**
			 * Short version of ``if(!empty() && is_object() and NOT ass empty){} else{}``.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @param mixed   $var A variable by reference (no NOTICE).
			 *    If ``$var`` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
			 *
			 * @param mixed   $or Defaults to ``stdClass``. This is the return value if ``$var`` IS empty, or is NOT an object.
			 *
			 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of ``$var`` will be set (via reference) to the return value.
			 *
			 * @return object|mixed Value of ``$var``, if ``(!empty() && is_object() and NOT ass empty)``.
			 *    Else returns ``$or`` (which could be any mixed data type — defaults to ``stdClass``).
			 *
			 * @note PHP does NOT consider any object ``empty()``, so we have an additional layer of functionality here.
			 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $a = 'a';
			 *    ($a) !== 'a'
			 * @assert $a = FALSE;
			 *    ($a, new \stdClass) !== FALSE
			 * @assert $_0 = 0;
			 *    ($_0, new \stdClass) !== 0
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello';
			 *    ($obj, new \stdClass) === $obj
			 * @assert $obj = new \stdClass();
			 *    ($obj, new \stdClass) !== $obj
			 * @assert $empty_array = array();
			 *    ($empty_array, new \stdClass) !== array()
			 * @assert $array = array('2');
			 *    ($array, new \stdClass) !== array('2')
			 *
			 * @assert ($foo, new \stdClass) !== NULL
			 */
			public function is_not_ass_empty_or(&$var, $or = NULL, $set_var = FALSE)
				{
					if($this->©object_os->is_not_ass_empty($var))
						return $var;

					$or = (func_num_args() >= 2) ? $or : new \stdClass();

					if($set_var)
						return ($var = $or);

					return $or;
				}

			/**
			 * Same as ``$this->is_not_ass_empty_or()``, but this allows an expression.
			 *
			 * @param mixed $var A variable (or an expression).
			 *
			 * @param mixed $or This is the return value if ``$var`` IS empty, or is NOT an object.
			 *
			 * @note This does NOT support the ``$set_var`` parameter, because ``$var`` is NOT by reference here.
			 *
			 * @return object|mixed See ``$this->is_not_ass_empty_or()`` for further details.
			 */
			public function ¤is_not_ass_empty_or($var, $or = NULL)
				{
					if($this->©object_os->¤is_not_ass_empty($var))
						return $var;

					$or = (func_num_args() >= 2) ? $or : new \stdClass();

					return $or;
				}

			/**
			 * Check if object values are set.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @note Max 26 arguments by reference. If vars are/were NOT already set,
			 *    they will be set to NULL by PHP, as a result of passing them by reference.
			 *    Starting with argument #27, vars cannot be passed by reference.
			 *
			 * @param mixed $a
			 * @param mixed $b
			 * @param mixed $c
			 * @param mixed $d
			 * @param mixed $e
			 * @param mixed $f
			 * @param mixed $g
			 * @param mixed $h
			 * @param mixed $i
			 * @param mixed $j
			 * @param mixed $k
			 * @param mixed $l
			 * @param mixed $m
			 * @param mixed $n
			 * @param mixed $o
			 * @param mixed $p
			 * @param mixed $q
			 * @param mixed $r
			 * @param mixed $s
			 * @param mixed $t
			 * @param mixed $u
			 * @param mixed $v
			 * @param mixed $w
			 * @param mixed $x
			 * @param mixed $y
			 * @param mixed $z
			 * @params-variable-length
			 *
			 * @return boolean TRUE if all arguments are objects, else FALSE.
			 *
			 * @assert $a = 'a';
			 *    ($a, $b) === FALSE
			 * @assert $a = new \stdClass();
			 *    ($a, $b) === FALSE
			 * @assert $_0 = 0; $c = new \stdClass();
			 *    ($_0, $c) === FALSE
			 * @assert $obj = new \stdClass();
			 *    ($obj, $obj, $obj) === TRUE
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello';
			 *    ($obj, $obj, $obj) === TRUE
			 * @assert $empty_array = array();
			 *    ($empty_array) === FALSE
			 * @assert $array = array('2');
			 *    ($array) === FALSE
			 *
			 * @assert ($foo, $foo, $foo) === FALSE
			 */
			public function are_set(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
				{
					foreach(func_get_args() as $_arg)
						if(!isset($_arg) || !is_object($_arg))
							return FALSE;
					unset($_arg);

					return TRUE;
				}

			/**
			 * Same as ``$this->are_set()``, but this allows expressions.
			 *
			 * @param mixed $a At least one variable (or an expression).
			 *
			 * @return boolean See ``$this->are_set()`` for further details.
			 */
			public function ¤are_set($a)
				{
					foreach(func_get_args() as $_arg)
						if(!isset($_arg) || !is_object($_arg))
							return FALSE;
					unset($_arg);

					return TRUE;
				}

			/**
			 * Check if object values are NOT ass empty.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @note PHP does NOT consider any object ``empty()``, so we have an additional layer of functionality here.
			 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
			 *
			 * @note Max 26 arguments by reference. If vars are/were NOT already set,
			 *    they will be set to NULL by PHP, as a result of passing them by reference.
			 *    Starting with argument #27, vars cannot be passed by reference.
			 *
			 * @param mixed $a
			 * @param mixed $b
			 * @param mixed $c
			 * @param mixed $d
			 * @param mixed $e
			 * @param mixed $f
			 * @param mixed $g
			 * @param mixed $h
			 * @param mixed $i
			 * @param mixed $j
			 * @param mixed $k
			 * @param mixed $l
			 * @param mixed $m
			 * @param mixed $n
			 * @param mixed $o
			 * @param mixed $p
			 * @param mixed $q
			 * @param mixed $r
			 * @param mixed $s
			 * @param mixed $t
			 * @param mixed $u
			 * @param mixed $v
			 * @param mixed $w
			 * @param mixed $x
			 * @param mixed $y
			 * @param mixed $z
			 * @params-variable-length
			 *
			 * @return boolean TRUE if all arguments are objects, and they're NOT ass empty, else FALSE.
			 *
			 * @note PHP does NOT consider any object ``empty()``, so we have an additional layer of functionality here.
			 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
			 *
			 * @assert $a = 'a';
			 *    ($a, $b) === FALSE
			 * @assert $a = new \stdClass();
			 *    ($a, $b) === FALSE
			 * @assert $_0 = 0; $c = new \stdClass();
			 *    ($_0, $c) === FALSE
			 * @assert $obj = new \stdClass();
			 *    ($obj, $obj, $obj) === FALSE
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello';
			 *    ($obj, $obj, $obj) === TRUE
			 * @assert $empty_array = array();
			 *    ($empty_array) === FALSE
			 * @assert $array = array('2');
			 *    ($array) === FALSE
			 *
			 * @assert ($foo, $foo, $foo) === FALSE
			 */
			public function are_not_ass_empty(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
				{
					foreach(func_get_args() as $_arg)
						if(!$this->©object_os->is_not_ass_empty($_arg))
							return FALSE;
					unset($_arg);

					return TRUE;
				}

			/**
			 * Same as ``$this->are_not_ass_empty()``, but this allows expressions.
			 *
			 * @param mixed $a At least one variable (or an expression).
			 *
			 * @return boolean See ``$this->are_not_ass_empty()`` for further details.
			 */
			public function ¤are_not_ass_empty($a)
				{
					foreach(func_get_args() as $_arg)
						if(!$this->©object_os->¤is_not_ass_empty($_arg))
							return FALSE;
					unset($_arg);

					return TRUE;
				}

			/**
			 * Check if objects are NOT ass empty in arrays/objects.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 *
			 * @note PHP does NOT consider any object ``empty()``, so we have an additional layer of functionality here.
			 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
			 *
			 * @note Max 26 arguments by reference. If vars are/were NOT already set,
			 *    they will be set to NULL by PHP, as a result of passing them by reference.
			 *    Starting with argument #27, vars cannot be passed by reference.
			 *
			 * @param mixed $a
			 * @param mixed $b
			 * @param mixed $c
			 * @param mixed $d
			 * @param mixed $e
			 * @param mixed $f
			 * @param mixed $g
			 * @param mixed $h
			 * @param mixed $i
			 * @param mixed $j
			 * @param mixed $k
			 * @param mixed $l
			 * @param mixed $m
			 * @param mixed $n
			 * @param mixed $o
			 * @param mixed $p
			 * @param mixed $q
			 * @param mixed $r
			 * @param mixed $s
			 * @param mixed $t
			 * @param mixed $u
			 * @param mixed $v
			 * @param mixed $w
			 * @param mixed $x
			 * @param mixed $y
			 * @param mixed $z
			 * @params-variable-length
			 *
			 * @return boolean TRUE if all arguments are objects or arrays containing objects; and none of the objects scanned deeply are empty; else FALSE.
			 *    Can have multidimensional arrays/objects containing objects.
			 *    Can have objects containing any property value; i.e. it's NOT an empty object.
			 *    Can have empty arrays; e.g. we consider these data containers.
			 *
			 * @note PHP does NOT consider any object ``empty()``, so we have an additional layer of functionality here.
			 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
			 *
			 * @assert $a = 'a';
			 *    ($a, $b) === FALSE
			 * @assert $a = new \stdClass();
			 *    ($a, $b) === FALSE
			 * @assert $_0 = 0; $c = new \stdClass();
			 *    ($_0, $c) === FALSE
			 * @assert $obj = new \stdClass();
			 *    ($obj, $obj, $obj) === FALSE
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello';
			 *    ($obj, $obj, $obj) === TRUE
			 * @assert $empty_array = array();
			 *    ($empty_array) === TRUE
			 * @assert $array = array('2');
			 *    ($array) === FALSE
			 *
			 * @assert $a = 'a'; $b = 'b'; $c = array('c');
			 *    ($a, $b, $c) === FALSE
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $a = $obj; $b = $obj; $c = array($obj);
			 *    ($a, $b, $c) === TRUE
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $a = $obj; $b = $obj; $c = array($obj, array($obj, array($obj, array($obj))));
			 *    ($a, $b, $c) === TRUE
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $a = $obj; $b = $obj; $c = array($obj, array($obj, array($obj, array(1))));
			 *    ($a, $b, $c) === FALSE
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $a = $obj; $b = $obj; $c = array($obj, array($obj, array($obj, array(NULL))));
			 *    ($a, $b, $c) === FALSE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $a = $obj; $b = $obj; $c = array($obj, array($obj, array($obj, array($obj)))); $d = new \stdClass(); $d->a = NULL;
			 *    ($a, $b, $c, $d) === TRUE
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $a = $obj; $b = $obj; $c = array($obj, array($obj, array($obj, array($obj)))); $d = new \stdClass(); $d->a = 0;
			 *    ($a, $b, $c, $d) === TRUE
			 * @assert $a = 1; $b = 1; $c = array(1, array(1, array(1, array(1)))); $d = new \stdClass(); $d->a = 1.2;
			 *    ($a, $b, $c, $d) === FALSE
			 *
			 * @assert ($foo, $foo, $foo) === FALSE
			 */
			public function are_not_ass_empty_in(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
				{
					$in_object = '.objects.are_not_ass_empty_in.in-object.b';
					// Recursion identifier (while inside an object).

					foreach(func_get_args() as $_arg)
						{
							if(is_array($_arg))
								{
									foreach($_arg as $__arg)
										if(!$this->are_not_ass_empty_in($__arg))
											return FALSE;
									unset($__arg);
								}
							else if(is_object($_arg))
								{
									if(!$this->©object_os->is_not_ass_empty($_arg))
										return FALSE;

									foreach($_arg as $__arg)
										if(!$this->are_not_ass_empty_in($__arg, $in_object))
											return FALSE;
									unset($__arg);
								}
							else if($b !== $in_object)
								return FALSE;
						}
					unset($_arg);

					return TRUE;
				}

			/**
			 * Same as ``$this->are_not_ass_empty_in()``, but this allows expressions.
			 *
			 * @param mixed $a At least one variable (or an expression).
			 * @param mixed $b Recursion identifier (while inside an object).
			 *
			 * @return boolean See ``$this->are_not_ass_empty_in()`` for further details.
			 */
			public function ¤are_not_ass_empty_in($a, $b)
				{
					$in_object = '.objects.¤are_not_ass_empty_in.in-object.b';
					// Recursion identifier (while inside an object).

					foreach(func_get_args() as $_arg)
						{
							if(is_array($_arg))
								{
									foreach($_arg as $__arg)
										if(!$this->are_not_ass_empty_in($__arg))
											return FALSE;
									unset($__arg);
								}
							else if(is_object($_arg))
								{
									if(!$this->©object_os->¤is_not_ass_empty($_arg))
										return FALSE;

									foreach($_arg as $__arg)
										if(!$this->¤are_not_ass_empty_in($__arg, $in_object))
											return FALSE;
									unset($__arg);
								}
							else if($b !== $in_object)
								return FALSE;
						}
					unset($_arg);

					return TRUE;
				}

			/**
			 * NOT ass empty coalesce.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @note PHP does NOT consider any object ``empty()``, so we have an additional layer of functionality here.
			 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
			 *
			 * @note Max 26 arguments by reference. If vars are/were NOT already set,
			 *    they will be set to NULL by PHP, as a result of passing them by reference.
			 *    Starting with argument #27, vars cannot be passed by reference.
			 *
			 * @param mixed $a
			 * @param mixed $b
			 * @param mixed $c
			 * @param mixed $d
			 * @param mixed $e
			 * @param mixed $f
			 * @param mixed $g
			 * @param mixed $h
			 * @param mixed $i
			 * @param mixed $j
			 * @param mixed $k
			 * @param mixed $l
			 * @param mixed $m
			 * @param mixed $n
			 * @param mixed $o
			 * @param mixed $p
			 * @param mixed $q
			 * @param mixed $r
			 * @param mixed $s
			 * @param mixed $t
			 * @param mixed $u
			 * @param mixed $v
			 * @param mixed $w
			 * @param mixed $x
			 * @param mixed $y
			 * @param mixed $z
			 * @params-variable-length
			 *
			 * @return object The first object argument that's NOT ass empty, else `stdClass`.
			 *
			 * @note PHP does NOT consider any object ``empty()``, so we have an additional layer of functionality here.
			 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
			 *
			 * @assert $a = 0; $b = new \stdClass(); $c = new \stdClass(); $c->hello = 'hello';
			 *    ($foo, $a, $b, $c) === $c
			 *
			 * @assert $NULL = NULL; $b = new \stdClass();
			 *    ($b, $NULL, $foo) !== $b
			 *
			 * @assert $NULL = NULL; $b = new \stdClass(); $c = new \stdClass(); $c->hello = 'hello';
			 *    ($c, $b, $NULL, $foo) === $c
			 *
			 * @assert ($foo, $foo, $foo) !== NULL
			 */
			public function not_ass_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
				{
					foreach(func_get_args() as $_arg)
						if($this->©object_os->is_not_ass_empty($_arg))
							return $_arg;
					unset($_arg);

					return new \stdClass();
				}

			/**
			 * Same as ``$this->not_ass_empty_coalesce()``, but this allows expressions.
			 *
			 * @param mixed $a At least one variable (or an expression).
			 *
			 * @return object See ``$this->not_ass_empty_coalesce()`` for further details.
			 */
			public function ¤not_ass_empty_coalesce($a)
				{
					foreach(func_get_args() as $_arg)
						if($this->©object_os->¤is_not_ass_empty($_arg))
							return $_arg;
					unset($_arg);

					return new \stdClass();
				}

			/**
			 * Is set coalesce.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @note Max 26 arguments by reference. If vars are/were NOT already set,
			 *    they will be set to NULL by PHP, as a result of passing them by reference.
			 *    Starting with argument #27, vars cannot be passed by reference.
			 *
			 * @param mixed $a
			 * @param mixed $b
			 * @param mixed $c
			 * @param mixed $d
			 * @param mixed $e
			 * @param mixed $f
			 * @param mixed $g
			 * @param mixed $h
			 * @param mixed $i
			 * @param mixed $j
			 * @param mixed $k
			 * @param mixed $l
			 * @param mixed $m
			 * @param mixed $n
			 * @param mixed $o
			 * @param mixed $p
			 * @param mixed $q
			 * @param mixed $r
			 * @param mixed $s
			 * @param mixed $t
			 * @param mixed $u
			 * @param mixed $v
			 * @param mixed $w
			 * @param mixed $x
			 * @param mixed $y
			 * @param mixed $z
			 * @params-variable-length
			 *
			 * @return object The first object argument, else `stdClass`.
			 *
			 * @assert $a = 0; $b = new \stdClass();
			 *    ($foo, $a, $b) === $b
			 *
			 * @assert $NULL = NULL; $b = new \stdClass();
			 *    ($b, $NULL, $foo) === $b
			 *
			 * @assert ($foo, $foo, $foo) !== NULL
			 */
			public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
				{
					foreach(func_get_args() as $_arg)
						if(isset($_arg) && is_object($_arg))
							return $_arg;
					unset($_arg);

					return new \stdClass();
				}

			/**
			 * Same as ``$this->isset_coalesce()``, but this allows expressions.
			 *
			 * @param mixed $a At least one variable (or an expression).
			 *
			 * @return boolean See ``$this->isset_coalesce()`` for further details.
			 */
			public function ¤isset_coalesce($a)
				{
					foreach(func_get_args() as $_arg)
						if(isset($_arg) && is_object($_arg))
							return $_arg;
					unset($_arg);

					return new \stdClass();
				}

			/**
			 * Forces an initial object value (NOT a deep scan).
			 *
			 * @param mixed $value Anything can be converted to an object.
			 *
			 * @return object Objectified value. This forces an initial object value at all times.
			 *    This automatically includes both scalars and resources too.
			 *
			 * @note Scalar and/or resource values (when converted to objects), result in an object with a single `scalar` property value.
			 *
			 * @see {@link http://www.php.net/manual/en/language.types.object.php#language.types.object.casting}
			 *
			 * @assert $obj = new \stdClass();
			 *    ($obj) === $obj
			 *
			 * @assert $integer = 1;
			 *    ($integer) is-type 'object'
			 *
			 * @assert $string = '1';
			 *    ($string) is-type 'object'
			 *
			 * @assert $resource = tmpfile();
			 *    ($resource) is-type 'object'
			 *
			 * @note Very difficult to unit test this particular routine.
			 *    Due to the nature of object instances, it's difficult to compare things here.
			 */
			public function ify($value)
				{
					return (object)$value;
				}

			/**
			 * Forces object values deeply (and intuitively).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 *    Arrays convert to objects. Each array is then scanned deeply as an object value.
			 *
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed   $value Anything can be converted to an object.
			 *    However, please see the details regarding parameter ``$include_scalars_resources``.
			 *    By default, we do NOT objectify scalars and/or resources in this routine.
			 *
			 * @param boolean $include_scalars_resources Optional. Defaults to FALSE. By default, we do NOT objectify scalars and/or resources.
			 *    Typecasting scalars and/or resources to objects, counterintuitively results in an object with a single `scalar` property.
			 *    While this might be desirable in some cases, it is FALSE by default. Set this as TRUE, to enable such behavior.
			 *
			 * @return object|mixed Objectified value. Even arrays are converted into object values by this routine.
			 *    However, this method may also return other mixed value types, depending on the parameter: ``$include_scalars_resources``.
			 *    If ``$include_scalars_resources`` is FALSE (it is by default); passing a scalar and/or resource value into this method,
			 *    will result in a return value that is unchanged (i.e. by default we do NOT objectify scalars and/or resources).
			 *
			 * @note Scalar and/or resource values (when/if converted to objects), result in an object with a single `scalar` property value.
			 *
			 * @see {@link http://www.php.net/manual/en/language.types.object.php#language.types.object.casting}
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $obj = new \stdClass();
			 *    ($obj) === $obj
			 *
			 * @assert $integer = 1;
			 *    ($integer) is-type 'integer'
			 *
			 * @assert $integer = 1;
			 *    ($integer, TRUE) is-type 'object'
			 *
			 * @assert $resource = tmpfile();
			 *    ($resource) is-type 'resource'
			 *
			 * @assert $resource = tmpfile();
			 *    ($resource, TRUE) is-type 'object'
			 *
			 * @assert $array = array(1, 2, array(1, 2, 3));
			 *    ($array) is-type 'object'
			 *
			 * @assert $array = array(1, 2, array(1, 2, 3));
			 *    ($array) is-type 'object'
			 *
			 * @note Very difficult to unit test this particular routine.
			 *    Due to the nature of object instances, it's difficult to compare things here.
			 */
			public function ify_deep($value, $include_scalars_resources = FALSE)
				{
					$this->check_arg_types('', 'boolean', func_get_args());

					if(is_array($value) || is_object($value))
						{
							if(is_array($value))
								$value = (object)$value;

							foreach($value as &$_value)
								$_value = $this->ify_deep($_value, $include_scalars_resources);
							unset($_value);

							return $value;
						}
					else if($include_scalars_resources)
						return (object)$value;
					else return $value;
				}
		}
	}