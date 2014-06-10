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
 *
 * @note This compiler requires that you have SASS installed.
 *    e.g. `brew install sass`
 *
 * @note This compiler requires that you have the YUI Compressor installed also.
 *    e.g. `brew install yuicompressor`
 */
namespace websharks_core_dev_utilities
{
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/.dev-utilities/core.php';
	compile(!empty($GLOBALS['argv'][1]) && $GLOBALS['argv'][1] === 'all');

	/*
	 * Compile
	 */
	function compile($all = FALSE)
	{
		$core = core(); // Core.
		$core->©env->prep_for_cli_dev_procedure();

		if($all) compile_font_awesome();
		if($all) compile_bootstrap_themes();

		ob_start(); // Open a PHP output buffer.
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-resets.min.css')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-utilities.min.css')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-fa.min.css')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core.min.css')."\n";
		file_put_contents($core->©dir->n_seps_up(__FILE__).'/core-libs.min.css', trim(ob_get_clean()));
	}

	/*
	 * Font Awesome Compiler
	 */
	function compile_font_awesome()
	{
		$core                    = core(); // WebSharks™ Core.
		$core_prefix_with_dashes = $core->___instance_config->core_prefix_with_dashes;

		$file     = $core->©dir->n_seps_up(__FILE__).'/core-fa.css';
		$min_file = $core->©dir->n_seps_up(__FILE__).'/core-fa.min.css';

		$file_dir     = $core->©dir->n_seps_up($file);
		$min_file_dir = $core->©dir->n_seps_up($min_file);
		if(!is_dir($file_dir)) mkdir($file_dir, 0755, TRUE);
		if(!is_dir($min_file_dir)) mkdir($min_file_dir, 0755, TRUE);

		$css = file_get_contents('http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
		$css = str_replace('../fonts/', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/fonts/', $css);
		$css = preg_replace('/@(?:[\w\-]+?\-)?viewport\s*(\{(?:[^{}]|(?1))*?\})/is', '', $css);
		$css = str_replace('FontAwesome', $core_prefix_with_dashes.'FontAwesome', $css);

		$imports             = array(); // Initialize array of @imports.
		$css                 = preg_replace_callback('/^@import\W[^;]*;/i', function ($m) use (&$imports)
		{
			$imports[] = $m[0];
			return ''; // Remove.
		}, $css); // Move to top.
		$css                 = implode("\n", $imports)."\n".
		                       '.'.trim($core_prefix_with_dashes, '-').'{'."\n".
		                       ' '.trim($css)."\n".
		                       '}';
		$font_face_tokenizer = font_face_tokenizer($css);
		$css                 = $font_face_tokenizer['css'];
		$keyframes_tokenizer = keyframes_tokenizer($css);
		$css                 = $keyframes_tokenizer['css'];

		file_put_contents($file, $css); // Save to file & Sassify.
		$core->©command->sass('--scss '.escapeshellarg($file).' '.escapeshellarg($file));
		$css = file_get_contents($file);

		$css = font_face_tokenizer($css, $font_face_tokenizer['tokens']);
		$css = keyframes_tokenizer($css, $keyframes_tokenizer['tokens']);

		file_put_contents($file, $css); // Save to file & compress.
		$core->©command->yuic('--type="css" -o '.escapeshellarg($min_file).' '.escapeshellarg($file));
		$core->©file->delete($file); // We only need to keep the `.min.css` file.
	}

	/*
	 * Bootstrap Themes Compiler
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
			$core                    = core(); // WebSharks™ Core.
			$core_prefix_with_dashes = $core->___instance_config->core_prefix_with_dashes;

			$file     = $core->©dir->n_seps_up(__FILE__, 3).'/templates/client-side/styles/themes/'.$slug.'/theme.css';
			$min_file = $core->©dir->n_seps_up(__FILE__, 3).'/templates/client-side/styles/themes/'.$slug.'/theme.min.css';

			$file_dir     = $core->©dir->n_seps_up($file);
			$min_file_dir = $core->©dir->n_seps_up($min_file);
			if(!is_dir($file_dir)) mkdir($file_dir, 0755, TRUE);
			if(!is_dir($min_file_dir)) mkdir($min_file_dir, 0755, TRUE);

			$css = file_get_contents($url);
			$css = preg_replace('/\.dropdown\-backdrop\b/', '.'.$core_prefix_with_dashes.'dropdown-backdrop', $css);
			$css = preg_replace('/\[data\-dismiss\=(["\'])?/', '[data-dismiss=${1}'.$core_prefix_with_dashes, $css);
			$css = preg_replace('/\[data\-toggle\=(["\'])?/', '[data-toggle=${1}'.$core_prefix_with_dashes, $css);
			$css = preg_replace('/\[data\-spy\=(["\'])?/', '[data-spy=${1}'.$core_prefix_with_dashes, $css);
			$css = str_replace('../fonts/', '//netdna.bootstrapcdn.com/bootswatch/3.1.1/fonts/', $css);
			$css = preg_replace('/@(?:[\w\-]+?\-)?viewport\s*(\{(?:[^{}]|(?1))*?\})/is', '', $css);

			$imports             = array(); // Initialize array of @imports.
			$css                 = preg_replace_callback('/^@import\W[^;]*;/i', function ($m) use (&$imports)
			{
				$imports[] = $m[0];
				return ''; // Remove.
			}, $css); // Move to top.
			$css                 = implode("\n", $imports)."\n".
			                       '.'.$core_prefix_with_dashes.$slug.'{'."\n".
			                       ' '.trim($css)."\n".
			                       '}';
			$font_face_tokenizer = font_face_tokenizer($css);
			$css                 = $font_face_tokenizer['css'];
			$keyframes_tokenizer = keyframes_tokenizer($css);
			$css                 = $keyframes_tokenizer['css'];

			file_put_contents($file, $css); // Save to file & Sassify.
			$core->©command->sass('--scss '.escapeshellarg($file).' '.escapeshellarg($file));
			$css = file_get_contents($file);

			$css = preg_replace('/'.preg_quote('.'.$core_prefix_with_dashes.$slug, '/').'\s+(?:html|body)\s+{/i', '.'.$core_prefix_with_dashes.$slug.' {', $css);
			$css = preg_replace('/'.preg_quote('.'.$core_prefix_with_dashes.$slug, '/').'\s+.modal\-open\s+{/i', '.'.$core_prefix_with_dashes.'modal-open {', $css);
			$css = preg_replace('/'.preg_quote('.'.$core_prefix_with_dashes.$slug, '/').'\s+.modal\-backdrop\s+{/i', '.'.$core_prefix_with_dashes.'modal-backdrop {', $css);
			$css = preg_replace('/'.preg_quote('.'.$core_prefix_with_dashes.$slug, '/').'\s+.modal\-backdrop\.in\s+{/i', '.'.$core_prefix_with_dashes.'modal-backdrop.in {', $css);

			$css = font_face_tokenizer($css, $font_face_tokenizer['tokens']);
			$css = keyframes_tokenizer($css, $keyframes_tokenizer['tokens']);

			file_put_contents($file, $css); // Save to file & compress.
			$core->©command->yuic('--type="css" -o '.escapeshellarg($min_file).' '.escapeshellarg($file));
			$core->©file->delete($file); // We only need to keep the `.min.css` file.
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
			$core                    = core(); // WebSharks™ Core.
			$tokens                  = array(); // Initialize the array of tokens.
			$animations              = array(); // Initialize the array of CSS animations.
			$core_prefix_with_dashes = $core->___instance_config->core_prefix_with_dashes;
			$css                     = preg_replace_callback('/(?P<keyframes>@(?:[\w\-]+?\-)?keyframes)\s*(?P<animation>[\w\-]+)\s*(?P<brackets>\{(?:[^{}]|(?&brackets))*?\})/is', function ($m) use (&$tokens, &$animations, $core_prefix_with_dashes)
			{
				$animations[$m['animation']] = $core_prefix_with_dashes.$m['animation'];
				$tokens[]                    = $m['keyframes'].' '.$animations[$m['animation']].' '.$m['brackets'];
				return '@keyframes _ { content: "token-'.(count($tokens) - 1).'"; }';
			}, $css);
			foreach($animations as $_animation => $_animation_rewrite)
				$css = preg_replace('/\b(?P<animation>animation(?:\-name)?)\s*\:\s*(?P<shorthand>[\w\-]+?\s+)?'.preg_quote($_animation, '/').'\b/i', '${1}:${2}'.$_animation_rewrite, $css);
			unset($_animation, $_animation_rewrite);

			return compact('css', 'tokens');
		}
	}
}