<?php

	 $fbox_id = rand() ; 
	 $output = ''; 
     extract(shortcode_atts(array(
	  'columns' => '2' , 
	  'style' => 'style1' ,  
	  'padding' => '' ,
	  'fc_align' => 'no' ,
	  'vpadding' => '',
	  'fi_align' => 'no',
	  'bg_color' => '#ffffff' , 
	  'inner_vpadding' => "default" ,
	  'inner_hpadding' => "default" ,
	  'divider' => 'no' ,
	  'di_style' => 'style1' ,
	  'di_color' => 'default',
	  'di_type' => 'tiny',
	  'border_color' => '' ,
	  'border_opacity' => '' ,
	  'bg_opacity' => "1",
	  "bg_shadow" => "no" ,
	  'bg_radius' => 'yes' , 
	  'box_style' => 'style1' , 
	  'icon_size' => 'normal' ,  
	  'icon_style' => 'style1' , 
	  'icon_side' => 'left', 
	  'icon_bw' => '1', 
	  'icon_c' => '' ,
	  'icon_br' => '50%' ,
	  'icon_c_opc' => '1' ,
	  'icon_bc' => '' ,
	  'icon_bc_opacity' => '1' ,
	  'icon_bgc' => '' ,
	  'icon_bgc_opacity' => '1' ,
	  'icon_c_hover' => '' ,
	  'icon_c_opc_hover' => '' , 
	  'icon_bgc_hover' => '' ,
	  'icon_bgc_opacity_hover' => '1' ,
	  'enable_crease' => 'no' , 
	  'el_class' => '',
	  'bottom_margin' => '0'),$atts));

     if($columns == '' || empty($columns)) { $columns = 2; }

	 $bottom_margin = $bottom_margin == 0 ? 0 : $bottom_margin.'px';
	 
	 /* Css Styles for feature box */
	 $output .= "<style type='text/css' scoped>#feature_boxes_{$fbox_id} .feature_box > .brad-icon{";
	 
	 if( $icon_style == 'style2' || $icon_style == 'style3'){
		 $output .= "-webkit-border-radius:{$icon_br};border-radius:{$icon_br};";
	 }
	 
	 if( $icon_c != '' ){
		 $rgb = brad_hex2rgb($icon_c);
		 $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$icon_c_opc})";
		 $output .=  "color:{$icon_c};color:{$rgba};";
	 }
	 if( $icon_bc != '' && $icon_style == 'style2' ){
		  $rgb = brad_hex2rgb($icon_bc);
	     $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$icon_bc_opacity})";
		 $output .=  "border-color:{$icon_bc};border-color:{$rgba};";
		 $output .= 'border-width:'.intval($icon_bw).'px;';
	 }
	 if( $icon_bgc != '' && $icon_style == 'style3' ){
		  $rgb = brad_hex2rgb($icon_bgc);
	     $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$icon_bgc_opacity})";
		 $output .=  "background-color:{$icon_bgc};background-color:{$rgba};";
	 }
	 $output .= "}";
	 
	 if( ( $icon_bgc_hover != '' || $icon_c_hover != '' ) && ( $icon_style == 'style3' || $icon_style == 'style2')){
		 $output .= "#feature_boxes_{$fbox_id} .feature_box:hover > .brad-icon{";
		 if( $icon_bgc_hover != ''){
			 $rgb = brad_hex2rgb($icon_bgc_hover);
			 $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},$icon_bgc_opacity_hover)";
			 $output .=  "background-color:{$rgba};border-color:{$rgba};";
		 }
		 if($icon_c_hover != '' ){
			 $rgb = brad_hex2rgb($icon_c_hover);
		     $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$icon_c_opc_hover})";
			 $output .=  "color:{$icon_c_hover};color:{$rgba};";
		 }
		 $output .=  "}";
	 }
	 
	 if( ( $bg_color != '' || $border_color != '' ) && $style == 'style3' ){
		 $output .= "#feature_boxes_{$fbox_id} .span .inner-content{";
		 if( $bg_color != '' ){
		     $rgb = brad_hex2rgb($bg_color);
		     $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$bg_opacity})";
		     $output .= "background-color:{$bg_color};background-color:{$rgba};";
		 }
		 if( $border_color != '' ){
			 $rgb = brad_hex2rgb($border_color);
		     $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$border_opacity})";
		     $output .= "border-color:{$border_color};border-color:{$rgba};";
			}
		 $output .= "}";
	 }
	 
	 $output .= "</style>";
	 
	 $el_class = $this->getExtraClass($el_class);
	 $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'row-fluid '.$style.' background-shadow-'.$bg_shadow.' background-radius-'.$bg_radius.' feature_boxes box-'.$box_style.' enable-hr-'.$divider.' element-vpadding-'.$vpadding.' hr-type-'.$di_type.' hr-color-'.$di_color.' hr-style-'.$di_style.' '.$icon_size.'-size element-inner-vertical-padding-'.$inner_vpadding.' element-inner-horizental-padding-'.$inner_hpadding.' icon-side-'.$icon_side.'  iconbox-'.$icon_style.'  align-content-center-'. $fc_align.' align-icon-center-'.$fi_align.' columns-'.$columns.' crease-background-'.$enable_crease.' element-padding-'.$padding.' '.$el_class.' ', $this->settings['base']);

	 $output .= "\n\t".'<div id="feature_boxes_container_'.$fbox_id.'" class="clearfix" style="margin-bottom:'.$bottom_margin.'">';
     $output .= "\n\t\t".'<div id="feature_boxes_'.$fbox_id.'" class="'.$css_class.'">';
     $output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
	 $output .= "\n\t\t".'</div>';
     $output .= "\n\t".'</div>'.$this->endBlockComment('feature_boxes')."\n";
     echo $output;	
	