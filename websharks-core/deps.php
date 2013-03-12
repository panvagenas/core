<?php
/**
 * Dependency Utilities.
 *
 * @note MUST remain PHP v5.2 compatible.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since   130302
 */
if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

/**
 * Load WebSharks™ Core dependency utilities.
 */
if(!class_exists('deps_websharks_core_v000000_dev'))
	include_once dirname(__FILE__).'/classes/websharks-core-v000000-dev/deps.php';