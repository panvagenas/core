/**
 * WebSharks™ Core Scripts.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 *
 * @TODO Finish documenting properties in this file.
 *    Most docBlocks are already in place; but they still need to be filled in.
 *    Several parameters are untyped and undocumented (among other things that are incomplete).
 */

(function($w) // Begin WebSharks™ Core closure.
	{
		'use strict'; // Standards.

		/**
		 * @type {Object} WebSharks™ Core.
		 */
		$w.$$websharks_core = $w.$$websharks_core || {};
		if(typeof $w.$$websharks_core.$ === 'function')
			return; // Core already exists.

		/**
		 * @constructor WebSharks™ Core constructor.
		 */
		$w.$$websharks_core.$ = function(){this.core_constructor.apply(this, arguments);};

		/**
		 * @type {Object} Current instance configuration.
		 */
		$w.$$websharks_core.$.prototype.___instance_config = {};

		/**
		 * Get instance configuration property.
		 *
		 * @param key {String} Key to get.
		 *
		 * @return {String|Array|Object|Number|Boolean}
		 */
		$w.$$websharks_core.$.prototype.get___instance_config = function(key)
			{
				var $$ = this, $ = jQuery;

				if(!$$.empty(typeof $$.___instance_config[key]))
					return $$.___instance_config[key];

				throw $.sprintf($$.get___i18n('get___instance_config__failure'), key);
			};

		/**
		 * @type {Object} Current verifiers.
		 */
		$w.$$websharks_core.$.prototype.___verifiers = {};

		/**
		 * Get string verifier property.
		 *
		 * @param key {String} Key to get.
		 *
		 * @return {String}
		 */
		$w.$$websharks_core.$.prototype.get___verifier = function(key)
			{
				var $$ = this, $ = jQuery;

				if(typeof $$.___verifiers[key] === 'string')
					return $$.___verifiers[key];

				throw $.sprintf($$.get___i18n('get___verifier__failure'), key);
			};

		/**
		 * @type {Object} Current translations.
		 */
		$w.$$websharks_core.$.prototype.___i18n = {};

		/**
		 * Get i18n string translation property.
		 *
		 * @param key {String} Key to get.
		 *
		 * @return {String}
		 */
		$w.$$websharks_core.$.prototype.get___i18n = function(key)
			{
				var $$ = this, $ = jQuery;

				if(typeof $$.___i18n[key] === 'string')
					return $$.___i18n[key];

				throw $.sprintf($$.___i18n['get___i18n__failure'], key);
			};

		/**
		 * @type {Object} All ``is...()`` type checks.
		 */
		$w.$$websharks_core.$.prototype.___is_type_checks = {
			'string'       : 'is_string',
			'!string'      : 'is_string',
			'string:!empty': 'is_string',

			'boolean'       : 'is_boolean',
			'!boolean'      : 'is_boolean',
			'boolean:!empty': 'is_boolean',

			'bool'       : 'is_boolean',
			'!bool'      : 'is_boolean',
			'bool:!empty': 'is_boolean',

			'integer'       : 'is_integer',
			'!integer'      : 'is_integer',
			'integer:!empty': 'is_integer',

			'float'       : 'is_float',
			'!float'      : 'is_float',
			'float:!empty': 'is_float',

			'number'       : 'is_number',
			'!number'      : 'is_number',
			'number:!empty': 'is_number',

			'numeric'       : 'is_numeric',
			'!numeric'      : 'is_numeric',
			'numeric:!empty': 'is_numeric',

			'array'       : 'is_array',
			'!array'      : 'is_array',
			'array:!empty': 'is_array',

			'function'       : 'is_function',
			'!function'      : 'is_function',
			'function:!empty': 'is_function',

			'xml'       : 'is_xml',
			'!xml'      : 'is_xml',
			'xml:!empty': 'is_xml',

			'object'       : 'is_object',
			'!object'      : 'is_object',
			'object:!empty': 'is_object',

			'null'       : 'is_null',
			'!null'      : 'is_null',
			'null:!empty': 'is_null',

			'undefined'       : 'is_undefined',
			'!undefined'      : 'is_undefined',
			'undefined:!empty': 'is_undefined'
		};

		/**
		 * @type {String} Represents a `public` type.
		 */
		$w.$$websharks_core.$.prototype.___public_type = '___public_type';

		/**
		 * @type {String} Represents a `protected` type.
		 */
		$w.$$websharks_core.$.prototype.___protected_type = '___protected_type';

		/**
		 * @type {String} Represents a `private` type.
		 */
		$w.$$websharks_core.$.prototype.___private_type = '___private_type';

		/**
		 * WebSharks™ Core constructor.
		 *
		 * @note This is called by the WebSharks™ Core constructor.
		 *    It sets up dynamic property values available only at runtime.
		 *
		 * @param plugin_root_ns_stub {String} Optional plugin root namespace stub.
		 * @param extension {String} Optional plugin extension name (if creating new extensions).
		 */
		$w.$$websharks_core.$.prototype.core_constructor = function(plugin_root_ns_stub, extension)
			{
				var $$ = this, $ = jQuery, core_ns_stub = 'websharks_core';

				$$.check_arg_types('string', 'string', arguments, 0);

				// Set dynamic ``___i18n`` property.

				$$.___i18n = $.extend({}, $w['$' + core_ns_stub + '___i18n'], $$.___i18n);

				if(!$$.empty(plugin_root_ns_stub) && typeof $w['$' + plugin_root_ns_stub + '___i18n'] === 'object')
					$.extend($$.___i18n, $w['$' + plugin_root_ns_stub + '___i18n']);

				if(!$$.empty(plugin_root_ns_stub, extension) && typeof $w['$' + plugin_root_ns_stub + '__' + extension + '___i18n'] === 'object')
					$.extend($$.___i18n, $w['$' + plugin_root_ns_stub + '__' + extension + '___i18n']);

				// Set dynamic ``___instance_config`` property.

				$$.___instance_config = $w['$' + core_ns_stub + '__current_plugin___instance_config'];

				if(!$$.empty(plugin_root_ns_stub) && typeof $w['$' + plugin_root_ns_stub + '___instance_config'] === 'object')
					$$.___instance_config = $w['$' + plugin_root_ns_stub + '___instance_config'];

				// Set dynamic ``___verifiers`` property.

				$$.___verifiers = $w['$' + core_ns_stub + '__current_plugin___verifiers'];

				if(!$$.empty(plugin_root_ns_stub) && typeof $w['$' + plugin_root_ns_stub + '___verifiers'] === 'object')
					$$.___verifiers = $w['$' + plugin_root_ns_stub + '___verifiers'];
			};

		/**
		 * Test for string type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_string = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'string');
			};

		/**
		 * Test for boolean type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_boolean = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'boolean');
			};

		/**
		 * Test for integer type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_integer = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'number' && String(v).indexOf('.') === -1);
			};

		/**
		 * Test for float type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_float = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'number' && String(v).indexOf('.') !== -1);
			};

		/**
		 * Test for number type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_number = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'number');
			};

		/**
		 * Test for numeric type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_numeric = function(v)
			{
				var $$ = this, $ = jQuery;

				return ((typeof(v) === 'number' || typeof(v) === 'string') && v !== '' && !isNaN(v));
			};

		/**
		 * Test for array type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_array = function(v)
			{
				var $$ = this, $ = jQuery;

				return (v instanceof Array);
			};

		/**
		 * Test for function type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_function = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'function');
			};

		/**
		 * Test for XML type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_xml = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'xml');
			};

		/**
		 * Test for object type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_object = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'object');
			};

		/**
		 * Test for NULL type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_null = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'null');
			};

		/**
		 * Test for undefined type.
		 *
		 * @param v
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_undefined = function(v)
			{
				var $$ = this, $ = jQuery;

				return (typeof v === 'undefined');
			};

		/**
		 * Is a value set?
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.isset = function()
			{
				var $$ = this, $ = jQuery;

				var undefinedVar;

				for(var _i = 0; _i < arguments.length; _i++)
					if(arguments[_i] === undefinedVar || arguments[_i] === null)
						return false;

				return true;
			};

		/**
		 * Is a value empty?
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.empty = function()
			{
				var $$ = this, $ = jQuery;

				empty: // Main iteration loop.
					for(var _i = 0, _p; _i < arguments.length; _i++)
						{
							if(arguments[_i] === '' || arguments[_i] === 0 || arguments[_i] === '0' || arguments[_i] === null || arguments[_i] === false)
								return true;

							else if(typeof arguments[_i] === 'undefined')
								return true;

							else if(arguments[_i] instanceof Array && !arguments[_i].length)
								return true;

							else if(typeof arguments[_i] == 'object')
								{
									for(_p in arguments[_i])
										continue empty;
									return true;
								}
						}
				return false;
			};

		/**
		 * Quotes regex meta characters.
		 *
		 * @param string
		 * @param delimiter
		 *
		 * @return {String}
		 */
		$w.$$websharks_core.$.prototype.preg_quote = function(string, delimiter)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string', 'string', arguments, 1);

				delimiter = !$$.empty(delimiter) ? delimiter : ''; // Force string value.

				var metaChars = ['.', '\\', '+', '*', '?', '[', '^', ']', '$', '(', ')', '{', '}', '=', '!', '<', '>', '|', ':', '-'];
				var regex = new RegExp('([\\' + metaChars.join('\\') + delimiter + '])', 'g');

				return string.replace(regex, '\\$1');
			};

		/**
		 * Escapes HTML special chars.
		 *
		 * @param string
		 *
		 * @return {String}
		 */
		$w.$$websharks_core.$.prototype.esc_html = $w.$$websharks_core.$.prototype.esc_attr = function(string)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string', arguments, 1);

				if(string.match(/[&<>"']/))
					{
						string = string.replace(/&/g, '&amp;');
						string = string.replace(/</g, '&lt;').replace(/>/g, '&gt;');
						string = string.replace(/"/g, '&quot;').replace(/'/g, '&#039;');
					}
				return string;
			};

		/**
		 * Escapes variables for use in jQuery™ attribute selectors.
		 *
		 * @param string
		 *
		 * @return {String}
		 */
		$w.$$websharks_core.$.prototype.esc_jquery_attr = function(string)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string', arguments, 1);

				return string.replace(/([.:\[\]])/g, '\\$1');
			};

		/**
		 * Gets the WebSharks™ Core CSS class name.
		 *
		 * @return {String} CSS class name.
		 */
		$w.$$websharks_core.$.prototype.core_css_class = function()
			{
				var $$ = this, $ = jQuery;

				return $$.get___instance_config('core_ns_stub_with_dashes');
			};

		/**
		 * Gets the plugin CSS class name (for current plugin).
		 *
		 * @return {String} CSS class name.
		 */
		$w.$$websharks_core.$.prototype.plugin_css_class = function()
			{
				var $$ = this, $ = jQuery;

				return $$.get___instance_config('plugin_root_ns_stub_with_dashes');
			};

		/**
		 * Gets closest UI theme CSS class (for current plugin).
		 *
		 * @note The search begins with ``to`` (and may also end at ``to``, if it contains a theme CSS class).
		 *    The search continues with jQuery™ ``parents()``; the search will fail if no parents have a UI theme class.
		 *
		 * @return {String} CSS class name.
		 */
		$w.$$websharks_core.$.prototype.closest_ui_theme_css_class_to = function(obj, include_ui_class)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('object', 'boolean', arguments, 1);

				var theme_css_class = ''; // Initialize string.

				$(obj).add($(obj).parents('.' + $$.plugin_css_class() + '.ui'))
					.each(function() // Begin iterations (we have two here).
					      {
						      var classes = $(this).attr('class');

						      $.each(classes.split(/\s+/), function(_i, _class)
						      {
							      if(_class.indexOf('ui-theme-') === 0)
								      {
									      theme_css_class = _class;
									      return false; // Breaks loop.
								      }
							      return true; // Default return value.
						      });
						      if(!$$.empty(theme_css_class))
							      return false; // Breaks loop.

						      return true; // Default return value.
					      });
				if(!$$.empty(theme_css_class))
					return (include_ui_class) ? 'ui ' + theme_css_class : theme_css_class;

				return ''; // Default return value.
			};

		/**
		 * Gets UI dialogue classes for an object (space separated).
		 *
		 * @note The `ui` class will ONLY be included, if we find a CSS theme class.
		 *    This is the intended behavior. If there is no UI theme, we exclude the `ui` class.
		 *
		 * @note The UI classes that we construct here, have a reaching impact on:
		 *    ``$$.wrap_problematic_ui_theme_components()``.
		 *
		 * @return {String}
		 */
		$w.$$websharks_core.$.prototype.ui_dialogue_classes_for = function(obj)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('object', arguments, 1);

				return $.trim($$.core_css_class() + ' ' + $$.plugin_css_class() + ' ' + $$.closest_ui_theme_css_class_to(obj, true));
			};

		/**
		 * Wraps up problematic jQuery™ UI components (i.e. dialogues and overlays).
		 */
		$w.$$websharks_core.$.prototype.wrap_problematic_ui_theme_components = function()
			{
				var $$ = this, $ = jQuery;

				$('.' + $$.plugin_css_class() + '.ui.ui-dialog')
					.each(function() // Iterate dialogues.
					      {
						      var $this = $(this),
							      wrapper_classes = [
								      $$.core_css_class(),
								      $$.plugin_css_class(),
								      'ui', // WebSharks™ Core UI enabler.
								      $$.closest_ui_theme_css_class_to($this),
								      // ^ We get a UI theme class from ``$this``.
								      $$.plugin_css_class() + '-ui-wrapper'
							      ];
						      var wrapper = '<div class="' + $$.esc_attr(wrapper_classes.join(' ')) + '"></div>';

						      $(this).wrap(wrapper)
							      .bind('dialogopen', function()
							            {
								            $('.ui-widget-overlay').wrap(wrapper);
							            })
							      .bind('dialogclose', function()
							            {
								            $('.' + wrapper_classes.join('.') + ':empty').remove();
							            });
					      });
			};

		/**
		 * Prepares jQuery™ UI forms.
		 */
		$w.$$websharks_core.$.prototype.prepare_ui_forms = function()
			{
				var $$ = this, $ = jQuery;

				var ui_form = '.' + $$.plugin_css_class() + ' form.ui-form';

				// Attach focus handlers to form field containers.

				$(ui_form + ' .ui-form-field-container')
					.focusin(function()
					         {
						         $(this)
							         .addClass('ui-state-highlight')
							         .removeClass('ui-state-default');
					         })
					.focusout(function()
					          {
						          $(this)
							          .addClass('ui-state-default')
							          .removeClass('ui-state-highlight');
					          });

				// Buttonize `input|button` `type="submit|reset|button"` elements.

				$(ui_form + ' input[type="submit"], ' + ui_form + ' input[type="reset"], ' + ui_form + ' input[type="button"], ' +
				  ui_form + ' button[type="submit"], ' + ui_form + ' button[type="reset"], ' + ui_form + ' button[type="button"]')
					.button({icons: {primary: 'ui-icon-grip-dotted-vertical', secondary: 'ui-icon-grip-dotted-vertical'}});

				// Chrome & Safari autofills.

				if($.browser.webkit) // Chrome & Safari autofills.
					{
						var autofill = {interval_time: 100, intervals: 0, max_intervals: 50};

						autofill.interval = setInterval((autofill.handler = function()
							{
								autofill.intervals++; // Increments counter.

								if((!('fields' in autofill) || !autofill.fields.length)
									&& (autofill.fields = $(ui_form + ' input:-webkit-autofill')).length)
									{
										clearInterval(autofill.interval);
										autofill.fields.each(function() // Replace.
										                     {
											                     var $this = $(this);
											                     var clone = $this.clone(true);
											                     $this.after(clone).remove();
										                     });
									}
								if(autofill.intervals > autofill.max_intervals)
									clearInterval(autofill.interval);

							}), autofill.interval_time);

						setTimeout(autofill.handler, 50);
					}

				// Password strength/mismatch indicators.

				var password_strength_mismatch_status = function(password1, password2)
					{
						$$.check_arg_types('string', 'string', arguments, 2);

						var score = 0; // Initialize score.

						if((password1 != password2) && password2.length > 0)
							return 'mismatch';
						else if(password1.length < 1)
							return 'empty';
						else if(password1.length < 6)
							return 'short';

						if(password1.match(/[0-9]/))
							score += 10;
						if(password1.match(/[a-z]/))
							score += 10;
						if(password1.match(/[A-Z]/))
							score += 10;
						if(password1.match(/[^0-9a-zA-Z]/))
							score = (score === 30) ? score + 20 : score + 10;

						if(score < 30) return 'weak';
						if(score < 50) return 'good';

						return 'strong'; // Default return value.
					};

				$(ui_form + ' .ui-form-field.ui-form-field-type-password.ui-form-field-confirm')
					.each(function() // Handles password strength/mismatch indicators.
					      {
						      var $field1 = $(this), $field2 = $field1.next('.ui-form-field.ui-form-field-type-password');
						      var $field_container1 = $('.ui-form-field-container', $field1), $field_container2 = $('.ui-form-field-container', $field2);
						      var $password1 = $('input[type="password"]', $field_container1), $password2 = $('input[type="password"]', $field_container2);

						      var strength_mismatch_indicator_classes = ['ui-form-field-strength-mismatch-indicator', 'ui-widget', 'ui-widget-content', 'ui-corner-all'];
						      $field_container2.after('<div class="' + strength_mismatch_indicator_classes.join(' ') + '"></div>'); // Adds the indicator.
						      var $strength_mismatch_indicator = $('.' + strength_mismatch_indicator_classes.join('.'), $field2);

						      $password1.add($password2)
							      .keyup(function() // Handles `keyup` events.
							             {
								             var strength_mismatch_status = password_strength_mismatch_status($.trim(String($password1.val())), $.trim(String($password2.val())));
								             $strength_mismatch_indicator.attr('class', strength_mismatch_indicator_classes.join(' ') + ' ' + strength_mismatch_status)
									             .html($$.get___i18n('password_strength_mismatch_status__' + strength_mismatch_status));
							             }).trigger('keyup');
					      });

				// Form field validation.

				$(ui_form)// Convert response errors for each form, into form field validation-errors.
					.each(function() // Iteration over each UI form (one at a time).
					      {
						      var $form = $(this), $response_errors = $form.prevAll('.responses.errors');

						      $('ul li[data-form-field-code]', $response_errors)// Only those w/ a form-field-code.
							      .each(function() // Iterate over each error that includes a form-field-code.
							            {
								            var $this = $(this), form_field_code, $input, $response_validation_errors;

								            if($$.empty(form_field_code = $this.attr('data-form-field-code')))
									            return; // No code for this error (continue loop).

								            if(!($input = $(':input[name="' + $$.esc_jquery_attr(form_field_code) + '"],' +
								                            ' :input[name$="' + $$.esc_jquery_attr('[' + form_field_code + ']') + '"],' +
								                            ' :input[name$="' + $$.esc_jquery_attr('[' + form_field_code + '][]') + '"]',
								                            $form).first()).length) // First in this form.
									            return; // Unable to locate form field w/ code.

								            if(($response_validation_errors = $('.response.validation-errors', $input.closest('.ui-form-field'))).length)
									            {
										            $this.clone().appendTo($('ul', $response_validation_errors));
										            $this.remove(); // Remove original error.
									            }
								            else // We need to create a new set of response validation errors (none exist yet).
									            {
										            $response_validation_errors = $(// Creates validation errors.
											            '<div class="responses validation-errors ui-widget ui-corner-bottom ui-state-error">' +
											            '<ul></ul>' + // Empty here (we'll append ``$this`` error below).
											            '</div>'
										            );
										            $this.clone().appendTo($('ul', $response_validation_errors));
										            $this.remove(); // Remove original error.

										            $input.closest('.ui-form-field-container').after($response_validation_errors)
											            // If it's inside an accordion, let's make sure the accordion is open.
											            .closest('.ui-accordion-content').prev('.ui-accordion-header.ui-state-default').click();
									            }
							            });
						      if($('ul:empty', $response_errors).length) // Don't leave completely empty.
							      $('ul', $response_errors).append('<li><span class="ui-icon ui-icon-alert"></span>'
								                                       + $$.get___i18n('validate_ui_form__check_issues_below') + '</li>');
					      });
				$(ui_form).attr({'novalidate': 'novalidate'})// Disables HTML 5 validation via browser.
					.submit(function() // This uses our own form field validation handler instead of the browser's.
					        {
						        return $$.validate_ui_form(this);
					        });
			};

		/**
		 * Validates form fields.
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.validate_ui_form = function(context)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('object', arguments, 1);

				var errors = {}, errors_exist = false, $id = null, scroll_to_errors = true;

				$('div.validation-errors', context).remove(); // Remove any existing errors.

				$('.ui-form-field.ui-form-field-confirm', context)// Validation routine (for field confirmations).
					.each(function() // Checks form fields that request user confirmation (e.g. we look for mismatched fields).
					      {
						      var $field1 = $(':input', this);
						      var $field2 = $(':input', $(this).next('.ui-form-field'));

						      if(!$$.empty($field1.attr('disabled')) || !$$.empty($field2.attr('disabled')))
							      return; // One of these is NOT even enabled (do nothing in this case).

						      var id = $field1.attr('id');
						      if($$.empty(id) || !$$.is_string(id))
							      return; // Must have an ID.

						      var field1_value = $field1.val(); // Possible array.
						      if($$.is_string(field1_value)) field1_value = $.trim(field1_value);

						      var field2_value = $field2.val(); // Possible array.
						      if($$.is_string(field2_value)) field2_value = $.trim(field2_value);

						      if(field1_value !== field2_value)
							      {
								      errors[id] = errors[id] || [];
								      errors[id].push($$.get___i18n('validate_ui_form__mismatch_fields'));
							      }
					      });

				$(':input[data-required]', context)// Validation routine (for required fields).
					.each(function() // Checks each `data-required` form field (some tag names are handled differently).
					      {
						      var $this = $(this); // jQuery object instance.

						      if(!$$.empty($this.attr('disabled')))
							      return; // It's NOT even enabled.

						      var value = $this.val(); // Possible array.
						      if($$.is_string(value)) value = $.trim(value);

						      var id = $this.attr('id');
						      if($$.empty(id) || !$$.is_string(id))
							      return; // Must have an ID.

						      var name = $this.attr('name');
						      if($$.empty(name) || !$$.is_string(name))
							      return; // Must have a name.

						      var tag_name = $this.prop('tagName');
						      if($$.empty(tag_name) || !$$.is_string(tag_name))
							      return; // Must have a tag name.
						      else tag_name = tag_name.toLowerCase();

						      var type = $this.attr('type'); // May need this below (for input tags).
						      if(tag_name === 'input') // Must have a type for input tags.
							      if($$.empty(type) || !$$.is_string(type))
								      return; // Must have a type.
							      else type = type.toLowerCase();

						      var checked, validation_minimum; // Might need these.

						      switch(tag_name/* Some tag names are handled a bit differently here. */)
						      {
							      case 'select': // We also check for multiple selections here.

								      if($this.attr('multiple')) // Allows multiple selections?
									      {
										      validation_minimum = $this.attr('data-validation-minimum-0');
										      validation_minimum = ($$.is_numeric(validation_minimum)) ? Number(validation_minimum) : null;

										      if($$.isset(validation_minimum) && validation_minimum > 1)
											      {
												      if(!$$.is_array(value) || value.length < validation_minimum)
													      {
														      errors[id] = errors[id] || [];
														      errors[id].push($.sprintf($$.get___i18n('validate_ui_form__required_select_at_least'), validation_minimum));
													      }
											      }
										      else if(!$$.is_array(value) || value.length < 1)
											      {
												      errors[id] = errors[id] || [];
												      errors[id].push($$.get___i18n('validate_ui_form__required_select_at_least_one'));
											      }
									      }
								      else if(!$$.is_string(value) || value.length < 1)
									      {
										      errors[id] = errors[id] || [];
										      errors[id].push($$.get___i18n('validate_ui_form__required_field'));
									      }
								      break; // Break switch handler.

							      case 'input': // We also check for multiple radios/checkboxes.

								      if($.inArray(type, ['radio', 'checkbox']) !== -1)
									      {
										      id = id.replace(/\-\-\-[0-9]+$/, ''); // Strip possible radio/checkbox key.

										      checked = $('input[id^="' + $$.esc_jquery_attr(id) + '"]:checked', context).length;

										      if(type === 'radio') // Radios are easy.
											      {
												      if(checked > 0) // We only need ONE radio check.
													      return; // At least one radio is checked (we're OK here).

												      else // Only one error for each radio group.
													      {
														      errors[id] = errors[id] || [];

														      if(!$$.empty(errors[id]))
															      return; // Only one error.

														      errors[id].push($$.get___i18n('validate_ui_form__required_radio'));
													      }
											      }
										      else if($('input[id^="' + $$.esc_jquery_attr(id) + '"]', context).length > 1)
											      {
												      validation_minimum = $this.attr('data-validation-minimum-0');
												      validation_minimum = ($$.isset(validation_minimum)) ? Number(validation_minimum) : null;

												      if($$.isset(validation_minimum) && validation_minimum > 1)
													      {
														      if(checked < validation_minimum)
															      {
																      errors[id] = errors[id] || [];

																      if(!$$.empty(errors[id]))
																	      return; // Only one error.

																      errors[id].push($.sprintf($$.get___i18n('validate_ui_form__required_check_at_least'), validation_minimum));
															      }
													      }
												      else if(checked < 1)
													      {
														      errors[id] = errors[id] || [];

														      if(!$$.empty(errors[id]))
															      return; // Only one error.

														      errors[id].push($$.get___i18n('validate_ui_form__required_check_at_least_one'));
													      }
											      }
										      else if(checked < 1)
											      {
												      errors[id] = errors[id] || [];
												      errors[id].push($$.get___i18n('validate_ui_form__required_checkbox'));
											      }
									      }
								      else if(!$$.is_string(value) || value.length < 1)
									      {
										      errors[id] = errors[id] || [];
										      errors[id].push($$.get___i18n('validate_ui_form__required_field'));
									      }
								      break; // Break switch handler.

							      default: // Everything else (including file/textarea fields).

								      if(!$$.is_string(value) || value.length < 1)
									      {
										      errors[id] = errors[id] || [];
										      errors[id].push($$.get___i18n('validate_ui_form__required_field'));
									      }
								      break; // Break switch handler.
						      }
					      });

				$(':input[data-validation-name-0]', context)// Validation (for data requirements).
					.each(function() // Checks each form field for attributes `data-requirements-name-[n]`.
					      {
						      var $this = $(this); // jQuery object instance.

						      if(!$$.empty($this.attr('disabled')))
							      return; // It's NOT even enabled.

						      var value = $this.val(); // Possible array.
						      if($$.is_string(value)) value = $.trim(value);

						      if(!value.length && !$$.isset($this.attr('data-required')))
						      // In this case, data requirements are ignored (value is empty).
							      return; // NOT required (and value is currently empty).

						      var id = $this.attr('id');
						      if($$.empty(id) || !$$.is_string(id))
							      return; // Must have an ID.

						      var name = $this.attr('name');
						      if($$.empty(name) || !$$.is_string(name))
							      return; // Must have a name.

						      var tag_name = $this.prop('tagName');
						      if($$.empty(tag_name) || !$$.is_string(tag_name))
							      return; // Must have a tag name.
						      else tag_name = tag_name.toLowerCase();

						      var type = $this.attr('type'); // May need this below (for input tags).
						      if(tag_name === 'input') // Must have a type for input tags.
							      if($$.empty(type) || !$$.is_string(type))
								      return; // Must have a type.
							      else type = type.toLowerCase();

						      if($.inArray(tag_name, ['select']) !== -1)
							      return; // Exclude (these have preset option value lists).

						      if($.inArray(type, ['radio', 'checkbox']) !== -1)
							      return; // Exclude (these have checked/preset values).

						      var validation_description_prefix, validation_name, validation_regex;
						      var validation_minimum, validation_maximum, validation_description;
						      var regex_begin, regex_end, regex_pattern, regex_flags, regex;

						      for(var _validation_errors = [], _i = 0; _i <= 24; _i++)
							      {
								      validation_name = $this.attr('data-validation-name-' + _i);
								      if($$.empty(validation_name) || !$$.is_string(validation_name))
									      continue; // Must have a validation name.

								      validation_regex = $this.attr('data-validation-regex-' + _i);
								      if($$.empty(validation_regex) || !$$.is_string(validation_regex))
									      continue; // Must have a regex validation pattern.

								      validation_minimum = $this.attr('data-validation-minimum-' + _i);
								      validation_minimum = ($$.isset(validation_minimum)) ? Number(validation_minimum) : null;

								      validation_maximum = $this.attr('data-validation-maximum-' + _i);
								      validation_maximum = ($$.isset(validation_maximum)) ? Number(validation_maximum) : null;

								      validation_description = $this.attr('data-validation-description-' + _i);
								      if($$.empty(validation_description) || !$$.is_string(validation_description))
									      continue; // Must have a validation description.

								      regex_begin = validation_regex.indexOf('/');
								      regex_end = validation_regex.lastIndexOf('/');

								      if(regex_begin === 0 && regex_end > 0)
									      {
										      regex_pattern = validation_regex.substr(regex_begin + 1, regex_end - 1);
										      regex_flags = validation_regex.substr(regex_end + 1);
										      regex = new RegExp(regex_pattern, regex_flags);
									      }
								      else continue; // We do NOT have a regex validation pattern.

								      if(_validation_errors.length)
									      validation_description_prefix = $$.get___i18n('validate_ui_form__or_validation_description_prefix');
								      else validation_description_prefix = $$.get___i18n('validate_ui_form__validation_description_prefix');

								      if(!$$.is_string(value) || !value.match(regex))
									      _validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

								      else if($.inArray(validation_name, ['integer', 'float', 'numeric']) !== -1)
									      {
										      if($$.isset(validation_minimum) && (!$$.is_string(value) || !value.length || isNaN(value) || Number(value) < validation_minimum))
											      _validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

										      else if($$.isset(validation_maximum) && (!$$.is_string(value) || !value.length || isNaN(value) || Number(value) > validation_maximum))
											      _validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
									      }
								      else // We interpret minimum/maximum as character lengths.
									      {
										      if($$.isset(validation_minimum) && (!$$.is_string(value) || value.length < validation_minimum))
											      _validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

										      else if($$.isset(validation_maximum) && (!$$.is_string(value) || value.length > validation_maximum))
											      _validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
									      }
								      if(!$$.isset(typeof _validation_errors[_i])) // Only need to pass ONE validation pattern.
									      _validation_errors = []; // If this one passes, it negates all existing validation errors.
							      }
						      if(_validation_errors.length)
							      {
								      errors[id] = errors[id] || [];
								      errors[id] = errors[id].concat(_validation_errors);
							      }
					      });

				for(var id in errors) // Scan all errors.
					{
						if(errors.hasOwnProperty(id) && errors[id].length > 0)
							{
								errors_exist = true;

								$id = $('#' + id, context);
								if(!$id.length) // Radios/checkboxes?
									$id = $('#' + id + '-0', context);

								if(!$$.empty(scroll_to_errors))
									{
										$.scrollTo($id, {offset: {top: -50, left: 0}, duration: 500});
										scroll_to_errors = false; // Done (no need to do it again).
									}
								$id.closest('.ui-form-field-container').after(
										'<div class="responses validation-errors ui-widget ui-corner-bottom ui-state-error">' +
										'<ul>' + // Includes an error icon prefix, for each list item we display.

										'<li><span class="ui-icon ui-icon-alert"></span>' +
										errors[id].join('</li><li><span class="ui-icon ui-icon-alert"></span>') +
										'</li>' +

										'</ul>' +
										'</div>'
									)// If it's inside an accordion, let's make sure the accordion is open.
									.closest('.ui-accordion-content').prev('.ui-accordion-header.ui-state-default').click();
							}
					}
				if(errors_exist) // Do NOT submit this form yet (errors exist).
					return false; // Stops form from being submitted here.

				return true; // Default return value.
			};

		/**
		 * Gets a query string variable value.
		 *
		 * @param query_var
		 *
		 * @return {String}
		 */
		$w.$$websharks_core.$.prototype.get_query_var = function(query_var)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string:!empty', arguments, 1);

				var qs_pairs = [];

				if(location.hash.substr(0, 2) === '#!')
					qs_pairs = qs_pairs.concat(location.hash.substr(2).split('&'));

				qs_pairs = qs_pairs.concat(location.search.substr(1).split('&'));

				for(var _i = 0, _qs_pair; _i < qs_pairs.length; _i++)
					{
						_qs_pair = qs_pairs[_i].split('=', 2);
						if(_qs_pair.length === 2 && decodeURIComponent(_qs_pair[0]) === query_var)
							return $.trim(decodeURIComponent(_qs_pair[1].replace(/\+/g, ' ')));
					}
				return '';
			};

		/**
		 * Test for WordPress® administrative areas.
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_admin = function()
			{
				var $$ = this, $ = jQuery;

				return location.href.match(/\/wp-admin(?:\/|\?|$)/)
					? true : false;
			};

		/**
		 * Is this a WordPress® menu page, for the current plugin?
		 *
		 * @param slug_s
		 *
		 * @return {String|Boolean}
		 */
		$w.$$websharks_core.$.prototype.is_plugin_menu_page = function(slug_s)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types(['string', 'array'], arguments, 0);

				var current_page, _matches, _page_slug;
				var regex = new RegExp('^' + $$.preg_quote($$.get___instance_config('plugin_root_ns_stub')) + '(?:__(.+))?$');

				if($$.is_admin() && !$$.empty(current_page = $$.get_query_var('page')))
					{
						if((_matches = regex.exec(current_page)).length) // A plugin menu page?
							{
								_page_slug = (_matches.length >= 2 && !$$.empty(_matches[1]))
									? _matches[1] : $$.get___instance_config('plugin_root_ns_stub');

								if($$.empty(slug_s)) // Nothing in particular?
									return _page_slug;

								else if($$.is_string(slug_s) && _page_slug === slug_s)
									return _page_slug;

								else if($$.is_array(slug_s) && $.inArray(_page_slug, slug_s))
									return _page_slug;
							}
					}
				return false;
			};

		/**
		 * Selects a DOM element.
		 *
		 * @param str_obj
		 */
		$w.$$websharks_core.$.prototype.select_all = function(str_obj)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types(['string:!empty', 'object'], arguments, 1);

				var obj = $(str_obj).get(0), range, selection;

				if(obj && document.implementation.hasFeature('Range', '2.0'))
					{
						selection = $w.getSelection();
						selection.removeAllRanges();

						range = document.createRange();
						range.selectNodeContents(obj);
						selection.addRange(range);

						return; // All done.
					}
				// Support for older browsers.
				var body = document.getElementsByTagName('body')[0];
				if(obj && typeof body.createTextRange === 'function')
					{
						range = body.createTextRange();
						range.moveToElementText(obj);
						range.select();
					}
			};

		/**
		 * Opens source code for a DOM element, in a new window.
		 *
		 * @param str_obj
		 */
		$w.$$websharks_core.$.prototype.view_source = function(str_obj)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types(['string:!empty', 'object'], arguments, 1);

				var $obj = $(str_obj), win, source, css = '* { list-style:none; font-size:12px; font-family:"Consolas",monospace; }';

				if((win = $$.win_open('', 750, 500)) && (source = win.document) && source.open())
					{
						source.write('<!DOCTYPE html>');
						source.write('<html>');

						source.write('<head>');
						source.write('<title>' + $$.get___i18n('view_source__doc_title') + '</title>');
						source.write('<style type="text/css" media="screen,print">' + css + '</style>');
						source.write('</head>');

						source.write('<body><pre>' + $obj.html() + '</pre></body>');

						source.write('</html>');

						source.close(), win.blur(), win.focus();
					}
			};

		/**
		 * Opens a new window.
		 *
		 * @param url
		 * @param width
		 * @param height
		 * @param name
		 *
		 * @return {Object}
		 */
		$w.$$websharks_core.$.prototype.win_open = function(url, width, height, name)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string', 'integer', 'integer', 'string', arguments, 1);

				width = (!$$.empty(width)) ? width : 1000, height = (!$$.empty(height)) ? height : 700, name = (!$$.empty(name)) ? name : '_win_open';
				var win, params = 'scrollbars=yes,resizable=yes,centerscreen=yes,modal=yes,width=' + width + ',height=' + height + ',top=' + ((screen.height - height) / 2) + ',screenY=' + ((screen.height - height) / 2) + ',left=' + ((screen.width - width) / 2) + ',screenX=' + ((screen.width - width) / 2);

				if(!(win = $w.open(url, name, params)))
					alert($$.get___i18n('win_open__turn_off_popup_blockers'));
				else win.focus();

				return win; // Window handle.
			};

		/**
		 * PHP equivalent of ``mt_rand()``.
		 *
		 * @param min
		 * @param max
		 *
		 * @return {Number}
		 */
		$w.$$websharks_core.$.prototype.mt_rand = function(min, max)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('integer', 'integer', arguments, 0);

				min = ($$.isset(min)) ? min : 0;
				max = ($$.isset(max)) ? max : 2147483647;

				return Math.floor(Math.random() * (max - min + 1)) + min;
			};

		/**
		 * Adds a query string argument onto a URL.
		 *
		 * @param name
		 * @param value
		 * @param url
		 *
		 * @return {String}
		 */
		$w.$$websharks_core.$.prototype.add_query_arg = function(name, value, url)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string:!empty', 'string', 'string', arguments, 3);

				url += (url.indexOf('?') === -1) ? '?' : '&';
				url += encodeURIComponent(name) + '=' + encodeURIComponent(value);

				return url;
			};

		/**
		 * Gets verifier for an AJAX action call.
		 *
		 * @param call
		 * @param type
		 *
		 * @return {String}
		 */
		$w.$$websharks_core.$.prototype.get_call_verifier = function(call, type)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string:!empty', 'string:!empty', arguments, 2);

				return $$.get___verifier(type + '::' + call);
			};

		/**
		 * Makes an AJAX call.
		 *
		 * @param method
		 * @param call
		 * @param type
		 * @param args
		 * @param ajax
		 */
		$w.$$websharks_core.$.prototype.ajax = function(method, call, type, args, ajax)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string:!empty', 'string:!empty', 'string:!empty', 'array', 'object', arguments, 3);

				var url = $$.get___instance_config('wp_load_url');
				var plugin_var_ns = $$.get___instance_config('plugin_var_ns');

				ajax = (!$$.empty(ajax)) ? ajax : {};
				ajax.type = method, ajax.url = url, ajax.data = {};

				ajax.data[plugin_var_ns + '[a][s]'] = 'ajax';
				ajax.data[plugin_var_ns + '[a][c]'] = call;
				ajax.data[plugin_var_ns + '[a][t]'] = type;
				ajax.data[plugin_var_ns + '[a][v]'] = $$.get_call_verifier(call, type);

				if(!$$.empty(args)) ajax.data[plugin_var_ns + '[a][a]'] = $.toJSON(args);

				$.ajax(ajax);
			};

		/**
		 * Makes an AJAX call via the GET method.
		 *
		 * @param call
		 * @param type
		 * @param args
		 * @param ajax
		 */
		$w.$$websharks_core.$.prototype.get = function(call, type, args, ajax)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string:!empty', 'string:!empty', 'array', 'object', arguments, 2);

				var _arguments = $.makeArray(arguments);
				_arguments.unshift('GET'), $$.ajax.apply($$, _arguments);
			};

		/**
		 * Makes an AJAX call via the POST method.
		 *
		 * @param call
		 * @param type
		 * @param args
		 * @param ajax
		 */
		$w.$$websharks_core.$.prototype.post = function(call, type, args, ajax)
			{
				var $$ = this, $ = jQuery;

				$$.check_arg_types('string:!empty', 'string:!empty', 'array', 'object', arguments, 2);

				var _arguments = $.makeArray(arguments);
				_arguments.unshift('POST'), $$.ajax.apply($$, _arguments);
			};

		/**
		 * Checks argument types.
		 *
		 * @return {Boolean}
		 */
		$w.$$websharks_core.$.prototype.check_arg_types = function()
			{
				var $$ = this, $ = jQuery;

				var _arg_type_hints__args__required_args = $.makeArray(arguments);

				var required_args = Number(_arg_type_hints__args__required_args.pop());
				var args = $.makeArray(_arg_type_hints__args__required_args.pop());

				// noinspection UnnecessaryLocalVariableJS
				var arg_type_hints = _arg_type_hints__args__required_args;

				var total_args = args.length;
				var total_arg_positions = total_args - 1;

				var _arg_position, _arg_type_hints;
				var _arg_types, _arg_type_key, _last_arg_type_key, _arg_type, is_;
				var problem, position, caller, types, empty, type_given;

				if(total_args < required_args)
					{
						caller = $$.get___i18n('check_arg_types__caller'); // Generic.
						// caller = arguments.callee.caller.name; not possible in strict mode.
						throw $.sprintf($$.get___i18n('check_arg_types__missing_args'), caller, required_args, total_args);
					}
				else if(total_args === 0) // No arguments (no problem).
					return true; // We can stop right here in this case.

				main_loop: // Marker for main loop (iterating each of the ``arg_type_hints``).

					for(_arg_position = 0; _arg_position < arg_type_hints.length; _arg_position++)
						{
							_arg_type_hints = arg_type_hints[_arg_position];
							_arg_types = !$$.is_array(_arg_type_hints) ? [_arg_type_hints] : _arg_type_hints;

							if(_arg_position > total_arg_positions) // Argument not even passed in?
								continue; // Argument was not even passed in (we don't need to check this value).

							_last_arg_type_key = null; // Unset before iterating (we'll define below, if necessary).

							types_loop: // Marker for types loop (iterating each of the ``_arg_types`` here).

								for(_arg_type_key = 0; _arg_type_key < _arg_types.length; _arg_type_key++)
									{
										_arg_type = _arg_types[_arg_type_key];

										switch_handler: // Marker for switch handler.

											switch(_arg_type)
												// This may NOT be a string representation.
												// JavaScript handles `instanceof`, w/ comparison to a function.
											{
												case '': // Anything goes (there are NO requirements).
													break types_loop; // We have a valid type/value here.

											/****************************************************************************/

												case ':!empty': // Anything goes. But check if it's empty.
													if($$.empty(args[_arg_position])) // Is empty?
														{
															if(_last_arg_type_key === null)
																_last_arg_type_key = _arg_types.length - 1;

															if(_arg_type_key === _last_arg_type_key)
															// Exhausted list of possible types.
																{
																	problem = {
																		'types'   : _arg_types,
																		'position': _arg_position,
																		'value'   : args[_arg_position],
																		'empty'   : $$.empty(args[_arg_position])
																	};
																	break main_loop;
																}
														}
													else break types_loop; // We have a valid type/value here.

													break switch_handler; // Default break; and continue type checking.

											/****************************************************************************/

												case 'string': // All of these fall under ``!is_...()`` checks.
												case 'boolean':
												case 'bool':
												case 'integer':
												case 'float':
												case 'number':
												case 'numeric':
												case 'array':
												case 'function':
												case 'xml':
												case 'object':
												case 'null':
												case 'undefined':

													is_ = $$[$$.___is_type_checks[_arg_type]];

													if(!is_(args[_arg_position])) // Not this type?
														{
															if(_last_arg_type_key === null)
																_last_arg_type_key = _arg_types.length - 1;

															if(_arg_type_key === _last_arg_type_key)
															// Exhausted list of possible types.
																{
																	problem = {
																		'types'   : _arg_types,
																		'position': _arg_position,
																		'value'   : args[_arg_position],
																		'empty'   : $$.empty(args[_arg_position])
																	};
																	break main_loop;
																}
														}
													else break types_loop; // We have a valid type/value here.

													break switch_handler; // Default break; and continue type checking.

											/****************************************************************************/

												case '!string': // All of these fall under ``is_...()`` checks.
												case '!boolean':
												case '!bool':
												case '!integer':
												case '!float':
												case '!number':
												case '!numeric':
												case '!array':
												case '!function':
												case '!xml':
												case '!object':
												case '!null':
												case '!undefined':

													is_ = $$[$$.___is_type_checks[_arg_type]];

													if(is_(args[_arg_position])) // Is this type?
														{
															if(_last_arg_type_key === null)
																_last_arg_type_key = _arg_types.length - 1;

															if(_arg_type_key === _last_arg_type_key)
															// Exhausted list of possible types.
																{
																	problem = {
																		'types'   : _arg_types,
																		'position': _arg_position,
																		'value'   : args[_arg_position],
																		'empty'   : $$.empty(args[_arg_position])
																	};
																	break main_loop;
																}
														}
													else break types_loop; // We have a valid type/value here.

													break switch_handler; // Default break; and continue type checking.

											/****************************************************************************/

												case 'string:!empty': // These are ``!is_...()`` || ``empty()`` checks.
												case 'boolean:!empty':
												case 'bool:!empty':
												case 'integer:!empty':
												case 'float:!empty':
												case 'number:!empty':
												case 'numeric:!empty':
												case 'array:!empty':
												case 'function:!empty':
												case 'xml:!empty':
												case 'object:!empty':
												case 'null:!empty':
												case 'undefined:!empty':

													is_ = $$[$$.___is_type_checks[_arg_type]];

													if(!is_(args[_arg_position]) || $$.empty(args[_arg_position]))
													// Now, have we exhausted the list of possible types?
														{
															if(_last_arg_type_key === null)
																_last_arg_type_key = _arg_types.length - 1;

															if(_arg_type_key === _last_arg_type_key)
															// Exhausted list of possible types.
																{
																	problem = {
																		'types'   : _arg_types,
																		'position': _arg_position,
																		'value'   : args[_arg_position],
																		'empty'   : $$.empty(args[_arg_position])
																	};
																	break main_loop;
																}
														}
													else break types_loop; // We have a valid type/value here.

													break switch_handler; // Default break; and continue type checking.

											/****************************************************************************/

												default: // Assume object `instanceof` in this default case handler.
													// For practicality & performance reasons, we do NOT check `!` or `:!empty` here.
													// It's VERY rare that one would need to require something that's NOT a specific object instance.
													// In fact, the ``_arg_type`` value should NOT be a string representation in this case.
													// JavaScript ONLY handles `instanceof`, w/ comparison to an actual function value.

													if(!$$.is_function(_arg_type) || !(args[_arg_position] instanceof _arg_type))
														{
															if(_last_arg_type_key === null)
																_last_arg_type_key = _arg_types.length - 1;

															if(_arg_type_key === _last_arg_type_key)
															// Exhausted list of possible types.
																{
																	problem = {
																		'types'   : _arg_types,
																		'position': _arg_position,
																		'value'   : args[_arg_position],
																		'empty'   : $$.empty(args[_arg_position])
																	};
																	break main_loop;
																}
														}
													else break types_loop; // We have a valid type for this arg.

													break switch_handler; // Default break; and continue type checking.
											}
									}
						}

				if(!$$.empty(problem)) // We have a problem!
					{
						position = problem.position + 1;

						type_given = $.type(problem.value);
						empty = (problem.empty) ? $$.get___i18n('check_arg_types__empty') + ' ' : '';

						if(problem.types.length && $$.is_string(problem.types[0]))
							types = problem.types.join('|');
						// Else we say `[a different object type]`.
						else types = $$.get___i18n('check_arg_types__diff_object_type');

						caller = $$.get___i18n('check_arg_types__caller'); // Generic.
						// caller = arguments.callee.caller.name; not possible in strict mode.
						throw $.sprintf($$.get___i18n('check_arg_types__invalid_arg'), position, caller, types, empty, type_given);
					}
				return true; // Default return value (no problem).
			};
		/**
		 * @type {Object} WebSharks™ Core instance.
		 */
		$w.$websharks_core = new $w.$$websharks_core.$();

	})(this); // End WebSharks™ Core closure.