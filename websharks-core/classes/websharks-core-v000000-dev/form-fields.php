<?php
/**
 * Form Fields.
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
		 * Form Fields.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class form_fields extends framework
		{
			/**
			 * @var string Defaults to `ui-`, for jQuery™ UI themes.
			 *
			 * @note This can be overridden on a per-field basis.
			 */
			public $ui_prefix = 'ui-';

			/**
			 * @var string Prefix for field names.
			 *
			 * @note This can be overridden on a per-field basis.
			 */
			public $name_prefix = '';

			/**
			 * @var string Prefix for field IDs.
			 *
			 * @note This can be overridden on a per-field basis.
			 */
			public $id_prefix = '';

			/**
			 * @var string Common CSS classes.
			 *
			 * @note This can be supplemented on a per-field basis.
			 *    Each field can add their own additional common classes.
			 *
			 * @note Common classes, are common to ALL fields in this instance.
			 *    If a specific field overrides this value, we will use the per-field specification,
			 *    but then we append any globally common classes onto the end of that per-field value.
			 *    Therefore, these CANNOT be completely overridden on a per-field basis.
			 */
			public $common_classes = '';

			/**
			 * @var string Common attributes.
			 *
			 * @note This can be supplemented on a per-field basis.
			 *    Each field can add their own additional common attributes.
			 *
			 * @note Common attributes, are common to ALL fields in this instance.
			 *    If a specific field overrides this value, we will use the per-field specification,
			 *    but then we append any globally common attributes onto the end of that per-field value.
			 *    Therefore, these CANNOT be completely overridden on a per-field basis.
			 */
			public $common_attrs = '';

			/**
			 * @var boolean Use option update markers?
			 *
			 * @note This can be overridden on a per-field basis.
			 *
			 * @note This is used in `select` fields that allow `multiple` option selections;
			 *    and also for checkbox`[]` options, sent to the server as arrays.
			 *    Update markers pad these arrays with an `___update` index.
			 *
			 *    In these two cases, it is a good idea to pad the arrays with an update marker,
			 *    just in case NO selection is made by a user (e.g. to ensure something is always sent back to the server).
			 *    This makes it possible to detect empty arrays on the server side.
			 */
			public $use_update_markers = FALSE;

			/**
			 * @var array Form field config defaults.
			 * @used-in ``$this->construct_field_markup()``.
			 */
			public $defaults = array(
				// Required.
				'type'                => '',
				'name'                => '',

				// Common, but optional.
				'label'               => '',
				'title'               => '',
				'tabindex'            => 0,

				// If empty, we establish this dynamically.
				// Generated using: `md5-[MD5 hash of field's name]`.
				'id'                  => '',

				// This is for types: `input|textarea`,
				// when ``$value`` is NULL (i.e. not yet defined).
				'default_value'       => '',
				// Does NOT work with radio buttons or checkboxes.
				// Use: `checked_value`, `checked_by_default`.

				// Details.
				'details'             => '',
				'extra_details'       => '',

				// Icon for this field, if applicable.
				'icon'                => 'icon-arrowreturnthick-1-e',

				// Requirements.
				'unique'              => FALSE,
				'required'            => FALSE,
				'maxlength'           => 0,

				// Validation patterns.
				'validation_patterns' => array(
					array(
						'name'        => '',
						'regex'       => '',
						'minimum'     => NULL,
						'maximum'     => NULL,
						'description' => ''
					)
				),

				// For types: `input|textarea`.
				'confirm'             => FALSE,
				'confirmation_label'  => '',

				// For type: `textarea`.
				'cols'                => 50,
				'rows'                => 3,
				'wrap'                => TRUE,

				// For type: `image`.
				'src'                 => '',
				'alt'                 => '',

				// For type: `select`.
				'size'                => 3,
				'multiple'            => FALSE,

				// For type: `select`.
				// For type: `radios`.
				// For type: `checkboxes`.
				'options'             => array(
					array(
						'label'      => '',
						'value'      => '',
						'is_default' => FALSE
					)
				),

				// For type: `file`.
				'accept'              => '',

				// For type: `radio|checkbox`.
				'check_label'         => '',
				'checked_value'       => '1',
				'checked_by_default'  => FALSE,

				// For type: `radios|checkboxes`.
				'block_rcs'           => FALSE,
				'scrolling_block_rcs' => FALSE,

				// Other statuses.
				'readonly'            => FALSE,
				'disabled'            => FALSE,

				// Other/misc specs.
				'spellcheck'          => TRUE,
				'autocomplete'        => FALSE,
				'mono'                => FALSE,
				'use_button_tag'      => TRUE,
				'div_wrapper_classes' => '',

				// Option update marker (allows for empty arrays).
				'use_update_marker'   => FALSE,

				// UI theme prefix.
				'ui_prefix'           => 'ui-',

				// Field name prefix.
				'name_prefix'         => '',

				// Field ID prefix.
				'id_prefix'           => '',

				// Custom/common classes.
				'common_classes'      => '',

				// Custom/common attributes.
				'common_attrs'        => ''
			);

			/**
			 * @var array All possible field types.
			 */
			public $types = array(
				'tel',
				'url',
				'text',
				'file',
				'email',
				'number',
				'search',
				'password',
				'radio',
				'radios',
				'checkbox',
				'checkboxes',
				'image',
				'button',
				'reset',
				'submit',
				'select',
				'textarea'
			);

			/**
			 * @var array All possible `input` types.
			 */
			public $input_types = array(
				'tel',
				'url',
				'text',
				'file',
				'email',
				'number',
				'search',
				'password',
				'radio',
				'checkbox',
				'image',
				'button',
				'reset',
				'submit'
			);

			/**
			 * @var array Field types that serve as buttons.
			 */
			public $button_types = array(
				'image',
				'button',
				'reset',
				'submit'
			);

			/**
			 * @var array Field types that include an icon.
			 */
			public $types_with_icons = array(
				'tel',
				'url',
				'text',
				'email',
				'number',
				'search',
				'password',
				'select'
			);

			/**
			 * @var array Field types that include a single checked value.
			 *    Note that `radios` and `checkboxes` use options, and NOT a single checked value.
			 */
			public $single_check_types = array(
				'radio',
				'checkbox'
			);

			/**
			 * @var array Field types that include options.
			 *    Note that `radio` and `checkbox` use a single checked value.
			 */
			public $types_with_options = array(
				'radios',
				'checkboxes',
				'select'
			);

			/**
			 * @var array Defaults icons, by field type.
			 */
			public $default_icons_by_type = array(
				'tel'      => 'icon-contact',
				'url'      => 'icon-link',
				'text'     => 'icon-arrowreturnthick-1-e',
				'email'    => 'icon-mail-closed',
				'number'   => 'icon-calculator',
				'search'   => 'icon-search',
				'password' => 'icon-key',
				'select'   => 'icon-triangle-1-s'
			);

			/**
			 * @var string Fields for a specific call action?
			 *    Set this to a dynamic `©class.®method`.
			 */
			public $for_call = ''; // Defaults to empty string.

			/**
			 * @var boolean Is ``$this->for_call``?
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $is_for_call = FALSE;

			/**
			 * Constructor.
			 *
			 * @param object|array $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or a new ``$___instance_config`` array.
			 *
			 * @param array        $properties Optional array of properties to set upon construction.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function __construct($___instance_config, $properties = array())
				{
					parent::__construct($___instance_config);

					$this->check_arg_types('', 'array', func_get_args());

					$this->set_properties($properties);

					if($this->for_call) // Is ``$this->for_call``?
						$this->is_for_call = $this->©action->is_call($this->for_call);
				}

			/**
			 * Gets a string form field value.
			 *
			 * @note This considers the current action call (if this instance is associated with one).
			 *
			 * @param mixed $value A variable (always by reference).
			 *    See ``$this->x_value()``, to pass a variable and/or an expression.
			 *
			 * @note A boolean FALSE is converted into a `0` string representation.
			 *
			 * @return string|null A string if ``$value`` is scalar, or this is the current action.
			 *    Else this returns NULL by default, so that default form field values can be considered properly.
			 */
			public function value(&$value)
				{
					if(is_scalar($value))
						return ($value === FALSE) ? '0' : (string)$value;

					if($this->is_for_call)
						return '';

					return NULL;
				}

			/**
			 * Same as ``$this->value()``, but this allows an expression.
			 *
			 * @param mixed $value A variable (or an expression).
			 *
			 * @return string|null See ``$this->value()`` for further details.
			 */
			public function ¤value($value)
				{
					return $this->value($value);
				}

			/**
			 * Gets an array of form field values.
			 *
			 * @note This considers the current action call (if this instance is associated with one).
			 *
			 * @param mixed $values A variable (always by reference).
			 *    See ``$this->x_values()``, to pass a variable and/or an expression.
			 *
			 * @return array|null An array if ``$values`` is an array, or this is the current action.
			 *    Else this returns NULL by default, so that default form field values can be considered properly.
			 */
			public function values(&$values)
				{
					if(is_array($values))
						return $values;

					if($this->is_for_call)
						return array();

					return NULL;
				}

			/**
			 * Same as ``$this->values()``, but this allows an expression.
			 *
			 * @param mixed $values A variable (or an expression).
			 *
			 * @return array|null See ``$this->values()`` for further details.
			 */
			public function ¤values($values)
				{
					return $this->values($values);
				}

			/**
			 * Builds HTML markup for a form field.
			 *
			 * @param null|string (or scalar)|array $field_value The current value(s) for this field.
			 *    If there is NO current value, set this to NULL; so that default values are considered properly.
			 *    That is, default values are only implemented, if ``$value`` is currently NULL.
			 *
			 * @note The current ``$field_value`` will be piped through ``$this->value()`` and/or ``$this->values()``.
			 *    In other words, we convert the ``$field_value`` into a NULL/string/array, depending upon the `type` of form field.
			 *    The current `call` action will also considered, if this instance is associated with one.
			 *    See: ``$this->value()`` and ``$this->values()`` for further details.
			 *
			 * @param array                         $field Field configuration options.
			 *
			 * @return string HTML markup for a form field, compatible with jQuery™ UI themes.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @throws exception If invalid types are found in the configuration array.
			 *    Each configuration option MUST have a value type matching it's default counterpart, as defined by this routine.
			 *
			 * @throws exception If required config options are missing.
			 */
			public function construct_field_markup($field_value, $field)
				{
					$this->check_arg_types(array('null', 'string', 'array'), 'array:!empty', func_get_args());

					$value  = $this->value($field_value); // String (or NULL by default).
					$values = $this->values($field_value); // Array (or NULL by default).

					// Establish defaults.

					$defaults = $this->defaults; // Initial defaults.

					if(!empty($field['type']) && !empty($this->default_icons_by_type[$field['type']]))
						$defaults['icon'] = $this->default_icons_by_type[$field['type']];

					$defaults['use_update_marker'] = $this->use_update_markers;
					$defaults['ui_prefix']         = $this->ui_prefix;
					$defaults['name_prefix']       = $this->name_prefix;
					$defaults['id_prefix']         = $this->id_prefix;
					$defaults['common_classes']    = $this->common_classes;
					$defaults['common_attrs']      = $this->common_attrs;

					// Check & standardize field configuration.
					$field = $this->standardize_field_config($field_value, $field, $defaults);

					// Wrapper.
					$html = '<div'.
					        ' class="'.esc_attr($field['id_prefix'].$field['id'].' '.$field['ui_prefix'].'form-field-wrapper '.$field['ui_prefix'].'form-field-type-'.$field['type'].(($field['confirm']) ? ' '.$field['ui_prefix'].'form-field-confirm' : '').' '.$field['ui_prefix'].'form-field').
					        ((in_array($field['type'], array('radios', 'checkboxes'), TRUE) && $field['block_rcs']) ? ' '.esc_attr($field['ui_prefix'].'form-field-type-block-rcs') : '').
					        ((in_array($field['type'], array('radios', 'checkboxes'), TRUE) && $field['scrolling_block_rcs']) ? ' '.esc_attr($field['ui_prefix'].'form-field-type-scrolling-block-rcs') : '').
					        esc_attr($field['div_wrapper_classes'].$field['common_classes']).'"'.
					        $field['common_attrs'].
					        '>';

					// Label.
					if($field['label'])
						{
							$html .= '<label'.
							         ((in_array($field['type'], array('radios', 'checkboxes'), TRUE)) ? '' : ' for="'.esc_attr($field['id_prefix'].$field['id']).'"').
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-label'.$field['common_classes']).'"'.
							         ' title="'.esc_attr($field['label']).'"'.
							         $field['common_attrs'].
							         '>'.

							         (($field['label'] && $field['required'])
								         ? $field['label'].$this->translate(' *', 'form-field-required-marker')
								         : $field['label']).

							         '</label>';
						}

					// Details.
					if($field['details'])
						{
							$html .= '<div'.
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-details'.$field['common_classes']).'"'.
							         $field['common_attrs'].
							         '>'.

							         $field['details'].

							         '</div>';
						}

					// Container.
					$html .= '<div'.
					         ' class="'.esc_attr($field['ui_prefix'].'form-field-container '.$field['ui_prefix'].'state-default '.$field['ui_prefix'].'corner-all'.$field['common_classes']).'"'.
					         $field['common_attrs'].
					         '>';

					// Field icon.
					if(in_array($field['type'], $this->types_with_icons, TRUE))
						{
							$html .= '<span'.
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-icon '.$field['ui_prefix'].'icon '.$field['ui_prefix'].$field['icon'].$field['common_classes']).'"'.
							         $field['common_attrs'].
							         '>'.
							         '</span>';
						}

					// Select fields.
					if(in_array($field['type'], array('select'), TRUE))
						{
							if($field['multiple'] && $field['use_update_marker'])
								{
									$html .= '<input type="hidden"'.
									         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---update"'.
									         ' name="'.esc_attr($field['name_prefix'].$field['name'].'[___update]').'"'.
									         ' value="'.esc_attr('___update').'"'.
									         '/>';
								}
							$html .= '<select'.
							         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
							         ' name="'.esc_attr($field['name_prefix'].$field['name'].(($field['multiple']) ? '[]' : '')).'"'.
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-tag '.$field['ui_prefix'].'corner-all').(($field['mono']) ? ' '.esc_attr($field['ui_prefix'].'form-field-mono') : '').esc_attr($field['common_classes']).'"'.

							         (($field['multiple']) ? ' multiple="multiple" size="'.esc_attr((string)$field['size']).'"' : '').

							         (($field['unique']) ? ' data-unique="'.esc_attr('true').'"' : '').
							         (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
							         (($field['validation_patterns']) ? ' '.$this->validation_attrs($field['validation_patterns']) : '').

							         (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').
							         (($field['title']) ? ' title="'.esc_attr($field['title']).'"' : '').

							         ((!$field['autocomplete']) ? ' autocomplete="off"' : '').

							         (($field['readonly']) ? ' readonly="readonly"' : '').
							         (($field['disabled']) ? ' disabled="disabled"' : '').

							         $field['common_attrs'].
							         '>';

							foreach($field['options'] as $_key => $_option)
								{
									if(is_array($_option) && $this->©strings->are_set($_option['label'], $_option['value']))
										{
											$html .= '<option'.
											         ' id="'.esc_attr($field['id_prefix'].$field['id']).'-'.esc_attr($_key).'"'.
											         ' class="'.esc_attr(trim($field['common_classes'])).'"'.
											         ' value="'.esc_attr($_option['value']).'"'.

											         (((!$field['multiple'] && !isset($value) && !empty($_option['is_default']))
											           || ($field['multiple'] && !isset($values) && !empty($_option['is_default']))
											           || (!$field['multiple'] && is_string($value) && $value === $_option['value'])
											           || ($field['multiple'] && is_array($values) && in_array($_option['value'], $values, TRUE)))
												         ? ' selected="selected"' : '').

											         $field['common_attrs'].
											         '">'.

											         $_option['label'].

											         '</option>';
										}
								}
							unset($_key, $_option);

							$html .= '</select>';
						}

					// Radios/checkboxes.
					else if(in_array($field['type'], array('radios', 'checkboxes'), TRUE))
						{
							if(in_array($field['type'], array('checkboxes'), TRUE) && $field['use_update_marker'])
								{
									$html .= '<input'.
									         ' type="hidden"'.
									         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---update"'.
									         ' name="'.esc_attr($field['name_prefix'].$field['name'].'[___update]').'"'.
									         ' value="'.esc_attr('___update').'"'.
									         '/>';
								}
							foreach($field['options'] as $_key => $_option)
								{
									if(is_array($_option) && $this->©strings->are_set($_option['label'], $_option['value']))
										{
											$html .= '<label'.
											         ' class="'.esc_attr($field['ui_prefix'].'corner-all').(($field['mono']) ? ' '.esc_attr($field['ui_prefix'].'form-field-mono') : '').esc_attr($field['common_classes']).'"'.
											         $field['common_attrs'].
											         '>'.

											         '<input'.
											         ' type="'.esc_attr(rtrim($field['type'], 'es')).'"'.
											         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---'.esc_attr($_key).'"'.
											         ' name="'.esc_attr($field['name_prefix'].$field['name'].((in_array($field['type'], array('checkboxes'), TRUE)) ? '[]' : '')).'"'.
											         ' class="'.esc_attr($field['ui_prefix'].'form-field-tag'.$field['common_classes']).'"'.
											         ' value="'.esc_attr($_option['value']).'"'.

											         ((($field['type'] === 'radios' && !isset($value) && !empty($_option['is_default']))
											           || ($field['type'] === 'checkboxes' && !isset($values) && !empty($_option['is_default']))
											           || ($field['type'] === 'radios' && is_string($value) && $value === $_option['value'])
											           || ($field['type'] === 'checkboxes' && is_array($values) && in_array($_option['value'], $values, TRUE)))
												         ? ' checked="checked"' : '').

											         (($field['unique']) ? ' data-unique="'.esc_attr('true').'"' : '').
											         (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
											         (($field['validation_patterns']) ? ' '.$this->validation_attrs($field['validation_patterns']) : '').

											         (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').

											         (($field['readonly']) ? ' readonly="readonly"' : '').
											         (($field['disabled']) ? ' disabled="disabled"' : '').

											         $field['common_attrs'].
											         ' />'.

											         ' '.$_option['label'].

											         '</label>';
										}
								}
							unset($_key, $_option);
						}

					// Textarea fields.
					else if(in_array($field['type'], array('textarea'), TRUE))
						{
							$html .= '<textarea'.
							         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
							         ' name="'.esc_attr($field['name_prefix'].$field['name']).'"'.

							         ' class="'.esc_attr($field['ui_prefix'].'form-field-tag '.$field['ui_prefix'].'corner-all').(($field['mono']) ? ' '.esc_attr($field['ui_prefix'].'form-field-mono') : '').esc_attr($field['common_classes']).'"'.

							         (($field['unique']) ? ' data-unique="'.esc_attr('true').'"' : '').
							         (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
							         (($field['maxlength']) ? ' maxlength="'.esc_attr((string)$field['maxlength']).'"' : '').
							         (($field['validation_patterns']) ? ' '.$this->validation_attrs($field['validation_patterns']) : '').

							         (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').
							         (($field['title']) ? ' title="'.esc_attr($field['title']).'"' : '').

							         ((!$field['spellcheck']) ? ' spellcheck="false"' : '').
							         ((!$field['autocomplete']) ? ' autocomplete="off"' : '').

							         (($field['readonly']) ? ' readonly="readonly"' : '').
							         (($field['disabled']) ? ' disabled="disabled"' : '').

							         ((!$field['wrap']) ? ' wrap="off"' : '').

							         ' cols="'.esc_attr((string)$field['cols']).'"'.
							         ' rows="'.esc_attr((string)$field['rows']).'"'.

							         $field['common_attrs'].
							         '>'.

							         ((!isset($value)) ? esc_html($field['default_value']) : esc_html((string)$value)).

							         '</textarea>';
						}

					// Buttons.
					else if(in_array($field['type'], $this->button_types, TRUE) && $field['use_button_tag'])
						{
							$html .= '<button'.
							         ' type="'.esc_attr($field['type']).'"'.
							         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-tag-button '.$field['ui_prefix'].'corner-all').(($field['mono']) ? ' '.esc_attr($field['ui_prefix'].'form-field-mono') : '').esc_attr($field['common_classes']).'"'.

							         ((!isset($value)) ? ' value="'.esc_attr($field['default_value']).'"' : ' value="'.esc_attr((string)$value).'"').

							         (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').
							         (($field['title']) ? ' title="'.esc_attr($field['title']).'"' : '').

							         (($field['readonly']) ? ' readonly="readonly"' : '').
							         (($field['disabled']) ? ' disabled="disabled"' : '').

							         $field['common_attrs'].
							         '>'.

							         ((!isset($value)) ? $field['default_value'] : (string)$value).

							         '</button>';
							;
						}

					// Input fields.
					else if(in_array($field['type'], $this->input_types, TRUE))
						{
							$html .= '<input'.
							         ' type="'.esc_attr($field['type']).'"'.
							         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
							         ((!in_array($field['type'], $this->button_types, TRUE)) ? ' name="'.esc_attr($field['name_prefix'].$field['name']).'"' : '').
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-'.((in_array($field['type'], $this->button_types, TRUE)) ? 'tag-button' : 'tag').' '.$field['ui_prefix'].'corner-all').(($field['mono']) ? ' '.esc_attr($field['ui_prefix'].'form-field-mono') : '').esc_attr($field['common_classes']).'"'.

							         ((in_array($field['type'], array('radio', 'checkbox'), TRUE)) ? ' value="'.esc_attr($field['checked_value']).'"'
								         : ((!isset($value)) ? ' value="'.esc_attr($field['default_value']).'"' : ' value="'.esc_attr((string)$value).'"')).

							         ((in_array($field['type'], array('radio', 'checkbox'), TRUE)
							           && ((!isset($value) && $field['checked_by_default']) || (is_string($value) && $value === $field['checked_value'])))
								         ? ' checked="checked"' : '').

							         ((in_array($field['type'], array('image'), TRUE) && $field['src']) ? ' src="'.esc_attr($field['src']).'"' : '').
							         ((in_array($field['type'], array('image'), TRUE) && $field['alt']) ? ' alt="'.esc_attr($field['alt']).'"' : '').
							         ((in_array($field['type'], array('file'), TRUE) && $field['accept']) ? ' accept="'.esc_attr($field['accept']).'"' : '').

							         ((!in_array($field['type'], $this->button_types, TRUE)) ?
								         (($field['unique']) ? ' data-unique="'.esc_attr('true').'"' : '').
								         (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
								         (($field['maxlength']) ? ' maxlength="'.esc_attr((string)$field['maxlength']).'"' : '').
								         (($field['validation_patterns']) ? ' '.$this->validation_attrs($field['validation_patterns']) : '') : '').

							         (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').
							         (($field['title']) ? ' title="'.esc_attr($field['title']).'"' : '').

							         ((!in_array($field['type'], $this->button_types, TRUE)) ?
								         ((!$field['spellcheck']) ? ' spellcheck="false"' : '').
								         ((!$field['autocomplete']) ? ' autocomplete="off"' : '') : '').

							         (($field['readonly']) ? ' readonly="readonly"' : '').
							         (($field['disabled']) ? ' disabled="disabled"' : '').

							         $field['common_attrs'].
							         ' />'.

							         ((in_array($field['type'], array('radio', 'checkbox'), TRUE)) ?

								         '<label'.
								         ' for="'.esc_attr($field['id_prefix'].$field['id']).'"'.
								         ' class="'.esc_attr($field['ui_prefix'].'form-field-check-label').(($field['mono']) ? ' '.esc_attr($field['ui_prefix'].'form-field-mono') : '').esc_attr($field['common_classes']).'"'.
								         $field['common_attrs'].
								         '>'.

								         ' '.$field['check_label'].

								         '</label>'

								         : '');
						}
					else throw $this->©exception(
						__METHOD__.'#invalid_type', compact('field'),
						sprintf($this->i18n('Invalid form field type: `%1$s`.'), $field['type'])
					);

					// Container.
					$html .= '</div>';

					// Extra details.
					if($field['extra_details'])
						{
							$html .= '<div'.
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-extra-details'.$field['common_classes']).'"'.
							         $field['common_attrs'].
							         '>'.

							         $field['extra_details'].

							         '</div>';
						}

					// Wrapper.
					$html .= '</div>';

					// Confirmation?
					if($field['confirm'])
						{
							$c                = $field; // Clone.
							$c['confirm']     = FALSE; // Confirm ONE time only.
							$c['id_prefix']   = 'c-'.$c['id_prefix'];
							$c['name_prefix'] = 'c_'.$c['name_prefix'];
							$c['label']       = $c['details'] = $c['extra_details'] = '';

							if($c['confirmation_label'])
								$c['label'] = $c['confirmation_label'];

							$html .= $this->construct_field_markup($field_value, $c);
						}
					return $html; // HTML markup.
				}

			/**
			 * Checks a field's configuration options.
			 *
			 * @param null|string (or scalar)|array $field_value The current value(s) for this field.
			 *    If there is NO current value, set this to NULL; so that default values are considered properly.
			 *    That is, default values are only implemented, if ``$value`` is currently NULL.
			 *
			 * @note The current ``$field_value`` will be piped through ``$this->value()`` and/or ``$this->values()``.
			 *    In other words, we convert the ``$field_value`` into a NULL/string/array, depending upon the `type` of form field.
			 *    The current `call` action will also considered, if this instance is associated with one.
			 *    See: ``$this->value()`` and ``$this->values()`` for further details.
			 *
			 * @param array                         $field The array of field configuration options.
			 *
			 * @param array                         $defaults An array of defaults for this field type.
			 *
			 * @return array A fully validated, and completely standardized configuration array.
			 *    Otherwise, we throw an exception on any type of validation failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If invalid types are found in the configuration array.
			 * @throws exception If required config options are missing.
			 */
			public function standardize_field_config($field_value, $field, $defaults)
				{
					$this->check_arg_types(array('null', 'string', 'array'), 'array:!empty', 'array:!empty', func_get_args());

					$value  = $this->value($field_value); // String (or NULL by default).
					$values = $this->values($field_value); // Array (or NULL by default).

					// Validate types.
					foreach($defaults as $_key => $_default)
						{
							$_key_exists = array_key_exists($_key, $field);

							if($_key_exists && !is_null($_default) && gettype($field[$_key]) !== gettype($_default))
								throw $this->©exception( // There's a problem with this array key.
									__METHOD__.'#invalid_key', compact('_key', 'defaults', 'field'),
									sprintf($this->i18n('Form field. Invalid key: `%1$s`.'), $_key).
									sprintf($this->i18n(' Defaults: `%1$s`.'), $this->©var->dump($defaults)).
									sprintf($this->i18n(' Invalid field configuration: `%1$s`.'), $this->©var->dump($field))
								);
						}
					unset($_key, $_default, $_key_exists); // Housekeeping.

					// Merge with defaults.
					$field = array_merge($defaults, $field);

					# Handle field types.

					// A `type` is always required.
					if(empty($field['type']))
						throw $this->©exception(
							__METHOD__.'#type_missing', compact('field'),
							$this->i18n('Form field. Invalid configuration (missing `type`).')
						);

					// The field `type` MUST be valid.
					if(!in_array($field['type'], $this->types, TRUE))
						throw $this->©exception(
							__METHOD__.'#invalid_type', compact('field'),
							$this->i18n('Form field. Invalid configuration (invalid `type`).')
						);

					# Handle field names.

					// A `name` is always required.
					if(!$this->©string->is_not_empty($field['name']))
						throw $this->©exception(
							__METHOD__.'#name_missing', compact('field'),
							$this->i18n('Form field. Invalid configuration (missing `name`).')
						);

					// The field `name` MUST be valid.
					if(!preg_match('/^(?:[a-z]|[\[a-z](?:[a-z0-9\._\[\]])*?[a-z0-9\]])$/i', $field['name']))
						throw $this->©exception(
							__METHOD__.'#invalid_name', compact('field'),
							$this->i18n('Form field. Invalid configuration (invalid `name`).').
							$this->i18n(' Invalid characters found in `name` value.').
							sprintf($this->i18n(' Got: `%1$s`.'), $field['name'])
						);

					# Handle field ID values.

					// Generates an `id` if one was NOT passed in.
					if(!$this->©string->is_not_empty($field['id']))
						$field['id'] = 'md5-'.strtolower(md5($field['name']));

					// The field `id` MUST be valid.
					if(!preg_match('/^(?:[a-z]|[a-z](?:[a-z0-9_\-])*?[a-z0-9])$/i', $field['id']))
						throw $this->©exception(
							__METHOD__.'#invalid_id', compact('field'),
							$this->i18n('Form field. Invalid configuration (invalid `id`).').
							$this->i18n(' Invalid characters found in `id` value.').
							sprintf($this->i18n(' Got: `%1$s`.'), $field['id'])
						);

					# Handle field icons.

					// An `icon` is required for some field types.
					if(in_array($field['type'], $this->types_with_icons, TRUE) && !$this->©string->is_not_empty($field['icon']))
						throw $this->©exception(
							__METHOD__.'#icon_missing', compact('field'),
							$this->i18n('Form field. Invalid configuration (missing `icon`).')
						);

					# Handle field options.

					// An `options` array is required for some field types.
					if(in_array($field['type'], $this->types_with_options, TRUE) && !$this->©array->is_not_empty($field['options']))
						throw $this->©exception(
							__METHOD__.'#options_missing', compact('field'),
							$this->i18n('Form field. Invalid configuration (missing `options`).')
						);
					// Make sure options array is indexed numerically.
					$field['options'] = array_values($field['options']);

					# Handle validation patterns.

					// Make sure validation patterns are indexed numerically.
					$field['validation_patterns'] = array_values($field['validation_patterns']);

					# Handle field titles (if possible).

					// Try to set a field title automatically (if possible).
					if(!$field['title'] && $field['label'])
						$field['title'] = $field['label'];
					else if(!$field['title'] && in_array($field['type'], $this->button_types, TRUE) && is_string($value))
						$field['title'] = $value; // Use button value.

					# Handle common classes.

					// Prepare `common_classes`; add padding.
					if($this->©string->is_not_empty($field['common_classes']))
						$field['common_classes'] = ' '.$field['common_classes'];

					// Appends globally common classes (common to ALL fields in this instance).
					if($this->common_classes && trim($field['common_classes']) !== $this->common_classes)
						$field['common_classes'] .= ' '.$this->common_classes;

					# Handle common attributes.

					// Prepare `common_attrs`; add padding.
					if($this->©string->is_not_empty($field['common_attrs']))
						$field['common_attrs'] = ' '.$field['common_attrs'];

					// Appends globally common attributes (common to ALL fields in this instance).
					if($this->common_attrs && trim($field['common_attrs']) !== $this->common_attrs)
						$field['common_attrs'] .= ' '.$this->common_attrs;

					# Handle div wrapper classes.

					// Prepare `div_wrapper_classes`; add padding.
					if($this->©string->is_not_empty($field['div_wrapper_classes']))
						$field['div_wrapper_classes'] = ' '.$field['div_wrapper_classes'];

					return $field; # Standardized now.
				}

			/**
			 * Builds validation pattern attributes.
			 *
			 * @param array $validation_patterns An array of validation patterns.
			 *
			 * @return string A string of validation pattern attributes.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function validation_attrs($validation_patterns)
				{
					$this->check_arg_types('array', func_get_args());

					$attrs = ''; // Initialize attributes.

					foreach(array_values($validation_patterns) as $_i => $_validation_pattern) $attrs .=
						((!empty($_validation_pattern['name'])) ? ' data-validation-name-'.$_i.'="'.esc_attr((string)$_validation_pattern['name']).'"' : '').
						((!empty($_validation_pattern['regex'])) ? ' data-validation-regex-'.$_i.'="'.esc_attr((string)$_validation_pattern['regex']).'"' : '').
						((isset($_validation_pattern['minimum']) && is_numeric($_validation_pattern['minimum'])) ? ' data-validation-minimum-'.$_i.'="'.esc_attr((string)$_validation_pattern['minimum']).'"' : '').
						((isset($_validation_pattern['maximum']) && is_numeric($_validation_pattern['maximum'])) ? ' data-validation-maximum-'.$_i.'="'.esc_attr((string)$_validation_pattern['maximum']).'"' : '').
						((!empty($_validation_pattern['description'])) ? ' data-validation-description-'.$_i.'="'.esc_attr((string)$_validation_pattern['description']).'"' : '');

					unset($_i, $_validation_pattern); // Housekeeping.

					return $attrs; // Return string of all attributes now.
				}
		}
	}