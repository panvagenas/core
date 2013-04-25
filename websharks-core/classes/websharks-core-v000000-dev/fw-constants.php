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
# -----------------------------------------------------------------------------------------------------------------------------------------
# WebSharks™ Core framework constants (interface used in the WebSharks™ Core framework base class).
# -----------------------------------------------------------------------------------------------------------------------------------------
namespace websharks_core_v000000_dev
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		# -----------------------------------------------------------------------------------------------------------------------------------
		# WebSharks™ Core framework constants (interface definition).
		# -----------------------------------------------------------------------------------------------------------------------------------
		/**
		 * WebSharks™ Core framework constants.
		 *
		 * @package WebSharks\Core
		 * @since   130331
		 */
		interface fw_constants
		{
			# --------------------------------------------------------------------------------------------------------------------------------
			# Multipurpose/misc constants.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string Represents the `core`.
			 */
			const core = '___core';

			/**
			 * @var string Represents `defaults`.
			 */
			const defaults = '___defaults';

			/**
			 * @var string Represents a reconsideration.
			 */
			const reconsider = '___reconsider';

			/**
			 * @var string Represents own components.
			 */
			const own_components = '___own_components';

			/**
			 * @var string Represents a direct call, as opposed to a hook/filter.
			 */
			const direct_call = '___direct_call';

			/**
			 * @var string Represents do `echo` command.
			 */
			const do_echo = '___do_echo';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Return value types.
			# --------------------------------------------------------------------------------------------------------------------------------

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

			# --------------------------------------------------------------------------------------------------------------------------------
			# Conditional logic types.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string Represents `all` logic.
			 */
			const all_logic = '___all_logic';

			/**
			 * @var string Represents `any` logic.
			 */
			const any_logic = '___any_logic';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Logging enabled/disabled flags.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string Represents logging enabled.
			 */
			const log_enable = '___log_enable';

			/**
			 * @var string Represents logging disabled.
			 */
			const log_disable = '___log_disable';

			# --------------------------------------------------------------------------------------------------------------------------------
			# RFC types (standards).
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string Represents conformity with rfc1738.
			 */
			const rfc1738 = '___rfc1738';

			/**
			 * @var string Represents conformity with rfc3986.
			 */
			const rfc3986 = '___rfc3986';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Regex flavors.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string Represents PHP regex flavor.
			 */
			const regex_php = '___regex_php';

			/**
			 * @var string Represents JavaScript regex flavor.
			 */
			const regex_js = '___regex_js';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Context types.
			# --------------------------------------------------------------------------------------------------------------------------------

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

			# --------------------------------------------------------------------------------------------------------------------------------
			# String replacement types.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string Represents ``preg_replace()`` type.
			 */
			const preg_replace_type = '___preg_replace_type';

			/**
			 * @var string Represents ``str_replace()`` type.
			 */
			const str_replace_type = '___str_replace_type';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Permission types.
			# --------------------------------------------------------------------------------------------------------------------------------

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

			# --------------------------------------------------------------------------------------------------------------------------------
			# MIME types.
			# --------------------------------------------------------------------------------------------------------------------------------

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

			# --------------------------------------------------------------------------------------------------------------------------------
			# Filesystem types.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string Represents `file` type.
			 */
			const file_type = '___file_type';

			/**
			 * @var string Represents `dir` type.
			 */
			const dir_type = '___dir_type';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Generalized types.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string Represents `any known` type.
			 */
			const any_known_type = '___any_known_type';

			/**
			 * @var string Represents `any` type.
			 */
			const any_type = '___any_type';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Exclusion types.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string Represents `ignore_globs` array key.
			 */
			const ignore_globs = '___ignore_globs';

			/**
			 * @var string Represents `ignore_extra_globs` array key.
			 */
			const ignore_extra_globs = '___ignore_extra_globs';

			/**
			 * @var string Represents `gitignore` array key.
			 */
			const gitignore = '___gitignore';

			# --------------------------------------------------------------------------------------------------------------------------------
			# Glob bitmask w/ additional WebSharks™ Core options.
			# --------------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var integer Adds a slash to each directory returned.
			 */
			const glob_mark = 1;

			/**
			 * @var integer Returns files as they appear in the directory (no sorting).
			 */
			const glob_nosort = 2;

			/**
			 * @var integer Return the search pattern if no files matching it were found.
			 */
			const glob_nocheck = 4;

			/**
			 * @var integer Backslashes do not quote metacharacters.
			 */
			const glob_noescape = 8;

			/**
			 * @var integer Expands `{a,b,c}` to match `'a'`, `'b'`, or `'c'`.
			 */
			const glob_brace = 16;

			/**
			 * @var integer Return only directory entries which match the pattern.
			 */
			const glob_onlydir = 32;

			/**
			 * @var integer Stop on read errors.
			 */
			const glob_err = 64;

			/**
			 * @var integer Use `[aA][bB]` to test caSe variations.
			 */
			const glob_casefold = 128;

			/**
			 * @var integer Find hidden dot `.` files using wildcards.
			 */
			const glob_period = 256;
		}
	}
