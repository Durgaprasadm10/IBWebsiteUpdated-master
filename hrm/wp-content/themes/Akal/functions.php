<?php

/* File Security Check */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Load Default theme text domain */
load_theme_textdomain( 'brad', get_template_directory() . '/languages' );
load_theme_textdomain( 'brad-framework', get_template_directory() . '/languages' );	
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable($locale_file) ) { require_once($locale_file); }  

/* Set the content width based on the theme's design and stylesheet. */
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* pixels */
}
/* Default RSS feed links */
add_theme_support('automatic-feed-links');


add_theme_support( 'custom-header' );

// Default custom backgrounds
add_theme_support( 'custom-background' );



/* Register Navigations */
register_nav_menu('main_navigation', 'Main Navigation');
register_nav_menu('main_navigation_left', 'Main Navigation Left');
register_nav_menu('main_navigation_right', 'Main Navigation Right');
register_nav_menu('top_navigation', 'Top Bar Navigation');
register_nav_menu('footer_navigation', 'Footer Navigation');

/* Theme options */
require_once (get_template_directory().'/framework/options.php');
$brad_data =  get_option('akal_options'); 

global $google_fonts;

$google_fonts = array();		
   
  if( $brad_data['font_body']['font-type'] == true && $brad_data['font_body']['font-family-custom'] != ''){
	  $brad_data['font_body']['font-family'] = $brad_data['font_body']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_body']['font-family'];
  }
  
  if( $brad_data['font_secondary']['font-type'] == true && $brad_data['font_secondary']['font-family-custom'] != ''){
	  $brad_data['font_secondary']['font-family'] = $brad_data['font_secondary']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_secondary']['font-family'];
  }
  
  if( $brad_data['font_h1']['font-type'] == true && $brad_data['font_h1']['font-family-custom'] != ''){
	  $brad_data['font_h1']['font-family'] = $brad_data['font_h1']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_h1']['font-family'];
  }
  
  if( $brad_data['font_h2']['font-type'] == true && $brad_data['font_h2']['font-family-custom'] != ''){
	  $brad_data['font_h2']['font-family'] = $brad_data['font_h2']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_h2']['font-family'];
  }
  
  if( $brad_data['font_h3']['font-type'] == true && $brad_data['font_h3']['font-family-custom'] != ''){
	  $brad_data['font_h3']['font-family'] = $brad_data['font_h3']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_h3']['font-family'];
  }
  
  if( $brad_data['font_h4']['font-type'] == true && $brad_data['font_h4']['font-family-custom'] != ''){
	  $brad_data['font_h4']['font-family'] = $brad_data['font_h4']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_h4']['font-family'];
  }
  
  if( $brad_data['font_h5']['font-type'] == true && $brad_data['font_h5']['font-family-custom'] != ''){
	  $brad_data['font_h5']['font-family'] = $brad_data['font_h5']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_h5']['font-family'];
  }
  
  if( $brad_data['font_h6']['font-type'] == true && $brad_data['font_h6']['font-family-custom'] != ''){
	  $brad_data['font_h6']['font-family'] = $brad_data['font_h6']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_h6']['font-family'];
  }
  
  if( $brad_data['font_nav']['font-type'] == true && $brad_data['font_nav']['font-family-custom'] != ''){
	  $brad_data['font_nav']['font-family'] = $brad_data['font_nav']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_nav']['font-family'];
  }
  
  if( $brad_data['font_nav_dropdown']['font-type'] == true && $brad_data['font_nav_dropdown']['font-family-custom'] != ''){
	  $brad_data['font_nav_dropdown']['font-family'] = $brad_data['font_nav_dropdown']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_nav_dropdown']['font-family'];
  }
  
  if( $brad_data['font_slider']['font-type'] == true && $brad_data['font_slider']['font-family-custom'] != ''){
	  $brad_data['font_slider']['font-family'] = $brad_data['font_slider']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_slider']['font-family'];
  }
 
  
  if( $brad_data['font_slider_subtitle']['font-type'] == true && $brad_data['font_slider_subtitle']['font-family-custom'] != ''){
	  $brad_data['font_slider_subtitle']['font-family'] = $brad_data['font_slider_subtitle']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_slider_subtitle']['font-family'];
  }
  
  if( $brad_data['font_slider_caption']['font-type'] == true && $brad_data['font_slider_caption']['font-family-custom'] != ''){
	  $brad_data['font_slider_caption']['font-family'] = $brad_data['font_slider_caption']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_slider']['font-family'];
  }
  
  if( $brad_data['font_titlebarheadline']['font-type'] == true && $brad_data['font_titlebarheadline']['font-family-custom'] != ''){
	  $brad_data['font_titlebarheadline']['font-family'] = $brad_data['font_titlebarheadline']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_titlebarheadline']['font-family'];
  }
  
  if( $brad_data['font_titlebarsubtitle']['font-type'] == true && $brad_data['font_titlebarsubtitle']['font-family-custom'] != ''){
	  $brad_data['font_titlebarsubtitle']['font-family'] = $brad_data['font_titlebarsubtitle']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_titlebarsubtitle']['font-family'];
  }
  
  if( $brad_data['font_footerheadline']['font-type'] == true && $brad_data['font_footerheadline']['font-family-custom'] != ''){
	  $brad_data['font_footerheadline']['font-family'] = $brad_data['font_footerheadline']['font-family-custom'];
  }
  else{
	  $google_fonts[] = $brad_data['font_footerheadline']['font-family'];
  }


