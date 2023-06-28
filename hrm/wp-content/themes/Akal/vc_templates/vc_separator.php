<?php

	$output = '';
    extract(shortcode_atts(array(
	    'type'  => 'large' , 
		'style' => 'normal' ,
		'align' => 'center' , 
		'color' => 'light',
		'icon' => '' ,
		'margin_top' => 2 , 
		'margin_bottom' => 25 ),
		$atts));

	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'hr border-'.$type.' '.$style.'-border align'.$align.' hr-border-'.$color.'', $this->settings['base']);
	
	if($icon != '' ){
		$css_class .= ' hr-with-icon';
	}
	
	$style = "margin-top:{$margin_top}px;margin-bottom:{$margin_bottom}px;";
				
	$output .= '<div  class="'.$css_class.'" style="'.$style.'"><span>'.brad_icon($icon,'','',false).'</span></div>'.$this->endBlockComment('separator')."\n";
	echo $output;	
 