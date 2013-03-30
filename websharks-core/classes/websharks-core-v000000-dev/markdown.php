<?php
/**
 * Markdown Parser.
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
		 * Markdown Parser.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class markdown extends framework
		{
			/**
			 * Markdown parser object instance (a singleton).
			 *
			 * @var \ws_markdown|null Set automatically by ``parse()`` method.
			 */
			public static $parser;

			/**
			 * Parses PHP Markdown syntax.
			 *
			 * @param string $string Markdown syntax string (no empty strings please).
			 *
			 * @return string String after having been parsed as PHP Markdown.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('hello `code`') === '<p>hello <code>code</code></p>'
			 * @assert ('hello *italic*') === '<p>hello <em>italic</em></p>'
			 */
			public function parse($string)
				{
					$this->check_arg_types('string', func_get_args());

					if(!isset(static::$parser))
						static::$parser = new \ws_markdown();

					return static::$parser->transform($string);
				}
		}
	}