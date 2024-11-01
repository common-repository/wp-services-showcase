(function() {
    tinymce.create('tinymce.plugins.wspIcon', {
        init : function(ed, url) {
            ed.addButton('wps_icon', {
                title : 'Wp Services Generator',
                image : url+'/icon.png',
                onclick : function() {
                    jQuery('.wps-constructor-apply').unbind('click');
                    jQuery('.wps-constructor-apply').bind('click', function(event) {
                        var params = jQuery('#wps-sc-params').serializeArray();
                        var sc = "[service";
                        jQuery.each(params,function(index, item){
                            if(item.value){
                                sc = sc + ' ' + item.name + '="' + item.value +'"';
                            }
                        });
                        sc = sc + "]";
                        if (sc) {
                            ed.execCommand('mceInsertContent', false, sc);
                        }
                        jQuery.colorbox.resize();
                        jQuery.colorbox.close();
                    });
                    jQuery("#wps-constructor-box").click();
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "FontAwesome Constructor",
                author : 'Alexey Golubnichenko',
                authorurl : 'https://github.com/AGolubnichenko',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('wps_icon', tinymce.plugins.wspIcon);
})();