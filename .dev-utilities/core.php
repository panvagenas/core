<?php
/**
 * WebSharks™ Core Loader
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 */
namespace wsc_dev_utilities
{
	/**
	 * @var boolean Marker.
	 */
	define('___CORE', TRUE);

	/*
	 * Check Dev Key for authorization.
	 */
	require_once dirname(__FILE__).'/dev-key.php';

	/*
	 * Load the WebSharks™ Core w/ WordPress®.
	 */
	require_once dirname(dirname(__FILE__)).'/core/stub.php';

	/**
	 * WebSharks™ Core framework instance.
	 *
	 * @param string $version A specific version of the WebSharks™ Core?
	 *    WARNING: This function will NOT automatically load a specific version for you.
	 *       The version that you specify MUST already be loaded up.
	 *
	 * @return \wsc__framework WebSharks™ Core framework instance.
	 */
	function core($version = '')
	{
		static $stub_file;
		if(!isset($stub_file))
		{
			${'/'}     = DIRECTORY_SEPARATOR;
			$stub_file = dirname(dirname(__FILE__)).
			             ${'/'}.'core'.${'/'}.'stub.php';
		}
		if(!$version) return $GLOBALS[$GLOBALS[$stub_file]['core_ns']];

		return $GLOBALS[\wsc__stub::$core_ns_stub_v.\wsc__stub::with_underscores((string)$version)];
	}
}