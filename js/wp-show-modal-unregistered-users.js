(function($) {
	 
	$(window).bind('beforeunload', function() {
        return 'Are you sure you want to leave?';
    });
	
})( jQuery );