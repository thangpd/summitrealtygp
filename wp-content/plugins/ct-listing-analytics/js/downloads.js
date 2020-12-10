
jQuery("document").ready( function() {

    //text: PDF Floor Plan; 
    //href: /wp-real-estate-7/multi-demo/wp-content/uploads/2015/07/PDF-Floor-Plan.pdf

    jQuery("#listing-attachments a").click( function( e ) {

        if ( jQuery( this ).hasClass( "login-register" ) ) {
            // This is the modal login / register button, don't track...
            return;
        }

        var href = jQuery(e.target).attr("href");
        
        var userId = listingArray["userId"];
        var listingId = listingArray["listingId"];
        var ip = listingArray["ip"];
        var userAgent = listingArray["userAgent"];
        var referer = listingArray["referer"];
        var date = listingArray["date"];
        var ajaxurl = listingArray["ajaxurl"];
        var downloadName = jQuery(e.target).text();
        var extension  = jQuery(e.target).attr("href")

        extension = extension.substr( extension.lastIndexOf(".") + 1 );
        extension = extension.toUpperCase();

        jQuery.post(
            ajaxurl,
            {
                'action': 'ct_la_trackDownload',
                'userId': userId,
                'listingId': listingId,
                'ip': ip,
                'userAgent': userAgent,
                'referer': referer,
                'date': date,
                'downloadName': downloadName + " - " + extension
            }
        );
        
    });

});
