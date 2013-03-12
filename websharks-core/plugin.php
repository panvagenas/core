<?php
/**
 * WebSharks™ Core (WP plugin).
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 130310
 */
/* -- WordPress® ------------------------------------------------------------------------

Version: 130310
Stable tag: 130310
Tested up to: 3.6-alpha
Requires at least: 3.5.1

Requires at least PHP version: 5.3.1
Tested up to PHP version: 5.4.12

Copyright: © 2012 WebSharks, Inc.
License: GNU General Public License
Contributors: WebSharks

Author: WebSharks, Inc.
Author URI: http://www.websharks-inc.com

Text Domain: websharks-core
Domain Path: /translations

Plugin Name: WebSharks™ Core
Plugin URI: http://github.com/WebSharks/Core

Description: WebSharks™ Core framework for WordPress® plugin development.
Tags: websharks, websharks core, framework, plugin framework, development, developers

-- end section for WordPress®. ------------------------------------------------------- */

if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

/**
 * Load dependency utilities.
 */
include_once dirname(__FILE__).'/deps.php';

/**
 * Check dependencies (and load/include plugin; if possible).
 */
if(deps_websharks_core_v000000_dev::check('WebSharks™ Core', 'websharks-core') === TRUE)
	include_once dirname(__FILE__).'/include.php';