<?php

	  $output  = '';
       extract(shortcode_atts(array(
	       'active_tab' => '1' ,
	       'style' => 'style1' ,
		   'el_class' => '' ,
             ), $atts));
			 
       $el_class = $this->getExtraClass($el_class);
	   $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'accordions '.$style.''.$el_class, $this->settings['base']);
	   $output .= "\n\t" . '<div class="'.$css_class.'" data-active-tab="'.$active_tab.'">';
       $output .= "\n\t\t" . wpb_js_remove_wpautop($content);
       $output .= "\n\t" . '</div>' . $this->endBlockComment('.accordions') . "\n";
	   echo $output;
?>

