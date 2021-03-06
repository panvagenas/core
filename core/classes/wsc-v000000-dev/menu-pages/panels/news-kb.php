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
namespace wsc_v000000_dev\menu_pages\panels
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
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's ``$instance``,
		 *    or a new ``$instance`` array.
		 *
		 * @param \wsc_v000000_dev\menu_pages\menu_page
		 *    $menu_page A menu page class instance.
		 */
		public function __construct($instance, $menu_page)
		{
			parent::__construct($instance, $menu_page);

			$this->heading_title = $this->__('Recent News / KB Articles');

			$this->content_body = // Latest news feed (powered by FeedBurner).

				'<p>'. // Brief description.
				'<img src="'.esc_attr($this->©url->to_template_dir_file('/client-side/images/kb-article-64x64.png')).'" class="pull-right l-margin" style="width:64px; height:64px;" alt="" />'.
				sprintf($this->__('The most recent news &amp; knowledge base articles from %1$s'), esc_html($this->instance->plugin_name)).
				'</p>';

			$this->content_body .= '<hr />';

			if(($feed_url = $this->©options->get('menu_pages.panels.news_kb.feed_url')))
				foreach($this->©feed->items($feed_url) as $_item)
					$this->content_body .= // Feed items.
						'<div class="em-b-margin clearfix">'.

						'<p class="text-ellipsis no-b-margin">'.
						'<a href="'.esc_attr($_item['link']).'" title="'.esc_attr($_item['title']).'" target="_blank">'.
						'<i class="fa fa-external-link"></i> '.$this->©string->excerpt($_item['title'], 35).
						'</a>'.
						'</p>'.

						'<p class="opacity-fade font-80 no-b-margin">'.
						$this->©string->excerpt($_item['excerpt'], 185).
						'</p>'.

						'<p class="font-80 pull-left">'.
						'<i class="fa fa-user"></i> <em>'.esc_html($_item['author']).'</em>'.
						'</p>'.

						'<p class="font-80 pull-right">'.
						'<em>'.esc_html($this->©date->i18n('M jS, Y', $_item['time'])).'</em> <i class="fa fa-calendar"></i>'.
						'</p>'.

						'</div>';
			unset($_item); // Housekeeping.

			$this->content_body .= // Additional links.
				'<p class="text-center no-b-margin">'.
				sprintf($this->__('<a class="btn btn-default width-100" href="%1$s" target="_blank">%2$s Knowledge Base <i class="fa fa-external-link"></i></a>'),
				        esc_attr($this->©url->to_plugin_site_uri('/kb-articles/')), esc_html($this->instance->plugin_name)).
				'</p>';
		}
	}
}