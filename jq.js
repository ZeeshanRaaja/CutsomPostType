
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



$("#selection").change(function(){
    var keyword = $(this).find("option:selected").text();
    var keyword = $(this).val();
    jQuery.ajax({
        url:   ajax_obj.ajaxurl,
        type: 'POST',
        data: { 
            action: 'select',  
            keyword: keyword 
        },
        success: function(data) {
            jQuery('#datafetch').html( data );
        }
    });
});
});