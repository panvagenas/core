<?php
/**
 * The `[if]` Shortcode.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace websharks_core_v000000_dev\shortcodes
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		/**
		 * The `[if]` Shortcode.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class if_conditionals extends \websharks_core_v000000_dev\shortcodes\shortcode
		{
			/**
			 * Shortcode processor.
			 *
			 * @param string|array $attr An array of all shortcode attributes (if there were any).
			 *    Or, a string w/ the entire attributes section (when WordPress® fails to parse attributes).
			 *
			 * @param null|string  $content Shortcode content (or NULL for self-closing shortcodes).
			 *
			 * @param string       $shortcode The name of the shortcode.
			 *
			 * @return string Shortcode content.
			 *
			 * @throws \websharks_core_v000000_dev\exception If invalid types are passed through arguments list.
			 * @throws \websharks_core_v000000_dev\exception If ``$shortcode`` is empty.
			 *
			 * @see http://codex.wordpress.org/Shortcode_API#Nested_Shortcodes
			 */
			public function do_shortcode($attr, $content, $shortcode)
				{
					$this->check_arg_types(array('string', 'array'), array('null', 'string'), 'string:!empty', func_get_args());

					// Initialize variables.

					$shortcode_depth    = strspn($shortcode, '_');
					$attr               = $this->normalize_attr_strings($attr);
					$attr_expressions   = $attr; // We'll narrow these down below.
					$attr_operators     = array(); // Initialize array of attribute operators.
					$conditions_fail    = NULL; // Defaults to a NULL value (i.e. no decision yet).
					$functions_allowed  = $this->functions_allowed(); // Array of functions allowed here.
					$restrict_functions = $this->©options->get('shortcodes.if_conditionals.restrict_functions');

					$content          = $this->©string->trim_content($content);
					$content_if       = $content; // Default value (the entire content block).
					$content_else     = ''; // Default value (assume nothing will display in this case).
					$content_if_tag   = str_repeat('_', $shortcode_depth).'content_if';
					$content_else_tag = str_repeat('_', $shortcode_depth).'content_else';

					// Defines content blocks (for each conditional result type).

					$has_content_if_tag   = preg_match('/\{('.preg_quote($content_if_tag, '/').')\}(?P<content>.*?)\{\/\\1\}/is', $content, $_content_if);
					$has_content_else_tag = preg_match('/\{('.preg_quote($content_else_tag, '/').')\}(?P<content>.*?)\{\/\\1\}/is', $content, $_content_else);

					if($has_content_if_tag && $has_content_else_tag) // Site owner MUST provide BOTH tags, else throw exception.
						{
							$content_if   = $this->©string->trim_content($_content_if['content']);
							$content_else = $this->©string->trim_content($_content_else['content']);
						}
					else if($has_content_else_tag && !$has_content_if_tag)
						throw $this->©exception( // Has one but NOT the other.
							$this->method(__FUNCTION__).'#missing_content_if_tag', get_defined_vars(),
							sprintf($this->i18n('Regarding the `%1$s` shortcode.'), $shortcode).
							sprintf($this->i18n(' Missing {%1$s}{/%1$s} tag. You MUST provide BOTH {%1$s}{/%1$s} and {%2$s}{/%2$s} tags.'),
							        $content_if_tag, $content_else_tag)
						);
					else if($has_content_if_tag && !$has_content_else_tag)
						throw $this->©exception( // Has one but NOT the other.
							$this->method(__FUNCTION__).'#missing_content_else_tag', get_defined_vars(),
							sprintf($this->i18n('Regarding the `%1$s` shortcode.'), $shortcode).
							sprintf($this->i18n(' Missing {%2$s}{/%2$s} tag. You MUST provide BOTH {%1$s}{/%1$s} and {%2$s}{/%2$s} tags.'),
							        $content_if_tag, $content_else_tag)
						);
					unset($_content_if, $_content_else); // Housekeeping.

					// Finds attributes that contain operators.
					// We collect & remove operators before processing expressions.

					foreach($attr as $_attr_key => $_attr_value) // Find operator attributes.
						if(preg_match('/^(?:&&|&amp;&amp;|&#038;&#038;|AND|\|\||OR|[!=<>]+)$/i', $_attr_value))
							{
								unset($attr_expressions[$_attr_key]);
								$attr_operators[] = strtolower($_attr_value);

								if(preg_match('/^[!=<>]+$/', $_attr_value))
									throw $this->©exception( // Unsupported operator.
										$this->method(__FUNCTION__).'#unsupported_operator', get_defined_vars(),
										sprintf($this->i18n('Regarding the `%1$s` shortcode.'), $shortcode).
										$this->i18n(' Simple conditionals CANNOT process operators like (`==` `!=` `<>`). Please use `AND` / `OR` logic only.'.
										            ' Or, you could use advanced PHP conditionals instead of shortcodes.'
										));
							}
					unset($_attr_key, $_attr_value); // Housekeeping.

					// Let's keep things simple. Do NOT allow operator mixtures.

					if(count($attr_operators = array_unique($attr_operators)) > 1)
						throw $this->©exception( // More than ONE operator!
							$this->method(__FUNCTION__).'#unsupported_operator_mix', get_defined_vars(),
							sprintf($this->i18n('Regarding the `%1$s` shortcode.'), $shortcode).
							$this->i18n(' It\'s NOT possible to mix logic using an AND/OR combination. Please stick to one type of logic or another.'.
							            ' If both types of logic are needed, you MUST use two different shortcode expressions.'.
							            ' Or, you could use advanced PHP conditionals instead of shortcodes.'
							));
					// Determine the type of logic applied by this shortcode.

					$logic = $this::all_logic; // This is the default logic type (MUST satisfy all expressions).
					if($this->©string->is_not_empty($attr_operators[0]) && preg_match('/^(?:\|\||OR)$/i', $attr_operators[0]))
						$logic = $this::any_logic; // Any satisfied expression allows content to display.

					// Process conditional expressions in the shortcode (based on logic type).

					foreach($attr_expressions as $_attr_expression_key => $_attr_expression_value)
						{
							// Parse and validate the overall expression.
							if(!preg_match('/^(?P<negating>\!)?(?P<function>.+?)(?:\()(?P<args>.*?)(?:\))$/', $_attr_expression_value, $_expression))
								throw $this->©exception(
									$this->method(__FUNCTION__).'#invalid_expression', get_defined_vars(),
									sprintf($this->i18n('Regarding the `%1$s` shortcode.'), $shortcode).
									sprintf($this->i18n(' The following is an invalid expression: `%1$s`.'), $_attr_expression_value).
									$this->i18n(' Please be sure to remove ALL spaces from your expression (for instance, remove spaces between arguments).').
									sprintf($this->i18n(' Please use one or more of these conditional functions: `%1$s`.'), $this->©var->dump($functions_allowed))
								);
							// Define all expression components.

							$_negating = (!empty($_expression['negating'])) ? TRUE : FALSE;
							$_function = strtolower($_expression['function']);
							$_args     = $_expression['args'];

							// Security validation (this MUST be an allowed function).

							if($restrict_functions && !$this->©string->in_wildcard_patterns($_function, $functions_allowed))
								throw $this->©exception(
									$this->method(__FUNCTION__).'#function_not_allowed', get_defined_vars(),
									sprintf($this->i18n('Regarding the `%1$s` shortcode.'), $shortcode).
									sprintf($this->i18n(' The following function is NOT allowed in a shortcode (for security purposes): `%1$s`.'), $_function).
									sprintf($this->i18n(' Functions allowed in shortcodes, are limited to: `%1$s`.'), $this->©var->dump($functions_allowed))
								);
							// Argument parsing (supports arrays, supports typecasting).

							$_args = preg_replace('/^\{(?P<args>.*?)\}$/', '${1}', $_args, 1, $_args_are_array);
							$_args = preg_replace_callback('/\{.+?\}/', function ($m)
								{
									return str_replace(',', ';', $m[0]); // Semicolons on nested array args.

								}, $_args); // Now we can split arguments (even arrays) on commas.
							$_args = (strlen($_args)) ? preg_split('/\s*,\s*/', $_args) : array();
							$_args = $this->typecast_args($_args);

							// Support for nested argument arrays (one additional level only).

							foreach($_args as &$_arg) // Iterate each argument value.
								{
									if(!is_string($_arg)) // Already cast as another type?
										continue; // If it's NOT a string anymore, no need to parse.

									$_arg = preg_replace('/^\{(?P<args>.*?)\}$/', '${1}', $_arg, 1, $_arg_is_array);

									if($_arg_is_array) // If this argument is an array, split on `;` character.
										{
											$_arg = (strlen($_arg)) ? preg_split('/\s*;\s*/', $_arg) : array();
											$_arg = $this->typecast_args($_arg);
										}
								}
							unset($_arg, $_arg_is_array); // Just a little housekeeping here.

							// Security validation (do NOT allow variables or expressions).
							// This is NOT possible anyway, because we're NOT evaluating argument strings.

							// Note: we do NOT scan for constants here, only because there's no reliable way to do so.
							// Constants are simply interpreted as strings anyway (we are NOT evaluating argument strings).

							// Because we are NOT evaluating argument strings, it's important to realize that an argument
							// which contains an expression like `new stdClass`, is interpreted as a string (because it's NOT evaluated).
							// Thus, `1 + 1` is NOT equal to `2`, it's simply equal to the string `1 + 1`.

							// The routine below is definitely NOT a complete scan, but it catches the most common mistakes.
							// We don't want site owners using expressions which will NOT be evaluated anyway.

							if(preg_match('/[$()]|new\s/i', serialize($_args)))
								throw $this->©exception(
									$this->method(__FUNCTION__).'#argument_not_allowed', get_defined_vars(),
									sprintf($this->i18n('Regarding the `%1$s` shortcode.'), $shortcode).
									$this->i18n(' One of the following snippets appear in at least one function argument value: `$`, `(`, `)`, `new `.').
									sprintf($this->i18n(' Please do NOT use a variable or expression as an argument value: `%1$s`.'), $this->©var->dump($_args))
								);
							// Process shortcode conditional.

							if($_args_are_array) // A single array?
								$_result = call_user_func($_function, $_args);
							else $_result = call_user_func_array($_function, $_args);

							// Handles conditional result (based on logic type).

							if((!$_negating && !$_result) || ($_negating && $_result))
								{
									$conditions_fail = TRUE;
									if($logic === $this::all_logic) break;
									// All expressions MUST pass (this one failed).
								}
							else // This condition passes (e.g. does NOT fail).
								{
									if($logic === $this::any_logic)
										{
											$conditions_fail = FALSE;
											break; // If any expression passes.
										}
								}
						}
					// Housekeeping (unset these temporary vars).
					unset($_attr_expression_key, $_attr_expression_value, $_expression);
					unset($_negating, $_function, $_args, $_args_are_array, $_arg_is_array, $_result);

					// Return content (w/ support for nested shortcodes).
					return do_shortcode((($conditions_fail) ? $content_else : $content_if));
				}

			/**
			 * Gets the list of functions allowed.
			 *
			 * @return array An array of functions allowed.
			 */
			public function functions_allowed()
				{
					$functions_allowed = array(

						// s2Member® API (conditional tags, e.g. functions).
						// See: <http://www.s2member.com/codex/>.

						'*::user_is_logged_in',
						'*::user_is_populated',

						'*::user_has_passtag',
						'*::user_has_passtags',
						'*::user_has_any_passtag',

						'*::user_had_passtag',
						'*::user_had_passtags',
						'*::user_did_have_passtag',
						'*::user_did_have_passtags',
						'*::user_did_have_any_passtag',
						'*::user_had_any_passtag',

						'*::user_can_passtag',
						'*::user_can_passtags',
						'*::user_can_access_passtag',
						'*::user_can_access_passtags',
						'*::user_can_access_any_passtag',

						'*::user_will_access_passtag',
						'*::user_will_access_passtags',
						'*::user_will_access_any_passtag',

						// WordPress® core (conditional tags, e.g. functions).
						// See: <http://codex.wordpress.org/Conditional_Tags>.

						'user_can',
						'author_can',
						'current_user_can',
						'current_user_can_for_blog',
						'is_user_logged_in',
						'is_super_admin',

						'user_pass_ok',
						'username_exists',
						'email_exists',
						'get_user_by',
						'is_email',

						'is_home',
						'is_front_page',

						'is_admin',
						'is_blog_admin',
						'is_user_admin',
						'is_network_admin',

						'is_multisite',

						'post_type_exists',
						'is_post_type_hierarchical',
						'is_post_type_archive',

						'is_single',
						'is_singular',
						'is_attachment',
						'is_local_attachment',

						'is_page',
						'is_page_template',

						'is_archive',

						'is_category',
						'in_category',
						'cat_is_ancestor_of',

						'is_tag',
						'has_tag',
						'is_tax',
						'has_term',
						'taxonomy_exists',

						'is_author',
						'is_multi_author',

						'is_date',
						'is_year',
						'is_month',
						'is_day',
						'is_time',
						'is_new_day',

						'is_trackback',
						'is_search',
						'is_feed',
						'is_404',

						'has_post_thumbnail',
						'has_nav_menu',
						'has_excerpt',
						'comments_open',
						'pings_open',
						'is_preview',
						'is_sticky',
						'is_paged',

						'in_the_loop',
						'is_comments_popup',
						'is_active_sidebar',

						'current_theme_supports',
						'is_plugin_active',
						'is_child_theme',

						'has_filter',
						'has_action',
						'did_action',

						'is_rtl',

						// PHP ``is_()`` functions (e.g. type checks).
						// See: <http://www.php.net/manual/en/ref.var.php>.

						'is_string',
						'is_bool',
						'is_integer',
						'is_float',
						'is_numeric',
						'is_scalar',
						'is_array',
						'is_object',
						'is_resource',
						'is_null'
					);
					if($this->©env->is_in_wp_debug_mode())
						$functions_allowed = array_merge($functions_allowed, array('print_r', 'var_dump', 'var_export'));

					if(($other_functions_allowed = $this->©options->get('shortcodes.if_conditionals.other_functions_allowed')))
						$functions_allowed = array_merge($functions_allowed, $other_functions_allowed);

					return $this->apply_filters('functions_allowed', $functions_allowed);
				}

			/**
			 * Forces arg types.
			 *
			 * @param array $args An array of arguments.
			 *
			 * @return array Array of arguments (with possible type changes).
			 */
			public function typecast_args($args)
				{
					$this->check_arg_types('array', func_get_args());

					$regex_arg_types = '/^\((?P<type>boolean|bool|integer|int|float|double|real|string|array|object|null)\)(?P<arg>.*)$/is';

					foreach($args as &$_arg) // Iteration by reference.
						{
							if(!is_string($_arg)) // String?
								continue; // Skip if NOT a string.

							// Handles argument typecasting.

							if(strpos($_arg, '(') === 0 && preg_match($regex_arg_types, $_arg, $_m))
								// The ``strpos()`` call helps to optimize this routine.
								{
									$_arg = $_m['arg'];
									settype($_arg, $_m['type']);
								}
							// Handles numeric (integer) values.

							else if(is_numeric($_arg) && strpos($_arg, '.') === FALSE)
								$_arg = (integer)$_arg;

							// Handles boolean and NULL values.

							else if(strcasecmp($_arg, 'TRUE') === 0) $_arg = TRUE;
							else if(strcasecmp($_arg, 'FALSE') === 0) $_arg = FALSE;
							else if(strcasecmp($_arg, 'NULL') === 0) $_arg = NULL;
						}
					unset($_arg, $_m); // Just a little housekeeping.

					return $args; // Possible type changes now (e.g. w/ ``settype()`` applied).
				}
		}
	}