require_once (get_template_directory().'/framework/brad_iconfont.php');


/*--------------------------------------------------------------------------------------------------
	All Required Files
--------------------------------------------------------------------------------------------------*/
include_once(get_template_directory().'/framework/custom-posts.php');
include_once(get_template_directory().'/framework/brad_functions.php');
include_once(get_template_directory().'/framework/brad-shortcodes/brad-shortcodes.php');

/* Reqister and eneque styles and scripts */
require_once (get_template_directory().'/framework/scripts.php');
require_once (get_template_directory().'/framework/styles.php');
require_once (get_template_directory().'/framework/custom_css.php');
require_once (get_template_directory().'/framework/mobile-detect.php');
require_once (get_template_directory().'/framework/custom_js.php');
require_once (get_template_directory().'/framework/brad-megamenu/brad-megamenu.php');




/* Include Meta Box */
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/framework/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/framework/meta-box' ) );
// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';
include get_template_directory().'/framework/metabox.php';

/* Load Widgets */
include_once(get_template_directory().'/framework/widgets/twitter_widget.php');
include_once(get_template_directory().'/framework/widgets/flickr_widget.php'); 
include_once(get_template_directory().'/framework/widgets/facebook_widget.php');
include_once(get_template_directory().'/framework/widgets/banner_125_widget.php');
include_once(get_template_directory().'/framework/widgets/portfolios_widget.php');
include_once(get_template_directory().'/framework/widgets/recent_posts.php');
include_once(get_template_directory().'/framework/widgets/embed_video.php');	



add_action('widgets_init', 'brad_register_widgets');

function brad_register_widgets(){
	register_widget('Ad_125_125_Widget');
	register_widget('widget_embed');
	register_widget('widget_flickr');
	register_widget('portfolios_Widget');
	register_widget('recent_posts_Widget');
	register_widget('widget_twitter');	
	register_widget('Facebook_Like_Widget');
}	

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */

add_action( 'vc_before_init', 'your_prefix_vcSetAsTheme' );
function your_prefix_vcSetAsTheme() {
	vc_set_as_theme( true);
}


// Initialising Visual shortcode editor
if (class_exists('WPBakeryVisualComposerAbstract')) {
	function requireVcExtend(){
		include_once( get_template_directory().'/vc_extend/extend-vc.php');
		include_once( get_template_directory().'/vc_extend/vc_templates.php');
	}
	add_action('init', 'requireVcExtend',2);
}



/*-------------------------------------------------------------------------------------------------*/
/* Woocommerce setup
/*-------------------------------------------------------------------------------------------------*/
add_theme_support( 'woocommerce' );
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
require_once(get_template_directory().'/framework/brad_woocommerce.php');


/* Automatic Plugin Activation */
require_once(get_template_directory().'/framework/plugin-activation.php');
require_once ( get_template_directory().'/framework/brad-love.php' );


/*--------------------------------------------------------------------------------------------------
	add theme update class
--------------------------------------------------------------------------------------------------*/

function brad_themes_update($updates) {
	global $brad_data;
	if ( isset($updates->checked) && !empty($brad_data['themeforest_username']) && !empty($brad_data['themeforest_apikey']) ) {
		
		require_once( get_template_directory()."/framework/theme-update/class-pixelentity-theme-update.php");
		
		$username = trim($brad_data['themeforest_username']);
		$apikey = trim($brad_data['themeforest_apikey']);

		$updater = new PixelentityThemeUpdate($username,$apikey,"bradweb");
		$updates = $updater->check($updates);
	}
	return $updates;
}

