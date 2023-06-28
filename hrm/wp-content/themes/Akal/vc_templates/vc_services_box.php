<?php

/*Service Box
--------------------------------------------------------------*/

	  $output = $i_style = $t_style = $c_style = $ft_style = $fc_style = $se_before = $se_after = '';
	  extract(shortcode_atts(array(
	  'radius' => '5px',
	  'title' =>  '' , 
	  'height' => '' , 
	  'title_flip' => '' ,
	  'desc' =>  '' ,    
	  'icon' =>  '' ,
	  'icon_style' => 'style1' ,
	  'icon_radius' => '50%',
	  'icon_size' => 'ex_large',
	  'icon_c' => '',
	  'icon_bc' => '',
	  'icon_bgc' => '',
	  'link'  => '',
	  'target' => '',
	  'bg_front' => '',
	  'bc_front' => '',
	  'c_front' => '',
	  "c_content" => '',
	  'bg_flip'  => '',
	  'bc_flip'  => '',
	  'c_flip'  => '',
	  'c_content'  => '',
	  'bg_flip'  => '',
	  'c_flip'  => '',
	  'c_content_flip'  => ''
	   ),$atts));
	   
	   if($link != ''){
		  $se_before = '<a class="fake-link" href="'.$link.'" target="'.$target.'"></a>';
	  }
	  
	  $flip_style =  $front_style = "-webkit-border-radius:{$radius};-moz-border-radius:{$radius};border-radius:{$radius};";
	  
	  if($bg_front != '') $front_style .= "background-color:{$bg_front};";
	  if($bc_front != '') $front_style .= "border:1px solid {$bc_front};";
	  $ex_class = ( $content != '' || $title_flip != '' ) ? 'yes' : 'no';
	  $ex_class1 = intval($height) > 0 ? ' style="min-height:'.intval($height).'px;height:'.intval($height).'px;"' : '';
	  
	  $output = '<div class="service-box flip-'. $ex_class .' hoverlay"><div class="front-content" style="'.$front_style.'"><div '.$ex_class1.'><div>';
	  
	   if($icon != "") {
		   
		   $i_style .= " -webkit-border-radius:{$icon_radius};-moz-border-radius:{$icon_radius};border-radius:{$icon_radius};";
		   if( $icon_c != '') $i_style .= "color:{$icon_c};";
		   if( $icon_bc != '' && $icon_style == 'style2') $i_style .= "border-color:{$icon_bc};";
		   if( $icon_bgc != '' && $icon_style == 'style3') $i_style .= "background-color:{$icon_bgc};";
		   $output .= brad_icon($icon , 'service-icon '. $icon_style .' '. $icon_size.'-size ' , '' , true , 'style="'.$i_style.'"' , true );
		   
	   }
	   
	   
	   if( $title != '' ) { 
		   if($c_front != '') $t_style .= "color:{$c_front}!important;";
		   $output .= '<h4  style="'.$t_style.'">'.$title.'</h4>';
	   }
	   
  
	   if( $desc != '' ) { 
		   if($c_content != '') $c_style .= "color:{$c_content}!important;";
		   $output .= '<div class="service-content" style="'.$c_style.'">'.$desc.'</div>';
	   }
	   
	   $output .= '</div></div></div>';
	   
	   if($content != '' || $title_flip != ''){
		   
		   if($bg_flip != '') $flip_style .= "background-color:{$bg_flip};";
		   if($bc_flip != '') $flip_style .= "border:1px solid {$bc_flip};";
		   $output .= '<div class="flip-content" style="'.$flip_style.'"><div><div>';
		   
		   if( $title_flip != ''){
			   if($c_flip != '') $ft_style .= "color:{$c_flip}!important;";
			   $output .= '<h4 style="'.$ft_style.'">'. $title_flip .'</h4>';
		   }
		   
		   
		   if($content != ''){
			   if($c_content_flip != '') $fc_style .= "color:{$c_content_flip}!important;";
			   $output .= '<div class="service-content" style="'.$fc_style.'">'. wpb_js_remove_wpautop($content) .'</div>';
		   }
		   
		   $output .= '</div></div></div>';
	   }
	   
	   $output .= $se_before.'</div>';
	   
	   echo $output;
?>	 