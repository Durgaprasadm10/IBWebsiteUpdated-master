<?php


/*--------------------------------------------------*/
/* Single Image 
/*--------------------------------------------------*/
add_shortcode('image','brad_image');

function brad_image($atts , $content){
    $output =  $img_b = $img_a = '';
    extract(shortcode_atts(array(
      'image' => '' ,
      'img_size'  => 'full',
	  'custom_img_size' => '',
	  'img_align' => 'none' ,
	  'img_lightbox' => false,
	  'icon_lightbox' => '118|ss-air',
      'img_link_large' => false,
      'img_link' => '',
	  'link' => '',
	  'target' => '',
      'img_link_target' => '_self',
      'el_class' => '',
      'css_animation' => '',
	  'css_animation_delay' => 0
       ), $atts));
 
	$img_id = preg_replace('/[^\d]/', '', $image);

    $img = wp_get_attachment_image_src( $image, $img_size);
    if ( $img == NULL ) $img[0] = '<img src="http://placekitten.com/g/400/300" /> <small>'.__('This is image placeholder, edit your page to replace it.', "brad-framework").'</small>';


    $link_to = '';
	
	if($link != ''){
		$img_b = '<a href="'.$link.'" target="'.$target.'">';
		$img_a = '</a>';
	}
	
    else if ($img_lightbox == 'yes') {
		$icon = brad_icon($icon_lightbox);
		if($img_link_large == 'yes'){
            $img_src = wp_get_attachment_image_src( $img_id, 'full');
            $link_to = '<a href="'.$img_src[0].'" class="icon image-lightbox" rel="prettyPhoto[singleImage'. rand() .']">'.$icon.'</a>';
		}
		else if(!empty($img_link)){
			$link_to = '<a href="'.$img_link.'" class="icon image-lightbox" rel="prettyPhoto[singleImage'. rand() .']">'.$icon.'</a>';
		}
   }
   
    $css_class =  'single-image img-align-'.$img_align ;
	
	if( $css_animation != ''){
		$css_class .= ' animate-when-visible';
	}
	
    $output .= "\n\t".'<div class="single-image-container img-align-'.$img_align.' '.$el_class.'"><div class="'.$css_class.'" data-animation-delay="'.$css_animation_delay.'" data-animation-effect="'.$css_animation.'">';
    $output .= "\n\t\t". $img_b . '<img src="' .$img[0] . '" />' . $img_a ;
	$output .= "\n\t\t\t".$link_to;
    $output .= "\n\t".'</div></div>';
    return $output;	
	
}

/*---------------------------------------------------*/
/* Social Share
/*---------------------------------------------------*/
add_shortcode('share_box','brad_share_box');
function brad_share_box( $atts , $content = null) {
	global $post , $brad_includes;
	 $output = '';
	 extract(shortcode_atts(array(
	  'fb'  =>  'yes' ,
	  'te'  =>  'yes' ,
	  'gp'  =>  'yes' ,
	  'li'  =>  'yes' ,
	  'pin'  =>  'yes' 
	  ),$atts));
	  
	  $output .= '<div class="post-share clearfix"><h4 class="share-label">'. __('Share','brad') .'</h4><ul class="post-share-menu">';
	  
	  if($fb == 'yes'): 
          $output .= '<li><a href="http://www.facebook.com/sharer.php?u='. get_the_permalink($post->ID) .'&amp;t='. get_the_title() .'"  class="facebook-share"><i class="fa-facebook"></i></a></li>';
	  endif;
	  
	  if($tw == 'yes'): 
          $output .= '<li ><a href="http://twitter.com/home?status='. get_the_title() .' '. get_the_permalink($post->ID) .'" class="twitter-share"><i class="fa-twitter"></i></a></li>';
	  endif;
	  
	  if($li == 'yes'): 
          $output .= '<li><a href="http://linkedin.com/shareArticle?mini=true&amp;url='. get_the_permalink($post->ID) .'&amp;title='. get_the_title() .'" class="linkedin-share"><i class="fa-linkedin"></i></a></li>';
	  endif;
	  
	  if($pin == 'yes'): 
          $output .= '<li ><a href="http://pinterest.com/pin/create/button/?url='. urlencode(get_the_permalink($post->ID)) .'&amp;description='. urlencode(get_the_title()) .'&amp;" class="pinterest-share"><i class="fa-pinterest"></i></a></li>';
	  endif;
	  
	  if($gp == 'yes'): 
          $output .= '<li><a href="https://plus.google.com/share?url='.get_the_permalink($post->ID).'"  class="google-share"><i class="fa-google-plus"></i></a></li>';
	  endif;
	  
	  $output .= '</ul></div>';
	  
	  return $output;
}
	  
