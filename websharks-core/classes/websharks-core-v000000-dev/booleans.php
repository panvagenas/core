<?php
/**
 * Boolean Utilities.
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
	 * Boolean Utilities.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class booleans extends framework
	{
		/**
		 * Short version of ``(isset() && is_bool())``.
		 *
		 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable ``(isset() && is_bool())``, else FALSE.
		 *
		 * @assert $string = '';
		 *    ($string) === FALSE
		 *
		 * @assert $boolean = TRUE;
		 *    ($boolean) === TRUE
		 *
		 * @assert $boolean = FALSE;
		 *    ($boolean) === TRUE
		 *
		 * @assert $integer = 1;
		 *    ($integer) === FALSE
		 *
		 * @assert $array = array();
		 *    ($array) === FALSE
		 *
		 * @assert ($foo) === FALSE
		 */
		public function is(&$var)
		{
			if(isset($var) && is_bool($var))
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
			if(isset($var) && is_bool($var))
				return TRUE;

			return FALSE;
		}

		/**
		 * Short version of ``(!empty() && is_bool())``.
		 *
		 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable is ``(!empty() && is_bool())``, else FALSE.
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
		 * @assert $boolean = TRUE;
		 *    ($boolean) === TRUE
		 *
		 * @assert $boolean = FALSE;
		 *    ($boolean) === FALSE
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
			if(!empty($var) && is_bool($var))
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
			if(!empty($var) && is_bool($var))
				return TRUE;

			return FALSE;
		}

		/**
		 * Short version of ``if(isset() && is_bool()){} else{}``.
		 *
		 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to FALSE. This is the return value if ``$var`` is NOT set, or is NOT a boolean.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of ``$var`` will be set (via reference) to the return value.
		 *
		 * @return boolean|mixed Value of ``$var``, if ``(isset() && is_bool())``.
		 *    Else returns ``$or`` (which could be any mixed data type — defaults to boolean FALSE).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert $a = 'a';
		 *    ($a) === FALSE
		 * @assert $a = FALSE;
		 *    ($a, TRUE) === FALSE
		 * @assert $_0 = 0;
		 *    ($_0, TRUE) === TRUE
		 * @assert $zero = '0';
		 *    ($zero) === FALSE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $FALSE = FALSE;
		 *    ($FALSE, TRUE) === FALSE
		 * @assert $empty_string = '';
		 *    ($empty_string, TRUE) === TRUE
		 * @assert $TRUE = TRUE;
		 *    ($TRUE, FALSE) === TRUE
		 * @assert $one = '1';
		 *    ($one, FALSE) === FALSE
		 * @assert $false = FALSE;
		 *    ($false, TRUE) === FALSE
		 *
		 * @assert $empty_array = array();
		 *    ($empty_array, TRUE) === TRUE
		 * @assert $array = array('2');
		 *    ($array, TRUE) === TRUE
		 *
		 * @assert ($foo, FALSE) === FALSE
		 * @assert ($foo, TRUE) === TRUE
		 */
		public function isset_or(&$var, $or = FALSE, $set_var = FALSE)
		{
			if(isset($var) && is_bool($var))
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
		 * @param mixed $or This is the return value if ``$var`` is NOT set, or is NOT a boolean.
		 *
		 * @note This does NOT support the ``$set_var`` parameter, because ``$var`` is NOT by reference here.
		 *
		 * @return boolean|mixed See ``$this->isset_or()`` for further details.
		 */
		public function ¤isset_or($var, $or = FALSE)
		{
			if(isset($var) && is_bool($var))
				return $var;

			return $or;
		}

		/**
		 * Short version of ``if(!empty() && is_bool()){} else{}``.
		 *
		 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If ``$var`` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to FALSE. This is the return value if ``$var`` IS empty, or is NOT a boolean.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of ``$var`` will be set (via reference) to the return value.
		 *
		 * @return boolean|mixed Value of ``$var``, if ``(!empty() && is_bool())``.
		 *    Else returns ``$or`` (which could be any mixed data type — defaults to boolean FALSE).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert $a = 'a';
		 *    ($a) === FALSE
		 * @assert $a = FALSE;
		 *    ($a, TRUE) === TRUE
		 * @assert $_0 = 0;
		 *    ($_0, TRUE) === TRUE
		 * @assert $zero = '0';
		 *    ($zero) === FALSE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $FALSE = FALSE;
		 *    ($FALSE, TRUE) === TRUE
		 * @assert $empty_string = '';
		 *    ($empty_string, TRUE) === TRUE
		 * @assert $TRUE = TRUE;
		 *    ($TRUE, FALSE) === TRUE
		 * @assert $one = '1';
		 *    ($one, FALSE) === FALSE
		 * @assert $false = FALSE;
		 *    ($false, TRUE) === TRUE
		 *
		 * @assert $empty_array = array();
		 *    ($empty_array, TRUE) === TRUE
		 * @assert $array = array('2');
		 *    ($array, TRUE) === TRUE
		 *
		 * @assert ($foo, FALSE) === FALSE
		 * @assert ($foo, TRUE) === TRUE
		 */
		public function is_not_empty_or(&$var, $or = FALSE, $set_var = FALSE)
		{
			if(!empty($var) && is_bool($var))
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
		 * @param mixed $or This is the return value if ``$var`` IS empty, or is NOT a boolean.
		 *
		 * @note This does NOT support the ``$set_var`` parameter, because ``$var`` is NOT by reference here.
		 *
		 * @return boolean|mixed See ``$this->is_not_empty_or()`` for further details.
		 */
		public function ¤is_not_empty_or($var, $or = FALSE)
		{
			if(!empty($var) && is_bool($var))
				return $var;

			return $or;
		}

		/**
		 * Check if boolean values are set.
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
		 * @return boolean TRUE if all arguments are booleans, else FALSE.
		 *
		 * @assert $a = 'a';
		 *    ($a, $b) === FALSE
		 * @assert $a = new \stdClass();
		 *    ($a, $b) === FALSE
		 * @assert $_0 = 0; $c = new \stdClass();
		 *    ($_0, $c) === FALSE
		 * @assert $TRUE = TRUE; $FALSE = FALSE;
		 *    ($TRUE, $FALSE, $TRUE) === TRUE
		 * @assert $FALSE = FALSE;
		 *    ($FALSE, $FALSE, $FALSE) === TRUE
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
				if(!isset($_arg) || !is_bool($_arg))
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
				if(!isset($_arg) || !is_bool($_arg))
					return FALSE;
			unset($_arg);

			return TRUE;
		}

		/**
		 * Check if boolean values are NOT empty.
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
		 * @return boolean TRUE if all arguments are booleans, and they're NOT empty, else FALSE.
		 *
		 * @assert $a = 'a'; $b = 'b';
		 *    ($a, $b) === FALSE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $TRUE = TRUE; $FALSE = FALSE;
		 *    ($TRUE, $FALSE) === FALSE
		 * @assert $TRUE = TRUE;
		 *    ($TRUE, $TRUE, $TRUE) === TRUE
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
				if(empty($_arg) || !is_bool($_arg))
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
				if(empty($_arg) || !is_bool($_arg))
					return FALSE;
			unset($_arg);

			return TRUE;
		}

		/**
		 * Check if boolean values are NOT empty in booleans/arrays/objects.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
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
		 * @return boolean TRUE if all arguments are booleans — or arrays/objects containing booleans; and NONE of the booleans scanned deeply are empty; else FALSE.
		 *    Can have multidimensional arrays/objects containing booleans.
		 *    Can have empty arrays; e.g. we consider these to be data containers.
		 *    Can have empty objects; e.g. we consider these data containers.
		 *
		 * @assert $a = 'a'; $b = 'b';
		 *    ($a, $b) === FALSE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $TRUE = TRUE; $FALSE = FALSE;
		 *    ($TRUE, $FALSE) === FALSE
		 * @assert $TRUE = TRUE;
		 *    ($TRUE, $TRUE, $TRUE) === TRUE
		 * @assert $_1 = 1; $empty_string = '';
		 *    ($_1, $empty_string) === FALSE
		 * @assert $_1 = 1; $a = 'a'; $b = 'b'; $empty_string = '';
		 *    ($_1, $a, $b, $empty_string) === FALSE
		 * @assert $non_empty_string = '-'; $another_non_empty_string = '-';
		 *    ($non_empty_string, $another_non_empty_string) === FALSE
		 *
		 * @assert $a = TRUE; $b = TRUE; $c = array();
		 *    ($a, $b, $c) === TRUE
		 * @assert $a = TRUE; $b = TRUE; $c = array(TRUE);
		 *    ($a, $b, $c) === TRUE
		 * @assert $a = TRUE; $b = TRUE; $c = array(TRUE, array(TRUE, array(TRUE, array(TRUE))));
		 *    ($a, $b, $c) === TRUE
		 * @assert $a = 0; $b = TRUE; $c = array(TRUE, array(TRUE, array(TRUE, array(TRUE))));
		 *    ($a, $b, $c) === FALSE
		 * @assert $a = FALSE; $b = TRUE; $c = array(TRUE, array(TRUE, array(TRUE, array(TRUE))));
		 *    ($a, $b, $c) === FALSE
		 *
		 * @assert $a = TRUE; $b = TRUE; $c = array(TRUE, array(TRUE, array(TRUE, array(TRUE)))); $d = new \stdClass(); $d->a = TRUE;
		 *    ($a, $b, $c, $d) === TRUE
		 * @assert $a = TRUE; $b = TRUE; $c = array(TRUE, array(TRUE, array(TRUE, array(TRUE)))); $d = new \stdClass(); $d->a = FALSE;
		 *    ($a, $b, $c, $d) === FALSE
		 * @assert $a = TRUE; $b = TRUE; $c = array(TRUE, array(TRUE, array(TRUE, array(TRUE)))); $d = new \stdClass(); $d->a = 1.2;
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
				else if(empty($_arg) || !is_bool($_arg))
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
				else if(empty($_arg) || !is_bool($_arg))
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
		 * @return boolean The first boolean argument that's NOT empty, else FALSE.
		 *
		 * @assert $a = 0; $b = 1;
		 *    ($a, $b) === FALSE
		 * @assert $a = 0; $b = 1; $TRUE = TRUE;
		 *    ($a, $b, $TRUE) === TRUE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $_1 = 1; $_2 = 2;
		 *    ($_1, $_2) === FALSE
		 * @assert $_1 = 1; $empty_string = '';
		 *    ($_1, $empty_string) === FALSE
		 * @assert $_1 = 1; $empty_string = ''; $a = 1; $b = 2;
		 *    ($_1, $empty_string, $a, $b) === FALSE
		 * @assert $empty_string = ''; $another_empty_string = '';
		 *    ($empty_string, $another_empty_string) === FALSE
		 * @assert $empty_string = ''; $a = TRUE; $non_empty_string = '-';
		 *    ($empty_string, $a, $non_empty_string) === TRUE
		 *
		 * @assert ($foo, $foo, $foo) === FALSE
		 */
		public function not_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_bool($_arg))
					return $_arg;
			unset($_arg);

			return FALSE;
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
				if(!empty($_arg) && is_bool($_arg))
					return $_arg;
			unset($_arg);

			return FALSE;
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
		 * @return boolean The first boolean argument, else FALSE.
		 *
		 * @assert $a = 0; $b = 1;
		 *    ($a, $b) === FALSE
		 * @assert $a = 0; $b = 1; $TRUE = TRUE;
		 *    ($a, $b, $TRUE) === TRUE
		 * @assert $NULL = NULL;
		 *    ($NULL) === FALSE
		 * @assert $_1 = 1; $_2 = 2;
		 *    ($_1, $_2) === FALSE
		 * @assert $_1 = 1; $empty_string = '';
		 *    ($_1, $empty_string) === FALSE
		 * @assert $_1 = 1; $empty_string = ''; $a = 1; $b = 2;
		 *    ($_1, $empty_string, $a, $b) === FALSE
		 * @assert $empty_string = ''; $another_empty_string = '';
		 *    ($empty_string, $another_empty_string) === FALSE
		 * @assert $empty_string = ''; $a = TRUE; $non_empty_string = '-';
		 *    ($empty_string, $a, $non_empty_string) === TRUE
		 * @assert $empty_string = ''; $a = FALSE; $b = TRUE; $non_empty_string = '-';
		 *    ($empty_string, $a, $b, $non_empty_string) === FALSE
		 *
		 * @assert ($foo, $foo, $foo) === FALSE
		 */
		public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_bool($_arg))
					return $_arg;
			unset($_arg);

			return FALSE;
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
				if(isset($_arg) && is_bool($_arg))
					return $_arg;
			unset($_arg);

			return FALSE;
		}

		/**
		 * Forces an initial boolean value (NOT a deep scan).
		 *
		 * @param mixed $value Anything can be converted to a boolean.
		 *
		 * @return boolean Boolified value. This forces an initial boolean value at all times.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting}
		 *
		 * @assert (NULL) === FALSE
		 * @assert ('1') === TRUE
		 * @assert ('1.0') === TRUE
		 * @assert ('1.23') === TRUE
		 * @assert (TRUE) === TRUE
		 * @assert (FALSE) === FALSE
		 * @assert ('hello') === TRUE
		 * @assert (1.0) === TRUE
		 * @assert (1.7) === TRUE
		 * @assert (0.0) === FALSE
		 * @assert (0) === FALSE
		 * @assert (0.1) === TRUE
		 * @assert (-1) === TRUE
		 *
		 * @assert  // NOT a deep scan.
		 *    (array(1,2,3)) === TRUE
		 *
		 * @assert $obj = new \stdClass(); // NOT a deep scan.
		 *    (array(1, $obj)) === TRUE
		 */
		public function ify($value)
		{
			return (boolean)$value;
		}

		/**
		 * Forces boolean values deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
		 *
		 * @param mixed $value Anything can be converted to a boolean.
		 *
		 * @return boolean|array|object Boolified value, array, or an object.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting}
		 *
		 * @assert (NULL) === FALSE
		 * @assert ('1') === TRUE
		 * @assert ('1.0') === TRUE
		 * @assert ('1.23') === TRUE
		 * @assert (TRUE) === TRUE
		 * @assert (FALSE) === FALSE
		 * @assert ('hello') === TRUE
		 * @assert (1.0) === TRUE
		 * @assert (1.7) === TRUE
		 * @assert (0.0) === FALSE
		 * @assert (0) === FALSE
		 * @assert (0.1) === TRUE
		 * @assert (-1) === TRUE
		 * @assert (array(array(1), array(TRUE), array(FALSE))) === array(array(TRUE), array(TRUE), array(FALSE))
		 * @assert (array(array(1), array(2.30))) === array(array(TRUE), array(TRUE))
		 * @assert $obj = new \stdClass(); $obj->prop = '1'; // Prop converts to boolean.
		 *    (array(array('hello'), array($obj))) === array(array(TRUE), array($obj))
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
			return (boolean)$value;
		}
	}
}