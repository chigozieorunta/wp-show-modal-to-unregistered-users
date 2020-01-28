(function($) {
	
	$("a:not(.wpsmuu)").on("click", function(event) {
		event.preventDefault();
		$("#wpsmuu").fadeIn("fast");
	});
	
	$("#wpsmuu > div:first-child").click(function() {
	    $("#wpsmuu").fadeOut("fast");
	});
	
})( jQuery );