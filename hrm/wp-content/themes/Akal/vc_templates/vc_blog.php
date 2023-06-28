<?php

/* Blog List
-----------------------------------------------------------------*/

	 $output = '';
	 
     extract( shortcode_atts( array(
            'category'        =>  '',
			'order'           => 'date',
			'orderby'         => 'DESC',
			'masonry'        => 'yes' ,
            'blog_type'       =>  'grid',
			'padding'     => 'default' ,
            'bg_style'        =>  '',
			'check_postlove' => '1' ,
			'columns'         => '3' ,
			'show_author'     => 1 ,
			'show_date'       => 1,
			'align'  => 'top' ,
			'upper_align' => 'center' ,
			'show_comments'   => 1,
			'ex_items'    => '',
			'show_sharebox'    => 0 ,
			'en_readmore'    => 1 ,
			'show_categories' => 1 ,
			//'show_excerpt'    => '1' ,
			'excerpt_length'  => '20' ,
			'max_items'       => '8',
            'pagination'      => 'default',
		  	//'button_style' => '' ,
		    //'lm_title' => __('Load More','brad-framework'),
		    //'nomore_posts_txt' => __('No More Projects','brad-framework'),
		    'icon' => '',
        ), $atts ) ); 
	
	global $post  , $brad_data;
	
	$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
	if(!$page) $page = 1;
	
	$args = array(
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'posts_per_page' => (int)$max_items,
		'paged'          => $page,
		'order'          => $order,
		'orderby'        => $orderby,
		'post__not_in' => wp_parse_id_list( $ex_items ) 
         );
		 
	 if(!empty($category)){
			$cat_id = explode(',', $category );
			$args['tax_query'] = array(
				array(
				 'taxonomy' => 'category',
				 'field' => 'slug',
				 'terms' => $cat_id
				     )
			     );
		      }
      
	  query_posts($args);	
	  
	  if(  have_posts() ) :
	  $brad_data['grid_blog_columns'] = $columns;
	  $brad_data['grid_blog_style'] = $bg_style;
	  $brad_data['check_blog_categories'] = $show_categories ;
	  $brad_data['check_author'] = $show_author;
	  $brad_data['check_blog_date'] = $show_date;
	  $brad_data['check_blog_comments'] = $show_comments;
	  $brad_data['text_excerptlength'] = $excerpt_length;
	  $brad_data['blog_pagination'] = $pagination;
	  $brad_data['check_blogshare'] = $show_sharebox;
	  $brad_data['check_readmore']  = $en_readmore;
	  $brad_data['blog_masonry']  = $masonry;
	  $brad_data['check_postlove'] = $check_postlove;
	  $brad_data['blog_padding'] = $padding;
	  $brad_data['blog_align'] = $align;
	  $brad_data['blog_upper_align'] = $upper_align;
	  
      ob_start();
	  get_template_part( 'framework/templates/blog/posts/posts', $blog_type );
	  $output .= ob_get_clean();
	  endif;
	  wp_reset_query();
      echo $output;	
?>
