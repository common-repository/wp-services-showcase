(function($){
    $( window ).resize(function() {
        resize();
    });
    function resize() {
        $.colorbox.resize();
    }
    $(".rt-tab-nav li").on('click', 'a', function(e){
        e.preventDefault();
        var container = $(this).parents('.rt-tab-container');
        var nav = container.children('.rt-tab-nav');
        var content = container.children(".rt-tab-content");
        var $this, $id;
        $this = $(this);
        $id = $this.attr('href');
        content.hide();
        nav.find('li').removeClass('active');
        $this.parent().addClass('active');
        container.find($id).show();
    });
    $(document).ready(function() {
        $(".rt-tab-nav li:first-child a").trigger('click');
        if ($(".rt-color").length) {
            $('.rt-color').wpColorPicker();
        }
        if ($(".rt-select2").length) {
            $(".rt-select2").select2({dropdownAutoWidth: true});
        }

        if (/Android|iPhone|iPad|iPod|webOS|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            $("#wps-constructor-box").colorbox({
                inline: true,
                width: "96%",
                onClosed: function () {
                    $('#wps-sc-params')[0].reset();
                }
            });
        } else {
            $("#wps-constructor-box").colorbox({
                inline: true,
                width: "50%",
                onClosed: function () {
                    $('#wps-sc-params')[0].reset();
                }
            });
        }
    });
    $(window).scroll(function() {
        var height = $(window).scrollTop();

        if(height  > 50) {
            $('.post-type-rttpg div#submitdiv').addClass('sticky');
        }else{
            $('.post-type-rttpg div#submitdiv').removeClass('sticky');
        }
    });

})(jQuery);

( function( global, $ ) {
    var editor,
        syncCSS = function() {
            wpsSyncCss();
        },
        loadAce = function() {
            $('.rt-custom-css').each(function(){
                var id = $(this).find('.custom-css').attr('id');
                editor = ace.edit( id );
                global.safecss_editor = editor;
                editor.getSession().setUseWrapMode( true );
                editor.setShowPrintMargin( false );
                editor.getSession().setValue( $(this).find('.custom_css_textarea').val() );
                editor.getSession().setMode( "ace/mode/css" );
            });

            jQuery.fn.spin&&$( '.custom_css_container' ).spin( false );
            $( '#post' ).submit( syncCSS );
        };
    if ( $.browser.msie&&parseInt( $.browser.version, 10 ) <= 7 ) {
        $( '.custom_css_container' ).hide();
        $( '.custom_css_textarea' ).show();
        return false;
    } else {
        $( global ).load( loadAce );
    }
    global.aceSyncCSS = syncCSS;
} )( this, jQuery );

function wpsSyncCss(){
    jQuery('.rt-custom-css').each(function(){
        var e = ace.edit( jQuery(this).find('.custom-css').attr('id') );
        jQuery(this).find('.custom_css_textarea').val( e.getSession().getValue() );
    });
}
function rtWPSSettings(e){
    wpsSyncCss();
    jQuery('rt-response').hide();
    var arg = jQuery( e ).serialize();
    var bindElement = jQuery('.rtSaveButton');
    wpsAjaxCall( bindElement, 'rtWPSSettings', arg, function(data){
        if(data.error){
            jQuery('.rt-response').addClass('updated');
            jQuery('.rt-response').removeClass('error');
            jQuery('.rt-response').show('slow').text(data.msg);
        }else{
            jQuery('.rt-response').addClass('error');
            jQuery('.rt-response').show('slow').text(data.msg);
        }
    });

}


function wpsAjaxCall( element, action, arg, handle){
    var data;
    if(action) data = "action=" + action;
    if(arg)    data = arg + "&action=" + action;
    if(arg && !action) data = arg;

    var n = data.search(wps.nonceID);
    if(n<0){
        data = data + "&"+ wps.nonceID + "=" + wps.nonce;
    }
    jQuery.ajax({
        type: "post",
        url: wps.ajaxurl,
        data: data,
        beforeSend: function() { jQuery("<span class='rt-loading'></span>").insertAfter(element); },
        success: function( data ){
            jQuery(".rt-loading").remove();
            handle(data);
        }
    });
}
