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
		 * Are command line operations possible?
		 *
		 * @return boolean TRUE if commands are possible, else FALSE.
		 *
		 * @assert () === TRUE
		 */
		public function possible()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->©function->is_possible('exec')
			   && $this->©function->is_possible('shell_exec')
			   && $this->©function->is_possible('proc_open')
			) $this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
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
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && $this->©env->is_unix())
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
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
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && $this->©env->is_windows())
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
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
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && is_array($java = $this->exec($this->java.' -version', '', TRUE)))
				if($java['status'] === 0 && stripos($java['output'], 'error') === FALSE && stripos($java['output'], 'version') !== FALSE)
					$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
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
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && is_array($git = $this->exec($this->git.' --version', '', TRUE)))
				if($git['status'] === 0 && stripos($git['output'], 'error') === FALSE && stripos($git['output'], 'version') !== FALSE)
					$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
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
		 *    ~ And, of course, also based on the argument values: `$return_array`, `$return_errors`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @assert // Test development server.
		 *    ('whoami') === 'websharks-inc.com'
		 */
		public function exec($cmd_args, $stdin = '', $return_array = FALSE, $return_errors = FALSE, $cwd = '', $env = array(), $other = array())
		{
			$this->check_arg_types('string:!empty', 'string', 'boolean', 'boolean',
			                       array('string', 'null'), array('array', 'null'), array('array', 'null'), func_get_args());

			// Bypass each of these in the `proc_open()` call with NULL values (if they are empty).

			$cwd   = $this->©var->is_not_empty_or($cwd, NULL);
			$env   = $this->©var->is_not_empty_or($env, NULL);
			$other = $this->©var->is_not_empty_or($other, NULL);

			$specs  = array( // Configure file descriptor specifications.
			                 0 => array('pipe', 'r'), // Input pipe for command to read input from (for us to write to).
			                 1 => array('pipe', 'w'), // Output pipe for command to write its output to (for us to read from).
			                 2 => array('pipe', 'w') // Error output pipe for command to write its errors to (for us to read from).
			);
			$errors = $this->©errors(); // Initialize an errors object instance.

			if(!$this->possible() || !is_resource($_process = proc_open($cmd_args, $specs, $_pipes, $cwd, $env, $other)))
			{
				$error = (!$this->possible()) ? $this->__('Commands are NOT possible on this server.')
					: $this->__('Unable to acquire a `proc_open()` resource.');

				$errors->add($this->method(__FUNCTION__), get_defined_vars(), $error);

				if($return_errors)
					return $errors;

				if($return_array)
					return array(
						'output' => '',
						'error'  => $error,
						'errors' => $errors,
						'status' => -1
					);
				return ''; // Default return value (failure).
			}
			if(strlen($stdin))
				fwrite($_pipes[0], $stdin);
			fclose($_pipes[0]); // Close pipe.

			$output = trim((string)stream_get_contents($_pipes[1]));
			fclose($_pipes[1]); // Close pipe.

			$error = trim((string)stream_get_contents($_pipes[2]));
			fclose($_pipes[2]); // Close pipe.

			$status = (integer)proc_close($_process);
			unset($_process, $_pipes);

			if($error) // Did we get an error?
				$errors->add($this->method(__FUNCTION__), get_defined_vars(), $error);

			if($return_errors && $errors->exist())
				return $errors;

			if($return_array)
				return array(
					'output' => $output,
					'error'  => $error,
					'errors' => $errors,
					'status' => $status
				);
			return $output; // Default return value (string).
		}

		/**
		 * A utility method for easier GIT interaction.
		 *
		 * @param string  $args Command and arguments; or only the arguments.
		 *    It is NOT necessary to prefix this with `git`; this routine will handle this automatically.
		 *    If you do pass `git`; it will be removed automatically and replaced with `$this->git`.
		 *
		 * @param string  $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @param boolean $return_array Return full array? Defaults to FALSE. If TRUE, this method will return an array with all connection details.
		 *    The default behavior of this function is to simply return a string that contains any output received from the command line routine.
		 *
		 * @return string|array The output from GIT; always a string. However, this will thrown an exception if GIT returns a non-zero status.
		 *    If `$return_array` is TRUE, we simply return the full array of connection details, regardless of what GIT returns.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception Only if `$return_array` is FALSE; and GIT returns a non-zero status.
		 *    We ignore GIT error messages; because GIT writes its progress to STDERR.
		 *    Thus, STDERR really should NOT be used to determine GIT status.
		 */
		public function git($args, $cwd_repo_dir, $return_array = FALSE)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'boolean', func_get_args());

			$cwd_repo_dir = $this->©dir->n_seps($cwd_repo_dir);
			$args         = preg_replace('/\/+/', '/', str_replace(array(DIRECTORY_SEPARATOR, '\\', '/'), '/', $args));
			$args         = str_ireplace($cwd_repo_dir.'/', '', $args);

			$git_args = $this->git.' '.preg_replace('/^'.preg_quote($this->git, '/').'\s+/', '', $args);
			$git      = $this->exec($git_args, '', TRUE, FALSE, $cwd_repo_dir);

			if($return_array) return $git; // Return array to caller?

			$git_status = $git['status'];
			$git_errors = $git['errors'];
			/** @var errors $git_errors */

			if($git_status !== 0)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#non_zero_status', get_defined_vars(),
					sprintf($this->__('The command: `%1$s`, returned a non-zero status: `%2$s`. Git said: `%3$s`'),
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
		 * @return string The current GIT branch; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to determine the current GIT branch.
		 */
		public function git_current_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(!($current_branch = trim($this->git('rev-parse --abbrev-ref HEAD', $cwd_repo_dir))))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#unable_to_determine', get_defined_vars(),
					sprintf($this->__('Unable to determine current branch in: `%1$s`.'), $cwd_repo_dir)
				);
			return $current_branch;
		}

		/**
		 * Gets an array of all GIT branches for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return array An array of all GIT branches; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire GIT branches.
		 */
		public function git_branches($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$branches = trim($this->git('branch', $cwd_repo_dir));
			$branches = preg_split('/['."\r\n".']+/', $branches, NULL, PREG_SPLIT_NO_EMPTY);
			$branches = $this->©strings->trim_deep($branches, '', '*');

			foreach($branches as &$_branch) // Cleanup symbolic reference pointers.
				if(strpos($_branch, '->') !== FALSE) $_branch = trim(strstr($_branch, '->', TRUE));
			unset($_branch); // Housekeeping.

			$branches = $this->©strings->trim_deep($branches);
			$branches = $this->©array->remove_empty_values_deep($branches);

			if(!$branches)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_branches', get_defined_vars(),
					sprintf($this->__('No branches in: `%1$s`.'), $cwd_repo_dir)
				);
			return $branches;
		}

		/**
		 * Gets an array of all GIT version branches for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return array An array of all GIT version branches; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire GIT version branches.
		 */
		public function git_version_branches($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$branches = $this->git_branches($cwd_repo_dir);

			foreach($branches as $_branch) // Version branches.
				if($this->©string->is_version($_branch))
					$version_branches[] = $_branch;
			unset($_branch); // Housekeeping.

			if(empty($version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_version_branches', get_defined_vars(),
					sprintf($this->__('No version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			return $version_branches;
		}

		/**
		 * Gets an array of all GIT plugin version branches for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return array An array of all GIT plugin version branches; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire GIT plugin version branches.
		 */
		public function git_plugin_version_branches($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$branches = $this->git_branches($cwd_repo_dir);

			foreach($branches as $_branch) // Plugin version branches.
				if($this->©string->is_plugin_version($_branch))
					$plugin_version_branches[] = $_branch;
			unset($_branch); // Housekeeping.

			if(empty($plugin_version_branches)) // No plugin version branches?
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_plugin_version_branches', get_defined_vars(),
					sprintf($this->__('No plugin version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			return $plugin_version_branches;
		}

		/**
		 * Gets latest GIT version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest GIT version branch; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire GIT version branches.
		 */
		public function git_latest_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$version_branches = $this->git_version_branches($cwd_repo_dir);

			usort($version_branches, 'version_compare');

			return array_pop($version_branches);
		}

		/**
		 * Gets latest GIT plugin version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest GIT plugin version branch; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire GIT plugin version branches.
		 */
		public function git_latest_plugin_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$plugin_version_branches = $this->git_plugin_version_branches($cwd_repo_dir);

			usort($plugin_version_branches, 'version_compare');

			return array_pop($plugin_version_branches);
		}

		/**
		 * Gets latest GIT dev version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest GIT dev version branch.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire GIT version branches.
		 * @throws exception If there are no GIT dev version branches available.
		 */
		public function git_latest_dev_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$version_branches = $this->git_version_branches($cwd_repo_dir);

			foreach($version_branches as $_version_branch)
				if($this->©string->is_dev_version($_version_branch))
					$dev_version_branches[] = $_version_branch;
			unset($_version_branch); // Housekeeping.

			if(empty($dev_version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_dev_version_branches', get_defined_vars(),
					sprintf($this->__('No dev version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			usort($dev_version_branches, 'version_compare');

			return array_pop($dev_version_branches);
		}

		/**
		 * Gets latest GIT plugin dev version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest GIT plugin dev version branch.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire GIT plugin version branches.
		 * @throws exception If there are no GIT plugin dev version branches available.
		 */
		public function git_latest_plugin_dev_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$plugin_version_branches = $this->git_plugin_version_branches($cwd_repo_dir);

			foreach($plugin_version_branches as $_plugin_version_branch)
				if($this->©string->is_plugin_dev_version($_plugin_version_branch))
					$plugin_dev_version_branches[] = $_plugin_version_branch;
			unset($_plugin_version_branch); // Housekeeping.

			if(empty($plugin_dev_version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_plugin_dev_version_branches', get_defined_vars(),
					sprintf($this->__('No plugin dev version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			usort($plugin_dev_version_branches, 'version_compare');

			return array_pop($plugin_dev_version_branches);
		}

		/**
		 * Gets latest GIT stable version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest GIT stable version branch.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire GIT version branches.
		 * @throws exception If there are no GIT stable version branches available.
		 */
		public function git_latest_stable_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$version_branches = $this->git_version_branches($cwd_repo_dir);

			foreach($version_branches as $_version_branch)
				if($this->©string->is_stable_version($_version_branch))
					$stable_version_branches[] = $_version_branch;
			unset($_version_branch); // Housekeeping.

			if(empty($stable_version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_stable_version_branches', get_defined_vars(),
					sprintf($this->__('No stable version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			usort($stable_version_branches, 'version_compare');

			return array_pop($stable_version_branches);
		}

		/**
		 * Gets latest GIT plugin stable version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest GIT plugin stable version branch.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire GIT plugin version branches.
		 * @throws exception If there are no GIT plugin stable version branches available.
		 */
		public function git_latest_plugin_stable_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$plugin_version_branches = $this->git_plugin_version_branches($cwd_repo_dir);

			foreach($plugin_version_branches as $_plugin_version_branch)
				if($this->©string->is_plugin_stable_version($_plugin_version_branch))
					$plugin_stable_version_branches[] = $_plugin_version_branch;
			unset($_plugin_version_branch); // Housekeeping.

			if(empty($plugin_stable_version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_plugin_stable_version_branches', get_defined_vars(),
					sprintf($this->__('No plugin stable version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			usort($plugin_stable_version_branches, 'version_compare');

			return array_pop($plugin_stable_version_branches);
		}

		/**
		 * Any uncommitted changes (and/or untracked & unignored) files?
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which GIT will be called upon (i.e. the repo directory).
		 *
		 * @return boolean TRUE if there are any uncommitted changes (and/or untracked & unignored) files.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function git_changes_exist($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$porcelain = trim($this->git('status --porcelain', $cwd_repo_dir));

			return (strlen($porcelain)) ? TRUE : FALSE;
		}
	}
}