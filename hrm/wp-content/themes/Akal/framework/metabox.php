<?php
add_action( 'admin_init', 'rw_register_meta_box' );
function rw_register_meta_box()
{
    // Check if plugin is activated or included in theme
    if ( !class_exists( 'RW_Meta_Box' ) ) { return; }
	global $brad_data , $wpdb;
	$revsliders =array();
	$revsliders[0] = 'Select a slider';
	if (is_plugin_active('revslider/revslider.php')) {
    $get_sliders = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'revslider_sliders');
    if($get_sliders) {
	    foreach($get_sliders as $slider) {
		   $revsliders[$slider->alias] = $slider->title;
	   }
    }
	}
	
	$bradsliders = array();
	$bradsliders[0] = 'Select a slider';
	$get_sliders = get_terms('bradslider-category');
	if( is_array($get_sliders) && !empty($get_sliders)){
		foreach($get_sliders as $slider){
			$bradsliders[$slider->slug] = $slider->name ;
		}
	}
	
	$nav_menus  = array();
	$nav_menus[0]  = '';
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

    foreach ( $menus as $menu ) {
		$nav_menus[$menu->term_id] = $menu->name;
    }
	
	$bg_pos = array(
	                          ''    => '' ,
				    'center top'	=> 'Center Top' ,
					'center right'	=> 'Center Right' ,
					'center bottom'	=> 'Center Bottom' ,
					'center center'	=> 'Center Center' ,
					'left top'	     => 'Left Top' ,
					'left center'	 => 'Left Center' ,
					'left bottom'	 => 'Left Bottom' ,
					'right top'	     => 'Right Top' ,
					'Right center'	 => 'Right Center' ,
					'Right bottom'	 => 'Right Bottom' ,
				);
				
	 $bg_repeat =  array(
	                ''          => '' ,
				    'no-repeat'	=> 'No Repeat',
					'repeat'    => 'Repeat',
					'repeat-x'  => 'Repeat X',
					'repeat-y'  => 'Repeat Y'
				);	
				
				
	  $bg_cover = array(
	                     ''     => '' ,
				      'cover'	=> 'Cover',
					'contain'   => 'Contain',
					'Inherit'   => 'Inherit'
				);	
				
	  $button_styles = array( "default" => __("Default", "brad-framework") , "readmore" =>  __("Readmore Button", "brad-framework") ,"grey" =>  __("Grey Button", "brad-framework") , "blue" => __("Blue Button", "brad-framework") , "green" => __("Green Button", "brad-framework") , "seagreen" => __("Sea Green Button", "brad-framework"), "orange" => __("Orange Button", "brad-framework"), "red" => __("Red Button", "brad-framework") , "black" => __("Black Button", "brad-framework") , "white" => __("White Button", "brad-framework") , "purple" => __("Purple Button", "brad-framework")  ,  "yellow" => __("Yellow Button", "brad-framework") , 'alternate' => __('Alternate Button','brad-framework') , 'alternatewhite' => __('Alternate Transparent Button','brad-framework') );							
	
	$prefix = 'brad_';
	$meta_boxes = array();
	$meta_boxes[] = array(
	    	'id' => 'brad-metabox-post-gallery',
		    'title' =>  __('Gallery Settings','brad-framework'),
	    	'description' => '',
    		'pages'      => array( 'post' ), // Post type
	    	'context'    => 'normal',
		    'priority'   => 'high',
	    	'show_names' => true, // Show field names on the lef
	    	'fields' => array(
			     array(
			         'name'		=> 'Gallery Images',
			         'desc'	    => 'Upload Images for post Gallery ( Upto 15 Images ).',
			         'type'     => 'image_advanced',
			         'id'	    => $prefix . 'image_list',
	         'max_file_uploads' => 15 
	         )
		)
	);


   $meta_boxes[] = array(
		'id' => 'brad-metabox-post-video',
		'title' => __('Video Settings','brad-framework'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array( 
		   array(
				  'name' => 'Featued Video',
				  'desc' => 'Insert The Embed Code from your Video ( Note : Please Do\' insert any Video Links Here)',
			  	  'id'   => $prefix . 'video_embed',
				  'type' => 'textarea',
			)
		  , 
		  array(
				'name'  => __('Feature Video Poster', 'brad-framework'),
				'id'    => $prefix  . "video_poster",
				'type'  => 'image_advanced',
				'max_file_uploads' => 1
			)
		)
	 );
	 
	

  //Parallax Slider

   $meta_boxes[] = array(
	   'id'		=> 'bradslider_options',
	   'title'		=> 'Slider Options',
	   'pages'		=> array( 'bradslider' ),
	   'context' => 'normal',
       'fields'	=> array(	
	
	    array(
				'name'		=> 'Slider Background Type',
				'id'		=> $prefix . "slider_type",
				'desc'      => __('Select the default background type','brad-framework'),
				'type'		=> 'select',
				'options'	=> array(
				    'image'	=> 'Image',
					'video'		=> 'Video'
				),
				'multiple'	=> false,
				'std'		=> array( 'image' )
		),
		
		array(
			'name'		=> 'Background Overlay Opacity',
			'id'		=> $prefix . 'slider_bg_opacity',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'Insert the value between 0 and 1' ,
			'std'		=> '0'
		),	
		
		array(
			'name'		=>  'Slider Background Image',
			'id'		=>  $prefix . 'slider_image',
			'type'      =>  'image_advanced',
			'max_file_uploads' => 1
		),	
		
		array(
				'name'		=> 'Background Size',
				'id'		=> $prefix . "slider_bg_cover",
				'type'		=> 'select',
				'options'	=>  $bg_cover,
				'multiple'	=> false,
				'std'		=> array( 'cover' )
		),
		
		array(
				'name'		=> 'Background Repeat',
				'id'		=> $prefix . "slider_bg_repeat",
				'type'		=> 'select',
				'options'	=> $bg_repeat ,
				'multiple'	=> false,
				'std'		=> array( 'no-repeat' )
		),
		
		array(
				'name'		=> 'Background Position',
				'id'		=> $prefix . "slider_bg_pos",
				'type'		=> 'select',
				'options'	=> $bg_pos ,
				'multiple'	=> false,
				'std'		=> array( 'center top' )
		),
		
		array(
				'name'		=> 'Enable Ken Burn / Pane Zoom',
				'id'		=> $prefix . "slider_kenburn",
				'type'		=> 'select',
				'options'	=> array(
				    'no'    => 'No',
				    'yes'	=> 'Yes'	
				),
				'multiple'	=> false,
				'std'		=> array( 'no' )
		),
		
		array(
				'name'		=> 'Ken Burn Start Position',
				'id'		=> $prefix . "slider_kbpos_start",
				'type'		=> 'select',
				'options'	=> $bg_pos ,
				'multiple'	=> false,
				'std'		=> array( 'center top' )
		),
		
		array(
				'name'		=> 'Ken Burn End Position',
				'id'		=> $prefix . "slider_kbpos_end",
				'type'		=> 'select',
				'options'	=> $bg_pos ,
				'multiple'	=> false,
				'std'		=> array( 'center top' )
		),
		
		array(
			'name'		=> 'Ken Burn Zoom Start (In %)',
			'id'		=> $prefix . 'slider_kbzoom_start',
			'type'		=> 'text',
			'std'		=> '110'
		),
		
		array(
			'name'		=> 'Ken Burn Zoom End (In %)',
			'id'		=> $prefix . 'slider_kbzoom_end',
			'type'		=> 'text',
			'std'		=> '100'
		),
		
		
		array(
			'name'		=> 'Ken Burn Duration in ms',
			'id'		=> $prefix . 'slider_kbduration',
			'type'		=> 'text',
			'std'		=> '9000'
		),
		
		array(
			'name'		=> 'Sider Background video ( mp4)',
			'id'		=> $prefix . 'slider_video_mp4',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'Slider Background mp4 video url if Slider background type selected to video . You can upload video with wordpress media.' ,
			'std'		=> ''
		),	
		
		array(
			'name'		=> 'Sider Background video (WebM)',
			'id'		=> $prefix . 'slider_video_webm',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'Slider Background Webm video url if Slider background type selected to video . You can upload video with wordpress media.' ,
			'std'		=> ''
		),	
		
		
		array(
			'name'		=> 'Sider Background video (OGV)',
			'id'		=> $prefix . 'slider_video_ogv',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'Slider Background ogv video url if Slider background type selected to video . You can upload video with wordpress media.' ,
			'std'		=> ''
		),	
		
		
	   array(
			"name" =>  __("Video Aspect Ratio","brad-framework"),
			"options" => array(
				   "" => __("Default","brad-framework") ,
			   "16:9" => "16:9" ,
				"4:3" => "4:3"
			  ),
			"type" => "select",
			"id" => $prefix . "video_ratio",
			"multiple" => false 
	 )
	 ,
	 
	 array(
			'name'		=> 'Sider SubTitle',
			'id'		=> $prefix . 'slider_subtitle',
			'clone'		=> false,
			'type'		=> 'textarea',
			'desc'      => '' ,
			'std'		=> ''
		),
		
	 array(
			'name'		=> 'Sider Title',
			'id'		=> $prefix . 'slider_title',
			'clone'		=> false,
			'type'		=> 'textarea',
			'desc'      => '' ,
			'std'		=> ''
		),
		
	
		
		
		array(
			'name'		=> 'Sider Caption',
			'id'		=> $prefix . 'slider_caption',
			'clone'		=> false,
			'type'		=> 'textarea',
			'desc'      => '' ,
			'std'		=> ''
		),	
		
		array(
			'name'		=> 'Sider Font Color Scheme',
			'id'		=> $prefix . 'slider_color',
			'type'		=> 'select',
				'options'	=> array(
				    'light'	=> 'light',
					'dark'	=> 'dark'
				),
			'multiple'	=> false,
			'std'		=> array( 'light' ),
			'desc'      => '' 
		),	
		
		
		array(
			'name'		=> 'Header Color Scheme',
			'id'		=> $prefix . 'slider_header_color',
			'type'		=> 'select',
				'options'	=> array(
				    'light'	=> 'light',
					'dark'	=> 'dark'
				),
			'multiple'	=> false,
			'std'		=> array( 'light' ),
			'desc'      => '' 
		),	
		
	   
	    array(
				'name'		=> 'Slider Content Width (Default 100%)',
				'id'		=> $prefix . "slider_content_width",
				'type'		=> 'text',
				'std'		=> '100%',
				'desc'     => __("Slider Content Width in px or percentage only for ex 500px or 50%.","brad-framework")
		),
		
		
		array(
			'name'		=> 'Sider Content horizental Align',
			'id'		=> $prefix . 'slider_caption_align',
			'type'		=> 'select',
				'options'	=> array(
				    'left'	=> 'left',
					'center'	=> 'center' ,
					'right'	=> 'right' 
				),
			'multiple'	=> false,
			'std'		=> array( 'center' ),
			'desc'      => '' 
		),	
		
		array(
			'name'		=> 'Sider Content Vertical Align',
			'id'		=> $prefix . 'slider_caption_valign',
			'type'		=> 'select',
				'options'	=> array(
				    'top'	=> 'top',
					'center'	=> 'center' ,
					'bottom'	=> 'bottom' 
				),
			'multiple'	=> false,
			'std'		=> array( 'center' ),
			'desc'      => '' 
		),	
		
		
		  array(
			'name'		=> 'Slider Caption Button Text',
			'id'		=> $prefix . 'slider_button',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'Leave Blank if you do\'t want to display this button' ,
			'std'		=> ''
		),
		
		
		array(
			'name'		=> 'Slider Caption Button Link',
			'id'		=> $prefix . 'slider_btn_link',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		),
			
		
		array(
			'name'		=> 'Slider Caption Button Style',
			'id'		=> $prefix . 'slider_button_style',
			'desc'      => 'Leave Blank if you do\'t want to display this button' ,
			'type'		=> 'select',
				'options'	=> $button_styles,
				'multiple'	=> false,
				'std'		=> array( 'default' )
		),	
		
		
		array(
			'name'		=> 'Slider Caption Alternate Button Text',
			'id'		=> $prefix . 'slider_button_alternate',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'Leave Blank if you do\'t want to display this button' ,
			'std'		=> ''
		),	
		
		array(
			'name'		=> 'Slider Caption Alternate Button Link',
			'id'		=> $prefix . 'slider_altbtn_link',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		),
		
		array(
			'name'		=> 'Slider Caption Alternate Button Style',
			'id'		=> $prefix . 'slider_button_style_alternate',
			'desc'      => 'Leave Blank if you do\'t want to display this button' ,
			'type'		=> 'select',
				'options'	=> $button_styles,
				'multiple'	=> false,
				'std'		=> array( 'alternate-white' )
		),	
		
	
		
		array(
				'name'		=> 'Slider Caption Css Animation',
				'id'		=> $prefix . "slider_caption_animation",
				'type'		=> 'select',
				'options'	=> array(
					'fadeIn'			=> 'Fade',
					'fadeInLeft'    => 'Slide From Left',
					'fadeInRight'   => 'Slide From Right',
					'fadeInBottom'     => 'Slide From Top',
					'fadeInTop'  => 'Slide From bottom'
				),
				'multiple'	=> false,
				'std'		=> array( 'fadeIn' )
		)
	
	)
  );
 

	//Portfolio Settings		
   $meta_boxes[] = array(
	   'id'		=> 'portfolio_settings',
	   'title'		=> 'Project Settings',
	   'pages'		=> array( 'portfolio' ),
	   'context' => 'normal',
	   'priority' => 'high' ,
       'fields'	=> array(
	    
	    array(
			'name'		=> 'Show visual composer Content',
			'id'		=> $prefix . "portfolio-pagebuilder",
			'type'		=> 'checkbox',
			"desc"   => 'This option will show visual composer content and disable all other portfolio content including images , video etc. <b>Note:</b> All the options in "Project Info" box will not work',
			'std'       => false
		 ) ,
		 
		 array(
			'name'		=> 'Enable Fullwidth?',
			'id'		=> $prefix . "portfolio-fullwidth",
			'type'		=> 'checkbox',
			"desc"      => 'If you are using visual composer for portfolio and want to use the fullwidth of page , check this option',
			'std'       => false
		) 
		, 
		 
		 array(
			'name'		=>  'Show Related Projects',
			'id'		=>  $prefix . "portfolio-relatedposts",
			'type'		=>  'checkbox',
			'std'       =>  true 
		) 
		,
		
		 array(
			'name'		=> 'Show Navigation Icons?',
			'id'		=> $prefix . "portfolio-shownav",
			'type'		=> 'checkbox',
			'std'       => true 
		)
		,
		
		array(
			'name'		=> 'Overlay text scheme for portfolio grid ?',
			'id'		=> $prefix . "portfolio-overlay",
			'type'		=> 'select',
			'desc'     => 'Portfolio overlay text scheme when portfolio overlay style set to visible initial',
  			'std'       => 'default',
			'options' => array(
			    'default' => 'Light' ,
				'dark'   => 'Dark'
				)
		)  ,
		
		 array(
			'name'		=> 'Overlay  Background Color for portfolio grid?',
			'id'		=> $prefix . "portfolio-overlay-bg",
			'type'		=> 'color',
			'std'       => ''
		)
		,
		
		 array(
			'name'		=> 'Overlay  Background opacity for portfolio grid?',
			'id'		=> $prefix . "portfolio-overlay-opacity",
			'type'		=> 'text',
			'std'       => '0'
		)
		
	  )
 );
	
	
	//Portfolio Settings		
   $meta_boxes[] = array(
	   'id'		=> 'blog_settings',
	   'title'		=> 'Blog Settings',
	   'pages'		=> array( 'post' ),
	   'context' => 'normal',
	   'priority' => 'high' ,
       'fields'	=> array(

		
		 array(
			'name'		=> 'Hide Featured image , gallery or video?',
			'id'		=> $prefix . "blog-featured",
			'type'		=> 'checkbox',
			'std'       => false
		) 
		,
		
		
		array(
			'name'		=> 'Hide Metadata for post?',
			'id'		=> $prefix . "blog-metadata",
			'type'		=> 'checkbox',
			'desc'     => 'use this option if you want to disable meta data for the post content including post title' ,
			'std'       => false
		) 
		,
		

		array(
			'name'		=> 'Default Layout',
			'id'		=> $prefix . "blog-layout",
			'type'		=> 'select',
			'options'	=> array(
				''			=> 'Default',
				'fullwidth' => 'Fullwidth',
				'sidebar'   => 'With Sidebar',

			),
			'multiple'	=> false,
		)
	   ,
	   
	   array(
			'name'		=> 'Post Background Overlay Color in Slider',
			'id'		=> $prefix . 'slider_bg_color',
			'clone'		=> false,
			'type'		=> 'color'
		),	
		
		
	   array(
			'name'		=> 'Post Background Overlay Opacity in Slider',
			'id'		=> $prefix . 'slider_bg_opacity',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'This option will work when this post is used in brad slider . Insert the value between 0 and 1' ,
			'std'		=> '0'
		),	
		
	  
	  array(
			'name'		=> 'Post Font Color Scheme in Slider',
			'id'		=> $prefix . 'slider_color',
			'type'		=> 'select',
				'options'	=> array(
				    'light'	=> 'light',
					'dark'	=> 'dark'
				),
			'multiple'	=> false,
			'std'		=> array( 'light' ),
			'desc'      => '' 
		) ,
		
		array(
			'name'		=> 'Readmore Button Style in Slider',
			'id'		=> $prefix . 'slider_button_style',
			'desc'      => 'Leave Blank if you do\'t want to display this button' ,
			'type'		=> 'select',
				'options'	=> $button_styles,
				'multiple'	=> false,
				'std'		=> array( 'default' )
		),	
		
		array(
				'name'		=> 'Featured image Background Size in Slider',
				'id'		=> $prefix . "slider_bg_cover",
				'type'		=> 'select',
				'options'	=>  $bg_cover,
				'multiple'	=> false,
				'std'		=> array( 'cover' )
		),
		
		array(
				'name'		=> 'Featured image Background Repeat in Slider',
				'id'		=> $prefix . "slider_bg_repeat",
				'type'		=> 'select',
				'options'	=> $bg_repeat ,
				'multiple'	=> false,
				'std'		=> array( 'no-repeat' )
		),
		
		array(
				'name'		=> 'Featured image Background Position in Slider',
				'id'		=> $prefix . "slider_bg_pos",
				'type'		=> 'select',
				'options'	=> $bg_pos ,
				'multiple'	=> false,
				'std'		=> array( 'center top' )
		)
			
	  )
	);
		
  
	//Portfolio Option		
   $meta_boxes[] = array(
	   'id'		=> 'portfolio_options',
	   'title'		=> 'Project Info',
	   'pages'		=> array( 'portfolio' ),
	   'context' => 'normal',
       'fields'	=> array(
	    
	    array(
			 'name'		=> 'excerpt',
			 'id'		=> $prefix . 'excerpt',
			 'clone'		=> false,
			 'type'		=> 'wysiwyg',
			 'desc'      => 'Project Excerpt' , 
			 'std'		=> ''
		  ),
		  	
		
		array(
			'name'		=> 'Project link',
			'id'		=> $prefix . 'portfolio-link',
			'desc'		=> 'URL to the Project if available (Do not forget the http://)',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		 ),
		 
		 array(
			'name'		=> 'Project link Target',
			'id'		=> $prefix . 'portfolio-link-target',
			'options'   => array("_self" => __("Same window", "brad-framework")  , "_blank" => __("New window", "brad-framework")) ,
  			'multiple'		=> false,
			'type'		=> 'select',
			'std'		=> '_self'
		 ),
		 
		 array(
			'name'		=> 'Use above url in portfolio entries',
			'id'		=> $prefix . "portfolio-linked",
			'type'		=> 'checkbox',
			"desc"   => 'Check this option if you want to set the above url as link on portfolio titles , link icon and images instead of project info or page link  ',
			'std'       => false
		 ) ,
		
		 array(
			'name'		=> 'Project link title',
			'id'		=> $prefix . 'portfolio-link-title',
			'desc'		=> '',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		 ),
		
		
		
	    array(
			'name'		=> 'Client',
			'id'		=> $prefix . 'project_client',
			'desc'		=> '',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		),
		
	    
		 /*
		 array(
				'name'		=> 'Project Image Size',
				'id'		=> $prefix . "project_img_size",
				'type'		=> 'select',
				'options'	=> array(
				    'fullwidth'	=> 'Fullwidth',
					'half'		=> '2/3 Width'
				),
				'description' => 'Project image if select portfolio type select to masonry layout.' ,
				'multiple'	=> false,
				'std'		=> array( 'fullwidth' )
		 ),
		 */
		
		 array(
				'name'		=> 'Project type',
				'id'		=> $prefix . "project_type",
				'type'		=> 'select',
				'options'	=> array(
				    ''	=> 'Fullwidth',
					'half'		=> '2/3 Width'
				),
				'multiple'	=> false,
				'std'		=> array( 'fullwidth' )
		),
		
		
	   
	   
	   array(
			'name'		=> 'Project Slider Images',
			'desc'	    => 'Upload up to 50 project images for a slideshow.',
			'type'      =>  'image_advanced',
			'id'	    => $prefix . 'image_list',
	        'max_file_uploads' => 50 ,
		
	  ),	
		
	
       array(
		    'name' => 'Featued Video for your project',
		    'desc' => 'Insert The Embed Code from your Video ( Note : Please Do\' insert only Video Links Here)',
	    	'id'   => $prefix . 'video_embed',
		    'type' => 'textarea',
			)	,
			
	  array(
		    'name' => 'Youtube/Vimeo url for lightbox',
		    'desc' => 'Insert video url that will show in lightbox',
	    	'id'   => $prefix . 'video_llink',
		    'type' => 'text',
			)	
						
	)
	
	
  );
  
 
 
 	
	/* Clients Meta Box */ 
	$meta_boxes[] = array(
		'id'    => 'client_meta_box',
		'title' => __('Client Meta', 'brad-framework'),
		'pages' => array( 'clients' ),
		'fields' => array(
			
			// CLIENT IMAGE LINK
			array(
				'name' => __('Client Link', 'brad-framework'),
				'id' => $prefix . 'client_link',
				'desc' => __("Enter the link for the client if you want the image to be clickable.", 'brad-framework'),
				'clone' => false,
				'type'  => 'text',
				'std' => ''
			),
			array(
				'name'  => __('Client Logo', 'brad-framework'),
				'desc'  => __('Enter the image for the Client (required).', 'brad-framework'),
				'id'    => $prefix  . "client_image",
				'type'  => 'image_advanced',
				'max_file_uploads' => 1
			),
			array(
				'name'  => __('Client Logo on hover', 'brad-framework'),
				'desc'  => __('Enter the image for the Client (required).', 'brad-framework'),
				'id'    => $prefix  . "client_hover",
				'type'  => 'image_advanced',
				'max_file_uploads' => 1
			)
		)	
	);
	
	
	/* Testimonials Meta Box */
	$meta_boxes[] = array(
		'id'    => 'testimonials_meta_box',
		'title' => __('Testimonial Info', 'brad-framework'),
		'pages' => array( 'testimonials' ),
		'fields' => array(
			
			array(
				'name' => __('Testimonial Name', 'brad-framework'),
				'id' => $prefix . 'testimonial_name',
				'desc' => __("Enter the cite name for the testimonial.", 'brad-framework'),
				'clone' => false,
				'type'  => 'text',
				'std' => ''
			),
			
			array(
				'name' => __('Role', 'brad-framework'),
				'id' => $prefix . 'testimonial_role',
				'desc' => __("Enter the role of testimonial for ex. Ceo  , President", 'brad-framework'),
				'clone' => false,
				'type'  => 'text',
				'std' => ''
			),

			array(
				'name' => __('Testimonial Company', 'brad-framework'),
				'id' => $prefix . 'testimonial_company',
				'desc' => __("Enter the testimonial company (optional).", 'brad-framework'),
				'clone' => false,
				'type'  => 'text',
				'std' => ''
			),
		
		  array(
				'name' => __('Company Link', 'brad-framework'),
				'id' => $prefix . 'testimonial_company_link',
				'desc' => __("Enter the Company url or leve blank if do't want to have a link", 'brad-framework'),
				'clone' => false,
				'type'  => 'text',
				'std' => ''
			),
			

			array(
				'name'  => __('Testimonial  Image', 'brad-framework'),
				'desc'  => __('Enter the image for the testimonial (optional).', 'brad-framework'),
				'id'    => $prefix  . "testimonial_image",
				'type'  => 'image_advanced',
				'max_file_uploads' => 1
			),
			
		   array(
			  'name'		=> 'Testimonial Column Width',
			  'id'		=> $prefix . "testm_width",
			  'type'		=> 'select',
			  'options'	=> array(
				  ''	=> 'Default',
				  'span6'		=> 'One Half' ,
				  'span4'      => 'One Third' ,
				  'span8'      => 'Two Third' ,
				  'span3'      => 'One Fourth' ,
				  'span9'      => 'Three Fourth' ,
				  'spanone_fith' => 'One Fifth' ,
				  'span2'  => 'One Sixth' ,
				  'span10' => 'Four Sixth'
			  ),
			  'multiple'	=> false
	     ),
		)	
	);
	

	 //Page Options
     $meta_boxes[] = array(
	   'id'		=> 'brad_page_settings_default',
	   'title'		=> 'Page Settings',
	   'pages'		=> array( 'page' , 'product' ),
	   'context' => 'side',
       'fields'	=> array(
	   
	   	array(
			'name'		=> 'Default Page Layout',
			'id'		=> $prefix . "page_layout",
			'type'		=> 'select',
			'options'	=> array(
			        'fullwidth'		=> 'Without Sidebar',
					'sidebar'		=> 'With Sidebar',
				),
			'multiple'	=> false
		),	
		
	  array(
			'name'		=> 'Sidebar Position',
			'id'		=> $prefix . "sidebar_position",
			'type'		=> 'select',
			'options'	=> array(
			        'left'		=> 'Left',
					'right'		=> 'Right',
				),
			'multiple'	=> false
		  ) ,
		  
	 
	 array(
			'name'		=> 'Page Sidebar if page layout selected to sidebar',
			'id'		=> $prefix . "default_sidebar",
			'type'		=> 'select',
			'options'	=> array(
			           'blog-sidebar'	  => 'Blog Sidebar',
					'woocommerce-sidebar' => 'Woocommerce Sidebar' ,
					'sidebar1'  => 'Sidebar 1' ,
					'sidebar2'  => 'Sidebar 2' ,
					'sidebar3'  => 'Sidebar 3' ,
					'sidebar4'  => 'Sidebar 4' ,
					'sidebar5'  => 'Sidebar 5' ,
				),
			'multiple'	=> false
		  ) ,
		  	  
		  
	  array(
			'name'		=> 'Current Navigation Menu',
			'id'		=> $prefix . "page_nav",
			'type'		=> 'select',
			'options'	=>  $nav_menus,
			'multiple'	=> false
		  ) 	  
	   	  
		)
	 );
	 
	 	

	
      $meta_boxes[] = array(
			'id' => 'styling',
			'title' => 'Background Styling Options',
			'pages' => array( 'page', 'portfolio' ),
			'context' => 'side',
			'priority' => 'low',
		
			// List of meta fields
			'fields' => array(
				array(
					'name'		=> 'Background Image',
					'id'		=> $prefix . 'bg_image',
					'desc'		=> '',
					'clone'		=> false,
					'type'		=> 'image_advanced',
					'max_file_uploads' => 1
				),
				array(
					'name'		=> 'Background Position',
					'id'		=> $prefix . "bg_position",
					'type'		=> 'select',
					'options'	=> $bg_pos ,
					'multiple'	=> false,
					'std'		=> array( '' )
				),
				array(
					'name'		=> 'Background Cover',
					'id'		=> $prefix . "bg_cover",
					'type'		=> 'select',
					'options'	=> $bg_cover ,
					'multiple'	=> false,
					'std'		=> array( '' )
				),
				array(
					'name'		=> 'Background Repeat',
					'id'		=> $prefix . "bg_repeat",
					'type'		=> 'select',
					'options'	=> $bg_repeat ,
					'multiple'	=> false,
					'std'		=> array( '' )
				),
				array(
					'name'		=> 'Background Attachment',
					'id'		=> $prefix . "bg_attachment",
					'type'		=> 'select',
					'options'	=> array('','fixed' => 'Fixed' , 'scroll' => 'Scroll' ,'inherit' => 'Inherit') ,
					'multiple'	=> false,
					'std'		=> array( '' )
				),
				array(
					'name'		=> 'Background Color',
					'id'		=> $prefix . "bg_color",
					'type'		=> 'color'
				)
			)
		);

		
	  $meta_boxes[] = array(
	   'id'		=> 'brad_page_settings_sideNavigation',
	   'title'		=> 'Side Nav Position',
	   'pages'		=> array( 'page' ),
	   'context' => 'side',
       'fields'	=> array(
	   
	  array(
			'name'		=> '',
			'id'		=> $prefix . "sidenav_position",
			'type'		=> 'select',
			'options'	=> array(
			        'left'		=> 'Left',
					'right'		=> 'Right',
				),
			'multiple'	=> false
		 )	
		)
	  );
		
     $meta_boxes[] = array(
	   'id'		=> 'brad_page_settings',
	   'title'		=> 'Page Header / Titlebar',
	   'pages'		=> array( 'page' , 'post' , 'portfolio' ),
	   'context' => 'normal',
       'fields'	=> array(
	    array(
			'name'		=> 'Header Type',
			'id'		=> $prefix . "header_type",
			'type'		=> 'select',
			'options'	=> array(
					  ''        => 'Select Header Type' ,
				'transparent'	=> 'Transparent',
				'solid'		    => 'Solid',
			),
			'multiple'	=> false
		),
		
		
		array(
			'name'		=> 'Make the Header Semi Transparent',
			'id'		=> $prefix . "header_semitrans",
			'type'		=> 'select',
			'options'	=> array(
				'no'    => 'No' ,
				'yes'	=> 'Yes'
			),
			'desc'  => 'Use this option to make header semi transparent if header type selected to transparent' ,
			'multiple'	=> false
		),
		
		
		array(
			'name'		=> 'Header Text Scheme',
			'id'		=> $prefix . "header_scheme",
			'desc'      => 'Change all the text color in header including titlebar . Does not affect Solid header',
			'type'		=> 'select',
			'options'	=> array(
				''        => 'Select Header Text Scheme' ,
				'dark'	  => 'Dark',
				'light'	  => 'Light'
			),
			'multiple'	=> false
		),
		
		
		array(
			'name'		=> 'Header Content',
			'id'		=> $prefix . "header_content",
			'type'		=> 'select',
			'options'	=> array(
					'titlebar'	=> 'Titlebar',
					'bradslider' => 'Bradslider',
					'revslider' => 'Revolution Slider',
					'none'  => 'none' 
				),
			'multiple'	=> false,
			'std' => array('titlebar')
		)
		,
		
		 array(
			'name'		=> 'Page Slider (Brad Slider Location)',
			'id'		=> $prefix . "bradslider",
			'type'		=> 'select',
			'options'	=> $bradsliders ,
			'multiple'	=> false
		)
		,
		
		
		array(
			'name'		=> 'Slider Effect',
			'id'		=> $prefix . "slider_effect",
			'type'		=> 'select',
			'options'	=> array(
				'fade'	   =>  'Fade',
				''	   =>  'Slide'
			),
			'multiple'	=> false,
			'std'		=> array( 'fade' )
		),
		
		array(
			'name'		=> 'Enable Parallax',
			'id'		=> $prefix . "slider_parallax",
			'type'		=> 'select',
			'options'	=> array(
				'yes'	   =>  'Yes',
				'no'	   =>  'No'
			),
			'multiple'	=> false,
			'std'		=> array( 'yes' )
		),
		
		array(
			'name'		=> 'Slider Height',
			'id'		=> $prefix . 'slider_height',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'Do \'t include px only just numbers' ,
			'std'		=> '450'
		),
		
		array(
			'name'		=> 'Slider Autorotate',
			'id'		=> $prefix . 'slider_interval',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'use value 0 if you do\'t want to autorotate slides' ,
			'std'		=> '5000'
		),	
		
		
		array(
			'name'		=> 'Show Navigation',
			'id'		=> $prefix . "slider_nav",
			'type'		=> 'select',
			'options'	=> array(
				'yes'	   =>  'Yes',
				'no'	   =>  'No'
			),
			'multiple'	=> false,
			'std'		=> array( 'yes' )
		),
		
		array(
			'name'		=> 'Show Pagination',
			'id'		=> $prefix . "slider_pagination",
			'type'		=> 'select',
			'options'	=> array(
				'yes'	   =>  'Yes',
				'no'	   =>  'No'
			),
			'multiple'	=> false,
			'std'		=> array( 'yes' )
		),
		
		array(
			'name'		=> 'Enable Responsive Height',
			'id'		=> $prefix . "ht_responsive",
			'type'		=> 'select',
			'options'	=> array(
				'yes'	   =>  'Yes',
				'no'	   =>  'No'
			),
			'multiple'	=> false,
			'std'		=> array( 'yes' )
		),
		
		array(
			'name'		=> 'Enable Swipe on Desktop',
			'id'		=> $prefix . "slider_swipe",
			'type'		=> 'select',
			'options'	=> array(
				'yes'	   =>  'Yes',
				'no'	   =>  'No'
			),
			'multiple'	=> false,
			'std'		=> array( 'yes' )
		),
		
	   array(
			'name'		=> 'Enable Full Slider height',
			'id'		=> $prefix . "slider_fullheight",
			'type'		=> 'select',
			'options'	=> array(
				'no'			=> 'No',
				'yes'			=> 'Yes',
			),
			'multiple'	=> false,
			'std'		=> array( 'no' )
		),
		
		 array(
			'name'		=> 'Page Slider (Rev Slider)',
			'id'		=> $prefix . "rev_slider",
			'type'		=> 'select',
			'options'	=> $revsliders ,
			'multiple'	=> false
		)
		,
		
		
		array(
			'name'		=> 'Show Breadcrumbs',
			'id'		=> $prefix . "titlebar_breadcrumb",
			'type'		=> 'select',
			'std'       => '' ,
			'options'	=> array(
			      '' => '',
				  'yes' => 'Yes',	
				  'no' => 'No'
			),
			'multiple'	=> false
		),
		
		array(
			'name'		=> 'Enable Titlbar Border',
			'id'		=> $prefix . "titlebar_border",
			'type'		=> 'select',
			'std'       => '' ,
			'options'	=> array(
			      '' => '',
				  'yes' => 'Yes',	
				  'no' => 'No'
			),
			'multiple'	=> false
		),
	
	
		 array(
			'name'		=> 'Titlebar Text Scheme',
			'id'		=> $prefix . "titlebar_scheme",
			'type'		=> 'select',
			'options'	=> array(
				''        => 'Select Titlebar Text Scheme' ,
				'dark'	  => 'Dark',
				'light'	  => 'Light'
			),
			'multiple'	=> false
		),
		
		

	   array(
			'name'		=> 'Titlebar Content Alignment',
			'id'		=> $prefix . "titlebar_alignment",
			'type'		=> 'select',
			'options'	=> array(
			      ''       => '' , 
				  'justify' => 'Justify',			
					'center' => 'Center'
			),
			'multiple'	=> false
		),
		
		
		array(
			'name'		=> 'Titlebar Text Size',
			'id'		=> $prefix . "titlebar_size",
			'type'		=> 'select',
			'options'	=> array(
			      '' => '',
				  'normal' => 'Normal',	
				  'medium' => 'Medium',			
				  'large' => 'Large'
			),
			'multiple'	=> false
		),
	
		
	    array(
			'name'		=> 'Titlebar Height',
			'id'		=> $prefix . 'title_height',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'Do \'t include px only just numbers' ,
			'std'		=> ''
		),	
		
		
	   array(
			'name'		=> 'Titlebar Background Color',
			'id'		=> $prefix . 'titlebar_bg_color',
			'clone'		=> false,
			'type'		=> 'color',
		),	
		
	   array(
			'name'		=>  'Titlebar Background Image',
			'id'		=>  $prefix . 'bg_image_titlebar',
			'type'      =>  'image_advanced',
			'max_file_uploads' => 1
		),
		
		array(
			'name'		=> 'Tilebar Bg Image Opacity',
			'id'		=> $prefix . 'titlebar_bg_opacity',
			'clone'		=> false,
			'type'		=> 'text',
			'desc'      => 'use value between 0 and 1' ,
		),
			
		
		
		array(
			'name'		=> 'Background Size',
			'id'		=> $prefix . "titlebar_bg_cover",
			'type'		=> 'select',
			'options'	=> $bg_cover ,
			'multiple'	=> false
		),
		
		array(
			'name'		=> 'Background Repeat',
			'id'		=> $prefix . "titlebar_bg_repeat",
			'type'		=> 'select',
			'options'	=> $bg_repeat ,
			'multiple'	=> false,

		),
		
		array(
			'name'		=> 'Background Position',
			'id'		=> $prefix . "titlebar_bg_pos",
			'type'		=> 'select',
			'options'	=> $bg_pos ,
			'multiple'	=> false,
		),
		
		
		array(
			'name'		=> 'Enable Parallax',
			'id'		=> $prefix . "titlebar_parallax",
			'type'		=> 'select',
			'options'	=> array(
				''             => '' ,
				'no'			=> 'No',
				'yes'			=> 'Yes',
			),
			'multiple'	=> false
		),
		
	 
			  		  	
	   array(
			'name'		=> 'Title',
			'id'		=> $prefix . 'page_title',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		),
		
	
	 array(
			'name'		=> 'Additional Content',
			'id'		=> $prefix . 'add_content',
			'clone'		=> false,
			'type'		=> 'textarea',
			'desc'      => 'Additional Content for Titlebar . This will be placed after the title and breadcrumb in titlebar' , 
			'std'		=> ''
		) ,
		
		array(
			'name'		=> 'Remove Header Space',
			"desc"      => 'Remove header space if the header type is selected to transparent' ,
			'id'		=> $prefix . "rm_header_space",
			'type'		=> 'select',
			'options'	=> array(
				'no'	   =>  'No' ,
				'yes'	   =>  'Yes',
			),
			'multiple'	=> false,
			'std'		=> array( 'yes' )
		)
	
	)
  );	
	   
	   
    foreach ( $meta_boxes as $meta_box )
    {
        new RW_Meta_Box( $meta_box );
    }
	
}

