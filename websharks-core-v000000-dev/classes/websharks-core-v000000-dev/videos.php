<?php
/**
 * Videos.
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
	 * Videos.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class videos extends framework
	{
		/**
		 * Builds a URL to a YouTube® video.
		 *
		 * @param string $video The video ID.
		 * @param array  $args Optional array of arguments that may choose to override our defaults.
		 *
		 * @return string URL to a YouTube® video.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function yt_url($video, $args = array())
		{
			$this->check_arg_types('string:!empty', 'array', func_get_args());

			$url      = $this->©url->current_scheme().'://www.youtube.com/v/'.urlencode($video);
			$defaults = array(
				'version'        => 2,
				'hd'             => 1,
				'fs'             => 1,
				'rel'            => 0,
				'autoplay'       => 0,
				'start'          => 0,
				'showinfo'       => 0,
				'modestbranding' => 1,
				'hl'             => 'en_US',
				'theme'          => 'light'
			);
			$args     = array_merge($defaults, $args);
			$args     = $this->©string->ify_deep($args);

			return add_query_arg(urlencode_deep($args), $url);
		}

		/**
		 * Builds an embed tag for a YouTube® video.
		 *
		 * @param string  $video The video ID.
		 * @param array   $args Optional array of arguments that may choose to override our defaults.
		 * @param array   $classes Optional array of CSS classes for the embed tag.
		 * @param string  $attrs Optional string of additional attributes for the embed tag.
		 *
		 * @return string Embed tag for a YouTube® video.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function yt_embed_tag($video, $args = array(), $classes = array(), $attrs = '')
		{
			$this->check_arg_types('string:!empty', 'array', 'array', 'string', func_get_args());

			$defaults = array(
				'width'  => '98%',
				'height' => '98%'
			);
			$args     = array_merge($defaults, $args);
			$args     = $this->©string->ify_deep($args);

			return '<embed type="application/x-shockwave-flash"'.

			       ' src="'.esc_attr($this->yt_url($video, $args)).'"'.
			       ' wmode="transparent" allowscriptaccess="always" allowfullscreen="true"'.

			       (($classes) ? ' class="'.esc_attr(implode(' ', $classes)).'"' : '').

			       ' style="width:'.esc_attr($args['width']).'; height:'.esc_attr($args['height']).';'.
			       ' padding:1%; background:#CCCCCC; border-radius:3px;"'.

			       (($attrs) ? ' '.$attrs : '').
			       ' />';
		}

		/**
		 * Builds a URL to a YouTube® video playlist.
		 *
		 * @param string $playlist The playlist ID.
		 * @param array  $args Optional array of arguments that may choose to override our defaults.
		 *
		 * @return string URL to a YouTube® video playlist.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function yt_playlist_url($playlist, $args = array())
		{
			$this->check_arg_types('string:!empty', 'array', func_get_args());

			$url      = $this->©url->current_scheme().'://www.youtube.com/p/'.urlencode($playlist);
			$defaults = array(
				'version'        => 2,
				'hd'             => 1,
				'fs'             => 1,
				'rel'            => 0,
				'autoplay'       => 0,
				'start'          => 0,
				'showinfo'       => 0,
				'modestbranding' => 1,
				'hl'             => 'en_US',
				'theme'          => 'light'
			);
			$args     = array_merge($defaults, $args);
			$args     = $this->©string->ify_deep($args);

			return add_query_arg(urlencode_deep($args), $url);
		}

		/**
		 * Builds an embed tag for a YouTube® video playlist.
		 *
		 * @param string $playlist The playlist ID.
		 * @param array  $args Optional array of arguments that may choose to override our defaults.
		 * @param array  $classes Optional array of CSS classes for the embed tag.
		 * @param string $attrs Optional string of additional attributes for the embed tag.
		 *
		 * @return string Embed tag for a YouTube® video playlist.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function yt_playlist_embed_tag($playlist, $args = array(), $classes = array(), $attrs = '')
		{
			$this->check_arg_types('string:!empty', 'array', 'array', 'string', func_get_args());

			$defaults = array(
				'width'  => '98%',
				'height' => '98%'
			);
			$args     = array_merge($defaults, $args);
			$args     = $this->©string->ify_deep($args);

			return '<embed type="application/x-shockwave-flash"'.

			       ' src="'.esc_attr($this->yt_playlist_url($playlist, $args)).'"'.
			       ' wmode="transparent" allowscriptaccess="always" allowfullscreen="true"'.

			       (($classes) ? ' class="'.esc_attr(implode(' ', $classes)).'"' : '').

			       ' style="width:'.esc_attr($args['width']).'; height:'.esc_attr($args['height']).';'.
			       ' padding:1%; background:#CCCCCC; border-radius:3px;"'.

			       (($attrs) ? ' '.$attrs : '').
			       ' />';
		}
	}
}