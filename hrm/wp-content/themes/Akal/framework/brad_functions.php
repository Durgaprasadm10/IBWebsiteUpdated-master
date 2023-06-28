<?php 
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

// Global Variables 
  $brad_includes = array(
      "load_gmap" => false ,
	  "load_isotope" => false ,
	  "load_caroufred" => false ,
	  "load_infiniteScroll" => false ,
	  "load_bootstrapCarousel" => false ,
	  "load_bxslider" => false ,
	  "load_mediaelement" => false,
	  "global_mapData" => array()
	  );


    $fa_icons = $uploaded_icons = array();
    $fa_pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
    $fa_path =  get_template_directory().'/css/icons.css';
	$fa_content = '';
    if( file_exists( $fa_path ) ) {
		$fa_content = file_get_contents($fa_path);
    }
   
   preg_match_all($fa_pattern, $fa_content , $fa_matches, PREG_SET_ORDER);
   foreach($fa_matches as $k => $fa_match){
	   $fa_icons[$k] = $fa_match[1];
   }
   

   
    if(!empty($brad_data['custom_iconfont']['css-file']) && !empty($brad_data['custom_iconfont']['prefix']) && !empty($brad_data['custom_iconfont']['name'])){

	    $pattern = '/\.('.$brad_data['custom_iconfont']['prefix'].'-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		
        $path =   $brad_data['custom_iconfont']['css-file'];
	    $content = '';
		
        if( file_exists( $path ) ) {
		   $content = file_get_contents($path);
        }

	    preg_match_all($pattern, $content , $matches, PREG_SET_ORDER);
        foreach($matches as $k => $match){
	        $uploaded_icons[$k] = $match[1];
        }

   }
   
 

// Brad icon sorting
function brad_icon( $icon , $class = '' , $id = '' , $wrapper = true , $data = '' ){
	global  $fa_icons , $uploaded_icons , $brad_data ;
	$return_icon = '';
	if( $icon == ''){
		return '' ;
	}
	if( $id != ''){
		$id = 'id="'.$id.'"';
	}
	
	$icon = explode ("|", $icon);
	if( empty($icon[1])){
		$icon_type = ''; 
	}
	else{
	   $icon_type = $icon[1];
	}
    $icon_value = $icon[0];

    if( $wrapper == true ) :
	     $return_icon = '<span '.$id.' class="brad-icon '.$class.'" '.$data.'>';
	endif;
	
    if($icon_type == 'uploaded' && array_key_exists($icon_value , $uploaded_icons)){
	    $return_icon .= '<i class="'.$brad_data['custom_iconfont']['prefix'].' '.$uploaded_icons[$icon_value].'"></i>';
     }
	 
     else if(  array_key_exists($icon_value , $fa_icons) ){	
	     $return_icon .= '<i class="'.$fa_icons[$icon_value].'"></i>';
	  }
	  
	 if( $wrapper == true ) :
         $return_icon .= '</span>';
     endif;

	return $return_icon;
}



// Get Realted Posts	
function brad_get_related_posts($post_id) {
	global $brad_data;
	$query = new WP_Query();
    $args = '';
	$args = wp_parse_args($args, array(
		'showposts' =>  intval($brad_data['blog_relatedpostsnumber']) ,
		'post__not_in' => array($post_id),
		'ignore_sticky_posts' => 0,
        'category__in' => wp_get_post_categories($post_id)
	));
	$query = new WP_Query($args);
  	return $query;
}


//Get realted Projects
function brad_get_related_projects($post_id) {
    $query = new WP_Query();
    $args = '';
    $item_cats = get_the_terms($post_id , 'portfolio_category');
    if($item_cats):
    foreach($item_cats as $item_cat) {
        $item_array[] = $item_cat->term_id;
    }
    endif;
	if( @ !is_array($item_array)){
		$item_array = array();
	}
    $args = wp_parse_args($args, array(
        'showposts' => -1,
        'post__not_in' => array($post_id),
        'ignore_sticky_posts' => 0,
		'meta_key' => '_thumbnail_id',
        'post_type' => 'portfolio',
        'tax_query' => array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'id',
                'terms' => $item_array
            )
        )
    ));
    
    $query = new WP_Query($args);
    return $query;
}



