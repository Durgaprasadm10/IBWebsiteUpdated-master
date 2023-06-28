<?php

      global $brad_includes;
	  
	  $output = '';
	  extract(shortcode_atts(array(
		  'type' => 'slider' ,
		  'columns' => '6',
		  'padding' => 'default',
		  'vpadding' => 'default' ,
		  'onclick' => 'link_image',
		  'custom_links' => '',
		  'custom_links_target' => '',
		  'show_metadata' => 'no',
		  'img_size' => 'full',
		  'custom_img_size' => '' ,
		  'images' => '',
		  'grey'  => 'no' ,
		  'el_class' => '',
		  'autoplay' => 'no'
		  ), $atts));
	  
	  if($img_size == 'custom' && $custom_img_size != '') {
		  $img_size = trim($custom_img_size);
	  }

	 $gal_images = '';
	 $link_start = '';
	 $link_end = '';
	 $el_start = '';
	 $el_end = '';
	 $slides_wrap_start = '';
	 $slides_wrap_end = '';

	 $el_class = $this->getExtraClass($el_class);
	 $class = $type == 'slider' ? 'slide' : 'span';

	 $el_start = '<div class="'.$class.'">';
	 $el_end = '</div>';
	 $slides_wrap_start = '';
	 $slides_wrap_end = '';
	 
	//if ( $images == '' ) return null;
	if ( $images == '' ) $images = '-1,-2,-3';
	$pretty_rel_random = ' rel="prettyPhoto[gallery]"'; //rel-'.rand();
	if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }
	$images = explode( ',', $images);
	$i = -1;

  foreach ( $images as $attach_id ) {
  $i++;
  if ($attach_id > 0) {
	  $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ));
	  $metadata =  get_post($attach_id);
  }
  else {
	  $different_kitten = 400 + $i;
	  $post_thumbnail = array();
	  $post_thumbnail['thumbnail'] = '<img src="http://placekitten.com/g/'.$different_kitten.'/300" />';
	  $post_thumbnail['p_img_large'][0] = 'http://placekitten.com/g/1024/768';
  }

  $thumbnail = $post_thumbnail['thumbnail'];
  $p_img_large = $post_thumbnail['p_img_large'];
  
  
  $link_start = $link_end = '';

  if ( $onclick == 'link_image' ) {
	  $link_start = '<a href="'.$p_img_large[0].'"'.$pretty_rel_random.'>';
	  $link_end = '</a>';
  }
  else if ( $onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
	  $link_start = '<a href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '>';
	  $link_end = '</a>';
  }
  
	  $gal_images .=  $el_start .'<div class="image hoverlay image-gallery">'. $link_start . $thumbnail .$link_end ;
	  
	  if( $show_metadata == 'yes' && ( !empty( $metadata->post_content) || !empty( $metadata -> post_excerpt) ) ){
		  $gal_images .= '<div class="image-overlay"><div class="image-overlay-content"><div>';
		  if( !empty( $metadata -> post_excerpt) ){
			  $gal_images .= '<h3>'. $metadata -> post_excerpt .'</h3>'; 
		  }
		  $gal_images .= $metadata->post_content. '</div></div></div>';
	  }
	  
	  $gal_images .= '</div>'. $el_end;

}
 

 if($type == 'grid'){
	   $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'brad-gallery row-fluid grey-'.$grey.' columns-'.$columns.' element-padding-'.$padding.' element-vpadding-'.$vpadding.' '.$el_class, $this->settings['base']);
	  $output .= '<div class="'.$css_class.'">'.$gal_images.'</div>';
 }
 else{
	 $brad_includes['load_bxslider'] = true;
	 $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'gallery-container '.$el_class.' clearfix', $this->settings['base']);
	 $output .= "\n\t".'<div class="'.$css_class.'">';
	 $output .= '<div class="flexible-slider-container"><div class="flexible-slider" data-autoplay="'.$autoplay.'">'.$slides_wrap_start.$gal_images.$slides_wrap_end.'</div></div>';
	 $output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_gallery');
 }
 echo $output;
