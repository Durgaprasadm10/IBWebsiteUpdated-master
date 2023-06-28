<?php

	 global $brad_includes;
	 $output = '';
     extract( shortcode_atts( array(
            'category'        =>  '',
            'type'            =>  '1',
            'max_items'       =>  '6',
			'excerpt_length'  => '20',
			'show_comments'   => 'no',
			'img_size'   => 'default'
        ), $atts ) ); 
	
	global $post , $wpdb;
	
	$args = array(
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'posts_per_page' => (int)$max_items
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
	  if( have_posts() ) :
	    $brad_includes['load_bxslider'] = true;
        $output .= '<div class="latest-posts-wrapper"><ul class="latest-posts style'.$type.' image-size-'.$img_size.' clearfix">';
    	while ( have_posts() ) : the_post();
		 
		 $num_comments = get_comments_number(); // get_comments_number returns only a numeric value
         $comments ='';
          if ( comments_open() ) {
	      if ( $num_comments == 0 ) {
		     $comments = __('No Comment','brad');
	      } elseif ( $num_comments > 1 ) {
		     $comments = $num_comments . __(' Comments','brad');
	      } else {
		    $comments = __('1 Comment','brad');
	      } }
	   
		if( $type == 1){
		  $output .= '<li class="latest-posts-item clearfix">';
		  
		  if(has_post_thumbnail() || ( get_post_format() == 'video' && get_post_meta($post->ID,'brad_video_poster',true) != '') ){
			 
			if(get_post_format() == 'video' && get_post_meta($post->ID,'brad_video_poster',true) != ''){
			   $src = wp_get_attachment_image_src( get_post_meta($post->ID,'brad_video_poster',true) , 'thumbnail' );
		       $src2 = wp_get_attachment_image_src( get_post_meta($post->ID,'brad_video_poster',true) , '' );
			}
			else{
			  $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) , 'thumbnail' );
			  $src2= wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) , '');
			}
			 
			  $output .= '<div class="image"><a href="'. $src2[0] . '" rel="prettyPhoto[slides]" class="block prettyPhoto"><img src="'.$src[0].'" alt="'.get_the_title().'" /></a></div>';

		  }
		  
		  $output .= '<div class="latest-posts-content"><div><h3><a class="title" href="'. get_permalink() .'">'.get_the_title().'</a></h3><p class="post-meta-data"><span>'.get_the_date().'</span>'. ( $comments != '' && $show_comments == 'yes' ? '<span>'.$comments.'</span>' : '' ) .'</p>';
		  
		  if( intval($excerpt_length) > 0){
			  $output .= '<p class="excerpt">'.brad_limit_words(get_the_excerpt(),intval($excerpt_length)). '</p>';
		  }
						
		  $output .= '</div></div></li>';			
		}
		
		else{
		  $output .= '<li class="latest-posts-item clearfix">';
		  $output .= '<div class="date"> <span class="month">'.get_the_time('M').'</span> <span class="day">'. get_the_time('d') .'</span> </div>';
		  $output .= '<div class="latest-posts-content"><div><h3><a class="title" href="'. get_permalink() .'">'.get_the_title().'</a></h3><p class="post-meta-data">'. ( $comments != '' && $show_comments == 'yes' ? '<span>'.$comments.'</span>' : '' ) .'</p>';
		  		  
		  if( intval($excerpt_length) > 0){
				$output .= '<p class="excerpt">'.brad_limit_words(get_the_excerpt(),intval($excerpt_length)). '</p>';
		  }
						 
		  $output .= '</div></div></li>';	
		}
	endwhile;
	wp_reset_query();
	$output .= '</ul></div>'.$this->endBlockComment('Blog List')."\n";
	endif;
    echo $output;	