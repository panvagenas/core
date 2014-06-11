<?php
/**
 * Plugin Loader
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
	define('___PLUGIN', TRUE);

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
	${__FILE__}['plugin_dir'] = core()->©vars->_SERVER('___PLUGIN_DIR');
	if(core()->©string->is_not_empty(${__FILE__}['plugin_dir']))
	{
		if(!is_file(${__FILE__}['plugin_dir'].'/plugin.php'))
			throw core()->©exception(
				'plugin_load_failure', get_defined_vars(),
				sprintf(core()->__('Failed to load: `%1$s`.'), ${__FILE__}['plugin_dir'].'/plugin.php')
			);
		require_once ${__FILE__}['plugin_dir'].'/plugin.php';
	}
}