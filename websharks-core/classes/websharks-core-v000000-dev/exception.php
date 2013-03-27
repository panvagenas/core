<?php
/**
 * Exception.
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
		 * Exception.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 */
		class exception extends \exception // Allow extenders.
		{
			/**
			 * @var boolean Enable debug file logging?
			 * @extenders Can be overridden by class extenders.
			 */
			public $wp_debug_log = TRUE;

			/**
			 * @var boolean Enable DB table logging?
			 * @extenders Can be overridden by class extenders.
			 */
			public $db_log = TRUE;

			/**
			 * Diagnostic data.
			 *
			 * @var mixed Diagnostic data.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $data; // Defaults to a NULL value.

			/**
			 * Plugin/framework instance.
			 *
			 * @var framework Plugin/framework instance.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $plugin; // Defaults to a NULL value.

			/**
			 * Constructor.
			 *
			 * @param object|array    $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or a new ``$___instance_config`` array.
			 *
			 * @param string          $code Optional error code (string, NO integers please).
			 *
			 * @param null|mixed      $data Optional exception data (i.e. something to assist in reporting/logging).
			 *    This argument can be bypassed using a NULL value (that's fine).
			 *
			 * @param string          $message Optional exception message (i.e. an error message).
			 *
			 * @param null|\exception $previous Optional previous exception (if re-thrown).
			 *
			 * @throws \exception If there is a missing and/or invalid ``$___instance_config``.
			 * @throws \exception A standard exception class; if any additional issues occur during this type of exception.
			 *    This prevents endless exceptions, which may occur when/if we make use of a plugin instance.
			 */
			public function __construct($___instance_config = NULL, $code = 'exception', $data = NULL, $message = '', \exception $previous = NULL)
				{
					try // We'll use standard exceptions for any issues here.
						{
							if($___instance_config instanceof framework)
								$plugin_root_ns = $___instance_config->___instance_config->plugin_root_ns;
							else if(is_array($___instance_config) && !empty($___instance_config['plugin_root_ns']))
								$plugin_root_ns = (string)$___instance_config['plugin_root_ns'];

							if(empty($plugin_root_ns) || !isset($GLOBALS[$plugin_root_ns]) || !($GLOBALS[$plugin_root_ns] instanceof framework))
								throw new \exception(sprintf(stub::i18n('Invalid `$___instance_config` to constructor: `%1$s`'),
								                             print_r($___instance_config, TRUE))
								);
							$this->plugin = $GLOBALS[$plugin_root_ns];
							$code         = ((string)$code) ? (string)$code : 'exception';
							$message      = ((string)$message) ? (string)$message : sprintf($this->plugin->i18n('Exception code: `%1$s`.'), $code);

							parent::__construct($message, 0, $previous); // Call parent constructor.
							$this->code = $code; // Set code for this instance. We always use string exception codes (no exceptions :-).
							$this->data = $data; // Optional diagnostic data associated with this exception (possibly a NULL value).

							if($this->plugin->©plugin->is_core()) // Always off in the WebSharks™ Core.
								// @TODO We need to figure out a way for us to leave this on for the WebSharks™ Core.
								$this->wp_debug_log = $this->db_log = FALSE;

							$this->wp_debug_log(); // Possible debug logging.
							$this->db_log(); // Possible database logging routine.
						}
					catch(\exception $exception) // Rethrow a standard exception class.
						{
							throw new \exception(
								sprintf(stub::i18n('Could NOT instantiate exception code: `%1$s` with message: `%2$s`.'), $code, $message).
								sprintf(stub::i18n(' Caused by exception code: `%1$s` with message: `%2$s`.'), $exception->getCode(), $exception->getMessage()), 20, $exception
							);
						}
				}

			/**
			 * Logs exceptions.
			 *
			 * @note We only log exceptions if the class instance enables this,
			 *    and `WP_DEBUG_LOG` MUST be enabled also (for this to work).
			 */
			public function wp_debug_log()
				{
					if($this->wp_debug_log && $this->plugin->©env->is_in_wp_debug_log_mode())
						{
							$log_dir  = $this->plugin->©dir->get_log_dir('private', 'debug');
							$log_file = $this->plugin->©file->maybe_archive($log_dir.'/debug.log');

							file_put_contents(
								$log_file,
								$this->plugin->i18n('— EXCEPTION —')."\n".
								$this->plugin->i18n('Exception Code').': '.$this->getCode()."\n".
								$this->plugin->i18n('Exception Line #').': '.$this->getLine()."\n".
								$this->plugin->i18n('Exception File').': '.$this->getFile()."\n".
								$this->plugin->i18n('Exception Time').': '.$this->plugin->©env->time_details()."\n".
								$this->plugin->i18n('Memory Details').': '.$this->plugin->©env->memory_details()."\n".
								$this->plugin->i18n('Version Details').': '.$this->plugin->©env->version_details()."\n".
								$this->plugin->i18n('Current User ID').': '.$this->plugin->©user->ID."\n".
								$this->plugin->i18n('Current User Email').': '.$this->plugin->©user->email."\n".
								$this->plugin->i18n('Exception Message').': '.$this->getMessage()."\n\n".
								$this->plugin->i18n('Exception Stack Trace').': '.$this->getTraceAsString()."\n\n".
								$this->plugin->i18n('Exception Data (if applicable)').': '.$this->plugin->©var->dump($this->data)."\n\n",
								FILE_APPEND
							);
						}
				}

			/**
			 * Logs exceptions.
			 *
			 * @note We only log exceptions if the class instance enables this.
			 *
			 * @extenders This is NOT implemented by the WebSharks™ Core.
			 *    Class extenders can easily extend this method, and perform their own DB logging routine.
			 */
			public function db_log()
				{
					if($this->db_log)
						{
						}
				}
		}
	}