<?php
/**
 * XML Utilities.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace wsc_v000000_dev
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * XML Utilities.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class xml extends framework
	{
		/**
		 * Gets an XML attribute value.
		 *
		 * @param \SimpleXMLElement $xml A SimpleXMLElement object instance.
		 * @param string            $attribute The name of the attribute we're looking for.
		 *
		 * @return string The value of the attribute, else an empty string on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function attribute($xml, $attribute)
		{
			$this->check_arg_types('\\SimpleXMLElement', 'string:!empty', func_get_args());

			foreach($xml->attributes() as $_attribute => $_value)
				if(strcasecmp($_attribute, $attribute) === 0)
					return (string)$_value;
			unset($_attribute, $_value);

			return '';
		}
	}
}