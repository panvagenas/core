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
 * @note The current plugin instance is available through the special keyword: `$this`.
 * @var $this templates|framework Template instance (extends framework).
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
	<title><?php echo $this->_x('Uncaught Exception'); ?> | <?php echo esc_html(get_bloginfo('name')); ?></title>
	<?php echo $this->stand_alone_styles(); ?>
</head>
<body>

<div class="<?php echo esc_attr($this->stand_alone_wrapper_classes()); ?>">
	<div class="<?php echo esc_attr($this->stand_alone_container_classes()); ?>">

		<div class="header wrapper">
			<div class="header container">

				<?php echo $this->stand_alone_header(); ?>

			</div>
		</div>

		<div class="content wrapper">
			<div class="content container <?php echo esc_attr($this->ui_widget_classes()); ?>">

				<!-- BEGIN: Content Body -->
				<!-- ↑ For exception handler (leave intact). -->

				<a name="exception" class="anchor"></a>

				<h1><?php echo $this->_x('Uncaught Exception'); ?></h1>

				<h3 class="marginize-top-x2">
					<?php echo $this->_x('Request failed w/ exception code:') ?>
				</h3>
				<p style="margin:0;">
					<code style="background:#FDFB76;"><?php echo esc_html($exception->getCode()); ?></code>
				</p>

				<?php if($this->©env->is_in_wp_debug_display_mode() || is_super_admin()): ?>

					<p>
						<?php echo sprintf($this->__('Exception occurred at line # <code>%1$s</code> in: <code>%2$s</code>.'), esc_html($exception->getLine()), esc_html($exception->getFile())); ?>
					</p>

					<hr class="marginize-x2" />

					<h3>
						<?php echo $this->__('Exception Message (Please Read)'); ?>
					</h3>
					<small><?php echo $this->__('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG_DISPLAY</a> mode; and for all super administrators of the site.'); ?></small>
					<pre><?php echo esc_html($exception->getMessage()); ?></pre>

					<hr class="marginize-x2" />

					<h3>
						<?php echo $this->__('Stack Trace (For Debugging Purposes)'); ?>
					</h3>
					<small><?php echo $this->__('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG_DISPLAY</a> mode; and for all super administrators of the site.'); ?></small>
					<pre><?php echo esc_html($exception->getTraceAsString()); ?></pre>

					<?php if(isset($exception->data)): ?>
						<hr class="marginize-x2" />
						<h3>
							<?php echo $this->__('Additional Data (For Debugging Purposes)'); ?>
						</h3>
						<small><?php echo $this->__('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG_DISPLAY</a> mode; and for all super administrators of the site.'); ?></small>
						<pre><?php echo esc_html($this->©var->dump($exception->data)); ?></pre>
					<?php endif; ?>

				<?php endif; ?>

				<hr class="marginize-x2" />

				<p class="float-half-left marginize">
					<?php echo sprintf($this->_x('If problems persist, please <a href="%1$s">contact support</a> for assistance.'), $this->©options->get('support.url')) ?>
				</p>

				<p class="float-half-right marginize">
					<a href="<?php echo esc_attr($this->©url->to_wp_home_uri()); ?>"><?php echo esc_html(get_bloginfo('name')); ?></a> »
				</p>

				<div class="clear"></div>

				<!-- ↓ For exception handler (leave intact). -->
				<!-- / END: Content Body -->

			</div>
		</div>

		<div class="footer wrapper">
			<div class="footer container">

				<?php echo $this->stand_alone_footer(); ?>

			</div>
		</div>

	</div>
</div>

<?php echo $this->stand_alone_footer_scripts(); ?>

</body>
</html>