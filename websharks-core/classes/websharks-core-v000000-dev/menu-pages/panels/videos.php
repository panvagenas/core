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
	class videos extends panel
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

			$this->heading_title = $this->__('Video Tutorials');

			$this->yt_playlist = $this->©options->get('menu_pages.panels.videos.yt_playlist');

			$this->content_body = // Video tutorials (w/ embedded playlist).
				'<p class="text-center no-b-margin">'.
				sprintf($this->__('<a class="btn btn-default width-100" href="%1$s" target="_blank">More Great Video Tutorials <i class="fa fa-external-link"></i></a>'),
				        esc_attr($this->©url->to_plugin_site_uri('/videos/')), esc_html($this->___instance_config->plugin_name)).
				'</p>';
		}
	}
}