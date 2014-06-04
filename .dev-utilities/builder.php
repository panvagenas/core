<?php
/**
 * Builder.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 */
namespace websharks_core_dev_utilities
{
	/**
	 * @var boolean Marker.
	 */
	define('___BUILDER', TRUE);

	/*
	 * Check Dev Key for authorization.
	 */
	require_once dirname(__FILE__).'/dev-key.php';

	/*
	 * Load WebSharks™ Core w/ WordPress®.
	 */
	require_once dirname(__FILE__).'/core.php';

	/*
	 * Load plugin file (if applicable).
	 */
	require_once dirname(__FILE__).'/plugin.php';

	/*
	 * Pre for CLI development procedure.
	 */
	core()->©env->prep_for_cli_dev_procedure();

	/*
	 * Get command-line arguments (and validate).
	 */
	${__FILE__}['argv'] = core()->©vars->_SERVER('argv');

	if(!is_array(${__FILE__}['argv']) || count(${__FILE__}['argv']) !== 15)
		throw core()->©exception(
			'missing_command_line_args', get_defined_vars(),
			core()->__('Missing command line args (should have `15`).')
		);
	foreach(${__FILE__}['argv'] as ${__FILE__}['_key'] => &${__FILE__}['_arg'])
		if(${__FILE__}['_key'] > 0 && is_string(${__FILE__}['_arg']) && strpos(${__FILE__}['_arg'], '%') !== FALSE)
		{
			${__FILE__}['_arg'] = str_ireplace('%YYMMDD%', date('ymd'), ${__FILE__}['_arg']);
			${__FILE__}['_arg'] = str_ireplace(array('%true%', '%on%', '%yes%'), array('true', 'on', 'yes'), ${__FILE__}['_arg']);
			${__FILE__}['_arg'] = str_ireplace(array('%false%', '%off%', '%no%'), array('false', 'off', 'no'), ${__FILE__}['_arg']);
		}
	unset(${__FILE__}['_key'], ${__FILE__}['_arg']);

	/*
	 * Establish some important working variables (and validate).
	 */
	${__FILE__}['core_repo_dir']            = core()->___instance_config->local_core_repo_dir;
	${__FILE__}['core_ns_stub_with_dashes'] = core()->___instance_config->core_ns_stub_with_dashes;
	${__FILE__}['building']                 = core()->©string->is_not_empty(${__FILE__}['argv'][1]) ? 'plugin' : 'core';

	${__FILE__}['current_core_version_branch']                  = core()->©command->git_current_branch(${__FILE__}['core_repo_dir']);
	${__FILE__}['current_core_version_branch_with_underscores'] = core()->©string->with_underscores(${__FILE__}['current_core_version_branch']);
	${__FILE__}['current_core_version_branch_with_dashes']      = core()->©string->with_dashes(${__FILE__}['current_core_version_branch']);

	if(!core()->©string->is_plugin_version(${__FILE__}['current_core_version_branch']))
		throw core()->©exception(
			'current_core_version_branch_not_a_version', get_defined_vars(),
			sprintf(core()->__('Invalid current core version branch: `%1$s`.'), ${__FILE__}['current_core_version_branch']).
			' '.core()->__('This is NOT a valid core/plugin version branch. Please check and try again.')
		);
	${__FILE__}['build_from_core_version_branch'] = core()->©string->is_not_empty_or(${__FILE__}['argv'][14], '');
	if(!${__FILE__}['build_from_core_version_branch']) // Defaults to the latest stable release of the WebSharks™ Core.
		${__FILE__}['build_from_core_version_branch'] = core()->©command->git_latest_plugin_stable_version_branch(${__FILE__}['core_repo_dir']);

