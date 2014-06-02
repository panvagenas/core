#!/usr/bin/env php
<?php
/**
 * WebSharks™ Core Styles (Compiler)
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
require_once $_SERVER['WEBSHARK_HOME'].'/WebSharks/websharks-core/.~dev-utilities/core.php';
websharks_core()->©env->prep_for_cli_dev_procedure();

/*
 * Font Awesome Compiler
 */

function compile_font_awesome()
{
	$core_prefix = websharks_core()->___instance_config->core_prefix_with_dashes;
	$file        = dirname(__FILE__).'/core-fa.scss';
	if(!is_dir(dirname($file))) mkdir(dirname($file), 0755, TRUE);

	$css = file_get_contents('http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
	$css = str_replace('../fonts/', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/fonts/', $css);
	$css = preg_replace('/@(?:[\w\-]+?\-)?viewport\s*(\{(?:[^{}]|(?1))*?\})/is', '', $css);
	$css = str_replace('FontAwesome', $core_prefix.'FontAwesome', $css);

	$imports             = array(); // Initialize array of @imports.
	$css                 = preg_replace_callback('/^@import\W[^;]*;/i', function ($m) use (&$imports)
	{
		$imports[] = $m[0];
		return ''; // Remove.
	}, $css); // Move to top.
	$css                 = implode("\n", $imports)."\n".
	                       '.'.$core_prefix.'ui{'."\n".
	                       ' '.trim($css)."\n".
	                       '}';
	$font_face_tokenizer = font_face_tokenizer($css);
	$css                 = $font_face_tokenizer['css'];
	$keyframes_tokenizer = keyframes_tokenizer($css);
	$css                 = $keyframes_tokenizer['css'];

	file_put_contents($file, $css);
	shell_exec('sass '.escapeshellarg($file).' '.escapeshellarg($file));
	$css = file_get_contents($file);

	$css = font_face_tokenizer($css, $font_face_tokenizer['tokens']);
	$css = keyframes_tokenizer($css, $keyframes_tokenizer['tokens']);

	file_put_contents($file, $css);
	shell_exec('compress-css '.escapeshellarg($file));
	unlink($file); // Keep `.min.css` file only.
}

/*
 * Bootstrap Themes
 */

function compile_bootstrap_themes()
{
	$themes = array
	( // <http://www.bootstrapcdn.com/?theme=1#bootswatch_tab>
	  'amelia'    => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/amelia/bootstrap.min.css',
	  'cerulean'  => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/cerulean/bootstrap.min.css',
	  'cosmo'     => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/cosmo/bootstrap.min.css',
	  'cyborg'    => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/cyborg/bootstrap.min.css',
	  'flatly'    => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/flatly/bootstrap.min.css',
	  'journal'   => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/journal/bootstrap.min.css',
	  'lumen'     => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/lumen/bootstrap.min.css',
	  'readable'  => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/readable/bootstrap.min.css',
	  'simplex'   => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/simplex/bootstrap.min.css',
	  'slate'     => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/slate/bootstrap.min.css',
	  'spacelab'  => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/spacelab/bootstrap.min.css',
	  'superhero' => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/superhero/bootstrap.min.css',
	  'united'    => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/united/bootstrap.min.css',
	  'yeti'      => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/yeti/bootstrap.min.css',
	  'darkly'    => 'http://netdna.bootstrapcdn.com/bootswatch/3.1.1/darkly/bootstrap.min.css',
	);
	foreach($themes as $slug => $url)
	{
		$core_prefix = websharks_core()->___instance_config->core_prefix_with_dashes;
		$file        = dirname(__FILE__).'/themes/'.$slug.'/theme.scss';
		if(!is_dir(dirname($file))) mkdir(dirname($file), 0755, TRUE);

		$css = file_get_contents($url);
		$css = str_replace('[data-', '[data-'.$core_prefix, $css);
		$css = str_replace('../fonts/', '//netdna.bootstrapcdn.com/bootswatch/3.1.1/fonts/', $css);
		$css = preg_replace('/@(?:[\w\-]+?\-)?viewport\s*(\{(?:[^{}]|(?1))*?\})/is', '', $css);

		$imports             = array(); // Initialize array of @imports.
		$css                 = preg_replace_callback('/^@import\W[^;]*;/i', function ($m) use (&$imports)
		{
			$imports[] = $m[0];
			return ''; // Remove.
		}, $css); // Move to top.
		$css                 = implode("\n", $imports)."\n".
		                       '.'.$core_prefix.'ui-'.$slug.'{'."\n".
		                       ' '.trim($css)."\n".
		                       '}';
		$font_face_tokenizer = font_face_tokenizer($css);
		$css                 = $font_face_tokenizer['css'];
		$keyframes_tokenizer = keyframes_tokenizer($css);
		$css                 = $keyframes_tokenizer['css'];

		file_put_contents($file, $css);
		shell_exec('sass '.escapeshellarg($file).' '.escapeshellarg($file));
		$css = file_get_contents($file);

		$css = preg_replace('/'.preg_quote('.'.$core_prefix.'ui-'.$slug, '/').'\s+(?:html|body)\s+{/i',
		                    '.'.$core_prefix.'ui-'.$slug.' {', $css);

		$css = font_face_tokenizer($css, $font_face_tokenizer['tokens']);
		$css = keyframes_tokenizer($css, $keyframes_tokenizer['tokens']);

		file_put_contents($file, $css);
		shell_exec('compress-css '.escapeshellarg($file));
		unlink($file); // Keep `.min.css` file only.
	}
}

/*
 * Tokenizers / Utilities
 */

function font_face_tokenizer($css, $tokens = NULL)
{
	if(is_array($tokens)) // Untokenize.
	{
		return preg_replace_callback('/(?P<font_face>@(?:[\w\-]+?\-)?font\-face)\s*(?P<brackets>\{(?:[^{}]|(?&brackets))*?\})/is', function ($m) use (&$tokens)
		{
			if(preg_match('/\{\s*content\s*\:\s*(["\'])token\-(?P<token>[0-9]+)(\\1)\s*;?\s*\}/i', $m['brackets'], $c))
				if(isset($tokens[$c['token']])) return $tokens[$c['token']];
			return $m[0];
		}, $css);
	}
	else // Else we need to tokenize (default behavior).
	{
		$tokens = array(); // Initialize the array of tokens.
		$css    = preg_replace_callback('/(?P<font_face>@(?:[\w\-]+?\-)?font\-face)\s*(?P<brackets>\{(?:[^{}]|(?&brackets))*?\})/is', function ($m) use (&$tokens)
		{
			$tokens[] = $m['font_face'].' '.$m['brackets'];
			return '@font-face { content: "token-'.(count($tokens) - 1).'"; }';
		}, $css);
		return compact('css', 'tokens');
	}
}

function keyframes_tokenizer($css, $tokens = NULL)
{
	if(is_array($tokens)) // Untokenize.
	{
		return preg_replace_callback('/(?P<keyframes>@(?:[\w\-]+?\-)?keyframes)\s*(?P<animation>[\w\-]+)\s*(?P<brackets>\{(?:[^{}]|(?&brackets))*?\})/is', function ($m) use (&$tokens)
		{
			if(preg_match('/\{\s*content\s*\:\s*(["\'])token\-(?P<token>[0-9]+)(\\1)\s*;?\s*\}/i', $m['brackets'], $c))
				if(isset($tokens[$c['token']])) return $tokens[$c['token']];
			return $m[0];
		}, $css);
	}
	else // Else we need to tokenize (default behavior).
	{
		$tokens      = array(); // Initialize the array of tokens.
		$animations  = array(); // Initialize the array of CSS animations.
		$core_prefix = websharks_core()->___instance_config->core_prefix_with_dashes;
		$css         = preg_replace_callback('/(?P<keyframes>@(?:[\w\-]+?\-)?keyframes)\s*(?P<animation>[\w\-]+)\s*(?P<brackets>\{(?:[^{}]|(?&brackets))*?\})/is', function ($m) use (&$tokens, &$animations, $core_prefix)
		{
			$animations[$m['animation']] = $core_prefix.$m['animation'];
			$tokens[]                    = $m['keyframes'].' '.$animations[$m['animation']].' '.$m['brackets'];
			return '@keyframes _ { content: "token-'.(count($tokens) - 1).'"; }';
		}, $css);
		foreach($animations as $_animation => $_animation_rewrite)
			$css = preg_replace('/\b(?P<animation>animation(?:\-name)?)\s*\:\s*(?P<shorthand>[\w\-]+?\s+)?'.preg_quote($_animation, '/').'\b/i', '${1}:${2}'.$_animation_rewrite, $css);
		unset($_animation, $_animation_rewrite);

		return compact('css', 'tokens');
	}
}

/*
 * Core Libs
 */

compile_font_awesome();
compile_bootstrap_themes();

ob_start(); // Begin compilation.
echo file_get_contents(dirname(__FILE__).'/core-resets.min.css')."\n";
echo file_get_contents(dirname(__FILE__).'/core.min.css')."\n";
echo file_get_contents(dirname(__FILE__).'/core-fa.min.css')."\n";
file_put_contents(dirname(__FILE__).'/core-libs.min.css', trim(ob_get_clean()));