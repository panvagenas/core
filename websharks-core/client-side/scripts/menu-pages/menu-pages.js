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

(function($) // Begin extension closure.
{
	'use strict'; // Strict standards.

	if($websharks_core.___did_menu_pages)
		return; // Already did these.

	$.each($websharks_core.$.___plugin_root_ns_stubs,
	       function(plugin_root_ns_stub_index, plugin_root_ns_stub)
	       {
		       var extension // Extension definition.
			       = $websharks_core.$.extension_class(plugin_root_ns_stub, 'menu_pages');
		       window['$' + plugin_root_ns_stub].$menu_pages = new extension();
		       var _ = window['$' + plugin_root_ns_stub].$menu_pages;

		       _.toggling_all_panels = false;

		       _.on_dom_ready = function()
		       {
			       var $menu_page = _.$menu_page();
			       var $content_panels = _.$content_panels();
			       var $sidebar_panels = _.$sidebar_panels();
			       var $content_sidebar_panels = _.$content_sidebar_panels();

			       $('#wpbody').addClass(_.instance_config('core_prefix_with_dashes') +
			                             _.closest_theme_class_to($menu_page))
				       .css({'margin-left': '-20px', 'padding-left': '20px', 'min-height': screen.height + 'px'});

			       $menu_page.find('.toggle-all-panels')
				       .on('click', function()
				           {
					           _.toggling_all_panels = true;
					           var $this = $(this), last_action = $this.data('last-action');
					           var this_action = last_action === 'show' ? 'hide' : 'show';

					           $this.data('last-action', this_action), $content_sidebar_panels.find('> .panel-collapse')
						           .wscCollapse({toggle: false}).wscCollapse(this_action);

					           setTimeout(function() // Wait for transitions to complete.
					                      {
						                      _.toggling_all_panels = false, // Now update panels state.
							                      update_content_panels_state(), update_sidebar_panels_state();
					                      }, 2000);
				           });

			       $menu_page.find('form.update-theme ul > li')
				       .on('click', function()
				           {
					           $menu_page.find('form.update-theme')
						           .find('input.selected-theme').val($(this).data('theme'))
						           .end().submit();
				           });

			       var update_content_panels_state = function()
			       {
				       if(_.toggling_all_panels)
					       return; // Ignore this scenario.

				       var panels_active = [], panels_inactive = [];

				       $content_panels.each(function()
				                            {
					                            var $this = $(this);
					                            if($this.find('> .panel-collapse').hasClass('in'))
						                            panels_active.push($this.data('panel-slug'));
					                            else panels_inactive.push($this.data('panel-slug'));
				                            });
				       _.post('©menu_pages__' + _.is_plugin_menu_page('', true) + '.®update_content_panels_state',
				              _.___private_type, [panels_active, panels_inactive]);
				       console.log('Updating content panels state.');
			       };
			       $content_panels.find('> .panel-collapse').on('shown.wsc-bs.collapse hidden.wsc-bs.collapse', update_content_panels_state);

			       var update_sidebar_panels_state = function()
			       {
				       if(_.toggling_all_panels)
					       return; // Ignore this scenario.

				       var panels_active = [], panels_inactive = [];

				       $sidebar_panels.each(function()
				                            {
					                            var $this = $(this);
					                            if($this.find('> .panel-collapse').hasClass('in'))
						                            panels_active.push($this.data('panel-slug'));
					                            else panels_inactive.push($this.data('panel-slug'));
				                            });
				       _.post('©menu_pages__' + _.is_plugin_menu_page('', true) + '.®update_sidebar_panels_state',
				              _.___private_type, [panels_active, panels_inactive]);
				       console.log('Updating sidebar panels state.');
			       };
			       $sidebar_panels.find('> .panel-collapse').on('shown.wsc-bs.collapse hidden.wsc-bs.collapse', update_sidebar_panels_state);

			       var update_content_panels_order = function()
			       {
				       var panels_order = [];

				       $menu_page.find('.content-panels > .panel')
					       .each(function()
					             {
						             var $this = $(this);
						             panels_order.push($this.data('panel-slug'));
					             });
				       _.post('©menu_pages__' + _.is_plugin_menu_page('', true) + '.®update_content_panels_order',
				              _.___private_type, [panels_order]);
				       console.log('Updating content panels order.');
			       };
			       $menu_page.find('.content-panels')
				       .sortable({
					                 items : '.panel',
					                 // $(.sidebar-panels).children(.panel)
					                 // $(.sidebar-panels).children(.panel).find(handle)
					                 handle: '> .panel-heading > .panel-title .cursor-move'
				                 });
			       $menu_page.find('.content-panels').on('sortupdate', update_content_panels_order);

			       var update_sidebar_panels_order = function()
			       {
				       var panels_order = [];

				       $menu_page.find('.sidebar-panels > .panel')
					       .each(function()
					             {
						             var $this = $(this);
						             panels_order.push($this.data('panel-slug'));
					             });
				       _.post('©menu_pages__' + _.is_plugin_menu_page('', true) + '.®update_sidebar_panels_order',
				              _.___private_type, [panels_order]);
				       console.log('Updating sidebar panels order.');
			       };
			       $menu_page.find('.sidebar-panels')
				       .sortable({
					                 items : '.panel',
					                 // $(.sidebar-panels).children(.panel)
					                 // $(.sidebar-panels).children(.panel).find(handle)
					                 handle: '> .panel-heading > .panel-title .cursor-move'
				                 });
			       $menu_page.find('.sidebar-panels').on('sortupdate', update_sidebar_panels_order);
		       };

		       _.on_win_load = function()
		       {
			       var $menu_page = _.$menu_page();

			       var content_panel_slug = _.get_query_var('content_panel_slug');
			       var sidebar_panel_slug = _.get_query_var('sidebar_panel_slug');
			       var $content_panel, $sidebar_panel; // Initialize.

			       if(content_panel_slug // Focusing on a specific content panel?
			          && ($content_panel = $menu_page.find('.content-panels #panel--' + content_panel_slug + '.panel-collapse')).length)
			       {
				       var scroll_to_content_panel = function()
				       {
					       $.scrollTo($content_panel.prev('.panel-heading'), {offset: {top: -100, left: 0}, duration: 500});
				       };
				       if($content_panel.hasClass('in')) scroll_to_content_panel(); // Expanded already.
				       else $content_panel.one('shown.wsc-bs.collapse', scroll_to_content_panel),
					       $content_panel.wscCollapse({toggle: false}).wscCollapse('show');
			       }
			       if(sidebar_panel_slug // Focusing on a specific sidebar panel?
			          && ($sidebar_panel = $menu_page.find('.sidebar-panels #panel--' + sidebar_panel_slug + '.panel-collapse')).length)
			       {
				       var scroll_to_sidebar_panel = function()
				       {
					       if(!content_panel_slug) // Only if we are NOT also scrolling to a content panel.
						       $.scrollTo($sidebar_panel.prev('.panel-heading'), {offset: {top: -100, left: 0}, duration: 500});
				       };
				       if($sidebar_panel.hasClass('in')) scroll_to_sidebar_panel(); // Expanded already.
				       else $sidebar_panel.one('shown.wsc-bs.collapse', scroll_to_sidebar_panel),
					       $sidebar_panel.wscCollapse({toggle: false}).wscCollapse('show');
			       }
		       };

		       _.$menu_page = function()
		       {
			       if(_.cache.$menu_page)
				       return _.cache.$menu_page;

			       return (_.cache.$menu_page // Current menu page.
			               = $('.' + _.instance_config('core_ns_stub_with_dashes') + '.menu-page'));
		       };

		       _.$content_panels = function()
		       {
			       if(_.cache.$content_panels)
				       return _.cache.$content_panels;

			       return (_.cache.$content_panels = _.$menu_page()
				       .find('.content-panels > .panel'));
		       };

		       _.$sidebar_panels = function()
		       {
			       if(_.cache.$sidebar_panels)
				       return _.cache.$sidebar_panels;

			       return (_.cache.$sidebar_panels = _.$menu_page()
				       .find('.sidebar-panels > .panel'));
		       };

		       _.$content_sidebar_panels = function()
		       {
			       if(_.cache.$content_sidebar_panels)
				       return _.cache.$content_sidebar_panels;

			       return (_.cache.$content_sidebar_panels = _.$menu_page()
				       .find('.content-panels > .panel, .sidebar-panels > .panel'));
		       };

		       $(document).on('ready', _.on_dom_ready), $(window).on('load', _.on_win_load);
	       });
	$websharks_core.___did_menu_pages = true;

})(jQuery); // End extension closure.