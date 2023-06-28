<?php

		$brad_box_id = rand();
		$output =  $style = '';
		extract(shortcode_atts(array(
		    'bg_color' => '' ,
			'opacity' => '1' ,
			'br_color' => '' ,
			'br_width' => '1' ,
			'br_top' => 'no' ,
			'br_bottom' => 'no' ,
			'padding' => '20',
			'color_scheme' => '',
			'hide_under' => '' ,
			'el_class' => ''
		),$atts));
		
		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'box  content-box '.$color_scheme.' border-bottom-radius-'.$br_bottom.' border-top-radius-'.$br_top.' '.$el_class , $this->settings['base']);
		
	    $style = "padding:{$padding};";
		$hidden_class = '';
		
		if(!empty($hide_under)){
		  $hide_under = explode(",",$hide_under);
		  foreach($hide_under as $v){
			  $hidden_class .= ' hidden-'.$v;
		  }
		}
		if( $bg_color != ''){
			$rgb = brad_hex2rgb($bg_color);
			$rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$opacity})";
		    $style .= "background-color:{$bg_color};background-color:{$rgba};";
		}
		if( $br_color != ''){
		    $style .= "border:{$br_width}px solid {$br_color};";
		}
		
		$output .= "\n\t".'<div id="brad_box_'.$brad_box_id.'" class="'.$css_class.$hidden_class.' " style="'.$style.'">';
		$output .= "\n\t\t".wpb_js_remove_wpautop($content); 
		$output .= "\n\t".'</div>';
		echo $output;

?>