add_filter("pre_set_site_transient_update_themes", "brad_themes_update");




#-----------------------------------------------------------------#
# Plug Activation Configurations
#-----------------------------------------------------------------#
	
add_action('tgmpa_register', 'brad_register_required_plugins');

function brad_register_required_plugins() {
	
	$plugins = array(
	     array(
		    'name'     		    => 'Slider Revolution', // The plugin name
		    'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri()  . '/framework/plugins/revslider.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '5.1.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)
		,
		
		array(
            'name'			=> 'WPBakery Visual Composer', // The plugin name
            'slug'			=> 'js_composer', // The plugin slug (typically the folder name)
            'source'			=> get_template_directory_uri() . '/framework/plugins/js_composer.zip', // The plugin source
            'required'			=> true, // If false, the plugin is only 'recommended' instead of required
            'version'			=> '4.8.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'		=> '', // If set, overrides default API URL and points to an external URL
        )
		
		,
		
		 array(
			'name'		=> 'oAuth Twitter Feed for Developers',
			'slug'		=> 'oauth-twitter-feed-for-developers',
			'required' 	=> false,
		)	
	);
	
	// Change this to your theme text domain, used for internationalising strings
		$theme_text_domain = 'brad-framework';
	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	
	
	$config = array(
			'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
			'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
			'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
			'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
			'menu'         		=> 'install-required-plugins', 	// Menu slug
			'has_notices'      	=> true,                       	// Show admin notices or not
			'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
			'message' 			=> '',							// Message to output right before the plugins table
			'strings'      		=> array(
				'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
				'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
				'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
				'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
				'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
				'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
				'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
				'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
				'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
				'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
				'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
				'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
				'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
			)
		);
	
		tgmpa($plugins, $config);
		
	}


#-----------------------------------------------------------------#
# Custom Images
#-----------------------------------------------------------------#

add_theme_support('post-thumbnails');
if ( function_exists( 'add_image_size' ) ) {
	   add_image_size( 'thumb-normal', 600 , 435 , true );
	   add_image_size( 'thumb-medium', 800 , 580 , true );
	   add_image_size( 'thumb-large' , 1100 , 797 , true );
	   add_image_size( 'thumb-normal-masonry', 600 , 9999 );
	   add_image_size( 'thumb-large-masonry' , 1100 , 9999  );
	   add_image_size( 'thumb-medium-masonry', 800 , 9999 );
	   add_image_size( 'fullwidth', 1200 , 9999 );
	   add_image_size( 'mini', 80 , 80 , true );	
}
	


global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
	add_action( 'init', 'brad_woocommerce_image_dimensions', 1 );
}
 

// Define Woocommerce image sizes 
function brad_woocommerce_image_dimensions() {
	$catalog = array(
		'width' => '500',	
		'height'	=> '532',	
		'crop'	=> 1 
	);
	 
	$single = array(
		'width' => '800',	
		'height'	=> '852',	
		'crop'	=> 1 
	);
	 
	$thumbnail = array(
		'width' => '100',	
		'height'	=> '100',	
		'crop'	=> 1 
	);
	 
	
	update_option( 'shop_catalog_image_size', $catalog ); // Product category thumbs
	update_option( 'shop_single_image_size', $single ); // Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs
}
	

#-----------------------------------------------------------------#
# Post formats and Widgets
#-----------------------------------------------------------------#

add_theme_support( 'post-formats', array('video','gallery','link','quote') );


