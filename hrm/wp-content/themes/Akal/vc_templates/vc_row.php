<?php

	$output = $el_class = $style = $style1 = '';
	global $brad_includes;
    extract(shortcode_atts(array(
	    'sid' => '' ,
		'padding' => 'default' ,
		'vpadding'  => 'default',
		'color_scheme' => '' ,
        'section_type' => '',  
		'equal_height' => 'no',
	    'sp_top' => '0' ,
		'sp_bottom' => '0' ,
	    'enable_border' => 'no' ,
		'enable_bottom_border' => 'no' ,
	    'background_color'=>'#ffffff',
	    'background_image'=>'',
		'bg_type' => '',
		'fb_image' => '',
		'bg_video_mp4' => '',
		'bg_video_ogg' => '',
		'bg_video_webm' => '',
		'background_style'=>'stretch',
		'fixed_bg'=>'no',
		'video_ratio'=>'',
	    'enable_parallax'=>'no',
		'parallax_speed' => '1',
		'bg_overlay' => 'no' ,
		'height' => 'content',
		'bg_overlay_color' => '',
		'bg_overlay_opacity' => '0.4',
		'bg_overlay_dot' => 'no',
		'enable_triangle' => 'no',
		'triangle_color' => '' ,
		'triangle_location' => 'top' ,
		'el_class' => '' ), $atts));
	
	$next_sc = $prev_sc = false ;
	
		
    $el_class = $this->getExtraClass($el_class);
	
	if ($this->settings['base']=='vc_row_inner') :
	
		$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'row-fluid element-padding-'.$padding.' element-vpadding-'.$vpadding.' '.$el_class, $this->settings['base']);
		$output .= '<div class="'.$css_class.'">';
		$output .= wpb_js_remove_wpautop($content);
		$output .= '</div>'.$this->endBlockComment('row');
	
	else :

	  $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'section content-box '.$color_scheme.' '.$section_type.' section-border-'.$enable_border.' section-bborder-'.$enable_bottom_border.' section-height-'.$height.' section-bgtype-'.$bg_type.' section-fixed-background-'.$fixed_bg.'  section-bgstyle-'.$background_style.' section-triangle-'.$enable_triangle.' triangle-location-'.$triangle_location.' parallax-section-'.$enable_parallax.' section-overlay-'.$bg_overlay.' section-overlay-dot-'.$bg_overlay_dot.' '.$el_class, $this->settings['base']);
	  
	  $sp_top = ($sp_top == '0' || $sp_top == 0 ) ? 0 : $sp_top.'px';
	  $sp_bottom = ($sp_bottom == '0' || $sp_bottom == 0 ) ? 0 : $sp_bottom.'px'; 
	  $style .= "padding-top:{$sp_top};padding-bottom:{$sp_bottom};";
	  
	  if( $background_color != ''){
		  $style .= "background-color:{$background_color};";
	  }
	  if( $background_image != '' ){
		   $img_id = preg_replace('/[^\d]/', '', $background_image);
		   $img_src =  wp_get_attachment_image_src( $img_id , '');
		   if( is_array($img_src) ) {
			   $img_src = $img_src[0];
			  } 
		   else {
			   $img_src = '';
			   }
		  $style .= "background-image:url({$img_src});";
	  }
	  
  
	  $current_id = $sid != '' ? $sid : 'section_'.rand() ;
	  
		  
		  if( $enable_triangle == 'yes' &&  $triangle_color != '' ) {
			  $output .= "<style type='text/css' scoped>#{$current_id}:after{border-top-color:{$triangle_color}}#{$current_id}.triangle-location-bottom:after{border-bottom-color:{$triangle_color}}</style>";
		}
		  
		  if( $bg_overlay == 'yes' && $bg_overlay_color != '' ):
			  $rgb = brad_hex2rgb($bg_overlay_color);
			  $overlay_rgb = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].','.$bg_overlay_opacity.')';
			  $style1.= "background-color:{$overlay_rgb}";
		  endif;
  
	
	  $output .= '<section id="'. $current_id .'" class="'.$css_class.'"  style="'.$style.'" data-video-ratio="'.$video_ratio.'" data-parallax-speed="'. $parallax_speed .'" >';
	  
	  if ($bg_type == "video" ) {
		  $brad_includes['load_mediaelement'] = true;
		  if( $fb_image != '' ){
			  $img_id = preg_replace('/[^\d]/', '', $fb_image);
			  $img_src =  wp_get_attachment_image_src( $img_id , '');
			  $img_src = $img_src[0];
		  } 
		  else {
			 $img_src = '';
		  }
	  $output .= '<video class="section-bg-video" poster="'.$img_src.'"  preload="auto" autoplay loop="loop" muted="muted">';	
		  if($bg_video_mp4 != ""){
			  $output .= '<source src="'.$bg_video_mp4.'" type="video/mp4">';
		  }
		  if ($bg_video_webm != "") {
			  $output .= '<source src="'.$bg_video_webm.'" type="video/webm">';
		  }
		  if ($bg_video_ogg != "") {
			  $output .= '<source src="'.$bg_video_ogg.'" type="video/ogg">';
		  }
	  $output .= '</video>';
	  }
  
	  $output .= '<div class="section-overlay" style="'.$style1.'"></div>';
	  $output .= '<div class="container section-content"><div class="row-fluid"><div class="row-fluid equal-cheight-'.$equal_height.'  element-padding-'.$padding.' element-vpadding-'.$vpadding.'">';
	  $output .= wpb_js_remove_wpautop($content);
	  $output .= '</div></div></div></section>'.$this->endBlockComment('section');
	endif;
	
	
    echo $output;