//Get class Name According to Columns
function brad_get_class_name($columns){
	switch ( $columns ){
		
		case '5':
		   $class = 'span_onefifth';
		break;
		
		case '4':
		   $class = 'span3';
		break;
		
		case '3':
		   $class = 'span4';
		break;
		
		case '2':
		   $class = 'span6';
		break;
		
		case '1':
		   $class = 'span12';
		break;
		
		default :
		   $class = 'span6';
		break;
	}
   return $class;
}


//Get image Size according to columns
function brad_get_img_size($columns , $masonry = 'no' , $fullwidth = 'yes'){
	
	$ex_thumb = '';
	
	if($masonry == 'yes'){
		$ex_thumb  = '-masonry';
	}
	
	
	switch($columns){
		case '4':
		case '5':
		case '6':
			$img_size = 'thumb-normal'.$ex_thumb ;
		break;
		
		case '3':
			$img_size = 'thumb-medium'.$ex_thumb;
		break;
		
		default:
			$img_size = 'thumb-large'.$ex_thumb;
		break;
	}
	
	return $img_size;
}




//brad_shortcode_pagination
function brad_pagination($pages = '', $range = 2 , $echo = true , $el_class = '' , $current_page = '' ){
	 global $brad_data , $paged;
	 $html = '';  
     $showitems = ($range * 2)+1;  

     if($current_page != '') $paged = $current_page;
	 if(empty($paged)) $paged = 1;
	 
     if($pages == '')
     {
		 global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {   //Edit here for sections
         $html .= "<div class='page-nav clearfix {$el_class}'>";
         //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'><span class='arrows'>&laquo;</span> First</a>";
         if($paged > 1) {
			  $html .= "<a  href='".get_pagenum_link($paged - 1)."' class='prev'><i class='fa-angle-left'></i>".__('Prev', 'brad')."</a>";
		 }

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                $html .= ($paged == $i)? "<span class='active'>".$i."</span>":"<a href='".get_pagenum_link($i)."' >".$i."</a>";
             }
         }

         if ($paged < $pages) {
			  $html .= "<a href='".get_pagenum_link($paged + 1)."' class='next'>".__('Next', 'brad')."<i class='fa-angle-right'></i></a>"; 
		 }
         //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last <span class='arrows'>&raquo;</span></a>";
         $html .= "</div>\n";
     }
	 if( $echo == false ){
	    return $html ;
	 }
	 echo $html;
}

	
 // New Excerpt length	
   function brad_new_excerpt_length($length) {
		global $brad_data;
	    return $brad_data['text_excerptlength'];
	}
   add_filter('excerpt_length', 'brad_new_excerpt_length');
	
	
	
  // Word Limiter
	function brad_limit_words($string, $word_limit) {
		$words = explode(' ', $string);
		return implode(' ', array_slice($words, 0, $word_limit));
	}

 
