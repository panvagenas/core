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
		final class exception_handler // Stand-alone.
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
					echo sprintf(static::$plugin->translate('Exception Code: %1$s'), static::$exception->getCode())."\n";
					exit(sprintf(static::$plugin->translate('Exception Message: %1$s'), static::$exception->getMessage()));
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

					if($template->content && static::is_browser())
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
					echo sprintf(static::translate('Exception Code: %1$s'), static::$exception->getCode())."\n";
					exit(sprintf(static::translate('Exception Message: %1$s'), static::$exception->getMessage()));
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

					if(file_exists($path = get_stylesheet_directory().'/'.$file) && is_readable($path))
						return $path;
					else if(file_exists($path = get_template_directory().'/'.$file) && is_readable($path))
						return $path;
					else if(file_exists($path = dirname(dirname(dirname(__FILE__))).'/templates/'.$file) && is_readable($path))
						return $path;

					trigger_error(sprintf(static::i18n('Unable to locate template file: `%1$s`.'), $file), E_USER_ERROR);

					exit(); // Exit script execution.
				}

			/**
			 * Is the current User-Agent a browser?
			 *
			 * @return boolean TRUE if the current User-Agent is a browser, else FALSE.
			 */
			public static function is_browser()
				{
					$regex = '/(?:msie|trident|gecko|webkit|presto|konqueror|playstation)[\/ ][0-9\.]+/i';

					if(!empty($_SERVER['HTTP_USER_AGENT']) && is_string($_SERVER['HTTP_USER_AGENT']))
						if(preg_match($regex, $_SERVER['HTTP_USER_AGENT']))
							return TRUE;

					return FALSE;
				}

			/**
			 * Handles core translations for this class (context: admin-side).
			 *
			 * @param string  $string String to translate.
			 *
			 * @param string  $other_contextuals Optional. Other contextual slugs relevant to this translation.
			 *    Contextual slugs normally follow the standard of being written with dashes.
			 *
			 * @return string Translated string.
			 */
			public static function i18n($string, $other_contextuals = '')
				{
					$core_ns_stub_with_dashes = 'websharks-core'; // Core namespace stub w/ dashes.
					$string                   = (string)$string; // Typecasting this to a string value.
					$other_contextuals        = (string)$other_contextuals; // Typecasting this to a string value.
					$context                  = $core_ns_stub_with_dashes.'--admin-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

					return _x($string, $context, $core_ns_stub_with_dashes);
				}

			/**
			 * Handles core translations for this class (context: front-side).
			 *
			 * @param string  $string String to translate.
			 *
			 * @param string  $other_contextuals Optional. Other contextual slugs relevant to this translation.
			 *    Contextual slugs normally follow the standard of being written with dashes.
			 *
			 * @return string Translated string.
			 */
			public static function translate($string, $other_contextuals = '')
				{
					$core_ns_stub_with_dashes = 'websharks-core'; // Core namespace stub w/ dashes.
					$string                   = (string)$string; // Typecasting this to a string value.
					$other_contextuals        = (string)$other_contextuals; // Typecasting this to a string value.
					$context                  = $core_ns_stub_with_dashes.'--front-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

					return _x($string, $context, $core_ns_stub_with_dashes);
				}

			/**
			 * Regex pattern matching template content body.
			 *
			 * @var string Regex pattern matching template content body.
			 */
			public static $template_content_body_regex = '/\<\!\-\- BEGIN\: Content Body \-\-\>\s*(?P<template_content_body>.+?)\s*\<\!\-\- \/ END\: Content Body \-\-\>/is';
		}

		/**
		 * Register exception handler.
		 */
		if(set_exception_handler('\\'.__NAMESPACE__.'\\exception_handler::handle') !== NULL)
			restore_exception_handler(); // Don't override an existing handler.
	}