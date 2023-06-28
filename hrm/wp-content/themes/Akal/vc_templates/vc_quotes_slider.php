<?php
/**
 */
	global $brad_includes;
	$output = '';
	extract(shortcode_atts(array(
		'el_class'  =>  '',
		'autoplay' => 'no',
		'navigation' => 'yes' ,
		'pagination' => 'no' ,
		'navigation_align' => 'side' ,
		'interval' => '5000' ,
		'effect' => 'fade' 
	   ),$atts));
	
	$output .= "\n\t".'<div class="quotes-slider-container bx-carousel-container navigation-align-'.$navigation_align.'" data-navigation="'.$navigation.'" data-effect="'.$effect.'" data-autoplay="'.$autoplay.'" data-interval="'.$interval.'" data-pagination="'. $pagination .'">';
	$output .= "\n\t\t".'<span class="carousel-next"></span><span class="carousel-prev"></span>';
	$output .= "\n\t\t\t".'<ul class="quotes-slider bx-fake-slider" >';
	$output .= "\n\t\t\t\t".wpb_js_remove_wpautop($content);
	$output .= "\n\t\t\t".'</ul>';
	$output .= "\n\t\t\t".'<div class="carousel-pagination"></div>';
	$output .= "\n\t".'</div>';
	$brad_includes['load_bxslider'] = true;
	echo $output;

