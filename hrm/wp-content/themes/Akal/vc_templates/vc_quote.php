<?php
/**
 */
		
	    $output = '';
		extract(shortcode_atts(array(
	        'logo'  =>  '',
			'person_name' => 'john doe',
			'person_desc' => '',
			'img_size' => '',
			'custom_img_size' => ''
	       ),$atts));
		   
		$output .= "\n\t".'<li class="quote-slider-item">';
		
		if( $logo != ''){
			$img_id = preg_replace('/[^\d]/', '', $logo);
	        if($custom_img_size != '') {
		        $img_size = $custom_img_size;
	        }
           $img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => $img_size ));
           if ( $img == NULL ) $img['thumbnail'] = '<img src="http://placekitten.com/g/400/300" /> <small>'.__('This is image placeholder, edit your page to replace it.', "brad-framework").'</small>';
		   
			$output .= '<div class="quote-logo">'.$img['thumbnail'].'</div>';
		}
		
		$output .= "\n\t\t".'<blockquote><q>'.wpb_js_remove_wpautop($content).'</q></blockquote>';
		if( $person_name != '' || $person_desc != ''){
			$output .= '<h4 class="cite">';
			if( $person_name != ''){
			    $output .= "\n\t\t\t".'<span class="quote-name"> - '.$person_name.'</span>';
				if($person_desc != ''){
					$output .= ' , ' ;
				}
			}
			if( $person_desc != ''){
			    $output .= "\n\t\t\t\t".'<span class="quote-desc">'.$person_desc.'</span>';
			}
			$output .= '</h4>';
		}
		$output .= "\n\t".'</li>';  
		echo $output;