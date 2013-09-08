(function( $ ) {
 
    $.fn.cleangallery = function(album) {

    	for (var i=0; i<album.length; i++) {
    		if(album[i].photo) {
    			this.append("<div>Photo index " + i + "</div>");
    		}
    		else {
    			this.append(
	    			$("<div>")
	    				.append("<h2>" + album[i].title + "</h2>")
	    				.append("<p>" + album[i].words + "</p>")
    			);
    		}
    	}

    };
 
 
}( jQuery ));