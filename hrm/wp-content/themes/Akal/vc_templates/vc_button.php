<?php

	$button_id = rand();	
	$output = $color = $size = $icon = $target = $href = $title = $position = '';
    extract(shortcode_atts(array(
       'style' => 'default',
	   'align' => '',
       'size' => '',
       'icon' => '',
	   'lb'  => 'no',
	   'icon_style' => '',
	   'icon_align' => 'right',
	   'icon_ds' => 'hover' ,
	   'icon_size' => 'normal',
       'target' => '_self',
       'href' => '',
	   'icon_c' => '' ,
	   'icon_c_hover' => '' ,
	   'icon_bc' => '' ,
	   'icon_bgc' => '' ,
	   'icon_bgc_hover' => '' ,
       'title' => __('Text on the button', "brad-framework"),
       'position' => '' ), $atts));
        $a_class = '';

       if ( $target == 'same' || $target == '_self' ) { 
	       $target = '';
	   }
	   
	 
	   
       $target = ( $target != '' ) ? ' target="'.$target.'"' : '';
       $color = ( $style != '' ) ? 'button_'.$style : '';
       $size = ( $size != '' && $size != 'default' ) ? ' button_'.$size : ' '.$size;
       $icon =   $style == 'readmore' ? brad_icon($icon  , $icon_style , '' , true ) : brad_icon($icon  , $icon_style , '' , false );
	   $ex_class = !empty($icon) ? ' btn-with-icon' : '';
	   
	   if( $style == 'readmore'){
		   $class = 'readmore  icon-align-'.$icon_align . ' visible-'. $icon_ds . $ex_class;
	   }
	   else {
		   $class = 'button button_'.$style.' '.$size.' '.$color.' icon-align-'.$icon_align . ' visible-'. $icon_ds . $ex_class ;
	   }
	   
	   if( $style == 'readmore' && ( $icon_bc != '' || $icon_c != '' || $icon_c_hover != '' || $icon_bgc != '' || $icon_bgc_hover != '' )){
		   $output .= "<style type='text/css' scoped>";
		   if( $icon_c_hover != '' || ( $icon_bgc_hover != "" && ( $icon_style == 'style2' || $icon_style == 'style3')) ){
		       $output .= "#brad_button_{$button_id}:hover .brad-icon{ ";
			   if( $icon_c_hover != '' ):
			       $output .= "color:{$icon_c_hover};";
			   endif;
			   if( $icon_bgc_hover != "" && ( $icon_style == 'style2' || $icon_style == 'style3')):
			        $output .= "background-color:{$icon_bgc_hover};border-color:{$icon_bgc_hover};";
			   endif;
			$output .= "}";
	     }
		   
		   if($icon_bc != '' || $icon_c != '' || $icon_bgc != '' ):
		       $output .= "#brad_button_{$button_id} .brad-icon{";
		       if( $icon_c != ''){
			       $output .= "color:{$icon_c};";
		       }
		       if( $icon_bc != '' && $icon_style == 'style2'){
			      $output .= "border-color:{$icon_bc};";
	           }
		       if( $icon_bgc != '' && $icon_style == 'style3'){
			       $output .= "background-color:{$icon_bgc};";
	           }
		      $output .= "}";
		   endif;
		   $output .= "</style>";
	   }
	   
	   if( $align == 'center' ){ $output .= '<p class="sp-container aligncenter">'; }
	  
       if ( $href != '' ) {
		   $lightbox = $lb == 'yes' ? ' rel="prettyPhoto[button'. rand() .']"' : '' ;
		   
           $output .= '<a id="brad_button_'.$button_id.'" class="'.$class.'" title="'.$title.'" href="'.$href.'" '.$target.' '.$lightbox.'>';
		   if( $icon_align != 'right' ) {
			   $output .= $icon;
		   }
		   $output .= '<span>'.$title.'</span>';
		   if( $icon_align == 'right'){
			   $output .= $icon;
		   }
		   $output .= '</a>';
       } 
       else {
          $output .= '<span id="brad_button_'.$button_id.'" class="'.$class.'">';
		   if( $icon_align != 'right' ) {
			   $output .= $icon;
		   }
		   $output .= $title;
		   if( $icon_align == 'right'){
			   $output .= $icon;
		   }
		   $output .= '</span>';
	   }
	   if( $align == 'center' ){ $output .= '</p>'; }
       $output .= $this->endBlockComment('button') . "\n";
       echo $output;
