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
namespace websharks_core_v000000_dev
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
		 * @var string Specifies diagnostic type.
		 */
		public $type = 'success';

		/**
		 * @var boolean Should this type of diagnostic be logged into a DEBUG file?
		 *    Applies only when/if `WP_DEBUG` mode is enabled.
		 */
		public $wp_debug_log = FALSE;

		/**
		 * @var boolean Should this type of diagnostic be logged into a DB table?
		 */
		public $db_log = TRUE;
	}
}