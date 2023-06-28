<?php

	$output =  $style1 = $style2 = $style3 = '';
    extract(shortcode_atts(array(
      'image' => '' ,
      'title'  => '',
	  'ca' => 'center' ,
	  'bg' => '',
	  'bo' => '',
	  'bc' => '',
	  'bw' => '',
	  'text_scheme' => 'default' 
       ), $atts));
 
	$img_id = preg_replace('/[^\d]/', '', $image);
	$img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => 'full' ));
	
	if( $bg != ''){
		$rgb = brad_hex2rgb($bg);
		$rgba = "rgba({$rgb[0]} , {$rgb[1]} , {$rgb[2]} , {$bo})";
		$style3 = " style='background-color:{$rgba}'";
	}
	
	if( $bc != ''){
		$style2 = " style='border:{$bw}px solid {$bc};'";
	}
   
    $output .= "\n\t".'<div class="teaser valign-'.$ca.'">';
    $output .= "\n\t\t".'<div class="image hoverlay">'. $img['thumbnail'];
	$output .= "\n\t\t\t".'<div class="teaser-container"><div class="box content-box '.$text_scheme.'" '.$style2.'><div class="box-inner" '.$style3.'><div>';
	
	if($title != ''){
		$output .= '<h2 class="teaser-heading"><span>'. $title .'</span></h2>';
	}
	if( $content != ''){
	    $output .= "\n\t\t\t\t".'<div class="teaser-content">'. wpb_js_remove_wpautop($content) .'</div>';
	}
    $output .= "\n\t".'</div></div></div></div></div></div> '.$this->endBlockComment('.teaser');
    echo $output;	
