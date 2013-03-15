<?php
/**
 * Exception Handler.
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
		 * Exception Handler.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 */
		final class exception_handler // Static methods only.
		{
			/**
			 * Exception being handled by this class.
			 *
			 * @var exception|\exception Exception class.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public static $exception;

			/**
			 * Plugin/framework instance.
			 *
			 * @var framework Plugin/framework instance; else NULL if unavailable.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public static $plugin;

			/**
			 * Handles all PHP exceptions.
			 *
			 * @param exception|\exception $exception An exception.
			 */
			public static function handle(\exception $exception)
				{
					// Define class properties.

					static::$exception = $exception;

					if(static::$exception instanceof exception)
						static::$plugin = $exception->plugin;

					// Handle this exception.

					if(static::$plugin)
						{
							try // Try to handle w/ plugin.
								{
									static::handle_plugin_exception();
								}
							catch(\exception $handle_plugin_exception)
								{
									static::handle_other_exceptions();
								}
						}
					else static::handle_other_exceptions();
				}

			/**
			 * Handles a plugin exception.
			 */
			protected static function handle_plugin_exception()
				{
					if(ob_get_level()) // Cleans output buffers.
						while(ob_get_level()) ob_end_clean();

					// Construct template.

					$exception = static::$exception; // For template data.
					$template  = static::$plugin->©template('exception.php', get_defined_vars());

					// Output exception message.

					if($template->content && static::$plugin->©env->is_browser())
						{
							if(!headers_sent()) // Can exception stand-alone?
								{
									static::$plugin->©headers->clean_status_type(500, 'text/html', TRUE);
									exit($template->content); // Display.
								}
							else if(preg_match(static::$template_content_body_regex, $template->content, $_m))
								exit(str_replace('<pre>', '<pre style="max-height:200px; overflow:auto;">', $_m['template_content_body']));
						}
					// Output exception message (command-line; and other non-browser devices).

					echo sprintf(static::$plugin->translate('Exception Code: %1$s'), static::$exception->getCode())."\n";
					echo sprintf(static::$plugin->translate('Exception Message: %1$s'), static::$exception->getMessage());
					if(static::$plugin->©env->is_in_wp_debug_mode() || is_super_admin())
						echo static::$exception->getTraceAsString();

					exit(); // Clean exit now.
				}

			/**
			 * Handles other exceptions.
			 */
			protected static function handle_other_exceptions()
				{
					if(ob_get_level()) // Cleans output buffers.
						while(ob_get_level()) ob_end_clean();

					// Construct template.

					ob_start();
					include static::template('exceptions.php');
					$template          = new \stdClass();
					$template->content = ob_get_clean();

					// Output exception message.

					if($template->content && \websharks_core_v000000_dev::is_browser())
						{
							if(!headers_sent()) // Can exception stand-alone?
								{
									status_header(500);
									header('Content-Type: text/html; charset=UTF-8');
									exit($template->content);
								}
							else if(preg_match(static::$template_content_body_regex, $template->content, $_m))
								exit(str_replace('<pre>', '<pre style="max-height:200px; overflow:auto;">', $_m['template_content_body']));
						}

					// Output exception message (command-line; and other non-browser devices).

					echo sprintf(static::translate('Exception Code: %1$s'), static::$exception->getCode())."\n";
					echo sprintf(static::translate('Exception Message: %1$s'), static::$exception->getMessage());
					if((defined('WP_DEBUG') && WP_DEBUG) || is_super_admin())
						echo static::$exception->getTraceAsString();

					exit(); // Clean exit now.
				}

			/**
			 * Locates a template file.
			 *
			 * @param string $file Template file name (relative path).
			 *
			 * @return string Absolute path to a template file (w/ the highest precedence).
			 *
			 * @triggers error If ``$file`` does NOT exist, or is NOT readable.
			 */
			public static function template($file)
				{
					$file = (string)$file;

					if(is_file($path = get_stylesheet_directory().'/'.$file) && is_readable($path))
						return $path;
					else if(is_file($path = get_template_directory().'/'.$file) && is_readable($path))
						return $path;
					else if(is_file($path = dirname(dirname(dirname(__FILE__))).'/templates/'.$file) && is_readable($path))
						return $path;

					trigger_error(sprintf(static::i18n('Unable to locate template file: `%1$s`.'), $file), E_USER_ERROR);

					exit(); // Exit script execution.
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

			/**
			 * Regex pattern matching template content body.
			 *
			 * @var string Regex pattern matching template content body.
			 */
			protected static $template_content_body_regex = '/\<\!\-\-\s+BEGIN\:\s+Content\s+Body\s+\-\-\>\s*(?P<template_content_body>.+?)\s*\<\!\-\-\s+\/\s+END\:\s+Content Body\s+\-\-\>/is';
		}

		/**
		 * Register exception handler.
		 */
		if(set_exception_handler('\\'.__NAMESPACE__.'\\exception_handler::handle') !== NULL)
			restore_exception_handler(); // Don't override an existing handler.
	}