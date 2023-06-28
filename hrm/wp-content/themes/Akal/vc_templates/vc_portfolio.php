<?php

/* Portfolio
--------------------------------------------------*/

   //global Variables
   global $post , $brad_includes ;
   
   //Portfolio Id
   $portfolio_id = rand() ;
   
   //Output Buffer
   $output =  $style = '';
   extract(shortcode_atts(array(
        'categories' => '' ,
	    'columns' => 2 , 
		'vpadding' => 'default' ,
	    'portfolio_style' => 'style1' ,  
		'info_onhover' => 'yes' ,
	    'padding' => '' ,  
	    'sortable' => 'no' , 
		'sortable_style' => '' , 
		'sortable_align' => '' ,
		"bg_style" => 'white' ,
		'sortable_label' => 'no',
		'fullwidth' => 'no' ,
		//'sortable_color_scheme' => '',
		//'sortable_container' => '' ,
		//'sortable_bg_color' => '' ,
	    'show_lb_icon' => 'no' ,
		'tabs_scheme'  => 'scheme1' ,
		'show_li_icon' => 'no' ,
		'en_loveit' => 'no' , 
		'disable_li_title' => 'no',
	    'css_animation' => '',
		'divider' => 'no' ,
	    'di_style' => 'style1' ,
	    'di_color' => 'default',
	    'di_type' => 'tiny',
	    'css_animation_delay' => '0', 
	    'max_items' => 8 , 
		'info_style' => "default" ,
	    'orderby' => 'date',
	    'order' => 'DESC',
		'masonry' => 'no' ,
	    'pagination' => 'default', 
		'img_size' => '' ,
		'custom_img_size' => '' ,
		'button_style' => '' ,
		'lm_title' => __('Load More','brad-framework'),
		//'nomore_posts_txt' => __('No More Projects','brad-framework'),
		'icon' => '',
	    'show_categories' => 'no',
	    'el_class' => ''
	         ),$atts));
	 
   //Extra Class
   $el_class = $this->getExtraClass($el_class);
   $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'row-fluid portfolio-items bg-style-'.$bg_style.' sortable-items portfolio-'.$portfolio_style.' columns-'.$columns.' love-it-'.$en_loveit.' enable-hr-'.$divider.' hr-type-'.$di_type.' hr-color-'.$di_color.' hr-style-'.$di_style.' element-padding-'.$padding.' info-style-'.$info_style.' element-vpadding-'.$vpadding.' info-onhover-'.$info_onhover.' '.$el_class, $this->settings['base']);
   $css_class .= brad_getCSSAnimation($css_animation);
	
	$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
	if(!$page) $page = 1;
		 
	$query_args = array(
		'post_type' => 'portfolio',
		'posts_per_page' => (int)$max_items,
		'paged'          => $page,
		'order'          => $order,
		'orderby'        => $orderby,
		'post_status'    => 'publish'
		
    );
	
	// Narrow by categories
    if ( $categories != '' ) {
    $category_query = explode(",", $categories);
    $query_args['tax_query'] = array(
			array(
				'taxonomy' => 'portfolio_category',
				'field' => 'slug',
				'terms' => $category_query,
				 'orderby' => 'ID' ,
				 )
			  );
	}
	
    $portfolios = new WP_Query( $query_args );
	//check if already ready a infinite scroll post or portfolio in this page 
	
	if( $brad_includes['load_infiniteScroll'] == true && ( $pagination == 'if_scroll' || $pagination == 'loadmore' )) {
	   $output .= '<p>'. __('Sorry You cannot create more than 1 infinite scroll or Load More Posts ( Portfolios ) per page . Please change this in page builder ','brad') .'</p>';
	}
	
	else {
		
    // check if portfolios  exists
    if( $portfolios -> have_posts() ) :
  
	   
	 // Show Sortable Container If enabled by default
	   if($sortable == 'yes') :
	       $terms = array();
	        if ( $categories != '' ) {
		        foreach ( explode( ',', $categories ) as $term_id ) {
			    $terms[] = get_term_by( 'slug', $term_id , 'portfolio_category' );
		    }
	        } else {
	           $terms = get_terms('portfolio_category','hide_empty=1');
		    }
	          if($terms):
	           $output .=  '<div class="portfolio-tabs '.$tabs_scheme.' portfolio-tabs-align-'.$sortable_align.' portfolio-tabs-black'.$sortable_style.' clearfix"><div class="portfolio-tabs-container"><ul class="clearfix">';
			   if( $sortable_label == 'yes') : 
			       $output .= '<li class="sort-label">'.__("Sort Portfolios :","brad-framework").'</li>';
			   endif;
			   $output .= '<li class="sort-item active"><a data-filter="*" href="#">'. __('All', 'brad') .'</a></li>';
	           foreach($terms as $term){
			       $output .=  '<li class="sort-item"><a data-filter=".'.$term->slug.'" href="#">'.$term->name.'</a></li>';
			    }
	           $output .= ' </ul></div></div>';
	        endif;
	    endif;

		$ex_class = ($pagination == 'ifscroll' || $pagination == 'loadmore' ) ? 'posts-with-infinite' : '' ;
		
		// Portfolio output starts here..
	    $output .= '<div id="portfolio_'.$portfolio_id.'" class="portfolio '. $ex_class .' padding-'.$padding.'" ><div class="'.$css_class.'" data-columns="'.$columns.'"  data-animation-delay="'.$css_animation_delay.'" data-animation-effect="'.$css_animation.'" data-masonry-layout="'.$masonry.'">';
	   
	   //Build Default argument for portfolio loop
	   $args = array(
	       'portfolio_style' => $portfolio_style ,
		   'class'  => 'span' ,
		   'img_size' => ($img_size == 'custom' && $custom_img_size != '' ) ? trim($custom_img_size) : brad_get_img_size($columns,$masonry,$fullwidth) ,
		   'show_lb_icon' => $show_lb_icon ,
		   'show_li_icon' => $show_li_icon,
		   'en_loveit'    => $en_loveit ,
		   'disable_li_title' => $disable_li_title ,
		   'show_categories' => $show_categories ,
		   'info_onhover' => $info_onhover
		   );
	   
	    while ( $portfolios -> have_posts() ) :  $portfolios -> the_post();
	        $output .= brad_portfolio_loop_style1( $portfolios , $args);
        endwhile;	
		   	
	   $output .= '</div></div>';
		   
		   
			//only included script if portfolio post exists
			$brad_includes['load_isotope'] = true ;
			
            if( $pagination == 'ifscroll' || $pagination == 'loadmore'){
				  $output .= '<div id="infinite_scroll_loading" class="clearfix margin-on-'.$padding.' '.$portfolio_style.'"></div>';
	              $brad_includes['load_infiniteScroll'] = true ;
             }
              
			endif;
			//End posts if exist;
            
			 if( $pagination == 'default' || $pagination == 'ifscroll' || $pagination == 'loadmore'):
			   $p_class =  $pagination == 'default' ? '' : 'hidden';
               $output .= brad_pagination($portfolios->max_num_pages , $range = 2 , false , $p_class ,$portfolios->query_vars['paged']);
            endif;
            
		   if( $pagination == 'loadmore' ):
		        $btn_class = !empty($icon) ? 'btn-with-icon' : '';
                $output .= '<p id="load_more" class="sp-container aligncenter"><a  href="#" class="button button_'.$button_style.' icon-align-right button_small '.$btn_class.'" title="'.$lm_title.'">'.brad_icon($icon,'','',false).'<span>'.$lm_title.'</span></a></p>';
           endif;
  
           wp_reset_postdata();			
			  
            }
     
            $portfolio_id;
            echo $output;  
