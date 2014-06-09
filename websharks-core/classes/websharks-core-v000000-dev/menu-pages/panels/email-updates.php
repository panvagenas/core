<?php
/**
 * Menu Page Panel.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 140523
 */
namespace websharks_core_v000000_dev\menu_pages\panels
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page Panel.
	 *
	 * @package WebSharks\Core
	 * @since 140523
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class email_updates extends panel
	{
		/**
		 * Constructor.
		 *
		 * @param object|array $___instance_config Required at all times.
		 *    A parent object instance, which contains the parent's ``$___instance_config``,
		 *    or a new ``$___instance_config`` array.
		 *
		 * @param \websharks_core_v000000_dev\menu_pages\menu_page
		 *    $menu_page A menu page class instance.
		 */
		public function __construct($___instance_config, $menu_page)
		{
			parent::__construct($___instance_config, $menu_page);

			$this->heading_title = $this->__('Updates Via Email').'<em>!</em>';

			$form_fields = $this->©form_fields(); // Object instance.

			$this->content_body = // For updates via email (powered by MailChimp®).

				'<form'.
				' method="post"'.
				' target="_blank"'.
				' action="'.esc_attr($this->©options->get('menu_pages.panels.email_updates.action_url')).'"'.
				'>'.

				'<p>'. // Brief description.
				'<img src="'.esc_attr($this->©url->to_template_dir_file('/client-side/images/email-64x64.png')).'" class="pull-right l-margin" style="width:64px; height:64px;" alt="" />'.
				sprintf($this->__('Get all the latest news &amp; knowledge base articles from %1$s'), esc_html($this->___instance_config->plugin_name)).
				'</p>'.

				'<div class="form-group">'.
				'<div class="input-group">'.
				'<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>'.
				$form_fields->markup(
					$form_fields->value($this->©user->first_name),
					array(
						'required'    => TRUE,
						'type'        => 'text',
						'name'        => 'FNAME',
						'placeholder' => $this->__('First Name')
					)
				).
				'</div>'.
				'</div>'.

				'<div class="form-group">'.
				'<div class="input-group">'.
				'<span class="input-group-addon"><i class="fa fa-level-up fa-rotate-90 fa-fw"></i></span>'.
				$form_fields->markup(
					$form_fields->value($this->©user->last_name),
					array(
						'required'    => TRUE,
						'type'        => 'text',
						'name'        => 'LNAME',
						'placeholder' => $this->__('Last Name')
					)
				).
				'</div>'.
				'</div>'.

				'<div class="form-group">'.
				'<div class="input-group">'.
				'<span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>'.
				$form_fields->markup(
					$form_fields->value($this->©user->email),
					array(
						'required'    => TRUE,
						'type'        => 'email',
						'name'        => 'EMAIL',
						'placeholder' => $this->__('Email Address')
					)
				).
				'</div>'.
				'</div>'.

				'<div class="form-group">'.
				'<div class="input-group">'.
				'<span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>'.
				$form_fields->markup(
					$form_fields->value($this->©user->email),
					array(
						'required'    => TRUE,
						'type'        => 'password',
						'name'        => 'EMAIL',
						'confirm' => TRUE,
						'placeholder' => $this->__('Email Address')
					)
				).
				'</div>'.
				'</div>'.

				'<div class="form-group no-b-margin">'.
				$form_fields->markup(
					$this->__('Subscribe').' <i class="fa fa-external-link"></i>',
					array(
						'type' => 'submit',
						'name' => 'subscribe'
					)
				).
				'</div>'.

				'</form>';
		}
	}
}