/*---------------------------------------------------*/
/* Slidr Shortcode 
/*---------------------------------------------------*/
add_shortcode('bradslider','brad_bradslider');
function brad_bradslider( $atts , $content = null) {
	global $post , $brad_includes;
	 static $slider_id = 1;
	 $output = '';
	 extract(shortcode_atts(array(
	  'category'  =>  '' , 
	  'type'  => 'gallery',
	  'effect'   => 'fade',
	  'order'           => 'date',
	  'orderby'         => 'DESC',
	  'show_excerpt'  => 'yes' ,
	  'show_categories' => 'yes' ,
	  'show_date' => 'yes',
	  'show_readmore' => 'yes' ,
	  'max'         => 10 ,
	  'excerpt_length'  => '20' ,
	  'max_width' => '1210px' ,
	  'height'      =>  '500' ,  
	  'fullheight'  =>  'no' , 
	  'swipe'  => 'yes' , 
	  'parallax'    =>  'no' ,
	  'navigation'  => 'yes',
	  'pagination'  => 'yes',
	  'responsive_height' => 'yes',
	  'interval'  => '5000',
	  'header_slider' => 'no',
	  'autoplay'    => '0'
	  ),$atts));
	  
 if( $type == 'post'){
	 $args = array(
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'posts_per_page' => (int)$max,
		'order'          => $order,
		'orderby'        => $orderby
         );
		 
	 if(!empty($post_category)){
			$cat_id = explode(',', $post_category );
			$args['tax_query'] = array(
				array(
				 'taxonomy' => 'category',
				 'field' => 'slug',
				 'terms' => $cat_id
				     )
			     );
		}
 }
 
 else{
	 $args = array(
		   'post_type' => 'bradslider',
		   'post_status' => 'publish',
		   'order' => 'DESC', 
		   'orderby' => 'menu_order' ,
		   'posts_per_page' => -1
	   );
       if( $category != ''):
		 $cat_slug = explode(',', $category );
		 $args['tax_query'] = array(
			array(
			  'taxonomy' => 'bradslider-category',
			  'field' => 'slug',
			  'terms' => $cat_slug
			  )
		 );
	  endif;
	}
			  
	 $pagination_lines = '';
	 $slides_count = 0;
	 $height = intval($height > 0) ? $height : 500;
	 $carousels = new WP_Query($args);
	 if( $carousels -> have_posts()):
	 
	 $style =  $parallax_script1 = $parallax_script2 = $parallax_script3 =  '';

	 
	 if($parallax == 'yes'){
		 $parallax_script2 = ' data-start="transform: translateY(0px); opacity:1;" data-300="transform: translateY(-100px);opacity:0;"';
		 $parallax_script1 = ' data-start="transform: translateY(0px);" data-1440="transform: translateY(-500px);"';
		 $parallax_script3 = ' data-start="opacity: 1;" data-300="opacity:0;"';
	 }
	
	 if($fullheight != 'yes'){
		 $style = 'height:'.$height.'px; max-height:'.$height.'px;';
	 }

    
	$output .= "<style type='text/css' scoped>#brad_slider{$slider_id} .carousel-caption-content { max-width:{$max_width};}</style>";
	 
	 $output .= '<div class="brad-slider-wrapper" style="'.$style.'"><div id="brad_slider'.$slider_id.'" class="carousel brad-slider slide '. $effect .' fullheight-'. $fullheight .' header-slider-'. $header_slider .' navigation-'.$navigation.'" data-height="'.$height.'"  data-fullheight='.$fullheight.'  data-rs-height="'. $responsive_height .'" data-interval="'.$interval.'" " data-swipe="'.$swipe.'" style="'.$style.'"><div class="carousel-preloader"><div class="spinner"></div><img src="'.get_template_directory_uri().'/images/loader.gif" /></div><div class="carousel-inner parallax-slider-'. $parallax .'" '. $parallax_script1 .'>';
	 
	 
	 while($carousels->have_posts()): $carousels->the_post();
	 
	   if( $type == 'post'){
		   
		   if(has_post_thumbnail()){
			 $slider_title = get_the_title();
			 $slider_excerpt = brad_limit_words(get_the_excerpt(),intval($excerpt_length));
			 $slider_date = get_the_date();
			 $slider_image = wp_get_attachment_image_src(get_post_thumbnail_id(), '');
			 $slider_btn_link = get_permalink();
			 $slider_color =  get_post_meta($post->ID,'brad_slider_color',true);
		     $slider_bg_opacity = get_post_meta($post->ID,'brad_slider_bg_opacity',true);
			 $slider_bg_color = get_post_meta($post->ID,'brad_slider_bg_color',true);
			 $slider_button_style = get_post_meta($post->ID,'brad_slider_button_style',true);
			 $slider_style = 'opacity:'. $slider_bg_opacity .'; filter:alpha(opacity='. intval($slider_bg_opacity*100). ');';
			 $slider_bg_cover = get_post_meta($post->ID,'brad_slider_bg_cover' , true);
		     $slider_bg_repeat = get_post_meta($post->ID,'brad_slider_bg_repeat' , true);
		     $slider_bg_pos = get_post_meta($post->ID,'brad_slider_bg_pos' , true);
			 
			 if($slider_bg_color != ''){
				 $slider_style .= 'background-color:'. $slider_bg_color. ';';
			 }
			 
			 
			 $output .= '<div class="item"  data-header-scheme="header-scheme-'. $slider_color .'"  data-slider-scheme="color-'.$slider_color.'"><div class="image bg-cover-'.$slider_bg_cover.'" style="background-image:url('. $slider_image[0] .'); background-position:'.$slider_bg_pos.'; background-repeat:'. $slider_bg_repeat .' " data-kenburn="no"><img src="'. $slider_image[0] .'"></div><div class="slider-bg-overlay" style="'. $slider_style .'"></div><div class="carousel-caption caption-halign-center caption-valign-center color-'.$slider_color.'" '. $parallax_script2 .'  ><div class="carousel-caption-wrapper"><div class="carousel-caption-content  fadeIn"><div class="carousel-caption-inner-content">';
		 
		 if($show_date == 'yes' || $show_categories == 'yes'){
			 $output .= '<h6 class="slider-subtitle">';
			 if($show_date == 'yes'):
			     $output .= '<span>'. $slider_date .'</span>';
			 endif;
			 if($show_categories == 'yes'):
			  $categories = get_the_category();
			  $separator = '';
			  if($categories){
				  $output .= '<span>';
	              foreach($categories as $category) {
		               $output .= $separator.'<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'brad' ), $category->name ) ) . '">'.$category->cat_name.'</a>';
					   $separator = ',';
	               }
				  $output .= '</span>'; 
			   }
			  
			 endif;
			 $output .= '</h6>';
		 }
		 
		 if($slider_title != ''){
			 $output .= '<h2 class="slider-title"><span>' .$slider_title. '</span></h2>';
		 }
		 
		 if( $show_excerpt == 'yes'){
			 $output .= '<div class="slider-content" >' .$slider_excerpt. '</div>';
		 }
		 
		 if($show_readmore == 'yes'){
			 $output .= '<div class="slider-buttons"><a  href="'. $slider_btn_link .'" class="button button_'.$slider_button_style.' button_small ">'. __('Read More','brad').'</a></div>';
		 }
		 
		 $output .= '</div></div></div></div></div>';
		 
		 $pagination_lines .= '<li data-target="#brad_slider'.$slider_id.'" data-slide-to="'.$slides_count.'">';

		   }
	   }
	   
	   else{
		 $slider_image_id =  preg_replace('/[^\d]/', '' , get_post_meta($post->ID,'brad_slider_image',true));
		 $slider_image = wp_get_attachment_image_src ( $slider_image_id ,'');
		 $slider_bg_cover = get_post_meta($post->ID,'brad_slider_bg_cover' , true);
		 $slider_bg_repeat = get_post_meta($post->ID,'brad_slider_bg_repeat' , true);
		 $slider_bg_pos = get_post_meta($post->ID,'brad_slider_bg_pos' , true);
		 $slider_type = get_post_meta($post->ID,'brad_slider_type' , true);
		 $slider_video_mp4 =  get_post_meta($post->ID,'brad_slider_video_mp4',true);
		 $slider_video_ogv =  get_post_meta($post->ID,'brad_slider_video_ogv',true);
		 $slider_video_webm =  get_post_meta($post->ID,'brad_slider_video_webm',true);
		 $slider_video_ratio =  get_post_meta($post->ID,'brad_video_ratio',true);
		 $caption_halign = get_post_meta($post->ID,'brad_slider_caption_align',true);
		 $caption_valign = get_post_meta($post->ID,'brad_slider_caption_valign',true);
		 $slider_title = get_post_meta($post->ID,'brad_slider_title',true);
		 $slider_subtitle = get_post_meta($post->ID,'brad_slider_subtitle',true);
		 $slider_caption = get_post_meta($post->ID,'brad_slider_caption',true);
		 $slider_button = get_post_meta($post->ID,'brad_slider_button',true);
		 $slider_button_style = get_post_meta($post->ID,'brad_slider_button_style',true);
		 $slider_color =  get_post_meta($post->ID,'brad_slider_color',true);
		 $slider_button_alternate = get_post_meta($post->ID,'brad_slider_button_alternate',true);
		 $slider_button_style_alternate = get_post_meta($post->ID,'brad_slider_button_style_alternate',true);
		 $slider_content_width = get_post_meta($post->ID,'brad_slider_content_width',true);
		 $slider_header_color = get_post_meta($post->ID,'brad_slider_header_color' , true);
		 $slider_effect = get_post_meta($post->ID,'brad_slider_caption_animation' , true);
		 $slider_btn_link = get_post_meta($post->ID,'brad_slider_btn_link',true);
		 $slider_altbtn_link = get_post_meta($post->ID,'brad_slider_altbtn_link',true);
		 $slider_bg_opacity = get_post_meta($post->ID,'brad_slider_bg_opacity',true);
		 $slider_bg_color = get_post_meta($post->ID,'brad_slider_bg_color',true);
		 $kenburn = get_post_meta($post->ID,'brad_slider_kenburn',true);
		 $kbpos_start = get_post_meta($post->ID,'brad_slider_kbpos_start',true);
		 $kbpos_end = get_post_meta($post->ID,'brad_slider_kbpos_end',true);
		 $kbzoom_start = get_post_meta($post->ID,'brad_slider_kbzoom_start',true);
		 $kbzoom_end = get_post_meta($post->ID,'brad_slider_kbzoom_end',true);
		 $kbduration = get_post_meta($post->ID,'brad_slider_kbduration',true);
		 $slider_style = 'opacity:'. $slider_bg_opacity .'; filter:alpha(opacity='. intval($slider_bg_opacity*100). ');';
			 
		 if($slider_bg_color != ''){
			 $slider_style .= 'background-color:'. $slider_bg_color. ';';
		 }
			 
			 
		 if( $kenburn == 'yes'){
			 $slider_bg_pos = $kbpos_start;
		 }
		 
		 $output .= '<div class="item" data-video-ratio="'.$slider_video_ratio.'"  data-header-scheme="header-scheme-'. $slider_header_color .'" data-slider-scheme="color-'.$slider_color.'"><div class="image bg-cover-'.$slider_bg_cover.'" style="background-image:url('. $slider_image[0] .'); background-position:'.$slider_bg_pos.'; background-repeat:'. $slider_bg_repeat .'" data-kenburn="'.$kenburn.'" data-kbstart="'.$kbpos_start.'" data-kbend="'.$kbpos_end.'" data-kbzoom-start="'.$kbzoom_start.'" data-kbzoom-end="'.$kbzoom_end.'" data-kb-duration="'.$kbduration.'" ><img src="'. $slider_image[0] .'"></div>';
		 
		 if($slider_type == 'video' && ( $slider_video_mp4 != '' || $slider_video_ogv != '' || $slider_video_webm != '')){
			 
			 $brad_includes['load_mediaelement'] = true;
			 
			 $output .= '<div class="carousel-video"><video poster="'.$slider_image[0].'"  preload="auto" autoplay loop="loop" muted="muted">';	
			 if($slider_video_mp4 != ""){
				$output .= '<source src="'.$slider_video_mp4.'" type="video/mp4">';
			 }
			 if ($slider_video_webm != "") {
				$output .= '<source src="'.$slider_video_webm.'" type="video/webm">';
			 }
			 if ($slider_video_ogv != "") {
				$output .= '<source src="'.$slider_video_ogv.'" type="video/ogg">';
			 }
			$output .= '</video></div>';
		 }
		 
		 $output .= '<div class="slider-bg-overlay" style="'.$slider_style.'"></div><div class="carousel-caption caption-halign-'. $caption_halign .' caption-valign-'.$caption_valign.' color-'.$slider_color.'"'. $parallax_script2 .'  ><div class="carousel-caption-wrapper"><div class="carousel-caption-content  ' .$slider_effect. '"><div class="carousel-caption-inner-content">';
		 
		 if($slider_subtitle != ''){
			 $output .= '<h6 class="slider-subtitle">'. $slider_subtitle .'</h6>';
		 }
		 
		 if($slider_title != ''){
			 $output .= '<h2 class="slider-title"><span>' .$slider_title. '</span></h2>';
		 }
		 
		 if( $slider_caption != ''){
			 $output .= '<div class="slider-content" >' .$slider_caption. '</div>';
		 }
		 
		 if($slider_button_alternate != '' || $slider_button != ''){
			 $output .= '<div class="slider-buttons">';
			 if($slider_button != ''){
				 $output .= '<a  href="'. $slider_btn_link .'" class="button button button_'.$slider_button_style.'">'.$slider_button.'</a>';
			 }
			 if($slider_button_alternate != ''){
				 $output .= '<a href="'. $slider_altbtn_link .'" class="button button button_'.$slider_button_style_alternate.'">'.$slider_button_alternate.'</a>';
			 }
			 $output .= '</div>';
		 }
		 
		 $output .= '</div></div></div></div></div>';
		 
		 $pagination_lines .= '<li data-target="#brad_slider'.$slider_id.'" data-slide-to="'.$slides_count.'">';
	   }
	   
	   $slides_count++;
	 endwhile;
	 
	 $output .= '</div>';
	 
	 if($pagination == 'yes'){
		 $output .= '<ol class="carousel-indicators">'.$pagination_lines.'</ol>';
	 }
	 
	 if($navigation == 'yes'){
		 $output .= '<a class="left carousel-control" href="#brad_slider'.$slider_id.'" data-slide="prev" '. $parallax_script3 .'></a><a class="right carousel-control" href="#brad_slider'.$slider_id.'" data-slide="next" '. $parallax_script3 .'></a>';
	 }
	 
	 $output .= '</div></div>';
	 
	 $brad_includes['load_bootstrapCarousel'] = true;
	 endif;

	 $slider_id++;	  
	 return $output;		  
 }
 
  
