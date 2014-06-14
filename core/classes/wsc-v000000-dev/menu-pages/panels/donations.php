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
namespace wsc_v000000_dev\menu_pages\panels
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
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's ``$instance``,
		 *    or a new ``$instance`` array.
		 *
		 * @param \wsc_v000000_dev\menu_pages\menu_page
		 *    $menu_page A menu page class instance.
		 */
		public function __construct($instance, $menu_page)
		{
			parent::__construct($instance, $menu_page);

			$this->heading_title = $this->__('Donations Welcome');

			$form_fields = $this->©form_fields(); // Object instance.

			$this->content_body = // Donations (form field selection).

				'<form'.
				' method="get"'.
				' target="_blank"'.
				' action="'.esc_attr($this->©url->to_plugin_site_uri('/donate/')).'"'.
				'>'.

				'<div class="form-group">'.
				'<div class="input-group select-input-group">'.
				'<span class="input-group-addon"><i class="fa fa-heart fa-fw"></i></span>'.
				$form_fields->markup(
					$form_fields->¤value(NULL),
					array(
						'required' => TRUE,
						'type'     => 'select',
						'name'     => 'amount',
						'options'  => array(
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
				'</div>'.
				'</div>'.

				'<div class="form-group no-b-margin">'.
				$form_fields->markup(
					'<i class="fa fa-gift"></i> '.$this->__('Donate').' <i class="fa fa-external-link"></i>',
					array(
						'type' => 'submit',
						'name' => 'donate'
					)
				).
				'</div>'.

				'</form>';
		}
	}
}