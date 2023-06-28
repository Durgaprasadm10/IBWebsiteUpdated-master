<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package WP Blog and Widgets
 * @since 1.2.5
 */

// Action to add menu
add_action('admin_menu', 'free_register_blogdesigns_submenu_page');

/**
 * Register plugin design page in admin menu
 * 
 * @package WP Blog and Widgets
 * @since 1.2.5
 */
function free_register_blogdesigns_submenu_page() {
	add_submenu_page( 'edit.php?post_type='.WPBAW_POST_TYPE, 'Pro Blog Designs', 'Pro Blog Designs', 'manage_options', 'wpbaw-designs-page', 'free_blogdesigns_page_callback' );
}

/**
 * Register plugin design page in admin menu
 * 
 * @package WP Blog and Widgets
 * @since 1.2.5
 */
function free_blogdesigns_page_callback() {
	$wpbaw_feed_tabs = array(
								'design-feed' 	=> __('Plugin Designs', 'wp-blog-and-widgets'),
								'plugins-feed' 	=> __('Our Plugins', 'wp-blog-and-widgets')
							);

	
	$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'design-feed';
	?>
	
	<div class="wrap wpbaw-wrap">

		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($wpbaw_feed_tabs as $tab_key => $tab_val) {

				$active_cls = ($tab_key == $active_tab) ? 'nav-tab-active' : '';
				$tab_link 	= add_query_arg( array('post_type' => WPBAW_POST_TYPE, 'page' => 'wpbaw-designs-page', 'tab' => $tab_key), admin_url('edit.php') );
			?>

			<a class="nav-tab <?php echo $active_cls; ?>" href="<?php echo $tab_link; ?>"><?php echo $tab_val; ?></a>

			<?php } ?>
		</h2>

		<div class="wpbaw-tab-cnt-wrp">
		<?php 
			if( isset($_GET['tab']) && $_GET['tab'] == 'plugins-feed' ) {
				echo wpbaw_get_design( 'plugins-feed' );
			} else {
				echo wpbaw_get_design();
			}
		?>
		</div><!-- end .wpbaw-tab-cnt-wrp -->

	</div><!-- end .wpbaw-wrap -->

<?php
}

/**
 * Function to add some css in admin head for designing
 * 
 * @package WP Blog and Widgets
 * @since 1.2.5
 */
function wpbaw_blogdesign_admin_style() {
	
	global $current_screen;

	// If page is our plugin design feed page
	if( isset($current_screen->id) && $current_screen->id == 'blog_post_page_wpbaw-designs-page' ) {

		$css = '<style type="text/css">
					.shortcode-priview{background:#f7f7f7; border-bottom:2px solid #e7e7e7; font-weight:bold; padding:10px; clear:both; margin-bottom:10px;}
					.wp-medium-4 .shortcode-priview{display:block; margin:0px;}
					.postdesigns{ min-height:340px;-moz-box-shadow: 0 0 5px #ddd;-webkit-box-shadow: 0 0 5px#ddd;box-shadow: 0 0 5px #ddd; background:#fff; padding:10px;  margin-bottom:15px;}
					.wpcolumn, .wpcolumns {-webkit-box-sizing: border-box;-moz-box-sizing: border-box;  box-sizing: border-box;}
					.postdesigns img{width:100%; height:auto; }
					.wpbaw-shrtcode-wrp{margin: 0 0 15px 0;}
					.wpbaw-shrtcode-wrp .wpcolumns-bg > h3{padding: 0 10px;}
					.wpcolumns-bg{background:#fff; width:100%; float:left;}

					@media only screen and (min-width: 40.0625em) {  
						.wpcolumn,
						.wpcolumns {position: relative;padding-left:10px;padding-right:10px;float: left; }
						.wp-medium-1 { width: 8.33333%; }
						.wp-medium-2 { width: 16.66667%; }
						.wp-medium-3 { width: 25%; }
						.wp-medium-4 { width: 33.33333%; }
						.wp-medium-5 { width: 41.66667%; }
						.wp-medium-6 { width: 50%; }
						.wp-medium-7 { width: 58.33333%; }
						.wp-medium-8 { width: 66.66667%; }
						.wp-medium-9 { width: 75%; }
						.wp-medium-10 { width: 83.33333%; }
						.wp-medium-11 { width: 91.66667%; }
						.wp-medium-12 { width: 100%; }
				</style>';

			echo $css;
	}
}

// Action to add css in admin head
add_action('admin_head', 'wpbaw_blogdesign_admin_style');

/**
 * Gets the plugin design part feed
 *
 * @package WP Blog and Widgets
 * @since 1.2.5
 */
function wpbaw_get_design( $feed_type = '' ) {
	
	$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'design-feed';
	
	$cache = get_transient( 'wpbaw_' . $active_tab );
	
	if ( false === $cache ) {
		
		// Feed URL
		if( $feed_type == 'plugins-feed' ) {
			$url = 'http://wponlinesupport.com/plugin-data-api/plugins-data.php';
		} else {
			$url = 'http://wponlinesupport.com/plugin-data-api/wp-blog-and-widgets/wp-blog-and-widgets.php';
		}

		$feed = wp_remote_get( esc_url_raw( $url ), array( 'timeout' => 120, 'sslverify' => false ) );

		if ( ! is_wp_error( $feed ) ) {
			if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 ) {
				$cache = wp_remote_retrieve_body( $feed );
				set_transient( 'wpbaw_' . $active_tab, $cache, 432000 );
			}
		} else {
			$cache = '<div class="error"><p>' . __( 'There was an error retrieving the data from the server. Please try again later.', 'wp-blog-and-widgets' ) . '</div>';
		}
	}
	return $cache;
}