/*---------------------------------------------------*/
/* button
/*---------------------------------------------------*/
add_shortcode('button','brad_shortcode_button');
function brad_shortcode_button( $atts , $content = null) {
	$button_id = rand();	
	$output = $color = $size = $icon = $target = $href = $title = $position = '';
    extract(shortcode_atts(array(
       'style' => 'default',
	   'align' => '',
       'size' => '',
       'icon' => '',
	   'icon_style' => '',
	   'icon_align' => 'right',
	   'icon_ds' => 'hover' ,
	   'icon_size' => 'normal',
       'target' => '_self',
       'href' => '',
	   'icon_c' => '' ,
	   'icon_c_hover' => '' ,
	   'icon_bc' => '' ,
	   'icon_bgc' => '' ,
	   'icon_bgc_hover' => '' ,
       'title' => __('Text on the button', "brad-framework"),
       'position' => '' ), $atts));
        $a_class = '';

       if ( $target == 'same' || $target == '_self' ) { 
	       $target = '';
	   }
	  
	   
       $target = ( $target != '' ) ? ' target="'.$target.'"' : '';
       $color = ( $style != '' ) ? 'button_'.$style : '';
       $size = ( $size != '' && $size != 'default' ) ? ' button_'.$size : ' '.$size;
       $icon =   $style == 'readmore' ? brad_icon($icon  , $icon_style , '' , true ) : brad_icon($icon  , $icon_style , '' , false );
	   $ex_class = !empty($icon) ? ' btn-with-icon' : '';
	   
	   if( $style == 'readmore'){
		   $class = 'readmore  icon-align-'.$icon_align . ' visible-'. $icon_ds . $ex_class;
	   }
	   else {
		   $class = 'button button_'.$style.' '.$size.' '.$color.' icon-align-'.$icon_align . ' visible-'. $icon_ds . $ex_class ;
	   }
	   
	   if( $style == 'readmore' && ( $icon_bc != '' || $icon_c != '' || $icon_c_hover != '' || $icon_bgc != '' || $icon_bgc_hover != '' )){
		   $output .= "<style type='text/css' scoped>";
		   if( $icon_c_hover != '' || ( $icon_bgc_hover != "" && ( $icon_style == 'style2' || $icon_style == 'style3')) ){
		       $output .= "#brad_button_{$button_id}:hover .brad-icon{ ";
			   if( $icon_c_hover != '' ):
			       $output .= "color:{$icon_c_hover};";
			   endif;
			   if( $icon_bgc_hover != "" && ( $icon_style == 'style2' || $icon_style == 'style3')):
			        $output .= "background-color:{$icon_bgc_hover};border-color:{$icon_bgc_hover};";
			   endif;
			$output .= "}";
	     }
		   
		   if($icon_bc != '' || $icon_c != '' || $icon_bgc != '' ):
		       $output .= "#brad_button_{$button_id} .brad-icon{";
		       if( $icon_c != ''){
			       $output .= "color:{$icon_c};";
		       }
		       if( $icon_bc != '' && $icon_style == 'style2'){
			      $output .= "border-color:{$icon_bc};";
	           }
		       if( $icon_bgc != '' && $icon_style == 'style3'){
			       $output .= "background-color:{$icon_bgc};";
	           }
		      $output .= "}";
		   endif;
		   $output .= "</style>";
	   }
	   
	   if( $align == 'center' ){ $output .= '<p class="sp-container aligncenter">'; }
	  
       if ( $href != '' ) {
           $output .= '<a id="brad_button_'.$button_id.'" class="'.$class.'" title="'.$title.'" href="'.$href.'"'.$target.'>';
		   if( $icon_align != 'right' ) {
			   $output .= $icon;
		   }
		   $output .= '<span>'.$title.'</span>';
		   if( $icon_align == 'right'){
			   $output .= $icon;
		   }
		   $output .= '</a>';
       } 
       else {
          $output .= '<span id="brad_button_'.$button_id.'" class="'.$class.'">';
		   if( $icon_align != 'right' ) {
			   $output .= $icon;
		   }
		   $output .= $title;
		   if( $icon_align == 'right'){
			   $output .= $icon;
		   }
		   $output .= '</span>';
	   }
	   if( $align == 'center'){ $output .= '</p>'; }

       return $output;
  }
	
