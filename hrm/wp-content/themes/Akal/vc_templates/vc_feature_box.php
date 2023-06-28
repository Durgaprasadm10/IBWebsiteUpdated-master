<?php

/*Feature Boxes
------------------------------------------------*/

	global $ss_air , $ss_social , $fa_icons ;	 
	$output = $title = $description = $readmore = $readmore_link = $icon = $image = $fe_before = $fe_after = $tl_before = $tl_after ='';
	extract(shortcode_atts(array(
	  'title' =>  '' , 
	  'feature_link' => '',
	  'title_link' => '',
	  'icon_link' => '',
	  'ftarget' => '' ,
	  'itarget' => '',
	  'ttarget' => '' ,
	  'description' =>  '' ,    
	  'icon' =>  '' , 
	  'text' => '' ,
	  'sub_title' => '' ,
	  'title_heading' => '' ,
	  'image' =>  '' ,
	  'css_animation' => '' ,
	  'css_animation_delay' => '0' ,
	  'css_animation_type' => 'box'),$atts));
	 $before_title = '';
	 
	 if($css_animation_type == 'iconbox'){
		 $el_class1 =  brad_getCSSAnimation($css_animation);
		 $el_class2 = '';
	 }
	 else{
		 $el_class1 = '';
		 $el_class2 = brad_getCSSAnimation($css_animation);
	 }
	 
	 if( $image != "" ) { 
		 $img_id = preg_replace('/[^\d]/', '', $image);
		 $img_src =  wp_get_attachment_image_src( $img_id , '');
		 $before_title = '<span class="brad-icon '.$el_class1.' image" data-animation-delay="'.$css_animation_delay.'" data-animation-effect="'.$css_animation.'"><img src="'.$img_src[0].'" alt="" /></span>';
	 }
	 
	 else if( $text != '') { 
		 $before_title = '<span class="brad-icon icon-text '.$el_class1.'" data-animation-delay="'.$css_animation_delay.'" data-animation-effect="'.$css_animation.'">'.$text.'</span>';
	 }
	 
	 else if($icon != "") {
		 $before_title = brad_icon($icon,$el_class1,'',true, 'data-animation-delay="'. $css_animation_delay .'" data-animation-effect="'. $css_animation.'"');
	 }
	 
	 
	 
	 
	 $ex_class = empty($content) ? 'no-content' : '';
	 
	 if($feature_link != ''){
		 $fe_before = '<a href="'. $feature_link .'" class="fake-link"  target="'.$ftarget.'">&nbsp;</a>';
	 }
	
	 
	 if($title_link != ''){
		 $tl_before = '<a href="'.$title_link.'" target="'.$ttarget.'">';
		 $tl_after = '</a>';
	 }
	 
	 $output = '<div class="span"><div class="inner-content '. $el_class2 . '" data-animation-delay="'.$css_animation_delay.'" data-animation-effect="'.$css_animation.'">'. $fe_before .'<div class="feature_box '.$ex_class.'">';
	 
	 $output .= $before_title;
	 if(empty($title_heading)) $title_heading = 'h4';
	 if( $title != '' || $sub_title != '' ) { 
		 $output .= '<div class="heading"><div class="heading-content">';
		 if($sub_title != ''){
			 $output .= '<div class="subtitle">'.$sub_title.'</div>';
		 }
		 if($title != ''){
			 $output .= '<'.$title_heading.'>'.$tl_before.$title.$tl_after.'</'.$title_heading.'>';
		 }
		 $output .= '</div><div class="hr"><span></span></div></div>';
	 }
	 
	  
	 if( $content != '' ) { 
		 $output .= '<div class="feature-content">'.wpb_js_remove_wpautop($content).'</div>';
	 }
	 
	 
	 $output .= '</div></div></div>';
	 echo $output;
  