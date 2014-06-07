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
	class donations extends panel
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

			$this->heading_title = $this->__('Donations Welcome');

			$form_fields = $this->©form_fields(); // Object instance.

			$this->content_body = // Donations (form field selection).

				'<form'.
				' method="get"'.
				' target="_blank"'.
				' class="donate"'.
				' action="'.esc_attr($this->©url->to_plugin_site_uri('/donate/')).'"'.
				'>'.
				$form_fields->construct_field_markup(
					$form_fields->¤value(NULL),
					array(
						'required' => TRUE,
						'type'     => 'select',
						'name'     => 'amount',
						'options'  => array(
							array(
								'label' => $this->__('— Choose Donation Amount —'),
								'value' => ''
							),
							array(
								'label' => $this->__('$5.00 USD'),
								'value' => '5.00'
							),
							array(
								'label' => $this->__('$10.00 USD'),
								'value' => '10.00'
							),
							array(
								'label' => $this->__('$15.00 USD'),
								'value' => '15.00'
							),
							array(
								'label' => $this->__('$20.00 USD'),
								'value' => '20.00'
							),
							array(
								'label' => $this->__('$25.00 USD'),
								'value' => '25.00'
							),
							array(
								'label' => $this->__('$50.00 USD'),
								'value' => '50.00'
							),
							array(
								'label' => $this->__('$75.00 USD'),
								'value' => '75.00'
							),
							array(
								'label' => $this->__('$100.00 USD'),
								'value' => '100.00'
							),
							array(
								'label' => $this->__('$150.00 USD'),
								'value' => '150.00'
							),
							array(
								'label' => $this->__('$250.00 USD'),
								'value' => '250.00'
							),
							array(
								'label' => $this->__('$500.00 USD'),
								'value' => '500.00'
							),
							array(
								'label' => $this->__('$1000.00 USD'),
								'value' => '1000.00'
							),
							array(
								'label' => $this->__('$2000.00 USD'),
								'value' => '2000.00'
							)
						)
					)
				).
				$form_fields->construct_field_markup(
					$form_fields->¤value($this->__('Donate')),
					array(
						'type' => 'submit',
						'name' => 'donate'
					)
				).
				'</form>';
		}
	}
}