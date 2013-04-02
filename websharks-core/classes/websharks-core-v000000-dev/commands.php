<?php
/**
 * Command Line Tools.
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
		 * Command Line Tools.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class commands extends framework
		{
			/**
			 * Path to GIT application.
			 * Normally exit status `0` indicates success.
			 *
			 * @var string Path to `git` command line tool.
			 */
			public $git = 'git';

			/**
			 * Path to Java™ application.
			 * Normally exit status `0` indicates success.
			 * However, this depends on which JAR file is called upon.
			 *
			 * @var string Path to `java` command line tool.
			 */
			public $java = 'java -Xms2M -Xmx32M';

			/**
			 * Path to 7-Zip application. Exit status `0` on success.
			 * See also: {@link http://sevenzip.sourceforge.jp/chm/cmdline/exit_codes.htm}
			 *
			 * @var string Path to `7z` command line tool.
			 */
			public $_7z = '7z';

			/**
			 * Path to `robocopy` in Windows®. Exit status `1` on success.
			 * See also: {@link http://ss64.com/nt/robocopy-exit.html}
			 *
			 * @var string Path to `robocopy` command line tool.
			 */
			public $robocopy = 'robocopy';

			/**
			 * Path to `rmdir` in Windows®. Exit status `0` on success.
			 * However, unable to find any official docs on exit status codes.
			 *
			 * @var string Path to `rmdir` command line tool.
			 *
			 * @note This command requires `\` directory separators; else it chokes.
			 */
			public $rmdir = 'rmdir';

			/**
			 * Path to `mklink` on Windows®. Exit status `0` on success.
			 * However, unable to find any official docs on exit status codes.
			 *
			 * @var string Path to `mklink` command line tool.
			 */
			public $mklink = 'mklink';

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
					// Here we might eventually modify certain properties based on operating system.
					// It might also be helpful to check multiple locations for some command line tools.
					// For instance, Java™ or 7-Zip might exist in one several different locations.
				}

			/**
			 * Are command line operations possible?
			 *
			 * @return boolean TRUE if commands are possible, else FALSE.
			 *
			 * @assert () === TRUE
			 */
			public function possible()
				{
					if(!isset($this->static['possible']))
						{
							$this->static['possible'] = FALSE;

							if($this->©function->is_possible('exec')
							   && $this->©function->is_possible('shell_exec')
							   && $this->©function->is_possible('proc_open')
							) $this->static['possible'] = TRUE;
						}
					return $this->static['possible'];
				}

			/**
			 * Are Unix® command line operations possible?
			 *
			 * @return boolean TRUE if Unix® command line operations are possible, else FALSE.
			 *
			 * @assert // Test development server.
			 *    () === TRUE
			 */
			public function unix_possible()
				{
					if(!isset($this->static['unix_possible']))
						{
							$this->static['unix_possible'] = FALSE;

							if($this->possible() && $this->©env->is_unix())
								$this->static['unix_possible'] = TRUE;
						}
					return $this->static['unix_possible'];
				}

			/**
			 * Are Windows® command line operations possible?
			 *
			 * @return boolean TRUE if Windows® command line operations are possible, else FALSE.
			 *
			 * @assert // Test development server.
			 *    () === FALSE
			 */
			public function windows_possible()
				{
					if(!isset($this->static['windows_possible']))
						{
							$this->static['windows_possible'] = FALSE;

							if($this->possible() && $this->©env->is_windows())
								$this->static['windows_possible'] = TRUE;
						}
					return $this->static['windows_possible'];
				}

			/**
			 * Are Java™ command line operations possible?
			 *
			 * @return boolean TRUE if Java™ command line operations are possible, else FALSE.
			 *
			 * @assert // Test development server.
			 *    () === FALSE
			 */
			public function java_possible()
				{
					if(!isset($this->static['java_possible']))
						{
							$this->static['java_possible'] = FALSE;

							if($this->possible() && is_array($java = $this->exec($this->java.' -version', '', TRUE)))
								if($java['status'] === 0 && stripos($java['output'], 'error') === FALSE && stripos($java['output'], 'version') !== FALSE)
									$this->static['java_possible'] = TRUE;
						}
					return $this->static['java_possible'];
				}

			/**
			 * Are GIT command line operations possible?
			 *
			 * @return boolean TRUE if GIT command line operations are possible, else FALSE.
			 *
			 * @assert // Test development server.
			 *    () === FALSE
			 */
			public function git_possible()
				{
					if(!isset($this->static['git_possible']))
						{
							$this->static['git_possible'] = FALSE;

							if($this->possible() && is_array($git = $this->exec($this->git.' --version', '', TRUE)))
								if($git['status'] === 0 && stripos($git['output'], 'error') === FALSE && stripos($git['output'], 'version') !== FALSE)
									$this->static['git_possible'] = TRUE;
						}
					return $this->static['git_possible'];
				}

			/**
			 * Command line execution processor.
			 *
			 * @param string  $cmd_args Command and arguments.
			 *
			 * @param string  $stdin Optional standard input to this command. This will be written to the input pipe.
			 *
			 * @param boolean $return_array Return full array? Defaults to FALSE. If TRUE, this method will return an array with all connection details.
			 *    The default behavior of this function is to simply return a string that contains any output received from the command line routine.
			 *
			 * @param boolean $return_errors If an error occurs, return an `errors` object instead of a string or array? Defaults to FALSE.
			 *    If TRUE, upon an error occurring, an `errors` object will be returned instead of a string or array.
			 *
			 * @param string  $cwd The initial working dir for the command. This must be an absolute directory path.
			 *    Defaults to an empty string. If needed, this parameter can by bypassed with an empty string.
			 *    Actually, this defaults to a NULL value, but that's handled internally.
			 *    To bypass this argument, use an empty string.
			 *
			 * @param array   $env An array with the environment variables for the command that will be run,
			 *    or an empty array to use the same environment as the current PHP process. Defaults to an empty array.
			 *    Actually, this defaults to a NULL value, but that's handled internally.
			 *    To bypass this argument, use an empty array.
			 *
			 * @param array   $other Allows you to specify additional options. Defaults to an empty array.
			 *    Actually, this defaults to a NULL value, but that's handled internally.
			 *    To bypass this argument, use an empty array.
			 *
			 * @see {@link http://php.net/manual/en/function.proc-open.php}
			 *
			 * @return string|array|errors The default behavior of this function is to simply return a string that contains any output received from the command line routine.
			 *    The return value of this function will depend very much on the command that was actually called upon.
			 *    ~ And, of course, also based on the argument values: ``$return_array``, ``$return_errors``.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert // Test development server.
			 *    ('whoami') === 'websharks-inc.com'
			 */
			public function exec($cmd_args, $stdin = '', $return_array = FALSE, $return_errors = FALSE, $cwd = '', $env = array(), $other = array())
				{
					$this->check_arg_types('string', 'string', 'boolean', 'boolean',
					                       array('string', 'null'), array('array', 'null'), array('array', 'null'), func_get_args());

					$specs = array(
						0 => array('pipe', 'r'), // Input pipe for command to read input from (for us to write to).
						1 => array('pipe', 'w'), // Output pipe for command to write its output to (for us to read from).
						2 => array('pipe', 'w') // Error output pipe for command to write its errors to (for us to read from).
					);

					if($cmd_args && $this->possible()) // Have something, and commands are possible?
						{
							// Bypass each of these with NULL values, when/if they are empty.

							$this->©var->is_not_empty_or($cwd, NULL, TRUE);
							$this->©var->is_not_empty_or($env, NULL, TRUE);
							$this->©var->is_not_empty_or($other, NULL, TRUE);

							if(is_resource($_process = proc_open($cmd_args, $specs, $_pipes, $cwd, $env, $other)))
								{
									// Execute.

									if(strlen($stdin))
										fwrite($_pipes[0], $stdin);
									fclose($_pipes[0]); // Close pipe.

									$output = trim((string)stream_get_contents($_pipes[1]));
									fclose($_pipes[1]); // Close pipe.

									$error = trim((string)stream_get_contents($_pipes[2]));
									fclose($_pipes[2]); // Close pipe.

									$status = (integer)proc_close($_process);
									unset($_process, $_pipes);

									// Handle errors.

									$errors = $this->©errors();

									if($error) // Did we get an error?
										$errors->add(__METHOD__, get_defined_vars(), $error);

									// Handle return values.

									if($return_errors && $errors->exist())
										return $errors;

									if($return_array)
										{
											return array(
												'output' => $output,
												'error'  => $error,
												'errors' => $errors,
												'status' => $status
											);
										}
									return $output;
								}
						}

					// Handle errors.

					$errors = $this->©error(
						__METHOD__, array('args' => func_get_args()),
						($error = $this->i18n('Command not possible.'))
					);

					// Handle return values.

					if($return_errors)
						return $errors;

					if($return_array)
						{
							return array(
								'output' => '',
								'error'  => $error,
								'errors' => $errors,
								'status' => -1
							);
						}
					return '';
				}

			/**
			 * A utility method for easier GIT interaction.
			 *
			 * @param string $args Command and arguments; or only the arguments.
			 *    It is NOT necessary to prefix this with `git`; this routine will handle this automatically.
			 *    If you do pass `git`; it will be removed automatically and replaced with ``$this->git``.
			 *
			 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
			 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
			 *
			 * @return string The output from GIT; always a string.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception Only if GIT returns a non-zero status. We ignore GIT error messages;
			 *    because GIT writes its progress to STDERR. Thus, it really should NOT be used to determine status.
			 */
			public function git($args, $cwd_repo_dir)
				{
					$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

					$cwd_repo_dir = $this->©dir->n_seps($cwd_repo_dir);
					// Manipulate path arguments; we need all of them to be relative to the repo directory.
					$args = preg_replace('/\/+/', '/', str_replace(array(DIRECTORY_SEPARATOR, '\\', '/'), '/', $args));
					$args = str_ireplace($cwd_repo_dir.'/', '', $args);

					$git_args = $this->git.' '.preg_replace('/^'.preg_quote($this->git, '/').'\s+/', '', $args);
					$git      = $this->exec($git_args, '', TRUE, FALSE, $cwd_repo_dir);

					$git_status = $git['status'];
					$git_errors = $git['errors'];
					/** @var errors $git_errors */

					if($git_status !== 0)
						throw $this->©exception(
							__METHOD__.'#issue', get_defined_vars(),
							sprintf($this->i18n('The command: `%1$s`, returned a non-zero status: `%2$s`. Git said: `%3$s`'),
							        $git_args, $git_status, $git_errors->get_message())
						);
					return $git['output'];
				}

			/**
			 * Gets current GIT branch for a given repo directory.
			 *
			 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
			 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
			 *
			 * @return string The current branch name; else an exception is thrown.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If GIT returns a non-zero status; or an error message.
			 * @throws exception If unable to acquire the current GIT branch name.
			 */
			public function git_current_branch($cwd_repo_dir)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(!($branch = trim($this->git(($args = 'rev-parse --abbrev-ref HEAD'), $cwd_repo_dir))))
						throw $this->©exception(
							__METHOD__.'#issue', get_defined_vars(),
							sprintf($this->i18n('Unable to acquire current GIT branch name for repo directory: `%1$s`.'), $cwd_repo_dir)
						);
					return $branch;
				}

			/**
			 * Gets current GIT branches for a given repo directory.
			 *
			 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
			 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
			 *
			 * @return array The current branches; else an exception is thrown.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If GIT returns a non-zero status; or an error message.
			 * @throws exception If unable to acquire the current GIT branches.
			 */
			public function git_current_branches($cwd_repo_dir)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(!($branches = trim($this->git(($args = 'branch'), $cwd_repo_dir))))
						throw $this->©exception(
							__METHOD__.'#issue', get_defined_vars(),
							sprintf($this->i18n('Unable to acquire current GIT branches for repo directory: `%1$s`.'), $cwd_repo_dir)
						);
					$branches = preg_split('/[\*'."\r\n".']+/', $branches, NULL, PREG_SPLIT_NO_EMPTY);
					$branches = $this->©array->remove_empty_values_deep($this->©strings->trim_deep($branches));

					foreach($branches as &$_branch) // Cleanup symbolic reference pointers.
						if(strpos($_branch, '->') !== FALSE)
							$_branch = trim(strstr($_branch, '->', TRUE));
					unset($_branch); // Housekeeping.

					return $branches;
				}

			/**
			 * Gets latest GIT branch for a given repo directory.
			 *
			 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
			 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
			 *
			 * @return string The latest branch; else the `master` branch.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If GIT returns a non-zero status; or an error message.
			 */
			public function git_latest_branch($cwd_repo_dir)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					$branches = $this->git_current_branches($cwd_repo_dir);

					usort($branches, 'version_compare');

					if(($latest = array_pop($branches)))
						return $latest;

					return 'master'; // Default value.
				}

			/**
			 * Gets latest GIT dev branch for a given repo directory.
			 *
			 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
			 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
			 *
			 * @return string The latest dev branch; else the `master` branch.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If GIT returns a non-zero status; or an error message.
			 */
			public function git_latest_dev_branch($cwd_repo_dir)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					$branches = $this->git_current_branches($cwd_repo_dir);

					foreach($branches as $_key => $_branch)
						if(!preg_match('/\-dev$/i', $_branch))
							unset($branches[$_key]);
					unset($_key, $_branch); // Housekeeping.

					usort($branches, 'version_compare');

					if(($latest = array_pop($branches)))
						return $latest;

					return 'master'; // Default value.
				}

			/**
			 * Gets latest GIT stable branch for a given repo directory.
			 *
			 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
			 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
			 *
			 * @return string The latest stable branch; else the `master` branch.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If GIT returns a non-zero status; or an error message.
			 */
			public function git_latest_stable_branch($cwd_repo_dir)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					$branches = $this->git_current_branches($cwd_repo_dir);

					foreach($branches as $_key => $_branch)
						if(FALSE !== strpos($_branch, '-'))
							if(!preg_match('/\-stable$/i', $_branch))
								unset($branches[$_key]);
					unset($_key, $_branch); // Housekeeping.

					usort($branches, 'version_compare');

					if(($latest = array_pop($branches)))
						return $latest;

					return 'master'; // Default value.
				}
		}
	}