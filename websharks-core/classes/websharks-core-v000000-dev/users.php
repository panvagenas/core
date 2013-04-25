<?php
/**
 * Users.
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
		 * Users.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__], 1)
		 */
		class users extends framework
		{
			/**
			 * @var array Constructor arguments.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $args = array();

			/**
			 * @var integer WordPress® ID.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $ID = 0;

			/**
			 * @var \WP_User WordPress® object instance.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $wp; // Defaults to a NULL value.

			/**
			 * @var boolean Was this object constructed for the current default user?
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $is_current_default = FALSE;

			/**
			 * @var string Current and/or last known IP address.
			 * @population Set dynamically, by population routine.
			 */
			public $ip = '';

			/**
			 * @var string WordPress® email address.
			 * @population Set dynamically, by population routine.
			 */
			public $email = '';

			/**
			 * @var string WordPress® username.
			 * @population Set dynamically, by population routine.
			 */
			public $username = '';

			/**
			 * @var string WordPress® nicename.
			 * @population Set dynamically, by population routine.
			 */
			public $nicename = '';

			/**
			 * @var string WordPress® encrypted password.
			 * @population Set dynamically, by population routine.
			 */
			public $password = '';

			/**
			 * @var string WordPress® first name.
			 * @population Set dynamically, by population routine.
			 */
			public $first_name = '';

			/**
			 * @var string WordPress® last name.
			 * @population Set dynamically, by population routine.
			 */
			public $last_name = '';

			/**
			 * @var string WordPress® full name.
			 * @population Set dynamically, by population routine.
			 */
			public $full_name = '';

			/**
			 * @var string WordPress® display name.
			 * @population Set dynamically, by population routine.
			 */
			public $display_name = '';

			/**
			 * @var string URL associated with this user.
			 * @population Set dynamically, by population routine.
			 */
			public $url = '';

			/**
			 * @var string AOL® Instant Messenger name for this user.
			 * @population Set dynamically, by population routine.
			 */
			public $aim = '';

			/**
			 * @var string Yahoo® Messenger name for this user.
			 * @population Set dynamically, by population routine.
			 */
			public $yim = '';

			/**
			 * @var string Jabber™ (or Google® Talk) name for this user.
			 * @population Set dynamically, by population routine.
			 */
			public $jabber = '';

			/**
			 * @var string Description (or bio details) for this user.
			 * @population Set dynamically, by population routine.
			 */
			public $description = '';

			/**
			 * @var integer WordPress® registration time.
			 * @population Set dynamically, by population routine.
			 */
			public $registration_time = 0;

			/**
			 * @var string WordPress® activation key.
			 * @population Set dynamically, by population routine.
			 */
			public $activation_key = '';

			/**
			 * @var integer WordPress® status.
			 * @population Set dynamically, by population routine.
			 */
			public $status = 0;

			/**
			 * Constructor.
			 *
			 * @param object|array              $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or a new ``$___instance_config`` array.
			 *
			 * @param null|integer              $user_id Defaults to NULL. A specific user?
			 *    If this and ``$by``, ``$value`` are all NULL, we construct an instance for the current user.
			 *
			 * @param null|string               $by Search for a user, by a particular type of value?
			 *    For further details, please check method: ``©user_utils->get_id_by()``.
			 *
			 * @param null|string|integer|array $value A value to search for (e.g. username(s), email address(es), ID(s)).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function __construct($___instance_config, $user_id = NULL, $by = NULL, $value = NULL)
				{
					parent::__construct($___instance_config);

					$this->check_arg_types('', array('null', 'integer:!empty'), array('null', 'string:!empty'),
					                       array('null', 'string:!empty', 'integer:!empty', 'array:!empty'), func_get_args());

					$this->args = array('user_id' => $user_id, 'by' => $by, 'value' => $value);

					if(!did_action('init') && !defined('___UNIT_TEST'))
						throw $this->©exception(
							__METHOD__.'#user_init_hook', array('args' => $this->args),
							$this->i18n('Doing it wrong (the `init` hook has NOT been fired yet).')
						);

					if($user_id && $user_id < 0)
						// This is NO user (explicitly).
						$this->ID = 0; // Set to `0` value.

					else if($user_id // A specific user by ID?
					        && is_object($wp = new \WP_User($user_id))
					        && !empty($wp->ID)
					) // Instance for a specific user.
						{
							$this->wp = $wp;
							$this->ID = $wp->ID;
						}
					else if($by && $value && strtolower($by) === 'id' && is_numeric($value)
					        && is_object($wp = new \WP_User((integer)$value))
					        && !empty($wp->ID)
					) // Instance for a specific user.
						{
							$this->wp = $wp;
							$this->ID = $wp->ID;
						}
					else if($by && $value && ($user_id = $this->©user_utils->get_id_by($by, $value))
					        && is_object($wp = new \WP_User($user_id))
					        && !empty($wp->ID)
					) // Instance for a specific user.
						{
							$this->wp = $wp;
							$this->ID = $wp->ID;
						}
					else if(is_null($user_id) && is_null($by) && is_null($value))
						{
							$this->is_current_default = TRUE;

							if(is_object($wp = wp_get_current_user())
							   && !empty($wp->ID)
							) // Instance for current user.
								{
									$this->wp = $wp;
									$this->ID = $wp->ID;
								}
						}
					if($this->ID && (!$this->wp || !$this->wp->user_email || !$this->wp->user_login || !$this->wp->user_nicename))
						{
							$this->©error( // For diagnostics reports.
								__METHOD__, array('args' => $this->args, 'ID' => $this->ID, 'wp' => $this->wp),
								sprintf($this->i18n('User ID: `%1$s` is missing vital components.'), $this->ID).
								$this->i18n(' Possible database corruption.')
							);
							$this->ID = 0; // User is corrupt in some way.
							$this->wp = NULL; // Force a NULL value in this case.
						}
					$this->populate(); // Populate (if possible).
				}

			/**
			 * Handles initialization routines.
			 *
			 * @extenders Can be overridden by class extenders.
			 *
			 * @attaches-to WordPress® `init` action hook.
			 * @hook-priority `1`.
			 *
			 * @hook-disabled-by-default Plugins should add this hook if sessions are implemented.
			 *    add_action('init', array($this, '©user.init'), 1);
			 *
			 * @assert () === NULL
			 */
			public function init()
				{
					if($this->is_current())
						$this->session_start();
				}

			/**
			 * Starts a session for this user (if they are the current user).
			 *
			 * @extenders Can be overridden by class extenders (when/if necessary).
			 *
			 * @return null Nothing. Simply starts a session for this user (if they are the current user).
			 *
			 * @assert () === NULL
			 */
			public function session_start()
				{
					// Core does NOT use sessions.
				}

			/**
			 * Ends a session for this user (if they are the current user).
			 *
			 * @extenders Can be overridden by class extenders (when/if necessary).
			 *
			 * @return null Nothing. Simply ends a session for this user (if they are the current user).
			 *
			 * @assert () === NULL
			 */
			public function session_end()
				{
					// Core does NOT use sessions.
				}

			/**
			 * Populates user object properties.
			 *
			 * @extenders Can be overridden by class extenders.
			 * @note Class extenders may wish to populate with ``$this->args['by']``, ``$this->args['value']`` in some special cases.
			 *    The core does NOT handle this on its own however (an extender is required).
			 *
			 * @return null Nothing. Simply populates user object properties.
			 *
			 * @assert () === NULL
			 */
			public function populate()
				{
					// Get IP (we try this even for current users w/o an ID).

					if($this->is_current())
						{
							$this->ip = $this->©env->ip();
							if($this->has_id() && $this->ip && $this->ip !== $this->get_meta('ip'))
								$this->update_meta('ip', $this->ip);
						}
					else if($this->has_id()) $this->ip = (string)$this->get_meta('ip');

					// Standardize these additional properties (for users w/ an ID).

					if($this->has_id()) // Has a user ID?
						{
							$this->email             = $this->wp->user_email;
							$this->username          = $this->wp->user_login;
							$this->nicename          = $this->wp->user_nicename;
							$this->password          = $this->wp->user_pass;
							$this->first_name        = $this->wp->first_name;
							$this->last_name         = $this->wp->last_name;
							$this->full_name         = trim($this->wp->first_name.' '.$this->wp->last_name);
							$this->display_name      = $this->wp->display_name;
							$this->url               = $this->wp->user_url;
							$this->aim               = $this->wp->aim;
							$this->yim               = $this->wp->yim;
							$this->jabber            = $this->wp->jabber;
							$this->description       = $this->wp->description;
							$this->registration_time = strtotime($this->wp->user_registered);
							$this->activation_key    = $this->wp->user_activation_key;
							$this->status            = (integer)$this->wp->user_status;
						}
					else // Else, there is nothing more we can populate in this case.
						{
							// Class extenders may wish to populate with ``$this->args['by']``, ``$this->args['value']``.
							// The core does NOT handle this on its own however (an extender is required).
						}
				}

			/**
			 * Does this user have an ID?
			 *
			 * @return boolean TRUE if this user has an ID, else FALSE.
			 *
			 * @note Any user with an ID, will by definition,
			 *    also have these non-empty properties:
			 *
			 *    • `wp`
			 *    • `email`
			 *    • `username`
			 *    • `nicename`
			 *
			 * @assert () === TRUE
			 */
			public function has_id()
				{
					return ($this->ID) ? TRUE : FALSE;
				}

			/**
			 * Does this user have an email address?
			 *
			 * @return boolean TRUE if this user has an email address, else FALSE.
			 *
			 * @note This is really just for internal standards. It's called upon by ``is_populated()``.
			 *
			 * @note Any user with an ID, will by definition,
			 *    also have these non-empty properties:
			 *
			 *    • `wp`
			 *    • `email`
			 *    • `username`
			 *    • `nicename`
			 *
			 * @assert () === TRUE
			 */
			public function has_email()
				{
					return ($this->email) ? TRUE : FALSE;
				}

			/**
			 * Is this user populated?
			 *
			 * @return boolean TRUE if this user has an ID and/or an email address, else FALSE.
			 *
			 * @assert () === TRUE
			 */
			public function is_populated()
				{
					return ($this->has_id() || $this->has_email()) ? TRUE : FALSE;
				}

			/**
			 * Is this user currently logged into the site?
			 *
			 * @return boolean TRUE if this user is currently logged in, else FALSE.
			 *
			 * @assert () === FALSE
			 */
			public function is_logged_in()
				{
					return ($this->has_id() && get_current_user_id() === $this->ID);
				}

			/**
			 * Is this the current default user?
			 *
			 * @return boolean TRUE if this is the current default user, else FALSE.
			 *
			 * @assert () === FALSE
			 */
			public function is_current_default()
				{
					return ($this->is_current_default) ? TRUE : FALSE;
				}

			/**
			 * Is this the current user?
			 *
			 * @return boolean TRUE if this is the current user, else FALSE.
			 *
			 * @assert () === FALSE
			 */
			public function is_current()
				{
					return ($this->is_current_default() || $this->is_logged_in()) ? TRUE : FALSE;
				}

			/**
			 * Instantiated with ``$this->args['by']``, ``$this->args['value']``?
			 *
			 * @return boolean TRUE if this was instantiated with ``$this->args['by']``, ``$this->args['value']``, else FALSE.
			 *
			 * @assert () === FALSE
			 */
			public function has_args_by_value()
				{
					return ($this->args['by'] && $this->args['value']) ? TRUE : FALSE;
				}

			/**
			 * Is this a super administrator?
			 *
			 * @return boolean TRUE if this is a super administrator, else FALSE.
			 *
			 * @assert () === TRUE
			 */
			public function is_super_admin()
				{
					if($this->has_id())
						{
							if(is_multisite())
								{
									if(is_array($super_admins = get_super_admins())
									   && in_array($this->username, $super_admins, TRUE)
									) return TRUE;
								}
							else if($this->wp->has_cap('delete_users'))
								return TRUE;
						}
					return FALSE;
				}

			/**
			 * Refreshes this object instance.
			 *
			 * @param null|string|array $components Optional. Defaults to a NULL value.
			 *    By default, with a NULL value, we simply refresh the entire object instance.
			 *    If this is a string (or an array), we only refresh specific components.
			 *
			 * @return null Nothing. Simply refreshes this object instance.
			 *
			 * @assert () === NULL
			 */
			public function refresh($components = NULL)
				{
					$this->check_arg_types(array('null', 'string:!empty', 'array:!empty'), func_get_args());

					if(is_null($components))
						{
							$this->wp    = NULL;
							$this->cache = array();

							$this->ip                = '';
							$this->email             = '';
							$this->username          = '';
							$this->nicename          = '';
							$this->password          = '';
							$this->first_name        = '';
							$this->last_name         = '';
							$this->full_name         = '';
							$this->display_name      = '';
							$this->url               = '';
							$this->aim               = '';
							$this->yim               = '';
							$this->jabber            = '';
							$this->description       = '';
							$this->registration_time = 0;
							$this->activation_key    = '';
							$this->status            = 0;

							if($this->has_id())
								{
									clean_user_cache($this->ID);
									wp_cache_delete($this->ID, 'user_meta');

									if(is_object($wp = new \WP_User($this->ID)) && !empty($wp->ID))
										$this->wp = $wp;
								}

							$this->populate(); // Repopulate.

							// Restart session (if possible).
							if($this->is_current() && !headers_sent())
								$this->session_start();
						}
					else // Only refresh specific data components.
						{
							foreach((array)$components as $_component => $_value)
								{
									if(is_integer($_component) && $this->©string->is_not_empty($_value))
										{
											if(isset($this->cache[$_value]))
												unset($this->cache[$_value]);
										}
									if($this->©string->is_not_empty($_component)) // Associative.
										{
											if(isset($this->$_component))
												$this->$_component = $_value;

											if(isset($this->cache[$_component]))
												unset($this->cache[$_component]);
										}
								}
							unset($_component, $_value); // Housekeeping.
						}
				}

			/**
			 * Logs this user out of their account access (if they are the current user).
			 *
			 * @throws exception If headers have already been sent before calling this routine.
			 */
			public function logout()
				{
					if(headers_sent())
						throw $this->©exception(
							__METHOD__.'#headers_sent_already', array('ID' => $this->ID),
							$this->i18n(' Doing it wrong! Headers have already been sent.')
						);

					if($this->is_current())
						$this->session_end();

					if($this->is_current() && $this->has_id())
						wp_logout();
				}

			/**
			 * Deletes this user.
			 *
			 * @note In the case of a multisite network installation of WordPress®,
			 *    this will simply remove the user from the current blog (e.g. they're NOT actually deleted).
			 *
			 * @param null|integer $reassign_posts_to_user_id Optional. A user ID to which any posts will be reassigned.
			 *    If this is NULL (which it is by default), all posts will simply be deleted, along with the user.
			 *
			 * @return boolean|errors TRUE if the user is deleted, else an errors object on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID (e.g. we CANNOT delete them).
			 */
			public function delete($reassign_posts_to_user_id = NULL)
				{
					$this->check_arg_types(array('null', 'integer:!empty'), func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot delete).')
						);

					if($this->is_super_admin())
						return $this->©error(
							__METHOD__.'#super_admin', array('ID' => $this->ID, 'username' => $this->username),
							sprintf($this->i18n('Cannot delete super administrator: `%1$s`.'), $this->username)
						);

					if(!wp_delete_user($this->ID, $reassign_posts_to_user_id))
						return $this->©error(
							__METHOD__.'#failure', array('ID' => $this->ID),
							sprintf($this->i18n('Failed to delete user ID: `%1$s`.'), $this->ID)
						);

					$ID       = $this->ID;
					$this->ID = 0;

					$this->wp    = NULL;
					$this->cache = array();

					$this->ip                = '';
					$this->email             = '';
					$this->username          = '';
					$this->nicename          = '';
					$this->password          = '';
					$this->first_name        = '';
					$this->last_name         = '';
					$this->full_name         = '';
					$this->display_name      = '';
					$this->url               = '';
					$this->aim               = '';
					$this->yim               = '';
					$this->jabber            = '';
					$this->description       = '';
					$this->registration_time = 0;
					$this->activation_key    = '';
					$this->status            = 0;

					clean_user_cache($ID);
					wp_cache_delete($ID, 'user_meta');

					return TRUE; // Default return value.
				}

			/**
			 * Updates this user.
			 *
			 * @param         $args array Array of arguments:
			 *
			 *  • (string)`ip` Optional. IP address for this user.
			 *
			 *  • (string)`email` Optional. A valid email address for this user.
			 *
			 *  • (string)`password` Optional. A plain text password (only if changing).
			 *
			 *  • (string)`first_name` Optional. User's first name (self explanatory).
			 *  • (string)`last_name` Optional. User's last name (self explanatory).
			 *  • (string)`display_name` Optional. User's display name (self explanatory).
			 *
			 *  • (string)`url` Optional. A URL associated with this user (e.g. their website URL).
			 *  • (string)`aim` Optional. AOL (AIM) screen name (for contact via instant messenger).
			 *  • (string)`yim` Optional. Yahoo Messenger ID (for contact via instant messenger chat).
			 *  • (string)`jabber` Optional. Google Talk Username (for contact via instant messenger chat).
			 *
			 *  • (string)`description` Optional. About the user (i.e. biographical information).
			 *
			 *  • (array)`options` Optional associative array. Any additional user option values.
			 *       These are stored via ``update_user_option()`` (e.g. blog-specific meta values).
			 *
			 *  • (array)`meta` Optional associative array. Any additional user meta values.
			 *       These are stored via ``update_user_meta()`` (e.g. site-wide meta values).
			 *
			 *  • (array)`data` Optional associative array. Any additional data you'd like to pass through ``wp_update_user()``.
			 *       See: http://codex.wordpress.org/Function_Reference/wp_update_user
			 *       See: http://codex.wordpress.org/Function_Reference/wp_insert_user
			 *
			 *  • (array)`profile_fields` Optional associative array w/ additional profile fields.
			 *       See ``$this->update_profile_fields()`` for further details (implemented by class extenders).
			 *
			 * @param string  $context One of these values: {@link fw_constants::context_registration}, {@link fw_constants::context_profile_updates}.
			 *    The context in which this user is being updated (defaults to {@link fw_constants::context_profile_updates}).
			 *
			 * @param array   $optional_requirements An array of optional fields, which we've decided to require in this scenario.
			 *
			 * @return boolean|errors TRUE on success; else an errors object on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID (e.g. we CANNOT update them).
			 */
			public function update($args, $context = self::context_profile_updates, $optional_requirements = array())
				{
					$this->check_arg_types('array', 'string:!empty', 'array', func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot update).')
						);

					// Formulate & validate incoming args.

					$default_args = array(
						'ip'             => NULL,
						'email'          => NULL,
						'role'           => NULL,
						'password'       => NULL,
						'first_name'     => NULL,
						'last_name'      => NULL,
						'display_name'   => NULL,
						'url'            => NULL,
						'aim'            => NULL,
						'yim'            => NULL,
						'jabber'         => NULL,
						'description'    => NULL,
						'activation_key' => NULL,
						'options'        => NULL,
						'meta'           => NULL,
						'data'           => NULL,
						'profile_fields' => NULL
					);

					$args = $this->check_extension_arg_types(
						'string', 'string', 'string', 'string', 'string', 'string', 'string',
						'string', 'string', 'string', 'string', 'string', 'string', 'array', 'array', 'array', 'array', $default_args, $args
					);
					$args = $this->©array->remove_nulls_deep($args); // Remove NULL values (i.e. those we are NOT updating here).

					// Build array of `data` for our call to ``wp_update_user()`` below.

					$data = array_merge(array( // For ``wp_update_user()`` below.
					                           'ID'           => $this->ID, // This user's ID.
					                           'role'         => ((isset($args['role'])) ? $args['role'] : NULL),
					                           'user_email'   => ((isset($args['email']) && strlen($args['email'])) ? (string)substr($args['email'], 0, 100) : NULL),
					                           'user_pass'    => ((isset($args['password']) && strlen($args['password'])) ? (string)substr($args['password'], 0, 100) : NULL),
					                           'first_name'   => ((isset($args['first_name'])) ? (string)substr($args['first_name'], 0, 100) : NULL),
					                           'last_name'    => ((isset($args['last_name'])) ? (string)substr($args['last_name'], 0, 100) : NULL),
					                           'display_name' => ((isset($args['display_name'])) ? (string)substr($args['display_name'], 0, 250) : NULL),
					                           'user_url'     => ((isset($args['url'])) ? (string)substr($args['url'], 0, 100) : NULL),
					                           'aim'          => ((isset($args['aim'])) ? (string)substr($args['aim'], 0, 100) : NULL),
					                           'yim'          => ((isset($args['yim'])) ? (string)substr($args['yim'], 0, 100) : NULL),
					                           'jabber'       => ((isset($args['jabber'])) ? (string)substr($args['jabber'], 0, 100) : NULL),
					                           'description'  => ((isset($args['description'])) ? (string)substr($args['description'], 0, 5000) : NULL),
					                    ), ((isset($args['data'])) ? $args['data'] : array()));

					$data = $this->©array->remove_nulls_deep($data); // Remove NULL values (i.e. those we are NOT updating here).

					// Validate a possible change of email address (only if it has length).

					if(isset($args['email']) && strlen($args['email'])
					   && $this->©errors->exist_in($validate_email_change_of_address = $this->©user_utils->validate_email_change_of_address($args['email'], $this->email))
					) return $validate_email_change_of_address; // An errors object instance.

					// Validate a possible change of password (only if it has length).

					if(isset($args['password']) && strlen($args['password'])
					   && $this->©errors->exist_in($validate_password = $this->©user_utils->validate_password($args['password']))
					) return $validate_password; // An errors object instance.

					// Validate a possible change of name (only if name(s) are required in this scenario).

					if(isset($args['first_name']) && empty($args['first_name']) && in_array('first_name', $optional_requirements, TRUE))
						return $this->©error(
							__METHOD__.'#first_name_missing', array_merge(array('form_field_code' => 'first_name'), compact('args')),
							$this->translate('Required field. Missing first name.')
						);
					else if(isset($args['last_name']) && empty($args['last_name']) && in_array('last_name', $optional_requirements, TRUE))
						return $this->©error(
							__METHOD__.'#last_name_missing', array_merge(array('form_field_code' => 'last_name'), compact('args')),
							$this->translate('Required field. Missing last name.')
						);
					else if(isset($args['display_name']) && empty($args['display_name']) && in_array('display_name', $optional_requirements, TRUE))
						return $this->©error(
							__METHOD__.'#display_name_missing', array_merge(array('form_field_code' => 'display_name'), compact('args')),
							$this->translate('Required field. Missing display name.')
						);
					// Validate a possible change in online contact info (only if required in this scenario).

					if(isset($args['url']) && empty($args['url']) && in_array('url', $optional_requirements, TRUE))
						return $this->©error(
							__METHOD__.'#url_missing', array_merge(array('form_field_code' => 'url'), compact('args')),
							$this->translate('Required field. Missing URL.')
						);
					else if(isset($args['url']) && strlen($args['url']) && !preg_match($this->©url->regex_pattern, $args['url']))
						return $this->©error(
							__METHOD__.'#invalid_url', array_merge(array('form_field_code' => 'url'), compact('args')),
							$this->translate('Invalid URL. Must start with `http://`.')
						);
					else if(isset($args['aim']) && empty($args['aim']) && in_array('aim', $optional_requirements, TRUE))
						return $this->©error(
							__METHOD__.'#aim_missing', array_merge(array('form_field_code' => 'aim'), compact('args')),
							$this->translate('Required field. Missing AOL® screen name.')
						);
					else if(isset($args['yim']) && empty($args['yim']) && in_array('yim', $optional_requirements, TRUE))
						return $this->©error(
							__METHOD__.'#yim_missing', array_merge(array('form_field_code' => 'yim'), compact('args')),
							$this->translate('Required field. Missing Yahoo® ID.')
						);
					else if(isset($args['jabber']) && empty($args['jabber']) && in_array('jabber', $optional_requirements, TRUE))
						return $this->©error(
							__METHOD__.'#jabber_missing', array_merge(array('form_field_code' => 'jabber'), compact('args')),
							$this->translate('Required field. Missing Jabber™ (or Google® Talk) username.')
						);

					// Validate a possible change in personal bio (i.e. user description).

					if(isset($args['description']) && empty($args['description']) && in_array('description', $optional_requirements, TRUE))
						return $this->©error(
							__METHOD__.'#description_missing', array_merge(array('form_field_code' => 'description'), compact('args')),
							$this->translate('Required field. Missing personal description.')
						);

					// Validate/update any additional profile fields (before we continue any further).

					if(!empty($args['profile_fields']) && // Handled by class extenders via ``$this->update_profile_fields()``.
					   $this->©errors->exist_in($update_profile_fields = $this->update_profile_fields($args['profile_fields'], $context))
					) return $update_profile_fields; // An errors object instance.

					// Update IP address (stored as a meta value).

					if(isset($args['ip']))
						$this->update_meta('ip', $args['ip']);

					// Handles update of option and/or meta values for this user.

					if(isset($args['options']))
						{
							foreach($args['options'] as $_key => $_value)
								if($this->©string->is_not_empty($_key)) $this->update_option($_key, $_value);
							unset($_key, $_value);
						}

					if(isset($args['meta']))
						{
							foreach($args['meta'] as $_key => $_value)
								if($this->©string->is_not_empty($_key)) $this->update_meta($_key, $_value);
							unset($_key, $_value);
						}
					// Update activation key.

					if(isset($args['activation_key']))
						$this->update_activation_key($args['activation_key']);

					// Finalize the update for this user (fires `profile_update` hook in WordPress®).

					if(is_wp_error($wp_update_user = wp_update_user($this->©strings->slash_deep($data))))
						// Given our own validation routines, errors should NOT occur here.
						{
							$this->refresh(); // Let's refresh (in case of updates above).

							if(!$wp_update_user->get_error_code() || !$wp_update_user->get_error_message())
								return $this->©error(
									__METHOD__.'#unknown_wp_error', get_defined_vars(),
									$this->translate('Unknown error (please try again).')
								);
							else return $this->©error(
								__METHOD__.'#wp_error_'.$wp_update_user->get_error_code(), get_defined_vars(),
								$wp_update_user->get_error_message() // Message from ``wp_update_user()``.
							);
						}
					// Fire hook, refresh, and return now.

					$this->do_action('update', $this, get_defined_vars());

					$this->refresh(); // Always refresh object instance after an update.

					return TRUE; // Default return value.
				}

			/**
			 * Updates additional profile fields implemented by class extenders.
			 *
			 * @note This is NOT handled by the core. It requires a class extender to override this.
			 *    By default, this method simply returns a TRUE value at all times.
			 *
			 * @param array  $profile_field_values An associative array of profile fields (by name).
			 *
			 * @param string $context One of these values: {@link fw_constants::context_registration}, {@link fw_constants::context_profile_updates}.
			 *    The context in which profile fields are being updated (defaults to {@link fw_constants::context_profile_updates}).
			 *
			 * @return boolean|errors TRUE on success; else an errors object on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function update_profile_fields($profile_field_values, $context = self::context_profile_updates)
				{
					$this->check_arg_types('array', 'string:!empty', func_get_args());

					return TRUE; // Default return value.
				}

			/**
			 * Handles user profile updates.
			 *
			 * @param array  $args An array of argument values that need to be updated.
			 *    See ``$this->update()`` for further details.
			 *
			 * @param string $optional_requirements An encrypted/serialized array of optional fields, which we've decided to require.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If the user has no ID (i.e. cannot update).
			 * @throws exception If ``$args`` contains data NOT allowed during basic profile updates.
			 */
			public function ®profile_update($args, $optional_requirements = '')
				{
					$this->check_arg_types('array', 'string', func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot update).')
						);

					if(isset($args['ip']) || isset($args['role']) || isset($args['activation_key']) || isset($args['options']) || isset($args['meta']) || isset($args['data']))
						throw $this->©exception(
							__METHOD__.'#security_issue', compact('args'),
							$this->i18n('Security issue. Some of the data submitted, is NOT allowed during basic profile updates.')
						);

					extract($args); // Extract for call data.

					if($optional_requirements && is_array($_optional_requirements = maybe_unserialize($this->©encryption->decrypt($optional_requirements))))
						$optional_requirements = $_optional_requirements; // A specific set of optional fields to require.
					else $optional_requirements = array(); // There are none.

					unset($_optional_requirements); // Housekeeping.

					if($this->©errors->exist_in($response = $this->update($args, $this::context_profile_updates, $optional_requirements)))
						$errors = $response; // Define ``$errors`` for template.

					else // We have success. Profile now up-to-date.
						{
							$successes = $this->©success(
								__METHOD__.'#success', get_defined_vars(),
								$this->translate('Profile updated successfully.')
							);
						}
					$this->©action->set_call_data_for('©users.®profile_update', get_defined_vars());
				}

			/**
			 * Handles user updates (for general/administrative purposes).
			 *
			 * @param array  $args An array of argument values that need to be updated.
			 *    See ``$this->update()`` for further details.
			 *
			 * @param string $optional_requirements An encrypted/serialized array of optional fields, which we've decided to require.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If the user has no ID (i.e. cannot update).
			 */
			public function ®update($args, $optional_requirements = '')
				{
					$this->check_arg_types('array', 'string', func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot update).')
						);

					if($optional_requirements && is_array($_optional_requirements = maybe_unserialize($this->©encryption->decrypt($optional_requirements))))
						$optional_requirements = $_optional_requirements; // A specific set of optional fields to require.
					else $optional_requirements = array(); // There are none.

					unset($_optional_requirements); // Housekeeping.

					if($this->©errors->exist_in($response = $this->update($args, $this::context_profile_updates, $optional_requirements)))
						$errors = $response; // Define ``$errors`` for template use.

					else // We have success. The user's profile has been updated.
						{
							$successes = $this->©success(
								__METHOD__.'#success', get_defined_vars(),
								$this->i18n('User updated successfully.')
							);
						}
					$this->©action->set_call_data_for('©users.®update', get_defined_vars());
				}

			/**
			 * Gets a user option value.
			 *
			 * @param string $key An option key/name.
			 *
			 * @return mixed Data from call to ``get_user_option()``.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID.
			 */
			public function get_option($key)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot get option).')
						);

					return get_user_option($this->ID, $key);
				}

			/**
			 * Updates a user option value.
			 *
			 * @param string $key An option key/name.
			 * @param mixed  $value An option value (mixed data types ok).
			 *    If ``$value`` is NULL, the option ``$key`` is deleted completely.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID.
			 */
			public function update_option($key, $value)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot update option).')
						);

					if(is_null($value))
						delete_user_option($this->ID, $key);
					else update_user_option($this->ID, $key, $value);
				}

			/**
			 * Deletes a user option value.
			 *
			 * @param string $key An option key/name.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID.
			 */
			public function delete_option($key)
				{
					$this->update_option($key, NULL);
				}

			/**
			 * Gets a user meta value.
			 *
			 * @param string $key A meta key/name.
			 *
			 * @return mixed Data from call to ``get_user_meta()``.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID.
			 */
			public function get_meta($key)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot get meta).')
						);

					return get_user_meta($this->ID, $key, TRUE);
				}

			/**
			 * Updates a user meta value.
			 *
			 * @param string $key A meta key/name.
			 * @param mixed  $value A meta value (mixed data types ok).
			 *    If ``$value`` is NULL, the meta ``$key`` is deleted completely.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID.
			 */
			public function update_meta($key, $value)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot update meta).')
						);

					if(is_null($value))
						delete_user_meta($this->ID, $key);
					else update_user_meta($this->ID, $key, $value);

					if($key === 'ip')
						$this->ip = (string)$value;

					else if($key === 'first_name')
						$this->first_name = (string)$value;

					else if($key === 'last_name')
						$this->last_name = (string)$value;

					if(in_array($key, array('first_name', 'last_name'), TRUE))
						$this->full_name = trim($this->first_name.' '.$this->last_name);
				}

			/**
			 * Deletes a user meta value.
			 *
			 * @param string $key A meta key/name.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID.
			 */
			public function delete_meta($key)
				{
					$this->update_meta($key, NULL);
				}

			/**
			 * Updates a user's activation key.
			 *
			 * @param null|string $activation_key A new activation key, or NULL to delete.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID.
			 */
			public function update_activation_key($activation_key)
				{
					$this->check_arg_types(array('null', 'string'), func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot update activation key).')
						);

					$activation_key = (string)$activation_key;
					$activation_key = (string)substr($activation_key, 0, 60);

					$this->©db->update(
						$this->©db_tables->get_wp('users'),
						array('user_activation_key' => $activation_key), array('ID' => $this->ID)
					);
					$this->activation_key = $activation_key;
				}

			/**
			 * Deletes a user's activation key.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID.
			 */
			public function delete_activation_key()
				{
					$this->update_activation_key(NULL);
				}

			/**
			 * Updates a user's password.
			 *
			 * @param string $password A new plain text password.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If this user does NOT have an ID.
			 */
			public function update_password($password)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot update password).')
						);

					wp_set_password($password, $this->ID);
					$this->delete_activation_key();
				}

			/**
			 * Gets the WordPress® Role for this user.
			 *
			 * @note This method assumes there at most ONE role for each user (per blog).
			 *    However, the WordPress® infrastructure appears to be making room for multiple roles to come in the future.
			 *
			 * @return string WordPress® Role for this user.
			 *
			 * @throws exception If this user does NOT have an ID.
			 */
			public function get_wp_role()
				{
					if(!$this->has_id())
						throw $this->©exception(
							__METHOD__.'#id_missing', array('ID' => $this->ID),
							$this->i18n('User has no ID (cannot get WP role).')
						);

					if(isset($this->wp->roles[0]) && is_string($this->wp->roles[0]))
						return $this->wp->roles[0];

					return ''; // Default return value (e.g. they have NO role).
				}
		}
	}