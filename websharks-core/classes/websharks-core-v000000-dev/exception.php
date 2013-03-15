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
			public $plugin;

			/**
			 * Constructor.
			 *
			 * @param object|array    $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or an explicit ``$___instance_config`` object/array will suffice also.
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
								$plugin_root_ns = (string)strstr(get_class($___instance_config), '\\', TRUE);
							else if(is_object($___instance_config) && !empty($___instance_config->plugin_root_ns))
								$plugin_root_ns = (string)$___instance_config->plugin_root_ns;
							else if(is_array($___instance_config) && !empty($___instance_config['plugin_root_ns']))
								$plugin_root_ns = (string)$___instance_config['plugin_root_ns'];

							if(empty($plugin_root_ns) || !isset($GLOBALS[$plugin_root_ns]) || !($GLOBALS[$plugin_root_ns] instanceof framework))
								throw new \exception(sprintf(static::i18n('Invalid `$___instance_config` to constructor: `%1$s`'),
								                             print_r($___instance_config, TRUE))
								);

							$this->plugin = $GLOBALS[$plugin_root_ns];
							$code         = ((string)$code) ? (string)$code : 'exception';
							$message      = ((string)$message) ? (string)$message : sprintf($this->plugin->i18n('Exception code: `%1$s`.'), $code);

							parent::__construct($message, 0, $previous); // Call parent constructor.
							$this->code = $code; // Set code for this instance. We always use string exception codes (no exceptions :-).
							$this->data = $data; // Optional diagnostic data associated with this exception (possibly a NULL value).

							$this->wp_debug_log(); // Possible debug logging.
							$this->db_log(); // Possible database logging routine.
						}
					catch(\exception $exception) // Rethrow a standard exception class.
						{
							throw new \exception(
								sprintf(static::i18n('Could NOT instantiate exception w/ code: `%1$s`.'), $code), 20, $exception
							);
						}
				}

			/**
			 * Logs exceptions.
			 *
			 * @note We only log exceptions if the class instance enables this,
			 *    and `WP_DEBUG` MUST be enabled also (for this to work).
			 */
			public function wp_debug_log()
				{
					if($this->wp_debug_log && $this->plugin->©env->is_in_wp_debug_mode())
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

			/**
			 * Handles core translations (context: admin-side).
			 *
			 * @return string {@inheritdoc}
			 *
			 * @see \websharks_core_v000000_dev::i18n()
			 * @inheritdoc \websharks_core_v000000_dev::i18n()
			 */
			public static function i18n() // Arguments are NOT listed here.
				{
					return call_user_func_array('\\'.__NAMESPACE__.'::i18n', func_get_args());
				}

			/**
			 * Handles core translations (context: front-side).
			 *
			 * @return string {@inheritdoc}
			 *
			 * @see \websharks_core_v000000_dev::translate()
			 * @inheritdoc \websharks_core_v000000_dev::translate()
			 */
			public static function translate() // Arguments are NOT listed here.
				{
					return call_user_func_array('\\'.__NAMESPACE__.'::translate', func_get_args());
				}
		}
	}