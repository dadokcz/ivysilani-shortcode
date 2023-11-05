<?php

/*
Plugin Name: iVysilani Shortcode
Plugin URI: http://wordpress.org/extend/plugins/ivysilani-shortcode/
Description: Embed customized iVysílání (CZ) videos anywhere using shortcodes
Version: 3.0
Author: Ondřej Dadok
Author URI: http://www.dadok.cz/
License: GPL2
*/

/*****************************************************************************
*
*	Function - Ondřej Dadok - iVysilani Shortcode
*
*****************************************************************************/





function iVysilani_shortcode($params = array()) {

	// default parameters
	extract(shortcode_atts(array(
		'title' => 'iVysílání',
		'id' 	=> 'ivysilani',
	    'url' 	=> '',
	    'width' 	=> '100%',
	    'height' 	=> 400
	), $params));


	if(!empty($url)){

		include_once('lib/simple_html_dom.php');

		$html = ivysilani_file_get_html($url);
		$programmePlayer = $html->find('span[class=media-ivysilani-placeholder]', 0)->outertext;
		$programmePlayerArray = explode('"', $programmePlayer);

		$url_video = $programmePlayerArray[5];
		// %20

		if(empty($programmePlayerArray[5])){
			
			$new_url = 'http://www.ceskatelevize.cz/'.$html->find('a.buttonProgrammePage', 0)->href;

			$html = ivysilani_file_get_html($new_url);

			$programmePlayer = $html->find('span[class=media-ivysilani-placeholder]', 0)->outertext;
			$programmePlayerArray = explode('"', $programmePlayer);

			$url_video = $programmePlayerArray[5];
			// %20

		}


		
		$output.= '
		
		<iframe id="iFramePlayer" src="'.$url_video.'" 
		width="'.$width.'" 
		height="'.$height.'" 
		border="no"
		frameborder="no"
		style="border-style: none;" 
		scrolling="no" class="iVysilaniPlayer"></iframe>
		';
		
		
		$output__.= "
		<script>
		
        jQuery(document).ready(function() {
			
		jQuery(window).resize(function(){
			var width = jQuery('#blog-cont').width();
			
	      	$('#blog-cont').attr('width', ''+width);
	      	$('#blog-cont iframe').attr('width', width);
	      	
	      	$('.iVysilaniPlayer').attr('width', width);
	      	$('.iVysilaniPlayer, .iVysilaniPlayer *').attr('src', 'http://www.seznam.cz');
	      	
	      				
	      	
	    });
	    
			     
					 var width = jQuery('#blog-cont').width();
					 
					 $('.iVysilaniPlayer').attr('width', ''+width);
		});
		</script>
		";
		
			
		
		
		return $output;

	}
}

add_shortcode('ivysilani', 'iVysilani_shortcode');


add_action( 'init', 'ivysilani_buttons' );
function ivysilani_buttons() {
	    add_filter( "mce_external_plugins", "iVysilani_add_buttons" );
	    add_filter( 'mce_buttons', 'iVysilani_register_buttons' );
}
function iVysilani_add_buttons( $plugin_array ) {
	    $plugin_array['wp_iVysilani'] = plugins_url().'/'.plugin_basename(dirname(__FILE__)).'/wp_ivysilani.js';
	    return $plugin_array;
}
function iVysilani_register_buttons( $buttons ) {
	    array_push( $buttons, 'wp_iVysilani_video' ); // dropcap', 'recentposts
	    return $buttons;
}


