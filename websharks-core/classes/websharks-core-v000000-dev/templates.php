<?php
/**
 * Templates.
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
	 * Templates.
	 *
	 * @package WebSharks\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class templates extends framework
	{
		/**
		 * @var string Template file name (relative path).
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $file = '';

		/**
		 * @var object Template data object properties.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $data; // Defaults to a NULL value.

		/**
		 * @var string UI theme.
		 *    Defaults to the current front-side theme.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $theme = '';

		/**
		 * @var null|errors An errors object instance; else NULL if no errors.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $errors; // Defaults to a NULL value.

		/**
		 * @var null|successes A successes object instance; else NULL if no successes.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $successes; // Defaults to a NULL value.

		/**
		 * @var null|messages A messages object instance; else NULL if no messages.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $messages; // Defaults to a NULL value.

		/**
		 * @var string Parsed template content.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $content = '';

		/**
		 * @var object XML config object properties.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $config; // Defaults to a NULL value.

		/**
		 * Constructor.
		 *
		 * @param object|array $___instance_config Required at all times.
		 *    A parent object instance, which contains the parent's `$___instance_config`,
		 *    or a new `$___instance_config` array.
		 *
		 * @param string       $file Template file name (relative path).
		 *
		 * @param array|object $data Optional array (or object) containing custom data, specifically for this template.
		 *    Or (if there is no data) an errors/successes/messages object instance can be passed directly through this argument value.
		 *
		 *    • Incoming `$data` will always be objectified by one dimension (e.g. we force object properties).
		 *
		 *    • If we have data AND `errors|successes|messages`, the data (along with `errors|successes|messages`)
		 *       can be passed into this constructor by adding the object instance(s) for `errors|successes|messages` to `$data`,
		 *       with array keys (or object property names) matching `errors`, `successes`, `messages` (when/if applicable).
		 *
		 *    • If a user object instance is passed through `$data` w/ the array key (or property name) `user`;
		 *       the `user` value is parsed with `$this->©user_utils->which()`; allowing variations supported by this utility.
		 *
		 * @param string       $theme Optional. Defaults to an empty string.
		 *    If this is passed in, a specific UI theme will be forced into play.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$file` is empty, or it CANNOT be located by `$this->©file->template()`.
		 */
		public function __construct($___instance_config, $file, $data = array(), $theme = '')
		{
			parent::__construct($___instance_config);

			$this->check_arg_types('', 'string:!empty', array('array', 'object'), 'string', func_get_args());

			$this->file = $file; // Template file name (relative path).
			$this->data = $this->parse_data($data); // Supports all possible scenarios.

			$this->theme = ($theme) ? $theme : $this->©options->get('styles.front_side.theme');
			if(!in_array($this->theme, array_keys($this->©styles->themes()), TRUE))
				$this->theme = $this->©options->get('styles.front_side.theme', TRUE);
			$this->©plugin->needs_front_side_styles_scripts(TRUE, $this->theme);

			$this->content = $this->parse_content(); // Parses content in this template file.
			$this->config  = $this->parse_config(); // Gets XML config values from this template file.
		}

		/**
		 * Gets stand-alone styles.
		 *
		 * @param string $theme Optional. Defaults to an empty string.
		 *    If this is passed in, a specific UI theme will be forced into play.
		 *
		 * @return string Stand-alone styles.
		 */
		public function stand_alone_styles($theme = '')
		{
			$this->check_arg_types('string', func_get_args());

			if($theme && in_array($this->theme, array_keys($this->©styles->themes()), TRUE))
				$this->theme = $theme; // Validate.
			$this->©plugin->needs_stand_alone_styles(TRUE, $this->theme);

			ob_start(); // Open output buffer.

			$this->©styles->print_styles($this->©styles->contextual_components($this->___instance_config->core_prefix_with_dashes.$this->theme));
			echo '<style type="text/css">html{'.$this->©options->get('templates.stand_alone.bg_style').'}</style>'."\n";
			echo $this->©php->evaluate($this->©options->get('templates.stand_alone.styles'))."\n";

			return ob_get_clean(); // Return final output buffer.
		}

		/**
		 * Gets email styles (e.g. those specifically for email messages).
		 *
		 * @return string Email styles.
		 */
		public function email_styles()
		{
			$styles = '<style type="text/css">';
			$styles .= file_get_contents($this->©file->template('client-side/styles/email.min.css'));
			$styles .= '</style>'; // Inline email classes via `<style>` tag.

			return $styles; // Return final styles.
		}

		/**
		 * Gets stand-alone scripts.
		 *
		 * @param boolean $in_footer Optional. Defaults to FALSE.
		 *    See @{link stand_alone_footer_scripts}
		 *
		 * @return string Stand-alone scripts.
		 *
		 * @see stand_alone_footer_scripts
		 */
		public function stand_alone_scripts($in_footer = FALSE)
		{
			$this->©plugin->needs_stand_alone_scripts(TRUE);

			ob_start(); // Open output buffer.

			if($in_footer) echo '<!-- footer-scripts -->'."\n";
			$this->©scripts->print_scripts($this->©scripts->contextual_components());
			echo $this->©php->evaluate($this->©options->get('templates.stand_alone.scripts'))."\n";
			if($in_footer) echo '<!-- footer-scripts -->'."\n";

			return ob_get_clean(); // Return final output buffer.
		}

		/**
		 * Gets stand-alone scripts (for footer).
		 *
		 * @return string Stand-alone scripts (for footer).
		 *
		 * @see stand_alone_scripts
		 */
		public function stand_alone_footer_scripts()
		{
			return $this->stand_alone_scripts(TRUE);
		}

		/**
		 * CSS front-side wrapper classes.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS front-side wrapper classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function front_side_wrapper_classes($others = array(), $format = self::space_sep_string)
		{
			return $this->wrapper_classes_for('front-side', $others, $format);
		}

		/**
		 * An alias for `$this->front_side_wrapper_classes()`.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS front-side wrapper classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function front_side_wrapper_classes_plus($others = array(), $format = self::space_sep_string)
		{
			return $this->front_side_wrapper_classes($others, $format);
		}

		/**
		 * CSS front-side container classes.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS front-side container classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function front_side_container_classes($others = array(), $format = self::space_sep_string)
		{
			return $this->container_classes_for('front-side', $others, $format);
		}

		/**
		 * An alias for `$this->front_side_container_classes()`.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS front-side container classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function front_side_container_classes_plus($others = array(), $format = self::space_sep_string)
		{
			return $this->front_side_container_classes($others, $format);
		}

		/**
		 * CSS stand-alone wrapper classes.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS stand-alone wrapper classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function stand_alone_wrapper_classes($others = array(), $format = self::space_sep_string)
		{
			return $this->wrapper_classes_for('stand-alone', $others, $format);
		}

		/**
		 * An alias for `$this->stand_alone_wrapper_classes()`.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS stand-alone wrapper classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function stand_alone_wrapper_classes_plus($others = array(), $format = self::space_sep_string)
		{
			return $this->stand_alone_wrapper_classes($others, $format);
		}

		/**
		 * CSS stand-alone container classes.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS stand-alone container classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function stand_alone_container_classes($others = array(), $format = self::space_sep_string)
		{
			return $this->container_classes_for('stand-alone', $others, $format);
		}

		/**
		 * An alias for `$this->stand_alone_container_classes()`.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS stand-alone container classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function stand_alone_container_classes_plus($others = array(), $format = self::space_sep_string)
		{
			return $this->stand_alone_container_classes($others, $format);
		}

		/**
		 * CSS email wrapper classes.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS email wrapper classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function email_wrapper_classes($others = array(), $format = self::space_sep_string)
		{
			return $this->wrapper_classes_for('email', $others, $format);
		}

		/**
		 * An alias for `$this->email_wrapper_classes()`.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS email wrapper classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function email_wrapper_classes_plus($others = array(), $format = self::space_sep_string)
		{
			return $this->email_wrapper_classes($others, $format);
		}

		/**
		 * CSS email container classes.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS email container classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function email_container_classes($others = array(), $format = self::space_sep_string)
		{
			return $this->container_classes_for('email', $others, $format);
		}

		/**
		 * An alias for `$this->email_container_classes()`.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS email container classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function email_container_classes_plus($others = array(), $format = self::space_sep_string)
		{
			return $this->email_container_classes($others, $format);
		}

		/**
		 * CSS wrapper classes.
		 *
		 * @param string       $for A class prefix.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS wrapper classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function wrapper_classes_for($for, $others = array(), $format = self::space_sep_string)
		{
			$this->check_arg_types('string:!empty', array('string', 'array'), 'string', func_get_args());

			$classes[] = $this->___instance_config->core_ns_stub_with_dashes;
			$classes[] = $this->___instance_config->plugin_root_ns_stub_with_dashes;

			$classes[] = trim($this->___instance_config->core_prefix_with_dashes, '-');
			$classes[] = $this->___instance_config->core_prefix_with_dashes.$this->theme;

			$classes[] = $this->___instance_config->core_ns_stub_with_dashes.'-'.$for.'-wrapper';
			$classes[] = $this->___instance_config->plugin_root_ns_stub_with_dashes.'-'.$for.'-wrapper';
			$classes[] = $for.'-wrapper'; // This one is the same (but without the leading prefix).
			$classes[] = $for.'-'.$this->©file->to_css_class(basename($this->file)).'-wrapper';
			$classes[] = $this->©file->to_css_class(basename($this->file)).'-wrapper';
			$classes[] = 'wrapper';

			$others  = ($others) ? (array)$others : array();
			$classes = array_unique(array_merge($classes, $others));

			return ($format === $this::array_n) ? $classes : implode(' ', $classes);
		}

		/**
		 * CSS container classes.
		 *
		 * @param string       $for A class prefix.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array CSS container classes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function container_classes_for($for, $others = array(), $format = self::space_sep_string)
		{
			$this->check_arg_types('string:!empty', array('string', 'array'), 'string', func_get_args());

			$classes[] = $this->___instance_config->core_ns_stub_with_dashes.'-'.$for.'-container';
			$classes[] = $this->___instance_config->plugin_root_ns_stub_with_dashes.'-'.$for.'-container';
			$classes[] = $for.'-container'; // This one is the same (but without the leading prefix).
			$classes[] = $for.'-'.$this->©file->to_css_class(basename($this->file)).'-container';
			$classes[] = $this->©file->to_css_class(basename($this->file)).'-container';
			$classes[] = 'container';

			$others  = ($others) ? (array)$others : array();
			$classes = array_unique(array_merge($classes, $others));

			return ($format === $this::array_n) ? $classes : implode(' ', $classes);
		}

		/**
		 * UI widget classes.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array UI widget classes.
		 */
		public function ui_widget_classes($others = array(), $format = self::space_sep_string)
		{
			$this->check_arg_types(array('string', 'array'), 'string', func_get_args());

			$others  = ($others) ? (array)$others : array();
			$classes = array('ui-widget', 'ui-widget-content', 'ui-corner-all');
			$classes = array_unique(array_merge($classes, $others));

			return ($format === $this::array_n) ? $classes : implode(' ', $classes);
		}

		/**
		 * An alias for `$this->ui_widget_classes()`.
		 *
		 * @param string|array $others Optional. Defaults to an empty array.
		 *    Any additional classes that should be included.
		 *
		 * @param string       $format Return value format. Defaults to {@link fw_constants::space_sep_string}.
		 *    Can also be set to {@link fw_constants::array_n} (for a numerically indexed array).
		 *
		 * @return string|array UI widget classes.
		 */
		public function ui_widget_classes_plus($others = array(), $format = self::space_sep_string)
		{
			return $this->ui_widget_classes($others, $format);
		}

		/**
		 * Gets stand-alone header for templates.
		 *
		 * @return string Stand-alone header.
		 */
		public function stand_alone_header()
		{
			return $this->©php->evaluate($this->©options->get('templates.stand_alone.header'));
		}

		/**
		 * Gets stand-alone footer for templates.
		 *
		 * @return string Stand-alone footer.
		 */
		public function stand_alone_footer()
		{
			return $this->©php->evaluate($this->©options->get('templates.stand_alone.footer'));
		}

		/**
		 * Gets email header for templates.
		 *
		 * @return string Email header.
		 */
		public function email_header()
		{
			return $this->©php->evaluate($this->©options->get('templates.email.header'));
		}

		/**
		 * Gets email footer for templates.
		 *
		 * @return string Email footer.
		 */
		public function email_footer()
		{
			return $this->©php->evaluate($this->©options->get('templates.email.footer'));
		}

		/**
		 * Should this template display errors?
		 *
		 * @return errors|boolean Errors if this template should display errors.
		 *    Otherwise, this returns a boolean FALSE value.
		 */
		public function has_errors()
		{
			if($this->errors && $this->©errors->exist_in($this->errors))
				return $this->errors; // Yes.

			return FALSE; // Default return value.
		}

		/**
		 * Should this template display successes?
		 *
		 * @return successes|boolean Successes if this template should display successes.
		 *    Otherwise, this returns a boolean FALSE value.
		 */
		public function has_successes()
		{
			if($this->successes && $this->©successes->exist_in($this->successes))
				return $this->successes; // Yes.

			return FALSE; // Default return value.
		}

		/**
		 * Should this template display messages?
		 *
		 * @return messages|boolean Messages if this template should display messages.
		 *    Otherwise, this returns a boolean FALSE value.
		 */
		public function has_messages()
		{
			if($this->messages && $this->©messages->exist_in($this->messages))
				return $this->messages; // Yes.

			return FALSE; // Default return value.
		}

		/**
		 * Should this template display responses?
		 *
		 * @return boolean TRUE if this template should display responses.
		 *    Otherwise, this returns a FALSE value.
		 */
		public function has_responses()
		{
			if($this->has_errors() || $this->has_successes() || $this->has_messages())
				return TRUE; // Yes.

			return FALSE; // Default return value.
		}

		/**
		 * Retrieves all template responses.
		 *
		 * @note This includes errors, successes, messages (when/if they exist).
		 *
		 * @return string Responses (as HTML markup); else an empty string.
		 */
		public function responses()
		{
			$responses = ''; // Initialize responses (as HTML markup).

			if($this->has_errors()) // Do we have errors?
				$responses .= // Errors (as HTML markup). Also w/ a specific icon.
					'<div class="responses errors ui-widget ui-corner-all ui-state-error">'.
					'<ul>'.$this->errors->get_messages_as_list_items('', 0, '<span class="ui-icon ui-icon-alert"></span>').'</ul>'.
					'</div>';

			if($this->has_successes()) // Do we have successes?
				$responses .= // Successes (as HTML markup). Also w/ a specific icon.
					'<div class="responses successes ui-widget ui-corner-all ui-state-highlight">'.
					'<ul>'.$this->successes->get_messages_as_list_items('', 0, '<span class="ui-icon ui-icon-check"></span>').'</ul>'.
					'</div>';

			if($this->has_messages()) // Do we have messages?
				$responses .= // Messages (as HTML markup). Also w/ a specific icon.
					'<div class="responses messages ui-widget ui-corner-all ui-state-highlight">'.
					'<ul>'.$this->messages->get_messages_as_list_items('', 0, '<span class="ui-icon ui-icon-info"></span>').'</ul>'.
					'</div>';

			return $responses; // All types of responses (as HTML markup).
		}

		/**
		 * Parses incoming data (supporting all possible scenarios).
		 *
		 * @param array|object $data Incoming data (passed into object constructor).
		 *
		 * @return object The parsed data object (stored in `$this->data`).
		 */
		protected function parse_data($data)
		{
			$this->check_arg_types(array('array', 'object'), func_get_args());

			if($data && $this->©errors->instance_in($data))
			{
				$this->errors = $data;
				$this->data   = new \stdClass();
				return $this->data; // Object properties.
			}
			if($data && $this->©successes->instance_in($data))
			{
				$this->successes = $data;
				$this->data      = new \stdClass();
				return $this->data; // Object properties.
			}
			if($data && $this->©messages->instance_in($data))
			{
				$this->messages = $data;
				$this->data     = new \stdClass();
				return $this->data; // Object properties.
			}
			$this->data = (object)$data; // Array/object of another type.

			if(property_exists($this->data, 'user'))
				$this->data->user = $this->©user_utils->which($this->data->user);

			if(isset($this->data->errors) && $this->©errors->instance_in($this->data->errors))
				$this->errors = $this->data->errors;

			if(isset($this->data->successes) && $this->©successes->instance_in($this->data->successes))
				$this->successes = $this->data->successes;

			if(isset($this->data->messages) && $this->©messages->instance_in($this->data->messages))
				$this->messages = $this->data->messages;

			return $this->data; // Object properties.
		}

		/**
		 * Parses a template file (returns content).
		 *
		 * @return string The parsed template file content.
		 *    Templates are included w/ PHP `include()`. Output is buffered by this routine.
		 */
		protected function parse_content()
		{
			ob_start();
			require $this->©file->template($this->file);
			return ($this->content = ob_get_clean());
		}

		/**
		 * Parses template configs (returns config array).
		 *
		 * @return object An object with all template configuration properties.
		 *    Also removes `<template-config>` tags from `$this->content`.
		 *
		 * @throws exception If any `<template-config>` tag is corrupt.
		 */
		protected function parse_config()
		{
			$this->config = new \stdClass(); // Standard object class.

			$regex_template_configs         = '/\<template-config[^\>]*\>.*?\<\/template-config\>/is';
			$regex_template_config_comments = '/\<\!\-\- BEGIN\: XML Template Config[^\>]*\>.*?\<\!\-\- \/ END\: XML Template Config \-\-\>/is';

			if($this->content && preg_match_all($regex_template_configs, $this->content, $_template_configs, PREG_SET_ORDER))
			{
				foreach($_template_configs as $_template_config) // Iterates through each `<template-config>` tag.
				{
					$_xml_obj = simplexml_load_string('<?xml version="1.0" encoding="UTF-8" ?>'."\n".
					                                  $_template_config[0], NULL, LIBXML_NOCDATA | LIBXML_NOERROR | LIBXML_NOWARNING);

					/** @var $_xml_obj \SimpleXMLElement We're looking for this specific type of class. */

					if(!$_xml_obj || !($_xml_obj instanceof \SimpleXMLElement)) // XML is corrupt?
						throw $this->©exception(
							$this->method(__FUNCTION__).'#unparsable_xml_config', get_defined_vars(),
							sprintf($this->__('Unparsable XML `<template-config>` in `%1$s`.'), $this->file).
							' '.$this->__('Please be sure to encode XML entities (i.e. special chars).').
							' '.sprintf($this->__('Got: `%1$s`.'), $_template_config)
						);
					if($this->©xml->attribute($_xml_obj, 'file') !== $this->file)
						continue; // It's NOT for this template file.

					foreach($_xml_obj->children() as $_xml_tag)
						if($_xml_tag instanceof \SimpleXMLElement)
							$this->config->{$_xml_tag->getName()} = trim((string)$_xml_tag);
					unset($_xml_tag); // Housekeeping.
				}
				unset($_template_config, $_xml_obj); // Housekeeping.

				$this->content = trim(preg_replace($regex_template_configs, '', $this->content));
				$this->content = trim(preg_replace($regex_template_config_comments, '', $this->content));
			}
			unset($_template_configs); // Some final housekeeping.

			return $this->config; // Object with all configuration properties.
		}

		/**
		 * Regex pattern matching template content body.
		 *
		 * @var string Regex pattern matching template content body.
		 */
		public $regex_template_content_body = '/\<\!\-\-\s+BEGIN\:\s+Content\s+Body\s+\-\-\>\s*(?P<template_content_body>.+?)\s*\<\!\-\-\s+\/\s+END\:\s+Content Body\s+\-\-\>/is';
	}
}