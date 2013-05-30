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
			 *
			 * @note Data types are IMPORTANT here. See {@link standardize_field_config()}.
			 *
			 * @by-constructor Updated dynamically by class constructor.
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
				// Generated using a `name` value basename.
				'code'                => '',

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
				'unique_callback_js'  => '',
				'unique_callback_php' => NULL,
				'required'            => FALSE,
				'maxlength'           => 0,

				// Validation patterns.
				'validation_patterns' => array(),

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
				// For type: `select|file`.
				'multiple'            => FALSE,

				// For type: `select`.
				// For type: `radios`.
				// For type: `checkboxes`.
				'options'             => array(),

				// For type: `file`.
				'accept'              => '',
				'move_to_dir'         => '',

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

				// Option update marker.
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
			 *
			 * @note If this list is updated, we will also need to update
			 *    the `core.js` validation routines (in many cases).
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
				'color',
				'range',
				'date',
				'datetime',
				'datetime-local',
				'radio',
				'radios',
				'checkbox',
				'checkboxes',
				'image',
				'button',
				'reset',
				'submit',
				'select',
				'textarea',
				'hidden'
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
				'color',
				'range',
				'date',
				'datetime',
				'datetime-local',
				'radio',
				'checkbox',
				'image',
				'button',
				'reset',
				'submit',
				'hidden'
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
			 * @var array Field types that include a single checked value.
			 *    Note that `radios` and `checkboxes` use options, and NOT a single checked value.
			 */
			public $single_check_types = array(
				'radio',
				'checkbox'
			);

			/**
			 * @var array Field types that include multiple checked values.
			 *    Note that `radios` and `checkboxes` use options, and NOT checked values.
			 */
			public $multi_check_types = array(
				'radios',
				'checkboxes'
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
			 * @var array Confirmable field types.
			 */
			public $confirmable_types = array(
				'tel',
				'url',
				'text',
				'email',
				'number',
				'search',
				'password',
				'color',
				'range',
				'date',
				'datetime',
				'datetime-local',
				'select',
				'textarea'
			);

			/**
			 * @var string Fields for a specific call action?
			 *    Set this to a dynamic `©class.®method`.
			 */
			public $for_call = ''; // Defaults to empty string.

			/**
			 * @var boolean Is an action {@link $for_call}?
			 *
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $is_action_for_call = FALSE;

			/**
			 * @var array A record of all fields generated by this instance.
			 *
			 * @note This list is built by {@link construct_field_markup()}.
			 */
			public $generated_fields = array();

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

					if($properties) $this->set_properties($properties);

					$this->defaults['ui_prefix']         = $this->ui_prefix;
					$this->defaults['name_prefix']       = $this->name_prefix;
					$this->defaults['id_prefix']         = $this->id_prefix;
					$this->defaults['common_classes']    = $this->common_classes;
					$this->defaults['common_attrs']      = $this->common_attrs;
					$this->defaults['use_update_marker'] = $this->use_update_markers;

					if($this->for_call) // For a specific call action?
						$this->is_action_for_call = $this->©action->is_call($this->for_call);
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
					$this->check_arg_types(array('null', 'scalar', 'array'), 'array:!empty', func_get_args());

					$value                                  = $this->value($field_value); // String (or NULL by default).
					$values                                 = $this->values($field_value); // Array (or NULL by default).
					$field                                  = $this->standardize_field_config($field_value, $field); // Merge w/ defaults and standardize.
					$this->generated_fields[$field['code']] = $field; // Indexed by code.
					$html                                   = ''; // Initialize string value.

					if($field['type'] !== 'hidden')
						$html .= '<div'.
						         ' class="'.esc_attr($field['id_prefix'].$field['id'].' '.$field['ui_prefix'].'form-field-wrapper '.$field['ui_prefix'].'form-field-type-'.$field['type'].(($field['confirm']) ? ' '.$field['ui_prefix'].'form-field-confirm' : '').' '.$field['ui_prefix'].'form-field').
						         (($field['block_rcs'] && in_array($field['type'], $this->multi_check_types, TRUE)) ? ' '.esc_attr($field['ui_prefix'].'form-field-type-block-rcs') : '').
						         (($field['scrolling_block_rcs'] && in_array($field['type'], $this->multi_check_types, TRUE)) ? ' '.esc_attr($field['ui_prefix'].'form-field-type-scrolling-block-rcs') : '').
						         esc_attr($field['div_wrapper_classes'].$field['common_classes']).'"'.
						         $field['common_attrs'].
						         '>';

					if($field['label'] && $field['type'] !== 'hidden')
						{
							$html .= '<label'.
							         ((in_array($field['type'], $this->multi_check_types, TRUE)) ? '' : ' for="'.esc_attr($field['id_prefix'].$field['id']).'"').
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-label'.$field['common_classes']).'"'.
							         ' title="'.esc_attr($field['label']).'"'.
							         $field['common_attrs'].
							         '>'.

							         (($field['label'] && $field['required'])
								         ? $field['label'].$this->translate(' *', 'form-field-required-marker')
								         : $field['label']).

							         '</label>';
						}
					if($field['details'] && $field['type'] !== 'hidden')
						{
							$html .= '<div'.
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-details'.$field['common_classes']).'"'.
							         $field['common_attrs'].
							         '>'.

							         $field['details'].

							         '</div>';
						}
					if($field['type'] !== 'hidden')
						$html .= '<div'.
						         ' class="'.esc_attr($field['ui_prefix'].'form-field-container '.$field['ui_prefix'].'state-default '.$field['ui_prefix'].'corner-all'.$field['common_classes']).'"'.
						         $field['common_attrs'].
						         '>';

					if(in_array($field['type'], $this->types_with_icons, TRUE) && $field['type'] !== 'hidden')
						{
							$html .= '<span'.
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-icon '.$field['ui_prefix'].'icon '.$field['ui_prefix'].$field['icon'].$field['common_classes']).'"'.
							         $field['common_attrs'].
							         '>'.
							         '</span>';
						}
					if(in_array($field['type'], $this->types_with_options, TRUE) && $field['type'] === 'select')
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
											         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---'.esc_attr($_key).'"'.
											         ' class="'.esc_attr(trim($field['common_classes'])).'"'.
											         ' value="'.esc_attr($_option['value']).'"'.

											         (((!$field['multiple'] && is_string($value) && $value === $_option['value'])
											           || (!$field['multiple'] && !isset($value) && $_option['is_default'])
											           || ($field['multiple'] && is_array($values) && in_array($_option['value'], $values, TRUE))
											           || ($field['multiple'] && !isset($values) && $_option['is_default']))
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
					else if(in_array($field['type'], $this->types_with_options, TRUE) && in_array($field['type'], $this->multi_check_types, TRUE))
						{
							if($field['type'] === 'checkboxes' && $field['use_update_marker'])
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
											         ' name="'.esc_attr($field['name_prefix'].$field['name'].(($field['type'] === 'checkboxes') ? '[]' : '')).'"'.
											         ' class="'.esc_attr($field['ui_prefix'].'form-field-tag'.$field['common_classes']).'"'.
											         ' value="'.esc_attr($_option['value']).'"'.

											         ((($field['type'] === 'radios' && is_string($value) && $value === $_option['value'])
											           || ($field['type'] === 'radios' && !isset($value) && $_option['is_default'])
											           || ($field['type'] === 'checkboxes' && is_array($values) && in_array($_option['value'], $values, TRUE))
											           || ($field['type'] === 'checkboxes' && !isset($values) && $_option['is_default']))
												         ? ' checked="checked"' : '').

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
					else if($field['type'] === 'textarea')
						{
							$html .= '<textarea'.
							         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
							         ' name="'.esc_attr($field['name_prefix'].$field['name']).'"'.

							         ' class="'.esc_attr($field['ui_prefix'].'form-field-tag '.$field['ui_prefix'].'corner-all').(($field['mono']) ? ' '.esc_attr($field['ui_prefix'].'form-field-mono') : '').esc_attr($field['common_classes']).'"'.

							         (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
							         (($field['maxlength']) ? ' maxlength="'.esc_attr((string)$field['maxlength']).'"' : '').
							         (($field['unique']) ? ' data-unique="'.esc_attr('true').'" data-unique-callback="'.esc_attr($field['unique_callback_js']).'"' : '').
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
						}
					else if(in_array($field['type'], $this->input_types, TRUE))
						{
							if($field['type'] === 'file' && $field['multiple'] && $field['use_update_marker'])
								{
									$html .= '<input'.
									         ' type="hidden"'.
									         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---update"'.
									         ' name="'.esc_attr($field['name_prefix'].$field['name'].'[___update]').'"'.
									         ' value="'.esc_attr('___update').'"'.
									         '/>';
								}
							$html .= '<input'. // MANY conditions here.

							         ' type="'.esc_attr($field['type']).'"'.
							         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
							         ((in_array($field['type'], $this->button_types, TRUE)) ? '' : ' name="'.esc_attr($field['name_prefix'].$field['name'].(($field['type'] === 'file' && $field['multiple']) ? '[]' : '')).'"').
							         (($field['type'] === 'hidden') ? '' : ' class="'.esc_attr($field['ui_prefix'].'form-field-'.((in_array($field['type'], $this->button_types, TRUE)) ? 'tag-button' : 'tag').' '.$field['ui_prefix'].'corner-all').(($field['mono']) ? ' '.esc_attr($field['ui_prefix'].'form-field-mono') : '').esc_attr($field['common_classes']).'"').

							         (($field['type'] === 'file') ? '' // Exclude (NOT possible to define a value for files).
								         : ((in_array($field['type'], $this->single_check_types, TRUE)) ? ' value="'.esc_attr($field['checked_value']).'"'
									         : ((!isset($value)) ? ' value="'.esc_attr($field['default_value']).'"' : ' value="'.esc_attr((string)$value).'"'))).

							         ((in_array($field['type'], $this->single_check_types, TRUE)
							           && ((!isset($value) && $field['checked_by_default']) || (is_string($value) && $value === $field['checked_value'])))
								         ? ' checked="checked"' : '').

							         (($field['src'] && $field['type'] === 'image') ? ' src="'.esc_attr($field['src']).'"' : '').
							         (($field['alt'] && $field['type'] === 'image') ? ' alt="'.esc_attr($field['alt']).'"' : '').
							         (($field['accept'] && $field['type'] === 'file') ? ' accept="'.esc_attr($field['accept']).'"' : '').
							         (($field['multiple'] && $field['type'] === 'file') ? ' multiple="multiple"' : '').

							         ((in_array($field['type'], $this->button_types, TRUE)) ? '' // Exclude.
								         : (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
								           (($field['maxlength'] && !in_array($field['type'], array_merge($this->single_check_types, array('file')), TRUE)) ? ' maxlength="'.esc_attr((string)$field['maxlength']).'"' : '').
								           (($field['unique'] && !in_array($field['type'], array_merge($this->single_check_types, array('file')), TRUE)) ? ' data-unique="'.esc_attr('true').'" data-unique-callback="'.esc_attr($field['unique_callback_js']).'"' : '').
								           (($field['validation_patterns']) ? ' '.$this->validation_attrs($field['validation_patterns']) : '')).

							         (($field['type'] === 'hidden') ? '' // Exclude.
								         : (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').
								           (($field['title']) ? ' title="'.esc_attr($field['title']).'"' : '')).

							         ((in_array($field['type'], array_merge($this->button_types, $this->single_check_types, array('file', 'hidden')), TRUE)) ? '' // Exclude.
								         : ((!$field['autocomplete']) ? ' autocomplete="off"' : '').
								           ((!$field['spellcheck']) ? ' spellcheck="false"' : '')).

							         (($field['readonly']) ? ' readonly="readonly"' : '').
							         (($field['disabled']) ? ' disabled="disabled"' : '').

							         $field['common_attrs'].
							         ' />'.

							         ((in_array($field['type'], $this->single_check_types, TRUE)) ?

								         '<label'.
								         ' for="'.esc_attr($field['id_prefix'].$field['id']).'"'.
								         ' class="'.esc_attr($field['ui_prefix'].'form-field-check-label').(($field['mono']) ? ' '.esc_attr($field['ui_prefix'].'form-field-mono') : '').esc_attr($field['common_classes']).'"'.
								         $field['common_attrs'].
								         '>'.

								         ' '.$field['check_label'].

								         '</label>'

								         : '');
						}
					else throw $this->©exception(__METHOD__.'#invalid_type', get_defined_vars(),
					                             sprintf($this->i18n('Invalid form field type: `%1$s`.'), $field['type']));

					if($field['type'] !== 'hidden') // Close container?
						$html .= '</div>'; // Closes container dive tag now.

					if($field['extra_details'] && $field['type'] !== 'hidden')
						{
							$html .= '<div'.
							         ' class="'.esc_attr($field['ui_prefix'].'form-field-extra-details'.$field['common_classes']).'"'.
							         $field['common_attrs'].
							         '>'.

							         $field['extra_details'].

							         '</div>';
						}
					if($field['type'] !== 'hidden') // Close wrapper?
						$html .= '</div>'; // Closes wrapper dive tag now.

					if($field['confirm'] && in_array($field['type'], $this->confirmable_types, TRUE))
						{
							$field_clone                        = $field; // Clone.
							$field_clone['confirm']             = FALSE; // Confirm ONE time only.
							$field_clone['unique']              = FALSE; // No unique enforcements.
							$field_clone['unique_callback_js']  = ''; // No unique enforcements.
							$field_clone['unique_callback_php'] = NULL; // No unique enforcements.
							$field_clone['required']            = FALSE; // No required enforcements.
							$field_clone['maxlength']           = 0; // No maxlength enforcements.
							$field_clone['name_prefix']         = 'c_'.$field_clone['name_prefix']; // Prefix.
							$field_clone['code']                = 'c_'.$field_clone['code']; // Prefix.
							$field_clone['id_prefix']           = 'c-'.$field_clone['id_prefix']; // Prefix.
							$field_clone['label']               = $field_clone['details'] = $field_clone['extra_details'] = ''; // Empty these.
							if($field_clone['confirmation_label']) // Has a confirmation label for this scenario?
								$field_clone['label'] = $field_clone['confirmation_label'];

							$html .= $this->construct_field_markup($field_value, $field_clone);
						}
					return $html; // HTML markup.
				}

			/**
			 * Validates form field values against form field configurations.
			 *
			 * @param array                       $field_values An array of field values to be validated here.
			 *
			 * @param null|array                  $fields Optional. Field configuration arrays.
			 *    If this is NULL, we use {@link $generated_fields} as a default value.
			 *
			 * @param null|integer|\WP_User|users $user The user we're working with here.
			 *
			 * @param array                       $args Optional. Arguments that control validation behavior.
			 *
			 * @return boolean|errors Either a TRUE value (no errors); or an errors object instance.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @note This is an EXTREMELY COMPLEX routine that should NOT be modified without serious consideration.
			 */
			public function validate($field_values, $fields = NULL, $user = NULL, $args = array())
				{
					$this->check_arg_types('array', array('null', 'array'), $this->©user_utils->which_types(), 'array', func_get_args());

					if(!isset($fields)) $fields = $this->generated_fields;
					$user         = $this->©user_utils->which($user);
					$default_args = array( // Defaults.
						'enforce_required_fields'  => TRUE,
						'validate_readonly_fields' => FALSE,
						'validate_disabled_fields' => FALSE
					); // All of these arguments are optional at all times.
					$args         = $this->check_extension_arg_types('boolean', 'boolean', 'boolean', 'boolean', $default_args, $args);
					$errors       = $this->©errors(); // Initialize an errors object (we deal w/ these below).

					if($args['enforce_required_fields']) foreach($fields as $_key => $_field)
						{
							$_value = NULL; // A default value (e.g. assume NOT set).
							if(isset($field_values[$_key])) $_value = $field_values[$_key];
							if(is_array($_value)) unset($_value['___update'], $_value['___file_info']);

							$_field = $this->standardize_field_config($_value, $_field); // Standardize.

							if(!$_field['required'] || !$args['enforce_required_fields']) continue;
							if($_field['readonly'] && !$args['validate_readonly_fields']) continue;
							if($_field['disabled'] && !$args['validate_disabled_fields']) continue;

							if(in_array($_field['type'], array('image', 'button', 'reset', 'submit'), TRUE))
								// Notice that we do NOT exclude hidden input fields here.
								continue; // Exclude (these are NEVER required).

							switch($_field['type']) // Some field types are handled a bit differently here.
							{
								case 'select': // We also check for multiple selections (i.e. `multiple="multiple"`).

										if($_field['multiple']) // Allows multiple selections?
											{
												foreach($_field['validation_patterns'] as $_validation_pattern)
													{
														if($_validation_pattern['min_max_type'] === 'array_length')
															if(isset($_validation_pattern['minimum']) && $_validation_pattern['minimum'] > 1)
																if(!isset($_validation_abs_minimum) || $_validation_pattern['minimum'] < $_validation_abs_minimum)
																	$_validation_abs_minimum = $_validation_pattern['minimum'];
													}
												if(isset($_validation_abs_minimum) && (!is_array($_value) || count($_value) < $_validation_abs_minimum))
													$errors->add(
														__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														sprintf($this->translate('Please select at least %1$s options.'), $_validation_abs_minimum)
													);
												else if(!is_array($_value) || count($_value) < 1)
													$errors->add(
														__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														$this->translate('Please select at least 1 option.')
													);
												unset($_validation_pattern, $_validation_abs_minimum); // A bit of housekeeping here.
											}
										else if(!is_string($_value) || !strlen($_value))
											$errors->add(
												__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
												$this->translate('This is a required field.')
											);
										break;

								case 'file': // We also check for multiple files (i.e. `multiple="multiple"`).

										if($_field['multiple']) // Allows multiple file uploads?
											{
												foreach($_field['validation_patterns'] as $_validation_pattern)
													{
														if($_validation_pattern['min_max_type'] === 'array_length')
															if(isset($_validation_pattern['minimum']) && $_validation_pattern['minimum'] > 1)
																if(!isset($_validation_abs_minimum) || $_validation_pattern['minimum'] < $_validation_abs_minimum)
																	$_validation_abs_minimum = $_validation_pattern['minimum'];
													}
												if(isset($_validation_abs_minimum) && (!is_array($_value) || count($_value) < $_validation_abs_minimum))
													$errors->add(
														__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														sprintf($this->translate('Please select at least %1$s files.'), $_validation_abs_minimum)
													);
												else if(!is_array($_value) || count($_value) < 1)
													$errors->add(
														__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														$this->translate('Please select at least one file.')
													);
												unset($_validation_pattern, $_validation_abs_minimum); // A bit of housekeeping here.
											}
										else if(!is_string($_value) || !strlen($_value))
											$errors->add(
												__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
												$this->translate('A file MUST be selected please.')
											);
										break;

								case 'radio':
								case 'radios':
										if(!is_string($_value) || !strlen($_value))
											$errors->add(
												__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
												$this->translate('Please choose one of the available options.')
											);
										break;

								case 'checkbox':
										if(!is_string($_value) || !strlen($_value))
											$errors->add(
												__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
												$this->translate('This box MUST be checked please.')
											);
										break;

								case 'checkboxes':
										foreach($_field['validation_patterns'] as $_validation_pattern)
											{
												if($_validation_pattern['min_max_type'] === 'array_length')
													if(isset($_validation_pattern['minimum']) && $_validation_pattern['minimum'] > 1)
														if(!isset($_validation_abs_minimum) || $_validation_pattern['minimum'] < $_validation_abs_minimum)
															$_validation_abs_minimum = $_validation_pattern['minimum'];
											}
										if(isset($_validation_abs_minimum) && (!is_array($_value) || count($_value) < $_validation_abs_minimum))
											$errors->add(
												__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
												sprintf($this->translate('Please check at least %1$s boxes.'), $_validation_abs_minimum)
											);
										else if(!is_array($_value) || count($_value) < 1)
											$errors->add(
												__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
												$this->translate('Please check at least one box.')
											);
										unset($_validation_pattern, $_validation_abs_minimum); // A bit of housekeeping here.

										break;

								default: // Everything else (including textarea fields).

									if(!is_string($_value) || !strlen($_value))
										$errors->add(
											__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
											$this->translate('This is a required field.')
										);
							}
						}
					unset($_key, $_field, $_value); // Housekeeping.

					foreach($fields as $_key => $_field) // Iterates field configurations.
						{
							$_value = $_file_info = NULL; // Default values (e.g. assume NOT set).
							if(isset($field_values[$_key])) $_value = $field_values[$_key];
							if(is_array($_value)) unset($_value['___update']);

							// Collect file info (if applicable).

							if(!empty($_field['type']) && $_field['type'] === 'file')
								if(is_array($_value) && $this->©array->is($_value['___file_info']))
									{
										$_file_info = $_value['___file_info'];
										unset($_value['___file_info']); // Remove file info.
									}
								else if(is_string($_value) && $this->©array->is($field_values['___file_info'][$_key]))
									$_file_info = $field_values['___file_info'][$_key];

							$_field = $this->standardize_field_config($_value, $_field); // Standardize.

							// Catch invalid data types. These should always trigger an error.

							if(isset($_value) && ($_field['multiple'] || $_field['type'] === 'checkboxes') && !is_array($_value))
								{
									$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
									             $this->translate('Invalid data type. Expecting an array.'));
									continue; // We CANNOT validate this any further.
								}
							if(isset($_value) && !$_field['multiple'] && $_field['type'] !== 'checkboxes' && !is_string($_value))
								{
									$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
									             $this->translate('Invalid data type. Expecting a string.'));
									continue; // We CANNOT validate this any further.
								}
							// Catch readonly/disabled fields.

							if($_field['readonly'] && !$args['validate_readonly_fields']) continue;
							if($_field['disabled'] && !$args['validate_disabled_fields']) continue;

							if(isset($_value) && $_field['disabled']) // Callers should handle this.
								{
									$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
									             $this->translate('Invalid data. Disabled fields should NOT be submitted w/ a value.'));
									continue; // We CANNOT validate this any further.
								}
							// Catch field types that we NEVER validate any further.

							if(in_array($_field['type'], array('image', 'button', 'reset', 'submit'), TRUE))
								// Notice that we do NOT exclude hidden input fields here.
								continue; // Exclude (these are NEVER validated any further).

							// Catch any other NULL, empty and/or invalid values. Stop here?

							if(!isset($_value) || (!is_string($_value) && !is_array($_value))
							   || (is_string($_value) && !strlen($_value)) || (is_array($_value) && !$_value)
							) if(!$_field['required'] || !$args['enforce_required_fields']) continue;
							else // This warrants an error. This field value is invalid or missing.
								{
									if(!$errors->get_code(__METHOD__.'#'.$_field['code'])) // Avoid duplicate errors.
										$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
										             $this->translate('This is a required field.'));
									continue; // We CANNOT validate this any further.
								}
							// Handle validation patterns now. This is an extremely complex routine.

							foreach($_field['validation_patterns'] as $_validation_pattern) // Check all validation patterns.
								{
									if($errors->get_code(__METHOD__.'#vp_'.$_field['code']))
										$_validation_description_prefix = $this->translate('<strong>OR:</strong>');
									else $_validation_description_prefix = $this->translate('<strong>REQUIRES:</strong>');

									if(!is_array($_error_data = $errors->get_data(__METHOD__.'#vp_'.$_field['code'])) || $_error_data['validation_pattern_name'] !== $_validation_pattern['name'])
										switch($_field['type']) // Based on field type.
										{
											case 'file': // Handle file upload selections.

													if($_field['multiple']) // Allows multiple?
														{
															if(!is_array($_value)) // Invalid data type?
																$errors->add(__METHOD__.'#vp_'.$_field['code'],
																             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																             $_validation_description_prefix.' '.$_validation_pattern['description']);

															else foreach($_value as $__key => $__value) if(!is_string($__value) || !preg_match($_validation_pattern['regex'], $__value))
																{
																	$errors->add(__METHOD__.'#vp_'.$_field['code'],
																	             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																	             $_validation_description_prefix.' '.$_validation_pattern['description']);
																	break; // No need to check any further.
																}
															unset($__key, $__value); // Housekeeping.
														}
													else if(!is_string($_value) || !preg_match($_validation_pattern['regex'], $_value))
														$errors->add(__METHOD__.'#vp_'.$_field['code'],
														             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
														             $_validation_description_prefix.' '.$_validation_pattern['description']);

													break; // Break switch handler.

											default: // All other types (excluding multiples).

												if(!$_field['multiple'] && $_field['type'] !== 'checkboxes') // Exclusions w/ predefined values.
													{
														if(!is_string($_value) || !preg_match($_validation_pattern['regex'], $_value))
															$errors->add(__METHOD__.'#vp_'.$_field['code'],
															             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
															             $_validation_description_prefix.' '.$_validation_pattern['description']);
													}
												break; // Break switch handler.
										}
									if(!is_array($_error_data = $errors->get_data(__METHOD__.'#vp_'.$_field['code'])) || $_error_data['validation_pattern_name'] !== $_validation_pattern['name'])
										if(isset($_validation_pattern['minimum']) || isset($_validation_pattern['maximum']))
											switch($_validation_pattern['min_max_type']) // Handle this based on min/max type.
											{
												case 'numeric_value': // Against min/max numeric value.

														switch($_field['type']) // Based on field type.
														{
															default: // All other types (minus exclusions w/ predefined and/or non-numeric values).

																if(!in_array($_field['type'], array('file', 'select', 'radio', 'radios', 'checkbox', 'checkboxes'), TRUE))
																	{
																		if(!is_string($_value)) // Invalid data type?
																			$errors->add(__METHOD__.'#vp_'.$_field['code'],
																			             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																			             $_validation_description_prefix.' '.$_validation_pattern['description']);

																		else if(isset($_validation_pattern['minimum']) && (!is_numeric($_value) || $_value < $_validation_pattern['minimum']))
																			$errors->add(__METHOD__.'#vp_'.$_field['code'],
																			             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																			             $_validation_description_prefix.' '.$_validation_pattern['description']);

																		else if(isset($_validation_pattern['maximum']) && (!is_numeric($_value) || $_value > $_validation_pattern['maximum']))
																			$errors->add(__METHOD__.'#vp_'.$_field['code'],
																			             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																			             $_validation_description_prefix.' '.$_validation_pattern['description']);
																	}
																break; // Break switch handler.
														}
														break; // Break switch handler.

												case 'file_size': // Against total file size.

														switch($_field['type']) // Based on field type.
														{
															case 'file': // Handle file upload selections.

																	if($_field['multiple']) // Allows multiple files?
																		{
																			if(!is_array($_value)) // Invalid data type?
																				$errors->add(__METHOD__.'#vp_'.$_field['code'],
																				             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																				             $_validation_description_prefix.' '.$_validation_pattern['description']);

																			else if($_file_info) // We need to collect the total file size and then run validation against that value.
																				{
																					$__size = 0; // Initialize total size of all files.

																					foreach($_value as $__key => $__value) if(!is_string($__value) || !isset($_file_info[$__key]))
																						{
																							$errors->add(__METHOD__.'#vp_'.$_field['code'],
																							             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																							             $_validation_description_prefix.' '.$_validation_pattern['description']);
																							break; // No need to check any further.
																						}
																					else $__size += $_file_info[$__key]['size']; // Of all files.

																					if(!is_array($_error_data = $errors->get_data(__METHOD__.'#vp_'.$_field['code'])) || $_error_data['validation_pattern_name'] !== $_validation_pattern['name'])
																						if(isset($_validation_pattern['minimum']) && (!is_numeric($__size) || $__size < $_validation_pattern['minimum']))
																							$errors->add(__METHOD__.'#vp_'.$_field['code'],
																							             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																							             $_validation_description_prefix.' '.$_validation_pattern['description']);

																						else if(isset($_validation_pattern['maximum']) && (!is_numeric($__size) || $__size > $_validation_pattern['maximum']))
																							$errors->add(__METHOD__.'#vp_'.$_field['code'],
																							             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																							             $_validation_description_prefix.' '.$_validation_pattern['description']);

																					unset($__size, $__key, $__value); // Housekeeping.
																				}
																		}
																	else // We're dealing with a single file in this case.
																		{
																			if(!is_string($_value)) // Invalid data type?
																				$errors->add(__METHOD__.'#vp_'.$_field['code'],
																				             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																				             $_validation_description_prefix.' '.$_validation_pattern['description']);

																			else if($_file_info && isset($_validation_pattern['minimum']) && (!is_numeric($_file_info['size']) || $_file_info['size'] < $_validation_pattern['minimum']))
																				$errors->add(__METHOD__.'#vp_'.$_field['code'],
																				             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																				             $_validation_description_prefix.' '.$_validation_pattern['description']);

																			else if($_file_info && isset($_validation_pattern['maximum']) && (!is_numeric($_file_info['size']) || $_file_info['size'] > $_validation_pattern['maximum']))
																				$errors->add(__METHOD__.'#vp_'.$_field['code'],
																				             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																				             $_validation_description_prefix.' '.$_validation_pattern['description']);
																		}
																	break; // Break switch handler.
														}
														break; // Break switch handler.

												case 'string_length': // Against string length.

														switch($_field['type']) // Based on field type.
														{
															default: // All other types (minus exclusions w/ predefined and/or N/A values).

																if(!in_array($_field['type'], array('file', 'select', 'radio', 'radios', 'checkbox', 'checkboxes'), TRUE))
																	{
																		if(!is_string($_value)) // Invalid data type?
																			$errors->add(__METHOD__.'#vp_'.$_field['code'],
																			             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																			             $_validation_description_prefix.' '.$_validation_pattern['description']);

																		else if(isset($_validation_pattern['minimum']) && (!is_string($_value) || strlen($_value) < $_validation_pattern['minimum']))
																			$errors->add(__METHOD__.'#vp_'.$_field['code'],
																			             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																			             $_validation_description_prefix.' '.$_validation_pattern['description']);

																		else if(isset($_validation_pattern['maximum']) && (!is_string($_value) || strlen($_value) > $_validation_pattern['maximum']))
																			$errors->add(__METHOD__.'#vp_'.$_field['code'],
																			             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																			             $_validation_description_prefix.' '.$_validation_pattern['description']);
																	}
																break; // Break switch handler.
														}
														break; // Break switch handler.

												case 'array_length': // Against array lengths.

														switch($_field['type']) // Based on field type.
														{
															case 'select': // Select menus w/ multiple options possible.
															case 'file': // Handle file upload selections w/ multiple files possible.
															case 'checkboxes': // Handle multiple file upload selections.

																	if($_field['multiple'] || $_field['type'] === 'checkboxes') // Allows multiple?
																		{
																			if(!is_array($_value)) // Invalid data type?
																				$errors->add(__METHOD__.'#vp_'.$_field['code'],
																				             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																				             $_validation_description_prefix.' '.$_validation_pattern['description']);

																			else if(isset($_validation_pattern['minimum']) && (!is_array($_value) || count($_value) < $_validation_pattern['minimum']))
																				$errors->add(__METHOD__.'#vp_'.$_field['code'],
																				             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																				             $_validation_description_prefix.' '.$_validation_pattern['description']);

																			else if(isset($_validation_pattern['maximum']) && (!is_array($_value) || count($_value) > $_validation_pattern['maximum']))
																				$errors->add(__METHOD__.'#vp_'.$_field['code'],
																				             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
																				             $_validation_description_prefix.' '.$_validation_pattern['description']);
																		}
																	break; // Break switch handler.
														}
														break; // Break switch handler.
											}
									if(is_array($_error_data = $errors->get_data(__METHOD__.'#vp_'.$_field['code'])) && $_error_data['validation_pattern_name'] !== $_validation_pattern['name'])
										$errors->remove(__METHOD__.'#vp_'.$_field['code']); // If this one passes, it negates all existing validation pattern errors.
								}
							unset($_validation_pattern, $_validation_description_prefix, $_error_data); // Housekeeping.

							if($errors->get_code(__METHOD__.'#vp_'.$_field['code'])) continue; // No need to go any further.

							if($_field['maxlength']) // Validate string length against max allowed chars?
								switch($_field['type']) // Based on field type.
								{
									default: // All other types (minus exclusions w/ predefined and/or N/A values).

										if(!in_array($_field['type'], array('file', 'select', 'radio', 'radios', 'checkbox', 'checkboxes'), TRUE))
											{
												if(!is_string($_value)) // Invalid data type?
													{
														$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														             $this->translate('Invalid data type. Expecting a string.'));
														continue 2; // We CANNOT validate this any further.
													}
												else if(strlen($_value) > $_field['maxlength'])
													{
														$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														             sprintf($this->translate('Too long. Max string length: `%1$s` characters.'), $_field['maxlength']));
														continue 2; // We CANNOT validate this any further.
													}
											}
										break; // Break switch handler.
								}
							if($_field['unique']) // Check uniqueness w/ a callback?
								switch($_field['type']) // Based on field type.
								{
									default: // All other types (minus exclusions w/ predefined and/or N/A values).

										if(!in_array($_field['type'], array('file', 'select', 'radio', 'radios', 'checkbox', 'checkboxes'), TRUE))
											{
												if(!is_string($_value)) // Invalid data type?
													{
														$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														             $this->translate('Invalid data type. Expecting a string.'));
														continue 2; // We CANNOT validate this any further.
													}
												else if(!$_field['unique_callback_php'] || !is_callable($_field['unique_callback_php']))
													{
														$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														             $this->translate('Unable to validate. Invalid unique callback.'));
														continue 2; // We CANNOT validate this any further.
													}
												else if(!$_field['unique_callback_php']($_value, $user))
													{
														$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														             $this->translate('Please try again (this value MUST be unique please).'));
														continue 2; // We CANNOT validate this any further.
													}
											}
										break; // Break switch handler.
								}
							// Handle file errors (when/if applicable; during file uploads).

							if($_field['type'] === 'file' && $_file_info) // Should check?
								{
									if($_field['multiple']) // Allows multiple files?
										{
											if(!is_array($_value)) // Invalid data type?
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             $this->translate('Invalid data type. Expecting an array.'));
													continue; // We CANNOT validate this any further.
												}
											else foreach($_value as $__key => $__value)
												if(!is_string($__value) || !isset($_file_info[$__key]) || $_file_info[$__key]['error'] !== UPLOAD_ERR_OK)
													{
														$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														             $this->translate('File upload failure.').' '.$this->©string->file_upload_error($_file_info[$__key]['error']));
														continue 2; // We CANNOT validate this any further.
													}
											unset($__key, $__value); // Housekeeping.
										}
									else // We're dealing with a single file in this case.
										{
											if(!is_string($_value)) // Invalid data type?
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             $this->translate('Invalid data type. Expecting a string.'));
													continue; // We CANNOT validate this any further.
												}
											else if($_file_info['error'] !== UPLOAD_ERR_OK)
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             $this->translate('File upload failure.').' '.$this->©string->file_upload_error($_file_info['error']));
													continue; // We CANNOT validate this any further.
												}
										}
								}
							// Handle file MIME types now (when/if applicable; during file uploads).

							if($_field['type'] === 'file' && $_field['accept'] && $_file_info) // Should check?
								{
									$_mime_types        = $this->©file->mime_types();
									$_wildcard_patterns = preg_split('/[;,]+/', $_field['accept'], NULL, PREG_SPLIT_NO_EMPTY);

									if($_field['multiple']) // Allows multiple files?
										{
											if(!is_array($_value)) // Invalid data type?
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             $this->translate('Invalid data type. Expecting an array.'));
													continue; // We CANNOT validate this any further.
												}
											else foreach($_value as $__key => $__value)
												if(!is_string($__value) || !isset($_file_info[$__key])
												   || (!$this->©string->in_wildcard_patterns($_file_info[$__key]['type'], $_wildcard_patterns, TRUE)
												       && (!$_file_info[$__key]['name'] || !($__extension = $this->©file->extension($_file_info[$__key]['name'])) || empty($_mime_types[$__extension])
												           || !$this->©string->in_wildcard_patterns($_mime_types[$__extension], $_wildcard_patterns, TRUE)))
												) // Check MIME type from browser; and also MIME type as determined by the file extension.
													{
														$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														             sprintf($this->translate('Invalid MIME type. Expecting: `%1$s`.'), $_field['accept']));
														continue 2; // We CANNOT validate this any further.
													}
											unset($__key, $__value, $__extension); // Housekeeping.
										}
									else // We're dealing with a single file in this case.
										{
											if(!is_string($_value)) // Invalid data type?
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             $this->translate('Invalid data type. Expecting a string.'));
													continue; // We CANNOT validate this any further.
												}
											else if(!$this->©string->in_wildcard_patterns($_file_info['type'], $_wildcard_patterns, TRUE)
											        && (!$_file_info['name'] || !($__extension = $this->©file->extension($_file_info['name'])) || empty($_mime_types[$__extension])
											            || !$this->©string->in_wildcard_patterns($_mime_types[$__extension], $_wildcard_patterns, TRUE))
											) // Check MIME type from browser; and also MIME type as determined by the file extension.
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             sprintf($this->translate('Invalid MIME type. Expecting: `%1$s`.'), $_field['accept']));
													continue; // We CANNOT validate this any further.
												}
											unset($__extension); // Housekeeping.
										}
									unset($_mime_types, $_wildcard_patterns); // Housekeeping.
								}
							// Handle file processing now (when/if applicable; during file uploads).
							// We ONLY move each file ONE time. This routine caches each `tmp_name` statically.

							if($_field['type'] === 'file' && $_field['move_to_dir'] && $_file_info) // Should move?
								{
									$__abspath             = $this->©dir->n_seps(ABSPATH);
									$_field['move_to_dir'] = $this->©dir->n_seps($_field['move_to_dir']);
									if(strpos($_field['move_to_dir'].'/', $__abspath.'/') !== 0) // Force into WordPress®.
										$_field['move_to_dir'] = $__abspath.'/'.ltrim($_field['move_to_dir'], '/');
									unset($__abspath); // Housekeeping.

									if(!is_dir($_field['move_to_dir']) && is_writable($this->©dir->n_seps_up($_field['move_to_dir'])))
										{
											mkdir($_field['move_to_dir'], 0775, TRUE); // Recursively.
											// However, the parent directory MUST exist already (as seen above).
											clearstatcache(); // Clear cache before checking again.

											if(!is_dir($_field['move_to_dir']) || !is_writable($_field['move_to_dir']))
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             $this->translate('Unable to handle file upload(s). Unable to move uploaded file(s).').
													             sprintf($this->translate(' Move-to directory NOT writable: `%1$s`.'), $_field['move_to_dir']));
													continue; // We CANNOT validate this any further.
												}
										} // If we get here, the directory exists.

									if($_field['multiple']) // Uploading multiple files?
										{
											if(!is_array($_value)) // Invalid data type?
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             $this->translate('Invalid data type. Expecting an array.'));
													continue; // We CANNOT validate this any further.
												}
											else foreach($_value as $__key => $__value)
												if(!is_string($__value) || !isset($_file_info[$__key])
												   || !$_file_info[$__key]['tmp_name'] || !$_file_info[$__key]['name']
												   || (!isset($this->static[__FUNCTION__.'_moved_tmp_name_to'][$_file_info[$__key]['tmp_name']])
												       && (!is_uploaded_file($_file_info[$__key]['tmp_name']) || !move_uploaded_file($_file_info[$__key]['tmp_name'], $_field['move_to_dir'].'/'.$_file_info[$__key]['name'])))
												) // File `name` value is always unique. See {@link vars::_merge_FILES_deeply_into()}.
													{
														$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
														             sprintf($this->translate('Unable to handle file upload. Unable to move to: `%1$s`.'), $_field['move_to_dir']));
														continue 2; // We CANNOT validate this any further.
													}
												else $this->static[__FUNCTION__.'_moved_tmp_name_to'][$_file_info[$__key]['tmp_name']] = $_field['move_to_dir'];

											unset($__key, $__value); // Housekeeping.
										}
									else // We're dealing with a single file in this case.
										{
											if(!is_string($_value)) // Invalid data type?
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             $this->translate('Invalid data type. Expecting a string.'));
													continue; // We CANNOT validate this any further.
												}
											else if(!$_file_info['tmp_name'] || !$_file_info['name']
											        || (!isset($this->static[__FUNCTION__.'_moved_tmp_name_to'][$_file_info['tmp_name']])
											            && (!is_uploaded_file($_file_info['tmp_name']) || !move_uploaded_file($_file_info['tmp_name'], $_field['move_to_dir'].'/'.$_file_info['name'])))
											) // File `name` value is always unique. See {@link vars::_merge_FILES_deeply_into()}.
												{
													$errors->add(__METHOD__.'#'.$_field['code'], array('form_field_code' => $_field['code']),
													             sprintf($this->translate('Unable to handle file upload. Unable to move to: `%1$s`.'), $_field['move_to_dir']));
													continue; // We CANNOT validate this any further.
												}
											else $this->static[__FUNCTION__.'_moved_tmp_name_to'][$_file_info['tmp_name']] = $_field['move_to_dir'];
										}
								}
						}
					unset($_key, $_field, $_value, $_file_info); // Housekeeping.

					return ($errors->exist()) ? $errors : TRUE;
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

					$attrs = ''; // Initialize string to contain all validation attributes.

					foreach(array_values($validation_patterns) /* Numerically indexed (always). */ as $_i => $_validation_pattern)
						$attrs .= (($_validation_pattern['name']) ? ' data-validation-name-'.$_i.'="'.esc_attr($_validation_pattern['name']).'"' : '').
						          (($_validation_pattern['description']) ? ' data-validation-description-'.$_i.'="'.esc_attr($_validation_pattern['description']).'"' : '').
						          (($_validation_pattern['regex']) ? ' data-validation-regex-'.$_i.'="'.esc_attr($_validation_pattern['regex']).'"' : '').
						          ((isset($_validation_pattern['minimum'])) ? ' data-validation-minimum-'.$_i.'="'.esc_attr((string)$_validation_pattern['minimum']).'"' : '').
						          ((isset($_validation_pattern['maximum'])) ? ' data-validation-maximum-'.$_i.'="'.esc_attr((string)$_validation_pattern['maximum']).'"' : '').
						          ((isset($_validation_pattern['min_max_type'])) ? ' data-validation-min-max-type-'.$_i.'="'.esc_attr($_validation_pattern['min_max_type']).'"' : '');

					unset($_i, $_validation_pattern); // Just a little housekeeping.

					return $attrs; // Return all attributes now.
				}

			/**
			 * Checks a field's configuration options.
			 *
			 * @param null|string (or scalar)|array $field_value The current value(s) for this field.
			 *    If there is NO current value, set this to NULL; so that default values are considered properly.
			 *    That is, default values are only implemented, if ``$value`` is currently NULL.
			 *
			 * @note The current ``$field_value`` will be piped through {@link value()} and/or {@link values()}.
			 *    In other words, we convert the ``$field_value`` into a NULL/string/array, depending upon the `type` of form field.
			 *    The current `call` action will also considered, if this instance is associated with one.
			 *    See: {@link value()} and {@link values()} for further details.
			 *
			 * @param array                         $field The array of field configuration options.
			 *
			 * @return array A fully validated, and completely standardized configuration array.
			 *    Otherwise, we throw an exception on any type of validation failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If invalid types are found in the configuration array.
			 * @throws exception If required config options are missing.
			 */
			public function standardize_field_config($field_value, $field)
				{
					$this->check_arg_types(array('null', 'scalar', 'array'), 'array:!empty', func_get_args());

					$value  = $this->value($field_value); // String (or NULL by default).
					$values = $this->values($field_value); // Array (or NULL by default).

					foreach($this->defaults as $_key => $_default) // Validate types.
						if(array_key_exists($_key, $field) && !is_null($_default) && gettype($field[$_key]) !== gettype($_default))
							throw $this->©exception( // There's a problem with this key.
								__METHOD__.'#invalid_key', get_defined_vars(),
								sprintf($this->i18n('Form field. Invalid key: `%1$s`.'), $_key).
								sprintf($this->i18n(' Invalid field configuration: `%1$s`.'), $this->©var->dump($field)).
								sprintf($this->i18n(' Defaults: `%1$s`.'), $this->©var->dump($this->defaults))
							);
					unset($_key, $_default); // Just a little housekeeping.

					$field = array_merge($this->defaults, $field); // Merge with defaults.

					// Handle field types.

					if(!$field['type'])
						throw $this->©exception(
							__METHOD__.'#type_missing', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (missing `type`).')
						);
					if(!in_array($field['type'], $this->types, TRUE))
						throw $this->©exception(
							__METHOD__.'#invalid_type', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (invalid `type`).')
						);
					if($field['confirm'] && !in_array($field['type'], $this->confirmable_types, TRUE))
						throw $this->©exception(
							__METHOD__.'#invalid_type', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (NOT a confirmable `type`).')
						);
					// Handle field names (and we consider a name prefix here too).

					if(!$field['name'])
						throw $this->©exception(
							__METHOD__.'#missing_name', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (missing `name`).').
							sprintf($this->i18n(' Got: `%1$s`.'), $field['name'])
						);
					if(!preg_match('/^(?:[a-z][a-z0-9_]*?[a-z0-9]|[a-z])(?:\[(?:[a-z][a-z0-9_]*?[a-z0-9]|[1-9][0-9]+|[0-9]|[a-z])\])*$/i', $field['name_prefix'].$field['name']))
						throw $this->©exception(
							__METHOD__.'#invalid_name_prefix_name', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (invalid `name_prefix`.`name`).').
							sprintf($this->i18n(' Got: `%1$s`.'), $field['name_prefix'].$field['name'])
						);
					// Handle field end name/code.

					if(!$field['code']) // We can auto-generate this.
						{
							$field['code'] = str_replace(array('[', ']'), '/', $field['name']);
							$field['code'] = basename(rtrim($field['code'], '/'));
						}
					if(!$field['code'])
						throw $this->©exception(
							__METHOD__.'#missing_code', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (missing `code`).').
							sprintf($this->i18n(' Got: `%1$s`.'), $field['code'])
						);
					if(!preg_match('/^(?:[a-z][a-z0-9_]*?[a-z0-9]|[1-9][0-9]+|[0-9]|[a-z])$/i', $field['code']))
						throw $this->©exception(
							__METHOD__.'#invalid_code', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (invalid `code`).').
							sprintf($this->i18n(' Got: `%1$s`.'), $field['code'])
						);
					// Handle field ID values.

					if(!$field['id']) // We can auto-generate IDs.
						$field['id'] = 'md5-'.strtolower(md5($field['name']));

					if(!$field['id'])
						throw $this->©exception(
							__METHOD__.'#missing_id', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (missing `id`).').
							sprintf($this->i18n(' Got: `%1$s`.'), $field['id'])
						);
					if(!preg_match('/^(?:[a-z][a-z0-9\-]*?[a-z0-9]|[a-z])$/i', $field['id_prefix'].$field['id']))
						throw $this->©exception(
							__METHOD__.'#invalid_id_prefix_id', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (invalid `id_prefix`.`id`).').
							sprintf($this->i18n(' Got: `%1$s`.'), $field['id_prefix'].$field['id'])
						);
					// Handle field icons.

					if(in_array($field['type'], $this->types_with_icons, TRUE) && !$field['icon'])
						if(!empty($this->default_icons_by_type[$field['type']]))
							$field['icon'] = $this->default_icons_by_type[$field['type']];
						else throw $this->©exception(
							__METHOD__.'#icon_missing', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (missing `icon`).')
						);
					// Handle field options.

					$field['options'] = array_values($field['options']);
					$_option_defaults = array('label' => '', 'value' => '', 'is_default' => FALSE);

					foreach($field['options'] as &$_option)
						{
							$_option = array_merge($_option_defaults, (array)$_option);

							if(!$this->©strings->are_set($_option['label'], $_option['value']) || !is_bool($_option['is_default']))
								throw $this->©exception(
									__METHOD__.'#invalid_options', get_defined_vars(),
									$this->i18n('Form field. Invalid configuration (invalid `options`).')
								);
						}
					unset($_option_defaults, $_option); // Housekeeping.

					if(in_array($field['type'], $this->types_with_options, TRUE) && !$field['options'])
						throw $this->©exception(
							__METHOD__.'#options_missing', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (missing `options`).')
						);
					// Handle unique fields (validate PHP callback).

					if($field['unique'] && !is_callable($field['unique_callback_php']))
						throw $this->©exception(
							__METHOD__.'#missing_unique_callback_php', get_defined_vars(),
							$this->i18n('Form field. Invalid configuration (missing and/or invalid `unique_callback_php`).').
							sprintf($this->i18n(' Expecting callable. Got: `%1$s`.'), $this->©var->dump($field['unique_callback_php']))
						);
					// Handle validation patterns.

					$_validation_pattern_defaults = array(
						'name'    => '', 'description' => '', 'regex' => '',
						'minimum' => NULL, 'maximum' => NULL, 'min_max_type' => NULL);
					$field['validation_patterns'] = array_values($field['validation_patterns']);

					foreach($field['validation_patterns'] as &$_validation_pattern)
						{
							$_validation_pattern = array_merge($_validation_pattern_defaults, (array)$_validation_pattern);

							if((!$this->©strings->are_not_empty($_validation_pattern['name'], $_validation_pattern['description'], $_validation_pattern['regex']))
							   || (!is_null($_validation_pattern['minimum']) && !is_numeric($_validation_pattern['minimum']))
							   || (!is_null($_validation_pattern['maximum']) && !is_numeric($_validation_pattern['maximum']))
							   || (!is_null($_validation_pattern['min_max_type']) && !$this->©string->is_not_empty($_validation_pattern['min_max_type']))
							) throw $this->©exception(
								__METHOD__.'#invalid_validation_patterns', get_defined_vars(),
								$this->i18n('Form field. Invalid configuration (invalid `validation_patterns`).')
							);
						}
					unset($_validation_pattern_defaults, $_validation_pattern); // Housekeeping.

					// Handle field titles.

					if(!$field['title'] && $field['label']) $field['title'] = $field['label'];
					else if(!$field['title'] && in_array($field['type'], $this->button_types, TRUE) && is_string($value))
						$field['title'] = $value; // Use button value.

					// Handle common classes.

					if($field['common_classes']) $field['common_classes'] = ' '.$field['common_classes'];
					if($this->common_classes && trim($field['common_classes']) !== $this->common_classes)
						$field['common_classes'] .= ' '.$this->common_classes;

					// Handle common attributes.

					if($field['common_attrs']) $field['common_attrs'] = ' '.$field['common_attrs'];
					if($this->common_attrs && trim($field['common_attrs']) !== $this->common_attrs)
						$field['common_attrs'] .= ' '.$this->common_attrs;

					// Handle div wrapper classes.

					if($field['div_wrapper_classes']) // Add padding to these.
						$field['div_wrapper_classes'] = ' '.$field['div_wrapper_classes'];

					return $field; // Standardized now.
				}

			/**
			 * Gets a string form field value.
			 *
			 * @note This considers the current action call (if this instance is associated with one).
			 *
			 * @param mixed $value A variable (always by reference).
			 *    See {@link ¤value()}, to pass a variable and/or an expression.
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

					if($this->is_action_for_call)
						return '';

					return NULL;
				}

			/**
			 * Same as {@link value()}, but this allows an expression.
			 *
			 * @param mixed $value A variable (or an expression).
			 *
			 * @return string|null See {@link value()} for further details.
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
			 *    See {@link ¤values()}, to pass a variable and/or an expression.
			 *
			 * @return array|null An array if ``$values`` is an array, or this is the current action.
			 *    Else this returns NULL by default, so that default form field values can be considered properly.
			 */
			public function values(&$values)
				{
					if(is_array($values))
						return $values;

					if($this->is_action_for_call)
						return array();

					return NULL;
				}

			/**
			 * Same as {@link values()}, but this allows an expression.
			 *
			 * @param mixed $values A variable (or an expression).
			 *
			 * @return array|null See {@link values()} for further details.
			 */
			public function ¤values($values)
				{
					return $this->values($values);
				}
		}
	}