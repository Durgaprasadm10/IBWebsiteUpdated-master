<?php

/* Posts Carousel
--------------------------------------------------*/

   global $brad_includes , $post , $brad_love;
   
   $output = '';
   
   extract(shortcode_atts(array(
    'category'=> '' ,
	'columns' => 2 , 
	'show_author' => 'yes' ,
	'show_excerpt' => 'yes' ,
	'show_categories' => 'yes' ,
	'show_date'   => 'yes' ,
	'show_comments' => 'yes',
	'show_like' => 'yes' ,
	'show_date' => 'yes' ,  
	'excerpt_length' => 'no' ,   
	'autoplay' => 'no' , 
	'navigation' => 'no' , 
	'pagination' => 'no' ,
	'max_items' => 8 ),$atts));

	$args = array(
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'posts_per_page' => (int) $max_items
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
    $blog_items = query_posts($args);
		
	if(  have_posts() ) :
	$output .= '<div class="carousel-container portfolio-carousel posts-carousel-container pagination-'.$pagination.' navigation-'.$navigation.'"  data-navigation="'.$navigation.'" data-autoplay="'.$autoplay.'">';
	
	if( $navigation == 'yes') :
	    $output .=  '<a class="bx-next" href="#"></a><a class="bx-prev" href="#"></a>';
	endif;
	
	if( $pagination == 'yes') :
	    $output .=  '<div class="pagination"></div>';
	endif;
	
	
	$output .= '<div class="carouel-outer clearfix"><div class="carousel-wrapper carousel-padding-default"><div class="row carousel-items posts-carousel columns-'.$columns.'"  data-columns="'.$columns.'">';
	
	$img_size = brad_get_img_size($columns);
	
	while ( have_posts() ) : the_post();

    $images =  rwmb_meta('brad_image_list', "type=image&size={$img_size}"); 
	
	$output .= '<div class="carousel-item span">';

	if( !empty($images) || get_post_meta(get_the_ID(),'brad_video_embed',true) != '' ){
		
		$output .= '<div class="flexible-slider-container"><div class="flexible-slider floated-slideshow">';
		
		if( get_post_meta(get_the_ID(),'brad_video_embed',true) != ''):
            $output .= '<div><div class="video">'.get_post_meta(get_the_ID(),'brad_video_embed',true).'</div></div>';
         endif;
		 
		 if(!empty($images)):
		   foreach($images as $image ){
			   $output .= '<div><div class="image hoverlay"><a  href="'.get_permalink().'"><img src="'.$image['url'].'" alt="'. get_the_title().'" /></a></div></div>';
			   }
		  endif;
	 
		 if( has_post_thumbnail() ){
			$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) , $img_size );
			$src2= wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) , '');
			$output .= '<div class="image hoverlay"><a href="'. $src2[0] . '" rel="prettyPhoto[posts]"><img src="'.$src[0].'" alt="'.get_the_title().'" /></a></div>';
		}
		
		$output .= '</div></div>';
	 
	}
	else if( has_post_thumbnail() ){
		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) , $img_size );
		$src2= wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) , '');
		$output .= '<div class="image hoverlay"><a href="'. $src2[0] . '" rel="prettyPhoto[posts]"><img src="'.$src[0].'" alt="'.get_the_title().'" /></a></div>';
	}
	
	$output .= '<div class="post-meta">';
	if($show_date == 'yes' ||   $show_categories == 'yes' ) :
	
	  $output .= '<div class="post-meta-data  style2">';
	  //If categories are enabled by default
	  if($show_categories == 'yes'){
		  $category_list = '';
		  $categories = get_the_category($post->ID);
		  $separator = '';
		  foreach( $categories as $category){
			  $category_list .= $separator.'<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" , "brad-framework" ), $category->name ) ) . '">'.$category->cat_name.'</a>' ;
			  $separator = ' , ';
		  }
		  $output .= '<span  class="post-meta-cats">'.$category_list.'</span>';
	  }
	  
	  if( $show_date == 'yes'){
		  $output .= '<span class="post-meta-date">'. get_the_date('d.m.y') .'</span>';
	  }
	 //End post meta
	 $output .= '</div>';
	endif;
	
	$output .= '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4></div>';
	
	

	
	//If Expert is showm
	if( $show_excerpt == 'yes'){
		$output .= '<p class="excerpt">'.brad_limit_words(get_the_excerpt(), $excerpt_length).'</p>';
	}
	
	if( ( $show_comments == 'yes' && comments_open() ) || $show_author == 'yes' || $show_like == 'yes') :
	
	$output .= '<div class="post-bottom"><div class="post-meta-data no-dash">';
	
	  if( $show_comments == 'yes' && comments_open() ){
				$comments = '';
				$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
				if ( $num_comments == 0 ) {
					$comments = '<i class="fa fa-comment-o"></i>'.__('0 Commment','brad-framework');
				}
				elseif ( $num_comments == 1 ) {
					$comments = '<a href="' . get_comments_link() .'"<i class="fa fa-comment-o"></i>'.  __('1 Commment','brad-framework') .'</a>';	  
				 } elseif ( $num_comments > 1 ) {
					$comments = '<a href="' . get_comments_link() .'"><i class="fa fa-comment-o"></i>'. sprintf( __('%s Commments','brad-framework') , $num_comments) .'</a>';
				}
			 
			 $output .= '<span>'. $comments .'</span>';
			 
	  }
	  
	  
	  if( $show_like == 'yes'){
		  $love = $brad_love->add_love(true); 
		  $output .= '<span class="love-it">'. $love .'</span>';
	  }
	  
	  if($show_author == 'yes'){
		  $output .= '<span><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'"><i class="fa fa-user"></i>'.get_the_author_meta( 'display_name' ) .'</a></span>';
	  }
	  
	 $output .= '</div></div>';
	 
	endif;
	
	
	$output .= '</div>';
	endwhile;
    wp_reset_query();
	$output .= '</div></div></div></div>'.$this->endBlockComment('Posts Carousel')."\n";
	
    $brad_includes['load_caroufred'] = true;	
	
	endif;
	echo $output;

