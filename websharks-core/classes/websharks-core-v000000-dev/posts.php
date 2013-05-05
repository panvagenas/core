<?php
/**
 * Posts.
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
		 * Posts.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class posts extends framework
		{
			/**
			 * Gets a WordPress® post by path; instead of by ID.
			 *
			 * @note This does NOT work with paginated paths (ex: `/sample-page/2/` will fail).
			 *
			 * @param string $path A URL path (ex: `/sample-page/`, `/sample-page`, `sample-page`).
			 *    This also works with sub-pages (ex: `/parent-page/sub-page/`).
			 *    Also with post type prefixes (ex: `/post/hello-world/`).
			 *
			 * @param array  $exclude_types Optional. Defaults to ``array('revision', 'nav_menu_item')``.
			 *    We will NOT search for these post types. Pass an empty array to search all post types.
			 *    Important to note... it is NOT possible to exclude the `attachment` type;
			 *    because {@link \get_page_by_path()} always searches this type.
			 *
			 * @return null|\WP_Post A WP_Post object instance if found; else NULL.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @see http://codex.wordpress.org/Function_Reference/get_page_by_path
			 */
			public function by_path($path, $exclude_types = array('revision', 'nav_menu_item'))
				{
					$this->check_arg_types('string', 'array', func_get_args());

					$path = trim($path, '/'); // Trim slashes.

					if($path && $path !== '/') foreach(get_post_types() as $_type)
						if(!in_array($_type, $exclude_types, TRUE))
							if(($_path = str_replace($_type.'/', '', $path)))
								if(($post = get_page_by_path($_path, OBJECT, $_type)))
									return $post;
					unset($_type); // Housekeeping.

					return NULL; // Default return value.
				}
		}
	}