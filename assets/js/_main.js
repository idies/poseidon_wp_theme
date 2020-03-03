/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can 
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
var Roots = {
  // All pages
  common: {
    init: function() {
      // JavaScript to be fired on all pages
    }
  },
  // Home page
  home: {
    init: function() {
      // JavaScript to be fired on the home page
    }
  },
  // About us page, note the change from about-us to about_us.
  about_us: {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  },
  // IDIES Orders page, note the change from idies-orders to idies_orders.
  idies_orders: {
    init: function() {
	  // JavaScript to be fired on the idies orders page

	  // Toggle the quote fields when Quote checkbox is checked
	  var quotecheckid = '#' + $( $( '.quoterequired' )[ 0 ]).prop( 'id' );
	  $( '#' + $( $( '.quoteattach-wrapper' )[ 0 ]).prop( 'id' ) ).hide();
	  $( '#' + $( $(' .quotetype-wrapper ')[ 0 ]).prop( 'id' ) ).hide();
	  $(quotecheckid).on('change' , function() { $( $( '.quoteattach-wrapper' )[ 0 ]).toggle(); } );
	  $(quotecheckid).on('change' , function() { $( $(' .quotetype-wrapper ')[ 0 ]).toggle(); } );
	  	  
	  // Toggle the quote fields when Quote checkbox is checked
	  var approvecheckid = '#' + $( $( '.approved' )[ 0 ]).prop( 'id' );
	  $( '#' + $( $( '.approveemail-wrapper' )[ 0 ]).prop( 'id' ) ).hide();
	  $(approvecheckid).on('change' , function() { $( $( '.approveemail-wrapper' )[ 0 ]).toggle(); } );
	}
  },
  // IDIES Orders page
  order_form: {
    init: function() {
		// JavaScript to be fired on the IDIES order form page
		var context = 'form#idies-orders';
		$("#quoterequired",context).on('change' , function() { 
			if ( $("#quoterequired",context).prop("checked") ) {
				$('#uploadquote',context).prop("required",true);
				$("input[name='quotetype']",context).each( function() { 
					$(this).prop("required",true);
				});
			} 
			else {
				$('#uploadquote',context).prop("required",false);
				$("input[name='quotetype']",context).each( function() { 
					$(this).prop("required",false);
				});
			}
		} );
		$("#purchaseapproved",context).on('change' , function() { 
			if ( $("#purchaseapproved",context).prop("checked") ) {
				$('#uploadapproval',context).prop("required",true);
			} 
			else {
				$('#uploadapproval',context).prop("required",false);
			}
		} );
	}
  }
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Roots;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

//$(document).ready(UTIL.loadEvents);
$( window ).load( UTIL.loadEvents );

})(jQuery); // Fully reference jQuery after this point.
