<?php


/* Clients
------------------------------------------------------------------*/

	$output = ''; 
	global $post , $brad_includes;
	$clients_id = rand();   
	extract(shortcode_atts(array(
	   'appearance' => 'columns' ,
	   'orderby' => 'date',
	   'order' => 'DESC',
	   'count' => 5 ,
	   'categories' => '', 
	   'columns' => '2' , 
	   'style' => 'style1' ,
	   'bg_color' => '#ffffff' ,
	   'bg_color_hover' => '' , 
	   'vpadding' => 'default',
	   'border_color' => '' , 
	   'border_color_hover' => '' , 
	   'bg_opacity' => "1",
	   'bg_opacity_hover' => "1",
	   'bg_shadow' => 'no' ,
	   'bg_radius' => 'yes' ,
	   'bg_radius_full' => 'no' ,
	   'padding' => '' ,
	   'inner_vpadding' => "default" ,
	   'inner_hpadding' => "default" ,
	   'autoplay' => 'no' , 
	   'navigation' => 'no' ,
	   'pagination' => 'no' ,
	   'img_size' => '' ,
	   'custom_img_size' => '' , 
	   'css_animation' => '' ,
	   'el_class' => '',
	   'css_animation_delay' => '0'),$atts));
	   
	$output = '';
	
	$query_args = array(
		'post_type' => 'clients',
		'posts_per_page' => (int)$count,
		'order'          => $order,
		'orderby'        => $orderby,
		'post_status'    => 'publish'
     );
	
	// Narrow by categories
    if ( $categories != '' ) {
    $categories = explode(",", $categories);
    $query_args['tax_query'] = array(
			array(
				'taxonomy' => 'clients-category',
				'field' => 'slug',
				'terms' => $categories
				 )
			  );
	}
	
	
	$clients = new WP_Query( $query_args );
	
	// check if testimonials  exists
    if( $clients -> have_posts() ) : 

	    $el_class = $this->getExtraClass($el_class);
	    if($columns == '' || empty($columns)) {
		    $columns = 2;
		}
	
	    if($img_size == 'custom' && $custom_img_size != '') {
		   $img_size = $custom_img_size;
	    }
	
	    if( ( $bg_color != '' || $bg_color_hover != '' || $border_color != '' || $border_color_hover != '' ) && $style == 'style3' ){
	        $output .= "<style type='text/css' scoped>";
			if( $bg_color != '' || $border_color != ''){
				$output .= "#clients_{$clients_id} .span .inner-content{";
			if( $bg_color != '' ){
		        $rgb = brad_hex2rgb($bg_color);
		        $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$bg_opacity})";
		        $output .= "background-color:{$bg_color};background-color:{$rgba};";
			}
			if( $border_color != '' ){
		        $output .= "border-color:{$border_color};";
			}
			$output .= "}";
			}
			if( $bg_color_hover != '' || $border_color_hover != ''){
				$output .= "#clients_{$clients_id} .span .inner-content:hover{";
				if( $bg_color_hover != '' ){
		           $rgb = brad_hex2rgb($bg_color_hover);
		           $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$bg_opacity_hover})";
		           $output .= "background-color:{$bg_color_hover};background-color:{$rgba};";
			    }
				if( $border_color_hover != '' ){
		           $output .= "border-color:{$border_color_hover};";
			    }
				$output .= "}";	
			}
			$output .= "</style>";	
	     }
	 
	$clients_loop = '';
	$i = 1;
	while ( $clients -> have_posts() ) :
	    $clients -> the_post();
		$title = get_the_title($post->ID);
		$link = get_post_meta($post->ID,'brad_client_link',true);
	    $logo_id = preg_replace('/[^\d]/', '' , get_post_meta($post->ID,'brad_client_image',true) );
		$logo_hover =  preg_replace('/[^\d]/', '' , get_post_meta($post->ID,'brad_client_hover',true) );
		
		if( $logo_id != ''  ){
			
			 $logo = wpb_getImageBySize(array( 'attach_id' => $logo_id, 'thumb_size' => 'full' ));
		     $clients_loop .= '<div class="span"><div class="inner-content  '.brad_getCSSAnimation($css_animation ).'" data-animation-delay="'.intval($css_animation_delay*$i).'" data-animation-effect="'.$css_animation.'">';
			 if( $link != ''){
				 $link_before = '<a class="clients-wrapper" href="'.$link.'" title="'.$title.'">';
				 $link_after = '</a>';
			 }
			 else{
				 $link_before = '<div class="clients-wrapper">';
				 $link_after = '</div>';
			 }
			 
		     $clients_loop .= $link_before. '<span>' .$logo['thumbnail'] . '</span>';
			 
			 if($logo_hover != ''){
				 $logo = wpb_getImageBySize(array( 'attach_id' => $logo_hover , 'thumb_size' => '' ));
				 $clients_loop .= '<span class="hover-logo">'. $logo['thumbnail']  .'</span>';
			}

			 $clients_loop .= $link_after.'</div></div>';
		}
		$i++;
	endwhile; 
	
	if($appearance == 'carousel') {
		$brad_includes['load_caroufred'] = true;
	    $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'clients  '.$style.' carousel-items row element-inner-vertical-padding-'.$inner_vpadding.' element-inner-horizental-padding-'.$inner_hpadding.' element-padding-'.$padding.' columns-'.$columns.' background-shadow-'.$bg_shadow.' background-radius-'.$bg_radius.' background-radius-full-'.$bg_radius_full.' '.$el_class, $this->settings['base']);	
	    $output .= '<div class="carousel-container clients-carousel-container pagination-'.$pagination.' navigation-'.$navigation.'"  data-autoplay="'.$autoplay.'" data-columns="'.$columns.'">';
	    if( $navigation == 'yes') {
	        $output .= '<a class="bx-next" href="#"></a><a class="bx-prev" href="#"></a>';
	    }
		if( $pagination == 'yes') :
	       $output .=  '<div class="pagination"></div>';
	    endif;
	    $output .= '<div class="carousel-outer clearfix"><div class="carousel-wrapper  carousel-padding-'.$padding.'"><div id="clients_'.$clients_id.'" class="'.$css_class.'" data-columns="'.$columns.'" >';
	    $output .= $clients_loop;
        $output .= '</div></div></div></div>'.$this->endBlockComment('clients')."\n";
    }
    else {
	    $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'row-fluid element-inner-vertical-padding-'.$inner_vpadding.' element-inner-horizental-padding-'.$inner_hpadding.' clients-grid '.$style.' element-padding-'.$padding.' element-vpadding-'.$vpadding.' columns-'.$columns.' '.$el_class, $this->settings['base']);
    $output .= '<div id="clients_'.$clients_id.'" class="'.$css_class.'" >';
    $output .= $clients_loop;
    $output .= '</div>'.$this->endBlockComment('clients')."\n";
   }
   endif;
   wp_reset_query();	
   echo $output;

