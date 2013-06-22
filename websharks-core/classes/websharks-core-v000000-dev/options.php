<?php
/**
 * Options.
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
		 * Options.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class options extends framework
		{
			/**
			 * Array of options.
			 *
			 * @var array Defaults to an empty array.
			 */
			public $options = array();

			/**
			 * Array of default options.
			 *
			 * @var array Defaults to an empty array.
			 */
			public $default_options = array();

			/**
			 * Array of option validators.
			 *
			 * @var array Defaults to an empty array.
			 */
			public $validators = array();

			/**
			 * Constructor.
			 *
			 * @param object|array $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or a new ``$___instance_config`` array.
			 */
			public function __construct($___instance_config)
				{
					parent::__construct($___instance_config);

					$default_options = array(
						'encryption.key'                                     => '',

						'support.url'                                        => 'mailto:'.get_bloginfo('admin_email'),

						'no_cache.headers.always'                            => '0',

						'styles.front_side.load'                             => '0',
						'styles.front_side.load_by_default'                  => '0',
						'styles.front_side.load_themes'                      => array('jquery-ui-theme-default'),
						'styles.front_side.theme'                            => 'jquery-ui-theme-default',

						'scripts.front_side.load'                            => '0',
						'scripts.front_side.load_by_default'                 => '0',
						'scripts.front_side.load_jquery_via_google'          => '0',
						'scripts.admin_side.load_jquery_via_google'          => '0',

						'crons.config'                                       => array(),

						'shortcodes.if_conditionals.enable'                  => '0',
						'shortcodes.if_conditionals.restrict_functions'      => '1',
						'shortcodes.if_conditionals.other_functions_allowed' => array(),

						'menu_pages.theme'                                   => 'jquery-ui-theme-default',
						'menu_pages.panels.order'                            => array(),
						'menu_pages.panels.state'                            => array(),

						'ips.prioritize_remote_addr'                         => '0',

						'captchas.google.public_key'                         => '6LeCANsSAAAAAIIrlB3FrXe42mr0OSSZpT0pkpFK',
						'captchas.google.private_key'                        => '6LeCANsSAAAAAGBXMIKAirv6G4PmaGa-ORxdD-oZ',

						'url_shortener.default_built_in_api'                 => 'goo_gl',
						'url_shortener.custom_url_api'                       => '',
						'url_shortener.api_keys.goo_gl'                      => '',

						'php.evaluate'                                       => '0',
						'php.post_types'                                     => array('page'),

						'compressor.enable'                                  => '0',
						'compressor.compress_if_logged_in'                   => '1',
						'compressor.compress_admin'                          => '1',
						'compressor.admin_regex_static_css_js'               => '/\.(?:css|js)[\?"\']/i',
						'compressor.compress_combine_head_body_css'          => '1',
						'compressor.compress_combine_head_js'                => '1',
						'compressor.compress_css_code'                       => '1',
						'compressor.compress_js_code'                        => '1',
						'compressor.compress_html_code'                      => '1',
						'compressor.compress_html_code_if_logged_in'         => '1',
						'compressor.compress_html_js_code'                   => '1',
						'compressor.cache_expiration'                        => '14 days',
						'compressor.css_exclusion_words'                     => array(),
						'compressor.js_exclusion_words'                      => array(
							'core__js_image_nonce_var' => 'imageNonce =',
							'core__user_settings_var'  => 'var userSettings'
						),
						'compressor.try_yui_compressor'                      => '0',
						'compressor.benchmark'                               => '1',
						'compressor.debug'                                   => '1',
						'compressor.vendor_css_prefixes'                     => array('moz', 'webkit', 'khtml', 'ms', 'o'),
						'compressor.wp_hook_priority'                        => '2',

						'installer.deactivation.uninstalls'                  => '0',

						'templates.stand_alone.styles'                       => '<style type="text/css">'."\n\n".'</style>',
						'templates.stand_alone.scripts'                      => '<script type="text/javascript">'."\n\n".'</script>',
						'templates.stand_alone.bg_style'                     => 'background: #FFFFFF;',
						'templates.stand_alone.header'                       => '',
						'templates.stand_alone.footer'                       => '',
						'templates.email.header'                             => '',
						'templates.email.footer'                             => '',

						'users.attach_init_hook'                             => '0',
						'users.registration.display_name_format'             => 'first_name',
						'users.attach_wp_authentication_filter'              => '0',

						'widgets.enable_shortcodes'                          => '0',

						'mail.smtp'                                          => '0',
						'mail.smtp.force_from'                               => '0',
						'mail.smtp.from_name'                                => get_bloginfo('name'),
						'mail.smtp.from_addr'                                => get_bloginfo('admin_email'),
						'mail.smtp.host'                                     => '',
						'mail.smtp.port'                                     => '0',
						'mail.smtp.secure'                                   => '',
						'mail.smtp.username'                                 => '',
						'mail.smtp.password'                                 => '',

						'plugin_site.username'                               => '',
						'plugin_site.password'                               => ''

					);
					$validators      = array(
						'encryption.key'                                     => array('string:!empty'),

						'support.url'                                        => array('string:!empty'),

						'no_cache.headers.always'                            => array('string:numeric >=' => 0),

						'styles.front_side.load'                             => array('string:numeric >=' => 0),
						'styles.front_side.load_by_default'                  => array('string:numeric >=' => 0),
						'styles.front_side.load_themes'                      => array('array'),
						'styles.front_side.theme'                            => array('string:!empty'),

						'scripts.front_side.load'                            => array('string:numeric >=' => 0),
						'scripts.front_side.load_by_default'                 => array('string:numeric >=' => 0),
						'scripts.front_side.load_jquery_via_google'          => array('string:numeric >=' => 0),
						'scripts.admin_side.load_jquery_via_google'          => array('string:numeric >=' => 0),

						'crons.config'                                       => array('array:!empty'),

						'shortcodes.if_conditionals.enable'                  => array('string:numeric >=' => 0),
						'shortcodes.if_conditionals.restrict_functions'      => array('string:numeric >=' => 0),
						'shortcodes.if_conditionals.other_functions_allowed' => array('array'),

						'menu_pages.theme'                                   => array('string:!empty'),
						'menu_pages.panels.order'                            => array('array:!empty'),
						'menu_pages.panels.state'                            => array('array:!empty'),

						'ips.prioritize_remote_addr'                         => array('string:numeric >=' => 0),

						'captchas.google.public_key'                         => array('string:!empty'),
						'captchas.google.private_key'                        => array('string:!empty'),

						'url_shortener.default_built_in_api'                 => array('string:in_array' => array('tiny_url', 'goo_gl')),
						'url_shortener.custom_url_api'                       => array('string:preg_match' => '/^https?\:/i'),
						'url_shortener.api_keys.goo_gl'                      => array('string:!empty'),

						'php.evaluate'                                       => array('string:numeric >=' => 0),
						'php.post_types'                                     => array('array:!empty'),

						'compressor.enable'                                  => array('string:numeric >=' => 0),
						'compressor.compress_if_logged_in'                   => array('string:numeric >=' => 0),
						'compressor.compress_admin'                          => array('string:numeric >=' => 0),
						'compressor.admin_regex_static_css_js'               => array('string:!empty'),
						'compressor.compress_combine_head_body_css'          => array('string:numeric >=' => 0),
						'compressor.compress_combine_head_js'                => array('string:numeric >=' => 0),
						'compressor.compress_css_code'                       => array('string:numeric >=' => 0),
						'compressor.compress_js_code'                        => array('string:numeric >=' => 0),
						'compressor.compress_html_code'                      => array('string:numeric >=' => 0),
						'compressor.compress_html_code_if_logged_in'         => array('string:numeric >=' => 0),
						'compressor.compress_html_js_code'                   => array('string:numeric >=' => 0),
						'compressor.cache_expiration'                        => array('string:!empty'),
						'compressor.css_exclusion_words'                     => array('array'),
						'compressor.js_exclusion_words'                      => array('array'),
						'compressor.try_yui_compressor'                      => array('string:numeric >=' => 0),
						'compressor.benchmark'                               => array('string:numeric >=' => 0),
						'compressor.debug'                                   => array('string:numeric >=' => 0),
						'compressor.vendor_css_prefixes'                     => array('array:!empty'),
						'compressor.wp_hook_priority'                        => array('string:numeric >=' => 1),

						'installer.deactivation.uninstalls'                  => array('string:numeric >=' => 0),

						'templates.stand_alone.styles'                       => array('string:!empty'),
						'templates.stand_alone.scripts'                      => array('string:!empty'),
						'templates.stand_alone.bg_style'                     => array('string'),
						'templates.stand_alone.header'                       => array('string:!empty'),
						'templates.stand_alone.footer'                       => array('string:!empty'),
						'templates.email.header'                             => array('string:!empty'),
						'templates.email.footer'                             => array('string:!empty'),

						'users.attach_init_hook'                             => array('string:numeric >=' => 0),
						'users.registration.display_name_format'             => array('string:!empty'),
						'users.attach_wp_authentication_filter'              => array('string:numeric >=' => 0),

						'widgets.enable_shortcodes'                          => array('string:numeric >=' => 0),

						'mail.smtp'                                          => array('string:numeric >=' => 0),
						'mail.smtp.force_from'                               => array('string:numeric >=' => 0),
						'mail.smtp.from_name'                                => array('string:!empty'),
						'mail.smtp.from_addr'                                => array('string:!empty'),
						'mail.smtp.host'                                     => array('string:!empty'),
						'mail.smtp.port'                                     => array('string:numeric >=' => 1),
						'mail.smtp.secure'                                   => array('string:in_array' => array('ssl', 'tls')),
						'mail.smtp.username'                                 => array('string:!empty'),
						'mail.smtp.password'                                 => array('string:!empty'),

						'plugin_site.username'                               => array('string:!empty'),
						'plugin_site.password'                               => array('string:!empty')
					);
					$this->setup($default_options, $validators);
				}

			/**
			 * Sets up default options and validators.
			 *
			 * @param array $default_options An associative array of default options.
			 * @param array $validators An array of validators (can be a combination of numeric/associative keys).
			 *
			 * @return array The current array of options.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``count($default_options) !== count($validators)``.
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    ($default_options, $validators) === array('unit' => '1', 'test' => array('1'))
			 */
			public function setup($default_options, $validators)
				{
					$this->check_arg_types('array', 'array', func_get_args());

					$default_options = $this->apply_filters('default_options', $default_options);
					$validators      = $this->apply_filters('validators', $validators);

					if(count($default_options) !== count($validators))
						throw $this->©exception( // This helps us catch mistakes.
							__METHOD__.'#options_mismatch_to_validators', get_defined_vars(),
							$this->i18n('Options mismatch. If you add a new default option, please add a validator for it also.').
							sprintf($this->i18n(' Got `%1$s` default options, `%2$s` validators. These should match up.'), count($default_options), count($validators))
						);
					if(!is_array($this->options = get_option($this->___instance_config->plugin_root_ns_stub.'__options')))
						update_option($this->___instance_config->plugin_root_ns_stub.'__options', ($this->options = array()));

					$this->default_options = $this->©string->ify_deep($this->©array->ify_deep($default_options));
					$this->options         = array_merge($this->default_options, $this->options);
					$this->validators      = $validators;
					$this->options         = $this->validate();

					return $this->options; // All options (after setup is complete).
				}

			/**
			 * Gets a specific option value.
			 *
			 * @param string  $option_name Required; and it MUST exist as a current option.
			 *    The name of an option to retrieve the value for.
			 *
			 * @param boolean $get_default Defaults to FALSE. If this is TRUE,
			 *    get the default option value, instead of current value.
			 *
			 * @return string|array The option value.
			 *    A string value, array, or multidimensional array.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$option_name`` is currently unknown.
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    ('unit') === '1'
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    ('test') === array('1')
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    ('unknown') throws exception
			 */
			public function get($option_name, $get_default = FALSE)
				{
					$this->check_arg_types('string:!empty', 'boolean', func_get_args());

					if($get_default && isset($this->default_options[$option_name]))
						return $this->apply_filters('get_'.$option_name, $this->default_options[$option_name]);

					if(!$get_default && isset($this->options[$option_name]))
						return $this->apply_filters('get_'.$option_name, $this->options[$option_name]);

					throw $this->©exception(
						__METHOD__.'#unknown_option_name', get_defined_vars(),
						sprintf($this->i18n('Unknown option name: `%1$s`.'), $option_name)
					);
				}

			/**
			 * Updates current options with one or more new option values.
			 *
			 * @note It's fine to force an update by calling this method without any arguments.
			 *
			 * @param array $new_options Optional. An associative array of option values to update, with each of their new values.
			 *    This array does NOT need to contain all of the current options. Only those which should be updated.
			 *
			 * @return array The current array of options.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    (array('test' => array('2'))) === array('unit' => '1', 'test' => array('2'))
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    (array('unit' => '2')) === array('unit' => '2', 'test' => array('1'))
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    (array('unit' => '2', 'test' => array('2'))) === array('unit' => '2', 'test' => array('2'))
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    (array('unit' => '', 'test' => array())) === $default_options
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    () === $default_options
			 */
			public function update($new_options = array())
				{
					$this->check_arg_types('array', func_get_args());

					if($new_options) // An array with ``$new_options``, NOT empty?
						{
							$new_options = $this->©string->ify_deep($this->©array->ify_deep($new_options));

							foreach($new_options as &$_new_option) // Variable by reference.
								if(is_array($_new_option)) // Remove update markers and possible file info.
									unset($_new_option['___update'], $_new_option['___file_info']);
							unset($_new_option);

							$this->options = array_merge($this->options, $new_options);
						}
					$this->options = $this->validate(TRUE); // Full validation before updates.
					update_option($this->___instance_config->plugin_root_ns_stub.'__options', $this->options);
					$this->©db_cache->purge(); // Updates indicate config changes (so we also purge the DB cache).

					return $this->options; // All options (w/ updates applied).
				}

			/**
			 * Validates the current array of option values.
			 *
			 * @param boolean $use_validators Defaults to FALSE. By default, we perform only a basic validation.
			 *    If TRUE, a full validation is performed, including all ``$validators``.
			 *
			 * @return array The current array of options.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If an unknown validation type is found in the array of ``$validators``.
			 * @modifies-options-array If an option fails validation, we silently revert that option to it's default value.
			 *
			 * @note Options will ONLY be strings, or multidimensional arrays containing other string option values.
			 *    All ``$default_options``, and new options added via ``update()``, will be stringified/arrayified deeply.
			 *    See: ``setup()`` and ``update()`` for further details regarding this.
			 *
			 * @note Option value types MUST match that of their default option counterpart.
			 *    In addition, options NOT in the list of defaults, are NOT allowed to exist on their own.
			 *    Any options NOT in the list of defaults, are silently removed by this routine.
			 *
			 * @note In order to avoid potential conflicts after a plugin upgrade,
			 *    the ``©installation->activation()`` routine should always call upon the ``update()`` method here in this class,
			 *    which fires this full validation routine; thereby preventing possible option value conflicts from one version to the next.
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    $this->object->update(array('unit' => array('2'), 'test' => '2'));
			 *    (TRUE) === array('unit' => '1', 'test' => array('1'))
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    $this->object->update(array('unit' => '2', 'test' => array('2')));
			 *    (TRUE) === array('unit' => '2', 'test' => array('2'))
			 */
			public function validate($use_validators = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					foreach($this->options as $_key => &$_value)
						{
							if(!isset($this->default_options[$_key])) unset($this->options[$_key]);

							else if(!in_array(gettype($_value), array('string', 'array'), TRUE))
								$_value = $this->default_options[$_key];

							else if(gettype($_value) !== gettype($this->default_options[$_key]))
								$_value = $this->default_options[$_key];

							else if($use_validators && $this->©array->is_not_empty($this->validators[$_key]))
								{
									foreach($this->validators[$_key] as $_validation_key => $_data)
										{
											// Can be a combination of numeric/associative keys.

											if(is_numeric($_validation_key)) // A numeric key?
												{
													$_validation_type = $_data; // As type.
													$_data            = NULL; // Nullify data.
												}
											else // Associative key with possible ``$_data``.
												{
													/** @var mixed $_data */
													$_validation_type = $_validation_key;
												}
											switch($_validation_type) // By validation type.
											{
												case 'string': // Validation only.

														if(!is_string($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:!empty': // Validation only.

														if(!is_string($_value) || empty($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:strlen': // Validation only.
														if(!is_string($_value) || !strlen($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:strlen <=': // Validation only.

														if(!is_string($_value) || (is_numeric($_data) && strlen($_value) > $_data))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:strlen >=': // Validation only.

														if(!is_string($_value) || (is_numeric($_data) && strlen($_value) < $_data))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:numeric': // Validation only.

														if(!is_string($_value) || !is_numeric($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:numeric <=': // Validation only.

														if(!is_string($_value) || !is_numeric($_value) || (is_numeric($_data) && $_value > $_data))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:numeric >=': // Validation only.

														if(!is_string($_value) || !is_numeric($_value) || (is_numeric($_data) && $_value < $_data))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:preg_match': // Validation only.

														if(!is_string($_value) || (is_string($_data) && !preg_match($_data, $_value)))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:in_array': // Validation only.

														if(!is_string($_value) || (is_array($_data) && !in_array($_value, $_data)))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'string:strtolower': // Validation w/procedure.

														if(!is_string($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														else // Just force lowercase.
															{
																$_value = strtolower($_value);
																break; // Do next validation.
															}

												case 'string:preg_replace': // Validation w/procedure.

														if(!is_string($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														else if(is_array($_data) && $this->©strings->are_set($_data['replace'], $_data['with']))
															$_value = preg_replace($_data['replace'], $_data['with'], $_value);

														break; // Do next validation.

												case 'array': // Validation only.

														if(!is_array($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'array:!empty': // Validation only.

														if(!is_array($_value) || empty($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'array:count <=': // Validation only.

														if(!is_array($_value) || (is_numeric($_data) && count($_value) > $_data))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'array:count >=': // Validation only.

														if(!is_array($_value) || (is_numeric($_data) && count($_value) < $_data))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'array:containing': // Validation only.

														if(!is_array($_value) || !in_array($_data, $_value, TRUE))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'array:containing-any-of': // Validation only.

														if(!is_array($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														else if(is_array($_data))
															{
																foreach($_data as $_data_value)
																	if(in_array($_data_value, $_value, TRUE))
																		break; // Do next validation.

																unset($_data_value); // Housekeeping.
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														break; // Do next validation.

												case 'array:containing-all-of': // Validation only.

														if(!is_array($_value))
															{
																$_value = $this->default_options[$_key];
																break 2; // Done validating here.
															}
														else if(is_array($_data))
															{
																foreach($_data as $_data_value)
																	if(!in_array($_data_value, $_value, TRUE))
																		{
																			$_value = $this->default_options[$_key];
																			break 2; // Done validating here.
																		}
																unset($_data_value); // Housekeeping.
															}
														break; // Do next validation.

												default: // Exception.
													throw $this->©exception(
														__METHOD__.'#unknown_validation_type', get_defined_vars(),
														sprintf($this->i18n('Unknown validation type: `%1$s`.'), $_validation_type)
													);
											}
										}
									unset($_validation_key, $_validation_type, $_data);
								}
						}
					unset($_key, $_value); // A little housekeeping.

					return $this->options; // Returns all options (fully validated).
				}

			/**
			 * Deletes all existing options from the database.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen (i.e. nothing will be deleted).
			 *
			 * @return array The current array of options (i.e. the defaults only).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @note Important... this is called upon by the ``deactivation_uninstall()`` method below.
			 * @note This could also be used to revert a site owner back to our default options.
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    $this->object->update(array('unit' => '2', 'test' => array('2')));
			 *    () === array('unit' => '2', 'test' => array('2'))
			 *
			 * @assert $default_options = array('unit' => '1', 'test' => array('1'));
			 * $validators = array('unit' => array('string:strlen'), 'test' => array('array:!empty'));
			 *    $this->object->setup($default_options, $validators);
			 *    $this->object->update(array('unit' => '2', 'test' => array('2')));
			 *    (TRUE) === $default_options
			 */
			public function delete($confirmation = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					if($confirmation) // Do we have confirmation?
						{
							$this->options = $this->default_options;
							delete_option($this->___instance_config->plugin_root_ns_stub.'__options');
						}
					return $this->options; // Defaults.
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

					$this->update();

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