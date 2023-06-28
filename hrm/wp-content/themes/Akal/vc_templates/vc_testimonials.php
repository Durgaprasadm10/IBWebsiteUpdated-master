<?php 

/* Testimonials
-----------------------------------------------*/

   global $post , $brad_includes;
   $output = $return = '';

	extract(shortcode_atts(array(
	    'appearance' => 'columns' , 
		'columns' => '2' , 
		'carousel_columns' => '1',
		'padding' => 'default' ,
		"vpadding"  => 'default' ,
		'autoplay' => 'no',
		'navigation' => 'no' ,
		'pagination' => 'no',
		'masonry' => 'no' ,
		"speed" => "4000",
		'navigation_align' => 'side' ,
		'categories' => '' ,
		'orderby' => 'date',
		'order' => 'DESC',
		'count' => 5 ,
		'rounded_image' => '' ,
		'el_class' => '',
        'css_animation' => '' ,
		'bg_style' => 'appear1' ,
		'bg_style_carousel' => 'appear1' ,
		'css_animation_delay' => '0' ,
	    'css_animation_type' => 'box' ,
	    'bottom_margin' => 'yes'),$atts));

	$query_args = array(
		'post_type' => 'testimonials',
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
			'taxonomy' => 'testimonials-category',
			'field' => 'slug',
			'terms' => $categories
			)
		 );
	}
	
	
	$testimonials = new WP_Query( $query_args );
	
	// check if testimonials  exists
    if( $testimonials -> have_posts() ) :
	
	if($css_animation_type == 'iconbox'){
			 $el_class1 =  brad_getCSSAnimation($css_animation);
			 $el_class2 = '';
		 }
        else{
			 $el_class1 = '';
			 $el_class2 = brad_getCSSAnimation($css_animation);
          }
	
	 $i = 1 ;
	   	 
	 while ( $testimonials -> have_posts() ) : 
	     $testimonial_class = 'span12';
         $testimonials -> the_post();
		 $person = get_post_meta($post->ID, 'brad_testimonial_name',true);
		 $company = get_post_meta($post->ID, 'brad_testimonial_company',true);
		 $person_role = get_post_meta($post->ID, 'brad_testimonial_role',true);
		 $company_link = get_post_meta($post->ID, 'brad_testimonial_company_link',true);
		 $testm_width  = get_post_meta($post->ID, 'brad_testm_width',true); 
		 if($appearance != 'carousel'){
			 $testimonial_class = ( !empty($testm_width) && $masonry == 'yes') ? $testm_width : brad_get_class_name($columns);
		 }
		 $testimonial_content = get_the_content($post->ID);
		 $img_id = preg_replace('/[^\d]/', '',get_post_meta(get_the_ID(),'brad_testimonial_image',true));
		 $return .= '<div class="testimonial-item '.$testimonial_class.'"><div class="inner-content '.$el_class2.'" data-animation-delay="'.intval($i*$css_animation_delay).'" data-animation-effect="'.$css_animation.'"><div class="testimonial animated-box "><div class="testimonial-content-wrapper">';
		 $return .= '<div class="testimonial-content"><blockquote><q>'. do_shortcode($testimonial_content) .'</q></blockquote></div>';
		 $return .= '<div class="author-info clearfix">';
		  if( $img_id != '' ){
			 $img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => 'mini' ));
			 if ( $img == NULL ) $img['thumbnail'] = '<img src="http://placekitten.com/g/400/300" /> <small>'.__('This is image placeholder, edit your page to replace it.', "brad-framework").'</small>';
			 $return .= '<div class="author-avatar '.$el_class1.'" data-animation-delay="'.intval($i*$css_animation_delay).'" data-animation-effect="'.$css_animation.'">'.$img['thumbnail'].'</div>';
		 }
		 
		 if( $person != ''){
			 $return .= '<h4 class="author-name">'. $person .'</h4>';
		 }
		 if( $company != '' ){
			 $person_role = $person_role != '' ? $person_role.' '.__('of','brad').' ' : '' ;
			 if( $company_link != ''){
			     $return .= '<div class="author-desc">'.$person_role.'<a href="'.$company_link.'">'.$company.'</a></div>';
			 }
			 else{
				 $return .= '<div class="author-desc">'.$person_role.$company.'</div>';
			 }
		 }
		 $return .= '</div></div>';
		
		 $return .= '</div></div></div>';
		 $i++;
	endwhile;		
		
	if($columns == '' || empty($columns)) { $columns = 2; }	
	$el_class = $this->getExtraClass($el_class);
	if( $appearance === 'carousel'){
	  $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' bx-carousel-container testimonials-carousel-container  navigation-align-'.$navigation_align.' clearfix rounded-image-'.$rounded_image.' '.$bg_style_carousel.' '.$el_class, $this->settings['base']);
	  $output .= "\n\t".'<div class="bx-carousel-wrapper"><div class="'.$css_class.'" data-navigation="'.$navigation.'" data-speed="'.$speed.'" data-autoplay="'.$autoplay.'" data-pagination="'.$pagination.'">';
	  $output .= "\n\t\t".'<span class="carousel-next"></span><span class="carousel-prev"></span>';
	  $output .= "\n\t\t\t".'<div class="bx-fake-slider testimonials-carousel" >';
	  $output .= "\n\t\t\t\t".$return ;
	  $output .= "\n\t\t\t".'</div>';
	  $output .= "\n\t\t\t\t".'<div class="carousel-pagination"></div>';
	  $output .= "\n\t".'</div></div>';
	  $brad_includes['load_bxslider'] = true;
	}
	else{
	  if( $masonry != 'yes'){
		  $el_class .= ' columns-'.$columns.'';
	  }
	  $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'row-fluid testimonials-grid  masonry-'.$masonry.' element-padding-'.$padding.' rounded-image-'.$rounded_image.' element-vpadding-'.$vpadding.' '.$bg_style.' '.$el_class, $this->settings['base']);
	  $output .= "\n\t".'<div class="'.$css_class.'" >';
	  $output .= "\n\t\t".$return;
	  $output .= "\n\t".'</div>'.$this->endBlockComment('testimonials')."\n";
	  if($masonry == 'yes'){
		  $brad_includes['load_isotope'] = true;
	  }
	}
    endif;
	wp_reset_query();	
	echo $output;