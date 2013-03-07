<?php
/**
 * JavaScript Minifier.
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
	 * JavaScript Minifier.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class js_minifier extends framework
	{
		/**
		 * JS Minifier object instance (a singleton).
		 *
		 * @var \ws_js_minifier|null Set automatically by ``compress()`` method.
		 */
		public static $minifier;

		/**
		 * Compress JavaScript code (as quickly as possible).
		 *
		 * @param string $js Any JavaScript code (exclude ``<script></script>`` tags please).
		 *
		 * @return string JavaScript after having been compressed as quickly as possible.
		 *    This uses our own modified variation of JS Min to handle compression.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert ('function test (){ var hello1 = "hello world"; }') === 'function test(){var hello1="hello world";}'
		 * @assert ('function test (){ var hello2 = "hello world"; }') === 'function test(){var hello2="hello world";}'
		 */
		public function compress($js)
		{
			$this->check_arg_types('string', func_get_args());

			if(!isset(static::$minifier))
			{
				include_once dirname(__FILE__)."/externals/ws-js-minifier/ws-js-minifier.php";
				static::$minifier = new \ws_js_minifier('');
			}
			return static::$minifier->compress($js);
		}
	}
}