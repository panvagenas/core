<?php
/**
 * Currencies.
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
		 * Currencies.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class currencies extends framework
		{
			/**
			 * Currency converter.
			 *
			 * Uses the Google® currency conversion API.
			 *
			 * @param float  $amount The amount, in ``$from`` currency.
			 * @param string $from A 3 character currency code.
			 * @param string $to A 3 character currency code.
			 *
			 * @return float Amount in ``$to``, after having been converted.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$from`` or ``$to`` are empty strings, or NOT 3 characters in length.
			 * @throws exception If currency conversion fails for any reason.
			 *
			 * @see http://www.google.com/finance/converter
			 * @see http://www.techmug.com/ajax-currency-converter-with-google-api/
			 *
			 * @assert (1.00, 'USD', 'CAD') === 1.0
			 * @assert (1.00, 'USD', 'TR') throws exception
			 * @assert (1.00, 'USD', 'EUR') === 0.77
			 */
			public function convert($amount, $from, $to)
				{
					$this->check_arg_types('float', 'string:!empty', 'string:!empty', func_get_args());

					if(strlen($from) !== 3)
						throw $this->©exception(
							$this->method(__FUNCTION__).'#invalid_from_currency', get_defined_vars(),
							$this->i18n('Argument `$from` MUST be 3 characters in length.').
							sprintf($this->i18n(' Got: `%1$s`.'), $from)
						);
					if(strlen($to) !== 3)
						throw $this->©exception(
							$this->method(__FUNCTION__).'#invalid_to_currency', get_defined_vars(),
							$this->i18n('Argument `$to` MUST be 3 characters in length.').
							sprintf($this->i18n(' Got: `%1$s`.'), $to)
						);
					// Attempt to convert the currency via Google's calculator.

					$q       = number_format($amount, 2, '.', '').$from.'=?'.$to;
					$url_api = 'http://www.google.com/ig/calculator?hl=en&q='.urlencode($q);

					if( // Test several conditions for success.

						($json = $this->©url->remote($url_api))

						&& ($json = $this->©string->json_dq_property_names($json))
						&& is_array($json = json_decode($json, TRUE))
						&& empty($json['error']) && !empty($json['icc'])

						&& ($converted_currency_amount = $this->©string->is_not_empty_or($json['rhs'], ''))
						&& ($converted_currency_amount = (float)$converted_currency_amount)
						&& ($converted_currency_amount = (float)$this->format($converted_currency_amount))

					) // It's a good day in Eureka! Currency conversion success.
						return $converted_currency_amount;

					// Throw exception when currency conversion fails.
					$error_msg = $this->i18n('unknown error');
					if(!empty($json['error']) && is_string($json['error']))
						$error_msg = $json['error'];

					throw $this->©exception(
						$this->method(__FUNCTION__).'#currency_conversion_failure', get_defined_vars(),
						sprintf($this->i18n('Currency conversion failed with error: `%1$s`.'), $error_msg).
						sprintf($this->i18n(' JSON response data: `%1$s`'), $this->©var->dump($json))
					);
				}

			/**
			 * Formats floats into amounts with two decimal places.
			 *
			 * @param float   $amount The amount.
			 *
			 * @param string  $currency Optional. Defaults to an empty string.
			 *    By default, this returns the amount only. If a currency code is passed in,
			 *    the amount will be prefixed with a currency symbol,
			 *    and suffixed with the currency code.
			 *
			 * @param boolean $prefix If ``$currency`` is passed in, should we add a prefix?
			 *    This defaults to TRUE, when ``$currency`` is passed in.
			 *    Setting this to FALSE will exclude the prefix.
			 *
			 * @param boolean $suffix If ``$currency`` is passed in, should we add a suffix?
			 *    This defaults to TRUE, when ``$currency`` is passed in.
			 *    Setting this to FALSE will exclude the suffix.
			 *
			 * @return string A numeric string representation, with two decimal places.
			 *    The resulting amount is rounded up, to the nearest penny.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$currency`` is passed with a value that is NOT 3 characters in length.
			 * @throws exception If ``$currency`` is passed with a value that is NOT a currently supported currency.
			 * @throws exception See ``get()`` method for further details.
			 *
			 * @assert (1.0) === '1.00'
			 * @assert (1.014) === '1.01'
			 *
			 * @assert // Rounds up to nearest penny.
			 *    (1.016) === '1.02'
			 *
			 * @assert (1.0, 'USD') === '$1.00 USD'
			 * @assert (1.0, 'USD', TRUE, FALSE) === '$1.00'
			 * @assert (1.0, 'USD', FALSE) === '1.00 USD'
			 * @assert (1.0, 'EUR') === '€1.00 EUR'
			 * @assert (1.0, 'EUR', FALSE) === '1.00 EUR'
			 * @assert (1.0, 'EUR', TRUE, FALSE) === '€1.00'
			 *
			 * @assert (0.0) === '0.00'
			 */
			public function format($amount, $currency = '', $prefix = TRUE, $suffix = TRUE)
				{
					$this->check_arg_types('float', 'string', 'boolean', 'boolean', func_get_args());

					$currencies = $this->get();

					if(($currency = strtoupper($currency)) && strlen($currency) !== 3)
						throw $this->©exception(
							$this->method(__FUNCTION__).'#invalid_currency', get_defined_vars(),
							$this->i18n('Argument `$currency` MUST be 3 characters in length.').
							sprintf($this->i18n(' Instead got: `%1$s`.'), $currency)
						);
					if($currency && !isset($currencies[$currency]))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#unsupported_currency', get_defined_vars(),
							$this->i18n('The `$currency` code is NOT currently supported by this software.').
							sprintf($this->i18n(' Unsupported currency code: `%1$s`.'), $currency)
						);
					$format = number_format($amount, 2, '.', '');
					$format = ($currency && $prefix) ? $this->get($currency, 'symbol').$format : $format;
					$format = ($currency && $suffix) ? $format.' '.strtoupper($currency) : $format;

					return $format;
				}

			/**
			 * Gets supported currency details.
			 *
			 * @param string $currency Optional. Defaults to an empty string.
			 *    By default, an array with all currencies/components will be returned.
			 *    If passed in, this MUST be a valid 3 character currency code to retrieve components for.
			 *
			 * @param string $component Defaults to an empty string.
			 *    By default, an array with all components will be returned.
			 *    If passed in, this MUST be one of: `symbol`, `singular_name`, `plural_name`.
			 *
			 * @return string|array Currency component(s).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$currency`` is passed with a value that is NOT 3 characters in length.
			 * @throws exception If ``$currency`` is passed with a value that is NOT a currently supported currency.
			 * @throws exception If ``$component`` is passed with a value that is NOT one of:
			 *    `symbol`, `singular_name`, `plural_name`.
			 *
			 * @assert // If currency is omitted, returns full array.
			 *    () is-type 'array'
			 *
			 * @assert // If currency is omitted, component is ignored.
			 * // If currency is omitted, returns full array.
			 *    ('', 'symbol') is-type 'array'
			 *
			 * @assert ('USD') === array('symbol' => '$', 'singular_name' => 'U.S. Dollar', 'plural_name' => 'U.S. Dollars')
			 * @assert ('USD', 'singular_name') === 'U.S. Dollar'
			 * @assert ('USD', 'plural_name') === 'U.S. Dollars'
			 * @assert ('USD', 'symbol') === '$'
			 *
			 * @assert ('US') throws exception
			 * @assert ('ZZZ') throws exception
			 * @assert ('USD', 'unknown') throws exception
			 * @assert ('ZZ', 'unknown') throws exception
			 * @assert ('ZZZ', 'symbol') throws exception
			 */
			public function get($currency = '', $component = '')
				{
					$this->check_arg_types('string', 'string', func_get_args());

					if(!isset($this->cache[__FUNCTION__]))
						$this->cache[__FUNCTION__] = array
						(
							'AUD' => array(
								'symbol'        => '$',
								'singular_name' => $this->translate('Australian Dollar'),
								'plural_name'   => $this->translate('Australian Dollars')
							),
							'BRL' => array(
								'symbol'        => 'R$',
								'singular_name' => $this->translate('Brazilian Real'),
								'plural_name'   => $this->translate('Brazilian Reais')
							),
							'CAD' => array(
								'symbol'        => '$',
								'singular_name' => $this->translate('Canadian Dollar'),
								'plural_name'   => $this->translate('Canadian Dollars')
							),
							'CZK' => array(
								'symbol'        => 'Kč',
								'singular_name' => $this->translate('Czech Koruna'),
								'plural_name'   => $this->translate('Czech Koruny')
							),
							'DKK' => array(
								'symbol'        => 'kr',
								'singular_name' => $this->translate('Danish Krone'),
								'plural_name'   => $this->translate('Danish Kroner')
							),
							'EUR' => array(
								'symbol'        => '€',
								'singular_name' => $this->translate('Euro'),
								'plural_name'   => $this->translate('Euros')
							),
							'HKD' => array(
								'symbol'        => '$',
								'singular_name' => $this->translate('Hong Kong Dollar'),
								'plural_name'   => $this->translate('Hong Kong Dollars')
							),
							'HUF' => array(
								'symbol'        => 'Ft',
								'singular_name' => $this->translate('Hungarian Forint'),
								'plural_name'   => $this->translate('Hungarian Forintok')
							),
							'ILS' => array(
								'symbol'        => '₪',
								'singular_name' => $this->translate('Israeli New Sheqel'),
								'plural_name'   => $this->translate('Israeli New Shekalim')
							),
							'JPY' => array(
								'symbol'        => '¥',
								'singular_name' => $this->translate('Japanese Yen'),
								'plural_name'   => $this->translate('Japanese Yen')
							),
							'MYR' => array(
								'symbol'        => 'RM',
								'singular_name' => $this->translate('Malaysian Ringgit'),
								'plural_name'   => $this->translate('Malaysian Ringgit')
							),
							'MXN' => array(
								'symbol'        => '$',
								'singular_name' => $this->translate('Mexican Peso'),
								'plural_name'   => $this->translate('Mexican Pesos')
							),
							'NOK' => array(
								'symbol'        => 'kr',
								'singular_name' => $this->translate('Norwegian Krone'),
								'plural_name'   => $this->translate('Norwegian Kroner')
							),
							'NZD' => array(
								'symbol'        => '$',
								'singular_name' => $this->translate('New Zealand Dollar'),
								'plural_name'   => $this->translate('New Zealand Dollars')
							),
							'PHP' => array(
								'symbol'        => 'Php',
								'singular_name' => $this->translate('Philippine Peso'),
								'plural_name'   => $this->translate('Philippine Pesos')
							),
							'PLN' => array(
								'symbol'        => 'zł',
								'singular_name' => $this->translate('Polish Zloty'),
								'plural_name'   => $this->translate('Polish Zlotys')
							),
							'GBP' => array(
								'symbol'        => '£',
								'singular_name' => $this->translate('Pound Sterling'),
								'plural_name'   => $this->translate('Pounds Sterling')
							),
							'SGD' => array(
								'symbol'        => '$',
								'singular_name' => $this->translate('Singapore Dollar'),
								'plural_name'   => $this->translate('Singapore Dollars')
							),
							'SEK' => array(
								'symbol'        => 'kr',
								'singular_name' => $this->translate('Swedish Krona'),
								'plural_name'   => $this->translate('Swedish Kronor')
							),
							'CHF' => array(
								'symbol'        => 'CHF',
								'singular_name' => $this->translate('Swiss Franc'),
								'plural_name'   => $this->translate('Swiss Francs')
							),
							'TWD' => array(
								'symbol'        => 'NT$',
								'singular_name' => $this->translate('Taiwan New Dollar'),
								'plural_name'   => $this->translate('Taiwan New Dollars')
							),
							'THB' => array(
								'symbol'        => '฿',
								'singular_name' => $this->translate('Thai Baht'),
								'plural_name'   => $this->translate('Thai Bahts')
							),
							'USD' => array(
								'symbol'        => '$',
								'singular_name' => $this->translate('U.S. Dollar'),
								'plural_name'   => $this->translate('U.S. Dollars')
							)
						);
					// Further validate arguments.

					if(($currency = strtoupper($currency)) && strlen($currency) !== 3)
						throw $this->©exception(
							$this->method(__FUNCTION__).'#invalid_currency', get_defined_vars(),
							$this->i18n('Argument `$currency` MUST be 3 characters in length.').
							sprintf($this->i18n(' Instead got: `%1$s`.'), $currency)
						);
					if(($component = strtolower($component)) && !in_array($component, array('symbol', 'singular_name', 'plural_name'), TRUE))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#invalid_component', get_defined_vars(),
							$this->i18n('Argument `$component` MUST be one of: `symbol`, `singular_name`, `plural_name`.').
							sprintf($this->i18n(' Instead got: `%1$s`.'), $component)
						);
					if($currency && !isset($this->cache[__FUNCTION__][$currency]))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#unsupported_currency', get_defined_vars(),
							$this->i18n('The `$currency` code is NOT currently supported by this software.').
							sprintf($this->i18n(' Unsupported currency code: `%1$s`.'), $currency)
						);
					// Everything looks good. Return now.

					if(!$currency)
						return $this->cache[__FUNCTION__];

					if(!$component)
						return $this->cache[__FUNCTION__][$currency];

					if($component === 'symbol')
						return $this->cache[__FUNCTION__][$currency]['symbol'];

					if($component === 'singular_name')
						return $this->cache[__FUNCTION__][$currency]['singular_name'];

					if($component === 'plural_name')
						return $this->cache[__FUNCTION__][$currency]['plural_name'];

					throw $this->©exception(
						$this->method(__FUNCTION__).'#unknown_component', get_defined_vars(),
						sprintf($this->i18n('Unknown currency component: `%1$s`.'), $component)
					);
				}
		}
	}