<?php
/**
 * String Utilities.
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
		 * String Utilities.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class strings extends framework
		{
			/**
			 * Short version of ``(isset() && is_string())``.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @param mixed $var A variable by reference (no NOTICE).
			 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
			 *
			 * @return boolean TRUE if the variable ``(isset() && is_string())``, else FALSE.
			 *
			 * @assert $string = '';
			 *    ($string) === TRUE
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
					if(isset($var) && is_string($var))
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
					if(isset($var) && is_string($var))
						return TRUE;

					return FALSE;
				}

			/**
			 * Short version of ``(!empty() && is_string())``.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @param mixed $var A variable by reference (no NOTICE).
			 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
			 *
			 * @return boolean TRUE if the variable is ``(!empty() && is_string())``, else FALSE.
			 *
			 * @assert $string = '';
			 *    ($string) === FALSE
			 *
			 * @assert $string = '1';
			 *    ($string) === TRUE
			 *
			 * @assert $integer = 1;
			 *    ($integer) === FALSE
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
					if(!empty($var) && is_string($var))
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
					if(!empty($var) && is_string($var))
						return TRUE;

					return FALSE;
				}

			/**
			 * Short version of ``if(isset() && is_string()){} else{}``.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @param mixed   $var A variable by reference (no NOTICE).
			 *    If ``$var`` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
			 *
			 * @param mixed   $or Defaults to an empty string. This is the return value if ``$var`` is NOT set, or is NOT a string.
			 *
			 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of ``$var`` will be set (via reference) to the return value.
			 *
			 * @return string|mixed Value of ``$var``, if ``(isset() && is_string())``.
			 *    Else returns ``$or`` (which could be any mixed data type — defaults to an empty string).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $a = 'a';
			 *    ($a) === 'a'
			 * @assert $a = FALSE;
			 *    ($a, 'b') === 'b'
			 * @assert $zero = '0';
			 *    ($zero) === '0'
			 * @assert $NULL = NULL;
			 *    ($NULL) === ''
			 * @assert $_1 = 1;
			 *    ($_1) === ''
			 * @assert $empty_string = '';
			 *    ($empty_string, 'a') === ''
			 * @assert $TRUE = TRUE;
			 *    ($TRUE, 'a') === 'a'
			 * @assert $one = '1';
			 *    ($one, '2') === '1'
			 * @assert $false = FALSE;
			 *    ($false, '1') === '1'
			 *
			 * @assert $empty_array = array();
			 *    ($empty_array, '0') === '0'
			 * @assert $array = array('2');
			 *    ($array, '1') === '1'
			 *
			 * @assert ($foo, '') === ''
			 * @assert ($foo, 'or') === 'or'
			 */
			public function isset_or(&$var, $or = '', $set_var = FALSE)
				{
					if(isset($var) && is_string($var))
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
			 * @param mixed $or This is the return value if ``$var`` is NOT set, or is NOT a string.
			 *
			 * @note This does NOT support the ``$set_var`` parameter, because ``$var`` is NOT by reference here.
			 *
			 * @return string|mixed See ``$this->isset_or()`` for further details.
			 */
			public function ¤isset_or($var, $or = '')
				{
					if(isset($var) && is_string($var))
						return $var;

					return $or;
				}

			/**
			 * Short version of ``if(!empty() && is_string()){} else{}``.
			 *
			 * @note Unlike PHP's ``is_...`` functions, this will NOT throw a NOTICE.
			 *
			 * @param mixed   $var A variable by reference (no NOTICE).
			 *    If ``$var`` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
			 *
			 * @param mixed   $or Defaults to an empty string. This is the return value if ``$var`` IS empty, or is NOT a string.
			 *
			 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of ``$var`` will be set (via reference) to the return value.
			 *
			 * @return string|mixed Value of ``$var``, if ``(!empty() && is_string())``.
			 *    Else returns ``$or`` (which could be any mixed data type — defaults to an empty string).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $a = 'a';
			 *    ($a) === 'a'
			 * @assert $zero = '0';
			 *    ($zero) === ''
			 * @assert $zero = '0';
			 *    ($zero, 'a') === 'a'
			 * @assert $NULL = NULL;
			 *    ($NULL) === ''
			 * @assert $_1 = 1;
			 *    ($_1) === ''
			 * @assert $empty_string = '';
			 *    ($empty_string, 'a') === 'a'
			 * @assert $TRUE = TRUE;
			 *    ($TRUE, 'a') === 'a'
			 * @assert $one = '1';
			 *    ($one, '2') === '1'
			 * @assert $false = FALSE;
			 *    ($false, '1') === '1'
			 *
			 * @assert $empty_array = array();
			 *    ($empty_array, '0') === '0'
			 * @assert $array = array('2');
			 *    ($array, '1') === '1'
			 *
			 * @assert ($foo, '') === ''
			 * @assert ($foo, 'or') === 'or'
			 */
			public function is_not_empty_or(&$var, $or = '', $set_var = FALSE)
				{
					if(!empty($var) && is_string($var))
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
			 * @param mixed $or This is the return value if ``$var`` IS empty, or is NOT a string.
			 *
			 * @note This does NOT support the ``$set_var`` parameter, because ``$var`` is NOT by reference here.
			 *
			 * @return string|mixed See ``$this->is_not_empty_or()`` for further details.
			 */
			public function ¤is_not_empty_or($var, $or = '')
				{
					if(!empty($var) && is_string($var))
						return $var;

					return $or;
				}

			/**
			 * Check if string values are set.
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
			 * @return boolean TRUE if all arguments are strings, else FALSE.
			 *
			 * @assert $a = 'a';
			 *    ($a, $b) === FALSE
			 * @assert $a = new \stdClass();
			 *    ($a, $b) === FALSE
			 * @assert $_0 = 0; $c = new \stdClass();
			 *    ($_0, $c) === FALSE
			 * @assert $string1 = ''; $string2 = '2'; $string3 = '3';
			 *    ($string1, $string2, $string3) === TRUE
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello';
			 *    ($obj, $obj, $obj) === FALSE
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
						if(!isset($_arg) || !is_string($_arg))
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
						if(!isset($_arg) || !is_string($_arg))
							return FALSE;
					unset($_arg);

					return TRUE;
				}

			/**
			 * Check if string values are NOT empty.
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
			 * @return boolean TRUE if all arguments are strings, and they're NOT empty, else FALSE.
			 *
			 * @assert $a = 'a'; $b = 'b';
			 *    ($a, $b) === TRUE
			 * @assert $NULL = NULL;
			 *    ($NULL) === FALSE
			 * @assert $_1 = 1; $_2 = 2;
			 *    ($_1, $_2) === FALSE
			 * @assert $_1 = 1; $empty_string = '';
			 *    ($_1, $empty_string) === FALSE
			 * @assert $_1 = 1; $a = 'a'; $b = 'b'; $empty_string = '';
			 *    ($_1, $a, $b, $empty_string) === FALSE
			 * @assert $non_empty_string = '-'; $another_non_empty_string = '-';
			 *    ($non_empty_string, $another_non_empty_string) === TRUE
			 *
			 * @assert ($foo, $foo, $foo) === FALSE
			 */
			public function are_not_empty(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
				{
					foreach(func_get_args() as $_arg)
						if(empty($_arg) || !is_string($_arg))
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
						if(empty($_arg) || !is_string($_arg))
							return FALSE;
					unset($_arg);

					return TRUE;
				}

			/**
			 * Check if string values are NOT empty in strings/arrays/objects.
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
			 * @return boolean TRUE if all arguments are strings — or arrays/objects containing strings; and NONE of the strings scanned deeply are empty; else FALSE.
			 *    Can have multidimensional arrays/objects containing strings.
			 *    Can have empty arrays; e.g. we consider these to be data containers.
			 *    Can have empty objects; e.g. we consider these data containers.
			 *
			 * @assert $a = 'a'; $b = 'b';
			 *    ($a, $b) === TRUE
			 * @assert $NULL = NULL;
			 *    ($NULL) === FALSE
			 * @assert $_1 = 1; $_2 = 2;
			 *    ($_1, $_2) === FALSE
			 * @assert $_1 = 1; $empty_string = '';
			 *    ($_1, $empty_string) === FALSE
			 * @assert $_1 = 1; $a = 'a'; $b = 'b'; $empty_string = '';
			 *    ($_1, $a, $b, $empty_string) === FALSE
			 * @assert $non_empty_string = '-'; $another_non_empty_string = '-';
			 *    ($non_empty_string, $another_non_empty_string) === TRUE
			 *
			 * @assert $a = 'a'; $b = 'b'; $c = array('c');
			 *    ($a, $b, $c) === TRUE
			 * @assert $a = 'a'; $b = 'b'; $c = array(TRUE);
			 *    ($a, $b, $c) === FALSE
			 * @assert $a = 'a'; $b = 'b'; $c = array('c', array('c', array('c', array('c'))));
			 *    ($a, $b, $c) === TRUE
			 * @assert $a = ''; $b = 'b'; $c = array('c', array('c', array('c', array('c'))));
			 *    ($a, $b, $c) === FALSE
			 * @assert $a = 'a'; $b = 'b'; $c = array('c', array('c', array('c', array(''))));
			 *    ($a, $b, $c) === FALSE
			 *
			 * @assert $a = 'a'; $b = 'b'; $c = array('c', array('c', array('c', array('c')))); $d = new \stdClass(); $d->a = 'a';
			 *    ($a, $b, $c, $d) === TRUE
			 * @assert $a = 'a'; $b = 'b'; $c = array('c', array('c', array('c', array('c')))); $d = new \stdClass(); $d->a = '0';
			 *    ($a, $b, $c, $d) === FALSE
			 * @assert $a = 'a'; $b = 'b'; $c = array('c', array('c', array('c', array('c')))); $d = new \stdClass(); $d->a = '';
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
							else if(empty($_arg) || !is_string($_arg))
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
							else if(empty($_arg) || !is_string($_arg))
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
			 * @return string The first string argument that's NOT empty, else an empty string.
			 *
			 * @assert $a = 'a'; $b = 'b';
			 *    ($a, $b) === 'a'
			 * @assert $NULL = NULL;
			 *    ($NULL) === ''
			 * @assert $_1 = 1; $_2 = 2;
			 *    ($_1, $_2) === ''
			 * @assert $_1 = 1; $empty_string = '';
			 *    ($_1, $empty_string) === ''
			 * @assert $_1 = 1; $empty_string = ''; $a = 'a'; $b = 'b';
			 *    ($_1, $empty_string, $a, $b) === 'a'
			 * @assert $empty_string = ''; $another_empty_string = '';
			 *    ($empty_string, $another_empty_string) === ''
			 * @assert $empty_string = ''; $a = 'a'; $non_empty_string = '-';
			 *    ($empty_string, $a, $non_empty_string) === 'a'
			 * @assert $empty_string = ''; $another_empty_string = ''; $non_empty_string = '-';
			 *    ($empty_string, $another_empty_string, $non_empty_string) === '-'
			 *
			 * @assert ($foo, $foo, $foo) === ''
			 */
			public function not_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
				{
					foreach(func_get_args() as $_arg)
						if(!empty($_arg) && is_string($_arg))
							return $_arg;
					unset($_arg);

					return '';
				}

			/**
			 * Same as ``$this->not_empty_coalesce()``, but this allows expressions.
			 *
			 * @param mixed $a At least one variable (or an expression).
			 *
			 * @return string See ``$this->not_empty_coalesce()`` for further details.
			 */
			public function ¤not_empty_coalesce($a)
				{
					foreach(func_get_args() as $_arg)
						if(!empty($_arg) && is_string($_arg))
							return $_arg;
					unset($_arg);

					return '';
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
			 * @return string The first string argument, else an empty string.
			 *
			 * @assert $a = 'a'; $b = 'b';
			 *    ($a, $b) === 'a'
			 * @assert $NULL = NULL;
			 *    ($NULL) === ''
			 * @assert $_1 = 1; $_2 = 2;
			 *    ($_1, $_2) === ''
			 * @assert $_1 = 1; $empty_string = '';
			 *    ($_1, $empty_string) === ''
			 * @assert $_1 = 1; $a = 'a'; $b = 'b'; $empty_string = '';
			 *    ($_1, $a, $b, $empty_string) === 'a'
			 * @assert $_1 = 1; $empty_string = ''; $another_empty_string = ''; $a = 'a';
			 *    ($_1, $empty_string, $another_empty_string, $a) === ''
			 * @assert $empty_string = ''; $another_empty_string = ''; $non_empty_string = '-';
			 *    ($empty_string, $another_empty_string, $non_empty_string) === ''
			 * @assert $empty_string = ''; $a = 'a'; $non_empty_string = '-';
			 *    ($empty_string, $a, $non_empty_string) === ''
			 *
			 * @assert ($foo, $foo, $foo) === ''
			 */
			public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
				{
					foreach(func_get_args() as $_arg)
						if(isset($_arg) && is_string($_arg))
							return $_arg;
					unset($_arg);

					return '';
				}

			/**
			 * Same as ``$this->isset_coalesce()``, but this allows expressions.
			 *
			 * @param mixed $a At least one variable (or an expression).
			 *
			 * @return string See ``$this->isset_coalesce()`` for further details.
			 */
			public function ¤isset_coalesce($a)
				{
					foreach(func_get_args() as $_arg)
						if(isset($_arg) && is_string($_arg))
							return $_arg;
					unset($_arg);

					return '';
				}

			/**
			 * Should a variable be interpreted as TRUE?
			 *
			 * @param mixed $var Any value to test against here.
			 *
			 * @return boolean TRUE for: TRUE, 'TRUE', 'true', 1, '1', 'on', 'ON', 'yes', 'YES' — else FALSE.
			 *    Any resource/object/array is of course NOT one of these values, and will always return FALSE.
			 *    In other words, any value that is NOT scalar, is NOT TRUE.
			 *
			 * @assert ('a') === FALSE
			 * @assert ('0') === FALSE
			 * @assert (NULL) === FALSE
			 * @assert (0) === FALSE
			 * @assert (1) === TRUE
			 * @assert ('') === FALSE
			 * @assert (TRUE) === TRUE
			 * @assert ('1') === TRUE
			 * @assert ('yes') === TRUE
			 * @assert ('YES') === TRUE
			 * @assert ('false') === FALSE
			 * @assert ('FALSE') === FALSE
			 * @assert ('no') === FALSE
			 * @assert ('NO') === FALSE
			 * @assert ('off') === FALSE
			 * @assert ('OFF') === FALSE
			 * @assert ('on') === TRUE
			 * @assert ('ON') === TRUE
			 * @assert ('true') === TRUE
			 * @assert ('TRUE') === TRUE
			 * @assert (array()) === FALSE
			 * @assert (array('hello' => 'hello')) === FALSE
			 * @assert (new \stdClass()) === FALSE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello';
			 *    ($obj) === FALSE
			 */
			public function is_true($var)
				{
					if(!is_scalar($var))
						return FALSE;

					return (filter_var($var, FILTER_VALIDATE_BOOLEAN)) ? TRUE : FALSE;
				}

			/**
			 * Should a variable be interpreted as FALSE?
			 *
			 * @param mixed $var Any value to test against here.
			 *
			 * @return boolean TRUE for anything that is (NOT): TRUE, 'TRUE', 'true', 1, '1', 'on', 'ON', 'yes', 'YES' — else FALSE.
			 *    Any resource/object/array is of course NOT one of these values (which means it ``is_false()``).
			 *    In other words, any value that is NOT scalar, is NOT TRUE.
			 *
			 * @assert ('a') === TRUE
			 * @assert ('0') === TRUE
			 * @assert (NULL) === TRUE
			 * @assert (0) === TRUE
			 * @assert (1) === FALSE
			 * @assert ('') === TRUE
			 * @assert (TRUE) === FALSE
			 * @assert ('1') === FALSE
			 * @assert ('yes') === FALSE
			 * @assert ('YES') === FALSE
			 * @assert ('false') === TRUE
			 * @assert ('FALSE') === TRUE
			 * @assert ('no') === TRUE
			 * @assert ('NO') === TRUE
			 * @assert ('off') === TRUE
			 * @assert ('OFF') === TRUE
			 * @assert ('on') === FALSE
			 * @assert ('ON') === FALSE
			 * @assert ('true') === FALSE
			 * @assert ('TRUE') === FALSE
			 * @assert (array()) === TRUE
			 * @assert (array('hello' => 'hello')) === TRUE
			 * @assert (new \stdClass()) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello';
			 *    ($obj) === TRUE
			 */
			public function is_false($var)
				{
					return (!$this->is_true($var)) ? TRUE : FALSE;
				}

			/**
			 * Is the string a valid PHP userland name?
			 *
			 * @param string $string Any input string to test against PHP userland naming guidelines.
			 *
			 * @return boolean TRUE if the string IS a valid userland name; else FALSE.
			 */
			public function is_valid_userland_name($string)
				{
					$this->check_arg_types('string', func_get_args());

					if(preg_match($this->regex_valid_userland_name, $string))
						return TRUE;

					return FALSE; // Default return value.
				}

			/**
			 * Forces an initial string value (NOT a deep scan).
			 *
			 * @param !object $value Anything but an object.
			 *
			 * @return string Stringified value. This forces an initial string value at all times.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (NULL) === ''
			 * @assert ('1') === '1'
			 * @assert (TRUE) === '1'
			 * @assert (FALSE) === ''
			 * @assert (1.1) === '1.1'
			 * @assert (1.2) === '1.2'
			 * @assert ('hello') === 'hello'
			 * @assert (array(1)) === 'Array'
			 * @assert (array()) === 'Array'
			 */
			public function ify($value)
				{
					$this->check_arg_types('!object', func_get_args());

					return (string)$value;
				}

			/**
			 * Forces string values deeply.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed $value Any value can be converted into a string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object Stringified value, array, or an object.
			 *
			 * @assert (NULL) === ''
			 * @assert ('1') === '1'
			 * @assert (TRUE) === '1'
			 * @assert (FALSE) === ''
			 * @assert (array(array(1), array(TRUE), array(FALSE))) === array(array('1'), array('1'), array(''))
			 * @assert (array(array(1), array(2.30))) === array(array('1'), array('2.3'))
			 * @assert $obj = new \stdClass(); $obj->prop = '1'; // Prop converts to string.
			 *    (array(array(0), array($obj))) === array(array('0'), array($obj))
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
					else return (string)$value;
				}

			/**
			 * Match a regex pattern against other values.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param string  $regex A regular expression.
			 *
			 * @param mixed   $value Any value can be converted into a string before comparison.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param boolean $collect_key_props Collect array keys and/or object properties?
			 *    This defaults to a FALSE value. If TRUE, this method returns an array with matching keys/properties.
			 *    However, if the initial input ``$value`` is NOT an object/array, this flag is ignored completely.
			 *
			 * @return boolean|array TRUE if regular expression finds a match, else FALSE.
			 *    If ``$collect_key_props`` is TRUE, this will return an array instead (i.e. containing all matching keys/properties);
			 *       else an empty array if no matches are found in the search for keys/properties.
			 *
			 *    IMPORTANT: if ``$collect_key_props`` is TRUE, but the initial input ``$value`` is NOT an object/array,
			 *       the ``$collect_key_props`` flag is ignored completely (e.g. there's no object/array to search).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('/^hello$/', array('hello', 'world')) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $obj->world = 'world';
			 *    ('/^hello$/', array(array($obj))) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $obj->world = 'world';
			 *    ('/^hello$/', $obj) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $obj->world = 'world';
			 *    ('/^hello$/', array(TRUE, array($obj, 1, TRUE))) === TRUE
			 *
			 * @assert ('/^hello$/', array(TRUE, array(array(), 1, TRUE))) === FALSE
			 * @assert ('/^hello$/', 'hello') === TRUE
			 */
			public function regex_pattern_in($regex, $value, $collect_key_props = FALSE)
				{
					$this->check_arg_types('string', '', 'boolean', func_get_args());

					$matching_key_props = array(); // Initialize.

					if(strlen($regex)) // Need a regex pattern (i.e. CANNOT be empty).
						{
							if(is_array($value) || is_object($value))
								{
									foreach($value as $_key_prop => $_value)
										{
											if(is_array($_value) || is_object($_value))
												{
													if(($_matching_key_props = $this->regex_pattern_in($regex, $_value, $collect_key_props)))
														if($collect_key_props) // Are we collecting keys, or can we just return now?
															$matching_key_props[] = array($_key_prop => $_matching_key_props);
														else // We can return now.
															return TRUE;
													unset($_matching_key_props);
												}
											else if(preg_match($regex, (string)$_value))
												if($collect_key_props) $matching_key_props[] = $_key_prop;
												else // We can return now.
													return TRUE;
										}
									unset($_key_prop, $_value);

									if($collect_key_props) // Matching keys/properties.
										return $matching_key_props;
								}
							else if(preg_match($regex, (string)$value))
								return TRUE; // We can return now.
						}
					return FALSE; // Defaults to a FALSE return value.
				}

			/**
			 * Search values containing regex patterns against a string.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param string  $string String to search within (possibly an empty string).
			 *
			 * @param mixed   $value This routine runs deeply into any value, looking for values that are already strings, and uses them as regex patterns.
			 *    This differs slightly from ``in_wildcard_patterns()``, where we cast any non-array/object value as a string.
			 *    This is because regex patterns will ONLY match if they are indeed a regex string pattern,
			 *    whereas wildcard patterns might match any value that we've cast as a string.
			 *    So, this routine will only look for values that are already strings.
			 *
			 * @param boolean $collect_key_props Collect array keys and/or object properties?
			 *    This defaults to a FALSE value. If TRUE, this method returns an array with matching keys/properties.
			 *    However, if the initial input ``$value`` is NOT an object/array, this flag is ignored completely.
			 *
			 * @return boolean|array TRUE if any string as a regex pattern finds a match, else FALSE.
			 *    If ``$collect_key_props`` is TRUE, this will return an array instead (i.e. containing all matching keys/properties);
			 *       else an empty array if no matches are found in the search for keys/properties.
			 *
			 *    IMPORTANT: if ``$collect_key_props`` is TRUE, but the initial input ``$value`` is NOT an object/array,
			 *       the ``$collect_key_props`` flag is ignored completely (e.g. there's no object/array to search).
			 *
			 * @note Error suppression applies to ``@ preg_match()`` here,
			 *    simply due to the nature of this method. Searching through multiple dimensions, we need to suppress errors
			 *    that may occur as a result of a non-regex string comparison being applied inadvertently.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('hello', array('/^hello$/', '/^world$/')) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = '/^hello$/'; $obj->world = '/^world$/';
			 *    ('hello', $obj) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = '/^hello$/'; $obj->world = '/^world$/';
			 *    ('hello', array(1, TRUE, array(1, TRUE, $obj))) === TRUE
			 *
			 * @assert ('hello', array(1, TRUE, array(1, TRUE, array()))) === FALSE
			 * @assert ('hello', array(1, TRUE, array('/^hello$/', TRUE, array()))) === TRUE
			 * @assert ('hello', '/^hello$/') === TRUE
			 */
			public function in_regex_patterns($string, $value, $collect_key_props = FALSE)
				{
					$this->check_arg_types('string', '', 'boolean', func_get_args());

					$matching_key_props = array(); // Initialize.

					if(is_array($value) || is_object($value))
						{
							foreach($value as $_key_prop => $_value)
								{
									if(is_array($_value) || is_object($_value))
										{
											if(($_matching_key_props = $this->in_regex_patterns($string, $_value, $collect_key_props)))
												if($collect_key_props) // Are we collecting keys, or can we just return now?
													$matching_key_props[] = array($_key_prop => $_matching_key_props);
												else // We can return now.
													return TRUE;
											unset($_matching_key_props);
										}
									else if(is_string($_value) && strlen($_value))
										{
											/** @noinspection PhpUsageOfSilenceOperatorInspection */
											if(@preg_match($_value, $string))
												if($collect_key_props) $matching_key_props[] = $_key_prop;
												else // We can return now.
													return TRUE;
										}
								}
							unset($_key_prop, $_value);

							if($collect_key_props) // Matching keys/properties.
								return $matching_key_props;
						}
					else if(is_string($value) && strlen($value))
						{
							/** @noinspection PhpUsageOfSilenceOperatorInspection */
							if(@preg_match($value, $string))
								return TRUE; // Return now.
						}
					return FALSE; // Defaults to a FALSE return value.
				}

			/**
			 * Match a wildcard pattern against other scalar values.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param string       $wildcard A wildcard pattern (possibly an empty string).
			 *
			 * @param mixed        $value Any value can be converted into a string before comparison.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param boolean      $case_insensitive Case insensitive? Defaults to FALSE.
			 *    If TRUE, the search is NOT case sensitive. We enable the `FNM_CASEFOLD` flag.
			 *
			 * @param boolean      $collect_key_props Collect array keys and/or object properties?
			 *    This defaults to a FALSE value. If TRUE, this method returns an array with matching keys/properties.
			 *    However, if the initial input ``$value`` is NOT an object/array, this flag is ignored completely.
			 *
			 * @param null|integer $x_flags Optional. Defaults to a NULL value.
			 *    Any additional flags supported by PHP's ``fnmatch()`` function are acceptable here.
			 *
			 * @param boolean      $___recursion Internal use only. Tracks recursion in this routine.
			 *
			 * @return boolean|array TRUE if wildcard pattern finds a match, else FALSE.
			 *    If ``$collect_key_props`` is TRUE, this will return an array instead (i.e. containing all matching keys/properties);
			 *       else an empty array if no matches are found in the search for keys/properties.
			 *
			 *    IMPORTANT: if ``$collect_key_props`` is TRUE, but the initial input ``$value`` is NOT an object/array,
			 *       the ``$collect_key_props`` flag is ignored completely (e.g. there's no object/array to search).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @see http://linux.die.net/man/3/fnmatch The underlying functionality provided by this routine.
			 *
			 * @assert ('hell*', array('hello', 'world')) === TRUE
			 * @assert ('WorLd*', array('hello', 'world')) === FALSE
			 * @assert ('WorLd*', array('hello', 'world'), TRUE) === TRUE
			 * @assert ('HELL*', array('hello', 'world')) === FALSE
			 * @assert ('HELL*', array('foo', 'bar'), FALSE) === FALSE
			 * @assert ('?[zye]l*', array('foo', 'bar')) === FALSE
			 * @assert ('?[zye]l*', array('foo', 'hello')) === TRUE
			 * @assert ('?[zye]L*', array('foo', 'hello')) === FALSE
			 * @assert ('?[zye]L*', array('foo', 'hello'), TRUE) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $obj->world = 'world';
			 *    ('hell*', array(array($obj))) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $obj->world = 'world';
			 *    ('hell*', $obj) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hello'; $obj->world = 'world';
			 *    ('hell*', array(TRUE, array($obj, 1, TRUE))) === TRUE
			 *
			 * @assert ('hell*', array(TRUE, array(array(), 1, TRUE))) === FALSE
			 * @assert ('hell*', 'hello') === TRUE
			 *
			 * @assert ('hell*', array(TRUE, array(array(), 1, TRUE)), TRUE, TRUE) is-type 'array'
			 */
			public function wildcard_pattern_in($wildcard, $value, $case_insensitive = FALSE, $collect_key_props = FALSE, $x_flags = NULL, $___recursion = FALSE)
				{
					$this->check_arg_types('string', '', 'boolean', 'boolean', array('null', 'integer'), 'boolean', func_get_args());

					$matching_key_props = array(); // Initialize.
					$flags              = ($case_insensitive) ? FNM_CASEFOLD : 0;
					$flags              = (isset($x_flags)) ? $flags | $x_flags : $flags;

					if(is_array($value) || is_object($value))
						{
							foreach($value as $_key_prop => $_value)
								{
									if(is_array($_value) || is_object($_value))
										{
											if(($_matching_key_props = $this->wildcard_pattern_in($wildcard, $_value, $case_insensitive, $collect_key_props, $x_flags, TRUE)))
												if($collect_key_props) // Are we collecting keys, or can we just return now?
													$matching_key_props[] = array($_key_prop => $_matching_key_props);
												else // We can return now.
													return TRUE;
											unset($_matching_key_props);
										}
									else // Treat this as a string value.
										{
											$_value = (string)$_value;

											if(fnmatch($wildcard, $_value, $flags))
												if($collect_key_props) $matching_key_props[] = $_key_prop;
												else // We can return now.
													return TRUE;
										}
								}
							unset($_key_prop, $_value); // Housekeeping.

							if($collect_key_props) // Matching keys/properties.
								return $matching_key_props;
						}
					else // Treat this as a string value.
						{
							$_value = (string)$value;

							if(fnmatch($wildcard, $_value, $flags))
								return TRUE; // We can return now.

							unset($_value); // Housekeeping.
						}
					return FALSE; // Defaults to a FALSE return value.
				}

			/**
			 * Search values containing wildcard patterns against a string.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param string       $string String to search within (possibly an empty string).
			 *
			 * @param mixed        $value This routine runs deeply into any value,
			 *    converting each non-array/object value into a wildcard string pattern.
			 *    This differs slightly from ``in_regex_patterns()``, where we only use values that are already strings.
			 *    This is because regex patterns will only match if they are indeed a regex string pattern,
			 *    whereas wildcard patterns might match any value that we've cast as a string.
			 *
			 * @param boolean      $case_insensitive Case insensitive? Defaults to FALSE.
			 *    If TRUE, the search is NOT case sensitive. We enable the `FNM_CASEFOLD` flag.
			 *
			 * @param boolean      $collect_key_props Collect array keys and/or object properties?
			 *    This defaults to a FALSE value. If TRUE, this method returns an array with matching keys/properties.
			 *    However, if the initial input ``$value`` is NOT an object/array, this flag is ignored completely.
			 *
			 * @param null|integer $x_flags Optional. Defaults to a NULL value.
			 *    Any additional flags supported by PHP's ``fnmatch()`` function are acceptable here.
			 *
			 * @param boolean      $___recursion Internal use only. Tracks recursion in this routine.
			 *
			 * @return boolean|array TRUE if any wildcard pattern finds a match, else FALSE.
			 *    If ``$collect_key_props`` is TRUE, this will return an array instead (i.e. containing all matching keys/properties);
			 *       else an empty array if no matches are found in the search for keys/properties.
			 *
			 *    IMPORTANT: if ``$collect_key_props`` is TRUE, but the initial input ``$value`` is NOT an object/array,
			 *       the ``$collect_key_props`` flag is ignored completely (e.g. there's no object/array to search).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @see http://linux.die.net/man/3/fnmatch The underlying functionality provided by this routine.
			 *
			 * @assert ('hello', array('hell*')) === TRUE
			 * @assert ('HeLlO', array('hell*')) === FALSE
			 * @assert ('HeLlO', array('hell*'), TRUE) === TRUE
			 * @assert ('HeLlO', array('foo', 'hell*')) === FALSE
			 * @assert ('HeLlO', array('foo', 'bar')) === FALSE
			 * @assert ('HeLlO', array('foo', '[hH][eE][lL]*[oO]')) === TRUE
			 * @assert ('HeLlO', array('foo', '[hH][eE][lL][lL][oO]')) === TRUE
			 * @assert ('HeLlO', array('foo', '?[zye]LL*')) === FALSE
			 * @assert ('HeLlO', array('foo', '?[zye]LL*'), TRUE) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hell*'; $obj->world = 'world*';
			 *    ('hello', $obj) === TRUE
			 *
			 * @assert $obj = new \stdClass(); $obj->hello = 'hell*'; $obj->world = 'world*';
			 *    ('hello', array(1, TRUE, array(1, TRUE, $obj))) === TRUE
			 *
			 * @assert ('hello', array(1, TRUE, array(1, TRUE, array()))) === FALSE
			 * @assert ('hello', 'hell*') === TRUE
			 *
			 * @assert ('hello', array('hello', 1, TRUE, array(1, TRUE, array('h*'))), TRUE, TRUE) is-type 'array'
			 */
			public function in_wildcard_patterns($string, $value, $case_insensitive = FALSE, $collect_key_props = FALSE, $x_flags = NULL, $___recursion = FALSE)
				{
					$this->check_arg_types('string', '', 'boolean', 'boolean', array('null', 'integer'), 'boolean', func_get_args());

					$matching_key_props = array(); // Initialize.
					$flags              = ($case_insensitive) ? FNM_CASEFOLD : 0;
					$flags              = (isset($x_flags)) ? $flags | $x_flags : $flags;

					if(is_array($value) || is_object($value))
						{
							foreach($value as $_key_prop => $_value)
								{
									if(is_array($_value) || is_object($_value))
										{
											if(($_matching_key_props = $this->in_wildcard_patterns($string, $_value, $case_insensitive, $collect_key_props, $x_flags, TRUE)))
												if($collect_key_props) // Are we collecting keys, or can we just return now?
													$matching_key_props[] = array($_key_prop => $_matching_key_props);
												else // We can return now.
													return TRUE;
											unset($_matching_key_props);
										}
									else // Treat this as a string value.
										{
											$_value = (string)$_value;

											if(fnmatch($_value, $string, $flags))
												if($collect_key_props) $matching_key_props[] = $_key_prop;
												else // We can return now.
													return TRUE;
										}
								}
							unset($_key_prop, $_value); // Housekeeping.

							if($collect_key_props) // Matching keys/properties.
								return $matching_key_props;
						}
					else // Treat this as a string value.
						{
							$_value = (string)$value;

							if(fnmatch($_value, $string, $flags))
								return TRUE; // We can return now.

							unset($_value); // Housekeeping.
						}
					return FALSE; // Defaults to a FALSE return value.
				}

			/**
			 * Escapes double quotes.
			 *
			 * @param string  $string A string value.
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string Escaped string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('"quotes"') === '\\"quotes\\"'
			 * @assert ('"quotes"', 0) === '"quotes"'
			 * @assert ('"quotes"', 2) === '\\\\"quotes\\\\"'
			 *
			 * @TODO Create deep variation.
			 */
			public function esc_dq($string, $times = 1)
				{
					$this->check_arg_types('string', 'integer', func_get_args());

					return str_replace('"', str_repeat('\\', abs($times)).'"', $string);
				}

			/**
			 * Escapes single quotes.
			 *
			 * @param string  $string A string value.
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string Escaped string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ("'quotes'") === "\\'quotes\\'"
			 * @assert ("'quotes'", 0) === "'quotes'"
			 * @assert ("'quotes'", 2) === "\\\\'quotes\\\\'"
			 *
			 * @TODO Create deep variation.
			 */
			public function esc_sq($string, $times = 1)
				{
					$this->check_arg_types('string', 'integer', func_get_args());

					return str_replace("'", str_repeat('\\', abs($times))."'", $string);
				}

			/**
			 * Escapes JS line breaks (removes "\r"); and escapes single quotes.
			 *
			 * @param string  $string A string value.
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string Escaped string, ready for JavaScript.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ("'quotes'") === "\\'quotes\\'"
			 * @assert ("'quotes'", 0) === "'quotes'"
			 * @assert ("'quotes'", 2) === "\\\\'quotes\\\\'"
			 * @assert ("'quotes''\r\n\n", 2) === "\\\\'quotes\\\\'\\\\'".'\n\n'
			 *
			 * @TODO Create deep variation.
			 */
			public function esc_js_sq($string, $times = 1)
				{
					$this->check_arg_types('string', 'integer', func_get_args());

					return str_replace("'", str_repeat('\\', abs($times))."'",
					                   str_replace(array("\r", "\n"), array('', '\\n'), $string)
					);
				}

			/**
			 * Escapes regex backreference chars (i.e. `\\$` and `\\\\`).
			 *
			 * @param string  $string A string value.
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string Escaped string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('\\1') === '\\\\1'
			 * @assert ('\\1', 2) === '\\\\\\1'
			 * @assert ('$hello') === '\\$hello'
			 * @assert ('$hello', 2) === '\\\\$hello'
			 */
			public function esc_refs($string, $times = 1)
				{
					$this->check_arg_types('string', 'integer', func_get_args());

					return $this->esc_refs_deep($string, $times);
				}

			/**
			 * Escapes regex backreference chars deeply (i.e. `\\$` and `\\\\`).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed   $value Any value can be converted into an escaped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string|array|object Escaped string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('\\1') === '\\\\1'
			 * @assert ('\\1', 2) === '\\\\\\1'
			 * @assert ('$hello') === '\\$hello'
			 * @assert ('$hello', 2) === '\\\\$hello'
			 * @assert (array('\\1')) === array('\\\\1')
			 * @assert (array('$hello')) === array('\\$hello')
			 * @assert (array(array('$hello'), array('$hello'))) === array(array('\\$hello'), array('\\$hello'))
			 */
			public function esc_refs_deep($value, $times = 1)
				{
					$this->check_arg_types('', 'integer', func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->esc_refs_deep($_value, $times);
							unset($_value);

							return $value;
						}
					return str_replace(
						array('\\', '$'),
						array(str_repeat('\\', abs($times)).'\\', str_repeat('\\', abs($times)).'$'),
						(string)$value
					);
				}

			/**
			 * Escapes SQL strings.
			 *
			 * @param string $string A string value.
			 *
			 * @return string Escaped string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @note This method intentionally has NO ``$times`` parameter, because that makes no sense for SQL.
			 *    In addition, if we attempted to use ``$times`` here, it would negate WordPress's ability to use ``mysql_real_escape_string()``.
			 *
			 * @assert ('\\foo') === '\\\\foo'
			 * @assert ("foo's") === "foo\'s"
			 */
			public function esc_sql($string)
				{
					$this->check_arg_types('string', func_get_args());

					return $this->esc_sql_deep($string);
				}

			/**
			 * Escapes SQL strings deeply.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed   $value Any value can be converted into an escaped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param boolean $convert_nulls_no_esc Optional. Defaults to a FALSE value.
			 *    By default, we convert all values into strings, and then we escape them via the DB class.
			 *    However, if this is TRUE, NULL values are treated differently. We convert them to the string `NULL`,
			 *    and they are NOT escaped here. This should be enabled when/if NULL values are being inserted into a DB table.
			 *
			 * @return string|array|object Escaped string, array, object (possible `NULL` string if ``$convert_null_no_wrap`` is TRUE).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @note This method intentionally has NO ``$times`` parameter, because that makes no sense for SQL.
			 *    In addition, if we attempted to use ``$times`` here, it would negate WordPress's ability to use ``mysql_real_escape_string()``.
			 *
			 * @assert ('\\foo') === '\\\\foo'
			 * @assert ("foo's") === "foo\'s"
			 * @assert (array('\\foo')) === array('\\\\foo')
			 * @assert (array(array('\\foo'), array("foo's"))) === array(array('\\\\foo'), array("foo\'s"))
			 */
			public function esc_sql_deep($value, $convert_nulls_no_esc = FALSE)
				{
					$this->check_arg_types('', 'boolean', func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->esc_sql_deep($_value);
							unset($_value);

							return $value;
						}
					if(is_null($value) && $convert_nulls_no_esc)
						return 'NULL'; // String `NULL` in this case.

					return $this->©db->_real_escape((string)$value);
				}

			/**
			 * Plain text excerpt with a trailing `...`.
			 *
			 * @param string  $string A string value.
			 *
			 * @param integer $max_length Maximum string length before trailing `...` appears.
			 *    If strings are within this length, the `...` does NOT appear at all.
			 *
			 * @return string Plain text excerpt (i.e. all HTML tags stripped).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('Hello world.', 5) === 'He...'
			 */
			public function excerpt($string, $max_length = 45)
				{
					$this->check_arg_types('string', 'integer', func_get_args());

					return $this->excerpt_deep($string, $max_length);
				}

			/**
			 * Plain text excerpts with a trailing `...`.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed   $value Any value can be converted into a plain text excerpt.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param integer $max_length Maximum string length before trailing `...` appears.
			 *    If strings are within this length, the `...` does NOT appear at all.
			 *
			 * @return string|array|object Plain text excerpt (i.e. all HTML tags stripped), array, or object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('Hello world.', 5) === 'He...'
			 * @assert (array(array('Hello world.'), array('Hello')), 5) === array(array('He...'), array('Hello'))
			 */
			public function excerpt_deep($value, $max_length = 45)
				{
					$this->check_arg_types('', 'integer', func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->excerpt_deep($_value, $max_length);
							unset($_value);

							return $value;
						}
					else if(strlen($value = strip_tags((string)$value)) > $max_length)
						return (string)substr($value, 0, (($max_length > 3) ? $max_length - 3 : 0)).'...';

					return (string)$value;
				}

			/**
			 * Escapes registered WordPress® Shortcodes (i.e. ``[[shortcode]]``).
			 *
			 * @param string $string A string value.
			 *
			 * @return string String with registered WordPress® Shortcodes escaped.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('[gallery]') === '[[gallery]]'
			 * @assert ('[gallery][/gallery]') === '[[gallery][/gallery]]'
			 *
			 * @TODO Create deep variation.
			 */
			public function esc_shortcodes($string)
				{
					$this->check_arg_types('string', func_get_args());

					if(empty($GLOBALS['shortcode_tags']) || !is_array($GLOBALS['shortcode_tags']))
						return $string; // Nothing to do.

					return preg_replace_callback('/'.get_shortcode_regex().'/s', array($this, '_esc_shortcodes'), $string);
				}

			/**
			 * Callback handler for escaping WordPress® Shortcodes.
			 *
			 * @param array $m An array of regex matches.
			 *
			 * @return string Escaped Shortcode.
			 *
			 * @throws exception If invalid types are passed through arguments list (disabled).
			 *
			 * @assert (array('[hello]')) === '[[hello]]'
			 */
			public function _esc_shortcodes($m)
				{
					// Commenting this out for performance.
					// This is used as a callback for ``preg_replace()``, so it's NOT absolutely necessary.
					// $this->check_arg_types('array', func_get_args());

					if(isset($m[1], $m[6]) && $m[1] === '[' && $m[6] === ']')
						return $m[0]; // Already escaped.

					else // Escape by wrapping with `[` ... `]`.
						return '['.$m[0].']';
				}

			/**
			 * Escapes regex special chars deeply (i.e. ``preg_quote()`` deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed  $value Any value can be converted into a quoted string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param string $delimiter Same as PHP's ``preg_quote()``.
			 *
			 * @return string|array|object Escaped string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (array('$hello'), '/') === array('\\$hello')
			 * @assert (array(array('$hello:'), array('$hello:')), '/') === array(array('\\$hello\\:'), array('\\$hello\\:'))
			 * @assert ('$hello', '/') === '\\$hello'
			 */
			public function preg_quote_deep($value, $delimiter = '')
				{
					$this->check_arg_types('', 'string', func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->preg_quote_deep($_value, $delimiter);
							unset($_value);

							return $value;
						}
					return preg_quote((string)$value, $delimiter);
				}

			/**
			 * Trims a string value.
			 *
			 * @param string $string A string value.
			 *
			 * @param string $chars Specific chars to trim.
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
			 *
			 * @param string $extra_chars Additional chars to trim.
			 *
			 * @return string Trimmed string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (' hello ') === 'hello'
			 * @assert ('.. hello @.. ', '', '.@') === 'hello'
			 * @assert ('.. hello @.. ', '.@') === ' hello @.. '
			 */
			public function trim($string, $chars = '', $extra_chars = '')
				{
					$this->check_arg_types('string', 'string', 'string', func_get_args());

					return $this->trim_deep($string, $chars, $extra_chars);
				}

			/**
			 * Trims strings deeply.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed  $value Any value can be converted into a trimmed string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param string $chars Specific chars to trim.
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
			 *
			 * @param string $extra_chars Additional chars to trim.
			 *
			 * @return string|array|object Trimmed string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (' hello ') === 'hello'
			 * @assert ('.. hello @.. ', '', '.@') === 'hello'
			 * @assert ('.. hello @.. ', '.@') === ' hello @.. '
			 * @assert (array(' hello ')) === array('hello')
			 * @assert (array(array('.. hello @.. '), array('.. hello @.. ')), '', '.@') === array(array('hello'), array('hello'))
			 * @assert (array(array('.. hello @.. '), array('.. hello @.. ')), '.@') === array(array(' hello @.. '), array(' hello @.. '))
			 */
			public function trim_deep($value, $chars = '', $extra_chars = '')
				{
					$this->check_arg_types('', 'string', 'string', func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->trim_deep($_value, $chars, $extra_chars);
							unset($_value);

							return $value;
						}
					$chars = (strlen($chars)) ? $chars : " \r\n\t\0\x0B";
					$chars = $chars.$extra_chars;

					return trim((string)$value, $chars);
				}

			/**
			 * Strips slashes (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed $value Any value can be converted into a stripped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object Stripped string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('\\hello\\') === 'hello'
			 * @assert (array('\\hello\\', array('\\hello\\'))) === array('hello', array('hello'))
			 */
			public function strip_deep($value)
				{
					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value) // Recursion.
								$_value = $this->strip_deep($_value);
							unset($_value); // Housekeeping.

							return $value; // Array or object value.
						}
					return stripslashes((string)$value);
				}

			/**
			 * Adds slashes (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed $value Any value can be converted into a slashes string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object Slashed string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ("Jason's") === 'Jason\\'s'
			 * @assert (array("Jason's", array("Jason's"))) === array('Jason\\'s', array('Jason\\'s'))
			 */
			public function slash_deep($value)
				{
					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value) // Recursion.
								$_value = $this->slash_deep($_value);
							unset($_value); // Housekeeping.

							return $value; // Array or object value.
						}
					return addslashes((string)$value);
				}

			/**
			 * Trims and strips slashes from a string.
			 *
			 * @param string $string A string value.
			 *
			 * @param string $chars Specific chars to trim.
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
			 *
			 * @param string $extra_chars Additional chars to trim.
			 *
			 * @return string Trimmed string value.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (' hello ') === 'hello'
			 * @assert ('.. hello @.. ', '', '.@') === 'hello'
			 * @assert ('.. foo\\\'s @.. ', '.@') === ' foo\'s @.. '
			 */
			public function trim_strip($string, $chars = '', $extra_chars = '')
				{
					$this->check_arg_types('string', 'string', 'string', func_get_args());

					return $this->trim_strip_deep($string, $chars, $extra_chars);
				}

			/**
			 * Trims/strips slashes from strings deeply.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed  $value Any value can be converted into a trimmed/stripped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param string $chars Specific chars to trim.
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
			 *
			 * @param string $extra_chars Additional chars to trim.
			 *
			 * @return string|array|object Trimmed/stripped string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (' hello ') === 'hello'
			 * @assert ('.. hello @.. ', '', '.@') === 'hello'
			 * @assert ('.. hello @.. ', '.@') === ' hello @.. '
			 * @assert (array(' hello ')) === array('hello')
			 * @assert (array('.. hello @.. '), '', '.@') === array('hello')
			 * @assert (array('.. hello @.. '), '.@') === array(' hello @.. ')
			 * @assert (array('.. foo\\\'s @.. '), '.@') === array(' foo\'s @.. ')
			 * @assert (array(array('.. foo\\\'s @.. '), array('.. foo\\\'s @.. ')), '.@') === array(array(' foo\'s @.. '), array(' foo\'s @.. '))
			 * @assert (array(array('.. hello @..\\ '), array('.. hello @..\\ ')), '', '.@') === array(array('hello'), array('hello'))
			 */
			public function trim_strip_deep($value, $chars = '', $extra_chars = '')
				{
					$this->check_arg_types('', 'string', 'string', func_get_args());

					return $this->trim_deep($this->strip_deep($value), $chars, $extra_chars);
				}

			/**
			 * Trims an HTML content string.
			 *
			 * @param string $string A string value.
			 *
			 * @param string $chars Other specific chars to trim (HTML whitespace is always trimmed).
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
			 *
			 * @param string $extra_chars Additional specific chars to trim.
			 *
			 * @return string Trimmed string (HTML whitespace is always trimmed).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function trim_content($string, $chars = '', $extra_chars = '')
				{
					$this->check_arg_types('string', 'string', 'string', func_get_args());

					return $this->trim_content_deep($string, $chars, $extra_chars);
				}

			/**
			 * Trims an HTML content string deeply.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed  $value Any value can be converted into a trimmed string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param string $chars Other specific chars to trim (HTML whitespace is always trimmed).
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
			 *
			 * @param string $extra_chars Additional specific chars to trim.
			 *
			 * @return string|array|object Trimmed string, array, object (HTML whitespace is always trimmed).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function trim_content_deep($value, $chars = '', $extra_chars = '')
				{
					$this->check_arg_types('', 'string', 'string', func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->trim_content_deep($_value, $chars, $extra_chars);
							unset($_value);

							return $this->trim_deep($value, $chars, $extra_chars);
						}
					$whitespace = implode('|', array_keys($this->html_whitespace));
					$value      = preg_replace('/^(?:'.$whitespace.')+|(?:'.$whitespace.')+$/', '', (string)$value);

					return $this->trim_deep($value, $chars, $extra_chars);
				}

			/**
			 * Trims double quotes (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed $value Any value can be converted into a trimmed string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object Trimmed string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('"hello"') === 'hello'
			 */
			public function trim_dq_deep($value)
				{
					return $this->trim_deep($value, '', '"');
				}

			/**
			 * Trims single quotes (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed $value Any value can be converted into a trimmed string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object Trimmed string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ("'hello'") === 'hello'
			 */
			public function trim_sq_deep($value)
				{
					return $this->trim_deep($value, '', "'");
				}

			/**
			 * Trims double/single quotes (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed $value Any value can be converted into a trimmed string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object Trimmed string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('\'"hello"\'') === 'hello'
			 */
			public function trim_dsq_deep($value)
				{
					return $this->trim_deep($value, '', '"\'');
				}

			/**
			 * Trims all single/double quotes, including entity variations (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed   $value Any value can be converted into a trimmed string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param boolean $trim_dsq Defaults to TRUE.
			 *    If FALSE, normal double/single quotes will NOT be trimmed, only entities.
			 *
			 * @return string|array|object Trimmed string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('&quot;\'"hello"\'&quot;') === 'hello'
			 * @assert ('&quot;\'"hello"\'&quot;', FALSE) === '\'"hello"\''
			 */
			public function trim_qts_deep($value, $trim_dsq = TRUE)
				{
					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value) // Recursion.
								$_value = $this->trim_qts_deep($_value, $trim_dsq);
							unset($_value); // Housekeeping.

							return $value; // Array or object value.
						}
					$qts = implode('|', array_keys($this->quote_entities_w_variations));
					$qts = ($trim_dsq) ? $qts.'|"|\'' : $qts;

					return preg_replace('/^(?:'.$qts.')+|(?:'.$qts.')+$/', '', (string)$value);
				}

			/**
			 * Case insensitive string replace (ONE time).
			 *
			 * @param string|array $needle String, or an array of strings, to search for.
			 *
			 * @param string|array $replace String, or an array of strings, to use as replacements.
			 *
			 * @param string       $string A string to run replacements on (i.e. the string to search in).
			 *
			 * @return string Value of ``$string`` after ONE replacement.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception For better performance, this function will NOT try to catch PHP string conversion errors when objects are passed inside ``$needle`` or ``$replace`` values.
			 *    To avoid string conversion errors from PHP, please refrain from passing objects in ``$needle`` or ``$replace`` arrays (that would make no sense anyway).
			 *
			 * @assert ('hello-', '', 'hello-hello-there') === 'hello-there'
			 * @assert ('heLlo-', '', 'HELLO-hello-there') === 'hello-there'
			 */
			public function ireplace_once($needle, $replace, $string)
				{
					$this->check_arg_types(array('string', 'array'), array('string', 'array'), 'string', func_get_args());

					return $this->replace_once_deep($needle, $replace, $string, TRUE);
				}

			/**
			 * Case insensitive string replace (ONE time), and deeply into arrays/objects.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param string|array $needle String, or an array of strings, to search for.
			 *
			 * @param string|array $replace String, or an array of strings, to use as replacements.
			 *
			 * @param mixed        $value Any value can be converted into a string to run replacements on.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return mixed Values after ONE replacement (deeply).
			 *    Any values that were NOT strings|arrays|objects, will be converted to strings by this routine.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception For better performance, this function will NOT try to catch PHP string conversion errors when objects are passed inside ``$needle`` or ``$replace`` values.
			 *    To avoid string conversion errors from PHP, please refrain from passing objects in ``$needle`` or ``$replace`` arrays (that would make no sense anyway).
			 *
			 * @assert ('hello-', '', 'hello-hello-there') === 'hello-there'
			 * @assert ('heLlo-', '', 'HELLO-hello-there') === 'hello-there'
			 * @assert ('heLlo-', '', array('HELLO-hello-there', 'HELLO-hello-there')) === array('hello-there', 'hello-there')
			 * @assert (array('heLlo-', '-ThEre'), '', array('HELLO-hello-there', 'HELLO-hello-there')) === array('hello', 'hello')
			 * @assert (array('heLlo-', '-ThEre'), array('hi-', '-jason'), array('HELLO-hello-there', 'HELLO-hello-there')) === array('hi-hello-jason', 'hi-hello-jason')
			 * @assert ('heLlo-', '', array('HELLO-hello-there', 'hello-there')) === array('hello-there', 'there')
			 */
			public function ireplace_once_deep($needle, $replace, $value)
				{
					$this->check_arg_types(array('string', 'array'), array('string', 'array'), '', func_get_args());

					return $this->replace_once_deep($needle, $replace, $value, TRUE);
				}

			/**
			 * String replace (ONE time).
			 *
			 * @param string|array $needle String, or an array of strings, to search for.
			 *
			 * @param string|array $replace String, or an array of strings, to use as replacements.
			 *
			 * @param string       $string A string to run replacements on (i.e. the string to search in).
			 *
			 * @param boolean      $case_insensitive Case insensitive? Defaults to FALSE.
			 *    If TRUE, the search is NOT case sensitive.
			 *
			 * @return string Value of ``$string`` after ONE string replacement.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception For better performance, this function will NOT try to catch PHP string conversion errors when objects are passed inside ``$needle`` or ``$replace`` values.
			 *    To avoid string conversion errors from PHP, please refrain from passing objects in ``$needle`` or ``$replace`` arrays (that would make no sense anyway).
			 *
			 * @assert ('hello-', '', 'hello-hello-there') === 'hello-there'
			 * @assert ('heLlo-', '', 'HELLO-hello-there') === 'HELLO-hello-there'
			 * @assert ('heLlo-', '', 'HELLO-hello-there', TRUE) === 'hello-there'
			 * @assert ('heLlo-', array(), 'HELLO-hello-there', TRUE) === 'hello-there'
			 * @assert ('heLlo-', array('hi-'), 'HELLO-hello-there', TRUE) === 'hi-hello-there'
			 * @assert ('heLlo-', array('hi-'), 'HELLO-hello-there') === 'HELLO-hello-there'
			 * @assert (array('heLlo-', '-theRe'), array('hi-'), 'HELLO-hello-there', TRUE) === 'hi-hello'
			 * @assert (array('heLlo-', '-theRe'), array('hi-', '-jason'), 'HELLO-hello-there', TRUE) === 'hi-hello-jason'
			 * @assert (array('heLlo-', '-there'), array('hi-', '-jason'), 'HELLO-hello-there') === 'HELLO-hello-jason'
			 */
			public function replace_once($needle, $replace, $string, $case_insensitive = FALSE)
				{
					$this->check_arg_types(array('string', 'array'), array('string', 'array'), 'string', 'boolean', func_get_args());

					return $this->replace_once_deep($needle, $replace, $string, $case_insensitive);
				}

			/**
			 * String replace (ONE time), and deeply into arrays/objects.
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param string|array $needle String, or an array of strings, to search for.
			 *
			 * @param string|array $replace String, or an array of strings, to use as replacements.
			 *
			 * @param mixed        $value Any value can be converted into a string to run replacements on.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param boolean      $case_insensitive Case insensitive? Defaults to FALSE.
			 *    If TRUE, the search is NOT case sensitive.
			 *
			 * @return mixed Values after ONE string replacement (deeply).
			 *    Any values that were NOT strings|arrays|objects, will be converted to strings by this routine.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception For better performance, this function will NOT try to catch PHP string conversion errors when objects are passed inside ``$needle`` or ``$replace`` values.
			 *    To avoid string conversion errors from PHP, please refrain from passing objects in ``$needle`` or ``$replace`` arrays (that would make no sense anyway).
			 *
			 * @see http://stackoverflow.com/questions/8177296/when-to-use-strtr-vs-str-replace
			 *
			 * @assert ('hello-', '', 'hello-hello-there') === 'hello-there'
			 * @assert ('heLlo-', '', 'HELLO-hello-there') === 'HELLO-hello-there'
			 * @assert ('heLlo-', '', 'HELLO-hello-there', TRUE) === 'hello-there'
			 * @assert ('heLlo-', array(), 'HELLO-hello-there', TRUE) === 'hello-there'
			 * @assert ('heLlo-', array('hi-'), 'HELLO-hello-there', TRUE) === 'hi-hello-there'
			 * @assert ('heLlo-', array('hi-'), 'HELLO-hello-there') === 'HELLO-hello-there'
			 * @assert (array('heLlo-', '-theRe'), array('hi-'), 'HELLO-hello-there', TRUE) === 'hi-hello'
			 * @assert (array('heLlo-', '-theRe'), array('hi-', '-jason'), 'HELLO-hello-there', TRUE) === 'hi-hello-jason'
			 * @assert (array('heLlo-', '-there'), array('hi-', '-jason'), 'HELLO-hello-there') === 'HELLO-hello-jason'
			 * @assert (array('heLlo-', '-theRe'), array('hi-', '-jason'), array('HELLO-hello-there', 'HELLO-hello-there'), TRUE) === array('hi-hello-jason', 'hi-hello-jason')
			 * @assert (array('heLlo-', '-there'), array('hi-', '-jason'), array('HELLO-hello-there', 'HELLO-hello-there')) === array('HELLO-hello-jason', 'HELLO-hello-jason')
			 */
			public function replace_once_deep($needle, $replace, $value, $case_insensitive = FALSE)
				{
					$this->check_arg_types(array('string', 'array'), array('string', 'array'), '', 'boolean', func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value) // Recursion.
								$_value = $this->replace_once($needle, $replace, $_value, $case_insensitive);
							unset($_value); // Housekeeping.

							return $value; // Array or object.
						}
					else // Otherwise, we handle the find/replace routine now.
						{
							$value = (string)$value; // Force string value.

							if($case_insensitive) // Case insensitive scenario?
								$strpos = 'stripos'; // Use ``stripos()``.
							else $strpos = 'strpos'; // Default.

							if(is_array($needle)) // Array of needles?
								{
									if(is_array($replace)) // Optimized for ``$replace`` array.
										{
											foreach($needle as $_key => $_needle)
												if(($_strpos = $strpos($value, ($_needle = (string)$_needle))) !== FALSE)
													{
														$_length  = strlen($_needle);
														$_replace = (isset($replace[$_key])) ? (string)$replace[$_key] : '';
														$value    = substr_replace($value, $_replace, $_strpos, $_length);
													}
											unset($_key, $_needle, $_strpos, $_length, $_replace);

											return $value; // Return string value.
										}
									else // Optimized for ``$replace`` string.
										{
											$_replace = $replace; // String.

											foreach($needle as $_needle)
												if(($_strpos = $strpos($value, ($_needle = (string)$_needle))) !== FALSE)
													{
														$_length = strlen($_needle);
														$value   = substr_replace($value, $_replace, $_strpos, $_length);
													}
											unset($_needle, $_strpos, $_length, $_replace);

											return $value; // Return string value.
										}
								}
							else // Otherwise, just a simple case here.
								{
									if(($_strpos = $strpos($value, $needle)) !== FALSE)
										{
											$_length = strlen($needle);

											if(is_array($replace)) // Use 1st element, else empty string.
												$_replace = (isset($replace[0])) ? (string)$replace[0] : '';
											else $_replace = $replace; // Use string value.

											$value = substr_replace($value, $_replace, $_strpos, $_length);
										}
									return $value; // Return string value.
								}
						}
				}

			/**
			 * Strips leading space and/or tab indentations.
			 *
			 * @param string $string A string value.
			 *
			 * @return string String minus leading indentation.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ("  \t  hello\n  \t  there") === 'hello'."\n".'there'
			 *
			 * @TODO Create deep variation.
			 */
			public function strip_leading_indents($string)
				{
					$this->check_arg_types('string', func_get_args());

					$string = trim($string, "\r\n");

					if(preg_match("/^([ \t]+)/", $string, $_m))
						$string = preg_replace("/^[ \t]{".strlen($_m[1])."}/m", '', $string);
					unset($_m); // A little housekeeping.

					return $string;
				}

			/**
			 * Sanitizes a string; by stripping characters NOT on a standard U.S. keyboard.
			 *
			 * @param string $string Input string.
			 *
			 * @return string Output string, after characters NOT on a standard U.S. keyboard have been stripped.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('hello® there') === 'hello there'
			 *
			 * @TODO Create deep variation.
			 */
			public function strip_2_kb_chars($string)
				{
					$this->check_arg_types('string', func_get_args());

					return preg_replace('/[^0-9A-Z'."\r\n\t".'\s`\=\[\]\\\\;,\.\/~\!@#\$%\^&\*\(\)_\+\|\}\{\:\?\>\<"\'\-]/i', '', remove_accents($string));
				}

			/**
			 * Generates a random string with letters/numbers/symbols.
			 *
			 * @param integer $length Optional. Defaults to `12`.
			 *    Length of the random string.
			 *
			 * @param boolean $special_chars Defaults to TRUE.
			 *    If FALSE, special chars are NOT included.
			 *
			 * @param boolean $extra_special_chars Defaults to FALSE.
			 *    If TRUE, extra special chars are included.
			 *
			 * @return string A randomly generated string, based on configuration.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert () !empty TRUE
			 */
			public function random($length = 12, $special_chars = TRUE, $extra_special_chars = FALSE)
				{
					$this->check_arg_types('integer', 'boolean', 'boolean', func_get_args());

					$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$chars .= ($special_chars) ? '!@#$%^&*()' : '';
					$chars .= ($extra_special_chars) ? '-_ []{}<>~`+=,.;:/?|' : '';

					for($i = 0, $random_str = ''; $i < abs($length); $i++)
						$random_str .= (string)substr($chars, mt_rand(0, strlen($chars) - 1), 1);

					return $random_str;
				}

			/**
			 * Base64 URL-safe encoding.
			 *
			 * @param string $string Input string to be base64 encoded.
			 *
			 * @param array  $url_unsafe_chars Optional. An array of un-safe characters.
			 *    Defaults to: ``array('+', '/')``.
			 *
			 * @param array  $url_safe_chars Optional. An array of safe character replacements.
			 *    Defaults to: ``array("-", "_")``.
			 *
			 * @param string $trim_padding_chars Optional. A string of padding chars to rtrim.
			 *    Defaults to: `=`.
			 *
			 * @return string The base64 URL-safe encoded string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If the call to ``base64_encode()`` fails.
			 *
			 * @assert ('hello') !empty TRUE
			 */
			public function base64_url_safe_encode($string, $url_unsafe_chars = array('+', '/'), $url_safe_chars = array('-', '_'), $trim_padding_chars = '=')
				{
					$this->check_arg_types('string', 'array', 'array', 'string', func_get_args());

					if(!is_string($base64_url_safe = base64_encode($string)))
						throw $this->©exception(
							__METHOD__.'#failure', compact('base64_url_safe'),
							$this->i18n('Base64 encoding failed (`$base64_url_safe` is NOT a string).')
						);

					$base64_url_safe = str_replace($url_unsafe_chars, $url_safe_chars, $base64_url_safe);
					$base64_url_safe = (strlen($trim_padding_chars)) ? rtrim($base64_url_safe, $trim_padding_chars) : $base64_url_safe;

					return $base64_url_safe;
				}

			/**
			 * Base64 URL-safe decoding.
			 *
			 * @param string $base64_url_safe Input string to be base64 decoded.
			 *
			 * @param array  $url_unsafe_chars Optional. An array of un-safe character replacements.
			 *    Defaults to: ``array('+', '/')``.
			 *
			 * @param array  $url_safe_chars Optional. An array of safe characters.
			 *    Defaults to: ``array('-', '_')``.
			 *
			 * @param string $trim_padding_chars Optional. A string of padding chars to rtrim.
			 *    Defaults to: `=`.
			 *
			 * @return string The decoded string. Or, possibly the original string, if ``$base64_url_safe``
			 *    was NOT base64 encoded to begin with. Helps prevent accidental data corruption.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $string = 'hello';
			 * $base64 = $this->object->base64_url_safe_encode($string);
			 *    ($base64) === 'hello'
			 */
			public function base64_url_safe_decode($base64_url_safe, $url_unsafe_chars = array('+', '/'), $url_safe_chars = array('-', '_'), $trim_padding_chars = '=')
				{
					$this->check_arg_types('string', 'array', 'array', 'string', func_get_args());

					$string = (strlen($trim_padding_chars)) ? rtrim($base64_url_safe, $trim_padding_chars) : $base64_url_safe;
					$string = (strlen($trim_padding_chars)) ? str_pad($string, strlen($string) % 4, '=', STR_PAD_RIGHT) : $string;
					$string = str_replace($url_safe_chars, $url_unsafe_chars, $string);

					if(!is_string($string = base64_decode($string, TRUE)))
						return ($original = $base64_url_safe);

					return $string;
				}

			/**
			 * Decodes unreserved chars encoded by PHP's ``urlencode()`` (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed $value Any value can be converted into a decoded string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object Decoded string, array, object.
			 *
			 * @see http://www.faqs.org/rfcs/rfc3986.html
			 *
			 * @assert $array = array(urlencode('hello-there now'));
			 *    ($array) === array('hello-there+now')
			 */
			public function urldecode_ur_chars_deep($value)
				{
					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->urldecode_ur_chars_deep($_value);
							unset($_value);

							return $value;
						}
					return str_replace(
						array('%2D', '%2E', '%5F', '%7E'),
						array('-', '.', '_', '~'),
						(string)$value
					);
				}

			/**
			 * Wraps strings with the characters provided (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed   $value Any value can be converted into a wrapped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param string  $beginning Optional. Defaults to an empty string.
			 *    A string value to wrap at the beginning of each value.
			 *
			 * @param string  $end Optional. Defaults to an empty string.
			 *    A string value to wrap at the end of each value.
			 *
			 * @param boolean $wrap_0b_strings Optional. Defaults to a TRUE value.
			 *    Should 0-byte strings be wrapped too?
			 *
			 * @param boolean $convert_nulls_no_wrap Optional. Defaults to a FALSE value.
			 *    By default, we convert all values into strings, and wrap them (based on ``$wrap_0b_strings``).
			 *    However, if this is TRUE, NULL values are treated differently. We convert them to the string `NULL`, and they are NOT wrapped up.
			 *    This is useful when data is being prepared for database insertion and/or updates.
			 *
			 * @return string|array|object Wrapped string, array, object (possible `NULL` string if ``$convert_null_no_wrap`` is TRUE).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $array = array('hello', 'there', '');
			 *    ($array, 'begin:', ':end') === array('begin:hello:end', 'begin:there:end', 'begin::end')
			 *
			 * @assert $array = array('hello', 'there', '');
			 *    ($array, 'begin:', ':end', FALSE) === array('begin:hello:end', 'begin:there:end', '')
			 */
			public function wrap_deep($value, $beginning = '', $end = '', $wrap_0b_strings = TRUE, $convert_nulls_no_wrap = FALSE)
				{
					$this->check_arg_types('', 'string', 'string', 'boolean', 'boolean', func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->wrap_deep($_value, $beginning, $end, $wrap_0b_strings);
							unset($_value);

							return $value;
						}
					if(is_null($value) && $convert_nulls_no_wrap)
						return 'NULL'; // String `NULL` in this case.

					$value = (string)$value;
					if($wrap_0b_strings || strlen($value))
						$value = $beginning.$value.$end;

					return $value; // Final value.
				}

			/**
			 * Wordwrap (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed   $value Any value can be converted into a word-wrapped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param integer $width See PHP's ``wordwrap()`` function.
			 * @param string  $break See PHP's ``wordwrap()`` function.
			 * @param boolean $cut See PHP's ``wordwrap()`` function.
			 *
			 * @param boolean $___recursion Internal use only.
			 *
			 * @return string|array|object Word-wrapped string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @TODO Update several methods in this class with an internal ``$___recursion`` parameter.
			 */
			public function wordwrap_deep($value, $width = 75, $break = "\n", $cut = FALSE, $___recursion = FALSE)
				{
					if(!$___recursion) // Only for the initial caller.
						$this->check_arg_types('', 'integer', 'string', 'boolean', func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value) // Recursion.
								$_value = $this->wordwrap_deep($_value, $width, $break, $cut, TRUE);
							unset($_value); // Housekeeping.

							return $value; // Array or object value.
						}
					return wordwrap((string)$value, $width, $break, $cut);
				}

			/**
			 * Checks if a string is encoded as UTF-8.
			 *
			 * @param string $string An input string to test against.
			 *
			 * @return boolean TRUE if the string is UTF-8, else FALSE.
			 */
			public function is_utf8($string)
				{
					$this->check_arg_types('string', func_get_args());

					if(!strlen($string) || seems_utf8($string))
						return TRUE;

					return FALSE;
				}

			/**
			 * Converts a string to UTF-8 encoding.
			 *
			 * @param string       $string An input string to convert to UTF-8.
			 *
			 * @param string|array $detection_order Optional. Defaults to ``$this->mb_detection_order``.
			 *    If a NON-empty string/array is provided, it is used instead.
			 *
			 * @return string A UTF-8 encoded string value.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function to_utf8($string, $detection_order = array())
				{
					$this->check_arg_types('string', array('string', 'array'), func_get_args());

					return $this->to_utf8_deep($string, $detection_order);
				}

			/**
			 * Converts strings to UTF-8 (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed        $value Any value can be converted into a UTF-8 string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param string|array $detection_order Optional. Defaults to ``$this->mb_detection_order``.
			 *    If a NON-empty string/array is provided, it is used instead.
			 *
			 * @return string|array|object UTF-8 string, array, object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function to_utf8_deep($value, $detection_order = array())
				{
					$this->check_arg_types('', array('string', 'array'), func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->to_utf8_deep($_value, $detection_order);
							unset($_value);

							return $value;
						}

					if(!$this->is_utf8($value = (string)$value))
						{
							if(empty($detection_order))
								$detection_order = $this->mb_detection_order;

							if($this->©function->is_possible('mb_convert_encoding'))
								$value = mb_convert_encoding($value, 'UTF-8', $detection_order);
						}
					return $value;
				}

			/**
			 * Converts a string into a hexadecimal notation.
			 *
			 * @param string $string String to convert into a hexadecimal notation.
			 *
			 * @return string Hexadecimal notation.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function to_hex($string)
				{
					$this->check_arg_types('string', func_get_args());

					return $this->to_hex_deep($string);
				}

			/**
			 * Converts strings to a hexadecimal notation (deeply).
			 *
			 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
			 * @note This routine will usually NOT include private, protected or static properties of an object class.
			 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
			 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by ``foreach()``.
			 *
			 * @param mixed $value Any value can be converted into a UTF-8 string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object Hexadecimal notation. Or an array/object containing strings in hexadecimal notation.
			 */
			public function to_hex_deep($value)
				{
					if(is_array($value) || is_object($value))
						{
							foreach($value as &$_value)
								$_value = $this->to_hex_deep($_value);
							unset($_value);

							return $value;
						}
					if(strlen($value = (string)$value))
						$value = '\\x'.substr(chunk_split(bin2hex($value), 2, '\\x'), 0, -2);

					return $value;
				}

			/**
			 * Adds quotes to invalid JSON code.
			 *
			 * @note This comes in handy when we're dealing with APIs that do things wrong.
			 *
			 * @param string $json JSON code to quotify.
			 *
			 * @return string Quotified JSON code.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $invalid_json = '{a:1,b:2,c:3,d:4,"e":5}';
			 *    ($invalid_json) === '{"a":1,"b":2,"c":3,"d":4,"e":5}'
			 */
			public function json_quotify($json)
				{
					$this->check_arg_types('string', func_get_args());

					return preg_replace('/([{,])\s*([^"]+?)\s*:/', '$1"$2":', $json);
				}

			/**
			 * Gets a string containing a verbose description of: ``preg_last_error()``.
			 *
			 * @return string Verbose description of ``preg_last_error()``.
			 *
			 * @assert () === 'None: `PREG_NO_ERROR`.'
			 */
			public function preg_last_error()
				{
					$preg_last_error = preg_last_error();

					if($preg_last_error == PREG_NO_ERROR)
						return $this->i18n('None: `PREG_NO_ERROR`.');

					else if($preg_last_error == PREG_INTERNAL_ERROR)
						return $this->i18n('Internal: `PREG_INTERNAL_ERROR`.');

					else if($preg_last_error == PREG_BACKTRACK_LIMIT_ERROR)
						return $this->i18n('Backtrack limit exhausted: `PREG_BACKTRACK_LIMIT_ERROR`.');

					else if($preg_last_error == PREG_RECURSION_LIMIT_ERROR)
						return $this->i18n('Recursion limit exhausted: `PREG_RECURSION_LIMIT_ERROR`.');

					else if($preg_last_error == PREG_BAD_UTF8_ERROR)
						return $this->i18n('Bad UTF8: `PREG_BAD_UTF8_ERROR`.');

					else if($preg_last_error == PREG_BAD_UTF8_OFFSET_ERROR)
						return $this->i18n('Bad UTF8 offset: `PREG_BAD_UTF8_OFFSET_ERROR`.');

					else return $this->i18n('No error.');
				}

			/**
			 * Generates a unique alphanumeric ID (based on time).
			 *
			 * @param string $prefix Optional. Defaults to an empty string.
			 *    See PHP's ``uniqid()`` function, for further details.
			 *
			 * @return string A unique alphanumeric ID (always w/ extra entropy).
			 *    Always 32 characters; plus the length of the optional ``$prefix``.
			 */
			public function unique_id($prefix = '')
				{
					$this->check_arg_types('string', func_get_args());

					return str_replace('.', '', uniqid($prefix.$this->random(10, FALSE), TRUE));
				}

			/**
			 * Ampersand entities. Keys are actually regex patterns here.
			 *
			 * @var array Ampersand entities. Keys are actually regex patterns here.
			 */
			public $ampersand_entities = array(
				'&amp;'       => '&amp;',
				'&#0*38;'     => '&#38;',
				'&#[xX]0*26;' => '&#x26;'
			);

			/**
			 * HTML whitespace. Keys are actually regex patterns here.
			 *
			 * @var array HTML whitespace. Keys are actually regex patterns here.
			 */
			public $html_whitespace = array(
				'\0\x0B'                  => "\0\x0B",
				'\s'                      => "\r\n\t ",
				'&nbsp;'                  => '&nbsp;',
				'\<br\>'                  => '<br>',
				'\<br\s*\/\>'             => '<br/>',
				'\<p\>(?:&nbsp;)*\<\/p\>' => '<p></p>'
			);

			/**
			 * PHP userland naming standards, via regex pattern.
			 *
			 * @var string PHP userland naming standards, via regex pattern.
			 * @see http://php.net/manual/en/userlandnaming.php
			 */
			public $regex_valid_userland_name = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';

			/**
			 * @var string WebSharks™ plugin variable namespace validation pattern.
			 *
			 *       1. Lowercase alphanumerics and/or underscores only.
			 *       2. CANNOT start or end with an underscore.
			 *       3. MUST start with a letter.
			 *       4. No double underscores.
			 */
			public $regex_valid_ws_plugin_var_ns = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])$/';

			/**
			 * @var string WebSharks™ plugin variable namespace validation pattern.
			 * @note Same as above. This is a static version for the core framework constructor.
			 */
			public static $_4fwc_regex_valid_ws_plugin_var_ns = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])$/';

			/**
			 * @var string WebSharks™ plugin root namespace validation pattern.
			 *
			 *       1. Lowercase alphanumerics and/or underscores only.
			 *       2. CANNOT start or end with an underscore.
			 *       3. MUST start with a letter.
			 *       4. No double underscores.
			 */
			public $regex_valid_ws_plugin_root_ns = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])$/';

			/**
			 * @var string WebSharks™ plugin root namespace validation pattern.
			 * @note Same as above. This is a static version for the core framework constructor.
			 */
			public static $_4fwc_regex_valid_ws_plugin_root_ns = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])$/';

			/**
			 * @var string WebSharks™ namespace\class path validation pattern.
			 *
			 *       1. Lowercase alphanumerics, underscores, and/or namespace `\` separators only.
			 *       2. MUST contain at least one namespace path (i.e. it MUST be within a namespace).
			 *       3. A path element CANNOT start or end with an underscore.
			 *       4. Each path element MUST start with a letter.
			 *       5. No double underscores in any path element.
			 */
			public $regex_valid_ws_ns_class = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])(?:\\\\(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z]))+$/';

			/**
			 * @var string WebSharks™ namespace\class path validation pattern.
			 * @note Same as above. This is a static version for the core framework constructor.
			 */
			public static $_4fwc_regex_valid_ws_ns_class = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])(?:\\\\(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z]))+$/';

			/**
			 * @var string Valid WebSharks™ flavored PHP namespace version (regex pattern).
			 * @see http://php.net/manual/en/function.version-compare.php
			 *
			 *       1. MUST start with the core namespace stub: `websharks_core`;
			 *          (caSe is ONLY relevant here in the core namespace stub and `_v`).
			 *       However, see: {@link \websharks_core_v000000_dev\strings\regex_valid_ws_ns_class}.
			 *          All namespace\class paths MUST be lowercase at all times (so caSe is important here).
			 *       2. MUST then include a `_v` (lowercase) followed by six digits.
			 *       3. May optionally end with a PHP version-compatible suffix;
			 *          (but NO dashes; only underscores).
			 *       5. MUST always end with an alphanumeric value.
			 *       4. May NOT contain double underscores.
			 */
			public $regex_valid_ws_core_ns_version = '/^websharks_core_v[0-9]{6}(?:_(?:[a-zA-Z](?:[a-zA-Z0-9]|_(?!_))*[a-zA-Z0-9]|[a-zA-Z]))?$/';

			/**
			 * @var string Valid WebSharks™ flavored PHP namespace version (regex pattern).
			 * @note Same as above. This is a static version for the core framework constructor.
			 */
			public static $_4fwc_regex_valid_ws_core_ns_version = '/^websharks_core_v[0-9]{6}(?:_(?:[a-zA-Z](?:[a-zA-Z0-9]|_(?!_))*[a-zA-Z0-9]|[a-zA-Z]))?$/';

			/**
			 * @var string Valid WebSharks™ flavored PHP namespace version (regex pattern with a dashed variation).
			 * @see http://php.net/manual/en/function.version-compare.php
			 *
			 *       1. MUST start with the core namespace stub: `websharks-core`;
			 *          (caSe is ONLY relevant here in the core namespace stub and `-v`).
			 *       2. MUST then include a `-v` (lowercase); followed by six digits.
			 *       3. May optionally end with a PHP version-compatible suffix.
			 *       5. MUST always end with an alphanumeric value.
			 *       4. May NOT contain double underscores.
			 */
			public $regex_valid_ws_core_ns_version_with_dashes = '/^websharks\-core\-v[0-9]{6}(?:\-(?:[a-zA-Z](?:[a-zA-Z0-9]|\-(?!\-))*[a-zA-Z0-9]|[a-zA-Z]))?$/';

			/**
			 * @var string Valid WebSharks™ flavored PHP namespace version (regex pattern with a dashed variation).
			 * @note Same as above. This is a static version for the core framework constructor.
			 */
			public static $_4fwc_regex_valid_ws_core_ns_version_with_dashes = '/^websharks\-core\-v[0-9]{6}(?:\-(?:[a-zA-Z](?:[a-zA-Z0-9]|\-(?!\-))*[a-zA-Z0-9]|[a-zA-Z]))?$/';

			/**
			 * @var string Valid WebSharks™ flavored PHP version string (regex pattern).
			 * @see http://php.net/manual/en/function.version-compare.php
			 *
			 *       1. Alphanumerics and/or dashes only (caSe is NOT important here).
			 *       2. CANNOT start or end with a dash.
			 *       3. MUST start with 6 digits(i.e. `YYMMDD`).
			 *       4. An optional development state is allowed;
			 *          (MUST be prefixed by a dash).
			 *       5. May NOT contain double dashes.
			 */
			public $regex_valid_ws_version = '/^[0-9]{6}(?:\-(?:[a-zA-Z](?:[a-zA-Z0-9]|\-(?!\-))*[a-zA-Z0-9]|[a-zA-Z]))?$/';

			/**
			 * @var string Valid WebSharks™ flavored PHP version string (regex pattern).
			 * @note Same as above. This is a static version for the core framework constructor.
			 */
			public static $_4fwc_regex_valid_ws_version = '/^[0-9]{6}(?:\-(?:[a-zA-Z](?:[a-zA-Z0-9]|\-(?!\-))*[a-zA-Z0-9]|[a-zA-Z]))?$/';

			/**
			 * @var string Valid PHP version string (regex pattern).
			 *    Standard PHP version strings which allow a dotted notation also.
			 * @see http://php.net/manual/en/function.version-compare.php
			 */
			public $regex_valid_version = '/^(?:[0-9](?:[a-zA-Z0-9]|\.(?!\.))*[a-zA-Z0-9]|[0-9]+)(?:\-(?:[a-zA-Z](?:[a-zA-Z0-9]|\-(?![\-\.])|\.(?![\.\-]))*[a-zA-Z0-9]|[a-zA-Z]))?$/';

			/**
			 * Quote entities. Keys are actually regex patterns here.
			 *
			 * @var array Quote entities. Keys are actually regex patterns here.
			 */
			public $quote_entities_w_variations = array(
				'&apos;'           => '&apos;',
				'&#0*39;'          => '&#39;',
				'&#[xX]0*27;'      => '&#x27;',
				'&lsquo;'          => '&lsquo;',
				'&#0*8216;'        => '&#8216;',
				'&#[xX]0*2018;'    => '&#x2018;',
				'&rsquo;'          => '&rsquo;',
				'&#0*8217;'        => '&#8217;',
				'&#[xX]0*2019;'    => '&#x2019;',
				'&quot;'           => '&quot;',
				'&#0*34;'          => '&#34;',
				'&#[xX]0*22;'      => '&#x22;',
				'&ldquo;'          => '&ldquo;',
				'&#0*8220;'        => '&#8220;',
				'&#[xX]0*201[cC];' => '&#x201C;',
				'&rdquo;'          => '&rdquo;',
				'&#0*8221;'        => '&#8221;',
				'&#[xX]0*201[dD];' => '&#x201D;'
			);

			/**
			 * Multibyte detection order.
			 *
			 * @var array Default character encoding detections.
			 */
			public $mb_detection_order = array('UTF-8', 'ISO-8859-1');
		}
	}