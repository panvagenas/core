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
	class community_forum extends panel
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

			$this->heading_title = $this->__('Community Forum');

			$form_fields = $this->©form_fields(); // Object instance.

			$this->content_body = // Community forum feed (powered by Feedburner).

				'<div>'.
				'<img src="'.esc_attr($this->©url->to_template_dir_file('/client-side/images/discussion-64x64.png')).'" style="width:64px; height:64px; float:right; margin:0 0 0 10px;" alt="" />'.
				$this->__('<p style="margin-top:0;">These are the latest community forum topics.</p>').
				'</div>';

			$this->content_body .= '<hr />';
			$this->content_body .= '<div class="feed">';
			if(($feed_url = $this->©options->get('menu_pages.panels.community_forum.feed_url')))
				foreach($this->©feed->items($feed_url) as $_item)
					$this->content_body .= // Feed items.
						'<div class="feed-item">'.

						'<div class="feed-item-title">'.
						'<a href="'.esc_attr($_item['link']).'" title="'.esc_attr($_item['title']).'" target="_blank" rel="xlink">'.
						$this->©string->excerpt($_item['title'], 35).
						'</a>'.
						'</div>'.

						'<div class="feed-item-excerpt">'.
						$this->©string->excerpt($_item['excerpt'], 185).
						'</div>'.

						'<div class="feed-item-date">'.
						$this->©date->i18n('M jS, Y', $_item['time']).
						'</div>'.

						'</div>';
			unset($_item); // Housekeeping.
			$this->content_body .= '</div>';

			$this->content_body .= // Additional links.
				'<hr />'.

				'<div style="text-align:center;">'.
				sprintf($this->__(
					'<p style="margin:0;"><a href="%1$s" target="_blank" rel="xlink">All Community Forum Topics</a></p>'
				), esc_attr($this->©url->to_plugin_site_uri('/community/'))).
				'</div>';
		}
	}
}