// Breadcrumbs
   function brad_breadcrumbs() {
       global $brad_data , $post ;
       $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
       $delimiter = '<span class="separator">/</span>'; // delimiter between crumbs
       $home = __('Home','brad'); // text for the 'Home' link
       $blog = __('Latest News','brad');
       $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
       $before = '<span class="current">'; // tag before the current crumb
       $after = '</span>'; // tag after the current crumb
       $homeLink = home_url();
	   
       //If homepage or Front Page
       if (is_home() || is_front_page()) {
       if ($showOnHome == 1) echo '<div id="breadcrumbs"><span class="breadcrumb-title">'.__('You Are Here:','brad').'</span><span><a href="' . $homeLink . '">' . $home . '</a></span> ' . $delimiter . ' ' . $blog . '</div>';
        } 
        else {
		  echo '<div id="breadcrumbs"><span class="breadcrumb-title">'.__('You Are Here:','brad').'</span><span><a href="' . $homeLink . '">' . $home . '</a></span> ' . $delimiter . ' ';
		  
		 //Category Display
		 if ( is_category() ) {
		   $thisCat = get_category(get_query_var('cat'), false);
		   if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
		   echo $before . __('Archive by category','brad').' "' . single_cat_title('', false) . '"' . $after;
		 } 
		 
		 //Search Results
		 elseif ( is_search() ) {
		   echo $before . __('Search results for','brad').' "' . get_search_query() . '"' . $after;
		 } 
		 
		 //Archives By Day
		 elseif ( is_day() ) {
		   echo '<span><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></span>' . $delimiter . ' ';
		   echo '<span><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></span>' . $delimiter . ' ';
		   echo $before . get_the_time('d') . $after;
			}
		  
		  //Archieves By Month
		  elseif ( is_month() ) {
			echo '<span><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> </span>' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
			} 
		  
		  //Archives By Year
		  elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
		  } 
		  
		  //Single Page 
		  elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
			  $post_type = get_post_type_object(get_post_type());
			  $slug = $post_type->rewrite;
			  echo '<span><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></span>';
			   if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			   } 
			   else {
			   $cat = get_the_category(); $cat = $cat[0];
			   $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			   if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
			   echo '<span>'.$cats.'</span>';
			   if ($showCurrent == 1) echo $before . get_the_title() . $after;
			 }
		  } 
	  
		  
		  //If Attachement
		  elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			  if( !empty( $parent)){
				  $cat = get_the_category($parent->ID); 
				  if(!empty($cat)){
					  $cat = $cat[0];
					  echo '<span>'.get_category_parents($cat, TRUE, ' ' . $delimiter . ' ').'</span>';
				  }
				  echo '<span><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></span>';
			  }
			 if ($showCurrent == 1) {
				  echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			 }
		  } 
		  
		  //Current Post
		  elseif ( is_page() ) {
		   $parents = array();
			  $parent_id = $post->post_parent;
			  while ( $parent_id ) :
				  $page = get_page( $parent_id );
				  $parents[]  = $before .'<a href="' . get_permalink( $page->ID ) . '" title="' . get_the_title( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>' . $after . $delimiter;
				  $parent_id  = $page->post_parent;
			  endwhile;
			  $parents = array_reverse( $parents );
			  echo join( '', $parents );
			  echo $before . get_the_title() . $after;
  
		  } 
  
		  //Tag Archives
		  elseif ( is_tag() ) {
		  echo $before . __('Posts tagged' , 'brad').' "' . single_tag_title('', false) . '"' . $after;
		  
		  //Author Page
		  } elseif ( is_author() ) {
		  global $author;
		  $userdata = get_userdata($author);
		  echo $before . __('Articles posted by','brad') . $userdata->display_name . $after;
		  } 
		  
		  //404 Page
		  elseif ( is_404() ) {
		  echo $before . __('Error 404','brad') . $after;
		  }
		  
		  // Query By page
		  if ( get_query_var('paged') ) {
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
		  echo __('Page','brad') . ' ' . get_query_var('paged');
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		   }
		   //End
		   echo '</div>';
		 }
	}



