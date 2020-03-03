+function ($) {
	$(document).ready(function(){

		//ensure all links with an external-link class open a new tab
		var $ext_links = $("li.external-link>a");
		$.merge($ext_links , $("a.external-link"));
	   $($ext_links).each(function(){
			$(this).attr("target","_blank")
		});
	
		//set up the expand-all and collapse-all buttons
		$("button#expand-all").click(function(){
			if ($(this).html().localeCompare("Expand All") == 0) {
				$(this).html('Collapse All');
				$(this).toggleClass('btn-success');
				$(this).toggleClass('btn-danger');
				$("div." + $(this).attr('data-group') + ">article>div.collapse").each(function(){ $(this).collapse('show') });			
			} else {
				$(this).html('Expand All');
				$(this).toggleClass('btn-success');
				$(this).toggleClass('btn-danger');
				$("div." + $(this).attr('data-group') + ">article>div.collapse").each(function(){ $(this).collapse('hide') });			
			}
		});
		
		//activate tabs on affiliate page
		$('#affiliateTabs a').click(function (e) {
			e.preventDefault()
			$(this).tab('show')
		});

		//Set up UStream viewer object
		if ( $( "#UstreamIframe").length ) {
			var viewer = UstreamEmbed('UstreamIframe');
			viewer.callMethod('low');
			viewer.callMethod('play');
			if ( $( "#UstreamIframe" ).data( "seek" ) !== undefined ) {
				//var gotosecond = $( "#UstreamIframe" ).data( "seek" );
				var gotosecond = 600
				console.log("Seeking " + gotosecond );
				viewer.callMethod('seek', gotosecond );
			}
		}
		

})
}(jQuery);
;