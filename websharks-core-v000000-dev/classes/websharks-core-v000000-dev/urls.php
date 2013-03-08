<?php
/**
 * URL Utilities.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120329
 */
namespace websharks_core_v000000_dev
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		/**
		 * URL Utilities.
		 *
		 * @package WebSharks\Core
		 * @since 120329
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class urls extends framework
		{
			/**
			 * @var string Regular expression matches a valid `host` name.
			 */
			public $host_regex_snippet = '[a-zA-Z0-9]+(?:-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:-*[a-zA-Z0-9]+)*)*\.[a-zA-Z]{2,6}';

			/**
			 * @var string Regular expression matches a valid `host:port` combination (port is optional).
			 */
			public $host_port_regex_snippet = '[a-zA-Z0-9]+(?:-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:-*[a-zA-Z0-9]+)*)*\.[a-zA-Z]{2,6}(?:\:[0-9]+)?';

			/**
			 * @var string Regular expression matches a valid `scheme://host:port*` URL (port is optional).
			 */
			public $regex_pattern = '/^https?\:\/\/[a-zA-Z0-9]+(?:-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:-*[a-zA-Z0-9]+)*)*\.[a-zA-Z]{2,6}(?:\:[0-9]+)?.*$/';

			/**
			 * Gets the current URL (via environment variables).
			 *
			 * @param string $scheme Optional. A scheme to force. (i.e. `https`, `http`).
			 *    Use `//` to force a cross-protocol compatible scheme.
			 *
			 * @note If ``$scheme`` is NOT passed in (or is empty), we detect the current scheme, and use that by default.
			 *    For instance, if this ``is_ssl()``, an SSL scheme will be used; else `http`.
			 *
			 * @return string The current URL, else an exception is thrown on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If unable to determine the current URL.
			 */
			public function current($scheme = '')
				{
					$this->check_arg_types('string', func_get_args());

					if(!isset($this->static['current']))
						$this->static['current'] = $this->current_scheme().'://'.$this->current_host().$this->current_uri();

					return ($scheme) ? $this->set_scheme($this->static['current'], $scheme) : $this->static['current'];
				}

			/**
			 * Gets the current host name (via environment variables).
			 *
			 * @return string The current host name, else an exception is thrown on failure.
			 *
			 * @throws exception If unable to determine the current host name.
			 */
			public function current_host()
				{
					if(!isset($this->static['current_host']))
						{
							$this->static['current_host'] = '';

							if(is_string($host = $this->©vars->_SERVER('HTTP_HOST')) && !empty($host))
								$this->static['current_host'] = $host;

							else throw $this->©exception(
								__METHOD__.'#missing_env_vars', array('_SERVER' => $this->©vars->_SERVER()),
								$this->i18n('Unable to detect current host name. Missing required `$_SERVER` vars.')
							);
						}
					return $this->static['current_host'];
				}

			/**
			 * Gets the current URI (via environment variables).
			 *
			 * @return string The current URI, else an exception is thrown on failure.
			 *
			 * @throws exception If unable to determine the current URI.
			 */
			public function current_uri()
				{
					if(!isset($this->static['current_uri']))
						{
							$this->static['current_uri'] = '';

							if(is_string($uri = $this->©vars->_SERVER('REQUEST_URI')))
								{
									if(is_string($uri = $this->parse_uri($uri)))
										$this->static['current_uri'] = $uri;

									else throw $this->©exception(
										__METHOD__.'#invalid_env_vars', array('_SERVER' => $this->©vars->_SERVER()),
										$this->i18n('Unable to detect current URI/location. Invalid `$_SERVER` vars.')
									);
								}
							else throw $this->©exception(
								__METHOD__.'#missing_env_vars', array('_SERVER' => $this->©vars->_SERVER()),
								$this->i18n('Unable to detect current URI/location. Missing required `$_SERVER` vars.')
							);
						}
					return $this->static['current_uri'];
				}

			/**
			 * Gets the current scheme (via environment variables).
			 *
			 * @return string The current scheme, else an exception is thrown on failure.
			 *
			 * @throws exception If unable to determine the current scheme.
			 */
			public function current_scheme()
				{
					if(!isset($this->static['current_scheme']))
						$this->static['current_scheme'] = (is_ssl()) ? 'https' : 'http';
					return $this->static['current_scheme'];
				}

			/**
			 * Parse a URL into an array of components.
			 *
			 * @param string  $url_uri A full URL, or a partial URI.
			 *
			 * @param integer $component Same as PHP's ``parse_url()`` component. Defaults to `-1`.
			 *
			 * @param boolean $n_scheme Defaults to FALSE. If TRUE, forces a normalized scheme at all times.
			 *
			 * @param boolean $n_path Defaults to TRUE. Forces a normalized path if at all possible.
			 *
			 * @return array|string|integer|null If a component is requested, returns a string component (or an integer in the case of ``PHP_URL_PORT``).
			 *    If a specific component is NOT requested, this returns a full array, of all component values.
			 *    Else, this returns NULL on any type of failure.
			 *
			 * @note Arrays returned by this method, will include a value for each component (a bit different from PHP's ``parse_url()`` function).
			 *    We start with an array of defaults (i.e. all empty strings, and `0` for the port number).
			 *    Components found in the URL, are then merged into these default values.
			 *    The array is also sorted by key (e.g. alphabetized).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('//example.com') === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => '', 'scheme' => '', 'user' => '')
			 * @assert ('//example.com/') === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => '', 'scheme' => '', 'user' => '')
			 * @assert ('//example.com#a') === array('fragment' => 'a', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => '', 'scheme' => '', 'user' => '')
			 * @assert ('//example.com?a') === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => 'a', 'scheme' => '', 'user' => '')
			 * @assert ('//example.com:80?a=a&b=b#c') === array('fragment' => 'c', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 80, 'query' => 'a=a&b=b', 'scheme' => '', 'user' => '')
			 * @assert ('http://example.com/') === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => '', 'scheme' => 'http', 'user' => '')
			 * @assert ('http://example.com') === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => '', 'scheme' => 'http', 'user' => '')
			 * @assert ('https://example.com#a') === array('fragment' => 'a', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => '', 'scheme' => 'https', 'user' => '')
			 * @assert ('https://example.com?a') === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => 'a', 'scheme' => 'https', 'user' => '')
			 * @assert ('https://example.com?a=a&b=b#c') === array('fragment' => 'c', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => 'a=a&b=b', 'scheme' => 'https', 'user' => '')
			 * @assert ('ftp://example.com/a/b/c?a=a&b=b#c') === array('fragment' => 'c', 'host' => 'example.com', 'pass' => '', 'path' => '/a/b/c', 'port' => 0, 'query' => 'a=a&b=b', 'scheme' => 'ftp', 'user' => '')
			 * @assert ('//example.com', -1, FALSE, FALSE) === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '', 'port' => 0, 'query' => '', 'scheme' => '', 'user' => '')
			 * @assert ('http://example.com', -1, FALSE, FALSE) === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '', 'port' => 0, 'query' => '', 'scheme' => 'http', 'user' => '')
			 * @assert ('//example.com:80') === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 80, 'query' => '', 'scheme' => '', 'user' => '')
			 * @assert ('//example.com:80', -1, TRUE) === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 80, 'query' => '', 'scheme' => 'http', 'user' => '')
			 * @assert ('//example.com:80', -1, TRUE, FALSE) === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '', 'port' => 80, 'query' => '', 'scheme' => 'http', 'user' => '')
			 * @assert ('//example.com:80', -1, FALSE, FALSE) === array('fragment' => '', 'host' => 'example.com', 'pass' => '', 'path' => '', 'port' => 80, 'query' => '', 'scheme' => '', 'user' => '')
			 * @assert ('//example.com:80#a', -1, FALSE, FALSE) === array('fragment' => 'a', 'host' => 'example.com', 'pass' => '', 'path' => '', 'port' => 80, 'query' => '', 'scheme' => '', 'user' => '')
			 * @assert ('//example.com:80#a', -1, FALSE, TRUE) === array('fragment' => 'a', 'host' => 'example.com', 'pass' => '', 'path' => '/', 'port' => 80, 'query' => '', 'scheme' => '', 'user' => '')
			 * @assert ('/#a') === array('fragment' => 'a', 'host' => '', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => '', 'scheme' => '', 'user' => '')
			 * @assert ('//#a') === array('fragment' => 'a', 'host' => '', 'pass' => '', 'path' => '/', 'port' => 0, 'query' => '', 'scheme' => '', 'user' => '')
			 */
			public function parse($url_uri, $component = -1, $n_scheme = FALSE, $n_path = TRUE)
				{
					$this->check_arg_types('string', 'integer', 'boolean', 'boolean', func_get_args());

					$x_compatible_scheme = FALSE; // Initialize this to FALSE value.

					// Check if it's a valid cross-compatible scheme when ``$url_uri`` starts with `//`.
					// By default, PHP does NOT parse a leading `//`, as a cross-protocol compatible scheme separator.
					if(strpos($url_uri, '//') === 0 && preg_match('/^\/\/'.$this->host_port_regex_snippet.'(?:\/|\?|#|$)/i', $url_uri))
						{
							$url_uri             = $this->current_scheme().':'.$url_uri; // So URL is parsed properly.
							$x_compatible_scheme = TRUE; // Flag this, so we can remove scheme below.
						}

					// Use PHP's ``parse_url()`` function.
					$parsed = parse_url($url_uri, $component);

					// Use empty string scheme, if we forced cross-protocol compatibility.
					if($x_compatible_scheme)
						{
							if(is_array($parsed))
								$parsed['scheme'] = '';
							else if($component === PHP_URL_SCHEME)
								$parsed = '';
						}

					if($n_scheme) // Normalize scheme?
						{
							if($component === -1 && is_array($parsed))
								{
									if(!$this->©string->is_not_empty($parsed['scheme']))
										$parsed['scheme'] = $this->current_scheme();
								}
							else if($component === PHP_URL_SCHEME && empty($parsed))
								$parsed = $this->current_scheme();
						}

					if($n_path) // Normalize path?
						{
							if($component === -1 && is_array($parsed))
								{
									if(!$this->©string->is($parsed['path']))
										$parsed['path'] = '/';
									$parsed['path'] = $this->n_path($parsed['path']);
								}
							else if($component === PHP_URL_PATH)
								{
									if(!$this->©string->is($parsed))
										$parsed = '/';
									$parsed = $this->n_path($parsed);
								}
						}

					if(in_array(gettype($parsed), array('array', 'string', 'integer'), TRUE))
						{
							if(is_array($parsed)) // An array?
								{
									// Standardize.
									$defaults       = array(
										'fragment' => '',
										'host'     => '',
										'pass'     => '',
										'path'     => '',
										'port'     => 0,
										'query'    => '',
										'scheme'   => '',
										'user'     => ''
									);
									$parsed         = array_merge($defaults, $parsed);
									$parsed['port'] = (integer)$parsed['port'];
									ksort($parsed); // Sort by key.
								}
							return $parsed; // A `string|integer|array`.
						}
					return NULL; // Default return value.
				}

			/**
			 * Un-parses a URL (putting it all back together again).
			 *
			 * @param array   $parsed An array with at least one URL component.
			 *
			 * @param boolean $n_scheme Defaults to FALSE. If TRUE, forces a normalized scheme if at all possible.
			 *
			 * @param boolean $n_path Defaults to TRUE. Forces a normalized path if at all possible.
			 *
			 * @return string A full or partial URL, based on components provided in the ``$parsed`` array.
			 *    It IS possible to receive an empty string, when/if ``$parsed`` does NOT contain any portion of a URL (i.e. it's empty).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (array('host' => 'example.com')) === '//example.com/'
			 * @assert (array('host' => 'example.com')) === '//example.com/'
			 * @assert (array('host' => 'example.com', 'path' => 'a')) === '//example.com/a'
			 * @assert (array('host' => 'example.com', 'path' => 'a'), TRUE) === 'http://example.com/a'
			 * @assert (array('host' => 'example.com', 'path' => '/a'), TRUE) === 'http://example.com/a'
			 * @assert (array('host' => 'example.com', 'path' => '/a/'), TRUE) === 'http://example.com/a/'
			 * @assert (array('scheme' => 'https', 'host' => 'example.com', 'path' => '/a/', 'query' => 'a=a&b=b', 'fragment' => 'c'), TRUE) === 'https://example.com/a/?a=a&b=b#c'
			 * @assert (array('scheme' => 'https', 'user' => 'websharks', 'host' => 'example.com', 'path' => '/a/', 'query' => 'a=a&b=b', 'fragment' => 'c'), TRUE) === 'https://websharks@example.com/a/?a=a&b=b#c'
			 * @assert (array('scheme' => 'http', 'user' => 'websharks', 'pass' => 'wS', 'host' => 'example.com', 'path' => '/a/', 'query' => 'a=a&b=b', 'fragment' => 'c'), TRUE) === 'http://websharks:wS@example.com/a/?a=a&b=b#c'
			 * @assert (array('scheme' => 'http', 'user' => 'websharks', 'pass' => 'wS', 'host' => 'example.com', 'port' => 80, 'path' => '/a/', 'query' => 'a=a&b=b', 'fragment' => 'c'), TRUE) === 'http://websharks:wS@example.com:80/a/?a=a&b=b#c'
			 * @assert (array('scheme' => '', 'user' => 'websharks', 'pass' => 'wS', 'host' => 'example.com', 'port' => 80, 'path' => '/a/', 'query' => 'a=a&b=b', 'fragment' => 'c')) === '//websharks:wS@example.com:80/a/?a=a&b=b#c'
			 * @assert (array('host' => 'example.com'), TRUE) === 'http://example.com/'
			 */
			public function un_parse($parsed, $n_scheme = FALSE, $n_path = TRUE)
				{
					$this->check_arg_types('array', 'boolean', 'boolean', func_get_args());

					$url = ''; // Initialize string value.

					// We do lots of type checks here, because this function *could* be passed an array.
					// that did NOT actually originate from ``parse_url()``; making this more compatible with a wide variety of uses.

					// Normalize scheme?
					if($n_scheme && !$this->©string->is_not_empty($parsed['scheme']))
						$parsed['scheme'] = $this->current_scheme();

					// Handle schemes.
					if($this->©string->is_not_empty($parsed['scheme']))
						$url .= $parsed['scheme'].'://';
					else if($this->©string->is_not_empty($parsed['host']))
						$url .= '//'; // Cross-protocol compatible.

					// Handle `user@`, or `user:password@`.
					if($this->©string->is_not_empty($parsed['user']))
						{
							$url .= $parsed['user'];
							if($this->©string->is_not_empty($parsed['pass']))
								$url .= ':'.$parsed['pass'];
							$url .= '@';
						}

					// Handle `host`.
					if($this->©string->is_not_empty($parsed['host']))
						$url .= $parsed['host'];

					// Handle `port` (accepts `integer|string` here).
					// Do NOT to include a `port` if it's empty (perhaps `0`).
					if($this->©integer->is_not_empty($parsed['port']))
						$url .= ':'.(string)$parsed['port'];
					else if($this->©string->is_not_empty($parsed['port']) && is_numeric($parsed['port']))
						$url .= ':'.$parsed['port']; // We also accept string port numbers.

					// Handle `path`.
					if($n_path) // Normalize path?
						{
							if(!$this->©string->is($parsed['path']))
								$parsed['path'] = '/';
							$parsed['path'] = $this->n_path($parsed['path']);
						}
					if($this->©string->is($parsed['path']))
						$url .= $parsed['path'];

					// Handle `query`.
					if($this->©string->is_not_empty($parsed['query']))
						$url .= '?'.$parsed['query'];

					// Handle `fragment`.
					if($this->©string->is_not_empty($parsed['fragment']))
						$url .= '#'.$parsed['fragment'];

					return $url; // Possible empty string.
				}

			/**
			 * Gets a URI from a URL (i.e. a URL path).
			 *
			 * @param string  $url_uri A full URL, or a partial URI.
			 *
			 * @param boolean $n_path Defaults to TRUE. Forces a normalized path if at all possible.
			 *
			 * @return string|null A URI (i.e. a URL path), else NULL on any type of failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('https://example.com') === '/'
			 * @assert ('http://example.com/') === '/'
			 * @assert ('http://example.com/file.php') === '/file.php'
			 * @assert ('http://example.com/file.php?a=a&b=b') === '/file.php?a=a&b=b'
			 * @assert ('http://example.com//file.php?a=a&b=b#c,c;c') === '/file.php?a=a&b=b'
			 * @assert ('http://example.com//a/b/c/file.php') === '/a/b/c/file.php'
			 * @assert ('/a/b/c/file.php') === '/a/b/c/file.php'
			 * @assert ('a/b/c/file.php') === '/a/b/c/file.php'
			 * @assert ('//a/b/c/file.php?a=a&b=b') === '/a/b/c/file.php?a=a&b=b'
			 * @assert ('a/b/c/file.php?a=a&b=b') === '/a/b/c/file.php?a=a&b=b'
			 * @assert ('?a=a&b=b') === '/?a=a&b=b'
			 * @assert ('a=a&b=b') === '/a=a&b=b'
			 */
			public function parse_uri($url_uri, $n_path = TRUE)
				{
					$this->check_arg_types('string', 'boolean', func_get_args());

					if(is_array($parsed = $this->parse($url_uri, -1, FALSE, $n_path)))
						{
							if($parsed['query'])
								return $parsed['path'].'?'.$parsed['query'];
							else return $parsed['path'];
						}
					return NULL; // Default return value.
				}

			/**
			 * Resolves a relative URL into a full URL from a base.
			 *
			 * @param string  $relative A relative URL path.
			 *
			 * @param string  $base A base URL. Defaults to current location.
			 *
			 * @param boolean $n_scheme Defaults to FALSE. If TRUE, forces a normalized scheme if at all possible.
			 *
			 * @param boolean $n_path Defaults to TRUE. Forces a normalized path if at all possible.
			 *
			 * @return string A full URL, else an exception will be thrown.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If there is no ``$base``, and we're also unable to detect the current location.
			 * @throws exception If it's NOT possible to parse ``$base`` as a valid URL.
			 *
			 * @assert ('file.php', 'http://example.com/') === 'http://example.com/file.php'
			 * @assert ('../file.php', 'http://example.com/a/b') === 'http://example.com/file.php'
			 * @assert ('/file.php', 'http://example.com/a/b/') === 'http://example.com/file.php'
			 * @assert ('./file.php', 'http://example.com') === 'http://example.com/file.php'
			 * @assert ('./file.php', 'http://example.com/') === 'http://example.com/file.php'
			 * @assert ('file.php', '//example.com/') === '//example.com/file.php'
			 * @assert ('/file.php', '//example.com/') === '//example.com/file.php'
			 * @assert ('/file.php', '//example.com/', true) === 'http://example.com/file.php'
			 * @assert ('/file.php', '//example.com//', true) === 'http://example.com/file.php'
			 * @assert ('../../../../../././/./file.php', 'http://example.com/') === 'http://example.com/file.php'
			 * @assert ('././././././././../../../file.php', 'http://example.com/a/') === 'http://example.com/file.php'
			 * @assert ('file.php', 'https://example.com/') === 'https://example.com/file.php'
			 */
			public function resolve_relative($relative, $base = '', $n_scheme = FALSE, $n_path = TRUE)
				{
					$this->check_arg_types('string', 'string', 'boolean', 'boolean', func_get_args());

					if(!$base) // There is no base URL? Argument ``$base`` is optional here.
						$base = $this->current(); // Auto-detect current URL/location.

					// Is the ``$base`` URL invalid (e.g. we're unable to parse)?
					if(!is_array($_p_base = $this->parse($base, -1, $n_scheme, $n_path)) || empty($_p_base['host']))
						{
							throw $this->©exception(
								__METHOD__.'#invalid_base', compact('base'),
								$this->i18n('Argument $base is not a valid URL (unable to parse).').
								sprintf($this->i18n(' Got: `%1$s`.'), $base)
							);
						}

					// Has ``$relative`` already been resolved?
					if(strpos($relative, '//') !== FALSE && is_array($_p_relative = $this->parse($relative)) && !empty($_p_relative['host']))
						{
							if($n_scheme) // Normalizing scheme? Here we can try to use the ``$base`` scheme.
								{
									if(empty($_p_relative['scheme']) && !empty($_p_base['scheme']))
										$_p_relative['scheme'] = $_p_base['scheme'];
								}
							// Full URL return value.
							return $this->un_parse($_p_relative, $n_scheme, $n_path);
						}
					unset($_p_relative); // Just a little housekeeping here.

					// Else resolve...

					// Start from ``$_p_base``.
					$resolution = $_p_base; // Copy of ``$p_base``.
					unset($_p_base); // Just a little housekeeping here.

					// Is ``$relative`` empty? ... Or, simply a query/fragment?
					if(!strlen($relative) || $relative[0] === '?' || $relative[0] === '#')
						{
							if(strlen($relative)) // Possible reductions.
								{
									if($relative[0] === '?')
										unset($resolution['query']);

									else if($relative[0] === '#')
										unset($resolution['fragment']);
								}
							// Full URL return value.
							return $this->un_parse($resolution, $n_scheme, $n_path).$relative;
						}

					// Reduce resolution path to a trailing `/` directory location.
					$resolution['path'] = preg_replace('/\/[^\/]*$/', '', $resolution['path']).'/';

					// Reduce resolution path to nothing, if ``$relative`` is an absolute path.
					if(strpos($relative, '/') === 0) // ``$relative`` is actually an absolute path?
						$resolution['path'] = ''; // No base resolution path in this case.

					// Replace `/./` and `/foo/../` with `/` (e.g. resolving relatives).
					for($_i = 1, $_absolute = $resolution['path'].$relative; $_i > 0;)
						$_absolute = preg_replace(array('/\/\.\//', '/\/(?!\.\.)[^\/]+\/\.\.\//'), '/', $_absolute, -1, $_i);
					unset($_i); // Just a little housekeeping.

					// We can ditch any unresolvable `../` patterns now.
					$resolution['path'] = $_absolute = str_replace('../', '', $_absolute);

					unset($_absolute); // Just a little housekeeping.

					// Full URL return value.
					return $this->un_parse($resolution, $n_scheme, $n_path);
				}

			/**
			 * URL leading to a WordPress® `/directory-or-file`.
			 *
			 * @param string  $dir_or_file Absolute server path to a WordPress® `/directory-or-file`.
			 *    Note that relative paths are NOT possible here (MUST be absolute).
			 *
			 * @return string URL leading to a WordPress® `/directory-or-file` (no trailing slash).
			 *    Else an empty string on any type of failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert (__FILE__) === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/classes/websharks-core-v000000-dev/urlsTest.php')
			 * @assert (dirname(__FILE__)) === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/classes/websharks-core-v000000-dev')
			 * @assert (dirname(__FILE__).'/') === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/classes/websharks-core-v000000-dev')
			 * @assert (ABSPATH.'wp-content/themes/twentyeleven') === site_url('/wp-content/themes/twentyeleven')
			 * @assert (ABSPATH.'wp-content/plugins') === site_url('/wp-content/plugins')
			 * @assert (ABSPATH.'wp-load.php') === site_url('/wp-load.php')
			 */
			public function to_wp_abs_dir_or_file($dir_or_file)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					// Standardize and get real ``$file``, ``$dir`` locations.

					if(is_file($dir_or_file) || preg_match('/\.(:?html|php|css|js)$/', $dir_or_file))
						{
							$file = '/'.basename($dir_or_file);
							$dir  = $this->©dirs->n_seps(dirname($dir_or_file));

							if(($dir_realpath = realpath($dir)))
								{
									$dir_realpath = $this->©dirs->n_seps($dir_realpath);
									if(($possible_real_file = realpath($dir.$file)))
										$possible_real_file = '/'.basename($possible_real_file);
									else $possible_real_file = $file;
								}
							else $dir_realpath = $possible_real_file = '';
						}
					else // Else, there is NO file (e.g. it's a directory path).
						{
							$file = $possible_real_file = '';
							$dir  = $this->©dirs->n_seps($dir_or_file);

							if(($dir_realpath = realpath($dir)))
								$dir_realpath = $this->©dirs->n_seps($dir_realpath);
							else $dir_realpath = '';
						}

					// Check WordPress® absolute/root directory.

					if(stripos($dir.'/', ($wp_dir = $this->©dirs->n_seps(ABSPATH)).'/') === 0)
						return site_url($this->©string->ireplace_once($wp_dir, '', $dir)).$file;

					else if($dir_realpath && stripos($dir_realpath.'/', $wp_dir.'/') === 0)
						return site_url($this->©string->ireplace_once($wp_dir, '', $dir_realpath)).
						       $possible_real_file; // But may default to ``$file``.

					// Check WordPress® content directory.

					else if(stripos($dir.'/', ($wp_content_dir = $this->©dirs->n_seps(WP_CONTENT_DIR)).'/') === 0)
						return content_url($this->©string->ireplace_once($wp_content_dir, '', $dir)).$file;

					else if($dir_realpath && stripos($dir_realpath.'/', $wp_content_dir.'/') === 0)
						return content_url($this->©string->ireplace_once($wp_content_dir, '', $dir_realpath)).
						       $possible_real_file; // But may default to ``$file``.

					// Check WordPress® plugins directory.

					else if(stripos($dir.'/', ($wp_plugins_dir = $this->©dirs->n_seps(WP_PLUGIN_DIR)).'/') === 0)
						return plugins_url($this->©string->ireplace_once($wp_plugins_dir, '', $dir)).$file;

					else if($dir_realpath && stripos($dir_realpath.'/', $wp_plugins_dir.'/') === 0)
						return plugins_url($this->©string->ireplace_once($wp_plugins_dir, '', $dir_realpath)).
						       $possible_real_file; // But may default to ``$file``.

					// Check WordPress® active style directory.

					else if(stripos($dir.'/', ($wp_active_style_dir = $this->©dirs->n_seps(get_stylesheet_directory())).'/') === 0)
						return get_stylesheet_directory_uri().$this->©string->ireplace_once($wp_active_style_dir, '', $dir).$file;

					else if($dir_realpath && stripos($dir_realpath.'/', $wp_active_style_dir.'/') === 0)
						return get_stylesheet_directory_uri().$this->©string->ireplace_once($wp_active_style_dir, '', $dir_realpath).
						       $possible_real_file; // But may default to ``$file``.

					// Check WordPress® active theme directory.

					else if(stripos($dir.'/', ($wp_active_theme_dir = $this->©dirs->n_seps(get_template_directory())).'/') === 0)
						return get_template_directory_uri().$this->©string->ireplace_once($wp_active_theme_dir, '', $dir).$file;

					else if($dir_realpath && stripos($dir_realpath.'/', $wp_active_theme_dir.'/') === 0)
						return get_template_directory_uri().$this->©string->ireplace_once($wp_active_theme_dir, '', $dir_realpath).
						       $possible_real_file; // But may default to ``$file``.

					// Else we MUST fail here.
					return ''; // Default return value.
				}

			/**
			 * URL leading to a WebSharks™ Core `/directory-or-file`.
			 *
			 * @param string  $dir_or_file Absolute server path to a WebSharks™ Core `/directory-or-file`.
			 *    Or, a relative path is also acceptable here, making this method very handy.
			 *
			 * @return string URL leading to a WebSharks™ Core `/directory-or-file` (no trailing slash).
			 *    Else an empty string on any type of failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('/client-side/scripts/core.js') === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/client-side/scripts/core.js')
			 * @assert (__FILE__) === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/classes/websharks-core-v000000-dev/urlsTest.php')
			 * @assert (dirname(__FILE__)) === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/classes/websharks-core-v000000-dev')
			 * @assert (dirname(__FILE__).'/') === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/classes/websharks-core-v000000-dev')
			 */
			public function to_core_dir_or_file($dir_or_file = '')
				{
					$this->check_arg_types('string', func_get_args());

					$dir_or_file = $this->©dirs->n_seps($dir_or_file);

					if($dir_or_file && ($realpath = @realpath($dir_or_file)))
						$realpath = $this->©dirs->n_seps($dir_or_file);
					else $realpath = '';

					if(strpos($dir_or_file.'/', dirname(dirname(dirname(__FILE__))).'/') !== 0
					   && (!$realpath || strpos($realpath.'/', dirname(dirname(dirname(__FILE__))).'/') !== 0)
					) $dir_or_file = dirname(dirname(dirname(__FILE__))).'/'.ltrim($dir_or_file, '/');

					return $this->to_wp_abs_dir_or_file($dir_or_file);
				}

			/**
			 * URL leading to a plugin `/directory-or-file`.
			 *
			 * @param string  $dir_or_file Absolute server path to a plugin `/directory-or-file`.
			 *    Or, a relative path is also acceptable here, making this method very handy.
			 *
			 * @return string URL leading to a plugin `/directory-or-file` (no trailing slash).
			 *    Else an empty string on any type of failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('/client-side/scripts/core.js') === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/client-side/scripts/core.js')
			 * @assert (__FILE__) === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/classes/websharks-core-v000000-dev/urlsTest.php')
			 * @assert (dirname(__FILE__)) === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/classes/websharks-core-v000000-dev')
			 * @assert (dirname(__FILE__).'/') === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/classes/websharks-core-v000000-dev')
			 */
			public function to_plugin_dir_or_file($dir_or_file = '')
				{
					$this->check_arg_types('string', func_get_args());

					$dir_or_file = $this->©dirs->n_seps($dir_or_file);

					if($dir_or_file && ($realpath = @realpath($dir_or_file)))
						$realpath = $this->©dirs->n_seps($dir_or_file);
					else $realpath = '';

					if(strpos($dir_or_file.'/', $this->___instance_config->plugin_dir.'/') !== 0
					   && (!$realpath || strpos($realpath.'/', $this->___instance_config->plugin_dir.'/') !== 0)
					) $dir_or_file = $this->___instance_config->plugin_dir.'/'.ltrim($dir_or_file, '/');

					return $this->to_wp_abs_dir_or_file($dir_or_file);
				}

			/**
			 * URL leading to a plugin data `/directory-or-file`.
			 *
			 * @param string  $dir_or_file Absolute server path to a plugin data `/directory-or-file`.
			 *    Or, a relative path is also acceptable here, making this method very handy.
			 *
			 * @return string URL leading to a plugin data `/directory-or-file` (no trailing slash).
			 *    Else an empty string on any type of failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('/example.txt') === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/example.txt')
			 * @assert ($this->object->___instance_config->plugin_data_dir) === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev')
			 */
			public function to_plugin_data_dir_or_file($dir_or_file = '')
				{
					$this->check_arg_types('string', func_get_args());

					$dir_or_file = $this->©dirs->n_seps($dir_or_file);

					if($dir_or_file && ($realpath = @realpath($dir_or_file)))
						$realpath = $this->©dirs->n_seps($dir_or_file);
					else $realpath = '';

					if(strpos($dir_or_file.'/', $this->___instance_config->plugin_data_dir.'/') !== 0
					   && (!$realpath || strpos($realpath.'/', $this->___instance_config->plugin_data_dir.'/') !== 0)
					) $dir_or_file = $this->___instance_config->plugin_data_dir.'/'.ltrim($dir_or_file, '/');

					return $this->to_wp_abs_dir_or_file($dir_or_file);
				}

			/**
			 * URL leading to a plugin pro `/directory-or-file`.
			 *
			 * @param string  $dir_or_file Absolute server path to a plugin pro `/directory-or-file`.
			 *    Or, a relative path is also acceptable here, making this method very handy.
			 *
			 * @return string URL leading to a plugin pro `/directory-or-file` (no trailing slash).
			 *    Else an empty string on any type of failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('/example.php') === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev/example.php')
			 * @assert ($this->object->___instance_config->plugin_pro_dir) === site_url('/wp-content/plugins/s2member-x/websharks-core-v000000-dev')
			 */
			public function to_plugin_pro_dir_or_file($dir_or_file = '')
				{
					$this->check_arg_types('string', func_get_args());

					$dir_or_file = $this->©dirs->n_seps($dir_or_file);

					if($dir_or_file && ($realpath = @realpath($dir_or_file)))
						$realpath = $this->©dirs->n_seps($dir_or_file);
					else $realpath = '';

					if(strpos($dir_or_file.'/', $this->___instance_config->plugin_pro_dir.'/') !== 0
					   && (!$realpath || strpos($realpath.'/', $this->___instance_config->plugin_pro_dir.'/') !== 0)
					) $dir_or_file = $this->___instance_config->plugin_pro_dir.'/'.ltrim($dir_or_file, '/');

					return $this->to_wp_abs_dir_or_file($dir_or_file);
				}

			/**
			 * Gets automatic update URL (w/ custom ZIP file source).
			 *
			 * @param string $username Optional. Plugin site username. Defaults to an empty string.
			 *    This is ONLY required, if the underlying plugin site requires it.
			 *
			 * @param string $password Optional. Plugin site password. Defaults to an empty string.
			 *    This is ONLY required, if the underlying plugin site requires it.
			 *
			 * @return string|errors URL leading to an automatic update of plugin (powered by WordPress®).
			 *    Else an `errors` object (with at least one error) is returned on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function to_plugin_update_via_wp($username = '', $password = '')
				{
					$this->check_arg_types('string', 'string', func_get_args());

					// Connects to the plugin site (POST array includes `username`, `password`, `version`).
					// The plugin site should return a serialized array, with a `zip` element (full URL to a ZIP file).
					// If an error occurs at the plugin site, the plugin site can return an `error` element, w/ an error message.

					$plugin_site_credentials = $this->©plugin->get_site_credentials($username, $password, TRUE);

					$plugin_site_post_vars = array(
						$this->___instance_config->plugin_var_ns.'_update_sync' => array(
							'username' => $plugin_site_credentials['username'],
							'password' => $plugin_site_credentials['password'],
							'version'  => $this->___instance_config->plugin_version
						)
					);
					$plugin_site_response  = $this->remote($this->to_plugin_site('/'), $plugin_site_post_vars);
					if(!is_array($plugin_site_response = maybe_unserialize($plugin_site_response)))
						$plugin_site_response = array();

					// Did the plugin site return a ZIP file URL (i.e. a URL that allows access)?

					if($this->©string->is_not_empty($plugin_site_response['zip']))
						{
							$update_args                                                         = array(
								'action'   => 'upgrade-plugin',
								'plugin'   => $this->___instance_config->plugin_dir_file_basename,
								'_wpnonce' => wp_create_nonce('upgrade-plugin_'.$this->___instance_config->plugin_dir_file_basename)
							);
							$update_args[$this->___instance_config->plugin_var_ns.'_update_zip'] = $plugin_site_response['zip'];

							return add_query_arg(urlencode_deep($update_args), admin_url('/update.php'));
						}

					// Did the update server return an error message?

					if($this->©string->is_not_empty($plugin_site_response['error']))
						return $this->©error(
							__METHOD__.'#plugin_site_error', get_defined_vars(), $plugin_site_response['error']
						);

					// Default return value (assume connectivity issue in this default case).

					return $this->©error(
						__METHOD__.'#plugin_site_connectivity_issue', get_defined_vars(),
						$this->i18n('Unable to communicate with plugin site (i.e. could NOT obtain ZIP package).').
						$this->i18n(' Possible connectivity issue. Please try again in 15 minutes.')
					);
				}

			/**
			 * Gets automatic update URL (w/ custom ZIP file source).
			 *
			 * @param string $username Optional. Plugin site username. Defaults to an empty string.
			 *    This is ONLY required, if the underlying plugin site requires it.
			 *
			 * @param string $password Optional. Plugin site password. Defaults to an empty string.
			 *    This is ONLY required, if the underlying plugin site requires it.
			 *
			 * @return string|errors URL leading to an automatic update of pro add-on (powered by WordPress®).
			 *    Else an `errors` object (with at least one error) is returned on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function to_plugin_pro_update_via_wp($username = '', $password = '')
				{
					$this->check_arg_types('string', 'string', func_get_args());

					// Connects to the plugin site (POST array includes `username`, `password`, `version`).
					// The plugin site should return a serialized array, with a `zip` element (full URL to a ZIP file).
					// If an error occurs at the plugin site, the plugin site can return an `error` element, w/ an error message.

					$plugin_site_credentials = $this->©plugin->get_site_credentials($username, $password, TRUE);

					$plugin_site_post_vars = array(
						$this->___instance_config->plugin_var_ns.'_pro_update_sync' => array(
							'username' => $plugin_site_credentials['username'],
							'password' => $plugin_site_credentials['password'],
							'version'  => $this->___instance_config->plugin_version
						)
					);
					$plugin_site_response  = $this->remote($this->to_plugin_site('/'), $plugin_site_post_vars);
					if(!is_array($plugin_site_response = maybe_unserialize($plugin_site_response)))
						$plugin_site_response = array();

					// Did the plugin site return a ZIP file URL (i.e. a URL that allows access)?

					if($this->©string->is_not_empty($plugin_site_response['zip']))
						{
							$update_args                                                             = array(
								'action'   => 'upgrade-plugin',
								'plugin'   => $this->___instance_config->plugin_pro_dir_file_basename,
								'_wpnonce' => wp_create_nonce('upgrade-plugin_'.$this->___instance_config->plugin_pro_dir_file_basename)
							);
							$update_args[$this->___instance_config->plugin_var_ns.'_pro_update_zip'] = $plugin_site_response['zip'];

							return add_query_arg(urlencode_deep($update_args), admin_url('/update.php'));
						}

					// Did the update server return an error message?

					if($this->©string->is_not_empty($plugin_site_response['error']))
						return $this->©error(
							__METHOD__.'#plugin_site_error', get_defined_vars(), $plugin_site_response['error']
						);

					// Default return value (assume connectivity issue in this default case).

					return $this->©error(
						__METHOD__.'#plugin_site_connectivity_issue', get_defined_vars(),
						$this->i18n('Unable to communicate with plugin site (i.e. could NOT obtain ZIP package).').
						$this->i18n(' Possible connectivity issue. Please try again in 15 minutes.')
					);
				}

			/**
			 * Gets a URL leading to the plugin site.
			 *
			 * @param string $path Optional. Defaults to an empty string.
			 *    Set this to whatever path is needed (examples: `/index.php`, `/faqs/`).
			 *
			 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
			 *    Note: ``$this->___instance_config->plugin_site`` will always have an `http` scheme by default.
			 *    This is a standard that is followed strictly by the WebSharks™ Core framework.
			 *
			 * @return string Full URL leading to the plugin site.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function to_plugin_site($path = '', $scheme = '')
				{
					$this->check_arg_types('string', 'string', func_get_args());

					$url = rtrim($this->___instance_config->plugin_site, '/');

					if($path) // Also include a path location?
						$url .= $this->n_path($path);

					return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
				}

			/**
			 * Processes remote connections.
			 *
			 * @param string            $url A full URL to a remote location.
			 *
			 * @param null|string|array $post_body Optional. Defaults to a NULL value (and defaults to a connection method type of `GET`).
			 *    If a string|array is passed in (empty or otherwise), the connection `method` is set to `POST` (if NOT already set);
			 *    and ``$post_body`` is POSTed to the remote location by this routine.
			 *
			 * @param array             $args An optional array of argument specifications (same as the `WP_Http` class).
			 *    In addition, we accept some other array elements here: `return_xml_object`, `xml_object_flags`, `return_array`, and `return_errors`.
			 *    For further details, please check the docs below regarding return values.
			 *
			 * @param integer           $timeout Optional. Defaults to a value of `5` seconds.
			 *    For important API communications, a value of `20` (or higher), is suggested for stability.
			 *    In the cURL transport layer, this controls both the connection and stream timeout values.
			 *    This can also be passed through ``$args['timeout']``, which produces more readable code.
			 *
			 * @return string|array|\SimpleXMLElement|object|errors|null This function has MANY possible return values.
			 *    By default, this method returns the string received from the remote request, else an empty string on ANY type of error (even connection errors). Very simple (default behavior).
			 *    If an XML object is requested via ``$args['return_xml_object']`` (and ``$args['return_array']`` is FALSE, which it is by default), this method returns an instance of `SimpleXMLElement`; else NULL on any type of connection error.
			 *    If an array is requested via ``$args['return_array']``, this method returns a full array of connection details (`code`, `message`, `headers`, `body`, `xml [populated only if $args['return_xml_object'] is TRUE]`); else NULL on any type of connection error.
			 *    If errors are requested via ``$args['return_errors']``, this method will always return an `errors` object instance on any type of connection error.
			 *
			 * @note Please note that ``$args['return_array']`` takes precedence over ``$args['return_xml_object']``.
			 *    This way it is possible to get a return array, with an `xml` element containing the XML object.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('http://www.websharks-inc.net/') is-type 'string'
			 * @assertion-via-other-methods This is tested with many other methods.
			 */
			public function remote($url, $post_body = NULL, $args = array(), $timeout = 5)
				{
					$this->check_arg_types('string:!empty', array('null', 'string', 'array'), 'array', 'integer:!empty', func_get_args());

					// Force method to uppercase.
					if(!empty($args['method']) && is_string($args['method']))
						$args['method'] = strtoupper($args['method']);

					if(isset($post_body)) // Have a ``$post_body``? (e.g. POST vars, or other data).
						{
							$args = array_merge( // Original ``$args`` ALWAYS take precedence here.
								array('method' => 'POST', 'body' => $post_body), $args
							);
							if(!isset($args['headers']['Content-Type']))
								$args['headers']['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
						}
					if(!empty($timeout)) // Do we have a ``$timeout`` value?
						$args = array_merge(array('timeout' => $timeout), $args);

					// Set default return value options.
					$return_array      = $this->©boolean->isset_or($args['return_array'], FALSE);
					$return_errors     = $this->©boolean->isset_or($args['return_errors'], FALSE);
					$return_xml_object = $this->©boolean->isset_or($args['return_xml_object'], FALSE);

					// Additional default option values.
					$xml_object_flags  = LIBXML_NOCDATA | LIBXML_NOERROR | LIBXML_NOWARNING;
					$xml_object_flags  = $this->©integer->isset_or($args['xml_object_flags'], $xml_object_flags);
					$args['sslverify'] = $this->©boolean->isset_or($args['sslverify'], FALSE);

					// Developers might like to fine tune things a bit further here.
					$url  = $this->apply_filters('remote__url', $url, get_defined_vars());
					$args = $this->apply_filters('remote__args', $args, get_defined_vars());

					// Now unset these ``$args``, so they don't get passed through WordPress® and cause problems.
					unset($args['return_array'], $args['return_errors'], $args['return_xml_object'], $args['xml_object_flags']);

					// Process with ``wp_remote_request()``.
					$response = wp_remote_request($url, $args);

					// Now let's handle return values provided by this routine.

					if(!is_wp_error($response)) // NO connection errors.
						{
							// XML object?
							if($return_xml_object)
								{
									$xml = simplexml_load_string(
										(string)wp_remote_retrieve_body($response),
										NULL, $xml_object_flags
									);
									// In case the XML string was BAD.
									// Here we force a SimpleXMLElement.
									if(!($xml instanceof \SimpleXMLElement))
										$xml = new \SimpleXMLElement('<xml />');
								}
							else $xml = NULL; // Not populating this.

							// Returning array?
							if($return_array) // Lots of useful info here.
								{
									return array(
										'code'                => (integer)wp_remote_retrieve_response_code($response),
										'message'             => (string)wp_remote_retrieve_response_message($response),
										'xml'                 => (($return_xml_object) ? (object)$xml : NULL),
										'headers'             => (array)wp_remote_retrieve_headers($response),
										'body'                => (string)wp_remote_retrieve_body($response),
										'last_http_debug_log' => $this->last_http_debug_log()
									);
								}

							// Returning XML object?
							else if($return_xml_object)
								return (object)$xml;

							// Else return string (default behavior).
							return (string)wp_remote_retrieve_body($response);
						}
					else // We have a connection error to deal with now.
						{
							// Get last HTTP debug log.
							$last_http_debug_log = $this->last_http_debug_log();

							// Generate errors.
							$errors = $this->©errors(
								__METHOD__, get_defined_vars(), $response->get_error_message()
							);

							// Returning errors?
							if($return_errors)
								return $errors;

							// Should return NULL on connection error?
							else if($return_array || $return_xml_object)
								return NULL;

							return ''; // String (default behavior).
						}
				}

			/**
			 * Catches details sent through the WordPress® ``WP_Http`` class.
			 *
			 * @attaches-to WordPress® `http_api_debug` hook (if ``WP_DEBUG`` mode is enabled).
			 * @hook-priority `1000` (if ``WP_DEBUG`` mode is enabled).
			 *
			 * @param array  $response ``WP_Http`` response array.
			 * @param string $state ``WP_Http`` current state (i.e. `response`).
			 * @param string $class ``WP_Http`` transport class name.
			 * @param array  $args Input args to the ``WP_Http`` class.
			 * @param string $url The ``WP_Http`` connection URL.
			 */
			public function http_api_debug($response = NULL, $state = NULL, $class = NULL, $args = NULL, $url = NULL)
				{
					$this->static['last_http_debug_log'] = array(
						'state'           => $state,
						'transport_class' => $class,
						'args'            => $args,
						'url'             => $url,
						'response'        => $response
					);
				}

			/**
			 * Returns a reference to the last HTTP communication log.
			 *
			 * @return array A reference to the last HTTP communication log.
			 */
			public function &last_http_debug_log()
				{
					$last_http_debug_log = array(); // Initialize.

					if(isset($this->static['last_http_debug_log']))
						$last_http_debug_log = & $this->static['last_http_debug_log'];

					else if(!$this->©env->is_in_wp_debug_mode())
						{
							$this->static['last_http_debug_log'] = array($this->i18n('`WP_DEBUG` mode is NOT currently enabled.'));
							$last_http_debug_log                 = & $this->static['last_http_debug_log'];
						}
					return $last_http_debug_log; // Returns reference.
				}

			/**
			 * Encodes ampersands in a URL with HTML entity `&amp;`.
			 *
			 * @param string $url_uri_query Input URL, URI, or just a query string.
			 *
			 * @return string Input URL after having it's ampersands converted.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $url = 'http://example.com/?a=b&b=b&amp;c=c&d=d&#038;e=e&f=f';
			 *    ($url) === 'http://example.com/?a=b&amp;b=b&amp;c=c&amp;d=d&amp;e=e&amp;f=f'
			 */
			public function e_amps($url_uri_query)
				{
					$this->check_arg_types('string', func_get_args());

					return str_replace('&', '&amp;', $this->n_amps($url_uri_query));
				}

			/**
			 * Converts ampersand entities in a URL to just `&`.
			 *
			 * @param string $url_uri_query Input URL, URI, or just a query string.
			 *
			 * @return string Input URL after having it's ampersands normalized.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert $url = 'http://example.com/?a=b&amp;b=b&#38;c=c&#038;d=d&#x26;e=e&f=f';
			 *    ($url) === 'http://example.com/?a=b&b=b&c=c&d=d&e=e&f=f'
			 */
			public function n_amps($url_uri_query)
				{
					$this->check_arg_types('string', func_get_args());

					$amps = implode('|', array_keys($this->©strings->ampersand_entities));

					return preg_replace('/(?:'.$amps.')/', '&', $url_uri_query);
				}

			/**
			 * Normalizes a URL scheme.
			 *
			 * @param string $scheme An input URL scheme (optional).
			 *
			 * @return string A normalized URL scheme.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('http') === 'http'
			 * @assert ('https') === 'https'
			 * @assert ('ftp') === 'ftp'
			 * @assert () === 'http'
			 * @assert ('') === 'http'
			 */
			public function n_scheme($scheme = '')
				{
					$this->check_arg_types('string', func_get_args());

					if(!$scheme) $scheme = $this->current_scheme();

					return $scheme; // Normal scheme.
				}

			/**
			 * Sets a particular scheme.
			 *
			 * @param string $url A full URL.
			 *
			 * @param string $scheme Optional. The scheme to use (i.e. `https`, `http`).
			 *    Use `//` to use a cross-protocol compatible scheme.
			 *    Defaults to the current scheme.
			 *
			 * @return string The full URL w/ ``$scheme``.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function set_scheme($url, $scheme = '')
				{
					$this->check_arg_types('string', 'string', func_get_args());

					if(!$scheme) $scheme = $this->current_scheme();
					$scheme = ($scheme === '//') ? '//' : $scheme.'://';

					return preg_replace('/^(?:https?\:)?\/\//i', $scheme, $url);
				}

			/**
			 * Normalizes URL paths.
			 *
			 * @param string $path An input URL path (optional).
			 *
			 * @return string A normalized URL path.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('//path/to//') === '/path/to/'
			 * @assert ('path') === '/path'
			 * @assert ('') === '/'
			 * @assert () === '/'
			 */
			public function n_path($path = '')
				{
					$this->check_arg_types('string', func_get_args());

					if(!strlen($path) || strpos($path, '/') !== 0)
						$path = '/'.$path;
					$path = preg_replace('/\/+/', '/', $path);

					return $path; // Normal path.
				}

			/**
			 * Adds a query string name/value pair onto a URL's hash/anchor.
			 *
			 * @param string             $name The name of the variable we're adding.
			 *    This CANNOT be empty.
			 *
			 * @param string             $value The value that we're setting the variable to.
			 *    This can be any scalar value. Converts to a string.
			 *    This can be empty, but always scalar.
			 *
			 * @param string             $url The URL that we're adding this onto.
			 *    This can be empty, but always a string.
			 *
			 * @return string Full URL with appended hash/anchor query string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$name`` is empty.
			 *
			 * @assert ('name', 'value', '') === '#!name=value'
			 * @assert ('name', 'value', '#!name=value') === '#!name=value&name=value'
			 */
			public function add_query_hash($name, $value, $url)
				{
					$this->check_arg_types('string:!empty', 'scalar', 'string', func_get_args());

					$url .= (strpos($url, '#') === FALSE) ? '#!' : '&';
					$url .= urlencode($name).'='.urlencode((string)$value);

					return $url;
				}

			/**
			 * Filters content redirection status.
			 *
			 * @param integer $status A redirection status code.
			 *
			 * @return integer A status redirection code,
			 *    possibly modified to a value of `302`.
			 *
			 * @throws exception If invalid types are passed through arguments lists.
			 *
			 * @see http://en.wikipedia.org/wiki/Web_browser_engine
			 *
			 * @assert (301) === 301
			 */
			public function redirect_browsers_using_302_status($status)
				{
					$this->check_arg_types('integer', func_get_args());

					if($status === 301 && $this->©env->is_browser())
						return 302;

					return $status; // Default value.
				}

			/**
			 * Shortens a long URL.
			 *
			 * @param string  $url A full/long URL to be shortened.
			 *
			 * @param string  $specific_api Optional. A specific URL shortening API to use.
			 *    Defaults to that which is configured in the options.
			 *
			 * @param boolean $try_backups Defaults to TRUE. If a failure occurs with the first API,
			 *    we'll try others until we have success. Also used internally by this routine.
			 *
			 * @return string The shortened URL on success, else the original ``$url`` on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert ('http://www.google.com/') === 'http://goo.gl/fbsS'
			 * @assert ('http://www.websharks-inc.com/', 'tiny_url') === 'http://tinyurl.com/29foqso'
			 * @assert ('http://www.websharks-inc.com/') === 'http://goo.gl/wRAFl'
			 */
			public function shorten($url, $specific_api = '', $try_backups = TRUE)
				{
					$this->check_arg_types('string:!empty', 'string', 'boolean', func_get_args());

					$apis = array('goo_gl', 'tiny_url'); // APIs built-in.

					$default_api     = $this->©options->get('url_shortener.default_api');
					$default_url_api = $this->©options->get('url_shortener.default_url_api');

					if(!$specific_api && ($custom_url = trim($this->apply_filters('shorten', '')))
					   && stripos($custom_url, 'http') === 0
					) return ($shorter_url = $custom_url);

					else if(!$specific_api && $default_url_api
					        && ($default_url_api = str_ireplace(array('%%long_url%%', '%%long_url_md5%%'), array(rawurlencode($url), urlencode(md5($url))), $default_url_api))
					        && ($custom_url = trim($this->remote($default_url_api)))
					        && stripos($custom_url, 'http') === 0
					) return ($shorter_url = $custom_url);

					else if((($specific_api) ? strtolower($specific_api) : $default_api) === 'goo_gl'
					        && is_string($goo_gl_key = ($goo_gl_key = $this->©options->get('url_shortener.api_keys.goo_gl')) ? '?key='.urlencode($goo_gl_key) : '')
					        && is_array($goo_gl = json_decode(trim($this->remote('https://www.googleapis.com/urlshortener/v1/url'.$goo_gl_key, json_encode(array('longUrl' => $url)), array('headers' => array('Content-Type' => 'application/json')))), TRUE))
					        && ($goo_gl_url = $this->©string->is_not_empty_or($goo_gl['id'], ''))
					        && stripos($goo_gl_url, 'http') === 0
					) return ($shorter_url = $goo_gl_url.'#'.$this->current_host());

					else if((($specific_api) ? strtolower($specific_api) : $default_api) === 'tiny_url'
					        && ($tiny_url = trim($this->remote('http://tinyurl.com/api-create.php?url='.rawurlencode($url))))
					        && stripos($tiny_url, 'http') === 0
					) return ($shorter_url = $tiny_url.'#'.$this->current_host());

					else if($try_backups && count($apis) > 1)
						{
							foreach(array_diff($apis, array((($specific_api) ? strtolower($specific_api) : $default_api))) as $backup)
								if(($backup = $this->shorten($url, $backup, FALSE)))
									return ($shorter_url = $backup);
						}
					return $url; // Default return value (the full URL).
				}

			/**
			 * Builds a WordPress® signup URL to: `/wp-signup.php`.
			 *
			 * @return string Full URL to `/wp-signup.php`.
			 *
			 * @assert () === home_url('/wp-signup.php')
			 */
			public function wp_signup()
				{
					return apply_filters('wp_signup_location', home_url('/wp-signup.php'));
				}

			/**
			 * Builds a WordPress® registration URL to: `/wp-login.php?action=register`.
			 *
			 * @return string Full URL to `/wp-login.php?action=register`.
			 *
			 * @assert () === home_url('/wp-login.php?action=register')
			 */
			public function wp_register()
				{
					return apply_filters('wp_register_location', add_query_arg(urlencode_deep(array('action' => 'register')), wp_login_url()));
				}

			/**
			 * Builds a BuddyPress registration URL to: `/register`.
			 *
			 * @return string Full URL to `/register`, if BuddyPress is installed; else an empty string.
			 *
			 * @assert () === ''
			 */
			public function bp_register()
				{
					if($this->©env->is_bp_installed())
						return user_trailingslashit(home_url('/'.bp_get_signup_slug().'/'));

					return ''; // Default return value.
				}

			/**
			 * Builds a BuddyPress activation URL to: `/activate`.
			 *
			 * @return string Full URL to `/activate`, if BuddyPress is installed; else an empty string.
			 *
			 * @assert () === ''
			 */
			public function bp_activate()
				{
					if($this->©env->is_bp_installed())
						return user_trailingslashit(home_url('/'.bp_get_activate_slug().'/'));

					return ''; // Default return value.
				}

			/**
			 * Removes all signatures from a full URL, a partial URI, or just a query string.
			 *
			 * @param string $url_uri_query A full URL, a partial URI, or just the query string; to remove signatures from.
			 *
			 * @param string $sig_var Optional signature name. Defaults to `_sig`. The name of the signature variable.
			 *
			 * @return string A full URL, a partial URI, or just the query string; without any signatures.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$sig_var`` is empty.
			 *
			 * @assert ('http://www.example.com/?this=that&_sig=hello') === 'http://www.example.com/?this=that'
			 * @assert ('/?this=that&_sig=hello') === '/?this=that'
			 * @assert ('this=that&_sig=hello') === 'this=that'
			 * @assert ('_sig=hello') === ''
			 * @assert ('') === ''
			 */
			public function remove_sigs($url_uri_query, $sig_var = '_sig')
				{
					$this->check_arg_types('string', 'string:!empty', func_get_args());

					$url_uri_query = $this->©string->trim($url_uri_query, '', '?&=');
					$sigs          = array_unique(array($sig_var, '_sig'));

					return trim(remove_query_arg($sigs, $url_uri_query), '?&=');
				}

			/**
			 * Adds a signature onto a full URL, a partial URI, or just a query string.
			 *
			 * @param string $url_uri_query A full URL, a partial URI, or just a query string; to append the signature onto.
			 *
			 * @param string $sig_var Optional signature name. Defaults to `_sig`. The name of the signature variable.
			 *
			 * @return string A full URL, a partial URI, or just a query string; with a signature.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$sig_var`` is empty.
			 *
			 * @assert ('http://www.example.com/?this=that') matches '/^http\:\/\/www\.example\.com\/\?this\=that&_sig\=.+$/'
			 * @assert ('http://www.example.com/?this=that', '_signature') matches '/^http\:\/\/www\.example\.com\/\?this\=that&_signature\=.+$/'
			 * @assert ('/?this=that') matches '/^\/\?this\=that&_sig\=.+$/'
			 * @assert ('this=that') matches '/^this\=that&_sig\=.+$/'
			 * @assert ('') === ''
			 */
			public function add_sig($url_uri_query, $sig_var = '_sig')
				{
					$this->check_arg_types('string', 'string:!empty', func_get_args());

					$url_uri_query = $query = $this->remove_sigs($this->©string->trim($url_uri_query, '', '?&='), $sig_var);

					if($url_uri_query && preg_match('/^(?:[a-z]+\:\/\/|\/)/i', $url_uri_query))
						{
							if(!is_string($query = $this->parse($url_uri_query, PHP_URL_QUERY)))
								$query = ''; // Defaults to an empty query string.
							else $query = trim($query, '?&=');
						}
					if($url_uri_query) // We DO process empty query strings.
						{
							$vars = $this->©vars->parse_query($query);
							$vars = $this->©array->remove_0b_strings_deep($this->©strings->trim_deep($vars));
							$vars = serialize($this->©array->ksort_deep($vars));

							$sig           = ($time = time()).'-'.$this->©encryption->hmac_sha1_sign($vars.$time);
							$url_uri_query = add_query_arg(urlencode_deep(array($sig_var => $sig)), $url_uri_query);
						}
					return $url_uri_query;
				}

			/**
			 * Verifies a signature; in a full URL, a partial URI, or in just a query string.
			 *
			 * @param string  $url_uri_query A full URL, a partial URI, or just a query string.
			 *    Must have a signature to validate.
			 *
			 * @param boolean $check_time Optional. Defaults to FALSE.
			 *    If TRUE, also check if the signature has expired, based on ``$exp_secs``.
			 *
			 * @param integer $exp_secs Optional. Defaults to `10`.
			 *    If ``$check_time`` is TRUE, check if the signature has expired, based on ``$exp_secs``.
			 *
			 * @param string  $sig_var Optional signature name. Defaults to `_sig`. The name of the signature variable.
			 *
			 * @return boolean TRUE if the signature is OK, else FALSE.
			 *
			 * @assert $signed_url = $this->object->add_sig('http://www.example.com/?this=that');
			 *    ($signed_url) === TRUE
			 *
			 * @assert $signed_url = $this->object->add_sig('http://www.example.com/?this=that');
			 *    ($signed_url.'&that=this') === FALSE
			 *
			 * @assert $signed_url = $this->object->add_sig('http://www.example.com/?this=that', '_signature');
			 *    ($signed_url, FALSE, 10, '_signature') === TRUE
			 *
			 * @assert $signed_url = $this->object->add_sig('http://www.example.com/?this=that', '_signature');
			 *    ($signed_url, TRUE, 10, '_signature') === TRUE
			 *
			 * @assert $signed_url = $this->object->add_sig('/?this=that');
			 *    ($signed_url) === TRUE
			 *
			 * @assert $signed_url = $this->object->add_sig('this=that');
			 *    ($signed_url) === TRUE
			 *
			 * @assert $signed_url = $this->object->add_sig('');
			 *    ($signed_url) === FALSE
			 */
			public function sig_ok($url_uri_query, $check_time = FALSE, $exp_secs = 10, $sig_var = '_sig')
				{
					$this->check_arg_types('string', 'boolean', 'integer', 'string:!empty', func_get_args());

					$url_uri_query = $query = $this->©string->trim($url_uri_query, '', '?&=');

					if($url_uri_query && preg_match('/^(?:[a-z]+\:\/\/|\/)/i', $url_uri_query))
						{
							if(!is_string($query = $this->parse($url_uri_query, PHP_URL_QUERY)))
								$query = ''; // Defaults to an empty query string.
							else $query = trim($query, '?&=');
						}
					if(preg_match_all('/'.preg_quote($sig_var, '/').'\=([0-9]+)-([^&]+)/', $query, $sigs))
						{
							$query = $this->remove_sigs($query, $sig_var);

							$vars = $this->©vars->parse_query($query);
							$vars = $this->©array->remove_0b_strings_deep($this->©strings->trim_deep($vars));
							$vars = serialize($this->©array->ksort_deep($vars));

							$time      = $sigs[1][count($sigs[1]) - 1];
							$sig       = $sigs[2][count($sigs[1]) - 1];
							$valid_sig = $this->©encryption->hmac_sha1_sign($vars.$time);

							if($check_time)
								return ($sig === $valid_sig && $time >= strtotime('-'.$exp_secs.' seconds'));

							return ($sig === $valid_sig);
						}
					return FALSE; // Default return value.
				}

			/**
			 * Checks to see if a URL/URI leads to a WordPress® root URL.
			 *
			 * @param string $url_uri Either a full URL, or a partial URI to test here.
			 *
			 * @param string $specifier Defaults to `any`. By default, this method returns TRUE if ``$url_uri`` matches any WordPress® root URL.
			 *    Set this to `home`, to test against the WordPress® ``home_url('/')``; or set to `site`, to test against ``site_url('/')``.
			 *
			 * @return boolean TRUE if the URL or URI leads to a WordPress® root URL, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$specifier`` is empty.
			 *
			 * @assert ('/') === TRUE
			 * @assert ('/?query') === TRUE
			 * @assert ('/wordpress/') === FALSE
			 * @assert ('http://dev.s2member.com') === TRUE
			 * @assert ('http://dev.s2member.com/') === TRUE
			 * @assert ('http://dev.s2member.com/#!hash_query=string') === TRUE
			 * @assert ('http://dev.s2member.com/?query=string') === TRUE
			 * @assert ('http://dev.s2member.com/wordpress/?query=string') === FALSE
			 * @assert ('http://foo.s2member.com/?query=string') === FALSE
			 * @assert ('http://foo.s2member.com') === FALSE
			 * @assert ('/?query=string') === TRUE
			 */
			public function is_wp_root($url_uri, $specifier = 'any')
				{
					$this->check_arg_types('string', 'string:!empty', func_get_args());

					$specifier   = strtolower($specifier); // Force lowercase value.
					$parsed_home = $this->parse_home(); // Parses home URL into an array.
					$parsed_site = $this->parse_site(); // Parses site URL into an array.

					if(($parsed = $this->parse($url_uri)) && $parsed_home && $parsed_site)
						{
							if( // We have several possibilities to consider here.

								(!$parsed['host'] // A URI? Assume same host here.
								 && in_array($specifier, array('home', 'any'), TRUE)
								 && $parsed['path'] === $parsed_home['path'])

								|| (!$parsed['host'] // A URI? Assume same.
								    && in_array($specifier, array('site', 'any'), TRUE)
								    && $parsed['path'] === $parsed_site['path'])

								|| ($parsed['host'] // Must match `host` in this case.
								    && in_array($specifier, array('home', 'any'), TRUE)
								    && strcasecmp($parsed['host'], $parsed_home['host']) === 0
								    && $parsed['path'] === $parsed_home['path'])

								|| ($parsed['host'] // Must match `host` in this case.
								    && in_array($specifier, array('site', 'any'), TRUE)
								    && strcasecmp($parsed['host'], $parsed_site['host']) === 0
								    && $parsed['path'] === $parsed_site['path'])

							) // This IS a WordPress® root URL (or URI).
								return TRUE;
						}
					return FALSE; // Default return value.
				}

			/**
			 * Checks to see if a URL/URI leads to a WordPress® administrative area.
			 *
			 * @param string $url_uri Either a full URL, or a partial URI to test here.
			 *
			 * @return boolean TRUE if the URL or URI leads to a WordPress® administrative area, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function is_in_wp_admin($url_uri)
				{
					$this->check_arg_types('string', func_get_args());

					return (preg_match('/\/wp-admin(?:\/|\?|$)/', $url_uri)) ? TRUE : FALSE;
				}

			/**
			 * A parsed ``home_url('/')`` array.
			 *
			 * @return array An array of data from a parsed ``home_url('/')``, else an empty array on failure.
			 *
			 * @assert () is-type 'array'
			 */
			public function parse_home()
				{
					if(!isset($this->static['parsed_home']))
						{
							$this->static['parsed_home'] = array();

							if(is_array($parsed = $this->parse(home_url('/'))))
								$this->static['parsed_home'] = $parsed;
						}
					return $this->static['parsed_home'];
				}

			/**
			 * A parsed ``site_url('/')`` array.
			 *
			 * @return array An array of data from a parsed ``site_url('/')``, else an empty array on failure.
			 *
			 * @assert () is-type 'array'
			 */
			public function parse_site()
				{
					if(!isset($this->static['parsed_site']))
						{
							$this->static['parsed_site'] = array();

							if(is_array($parsed = $this->parse(site_url('/'))))
								$this->static['parsed_site'] = $parsed;
						}
					return $this->static['parsed_site'];
				}
		}
	}