//Get Tweets

 if (!function_exists('brad_get_tweets')) {
  
  function brad_get_tweets($count, $twitterID) {
	
	  $content = "";
	  
	  if ($twitterID == "") {
		  return __("Please provide your Twitter username", "brad");
	  }
	  
	  if (function_exists('getTweets')) {
					  
		  $options = array('trim_user'=>true, 'exclude_replies'=>false, 'include_rts'=>false);
					  
		  $tweets = getTweets($twitterID, $count, $options);
		  
		  $content .= '<div class="recent-tweets" id="recent_tweets_'.rand().'"><ul>';
		  

		  
		  if(is_array($tweets)){
					  
			  foreach($tweets as $tweet){
									  
				  $content .= '<li>';
			  
				  if(is_array($tweet) && $tweet['text']){
					  
					  $content .= '<span>';
					  
					  $the_tweet = $tweet['text'];
				
					  if(is_array($tweet['entities']['user_mentions'])){
						  foreach($tweet['entities']['user_mentions'] as $key => $user_mention){
							  $the_tweet = preg_replace(
								  '/@'.$user_mention['screen_name'].'/i',
								  '<a href="http://www.twitter.com/'.$user_mention['screen_name'].'" target="_blank">@'.$user_mention['screen_name'].'</a>',
								  $the_tweet);
						  }
					  }
			  
					  // ii. Hashtags must link to a twitter.com search with the hashtag as the query.
					  if(is_array($tweet['entities']['hashtags'])){
						  foreach($tweet['entities']['hashtags'] as $key => $hashtag){
							  $the_tweet = preg_replace(
								  '/#'.$hashtag['text'].'/i',
								  '<a href="https://twitter.com/search?q=%23'.$hashtag['text'].'&amp;src=hash" target="_blank">#'.$hashtag['text'].'</a>',
								  $the_tweet);
						  }
					  }
			  
					  // iii. Links in Tweet text must be displayed using the display_url
					  //      field in the URL entities API response, and link to the original t.co url field.
					  if(is_array($tweet['entities']['urls'])){
						  foreach($tweet['entities']['urls'] as $key => $link){
							  $the_tweet = preg_replace(
								  '`'.$link['url'].'`',
								  '<a href="'.$link['url'].'" target="_blank">'.$link['url'].'</a>',
								  $the_tweet);
						  }
					  }
					  
					  // Custom code to link to media
					  if(isset($tweet['entities']['media']) && is_array($tweet['entities']['media'])){
						  foreach($tweet['entities']['media'] as $key => $media){
							  $the_tweet = preg_replace(
								  '`'.$media['url'].'`',
								  '<a href="'.$media['url'].'" target="_blank">'.$media['url'].'</a>',
								  $the_tweet);
						  }
					  }
					  
					  $content .= $the_tweet;
					  
					  $content .= '</span>';
			  
					  $date = strtotime($tweet['created_at']); // retrives the tweets date and time in Unix Epoch terms
					  $blogtime = current_time('U'); // retrives the current browser client date and time in Unix Epoch terms
					  $dago = human_time_diff($date, $blogtime) . ' ' . sprintf(__('ago', 'brad')); // calculates and outputs the time past in human readable format
					  $content .= '<br /><a class="timestamp" href="https://twitter.com/'.$twitterID.'/status/'.$tweet['id_str'].'" target="_blank">'.$dago.'</a>'. "\n";
				  } else {
					  $content .= '<br /><a href="http://twitter.com/'.$twitterID.'" target="_blank">@'.$twitterID.'</a>';
				  }
				  $content .= '</li>';
			  }
		  }
		  
		  $content .= '</ul></div>';
		  return $content;
	  } else {
		  return 'Please install the oAuth Twitter Feed Plugin';
	  }	
  }
}

 
function brad_breadcrumb(){
	if( ( class_exists( 'Woocommerce' ) && is_woocommerce() ) || ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
				woocommerce_breadcrumb(array(
					'wrap_before' => '<div id="breadcrumbs"><span class="breadcrumb-title">'.__('You Are Here:','brad').'</span>',
					'wrap_after' => '</div>',
					'before' => '<span>',
					'after' => '</span>',
					'delimiter' => '<span class="divider">/</span>'
				));
	}
	else{
		brad_breadcrumbs();
		
	}
	
}


/**
 * Ajax send mail function.
 */
