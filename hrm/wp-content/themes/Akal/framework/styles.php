<?php 

function brad_styles_basic()  
{  
	global $brad_data , $woocommerce;
	/* ------------------------------------------------------------------------ */
	/* Register Stylesheets */
	/* ------------------------------------------------------------------------ */
	
	wp_dequeue_style("js_composer_front");
	wp_dequeue_style( 'style-css' );
	
	wp_register_style( 'layout', get_template_directory_uri() . '/css/layout.css');
	wp_register_style( 'main', get_template_directory_uri() . '/css/main.css' );
	wp_register_style( 'shortcodes', get_template_directory_uri() . '/css/shortcodes.css' );
	wp_register_style( 'prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css' );
	wp_register_style( 'mediaelement', get_template_directory_uri() . '/css/mediaelementplayer.css' );
	wp_deregister_style( 'woocommerce');
	wp_register_style( 'woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );
	wp_register_style( 'themestyle', get_stylesheet_uri() );
	wp_register_style( 'responsive', get_template_directory_uri() . '/css/responsive.css' );
	
	
	/* ------------------------------------------------------------------------ */
	/* Enqueue Stylesheets */
	/* ------------------------------------------------------------------------ */
	


	wp_enqueue_style( 'layout');
	wp_enqueue_style( 'main');
	wp_enqueue_style( 'shortcodes');
	wp_enqueue_style( 'mediaelement');
	if($woocommerce){
		wp_enqueue_style( 'woocommerce' ); 
	}
	wp_enqueue_style( 'prettyPhoto' ); 
	wp_enqueue_style( 'themestyle' );	
    wp_enqueue_style( 'responsive' ); 
	
}  

add_action( 'wp_enqueue_scripts', 'brad_styles_basic' , 99); 


?>