/*---------------------------------------------------*/
/* Gap
/*---------------------------------------------------*/

add_shortcode('gap', 'brad_gap');
	function brad_gap($atts, $content = null) {
		$output = '';
		extract(shortcode_atts(array(
		   'height' => '20'
         ), $atts));
		$output .= '<div class="gap" style="height:'.$height.'px"></div>';
		return $output;
	}



/*---------------------------------------------------*/
/* Pricing Table
/*---------------------------------------------------*/

add_shortcode('pricing_table', 'brad_pricing_table');
	function brad_pricing_table($atts, $content = null) {
		$output = '';
		extract(shortcode_atts(array(
		   'columns' => '3'
         ), $atts));
		$output .= "\n\t".'<div class="pricing-table row-fluid columns-'.$columns.'">';
		$output .= "\n\t\t".do_shortcode($content);
		$output .= "\n\t".'</div>';
		return $output;
	}


// Pricing Column
add_shortcode('pricing_column', 'brad_pricing_column');
	function brad_pricing_column($atts, $content = null) {
		$output = '';
		static $pricing_cid  = 1 ;
		extract(shortcode_atts(array(
		   'title' => '' ,
		   'icon' => '' ,
		   'title_bgcolor' => '',
		   'title_textcolor' => '',
		   'feature_bg_color' => '',
		   'featured' => 'no' ,
		   'feature_color' => '', 
		   'title_bc' => '',
       	   'price' => '10', 
		   'price_top_left' => '$',
		   'price_bottom_right' => '/Month',
		   'price_subtext' => '' ,
		   'button_text' => 'Sign Up' ,
		   'button_url' => '' , 
		   'button_icon' => ''
    ), $atts));
	
	 
	  if($icon != '' ){ $icon = '<span class="icon">'.brad_icon($icon , '' , '' , false).'</span>'; }
	  if($button_icon != '' ){ $button_icon = '<i class="'.$button_icon.'"></i>'; }
	  $style = $style1 = '';
	  if($title_bgcolor != '') { $style .= 'background-color:'.$title_bgcolor.';'; }
	  if($title_textcolor != '') { $style .= 'color:'.$title_textcolor.';'; }
	  if( $title_bc != '') { $style .= "border-top-color:{$title_bc}";}
	  $style = ' style="'.$style.'"';
	  if($feature_bg_color != '' || $feature_color != ''){
		  $style1 .= "background-color:{$feature_bg_color}; color:{$feature_color}";
	  }
	  
	  $output .= "\n\t".'<div class="span"><div id="pricing_column_'.$pricing_cid.'" class="pricing-column featured='.$featured.'" style="'.$style1.'">';
	  $output .= "\n\t\t".'<div class="title-box">' .$icon. '<h2>' .$title. '</h2></div>';
	  $output .= "\n\t\t\t".'<div class="pricing-box"><div><span class="price"><span class="dollor">'.$price_top_left.'</span>'.$price.'</span><span class="month">'.$price_bottom_right.'</span></div><div class="price-info">'.$price_subtext.'</div></div>'; 
	  
	  $output .= "\n\t\t\t\t".'<ul class="feature-list">' .do_shortcode($content). '</ul>';
      $output .= "\n\t\t\t\t\t".'<div class="pricing-signup"><a class="button button_alternateprimary button_small" href="'.$button_url.'">'.$button_icon.$button_text.'</a></div>';
	  $output .= "\n\t".'</div></div>';
	  $pricing_cid++;
	  return $output;
	}