function brad_send_mail() {
	global $brad_data;
	$send = false;
	$error = 0;
	$success = 0;
	$fields = empty( $_POST['fields'] ) ? array() : $_POST['fields'];
	$fields_titles = array(
		'name'		=> __( 'Name: ', 'brad-framework' ),
		'email'		=> __( 'Email: ', 'brad-framework' ),
		'telephone'	=> __( 'Telephone: ', 'brad-framework' ),
		'country'	=> __( 'Country: ',  'brad-framework' ),
		'city'		=> __( 'City: ', 'brad-framework' ),
		'company'	=> __( 'Company: ', 'brad-framework' ),
		'message'	=> __( 'Message: ', 'brad-framework' ),
		'website'	=> __( 'Website: ', 'brad-framework' ),
	);

	$fields = apply_filters( 'brad_sanitize_form_fields', $fields, $fields_titles );

	if ( ! check_ajax_referer( 'brad_contact_form', 'nonce', false ) ) {
		$error = 1;
	}
	elseif ( !empty($fields) ) {

		// target email
		if( $fields['contact_form_email_nonce'] == 'alternate'){
			$myemail = $brad_data['contact_form_email_alternate'];
		}
		else {
			$myemail = $brad_data['contact_form_email'];
		}
		
		if( empty($myemail)){
			$myemail = get_option( 'admin_email' );
		}
		$em = apply_filters( 'brad_send_mail_to', $myemail );
		$name = get_option( 'blogname' );
		$email = $em;

		if ( !empty( $fields['email'] ) && is_email( $fields['email'] ) ) {
			$email = $fields['email'];
		}

		if ( !empty( $fields['name'] ) ) {
			$name = $fields['name'];
		}

		// set headers
		$headers = array(
			'From: ' . esc_attr( strip_tags( $name ) ) . ' <' . esc_html( $email ) . '>',
			'Reply-To: ' . esc_html( $email ),
		);
		$headers = apply_filters( 'brad_send_mail_headers', $headers );

		// construct mail message
		$msg_mail = '';
		foreach ( $fields as $field=>$value ) {
			if ( !isset($fields_titles[ $field ]) ) {
				continue;
			}

			$msg_mail .= $fields_titles[ $field ] . $value . "\n";
		}
		$msg_mail = apply_filters( 'brad_send_mail_msg', $msg_mail, $fields );
		$subject = apply_filters( 'brad_send_mail_subject', '[Feedback from: ' . esc_attr( get_option( 'blogname' ) ) . ']' );

		// send email
		$send = wp_mail(
			$em,
			$subject,
			$msg_mail,
			$headers
		);

		// message
		if ( $send ) {
		  $success = 1;
		} else {
			$error = 1 ;
		}
	 }
		$nonce = wp_create_nonce( 'brad_contact_form' );
	    $response = json_encode(
		 array(
			'success'		=> $success,
			'error'         => $error,
			'nonce'         => $nonce
		 )
	);

	// response output
	header( "Content-Type: application/json" );
	echo $response;

	// IMPORTANT: don't forget to "exit"
	exit;
}

add_action( 'wp_ajax_nopriv_brad_send_mail', 'brad_send_mail' );
add_action( 'wp_ajax_brad_send_mail', 'brad_send_mail' );



/**
 * Sanitize email fields.
 *
 * @param $fields array
 * @param $fields_titles array
 *
 * @return array
 */
function brad_sanitize_email_fields( $fields = array(), $fields_titles = array() ) {
	if ( empty( $fields ) || empty( $fields_titles ) ) {
		return array();
	}

	foreach ( $fields as $field=>$value ) {
		if ( !isset($fields_titles[ $field ]) ) {
			unset( $fields[ $field ] );
		}

		switch ( $field ) {

			case 'email' :
				$fields[ $field ] = sanitize_email( $value );
				break;

			case 'message' :
				$fields[ $field ] = esc_html( $value );
				break;

			default:
				$fields[ $field ] = sanitize_text_field( $value );
		}
	}

	return $fields;
}
add_filter( 'brad_sanitize_form_fields', 'brad_sanitize_email_fields', 15, 2 );
	
function brad_js_remove_wpautop($content) {
  $content = do_shortcode( shortcode_unautop($content) );
  $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
  return $content;
}



//Hex to Rgb
function brad_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb;
}


/**
* ShortcodeHelper class 
*/
function brad_getCSSAnimation($css_animation){
	if ( $css_animation != '' ) {
        return ' animate-when-visible';
    }
	return '';
}


// portfolio loop style1 ,2 ,3

