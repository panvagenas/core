<?php
/**
 * HTML Minifier.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120329
 */
namespace websharks_core_v000000_dev
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		/**
		 * HTML Minifier.
		 *
		 * @package WebSharks\Core
		 * @since 120329
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class html_minifier extends framework
		{
			/**
			 * Compresses HTML markup (as quickly as possible).
			 *
			 * @param string $html Any HTML markup (no empty strings please).
			 *
			 * @return string Compressed HTML markup. With all comments and extra whitespace removed as quickly as possible.
			 *    This preserves portions of HTML that depend on whitespace. Like `pre/code/script/style/textarea` tags.
			 *    It also preserves conditional comments and JavaScript `on(click|blur|etc)` attributes.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $html = '<html>'."\n".'<head><base href="" /></head><body><pre>pre'."\n".'text</pre></body></html>'."\n";
			 *    ($html) === '<html> <head><base href=""/></head><body><pre>pre'."\n".'text</pre></body></html>'
			 */
			public function compress($html)
				{
					$this->check_arg_types('string', func_get_args());

					if(!isset($this->static['preservations'], $this->static['compressions'], $this->static['compress_with']))
						{
							$this->static['preservations'] = array(
								'special_tags'            => '\<(pre|code|script|style|textarea)[\s\>].*?\<\/\\2>',
								'ie_conditional_comments' => '\<\!--\[if\s*[^\]]*\]\>.*?\<\!\[endif\]--\>',
								'special_attributes'      => '\s(?:style|on[a-z]+)\s*\=\s*(["\']).*?\\3'
							);
							$this->static['preservations'] = // Implode for regex capture.
								'/(?P<preservation>'.implode('|', $this->static['preservations']).')/is';

							$this->static['compressions']['remove_html_comments']  = '/\<\!--.*?--\>/s';
							$this->static['compress_with']['remove_html_comments'] = '';

							$this->static['compressions']['remove_extra_whitespace']  = '/\s+/';
							$this->static['compress_with']['remove_extra_whitespace'] = ' ';

							$this->static['compressions']['remove_extra_whitespace_in_self_closing_tags']  = '/\s+\/\>/';
							$this->static['compress_with']['remove_extra_whitespace_in_self_closing_tags'] = '/>';
						}

					// Check if the HTML markup contains what we consider ``$preservations``.
					if(preg_match_all($this->static['preservations'], $html, $_preservation_matches, PREG_SET_ORDER))
						{
							foreach($_preservation_matches as $_preservation_match_key => $_preservation_match)
								{
									$_preservations[]             = $_preservation_match['preservation'];
									$_preservation_placeholders[] = '%%ws-html-minifier-'.$_preservation_match_key.'%%';
								}
							// Commenting this out for performance. It's not absolutely necessary.
							// unset($_preservation_matches, $_preservation_match_key, $_preservation_match);

							if(isset($_preservations, $_preservation_placeholders)) // We have preservations?
								$html = $this->©strings->replace_once($_preservations, $_preservation_placeholders, $html);
						}
					// Now let's compress the HTML markup (as best we can).
					$html = preg_replace($this->static['compressions'], $this->static['compress_with'], $html);

					// If we DID find ``$preservations``, we'll need to restore them now.
					if(isset($_preservations, $_preservation_placeholders)) // Restore preservations?
						$html = $this->©strings->replace_once($_preservation_placeholders, $_preservations, $html);

					// Commenting this out for performance. It's not absolutely necessary.
					// unset($_preservations, $_preservation_placeholders);

					return trim($html); // Compressed HTML markup.
				}
		}
	}