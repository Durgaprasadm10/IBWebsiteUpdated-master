<?php

	$output =  '';
    extract(shortcode_atts(array(
      'image' => '' ,
      'img_size'  => 'full',
	  'custom_img_size' => '',
	  'img_align' => 'none' ,
	  'img_lightbox' => false,
	  'img_lb'  => false ,
	  'icon_lightbox' => '',
      'img_link_large' => false,
      'img_link' => '',
      'target' => '_self',
      'el_class' => '',
      'css_animation' => '',
	  'css_animation_delay' => 0
       ), $atts));
 
	$img_id = preg_replace('/[^\d]/', '', $image);
	if($custom_img_size != '') {
		$img_size = $custom_img_size;
	}

    $img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => $img_size ));
    if ( $img == NULL ) $img['thumbnail'] = '<img src="http://placekitten.com/g/400/300" /> <small>'.__('This is image placeholder, edit your page to replace it.', "brad-framework").'</small>';
    $el_class = $this->getExtraClass($el_class);

    $link_s = $link_e = $link_icon = $lb_html = '';
	
	if( $img_link != '' || $img_link_large == true){
		
		if( $img_lb == true) { $lb_html = ' rel="prettyPhoto[singleimage'.rand().']"'; }
		if($img_lightbox == true && $icon_lightbox != ''){ $lb_html .= ' class="icon image-lightbox"';}
		
		if($img_link_large == true){
			$img_src = wp_get_attachment_image_src( $img_id, 'large');
			$link_s = '<a href="'.$img_src[0].'" target="'.$target.'" '.$lb_html.'>';
		}
		else{
			$link_s = '<a href="'.$img_link.'" target="'.$target.'" '.$lb_html.'>';
		}
		
		
		$link_e = '</a>';
	}
	
	
   
    $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'single-image', $this->settings['base']);
    $css_class .= brad_getCSSAnimation($css_animation);
	
    $output .= "\n\t".'<div class="single-image-container img-align-'.$img_align.' '.$el_class.'"><div class="'.$css_class.'" data-animation-delay="'.$css_animation_delay.'" data-animation-effect="'.$css_animation.'">';
	
	if($img_lightbox == true && $icon_lightbox != ''){
		$icon = brad_icon($icon_lightbox);
		$output .= "\n\t\t". $link_s . $icon . $link_e . $img['thumbnail'] ;
	}
	else {
		 $output .= "\n\t\t". $link_s .  $img['thumbnail'] . $link_e ;
	}

    $output .= "\n\t".'</div></div>'.$this->endBlockComment('.image');
    echo $output;	
