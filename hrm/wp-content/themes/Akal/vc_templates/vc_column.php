<?php

      $output = $el_class = $width = $style = '';
      extract(shortcode_atts(array(
         'el_class' => '',
		 'hide_under' => '',
		 'color_scheme' => '' ,
		 'bg_overlay_color' => '',
		 'p_top' => '' ,
		 'p_bottom' => '',
		 'p_left' => '0',
		 'p_right' => '0' ,
		 'bg_overlay_opacity' => '0.4',
		 'background_color'=>'',
		 'bg_overlay' => 'no' ,
	     'background_image'=>'',
         'width' => '1/1' ), $atts));

     $el_class = $this->getExtraClass($el_class);
     $width = str_replace('vc_col-sm-' , 'span' , wpb_translateColumnWidthToSpan($width));
	 $hidden_class = '';
		if(!empty($hide_under)){
		  $hide_under = explode(",",$hide_under);
		  foreach($hide_under as $v){
			  $hidden_class .= ' hidden-'.$v;
		  }
		}
		
	if ($this->settings['base']=='vc_columns_inner') :
	
	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width.$el_class.$hidden_class, $this->settings['base']);
     $output .= "\n\t".'<div class="'.$css_class.'">';

     $output .= "\n\t\t".'<div class="inner-content">';
     $output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
     $output .= "\n\t\t".'</div> ';
     $output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";
	
	else:
	
	$p_top = preg_match('/%/i',$p_top) ||  preg_match('/%/i',$p_top)  ? $p_top : intval($p_top).'px';
	$p_bottom = preg_match('/%/i',$p_bottom) ||  preg_match('/%/i',$p_bottom)  ? $p_bottom : intval($p_bottom).'px';
	$p_left = preg_match('/%/i',$p_left) ||  preg_match('/%/i',$p_left)  ? $p_left : intval($p_left).'px';
	$p_right = preg_match('/%/i',$p_right) ||  preg_match('/%/i',$p_right)  ? $p_right : intval($p_right).'px';

	
	 if( $background_color != ''){
		 $style .= " background-color:{$background_color};";
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
	  
	 
	 
	 	
     $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'section-column '.$width.$el_class.$hidden_class, $this->settings['base']);
     $output .= "\n\t".'<div class="'.$css_class.'" style="'.$style.'">';
	 if( $bg_overlay_color != '' && $bg_overlay == 'yes'){
		 $rgb = brad_hex2rgb($bg_overlay_color);
		 $rgba = 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].','.$bg_overlay_opacity.')';
		 $output .= '<div class="section-overlay" style="background-color:'.$rgba.'"></div>';
	 }
	 
     $output .= "\n\t\t".'<div class="inner-content  content-box '.$color_scheme.'" style="padding-top:'.$p_top.';padding-bottom:'.$p_bottom.';padding-left:'.$p_left.';padding-right:'.$p_right.';">';
     $output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
     $output .= "\n\t\t".'</div> '.$this->endBlockComment('.inner-content');
     $output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";
	 endif;
     echo  $output;