function brad_portfolio_loop_style1( &$portfolios , $args){
	global $post , $wpdb  , $brad_love ;
	$output = $lb_icon = $li_icon = $info = $loveit = '';
	
	$item_classes = '';
	$item_cats    = get_the_terms($post->ID, 'portfolio_category');
	if($item_cats):
	    foreach($item_cats as $item_cat) { $item_classes .= $item_cat->slug . ' '; }
    endif;

   //get the additional images for portfolio
   /*
    $img_list = get_post_meta( $post->ID , 'brad_image_list', false );
    if ( !is_array( $img_list ) ) { $img_list = ( array ) $img_list; }
	if ( !empty( $img_list ) ) {
		$img_list = implode( ',', $img_list );
		$images = $wpdb->get_col( "
			    	SELECT ID FROM $wpdb->posts
			    	WHERE post_type = 'attachment'
			    	AND ID IN ( $img_list )
			    	ORDER BY menu_order ASC
			    	" );
	 }
	 else{
	     $images = false;
	 }
	 */

   //if portfolio has featured image or additional images
   if( has_post_thumbnail() ):		
   
   @$link = ( get_post_meta($post->ID , 'brad_portfolio-linked' , true) == true && get_post_meta($post->ID , 'brad_portfolio-link' , true) != '' ) ? get_post_meta($post->ID , 'brad_portfolio-link' , true) : get_permalink($post->ID);
   
   @$link_target = get_post_meta($post->ID , 'brad_portfolio-linked' , true) ? get_post_meta($post->ID , 'brad_portfolio-link-target' , true) : '_self';
   
   //If lightbox icon is enabled
   if( $args['show_lb_icon'] == 'yes'){
	   if( get_post_meta( $post->ID , 'brad_video_embed', true ) != '' && get_post_meta( $post->ID , 'brad_video_llink', true ) != ''){
		   $lb_id = rand();
		   $lb_icon = '<a href="'.get_post_meta( $post->ID , 'brad_video_llink', true ).'" title="'. get_the_title() .'" class="lightbox-icon" rel="prettyPhoto[portfolio'. rand() .']"><i class="fa fa-brad-search"></i></a>';
	   }
	   else{
           $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');	
	       $lb_icon = '<a href="'.$full_image[0].'" title="'. get_the_title() .'" class="lightbox-icon" rel="prettyPhoto[portfolio'. rand() .']"><i class="fa-brad-search"></i></a>'; 
	   }
	}
	
     //If link icon is enabled
     if( $args['show_li_icon'] == 'yes'){
       $li_icon = '<a href="'.$link.'" title="'. get_the_title() .'" class="lightbox-icon"><i class="fa fa-brad-link"></i></a>'; 
	}
	
	if( $args['en_loveit'] == 'yes'){
		$love = $brad_love->add_love(); 
		$loveit = '<span class="love-it">'. $love .'</span>';
	}
	
	 //set the info
	 $info = '<div class="info">';
	 $info .= '<h3>';
     if( $args['disable_li_title'] == 'yes'){
         $info .= get_the_title();
	  }
     else {
	    $info .= '<a href="'.$link.'" target="'.$link_target.'" title="'.get_the_title().'">'.get_the_title().'</a>';
	  }
	 
	 $info .= '</h3>';
	 
	 if( $args['show_categories'] == 'yes'){
		 $info .=  '<h5>'.get_the_term_list($post->ID, 'portfolio_category' , '', ' / ','').'</h5>';
	 }
	 
	 if( $args['portfolio_style'] != 'style1'){
		 $info .= $loveit;
	 }
	  $info .= '</div>';
	
	
	//Attachement Image ( Featured Image )
	$attachment_image = wpb_getImageBySize( array( "attach_id" => get_post_thumbnail_id(), "thumb_size" => $args['img_size']) );
    $overlay_scheme = get_post_meta($post->ID , 'brad_portfolio-overlay',true);
	$overlay_bgcolor = get_post_meta($post->ID , 'brad_portfolio-overlay-bg',true);
	$overlay_bgopacity = get_post_meta($post->ID , 'brad_portfolio-overlay-opacity',true);
	$style= '';
	
	if( $overlay_bgcolor != '' && $args['info_onhover'] == 'no'){
		$rgb = brad_hex2rgb($overlay_bgcolor);
		$rgba = "rgba({$rgb[0]},{$rgb[1]},{$rgb[2]}, $overlay_bgopacity)";
		$style = " style='background-color:{$rgba}!important;'";
	}
	
	//Output Buffer
	$output .=  '<div class="portfolio-item '.$item_classes.' '.$args['class'].' scheme-'.$overlay_scheme.'"><div class="inner-content">';
	
	//If the portfolio style set to Grid
	if( $args['portfolio_style'] == 'style1'){
		$output .= '<div class="image hoverlay"><a href="'.$link.'" target="'.$link_target.'">'.$attachment_image['thumbnail'].'</a>';
	    $output .= '<div class="overlay" '.$style.'><a class="fake-link" href="'.$link.'" target="'.$link_target.'"></a>'. $loveit .'<div class="overlay-content">'.$li_icon.$lb_icon.$info.'</div></div>';
		$output .= '</div>';
	}
	
	//otherwise
	else {
		$output .= '<div class="image hoverlay"><a href="'.$link.'" target="'.$link_target.'">'.$attachment_image['thumbnail'].'</a>';
		if( $li_icon != '' || $lb_icon != '' ){
			$output .= '<div class="overlay"><a class="fake-link" href="'.$link.'" target="'.$link_target.'"></a><div class="overlay-content">'.$li_icon.$lb_icon.'</div></div>';
		}
	   $output .= '</div>'.$info;
	}
	//Finish the Video
    $output .=  '</div></div>';	
    endif;	
    return $output;
	
}

