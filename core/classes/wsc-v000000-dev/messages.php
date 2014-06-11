<?php
/**
 * Messages.
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
	 * Messages.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class messages extends diagnostics
	{
		/**
		 * @var string Diagnostic type.
		 */
		public $type = 'message';

		/**
		 * @var boolean Log to a DEBUG file?
		 */
		public $wp_debug_log = FALSE;

		/**
		 * @var boolean Log into a DB table?
		 */
		public $db_log = FALSE;

	}
}