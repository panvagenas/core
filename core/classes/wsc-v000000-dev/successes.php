<?php
/**
 * Successes.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace wsc_v000000_dev
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Successes.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class successes extends diagnostics
	{
		/**
		 * @var string Diagnostic type.
		 */
		public $type = 'success';

		/**
		 * @var boolean Log to a DEBUG file?
		 */
		public $wp_debug_log = TRUE;

		/**
		 * @var boolean Log into a DB table?
		 */
		public $db_log = TRUE;
	}
}