<?php
/**
 * CRON Jobs.
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
		 * CRON Jobs.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class crons extends framework
		{
			/**
			 * Handles loading sequence.
			 *
			 * @attaches-to WordPress® `wp_loaded` action hook.
			 * @hook-priority `9999`.
			 *
			 * @return null Nothing.
			 *
			 * @assert () === NULL
			 */
			public function wp_loaded()
				{
					add_filter('cron_schedules', array($this, 'extend'));
				}

			/**
			 * Extends CRON schedules to support additional frequencies.
			 *
			 * @attaches-to WordPress® filter `cron_schedules`.
			 * @hook-priority Default is fine.
			 *
			 * @param array $schedules Expects an array of schedules, passed in by the WordPress® filter.
			 *
			 * @return array Modified array of CRON schedules.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (array()) !empty TRUE
			 */
			public function extend($schedules)
				{
					$this->check_arg_types('array', func_get_args());

					$new_schedules = array
					(
						'every10m' => array(
							'interval' => 600,
							'display'  => $this->i18n('Every 10 Minutes')
						)
					);

					return array_merge($schedules, $new_schedules);
				}

			/**
			 * Configures CRON job events with WordPress®.
			 *
			 * @param array $cron_jobs An array of CRON jobs to configure.
			 *
			 * @return integer The number of new CRON jobs configured.
			 *    Returns `0` if nothing was new (e.g. all CRONs were already configured properly).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If any CRON job fails validation.
			 *
			 * @assert $cron_jobs = array(array('©class.method' => '©foo.bar', 'schedule' => 'every10m'));
			 *    ($cron_jobs) === 1
			 *
			 * @assert $cron_jobs = array(array('©class.method' => '©foo.bar', 'schedule' => 'daily'));
			 *    ($cron_jobs) === 1
			 *
			 * @assert $cron_jobs = array(array('©class.method' => '©foo.bar', 'schedule' => 'daily'));
			 *    ($cron_jobs) === 0
			 */
			public function config($cron_jobs)
				{
					$this->check_arg_types('array', func_get_args());

					$schedules      = array_keys(wp_get_schedules());
					$config         = $this->©options->get('crons.config');
					$configurations = 0; // Initialize to zero.

					foreach($cron_jobs as $_key => $_cron_job) // Main loop. Inspect each of these.
						{
							if // Each CRON job MUST pass the following validators; else we throw an exception below.
							(
								is_array($_cron_job) // Make sure this IS an array.
								&& $this->©string->is_not_empty($_cron_job['©class.method'])
								&& substr_count($_cron_job['©class.method'], '©') === 1 && substr_count($_cron_job['©class.method'], '.') === 1
								&& $this->©string->is_not_empty($_cron_job['schedule']) && in_array($_cron_job['schedule'], $schedules, TRUE)

							) // Now... let's add each event hook, and check if this CRON job needs to be configured, or NO?
								{
									$_key = $_cron_job['©class.method']; // Use as: ``$config[$_key]``.

									list($_cron_job['©class'], $_cron_job['method']) = explode('.', $_cron_job['©class.method'], 2);
									$_cron_job['event_hook'] = '_cron__'.$this->___instance_config->plugin_root_ns_stub.'__'.trim($_cron_job['©class'], '©').'__'.$_cron_job['method'];

									add_action($_cron_job['event_hook'], array($this, $_cron_job['©class.method']));

									if(!empty($config[$_key]['last_config_time']))
										$_cron_job['last_config_time'] = (integer)$config[$_key]['last_config_time'];
									else $_cron_job['last_config_time'] = 0;

									if(!$_cron_job['last_config_time']
									   || $_cron_job['schedule'] !== $this->©string->is_not_empty_or($config[$_key]['schedule'], '')
									) // If it's NEVER been configured, or if it's schedule has been changed in some way.
										{
											wp_clear_scheduled_hook($_cron_job['event_hook']);
											wp_schedule_event(time() + mt_rand(300, 18000), $_cron_job['schedule'], $_cron_job['event_hook']);

											$_cron_job['last_config_time'] = time();
											$config[$_key]                 = $_cron_job;
											$this->©options->update(array('crons.config' => $config));

											$configurations++; // Increment this now.
										}
								}
							else throw $this->©exception(
								__METHOD__.'#invalid_cron_job', compact('_cron_job'),
								$this->i18n('Invalid CRON job (missing and/or invalid array keys).').
								sprintf($this->i18n(' Got: `%1$s`.'), printf($_cron_job, TRUE))
							);
						}
					unset($_key, $_cron_job); // A little housekeeping.

					return $configurations;
				}

			/**
			 * Deletes CRON job events for the current plugin.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen; and this method returns `0`.
			 *
			 * @param array   $cron_jobs Optional. Defaults to an empty array.
			 *    If this is passed in, and it's NOT empty, we'll delete ONLY CRON jobs in this array.
			 *    Otherwise, by default, all CRON jobs are deleted.
			 *
			 * @return integer The number of CRON jobs deleted.
			 *    Returns `0` if nothing was deleted (e.g. no CRON jobs were configured).
			 *    Also returns `0` if ``$confirmation`` was NOT a TRUE value.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $this->object->delete(TRUE);
			 * $cron_jobs = array(array('©class.method' => '©foo1.bar1', 'schedule' => 'every10m'), array('©class.method' => '©foo2.bar2', 'schedule' => 'every10m'));
			 * $this->object->config($cron_jobs);
			 *    () === 0
			 *
			 * @assert $this->object->delete(TRUE);
			 * $cron_jobs = array(array('©class.method' => '©foo1.bar1', 'schedule' => 'every10m'), array('©class.method' => '©foo2.bar2', 'schedule' => 'every10m'));
			 * $this->object->config($cron_jobs);
			 *    (TRUE) === 2
			 *
			 * @assert $this->object->delete(TRUE);
			 * $cron_jobs = array(array('©class.method' => '©foo1.bar1', 'schedule' => 'every10m'), array('©class.method' => '©foo2.bar2', 'schedule' => 'every10m'));
			 * $cron_jobs_to_delete = $cron_jobs;
			 * $this->object->config($cron_jobs);
			 *    (TRUE, $cron_jobs_to_delete) === 2
			 *
			 * @assert $this->object->delete(TRUE);
			 * $cron_jobs = array(array('©class.method' => '©foo1.bar1', 'schedule' => 'every10m'), array('©class.method' => '©foo2.bar2', 'schedule' => 'every10m'));
			 * $cron_jobs_to_delete = array(array('©class.method' => '©foo1.bar1', 'schedule' => 'every10m'));
			 * $this->object->config($cron_jobs);
			 *    (TRUE, $cron_jobs_to_delete) === 1
			 */
			public function delete($confirmation = FALSE, $cron_jobs = array())
				{
					$this->check_arg_types('boolean', 'array', func_get_args());

					if(!$confirmation)
						return 0; // Added security.

					$deletions = 0; // Initialize to zero (NO deletions thus far).

					$cron_job_keys = $this->©array->compile_key_elements_deep($cron_jobs, '©class.method');

					foreach(($config = $this->©options->get('crons.config')) as $_key => $_cron_job)
						{
							if(empty($cron_job_keys) || in_array($_key, $cron_job_keys, TRUE))
								{
									if(is_array($_cron_job) // Make sure this IS an array.
									   && $this->©string->is_not_empty($_cron_job['event_hook'])
									) // Delete (i.e. clear) the scheduled CRON job event hook.
										wp_clear_scheduled_hook($_cron_job['event_hook']);

									unset($config[$_key]); // Delete from ``$config``.

									$deletions++; // Increment.
								}
						}
					unset($_key, $_cron_job); // A little housekeeping.

					$this->©options->update(array('crons.config' => $config));

					return $deletions; // Total deletions.
				}

			/**
			 * Adds data/procedures associated with this class.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen; and this method returns FALSE.
			 *
			 * @return boolean TRUE if successfully installed, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert () === FALSE
			 * @assert (TRUE) === TRUE
			 */
			public function activation_install($confirmation = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					if(!$confirmation)
						return FALSE; // Added security.

					$this->delete(TRUE);

					return TRUE;
				}

			/**
			 * Removes data/procedures associated with this class.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen; and this method returns FALSE.
			 *
			 * @return boolean TRUE if successfully uninstalled, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert () === FALSE
			 * @assert (TRUE) === TRUE
			 */
			public function deactivation_uninstall($confirmation = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					if(!$confirmation)
						return FALSE; // Added security.

					$this->delete(TRUE);

					return TRUE;
				}
		}
	}