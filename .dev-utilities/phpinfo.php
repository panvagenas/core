<?php
/**
 * PHP Info Checker
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
	define('___PHPINFO', TRUE);

	/*
	 * Check Dev Key for authorization.
	 */
	require_once dirname(__FILE__).'/dev-key.php';

	/*
	 * Output PHP info/details.
	 */
	return phpinfo();
}