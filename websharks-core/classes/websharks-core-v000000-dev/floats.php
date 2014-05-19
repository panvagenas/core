<?php
/**
 * Float Utilities.
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
	 * Float Utilities.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class floats extends framework
	{
		/**
		 * Short version of ``(isset() && is_float())``.
		 *
		 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable ``(isset() && is_float())``, else FALSE.
		 *
		 * @assert $string = '';
		 *    ($string) === FALSE
		 *
		 * @assert $integer = 1;
		 *    ($integer) === FALSE
		 *
		 * @assert $float = 0.1;
		 *    ($float) === TRUE
		 *
		 * @assert $float = 1.0;
		 *    ($float) === TRUE
		 *
		 * @assert $array = array();
		 *    ($array) === FALSE
		 *
		 * @assert ($foo) === FALSE
		 */
		public function is(&$var)
		{
			if(isset($var) && is_float($var))
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
			if(isset($var) && is_float($var))
				return TRUE;

			return FALSE;
		}

		/**
		 * Short version of ``(!empty() && is_float())``.
		 *
		 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable is ``(!empty() && is_float())``, else FALSE.
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
		 * @assert $float = 0.1;
		 *    ($float) === TRUE
		 *
		 * @assert $float = 1.0;
		 *    ($float) === TRUE
		 *
		 * @assert $array = array();
		 *    ($array) === FALSE
		 *
		 * @assert $array = array(1);
		 *    ($array) === FALSE
		 *
		 * @assert ($foo) === FALSE
		 */
		public function is_not_empty(&$var)
		{
			if(!empty($var) && is_float($var))
				return TRUE;

			return FALSE;
		}

		/**
		 * Same as ``$this->is_not_empty()``, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @return boolean See ``$this->is_not_empty()`` for further details.
		 */
		public function ¤is_not_empty($var)
		{
			if(!empty($var) && is_float($var))
				return TRUE;

			return FALSE;
		}

		/**
		 * Short version of ``if(isset() && is_float()){} else{}``.
		 *
		 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to `0.0`. This is the return value if ``$var`` is NOT set, or is NOT a float.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of ``$var`` will be set (via reference) to the return value.
		 *
		 * @return float|mixed Value of ``$var``, if ``(isset() && is_float())``.
		 *    Else returns ``$or`` (which could be any mixed data type — defaults to `0.0`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert $a = 'a';
		 *    ($a) === 0.0
		 * @assert $a = FALSE;
		 *    ($a, 4.0) === 4.0
		 * @assert $_0_0 = 0.0;
		 *    ($_0_0, 4.3) === 0.0
		 * @assert $zero = '0';
		 *    ($zero) === 0.0
		 * @assert $NULL = NULL;
		 *    ($NULL) === 0.0
		 * @assert $_2_34 = 2.34;
		 *    ($_2_34, 0.0) === 2.34
		 * @assert $_1_1 = 1.1;
		 *    ($_1_1) === 1.1
		 * @assert $empty_string = '';
		 *    ($empty_string, 5.3) === 5.3
		 * @assert $TRUE = TRUE;
		 *    ($TRUE, 6.4) === 6.4
		 * @assert $one = '1';
		 *    ($one, 3.4) === 3.4
		 * @assert $false = FALSE;
		 *    ($false, 1.0) === 1.0
		 *
		 * @assert $empty_array = array();
		 *    ($empty_array, 5.4) === 5.4
		 * @assert $array = array('2');
		 *    ($array, 5.3) === 5.3
		 *
		 * @assert ($foo, 7.0) === 7.0
		 * @assert ($foo, 0.1) === 0.1
		 * @assert ($foo, 234.444) === 234.444
		 */
		public function isset_or(&$var, $or = 0.0, $set_var = FALSE)
		{
			if(isset($var) && is_float($var))
				return $var;

			if($set_var)
				return ($var = $or);

			return $or;
		}

		/**
		 * Same as ``$this->isset_or()``, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @param mixed $or This is the return value if ``$var`` is NOT set, or is NOT a float.
		 *
		 * @note This does NOT support the ``$set_var`` parameter, because ``$var`` is NOT by reference here.
		 *
		 * @return float|mixed See ``$this->isset_or()`` for further details.
		 */
		public function ¤isset_or($var, $or = 0.0)
		{
			if(isset($var) && is_float($var))
				return $var;

			return $or;
		}

		/**
		 * Short version of ``if(!empty() && is_float()){} else{}``.
		 *
		 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If ``$var`` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to `0.0`. This is the return value if ``$var`` IS empty, or is NOT a float.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of ``$var`` will be set (via reference) to the return value.
		 *
		 * @return float|mixed Value of ``$var``, if ``(!empty() && is_float())``.
		 *    Else returns ``$or`` (which could be any mixed data type — defaults to `0.0`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert $a = 'a';
		 *    ($a) === 0.0
		 * @assert $a = FALSE;
		 *    ($a, 4.0) === 4.0
		 * @assert $_0_0 = 0.0;
		 *    ($_0_0, 4.2) === 4.2
		 * @assert $zero = '0';
		 *    ($zero) === 0.0
		 * @assert $NULL = NULL;
		 *    ($NULL) === 0.0
		 * @assert $_2_34 = 2.34;
		 *    ($_2_34, 0.0) === 2.34
		 * @assert $_0_1 = 0.1;
		 *    ($_0_1) === 0.1
		 * @assert $empty_string = '';
		 *    ($empty_string, 5.3) === 5.3
		 * @assert $TRUE = TRUE;
		 *    ($TRUE, 6.4) === 6.4
		 * @assert $_0_01 = 0.01;
		 *    ($_0_01, 3.4) === 0.01
		 * @assert $false = FALSE;
		 *    ($false, 1.0) === 1.0
		 *
		 * @assert $empty_array = array();
		 *    ($empty_array, 5.4) === 5.4
		 * @assert $array = array('2');
		 *    ($array, 5.3) === 5.3
		 *
		 * @assert ($foo, 7.0) === 7.0
		 * @assert ($foo, 0.3) === 0.3
		 * @assert ($foo, 234.444) === 234.444
		 */
		public function is_not_empty_or(&$var, $or = 0.0, $set_var = FALSE)
		{
			if(!empty($var) && is_float($var))
				return $var;

			if($set_var)
				return ($var = $or);

			return $or;
		}

		/**
		 * Same as ``$this->is_not_empty_or()``, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @param mixed $or This is the return value if ``$var`` IS empty, or is NOT a float.
		 *
		 * @note This does NOT support the ``$set_var`` parameter, because ``$var`` is NOT by reference here.
		 *
		 * @return float|mixed See ``$this->is_not_empty_or()`` for further details.
		 */
		public function ¤is_not_empty_or($var, $or = 0.0)
		{
			if(!empty($var) && is_float($var))
				return $var;

			return $or;
		}

		/**
		 * Check if float values are set.
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
		 * @return boolean TRUE if all arguments are floats, else FALSE.
		 *
		 * @assert $a = 'a';
		 *    ($a, $b) === FALSE
		 * @assert $a = new \stdClass();
		 *    ($a, $b) === FALSE
		 * @assert $_0 = 0; $c = new \stdClass();
		 *    ($_0, $c) === FALSE
		 * @assert $float = 1.1;
		 *    ($float, $float, $float) === TRUE
		 * @assert $float1 = 1.2; $float2 = 0.1; $float3 = 0.0;
		 *    ($float1, $float2, $float3) === TRUE
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
				if(!isset($_arg) || !is_float($_arg))
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
				if(!isset($_arg) || !is_float($_arg))
					return FALSE;
			unset($_arg);

			return TRUE;
		}

		/**
		 * Check if float values are NOT empty.
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
		 * @return boolean TRUE if all arguments are floats, and they're NOT empty, else FALSE.
		 *
		 * @assert $a = 'a'; $b = 'b';
		 *    ($a, $b) === FALSE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $_1_1 = 1.1; $_2_2 = 2.2;
		 *    ($_1_1, $_2_2) === TRUE
		 * @assert $_1_1 = 1.1; $_2 = 2;
		 *    ($_1_1, $_2) === FALSE
		 * @assert $_1 = 1; $_2 = 2;
		 *    ($_1, $_2) === FALSE
		 * @assert $_1 = 1; $a = 'a'; $b = 'b'; $empty_string = '';
		 *    ($_1, $a, $b, $empty_string) === FALSE
		 * @assert $non_empty_string = '-'; $another_non_empty_string = '-';
		 *    ($non_empty_string, $another_non_empty_string) === FALSE
		 *
		 * @assert ($foo, $foo, $foo) === FALSE
		 */
		public function are_not_empty(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(empty($_arg) || !is_float($_arg))
					return FALSE;
			unset($_arg);

			return TRUE;
		}

		/**
		 * Same as ``$this->are_not_empty()``, but this allows expressions.
		 *
		 * @param mixed $a At least one variable (or an expression).
		 *
		 * @return boolean See ``$this->are_not_empty()`` for further details.
		 */
		public function ¤are_not_empty($a)
		{
			foreach(func_get_args() as $_arg)
				if(empty($_arg) || !is_float($_arg))
					return FALSE;
			unset($_arg);

			return TRUE;
		}

		/**
		 * Check if float values are NOT empty in floats/arrays/objects.
		 *
		 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
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
		 * @return boolean TRUE if all arguments are floats — or arrays/objects containing floats; and NONE of the floats scanned deeply are empty; else FALSE.
		 *    Can have multidimensional arrays/objects containing floats.
		 *    Can have empty arrays; e.g. we consider these to be data containers.
		 *    Can have empty objects; e.g. we consider these data containers.
		 *
		 *
		 * @assert $a = 'a'; $b = 'b';
		 *    ($a, $b) === FALSE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $_1 = 1; $_2 = 2;
		 *    ($_1, $_2) === FALSE
		 * @assert $_1_1 = 1.1; $_2_2 = 2.2;
		 *    ($_1_1, $_2_2) === TRUE
		 * @assert $_1 = 1; $empty_string = '';
		 *    ($_1, $empty_string) === FALSE
		 * @assert $_1 = 1; $a = 'a'; $b = 'b'; $empty_string = '';
		 *    ($_1, $a, $b, $empty_string) === FALSE
		 * @assert $non_empty_string = '-'; $another_non_empty_string = '-';
		 *    ($non_empty_string, $another_non_empty_string) === FALSE
		 *
		 * @assert $a = 1.0; $b = 1.0; $c = array(1.0);
		 *    ($a, $b, $c) === TRUE
		 * @assert $a = 1; $b = 1.0; $c = array(1.0);
		 *    ($a, $b, $c) === FALSE
		 * @assert $a = 1.0; $b = 1.0; $c = array(1.0, array(1.0, array(1.0, array(1.0))));
		 *    ($a, $b, $c) === TRUE
		 * @assert $a = 0; $b = 1.0; $c = array(1.0, array(1.0, array(1.0, array(1.0))));
		 *    ($a, $b, $c) === FALSE
		 * @assert $a = 1.0; $b = 1.0; $c = array(1.0, array(1.0, array(1.0, array(NULL))));
		 *    ($a, $b, $c) === FALSE
		 *
		 * @assert $a = 1.0; $b = 1.0; $c = array(1.0, array(1.0, array(1.0, array(1.0)))); $d = new \stdClass(); $d->a = 1.0;
		 *    ($a, $b, $c, $d) === TRUE
		 * @assert $a = 1.0; $b = 1.0; $c = array(1.0, array(1.0, array(1.0, array(1.0)))); $d = new \stdClass(); $d->a = 0.0;
		 *    ($a, $b, $c, $d) === FALSE
		 * @assert $a = 1.0; $b = 1.0; $c = array(1.0, array(1.0, array(1.0, array(1.0)))); $d = new \stdClass(); $d->a = 2998;
		 *    ($a, $b, $c, $d) === FALSE
		 *
		 * @assert ($foo, $foo, $foo) === FALSE
		 */
		public function are_not_empty_in(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
			{
				if(is_array($_arg) || is_object($_arg))
				{
					foreach($_arg as $__arg)
						if(!$this->are_not_empty_in($__arg))
							return FALSE;
					unset($__arg);
				}
				else if(empty($_arg) || !is_float($_arg))
					return FALSE;
			}
			unset($_arg);

			return TRUE;
		}

		/**
		 * Same as ``$this->are_not_empty_in()``, but this allows expressions.
		 *
		 * @param mixed $a At least one variable (or an expression).
		 *
		 * @return boolean See ``$this->are_not_empty_in()`` for further details.
		 */
		public function ¤are_not_empty_in($a)
		{
			foreach(func_get_args() as $_arg)
			{
				if(is_array($_arg) || is_object($_arg))
				{
					foreach($_arg as $__arg)
						if(!$this->¤are_not_empty_in($__arg))
							return FALSE;
					unset($__arg);
				}
				else if(empty($_arg) || !is_float($_arg))
					return FALSE;
			}
			unset($_arg);

			return TRUE;
		}

		/**
		 * NOT empty coalesce.
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
		 * @return float The first float argument that's NOT empty, else `0.0`.
		 *
		 * @assert $a = 0; $b = 1.3;
		 *    ($a, $b) === 1.3
		 * @assert $NULL = NULL;
		 *    ($NULL) === 0.0
		 * @assert $_1 = 1; $_2 = 2;
		 *    ($_1, $_2) === 0.0
		 * @assert $_1 = 1; $empty_string = '';
		 *    ($_1, $empty_string) === 0.0
		 * @assert $_0_0 = 0.0; $empty_string = ''; $a = 1.9; $b = 2;
		 *    ($_0_0, $empty_string, $a, $b) === 1.9
		 * @assert $empty_string = ''; $another_empty_string = '';
		 *    ($empty_string, $another_empty_string) === 0.0
		 * @assert $_0_0 = 0.0; $a = 1.4; $non_empty_string = '-';
		 *    ($_0_0, $a, $non_empty_string) === 1.4
		 *
		 * @assert ($foo, $foo, $foo) === 0.0
		 */
		public function not_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_float($_arg))
					return $_arg;
			unset($_arg);

			return 0.0;
		}

		/**
		 * Same as ``$this->not_empty_coalesce()``, but this allows expressions.
		 *
		 * @param mixed $a At least one variable (or an expression).
		 *
		 * @return boolean See ``$this->not_empty_coalesce()`` for further details.
		 */
		public function ¤not_empty_coalesce($a)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_float($_arg))
					return $_arg;
			unset($_arg);

			return 0.0;
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
		 * @return float The first float argument, else `0.0`.
		 *
		 * @assert $a = 'a'; $b = 2.4;
		 *    ($a, $b) === 2.4
		 * @assert $NULL = NULL;
		 *    ($NULL) === 0.0
		 * @assert $_0 = 0; $_2 = 2;
		 *    ($_0, $_2) === 0.0
		 * @assert $two = '2'; $_0_0 = 0.0; $_1_0 = 1.0;
		 *    ($two, $_0_0, $_1_0) === 0.0
		 * @assert $_1 = 1; $a = 'a'; $b = 'b'; $empty_string = '';
		 *    ($_1, $a, $b, $empty_string) === 0.0
		 * @assert $_1 = 1; $empty_string = ''; $another_empty_string = ''; $a = 'a';
		 *    ($_1, $empty_string, $another_empty_string, $a) === 0.0
		 * @assert $empty_string = ''; $another_empty_string = ''; $non_empty_string = '-';
		 *    ($empty_string, $another_empty_string, $non_empty_string) === 0.0
		 * @assert $two = '2'; $TRUE = TRUE; $RESOURCE = tmpfile(); $_1 = 1; $_4_4 = 4.4;
		 *    ($two, $TRUE, $RESOURCE, $_1, $_4_4) === 4.4
		 *
		 * @assert ($foo, $foo, $foo) === 0.0
		 */
		public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_float($_arg))
					return $_arg;
			unset($_arg);

			return 0.0;
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
				if(isset($_arg) && is_float($_arg))
					return $_arg;
			unset($_arg);

			return 0.0;
		}

		/**
		 * Forces an initial float value (NOT a deep scan).
		 *
		 * @param !object $value Anything but an object.
		 *
		 * @return float Floatified value. This forces an initial float value at all times.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.float.php#language.types.float.casting}
		 *
		 * @assert (NULL) === 0.0
		 * @assert ('1') === 1.0
		 * @assert ('1.0') === 1.0
		 * @assert ('1.23') === 1.23
		 * @assert (TRUE) === 1.0
		 * @assert (FALSE) === 0.0
		 * @assert ('hello') === 0.0
		 * @assert (1.0) === 1.0
		 *
		 * @assert (array(1.2)) === 1.0
		 */
		public function ify($value)
		{
			$this->check_arg_types('!object', func_get_args());

			return (float)$value;
		}

		/**
		 * Forces float values deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
		 *
		 * @param mixed $value Anything can be converted to a float value.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @return float|array|object Floatified value, array, or an object.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.float.php#language.types.float.casting}
		 *
		 * @assert (NULL) === 0.0
		 * @assert ('1') === 1.0
		 * @assert ('1.0') === 1.0
		 * @assert ('1.23') === 1.23
		 * @assert (TRUE) === 1.0
		 * @assert (FALSE) === 0.0
		 * @assert ('hello') === 0.0
		 * @assert (1.0) === 1.0
		 *
		 * @assert (array(array(1), array(TRUE), array(FALSE))) === array(array(1.0), array(1.0), array(0.0))
		 * @assert (array(array(1), array(2.30))) === array(array(1.0), array(2.3))
		 * @assert $obj = new \stdClass(); $obj->prop = '1'; // Prop converts to float.
		 *    (array(array('hello'), array($obj))) === array(array(0.0), array($obj))
		 */
		public function ify_deep($value)
		{
			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->ify_deep($_value);
				unset($_value);

				return $value;
			}
			return (float)$value;
		}
	}
}