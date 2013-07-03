<?php
/**
 * No-Cache Utilities.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace websharks_core_v000000_dev
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		/**
		 * No-Cache Utilities.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class no_cache extends framework
		{
			/**
			 * Handles no-cache headers/constants.
			 *
			 * @attaches-to WordPress® `init` action hook.
			 * @hook-priority `-1` Before most everything else.
			 *
			 * @assertion-via WordPress®.
			 */
			public function init()
				{
					if(is_admin() // No-cache all administrative areas.
					   || $this->©env->is_systematic_routine()
					   || $this->©user->is_logged_in()
					   || $this->©action->is()
					) // No cache in these cases.
						{
							$this->headers(); // Prevents browser caching.
							$this->constants(); // Stops caching plugins.
						}
					else if($this->©options->get('no_cache.headers.always'))
						$this->headers(); // Prevents browser caching.
				}

			/**
			 * Sends no-cache headers.
			 */
			public function headers()
				{
					if(isset($this->static[__FUNCTION__]) || $this->©vars->_REQUEST('qcABC'))
						return; // Already sent; or we're respecting Quick Cache.

					$this->©headers->no_cache();

					$this->static[__FUNCTION__] = TRUE;
				}

			/**
			 * Sets no-cache constants.
			 */
			public function constants()
				{
					if(isset($this->static[__FUNCTION__]) || $this->©vars->_REQUEST('qcAC'))
						return; // Already defined; or we're respecting Quick Cache.

					if(!defined('DONOTCACHEDB'))
						/**
						 * @var boolean For cache plugins.
						 */
						define ('DONOTCACHEDB', TRUE);

					if(!defined('DONOTCACHEPAGE'))
						/**
						 * @var boolean For cache plugins.
						 */
						define ('DONOTCACHEPAGE', TRUE);

					if(!defined('DONOTCACHEOBJECT'))
						/**
						 * @var boolean For cache plugins.
						 */
						define ('DONOTCACHEOBJECT', TRUE);

					if(!defined('QUICK_CACHE_ALLOWED'))
						/**
						 * @var boolean For Quick Cache.
						 */
						define ('QUICK_CACHE_ALLOWED', FALSE);

					$this->static[__FUNCTION__] = TRUE;
				}
		}
	}