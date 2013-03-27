<?php
/**
 * Output Compressor.
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
		 * Output Compressor.
		 *
		 * This class must be enabled elsewhere,
		 * by attaching the ``init()`` method to the WordPress® `init` Action Hook.
		 *
		 * @package WebSharks\Core
		 * @since 120329
		 *
		 * @TODO Remove from WebSharks™ Core. This needs to be developed as a separate plugin.
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class compressor extends framework
		{
			/**
			 * @var string Current base HREF value.
			 * @note Set by various routines that work together.
			 */
			public $current_base = '';

			/**
			 * @var string Regex CSS exclusions.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $regex_css_exclusions = '';

			/**
			 * @var string Regex JS exclusions.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $regex_js_exclusions = '';

			/**
			 * @var string Regex vendor CSS prefixes.
			 * @by-constructor Set dynamically by class constructor.
			 */
			public $regex_vendor_css_prefixes = '';

			/**
			 * @var array CRON jobs associated with this class.
			 */
			public $cron_jobs = array
			(
				array(
					'©class.method' => '©compressor.cleanup_cache',
					'schedule'      => 'daily'
				)
			);

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

					if(($css_exclusion_words = $this->©options->get('compressor.css_exclusion_words')))
						$this->regex_css_exclusions = '/'.implode('|', $this->©strings->preg_quote_deep($css_exclusion_words, '/')).'/i';

					if(($js_exclusion_words = $this->©options->get('compressor.js_exclusion_words')))
						$this->regex_js_exclusions = '/'.implode('|', $this->©strings->preg_quote_deep($js_exclusion_words, '/')).'/i';

					$this->regex_vendor_css_prefixes = implode('|', $this->©strings->preg_quote_deep($this->©options->get('compressor.vendor_css_prefixes'), '/'));
				}

			/**
			 * Handles loading sequence.
			 *
			 * @attaches-to WordPress® `wp_loaded` action hook.
			 * @hook-priority `10000`.
			 *
			 * @return null Nothing.
			 */
			public function wp_loaded()
				{
					if(isset($this->static['loaded']))
						return; // Already loaded.

					$this->static['loaded'] = TRUE;

					if(!$this->©options->get('compressor.enable'))
						return; // Disabled via configuration.

					$this->©crons->config($this->cron_jobs); // Configures CRON jobs.

					if($this->©options->get('compressor.debug') && !is_super_admin())
						return; // Not Super Admin. Stop right here in this case.

					if($this->©options->get('compressor.compress_admin'))
						add_action('admin_init', array($this, 'start_compression_buffer'));

					if(!$this->©options->get('compressor.compress_if_logged_in') && is_user_logged_in())
						return; // Stop here (logged in).

					if(!is_admin()) // Make sure this hook is never attached to the admin area.
						add_action('wp', array($this, 'start_compression_buffer'), (integer)$this->©options->get('compressor.wp_hook_priority'));
				}

			/**
			 * Starts output compression buffer.
			 *
			 * @return null Nothing.
			 */
			public function start_compression_buffer()
				{
					ob_start(array($this, 'compression_buffer'));
				}

			/**
			 * Handles output compression. The heart of this class.
			 *
			 * @param string $buffer The buffer passed via PHP internals.
			 *
			 * @return string Possibly compressed output.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert-failure-for-inspection // Note, this test could be modified (just a bit) to view the current outcome of the compression routine, and make any needed adjustments.
			 * // This test covers everything else. However, we do run additional tests against the cache cleanup/purging routines, and CRON jobs below.
			 *    (file_get_contents(dirname(dirname(dirname(__FILE__))).'/._dev-utilities/unit-test-files/compress-me.html')) === 'nill'
			 */
			public function compression_buffer($buffer)
				{
					$this->check_arg_types('string', func_get_args());

					if($this->©options->get('compressor.benchmark'))
						$_time = microtime(TRUE);

					if(!$this->can_compress_buffer($buffer))
						return $buffer;

					$html = & $buffer; // Grab the buffer.
					$html = $this->maybe_compress_combine_head_body_css($html);
					$html = $this->maybe_compress_combine_head_js($html);
					$html = $this->maybe_compress_html_js_code($html);
					$html = $this->maybe_compress_html_code($html);

					if($this->©options->get('compressor.benchmark') && isset($_time))
						{
							$_time = number_format(microtime(TRUE) - $_time, 5, '.', '');
							$html .= "\n\n".'<!-- '.sprintf(
								$this->i18n('%1$s — compression routines took: %2$s seconds -->'),
								$this->___instance_config->plugin_name, $_time
							);
							unset ($_time);
						}
					return $html;
				}

			/**
			 * Possible to compress the buffer?
			 *
			 * @param string $buffer The buffer passed via PHP internals.
			 *
			 * @return boolean TRUE if possible, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function can_compress_buffer($buffer)
				{
					$this->check_arg_types('string', func_get_args());

					if(stripos($buffer, '</html>') === FALSE || !$this->©url->current())
						return FALSE; // Is NOT HTML markup, or NOT a web request.

					foreach(headers_list() as $_header)
						if(stripos($_header, 'Content-Type:') === 0)
							$_content_type_header = $_header;

					if(!empty($_content_type_header) && stripos($_content_type_header, 'html') === FALSE)
						return FALSE; // Not HTML markup. A PHP script may have sent its own header.

					return TRUE; // Default return value.
				}

			/**
			 * Cache cleanup routine (attaches to CRON job).
			 *
			 * @return null Nothing. Simply cleans up the cache.
			 *
			 * @assert () === NULL
			 */
			public function cleanup_cache()
				{
					if(is_dir($cache_dir = $this->©dirs->get_cache_dir('public', 'compressor')))
						{
							$max_age = strtotime('-'.$this->©options->get('compressor.cache_expiration'));

							// Cleanup compressor parts.

							if(is_array($_cache_files_glob = glob($cache_dir.'/*compressor-parts.*')))
								{
									foreach($_cache_files_glob as $_cache_file)
										{
											if(is_file($_cache_file) && filemtime($_cache_file) < $max_age)
												if(is_writable($_cache_file) && unlink($_cache_file))
													clearstatcache();
										}
								}
							unset ($_cache_files_glob, $_cache_file);

							// Cleanup compressor part files.

							if(is_array($_cache_files_glob = glob($cache_dir.'/*compressor-part.*')))
								{
									foreach($_cache_files_glob as $_cache_file)
										{
											if(is_file($_cache_file) && filemtime($_cache_file) < $max_age - 3600)
												if(is_writable($_cache_file) && unlink($_cache_file))
													clearstatcache();
										}
								}
							unset ($_cache_files_glob, $_cache_file);
						}
				}

			/**
			 * Cache purging routine.
			 *
			 * @return boolean TRUE if the cache directory is successfully deleted, else FALSE.
			 *    Also returns TRUE if the directory is already non-existent (i.e. nothing to purge).
			 *
			 * @see The ``del_cache_dir()`` method in the directories class.
			 *
			 * @assert () === TRUE
			 */
			public function purge_cache()
				{
					return $this->©dirs->del_cache_dir('public', 'compressor');
				}

			/**
			 * Deletes all CRON jobs associated with this class.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen (i.e. nothing will be deleted).
			 *
			 * @return integer The number of CRON jobs that were deleted. Possibly `0`.
			 *    Check the CRONs class for further details on this return value.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @note Called by the ``deactivation_uninstall()`` method below.
			 *
			 * @assert () === 0
			 * @assert $this->object->©crons->config($this->object->cron_jobs);
			 *    (TRUE) === count($this->object->cron_jobs)
			 */
			public function delete_cron_jobs($confirmation = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					if(!$confirmation)
						return 0; // Added security.

					return $this->©crons->delete(TRUE, $this->cron_jobs);
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

					$this->delete_cron_jobs(TRUE);
					$this->purge_cache();

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

					$this->delete_cron_jobs(TRUE);
					$this->purge_cache();

					return TRUE;
				}

			/**
			 * Handles possible compression of head/body CSS.
			 *
			 * @param string $html Input HTML code.
			 *
			 * @return string HTML code, after possible CSS compression.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function maybe_compress_combine_head_body_css($html)
				{
					$this->check_arg_types('string', func_get_args());

					if($this->©options->get('compressor.compress_combine_head_body_css')) // Is this enabled?
						{
							if(($_html_frag = $this->get_html_frag($html)) && ($_head_frag = $this->get_head_frag($html)))
								if(($_css_tag_frags = $this->get_css_tag_frags($_html_frag)) && ($_css_parts = $this->compile_css_tag_frags_into_parts($_css_tag_frags)))
									{
										$_css_tag_frags_all_compiled = $this->©array->compile_key_elements_deep($_css_tag_frags, 'all');
										$html                        = $this->©strings->replace_once($_head_frag['all'], '%%ws-compressor%%', $html);
										$html                        = $this->©strings->replace_once($_css_tag_frags_all_compiled, '', $html);
										$_cleaned_head_contents      = $this->©strings->replace_once($_css_tag_frags_all_compiled, '', $_head_frag['contents']);
										$_cleaned_head_contents      = $this->cleanup_head($_cleaned_head_contents);

										$_compressed_css_tags = array(); // Initialize this array.

										foreach($_css_parts as $_css_part)
											{
												if(isset($_css_part['exclude_frag'], $_css_tag_frags[$_css_part['exclude_frag']]['all']))
													$_compressed_css_tags[] = $_css_tag_frags[$_css_part['exclude_frag']]['all'];
												else $_compressed_css_tags[] = $_css_part['tag'];
											}
										$_compressed_css_tags = implode("\n", $_compressed_css_tags);

										$_compressed_head_parts = array($_head_frag['open_tag'], $_cleaned_head_contents, $_compressed_css_tags, $_head_frag['closing_tag']);
										return ($html = $this->©strings->replace_once('%%ws-compressor%%', implode("\n", $_compressed_head_parts), $html));
									}
							unset($_html_frag, $_head_frag, $_css_tag_frags_all_compiled, $_cleaned_head_contents, $_css_tag_frags, $_css_parts, $_compressed_css_tags, $_compressed_head_parts);
						}
					return $html; // With possible compression having been applied here.
				}

			/**
			 * Handles possible compression of head JS.
			 *
			 * @param string $html Input HTML code.
			 *
			 * @return string HTML code, after possible JS compression.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function maybe_compress_combine_head_js($html)
				{
					$this->check_arg_types('string', func_get_args());

					if($this->©options->get('compressor.compress_combine_head_js')) // Is this enabled?
						{
							if(($_head_frag = $this->get_head_frag($html)))
								if(is_array($_js_tag_frags = $this->get_js_tag_frags($_head_frag)) && !empty($_js_tag_frags))
									if(($_js_parts = $this->compile_js_tag_frags_into_parts($_js_tag_frags)))
										{
											$_js_tag_frags_all_compiled = $this->©array->compile_key_elements_deep($_js_tag_frags, 'all');
											$html                       = $this->©strings->replace_once($_head_frag['all'], '%%ws-compressor%%', $html);
											$_cleaned_head_contents     = $this->©strings->replace_once($_js_tag_frags_all_compiled, '', $_head_frag['contents']);
											$_cleaned_head_contents     = $this->cleanup_head($_cleaned_head_contents);

											$_compressed_js_tags = array(); // Initialize this array.

											foreach($_js_parts as $_js_part)
												{
													if(isset($_js_part['exclude_frag'], $_js_tag_frags[$_js_part['exclude_frag']]['all']))
														$_compressed_js_tags[] = $_js_tag_frags[$_js_part['exclude_frag']]['all'];
													else $_compressed_js_tags[] = $_js_part['tag'];
												}
											$_compressed_js_tags = implode("\n", $_compressed_js_tags);

											$_compressed_head_parts = array($_head_frag['open_tag'], $_cleaned_head_contents, $_compressed_js_tags, $_head_frag['closing_tag']);
											return ($html = $this->©strings->replace_once('%%ws-compressor%%', implode("\n", $_compressed_head_parts), $html));
										}
							unset($_head_frag, $_js_tag_frags_all_compiled, $_cleaned_head_contents, $_js_tag_frags, $_js_parts, $_compressed_js_tags, $_compressed_head_parts);
						}
					return $html; // With possible compression having been applied here.
				}

			/**
			 * Compiles CSS tag fragments into CSS parts with compression.
			 *
			 * @param array $css_tag_frags CSS tag fragments.
			 *
			 * @return array Array of CSS parts, else an empty array on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function compile_css_tag_frags_into_parts($css_tag_frags)
				{
					$this->check_arg_types('array', func_get_args());

					$cache_checksum = $this->get_tag_frags_checksum($css_tag_frags);
					$cache_dir      = $this->©dirs->get_cache_dir('public', 'compressor');

					$cache_parts_file      = $cache_checksum.'-compressor-parts.css-cache';
					$cache_parts_file_path = $cache_dir.'/'.$cache_parts_file;

					$cache_part_file      = '%%code-checksum%%-compressor-part.css';
					$cache_part_file_path = $cache_dir.'/'.$cache_part_file;
					$cache_part_file_url  = $this->©url->to_wp_abs_dir_or_file($cache_dir.'/'.$cache_part_file);

					if(is_file($cache_parts_file_path) && filemtime($cache_parts_file_path) > strtotime('-'.$this->©options->get('compressor.cache_expiration')))
						if(is_array($_cached_parts = maybe_unserialize(file_get_contents($cache_parts_file_path))))
							return $_cached_parts;
					unset ($_cached_parts);

					$css_parts      = array(); // Initialize these vars.
					$_css_part      = 0;
					$_css_code_part = 1;

					foreach($css_tag_frags as $_css_tag_frag_pos => $_css_tag_frag)
						{
							if($_css_tag_frag['exclude'])
								{
									if($_css_tag_frag['link_href'] || $_css_tag_frag['style_css'])
										{
											if(!empty($css_parts))
												$_css_part++; // Starts a new part.

											$css_parts[$_css_part]['tag']          = '';
											$css_parts[$_css_part]['exclude_frag'] = $_css_tag_frag_pos;

											$_css_part++; // Always indicates a new part in the next iteration.
										}
								}
							else if($_css_tag_frag['link_href'])
								{
									if(($_css_tag_frag['link_href'] = $this->©url->resolve_relative($_css_tag_frag['link_href'], '', TRUE)) #
									   && ($_css_code = $this->©url->remote($_css_tag_frag['link_href']))
									) // We CAN resolve this? And we DID fetch something remotely?
										{
											$_css_code = $this->resolve_css_relatives($_css_code, $_css_tag_frag['link_href']);
											$_css_code = $this->resolve_resolved_css_imports($_css_code);
											$_css_code = $this->maybe_wrap_css_media($_css_code, $_css_tag_frag['media']);

											if($_css_code) // Now, DO we have something here?
												{
													if(!empty($css_parts[$_css_part]['code']))
														$css_parts[$_css_part]['code'] .= "\n\n".$_css_code;
													else $css_parts[$_css_part]['code'] = $_css_code;
												}
										}
								}
							else if($_css_tag_frag['style_css'])
								{
									$_css_code = $_css_tag_frag['style_css'];
									$_css_code = $this->resolve_css_relatives($_css_code);
									$_css_code = $this->resolve_resolved_css_imports($_css_code);
									$_css_code = $this->maybe_wrap_css_media($_css_code, $_css_tag_frag['media']);

									if($_css_code) // Now, DO we have something here?
										{
											if(!empty($css_parts[$_css_part]['code']))
												$css_parts[$_css_part]['code'] .= "\n\n".$_css_code;
											else $css_parts[$_css_part]['code'] = $_css_code;
										}
								}
						}
					foreach(($css_parts = array_merge($css_parts)) as $_css_part => $_)
						{
							if(!empty($css_parts[$_css_part]['code']))
								{
									$_css_code    = $css_parts[$_css_part]['code'];
									$_css_code    = $this->move_css_charsets_namespaces_2_top($_css_code);
									$_css_code    = $this->strip_maybe_prepend_css_charset_utf8($_css_code);
									$_css_code_cs = md5($_css_code); // Do this before compression.
									$_css_code    = $this->maybe_compress_css_code($_css_code);

									$_css_code_path = str_replace('%%code-checksum%%', $_css_code_cs, $cache_part_file_path);
									$_css_code_url  = str_replace('%%code-checksum%%', $_css_code_cs, $cache_part_file_url);

									file_put_contents($_css_code_path, $_css_code); // Cache this compressed CSS code.

									$css_parts[$_css_part]['tag'] = '<link rel="stylesheet" type="text/css" href="'.esc_attr($_css_code_url).'" media="all" />';
									unset ($css_parts[$_css_part]['code']);
									$_css_code_part++;
								}
						}
					unset($_css_tag_frag_pos, $_css_tag_frag, $_css_part, $_css_code_part, $_css_code, $_css_code_cs, $_css_code_path, $_css_code_url, $_);

					if(file_put_contents($cache_parts_file_path, serialize($css_parts)))
						return $css_parts;
					else return array();
				}

			/**
			 * Compiles JS tag fragments into JS parts with compression.
			 *
			 * @param array $js_tag_frags JS tag fragments.
			 *
			 * @return array Array of JS parts, else an empty array on failure.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function compile_js_tag_frags_into_parts($js_tag_frags)
				{
					$this->check_arg_types('array', func_get_args());

					$cache_checksum = $this->get_tag_frags_checksum($js_tag_frags);
					$cache_dir      = $this->©dirs->get_cache_dir('public', 'compressor');

					$cache_parts_file      = $cache_checksum.'-compressor-parts.js-cache';
					$cache_parts_file_path = $cache_dir.'/'.$cache_parts_file;

					$cache_part_file      = '%%code-checksum%%-compressor-part.js';
					$cache_part_file_path = $cache_dir.'/'.$cache_part_file;
					$cache_part_file_url  = $this->©url->to_wp_abs_dir_or_file($cache_dir.'/'.$cache_part_file);

					if(is_file($cache_parts_file_path) && filemtime($cache_parts_file_path) > strtotime('-'.$this->©options->get('compressor.cache_expiration')))
						if(is_array($_cached_parts = maybe_unserialize(file_get_contents($cache_parts_file_path))))
							return $_cached_parts;
					unset ($_cached_parts);

					$js_parts      = array(); // Initialize these vars.
					$_js_part      = 0;
					$_js_code_part = 1;

					foreach($js_tag_frags as $_js_tag_frag_pos => $_js_tag_frag)
						{
							if($_js_tag_frag['exclude'])
								{
									if($_js_tag_frag['script_src'] || $_js_tag_frag['script_js'])
										{
											if(!empty($js_parts))
												$_js_part++; // Starts a new part.

											$js_parts[$_js_part]['tag']          = '';
											$js_parts[$_js_part]['exclude_frag'] = $_js_tag_frag_pos;

											$_js_part++; // Always indicates a new part in the next iteration.
										}
								}
							else if($_js_tag_frag['script_src'])
								{
									if(($_js_tag_frag['script_src'] = $this->©url->resolve_relative($_js_tag_frag['script_src'], '', TRUE)) #
									   && ($_js_code = $this->©url->remote($_js_tag_frag['script_src']))
									) // We CAN resolve this? And we DID fetch something remotely?
										{
											$_js_code = rtrim($_js_code, ';').';';

											if($_js_code) // Now, DO we have something here?
												{
													if(!empty($js_parts[$_js_part]['code']))
														$js_parts[$_js_part]['code'] .= "\n\n".$_js_code;
													else $js_parts[$_js_part]['code'] = $_js_code;
												}
										}
								}
							else if($_js_tag_frag['script_js'])
								{
									$_js_code = $_js_tag_frag['script_js'];
									$_js_code = rtrim($_js_code, ';').';';

									if($_js_code) // Now, DO we have something here?
										{
											if(!empty($js_parts[$_js_part]['code']))
												$js_parts[$_js_part]['code'] .= "\n\n".$_js_code;
											else $js_parts[$_js_part]['code'] = $_js_code;
										}
								}
						}
					foreach(($js_parts = array_merge($js_parts, array())) as $_js_part => $_)
						{
							if(!empty($js_parts[$_js_part]['code']))
								{
									$_js_code    = $js_parts[$_js_part]['code'];
									$_js_code_cs = md5($_js_code); // Before compression.
									$_js_code    = $this->maybe_compress_js_code($_js_code);

									$_js_code_path = str_replace('%%code-checksum%%', $_js_code_cs, $cache_part_file_path);
									$_js_code_url  = str_replace('%%code-checksum%%', $_js_code_cs, $cache_part_file_url);

									file_put_contents($_js_code_path, $_js_code); // Cache this compressed JS code.

									$js_parts[$_js_part]['tag'] = '<script type="text/javascript" src="'.esc_attr($_js_code_url).'"></script>';
									unset ($js_parts[$_js_part]['code']);
									$_js_code_part++;
								}
						}
					unset($_js_tag_frag_pos, $_js_tag_frag, $_js_part, $_js_code_part, $_js_code, $_js_code_cs, $_js_code_path, $_js_code_url, $_);

					if(file_put_contents($cache_parts_file_path, serialize($js_parts)))
						return $js_parts;
					else return array();
				}

			/**
			 * Parses and returns an array of CSS tag fragments.
			 *
			 * @param array $html_frag An HTML tag fragment array.
			 *
			 * @return array An array of CSS tag fragments (ready to be converted into CSS parts).
			 *    Else an empty array (i.e. no CSS tag fragments in the HTML fragment array).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_css_tag_frags($html_frag)
				{
					$this->check_arg_types('array', func_get_args());

					$regex = '/(?P<all>'.
					         '(?P<if_open_tag>\<\!--\[if [^\]]*?\]\>\s*)?'.
					         '(?:(?P<link_self_closing_tag>\<link(?![a-z0-9_\-])[^\>]*?\>)'.
					         '|(?P<style_open_tag>\<style(?![a-z0-9_\-])[^\>]*?\>)(?P<style_css>.*?)(?P<style_closing_tag>\<\/style\>))'.
					         '(?P<if_closing_tag>\s*\<\!\[endif\]--\>)?'.
					         ')/is'; // Dot matches line breaks.

					if(!empty($html_frag['contents']) && preg_match_all($regex, $html_frag['contents'], $_tag_frags, PREG_SET_ORDER))
						{
							foreach($_tag_frags as $_tag_frag)
								{
									$_link_href = $_style_css = $_media = '';

									if(($_link_href = $this->get_link_css_href($_tag_frag)))
										$_media = $this->get_link_css_media($_tag_frag);

									else if(($_style_css = $this->get_style_css($_tag_frag)))
										$_media = $this->get_style_css_media($_tag_frag);

									if($_link_href || $_style_css) // One or the other is fine.
										{
											$css_tag_frags[] = array(
												'all'                   => $_tag_frag['all'],
												'if_open_tag'           => $this->©string->isset_or($_tag_frag['if_open_tag'], ''),
												'if_closing_tag'        => $this->©string->isset_or($_tag_frag['if_closing_tag'], ''),
												'link_self_closing_tag' => $this->©string->isset_or($_tag_frag['link_self_closing_tag'], ''),
												'link_href'             => $_link_href, // This could also be empty.
												'style_open_tag'        => $this->©string->isset_or($_tag_frag['style_open_tag'], ''),
												'style_css'             => $_style_css, // This could also be empty.
												'style_closing_tag'     => $this->©string->isset_or($_tag_frag['style_closing_tag'], ''),
												'media'                 => $_media, // Defaults to `all`.
												'exclude'               => FALSE // Default value.
											);

											$_tag_frag_r = & $css_tag_frags[count($css_tag_frags) - 1];

											if($_tag_frag_r['if_open_tag'] || $_tag_frag_r['if_closing_tag'])
												$_tag_frag_r['exclude'] = TRUE;

											else if($this->regex_css_exclusions && $_tag_frag_r['link_href'] && preg_match($this->regex_css_exclusions, $_tag_frag_r['link_self_closing_tag']))
												$_tag_frag_r['exclude'] = TRUE;

											else if($this->regex_css_exclusions && $_tag_frag_r['style_css'] && preg_match($this->regex_css_exclusions, $_tag_frag_r['style_open_tag'].$_tag_frag_r['style_css']))
												$_tag_frag_r['exclude'] = TRUE;

											else if($this->©options->get('compressor.compress_admin') && $_tag_frag_r['link_href'] && is_admin() && !preg_match($this->©options->get('compressor.admin_regex_static_css_js'), $_tag_frag_r['link_href']))
												$_tag_frag_r['exclude'] = TRUE;
										}
								}
						}
					unset ($_tag_frags, $_tag_frag, $_tag_frag_r, $_link_href, $_style_css, $_media);

					return (!empty($css_tag_frags)) ? $css_tag_frags : array();
				}

			/**
			 * Parses and return an array of JS tag fragments.
			 *
			 * @param array $html_frag An HTML tag fragment array.
			 *
			 * @return array An array of JS tag fragments (ready to be converted into JS parts).
			 *    Else an empty array (i.e. no JS tag fragments in the HTML fragment array).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_js_tag_frags($html_frag)
				{
					$this->check_arg_types('array', 'boolean', func_get_args());

					$regex = '/(?P<all>'.
					         '(?P<if_open_tag>\<\!--\[if [^\]]*?\]\>\s*)?'.
					         '(?P<script_open_tag>\<script(?![a-z0-9_\-])[^\>]*?\>)(?P<script_js>.*?)(?P<script_closing_tag>\<\/script\>)'.
					         '(?P<if_closing_tag>\s*\<\!\[endif\]--\>)?'.
					         ')/is'; // Dot matches line breaks.

					if(!empty($html_frag['contents']) && preg_match_all($regex, $html_frag['contents'], $_tag_frags, PREG_SET_ORDER))
						{
							foreach($_tag_frags as $_tag_frag)
								{
									$_script_src = $_script_js = $_script_async = '';

									if(($_script_src = $this->get_script_js_src($_tag_frag)) || ($_script_js = $this->get_script_js($_tag_frag)))
										$_script_async = $this->get_script_js_async($_tag_frag);

									if($_script_src || $_script_js) // One or the other is fine.
										{
											$js_tag_frags[] = array(
												'all'                => $_tag_frag['all'],
												'if_open_tag'        => $this->©string->isset_or($_tag_frag['if_open_tag'], ''),
												'if_closing_tag'     => $this->©string->isset_or($_tag_frag['if_closing_tag'], ''),
												'script_open_tag'    => $this->©string->isset_or($_tag_frag['script_open_tag'], ''),
												'script_src'         => $_script_src, // This could also be empty.
												'script_js'          => $_script_js, // This could also be empty.
												'script_async'       => $_script_async, // This could also be empty.
												'script_closing_tag' => $this->©string->isset_or($_tag_frag['script_closing_tag'], ''),
												'exclude'            => FALSE // Default value.
											);

											$_tag_frag_r = & $js_tag_frags[count($js_tag_frags) - 1];

											if($_tag_frag_r['if_open_tag'] || $_tag_frag_r['if_closing_tag'] || $_tag_frag_r['script_async'])
												$_tag_frag_r['exclude'] = TRUE;

											else if($this->regex_js_exclusions && $_tag_frag_r['script_open_tag'] && preg_match($this->regex_js_exclusions, $_tag_frag_r['script_open_tag'].$_tag_frag_r['script_js']))
												$_tag_frag_r['exclude'] = TRUE;

											else if($this->©options->get('compressor.compress_admin') && $_tag_frag_r['script_src'] && is_admin() && !preg_match($this->©options->get('compressor.admin_regex_static_css_js'), $_tag_frag_r['script_src']))
												$_tag_frag_r['exclude'] = TRUE;
										}
								}
						}
					unset ($_tag_frags, $_tag_frag, $_tag_frag_r, $_script_src, $_script_js, $_script_async);

					return (!empty($js_tag_frags)) ? $js_tag_frags : array();
				}

			/**
			 * Construct a checksum for an array of tag fragments.
			 *
			 * This routine purposely excludes any exclusions from the checksum calculation.
			 * All that's important here is an exclusion's position in the array, not its fragmentation — because it's excluded anyway.
			 *
			 * @param array $tag_frags Array of tag fragments.
			 *
			 * @return string MD5 checksum.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_tag_frags_checksum($tag_frags)
				{
					$this->check_arg_types('array', func_get_args());

					foreach($tag_frags as &$_frag) // Exclude exclusions.
						$_frag = ($_frag['exclude']) ? array('exclude' => TRUE) : $_frag;
					unset ($_frag); // A little housekeeping.

					return md5(serialize($tag_frags));
				}

			/**
			 * Strip existing charsets, and maybe prepend a UTF-8 charset rule (if there is any CSS code remaining).
			 *
			 * @param string $css CSS code.
			 *
			 * @return string CSS code (possibly with a prepended UTF-8 charset rule).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function strip_maybe_prepend_css_charset_utf8($css)
				{
					$this->check_arg_types('string', func_get_args());

					if(($css = trim($css))) // If we have CSS code.
						{
							$css = $this->strip_existing_css_charsets($css);
							$css = ($css) ? '@charset "UTF-8";'."\n\n".$css : '';
						}
					return $css;
				}

			/**
			 * Strip existing charset rules from CSS code.
			 *
			 * @param string $css CSS code.
			 *
			 * @return string CSS after having stripped away existing charset rules.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function strip_existing_css_charsets($css)
				{
					$this->check_arg_types('string', func_get_args());

					if(($css = trim($css))) // If we have CSS code.
						$css = trim(preg_replace('/@(?:-(?:'.$this->regex_vendor_css_prefixes.')-)?charset(?![a-z0-9_\-])[^;]*;/i', '', $css));

					return $css;
				}

			/**
			 * Move @ charset and namespace rules to the top.
			 *
			 * @note This method will move @ charset rules to the very top of the CSS file.
			 * @note This method will move @ namespace rules to the very top of the CSS file,
			 *    or re-insert them right after a possible @ charset rule.
			 *
			 * @param string  $css CSS code.
			 * @param integer $recursion Defaults to `0`. Set internally (used in recursion).
			 *
			 * @return string CSS code (with @ charset and @ namespace rules to the top).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function move_css_charsets_namespaces_2_top($css, $recursion = 0)
				{
					$this->check_arg_types('string', 'integer', func_get_args());

					$css            = trim($css); // Trim this up.
					$max_recursions = 2; // Safeguard against inadvertent recursion.

					if($css && $recursion <= $max_recursions) // Move @ charset & @ namespace rules to the top of the file.
						{
							if(preg_match_all('/(?P<rule>@(?:-(?:'.$this->regex_vendor_css_prefixes.')-)?charset(?![a-z0-9_\-])[^;]*;)/i', $css, $_rules, PREG_SET_ORDER)
							   || preg_match_all('/(?P<rule>@(?:-(?:'.$this->regex_vendor_css_prefixes.')-)?namespace(?![a-z0-9_\-])[^;]*;)/i', $css, $_rules, PREG_SET_ORDER)
							) // These are searched in a specific order. See docBlock comments for further details about how this is handled with recursion.
								{
									$_rules_2_top = array(); // Initialize this array of rules.
									foreach($_rules as $_rule) // Remove these temporarily.
										$_rules_2_top[] = $_rule['rule'];

									$css = $this->©string->replace_once($_rules_2_top, '', $css);
									$css = $this->move_css_charsets_namespaces_2_top($css, $recursion++);
									$css = implode("\n\n", $_rules_2_top)."\n\n".$css;
								}
							unset($_rules, $_rule, $_rules_2_top); // Housekeeping.
						}
					return $css;
				}

			/**
			 * Try to wrap CSS code with the specified @ media rule.
			 *
			 * @note All @ import rules should have already been resolved with ``resolve_resolved_css_imports()`` BEFORE running this routine.
			 *
			 * @note Trying — because it's not possible if we're unable to move existing @ rules to the top of the file.
			 *    CSS specs require all @ rules to come first. If others are embedded into the existing CSS, we can't wrap them
			 *    all up with an @ media rule. In other words, @ media rules may NOT wrap *any* other @ rule.
			 *
			 * @note This method will attempt to move @ charset rules out of the way,
			 *    re-inserting them into the very top of the CSS file.
			 *
			 * @note This method will attempt to move @ namespace rules out of the way,
			 *    re-inserting them into the very top of the CSS file,
			 *    or re-inserting them right after a possible @ charset rule.
			 *
			 * @note This method will attempt to move @ page rules out of the way,
			 *    re-inserting them into the very top of the CSS file,
			 *    or re-inserting them right after a possible @ charset rule,
			 *    or re-inserting them right after a possible @ namespace rule.
			 *
			 * @note This method will attempt to move @ keyframes rules out of the way,
			 *    re-inserting them into the very top of the CSS file,
			 *    or re-inserting them right after a possible @ charset rule,
			 *    or re-inserting them right after a possible @ namespace rule,
			 *    or re-inserting them right after a possible @ page rule.
			 *
			 * @note This method will attempt to move @ font-face rules out of the way
			 *    re-inserting them into the very top of the CSS file,
			 *    or re-inserting them right after a possible @ charset rule,
			 *    or re-inserting them right after a possible @ namespace rule,
			 *    or re-inserting them right after a possible @ page rule,
			 *    or re-inserting them right after a possible @ keyframes rule.
			 *
			 * @param string  $css CSS code.
			 * @param string  $media Media rule/declaration.
			 * @param integer $recursion Defaults to `0`. Set internally (used in recursion).
			 *
			 * @return string CSS code (possibly wrapped with an @ media rule).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function maybe_wrap_css_media($css, $media, $recursion = 0)
				{
					$this->check_arg_types('string', 'string', 'integer', func_get_args());

					$css            = trim($css); // Trim this up.
					$media          = trim($media); // Trim this up.
					$max_recursions = 5; // Safeguard against inadvertent recursion.

					$regex_at_rules = 'charset|import|namespace|page|keyframes|font-face|media';

					if($css && $media && !preg_match('/@(?:-(?:'.$this->regex_vendor_css_prefixes.')-)?(?:'.$regex_at_rules.')/i', $css))
						$css = '@media '.$media.' {'."\n\n".$css."\n\n".'}'; // We can wrap now.

					else if($css && $media && $recursion <= $max_recursions) // Try to make room for an @media rule.
						{
							if(preg_match_all('/(?P<rule>@(?:-(?:'.$this->regex_vendor_css_prefixes.')-)?charset(?![a-z0-9_\-])[^;]*;)/i', $css, $_rules, PREG_SET_ORDER)
							   || preg_match_all('/(?P<rule>@(?:-(?:'.$this->regex_vendor_css_prefixes.')-)?namespace(?![a-z0-9_\-])[^;]*;)/i', $css, $_rules, PREG_SET_ORDER)
							   || preg_match_all('/(?P<rule>@(?:-(?:'.$this->regex_vendor_css_prefixes.')-)?page(?![a-z0-9_\-])[^\{]*\{[^\}]*\})/i', $css, $_rules, PREG_SET_ORDER)
							   || preg_match_all('/(?P<rule>@(?:-(?:'.$this->regex_vendor_css_prefixes.')-)?keyframes(?![a-z0-9_\-])[^\{]*\{[^\}]*\})/i', $css, $_rules, PREG_SET_ORDER)
							   || preg_match_all('/(?P<rule>@(?:-(?:'.$this->regex_vendor_css_prefixes.')-)?font-face(?![a-z0-9_\-])[^\{]*\{[^\}]*\})/i', $css, $_rules, PREG_SET_ORDER)
							) // These are searched in a specific order. See docBlock comments for further details about how this is handled with recursion.
								{
									$_rules_2_top = array(); // Initialize this array of rules.
									foreach($_rules as $_rule) // Remove these temporarily.
										$_rules_2_top[] = $_rule['rule'];

									$css = $this->©strings->replace_once($_rules_2_top, '', $css);
									$css = $this->maybe_wrap_css_media($css, $media, $recursion++);
									$css = implode("\n\n", $_rules_2_top)."\n\n".$css;
								}
							unset($_rules, $_rule, $_rules_2_top); // Housekeeping.
						}
					return $css;
				}

			/**
			 * Resolves @ import rules in CSS code recursively.
			 *
			 * @param string $css CSS code.
			 *
			 * @return string CSS code after having all @ import rules resolved recursively.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function resolve_resolved_css_imports($css)
				{
					$this->check_arg_types('string', func_get_args());

					$_import_media_without_url_regex = '/@import\s*(["\'])(?P<url>.+?)\\1(?P<media>[^;]*);/i';
					$_import_media_with_url_regex    = '/@import\s*url\s*\(\s*(["\']?)(?P<url>.+?)\\1\s*\)(?P<media>[^;]*);/i';

					$css = preg_replace_callback($_import_media_without_url_regex, array($this, '_resolve_resolved_css_imports_cb'), $css);
					$css = preg_replace_callback($_import_media_with_url_regex, array($this, '_resolve_resolved_css_imports_cb'), $css);

					if(preg_match($_import_media_without_url_regex, $css) || preg_match($_import_media_with_url_regex, $css))
						return $this->resolve_resolved_css_imports($css); // Recursive resolutions.

					unset ($_import_media_without_url_regex, $_import_media_with_url_regex);

					return $css;
				}

			/**
			 * Callback handler for resolving @ import rules.
			 *
			 * @param array $m An array of regex matches.
			 *
			 * @return string CSS after import resolution, else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list (disabled).
			 */
			public function _resolve_resolved_css_imports_cb($m)
				{
					// Commenting this out for performance.
					// This is used as a callback for ``preg_replace()``, so it's NOT absolutely necessary.
					// $this->check_arg_types('array', func_get_args());

					if(!empty($m['url']) && ($css = $this->©url->remote($m['url'])))
						{
							$css   = $this->resolve_css_relatives($css, $m['url']);
							$media = (!empty($m['media']) && ($m['media'] = trim($m['media']))) ? $m['media'] : 'all';

							return $this->maybe_wrap_css_media($css, $media);
						}
					return '';
				}

			/**
			 * Resolve relative URLs in CSS code.
			 *
			 * @param string $css CSS code.
			 * @param string $base Optional. Base URL to calculate from.
			 *    Defaults to the current HTTP location for the browser.
			 *
			 * @return string CSS code after having all URLs resolved.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function resolve_css_relatives($css, $base = '')
				{
					$this->check_arg_types('string', 'string', func_get_args());

					$_import_without_url_regex = '/(?P<import>@import\s*)(?P<open_encap>["\'])(?P<url>.+?)(?P<close_encap>\\2)/i';
					$_any_url_regex            = '/(?P<url_>url\s*)(?P<open_bracket>\(\s*)(?P<open_encap>["\']?)(?P<url>.+?)(?P<close_encap>\\3)(?P<close_bracket>\s*\))/i';

					$this->current_base = $base; // << Make this available to callback handlers (possible empty string here).
					$css                = preg_replace_callback($_import_without_url_regex, array($this, '_resolve_css_relatives_import_cb'), $css);
					$css                = preg_replace_callback($_any_url_regex, array($this, '_resolve_css_relatives_url_cb'), $css);

					unset ($_import_without_url_regex, $_any_url_regex);

					return $css;
				}

			/**
			 * Callback handler for CSS relative URL resolutions.
			 *
			 * @param array $m An array of regex matches.
			 *
			 * @return string CSS @ import rule with relative URL resolved.
			 *
			 * @throws exception If invalid types are passed through arguments list (disabled).
			 */
			public function _resolve_css_relatives_import_cb($m)
				{
					// Commenting this out for performance.
					// This is used as a callback for ``preg_replace()``, so it's NOT absolutely necessary.
					// $this->check_arg_types('array', func_get_args());

					return $m['import'].$m['open_encap'].$this->©url->resolve_relative($m['url'], $this->current_base, TRUE).$m['close_encap'];
				}

			/**
			 * Callback handler for CSS relative URL resolutions.
			 *
			 * @param array $m An array of regex matches.
			 *
			 * @return string CSS `url()` resource with relative URL resolved.
			 *
			 * @throws exception If invalid types are passed through arguments list (disabled).
			 */
			public function _resolve_css_relatives_url_cb($m)
				{
					// Commenting this out for performance.
					// This is used as a callback for ``preg_replace()``, so it's NOT absolutely necessary.
					// $this->check_arg_types('array', func_get_args());

					return $m['url_'].$m['open_bracket'].$m['open_encap'].$this->©url->resolve_relative($m['url'], $this->current_base, TRUE).$m['close_encap'].$m['close_bracket'];
				}

			/**
			 * Get a CSS link href value from a tag fragment.
			 *
			 * @param array $tag_frag A CSS tag fragment.
			 *
			 * @return string The link href value if possible, else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_link_css_href($tag_frag)
				{
					$this->check_arg_types('array', func_get_args());

					if(!empty($tag_frag['link_self_closing_tag']) && preg_match('/type\s*\=\s*(["\'])text\/css\\1|rel\s*=\s*(["\'])stylesheet\\2/i', $tag_frag['link_self_closing_tag']))
						if(preg_match('/href\s*\=\s*(["\'])(?P<value>.*?)\\1/i', $tag_frag['link_self_closing_tag'], $_href) && ($link_css_href = trim($this->©url->n_amps($_href['value']))))
							return $link_css_href;
					unset ($_href);

					return '';
				}

			/**
			 * Get a CSS link media rule from a tag fragment.
			 * If there is no media specified, defaults to a value of `all`.
			 *
			 * @param array $tag_frag A CSS tag fragment.
			 *
			 * @return string The link media value if possible (defaulting to `all`), else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_link_css_media($tag_frag)
				{
					$this->check_arg_types('array', func_get_args());

					if(!empty($tag_frag['link_self_closing_tag']) && preg_match('/type\s*\=\s*(["\'])text\/css\\1|rel\s*=\s*(["\'])stylesheet\\2/i', $tag_frag['link_self_closing_tag']))
						if((preg_match('/media\s*\=\s*(["\'])(?P<value>.*?)\\1/i', $tag_frag['link_self_closing_tag'], $_media) && ($link_css_media = trim($_media['value']))) || ($link_css_media = 'all'))
							return $link_css_media;
					unset ($_media);

					return '';
				}

			/**
			 * Get a CSS style media rule from a tag fragment.
			 * If there is no media specified, defaults to a value of `all`.
			 *
			 * @param array $tag_frag A CSS tag fragment.
			 *
			 * @return string The style media value if possible (defaulting to `all`), else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_style_css_media($tag_frag)
				{
					$this->check_arg_types('array', func_get_args());

					if(!empty($tag_frag['style_open_tag']) && !empty($tag_frag['style_closing_tag']) && preg_match('/\<style\>|type\s*\=\s*(["\'])text\/css\\1/i', $tag_frag['style_open_tag']))
						if((preg_match('/media\s*\=\s*(["\'])(?P<value>.*?)\\1/i', $tag_frag['style_open_tag'], $_media) && ($style_css_media = trim($_media['value']))) || ($style_css_media = 'all'))
							return $style_css_media;
					unset ($_media);

					return '';
				}

			/**
			 * Get style CSS from a CSS tag fragment.
			 *
			 * @param array $tag_frag A CSS tag fragment.
			 *
			 * @return string The style CSS code (if possible), else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_style_css($tag_frag)
				{
					$this->check_arg_types('array', func_get_args());

					if(!empty($tag_frag['style_open_tag']) && !empty($tag_frag['style_closing_tag']) && preg_match('/\<style\>|type\s*\=\s*(["\'])text\/css\\1/i', $tag_frag['style_open_tag']))
						if(!empty($tag_frag['style_css']) && ($style_css = trim($tag_frag['style_css'])))
							return $style_css;

					return '';
				}

			/**
			 * Get script JS src value from a JS tag fragment.
			 *
			 * @param array $tag_frag A JS tag fragment.
			 *
			 * @return string The script JS src value (if possible), else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_script_js_src($tag_frag)
				{
					$this->check_arg_types('array', func_get_args());

					if(!empty($tag_frag['script_open_tag']) && !empty($tag_frag['script_closing_tag']) && preg_match('/\<script\>|type\s*\=\s*(["\'])(?:text\/javascript|application\/(?:x-)?javascript)\\1|language\s*\=\s*(["\'])javascript\\2/i', $tag_frag['script_open_tag']))
						if(preg_match('/src\s*\=\s*(["\'])(?P<value>.*?)\\1/i', $tag_frag['script_open_tag'], $_src) && ($script_js_src = trim($this->©url->n_amps($_src['value']))))
							return $script_js_src;
					unset ($_src);

					return '';
				}

			/**
			 * Get script JS async|defer value from a JS tag fragment.
			 *
			 * @param array $tag_frag A JS tag fragment.
			 *
			 * @return string The script JS async|defer value (if possible), else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_script_js_async($tag_frag)
				{
					$this->check_arg_types('array', func_get_args());

					if(!empty($tag_frag['script_open_tag']) && !empty($tag_frag['script_closing_tag']) && preg_match('/\<script\>|type\s*\=\s*(["\'])(?:text\/javascript|application\/(?:x-)?javascript)\\1|language\s*\=\s*(["\'])javascript\\2/i', $tag_frag['script_open_tag']))
						if(preg_match('/(?:async|defer)\s*\=\s*(["\'])(?P<value>1|on|yes|true|async|defer)\\1/i', $tag_frag['script_open_tag'], $_async) && ($script_js_async = 'async'))
							return $script_js_async;
					unset ($_async);

					return '';
				}

			/**
			 * Get script JS from a JS tag fragment.
			 *
			 * @param array $tag_frag A JS tag fragment.
			 *
			 * @return string The script JS code (if possible), else an empty string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_script_js($tag_frag)
				{
					$this->check_arg_types('array', func_get_args());

					if(!empty($tag_frag['script_open_tag']) && !empty($tag_frag['script_closing_tag']) && preg_match('/\<script\>|type\s*\=\s*(["\'])(?:text\/javascript|application\/(?:x-)?javascript)\\1|language\s*\=\s*(["\'])javascript\\2/i', $tag_frag['script_open_tag']))
						if(!empty($tag_frag['script_js']) && ($script_js = trim($tag_frag['script_js'])))
							return $script_js;

					return '';
				}

			/**
			 * Build an HTML fragment from HTML source code.
			 *
			 * @param string $html Raw HTML code.
			 *
			 * @return array An HTML fragment (if possible), else an empty array.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_html_frag($html)
				{
					$this->check_arg_types('string', func_get_args());

					if($html && preg_match('/(?P<all>(?P<open_tag>\<html(?![a-z0-9_\-])[^\>]*?\>)(?P<contents>.*?)(?P<closing_tag>\<\/html\>))/is', $html, $html_frag))
						return $this->©array->remove_numeric_keys_deep($html_frag);

					return array();
				}

			/**
			 * Build a head fragment from HTML source code.
			 *
			 * @param string $html Raw HTML code.
			 *
			 * @return array A head fragment (if possible), else an empty array.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function get_head_frag($html)
				{
					$this->check_arg_types('string', func_get_args());

					if($html && preg_match('/(?P<all>(?P<open_tag>\<head(?![a-z0-9_\-])[^\>]*?\>)(?P<contents>.*?)(?P<closing_tag>\<\/head\>))/is', $html, $head_frag))
						return $this->©array->remove_numeric_keys_deep($head_frag);

					return array();
				}

			/**
			 * Cleans up ``<head></head>`` tag contents.
			 *
			 * @param string $contents Contents of a ``<head></head>`` tag.
			 *
			 * @return string Cleaned ``<head></head>`` tag contents.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function cleanup_head($contents)
				{
					$this->check_arg_types('string', func_get_args());

					return trim(preg_replace('/\>\s*'."[\r\n]".'+\s*\</', ">\n<", $contents));
				}

			/**
			 * Maybe compress HTML code.
			 *
			 * @param string $html Raw HTML code.
			 *
			 * @return string Possibly compressed HTML code.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function maybe_compress_html_code($html)
				{
					$this->check_arg_types('string', func_get_args());

					if(!$this->©options->get('compressor.compress_html_code') || (!$this->©options->get('compressor.compress_html_code_if_logged_in') && is_user_logged_in()))
						return $html; // Nothing to do here.

					if(($compressed_html = $this->©html_minifier->compress($html)))
						return $compressed_html;

					return $html;
				}

			/**
			 * Maybe compress inline JS code within the HTML source.
			 *
			 * @param string $html Raw HTML code.
			 *
			 * @return string HTML source code, with possible inline JS compression.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function maybe_compress_html_js_code($html)
				{
					$this->check_arg_types('string', func_get_args());

					if(!$this->©options->get('compressor.compress_html_code') || (!$this->©options->get('compressor.compress_html_code_if_logged_in') && is_user_logged_in()) #
					   || !$this->©options->get('compressor.compress_html_js_code') || !$this->©options->get('compressor.compress_js_code')
					) // Must satisfy all of these configuration options.
						return $html; // Nothing to do here.

					if(($_html_frag = $this->get_html_frag($html)) && ($_js_tag_frags = $this->get_js_tag_frags($_html_frag, TRUE)))
						{
							foreach($_js_tag_frags as $_js_tag_frag_key => $_js_tag_frag) // Loop through each JS tag fragment.
								if($_js_tag_frag['script_js']) // Remove inline JS code temporarily (we'll re-insert after compression).
									{
										$_js_tag_frags_script_js_parts[]                             = $_js_tag_frag['all'];
										$_js_tag_frags_script_js_part_placeholders[]                 = '%%ws-compressor-'.$_js_tag_frag_key.'%%';
										$_js_tag_frags_script_js_part_placeholder_key_replacements[] = $_js_tag_frag_key;
									}
							if(isset($_js_tag_frags_script_js_parts, $_js_tag_frags_script_js_part_placeholders, $_js_tag_frags_script_js_part_placeholder_key_replacements))
								{
									$html = $this->©strings->replace_once(
										$_js_tag_frags_script_js_parts,
										$_js_tag_frags_script_js_part_placeholders, $html
									);

									foreach($_js_tag_frags_script_js_part_placeholder_key_replacements as &$_js_tag_frag_key_replacement)
										{
											$_js_tag_frag = $_js_tag_frags[$_js_tag_frag_key_replacement];

											$_js_tag_frag_key_replacement = $_js_tag_frag['if_open_tag'];
											$_js_tag_frag_key_replacement .= $_js_tag_frag['script_open_tag'];
											$_js_tag_frag_key_replacement .= $this->maybe_minify_inline_js_code($_js_tag_frag['script_js']);
											$_js_tag_frag_key_replacement .= $_js_tag_frag['script_closing_tag'];
											$_js_tag_frag_key_replacement .= $_js_tag_frag['if_closing_tag'];
										}
									$html = $this->©strings->replace_once(
										$_js_tag_frags_script_js_part_placeholders,
										$_js_tag_frags_script_js_part_placeholder_key_replacements, $html
									);
								}
						}
					unset($_html_frag, $_js_tag_frags, $_js_tag_frag_key, $_js_tag_frag);
					unset($_js_tag_frags_script_js_parts, $_js_tag_frags_script_js_part_placeholders, $_js_tag_frags_script_js_part_placeholder_key_replacements);

					return $html; // After possible inline JS compression.
				}

			/**
			 * Maybe compress CSS code.
			 *
			 * @param string $css Raw CSS code.
			 *
			 * @return string CSS code (possibly compressed).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function maybe_compress_css_code($css)
				{
					$this->check_arg_types('string', func_get_args());

					if(!$this->©options->get('compressor.compress_css_code'))
						return $css; // Nothing to do here.

					$_regex = '/(?:https?\:)?\/\/'.preg_quote($this->©url->current_host(), '/').'\//i';
					$css    = preg_replace($_regex, '/', $css); // To absolute paths.
					unset ($_regex);

					if($this->©options->get('compressor.try_yui_compressor') && $this->©commands->java_possible())
						{
							$yui = dirname(__FILE__).'/externals/yui-compressor/yui-compressor.jar';
							// @TODO This is NOT compatible with PHAR; because Java will not get the jar file here.
							$yui = $this->©commands->java.' -jar '.$this->©commands->esa($yui).' --type css --charset utf-8';

							if(($compressed_css = (string)$this->©commands->exec($yui, $css)))
								return '/*YUI*/'.$compressed_css;
						}
					else // Else fallback on the WebSharks™ CSS Minifier.
						{
							if(($compressed_css = $this->©css_minifier->compress($css)))
								return '/*WS*/'.$compressed_css;
						}
					return $css;
				}

			/**
			 * Maybe compress JS code.
			 *
			 * @param string $js Raw JS code.
			 *
			 * @return string JS code (possibly compressed).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function maybe_compress_js_code($js)
				{
					$this->check_arg_types('string', func_get_args());

					if(!$this->©options->get('compressor.compress_js_code'))
						return $js; // Nothing to do here.

					if($this->©options->get('compressor.try_yui_compressor') && $this->©commands->java_possible())
						{
							$yui = dirname(__FILE__).'/externals/yui-compressor/yui-compressor.jar';
							// @TODO This is NOT compatible with PHAR; because Java will not get the jar file here.
							$yui = $this->©commands->java.' -jar '.$this->©commands->esa($yui).' --type js --charset utf-8';

							if(($compressed_js = (string)$this->©commands->exec($yui, $js)))
								return '/*YUI*/'.$compressed_js;
						}
					else // Else fallback on the WebSharks™ JS Minifier.
						{
							if(($compressed_js = $this->©js_minifier->compress($js)))
								return '/*WS*/'.$compressed_js;
						}
					return $js;
				}

			/**
			 * Maybe minify inline JS code.
			 *
			 * @param string $js Raw JS code.
			 *
			 * @return string JS code (possibly minified).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 */
			public function maybe_minify_inline_js_code($js)
				{
					$this->check_arg_types('string', func_get_args());

					if(!$this->©options->get('compressor.compress_js_code'))
						return $js; // Nothing to do here.

					if(($minified_js = $this->©js_minifier->compress($js)))
						return '/*WS*//*<![CDATA[*/'.$minified_js.'/*]]>*/';

					return $js;
				}
		}
	}