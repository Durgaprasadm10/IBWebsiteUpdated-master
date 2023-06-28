<?php

/*Counters
------------------------------------------------*/

	

	$output = $title = $value = $unit = '';
	extract(shortcode_atts(array(
	'title' =>  '' , 
	'value' =>  '' , 
	'icon' => '' ,
	'css_animation' => '' ,
	'css_animation_delay' => '0' , 
	'unit' =>  '' ,  
	 ),$atts));
	 $icon = brad_icon($icon);
	 $output = '<div class="span"><div class="inner-content '.$this->getCSSAnimation($css_animation).'" data-animation-delay="'. $css_animation_delay .'" data-animation-effect="'. $css_animation.'"><div class="counter-box-container"><div class="counter-box">';
	 
	 $output .= '<div class="counter-title">';
	 $output .= $icon ;
	 $output .= '<span class="counter-value"><span data-percentage="'.trim($value).'">'.$value.'</span>'.$unit.'</span>';
	 if($title != '') {
	   $output .= '<div class="hr"><span></span></div><p class="title">'.$title.'</p>';
	 }
	 $output .= '</div></div></div></div></div>';
	 echo $output;