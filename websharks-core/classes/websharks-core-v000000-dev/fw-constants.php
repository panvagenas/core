<?php
/**
 * WebSharks™ Core framework constants.
 *
 * Copyright: © 2013 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 130331
 */
namespace websharks_core_v000000_dev
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		/**
		 * WebSharks™ Core framework constants.
		 *
		 * @package WebSharks\Core
		 * @since   130331
		 */
		interface fw_constants
		{
			/**
			 * @var string Represents the `core`.
			 */
			const core = '___core';

			/**
			 * @var string Represents `object` properties.
			 */
			const object_p = '___object_p';

			/**
			 * @var string Represents associative `array`.
			 */
			const array_a = '___array_a';

			/**
			 * @var string Represents numeric `array`.
			 */
			const array_n = '___array_n';

			/**
			 * @var string Represents space-separated `string`.
			 */
			const space_sep_string = '___space_sep_string';

			/**
			 * @var string Represents `all` logic.
			 */
			const all_logic = '___all_logic';

			/**
			 * @var string Represents `any` logic.
			 */
			const any_logic = '___any_logic';

			/**
			 * @var string Represents a reconsideration.
			 */
			const reconsider = '___reconsider';

			/**
			 * @var string Represents logging enabled.
			 */
			const log_enable = '___log_enable';

			/**
			 * @var string Represents logging disabled.
			 */
			const log_disable = '___log_disable';

			/**
			 * @var string Represents a `public` type.
			 */
			const public_type = '___public_type';

			/**
			 * @var string Represents a `protected` type.
			 */
			const protected_type = '___protected_type';

			/**
			 * @var string Represents a `private` type.
			 */
			const private_type = '___private_type';

			/**
			 * @var string Represents conformity with rfc1738.
			 */
			const rfc1738 = '___rfc1738';

			/**
			 * @var string Represents conformity with rfc3986.
			 */
			const rfc3986 = '___rfc3986';

			/**
			 * @var string Represents own components.
			 */
			const own_components = '___own_components';

			/**
			 * @var string Represents do `echo` command.
			 */
			const do_echo = '___do_echo';

			/**
			 * @var string Represents a direct call, as opposed to a hook/filter.
			 */
			const direct_call = '___direct_call';

			/**
			 * @var string Represents ``preg_replace()`` type.
			 */
			const preg_replace_type = '___preg_replace_type';

			/**
			 * @var string Represents ``str_replace()`` type.
			 */
			const str_replace_type = '___str_replace_type';

			/**
			 * @var string Represents PHP regex flavor.
			 */
			const regex_php = '___regex_php';

			/**
			 * @var string Represents JavaScript regex flavor.
			 */
			const regex_js = '___regex_js';

			/**
			 * @var string Represents `profile_updates` context.
			 */
			const context_registration = '___context_registration';

			/**
			 * @var string Represents `profile_updates` context.
			 */
			const context_profile_updates = '___context_profile_updates';

			/**
			 * @var string Represents `profile_updates` context.
			 */
			const context_profile_views = '___context_profile_views';

			/**
			 * @var string Represents `textual` type.
			 */
			const textual_type = '___textual_type';

			/**
			 * @var string Represents `compressable` type.
			 */
			const compressable_type = '___compressable_type';

			/**
			 * @var string Represents `cacheable` type.
			 */
			const cacheable_type = '___cacheable_type';

			/**
			 * @var string Represents `binary` type.
			 */
			const binary_type = '___binary_type';

			/**
			 * @var string Represents `any` type.
			 */
			const any_type = '___any_type';
		}
	}
