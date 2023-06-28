<?php

	  $output = '';	
	  extract(shortcode_atts(array(
	   'title' => __('Section','brad'),
	   'icon' => '' ,
	   'el_class' => ''), $atts));
	  
	   $el_class = $this->getExtraClass($el_class);
	   $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'accordion '.$el_class.' not-column-inherit', $this->settings['base']);
	  $output .= "\n\t".'<div class="'.$css_class.'">';       //data-interval="'.$interval.'"
	  $output .= "\n\t\t".'<h4 class="accordion-title"><a href="#">'.brad_icon($icon).$title.'<span class="plus"></span></a></h4>';
	  $output .= "\n\t\t\t".'<div class="accordion-inner">'. wpb_js_remove_wpautop($content) .'</div>';
	  $output .= "\n\t".'</div> '.$this->endBlockComment('.accordion');
	  echo $output;	
?>