
jQuery(document).ready(function($){  
    
    
    $("#keyword").on("keyup",function(){
        var keyword = $(this).val();

        jQuery.ajax({
            url:   ajax_obj.ajaxurl,
            type: 'POST',
            data: { 
                action: 'data_fetch',  
                keyword: keyword 
            },
            success: function(data) {
                jQuery('#datafetch').html( data );
            }
        });
    });
});