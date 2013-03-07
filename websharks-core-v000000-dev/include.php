<?php
/**
 * WebSharks™ Core Framework.
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
		 * Load WebSharks™ Core framework.
		 */
		if(!class_exists('\\'.__NAMESPACE__.'\\framework'))
			include_once dirname(__FILE__).'/classes/websharks-core-v000000-dev/framework.php';
	}