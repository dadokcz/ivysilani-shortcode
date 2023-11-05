(function() {
    tinymce.create('tinymce.plugins.wp_iVysilani', {
        init : function(ed, url) {
   
 
            ed.addButton('wp_iVysilani_video', {
                title : 'Enter valid URL of iVysilani.cz',
                cmd : 'wp_iVysilani_video',
                image : url + '/wp_ivysilani.png'
            });
 
            ed.addCommand('wp_iVysilani_video', function() {
                var number = prompt("Enter valid URL"), shortcode;
                if (number !== null && number != '') {
                        
                        shortcode = '[ivysilani url="' + number + '" width="100%" height="400" /]';
                        ed.execCommand('mceInsertContent', 0, shortcode);

                }
            });
        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'wp_iVysilani', tinymce.plugins.wp_iVysilani );
})();