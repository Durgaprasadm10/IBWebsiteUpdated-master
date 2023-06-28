<?php 


	  $brad_icon_id = rand() ;
	  $out = $li_after = $li_before = '';
	  
	  extract(shortcode_atts(array(
		  'icon' => '' , 'size' => 'small' ,'style' => 'style1' , 'align' => '' , 'color' => '' , 'color_hover' => '' ,'bg_color' => '' , 'bg_color_hover' => ''  , 'border_color' => ''  , 'border_width' => '1' , 'lb' =>'no' , 'link' => '' , 'enable_crease' => 'no' , 'alpha' => '' , 'css_animation' => '',
	  'css_animation_delay' => 0 
	  ), $atts));
	  
	  if( $link != ''){
		  $li_before = '<a href="'.$link.'"';
		  if($lb == 'yes') $li_before .= ' rel="prettyPhoto[icon'. rand() .']"';
		  $li_before .= '>';
		  $li_after .= '</a>';
	  }
	  
	  $class = ' enable-crease-'.$enable_crease.' '.$size.'-size '.$style ;
	  $class .= brad_getCSSAnimation($css_animation);
	  $icon = !empty($alpha) ? "<span id='brad_vc_icon_{$brad_icon_id}' class='brad-icon icon-text {$class}' data-animation-delay='{$css_animation_delay}' data-animation-effect='{$css_animation}'>{$alpha}</span>" : brad_icon($icon,$class,"brad_vc_icon_{$brad_icon_id}" , true , "data-animation-delay='{$css_animation_delay}' data-animation-effect='{$css_animation}'");
	  
	  if( $color != '' || $color_hover != '' || $bg_color != '' || $bg_color_hover != '' || $border_color != '' ){
		  $out .= "<style type='text/css' scoped>#brad_vc_icon_{$brad_icon_id}{";
		  if( $color != ''){
			  $out .= "color:{$color};";
		  }
		  if( $bg_color != '' && $style == 'style3'){
			  $out .= "background-color:{$bg_color};";
		  }
		  if( $border_color != '' && $style == 'style2'){
			  $out .= 'border-width:'. intval($border_width) .'px;';
			  $out .= "border-color:{$border_color};";
		  }
		  $out .= "}";
		  
		  if( $bg_color_hover != '' || $color_hover != ''){
			  $out .= "#brad_vc_icon_{$brad_icon_id}:hover{";
			  if($bg_color_hover != '' || ( $style == 'style2' || $style == 'style3') ){
		
				  $out .= "background-color:{$bg_color_hover};border-color:{$bg_color_hover};";
			  }
			  if($color_hover){
				  $out .= "color:{$color_hover};";
			  }
			  $out .= "}";
		  }
		  $out .= "</style>";
	  }
	 
	  if( $align == 'center'){ 
		   $out .= "\n\t".'<p class="sp-container textcenter">'. $li_before . $icon . $li_after.'</p>';
	  }
	  else{
		 $out .= "\n\t". $li_before.$icon.$li_after;
	  }

	  echo $out;
 