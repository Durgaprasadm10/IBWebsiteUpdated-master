<?php

/* Portfolio Carousel
--------------------------------------------------*/
   global $post , $brad_includes ;
   $output = '';
   
   extract(shortcode_atts(array(
    'category' => '' ,
	'columns' => 2 , 
	'padding' => 'default' ,   
	'fullwidth' => 'no' , 
	'portfolio_style' => 'style1' ,  
	'max_items' => 8 ,
	'show_lb_icon' => 'no' ,
    'show_li_icon' => 'no' ,
	'en_loveit' => 'no' , 
	'disable_li_title' => 'no',
	'info_onhover' => 'yes' ,
	'navigation' => 'no' , 
	'bg_style' => '',
	'pagination' => 'no' ,
	'divider' => 'no' ,
	'di_style' => 'style1' ,
	'di_color' => 'default',
	'di_type' => 'tiny',
	'img_size' => '',
	'custom_img_size' => '' ,
	'orderby' => 'date',
	'order'   => 'DESC',
	'autoplay' => 'no' , 
	'show_categories' => 'no'),$atts));

   $args = array(
		'post_type' => 'portfolio',
		'posts_per_page' => (int)$max_items,
		'order'          =>  $order,
		'orderby'        => $orderby ,
		'post_status'    => 'publish'
    );

   // Narrow by categories
    if ( $category != '' ) {
    $category_query = explode(",", $category);
    $args['tax_query'] = array(
			array(
				'taxonomy' => 'portfolio_category',
				'field' => 'slug',
				'terms' => $category_query
				 )
			  );
	}
	
   $portfolios = new WP_Query( $args );
   
   // check if portfolios  exists
    if( $portfolios->have_posts() ) :
	$brad_includes['load_caroufred'] = true;


    $output .= '<div class="carousel-container portfolio-carousel pagination-'.$pagination.' navigation-'.$navigation.'"  data-fullwidth="'.$fullwidth.'" data-autoplay="'.$autoplay.'">';
	if( $navigation == 'yes') :
	    $output .=  '<a class="bx-next" href="#"></a><a class="bx-prev" href="#"></a>';
	endif;
	if( $pagination == 'yes') :
	    $output .=  '<div class="pagination"></div>';
	endif;
	$output .= '<div class="carouel-outer clearfix"><div class="carousel-wrapper carousel-padding-'.$padding.'">
				<div class="row carousel-items portfolio-items portfolio-'.$portfolio_style.' enable-hr-'.$divider.' hr-type-'.$di_type.' hr-color-'.$di_color.' hr-style-'.$di_style.' love-it-'.$en_loveit.'  element-padding-'.$padding.' bg-style-'.$bg_style.' columns-'.$columns.'" data-columns="'.$columns.'">';
    
	//Build Default argument for portfolio loop
	$args = array(
	       'portfolio_style' => $portfolio_style ,
		   'class'  => 'span' ,
		   'img_size' => ($img_size == 'custom' && $custom_img_size != '' ) ? trim($custom_img_size) : brad_get_img_size( $columns , 'no' , $fullwidth) ,
		   'show_lb_icon' => $show_lb_icon ,
		   'show_li_icon' => $show_li_icon,
		   'en_loveit'    => $en_loveit ,
		   'info_onhover' => $info_onhover,
		   'disable_li_title' => $disable_li_title ,
		   'show_categories' => $show_categories 
		   );
		   
	while ( $portfolios -> have_posts() ) : $portfolios ->the_post();
	    //if portfolio has featured image or additional images
	    $output .= brad_portfolio_loop_style1( $portfolios , $args);
    endwhile;	

    $output .= '</div></div></div></div>';
    endif;
	wp_reset_query();
    echo $output;  
