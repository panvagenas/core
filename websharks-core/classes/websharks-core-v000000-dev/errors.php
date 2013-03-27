<?php
/**
 * Errors.
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
		 * Errors.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class errors extends diagnostics
		{
			/**
			 * @var string Specifies diagnostic type.
			 */
			public $type = 'error';

			/**
			 * @var boolean Should this type of diagnostic be logged into a DEBUG file?
			 *    Applies only when/if `WP_DEBUG` mode is enabled.
			 */
			public $wp_debug_log = TRUE;

			/**
			 * @var boolean Should this type of diagnostic be logged into a DB table?
			 */
			public $db_log = TRUE;
		}
	}