// Pricing Row
add_shortcode('pricing_feature', 'brad_pricing_feature');
	function brad_pricing_feature($atts, $content = null) {
		$str = '';
		$str .= "\n\t".'<li class="included-text">';
		$str .= "\n\t\t".do_shortcode($content);
		$str .= "\n\t".'</li>';
		return $str;
	}
	
	
/*------------------------------------------------------*/
/* Compare Table
/*------------------------------------------------------*/

add_shortcode('compare_table','brad_compare_table');
function brad_compare_table($atts, $content = null) {
	$output = '';
	static $compare_table_id = 1;
    extract(shortcode_atts(array(
        'title'      => '' ,
		'title_bg' => '' ,
		'title_color' => '' ,
		'element'    => '3',
		'e1_title'      => '' ,
		'e1_icon'      => '' ,
		'e2_title'      => '' ,
		'e2_icon'      => '' ,
		'e3_title'      => '' ,
		'e3_icon'      => '' ,
		'e4_title'      => '' ,
		'e4_icon'      => '' ,
		'e5_title'      => '' ,
		'e5_icon'      => '' ,
		'sign_color' => '' ,
		'c_sign'      => 'dot' ,
		'i_sign'      => 'none'
    ), $atts));
	
	if( $sign_color != '' || $title_bg != '' || $title_color != '' ):
	
	   $output .= "<style type='text/css' scoped>";
	   if( $title_bg != ''){
		   $output .= "#compare_table_{$compare_table_id}.compare-table .table-heading{background-color:{$title_bg};}";
	   }
	   if( $title_color != ''){
		   $output .= "#compare_table_{$compare_table_id}.compare-table .table-heading-title h4,#compare_table_{$compare_table_id}.compare-table .table-element h4,#compare_table_{$compare_table_id}.compare-table .table-element .brad-icon{color:{$title_color};}";
	   }
	   if( $sign_color != ''){
		   $output .= "#compare_table_{$compare_table_id}.compare-table .table-feature .feature-element span{color:{$sign_color};}";
	   }
	   $output .= "</style>";
	   
	endif;
	
	$output .= '<div id="compare_table_'.$compare_table_id.'" class="compare-table elements-'. $element .' included-sign-'.$c_sign.' sign-'.$i_sign.' clearfix"><div class="table-heading clearfix"><div class="table-left table-heading-title"><h4>'.$title.'</h4></div><div class="table-elements table-right">';
	if($e1_title != ''){
		$output .= '<div class="table-element">';
		$output .= brad_icon($e1_icon);
		$output .= '<h4>'.$e1_title.'</h4>';
		$output .= '</div>';
	}
	
	if($e2_title != ''){
		$output .= '<div class="table-element">';
		$output .= brad_icon($e2_icon);
		$output .= '<h4>'.$e2_title.'</h4>';
		$output .= '</div>';
	}
	
	if($e3_title != ''){
		$output .= '<div class="table-element">';
		$output .= brad_icon($e3_icon);
		$output .= '<h4>'.$e3_title.'</h4>';
		$output .= '</div>';
	}
	
	if($e4_title != ''){
		$output .= '<div class="table-element">';
		$output .= brad_icon($e4_icon);
		$output .= '<h4>'.$e4_title.'</h4>';
		$output .= '</div>';
	}
	
	if($e5_title != ''){
		$output .= '<div class="table-element">';
		$output .= brad_icon($e5_icon);
		$output .= '<h4>'.$e5_title.'</h4>';
		$output .= '</div>';
	}
	
	$output .= '</div></div>';
	$output .= '<div class="table-features">';
	$output .= do_shortcode($content);
	$output .= '</div></div>';
	$compare_table_id++;
    return $output;
}


