<?php global $brad_data , $post , $brad_page_id; ?>

<!doctype html>
<html  <?php language_attributes(); ?>>
<head>

<!-- Meta Tags -->

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>

<?php
	if ( defined('WPSEO_VERSION') ) {
		wp_title('');
	} else {
		bloginfo('name'); ?> <?php wp_title(' - ', true, 'left');
	}
	?>
</title>

<!--[if lte IE 8]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php if( !empty($brad_data['media_favicon']['url'] )) { ?>
<link rel="shortcut icon" href="<?php echo $brad_data['media_favicon']['url']; ?>">
<?php } ?>
<?php if( !empty($brad_data['media_favicon_iphone']['url'] )) { ?>
<link rel="apple-touch-icon" href="<?php echo $brad_data['media_favicon_iphone']['url']; ?>">
<?php } ?>
<?php if( !empty($brad_data['media_favicon_iphone_retina']['url'] )) { ?>
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $brad_data['media_favicon_iphone_retina']['url']; ?>">
<?php } ?>
<?php if( !empty($brad_data['media_favicon_ipad']['url'] )) { ?>
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $brad_data['media_favicon_ipad']['url']; ?>">
<?php } ?>
<?php if( !empty($brad_data['media_favicon_ipad_retina']['url'] )) { ?>
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $brad_data['media_favicon_ipad_retina']['url']; ?>">
<?php } ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php 
   
   if( is_search() || is_archive() || is_404()  ) {
		$brad_page_id = -1 ;
	}
	else if( is_home() && get_option('page_for_posts')){
		$brad_page_id = get_option('page_for_posts');
	}
	else if( is_single() || is_singular('portfolio')){
		$brad_page_id = $post->ID;
	}
	else {
		$brad_page_id = get_the_ID();
	}
	
	if(class_exists('Woocommerce')) {
			if(is_shop() || is_tax('product_cat') || is_tax('product_tag')) {
				$brad_page_id = get_option('woocommerce_shop_page_id');
	    }
		
		
	}
?>
 
<?php 
$body_class = '';
$header_type =  get_post_meta($brad_page_id,'brad_header_type',true) != '' ? get_post_meta($brad_page_id,'brad_header_type',true) : $brad_data['header_type'];
$header_scheme =  get_post_meta($brad_page_id,'brad_header_scheme',true) != '' ? get_post_meta($brad_page_id,'brad_header_scheme',true) : $brad_data['header_scheme'];
$brad_data['header_layout'] = !empty($brad_data['header_layout']) ? $brad_data['header_layout'] : 'type1';

global $header_class;

if($header_type == 'transparent' && ( $brad_data['header_layout'] == 'type1' || $brad_data['header_layout'] == 'type2' )){
	$header_class .= ' transparent-header';
}
else{
	$header_class .= ' solid-header';
}

if($header_scheme == 'light'){
	$header_class .= ' header-scheme-light';
}
else{
	$header_class .= ' header-scheme-dark';
}

if( intval($brad_data['header_height']) == 0){ 
    $brad_data['header_height'] = 84;
}

if( get_post_meta($brad_page_id,'brad_header_semitrans',true) == 'yes'){
	$header_class .= ' semitrans-header-yes';
}

$header_class .= ' '.$brad_data['header_layout'];

?>

<?php wp_head(); ?>
<!--[if IE]>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/ie.css">
<![endif]-->
<!--[if lte IE 8]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
<![endif]-->
</head>


<body id="home" <?php body_class($body_class . $header_class . ' header-fullwidth-'.$brad_data['header_fullwidth'] );?>>
<?php if( $brad_data['check_loader'] == true): ?>
<div class="brad-loader-overlay">
    <div class="bubblingG">
	    <span id="bubblingG_1"></span>
	    <span id="bubblingG_2"></span>
		<span id="bubblingG_3"></span>
    </div>
</div>
<?php endif; ?>

<!-- mobile menu Starts Here-->
<?php
global $brad_menu_id;
$brad_menu_id  = "";
if( get_post_meta($brad_page_id , 'brad_page_nav' , true) != ''){
	$brad_menu_id = get_post_meta($brad_page_id , 'brad_page_nav' , true);
}
?>
<div id="mobile_navigation">
  <a id="close-mobile-menu" href="#">X</a>
  <?php wp_nav_menu(array('theme_location' => 'main_navigation', 'menu' => $brad_menu_id ,'depth' => 3 , 'container' => false, 'menu_id' => 'mobile_menu','menu_class' => 'mobile_menu')); ?>
</div>
<!-- End Mobile Navigation -->

