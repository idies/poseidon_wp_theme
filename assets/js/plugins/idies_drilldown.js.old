/* ========================================================================
 * IDIES: drilldown.js v0.1
 * Based on Bootstrap's COLLAPSE
 * ========================================================================
 * Copyright 2011-2015 IDIES
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */

 //self invoking function
+function ($) {
 
	'use strict';

	// DRILLDOWN PUBLIC CLASS DEFINITION
	// ================================
	var Drilldown = {
		
		// initialize the plugin
		init: function(){
			this.groups = [];
			
			//update controller counts
			this.resetCount();
			
			// save controllers for groups and
			// set onclick functions for group-controllers and individual-controllers
			var dd=this;
			$("li[data-toggle='drilldown'][data-target$='-all']").each( function() {
				var this_group = this.dataset.target.replace( "-all" , "" )
				$( this ).on( "click" , { group: this_group } , dd.toggleGroup );
				dd.groups.push( this_group );
			});
			
			//loop through groups
			//find all individuals in the group
			// set the indiv function to call with group name and indiv name
			$(dd.groups).each( function(  ) {
				var this_group = this;
				$("li[data-toggle='drilldown'][data-target^='"+this+"']:not([data-target$='-all'])").each( function() {
					$( this ).on( "click" , { group : this_group , target: this.dataset.target } , dd.toggleIndiv );
				});
			});			
		},
		
		// reset the count of shown elements in menu
		resetCount: function(){
			$('li[data-toggle="drilldown"]').each( function() {
				if ($(this.dataset.target + ":not(.hidden)").length) {
					$("span", this).html(' ('+$(this.dataset.target + ":not(.hidden)").length+')');
				} else {
					$("span", this).html('');
				}
			})
		},
		
		// toggle an 'all' drilldown controller
		toggleGroup: function( event ) {
			
			if ( $( this ).hasClass('off') ) {
			
				// if off, turn it on
				$( this ).removeClass('off');
				
				// turn individual controls on an unhide targets
				$("li[data-toggle='drilldown'][data-target^='"+event.data.group+"']:not([data-target$='-all'])").each( function() {
					if ( $( this ).hasClass('off') ) {
						$( this ).removeClass('off');
						$( this.dataset.target ).removeClass('hidden');
					}
				});
			} else {
			
				//turn it off
				$( this ).addClass('off');
				
				//turn off all individuals in this group and hide their targets
				$("li[data-toggle='drilldown'][data-target^='"+event.data.group+"']:not([data-target$='-all'])").each( function() {
					$( this ).addClass('off');
					$( this.dataset.target ).addClass('hidden');
				});
			}

			
			//hide what needs to be hidden and reset the counts
			$( "li.off[data-toggle='drilldown']:not([data-target$='-all'])" ).each( function() { $( this.dataset.target ).addClass("hidden") } );
			Drilldown.resetCount();
		},
		
		// toggle an 'individual' drilldown controller
		toggleIndiv: function( event ) {
			
			//if off,  turn on, show target, update if all are shown
			if ( $( this ).hasClass('off') ) {
			
				// turn on and unhide target
				$( this ).removeClass('off');
				$( event.data.target ).removeClass('hidden');
				
				// see if any individual controllers are off, and if not, turn on group controller
				if ( $( "li.off[data-toggle='drilldown'][data-target^='"+event.data.group+"']:not([data-target$='-all'])" ).length == 0 ) {
					$("li[data-toggle='drilldown'][data-target='"+event.data.group+"-all']").removeClass( 'off' );
				}
			//if on,  turn off, hide target, update not all are shown			
			} else {
				$( this ).addClass('off');
				$( event.data.target ).addClass('hidden');
				$("li[data-toggle='drilldown'][data-target='"+event.data.group+"-all']").addClass('off')
			}
			
			//hide what needs to be hidden and reset the counts
			$( "li.off[data-toggle='drilldown']:not([data-target$='-all'])" ).each( function() { $( this.dataset.target ).addClass("hidden") } );
			Drilldown.resetCount();
		}
		
		// turn 'all' elements on
		
		// turn one off
		
		// turn one on
	}

	$(document).ready(function() {

		//Drilldown.resetCount();

		Drilldown.init();

		return;
		
	});
  
}(jQuery);