add_shortcode('compare_feature','brad_compare_feature');
function brad_compare_feature($atts, $content = null) {
	$output = '';
	extract(shortcode_atts(array(
        'title'      => '' ,
		'e1_included' => true ,
		'e2_included' => false ,
		'e3_included' => false ,
		'e4_included' => false ,
		'e5_included' => false ,
    ), $atts));
	
	$f1_in = $e1_included == "yes" ? '<span class="feature-included-yes">&nbsp;</span>' : '<span class="feature-included-no"></span>';
	$f2_in = $e2_included == "yes" ? '<span class="feature-included-yes">&nbsp;</span>' : '<span class="feature-included-no"></span>';
	$f3_in = $e3_included == "yes" ? '<span class="feature-included-yes">&nbsp;</span>' : '<span class="feature-included-no"></span>';
	$f4_in = $e4_included == "yes" ? '<span class="feature-included-yes">&nbsp;</span>' : '<span class="feature-included-no"></span>';
	$f5_in = $e5_included == "yes" ? '<span class="feature-included-yes">&nbsp;</span>' : '<span class="feature-included-no"></span>';
	
	
	$output .= "\n\t".'<div class="table-feature clearfix"><div class="table-left table-feature-title"><p>'.$title.'</p></div><div class="table-right table-feature-elements"><div class="table-element feature-element">'.$f1_in.'</div><div class="table-element feature-element">'.$f2_in.'</div><div class="table-element  feature-element">'.$f3_in.'</div><div class="table-element  feature-element">'.$f4_in.'</div><div class="table-element  feature-element">'.$f5_in.'</div></div></div>';
	
	return $output;
}






/*-----------------------------------------------------------------------------------*/
/*	Icon Lists
/*-----------------------------------------------------------------------------------*/
add_shortcode('iconlist','brad_iconlist');
function brad_iconlist( $atts, $content = null ) {
	extract( shortcode_atts( array(
           'style' => 'style1' , 'size'    => 'small'
           ), $atts ) );
    return '<ul class="styled-list '.$style.' size-'.$size.'">'. do_shortcode($content) .'</ul>';
}

add_shortcode('listitem','brad_listitem');
function brad_listitem( $atts, $content = null ) {
	extract( shortcode_atts( array(
           'icon' => ''
           ), $atts ) );
		   
	return '<li>'.brad_icon($icon , '','',false). do_shortcode($content) . '</li>';
}



/*-----------------------------------------------------------------------------------*/
/* List Item
/*-----------------------------------------------------------------------------------*/

add_shortcode('checklist','brad_list');
function brad_list( $atts, $content = null ) {
   extract(shortcode_atts(array(
       	'icon'      =>  '' ,
		'style'     =>  'style1',
		'size'    => 'small'
    ), $atts));
	
	$out = '<ul class="styled-list '.$style.' size-'.$size.'">';
	if($icon != "")
	{ $icon = brad_icon($icon,'','',false);}
	$content = str_replace ( '<i class="icon-to-replace"></i>',$icon , do_shortcode($content) );
	$out .= $content.'</ul>';
    return $out;
}

function brad_item( $atts, $content = null ) {
	return '<li><i class="icon-to-replace"></i>'. do_shortcode($content) . '</li>';
}
add_shortcode('item','brad_item');




/*------------------------------------------------------*/
/*Dropcap
/*------------------------------------------------------*/

