<?php
/**
 * WebSharks™ Core Debugger
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
	define('___XDEBUG', TRUE);

	/*
	 * Check Dev Key for authorization.
	 */
	require_once dirname(__FILE__).'/dev-key.php';

	/*
	 * Load WebSharks™ Core w/ WordPress®.
	 */
	require_once dirname(__FILE__).'/core.php';

	/*
	 * Load plugin file (if applicable).
	 */
	require_once dirname(__FILE__).'/plugin.php';

	/*
	 * Enable all error reporting.
	 */
	core()->©env->enable_all_error_reporting();

	/*
	 * Define some important working variables.
	 */
	${__FILE__}['argv']      = core()->©var->_SERVER('argv');
	${__FILE__}['___xdebug'] = core()->©var->_GET('___xdebug');

	/*
	 * Debug file via command line?
	 */
	if(core()->©env()->is_cli() && is_array(${__FILE__}['argv']) && core()->©string->is_not_empty(${__FILE__}['argv'][1]))
		if(strpos(${__FILE__}['argv'][1], '..') === FALSE && is_file(dirname(__FILE__).'/xdebug-tests/'.${__FILE__}['argv'][1]))
			return require_once dirname(__FILE__).'/xdebug-tests/'.${__FILE__}['argv'][1];

	/*
	 * Debug file via `$_GET` request?
	 */
	if(core()->©string->is_not_empty(${__FILE__}['___xdebug']))
		if(strpos(${__FILE__}['___xdebug'], '..') === FALSE && is_file(dirname(__FILE__).'/xdebug-tests/'.${__FILE__}['___xdebug']))
			return require_once dirname(__FILE__).'/xdebug-tests/'.${__FILE__}['___xdebug'];

	/*
	 * Else throw exception (nothing to debug).
	 */
	throw core()->©exception(
		'xdebug_failure', get_defined_vars(),
		core()->__('Nothing to debug. Please check `___xdebug` argument value.')
	);
}