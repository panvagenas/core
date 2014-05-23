<?php
/**
 * Integer Utilities.
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
	 * Integer Utilities.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class integers extends framework
	{
		/**
		 * Short version of `(isset() && is_integer())`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable `(isset() && is_integer())`, else FALSE.
		 *
		 * @assert $string = '';
		 *    ($string) === FALSE
		 *
		 * @assert $integer = 1;
		 *    ($integer) === TRUE
		 *
		 * @assert $array = array();
		 *    ($array) === FALSE
		 *
		 * @assert ($foo) === FALSE
		 */
		public function is(&$var)
		{
			if(isset($var) && is_integer($var))
				return TRUE;

			return FALSE;
		}

		/**
		 * Same as `$this->is()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @return boolean See `$this->is()` for further details.
		 */
		public function ¤is($var)
		{
			if(isset($var) && is_integer($var))
				return TRUE;

			return FALSE;
		}

		/**
		 * Short version of `(!empty() && is_integer())`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable is `(!empty() && is_integer())`, else FALSE.
		 *
		 * @assert $string = '';
		 *    ($string) === FALSE
		 *
		 * @assert $string = '1';
		 *    ($string) === FALSE
		 *
		 * @assert $integer = 1;
		 *    ($integer) === TRUE
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
			if(!empty($var) && is_integer($var))
				return TRUE;

			return FALSE;
		}

		/**
		 * Same as `$this->is_not_empty()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @return boolean See `$this->is_not_empty()` for further details.
		 */
		public function ¤is_not_empty($var)
		{
			if(!empty($var) && is_integer($var))
				return TRUE;

			return FALSE;
		}

		/**
		 * Short version of `if(isset() && is_integer()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to `0`. This is the return value if `$var` is NOT set, or is NOT an integer.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return integer|mixed Value of `$var`, if `(isset() && is_integer())`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to `0`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert $a = 'a';
		 *    ($a) === 0
		 * @assert $a = FALSE;
		 *    ($a, 4) === 4
		 * @assert $_0 = 0;
		 *    ($_0, 4) === 0
		 * @assert $zero = '0';
		 *    ($zero) === 0
		 * @assert $NULL = NULL;
		 *    ($NULL) === 0
		 * @assert $_1 = 1;
		 *    ($_1) === 1
		 * @assert $empty_string = '';
		 *    ($empty_string, 5) === 5
		 * @assert $TRUE = TRUE;
		 *    ($TRUE, 6) === 6
		 * @assert $one = '1';
		 *    ($one, 3) === 3
		 * @assert $false = FALSE;
		 *    ($false, 1) === 1
		 *
		 * @assert $empty_array = array();
		 *    ($empty_array, 5) === 5
		 * @assert $array = array('2');
		 *    ($array, 5) === 5
		 *
		 * @assert ($foo, 7) === 7
		 * @assert ($foo, 1) === 1
		 * @assert ($foo, 234) === 234
		 */
		public function isset_or(&$var, $or = 0, $set_var = FALSE)
		{
			if(isset($var) && is_integer($var))
				return $var;

			if($set_var)
				return ($var = $or);

			return $or;
		}

		/**
		 * Same as `$this->isset_or()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @param mixed $or This is the return value if `$var` is NOT set, or is NOT an integer.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return integer|mixed See `$this->isset_or()` for further details.
		 */
		public function ¤isset_or($var, $or = 0)
		{
			if(isset($var) && is_integer($var))
				return $var;

			return $or;
		}

		/**
		 * Short version of `if(!empty() && is_integer()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to `0`. This is the return value if `$var` IS empty, or is NOT an integer.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return integer|mixed Value of `$var`, if `(!empty() && is_integer())`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to `0`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert $a = 'a';
		 *    ($a) === 0
		 * @assert $zero = '0';
		 *    ($zero) === 0
		 * @assert $_0 = 0;
		 *    ($zero, 4) === 4
		 * @assert $zero = '0';
		 *    ($zero, 4) === 4
		 * @assert $NULL = NULL;
		 *    ($NULL) === 0
		 * @assert $_1 = 1;
		 *    ($_1) === 1
		 * @assert $empty_string = '';
		 *    ($empty_string, 5) === 5
		 * @assert $TRUE = TRUE;
		 *    ($TRUE, 5) === 5
		 * @assert $one = '1';
		 *    ($one, 5) === 5
		 * @assert $false = FALSE;
		 *    ($false, 5) === 5
		 *
		 * @assert $empty_array = array();
		 *    ($empty_array, 6) === 6
		 * @assert $array = array('2');
		 *    ($array, 4) === 4
		 *
		 * @assert ($foo, 4) === 4
		 * @assert ($foo, 8) === 8
		 * @assert ($foo, 344) === 344
		 */
		public function is_not_empty_or(&$var, $or = 0, $set_var = FALSE)
		{
			if(!empty($var) && is_integer($var))
				return $var;

			if($set_var)
				return ($var = $or);

			return $or;
		}

		/**
		 * Same as `$this->is_not_empty_or()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @param mixed $or This is the return value if `$var` IS empty, or is NOT an integer.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return integer|mixed See `$this->is_not_empty_or()` for further details.
		 */
		public function ¤is_not_empty_or($var, $or = 0)
		{
			if(!empty($var) && is_integer($var))
				return $var;

			return $or;
		}

		/**
		 * Check if integer values are set.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
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
		 * @return boolean TRUE if all arguments are integers, else FALSE.
		 *
		 * @assert $a = 'a';
		 *    ($a, $b) === FALSE
		 * @assert $a = new \stdClass();
		 *    ($a, $b) === FALSE
		 * @assert $_0 = 0; $c = new \stdClass();
		 *    ($_0, $c) === FALSE
		 * @assert $integer = 1;
		 *    ($integer, $integer, $integer) === TRUE
		 * @assert $integer = 1; $float = 0.1;
		 *    ($integer, $integer, $integer, $float) === FALSE
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
				if(!isset($_arg) || !is_integer($_arg))
					return FALSE;
			unset($_arg);

			return TRUE;
		}

		/**
		 * Same as `$this->are_set()`, but this allows expressions.
		 *
		 * @param mixed $a At least one variable (or an expression).
		 *
		 * @return boolean See `$this->are_set()` for further details.
		 */
		public function ¤are_set($a)
		{
			foreach(func_get_args() as $_arg)
				if(!isset($_arg) || !is_integer($_arg))
					return FALSE;
			unset($_arg);

			return TRUE;
		}

		/**
		 * Check if integer values are NOT empty.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
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
		 * @return boolean TRUE if all arguments are integers, and they're NOT empty, else FALSE.
		 *
		 * @assert $a = 'a'; $b = 'b';
		 *    ($a, $b) === FALSE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $_1 = 1; $_2 = 2;
		 *    ($_1, $_2) === TRUE
		 * @assert $_1 = 1; $empty_string = '';
		 *    ($_1, $empty_string) === FALSE
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
				if(empty($_arg) || !is_integer($_arg))
					return FALSE;
			unset($_arg);

			return TRUE;
		}

		/**
		 * Same as `$this->are_not_empty()`, but this allows expressions.
		 *
		 * @param mixed $a At least one variable (or an expression).
		 *
		 * @return boolean See `$this->are_not_empty()` for further details.
		 */
		public function ¤are_not_empty($a)
		{
			foreach(func_get_args() as $_arg)
				if(empty($_arg) || !is_integer($_arg))
					return FALSE;
			unset($_arg);

			return TRUE;
		}

		/**
		 * Check if integer values are NOT empty in integers/arrays/objects.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
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
		 * @return boolean TRUE if all arguments are integers — or arrays/objects containing integers; and NONE of the integers scanned deeply are empty; else FALSE.
		 *    Can have multidimensional arrays/objects containing integers.
		 *    Can have empty arrays; e.g. we consider these to be data containers.
		 *    Can have empty objects; e.g. we consider these data containers.
		 *
		 * @assert $a = 'a'; $b = 'b';
		 *    ($a, $b) === FALSE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $_1 = 1; $_2 = 2;
		 *    ($_1, $_2) === TRUE
		 * @assert $_1 = 1; $empty_string = '';
		 *    ($_1, $empty_string) === FALSE
		 * @assert $_1 = 1; $a = 'a'; $b = 'b'; $empty_string = '';
		 *    ($_1, $a, $b, $empty_string) === FALSE
		 * @assert $non_empty_string = '-'; $another_non_empty_string = '-';
		 *    ($non_empty_string, $another_non_empty_string) === FALSE
		 *
		 * @assert $a = 'a'; $b = 'b'; $c = array('c');
		 *    ($a, $b, $c) === FALSE
		 * @assert $a = 1; $b = 2; $c = array(1);
		 *    ($a, $b, $c) === TRUE
		 * @assert $a = 1; $b = 1; $c = array(1, array(1, array(1, array(1))));
		 *    ($a, $b, $c) === TRUE
		 * @assert $a = 0; $b = 1; $c = array(1, array(1, array(1, array(1))));
		 *    ($a, $b, $c) === FALSE
		 * @assert $a = 1; $b = 1; $c = array(1, array(1, array(1, array(NULL))));
		 *    ($a, $b, $c) === FALSE
		 *
		 * @assert $a = 1; $b = 1; $c = array(1, array(1, array(1, array(1)))); $d = new \stdClass(); $d->a = 1;
		 *    ($a, $b, $c, $d) === TRUE
		 * @assert $a = 1; $b = 1; $c = array(1, array(1, array(1, array(1)))); $d = new \stdClass(); $d->a = 0;
		 *    ($a, $b, $c, $d) === FALSE
		 * @assert $a = 1; $b = 1; $c = array(1, array(1, array(1, array(1)))); $d = new \stdClass(); $d->a = 1.2;
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
				else if(empty($_arg) || !is_integer($_arg))
					return FALSE;
			}
			unset($_arg);

			return TRUE;
		}

		/**
		 * Same as `$this->are_not_empty_in()`, but this allows expressions.
		 *
		 * @param mixed $a At least one variable (or an expression).
		 *
		 * @return boolean See `$this->are_not_empty_in()` for further details.
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
				else if(empty($_arg) || !is_integer($_arg))
					return FALSE;
			}
			unset($_arg);

			return TRUE;
		}

		/**
		 * NOT empty coalesce.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
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
		 * @return integer The first integer argument that's NOT empty, else `0`.
		 *
		 * @assert $a = 0; $b = 1;
		 *    ($a, $b) === 1
		 * @assert $NULL = NULL;
		 *    ($NULL) === 0
		 * @assert $_1 = 1; $_2 = 2;
		 *    ($_1, $_2) === 1
		 * @assert $_1 = 1; $empty_string = '';
		 *    ($_1, $empty_string) === 1
		 * @assert $_1 = 1; $empty_string = ''; $a = 1; $b = 2;
		 *    ($_1, $empty_string, $a, $b) === 1
		 * @assert $empty_string = ''; $another_empty_string = '';
		 *    ($empty_string, $another_empty_string) === 0
		 * @assert $empty_string = ''; $a = 1; $non_empty_string = '-';
		 *    ($empty_string, $a, $non_empty_string) === 1
		 *
		 * @assert ($foo, $foo, $foo) === 0
		 */
		public function not_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_integer($_arg))
					return $_arg;
			unset($_arg);

			return 0;
		}

		/**
		 * Same as `$this->not_empty_coalesce()`, but this allows expressions.
		 *
		 * @param mixed $a At least one variable (or an expression).
		 *
		 * @return boolean See `$this->not_empty_coalesce()` for further details.
		 */
		public function ¤not_empty_coalesce($a)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_integer($_arg))
					return $_arg;
			unset($_arg);

			return 0;
		}

		/**
		 * Is set coalesce.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
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
		 * @return integer The first integer argument, else `0`.
		 *
		 * @assert $a = 'a'; $b = 1;
		 *    ($a, $b) === 1
		 * @assert $NULL = NULL;
		 *    ($NULL) === 0
		 * @assert $_0 = 0; $_2 = 2;
		 *    ($_0, $_2) === 0
		 * @assert $two = '2'; $_1 = 1; $empty_string = '';
		 *    ($two, $_1, $empty_string) === 1
		 * @assert $_1 = 1; $a = 'a'; $b = 'b'; $empty_string = '';
		 *    ($_1, $a, $b, $empty_string) === 1
		 * @assert $_1 = 1; $empty_string = ''; $another_empty_string = ''; $a = 'a';
		 *    ($_1, $empty_string, $another_empty_string, $a) === 1
		 * @assert $empty_string = ''; $another_empty_string = ''; $non_empty_string = '-';
		 *    ($empty_string, $another_empty_string, $non_empty_string) === 0
		 *
		 * @assert ($foo, $foo, $foo) === 0
		 */
		public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_integer($_arg))
					return $_arg;
			unset($_arg);

			return 0;
		}

		/**
		 * Same as `$this->isset_coalesce()`, but this allows expressions.
		 *
		 * @param mixed $a At least one variable (or an expression).
		 *
		 * @return boolean See `$this->isset_coalesce()` for further details.
		 */
		public function ¤isset_coalesce($a)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_integer($_arg))
					return $_arg;
			unset($_arg);

			return 0;
		}

		/**
		 * Forces an initial integer value (NOT a deep scan).
		 *
		 * @param !object $value Anything but an object.
		 *
		 * @return integer Intified value. This forces an initial integer value at all times.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.integer.php#language.types.integer.casting}
		 */
		public function ify($value)
		{
			$this->check_arg_types('!object', func_get_args());

			return (integer)$value;
		}

		/**
		 * Forces integer values deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed $value Any value can be converted to an integer.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @return integer|array|object Intified value, array, or an object.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.integer.php#language.types.integer.casting}
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
			return (integer)$value;
		}

		/**
		 * Finds the next highest power of 2 :-)
		 *
		 * @param integer $integer Any input integer value.
		 *
		 * @return integer Next highest power of 2.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function next_power_of_2($integer)
		{
			$this->check_arg_types('integer', func_get_args());

			if($integer <= 2) return 2;
			if($this->is_power_of_2($integer))
				return $integer;

			while(($integer_lsb = $integer & ($integer - 1)))
				$integer = $integer_lsb; // Minus LSB ;-)
			return ($power_of_2 = $integer << 1);
		}

		/**
		 * Checks if an integer is already a power of 2.
		 *
		 * @param integer $integer Any input integer value.
		 *
		 * @return boolean TRUE if it's a power of 2.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_power_of_2($integer)
		{
			$this->check_arg_types('integer', func_get_args());

			return !($integer & ($integer - 1));
		}

		/**
		 * Calculates percentage value.
		 *
		 * @param integer|float $value Amount/value to calculate.
		 *
		 * @param integer|float $of Percentage of what? Defaults to `100`.
		 *    NOTE: This value may NOT be empty. That's not possible to calculate.
		 *
		 * @param integer       $precision Optional. Defaults to `0`; no decimal place.
		 *
		 * @param boolean       $format_string Optional. Defaults to a FALSE value.
		 *    If this is TRUE, a string is returned; and it is formatted (e.g. `[percent]%`).
		 *
		 * @return integer|float Percentage. A float if `$precision` is passed; else an integer (default behavior).
		 *    If `$format_string` is TRUE, the value is always converted to string format (e.g. `[percent]%`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$of` is empty (e.g. NOT possible to calculate).
		 */
		public function percent($value, $of = 100, $precision = 0, $format_string = FALSE)
		{
			$this->check_arg_types(array('integer', 'float'), array('integer:!empty', 'float:!empty'), 'integer', 'boolean', func_get_args());

			$percent = number_format(($value / $of) * 100, $precision, '.', '');
			$percent = ($precision) ? (float)$percent : (integer)$percent;

			if($format_string) // Format (e.g. add suffix)?
				$percent .= '%';

			return $percent;
		}

		/**
		 * Calculates percentage difference.
		 *
		 * @param integer|float $from Amount to calculate from.
		 *
		 * @param integer|float $to Amount to calculate (e.g. the value now).
		 *
		 * @param integer       $precision Optional. Defaults to `0`; no decimal place.
		 *
		 * @param boolean       $format_string Optional. Defaults to a FALSE value.
		 *    If this is TRUE, a string is returned; and it is formatted (e.g. `+|-[percent]%`).
		 *
		 * @return integer|float|string Percentage. A float if `$precision` is passed; else an integer (default behavior).
		 *    If `$format_string` is TRUE, the value is always converted to string format (e.g. `+|-[percent]%`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function percent_diff($from, $to, $precision = 0, $format_string = FALSE)
		{
			$this->check_arg_types(array('integer', 'float'), array('integer', 'float'), 'integer', 'boolean', func_get_args());

			if(!$from) $from++ & $to++; // Stop division by `0`.
			$percent = number_format(($to - $from) * 100 / $from, $precision, '.', '');
			$percent = ($precision) ? (float)$percent : (integer)$percent;

			if($format_string) // Format return value (e.g. add a prefix/suffix)?
				$percent = ($percent > 0) ? '+'.$percent.'%' : $percent.'%';

			return $percent;
		}
	}
}