add_shortcode('dropcap','brad_dropcap');
function brad_dropcap($atts, $content = null) {
    extract(shortcode_atts(array(
        'style'      =>  'default' ,
		'color' => 'default' 
    ), $atts));
	
	$out = "<span class='dropcap ". $style ." color-".$color."'>" .$content. "</span>";
    return $out;
}


/*-----------------------------------------------------------------------------------*/
/* Media */
/*-----------------------------------------------------------------------------------*/
add_shortcode('custom_video','brad_video');
function brad_video($atts) {
	extract(shortcode_atts(array(
		'type' 	=> '',
		'id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
		'autoplay' 	=> ''
	), $atts));
	
	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16);
	if (!$height && !$width){
		$height = 320;
		$width = 560;
	}
	
	$autoplay = ($autoplay == 'yes' ? '1' : false);
		
	if($type == "vimeo") $return = "<div class='video'><iframe src='http://player.vimeo.com/video/$id?autoplay=$autoplay&amp;title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' class='iframe'></iframe></div>";
	
	else if($type == "youtube") $return = "<div class='video'><iframe src='http://www.youtube.com/embed/$id?HD=1;rel=0;showinfo=0' width='$width' height='$height' class='iframe'></iframe></div>";
	
	else if($type == "dailymotion") $return ="<div class='video'><iframe src='http://www.dailymotion.com/embed/video/$id?width=$width&amp;autoPlay={$autoplay}&foreground=%23FFFFFF&highlight=%23CCCCCC&background=%23000000&logo=0&hideInfos=1' width='$width' height='$height' class='iframe'></iframe></div>";
		
	if (!empty($id)){
		return $return;
	}
}



/*-----------------------------------------------------------------------------*/
/* Icons
/*-----------------------------------------------------------------------------*/

add_shortcode('icon','brad_sh_icon');

function brad_sh_icon( $atts, $content = null ) {
	static $brad_icon_id = 1 ;
	$out = $li_after = $li_before = '';
	
	extract(shortcode_atts(array(
       	'icon'      => '' ,'size' => 'small' ,'style' => 'style1' , 'align' => '' , 'color' => '' , 'color_hover' => '' ,'bg_color' => '', 'bg_opacity' => '','bg_color_hover' => '', 'bg_opacity_hover' => '','border_color' =>'', 'border_opacity' => '' , 'border_width' => '1' , 'lb' =>'no' , 'link' => '' , 'enable_crease' => 'no' 
    ), $atts));
	
	if( $link != ''){
		$li_before = '<a href="'.$link.'"';
		if($lb == 'yes') $li_before .= ' rel="prettyPhoto[icon'. rand() .']"';
		$li_before .= '>';
		$li_after .= '</a>';
	}
	
	if( $color != '' || $color_hover != '' || $bg_color != '' || $bg_color_hover != '' || $border_color != '' ){
		$out .= "<style type='text/css' scoped>#brad_icon_{$brad_icon_id}{";
		if( $color != ''){
			$out .= "color:{$color};";
		}
		if( $bg_color != '' && $style == 'style3'){
			$rgb = brad_hex2rgb($bg_color);
			$rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$bg_opacity})";
			$out .= "background-color:{$bg_color};background-color:{$rgba};";
		}
		if( $border_color != '' && $style == 'style2'){
			$rgb = brad_hex2rgb($border_color);
			$rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$border_opacity})";
			$out .= 'border-width:'. intval($border_width) .'px;';
			$out .= "border-color:{$border_color};border-color:{$rgba};";
		}
		$out .= "}";
		
		if( $bg_color_hover != '' || $color_hover != ''){
			$out .= "#brad_icon_{$brad_icon_id}:hover{";
			if($bg_color_hover != '' || ( $style == 'style2' || $style == 'style3') ){
				$rgb = brad_hex2rgb($bg_color_hover);
			    $rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},{$bg_opacity_hover})";
				$out .= "background-color:{$bg_color_hover};background-color:{$rgba};border-color:{$bg_color_hover};border-color:{$rgba};";
			}
			if($color_hover){
				$out .= "color:{$color_hover};";
			}
			$out .= "}";
		}
		$out .= "</style>";
	}
    $class = ' enable-crease-'.$enable_crease.' '.$size.'-size '.$style ;
	if( $align == 'center'){ 
	     $out .= "\n\t".'<p class="sp-container textcenter">'. $li_before . brad_icon($icon,$class,"brad_icon_{$brad_icon_id}") . $li_after.'</p>';
	}
	else{
	   $out .= "\n\t". $li_before.brad_icon($icon,$class,"brad_icon_{$brad_icon_id}").$li_after;
	}
	$brad_icon_id++;
    return $out;
}



/*-----------------------------------------------------------------------------------*/
/*  Icons 
/*-----------------------------------------------------------------------------------*/
add_shortcode('icons','brad_sh_icons');