	if(!core()->©string->is_plugin_version(${__FILE__}['build_from_core_version_branch']))
		throw core()->©exception(
			'build_from_core_version_branch_not_a_version', get_defined_vars(),
			sprintf(core()->__('Cannot build from core version branch: `%1$s`.'), ${__FILE__}['build_from_core_version_branch']).
			' '.core()->__('This is NOT a valid core/plugin version branch. Please check and try again.')
		);
	${__FILE__}['build_from_core_version_branch_with_underscores'] = core()->©string->with_underscores(${__FILE__}['build_from_core_version_branch']);
	${__FILE__}['build_from_core_version_branch_with_dashes']      = core()->©string->with_dashes(${__FILE__}['build_from_core_version_branch']);
	${__FILE__}['build_from_core_ns']                              = core()->___instance_config->core_ns_stub_v.${__FILE__}['build_from_core_version_branch_with_underscores'];
	${__FILE__}['build_from_core_ns_with_dashes']                  = core()->©string->with_dashes(${__FILE__}['build_from_core_ns']);

	/*
	 * Uncommitted changes (and/or untracked & unignored files)?
	 */
	if(core()->©command->git_changes_exist(${__FILE__}['core_repo_dir']))
		throw core()->©exception(
			'changes_exist_in_current_core_version_branch', get_defined_vars(),
			sprintf(core()->__('Changes exist in current core version branch: `%1$s`.'), ${__FILE__}['current_core_version_branch']).
			' '.core()->__('Please commit changes and/or resolve untracked files in the current version branch before building.')
		);

	/*
	 * Make sure we're on the correct version branch (we do a checkout if necessary).
	 */
	if(${__FILE__}['current_core_version_branch'] !== ${__FILE__}['build_from_core_version_branch'])
	{
		core()->©command->git('checkout '.escapeshellarg(${__FILE__}['build_from_core_version_branch']), ${__FILE__}['core_repo_dir']);

		// Do NOT call upon the WebSharks™ Core again until we've included (required) all files below.
		// The old version is NO longer capable of loading its class files; the current file structure has changed now.
		// From this point on we MUST use this syntax: `core(${__FILE__}['build_from_core_version_branch'])`.

		$GLOBALS['autoload_'.${__FILE__}['build_from_core_ns']] = FALSE; // We'll load (require) files explicitly here.
		require ${__FILE__}['core_repo_dir'].'/'.${__FILE__}['core_ns_stub_with_dashes'].'/stub.php'; // Do NOT to use `require_once` w/ stub file.
		require_once ${__FILE__}['core_repo_dir'].'/'.${__FILE__}['core_ns_stub_with_dashes'].'/classes/'.${__FILE__}['build_from_core_ns_with_dashes'].'/deps.php';
		require_once ${__FILE__}['core_repo_dir'].'/'.${__FILE__}['core_ns_stub_with_dashes'].'/classes/'.${__FILE__}['build_from_core_ns_with_dashes'].'/framework.php';

		if(core(${__FILE__}['build_from_core_version_branch'])->©command->git_changes_exist(${__FILE__}['core_repo_dir']))
			throw core(${__FILE__}['build_from_core_version_branch'])->©exception(
				'changes_exist_in_build_from_core_version_branch', get_defined_vars(),
				sprintf(core(${__FILE__}['build_from_core_version_branch'])->__('Changes exist; cannot build from core version branch: `%1$s`.'), ${__FILE__}['build_from_core_version_branch']).
				' '.core(${__FILE__}['build_from_core_version_branch'])->__('Please commit changes and/or resolve untracked files in this core version branch before building from it.')
			);
	}
	/*
	 * Process build routines w/ `core(${__FILE__}['build_from_core_version_branch'])`.
	 */
	echo core(${__FILE__}['build_from_core_version_branch'])->__('Processing build routines...')."\n\n";

	echo core(${__FILE__}['build_from_core_version_branch'])->©build(
		${__FILE__}['argv'][1], ${__FILE__}['argv'][2], ${__FILE__}['argv'][3], ${__FILE__}['argv'][4],
		${__FILE__}['argv'][5], ${__FILE__}['argv'][6], ${__FILE__}['argv'][7], ${__FILE__}['argv'][8],
		${__FILE__}['argv'][9], ${__FILE__}['argv'][10], ${__FILE__}['argv'][11], ${__FILE__}['argv'][12],
		${__FILE__}['argv'][13], ${__FILE__}['argv'][14]
	)->successes->get_messages_as_list('', 125);
}