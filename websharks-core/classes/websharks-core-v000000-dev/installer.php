<?php
/**
 * Installation Utilities.
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
	 * Installation Utilities.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class installer extends framework
	{
		/**
		 * Handles activation and/or re-activation routines.
		 *
		 * @attaches-to WordPress® `register_activation_hook`, for the current plugin.
		 * @hook-priority Irrelevant. WordPress® deals with this automatically.
		 */
		public function activation()
		{
			if(!isset($this->cache[__FUNCTION__])) $this->cache[__FUNCTION__] = 0;
			$this->cache[__FUNCTION__]++; // Record each call (incrementing counter).

			if($this->cache[__FUNCTION__] > 1 /* More than ONE time? */)
				return; // Only run this routine ONE time.

			$reactivating = (bool)$this->©plugin->last_active_version();

			if( // Run all activation routines.

				$this->©dirs->activation_install(TRUE)
				&& $this->©options->activation_install(TRUE)
				&& $this->©db_utils->activation_install(TRUE)
				&& $this->©db_cache->activation_install(TRUE)
				&& $this->©db_tables->activation_install(TRUE)
				&& $this->©notices->activation_install(TRUE)
				&& $this->©crons->activation_install(TRUE)
				&& $this->additional_activations()

			) // Activation success! Everything returned TRUE here.
			{
				update_option(
					$this->___instance_config->plugin_root_ns_stub.'__version',
					$this->___instance_config->plugin_version
				);
				$this->©plugin->is_active_at_current_version($this::reconsider);

				$this->©notice->enqueue(
					'<p>'.
					sprintf($this->__('%1$s was a complete success<em>!</em> Current version: <strong>%2$s</strong>.'),
						(($reactivating) ? $this->__('Reactivation') : $this->__('Activation')), $this->___instance_config->plugin_version).
					'</p>'
				);
			}
			else // The activation failed for some reason.
			{
				$this->©notice->enqueue_error(
					'<p>'.
					sprintf($this->__('%1$s failed (please try again). Or, contact support if you need assistance.'),
						(($reactivating) ? $this->__('Reactivation') : $this->__('Activation'))).
					'</p>'
				);
			}
		}

		/**
		 * Any additional activation/installation routines.
		 *
		 * @note This should be overwritten by class extenders (when/if needed).
		 *
		 * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
		 */
		public function additional_activations()
		{
			return TRUE;
		}

		/**
		 * Handles deactivation routines.
		 *
		 * @param boolean $uninstall Optional. Defaults to a FALSE value.
		 *    If this is TRUE, we'll force a complete uninstall; regardless of configuration.
		 *
		 * @attaches-to WordPress® `register_deactivation_hook`, for the current plugin.
		 * @hook-priority Irrelevant. WordPress® deals with this automatically.
		 */
		public function deactivation($uninstall = FALSE)
		{
			$this->check_arg_types('boolean', func_get_args());

			if(!isset($this->cache[__FUNCTION__])) $this->cache[__FUNCTION__] = 0;
			$this->cache[__FUNCTION__]++; // Record each call (incrementing counter).

			if($this->cache[__FUNCTION__] > 1 /* More than ONE time? */)
				return; // Only run this routine ONE time.

			if(!$uninstall || !$this->©options->get('installer.deactivation.uninstalls'))
				return; // Nothing to do here.

			$this->additional_deactivations();
			$this->©crons->deactivation_uninstall(TRUE);
			$this->©notices->deactivation_uninstall(TRUE);
			$this->©db_tables->deactivation_uninstall(TRUE);
			$this->©db_cache->deactivation_uninstall(TRUE);
			$this->©db_utils->deactivation_uninstall(TRUE);
			$this->©options->deactivation_uninstall(TRUE);
			$this->©dirs->deactivation_uninstall(TRUE);
			deps::deactivation_uninstall(TRUE);

			delete_option($this->___instance_config->plugin_root_ns_stub.'__version');

			$this->©plugin->is_active_at_current_version($this::reconsider);
		}

		/**
		 * Any additional deactivation/uninstall routines.
		 *
		 * @note This should be overwritten by class extenders (when/if needed).
		 *
		 * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
		 */
		public function additional_deactivations()
		{
			return TRUE;
		}
	}
}