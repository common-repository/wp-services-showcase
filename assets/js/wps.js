(function($){

    $(window).resize( function(){
        HeightResizeWps();
        //listIconDoxResize();
    });
    $(window).load(function(){
        HeightResizeWps();
        //listIconDoxResize();
    });

    function HeightResizeWps(){
        jQuery(".rt-services").each(function(){
            var rtMaxH = 0;
            jQuery(this).children('div').children(".rt-equal-height").height("auto");
            jQuery(this).children('div').children('.rt-equal-height').each(function(){
                var $thisH = jQuery(this).actual( 'outerHeight' );
                if($thisH > rtMaxH){
                    rtMaxH = $thisH;
                }
            });
            jQuery(this).children('div').children(".rt-equal-height").css('height', rtMaxH + "px");
        });
    }

    function listIconDoxResize(){
        jQuery(".rt-services.list").each(function(){
            var rtMaxW = 0;
            jQuery(this).find('.service-image').width("auto");
            jQuery(this).find('.single-service').each(function(){
                var $thisW = jQuery(this).find(".service-image").actual( 'outerWidth' );
                if($thisW > rtMaxW){
                    rtMaxW = $thisW;
                }
            });
            jQuery(this).find('.service-image').css('width', rtMaxW + "px");
        });
    }

})(jQuery)