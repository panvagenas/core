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
	class news_kb extends panel
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

			$this->heading_title = $this->__('Latest News / KB Articles');

			$this->content_body = // Latest news feed (powered by FeedBurner).

				'<div>'.
				'<img src="'.esc_attr($this->©url->to_template_dir_file('/client-side/images/kb-article-60x60.png')).'" style="width:60px; height:60px; background:#FFFFFF; border:2px solid #EEEEEE; border-radius:5px; float:right; margin:0 0 0 10px;" alt="" />'.
				sprintf($this->__(
					'<p style="margin-top:0;">These are the latest news &amp; knowledge base articles from %1$s</p>'.
					'<p class="clear" style="margin-bottom:0;"><strong>See also:</strong> <a href="%2$s" target="_blank" rel="xlink">%1$s FAQs</a></p>'
				), esc_html($this->___instance_config->plugin_name), esc_attr($this->©url->to_plugin_site_uri('/faqs/'))).
				'</div>';

			$this->content_body .= '<hr />';
			$this->content_body .= '<div class="feed">';
			if(($feed_url = $this->©options->get('menu_pages.panels.news_kb.feed_url')))
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
					'<p style="margin:0;"><a href="%1$s" target="_blank" rel="xlink">%1$s Knowledge Base</a></p>'
				), esc_html($this->___instance_config->plugin_name), esc_attr($this->©url->to_plugin_site_uri('/kb-articles/'))).
				'</div>';
		}
	}
}