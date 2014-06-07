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
	class update extends panel
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

			$call        = '©plugin.®update';
			$form_fields = $this->©form_fields(array('for_call' => $call));
			$data        = $this->©action->get_call_data_for($call);

			$username    = $this->©string->is_not_empty_or($data->username, '');
			$password    = $this->©string->is_not_empty_or($data->password, '');
			$credentials = $this->©plugin->get_site_credentials($username, $password);

			$this->heading_title = sprintf($this->__('%1$s Framework Updater'), $this->___instance_config->plugin_name);

			$this->content_body = // Updates Framework to the latest version.

				sprintf($this->__('<p>This will automatically update your copy of the %1$s Framework to the latest available version. This update routine is powered by WordPress®. Depending on your configuration of WordPress®, you might be asked for FTP credentials before the update will begin. The %1$s Framework (which is free), can also be updated from the plugins menu in WordPress®. Please be sure to <strong>BACKUP</strong> your entire file structure and database before updating any WordPress® component.</p>'),
				        esc_html($this->___instance_config->plugin_name)).
				'<form method="post" action="'.esc_attr($this->©menu_page->url($this->menu_page->slug, $this->slug)).'" class="update">'.

				$this->©action->hidden_inputs_for_call($call, $this::private_type).

				$this->©action->get_call_responses_for($call).

				$form_fields->construct_field_markup(
					$form_fields->¤value(sprintf($this->__('%1$s Framework (Update)'), $this->___instance_config->plugin_name)),
					array(
						'type'                => 'submit',
						'name'                => 'update',
						'div_wrapper_classes' => 'form-submit update'
					)
				).
				'</form>';
		}
	}
}