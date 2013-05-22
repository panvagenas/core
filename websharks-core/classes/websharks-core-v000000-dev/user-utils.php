<?php
/**
 * User Utilities.
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
		 * User Utilities.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class user_utils extends framework
		{
			/**
			 * Username regex pattern.
			 *
			 * @var string Username regex pattern.
			 *
			 * @note Minimum 4 characters. Must be 4-60 characters in length.
			 *    Usernames may NEVER exceed 60 characters (max DB column size).
			 */
			public $regex_valid_username = '/^[a-zA-Z][a-zA-Z0-9@._\-]{3,59}$/';

			/**
			 * Username regex pattern (for multisite networks).
			 *
			 * @var string Username regex pattern (for multisite networks).
			 *
			 * @note Minimum 4 characters. Must be 4-60 characters in length.
			 *    Usernames may NEVER exceed 60 characters (max DB column size).
			 */
			public $regex_valid_multisite_username = '/^[a-z][a-z0-9]{3,59}$/';

			/**
			 * Email address regex pattern.
			 *
			 * @var string Email address regex pattern.
			 *
			 * @note Emails may NEVER exceed 100 chars (the max DB column size).
			 * @note This is NOT 100% RFC compliant. This does NOT grok i18n domains.
			 * @see http://en.wikipedia.org/wiki/Email_address
			 */
			public $regex_valid_email = '/^[a-zA-Z0-9_!#$%&*+=?`{}~|\/\^\'\-]+(?:\.?[a-zA-Z0-9_!#$%&*+=?`{}~|\/\^\'\-]+)*@[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?$/';

			/**
			 * Which user are we working with?
			 *
			 * @param null|integer|\WP_User|users $user Optional. One of the following:
			 *    • NULL indicates the current user (i.e. ``$this->©user``).
			 *    • A value of `-1`, indicates NO user explicitly (e.g. a public user w/o an account).
			 *    • An integer indicates a specific user ID (which we'll obtain an object instance for).
			 *    • A ``\WP_User`` object, indicates a specific user (which we'll obtain an object instance for).
			 *    • A ``users`` object, indicates a specific user object instance.
			 *
			 * @return users A user object instance.
			 *    Else an exception is thrown (e.g. unable to determine).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If unable to determine which user we're suppose to be working with.
			 *
			 * @assert () instanceof '\\websharks_core_v000000_dev\\users'
			 * @assert (NULL) instanceof '\\websharks_core_v000000_dev\\users'
			 * @assert (1) instanceof '\\websharks_core_v000000_dev\\users'
			 * @assert (new \WP_User(1)) instanceof '\\websharks_core_v000000_dev\\users'
			 * @assert (-1) instanceof '\\websharks_core_v000000_dev\\users'
			 * @assert (0) instanceof '\\websharks_core_v000000_dev\\users'
			 */
			public function which($user = NULL)
				{
					$this->check_arg_types($this->which_types(), func_get_args());

					if($user instanceof users)
						return $user;

					if(is_null($user))
						return $this->©user;

					if($this->©integer->is_not_empty($user))
						return $this->©user($user);

					if(is_integer($user))
						return $this->©user(-1);

					if($user instanceof \WP_User && $this->©integer->is_not_empty($user->ID))
						return $this->©user($user->ID);

					if($user instanceof \WP_User)
						return $this->©user(-1);

					throw $this->©exception(
						__METHOD__.'#unexpected_user', get_defined_vars(),
						$this->i18n('Not sure which `$user` we\'re dealing with.').
						sprintf($this->i18n(' Got: `%1$s`.'), $this->©var->dump($user))
					);
				}

			/**
			 * Gets an array of ``$this->which()`` user types.
			 *
			 * @return array Array of ``$this->which()`` user types.
			 */
			public function which_types()
				{
					if(!isset($this->cache['which_types']))
						{
							$this->cache['which_types'] = array_unique(
								array(
								     'null', 'integer', '\\WP_User',
								     $this->___instance_config->core_ns_prefix.'\\users',
								     $this->___instance_config->plugin_root_ns_prefix.'\\users'
								));
						}
					return $this->cache['which_types'];
				}

			/**
			 * Gets a dynamic ©user object instance.
			 *
			 * @param string               $by Searches for a user, by a particular type of value.
			 *
			 *    MUST be one of these values:
			 *    • `ID`
			 *    • `username`
			 *    • `email`
			 *    • `activation_key`
			 *    • Others become possible, when/if ``get_id_by()`` is enhanced by a class extender.
			 *
			 * @param string|integer|array $value A value to search for (e.g. username(s), email address(es), ID(s)).
			 *
			 * @return null|users A user object instance, else NULL on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$by`` or ``$value`` are empty.
			 *
			 * @assert ('ID', 1) is-type 'object'
			 * @assert ('username', 'Jason') is-type 'object'
			 * @assert ('email', 'jason@websharks-inc.com') is-type 'object'
			 * @assert ('email', array('foo', 'jason@websharks-inc.com')) is-type 'object'
			 * @assert ('ID', array('99999', '1')) is-type 'object'
			 */
			public function get_by($by, $value)
				{
					$this->check_arg_types('string:!empty', array('string:!empty', 'integer:!empty', 'array:!empty'), func_get_args());

					$by = strtolower($by);

					if($by === 'id' && is_numeric($value))
						{
							if(($value = (integer)$value)
							   && is_object($user = $this->©user($value))
							   && $user->has_id()
							) return $user;
						}
					else if(($user_id = $this->get_id_by($by, $value))
					        && is_object($user = $this->©user($user_id))
					        && $user->has_id()
					) return $user;

					else if(is_object($user = $this->©user(NULL, $by, $value))
					        && $user->is_populated()
					) return $user;

					return NULL; // Default return value.
				}

			/**
			 * Gets a WordPress® user ID.
			 *
			 * @param string               $by Searches for a user, by a particular type of value.
			 *
			 *    MUST be one of these values:
			 *    • `ID`
			 *    • `username`
			 *    • `email`
			 *    • `activation_key`
			 *    • Others become possible when/if this method is enhanced by a class extender.
			 *
			 * @param string|integer|array $value A value to search for (e.g. username(s), email address(es), ID(s)).
			 *
			 * @return integer A WordPress® user ID, else `0`.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$by`` or ``$value`` are empty.
			 *
			 * @assert ('ID', 1) === 1
			 * @assert ('username', 'Jason') === 1
			 * @assert ('email', 'jason@websharks-inc.com') === 1
			 * @assert ('email', array('foo', 'jason@websharks-inc.com')) === 1
			 * @assert ('ID', array('99999', '1')) === 1
			 */
			public function get_id_by($by, $value)
				{
					$this->check_arg_types('string:!empty', array('string:!empty', 'integer:!empty', 'array:!empty'), func_get_args());

					$by = strtolower($by);

					if(in_array($by, array('id', 'username', 'email', 'activation_key'), TRUE))
						{
							if($by === 'id')
								$by = 'ID';

							else if($by === 'username')
								$by = 'user_login';

							else if($by === 'email')
								$by = 'user_email';

							else if($by === 'activation_key')
								$by = 'user_activation_key';

							$query =
								"SELECT".
								" `users`.`ID`".

								" FROM".
								" `".$this->©db_tables->get_wp('users')."` AS `users`".

								" WHERE".
								" `users`.`".$this->©string->esc_sql($by)."` IN(".$this->©db_utils->comma_quotify((array)$value).")".

								" LIMIT 1";

							if(($user_id = (integer)$this->©db->get_var($query)))
								return $user_id;
						}
					return 0; // Default return value.
				}

			/**
			 * Formats a user's registration display name.
			 *
			 * @param array|object $data An array of user data, or an object.
			 *
			 *    Should contain at least one of these:
			 *    • `email`
			 *    • `username`
			 *    • `first_name`
			 *    • `last_name`
			 *    • `full_name`
			 *    • `display_name` (we'll use this if it's in the array/object)
			 *
			 * @return string The user's display name, based on formatting options set by a site owner.
			 *    If there is NOT enough data available to fill the display name, this defaults to `Anonymous`.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (array('first_name' => 'Jason')) === 'Jason'
			 * @assert (array('last_name' => 'Caldwell', 'first_name' => 'Jason')) === 'Jason'
			 */
			public function format_registration_display_name($data = array())
				{
					$this->check_arg_types(array('array', 'object'), func_get_args());

					if(is_array($data)) $data = (object)$data;

					if($this->©string->is_not_empty($data->display_name))
						return $data->display_name;

					switch($format = $this->©options->get('users.registration.display_name_format'))
					{
						case 'email':
								if($this->©string->is_not_empty($data->email))
									return $data->email;
								break;

						case 'username':
								if($this->©string->is_not_empty($data->username))
									return $data->username;
								break;

						case 'first_name':
								if($this->©string->is_not_empty($data->first_name))
									return $data->first_name;
								break;

						case 'last_name':
								if($this->©string->is_not_empty($data->last_name))
									return $data->last_name;
								break;

						case 'full_name':
								if($this->©string->is_not_empty($data->full_name))
									return $data->full_name;
								else if($this->©string->is_not_empty($data->first_name) || $this->©string->is_not_empty($data->last_name))
									return trim($this->©string->is_not_empty_or($data->first_name, '').' '.$this->©string->is_not_empty_or($data->last_name, ''));
								break;
					}
					if($this->©string->is_not_empty($data->first_name)) return $data->first_name;
					if($this->©string->is_not_empty($data->full_name)) return $data->full_name;
					if($this->©string->is_not_empty($data->username)) return $data->username;
					if($this->©string->is_not_empty($data->last_name)) return $data->last_name;
					if($this->©string->is_not_empty($data->email)) return $data->email;

					return $this->apply_filters('default_display_name', $this->translate('Anonymous', 'default-display-name'));
				}

			/**
			 * Is this a valid email address for registration?
			 *
			 * @param string $email A possible email address to validate.
			 *
			 * @return boolean|errors TRUE if ``$email`` is a valid (available) email address.
			 *    Otherwise, this returns an errors object on failure.
			 *
			 * @note Emails may NEVER exceed 100 chars (the max DB column size).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('123') instanceof '\\websharks_core_v000000_dev\\errors'
			 * @assert ('tiny') instanceof '\\websharks_core_v000000_dev\\errors'
			 * @assert ('?@example.com') instanceof '\\websharks_core_v000000_dev\\errors'
			 * @assert ('jason@example.com') === TRUE
			 */
			public function validate_registration_email($email)
				{
					$this->check_arg_types('string', func_get_args());

					$form_field_code = 'email'; // For form errors.
					$user            = (string)strstr($email, '@', TRUE);
					$domain          = ltrim((string)strstr($email, '@'), '@');

					if(!$email)
						return $this->©error(
							__METHOD__.'#missing_email', get_defined_vars(),
							$this->translate('Missing email address (empty).')
						);
					if(is_multisite()) // A multisite network?
						{
							if(!preg_match($this->regex_valid_email, $email)
							   || !is_email($email)
							   || $email !== sanitize_email($email)
							   || strlen($email) > 100
							) return $this->©error(
								__METHOD__.'#invalid_multisite_email', get_defined_vars(),
								sprintf($this->translate('Invalid email address: `%1$s`.'), $email)
							);
							if(email_exists($email))
								return $this->©error(
									__METHOD__.'#multisite_email_exists', get_defined_vars(),
									sprintf($this->translate('Email address: `%1$s`, is already in use.'), $email)
								);
							if(is_array($limited_email_domains = get_site_option('limited_email_domains'))
							   && !empty($limited_email_domains)
							   && !in_array(strtolower($domain), $limited_email_domains, TRUE)
							) return $this->©error(
								__METHOD__.'#unapproved_multisite_email', get_defined_vars(),
								sprintf($this->translate('Unapproved email domain: `%1$s`.'), $domain).
								$this->translate(' You cannot use an email address with this domain.')
							);
							if(is_email_address_unsafe($email))
								return $this->©error(
									__METHOD__.'#restricted_multisite_email', get_defined_vars(),
									sprintf($this->translate('Restricted email domain: `%1$s`.'), $domain).
									$this->translate(' We are having problems with this domain blocking some of our email.'.
									                 ' Please use another email service provider.')
								);
							// Check the WordPress® `signups` table too (in case it's awaiting activation).
							$query = // Checks the WordPress® `signups` table.
								"SELECT".
								" `signups`.*".

								" FROM".
								" `".$this->©string->esc_sql($this->©db_tables->get_wp('signups'))."` AS `signups`".

								" WHERE".
								" `signups`.`user_email` = '".$this->©string->esc_sql($email)."'".

								" LIMIT 1"; // Only need one row here.

							if(is_object($signup = $this->©db->get_row($query, OBJECT)))
								{
									if($signup->active)
										return $this->©error(
											__METHOD__.'#multisite_email_exists', get_defined_vars(),
											sprintf($this->translate('Email address: `%1$s`, is already in use.'), $email)
										);
									if(strtotime($signup->registered) < strtotime('-2 days'))
										$this->©db->delete($this->©db_tables->get_wp('signups'), array('user_email' => $email));

									else return $this->©error(
										__METHOD__.'#reserved_multisite_email', get_defined_vars(),
										sprintf($this->translate('Reserved email address: `%1$s`.'), $email).
										$this->translate(' This email address has already been used. Please check your inbox for an activation link.'.
										                 ' If you do nothing, this email address will become available again — after two days.')
									);
								}
						}
					else // This is a standard WordPress® installation (e.g. it is NOT a multisite network).
						{
							if(!preg_match($this->regex_valid_email, $email)
							   || !is_email($email)
							   || $email !== sanitize_email($email)
							   || strlen($email) > 100
							) return $this->©error(
								__METHOD__.'#invalid_email', get_defined_vars(),
								sprintf($this->translate('Invalid email address: `%1$s`.'), $email)
							);
							if(email_exists($email))
								return $this->©error(
									__METHOD__.'#email_exists', get_defined_vars(),
									sprintf($this->translate('Email address: `%1$s`, is already in use.'), $email)
								);
						}
					return TRUE; // Default return value.
				}

			/**
			 * Is this a valid email address change?
			 *
			 * @param string $email A possible email address to validate.
			 * @param string $existing_email The user's existing email address (possibly the same).
			 *
			 * @return boolean|errors TRUE if ``$email`` is a valid (available) email address.
			 *    Otherwise, this returns an errors object on failure.
			 *
			 * @note Emails may NEVER exceed 100 chars (the max DB column size).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('123') instanceof '\\websharks_core_v000000_dev\\errors'
			 * @assert ('tiny') instanceof '\\websharks_core_v000000_dev\\errors'
			 * @assert ('?@example.com') instanceof '\\websharks_core_v000000_dev\\errors'
			 * @assert ('jason@example.com') === TRUE
			 */
			public function validate_email_change_of_address($email, $existing_email)
				{
					$this->check_arg_types('string', 'string', func_get_args());

					$form_field_code = 'email'; // For form errors.
					$user            = (string)strstr($email, '@', TRUE);
					$domain          = ltrim((string)strstr($email, '@'), '@');

					if(!$email)
						return $this->©error(
							__METHOD__.'#missing_email', get_defined_vars(),
							$this->translate('Missing email address (empty).')
						);
					if(is_multisite()) // A multisite network?
						{
							if(!preg_match($this->regex_valid_email, $email)
							   || !is_email($email)
							   || $email !== sanitize_email($email)
							   || strlen($email) > 100
							) return $this->©error(
								__METHOD__.'#invalid_multisite_email', get_defined_vars(),
								sprintf($this->translate('Invalid email address: `%1$s`.'), $email)
							);
							if(strcasecmp($email, $existing_email) !== 0 && email_exists($email))
								return $this->©error(
									__METHOD__.'#multisite_email_exists', get_defined_vars(),
									sprintf($this->translate('Email address: `%1$s`, is already in use.'), $email)
								);
							if(is_array($limited_email_domains = get_site_option('limited_email_domains'))
							   && !empty($limited_email_domains)
							   && !in_array(strtolower($domain), $limited_email_domains, TRUE)
							) return $this->©error(
								__METHOD__.'#unapproved_multisite_email', get_defined_vars(),
								sprintf($this->translate('Unapproved email domain: `%1$s`.'), $domain).
								$this->translate(' You cannot use an email address with this domain.')
							);
							if(is_email_address_unsafe($email))
								return $this->©error(
									__METHOD__.'#restricted_multisite_email', get_defined_vars(),
									sprintf($this->translate('Restricted email domain: `%1$s`.'), $domain).
									$this->translate(' We are having problems with this domain blocking some of our email.'.
									                 ' Please use another email service provider.')
								);
							if(strcasecmp($email, $existing_email) !== 0) // Check the WordPress® `signups` table.
								{
									$query = // Checks the WordPress® `signups` table.
										"SELECT".
										" `signups`.*".

										" FROM".
										" `".$this->©string->esc_sql($this->©db_tables->get_wp('signups'))."` AS `signups`".

										" WHERE".
										" `signups`.`user_email` = '".$this->©string->esc_sql($email)."'".

										" LIMIT 1"; // Only need one row here.

									if(is_object($signup = $this->©db->get_row($query, OBJECT)))
										{
											if($signup->active)
												return $this->©error(
													__METHOD__.'#multisite_email_exists', get_defined_vars(),
													sprintf($this->translate('Email address: `%1$s`, is already in use.'), $email)
												);
											if(strtotime($signup->registered) < strtotime('-2 days'))
												$this->©db->delete($this->©db_tables->get_wp('signups'), array('user_email' => $email));

											else return $this->©error(
												__METHOD__.'#reserved_multisite_email', get_defined_vars(),
												sprintf($this->translate('Reserved email address: `%1$s`.'), $email).
												$this->translate(' This email address is already associated with another account holder.'.
												                 ' However, there\'s a chance it will become available again in a couple of days;'.
												                 ' should the other account holder fail to complete activation for some reason.')
											);
										}
								}
						}
					else // This is a standard WordPress® installation.
						{
							if(!preg_match($this->regex_valid_email, $email)
							   || !is_email($email)
							   || $email !== sanitize_email($email)
							   || strlen($email) > 100
							) return $this->©error(
								__METHOD__.'#invalid_email', get_defined_vars(),
								sprintf($this->translate('Invalid email address: `%1$s`.'), $email)
							);
							if(strcasecmp($email, $existing_email) !== 0 && email_exists($email))
								return $this->©error(
									__METHOD__.'#email_exists', get_defined_vars(),
									sprintf($this->translate('Email address: `%1$s`, is already in use.'), $email)
								);
						}
					return TRUE; // Default return value.
				}

			/**
			 * Is this a valid/available username?
			 *
			 * @param string $username A possible username to validate.
			 *
			 * @return boolean|errors TRUE if ``$username`` is a valid (available) username.
			 *    Otherwise, this returns an errors object on failure.
			 *
			 * @note Usernames may NEVER exceed 60 characters (the max DB column size).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('123') instanceof '\\websharks_core_v000000_dev\\errors'
			 * @assert ('tiny') instanceof '\\websharks_core_v000000_dev\\errors'
			 * @assert ('?@example.com') instanceof '\\websharks_core_v000000_dev\\errors'
			 * @assert ('jason@example.com') === TRUE
			 */
			public function validate_registration_username($username)
				{
					$this->check_arg_types('string', func_get_args());

					$form_field_code = 'username'; // For form errors.

					if(!$username)
						return $this->©error(
							__METHOD__.'#missing_username', get_defined_vars(),
							$this->translate('Missing username (empty).')
						);
					if(is_multisite()) // A multisite network?
						{
							if(!is_array($illegal_names = get_site_option('illegal_names')))
								add_site_option('illegal_names', ($illegal_names = array('www', 'web', 'root', 'admin', 'main', 'invite', 'administrator')));

							if(!preg_match($this->regex_valid_multisite_username, $username)
							   || $username !== sanitize_user($username, TRUE)
							   || strlen($username) > 60
							) return $this->©error(
								__METHOD__.'#invalid_multisite_username', get_defined_vars(),
								sprintf($this->translate('Invalid username: `%1$s`.'), $username).
								$this->translate(' Please use `a-z0-9` only (lowercase, 4 character minimum).').
								$this->translate(' Username MUST start with a letter.')
							);
							if(username_exists($username))
								return $this->©error(
									__METHOD__.'#multisite_username_exists', get_defined_vars(),
									sprintf($this->translate('Username: `%1$s`, is already in use.'), $username)
								);
							if(in_array(strtolower($username), $illegal_names, TRUE))
								return $this->©error(
									__METHOD__.'#illegal_multisite_username', get_defined_vars(),
									sprintf($this->translate('Illegal/reserved username: `%1$s`.'), $username)
								);
							// Check the WordPress® `signups` table too (in case it's awaiting activation).
							$query = // Checks the WordPress® `signups` table.
								"SELECT".
								" `signups`.*".

								" FROM".
								" `".$this->©string->esc_sql($this->©db_tables->get_wp('signups'))."` AS `signups`".

								" WHERE".
								" `signups`.`user_login` = '".$this->©string->esc_sql($username)."'".

								" LIMIT 1"; // Only need one row here.

							if(is_object($signup = $this->©db->get_row($query, OBJECT)))
								{
									if($signup->active)
										return $this->©error(
											__METHOD__.'#multisite_username_exists', get_defined_vars(),
											sprintf($this->translate('Username: `%1$s`, is already in use.'), $username)
										);
									if(strtotime($signup->registered) < strtotime('-2 days'))
										$this->©db->delete($this->©db_tables->get_wp('signups'), array('user_login' => $username));

									else return $this->©error(
										__METHOD__.'#reserved_multisite_username', get_defined_vars(),
										sprintf($this->translate('Reserved username: `%1$s`.'), $username).
										$this->translate(' Username is currently reserved, but might become available in a couple of days.')
									);
								}
						}
					else // This is a standard WordPress® installation (e.g. it is NOT a multisite network).
						{
							if(!preg_match($this->regex_valid_username, $username)
							   || $username !== sanitize_user($username, TRUE)
							   || strlen($username) > 60
							) return $this->©error(
								__METHOD__.'#invalid_username', get_defined_vars(),
								sprintf($this->translate('Invalid username: `%1$s`.'), $username).
								$this->translate(' Please use `A-Z a-z 0-9 _ . @ -` only (4 character minimum).').
								$this->translate(' Username MUST start with a letter.')
							);
							if(username_exists($username))
								return $this->©error(
									__METHOD__.'#username_exists', get_defined_vars(),
									sprintf($this->translate('Username: `%1$s`, is already in use.'), $username)
								);
						}
					return TRUE; // Default return value.
				}

			/**
			 * Checks to see if a username/email combo DOES exist, but NOT on a specific blog ID.
			 *
			 * @param string       $username A WordPress® username.
			 * @param string       $email A matching email address to look for.
			 * @param null|integer $blog_id A specific blog ID. Defaults to a NULL value.
			 *    If this is NULL, we assume the current blog ID.
			 *
			 * @return integer The existing user ID, if the ``$username``, ``$email`` combination actually DOES exist already,
			 *    BUT the ``$username``, ``$email`` combination is NOT currently a member of ``$blog_id`` (e.g. we can add them to ``$blog_id``).
			 *    Otherwise, this returns `0` by default.
			 */
			public function username_email_exists_but_not_on_blog($username, $email, $blog_id = NULL)
				{
					$this->check_arg_types('string', 'string', array('null', 'integer'), func_get_args());

					if(!isset($blog_id)) $blog_id = get_current_blog_id();

					if($username && $email && $blog_id)
						{
							$query = // Looking for a specific username/email combination.
								"SELECT".
								" `users`.`ID`".

								" FROM".
								" `".$this->©string->esc_sql($this->©db_tables->get_wp('users'))."` AS `users`".

								" WHERE".
								" `users`.`user_login` = '".$this->©string->esc_sql($username)."'".
								" AND `users`.`user_email` = '".$this->©string->esc_sql($email)."'".

								" LIMIT 1";

							if(($user_id = (integer)$this->©db->get_var($query)) && !is_user_member_of_blog($user_id, $blog_id))
								return $user_id;
						}
					return 0; // Default return value.
				}

			/**
			 * Is this a valid password?
			 *
			 * @param string $password A possible password to validate.
			 *
			 * @return boolean|errors TRUE if ``$password`` is a valid (i.e. long/strong enough).
			 *    Otherwise, this returns an errors object on failure.
			 *
			 * @note Passwords may NEVER exceed 100 characters (that's ridiculous).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function validate_password($password)
				{
					$this->check_arg_types('string', func_get_args());

					$form_field_code = 'password'; // For form errors.

					if(!$password) // Missing completely?
						return $this->©error(
							__METHOD__.'#missing_password', get_defined_vars(),
							$this->translate('Missing password (empty).')
						);
					if(strlen($password) < $this->apply_filters('min_password_length', 6))
						return $this->©error(
							__METHOD__.'#password_too_short', get_defined_vars(),
							$this->translate('Password is too short (must be at least six characters).')
						);
					if(strlen($password) > $this->apply_filters('max_password_length', 100))
						return $this->©error(
							__METHOD__.'#password_too_long', get_defined_vars(),
							$this->translate('Password is too long (100 characters max).')
						);
					return TRUE; // Default return value.
				}

			/**
			 * Creates a new WordPress® user.
			 *
			 * @param $args array Array of arguments:
			 *
			 *  • (string)`ip` A required parameter. An IP address for this user.
			 *  • (string)`email` A required parameter. A valid email address.
			 *
			 *    All other parameters are optional. Except ``$username`` is required on multisite networks.
			 *
			 *  • (string)`username` Optional on standard WordPress® installs (but required in multisite networks).
			 *       A valid username. Chars allowed: `A-Za-z0-9_.@-`. If empty, defaults to ``$email`` value.
			 *
			 *       Multisite networks MUST collect a username, because an email address will NOT work in a multisite network.
			 *       WordPress® character restrictions (for usernames) in a multisite network, do NOT allow email addresses.
			 *       On multisite networks, the allowed chars include: `a-z0-9` only (all lowercase).
			 *
			 *  • (string)`password` Optional. A plain text password. If empty, one will be generated automatically.
			 *
			 *  • (string)`first_name` Optional. User's first name (self explanatory).
			 *  • (string)`last_name` Optional. User's last name. Note that a user's `display_name`,
			 *       is NOT collected by this method. Instead, we format a `display_name` automatically, based on preference.
			 *       However, if you'd like to force a specific `display_name`, you can pass it through ``$data``, as detailed below.
			 *       See also: ``format_display_name()`` for further details.
			 *
			 *  • (string)`url` Optional. A URL associated with this user (e.g. their website URL).
			 *
			 *  • (boolean)`must_activate` Optional. Defaults to a TRUE value.
			 *       When this is TRUE, the user account is created; but the account will require email activation.
			 *       This creates a user option: `must_activate` = `TRUE`, which MUST be deleted before access.
			 *
			 *  • (boolean)`send_welcome` Optional. Defaults to a TRUE value.
			 *       When this is TRUE, the user will receive a welcome email, as configured by the site owner.
			 *       If the user `must_activate`, the welcome email is sent upon activation.
			 *
			 *  • (array)`options` Optional associative array. Any additional user option values.
			 *       These are stored via ``update_user_option()`` (e.g. blog-specific meta values).
			 *
			 *  • (array)`meta` Optional associative array. Any additional user meta values.
			 *       These are stored via ``update_user_meta()`` (e.g. site-wide meta values).
			 *
			 *  • (array)`data` Optional associative array. Any additional data you'd like to pass through ``wp_insert_user()``.
			 *       See: http://codex.wordpress.org/Function_Reference/wp_insert_user
			 *
			 * @return array|errors An associative array on success, with a new user ID & password; else an errors object on failure.
			 *    The return array contains three elements: (integer)`ID`, (object)`user`, and (string)`password`.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If unable to acquire user object instance after creation.
			 */
			public function create($args)
				{
					$this->check_arg_types('array', func_get_args());

					// Formulate and validation incoming args.

					$default_args = array(
						'ip'            => '', // Required argument value.
						'email'         => '', // Required argument value.
						'username'      => '', // Required on multisite networks.

						'role'          => get_option('default_role'),

						'password'      => '',
						'first_name'    => '',
						'last_name'     => '',
						'url'           => '',

						'must_activate' => TRUE,
						'send_welcome'  => TRUE,

						'options'       => array(),
						'meta'          => array(),
						'data'          => array()
					);
					$args         = $this->check_extension_arg_types(
						'string', 'string', 'string', 'string:!empty', // `ip`, `email`, `username`, `role`.
						'string', 'string', 'string', 'string', // `password`, `first_name`, `last_name`, `url`.
						'boolean', 'boolean', // `must_activate`, `send_welcome`.
						'array', 'array', 'array', // `options`, `meta`, `data`.
						$default_args, $args, ((is_multisite()) ? 3 : 2)
					);
					// Handle some default values (when/if possible) & minor adjustments.

					if(!$args['username'] && !is_multisite()) // Username is optional (but NOT on multisite networks).
						$args['username'] = $args['email']; // Allows emails to serve as a username. Not recommended, but possible.

					if(is_multisite()) // Force lowercase in multisite networks. Allowed chars include: `a-z0-9` only (all lowercase).
						$args['username'] = strtolower($args['username']); // WordPress® is VERY restrictive in a multisite network.

					if(!$args['password']) // If we were NOT given a plain text password, let's generate one automatically.
						$args['password'] = $this->©string->random(15); // Not recommended, but possible.

					// Put array of `data` together for our call to ``wp_insert_user()`` below.

					$data = array_merge(array( // For ``wp_insert_user()`` below.
					                           'role'       => $args['role'],
					                           'user_email' => (string)substr($args['email'], 0, 100),
					                           'user_login' => (string)substr($args['username'], 0, 60),
					                           'user_pass'  => (string)substr($args['password'], 0, 100),
					                           'first_name' => (string)substr($args['first_name'], 0, 100),
					                           'last_name'  => (string)substr($args['last_name'], 0, 100),
					                           'user_url'   => (string)substr($args['url'], 0, 100)
					                    ), $args['data']);

					$data = array_merge(array( // Format this based on site preference.
					                           'display_name' => (string)substr($this->format_registration_display_name($data), 0, 250)
					                    ), $data);

					// Handles user creation in multisite networks (where the user already exists).

					if(is_multisite() && $args['username'] && $args['email']
					   && ($user_id = $this->username_email_exists_but_not_on_blog($args['username'], $args['email']))
					   && !is_wp_error(add_existing_user_to_blog(array('user_id' => $user_id, 'role' => $args['role'])))
					   && ($user = $this->get_by('id', $user_id)) // Make sure we can get an object instance for this user.
					) // In a network, we can add existing users to this blog, IF they're already in the network (on another blog).
						{
							// We MUST update the password now, because the user will NOT understand what's actually happened here.
							// This MAY lead to confusion, because now the password is different on other blogs in the network, of which they might be a member.
							// Worst case scenario, the user will need to retrieve their password on other blogs in the network, of which they're a member.
							$user->update_password($args['password']); // Set password quietly (i.e. no hooks).
							do_action('user_register', $user->ID); // Actually a registration (so fire this hook).
						}
					else // We're dealing with a brand new user in this scenario (applies also to a multisite network).
						{
							if($this->©errors->exist_in($validate_registration_email = $this->validate_registration_email($args['email'])))
								return $validate_registration_email; // Problem(s) w/ email address.

							if($this->©errors->exist_in($validate_registration_username = $this->validate_registration_username($args['username'])))
								return $validate_registration_username; // Username issue(s).

							if($this->©errors->exist_in($validate_password = $this->validate_password($args['password'])))
								return $validate_password; // Password issue(s).

							if(is_wp_error($wp_insert_user = $user_id = wp_insert_user($this->©strings->slash_deep($data))))
								// Given our own validation routines, errors should NOT occur here (but just in case they do).
								{
									if(!$wp_insert_user->get_error_code() || !$wp_insert_user->get_error_message())
										return $this->©error(
											__METHOD__.'#unknown_wp_error', get_defined_vars(),
											$this->translate('Unknown error (please try again).')
										);
									return $this->©error(
										__METHOD__.'#wp_error_'.$wp_insert_user->get_error_code(), get_defined_vars(),
										$wp_insert_user->get_error_message() // Message from ``wp_insert_user()``.
									);
								}
							if(!($user = $this->get_by('id', $user_id))) // A VERY wrong scenario.
								throw $this->©exception(
									__METHOD__.'#unable_to_acquire_user', get_defined_vars(),
									sprintf($this->i18n('Unable to acquire user ID: `%1$s`.'), $user_id)
								);
							if(is_multisite() // In networks, we need to add the user to the current blog (formally).
							   && is_wp_error($add_existing_user_to_blog = add_existing_user_to_blog(array('user_id' => $user->ID, 'role' => $args['role'])))
							) // If errors occur here, we'll need to stop. The user MUST be formally added to the current blog.
								// Adding the user to this blog, updates their `primary_blog` and `source_domain`.
								{
									/** @var $add_existing_user_to_blog \WP_Error WordPress® error class. */

									if(!$add_existing_user_to_blog->get_error_code() || !$add_existing_user_to_blog->get_error_message())
										return $this->©error(
											__METHOD__.'#unknown_wp_error', get_defined_vars(),
											$this->translate('Unknown error (please try again).')
										);
									return $this->©error(
										__METHOD__.'#wp_error_'.$add_existing_user_to_blog->get_error_code(), get_defined_vars(),
										$add_existing_user_to_blog->get_error_message() // Message from ``add_existing_user_to_blog()``.
									);
								}
						}
					// Save IP address (as a meta value).

					$user->update_meta('ip', $args['ip']);

					// Handle possible option and/or meta values here.

					foreach($args['options'] as $_key => $_value)
						if($this->©string->is_not_empty($_key))
							$user->update_option($_key, $_value);
					unset($_key, $_value);

					foreach($args['meta'] as $_key => $_value)
						if($this->©string->is_not_empty($_key))
							$user->update_meta($_key, $_value);
					unset($_key, $_value);

					// Handle emails and/or activation.

					if($args['must_activate']) // Require email activation?
						$this->send_activation_email($user->ID, $args['password'], $args['send_welcome']);
					else if($args['send_welcome']) // Sends welcome msg.
						$this->send_welcome_email($user->ID, $args['password']);

					// Fire `created` hook and return now.

					$this->do_action('created', $user->ID, get_defined_vars());

					return array('ID' => $user->ID, 'user' => $user, 'password' => $args['password']);
				}

			/**
			 * Additional user authentications.
			 *
			 * @attaches-to WordPress® filter `wp_authenticate_user`.
			 * @filter-priority `1000`
			 *
			 * @param \WP_User|\WP_Error $authentication A `WP_User` object on success, else a `WP_Error` object failure.
			 *
			 * @return \WP_User|\WP_Error A `WP_Error` on failure, else pass ``$authentication`` through.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function wp_authenticate_user($authentication)
				{
					$this->check_arg_types(array('\\WP_User', '\\WP_Error'), func_get_args());

					if(!is_wp_error($authentication) && get_user_option('must_activate', $authentication->ID))
						return new \WP_Error(
							'must_activate', $this->translate('This account has NOT been activated yet. Please check your email for the activation link.')
						);
					if(!is_wp_error($authentication) && is_multisite() && !is_super_admin($authentication->ID) && !in_array(get_current_blog_id(), array_keys(get_blogs_of_user($authentication->ID)), TRUE))
						return new \WP_Error(
							'invalid_username', $this->translate('Invalid username for this site.')
						);
					return $authentication; // Default return value.
				}

			/**
			 * Activates a new WordPress® user.
			 *
			 * @param string $activation_key An encrypted activation key, as produced by ``$this->send_activation_email()``.
			 *
			 * @return array|errors This will return an array on success; else an errors object on failure.
			 *    An array on success, includes: (integer)`ID`, (object)`user`, (string)`password`.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$activation_key`` is empty.
			 */
			public function activate($activation_key)
				{
					$this->check_arg_types('string', func_get_args());

					$decrypted_activation_key = $this->©encryption->decrypt($activation_key);

					if(!$decrypted_activation_key
					   || strpos($decrypted_activation_key, '::') === FALSE
					) // Unable to decrypt (or it's in the wrong format).
						return $this->©error(
							__METHOD__.'#invalid_activation_key', get_defined_vars(),
							$this->translate('Activation failure. Invalid activation key.').
							sprintf($this->translate(' Got: `%1$s`.'), $activation_key)
						);
					list($ID, $password) = explode('::', $decrypted_activation_key, 2);
					$ID = (integer)$ID; // Force integer ID here.

					if(!$ID || !$password // Check parts, user existence, and key MUST match what's on file.
					   || !($user = $this->get_by('id', $ID)) || substr($activation_key, 0, 60) !== $user->activation_key
					) // Something is wrong. This key does NOT match up in some way.
						return $this->©error(
							__METHOD__.'#invalid_activation_key', get_defined_vars(),
							$this->translate('Activation failure. Invalid activation key.').
							sprintf($this->translate(' Got: `%1$s`.'), $activation_key)
						);
					if(!$user->get_option('must_activate'))
						return $this->©error(
							__METHOD__.'#already_active', get_defined_vars(),
							sprintf($this->translate('User ID: `%1$s`. This account is already active.'), $user->ID).
							sprintf($this->translate(' Please <a href="%1$s">log in</a>.'), esc_attr($this->©url->to_wp_login()))
						);
					if($user->get_option('on_activation_send_welcome')) // Send welcome email?
						$this->send_welcome_email($user, $password);

					$user->delete_activation_key();
					$user->delete_option('on_activation_send_welcome');
					$user->delete_option('must_activate');

					return array('ID' => $user->ID, 'user' => $user, 'password' => $password);
				}

			/**
			 * Handles activate action.
			 *
			 * @param string $activation_key An encrypted activation key, as produced by ``$this->send_activation_email()``.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If headers have already been sent, before calling this routine.
			 */
			public function ®activate($activation_key)
				{
					$this->check_arg_types('string', func_get_args());

					if(headers_sent())
						throw $this->©exception(
							__METHOD__.'#headers_sent_already', get_defined_vars(),
							$this->i18n('Unable to activate (headers have already been sent).').
							$this->i18n(' Doing it wrong! Headers have already been sent. Please check hook priorities.')
						);
					if($this->©errors->exist_in($response = $this->activate($activation_key)))
						$errors = $response; // Define ``$errors`` for template use.

					else // We have success. The user needs to log in now.
						{
							extract($response); // Extracts response vars.

							$successes = $this->©success(
								__METHOD__.'#success', get_defined_vars(),
								$this->translate('Account activated successfully.').
								sprintf($this->translate(' Please [CLICK HERE](%1$s) to log in.'), $this->©url->to_wp_login())
							);
						}
					$this->©action->set_call_data_for('©user_utils.®activate', get_defined_vars());

					$this->©headers->clean_status_type(200, 'text/html', TRUE);
					exit($this->©template('activation.php', get_defined_vars())->content);
				}

			/**
			 * Sends user activation email message.
			 *
			 * @param null|integer|\WP_User|users $user User we're sending this email to.
			 *
			 * @param string                      $password Plain text password (required).
			 *
			 * @param boolean                     $send_welcome Optional. Defaults to TRUE. By default, a welcome message is sent upon activation.
			 *    If this is FALSE, no welcome email will be sent upon activation of the account for this user.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$password`` is empty.
			 * @throws exception If ``$user`` does NOT have an ID.
			 */
			public function send_activation_email($user, $password, $send_welcome = TRUE)
				{
					$this->check_arg_types($this->which_types(), 'string:!empty', 'boolean', func_get_args());

					$user = $this->which($user);
					if(!$user->has_id()) // Does this user have an ID?
						throw $this->©exception(
							__METHOD__.'#id_missing', compact('user'),
							$this->i18n('The `$user` has no ID (cannot send activation email message).')
						);
					$activation_key        = $this->©encryption->encrypt($user->ID.'::'.$password);
					$activation_link       = $this->©action->link_for_call('©user_utils.®activate', $this::protected_type, array($activation_key));
					$activation_short_link = $this->©url->shorten($activation_link);

					$template = $this->©template('emails/activation.php', get_defined_vars());

					if($this->©strings->are_not_empty(
						$template->config->from_name, $template->config->from_addr,
						$template->config->subject, $template->config->recipients, $template->content)
					) // OK. We've got everything we need to send this email message.
						{
							$user->update_option('must_activate', TRUE);
							$user->update_activation_key((string)substr($activation_key, 0, 60));

							if($send_welcome)
								$user->update_option('on_activation_send_welcome', TRUE);
							else $user->delete_option('on_activation_send_welcome');

							$this->©mail->send(array(
							                        'from_name'  => $this->©string->is_not_empty_or($template->config->from_name, get_bloginfo('name')),
							                        'from_addr'  => $this->©string->is_not_empty_or($template->config->from_addr, get_bloginfo('admin_email')),
							                        'subject'    => $this->©string->is_not_empty_or($template->config->subject, sprintf($this->translate('Activation Required (For: %1$s)'), get_bloginfo('name'))),
							                        'recipients' => $template->config->recipients,
							                        'message'    => $template->content
							                   ));
						}
				}

			/**
			 * Sends user welcome email message.
			 *
			 * @param null|integer|\WP_User|users $user User we're sending this email to.
			 *
			 * @param string                      $password Plain text password (required).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$password`` is empty.
			 * @throws exception If ``$user`` does NOT have an ID.
			 */
			public function send_welcome_email($user, $password)
				{
					$this->check_arg_types($this->which_types(), 'string:!empty', func_get_args());

					$user = $this->which($user);
					if(!$user->has_id()) // Does this user have an ID?
						throw $this->©exception(
							__METHOD__.'#id_missing', compact('user'),
							$this->i18n('The `$user` has no ID (cannot send welcome email message).')
						);
					$template = $this->©template('emails/welcome.php', get_defined_vars());

					if($this->©strings->are_not_empty(
						$template->config->from_name, $template->config->from_addr,
						$template->config->subject, $template->config->recipients, $template->content)
					) // OK. We've got everything we need to send this email message.
						{
							$this->©mail->send(array(
							                        'from_name'  => $this->©string->is_not_empty_or($template->config->from_name, get_bloginfo('name')),
							                        'from_addr'  => $this->©string->is_not_empty_or($template->config->from_addr, get_bloginfo('admin_email')),
							                        'subject'    => $this->©string->is_not_empty_or($template->config->subject, sprintf($this->translate('Login Details (Welcome To: %1$s)'), get_bloginfo('name'))),
							                        'recipients' => $template->config->recipients,
							                        'message'    => $template->content
							                   ));
						}
				}

			/**
			 * Logs a user into their account.
			 *
			 * @param string  $username Username.
			 * @param string  $password Password.
			 *
			 * @param boolean $remember Optional. Defaults to a TRUE value.
			 *    If FALSE, the login session will end after browser is closed (one session only).
			 *
			 * @param boolean $test_cookies Optional. Defaults to a FALSE value.
			 *    If TRUE, we'll check for the existence of a test cookie.
			 *
			 * @return array|errors This will return an array on success; else an errors object on failure.
			 *    An array on success, includes: (integer)`ID`, (object)`user`, (string)`password`.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If headers have already been sent, before calling this routine.
			 * @throws exception If unable to acquire user object instance after login.
			 */
			public function login($username, $password, $remember = TRUE, $test_cookies = FALSE)
				{
					$this->check_arg_types('string', 'string', 'boolean', 'boolean', func_get_args());

					if(headers_sent())
						throw $this->©exception(
							__METHOD__.'#headers_sent_already', get_defined_vars(),
							$this->i18n('Unable to log user in (headers have already been sent).').
							$this->i18n(' Doing it wrong! Headers have already been sent. Please check hook priorities.')
						);
					if($test_cookies && !$this->©cookie->get(TEST_COOKIE))
						return $this->©error(
							__METHOD__.'#cookie_failure', get_defined_vars(),
							$this->translate('Cookies are blocked (perhaps); or NOT supported by your browser.')
						);
					if($username && !force_ssl_admin()
					   && ($ID = $this->get_id_by('username', $username)) && get_user_option('use_ssl', $ID)
					) // If the user wants SSL, force SSL administrative URLs.
						force_ssl_admin(TRUE);

					$secure_cookie = (force_ssl_admin() && is_ssl()) ? TRUE : FALSE; // Only if forcing SSL administration (and this is an SSL login).

					if(is_wp_error($wp_signon = wp_signon(array('user_login' => $username, 'user_password' => $password, 'remember' => $remember), $secure_cookie)))
						{
							if(!$wp_signon->get_error_code() || !$wp_signon->get_error_message())
								return $this->©error(
									__METHOD__.'#unknown_wp_error', get_defined_vars(),
									$this->translate('Missing data (please try again).')
								);
							return $this->©error(
								__METHOD__.'#wp_error_'.$wp_signon->get_error_code(), get_defined_vars(),
								$wp_signon->get_error_message() // Message from ``wp_signon()``.
							);
						}
					if(!($user = $this->get_by('id', $wp_signon->ID)))
						throw $this->©exception(
							__METHOD__.'#unable_to_acquire_user', get_defined_vars(),
							sprintf($this->i18n('Unable to acquire user ID: `%1$s`.'), $wp_signon->ID)
						);
					return array('ID' => $user->ID, 'user' => $user, 'password' => $password);
				}

			/**
			 * Handles login action.
			 *
			 * @param string         $username Username.
			 * @param string         $password Password.
			 *
			 * @param string|boolean $remember Optional. Defaults to a TRUE value.
			 *    If FALSE, the login session will end after browser is closed (one session only).
			 *
			 * @param string|boolean $test_cookies Optional. Defaults to a FALSE value.
			 *    If TRUE, we'll check for the existence of a test cookie.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If headers have already been sent, before calling this routine.
			 */
			public function ®login($username, $password, $remember = TRUE, $test_cookies = FALSE)
				{
					$this->check_arg_types('string', 'string', array('string', 'boolean'), array('string', 'boolean'), func_get_args());
					$remember     = (boolean)$remember; // So this arg can be passed via `call` actions.
					$test_cookies = (boolean)$test_cookies; // So it can be passed via `call` actions.

					if(headers_sent())
						throw $this->©exception(
							__METHOD__.'#headers_sent_already', get_defined_vars(),
							$this->i18n('Unable to log user in (headers have already been sent).').
							$this->i18n(' Doing it wrong! Headers have already been sent. Please check hook priorities.')
						);
					if((force_ssl_login() || force_ssl_admin()) && !is_ssl())
						wp_redirect($this->©url->current('https')).exit();

					$this->©cookie->set(TEST_COOKIE, '1', 0);

					if($this->©errors->exist_in($response = $this->login($username, $password, $remember, $test_cookies)))
						{
							$errors = $response; // Set `errors` for template.

							$this->©action->set_call_data_for('©user_utils.®login', get_defined_vars());

							if((string)$this->©vars->_REQUEST('via_shortcode'))
								return; // Allow shortcode to handle.

							$this->©headers->clean_status_type(200, 'text/html', TRUE);
							exit($this->©template('login.php', get_defined_vars())->content);
						}
					else // Handle this with an automatic redirection after having logged-in.
						{
							extract($response); // Extracts all response vars for use below.
							/** @var $user users A `users` object instance (via ``$response`` vars). */

							if(!($redirect_to = $_r_redirect_to = (string)$this->©vars->_REQUEST('redirect_to')))
								$redirect_to = $this->©url->to_wp_admin_uri();

							$redirect_to = apply_filters('login_redirect', $redirect_to, $_r_redirect_to, $user->wp, $user);

							if(!$redirect_to || rtrim($redirect_to, '/') === 'wp-admin' || preg_match('/\/wp-admin[\/?#]*$/', $redirect_to))
								{
									if(is_multisite() && !get_active_blog_for_user($user->ID) && !$user->is_super_admin())
										$redirect_to = $this->©url->to_wp_user_admin_uri();

									else if(is_multisite() && !$user->wp->has_cap('read'))
										$redirect_to = $this->©url->to_wp_user_dashboard_uri($user->ID);

									else if(!$user->wp->has_cap('edit_posts'))
										$redirect_to = $this->©url->to_wp_admin_uri('/profile.php');
								}
							if(!$redirect_to) // Absolute default value (if all else fails somehow).
								$redirect_to = $this->©url->to_wp_home_uri(); // Redirect user to the home page.

							if(force_ssl_admin() && $this->©url->is_in_wp_admin($redirect_to))
								$redirect_to = $this->©url->set_scheme($redirect_to, 'https');

							$this->©action->set_call_data_for('©user_utils.®login', get_defined_vars());

							wp_safe_redirect($redirect_to).exit();
						}
				}

			/**
			 * Handles logout action.
			 *
			 * @throws exception If headers have already been sent, before calling this routine.
			 */
			public function ®logout()
				{
					if(headers_sent())
						throw $this->©exception(
							__METHOD__.'#headers_sent_already', get_defined_vars(),
							$this->i18n('Unable to log user out (headers have already been sent).').
							$this->i18n(' Doing it wrong! Headers have already been sent. Please check hook priorities.')
						);
					if((force_ssl_login() || force_ssl_admin()) && !is_ssl())
						wp_redirect($this->©url->current('https')).exit();

					$this->©user->logout(); // Logs current user out of WordPress®.

					$this->©action->set_call_data_for('©user_utils.®logout', get_defined_vars());

					if(($redirect_to = (string)$this->©vars->_REQUEST('redirect_to')))
						wp_safe_redirect($redirect_to).exit();

					else // Else handle this w/ template display (e.g. a logged-out message).
						{
							$messages = $this->©message(
								__METHOD__.'#logged-out', get_defined_vars(),
								$this->translate('You are now logged-out.')
							);

							$this->©headers->clean_status_type(200, 'text/html', TRUE);
							exit($this->©template('login.php', get_defined_vars())->content);
						}
				}

			/**
			 * Handles lost passwords (sends password reset email).
			 *
			 * @param string $username_or_email A username or email address.
			 *
			 * @return array|errors This will return an array on success; else an errors object on failure.
			 *    An array on success, includes: (integer)`ID`, (object)`user`, (string)`activation_key`.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If we're unable to establish an activation key for the associated user.
			 */
			public function lost_password($username_or_email)
				{
					$this->check_arg_types('string', func_get_args());

					if($username_or_email // Can we find this user?
					   && (($ID = $this->get_id_by('username', $username_or_email))
					       || ($ID = $this->get_id_by('email', $username_or_email)))
					   && ($user = $this->get_by('id', $ID))
					) // OK. We found the account ID for this user.
						{
							// We support this WordPress® filter.
							if(!apply_filters('allow_password_reset', TRUE, $user->ID))
								return $this->©error(
									__METHOD__.'#password_reset_disabled', get_defined_vars(),
									$this->translate('Password reset is NOT allowed for this user.')
								);
							if(!$user->activation_key)
								$user->update_activation_key($this->©encryption->keygen(60));

							if(!$user->activation_key)
								throw $this->©exception(
									__METHOD__.'#missing_activation_key', compact('user'),
									sprintf($this->i18n('No activation key for user ID: `%1$s`.'), $user->ID)
								);
							$this->send_password_reset_email($user);

							return array('ID' => $user->ID, 'user' => $user, 'activation_key' => $user->activation_key);
						}
					return $this->©error(
						__METHOD__.'#username_email_not_found', get_defined_vars(),
						$this->translate('Username (or email address) is NOT associated with a user of this site.')
					);
				}

			/**
			 * Handles lost passwords action.
			 *
			 * @param string $username_or_email A username or email address.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If headers have already been sent, before calling this routine.
			 */
			public function ®lost_password($username_or_email)
				{
					$this->check_arg_types('string', func_get_args());

					if(headers_sent())
						throw $this->©exception(
							__METHOD__.'#headers_sent_already', get_defined_vars(),
							$this->i18n('Unable to retrieve lost password (headers have already been sent).').
							$this->i18n(' Doing it wrong! Headers have already been sent. Please check hook priorities.')
						);
					if((force_ssl_login() || force_ssl_admin()) && !is_ssl())
						wp_redirect($this->©url->current('https')).exit();

					if($this->©errors->exist_in($response = $this->lost_password($username_or_email)))
						$errors = $response; // Define ``$errors`` for template use.

					else // We have success. They user needs to check their email now.
						{
							extract($response); // Extracts response vars.

							$successes = $this->©success(
								__METHOD__.'#success', get_defined_vars(),
								$this->translate('Please check your email for a password reset link.')
							);
						}
					$this->©action->set_call_data_for('©user_utils.®lost_password', get_defined_vars());

					$this->©headers->clean_status_type(200, 'text/html', TRUE);
					exit($this->©template('lost-password.php', get_defined_vars())->content);
				}

			/**
			 * Sends user a password reset email message.
			 *
			 * @param null|integer|\WP_User|users $user User we're sending this email to.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$user`` does NOT have an ID, or has NO activation key.
			 */
			public function send_password_reset_email($user)
				{
					$this->check_arg_types($this->which_types(), func_get_args());

					$user = $this->which($user);
					if(!$user->has_id()) // Does this user have an ID?
						throw $this->©exception(
							__METHOD__.'#id_missing', compact('user'),
							$this->i18n('The `$user` has no ID (cannot send password reset email message).')
						);
					if(!$user->activation_key)
						$user->update_activation_key($this->©encryption->keygen(60));

					if(!$user->activation_key) // Does this user have an activation key?
						throw $this->©exception(
							__METHOD__.'#activation_key_missing', compact('user'),
							$this->i18n('The `$user` has no activation key (cannot send password reset email message).')
						);
					$activation_key            = $user->activation_key;
					$password_reset_link       = $this->©action->link_for_call('©user_utils.®reset_password', $this::protected_type, array($activation_key));
					$password_reset_short_link = $this->©url->shorten($password_reset_link);

					$template = $this->©template('emails/password-reset.php', get_defined_vars());

					if($this->©strings->are_not_empty(
						$template->config->from_name, $template->config->from_addr,
						$template->config->subject, $template->config->recipients, $template->content)
					) // OK. We've got everything we need to send this email message.
						{
							$this->©mail->send(array(
							                        'from_name'  => $this->©string->is_not_empty_or($template->config->from_name, get_bloginfo('name')),
							                        'from_addr'  => $this->©string->is_not_empty_or($template->config->from_addr, get_bloginfo('admin_email')),
							                        'subject'    => $this->©string->is_not_empty_or($template->config->subject, sprintf($this->translate('Password Reset (%1$s)'), get_bloginfo('name'))),
							                        'recipients' => $template->config->recipients,
							                        'message'    => $template->content
							                   ));
						}
				}

			/**
			 * Handles password reset for a user.
			 *
			 * @param string $activation_key A valid password reset activation key.
			 * @param string $password A new password for this user.
			 *
			 * @return array|errors This will return an array on success; else an errors object on failure.
			 *    An array on success, includes: (integer)`ID`, (object)`user`, (string)`activation_key`, (string)`password`.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function reset_password($activation_key, $password)
				{
					$this->check_arg_types('string', 'string', func_get_args());

					if($activation_key // Can we find this user w/ activation key?
					   && ($user = $this->get_by('activation_key', $activation_key))
					) // OK. We found the account ID for this user.
						{
							// We support this WordPress® filter.
							if(!apply_filters('allow_password_reset', TRUE, $user->ID))
								return $this->©error(
									__METHOD__.'#password_reset_disabled', get_defined_vars(),
									$this->translate('Password reset is NOT allowed for this user.')
								);
							if($this->©errors->exist_in($validate_password = $this->validate_password($password)))
								return $validate_password; // Password issue(s).

							$user->update_password($password); // Looks good (update password now).

							return array('ID' => $user->ID, 'user' => $user, 'activation_key' => $activation_key, 'password' => $password);
						}
					return $this->©error(
						__METHOD__.'#invalid_activation_key', get_defined_vars(),
						$this->translate('Password reset failure. Invalid (or expired) activation key.').
						sprintf($this->translate(' Got: `%1$s`.'), $activation_key)
					);
				}

			/**
			 * Handles password reset action.
			 *
			 * @param string $activation_key A valid password reset activation key.
			 * @param string $password A new password for this user.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If headers have already been sent, before calling this routine.
			 */
			public function ®reset_password($activation_key, $password = '')
				{
					$this->check_arg_types('string', 'string', func_get_args());

					if(headers_sent())
						throw $this->©exception(
							__METHOD__.'#headers_sent_already', get_defined_vars(),
							$this->i18n('Unable to reset password (headers have already been sent).').
							$this->i18n(' Doing it wrong! Headers have already been sent. Please check hook priorities.')
						);
					if((force_ssl_login() || force_ssl_admin()) && !is_ssl())
						wp_redirect($this->©url->current('https')).exit();

					if($password) // Only if a password has been submitted (else do nothing).
						{
							if($this->©errors->exist_in($response = $this->reset_password($activation_key, $password)))
								$errors = $response; // Define ``$errors`` for template use.

							else // We have success. The user may now log in.
								{
									extract($response); // Extracts response vars.

									$successes = $this->©success(
										__METHOD__.'#success', get_defined_vars(),
										sprintf($this->translate('Password reset. Please [log in](%1$s).'), $this->©url->to_wp_login())
									);
								}
						}
					$this->©action->set_call_data_for('©user_utils.®reset_password', get_defined_vars());

					$this->©headers->clean_status_type(200, 'text/html', TRUE);
					exit($this->©template('reset-password.php', get_defined_vars())->content);
				}
		}
	}