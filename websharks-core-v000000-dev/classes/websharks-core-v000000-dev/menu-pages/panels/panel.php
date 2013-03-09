<?php
/**
 * Menu Page Panel (Base Class).
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace websharks_core_v000000_dev\menu_pages\panels
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page Panel (Base Class).
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class panel extends \websharks_core_v000000_dev\framework
	{
		/**
		 * @var string Slug for this panel.
		 *
		 * @by-constructor Set dynamically by the class constructor.
		 *    This is always set to the base name of the class.
		 */
		public $slug = '';

		/**
		 * @var string Heading/title for this panel.
		 *
		 * @extenders Should be overridden by class extenders.
		 */
		public $heading_title = '';

		/**
		 * @var string Content/body for this panel.
		 *
		 * @extenders Should be overridden by class extenders.
		 */
		public $content_body = '';

		/**
		 * @var string Additional documentation for this panel.
		 *
		 * @extenders Can be overridden by class extenders.
		 */
		public $documentation = '';

		/**
		 * @var string YouTube® playlist ID for this panel.
		 *
		 * @extenders Can be overridden by class extenders.
		 */
		public $yt_playlist = '';

		/**
		 * @var \websharks_core_v000000_dev\menu_pages\menu_page
		 *    A menu page class instance.
		 *
		 * @by-constructor Set during class construction.
		 */
		public $menu_page; // Defaults to a NULL value.

		/**
		 * Constructor.
		 *
		 * @param object|array $___instance_config Required at all times.
		 *    A parent object instance, which contains the parent's ``$___instance_config``,
		 *    or a new ``$___instance_config`` array.
		 *
		 * @param \websharks_core_v000000_dev\menu_pages\menu_page
		 *    $menu_page A menu page class instance.
		 *
		 * @throws \websharks_core_v000000_dev\exception If invalid types are passed through arguments list.
		 */
		public function __construct($___instance_config, $menu_page)
		{
			parent::__construct($___instance_config);

			$this->check_arg_types('', $this->___instance_config->core_ns_prefix.'\\menu_pages\\menu_page', func_get_args());

			$this->slug      = $this->___instance_config->ns_class_basename;
			$this->menu_page = $menu_page;
		}
	}
}