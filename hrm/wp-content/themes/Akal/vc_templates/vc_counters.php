<?php

/*Counters
------------------------------------------------*/

	$output = $columns = $style = $bg_type = '';
	$counter_id = rand();
    extract(shortcode_atts(array(
	  'columns' => '2' , 
	  'style' => 'style1',
	  'text_size' => 'default' ,
	  'center' => 'no',
	  'icon_color' => '',
	  'value_color' => '',
	  'title_color' => '',
	  'bg_color' => '' , 
	  'divider' => 'no' ,
	  'di_style' => 'style1' ,
	  'di_color' => 'default',
	  'di_type' => 'tiny',
	  'border_color' => '',
	  "border_width" => "1" ,
	  'width' => '',
	  'height' => '' ,
	  "border_radius" => '50%'
	   ),$atts));

     if($columns == '' || empty($columns)) { $columns = 2; }
	 
	 $output .= "<style type='text/css' scoped>";
	 if($width != ''){
		 $output .= "#counter_{$counter_id} .counter-box-container{width:". intval($width)."px}";
	 }
	 if($height != ''){
		 $output .= "#counter_{$counter_id} .counter-box{height:". intval($height)."px}";
	 }
	 if($title_color != ''){
		 $output .= "#counter_{$counter_id} .counter-box .title{color:{$title_color}!important;}";
	 }
	 if($icon_color != ''){
		$output .= "#counter_{$counter_id} .counter-box .brad-icon{color:{$icon_color}!important;}"; 
	 }
	 if($value_color != ''){
		$output .= "#counter_{$counter_id} .counter-box .counter-value{color:{$value_color}!important;}"; 
	 }
	 
	 if( ( $bg_color != '' || $border_color != '')  ){
	        $output .= "#counter_{$counter_id} .counter-box{";
			if( $bg_color != '' ){
		        $output .= "background-color:{$bg_color};";
			}
			if( $border_color != '' ){
		        $output .= "border:". intval($border_width) ."px solid {$border_color};";
			}
			$output .= "-webkit-border-radius:{$border_radius};border-radius:{$border_radius}";
	 }
	 
	 $output .= "}</style>";	

	 
     $output .= '<div id="counter_'.$counter_id.'" class="row-fluid counters '.$style.'  text-size-'.$text_size.' enable-hr-'.$divider.' hr-type-'.$di_type.' hr-color-'.$di_color.' hr-style-'.$di_style.' columns-'.$columns.' align-center-'.$center.'">';
     $output .= wpb_js_remove_wpautop($content);
     $output .= '</div>'.$this->endBlockComment('counters')."\n";
     echo $output;	
?>