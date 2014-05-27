/**
 * Menu Pages Extension
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */

(function($w) // Begin extension closure.
{
	'use strict'; // Standards.

	/**
	 * @type {Object} WebSharks™ Core.
	 */
	$w.$$websharks_core = $w.$$websharks_core || {};
	if(typeof $w.$$websharks_core.$menu_pages === 'function')
		return; // Extension already exists.

	/**
	 * @constructor Extension constructor & prototype definitions.
	 */
	$w.$$websharks_core.$menu_pages = function(){this.setup_initialize.apply(this, arguments);};
	$w.$$websharks_core.$menu_pages.prototype = new $w.$$websharks_core.$('websharks_core', 'menu_pages');
	$w.$$websharks_core.$menu_pages.prototype.constructor = $w.$$websharks_core.$menu_pages;
	$w.$$websharks_core.$menu_pages.prototype.setup_initialize = function()
	{
		var $$ = this, $ = jQuery; // $Quickies.

		$(document)// Handles document ready state event (DOM ready).
			.ready(function() // Setup/initialization routines.
			       {
				       var div = {}; // Start by initializing a few variables.

				       div.menu_page = 'div.' + $$.plugin_css_class() + '--menu-page';
				       div.menu_page_wrapper = div.menu_page + ' div.menu-page.wrapper';

				       div.header_controls = div.menu_page_wrapper + ' div.menu-page.controls';

				       div.content_wrapper = div.menu_page + ' div.content.wrapper';
				       div.content_panels = div.content_wrapper + ' div.panels';

				       div.sidebar_wrapper = div.menu_page + ' div.sidebar.wrapper';
				       div.sidebar_panels = div.sidebar_wrapper + ' div.panels';

				       // Setup/initialize header controls.

				       $(div.header_controls + ' button.toggle-all-content-panels')
					       .button({icons: {primary: 'ui-icon-triangle-1-s', secondary: 'ui-icon-triangle-1-n'}})
					       .click(function()
					              {
						              $(div.content_panels).toggles({}, {toggleAll: true});
						              return false;
					              });

				       $(div.header_controls + ' button.choose-theme')
					       .button({icons: {secondary: 'ui-icon-circle-triangle-s'}})
					       .click(function()
					              {
						              $(div.header_controls + ' form.update-theme')
							              .toggle().position
						              ({
							               collision: 'none',
							               my       : 'right top',
							               at       : 'right bottom',
							               offset   : '-5 0',
							               of       : this
						               });
						              return false;
					              });

				       $(div.header_controls + ' ul.theme-options li')
					       .click(function()
					              {
						              $(div.header_controls + ' form.update-theme')
							              .find('input.theme').val($(this).data('theme')).end()
							              .submit();
					              });

				       // Setup/initialize docs.

				       $(div.content_wrapper + ' div.panel.content div.docs')
					       .each(function()
					             {
						             var $this = $(this);

						             $this.before('<a class="docs-toggle" href="#">' + $$.__('ready__docs__button_label') + '</a>').prev('a.docs-toggle')
							             .button({icons: {primary: 'ui-icon-info'}})
							             .click(function()
							                    {
								                    $this.dialog('open');
								                    return false;
							                    });
						             $this.dialog({
							                          title      : $$.__('ready__docs__dialog_title'),
							                          dialogClass: $$.ui_dialogue_classes_for($this),
							                          width      : 853,
							                          autoOpen   : false,
							                          modal      : true
						                          });
					             });

				       // Setup/initialize video buttons.

				       $(div.content_wrapper + ' div.panel.content div.video')
					       .each(function()
					             {
						             var $this = $(this);

						             $this.before('<a class="video-toggle" href="#">' + $$.__('ready__video__button_label') + '</a>').prev('a.video-toggle')
							             .button({icons: {primary: 'ui-icon-video'}})
							             .click(function()
							                    {
								                    $this.dialog('open');
								                    return false;
							                    });
						             $this.dialog({
							                          title      : $$.__('ready__video__dialog_title'),
							                          dialogClass: $$.ui_dialogue_classes_for($this),
							                          width      : 853,
							                          height     : 480,
							                          autoOpen   : false,
							                          modal      : true
						                          });
					             });

				       // Setup/initialize content toggles.

				       $(div.content_panels).toggles
				       ({
					        isActive: function()
					        {
						        if('#' + $$.get_query_var('content_panel_slug') === this.hash)
						        {
							        $.scrollTo(this, {offset: {top: -50, left: 0}, duration: 500});
							        return true;
						        }
						        else return false;
					        },
					        onToggle: function(states)
					        {
						        var panels_active = [], panels_inactive = [];
						        var current_menu_page = $$.is_plugin_menu_page();

						        $.each(states.active, function(){ panels_active.push($(this).data('panel-slug')); });
						        $.each(states.inactive, function(){ panels_inactive.push($(this).data('panel-slug')); });

						        $$.post('©menu_pages__' + current_menu_page + '.®update_content_panels_state', $$.___private_type, [panels_active, panels_inactive]);
					        }
				        })
					       .sortable // Make them sortable.
				       ({
					        axis                : 'y',
					        forcePlaceholderSize: true,
					        handle              : '> div > h3',
					        placeholder         : 'ui-state-highlight',
					        stop                : function(event, ui)
					        {
						        // IE doesn't register the blur when sorting,
						        // so trigger focusout handlers to remove .ui-state-focus
						        ui.item.children('> div > h3').triggerHandler('focusout');

						        var panels_order = [];
						        var current_menu_page = $$.is_plugin_menu_page();

						        $(div.content_panels + ' div.panel.wrapper')
							        .each(function()
							              {
								              panels_order.push($(this).data('panel-slug'));
							              });

						        $$.post('©menu_pages__' + current_menu_page + '.®update_content_panels_order', $$.___private_type, [panels_order]);
					        }
				        });

				       // Setup/initialize sidebar toggles.

				       $(div.sidebar_panels).toggles
				       ({
					        isActive: function()
					        {
						        return ('#' + $$.get_query_var('sidebar_panel_slug') === this.hash);
					        },
					        onToggle: function(states)
					        {
						        var panels_active = [], panels_inactive = [];
						        var current_menu_page = $$.is_plugin_menu_page();

						        $.each(states.active, function(){ panels_active.push($(this).data('panel-slug')); });
						        $.each(states.inactive, function(){ panels_inactive.push($(this).data('panel-slug')); });

						        $$.post('©menu_pages__' + current_menu_page + '.®update_sidebar_panels_state', $$.___private_type, [panels_active, panels_inactive]);
					        }
				        })
					       .sortable // Make them sortable.
				       ({
					        axis                : 'y',
					        forcePlaceholderSize: true,
					        handle              : '> div > h3',
					        placeholder         : 'ui-state-highlight',
					        stop                : function(event, ui)
					        {
						        // IE doesn't register the blur when sorting,
						        // so trigger focusout handlers to remove .ui-state-focus
						        ui.item.find('> div > h3').triggerHandler('focusout');

						        var panels_order = [];
						        var current_menu_page = $$.is_plugin_menu_page();

						        $(div.sidebar_panels + ' div.panel.wrapper')
							        .each(function()
							              {
								              panels_order.push($(this).data('panel-slug'));
							              });

						        $$.post('©menu_pages__' + current_menu_page + '.®update_sidebar_panels_order', $$.___private_type, [panels_order]);
					        }
				        });
				       // Prepare UI forms.
				       $$.prepare_ui_forms();

				       // Wrap problematic UI theme components.
				       $$.wrap_problematic_ui_theme_components();

				       // Make menu page visible (it's hidden initially via CSS).
				       $(div.menu_page).css({visibility: 'visible'});
			       });
	};
	/**
	 * @type {Object} Creating an instance of this extension.
	 */
	$w.$websharks_core.$menu_pages = new $w.$$websharks_core.$menu_pages();

})(this); // End extension closure.