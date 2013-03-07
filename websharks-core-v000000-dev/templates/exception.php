<?php
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
 * @note The current plugin instance is available through the special keyword: ``$this``.
 * @var $this framework Current plugin framework instance (extended by templates class).
 * @var $this templates Template instance (extends framework).
 * @var $exception exception Exception class instance.
 */
if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

$exception = $this->data->exception;
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8" />
	<title><?= $this->translate('Uncaught Exception'); ?> | <?= esc_html(get_bloginfo('name')); ?></title>
	<?= $this->stand_alone_styles().$this->stand_alone_scripts(); ?>
</head>
<body>

<div class="<?= esc_attr($this->stand_alone_wrapper_classes()); ?>">
	<div class="<?= esc_attr($this->stand_alone_container_classes()); ?>">

		<div class="header wrapper">
			<div class="header container">

				<?= $this->stand_alone_header(); ?>

			</div>
		</div>

		<div class="content wrapper">
			<div class="content container <?= esc_attr($this->ui_widget_classes()); ?>">

				<!-- BEGIN: Content Body -->
				<!-- ↑ For exception handler (leave intact). -->

				<a name="exception" class="anchor"></a>

				<h1><?= $this->translate('Uncaught Exception'); ?></h1>

				<h3 class="marginize-top-x2">
					<?= $this->translate('Request failed w/ exception code:') ?>
				</h3>
				<p style="margin:0;">
					<code style="background:#FDFB76;"><?= esc_html($exception->getCode()); ?></code>
				</p>

				<? if($this->©env->is_in_wp_debug_mode() || is_super_admin()): ?>
					<p>
						<?= sprintf($this->i18n('Exception occurred at line # <code>%1$s</code> in: <code>%2$s</code>.'), esc_html($exception->getLine()), esc_html($exception->getFile())); ?>
					</p>

					<hr class="marginize-x2" />

					<h3>
						<?= $this->i18n('Exception Message (Please Read)'); ?>
					</h3>
					<small><?= $this->i18n('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG</a> mode; and for all super administrators of the site.'); ?></small>
					<pre><?= esc_html($exception->getMessage()); ?></pre>

					<hr class="marginize-x2" />

					<h3>
						<?= $this->i18n('Stack Trace (For Debugging Purposes)'); ?>
					</h3>
					<small><?= $this->i18n('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG</a> mode; and for all super administrators of the site.'); ?></small>
					<pre><?= esc_html($exception->getTraceAsString()); ?></pre>

					<? if(isset($exception->data)): ?>
						<hr class="marginize-x2" />
						<h3>
							<?= $this->i18n('Additional Data (For Debugging Purposes)'); ?>
						</h3>
						<small><?= $this->i18n('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG</a> mode; and for all super administrators of the site.'); ?></small>
						<pre><?= esc_html($this->©var->dump($exception->data)); ?></pre>
					<? endif; ?>
				<? endif; ?>

				<hr class="marginize-x2" />

				<p class="float-half-left marginize">
					<?= sprintf($this->translate('If problems persist, please <a href="%1$s">contact support</a> for assistance.'), $this->©options->get('support.url')) ?>
				</p>

				<p class="float-half-right marginize">
					<a href="<?= esc_attr(home_url('/')); ?>"><?= esc_html(get_bloginfo('name')); ?></a> »
				</p>

				<div class="clear"></div>

				<!-- ↓ For exception handler (leave intact). -->
				<!-- / END: Content Body -->

			</div>
		</div>

		<div class="footer wrapper">
			<div class="footer container">

				<?= $this->stand_alone_footer(); ?>

			</div>
		</div>

	</div>
</div>

</body>
</html>