#!/usr/bin/env php
<?php
/**
 * WebSharks™ Core Scripts (Compiler)
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace websharks_core_dev_utilities
{
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/.dev-utilities/core.php';
	core()->©env->prep_for_cli_dev_procedure();
	compile_all(); // Run compiler.

	/*
	 * Compile All
	 */
	function compile_all()
	{
		$core = core(); // WebSharks™ Core.

		ob_start(); // Begin JavaScript compilation.
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-sprintf.min.js')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-jq-scrollto.min.js')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-bs.min.js')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core.min.js')."\n";
		file_put_contents(dirname(__FILE__).'/core-libs.min.js', trim(ob_get_clean()));
	}
}