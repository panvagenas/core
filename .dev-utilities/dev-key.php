<?php
/**
 * WebSharks™ Dev Key
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 */
namespace wsc_dev_utilities
{
	if(defined('___DEV_KEY_OK'))
		return; // Already OK.

	// Allow command line usage always.

	if(strcasecmp(PHP_SAPI, 'cli') === 0)
		/** @var boolean */
		define('___DEV_KEY_OK', TRUE);

	else // Must have a valid dev key in the request; or via cookies.
	{
		if(!defined('___DEV_KEY') && !empty($_SERVER['___DEV_KEY']))
			/** @var string Valid dev key; via environment variable. */
			define('___DEV_KEY', (string)$_SERVER['___DEV_KEY']);

		else if(!defined('___DEV_KEY'))
			/** @var string Empty dev key. */
			define('___DEV_KEY', '');

		if(___DEV_KEY // Allow anyone authorized with a `___DEV_KEY`.
		   && ((!empty($_REQUEST['___DEV_KEY']) && $_REQUEST['___DEV_KEY'] === ___DEV_KEY)
		       || (!empty($_COOKIE['___DEV_KEY']) && $_COOKIE['___DEV_KEY'] === ___DEV_KEY))
		) // In the case of a `___DEV_KEY` in the request; we convert that a cookie.
		{
			if(!headers_sent()) // Store dev key in a cookie.
				setcookie('___DEV_KEY', ___DEV_KEY, time() + 31556926, '/');
			/** @var boolean */
			define('___DEV_KEY_OK', TRUE);
		}
	}
	if(defined('___DEV_KEY_OK')) return; // Granted access.
	// Else deny access by default. We need to keep things secure.
	throw new \exception('`___DEV_KEY` is missing (access denied).');
}