function brad_sh_icons( $atts, $content = null) {
	$output = '';
	static $si_id = 1;
	  extract( shortcode_atts( array(
           'size'=>'', 'style' => '' ,'icon_c' => '', 'align' => 'left' , 'icon_bgc' => '', 'icon_c_hover' => '', 'border_radius' => '0' ,'icon_bgc_hover' => '',
      ), $atts ) );
	  if(  $icon_bgc != '' || $icon_c != '' || $icon_c_hover != ''  || $icon_bgc_hover != '' ){
		  $output .= "<style type='text/css' scoped>";
		  if(  $icon_bgc != '' || $icon_c != '' || intval($border_radius) > 0 ):
		  $output .= "#brad_icons_{$si_id} li a{";
		  if( $icon_c != '') { $output .= "color:{$icon_c};";}
		  if( $icon_bgc != '') { $output .= "background-color:{$icon_bgc};";}
		  if( intval($border_radius) > 0 ){ $output .= "-webkit-border-radius:{$border_radius};border-radius:{$border_radius};";}
		  $output .= "}";
		  endif;
		  
		  if(  $icon_bgc_hover != '' || $icon_c_hover != '' ):
		  $output .= "#brad_icons_{$si_id} li a:hover{";
		  if( $icon_c_hover != '') { $output .= "color:{$icon_c_hover};";}
		  if( $icon_bgc_hover != '') { $output .= "background-color:{$icon_bgc_hover};";}
		  $output .= "}";
		  endif;
		  
		  $output .= "</style>";
	  }
      $output .=  "\n\t".'<ul id="brad_icons_'.$si_id.'" class="brad-icons '.$size.' '.$style.' icons-align-'.$align.'">';
	  $output .= "\n\t\t".do_shortcode($content); 
	  $output .= "\n\t".'</ul>';
	  $si_id++;
	  return $output;
}


add_shortcode('single_icon','brad_single_icon');
function brad_single_icon($atts,$content){
	
	extract( shortcode_atts( array(
      'icon' 	=> '',
      'url'		=> '#',
	  'title'   => '' ,
      'target' 	=> '_blank'
      ), $atts ) );
	 
	   
	 return "\n\t".'<li><a href="' . $url . '" title="' . $title . '" target="' . $target . '">'. brad_icon($icon , '' , '' , false) .'</a></li>'; 
	
	
	}
	
	
/*-----------------------------------------------------------------------------------*/
/* Tooltip */
/*-----------------------------------------------------------------------------------*/
add_shortcode('tooltip','brad_tooltip');

function brad_tooltip( $atts, $content = null){
	extract(shortcode_atts(array(
        'text' => '',
		'align' => 'top'
    ), $atts));

return '<span class="tooltips" data-align="'.$align.'"><a href="#"  title="'.$text.'" rel="tooltip" >'. do_shortcode($content) . '</a></span>';

}

/*-----------------------------------------------------------------------------------*/
/* Heading */
/*-----------------------------------------------------------------------------------*/
function brad_heading( $atts, $content = null){
	extract(shortcode_atts(array('type' => 'h1' ,'style'=>'' , 'text_transform' => 'default' , 'align' => 'left' , 'title' => 'Your title here' , 'margin_bottom' => '20px'),$atts));
	
	$output = "\n\t".'<'.$type.' class="title text'.$align.' '.$style.' text'.$text_transform.'" style="margin-bottom:'.$margin_bottom.'px">';
	$output .= "\n\t\t".'<span>'.$title.'</span>';
	$output .= "\n\t".'</'.$type.'>'."\n";
	return $output;
	
}

add_shortcode('heading','brad_heading');

/*-----------------------------------------------------------------------------------*/
/* Separator */
/*-----------------------------------------------------------------------------------*/

function brad_separator( $atts, $content = null){
    $output = '';
    extract(shortcode_atts(array(
	    'type'  => 'large' , 
		'style' => 'normal' ,
		'align' => 'center' , 
		'color' => 'light',
		'icon' => '' ,
		'margin_top' => 2 , 
		'margin_bottom' => 25 ),
		$atts));

	$css_class = 'hr border-'.$type.' '.$style.'-border align'.$align.' hr-border-'.$color;
	
	if($icon != '' ){
		$css_class .= ' hr-with-icon';
	}
	
	$style = "margin-top:{$margin_top}px;margin-bottom:{$margin_bottom}px;";
				
	$output .= '<div  class="'.$css_class.'" style="'.$style.'"><span>'.brad_icon($icon,'','',false).'</span></div>';
	return $output;
	
  }	
add_shortcode('separator','brad_separator');



/*---------------------------------------------------*/
/* highlight
/*---------------------------------------------------*/
function brad_highlighted($atts, $content = null) {

 $output = '';
 extract(shortcode_atts(array(
  'style' => 'style1'
  ), $atts));
  $output .= "\n\t".'<span class="highlighted '.$style.'">';
  $output .= "\n\t\t". do_shortcode($content);
  $output .= "\n\t".'</span>';
  return $output;
}
	
add_shortcode('highlighted','brad_highlighted');




/*-----------------------------------------------------*/
/*	Columns
/*-----------------------------------------------------*/


function brad_columns($atts , $content = null){
	
	return '<div class="row-fluid">' . do_shortcode($content) . '</div>';
	
	}
	add_shortcode('columns','brad_columns');
	
	
// 6
function brad_one_sixth( $atts, $content = null ) {
   return '<div class="span2">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'brad_one_sixth');



// 4
function brad_one_fourth( $atts, $content = null ) {
   return '<div class="span3">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fourth', 'brad_one_fourth');

// 5
function brad_one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'brad_one_fifth');


// 3
function brad_one_third( $atts, $content = null ) {
   return '<div class="span4">'.do_shortcode($content).'</div>';
}
add_shortcode('one_third', 'brad_one_third');


// 2
function brad_one_half( $atts, $content = null ) {
   return '<div class="span6">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'brad_one_half');


// 2/3
function brad_two_thirds( $atts, $content = null ) {
   return '<div class="span8">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds', 'brad_two_thirds');

//3/4
function brad_three_fourths( $atts, $content = null ) {
   return '<div class="span9">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourths', 'brad_three_fourths');



/*-----------------------------------------------------*/
/*	code
/*-----------------------------------------------------*/
function brad_code( $atts, $content=null ) {
	$content = str_replace('<br />', '', $content);
	$content = str_replace('<p>', '', $content);
	$content = str_replace('</p>', '', $content);
    $code = '<pre class="">'.htmlentities($content).'</pre>';
	return $code;
}

add_shortcode('code', 'brad_code');



?>