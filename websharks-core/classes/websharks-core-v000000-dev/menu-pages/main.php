<?php
/**
 * Menu Page.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 140523
 */
namespace websharks_core_v000000_dev\menu_pages
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page.
	 *
	 * @package WebSharks\Core
	 * @since 140523
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class main extends menu_page
	{
		/**
		 * Constructor.
		 *
		 * @param object|array $___instance_config Required at all times.
		 *    A parent object instance, which contains the parent's ``$___instance_config``,
		 *    or a new ``$___instance_config`` array.
		 */
		public function __construct($___instance_config)
		{
			parent::__construct($___instance_config);

			$this->heading_title           = $this->__('Quick-Start Guide');
			$this->sub_heading_description = $this->__('Just a quick overview w/ a few instructions.');
		}

		/**
		 * Displays HTML markup producing content panels for this menu page.
		 */
		public function display_content_panels()
		{
			$this->add_content_panel($this->©menu_pages__panels__quick_start($this), TRUE);

			parent::display_content_panels();
		}
	}
}