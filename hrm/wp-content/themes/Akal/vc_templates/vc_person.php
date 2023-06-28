<?php

/* Person
--------------------------------------------------*/

		 $output = $social = '';
		 
		 $person_id = rand();
		 
		 extract(shortcode_atts(array(
		   'image' => '' ,
		   'name' => '',
		   'role' => '',
		   'bio'  => '',
		   'social_links' => '',
		   'twitter' => '',
           'facebook' => '',
           'youtube' => '',
           'google' => '',
           'linkedin' => '',
		   'behance' => '',
		   'dribbble' => '' ,
		   'pinterest' => '',
		   'bg_color' => '',
		   'color' => '',
		   'heading_color' => '',
		   'icon_color' => '',
		   'icon_color_hover' => '',
		   'bg_color_overlay' => '',
		   'bg_overlay_opacity' => '1',
		   'overlay_color' => '',
		   'overlay_content' => '',
		   'di_color' => '',
	        ),$atts));
		 
		 $social_links = explode ("," , $social_links);
		 
		 if( in_array('facebook',$social_links) || in_array('twitter',$social_links) || in_array('youtube',$social_links) || in_array('dribbble',$social_links) || in_array('linkedin',$social_links) || in_array('pinterest',$social_links) || in_array('behance',$social_links) || in_array('google',$social_links) ) {
		 $social = '<div class="social-icons-wrapper"><ul class="social-icons">';
		 if( in_array('facebook',$social_links) && $facebook != '') {
			 $social .= '<li > <a class="facebook" href="' .$facebook. '" target="_blank" title="Facebook"><i class="fa-facebook"></i></a></li>';
		 }
		 
		 if( in_array('twitter',$social_links) && $twitter != '') {
			 $social .= '<li > <a class="twitter" href="' .$twitter. '" target="_blank" title="twitter"><i class="fa-twitter"></i></a></li>';
		 }
		 
		 if( in_array('linkedin',$social_links) && $linkedin != '') {
			 $social .= '<li > <a class="linkedin" href="' .$linkedin. '" target="_blank" title="linkedin"><i class="fa-linkedin"></i></a></li>';
		 }
		 
		 if( in_array('dribbble',$social_links) && $dribbble != '') {
			 $social .= '<li > <a class="dribbble" href="' .$dribbble. '" target="_blank" title="dribbble"><i class="fa-dribbble"></i></a></li>';
		 }
		 
		  if( in_array('behance',$social_links) && $behance != '') {
			 $social .= '<li><a class="behance" href="' .$behance. '" target="_blank" title="behance"><i class="fa fa-behance"></i></a></li>';
		 }
		 
		  if( in_array('youtube',$social_links) && $youtube != '') {
			 $social .= '<li><a class="youtube" href="' .$youtube. '" target="_blank" title="youtube"><i class="fa-youtube"></i></a></li>';
		 }
		 
		  if( in_array('pinterest',$social_links) && $pinterest != '') {
			 $social .= '<li > <a class="pinterest" href="' .$pinterest. '" target="_blank" title="pinterest"><i class="fa-pinterest"></i></a></li>';
		 }
		 
		  if( in_array('google',$social_links) && $google != '') {
			 $social .= '<li > <a class="google" href="' .$google. '" target="_blank" title="google plus"><i class="fa-google-plus"></i></a></li>';
		 }
		$social .= '</ul></div>';
		 }
		 
		if( $icon_color != ''){
			$output .= "<style type='text/css' scoped>#person_{$person_id} .social-icons li a{color:{$icon_color};}#person_{$person_id} .social-icons li a:hover{color:{$icon_color_hover};}</style>";
		}
		 
		$output .= "\n\t".'<div id="person_'. $person_id .'" class="person" style="background-color:'.$bg_color.'">';
		
		if( $bio != ''){
			$bio = '<p>'. $bio .'</p>';
		}
		
		if($image != ''){
		  $img_id = preg_replace('/[^\d]/', '', $image);
		  $img =   wp_get_attachment_image_src( $img_id , '');
		  $output .= '<div class="image hoverlay"><img src="'.$img[0].'" alt="'.$name.'" />';
		  if($content != ''){
			  $style1 = $style2 = '';
			  if( $overlay_color != ''){ $style2 = " style='color:{$overlay_color}!important;'";}
			  if( $bg_color_overlay != ''){ $rgb = brad_hex2rgb($bg_color_overlay); $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$bg_overlay_opacity})";$style1 = " style='background-color:{$rgba}!important;'";}
			  $output .= '<div class="overlay" '.$style1.'><div class="overlay-content" '.$style2.'>'. wpb_js_remove_wpautop($content) .'</div></div>';
		  }
		  $output .= '</div>';
		}
		
		$style1 = $style2 = $style3 = '';
		
		if( $heading_color != ''){ $style1 = " style='color:{$heading_color};'";}
		if( $color != ''){ $style2 = " style='color:{$color}'";}
		if( $di_color != ''){ $style3 = " style='background-color:{$di_color}'";}
		
		$output .= "\n\t\t".'<div class="person-info" '.$style2.'>';
		if($name != '' ) { $output .= "\n\t\t\t".'<h4 '.$style1.'>'.$name.'</h4>';}
		if($role != '' ) { $output .= "\n\t\t\t\t".'<p class="role">'.$role.'</p>';}
		$output .=  wpb_js_remove_wpautop($bio) .'<div class="divider"><span '.$style3.'></span></div>'  . $social ;
		$output .= "\n\t\t".'</div>';
		$output .= "\n\t".'</div>';
		echo $output;