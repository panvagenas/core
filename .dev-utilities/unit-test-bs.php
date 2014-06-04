<?php
/**
 * Unit Test Bootstrap.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 */
namespace websharks_core_dev_utilities
{
	/**
	 * @var boolean Marker.
	 */
	define('___UNIT_TEST', TRUE);

	/*
	 * Check Dev Key for authorization.
	 */
	require_once dirname(__FILE__).'/dev-key.php';

	/*
	 * Define all WordPress® globals.
	 */
	require_once dirname(__FILE__).'/wp-globals.php';

	/*
	 * Load WebSharks™ Core w/ WordPress®.
	 */
	require_once dirname(__FILE__).'/core.php';

	/*
	 * Load plugin file (if applicable).
	 */
	require_once dirname(__FILE__).'/plugin.php';
}