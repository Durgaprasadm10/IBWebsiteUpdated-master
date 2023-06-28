 
 
jQuery(document).ready(function ($) {
	'use strict';



var	$slider_elements = $('#brad_bradslider , #brad_slider_parallax , #brad_slider_height , #brad_slider_nav , #brad_slider_pagination , #brad_ht_responsive , #brad_slider_fullheight , #brad_slider_interval , #brad_slider_swipe , #brad_slider_effect') ,
	$titlebar_elements = $('#brad_page_title , #brad_add_content ,  #brad_titlebar_alignment , #brad_title_height , #brad_titlebar_bg_color , [data-field_id="brad_bg_image_titlebar"]  , #brad_titlebar_bg_cover , #brad_titlebar_bg_repeat , #brad_titlebar_bg_pos , #brad_titlebar_divi, #brad_titlebar_parallax , #brad_titlebar_scheme , #brad_titlebar_bg_opacity , #brad_titlebar_breadcrumb , #brad_titlebar_border , #brad_titlebar_size');


function checkTitlebar(){
		
		 var $header_content = $('#brad_header_content').attr('value');
		 
			if($header_content == 'bradslider'){
				
				$slider_elements.each(function(index, element) {
                    $(this).parents('.rwmb-field').stop(true,true).fadeIn(300);
                });
				
				$titlebar_elements.each(function(index, element) {
                    $(this).parents('.rwmb-field').stop(true,true).fadeOut(300);
                });
				$('#brad_rm_header_space').parents('.rwmb-field').stop(true,true).fadeOut(300);
				$('#brad_rev_slider').parents('.rwmb-field').stop(true,true).fadeOut(300);
		   
		   }
			else if( $header_content == 'revslider' ){
				
				$('#brad_rev_slider').parents('.rwmb-field').stop(true,true).fadeIn(300);
				$('#brad_rm_header_space').parents('.rwmb-field').stop(true,true).fadeOut(300);
				
				$slider_elements.each(function(index, element) {
                    $(this).parents('.rwmb-field').stop(true,true).fadeOut(300);
                });
				
				$titlebar_elements.each(function(index, element) {
                    $(this).parents('.rwmb-field').stop(true,true).fadeOut(300);
                });
				
				
				
			}
			
			else if( $header_content == 'none' ){
				
				$('#brad_rm_header_space').parents('.rwmb-field').stop(true,true).fadeIn(300);
				
				$('#brad_rev_slider').parents('.rwmb-field').stop(true,true).fadeOut(300);
				
				$slider_elements.each(function(index, element) {
                    $(this).parents('.rwmb-field').stop(true,true).fadeOut(300);
                });
				
				$titlebar_elements.each(function(index, element) {
                    $(this).parents('.rwmb-field').stop(true,true).fadeOut(300);
                });
				
			}
			
			
			else {
			    
				$titlebar_elements.each(function(index, element) {
                    $(this).parents('.rwmb-field').stop(true,true).fadeIn(300);
                })
				
				$slider_elements.each(function(index, element) {
                    $(this).parents('.rwmb-field').stop(true,true).fadeOut(300);
                });
				
				$('#brad_rev_slider').parents('.rwmb-field').stop(true,true).fadeOut(300);
				$('#brad_rm_header_space').parents('.rwmb-field').stop(true,true).fadeOut(300);
	
			}	
	}	
	
	
	$('#brad_header_content').change(checkTitlebar);
	checkTitlebar();
	
	
    $('#post-formats-select input').change(checkFormat);
	
	function checkFormat(){
		var format = $('#post-formats-select input:checked').attr('value');

		//only run on the posts page
		if(typeof format != 'undefined'){
			
			if(format == 'gallery'){
				$('#poststuff div[id$=slide][id^=post]').stop(true,true).fadeIn(500);
			}
			
			else {
				$('#poststuff div[id$=slide][id^=post]').stop(true,true).fadeOut(500);
			}
			
			$('#post-body div[id^=brad-metabox-post-]').hide();
			$('#post-body #brad-metabox-post-'+format+'').stop(true,true).fadeIn(500);			
		}
	}
	
	checkFormat();

	$('#page_template').change(checkPageSettings);
	
	function checkPageSettings(){
		var format = $('#page_template').attr('value');

		//only run on the page
		if(typeof format != 'undefined'){
			format = format.replace('.php', '');
			$('#post-body div[id^=brad_page_settings_]').hide();
			$('#post-body #brad_page_settings_'+format+'').stop(true,true).fadeIn(500);
					
		}
	
	}
	
	checkPageSettings();
	
});