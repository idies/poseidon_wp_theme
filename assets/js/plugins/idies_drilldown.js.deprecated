/* ========================================================================
 * IDIES: drilldown.js v0.3
 * ========================================================================
 * What it does:
 * 
 * Shows and hides elements based on constraints selected from one or more 
 * groups of constraints, e.g. schools, departments, research interests.
 * 
 * All controls should be in a wrapper with the class [prefix]-controls.
 * All targets should be in a wrapper with the class [prefix]-targets.
 * [prefix] is passed in when initializing the class in the Drilldown.ready function. 
 *
 * Formatting is set up in less using the prefix.
 * 
 * Each group of controls starts with a Show All control with data-toggle="drilldown" 
 * and data-target="[prefix]-[groupname]-all", e.g. "sch-all". Drilldown will get the 
 * group names from the webpage.
 * 
 * Each individual constraint has a data-toggle set to 'tog' and a data-target 
 * set to a unique selector "[group]-[selector]", e.g. "sch-1099".
 * Only elements satisfying all constraints will be shown.
 * 
 * Next to each control the plugin displays the number of shown targets 
 * satisfying that constraint.
 * 
 * Initially, only the Show All option is checked.
 * 
 * Selecting an individual constraint will (1) uncheck the Show All option and 
 * (2) hide all elements not satisfying ALL constraints, (3) update the number 
 * of shown elements next to each constraint.
 * 
 * Unselecting an individual constraint will (1) uncheck the option and (2) if no 
 * constraints are selected, check Show All, (3) hide all elements not satisfying 
 * ALL constraints, (4) update the number of shown elements next to each 
 * constraint.
 * 
 * Selecting the Show All option will (1) do nothing if already selected, 
 * (2) select all options in that group is Show All not selected, (3) hide 
 * all elements not satisfying ALL constraints, (4) update the number of shown 
 * elements next to each constraint.
 * 
 * 
 * ======================================================================== 
 * Copyright 2011-2015 IDIES
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */

 //self invoking function
+function ($) {
 
	'use strict';

	// Drilldown PUBLIC CLASS DEFINITION
	// ================================
	var Drilldown = {
		
		// initialize the plugin
		init: function( pre ){
			Drilldown.tog = pre;
			Drilldown.pre = "."+pre+"-";
			
			//reset controls count
			this.resetCount();
			this.resetOverview();
			// set onclick functions for group-controllers and individual-controllers
			var dd2=this;
			$(Drilldown.pre+"controls [data-toggle='"+Drilldown.tog+"'][data-target$='-all']").each( function() {
				
				//get the prefix of the group
				var this_group = this.dataset.target.replace( "-all" , "" )
				
				// set the click event for group constraint
				$( this ).on( "click" , { group: this_group } , dd2.toggleGroup );
				
				//set the click events for individual constraints
				$(Drilldown.pre+"controls [data-toggle='"+Drilldown.tog+"'][data-target^='"+this_group+"']:not([data-target$='-all'])").each( function() {
					$( this ).on( "click" , { group : this_group , target: this.dataset.target } , dd2.toggleIndiv );
				});
			});
			
		},
		
		// Show targets that have controls Checked.
		updateHidden: function(){
		
			//first show-hide groups
			$(Drilldown.pre+"controls [data-toggle='"+Drilldown.tog+"'][data-target$='-all']").each( function() {
				$( Drilldown.pre + "targets ." + this.id + ".hidden").each( function() {
					$(this).removeClass('hidden');
				});
			});
			
			//then hide unchecked indiv in unchecked groups
			$(Drilldown.pre+"controls [data-toggle='" + Drilldown.tog + "'][data-target$='-all']" ).each( function() {
				if ( !$( this ).prop('checked') ) {

					$((Drilldown.pre+"controls [data-target^='." + this.id.replace('-all','') + "']:not([data-target$='-all'])")).each( function() {
						if( !this.checked) $(this.dataset.target).addClass('hidden');
					});
					
					//but show checked indiv in unchecked groups (because of multiple affiliations)
					$((Drilldown.pre+"controls [data-target^='." + this.id.replace('-all','') + "']:not([data-target$='-all'])")).each( function() {
						if( this.checked) $(this.dataset.target).removeClass('hidden');
					});
				}
			});

		},
		
		// reset the menu count of shown elements
		resetCount: function(){
			
			//new
			$(Drilldown.pre + "controls [data-target^='" + Drilldown.pre + "']:not([data-target$='-all']").each( function() {
				$("label[for='" + this.id + "'] span").html("(" + $(Drilldown.pre + "targets ." + this.id ).length + ")");
			});
		
		},
		
		// reset the menu count of shown elements
		resetOverview: function(){
			$(Drilldown.pre + "overview").html("<span>Showing " + $(Drilldown.pre + "target:not(.hidden)").length + " of " + $(Drilldown.pre + "target").length + " Affiliates<span>");
		
		},
		
		// toggle an 'all'  controller - uncheck indiv if checked, can't uncheck
		toggleGroup: function( event ) {
			
			// if checked
			if ( $( this ).prop('checked') ) {
				
				//uncheck other boxes in group
				$( Drilldown.pre+"controls [data-toggle='"+Drilldown.tog+"'][data-target^='"+event.data.group+"']:not([data-target$='-all'])").each( function(  ) {
					$( this ).prop( 'checked' , false );
				});

			} else {
				//can only uncheck by checking indiv.
				$( this ).prop( 'checked' , true )
			}
			
			Drilldown.updateHidden();
			Drilldown.resetCount();
			Drilldown.resetOverview();
			
		},
		
		// toggle an 'individual' controller
		toggleIndiv: function( event ) {
			
			// if checked
			if ( $( this ).prop('checked') ) {
				
				$( Drilldown.pre+"controls [data-toggle='"+Drilldown.tog+"'][data-target='"+event.data.group+"-all']" ).prop('checked',false);
				
			}
			
			//hide what needs to be hidden and reset the counts
			Drilldown.updateHidden();
			Drilldown.resetCount();
			Drilldown.resetOverview();
		}

	}

	$(document).ready(function() {

		Drilldown.init("dd2");

		return;
		
	});
  
}(jQuery);
