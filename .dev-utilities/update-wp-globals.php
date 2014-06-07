<?php
/**
 * Updates WordPress Globals
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 */
namespace websharks_core_dev_utilities
{
	/*
	 * Check Dev Key for authorization.
	 */
	require_once dirname(__FILE__).'/dev-key.php';

	/*
	 * Load WebSharks™ Core w/ WordPress®.
	 */
	require_once dirname(__FILE__).'/core.php';

	/*
	 * Pre for CLI development procedure.
	 */
	core()->©env->prep_for_cli_dev_procedure();

	/*
	 * Shutdown action hook to grab `$GLOBALS`.
	 */
	add_action('shutdown', function ()
	{
		$core           = core();
		$core_class     = get_class($core);
		$wp_global_keys = array(); // Initialize.

		foreach($GLOBALS as $_key => $_value)
		{
			if(in_array($_key, array('GLOBALS', '_GET', '_POST', '_REQUEST', '_COOKIE', '_FILES', '_SERVER', '_ENV', 'argv', 'argc', 'php_errormsg'), TRUE))
				continue; // Exclude all of these built-in globals in PHP.

			if($_value instanceof $core_class) continue; // Exclude global instances of the core.
			if(preg_match('/[^a-z0-9_]/i', $_key)) continue; // Exclude invalid `global $keys`.

			$wp_global_keys[] = $_key;
		}
		sort($wp_global_keys, SORT_STRING);

		$wp_globals = '<?php'."\n";
		foreach($wp_global_keys as $_key)
			$wp_globals .= 'global $'.$_key.';'."\n";
		unset($_key, $_value);

		file_put_contents(dirname(__FILE__).'/wp-globals.php', $wp_globals);
		echo trim($wp_globals); // Output when complete.

	}, PHP_INT_MAX); // Latest possible priority.
}