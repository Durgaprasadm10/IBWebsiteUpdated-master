<?php

$output = $after_output = '';
extract(shortcode_atts(array(
	    'sid' => '' ,
		'padding' => 'default' ,
		'vpadding'  => 'default',
		'el_class' => '' ), $atts));
	

$el_class = $this->getExtraClass( $el_class );


	
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'row-fluid element-padding-'.$padding.' element-vpadding-'.$vpadding.' '.$el_class, $this->settings['base']);
$output .= '<div class="'.$css_class.'">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>'.$this->endBlockComment('row');
echo $output;