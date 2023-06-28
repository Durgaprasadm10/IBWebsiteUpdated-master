<?php
/**
	ReduxFramework Sample Config File
	For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
**/

 if( file_exists( dirname( __FILE__ ) . '/ReduxCore/framework.php' ) ) {
                require_once( dirname( __FILE__ ) . '/ReduxCore/framework.php' );
            }
			
			
if ( !class_exists( "ReduxFramework" ) ) {
	return;
} 

if ( !class_exists( "Redux_Framework_config" ) ) {
	class Redux_Framework_config {

		public $args = array();
		public $sections = array();
		public $ReduxFramework;

		public function __construct( ) {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();
			
			// Create the sections and fields
			$this->setSections();
			
			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}
			
		
			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);

		}
	
		
	
  public function setSections() {
	  
	 global $wp_registered_sidebars; 
  // ACTUAL DECLARATION OF SECTIONS
     
	 $button_colors_arr = array(
	      "default" => __("Default", "brad-framework")  ,  
		  "grey" => __("Grey", "brad-framework") , 
		  "white" =>  __("White", "brad-framework")  , 
		  "green" => __("Green", "brad-framework"), 
		  "seagreen" => __("Sea Green", "brad-framework"), 
		  "blue" => __("Blue", "brad-framework"), 
		  "orange" => __("Orange", "brad-framework"), 
		  "red" => __("Red", "brad-framework")  , 
		  "black" => __("Black", "brad-framework")  , 
		  "purple" => __("Purple", "brad-framework")  ,
		  "yellow" =>  __("Yellow", "brad-framework")  , 
		  'alternate' => __('Alternate','brad-framework') , 
		  'alternateprimary' => __('Alternate Primary','brad-framework') , 
		  'alternatewhite' => __('Alternate Transparent','brad-framework') );
  
    $this->sections[] = array(
		'icon' => 'el-icon-cog',
		'icon_class' => 'icon-small',
        'title' => __('General Settings', "brad-framework"),
        'desc' => '<p class="description">'. __('Customize the main settings for theme', "brad-framework") .'</p>',
        'fields' => array(
		/*
        array( "title" => __( "Enable Responsive Layout" , "brad-framework") ,
				"subtitle" => __( "Check this option to if you want responsive layout." , "brad-framework"),
				 "id" => "check_responsive",
				 "default" => 1,
				 "type" => "switch" 
				 ),  
		 */  
		 
		array( "title" => __( "Enable Page Loader ", "brad-framework"),
			   "id" => "check_loader",
			   "default" => 0,
			   "type" => "switch" ,
			),
				
			
	   array( "title" => __( "Load Minify Scripts", "brad-framework"),
			   "id" => "minify_scripts",
			   "default" => 1,
			   "type" => "switch" ,
			),		
			 
		array( "title" => __( "Disable Comments for all Content Pages ", "brad-framework"),
			   "subtitle" => __( "Check this option to disable comments for all pages ", "brad-framework"),
			   "id" => "check_disablecomments",
			   "default" => 1,
			   "type" => "switch" ,
			), 
				
		  array( "title" => "Default Email Address for Contact Form",
				 "sub_desc" => "Default Email address where you want to send user feedback",
				 "id" => "contact_form_email",
				 "std" => get_option('admin_email') ,
				 "type" => "text"
				 ), 
				 
		array( "title" => "Alternate Email Address For Contact Form",
			   "sub_desc" => "Alternate Email address where you want to send user feedback ( you can use speical email address page builder where you want to send emails)",
			   "id" => "contact_form_email_alternate",
			   "std" => '' ,
			   "type" => "text"
			), 		 
				 
				 				 
	   array( 'type' => 'divide',
		      'id' => 'divider_after_comments'
			 ) ,
		  					
	  
     array( "title" => __(  "Background Style for Body", "brad-framework"),
            "id" => "bg_style",
            "default" =>array( "background-color" => "#ffffff" , "background-position" => "center center" , "background-repeat" => "no-repeat","background-size" => "cover" , "background-attachment" => "fixed" ,"background-image" => false),
            "type" => "background"),

    
	 array( "title" => __( "Layout", "brad-framework"),
              "subtitle" => __( "Select boxed or wide layout.", "brad-framework"),
			  "multiselect" => false ,
              "id" => "layout",
              "default" => 'wide' ,
              "type" => "select",
              "options" => array(
                'boxed' => 'Boxed',
                'wide' => 'Wide',
            )),
			
	array( "title" => 'Boxed Style',
	       "id"  => "boxed_bstyle",
		   "options" => array( 'default' => 'Default without Margin' , 'minimal' => 'Boxed With Margin From Top') ,
		   'required' => array('layout','=','boxed'),	
		   'type' => 'select' ),
		   
  array( "title" => 'Use extra Horizental padding for boxed layout',
	       "id"  => "boxed_bpadding",
		   "default" => "no",
		   "options" => array( 'no' => 'No' , 'yes' => 'Yes') ,
		   'required' => array('layout','=','boxed'),	
		   'type' => 'select' ),
		   
  array( "title" => 'Use extra Vertical padding for boxed layout',
	       "id"  => "boxed_vpadding",
		   "default" => "no",
		   "options" => array( 'no' => 'No' , 'yes' => 'Yes') ,
		   'required' => array('layout','=','boxed'),	
		   'type' => 'select' ),		   	
		   
  
   array( "title" => 'Cover padding for header',
	       "id"  => "boxed_pcover_header",
		   "default" => "no",
		   "desc" => "When you use extra padding ,the left and right corner of header will look seprate form boxed version , click this if you want to remove that extra spce",
		   "options" => array( 'no' => 'No' , 'yes' => 'Yes') ,
		   'required' => array('boxed_bpadding','=','yes'),	
		   'type' => 'select' ),
	
	array( "title" => 'Cover padding for Titlebar',
	       "id"  => "boxed_pcover_titlebar",
		   "default" => "no",
		   "options" => array( 'no' => 'No' , 'yes' => 'Yes') ,
		   'required' => array('boxed_bpadding','=','yes'),	
		   'type' => 'select' ),
		   
		   	   
    array( "title" => 'Cover padding for Footer',
	       "id"  => "boxed_pcover_footer",
		   "default" => "no",
		   "options" => array( 'no' => 'No' , 'yes' => 'Yes') ,
		   'required' => array('boxed_bpadding','=','yes'),	
		   'type' => 'select' ),		 
		   
		     		 	   		   	  
		   
	array( "title" => 'Enable Outer Box Shadow',
	       "id"  => "boxed_shadow",
		   "default" => "yes" ,
		   "options" => array( 'yes' => 'Yes' , 'no' => 'No') ,
		   'required' => array('layout','=','boxed'),	
		   'type' => 'select' ),	
		   
   array( "title" => 'Border For Boxed Layout',
	       "id"  => "boxed_border",
		   "default" => array( "border-top" => "0" , "border-style" => "" , "border-color" => ""  ) ,
		   'required' => array('layout','=','boxed'),	
		   'type' => 'border' ),		   
		   	   
			
	array( "title" => __(  "Background Style for Outer area of boxed content", "brad-framework"),
            "id" => "bg_style_boxed",
			'required' => array('layout','=','boxed'),				
            "default" =>array( "background-color" => "#f3f3f3" , "background-position" => "center center" , "background-repeat" => "no-repeat","background-size" => "cover" , "background-attachment" => "fixed" ,"background-image" => false),
            "type" => "background"),	
			
	 array( "title" => __( "Background Pattern for outer boxed area", "brad-framework"),
            "subtitle" => __( "Enable Background pattern ", "brad-framework"),
            "id" => "bg_pattern",
            "default" => 0,
			'required' => array('layout','=','boxed'),	
            "type" => "checkbox"),

     array( "title" => __( "Select a Background Pattern", "brad-framework"),
            "id" => "bg_patterns",
			'required' => array('bg_pattern','=', 1 ),	
            "default" => "pattern1",
			'required' => array('layout','=','boxed'),	
            "type" => "image_select",
            "options" => array(
                "pattern1.png" => array( "title" => __( "Pattern 1", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt01.jpg"),
                "pattern2.png" => array( "title" => __( "Pattern 2", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt02.jpg"),
                "pattern3.png" => array( "title" => __( "Pattern 3", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt03.jpg"),
                "pattern4.png" => array( "title" => __( "Pattern 4", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt04.jpg"),
                "pattern5.png" => array( "title" => __( "Pattern 5", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt05.jpg"),
                "pattern6.png" => array( "title" => __( "Pattern 6", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt06.jpg"),
                "pattern7.png" => array( "title" => __( "Pattern 7", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt07.jpg"),
                "pattern8.png" => array( "title" => __( "Pattern 8", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt08.jpg"),
				"pattern9.jpg" => array( "title" => __( "Pattern 9", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt09.jpg"),
				"pattern10.png" => array( "title" => __( "Pattern 10", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt10.jpg"),
				"pattern11.jpg" => array( "title" => __( "Pattern 11", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt11.jpg"),
				"pattern12.jpg" => array( "title" => __( "Pattern 12", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt12.jpg"),
				"pattern13.jpg" => array( "title" => __( "Pattern 13", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt13.jpg"),
				"pattern14.png" => array( "title" => __( "Pattern 14", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt14.jpg"),
				"pattern15.png" => array( "title" => __( "Pattern 15", "brad-framework") , "img" => get_template_directory_uri()."/images/patterns/patt15.jpg")
            )),			

			
		 array( "title" => __( "Custom CSS", "brad-framework"),
                "subtitle" => __( "Quickly add some CSS to your theme by adding it to this block. Do't Included ( <style type=\"text/css\"></style> ) Code", "brad-framework"),
                "id" => "custom_css",
                "default" => "",
                "type" => "textarea"
				),

        array( "title" => __( "Tracking Code", "brad-framework"),
		       "subtitle" => __( "Paste your Google Analytics (or other) tracking code here. This will be added into the  template of your theme.", "brad-framework"),
		       "id" => "google_analytics",
		       "default" => "",
		       "type" => "textarea"
			   ),   		
			   
	  array( "title" => __( "Custom font icon file", "brad-framework"),
			   "subtitle" => 'You can upload here a zip file containing css and icon font files. Use the <a href="http://icomoon.io/app/" target="_top">Icomoon</a> app to create icon font. Only zip files optained from icomoon application are supported. ' ,
			   "id" => "custom_iconfont",
			   "type" => "file" 
			)			   					 
        )
    );
    
$this->sections[] =  array(
		'icon' => 'el-icon-livejournal',
		'icon_class' => 'icon-small',
        'title' => __('Logo and Favicons', "brad-framework"),
		'desc' => '<p>Upload the Main  Logo and Favicons with  Retina Versions </p>' ,
        'fields' => array( 
			
			
			 array( "title" => "Logo Container Width in px",
					"sub_desc" => " Set the width for logo container. Logo container is used to fit the logo in navigation.",
					"id" => "logo_con_width",
					"default" => '110',
					"min" => '0' ,
					"max" => '500' ,
					"type" => "slider"
					),
					
			array( "title" => "Logo Offset Top",
					"id" => "logo_offset_top",
					"default" => '0',
					"min" => '0' ,
					"max" => '100' ,
					"type" => "slider"
					),	
					
		  array( "title" => "Logo Offset Top for Shrinked Nav",
					"id" => "logo_offset1_top",
					"default" => '0',
					"min" => '0' ,
					"max" => '100' ,
					"type" => "slider"
					),					
					
							
            array( "title" => __( "Logo Upload", "brad-framework"),
					"subtitle" => __( "Upload your Logo", "brad-framework"),
					"id" => "media_logo",
					"default" => array( "url" =>  get_template_directory_uri()."/images/logo.png" ),
					'type' => 'media',
					'mode' => 'image'
					),
					
			array( "title" => __( "Logo Upload (Light Version)", "brad-framework"),
					"id" => "media_logo_white",
					"subtitle" => __( "Enter your logo that will be showed on light header (This is optional)", "brad-framework"),
					"default" => array( "url" =>  get_template_directory_uri()."/images/logowhite.png" ),
					'type' => 'media',
					'mode' => 'image'
					),		
					
					
             array( "title" => __( "Logo Upload Retina", "brad-framework"),
					"subtitle" => __( "Upload your Retina Logo.", "brad-framework"),
					"id" => "media_logo_retina",
					"default" => array( "url" => get_template_directory_uri()."/images/logo_2x.png" ),
					"type" => "media",
					'mode' => 'image'),
					
			array( "title" => __( "Logo Upload Retina(Light Version)", "brad-framework"),
					"id" => "media_logo_retina_white",
					"default" => array( "url" => get_template_directory_uri()."/images/logowhite_2x.png" ),
					"type" => "media",
					'mode' => 'image'),
				
             array( "title" => __( "Original Logo Width ( For Retina Version )", "brad-framework"),
					"subtitle" => __( "This width will be used to make the retina logo dimension equal to standard logo", "brad-framework"),
					"id" => "logo_width",
					"default" => "110",
					"type" => "text"),
					
			
             array( "title" => __( "Custom Favicon (16x16)", "brad-framework"),
					"subtitle" => __( "Upload a 16px x 16px Png/ico image that will represent your website's favicon - use <a href='http://www.favicon.cc/' target='_blank'>favicon.cc</a> to make sure it's fully compatible)", "brad-framework"),
					"id" => "media_favicon",
					"default" => "",
					"type" => "media",
					'mode' => 'image'),
					
             array( "title" => __( "Apple iPhone Custom Icon (57x57)", "brad-framework"),
					"subtitle" => __( "Upload your Apple Touch Icon (57x57px png)", "brad-framework"),
					"id" => "media_favicon_iphone",
					"default" => "",
					"type" => "media",
					'mode' => 'image'),
					
            array( "title" => __( "Apple iPhone Custom Retina Icon  (114x114)", "brad-framework"),
					"subtitle" => __( "Upload your Apple Touch Retina Icon (114x114px png)", "brad-framework"),
					"id" => "media_favicon_iphone_retina",
					"default" => "",
					"type" => "media",
					'mode' => 'image'),
					
             array( "title" => __( "Apple iPad Custom Icon (72x72)", "brad-framework"),
					"subtitle" => __( "Upload your Apple Touch Retina Icon (144x144px png)", "brad-framework"),
					"id" => "media_favicon_ipad",
					"default" => "",
					"type" => "media",
					'mode' => 'image'),
					
             array( "title" => __( "Apple iPad Custom Retina Icon  (144x144px)", "brad-framework"),
					"subtitle" => __( "Upload your Apple Touch Retina Icon (144x144px png)", "brad-framework"),
					"id" => "media_favicon_ipad_retina",
					"default" => "",
					"type" => "media",
					'mode' => 'image') )) ;
					
					
								
$this->sections[] = array(
		'icon' => 'el-icon-text-width',
		'icon_class' => 'icon-small',
        'title' => __('Typography', "brad-framework"),
		'desc' => '<p>Customize the fonts for body , headings etc.</p><p>Use the below uploader fields to upload your fonts.To use the uploaded font please select the desired custom font from the select menu for font properties</p>' ,
        'fields' => array(
		
		
		   		
	 array( "title" => __( "Load Google fonts Directly ", "brad-framework"),
			   "id" => "load_gid",
			   "default" => 0,
			   "type" => "switch" ,
			),	
			
			
		    array( "title" => __( "Fonts Scripts", "brad-framework"),
                "subtitle" => __( "Use this field to insert javascript provided by premium font vendors", "brad-framework"),
                "id" => "fonts_js",
                "default" => "",
                "type" => "textarea"
				),
				
				
	        array( 
		            "title" => __( "Custom Font WOFF 1", "brad-framework"),
					"subtitle" => "",
					"id" => "custom_font_woff_1",
					'compiler'  => 'true',
                    'mode'      => false,
			        'default'  => array("url" => get_template_directory_uri().'/fonts/Museo_Slab_300-webfont.woff'),
					"type" => "media" ,
					"subtitle" => __("Upload your .woff font file","brad-framework")),

			array( 
		            "title" => __( "Custom Font TTF 1", "brad-framework"),
					"subtitle" => "",
					"id" => "custom_font_ttf_1",
					'compiler'  => 'true',
                    'mode'      => false,
					'default'  => array("url" => get_template_directory_uri().'/fonts/Museo_Slab_300-webfont.ttf'),
					"type" => "media",
					"subtitle" => __("Upload your .ttf font file","brad-framework") ),
				
			array( 
		            "title" => __( "Custom Font EOT 1", "brad-framework"),
					"subtitle" => "",
					"id" => "custom_font_eot_1",
					'default'  => array("url" => get_template_directory_uri().'/fonts/Museo_Slab_300-webfont.eot'),
					'compiler'  => 'true',
                    'mode'      => false,
					"type" => "media",
					"subtitle" => __("Upload your .eot font file","brad-framework") ),
					
			array( 
		            "title" => __( "Custom Font SVG 1", "brad-framework"),
					"subtitle" => "",
					"id" => "custom_font_svg_1",
					'compiler'  => 'true',
                    'mode'      => false,
					'default'  => array("url" => get_template_directory_uri().'/fonts/Museo_Slab_300-webfont.svg'),
					"type" => "media",
					"subtitle" => __("Upload your .svg font file","brad-framework") ),
					
		  array( 
		            "title" => __( "Custom Font WOFF 2", "brad-framework"),
					"subtitle" => "",
					"id" => "custom_font_woff_2",
					'compiler'  => 'true',
                    'mode'      => false,
					"default" => array("url" => false) ,
					"type" => "media",
					"subtitle" => __("Upload your .woff font file","brad-framework") ),

			array( 
		            "title" => __( "Custom Font TTF 2", "brad-framework"),
					"subtitle" => "",
					"id" => "custom_font_ttf_2",
					'compiler'  => 'true',
                    'mode'      => false,
					"default" => array("url" => false) ,
					"type" => "media",
					"subtitle" => __("Upload your .ttf font file","brad-framework") ),
				
			array( 
		            "title" => __( "Custom Font EOT 2", "brad-framework"),
					"subtitle" => "",
					"id" => "custom_font_eot_2",
					'compiler'  => 'true',
                    'mode'      => false,
					"default" => array("url" => false) ,
					"type" => "media",
					"subtitle" => __("Upload your .eot font file","brad-framework") ),
					
			array( 
		            "title" => __( "Custom Font SVG 2", "brad-framework"),
					"subtitle" => "",
					"id" => "custom_font_svg_2",
					'compiler'  => 'true',
                    'mode'      => false,
					"default" => array("url" => false) ,
					"type" => "media",
					"subtitle" => __("Upload your .svg font file","brad-framework") ),									
					
			array(  "title" => __( "Main Body  Font", "brad-framework"),
					"subtitle" => __( "Specify the Body font properties", "brad-framework"),
					"id" => "font_body",
					"color" => false ,
					"preview" => false ,
					"font-backup" => true ,
					"text-align" => false ,
					"google" => true ,
					"default" => array('font-type' => false , 'font-family' => 'Raleway',"font-style" => "normal"  ,'font-weight' => '400' , 'font-size' => '14px' , 'line-height' => '24px'),
					"type" => "typography" ),
					
					
		  array(  "title" => __( "Secondary Body  Font", "brad-framework"),
					"subtitle" => __( "This font will be used on some place that seems to look different from main font", "brad-framework"),
					"id" => "font_secondary",
					"color" => false ,
					"preview" => false ,
					"font-style" => false ,
					"font-weight" => false ,
					"font-size" => false ,
					"font-backup" => true ,
					"line-height" => false ,
					"text-align" => false ,
					"google" => true ,
					"default" => array('font-type' => false , 'font-family' => 'Custom Font One'),
					"type" => "typography" ),			
					
					
            array( "type" => "divide" ,
			       "id"   => "typography_divider"),
				
            array(  "title" => __( "H1 - Headline Font", "brad-framework"),
					"subtitle" => __( "Specify the H1 Headline font properties", "brad-framework"),
					"id"       => "font_h1",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					"text-transform" => true ,
					'letter-spacing' => true ,
					"text-align" => false ,
					"default" => array('font-type' => false  , 'font-family' => 'Custom Font One', 'font-backup' => 'Arial, Helvetica, sans-serif' , 'font-weight' => '400' , 'font-size' => '34px' , 'font-style' => 'normal' ,  'line-height' => '38px','letter-spacing' => '-0.5px' , "text-transform" => 'none'),
					"type"     => "typography" ),  
					
        
					
			 array( "title" => __( "H2 - Headline Font", "brad-framework"),
					"subtitle" => __( "Specify the H2 Headline font properties", "brad-framework"),
					"id" => "font_h2",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					'letter-spacing' => true ,
					"text-transform" => true ,
					"text-align" => false ,
					"default" => array( 'font-type' => false , 'font-family' => 'Custom Font One', 'font-backup' => 'Arial, Helvetica, sans-serif' , 'font-weight' => '400' , 'font-size' => '25px' , 'line-height' => '32px', 'font-style' => 'normal'  , 'letter-spacing' => '0px' , "text-transform" => 'none'),
					"type" => "typography"),  
					
						
					
             array( "title" => __( "H3 - Headline Font", "brad-framework"),
					"subtitle" => __( "Specify the H3 Headline font properties", "brad-framework"),
					"id" => "font_h3",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					"text-align" => false ,
					"text-transform" => true ,
					'letter-spacing' => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Custom Font One', 'font-backup' => 'Arial, Helvetica, sans-serif' , 'font-weight' => '400' , 'font-size' => '21px' , 'line-height' => '30px' , 'font-style' => 'normal' ,'letter-spacing' => '0' , "text-transform" => 'none'),
					"type" => "typography"),  
				

             array( "title" => __( "H4 - Headline Font", "brad-framework"),
					"subtitle" => __( "Specify the H4 Headline font properties", "brad-framework"),
					"id" => "font_h4",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					"text-align" => false ,
					'letter-spacing' => true ,
					"text-transform" => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Custom Font One', 'font-backup' => 'Arial, Helvetica, sans-serif' , 'font-weight' => '400' , 'font-size' => '18px' , 'line-height' => '24px' , 'font-style' => 'normal'  , 'letter-spacing' => '0px' , "text-transform" => 'none'),
					"type" => "typography"),  
					
				
					
			array( "title" => __( "H5 - Headline Font", "brad-framework"),
					"subtitle" => __( "Specify the H5 Headline font properties", "brad-framework"),
					"id" => "font_h5",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					"text-align" => false ,
					'letter-spacing' => true ,
					"text-transform" => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway',"font-backup"=> "Arial, Helvetica, sans-serif" , 'font-weight' => '400' , 'font-size' => '16px' , 'line-height' => '25px' , 'font-style' => 'normal'  , 'letter-spacing' => '0' , "text-transform" => 'none'),
					"type" => "typography"),  
	

            array( "title" => __( "H6 - Headline Font", "brad-framework"),
					"subtitle" => __( "Specify the H6 Headline font properties", "brad-framework"),
					"id" => "font_h6",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					"text-transform" => true ,
					"text-align" => false ,
					'letter-spacing' => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway',"font-backup"=> "Arial, Helvetica, sans-serif" , 'font-weight' => '600' , 'font-size' => '17px' , 'line-height' => '24px' , 'font-style' => 'normal'  , 'letter-spacing' => '1-x' , "text-transform" => 'uppercase'),
					"type" => "typography"), 
					
			
			
			array( "title" => __( "Sidebar Headline Font", "brad-framework"),
					"id" => "font_sidebar_hl",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					"text-align" => false ,
					'letter-spacing' => true ,
					"text-transform" => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway', 'font-backup' => 'Arial, Helvetica, sans-serif' , 'font-weight' => '700' , 'font-size' => '14px' , 'font-style' => 'normal' , 'line-height' => '45px','letter-spacing' => '0' , "text-transform" => 'uppercase'),
					"type" => "typography"),
					
			array(  "title" => __( "Accordion/Toggle & Tabs Font", "brad-framework"),
					"id" => "font_tabs",
					"color" => false ,
					"preview" => false ,
					'font-weight' => true ,
					"font-backup" => true ,
					"text-transform" => true ,
					"letter-spacing" => true ,
					"line-height" => false ,
					"text-align" => false ,
					"google" => true ,
					"default" => array('font-family' => 'Raleway' , 'font-style' => 'normal' , 'font-weight' => '700' , 'text-transform' => "uppercase" , 'font-type' => false ),
					"type" => "typography" ),	
					
		   
		   array(  "title" => __( "Blog Categores & Date font", "brad-framework"),
					"id" => "font_blog",
					"color" => false ,
					"preview" => false ,
					'font-weight' => true ,
					"font-backup" => true ,
					"text-transform" => true ,
					"text-align" => false ,
					'font-size' => true ,
					'letter-spacing' => true,
					"google" => true ,
					"default" => array('font-family' => 'Raleway' , 'font-style' => 'normal' , 'text-transform' => 'uppercase' , 'letter-spacing' => '0.5px' , 'font-size' => '13px' , 'font-weight' => '600' , 'font-type' => false ),
					"type" => "typography" ),	
					
		
		 array(  "title" => __( "Blog Grid Categores & Date font Size", "brad-framework"),
					"id" => "font_blog_grid",
					"color" => false ,
					"type" => "slider",
					"default" => "12" ,
					"min" => "5",
					"max" => "50"),							
					
		
		array(  "title" => __( "Blockquote Font", "brad-framework"),
					"subtitle" => __( "Specify Blockquote font properties", "brad-framework"),
					"id"       => "font_blockquote",
					"color" => true ,
					"preview" => false ,
					"font-backup" => true ,
					"text-transform" => true ,
					'letter-spacing' => true ,
					"text-align" => false ,
					"default" => array('font-type' => false  , 'font-family' => 'Crete Round', 'font-backup' => 'Arial, Helvetica, sans-serif' , 'font-weight' => 'normal' , "font-style" => "italic" , 'font-size' => '21px' , 'line-height' => '31px','letter-spacing' => '0' , "text-transform" => 'none' , 'color' => '#999999' ),
					"type"     => "typography" )			
		) 	
    );
    
	
 $this->sections[] = array(
	'icon' => 'el-icon-minus' ,
	'icon-class' => 'icon-small' ,
	'title' => __('Header Options', "brad-framework") ,
	'desc' => '<p>Customize the main Header Options .</p>' ,
	'fields' => array(
	       
		   
		    array( "title" => __(  "Background Style for Header", "brad-framework"),
            "id" => "bg_style_header",
			"background-attachment" => false ,
            "default" =>array( "background-color" => "#ffffff" , "background-position" => "center center" , "background-repeat" => "no-repeat","background-size" => "cover"  ,"background-image" => false),
            "type" => "background"),
			
			
		    array( 
		    "title" => __( "Header Layout", "brad-framework") ,
            "id" => "header_layout",
            "default" => "type1",
            "type" => "select",
			"multiselect" => false ,
            "options" => array (
			         "type1" => __("Default Header ( Logo on left )","brad-framework"), 
				     "type2" => __("Logo in Center","brad-framework"),
					 "type3" => __("Logo on Top","brad-framework") ,
					 "type4" => __("Header on Left Side","brad-framework"),
					 /*
					 "type5" => __("Header on Right Side","brad-framework")
					 */
            )),
			
		
	
			
		
		array( 
		   "title" => 'Nav Menu Divider',
	       "id"  => "header_bstyle",
		   "default" => "default" ,
		   "options" => array(  'default' => 'Divider on top and bottom' , 'center' => 'Divider In Center', 'no' => 'No Divider' ) ,
		   'required' => array('header_layout','=','type3'),	
		   'type' => 'select'
		 ),	
		 
		 
		 array( 
		   "title" => 'Nav Menu Divider Width',
	       "id"  => "header_dwidth",
		   "default" => "default" ,
		   "options" => array(  'grid' => 'In the Grid' , 'full' => 'Equal to Header Width') ,
		   'required' => array('header_layout','=','type3'),	
		   'type' => 'select'
		 ),	
		   	
		
		  array( 
		    "title" => __( "Header Fullwidth", "brad-framework") ,
	        "subtitle" => __( "Set this option to yes for making header to fullwidth", "brad-framework"),
            "id" => "header_fullwidth",
            "default" => 'no',
            "type" => "select",
			"required" => array("header_layout" , "!=" , array("type4","type5")) ,
			"multiselect" => false ,
            "options" => array ( "no" => "No" , "yes" => "Yes")
			),	

	       array( 
		    "title" => __( "Header Type", "brad-framework") ,
	        "subtitle" => __( "Select the default header type and modify the selected header below", "brad-framework"),
            "id" => "header_type",
            "default" => "solid",
            "type" => "select",
			"required" => array("header_layout" , "!=" , array("type3","type4","type5")) ,
			"multiselect" => false ,
            "options" => array (
			            "solid" => __("Solid Header","brad-framework"), 
				  "transparent" => __("Transparent Header","brad-framework")
            )),
			
			
			array( 
		    "title" => __( "Header Scheme", "brad-framework") ,
            "id" => "header_scheme",
            "default" => "light",
			"required" => array("header_type" , "=" , "transparent") ,
            "type" => "select",
			"multiselect" => false ,
            "options" => array (
			      "light" => __("Light Scheme","brad-framework"), 
				  "dark" => __("Dark Scheme","brad-framework")
            )),


			
			array( "title" => "Header Height",
					"sub_desc" => " Default Header Height in px, Do't include px just numbers",
					"id" => "header_height",
					"default" => '110',
					"min" => '40' ,
					"max" => '400' ,
					"required" => array("header_layout" ,"!=" , array("type4","type5")),
					"type" => "slider"
					),
			
			
			array( "title" => __("Fixed Header", "brad-framework"),
				   "id" => "check_fixed_header",
                   "default" => false ,
				   "required" => array("header_layout" , "!=" , array("type4","type5") ) ,
				   "type" => "switch"),
				   
		   array( "title" => __("Auto offset for shrinked nav", "brad-framework"),
				   "id" => "check_auto_offset",
				   "sub_desc" => "check this field if you want to auto calculate offset for shrinked nav",
                   "default" => true ,
				   "required" => array("check_fixed_header" , "=" , true) ,
				   "type" => "switch"),		   
				   
		   
		   	array( "title" => __("Shrink nav offset", "brad-framework"),
				   "id" => "shrink_nav_offset",
                   "default" => '0' ,
				   "required" => array("check_auto_offset" , "!=" , true) ,
				   "type" => "text"),		    
				   
		   array( "title" => __("Show Second Nav", "brad-framework"),
				   "id" => "show_second_nav",
                   "default" => true ,
				   "required" => array("check_fixed_header" , "!=" , true) ,
				   "type" => "switch"),		
				   
		 array( "title" => __("Second Nav offset", "brad-framework"),
				   "id" => "second_nav_offset",
                   "default" => '0' ,
				   "sub_desc" => 'By default second nav will appear while main nav is completely hidden , to add more offset you can use value  such as \'10\' , do\'t include px' ,
				   "required" => array("show_second_nav" , "=" , true) ,
				   "type" => "text"),				      	   
				   
			
					
			array( "title" => __("Shrinked or second nav height", "brad-framework"),
				   "id" => "shrink_nav_height",
				   'sub_desc' => 'Please note that this field should not be greater than header height' ,
				   "default" => '65',
					"min" => '40' ,
					"max" => '400' ,
				   "type" => "slider"),	  
				   
				   	   			
			array( "title" => __("Show Social Icons in Header", "brad-framework"),
				   "id" => "check_searchicons_header",
                   "default" => false ,
				   "type" => "switch"),
				   	   						
	        array( "title" => __("Social Icons Positon", "brad-framework"),
				   "id" => "si_postion",
                   "required" => array("header_layout" , "=" , "type2") ,
                  "type" => "select",
			      "multiselect" => false ,
                  "options" => array (
			          "right" => __("Right side of the logo","brad-framework"), 
				      "left" => __("Left Side of the Logo","brad-framework")
            )),		
			
			
            array( "title" => __("Show Search Form in Header", "brad-framework"),
				   "id"=>"check_searchform",
                   "default"=>true,
				   "required" => array("header_layout" , "!=" , array("type4","type5")) ,
				   "type"=>"switch"),
				   
				   
			array( "title" => __("Search Icon Positon", "brad-framework"),
				   "id" => "sei_postion",
                   "required" => array("header_layout" , "=" , "type2") ,
                  "type" => "select",
			      "multiselect" => false ,
                  "options" => array (
			          "right" => __("Right side of the logo","brad-framework"), 
				      "left" => __("Left Side of the Logo","brad-framework")
            )),		
			
				   
            array( "type" => "divide",
			       "id" => "header_typorgrapy_divider") ,
				   
				   				
							
             array( "title" => __( "Nav Menu font - first level", "brad-framework"),
					"subtitle" => __( "Nav Menu - first Level Font Settings", "brad-framework"),
					"id"         => "font_nav",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					'letter-spacing' => true ,
					"text-transform" => true ,
					"text-align" => false ,
					"line-height" => false ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway',"font-backup"=> "Arial, Helvetica, sans-serif" , 'font-weight' => '600' , 'font-size' => '12px' , 'letter-spacing' => '1px' ,"text-transform" => "uppercase"),
					"type"       => "typography"),	
							
          																	
             array( "title" => __( "Nav Dropdown Menu font", "brad-framework"),
					"id" => "font_nav_dropdown",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					"text-align" => false ,
					'letter-spacing' => true ,
					"text-transform" => true ,
					"line-height" => false ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway',"font-backup"=> "Arial, Helvetica, sans-serif" , 'font-weight' => '400' , 'font-size' => '13px' , 'letter-spacing' => '0px' , "text-transform" => "none"),
					"type" => "typography"),
					
					
			array( "title" => __( "Nav Dropdown Megamenu font", "brad-framework"),
					"id" => "font_megamenu_dropdown",
					"color" => false ,
					"preview" => false ,
					
					"font-backup" => true ,
					"text-align" => false ,
					'letter-spacing' => true ,
					"text-transform" => true ,
					"line-height" => false ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway',"font-backup"=> "Arial, Helvetica, sans-serif" , 'font-weight' => '600' , 'font-size' => '13px' , 'letter-spacing' => '1px' , "text-transform" => "uppercase"),
					"type" => "typography"),
								
			
		   array( 
		    "title" => __( "Nav Dropdown Style", "brad-framework") ,
            "id" => "dropdown_style",
			"required" => array("header_layout" , "=" , array("type1","type2","type3")),
            "default" => "style1",
            "type" => "select",
			"multiselect" => false ,
            "options" => array (
			         "style1" => __("Style 1","brad-framework"), 
				     "style2" => __("Style 2","brad-framework")
            )),
			
			
			
			
			array( "title" => __( "Phone Number", "brad-framework"),
					"subtitle" => __( "Phone number ( Side Nav)", "brad-framework"),
					"id" => "phone_sidenav",
					"required" => array("header_layout","=", array("type4","type5")),
					"default" => "(+91) 9876543210",
					"type" => "text",
					), 
			
			 array( "title" => __( "Email Id", "brad-framework"),
					"subtitle" => __( "Email Id or Link to show in Side Nav", "brad-framework"),
					"id" => "email_sidenav",
					"required" => array("header_layout","=", array("type4","type5")),
					"default" => "no-reply@envato.com",
					"type" => "text"), 
					
					
            array( "type" => "divide",
			       "id" => "topbar_settings_divider") ,
            
			 array( "title" => __( "Show Topbar", "brad-framework"),
					"subtitle" => __( "Check to show Topbar (Callus Text & Social Media)", "brad-framework"),
					"id" => "show_topbar",
					"default" => false,
					"type" => "switch" ), 
			
			
			array( "title" => __( "Top Bar left content", "brad-framework"),
					"subtitle" => __( "Select content type form the list you want to display on left side of topbar", "brad-framework"),
					"id" => "topbar_left_content",
					"default" => 'contactinfo' ,
					"required" => array("show_topbar","=",1),
					"type" => "select",
					'multiselect' => false ,
					"options" => array(
					    "contactinfo" => 'Contact Info' ,
						"topmenu" => 'Top Navigation Menu' ,
						"socialicons" => 'Social Icons',
						'none' => 'Nothing' )
						),
						
			array( "title" => __( "Top Bar Right content", "brad-framework"),
					"subtitle" => __( "Select content type form the list you want to display on right side of topbar", "brad-framework"),
					"id" => "topbar_right_content",
					"default" => 'socialicons',
					"required" => array("show_topbar","=",1),
					"type" => "select",
					'multiselect' => false ,
					"options" => array(
					    "contactinfo" => 'Contact Info' ,
						"topmenu" => 'Top Navigation Menu' ,
						"socialicons" => 'Social Icons',
						'none' => 'Nothing' )
						),			 
			
			
             array( "title" => __( "Phone Number", "brad-framework"),
					"subtitle" => __( "Phone number to show in Topbar", "brad-framework"),
					"id" => "phone_topbar",
					"required" => array("show_topbar","=",1),
					"default" => "(+91) 9876543210",
					"type" => "text",
					), 
			
			 array( "title" => __( "Email Id", "brad-framework"),
					"subtitle" => __( "Email Id or Link to show in Topbar", "brad-framework"),
					"id" => "email_topbar",
					"required" => array("show_topbar","=",1),
					"default" => "no-reply@envato.com",
					"type" => "text"), 	
			
			/*		
			array( "title" => __( "Location", "brad-framework"),
					"subtitle" => __( "Location", "brad-framework"),
					"id" => "location_topbar",
					"required" => array("show_topbar","=",1),
					"default" => "no-reply@envato.com",
					"type" => "text"), 				
			*/	
			
			 array( "type" => "divide",
			       "id" => "titlebar_settings_divider") ,
				   		
             array( "title" => __( "Hide Titlebar On All Standard Pages including homepage", "brad-framework"),
					"subtitle" => 'This option will hide titlebar on all pages and override the settigs on page header/titlebar option.',
					"id" => "hide_titlebar",
					"default" => false,
					"type" => "switch" ), 
					
					
			array( "title" => __( "Hide Titlebar On All Posts", "brad-framework"),
					"id" => "hide_titlebar_posts",
					"default" => false,
					"type" => "switch" ), 	
					

			
			array( "title" => __( "Hide Titlebar On All Portfolios/Projects", "brad-framework"),
					"id" => "hide_titlebar_portfolio",
					"default" => false,
					"type" => "switch" ), 				
			
			array( "title" => __( "Hide Titlebar On All Woocommerce products", "brad-framework"),
					"id" => "hide_titlebar_products",
					"default" => false,
					"type" => "switch" ), 			
					
					
			 array( "title" => __( "Titlebar Background", "brad-framework"),
					"id" => "bg_titlebar",
					"background-attachment" => false ,
					"default" => array("background-color" => "#f7f7f7" , "background-image" => false , "background-size" => "cover" , "background-position" => "left top" , "background-repeat" => "no-repeat" ),
					"subtitle"  => "You can overide these option under page settings for each page , post or portfolio" ,
					"type" => "background"), 
					
		  array( "title" => 'Titlebar Background overlay color',
			   	   "id"  => 'titlebar_bgo_color',
				   "default" => '' ,
				   "type" => "color" ) ,
		  
		  
		  array( "title" => 'Titlebar Background overlay opacity',
			   	   "id"  => 'titlebar_bgo_opacity',
				   "default" => 1 ,
				   "type" => "text" )
				  ,		

		 array( "title" => __( "Enable Parallax", "brad-framework"),
				"subtitle" => 'Autoadjust the height on different screens.',
				"id" => "titlebar_parallax",
				"default" => 'no' ,
				 
				"options" => array( 'yes' => 'Yes' , 'no' => 'No') ,
				"type" => "select" ),
				
	    
		array( "title" => __( "Enable titlebar Border", "brad-framework"),
				"id" => "titlebar_border",
				"default" => 'yes' ,
				 
				"options" => array( 'yes' => 'Yes' , 'no' => 'No') ,
				"type" => "select" ),			
				
							
		  array( "title" => __( "Titlebar Horizental Text Alignment", "brad-framework"),
					"id" => "titlebar_alignment",
					"type" => "select",
					"multiselect" => false ,
					"default" => "justify" ,
					"options" => array("justify" => "justify" , "center" => "center" ) ), 
					
		 
		 array( "title" => __( "Titlebar Vertical Text Alignment", "brad-framework"),
					"id" => "titlebar_valignment",
					"type" => "select",
					"multiselect" => false ,
					"default" => "center" ,
					"options" => array("top" => "top" , "center" => "center" ,"bottom" => "bottom" ) ), 
					
		
					
		  array( "title" => __( "Titlebar Text Size", "brad-framework"),
					"id" => "titlebar_text_size",
					"type" => "select",
					 
					"multiselect" => false ,
					"default" => "normal" ,
					"options" => array("normal" => "normal" , "medium" => "medium" , "large" => "large" ) ), 
					
		 
		 
		
 			
		 array( "title" => __( "Titlebar Height in px", "brad-framework"),
				"id" => "titlebar_height",
				"type" => "slider",
				"min" => 50 ,
				"max" => 1000 ,
				"multiselect" => false ,
				"default" => '80') ,
		
		 array( "title" => __( "Responsive Height", "brad-framework"),
				"subtitle" => 'Autoadjust the height on different screens.',
				"id" => "rs_height",
				"default" => 'yes',
				 
				"options" => array( 'yes' => 'Yes' , 'no' => 'No') ,
				"type" => "select" ),
				 
										
					
		 array( "title" => __( "Titlebar Text Color Scheme", "brad-framework"),
				"id" => "titlebar_scheme",
				 
				"type" => "select",
				"default" => 'dark' ,
				"multiselect" => false ,
				"options" => array("dark" => "dark" , "light" => "light" ))
				, 											
		
		 array( "title" => __( "Show Breadcrumbs", "brad-framework"),
				"id" => "titlebar_breadcrumb",
				 
				"default" => 'yes' ,
				"type" => "select" ,
				"multiselect" => false ,
				"options" => array("yes" => "yes" , "no" => "no" )), 		
					
         array( "title" => __( "Titlebar Headline Font:Common", "brad-framework"),
				"id" => "font_titlebarheadline",
				"preview" => false ,
				"line-height" => false ,
				"font-size" => false,
				"letter-spacing" => false ,
				"text-align" => false ,
				'text-transform' => false ,
				"color" => false ,
				"default" => array('font-type' => false , 'font-family' => 'Custom Font One',"font-style" => "normal"  ,'font-weight' => '400' ),
				"type" => "typography"), 
				
	 
	     array( "title" => __( "Subtitle Font", "brad-framework"),
				"id" => "font_titlebarsubtitle",
				"preview" => false ,
				"line-height" => false ,
				"font-size"  => false ,
				"letter-spacing" => true ,
				"text-align" => false ,
				"text-transform" => true ,
				"color"  => false , 
				"default" => array(  'font-family' => 'Raleway' , 'font-type' => false , "font-weight" => 'normal' , 'font-style' => 'normal' ,  "text-transform" => "uppercase"  ,'letter-spacing' => '1px' ),
				"type" => "typography")						
		 )
);


$this->sections[] = array(
	'icon' => 'el-icon-error-alt' ,
	'icon-class' => 'icon-small' ,
	'title' => __('Footer Options', "brad-framework") ,
	'desc' => '<p>Customize The Main Footer Options</p>' ,
	'fields' => array(
		 array( "title" => __( "Footer Font Size (in px)", "brad-framework"),
			        "id" => "fontsize_footer",
			        "default" => 14,
					"min" => 10,
					"max" => 20 ,
			        "type" => "slider"), 
					
					
	    array( "title" => __( "Footer Line Height (in px)", "brad-framework"),
			        "id" => "lineheight_footer",
			        "default" => 24,
					"min" => 10,
					"max" => 40 ,
			        "type" => "slider"), 								
			
					
	 
	   array( "title" => __( "Enable  Footer widgets Area1", "brad-framework"),
					"subtitle" => __( "Check to show widgetized Footer.", "brad-framework"),
					"id" => "check_footerwidgets",
					"default" => 1,
					"type" => "switch" ),
					
					
	    array( "title" => __( "Footer Widget Area1 Background Color", "brad-framework"),
			        "id" => "color_footerbg",
					"required" => array("check_footerwidgets" , "=" , true) ,
			        "default" => "#262626",
			        "type" => "color"), 				
		
	   array( "title" => 'Top Border For Footer Widget Area1',
	       "id"  => "footer_border",
		   "default" => array( "border-top" => "0" , "border-style" => "" , "border-color" => ""  ) ,
		   "required" => array("check_footerwidgets" , "=" , true) ,
		   'type' => 'border' ),	
		   
		   			
	   array( "title" => __( "Footer Widget Area1 Text Color", "brad-framework"),
			       "id" => "color_footertext",
			       "default" => "#999999",
				   "required" => array("check_footerwidgets" , "=" , true) ,
			       "type" => "color"), 
				   
		array( "title" => __( "Footer Widget Area1 Divider Color", "brad-framework"),
			       "id" => "color_footerdivider",
			       "default" => "#555555",
				   "required" => array("check_footerwidgets" , "=" , true) ,
				   "subtitle" => __("Footer Divider Color Used In various widget places","brad-framework"),
			       "type" => "color"), 		  
				   
				   
		array( 
		          "title" => __( "Footer Widget Area1 Columns", "brad-framework") ,
                  "id" => "footer_columns",
                  "default" => "4",
				  "required" => array("check_footerwidgets" , "=" , true) ,
                  "type" => "select",
			      "multiselect" => false ,
                  "options" => array (
				        "1" => __("One","brad-framework"),
			            "2" => __("Two","brad-framework"), 
				        "3" => __("Three","brad-framework"),
						"4" => __("Four","brad-framework"),
						"5" => __("Five","brad-framework")
            )),
					   
		
		 array( "title" => __( "Footer Widget Area1 Headline", "brad-framework"),
					"id" => "font_footerheadline",
					"preview" => false ,
					"required" => array("check_footerwidgets" , "=" , true) ,
					"font-backup" => true ,
					'letter-spacing' => true ,
					"text-align" => false ,
					"line-height" => true ,
					'text-transform' => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway',"font-style" => "normal"  ,'font-weight' => '700', 'font-size' => '14px' ,'letter-spacing'=> '1px','font-backup' => 'Arial, Helvetica, sans-serif' , 'color' => '#ffffff' , 'text-transform' => 'uppercase' , "line-height" => "35px" ),
					"type" => "typography"),
					
		array( "title" => __( "Footer Widget Area1 Headline Bg Color", "brad-framework"),
			        "id" => "font_footerheadline_bg",
			        "default" => "transparent",
					"required" => array("check_footerwidgets" , "=" , true) ,
			        "type" => "color"), 
					
								
		array( "title" => __( "Footer Widget Area1 Link Color", "brad-framework"),
			       "id" => "color_footerlink",
			       "default" => "#cccccc",
				   "required" => array("check_footerwidgets" , "=" , true) ,
			       "type" => "color"), 
					
        array( "title" => __( "Footer Widget Area1 Link Hover Color", "brad-framework"),
	    	       "id" => "color_footerlinkhover",
			       "default" => "#ebebeb",
				   "required" => array("check_footerwidgets" , "=" , true) ,
			       "type" => "color"), 	
				   
				   					   
		array( "title" => __( "Enable  Footer widgets Area2", "brad-framework"),
					"subtitle" => __( "Check to show widgetized Footer Area2.", "brad-framework"),
					"id" => "check_footerwidgets2",
					"default" => false ,
					"type" => "switch" ),
					
		array( "title" => 'Top Border For Footer Widget Area2',
	       "id"  => "footer_border2",
		   "default" => array( "border-top" => "0" , "border-style" => "" , "border-color" => ""  ) ,
		   "required" => array("check_footerwidgets2" , "=" , true) ,
		   'type' => 'border' ),
		   
		   			
	    array( "title" => __( "Footer Widget Area2 Background Color", "brad-framework"),
			        "id" => "color_footerbg2",
					"required" => array("check_footerwidgets2" , "=" , true) ,
			        "default" => "#262626",
			        "type" => "color"), 				
					
	   array( "title" => __( "Footer Widget Area2 Text Color", "brad-framework"),
			       "id" => "color_footertext2",
			       "default" => "#999999",
				   "required" => array("check_footerwidgets2" , "=" , true) ,
			       "type" => "color"), 
				   
		array( "title" => __( "Footer Widget Area2 Divider Color", "brad-framework"),
			       "id" => "color_footerdivider2",
			       "default" => "#555555",
				   "required" => array("check_footerwidgets2" , "=" , true) ,
				   "subtitle" => __("Footer Divider Color Used In various widget places","brad-framework"),
			       "type" => "color"), 		  
				   
				   
		array( 
		          "title" => __( "Footer Widget Area2 Columns", "brad-framework") ,
                  "id" => "footer_columns2",
                  "default" => "4",
				  "required" => array("check_footerwidgets2" , "=" , true) ,
                  "type" => "select",
			      "multiselect" => false ,
                  "options" => array (
				        "1" => __("One","brad-framework"),
			            "2" => __("Two","brad-framework"), 
				        "3" => __("Three","brad-framework"),
						"4" => __("Four","brad-framework"),
						"5" => __("Five","brad-framework")
            )),
					   
		
		 array( "title" => __( "Footer Widget Area2 Headline", "brad-framework"),
					"id" => "font_footerheadline2",
					"preview" => false ,
					"required" => array("check_footerwidgets2" , "=" , true) ,
					"font-backup" => true ,
					'letter-spacing' => true ,
					"text-align" => false ,
					"line-height" => true ,
					'text-transform' => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway',"font-style" => "normal"  ,'font-weight' => '500', 'font-size' => '13px' ,'letter-spacing'=> '1px'  , "line-height" => "35px"  ,'font-backup' => 'Arial, Helvetica, sans-serif' , 'color' => '#ffffff' , 'text-transform' => 'uppercase' ),
					"type" => "typography"),
					
					
		array( "title" => __( "Footer Widget Area2 Headline Bg Color", "brad-framework"),
			        "id" => "font_footerheadline_bg2",
					"required" => array("check_footerwidgets2" , "=" , true) ,
			        "default" => "#f5f5f5",
			        "type" => "color"), 
					
								
		array( "title" => __( "Footer Widget Area2 Link Color", "brad-framework"),
			       "id" => "color_footerlink2",
			       "default" => "#cccccc",
				   "required" => array("check_footerwidgets2" , "=" , true) ,
			       "type" => "color"), 
					
        array( "title" => __( "Footer Widget Area2 Link Hover Color", "brad-framework"),
	    	       "id" => "color_footerlinkhover2",
				   "required" => array("check_footerwidgets2" , "=" , true) ,
			       "default" => "#ebebeb",
			       "type" => "color"), 	
		
			
	   array( "title" => __( "Footer Copyright Background Color", "brad-framework"),
			 "id" => "color_bgcopyright",
			 "default" => "#1b1b1b",
			 "type" => "color"), 
	  
	  array( "title" => 'Top Border For Footer Copyright',
	       "id"  => "copyright_border",
		   "default" => array( "border-top" => "0" , "border-style" => "" , "border-color" => ""  ) ,
		   'type' => 'border' ),
		   
		   
	  array( "title" => __( "Footer Copyright Text Color", "brad-framework"),
			       "id" => "color_copyrighttext",
			       "default" => "#999999",
			       "type" => "color"), 
				   
	array( "title" => __( "Footer Copyright Divider Color", "brad-framework"),
			       "id" => "color_copyrightdivider",
			       "default" => "#555555",
			       "type" => "color"), 	
			
	 array( "title" => __( "Footer Copyright Link Color", "brad-framework"),
			       "id" => "color_copyrightlink",
			       "default" => "#cccccc",
			       "type" => "color"), 
					
        array( "title" => __( "Footer Copyright Link Hover Color", "brad-framework"),
	    	       "id" => "color_copyrightlinkhover",
			       "default" => "#ebebeb",
			       "type" => "color"), 			   
				   		 
							  
	   array( "title" => __( "Footer Copyright Section right content", "brad-framework"),
			  "id" => "footer_rightcontent",
			   "multiselect" => false ,
			   "default" => "menu" ,
			   "options" => array (
				  "menu" => __("Menu","brad-framework"), 
				  "social" => __("Social Ions","brad-framework"),
				  "top" => __("Go to Top Button","brad-framework"),
				  "none" => __("None","brad-framework") ) ,
			  "type" => "select" ) 
	  ,
    
	
	
			  
	  array( "title" => __( "Copyright Text", "brad-framework"),
			  "subtitle" => __( "Enter your Copyright Text (HTML allowed)", "brad-framework"),
			  "id" => "textarea_copyright",
			  "default" => "Aperio v1.0 by <a href='http://themeforest.net/user/bradweb'>bradweb</a>",
			  "type" => "textarea")
			  )
				);
	
$this->sections[] = array(
		'icon' => 'el-icon-brush',
		'icon_class' => 'icon-small',
        'title' => __('Styling', "brad-framework"),
		'desc' => '<p>Customize  the Colors for body , menu , headings Etc.</p>' ,
        'fields' => array(
		     array( "title" => __( "Primary Color", "brad-framework"),
					"id" => "color_primary",
					"default" => "#3498db",
					"type" => "color"), 

 		     array( "title" => __( "Link Color", "brad-framework"),
					"id" => "color_link",
					"default" => "#3498db",
					"type" => "color"), 
					
 		     array( "title" => __( "Link Hover Color", "brad-framework"),
					"id" => "color_hover",
					"default" => "#2d2d2d",
					"type" => "color"), 
					
			 array( "type" => "divide",
		      "id" => "main_body_style_divider") ,		
	
		     array( "title" => __( "Main Body  Font Color", "brad-framework"),
					"id" => "font_body_color",
					"default" => '#818181',
					"type" => "color"),
			
			 array( "title" => __( "H1 Color", "brad-framework"),
					"id" => "font_h1_color",
					"default" => '#2d2d2d',
					"type" => "color"),		
			
			 array( "title" => __( "H2 Color", "brad-framework"),
					"id" => "font_h2_color",
					"default" => '#2d2d2d',
					"type" => "color"),					
			
			 array( "title" => __( "H3 Color", "brad-framework"),
					"id" => "font_h3_color",
					"default" => '#2d2d2d',
					"type" => "color"),	
					
			array( "title" => __( "H4 Color", "brad-framework"),
					"id" => "font_h4_color",
					"default" => '#2d2d2d',
					"type" => "color"),
					
			array( "title" => __( "H5 Color", "brad-framework"),
					"id" => "font_h5_color",
					"default" => '#999999',
					"type" => "color"),
					
			array( "title" => __( "H6 Color", "brad-framework"),
					"id" => "font_h6_color",
					"default" => '#666666',
					"type" => "color"),												
		
		
		 array( "type" => "divide",
		         "id" => 'style_sidebar_headline_divider') ,
				 
				 			
		  array( "title" => __( "Sidebar Headline color", "brad-framework"),
			     "id" => "color_sidebar_hl",
				 "default" => '#2d2d2d' ,
				 "type" => "color"),
				 
		 array( "title" => __( "Sidebar Headline Bg color", "brad-framework"),
			     "id" => "bgcolor_sidebar_hl",
				 "default" => '#f6f6f6' ,
				 "type" => "color"),		    
					
		
	
	   array( "type" => "divide",
		         "id" => 'style_nav_divider') ,
				 
		 
		array( "title" => __( "Topbar Background color", "brad-framework"),
				"id" => "topbar_bg_color",
				"default" => '#ffffff',
				"type" => "color"),	 
				
		array( "title" => __( "Topbar Border color", "brad-framework"),
				"id" => "topbar_border_color",
				"default" => '#e8e8e8',
				"type" => "color"),	 		
	   
	   array( "title" => __( "Topbar Font color", "brad-framework"),
				"id" => "topbar_font_color",
				"default" => '#bbbbbb',
				"type" => "color"),	 
				
	    array( "title" => __( "Topbar Link color", "brad-framework"),
				"id" => "top_link_color",
				"default" => '#999999',
				"type" => "color"),	 
				
				
	array( "title" => __( "Topbar Links  color:hover", "brad-framework"),
				"id" => "top_link_color_hover",
				"default" => '#3498db',
				"type" => "color"),	 
				
				
		array( "title" => __( "Topbar Dividers Color", "brad-framework"),
				"id" => "topbar_ci_divi",
				"default" => '#e8e8e8',
				"type" => "color"),	
			
				 
	    array( "type" => "divide",
		      "id" => "nav_style_divider") ,
	 																					
															
		 array( "title" => __( "Nav Menu font color - first level", "brad-framework"),
				"id" => "font_nav_color",
				"default" => '#555555',
				"type" => "color"),	  
										
 		  array( "title" => __( "Nav Menu font Color on hover", "brad-framework"),		
				    "id" => "nav_font_hover_color",
			   "default" => "#2d2d2d",
				  "type" => "color"),	
				 
		array( "title" => __( "Nav Active Menu font Color", "brad-framework"),		
				  "id" => "nav_font_active_color",
		     "default" => "#3498db",
				"type" => "color"),
				  	
			  
		array( "title" => __( "Nav Dropdown  Background color", "brad-framework"),		
				"id" => "dropdown_background_color",
				"default" => "#fafafa",
				 "required" => array("header_layout" ,"!=" , array("type4","type5")),
				"type" => "color"),	
				
		array( "title" => __( "Top Nav Dropdown  Background Opacity", "brad-framework"),		
				"id" => "dropdown_background_opacity",
				"default" => "0.99",
				 "required" => array("header_layout" ,"!=" , array("type4","type5")),
				"type" => "text" ),	
				
							
		array( "title" => __( "Nav Dropdown  Border color", "brad-framework"),		
				"id" => "dropdown_border_color",
				"default" => "#3498db",
				 "required" => array("header_layout" ,"!=" , array("type4","type5")),
				"type" => "color"),
				
	   					
					
       array( "title" => __( "Nav 2nd  & 3rd level Menu font Color", "brad-framework"),
			  "id" => "font_dropdown_color",
			  "default" => '#888888',
			  "type" => "color"),
			  
	/*
	  array( "title" => __( "Nav Dropdown Menu Bottom Border Color", "brad-framework"),
			  "id" => "dropdown_menu_border_color",
			  "default" => 'transparent',
			  "type" => "color"),
	*/
		  	
	  array( "title" => __( "Top Nav  MegaMenu Title Color", "brad-framework"),
			  "id" => "megamenu_title_color",
			  "required" => array("header_layout" ,"!=" , array("type4","type5")),
			  "default" => '#343434',
			  "type" => "color"),	
			  
	 array( "title" => __( "Nav Dropdown Megamenu Divider color", "brad-framework"),		
				"id" => "megamenu_di_color",
				"default" => "#f0f0f0",
				 "required" => array("header_layout" ,"!=" , array("type4","type5")),
				"type" => "color"),		  			  	
			  
	   array( "title" => __( "Nav 2nd  & 3rd level Active Menu font Color", "brad-framework"),
			  "id" => "font_dropdown_active_color",
			  "default" => '#454545',
			  "type" => "color"),			  
							
       array( "title" => __( "Nav 2nd  & 3rd level Menu font Color : hover", "brad-framework"),		
			  "id" => "dropdown_font_hover_color",
			  "default" => "#3498db",
			  "type" => "color"),	
			  
	  	array( "title" => __( "Nav 2nd  & 3rd level  Menu Background Color : hover", "brad-framework"),
			  "id" => "dropdown_bg_color_hover",
			  "default" => 'transparent',
			   "required" => array("header_layout" ,"!=" , array("type4","type5")),
			  "type" => "color"),
		
	 
	  array( "title" => __( "Side Nav Dividers Colors", "brad-framework"),
			  "id" => "sidenav_divi_color",
			  "default" => '#dddddd',
			  "required" => array("header_layout" ,"=" , array("type4","type5")),
			  "type" => "color"),	

			    
	array( "title" => __( "Side Nav Email & Phone Area Color", "brad-framework"),
			  "id" => "sidenav_ex_color",
			  "required" => array("header_layout" ,"=" , array("type4","type5")),
			  "default" => '#999999',
			  "type" => "color"),
			  
	array( "title" => __( "Side Nav Email & Phone Area Icon Color", "brad-framework"),
			  "id" => "sidenav_ex_iconcolor",
			  "default" => '#454545',
			  "required" => array("header_layout" ,"=" , array("type4","type5")),
			  "type" => "color"),		  			  	  
		 		 
				 
		array( "type" => "divide",
		      "id" => "exnav_style_divider") ,		 		 
				 
		
		array( "title" => __( "Nav Menu Icons color ", "brad-framework"),
	          "subtitle"  => 'Color for social icons , search icon and cart icon in nav menu',
			  "id" => "color_ex_header",
			  "default" => '#454545',
			  "type" => "color"),
			  
			  
	    array( "title" => __( "Nav Menu Icons Background color ", "brad-framework"),
			  "id" => "bg_ex_header",
			  "default" => 'transparent',
			  "type" => "color"),
			  		  
			  
	    array( "title" => __( "Header Extra Icon color:hover ", "brad-framework"),
			  "id" => "color_ex_header_hover",
			  "default" => '#3d3d3d',
			  "type" => "color"),			 
	 			 								
												
	    array( "title" => __( "Nav Menu Icons Background color :hover ", "brad-framework"),
			  "id" => "bg_ex_header_hover",
			  "default" => 'transparent',
			  "type" => "color"),										
						
  
	
	   array( "type" => "divide",
		      "id" => "woocmerce_cart_divider") , 	  
			    		  	
	   array( "title" => __( "Header Woocommerce cart background color", "brad-framework"),
			  "id" => "bg_woocart",
			  "default" => '#ffffff',
			  "type" => "color"),	
			  
	   array( "title" => __( "Header Woocommerce cart Opacity", "brad-framework"),		
				"id" => "woo_bg_opacity",
				"default" => "0.98",
				"type" => "text" ),	
				
	 array( "title" => __( "Woocommerce cart Dividers color", "brad-framework"),
			  "id" => "divi_woocart",
			  "default" => '#e8e8e8',
			  "type" => "color"),					  
				
	 array( "title" => __( "Woocommerce cart Text color", "brad-framework"),
			  "id" => "color_woocart",
			  "default" => '#999999',
			  "type" => "color"),
			  
	 
	array( "title" => __( "Woocommerce cart link & Buttons color", "brad-framework"),
			  "id" => "color_woolink",
			  "default" => '#454545',
			  "type" => "color"),
			  
	array( "title" => __( "Woocommerce cart link & Buttons color:hover", "brad-framework"),
			  "id" => "color_woolink_hover",
			  "default" => '#3498db',
			  "type" => "color"),		  		  			
			  
			  		  
									
	array( "type" => "divide",
		      "id" => "dropdown_style_divider") ,

		   	
	array( "title" => __( "Primary Button Background Color", "brad-framework"),
	       "id" => "color_buttonbg",
		   "default" => "#3498db",
 		   "type" => "color"), 
							
	array( "title" => __( "Primary Button Text color", "brad-framework"),
		   "id" => "color_buttontext",
		   "default" => "#ffffff",
		   "type" => "color"), 
		  
    array( "type" => "divide",
		      "id" => "overlay_style_divider") ,

		   	
	array( "title" => __( "Overlay Background Color", "brad-framework"),
	       "id" => "bg_overlay",
		   "default" => "#fcfcfc",
 		   "type" => "color"),
		   
	array( "title" => __( "Overlay Background Opacity", "brad-framework"),
	       "id" => "bg_overlay_opacity",
		   "default" => "0.9",
 		   "type" => "text"),	    
							
	array( "title" => __( "Overlay content color", "brad-framework"),
		   "id" => "color_overlay",
		   "default" => "#3d3d3d",
		   "type" => "color"), 
		   
    array( "title" => __( "Overlay content headings color", "brad-framework"),
		   "id" => "color_overlay_heading",
		   "default" => "#2d2d2d",
		   "type" => "color"), 	
		   
	array( "title" => __( "Overlay Icon Background color", "brad-framework"),
		   "id" => "bg_overlay_icon",
		   "default" => "#3498db",
		   "type" => "color"), 	
		   
   array( "title" => __( "Overlay Icon Color", "brad-framework"),
		   "id" => "color_overlay_icon",
		   "default" => "#ffffff",
		   "type" => "color"), 			   	   	   
   )  
 );
		  
	
   		  
	
$this->sections[] = array(
	'icon' => 'el-icon-comment',
	'icon_class' => 'icon-small',
    'title' => __('Blog settings', "brad-framework"),
	'desc' => '<p>Customize the Blog settings .</p>' ,
	'fields' => array(
	   array( "title" => __( "Blog Title", "brad-framework"),
			  "id" => "blog_title",
			  "default" => "Latest News",
			  "type" => "text"),

					
         array( "title" => __( "Blog Type", "brad-framework"),
				"id" => "blog_type",
				"default" => "standard",
				"type" => "select",
				"multiselect" => false ,
				"options" => array(
				  'standard' => 'Standard Blog',
				  'grid' =>  'Grid Blog'
				  )
				  ),	
				  
	   array( "title" => __( "Default Blog Layout", "brad-framework"),
			  "subtitle" => __( "Select the default layout . This will be same for post display page", "brad-framework"),
			  "id" => "blog_layout",
			  "default" => "sidebar",
		      "type" => "select",
			  "multiselect" => false ,
			  "options" => array(
				    'sidebar'   => 'Blog With Sidebar', 
					'fullwidth' =>  'Blog Without Sidebar' )
					),	
	              
         array( "title" => __( "Blog Sidebar Position", "brad-framework"),
				"subtitle" => __( "Blog Listing Sidebar Position if Blog Layout Selected to Blog With Sidebar", "brad-framework"),
				"id" => "select_blogsidebar",
			    "default" => "sidebar-right",
				'required' => array('blog_layout','=','sidebar'),
				"type" => "select",
				"multiselect" => false ,
				"options" => array( 
				     'sidebar-right'=>'sidebar-right' , 
					 'sidebar-left' => 'sidebar-left'
					 )
				),	
						  
		 array( "title" => __( "Grid Blog Columns ?", "brad-framework"),
				"subtitle" => __( "If Blog Type selected to Grid Blog", "brad-framework"),
				"id" => "grid_blog_columns",
				"default" => "3",
				"type" => "select",
				"multiselect" => false ,
				'required' => array('blog_type','=','grid'),
				"options" => array(
				    '2' => 'Two columns',
				    '3' => 'Three Columns', 
				    '4' => 'Four Columns',
					'5' => 'Five Columns',
					'6' => 'Six Columns')
				  ),
				  
	 array(
      "type" => "select",
      "title" => __("Horizental Whitespace Between Grid Elements? ", "brad-framework"),
      "id" => "blog_padding",
	  "default" => "medium",
	  'required' => array('blog_type','=','grid'),
	  "options" => Array( 
	     "medium"  => "40px (Default)" ,
		 "large"   => "60px" ,
		 "large2"  => "50px" ,
		 "medium2" => "30px"  ,
		 "small"   => "20px"  ,
		 "small2"  => "10px" ,
		 "narrow"  => "4px" ,
		 "no"      => "0px" ) 	
	),
	
	array(
      "type" => "select",
      "title" => __("Vertical Whitespace Between Grid Elements? ", "brad-framework"),
      "id" => "blog_vpadding",
	  "default" => "medium",
	  'required' => array('blog_type','=','grid'),
	  "options" => Array( 
	     "medium"  => "40px (Default)" ,
		 "large"   => "60px" ,
		 "large2"  => "50px" ,
		 "medium2" => "30px"  ,
		 "small"   => "20px"  ,
		 "small2"  => "10px" ,
		 "narrow"  => "4px" ,
		 "no"      => "0px" ) 	
	),
	
	
	array(
      "type" => "select",
      "title" => __("Blog Heading Align  ? ", "brad-framework"),
      "id" => "blog_align",
	  "default" => "top",
	  'required' => array('blog_type','=','standard'),
	  "options" => Array( 
	     "top" => "Top of image"  ,
		 "bottom" => "Bottom of Image" 
	)
	),
	
	array(
      "type" => "select",
      "title" => __("Blog Heading Text Align? ", "brad-framework"),
      "id" => "blog_upper_align",
	  "default" => "center",
	  'required' => array('blog_type','=','standard'),
	  "options" => Array( 
	     "center" => "center"  ,
		 "left" => "left" ,
		 "right"  => "right" 
	)
	),
	
	
	array( "title" => __( "Enable Max. Width for Blog Entries content", "brad-framework"),
				"id" => "blog_maxwidth",
			    "default" => "yes",
				"subtitle" => "This option will set maxwidth(940px) on the blog excerpt and  metedata" , 
				'required' => array('blog_type','=','standard'),
				"type" => "select",
				"multiselect" => false ,
				"options" => array( 
				     'yes'=>'yes' , 
					 'no' => 'no'
					 )
		 ),	
				
				  
				  
	   array( "title" => __( "Blog Masonry Layout", "brad-framework"),
				"id" => "blog_masonryr",
			    "default" => "yes",
				'required' => array('blog_type','=','grid'),
				"type" => "select",
				"multiselect" => false ,
				"options" => array( 
				     'yes'=>'yes' , 
					 'no' => 'no'
					 )
				),				  
	
		
	  array(
        "type" => "select",
        "title" =>  __("Blog Pagination", "brad-framework"),
        "id" => "blog_pagination",
	    "multiselect" => false ,
	    "required" => array("blog_type","=","grid"),
	    "default" => "default",
        "options" => array(
		              'default' => __('Standard Pagination','brad-framework') ,
	                 'ifscroll' => __('Infinite Scroll','brad-framework') ,
					 'loadmore' => __('Load More Button','brad-framework') ,
					       'no' => __('No Pagination','brad-framework') )
			     )
      ,
	  
	  array(
        "type"     => "select",
        "title" =>  __("Background Style for Grid Blog ?", "brad-framework"),
        "id"       => "grid_blog_style",
		"default"  => "default",
	    "subtitle" => __("This will help you to match  background color blog item with parent","brad-framework"),
	    "options"  => Array(
	                  "" => __( "Transparent" , "brad-framework" ) ,
				"stroke" => __( "Transparent with Stroke" , "brad-framework" )  ,
		         "white" => __( "White" , "brad-framework" ) ,
		          "grey" => __("White Smoke" , "brad-framework") )	   
	  )
	  ,
	  
	
	  array(  "title" => __( "Enable Automatic Excerpts", "brad-framework"),
			   "subtitle" => __( "Check to create automatically excerpt for Standard Blog Type. This options is not available for except standard blog", "brad-framework"),
			   "id" => "check_excerpts",
			   "default" => 1 ,
			   "type" => "switch",
			   'required' => array('blog_type','=','standard')),  
	
	  array(  "title" => __( "Enable 'Read More' Button", "brad-framework"),
			   "subtitle" => __( "Check to enable 'Read More' button on blog entries if automatic experts are on", "brad-framework"),
			   "id" => "check_readmore",
			   "default" => 1,
			   "type" => "switch"), 		   	
			   			    			 
       array( "title" => __( "Blog Excerpt Length", "brad-framework"),
			  "subtitle" => __( "Default: 40. Used for blog entries page , archives & search results.", "brad-framework"),
			  "id" => "text_excerptlength",
			  "default" => "40",
			  "type" => "text"), 				
					
       array( "title" => __( "Show Categories", "brad-framework"),
			  "subtitle" => __( "Check to show 'Categories' on blog entries.", "brad-framework"),
			  "id" => "check_blog_categories",
			  "default" => 1,
			  "type" => "switch"),
			  
	  array( "title" => __( "Show No of Comments", "brad-framework"),
			  "id" => "check_blog_comments",
			  "default" => 1,
			  "type" => "switch"),		  
		
	  array(  "title" => __( "Enable Loveit", "brad-framework"),
			   "id" => "check_postlove",
			   "default" => 1,
			   "type" => "switch"), 
			   		  
	  array( "title" => __( "Show Author in Blog Entries", "brad-framework"),
			  "subtitle" => __( "Check to show 'Author' on blog entries.", "brad-framework"),
			  "id" => "check_author",
			  "default" => 1,
			  "type" => "switch"),	
			  
	  array( "title" => __( "Show Date", "brad-framework"),
			  "subtitle" => __( "Check to show 'date' on blog entries.", "brad-framework"),
			  "id" => "check_blog_date",
			  "default" => 1,
			  "type" => "switch"),		  

    array(
      "type" => "text",
      "title" => __("Text on the load more button", "brad-framework"),
      "id" => "blog_lm_title",
      "default" => __("Load More", "brad-framework"),
      "subtitle" => __("Text on the load More button.", "brad-framework"),
	  'required' => array('blog_pagination' ,'=' , 'loadmore')
    ),
 	    
       array( "title" => __( "Enable Author Info on Post Detail", "brad-framework"),
			   "subtitle" => __( "Check to enable Author Info", "brad-framework"),
			   "id" => "check_authorinfo",
			   "default" => 1,
			   "type" => "switch"  ), 

       array(  "title" => __( "Enable Related Posts on Post Detail", "brad-framework"),
				"subtitle" => __( "Check to enable Related Posts", "brad-framework"),
				"id" => "check_relatedposts",
				"default" => 1,
				"type" => "switch"), 
				
	
	 array( "title" => __( "Show Post Tags in Post Detail", "brad-framework"),
			 "id" => "check_tags",
			 "default" => 1,
			 "type" => "switch" ),
			 
			 
	  array( "title" => __( "Related Posts Number", "brad-framework"),
			 "subtitle" => __( "Maxmium Related Posts to display on Single Page", "brad-framework"),
			 "id" => "blog_relatedpostsnumber",
			 "default" => "10",
			 "type" => "text"),			
					
      array( "title" => __( "Enable Share-Box on Blog Enteries", "brad-framework"),
			 "id" => "check_blogshare",
			 "default" => 1,
			 "type" => "switch" ),
					
      array( "title" => __( "Enable Share-Box on Post Detail", "brad-framework"),
			 "subtitle" => __( "Check to enable Share-Box", "brad-framework"),
			 "id" => "check_sharebox",
			 "default" => 1,
			 "type" => "switch" ), 
 
     array( "title" => __( "Enable Google +  in Social Sharing Box", "brad-framework"),
			"subtitle" => __( "Check to enable Google in Social Sharing Box", "brad-framework"),
			"id" => "check_sharingboxgoogle",
			"default" => 1,
			"type" => "checkbox" ), 
										
     array( "title" => __( "Enable Facebook in Social Sharing Box", "brad-framework"),
			"subtitle" => __( "Check to enable Facebook in Social Sharing Box", "brad-framework"),
			"id" => "check_sharingboxfacebook",
			"default" => 1,
			"type" => "checkbox" ), 
					
    array( "title" => __( "Enable Twitter in Social Sharing Box", "brad-framework"),
		   "subtitle" => __( "Check to enable Twitter in Social Sharing Box", "brad-framework"),
		   "id" => "check_sharingboxtwitter",
		   "default" => 1,
		   "type" => "checkbox" 
		   ), 
					
  array(  "title" => __( "Enable LinkedIn in Social Sharing Box", "brad-framework"),
		  "subtitle" => __( "Check to enable LinkedIn in Social Sharing Box", "brad-framework"),
		  "id" => "check_sharingboxlinkedin",
		  "default" => 1,
	 	  "type" => "checkbox"  ), 
					
  array( "title" => __( "Enable Pinterest in Social Sharing Box", "brad-framework"),
		 "subtitle" => __( "Check to enable Pinterset in Social Sharing Box", "brad-framework"),
		 "id" => "check_sharingboxpinterest",
		 "default" => 1,
		 "type" => "checkbox" )
		)
	);	
	

$this->sections[] = array(
	
	'icon' => 'el-icon-th-large',
	'icon_class' => 'icon-small',
    'title' => __('Portfolio settings', "brad-framework"),
	'desc'  => 'Customize the portfolios to look on archive page  and in the related projects section for single portfolio page',
	'fields' => array(
	 
	   array(
                'id' => 'portfolio_rewriteslug', 
                'type' => 'text', 
                'title' => __('Custom Slug', "brad-framework"),
                'sub_desc' => __('If you want your portfolio post type to have a custom slug in the url, please enter it here. <br /><b>Note:</b>After Saving this option , refresh your permalinks just by going to Settings > Permalinks and clicking save.', "brad-framework"),
                'desc' => ''
			), 
			
		
		array(
                'id' => 'portfolio_cat_rewriteslug', 
                'type' => 'text', 
                'title' => __('Custom Slug for portfolio category', "brad-framework"),
                'desc' => ''
			), 		
			
			
	    array(
                'id' => 'portfolio_item', 
                'type' => 'text', 
                'title' => __('Portfolio Singular Name', "brad-framework"),
                'desc' => ''
			),		
			
    
	array( 
	  "type" => "divide" ,
	  "id"   => "portfolio_divider"
	 ),
				   
	
	 array( "title" => __("Portfolio Layout",'brad-framework'),
				"subtitle" => "Portfolio layout for archive page",
				"id" => "portfolio_layout",
				"default" => "fullwidth",
				"type" => "select",
				"multiselect" => false ,
				"options" => array(
				  'fullwidth' => __('Fullwidth','brad-framework'),
				  'sidebar' =>  __('With Sidebar','brad-framework') )
				  ),	
				  
        array( "title" => __("Sidebar Position",'brad-framework'),
				"subtitle" => __("Sidebar Position if Portfolio Layout Selected to \"With Sidebar\"",'brad-framework'),
				"id" => "portfolio_sidebar_position",
			    "default" => "sidebar-right",
				"type" => "select",
				"required" => array("portfolio_layout","=","sidebar"),
				"multiselect" => false ,
				"options" => array( 
				     'sidebar-right'=> __('Sidebar Right','brad-framework') , 
					 'sidebar-left' => __('sidebar-left','brad-framework')
					 )
				),	
				
		
	 		
	  array("title" => __("Default sidebar",'brad-framework'),
			"subtitle" => __("Select a sidebar if Portfolio Layout Selected to \"With Sidebar\" . You must first create the sidebar under Appearance > Sidebars.",'brad-framework'),
			"id" => "portfolio_sidebar",
		    "default" => "",
			"type" => "select",
			"multiselect" => false ,
			"required" => array("portfolio_layout","=","sidebar"),
			"options" =>  array(
			        'blog-sidebar'	  => 'Blog Sidebar',
					'woocommerce-sidebar' => 'Woocommerce Sidebar' ,
					'sidebar1'  => 'Sidebar 1' ,
					'sidebar2'  => 'Sidebar 2' ,
					'sidebar3'  => 'Sidebar 3' ,
					'sidebar4'  => 'Sidebar 4' ,
					'sidebar5'  => 'Sidebar 5' ,
				)
			),	
			
	
	 array(
      "type" => "select",
      "title" => __("Horizental Whitespace Between child elements /columns", "brad-framework"),
      "id" => "padding",
	  "default" => "small",
	  "options" => Array( 
	   "medium" =>  "40px"   ,
	   "large"  =>	 "60px"  ,
	   "large2" =>	 "50px" ,
	   "medium2" => "30px" ,
	   "small"	 => "20px"  ,
	   "small2"	=> "10px"  ,
	   "narrow" =>	 "4px" ,
	   "no"   =>	 "0px" ) 	 
) ,

   array(
      "type" => "select",
	  "default" => "small",
	  "subtitle" => "Only for Portfolio Archive" ,
      "title" => __("Vertical Whitespace Between child elements /columns", "brad-framework"),
      "id" => "vpadding",
	  "options" => Array( 
	   "medium" =>  "40px"   ,
	   "large"  =>	 "60px"  ,
	   "large2" =>	 "50px" ,
	   "medium2" => "30px" ,
	   "small"	 => "20px"  ,
	   "small2"	=> "10px"  ,
	   "narrow" =>	 "4px" ,
	   "no"   =>	 "0px" ) 	 
  ),
	
	 array(
      "type" => "select",
      "title" => __("Portfolio Style", "brad-framework"),
      "id" => "portfolio_style",
	  "default" => 'style2',
      "options" => array(
	  		 'style1' => 'Simple Grid Style' , 
			 'style2' => 'Box Style with Info'
			// 'Masonry Portfolios'  => 'style4'
			),
      "subtitle" => "Default Style for Portfolio ( For Archives and related projects )."
    )  
   ,
   		
  	array(
      "type" => "select",
      "title" => __("Portfolio Item Background Style? ", "brad-framework"),
      "id" => "portfolio_bg_style",
	  "subtitle" => "For both Archives and related projects" ,
	  "default" => "white-smoke" ,
	  "options" => Array(
	                    "white" =>  __("White", "brad-framework") ,
				  "white-smoke" =>  __("White Smoke", "brad-framework"),
				       "stroke" =>  __("Transparent With Stroke", "brad-framework"),
				  "transparent" =>  __("Transparent", "brad-framework") 
				   ),
	  "required" => array('portfolio_style' ,  "=", 'style2')
	)
   ,	
						  
	array( "title" => __("Columns (Archive)",'brad-framework'),
		   "id" => "portfolio_columns",
		   "default" => "3",
		   "type" => "select",
		   "multiselect" => false ,
		   "options" => array(
		       '2' => __('Two columns','brad-framework'),
		       '3' => __('Three Columns','brad-framework'), 
		       '4' => __('Four Columns','brad-framework'),
			   '5' => __('Five Columns','brad-framework'),
			   '6' => __('Five Columns','brad-framework'))
		),
		
   array( "title" => __("Columns ( Related projects)",'brad-framework'),
		   "id" => "portfolio_rcolumns",
		   "default" => "3",
		   "type" => "select",
		   "multiselect" => false ,
		   "options" => array(
		       '2' => __('Two columns','brad-framework'),
		       '3' => __('Three Columns','brad-framework'), 
		       '4' => __('Four Columns','brad-framework'),
			   '5' => __('Five Columns','brad-framework'),
			   '6' => __('Five Columns','brad-framework'))
		),		
		
	array( "title" => __("Enable Masonry Layout ( For Archives only)",'brad-framework'),
		   "id" => "portfolio_masonry",
		   "default" =>"no" ,
		   "type" => "select" ,
		   "options" => array("yes" => __('Yes','brad-framework') , 'no' => __('No','brad-framework')) 
		   ),
		   
	array(
      "type" => "select",
      "title" => __("Portfolio Image Size ? ", "brad-framework"),
      "id" => "img_size",
	  "default" => "auto",
	  "options" => Array("automatic" => "Automatc ( Will get the best image size according to columns width)" , "custom" => __("Custom Image Size","brad_framework")),
	  "description" => "if you choose custom image size the portfolio image width will be still 100% to fill the container."
	)
   ,
   
   array(
      "type" => "text",
      "title" => __("Custom Image Size", "brad-framework"),
      "id" => "custom_img_size",
	  "default" => "",
	  "desc" => "Custom image size in width X Height. For ex. 570x400 <strong>note:</strong>Do't include px or any whitespace.",
	  "required" => array("img_size" , "=" , "custom")
	)
   , 

  array(
      "type" => "select",
      "title" => __("Portfolio overlay content style? ", "brad-framework"),
      "id" => "info_style",
	  "options" => Array(
	            "center" =>   __("Content in Center", "brad-framework")  ,
				"left"   =>   __("Content on left top", "brad-framework") 
			),
	  "default" => "center",			   
	  "required" => Array('portfolio_style', '=' , 'style1')
	)
   ,
   
   
   array(
      "type" => "select",
      "title" => __("Info visiblity? ", "brad-framework"),
      "id" => "info_onhover",
	  "default" => "yes",
	  "options" => Array(
	              "yes" =>  __("Show on hover", "brad-framework") ,
				  "no"  => __("Show initial", "brad-framework") 
				   ),
	 "required" => Array('portfolio_style', '=' , 'style1')
	)
   ,	   
		   		   		  
	array( "title" => __("Enable Lightbox Icon",'brad-framework'),
		   "id" => "portfolio_lightbox",
		   "default" => "yes" ,
		   "type" => "select" ,
		   "options" => array("yes" => __('Yes','brad-framework') , 'no' => __('No','brad-framework')) 
		   ),
			   
    array( "title" => __("Enable Link Icon",'brad-framework'),
			"id" => "portfolio_linkicon",
			 "default" => "yes" ,
		    "type" => "select" ,
		   "options" => array("yes" => __('Yes','brad-framework') , 'no' => __('No','brad-framework'))
			  ),
			  
	array( "title" => __("Enable Loveit",'brad-framework'),
			"id" => "portfolio_loveit",
			"default" => "no" ,
		    "type" => "select" ,
		    "options" => array("yes" => __('Yes','brad-framework') , 'no' => __('No','brad-framework'))
			  ),		  			   
  
   array(
      "type" => "select",
      "title" => "Enable divider",
      "id" => "divider",
	  "default" => "yes" ,
      "options" => array(  'yes' =>  __('Yes','brad-framework') , 'no' => __('No','brad-framework'))
   ),
	
  array(
      "type" => "select",
      "title" => __( "Divider Type" ,"brad-framework"),
      "id" => "di_type",
	  "default" => "small" ,
	  'required' => array("divider" , "=" , "yes") ,
	  "options" => array(
	    "tiny" => "Extra Small Border",
	    "large" => "100% Border" ,
		"medium" => "Medium Border",
		"small" => "Small Border" 
		 )
	),
	
   array(
      "type" => "select",
	  'required' => array( "divider" , "=" , "yes") ,
      "title" => __( "Divider Style" ,"brad-framework"),
      "id" => "di_style",
	  "default" => "double" ,
	  "options" => array(
	    "normal" => "Normal Border" ,
		 "double"  => "Thick Border" )
	),
	
   array(
      "type" => "select",
	  'required' => array( "divider" , "=" , "yes") ,
      "title" => __( "Divider Color" ,"brad-framework"),
      "id" => "di_color",
	  "default" => "primary" ,
	  "options" => array(
	    "light"  => "Light",
		"dark" => "Dark" ,
		"primary" => "Primary"  )
	),
		
	array( "title" => __("Show Categories in portfolio info",'brad-framework'),
		   "id" => "portfolio_categories",
		   "default" => "yes" ,
		   "type" => "select" ,
		   "options" => array("yes" => __('Yes','brad-framework') , 'no' => __('No','brad-framework'))
	     )	,
	
  array( "title" => __("Disable Link on title",'brad-framework'),
		 "id" => "disable_li_title",
		 "default" => "no" ,
		 "type" => "select" ,
		 "options" => array("yes" => __('Yes','brad-framework') , 'no' => __('No','brad-framework'))	    
),

 array(
      "type" => "select",
      "title" => __("Pagination ( Only for Archives)", "brad-framework"),
      "id" => "portfolio_pagination",
	  "default" => "default" ,
      "options" => array( 
	       'default' => __('Standard Pagination','brad-framework')   ,
	       'ifscroll'  => __('Infinite Scroll','brad-framework') ,
		   'loadmore' => __('Load More Button','brad-framework')  ,
		   'no'  => __('No Pagination','brad-framework')  )
		 )
   ,
   
     array(
      "type" => "select",
      "heading" => __("Button Style", "brad-framework"),
      "id" => "portfolio_button_style",
      "options" => $button_colors_arr,
	  'required' => array("portfolio_pagination" , "==" , "loadmore'")
    ),
	
	array(
      "type" => "text",
      "title" => __("Portfolio load more text", "brad-framework"),
      "id" => "portfolio_lm_title",
	  "default" => __('Load More','brad'),
	  'required' => array("portfolio_pagination" , "==" , "loadmore'")
	)
      
));	


$this->sections[] = array(
   'icon' => 'el-icon-bulb',
   'icon_class' => 'icon-small',
   'title' => __('Brad Slider', "brad-framework"),
   'desc' => '<p class="description">Customize the Bradslider</p>',
   'fields' => array(
   
             array( "title" => __( "Brad Slider Title Font", "brad-framework"),
					"subtitle" => "",
					"id" => "font_slider",
					"color" => false ,
					"preview" => false ,
					"font-backup" => true ,
					"text-transform" => true ,
					"text-align" => false ,
					'letter-spacing' => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway',"font-backup"=> "Arial, Helvetica, sans-serif" , 'font-weight' => '700' , 'font-size' => '55px' , 'font-style' => 'normal' ,'line-height' => '65px' , 'letter-spacing' => '2px' , "text-transform" => 'uppercase'),
					"type" => "typography"),	
					
					
			
		     array( "title" => __( "Brad Slider SubTitle Font", "brad-framework"),
					"subtitle" => "",
					"id" => "font_slider_subtitle",
					"color" => false ,
					"preview" => false ,
					"font-backup" => true ,
					"text-transform" => true ,
					"text-align" => false ,
					'letter-spacing' => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Crete Round',"font-backup"=> "Arial, Helvetica, sans-serif" , 'font-weight' => 'normal' , 'font-size' => '21px' , 'font-style' => 'normal' ,  'line-height' => '31px' , 'letter-spacing' => '0px' , "text-transform" => 'none' , 'font-style' => 'italic' ),
					"type" => "typography"),				
			
			 array( "title" => __( "Brad Slider Caption Font", "brad-framework"),
					"subtitle" => "",
					"id" => "font_slider_caption",
					"color" => false ,
					"preview" => false ,
					"font-backup" => true ,
					"text-transform" => true ,
					"text-align" => false ,
					'letter-spacing' => true ,
					"default" => array( 'font-type' => false , 'font-family' => 'Raleway',"font-backup"=> "Arial, Helvetica, sans-serif" , 'font-weight' => 'normal' , 'font-size' => '19px' , 'font-style' => 'normal' ,  'line-height' => '30px' , 'letter-spacing' => '0' , "text-transform" => 'none'),
					"type" => "typography"),
					
		   array( "title" => "Customize Slider Navigation",
			      "id" => "slider_nav" ,
			      "type" => "switch",
			      "default" => false
		       ),
		   		
		   array( "title" => 'Bradslider Navigation Border Style',
	              "id"  => "slider_border",
			      "color" => false,
			      "required" => array("slider_nav","=",true) ,
		          "default" => array( "border-top" => "2" , "border-style" => ""  ) ,
		          'required' => array('layout','=','boxed'),	
		          'type' => 'border' ),
			 
	      
		  array( "title" => "Bradslider Navigation radius (in px)" ,
		          "id" => "slider_radius",
		          "type" => "slider" ,
		          "required" => array("slider_nav","=",true) ,
		          "min" => 0 ,
		          "max" => 100,
		          "default" => 4	 		
		  )	,	
		  
		  array( "title" => "Bradslider Navigation Border Color" ,
		         "sub_title" => "Leave this field blank for auto",
		          "id" => "slider_bc",
		          "type" => "color" ,
				  "required" => array("slider_nav","=",true) ,
		          "default" => ""		
		  )	,

         array( "title" => "Bradslider Navigation Border Color:hover" ,
		          "id" => "slider_bc_hover",
		          "type" => "color" ,
				  "required" => array("slider_nav","=",true) ,
		          "default" => ""		
		  )	,
		  
		  
		  array( "title" => "Bradslider Navigation Bg Color" ,
		         "sub_title" => "Leave this field blank for auto",
		          "id" => "slider_bgc",
		          "type" => "color" ,
				  "required" => array("slider_nav","=",true) ,
		          "default" => ""		
		  )	,

         array( "title" => "Bradslider Navigation Bg Color:hover" ,
		          "id" => "slider_bgc_hover",
		          "type" => "color" ,
				  "required" => array("slider_nav","=",true) ,
		          "default" => ""		
		  )	,
		
		  
		  array( "title" => "Bradslider Navigation Icon Color" ,
		         "sub_title" => "Leave this field blank for auto",
		          "id" => "slider_c",
		          "type" => "color" ,
				  "required" => array("slider_nav","=",true) ,
		          "default" => ""		
		  )	,	
		  
		  
		  array( "title" => "Bradslider Navigation Icon Color:hover" ,
		          "id" => "slider_c_hover",
		          "type" => "color" ,
				  "required" => array("slider_nav","=",true) ,
		          "default" => ""		
		  )	,	

		  
		  
		  
		  
		  array( "title" => "Bradslider Navigation Size" ,
		          "id" => "slider_navsize",
		          "type" => "slider" ,
		          "required" => array("slider_nav","=",true) ,
		          "min" => 0 ,
		          "max" => 200,
		          "default" => 50	 		
		  )	,
		  
		  array( "title" => "Bradslider Navigation Icon Size" ,
		          "id" => "slider_iconsize",
		          "type" => "slider" ,
		          "required" => array("slider_nav","=",true) ,
		          "min" => 0 ,
		          "max" => 200,
		          "default" => 50	 		
		  )	
		  
		  	
		  
		   
		
 )
);										 				   
			 
	
$this->sections[] = array(
   'icon' => 'el-icon-bulb',
   'icon_class' => 'icon-small',
   'title' => __('Lightbox', "brad-framework"),
   'desc' => '<p class="description">Customize the Lightbox Settings</p>',
   'fields' => array(
        array( "title" => __( "Lightbox Theme", "brad-framework"),
			   "id" => "lightbox_theme",
			   "default" => "pp_default",
			   "type" => "select",
			   "multiselect" => false ,
			   "options" => array(
				    'pp_default' => 'pp_default',
					'light_rounded' => 'light_rounded',
					'dark_rounded' => 'dark_rounded',
					'light_square' => 'light_square',
					'dark_square' => 'dark_square',
					'facebook' => 'facebook'
					)),	
					
             array( "title" => __( "Disable Lightbox on Smartphone", "brad-framework"),
					"subtitle" => __( "Check this  to disable Lightbox on Smartphones. This will link directly to the image", "brad-framework"),
					"id" =>  "lightbox_smartphones",
					"default" => 0,
					"switch" => true , "type" => "checkbox"),						
					
            array( "title" => __( "Animation Speed", "brad-framework"),
					"id" => "lightbox_animation_speed",
					"default" => "fast",
					"type" => "select",
					"multiselect" => false ,
					"options" => array('fast' => 'Fast', 'slow' => 'Slow', 'normal' => 'Normal')),

            array( "title" => __( "Background Opacity", "brad-framework"),
					"subtitle" => "",
					"id" => "lightbox_opacity",
					"default" => "0.8",
					"type" => "text"),

            array( "title" => __( "Show title", "brad-framework"),
					"subtitle" => __( "Check to show the title", "brad-framework"),
					"id" => "lightbox_title",
					"default" => 1,
					"switch" => true , "type" => "checkbox"),
					
            array( "title" => __( "Show Gallery Thumbnails", "brad-framework"),
					"subtitle" => __( "Check to show gallery thumbnails", "brad-framework"),
					"id" => "lightbox_gallery",
					"default" => 1,
					"switch" => true , "type" => "checkbox"),

            array( "title" => __( "Autoplay Gallery", "brad-framework"),
					"subtitle" => __( "Check to autoplay the lightbox gallery", "brad-framework"),
					"id" => "lightbox_autoplay",
					"default" => 0,
					"switch" => true , "type" => "checkbox"),

            array( "title" => __( "Autoplay Gallery Speed", "brad-framework"),
					"subtitle" => __( "If autoplay is set to true, select the slideshow speed in ms. (Default: 5000, 1000 ms = 1 second)", "brad-framework"),
					"id" => "lightbox_slideshow_speed",
					"default" => "5000",
					"type" => "text"),

            array( "title" => __( "Social Icons", "brad-framework"),
					"subtitle" => __( "Check to show social sharing icons", "brad-framework"),
					"id" => "lightbox_social",
					"default" => 1,
					"switch" => true , "type" => "checkbox")	
        
        )
    );


$this->sections[] = array(
		'icon' => 'el-icon-twitter',
		'icon_class' => 'icon-small',
        'title' => __('Social Media', "brad-framework"),
        'desc' => '<p class="description">Enter your username / URL to show or leave blank to hide Social Media Icons</p>',
        'fields' => array(				
             array( "title" => __( "Twitter Username", "brad-framework"),
					"subtitle" => __( "Enter your Twitter Username", "brad-framework"),
					"id" => "social_twitter",
					"default" => "",
					"type" => "text"), 
					
             array( "title" => __( "Flickr URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Flickr Account", "brad-framework"),
					"id" => "social_flickr",
					"default" => "",
					"type" => "text"), 

            array( "title" => __( "Facebook URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Facebook Account", "brad-framework"),
					"id" => "social_facebook",
					"default" => "",
					"type" => "text"), 
					
            array( "title" => __( "Google+ URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Google+ Account", "brad-framework"),
					"id" => "social_google",
					"default" => "",
					"type" => "text"), 
					
            array( "title" => __( "LinkedIn URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your LinkedIn Account", "brad-framework"),
					"id" => "social_linkedin",
					"default" => "",
					"type" => "text"),
					 
            array( "title" => __( "YouTube URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your YouTube Account", "brad-framework"),
					"id" => "social_youtube",
					"default" => "",
					"type" => "text"), 
					
            array( "title" => __( "Instagram URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Instagram Account", "brad-framework"),
					"id" => "social_instagram",
					"default" => "",
					"type" => "text"), 					
					
            array( "title" => __( "Vimeo URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Vimeo Account", "brad-framework"),
					"id" => "social_vimeo",
					"default" => "",
					"type" => "text"), 
										
            array( "title" => __( "Skype URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Skype Account", "brad-framework"),
					"id" => "social_skype",
					"default" => "",
					"type" => "text"), 
					
            array( "title" => __( "Forrst URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Forrst Account", "brad-framework"),
					"id" => "social_forrst",
					"default" => "",
					"type" => "text"), 

            array( "title" => __( "Dribbble URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Dribbble Account", "brad-framework"),
					"id" => "social_dribbble",
					"default" => "",
					"type" => "text"), 
						
           
            /*
			
			 array( "title" => __( "Digg URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Digg Account", "brad-framework"),
					"id" => "social_digg",
					"default" => "",
					"type" => "text"), 

            array( "title" => __( "Yahoo URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Yahoo Account", "brad-framework"),
					"id" => "social_yahoo",
					"default" => "",
					"type" => "text"),
					
       array( "title" => __( "DeviantArt URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your DeviantArt Account", "brad-framework"),
					"id" => "social_deviantart",
					"default" => "",
					"type" => "text"), 					 
			*/
					
            array( "title" => __( "Tumblr URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Tumblr Account", "brad-framework"),
					"id" => "social_tumblr",
					"default" => "",
					"type" => "text"), 
					
      
					
            array( "title" => __( "Behance URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Behance Account", "brad-framework"),
					"id" => "social_behance",
					"default" => "",
					"type" => "text"),
					
            array( "title" => __( "Pinterest URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Pinterest Account", "brad-framework"),
					"id" => "social_pinterest",
					"default" => "",
					"type" => "text"),  
					
            array( "title" => __( "PayPal URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your PayPal Account", "brad-framework"),
					"id" => "social_paypal",
					"default" => "",
					"type" => "text"), 
					
            array( "title" => __( "Delicious URL", "brad-framework"),
					"subtitle" => __( "Enter URL to your Delicious Account", "brad-framework"),
					"id" => "social_delicious",
					"default" => "",
					"type" => "text"), 
					
            array( "title" => __( "Show RSS", "brad-framework"),
					"subtitle" => __( "Check to Show RSS Icon", "brad-framework"),
					"id" => "social_rss",
					"default" => 1,
					"switch" => true , "type" => "checkbox")
					)
             );
 	
$this->sections[] = array(
	'icon' => 'el-icon-shopping-cart',
	'icon_class' => 'icon-small',
    'title' => __('woocommerce', "brad-framework"),
	'desc' => '<p>Customize the Blog settings .</p>' ,
	'fields' => array(
	 
  
	
       array( "title" => __( "Enable Rollover Effect for Product Images", "brad-framework"),
			 "id" => "check_shoprollover",
			 "default" => 1,
			 "type" => "switch" ) ,
		
	   array( "title" => __( "Enable Cart Display in header", "brad-framework"),
			 "id" => "check_cartheader",
			 "default" => 1,
			 "required" => array("header_layout" , "!=" , "type4") ,
			 "type" => "switch" ) ,	

			 
	  array( "title" => __("Cart Icon Positon", "brad-framework"),
				   "id" => "ci_postion",
                   "required" => array("header_layout" , "=" , "type2") ,
                  "type" => "select",
			      "multiselect" => false ,
                  "options" => array (
			          "right" => __("Right side of the logo","brad-framework"), 
				      "left" => __("Left Side of the Logo","brad-framework")
            )),		
			
					 		 
	   array( "title" => __( "Enable Cart icon for mobile", "brad-framework"),
			 "id" => "check_cartmobile",
			 "default" => 1,
			 "type" => "switch" ) ,
			 
	  array( "title" => __("Single Product Layout", "brad-framework"),
		     "id" => "singlepr_layout",
     
                  "type" => "select",
			      "multiselect" => false ,
                  "options" => array (
			          "type1" => __("Tabs content at right","brad-framework"), 
				      "type2" => __("Tabs content at Bottom","brad-framework")
            ))		 	 
					
		)
	);	
	
                            

$this->sections[] = array(
		'icon' => 'el-icon-leaf',
		'icon_class' => 'icon-small',
        'title' => __('Theme Update', "brad-framework"),
        'desc' => '<p class="description">Enter your username / Api to get theme update notifications</p>',
        'fields' => array(				
             array( "title" => "Themeforest Username",
					"subtitle" => "Enter your Themeforest Username",
					"id" => "themeforest_username",
					"std" => "",
					"type" => "text"), 
			
			 array( "title" => "Themeforest Api Key",
					"subtitle" => "Enter your Themeforest api Key",
					"id" => "themeforest_apikey",
					"std" => "",
					"type" => "text"), 
					)		
			);		    
			
			

		}	




		/**
			
			All the possible arguments for Redux.
			For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 **/
		public function setArguments() {
			
			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
	            
	            // TYPICAL -> Change these values as you need/desire
				 
				'opt_name' => 'akal_options' , // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			=> $theme->get('Name'), // Name that appears at the top of your panel
				'display_version'		=> $theme->get('Version'), // Version that appears at the top of your panel
				'menu_type'          	=> 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
			
			    'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
				'menu_title'			=> __( 'Akal Options', 'brad-framework' ),
	            'page'		 	 		=> __( 'Akal Options', 'brad-framework' ),
	            'google_api_key'   	 	=> '', // Must be defined to add google fonts to the typography module
	            'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
	            'dev_mode'           	=> false , // Show the time the page took to load, etc
	            'customizer'         	=> false , // Enable basic customizer support

	            // OPTIONAL -> Give you extra features
	            'page_priority'      	=> 50 , // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	            'page_parent'        	=> 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	            'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
	            'menu_icon'          	=> '', // Specify a custom URL to an icon
	            'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
	            'page_icon'          	=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
	            'page_slug'          	=> '_options', // Page slug used to denote the panel
	            'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
	            'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
	            'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *


	            // CAREFUL -> These options are for advanced use only
	            'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
	            'output'            	=>  false , // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	            'output_tag'            	=> false , // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	            //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
	            'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
	            

	            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	            'database'           	=> '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	            
	        
	            'show_import_export' 	=> true, // REMOVE
	            'system_info'        	=> false, // REMOVE
	            
	            'help_tabs'          	=> array(),
	            'help_sidebar'       	=> '', // __( '', $this->args['domain'] );            
				);

		}
	}
	
	new Redux_Framework_config();

}