function brad_dynamic_sidebar(){
	global $brad_page_id;
	$sidebar = get_post_meta($brad_page_id,'brad_default_sidebar',true);
	
	switch( $sidebar){
		case 'woocommerce-sidebar':
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Woocommerce Sidebar')):
		endif;
		break;
		
		case 'sidebar1':
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar 1')):
		endif;
		break;
		
		case 'sidebar2':
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar 2')):
		endif;
		break;
		
		case 'sidebar3':
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar 3')):
		endif;
		break;
		
		case 'sidebar4':
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar 4')):
		endif;
		break;
		
		case 'sidebar5':
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar 5')):
		endif;
		break;
		
		default :
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog Sidebar')):
		endif;
		break;
	}
	

}


// Custom display comments 
function brad_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
<?php $add_below = ''; ?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
  <div class="comment-body"> <?php echo get_avatar($comment, 60); ?>
    <div class="reply">
      <?php edit_comment_link(__('Edit', 'brad'),'  ','') ?>
      <?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply', 'brad'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'])))?>
    </div>
    <h4><?php echo str_replace('</a>', '&nbsp;'. __('Says :','brad'). ' </a>',get_comment_author_link()); ?></h4>
    <div class="comment-meta"><?php echo __("Posted on",'brad');?> <?php printf(__('%1$s at %2$s', 'brad'), get_comment_date(),  get_comment_time()) ?></a></div>
    <p>
      <?php if ($comment->comment_approved == '0') : ?>
      <em><?php echo __('Your comment is awaiting moderation.', 'brad') ?></em><br />
      <?php endif; ?>
      <?php comment_text() ?>
    </p>
  </div>
  <?php }
  
  
function get_gmap_coordinates( $address ) {

		$address_hash = md5( $address );
		$coordinates = get_transient( $address_hash );

		if ( $coordinates === false ) {

			if( strpos( $address, 'latlng=' ) === 0 ) {
				$args = array( 'latlng' => urlencode( substr( $address, 7 ) ), 'sensor' => 'false' );
			}else {
				$args = array( 'address' => urlencode( $address ), 'sensor' => 'false' );
			}

			$url = 'http://maps.googleapis.com/maps/api/geocode/json';
			$url		= esc_url_raw ( add_query_arg( $args, $url ) );
		 	$response 	= wp_remote_get( $url );

		 	if( is_wp_error( $response ) )
		 		return;

		 	$data = wp_remote_retrieve_body( $response );

		 	if( is_wp_error( $data ) )
		 		return;

			if ( $response['response']['code'] == 200 ) {

				$data = json_decode( $data );

				if ( $data->status === 'OK' ) {

				  	$coordinates = $data->results[0]->geometry->location;

				  	$cache_value['lat'] 	= $coordinates->lat;
				  	$cache_value['lng'] 	= $coordinates->lng;
				  	$cache_value['address'] = (string) $data->results[0]->formatted_address;

				  	// cache coordinates for 3 months
				  	set_transient($address_hash, $cache_value, 3600*24*30*3);
				  	$data = $cache_value;

				} elseif ( $data->status === 'ZERO_RESULTS' ) {
				  	return __( 'No location found for the entered address.', 'brad-framework' );
				} elseif( $data->status === 'INVALID_REQUEST' ) {
				   	return __( 'Invalid request. Did you enter an address?', 'brad-framework' );
				} else {
					return __( 'Something went wrong while retrieving your map, please ensure you have entered the short code correctly.', 'brad-framework' );
				}

			} else {
			 	return __( 'Unable to contact Google API service.', 'brad-framework' );
			}

		} else {
		   // return cached results
		   $data = $coordinates;
		}

		return $data;

	}  
  
  