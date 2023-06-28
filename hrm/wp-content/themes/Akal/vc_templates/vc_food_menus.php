<?php

	  $output  = '';
	  $id = rand();
       extract(shortcode_atts(array(
	       'scheme' => 'default' ,
	       'divider' => 'no' ,
		   'bgcolor' => '' ,
		   'bgcolor_hover' => '' ,
		   'el_class' => '' ), 
		$atts));
	   
	   if($bgcolor != '' || $bgcolor_hover != ''){ $output .= "<style type='text/css' scoped>#food_menu_{$id} > li{background-color:{$bgcolor}}#food_menu_{$id} > li:hover{background-color:{$bgcolor_hover}}</style>";}
	   	 
       $el_class = $this->getExtraClass($el_class);
	   $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'food-menu clearfix '.$scheme.' divider-'.$divider.' '.$el_class, $this->settings['base']);
	   $output .= "\n\t" . '<ul  id="food_menu_'.$id.'"class="'.$css_class.'">';
       $output .= "\n\t\t" . wpb_js_remove_wpautop($content);
       $output .= "\n\t" . '</ul>' . $this->endBlockComment('food_menu') . "\n";
	   echo $output;
?>