/* Register widgetized locations */
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id'   => 'blog-sidebar',
		'before_widget' => '<div id="%1$s" class="widget widget_meta %2$s">',
		'after_widget' => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	));
	
	register_sidebar(array(
		'name' => 'Woocommerce Sidebar',
		'id'   => 'woocommerce-sidebar',
		'before_widget' => '<div id="%1$s" class="widget widget_meta %2$s">',
		'after_widget' => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	));
	
	
	register_sidebar(array(
		'name' => 'Sidebar 1',
		'id'   => 'sidebar1',
		'before_widget' => '<div id="%1$s" class="widget widget_meta %2$s">',
		'after_widget' => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	));
	
	
	register_sidebar(array(
		'name' => 'Sidebar 2',
		'id'   => 'sidebar2',
		'before_widget' => '<div id="%1$s" class="widget widget_meta %2$s">',
		'after_widget' => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	));
	
	
	
	register_sidebar(array(
		'name' => 'Sidebar 3',
		'id'   => 'sidebar3',
		'before_widget' => '<div id="%1$s" class="widget widget_meta %2$s">',
		'after_widget' => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	));
	
	
	register_sidebar(array(
		'name' => 'Sidebar 4',
		'id'   => 'sidebar4',
		'before_widget' => '<div id="%1$s" class="widget widget_meta %2$s">',
		'after_widget' => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	));
	
	
	register_sidebar(array(
		'name' => 'Sidebar 5',
		'id'   => 'sidebar5',
		'before_widget' => '<div id="%1$s" class="widget widget_meta %2$s">',
		'after_widget' => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	));
	
	
	
	register_sidebar(array(
	   'name' => 'Footer Widgets',
	   'id'   => 'footer-widgets',
		'description'   => __( 'These are widgets for the Footer.','brad-framework' ),
		'before_widget' => '<div id="%1$s" class="widget widget_meta %2$s '.brad_get_class_name($brad_data['footer_columns']).'">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
   	));
}


/*--------------------------------------------------------------------------------------------------
	All the small fixers for theme
--------------------------------------------------------------------------------------------------*/

 
add_filter('the_content', 'brad_content_filter');
add_filter('widget_text', 'brad_content_filter');
 
function brad_content_filter($content) {
 
	// array of custom shortcodes requiring the fix 
	$block = join("|",array("bradslider","share_box","button","gap","pricing_table","pricing_column","pricing_feature","compare_table","compare_feature","iconlist","listitem","checklist","item","dropcap","video","icon","icons","single_icon","tooltip","heading","separator","highlighted","columns","one_sixth","one_fifth","one_fourth","one_third","one_half","three_fourths","two_thirds","code"));
 
	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
 
	return $rep;
 
}


/* Add permissios to upload font */
add_filter('upload_mimes', 'brad_font_mime_types');
function brad_font_mime_types($mimes)
{
	$mimes['ttf'] = 'font/ttf';
	$mimes['woff'] = 'font/woff';
	$mimes['svg'] = 'font/svg';
	$mimes['eot'] = 'font/eot';

	return $mimes;
}


/* Set the Image qulaity to 100% */
add_filter('jpeg_quality', 'brad_image_quality');
add_filter('wp_editor_set_quality', 'brad_image_quality');
function brad_image_quality($quality) {
    return 100;
}

add_filter( 'wp_title', 'brad_hack_wp_title_for_home' );
function brad_hack_wp_title_for_home( $title )
{
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return ' - ' . get_bloginfo( 'description' );
  }
  return $title;
}


/* Fix category and Archives span count */
add_filter('get_archives_link', 'brad_fix_category_span');
add_filter('wp_list_categories', 'brad_fix_category_span');
function brad_fix_category_span($links) {
	$get_count = preg_match_all('#\((.*?)\)#', $links, $matches);

	if($matches) {
		$i = 0;
		foreach($matches[0] as $val) {
			$links = str_replace('</a> '.$val, ' '.$val.'</a>', $links);
			$links = str_replace('</a>&nbsp;'.$val, ' '.$val.'</a>', $links);
			$i++;
		}
	}
	
	return $links;
}

/* Allow shortcodes in widget text */
add_filter('widget_text', 'do_shortcode');

add_action('wp_logout','go_home');
function go_home(){
  //wp_redirect( home_url() );
return 'http://hrm.ideabyte.net/';
  exit();
}
add_filter( 'wpmem_login_redirect', 'my_login_redirect' );

function my_login_redirect()
{
	// return the url that the login should redirect to
	return 'http://hrm.ideabyte.net/';
}
function get_user_role() {
	global $current_user;

	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);

	return $user_role;
}
function my_wp_nav_menu_args( $args = '' ) {



if( is_user_logged_in() ) {

$roll = get_user_role();

if(($roll) == 'editor'){

    $args['menu'] = 'editor_menu';

} 

if(($roll) == 'subscriber'){

    $args['menu'] = 'subscriber_menu';

} 
if(($roll) == 'author'){

    $args['menu'] = 'author_menu';

} 


}

    return $args;

}

add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );
function replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Howdy,', 'Welcome', $my_account->title );
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'replace_howdy',25 );
