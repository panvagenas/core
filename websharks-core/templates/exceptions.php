<?
namespace websharks_core_v000000_dev;
/**
 * Template.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 *
 * @note All WordPress® template tags are available for use in this template.
 *    See: {@link http://codex.wordpress.org/Template_Tags}
 *    See: {@link http://codex.wordpress.org/Conditional_Tags}
 *
 * @var $static exception_handler Exception handler.
 * @var $exception exception|\exception Exception object instance.
 */
if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

$static     = get_class();
$exception  = $static::$exception;
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8" />
	<title><?= $static::translate('Uncaught Exception'); ?> | <?= esc_html(get_bloginfo('name')); ?></title>
	<style type="text/css">
		html, body
		{
			background  : #EEEEEE;
			font-family : 'Arial', sans-serif;
			font-size   : 14px;
		}
		a:link
		{
			color : #666666;
		}
		a:visited
		{
			color : #999999;
		}
		a:hover, a:active, a:focus
		{
			color : #000000;
		}
		div.header.wrapper
		{
			width      : 960px;
			text-align : center;
			margin     : 50px auto 10px auto;
		}
		div.content.wrapper
		{
			width         : 960px;
			margin        : 0 auto 0 auto;

			border-radius : 5px;
			background    : #FFFFFF;
			border        : 1px solid #CCCCCC;
			box-shadow    : 0 8px 6px -6px #999999;
		}
		div.content.wrapper div.content.container
		{
			padding : 20px;
		}
		h1
		{
			font-size     : 24px;
			font-weight   : normal;
			font-family   : 'Georgia', serif;

			margin        : 0 0 20px 0;
			padding       : 0 0 10px 0;
			border-bottom : 1px solid;
		}
		h3, p
		{
			margin : 0;
		}
		p + p
		{
			margin-top : 20px;
		}
		code, pre
		{
			font-family : 'Consolas', 'Courier New', monospace;
		}
		pre
		{
			max-width     : 100%;
			max-height    : 200px;
			overflow      : auto;

			border-radius : 3px;
			padding       : 10px;
			border        : 1px solid;

			white-space   : pre;

			color         : #FFFFFF;
			background    : #151515;
		}
	</style>
</head>
<body>

<div class="stand-alone wrapper">
	<div class="stand-alone container">

		<div class="header wrapper">
			<div class="header container">

			</div>
		</div>

		<div class="content wrapper">
			<div class="content container">

				<!-- BEGIN: Content Body -->
				<!-- ↑ For exception handler (leave intact). -->

				<a name="exception" class="anchor"></a>

				<h1><?= $static::translate('Uncaught Exception'); ?></h1>

				<h3>
					<?= $static::translate('Request failed w/ exception code:') ?>
				</h3>
				<p style="margin:0;">
					<code style="background:#FDFB76;"><?= esc_html($exception->getCode()); ?></code>
				</p>

				<? if((defined('WP_DEBUG') && WP_DEBUG) || is_super_admin()): ?>
					<p>
						<?= sprintf($static::i18n('Exception occurred at line # <code>%1$s</code> in: <code>%2$s</code>.'), esc_html($exception->getLine()), esc_html($exception->getFile())); ?>
					</p>

					<hr />

					<h3>
						<?= $static::i18n('Exception Message (Please Read)'); ?>
					</h3>
					<small><?= $static::i18n('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG</a> mode; and for all super administrators of the site.'); ?></small>
					<pre><?= esc_html($exception->getMessage()); ?></pre>

					<hr />

					<h3>
						<?= $static::i18n('Stack Trace (For Debugging Purposes)'); ?>
					</h3>
					<small><?= $static::i18n('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG</a> mode; and for all super administrators of the site.'); ?></small>
					<pre><?= esc_html($exception->getTraceAsString()); ?></pre>

					<? if(isset($exception->data)): ?>
						<hr />
						<h3>
							<?= $static::i18n('Additional Data (For Debugging Purposes)'); ?>
						</h3>
						<small><?= $static::i18n('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG</a> mode; and for all super administrators of the site.'); ?></small>
						<pre><?= esc_html(print_r($exception->data, TRUE)); ?></pre>
					<? endif; ?>
				<? endif; ?>

				<p>
					<?= $static::translate('If problems persist, please contact support for assistance.') ?>
				</p>

				<p style="text-align:right;">
					<a href="<?= esc_attr(home_url('/')); ?>"><?= esc_html(get_bloginfo('name')); ?></a> »
				</p>

				<div style="clear:both;"></div>

				<!-- ↓ For exception handler (leave intact). -->
				<!-- / END: Content Body -->

			</div>
		</div>

		<div class="footer wrapper">
			<div class="footer container">

			</div>
		</div>

	</div>
</div>

</body>
</html>