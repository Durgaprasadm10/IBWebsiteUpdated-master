<?php

/* bradslider
-----------------------------------------------*/

	 extract(shortcode_atts(array(
	  'category'  =>  '' ,
	  'post_category' => '',
	  'type' => 'gallery' ,
	  'show_excerpt' => 'yes',
	  'show_readmore' => 'yes',
	  'show_categories' => 'yes' ,
	  'excerpt_length' => '35',
	  'max'  => '8',
	  'show_date' => 'yes' , 
	  'effect'   => 'fade' ,
	  'height'      =>  '500' ,  
	  'fullheight'  =>  'no' , 
	  'max_width' => '1210px',
	  'swipe'  => 'yes' , 
	  'parallax'    =>  'no' ,
	  'navigation'  => 'yes',
	  'pagination'  => 'yes',
	  'responsive_height' => 'yes',
	  'interval'  => '5000'
	  ),$atts));
	  
	  echo wpb_js_remove_wpautop('[bradslider max="'.$max.'" post_category="'.$post_category.'" type="'.$type.'" show_categories="'.$show_categories.'" show_excerpt="'.$show_excerpt.'" show_readmore="'.$show_readmore.'" excerpt_length="'.$excerpt_length.'"  max_width="'.$max_width.'" show_date="'.$show_date.'" category="' .$category. '" height="' .$height.'" fullheight="'. $fullheight .'" swipe="'. $swipe .'" parallax="' .$parallax. '" navigation="' .$navigation. '" pagination=" '.$pagination.'" responsive_height="' .$responsive_height. '"  interval="' .$interval. '" ]') ;		  
