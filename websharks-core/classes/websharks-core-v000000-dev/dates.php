<?php
/**
 * Dates.
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
		 * Dates.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class dates extends framework
		{
			/**
			 * Date translations (in local time, as configured by WordPress®).
			 *
			 * @param string  $format Date format. Same formats allowed by PHP's ``date()`` function.
			 *    This is optional. Defaults to: ``get_option('date_format').' '.get_option('time_format')``.
			 *
			 * @note There are several PHP constants that can be used here, making ``$format`` easier to deal with.
			 *    Please see: {@link http://www.php.net/manual/en/class.datetime.php#datetime.constants.types}.
			 *
			 * @param integer $time Optional timestamp. A UNIX timestamp, based on UTC time.
			 *    This defaults to the current time if NOT passed in explicitly.
			 *    WARNING: Please make sure ``$time`` is based on UTC.
			 *
			 * @param boolean $utc Defaults to FALSE (recommended).
			 *    If this is TRUE the time will be returned in UTC time instead of local time.
			 *
			 * @return string Date translation (in local time, as configured by WordPress®).
			 *    Or, if ``$utc`` is TRUE the time will be returned in UTC time, instead of local time.
			 *
			 * @note This uses ``date_i18n()`` from WordPress®. We supplement this built-in WordPress® function,
			 *    by forcing the ``$time`` argument value at all times. WordPress® has some issues with its default for ``$time``,
			 *    but we can force ``$time`` to resolve those problems completely here.
			 *
			 * @difference Unless ``$utc`` is TRUE, this method always adds the UTC offset to ``$time``,
			 *    which is something that WordPress® does NOT do by default. Making this a better alternative.
			 *
			 * @WARNING WordPress® has a broken implementation of ``$utc``. Dates with a ``$format`` that include a timezone char,
			 *    like `O` or `T`, are always represented with the blog's timezone (even when ``$utc`` is TRUE).
			 *    This is wrong, because ``$utc`` being TRUE should be indicated with a UTC timezone.
			 *
			 *    We fix this issue here by removing timezone chars from ``$format``, when ``$utc`` is TRUE.
			 *    Once the translation is completed, we add ` UTC` onto the end as a quick fix.
			 *    TODO Review again upon release of WP 4. Hoping for a better solution.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function i18n_($format = '', $time = 0, $utc = FALSE)
				{
					$this->check_arg_types('string', 'integer', 'boolean', func_get_args());

					$format = ($format) ? $format : get_option('date_format').' '.get_option('time_format');

					$time = ($time) ? abs($time) : time(); // Default time.
					$time = ($utc) ? $time : $time + (get_option('gmt_offset') * 3600);

					if($utc && preg_match('/(?<!\\\\)[PIOTZe]/', $format))
						{
							$format = preg_replace('/(?<!\\\\)[PIOTZe]/', '', $format);
							$format = trim(preg_replace('/\s+/', ' ', $format));

							return date_i18n($format, $time, $utc).' UTC';
						}
					return date_i18n($format, $time, $utc); // Default return value.
				}

			/**
			 * Date translations (in UTC time). See: {@link i18n_()}.
			 *
			 * @param string  $format Date format. Same formats allowed by PHP's ``date()`` function.
			 *    This is optional. Defaults to: ``get_option('date_format').' '.get_option('time_format')``.
			 *
			 * @note There are several PHP constants that can be used here, making ``$format`` easier to deal with.
			 *    Please see: {@link http://www.php.net/manual/en/class.datetime.php#datetime.constants.types}.
			 *
			 * @param integer $time Optional timestamp. A UNIX timestamp, based on UTC time.
			 *    This defaults to the current time if NOT passed in explicitly.
			 *    WARNING: Please make sure ``$time`` is based on UTC.
			 *
			 * @return string See: {@link i18n_()}.
			 */
			public function i18n_utc($format = '', $time = 0)
				{
					return $this->i18n_($format, $time, TRUE);
				}

			/**
			 * Calculates approx time different (in human readable format).
			 *
			 * @param integer $from A UTC timestamp to calculate from (i.e. start time).
			 * @param integer $to A UTC timestamp to calculate to (i.e. the end time).
			 *
			 * @return string Approx. time different (in human readable format).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function approx_time_difference($from, $to)
				{
					$this->check_arg_types('integer:!empty', 'integer:!empty', func_get_args());

					$difference = ($to - $from >= 0) ? $to - $from : 0;

					if($difference < 3600)
						{
							$minutes = (integer)round($difference / 60);

							$since = sprintf($this->translate_p('%1$s minute', '%1$s minutes', $minutes), $minutes);
							$since = ($minutes < 1) ? $this->translate('less than a minute') : $since;
							$since = ($minutes >= 60) ? $this->translate('about 1 hour') : $since;
						}
					else if($difference >= 3600 && $difference < 86400)
						{
							$hours = (integer)round($difference / 3600);

							$since = sprintf($this->translate_p('%1$s hour', '%1$s hours', $hours), $hours);
							$since = ($hours >= 24) ? $this->translate('about 1 day') : $since;
						}
					else if($difference >= 86400 && $difference < 604800)
						{
							$days = (integer)round($difference / 86400);

							$since = sprintf($this->translate_p('%1$s day', '%1$s days', $days), $days);
							$since = ($days >= 7) ? $this->translate('about 1 week') : $since;
						}
					else if($difference >= 604800 && $difference < 2592000)
						{
							$weeks = (integer)round($difference / 604800);

							$since = sprintf($this->translate_p('%1$s week', '%1$s weeks', $weeks), $weeks);
							$since = ($weeks >= 4) ? $this->translate('about 1 month') : $since;
						}
					else if($difference >= 2592000 && $difference < 31556926)
						{
							$months = (integer)round($difference / 2592000);

							$since = sprintf($this->translate_p('%1$s month', '%1$s months', $months), $months);
							$since = ($months >= 12) ? $this->translate('about 1 year') : $since;
						}
					else // We use years here (default case handler).
						{
							$years = (integer)round($difference / 31556926);
							$since = sprintf($this->translate_p('%1$s year', '%1$s years', $years), $years);
						}
					return $since; // Human readable time difference calculation.
				}
		}
	}