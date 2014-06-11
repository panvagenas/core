<?php
/**
 * Capabilities.
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
	 * Capabilities.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class caps extends framework
	{
		/**
		 * Maps our own custom capabilities to existing capabilities in WordPress®.
		 *
		 * @param string $custom_cap Our own custom capability.
		 *
		 * @param string $context Optional context, which can be useful in some cases.
		 *    A `$context` is particularly helpful when applying filters.
		 *
		 * @return string The WordPress® capability that we mapped to.
		 *    Or a custom capability mapped by a custom filter.
		 */
		public function map($custom_cap, $context = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			switch($custom_cap)
			{
				case 'manage_user_profile_fields':
					$cap = 'edit_users';
					break;

				default: // Requires administrator.
					$cap = 'administrator';
					break;
			}
			return $this->apply_filters($custom_cap, $cap, $context);
		}
	}
}