<?php if( $brad_data['layout'] == 'boxed' && $brad_data['header_layout'] != 'type4' ) { ?>
<!-- Boxed Layout -->
<div class="boxed-layout boxed-shadow-<?php echo $brad_data['boxed_shadow'];?> style-<?php echo $brad_data['boxed_bstyle'];?>">
<?php  } ?>

<!-- Header -->
<?php get_template_part('framework/headers/header' , $brad_data['header_layout']); ?>


<?php
    //if header content selected to  revslider
    if( get_post_meta( $brad_page_id , 'brad_header_content', true) == 'revslider' && get_post_meta( $brad_page_id , 'brad_rev_slider', true) ) {
		echo '<!-- Rev Slider Start -->';
		echo do_shortcode('[rev_slider '.get_post_meta(get_the_ID(), 'brad_rev_slider', true).' ]');
		echo '<!-- Rev Slider End -->';
	}
	//if header content selected to  bradslider
	elseif( get_post_meta( $brad_page_id , 'brad_header_content', true) == 'bradslider' && get_post_meta( $brad_page_id , 'brad_bradslider', true) ) {
		
		echo '<!-- Brad Slider Start -->';
		echo do_shortcode('[bradslider category="'. get_post_meta( $brad_page_id , 'brad_bradslider', true) .'" height="'. get_post_meta( $brad_page_id , 'brad_slider_height', true) .'" interval="' .get_post_meta( $brad_page_id , 'brad_slider_interval', true). '" effect="' .get_post_meta( $brad_page_id , 'brad_slider_effect', true). '" responsive_height="' .get_post_meta( $brad_page_id , 'brad_ht_responsive', true). '" fullheight="' .get_post_meta( $brad_page_id , 'brad_slider_fullheight', true). '" parallax="' .get_post_meta( $brad_page_id , 'brad_slider_parallax', true). '" swipe="' .get_post_meta( $brad_page_id , 'brad_slider_swipe', true). '" navigation="' .get_post_meta( $brad_page_id , 'brad_slider_nav', true). '" pagination="' .get_post_meta( $brad_page_id , 'brad_slider_pagination', true). '" header_slider="yes"]');  
		echo '<!-- Brad Slider End -->';
	}
  
  elseif ( get_post_meta( $brad_page_id , 'brad_header_content', true) == 'none') {
  
      if( get_post_meta( $brad_page_id , 'brad_rm_header_space', true) != 'yes' && $header_type == 'transparent'){
		  echo '<div id="header_space"></div>';
       }
  
  }
    //if header content selected to  titlebar
    else if( $brad_data['hide_titlebar'] != true ) { 
		 if( get_post_meta($brad_page_id,'brad_titlebar_scheme',true) != ''){
			  $brad_data['titlebar_scheme'] = get_post_meta($brad_page_id,'brad_titlebar_scheme',true) ;
		 }
		if( get_post_meta($brad_page_id,'brad_titlebar_alignment',true)  != '' ){ 
		    $brad_data['titlebar_alignment'] = get_post_meta($brad_page_id,'brad_titlebar_alignment',true) ;
		}
		
		if( get_post_meta($brad_page_id,'brad_titlebar_size',true) != '' ) {
			  $brad_data['titlebar_text_size'] =  get_post_meta($brad_page_id,'brad_titlebar_size',true) ;
		}
		
		if( get_post_meta($brad_page_id,'brad_titlebar_breadcrumb',true) != '' ) {
			$brad_data['titlebar_breadcrumb'] = get_post_meta($brad_page_id,'brad_titlebar_breadcrumb',true);
		}
		
		if( get_post_meta($brad_page_id,'brad_titlebar_border',true) != '' ) {
			$brad_data['titlebar_border'] = get_post_meta($brad_page_id,'brad_titlebar_border',true);
		}

		if( get_post_meta( $brad_page_id , 'brad_titlebar_parallax' , true) == '' ){
			$brad_data['titlebar_parallax'] = get_post_meta( $brad_page_id , 'brad_titlebar_parallax' , true) ;
		}
	    ?>
        
        <?php if( ( ( is_home() || is_single() ) && !is_singular('portfolio') )   &&  (  !class_exists('Woocommerce') || !is_woocommerce()  ))  { ?>
<!-- Static Page Titlebar -->
<section id="titlebar" class="titlebar titlebar-type-<?php echo $header_type;?> border-<?php echo $brad_data['titlebar_border'];?> titlebar-scheme-<?php echo $brad_data['titlebar_scheme'];?> titlebar-alignment-<?php echo $brad_data['titlebar_alignment'];?> titlebar-size-<?php echo $brad_data['titlebar_text_size'];?>" data-height="<?php echo $brad_data['titlebar_height']?>" data-rs-height="<?php echo $brad_data['rs_height'];?>">
  <div class="titlebar-wrapper">
    <div class="titlebar-content">
      <div class="container">
        <div class="row-fluid">
          <div class="row-fluid">
            <div class="titlebar-heading">
              <?php if(get_post_meta($brad_page_id, 'brad_page_title', true) != '' ) { echo '<h1><span>'.get_post_meta($brad_page_id, 'brad_page_title', true).'</span></h1>'; } else {  echo '<h1><span>'. $brad_data['blog_title'] .'</span></h1>'; } ?>
            </div>
             <?php if( $brad_data['titlebar_breadcrumb'] == 'yes'):
                  brad_breadcrumb();
				endif; 
		    ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
     <?php } 
	 else if(  is_page()  || is_singular('portfolio') ||  ( class_exists('Woocommerce') && ( is_product() || is_shop() ) )  ) { ?>
<!-- Static Page Titlebar -->
<section id="titlebar" class="titlebar  titlebar-type-<?php echo $header_type;?> border-<?php echo $brad_data['titlebar_border'];?> titlebar-scheme-<?php echo $brad_data['titlebar_scheme'];?> titlebar-alignment-<?php echo $brad_data['titlebar_alignment'];?> titlebar-size-<?php echo $brad_data['titlebar_text_size'];?>" data-height="<?php echo $brad_data['titlebar_height']?>" data-rs-height="<?php echo $brad_data['rs_height'];?>"  >
  <div class="titlebar-overlay parallax-section-<?php echo $brad_data['titlebar_parallax'];?>" ></div>
  <div class="titlebar-wrapper">
    <div class="titlebar-content">
      <div class="container">
        <div class="row-fluid">
          <div class="row-fluid">
            <div class="titlebar-heading">
              <?php if(get_post_meta($brad_page_id, 'brad_page_title', true) != '' ) { echo '<h1><span>'.get_post_meta($brad_page_id, 'brad_page_title', true).'</span></h1>'; } else {  echo '<h1><span>'.get_the_title($brad_page_id).'</span></h1>'; } ?>
            <?php if(  get_post_meta($brad_page_id,'brad_add_content',true) != ''):
					echo '<div class="titlebar-subcontent">';
					echo get_post_meta($brad_page_id,'brad_add_content',true);  
					echo '</div>';
				  endif ; ?>
            </div>
            <?php if( $brad_data['titlebar_breadcrumb'] == 'yes'):
                    brad_breadcrumb();
				 endif; 
		    ?>                                
          </div>
         </div>
      </div>
    </div>
  </div>
</section>
<?php
} 
else if( is_search() || is_archive()  ) { // for all other especially Archives	
    if(is_day()) : 
		$title = sprintf( __( '%s', 'brad' ), get_the_date() );		
	elseif(is_month()) : 
		$title = sprintf( __( '%s', 'brad' ), get_the_date('F Y') );					
	elseif(is_year()) : 
		$title = sprintf( __( '%s', 'brad' ), get_the_date('Y') );				
	elseif( is_category() ) :
		$title = sprintf( __( '%s', 'brad' ), single_cat_title( '', false ) );	
	elseif( is_search() && !have_posts() ) : 
		$title = __( 'Nothing Found', 'brad' );
	elseif( is_search() ) : 
		$title = __( 'Search Results', 'brad' );				
	else : 
		$title = single_cat_title( '', false );
	endif; ?>
<!-- Titlebar for archibes -->
<section id="titlebar" class="titlebar titlebar-type-<?php echo $header_type;?> border-<?php echo $brad_data['titlebar_border'];?> titlebar-scheme-<?php echo $brad_data['titlebar_scheme'];?> titlebar-alignment-<?php echo $brad_data['titlebar_alignment'];?> titlebar-size-<?php echo $brad_data['titlebar_text_size'];?>" data-height="<?php echo $brad_data['titlebar_height']?>" data-rs-height="<?php echo $brad_data['rs_height'];?>" >
<div class="titlebar-overlay parallax-section-<?php echo $brad_data['titlebar_parallax'];?>" ></div>
   <div class="titlebar-wrapper">
    <div class="titlebar-content">
      <div class="container">
        <div class="row-fluid">
          <div class="row-fluid">
            <div class="span titlebar-heading"><h1><span><?php echo $title; ?></span></h1>
             </div>                                
          </div>
         </div>
      </div>
    </div>
  </div>
</section>
<?php 
  } 
}
?>
<!--End Header -->
