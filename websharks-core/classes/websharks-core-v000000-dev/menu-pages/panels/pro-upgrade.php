<?php
/**
 * Menu Page Panel.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 140523
 */
namespace websharks_core_v000000_dev\menu_pages\panels
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page Panel.
	 *
	 * @package WebSharks\Core
	 * @since 140523
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class pro_upgrade extends panel
	{
		/**
		 * Constructor.
		 *
		 * @param object|array $___instance_config Required at all times.
		 *    A parent object instance, which contains the parent's ``$___instance_config``,
		 *    or a new ``$___instance_config`` array.
		 *
		 * @param \websharks_core_v000000_dev\menu_pages\menu_page
		 *    $menu_page A menu page class instance.
		 */
		public function __construct($___instance_config, $menu_page)
		{
			parent::__construct($___instance_config, $menu_page);

			$this->heading_title = $this->__('Pro Upgrade');

			$this->content_body = // Pro upgrade.

				'<div style="text-align:center;">'.
				sprintf($this->__('<p style="margin:0;">%1$s Pro is a recommended upgrade. <a href="%2$s" target="_blank" rel="xlink">Click here</a> to learn more.</p>'),
				        esc_html($this->___instance_config->plugin_name), esc_attr($this->©url->to_plugin_site_uri('/pro/'))).
				'</div>'.

				'<div style="text-align:center; margin-top:5px;">'.
				'<p style="margin:0;"><a href="'.esc_attr($this->©url->to_plugin_site_uri('/pro/')).'" target="_blank"><img src="'.esc_attr($this->©url->to_template_dir_file('/client-side/images/pro-upgrade-160x80.png')).'" style="width:160px; height:80px;" alt="" /></a></p>'.
				'</div>';
		}
	}
}