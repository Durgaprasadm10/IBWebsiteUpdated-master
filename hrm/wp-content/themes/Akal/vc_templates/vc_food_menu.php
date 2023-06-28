<?php

	   $output  = $imglink_b = $imglink_a = $menulink = $exclass = $style = '';
       extract(shortcode_atts(array(
	       'link' => '' ,
	       'image' => '' ,
		   'height' => '',
		   'img_align' => 'left' ,
		   'img_lightbox' => 'no' ,
		   'menu_lightbox' => 'no',
		   'title' => '' ,
		   'price' => '' ), 
		$atts));
	  
	   if($link != ''){
		   $menulink = '<a href="'.$link.'" class="fake-link"></a>';
	   }
	   
	   if($height != ''){
		   $style .= 'min-height:'.intval($height).'px';
	   }
	   
	   $output .= "\n\t" . '<li class="food-menu-item img-align-'.$img_align.'" style="'.$style.'">';
	   
	   if($image != ''){
		    $exclass = 'with-image';
		    $img_id = preg_replace('/[^\d]/', '', $image);
	        $img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => 'mini' ));
			if ($img_lightbox == 'yes') {
				$img_src = wp_get_attachment_image_src( $img_id, 'full');
                $imglink_b = '<a href="'.$img_src[0].'"  rel="prettyPhoto[menuImage]">';
				$imglink_a = '</a>';
			}
			
			if($menu_lightbox == 'yes'){
				$img_src = wp_get_attachment_image_src( $img_id, 'full');
                $menulink = '<a href="'.$img_src[0].'"  rel="prettyPhoto[menuImage]"></a>';
			}
			
			$output .= "\n\t\t".'<div class="food-image">'. $imglink_b . $img['thumbnail'] . $imglink_a.'</div>';
	   }
	   
	   $output .= '<div class="menu-content '.$exclass.'">';
	   
	   if( $title != ''){
		   $output .= '<h4>'.$title.'</h4>';
	   }
	   
	   if( $price != ''){
		   $output .= '<span class="price">'.$price.'</span>';
	   }
	   
	   if( $content != ''){
		    $output .= "\n\t\t" . '<div class="description">'. wpb_js_remove_wpautop($content) . '</div>';
	   }
	   
       $output .= "\n\t" .'</div>';
	    if($menulink != ''){
		   $output .= $menulink;
	   }
	   
	   $output .= '</li>';
	   echo $output;
?>