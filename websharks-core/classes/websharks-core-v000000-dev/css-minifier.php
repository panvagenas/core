<?php
/**
 * CSS Minifier.
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
		 * CSS Minifier.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class css_minifier extends framework
		{
			/**
			 * Compresses CSS code (as quickly as possible).
			 *
			 * @param string $css Any CSS code (excluding ``<style></style>`` tags please).
			 *
			 * @return string Compressed CSS code. This removes CSS comments, extra whitespace, and it compresses HEX color codes whenever possible.
			 *    In addition, this will also remove any unnecessary `;` line terminators to further optimize the overall file size.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $css = 'div#hello > input [ type =  "text" ]'."\r\n".' { color :  #FFFFFF; } '."\n";
			 *    ($css) === 'div#hello>input[type="text"]{color:#FFF}'
			 */
			public function compress($css)
				{
					$this->check_arg_types('string', func_get_args());

					if(!isset($this->static[__FUNCTION__]))
						$this->static[__FUNCTION__] = array();
					$static =& $this->static[__FUNCTION__]; // Shorter reference.

					if(!isset($static['replace'], $static['with'], $static['colors']))
						{
							$static['replace'] = array('[', ']', '{', '}', '!=', '|=', '^=', '$=', '*=', '~=', '=', '+', '~', ':', ';', ',', '>');
							$static['replace'] = implode('|', $this->©strings->preg_quote_deep($static['replace'], '/'));

							$static['replace'] = array('comments'        => '/\/\*.*?\*\//s',
							                           'line_breaks'     => "/[\r\n\t]+/",
							                           'extra_spaces'    => '/ +/',
							                           'de_spacifiables' => '/ *('.$static['replace'].') */',
							                           'unnecessary_;s'  => '/;\}/'
							);
							$static['with']    = array('', '', ' ', '$1', '}');
							$static['colors']  = '/(?P<context>\:#| #)(?P<hex>[a-z0-9]{6})/i';
						}
					$css = preg_replace($static['replace'], $static['with'], $css);
					$css = preg_replace_callback($static['colors'], array($this, '_maybe_compress_css_color'), $css);

					return $css; // Compressed now.
				}

			/**
			 * Compresses HEX color codes.
			 *
			 * @param array $m Regular expression matches.
			 *
			 * @return string Full match with compressed HEX color code.
			 *
			 * @throws exception If invalid types are passed through arguments list (disabled).
			 *
			 * @callback-assertion Assertion via ``compress()``.
			 */
			public function _maybe_compress_css_color($m)
				{
					// Commenting this out for performance.
					// This is used as a callback for ``preg_replace()``, so it's NOT absolutely necessary.
					// $this->check_arg_types('array', func_get_args());

					$m['hex'] = strtoupper($m['hex']); // Convert to uppercase for easy comparison.

					if($m['hex'][0] === $m['hex'][1] && $m['hex'][2] === $m['hex'][3] && $m['hex'][4] === $m['hex'][5])
						return $m['context'].$m['hex'][0].$m['hex'][2].$m['hex'][4];

					return $m[0];
				}
		}
	}