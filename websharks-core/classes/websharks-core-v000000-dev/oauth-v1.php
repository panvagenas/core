<?php
/**
 * OAuth v1.
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
		 * OAuth v1.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class oauth_v1 extends framework
		{
			/**
			 * @var string URL, where we can request a new access token.
			 *    An API that has implemented an OAuth client, should always provide this.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $access_token_url = '';

			/**
			 * @var string A string containing vital OAuth credentials.
			 *    This is a pipe-delimited string, containing a total of five parts.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $authorization_code = '';

			/**
			 * @var string A string containing vital OAuth credentials.
			 *    This is a line-delimited string, containing a total of three parts.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $access_code = '';

			/**
			 * @var string A string containing vital OAuth credentials.
			 *    This is ONLY set, if object construction results in a new access code.
			 * @by-constructor Set dynamically by class constructor.
			 *
			 * @note Callers should ALWAYS check this property after object construction.
			 *    If it's NOT empty, the new access code should be saved for future use (in a DB perhaps).
			 *
			 * @see Conditional ``has_new_access_code()`` in this class.
			 */
			public $new_access_code = '';

			/**
			 * @var array OAuth signable var types (i.e. `GET`, `POST`, etc).
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $signable_var_types = array();

			/**
			 * @var string $consumer_key An OAuth consumer key.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $consumer_key = '';

			/**
			 * @var string $consumer_secret An OAuth consumer secret.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $consumer_secret = '';

			/**
			 * @var string $token An OAuth token.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $token = '';

			/**
			 * @var string $token_secret An OAuth token secret.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $token_secret = '';

			/**
			 * @var array Permissible errors codes (based on request type).
			 * @note This enhances error handling in a few predictable scenarios.
			 */
			public $permissible_error_codes = array();

			/**
			 * @var array Default OAuth vars.
			 * @note A default set of OAuth vars, used by ``sign()``.
			 */
			public $default_vars = array(
				'oauth_consumer_key'     => '',
				'oauth_nonce'            => '',
				'oauth_signature'        => '',
				'oauth_signature_method' => 'HMAC-SHA1',
				'oauth_timestamp'        => '',
				'oauth_token'            => '',
				'oauth_verifier'         => '',
				'oauth_version'          => '1.0'
			);

			/**
			 * Did object construction result in a new access code?
			 *
			 * @return boolean TRUE if we have a new access code; else FALSE.
			 *    A new access code will be available in property value: ``$this->new_access_code``.
			 *
			 * @note Callers should ALWAYS check this after object construction.
			 *    If this is TRUE, the new access code should be saved for future use.
			 */
			public function has_new_access_code()
				{
					return ($this->new_access_code) ? TRUE : FALSE;
				}

			/**
			 * Is this OAuth instance ready-to-go?
			 *
			 * @return boolean TRUE if we have valid authorization/access codes.
			 *    Otherwise, this returns a FALSE value (class methods may return unexpected results).
			 */
			public function has_authorization_access_codes()
				{
					return ($this->authorization_code && $this->access_code) ? TRUE : FALSE;
				}

			/**
			 * Constructor.
			 *
			 * @param object|array $___instance_config Required at all times.
			 *    A parent object instance, which contains the parent's ``$___instance_config``,
			 *    or a new ``$___instance_config`` array.
			 *
			 * @param string       $access_token_url string URL, where we can request a new access token.
			 *    An API that has implemented an OAuth client should always provide this.
			 *
			 * @var string         $authorization_code A string containing vital OAuth credentials.
			 *    This is a pipe-delimited string, containing a total of five parts:
			 *
			 *       • Consumer key.
			 *       • Consumer secret.
			 *       • Request token.
			 *       • Request token secret.
			 *       • Verifier.
			 *
			 * @var string         $access_code A string containing vital OAuth credentials.
			 *    This is a line-delimited string, containing a total of three parts:
			 *
			 *       • Access token.
			 *       • Access token secret.
			 *       • Authorization code used to obtain this access code.
			 *
			 * @param array        $signable_var_types Optional. This defaults to ``array('GET', 'POST')``.
			 *    Some APIs using OAuth, do NOT consider POST vars in their signature base string.
			 *    That OAuth standards say they SHOULD; but AWeber® is one shining example.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$access_token_url`` is empty.
			 */
			public function __construct($___instance_config,
			                            $access_token_url, $authorization_code, $access_code,
			                            $signable_var_types = array('GET', 'POST'))
				{
					parent::__construct($___instance_config); // Call parent constructor.

					$this->check_arg_types('', 'string:!empty', 'string', 'string', 'array', func_get_args());

					// Fill some initial property values.

					$this->access_token_url   = $access_token_url;
					$this->authorization_code = $authorization_code;
					$this->access_code        = $access_code;
					$this->signable_var_types = $signable_var_types;

					// Split authorization/access codes into parts. None of these can be empty.

					$authorization_code_parts = preg_split('/\|/', $this->authorization_code, NULL, PREG_SPLIT_NO_EMPTY);
					$access_code_parts        = preg_split("/\n/", $this->access_code, NULL, PREG_SPLIT_NO_EMPTY);

					// We MUST have a valid authorization code to fill remaining property values.

					if($this->authorization_code && count($authorization_code_parts) === 5)
						{
							// Set properties (these get us an access code).

							$this->consumer_key    = $authorization_code_parts[0];
							$this->consumer_secret = $authorization_code_parts[1];
							$this->token           = $authorization_code_parts[2];
							$this->token_secret    = $authorization_code_parts[3];
							$this->verifier        = $authorization_code_parts[4];

							// Check access code. Do we NOT have one yet? Or, do we need a NEW one?

							if($this->access_code && count($access_code_parts) === 3 && $access_code_parts[2] === $this->authorization_code)
								{
									$this->token        = $access_code_parts[0];
									$this->token_secret = $access_code_parts[1];
								}
							else if(is_array($api_response = $this->api_response('POST', $this->access_token_url, array(), $this->verifier))
							        && $this->©strings->are_not_empty($api_response['oauth_token'], $api_response['oauth_token_secret'])
							) // Update ``$this->access_code`` & also set flag w/ ``$this->new_access_code``.
								{
									$this->access_code = $api_response['oauth_token']."\n".
									                     $api_response['oauth_token_secret']."\n".
									                     $this->authorization_code;

									$this->token        = $api_response['oauth_token'];
									$this->token_secret = $api_response['oauth_token_secret'];

									$this->new_access_code = $this->access_code; // This should be saved now.
								}
							else $this->authorization_code = $this->access_code = ''; // Cannot get an access code.
						}
					else $this->authorization_code = $this->access_code = ''; // We don't even have an authorization code.
				}

			/**
			 * Calls an OAuth API (gets response).
			 *
			 * @param string $method The request method (i.e. `GET`, `POST`, etc).
			 * @param string $url The request URL (i.e. an OAuth API endpoint).
			 * @param array  $vars Array of all GET/POST request vars.
			 * @param string $verifier Optional, an OAuth verifier.
			 *
			 * @return array|boolean|errors This returns an array of data the OAuth API provides in its response.
			 *    Or, this may return boolean TRUE, if there were no errors, and there was no response data.
			 *    Else, this will return an `errors` object if the API call fails, for any reason.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$method`` or ``$url`` are empty.
			 *
			 * @see http://oauth.net/core/1.0/
			 * @see http://oauth.net/core/1.0/#response_parameters
			 */
			public function api_response($method, $url, $vars = array(), $verifier = '')
				{
					$this->check_arg_types('string:!empty', 'string:!empty', 'array', 'string', func_get_args());

					$method  = strtoupper($method);
					$headers = array();
					$body    = NULL;

					$request_type = $this->request_type($url);
					$request_type = $this->©string->is_not_empty_or($request_type, 'n/a');
					$vars         = $this->apply_filters($method.'__'.$request_type.'__vars', $vars, get_defined_vars());

					if($method === 'GET' && $vars)
						$url = add_query_arg(rawurlencode_deep($vars), $url);

					else if($method === 'POST' && $vars)
						{
							$body                    = $this->©vars->build_raw_query($vars);
							$headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
						}
					$oauth_signature          = $this->sign($method, $url, $vars, $verifier);
					$headers['Authorization'] = $oauth_signature['header'];

					$response = $this->©url->remote(
						$url, NULL, array(
						                 'timeout'      => 20, 'redirection' => 0,
						                 'return_array' => TRUE, 'return_errors' => TRUE,
						                 'method'       => $method, 'headers' => $headers, 'body' => $body
						            )
					);
					if(!is_array($response))
						return $this->©error(
							$this->method(__FUNCTION__), get_defined_vars(),
							sprintf($this->i18n('OAuth API call: `%1$s » %2$s`).'), $method, $url).
							$this->i18n(' Connection failure.')
						);
					$oauth = array(); // Initialize OAuth response array.

					if($response['body']) // Detect response body type.
						// There does NOT seem to be any way of forcing OAuth to a particular output type.
						// Some services use JSON, but there's no way to enforce JSON; so we'll leave this here.
						{
							if(!is_array($oauth = json_decode($response['body'], TRUE)))
								if(!is_array($oauth = maybe_unserialize($response['body'])))
									$oauth = $this->©vars->parse_query($response['body']);
							$oauth = $this->©string->ify_deep($oauth);
						}
					if(isset($oauth['error']['status'])
					   && $this->©string->is_not_empty($oauth['error']['status'])
					) $error_code = $oauth['error']['status'];
					else if($response['code'] >= 400)
						$error_code = (string)$response['code'];

					if(!empty($error_code)) // Handle errors (get error message).
						{
							if(isset($oauth['error']['message'])
							   && $this->©string->is_not_empty($oauth['error']['message'])
							) $error_message = $oauth['error']['message'];

							else if($response['message'])
								$error_message = $response['message'];

							else // Generates a default error message.
								$error_message = $this->i18n('Check error code.');

							if($this->©array->is_not_empty($this->permissible_error_codes[$request_type])
							   && in_array($error_code, $this->permissible_error_codes[$request_type], TRUE)
							) $error_code = $error_message = NULL; // Nullify.

							if($error_code) // Error is NOT permissible (we MUST fail).
								{
									return $this->©error(
										$this->method(__FUNCTION__), get_defined_vars(),
										sprintf($this->i18n('OAuth API call: `%1$s » %2$s`).'), $method, $url).
										sprintf($this->i18n(' Error code: `%1$s`.'), $error_code).
										sprintf($this->i18n(' Message: `%1$s`.'), $error_message)
									);
								}
						}
					$this->©success(
						$this->method(__FUNCTION__), get_defined_vars(),
						sprintf($this->i18n('OAuth API call: `%1$s » %2$s`).'), $method, $url).
						$this->i18n(' Status: `success`.')
					);
					if(empty($oauth))
						return TRUE; // Assume success.

					return $oauth; // Array of data from the API response.
				}

			/**
			 * Parses the request type from an API request URL.
			 *
			 * @param string $url An OAuth API request URL (i.e. an endpoint URL).
			 *
			 * @return string The request type; else an empty string on detection failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function request_type($url)
				{
					$this->check_arg_types('string', func_get_args());

					foreach(array_reverse(explode('/', (string)$this->©url->parse($url, PHP_URL_PATH))) as $dir)
						if($dir && !is_numeric($dir[0]))
							return $dir;

					return ''; // Default return value.
				}

			/**
			 * Generates an OAuth (base64 encoded, HMAC-SHA1) signature.
			 *
			 * @param string $method The request method (i.e. `GET`, `POST`, etc).
			 * @param string $url The request URL (i.e. an OAuth API endpoint).
			 * @param array  $vars Array of all GET/POST request vars.
			 * @param string $verifier Optional, an OAuth verifier.
			 *
			 * @return array An array w/ these elements:
			 *    • (array)`signable_vars` — Sorted (signable) vars.
			 *    • (string)`signable_vars_qs` — Sorted (signable) vars; as query string.
			 *    • (array)`signed_vars` — Sorted (signed) vars; including the signature.
			 *    • (string)`signed_vars_qs` — Sorted (signed) vars; including the signature; as query string.
			 *    • (string)`header` — An `Authorization` header value; including all OAuth vars.
			 *    • (string)`signature` — OAuth (base64 encoded, HMAC-SHA1) signature.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$method`` or ``$url`` are empty.
			 *
			 * @see http://oauth.net/core/1.0/#sig_base_example
			 * @see http://oauth.net/core/1.0/#sig_norm_param
			 */
			public function sign($method, $url, $vars = array(), $verifier = '')
				{
					$this->check_arg_types('string:!empty', 'string:!empty', 'array', 'string', func_get_args());

					$method = strtoupper($method); // Force an uppercase value.

					// Establish initial array of signable vars.
					if(in_array($method, $this->signable_var_types, TRUE))
						$signable_vars = $vars; // Include.
					else $signable_vars = array();

					// OAuth vars.
					$oauth_vars = array_merge(
						$this->default_vars, // Defaults.
						array( // Merge together w/ default vars.
						       'oauth_consumer_key' => $this->consumer_key,
						       'oauth_nonce'        => $this->©string->unique_id(),
						       'oauth_timestamp'    => (string)time(),
						       'oauth_token'        => $this->token,
						       'oauth_verifier'     => $verifier
						)
					);
					// Merge OAuth vars into ``$signable_vars``.
					$signable_vars = array_merge($signable_vars, $oauth_vars);

					// Remove the signature (for now). It's NEVER a signable var.
					unset($oauth_vars['oauth_signature'], $signable_vars['oauth_signature']);

					// An `oauth_verifier` (for obtaining an access token); is N/A in most cases.
					if(!$oauth_vars['oauth_verifier'] || !$signable_vars['oauth_verifier'])
						unset($oauth_vars['oauth_verifier'], $signable_vars['oauth_verifier']);

					if(($_url_parts = $this->©url->parse($url, NULL, 0 /* We normalize below. */)))
						{
							// Include GET vars (i.e. those in the query string)?
							if($_url_parts['query'] && in_array('GET', $this->signable_var_types, TRUE))
								{
									$_query_vars   = $this->©vars->parse_raw_query($_url_parts['query'], FALSE);
									$signable_vars = array_merge($signable_vars, $_query_vars);
									unset($_query_vars);
								}
							// According to OAuth specs.
							$_url_parts['scheme'] = strtolower($_url_parts['scheme']);
							$_url_parts['host']   = strtolower($_url_parts['host']);

							// According to OAuth specs.
							if($_url_parts['scheme'] === 'http' && $_url_parts['port'] === 80
							   || $_url_parts['scheme'] === 'https' && $_url_parts['port'] === 443
							) unset($_url_parts['port']);

							// According to OAuth specs.
							unset($_url_parts['query'], $_url_parts['fragment']);

							// Piece the URL back together now.
							$url = $this->©url->unparse($_url_parts, 0);
						}
					unset($_url_parts); // Just a little housekeeping here.

					// Sort ``$signable_vars``; build raw query: ``$signable_vars_qs``.
					$signable_vars    = $this->©array->ksort_deep($signable_vars, SORT_STRING);
					$signable_vars_qs = $this->©vars->build_raw_query($signable_vars);

					// Formulate OAuth base signature string, and signature key.
					$base = rawurlencode($method).'&'.rawurlencode($url).'&'.rawurlencode($signable_vars_qs);
					$key  = rawurlencode($this->consumer_secret).'&'.rawurlencode($this->token_secret);

					// Generate signature; construct array of ``$signed_vars`` (w/ signature).
					$signature      = base64_encode($this->©encryption->hmac_sha1_sign($base, $key, TRUE));
					$signed_vars    = array_merge($signable_vars, array('oauth_signature' => $signature));
					$signed_vars    = $this->©array->ksort_deep($signed_vars, SORT_STRING);
					$signed_vars_qs = $this->©vars->build_raw_query($signed_vars);

					// Finalize ``$oauth_vars``; (adding signature into the array).
					$oauth_vars    = array_merge($oauth_vars, array('oauth_signature' => $signature));
					$oauth_vars    = $this->©array->ksort_deep($oauth_vars, SORT_STRING);
					$oauth_vars_qs = $this->©vars->build_raw_query($oauth_vars);

					// Construct `Authorization` header.
					$header = 'OAuth realm="OAuth"';
					foreach($oauth_vars as $_key => $_value)
						$header .= ','.$_key.'="'.$this->©string->esc_dq($_value).'"';
					unset($_key, $_value);

					return ($signature_array = array( // Return final array w/ these elements.
						'signable_vars' => $signable_vars, 'signable_vars_qs' => $signable_vars_qs,
						'signed_vars'   => $signed_vars, 'signed_vars_qs' => $signed_vars_qs,
						'oauth_vars'    => $oauth_vars, 'oauth_vars_qs' => $oauth_vars_qs,
						'header'        => $header, 'signature' => $signature
					));
				}
		}
	}