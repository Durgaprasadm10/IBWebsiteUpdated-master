<?php
/*** Removing shortcodes ***/
vc_remove_element("vc_column_inner");
vc_remove_element("vc_widget_sidebar");
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_rss");
vc_remove_element("vc_teaser_grid");
vc_remove_element("vc_button");
vc_remove_element("vc_cta_button");
vc_remove_element("vc_cta_button2");
vc_remove_element("vc_message");
vc_remove_element("vc_progress_bar");
vc_remove_element("vc_pie");
vc_remove_element("vc_posts_slider");
vc_remove_element("vc_images_carousel");
vc_remove_element("vc_posts_grid");
vc_remove_element("vc_carousel");
vc_remove_element("vc_separator");
vc_remove_element("vc_icon");


/*** Remove unused parameters ***/
if (function_exists('vc_remove_param')) {
	vc_remove_param('vc_toggle', 'css_animation');
	vc_remove_param('vc_row', 'font_color');
	vc_remove_param('vc_row', 'margin_bottom');
	vc_remove_param('vc_tabs', 'interval');
	vc_remove_param('vc_accordion', 'collapsible');
}



/*** Remove frontend editor ***/
if(function_exists('vc_disable_frontend')){
	vc_disable_frontend();
}

/* Extended vc taxonomy */

function brad_category_sorter($settings, $value) {
	$dependency = vc_generate_dependencies_attributes($settings);
	
		if ( !empty($settings['taxonomy']) ) {
           $terms = get_terms( $settings['taxonomy'] );
		}
		else
		{
		    $terms = '' ;
		 }

		$current_value = explode(",", $value);
		$return = '';
		
		if( is_array($terms) && !empty($terms))
		{
			foreach( $terms as $term ) {
			$checked = in_array($term->slug , $current_value) ? ' checked="checked"' : '';	
			$return  .= sprintf('<input id="%s-%s" value="%s" class="wpb_vc_param_value %s taxonomy" type="checkbox" name="%s" %s>%s' , $settings['param_name'] , $term->slug , $term->slug  , $settings['param_name'] , $settings['param_name'] , $checked ,$term->name );
		}
	}
		 
    return $return;
}

vc_add_shortcode_param('taxonomy', 'brad_category_sorter' , get_template_directory_uri().'/vc_extend/js/taxonomy.js' );



/* Custom Icon picker */
function brad_icon_settings_field($settings, $value) {
   global $fa_icons , $uploaded_icons , $brad_data;
   $dependency = vc_generate_dependencies_attributes($settings);
   $return = '<div class="icongroup"><input type="hidden" name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field vc-icon-picker" value="'.$value.'" '.$dependency.'>';
   
	$icon_value = explode("|",$value);
				
	$return .= '<div class="vc-icon-option wpb-icon-prefix">';
	
	if( is_array($uploaded_icons ) && !empty($uploaded_icons)) {
	  foreach( $uploaded_icons as $k => $icon) { 
		 $return .= '<i class="'.$brad_data['custom_iconfont']['prefix'].' '.$icon.' '.($icon_value[0] == $k && @$icon_value[1] == 'uploaded' ? "selected" : "" ).'" data-icon="'.$k.'|uploaded"></i>';
	   }
	}
	
	if( is_array($fa_icons ) && !empty($fa_icons)) {
	  foreach( $fa_icons as $k => $fontawesome_icon) { 
		 $return .= '<i class="'.$fontawesome_icon.' '.($icon_value[0] == $k && @$icon_value[1] == 'fontawesome' ? "selected" : "" ).'" data-icon="'.$k.'|fontawesome"></i>';
	   }
	}
	
	$return .= '</div></div>';
	
	return $return;
}

vc_add_shortcode_param('brad_iconpicker', 'brad_icon_settings_field' , get_template_directory_uri().'/vc_extend/js/iconpicker.js');



// Used in "Button", "Call to Action", "Pie chart" blocks
$colors_arr = array(__("Default", "brad-framework") => "default" ,  __("Grey", "brad-framework") => "grey",  __("White", "brad-framework") => "white" , __("Green", "brad-framework") => "green",__("Sea Green", "brad-framework") => "seagreen", __("Blue", "brad-framework") => "blue", __("Orange", "brad-framework") => "orange", __("Red", "brad-framework") => "red", __("Black", "brad-framework") => "black" , __("Purple", "brad-framework") => "purple" , __("Yellow", "brad-framework") => "yellow" , __('Alternate','brad-framework') => 'alternate',__('Alternate Primary','brad-framework') => 'alternateprimary' , __('Alternate Transparent','brad-framework') => 'alternatewhite' );

$button_colors_arr = $colors_arr;

$button_colors_arr[__('Read More Button','brad-framework')] =  'readmore';

// Used in "Button" and "Call to Action" blocks
$size_arr = array(__("Regular size", "brad-framework") => "default", __("Large", "brad-framework") => "large", __("Small", "brad-framework") => "small");

$target_arr = array(__("Same window", "brad-framework") => "_self", __("New window", "brad-framework") => "_blank");

$add_order_by = array(
                  "type" => "dropdown",
                  "heading" => __("Order by", "brad-framework"),
                  "param_name" => "orderby",
                  "value" => array(  __("Date", "brad-framework") => "date", __("ID", "brad-framework") => "ID",  __("Title", "brad-framework") => "title", __("Modified", "brad-framework") => "modified", __("Random", "brad-framework") => "rand", __("Menu order", "brad-framework") => "menu_order" ),
                  "description" => sprintf(__('Select how to sort retrieved posts. More at %s.', 'brad-framework'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    );
	
$add_order =  array(
                 "type" => "dropdown",
                 "heading" => __("Order", "brad-framework"),
                 "param_name" => "order",
                 "value" => array( __("Descending", "brad-framework") => "DESC", __("Ascending", "brad-framework") => "ASC" ),
                 "description" => sprintf(__('Designates the ascending or descending order. More at %s.', 'brad-framework'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    );
	
$add_bottom_margin = array(
                  "type" => "textfield",
                  "heading" => __("Bottom Margin", "brad-framework"),
                  "param_name" => "bottom_margin",
	              "value" => 0 ,
				  "description" => "Default Bottom Margin in px . Do't Included px just numbers"
     );	
	
$add_css_animation = array(
                     "type" => "dropdown",
                     "heading" => __("CSS Animation", "brad-framework"),
                     "param_name" => "css_animation",
                     "admin_label" => true,
                     "value" => array(__("No", "brad-framework") => '', __("Left to Right", "brad-framework") => "fadeInLeft", __("Right to Left", "brad-framework") => "fadeInRight", __("Bottom to top", "brad-framework") => "fadeInTop", __("Top to Bottom", "brad-framework") => "fadeInBottom",__("Left to Right Big", "brad-framework") => "fadeInLeftBig", __("Right to Big big", "brad-framework") => "fadeInRightBig", __("Bottom to Top Big", "brad-framework") => "fadeInTopBig", __("Top to Bottom Big", "brad-framework") => "fadeInBottomBig" , __("Appear from center", "brad-framework") => "appearFromCenter" , __("Fade In", "brad-framework") => "fadeIn"),
                     "description" => "Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers."
);

$add_hidden_array = array(
                        "type" => "checkbox",
                        "heading" => __("Hide Under", "brad-framework"),
                        "param_name" => "hide_under",
                        "value" => array(__("Dektop", "brad-framework") => 'desktop', __("Tablet", "brad-framework") => 'tablet' , __("Smartphones", "brad-framework") => 'mobile')
);

$add_css_animation_delay = array(
                        "type" => "dropdown",
                        "heading" => __("CSS Animation Delay", "brad-framework"),
                        "param_name" => "css_animation_delay",
                        "value" => array(__("No Delay", "brad-framework") => '0', '100' => '100' , '200' => '200', '300' => '300' , '400' => '400' , '500' => '500' ,'600' => '600' , '700' => '700' , '800' => '800','1000' => '1000' , '1200' => '1200' , '1400' => '1400' , '1600' => '1600' , '1800' => '1800' , '2000' => '2000')
);

$add_img_size = array(
      "type" => "dropdown",
      "heading" => __("Image size", "brad-framework"),
      "param_name" => "img_size",
	  "value" => Array( 
	     __("Default","brad-framework") => "" ,
		 __("Large","brad-framework") => "thumb-large" ,
		 __("Medium","brad-framework") => "thumb-medium" ,
		 __("Small","brad-framework") => "thumb-normal" ,
		 __("Masonry Large","brad-framework") => "thumb-large-masonry" ,
		 __("Masonry Medium","brad-framework") => "thumb-medium-masonry" ,
		 __("Masonry Small","brad-framework") => "thumb-normal-masonry" ,
		 __("Thumbnail","brad-framework") => "thumbnail" ,
		 __("Fullwidth",'brad-framework') => "fullwidth" ,
		 __("Mini","brad-framework") => "mini" ,	 	 
		 __("Custom","brad-framework") => "custom" )
		 );
		 
$add_box_padding = array(
      "type" => "dropdown",
      "heading" => __("Horizental Whitespace Between child elements /columns", "brad-framework"),
      "param_name" => "padding",
	  "value" => Array( 
	  
	     "Default (40px)" => "medium" ,
		 "60px" => "large" ,
		 "50px" => "large2" ,
		 "30px" => "medium2" ,
		 "20px" => "small" ,
		 "10px" => "small2" ,
		 "4px" => "narrow" ,
		 "0px" => "no" ) 	 
);

$add_box_vpadding = array(
      "type" => "dropdown",
      "heading" => __("Vertical Whitespace Between child elements /columns", "brad-framework"),
      "param_name" => "vpadding",
	  "value" => Array( 
	     "Default (40px)" => "medium" ,
		 "60px" => "large" ,
		 "50px" => "large2" ,
		 "30px" => "medium2" ,
		 "20px" => "small" ,
		 "10px" => "small2" ,
		 "4px" => "narrow" ,
		 "0px" => "no" ) 	 
);	
		 
		 
$add_inner_vpadding = array(
      "type" => "dropdown",
      "heading" => __("Box Inner Vertical Padding ? ", "brad-framework"),
      "param_name" => "inner_vpadding",
	  "value" => Array( 
	     "Default (Medium)" => "medium" ,
		   "Narrow Padding" => "narrow" ,
		    "Large Padding" => "large"	 ) ,
	 "dependency" => array("element" => "style" , "value" => array("style3"))
	);
	
$add_inner_hpadding = array(
      "type" => "dropdown",
      "heading" => __("Box Inner horizental Padding ? ", "brad-framework"),
      "param_name" => "inner_hpadding",
	  "value" => Array( 
	     "Default (Medium)" => "medium" ,
		   "Narrow Padding" => "narrow" ,
		    "Large Padding" => "large"	 ) ,
	 "dependency" => array("element" => "style" , "value" => array("style3"))
	);
		 
		 		 		 
$add_custom_img_size = array(
	  "type" => "textfield",
	  "heading" => __("Custom Image size", "brad-framework"),
      "param_name" => "custom_img_size",	  	 
      "description" => "Enter image size in pixels: 200x100 (Width x Height). Leave empty to use default size.",
	   "dependency" => Array('element' => "img_size", "value" => array("custom"))
	   );


$add_box_bgcolor =  array(
      "type" => "colorpicker",
      "heading" => __("Background Color for box", "brad-framework"),
      "param_name" => "bg_color",
      "value" => "#ffffff",
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
    ) ; 
	
$add_box_bgcolor_hover =  array(
      "type" => "colorpicker",
      "heading" => __("Background Color for box : hover", "brad-framework"),
      "param_name" => "bg_color_hover",
      "value" => "",
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
    ) ; 	
	
$add_box_stroke_color =  array(
      "type" => "colorpicker",
      "heading" => __("Border Color for Box", "brad-framework"),
      "param_name" => "border_color",
      "value" => "",
	  "description" => "Border color of box or leave blank for no border",
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
    ) ;
	
$add_box_stroke_color_hover =  array(
      "type" => "colorpicker",
      "heading" => __("Border Color for Box : hover", "brad-framework"),
      "param_name" => "border_color_hover",
      "value" => "",
	  "description" => "Border color of box or leave blank for no border",
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
    ) ;	
	
$add_box_stroke_opacity =  array(
      "type" => "colorpicker",
      "heading" => __("Border Opacity", "brad-framework"),
      "param_name" => "border_opacity",
      "value" => "1",
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
    ) ; 
	
$add_box_stroke_opacity_hover =  array(
      "type" => "colorpicker",
      "heading" => __("Border Opacity", "brad-framework"),
      "param_name" => "border_opacity_hover",
      "value" => "1",
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
    ) ; 		

$add_box_opacity_hover =  array(
      "type" => "textfield",
      "heading" => __("Opacity for Box", "brad-framework"),
      "param_name" => "bg_opacity_hover",
      "value" => "1",
	  "description" => "Insert a value between o and 1 , for ex. 0.755",
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
    ) ;
	  
$add_box_opacity =  array(
      "type" => "textfield",
      "heading" => __("Opacity for Box", "brad-framework"),
      "param_name" => "bg_opacity",
      "value" => "1",
	  "description" => "Insert a value between o and 1 , for ex. 0.755" ,
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
    ) ;
  
$add_box_shadow =  array(
      "type" => "checkbox",
      "heading" => __("Box Outer Shadow? ", "brad-framework"),
      "param_name" => "bg_shadow",
	  "value" => array(__("Yes","brad-framework") => "yes"),
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
  );
 
  
$add_box_radius =  array(
      "type" => "dropdown",
      "heading" => __("Box Container Border Radius ?", "brad-framework"),
      "param_name" => "bg_radius",
	  "value" => array(__("Yes","brad-framework") => "yes" , __("No","brad-framework") => "no"),
	  "dependency" => Array('element' => "style", 'value' => array('style3'))
  );
  
$add_box_radius_round =  array(
      "type" => "checkbox",
      "heading" => __("Totally Round the Border Radius? ", "brad-framework"),
      "param_name" => "bg_radius_full",
	  "value" => array(__("Yes","brad-framework") => "yes" ),
	  "dependency" => Array('element' => "bg_radius", 'value' => array('yes'))
  );
  
 $extra_class = array(
      "type" => "textfield",
      "heading" => __("Extra class name", "brad-framework"),
      "param_name" => "el_class",
      "description" => "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",
    ); 

$add_divider = array(
      "type" => "checkbox",
      "heading" => "Enable divider",
      "param_name" => "divider",
      "value" => array( __('Yes','brad-framework') => 'yes')
    );
	
$add_divider_type =	array(
      "type" => "dropdown",
      "heading" => __( "Divider Type" ,"brad-framework"),
      "param_name" => "di_type",
	  'dependency' => array("element" => "divider" , "value" => array("yes")) ,
	  "value" => array(
	    "Extra Small Border" => "tiny",
	    "100% Border"        => "large",
		"Medium Border"      => "medium",
		"Small Border"       => "small"
		 )
	);
	
$add_divider_style =	array(
      "type" => "dropdown",
	  'dependency' => array("element" => "divider" , "value" => array("yes")) ,
      "heading" => __( "Divider Style" ,"brad-framework"),
      "param_name" => "di_style",
	  "value" => array(
	    "Normal Border" => "normal",
		"Thick Border"  => "double" )
	);
	
$add_divider_color =	array(
      "type" => "dropdown",
	  'dependency' => array("element" => "divider" , "value" => array("yes")) ,
      "heading" => __( "Divider Color" ,"brad-framework"),
      "param_name" => "di_color",
	  "value" => array(
	    "Light" => "light",
		"Dark"  => "dark" ,
		"Primary" => "primary" )
	);
	  
	  
$add_autoplay = array(
      "type" => "checkbox",
      "heading" => __("Autoplay ?", "brad-framework"),
      "param_name" => "autoplay",
	  "value" => array(__('Yes','brad-framework') => 'yes') ,
    );
	
$add_autoplay_dependency = array(
      "type" => "checkbox",
      "heading" => __("Autoplay ?", "brad-framework"),
      "param_name" => "autoplay",
	  "dependecny" => array("element" => "appearance", "value" => array("carousel") ) ,
	  "value" => array(__('Yes','brad-framework') => 'yes') ,
    );	
	
$add_autoplay_interval	= array(
      "type" => "textfield",
      "heading" => __("Autoplay Interval ?", "brad-framework"),
      "param_name" => "interval",
	  "value" => "5000",
	  "dependency" => array("element" => "autoplay" , "value" => array("yes"))
 );	  
 
 
vc_add_param('vc_accordion_tab' , array(
      "type" => "brad_iconpicker",
      "heading" => __("Accordion Icon", "brad-framework"),
      "param_name" => "icon",
      "description" => __("Select an icon for this tab.", "brad-framework")
 ));
 
 vc_add_param('vc_tab' , array(
      "type" => "brad_iconpicker",
      "heading" => __("Tab Icon", "brad-framework"),
      "param_name" => "icon",
      "description" => __("Select an icon for this tab.", "brad-framework")
 ));
 
  
vc_add_param('vc_toggle' , array(
      "type" => "brad_iconpicker",
      "heading" => __("Toggle Icon", "brad-framework"),
      "param_name" => "icon",
      "description" => __("Select an icon for this tab.", "brad-framework")
 ));
	
vc_add_param( 'vc_row' , array(
	  "type" => "textfield",
	  "heading" => __("Anchor Id","brad-framework"),
	  "value" => "",
	  "param_name" => "sid",
	  "description" => "You can use this Anchor id in Appearance -> Menus to scroll to  this row/section"
	  )
);

vc_add_param( 'vc_row' , $add_box_padding );
vc_add_param( 'vc_row_inner' , $add_box_padding );
vc_add_param( 'vc_row' , $add_box_vpadding );
vc_add_param( 'vc_row_inner' , $add_box_vpadding );
	
	
vc_add_param( 'vc_row' , array(
      "type" => "dropdown",
      "heading" => __("Text color Scheme ?", "brad-framework"),
      "param_name" => "color_scheme",
	  "value" => array(
	               __('Default Text',"brad-framework") => '' , 
	               __('All text to White',"brad-framework") => 'scheme1' 
				   )			   
));
	
	
vc_add_param( 'vc_row' , array(
      "type" => "dropdown",
      "heading" => __("Type","brad-framework"),
      "param_name" => "section_type",
	  "description" => 'To use this feature you need to set your page template as fullwidth instead of default template. Refer to the following link <a href="http://codex.wordpress.org/Page_Templates">http://codex.wordpress.org/Page_Templates</a>' ,
	  "value" => array(
		"Default" => "",
		"Full Width" => "full-width",
		"Full Width With Padding" => "full-width-with-padding",
		"940 Grid" => "grid-940"
	   )
    )
);

vc_add_param( 'vc_row' , array(
	  "type" => "textfield",
	  "heading" => __("Padding Top","brad-framework"),
	  "value" => "0",
	  "param_name" => "sp_top",
	  "description" => "Do't Include px ( in numbers only)"
));

vc_add_param( 'vc_row' , array(
	  "type" => "textfield",
	  "heading" => __("Padding Bottom","brad-framework"),
	  "value" => "0",
	  "param_name" => "sp_bottom"
));

vc_add_param( 'vc_row' , array(
      "type" => "checkbox",
      "heading" => __("Enable Top Border","brad-framework"),
      "param_name" => "enable_border",
	  "value" => Array(__("Yes", "brad-framework") => 'yes') ,
      "description" => ""
));

vc_add_param( 'vc_row' , array(
      "type" => "checkbox",
      "heading" => __("Enable Bottom Border","brad-framework"),
      "param_name" => "enable_bottom_border",
	  "value" => Array(__("Yes", "brad-framework") => 'yes') ,
      "description" => ""
));
	
	
vc_add_param( 'vc_row' , array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => __("Background color","brad-framework"),
	"param_name" => "background_color"
));

vc_add_param( 'vc_row' , array(
	"type" => "dropdown" , 
	"heading" => __("Background Type","brad-framework"),
	"param_name" => "bg_type",
	"value" => array(__("Image","brad-framework") => "image", __('Video','brad-framework') => 'video')
));
   
vc_add_param( 'vc_row' , array(
	"type" => "attach_image", 
	"class" => "bg_image",
	"heading" => __("Background image","brad-framework"),
	"param_name" => "background_image",
    "dependency" => array("element" => "bg_type" , "value" => array("image") )
));



vc_add_param( 'vc_row' , array(
	"type" => "checkbox",
	"value" => array(__("Yes","brad-framework") => "yes"),
	"heading" => __("Equal Columns Height","brad-framework"),
	"description" => "Make the height of all the columns inside this row equal to each others" ,
	"param_name" => "equal_height") 
);



   
vc_add_param( 'vc_row' , array(
      "type" => "dropdown",
      "heading" => __("Background Style","brad-framework"),
      "param_name" => "background_style",
	  "value" => Array(__('Stretch','brad-framework') => 'stretch' , __('Repeat','brad-framework') => 'repeat' ,  __('No Repeat','brad-framework') => 'norepeat' ),
      "description" => "",
	  "dependency" => array("element" => "bg_type" , "value" => array("image") )
));

	
vc_add_param( 'vc_row' , array(
      "type" => "dropdown",
      "heading" => __("Fixed Background","brad-framework"),
      "param_name" => "fixed_bg",
	  "value" => Array( __('No','brad-framework') => 'no' , __('Yes','brad-framework') => 'yes'),  
      "description" => "",
	  "dependency" => array("element" => "bg_type" , "value" => array("image") )
));
   
vc_add_param( 'vc_row' , array(
	  "type" => "dropdown", 
	  "heading" => __("Enable Parallax","brad-framework"),
	  "param_name" => "enable_parallax",
	  "value" => Array( __('No','brad-framework') => 'no' , __('Yes','brad-framework') => 'yes' )
));
	  
vc_add_param( 'vc_row' , array(
	"type" => "textfield", //attach_video
	//"holder" => "img",
	"heading" => __("Parallax Speed","brad-framework"),
	"param_name" => "parallax_speed",
	"dependency" => array("element" => "enable_parallax" , 'value' => array('yes'))
));
	
vc_add_param( 'vc_row' , array(
	"type" => "attach_image", 
	"heading" => __("Fallback image for video","brad-framework"),
	"param_name" => "fb_image" ,
	"dependency" => array("element" => "bg_type" , 'value' => array('video'))
));
	
vc_add_param( 'vc_row' , array(
	"type" => "textfield", //attach_video
	//"holder" => "img",
	"heading" => __("Background Video mp4","brad-framework"),
	"param_name" => "bg_video_mp4",
	"dependency" => array("element" => "bg_type" , 'value' => array('video'))
));

vc_add_param( 'vc_row' , array(
	"type" => "textfield", //attach_video
	//"holder" => "img",
	"heading" => __("Background Video ogg","brad-framework"),
	"param_name" => "bg_video_ogg",
	"dependency" => array("element" => "bg_type" , 'value' => array('video'))
));

vc_add_param( 'vc_row' , array(
	"type" => "textfield", //attach_video
	//"holder" => "img",
	"heading" => __("Background Video WebM","brad-framework"),
	"param_name" => "bg_video_webm",
	"dependency" => array("element" => "bg_type" , 'value' => array('video'))
));


vc_add_param( 'vc_row' , array(
	"type" => "dropdown",
	"value" => array(
	            __("According to Content height","brad-framework") => "content",
				__("According to Video height","brad-framework") => "video"
				),
	"heading" => __("Video height","brad-framework"),
	"param_name" => "height",
	"dependency" => array("element" => "bg_type" , 'value' => array('video'))
));
	 
	 
vc_add_param( 'vc_row' , array(
	"type" => "dropdown",
	"value" => array(
	            __("Default","brad-framework") => "",
				__("16:9","brad-framework") => "16:9",
				__("4:3","brad-framework") => "4:3"
				),
	"heading" => __("Video Aspect Ratio","brad-framework"),
	"param_name" => "video_ratio",
	"dependency" => array("element" => "bg_type" , 'value' => array('video'))
));


   		
vc_add_param( 'vc_row' , array(
	"type" => "checkbox",
	"value" => array(__("Yes","brad-framework") => "yes"),
	"heading" => __("Enable Background Overlay","brad-framework"),
	"param_name" => "bg_overlay") 
);

vc_add_param( 'vc_row' , array(
	"type" => "colorpicker",
	"value" => "",
	"heading" => __("Background Overlay Color","brad-framework"),
	"param_name" => "bg_overlay_color",
	"dependency" => Array('element' => "bg_overlay", "value" => array("yes"))
));
	
vc_add_param( 'vc_row' , array(
	"type" => "textfield",
	"value" => "0.4",
	"heading" => __("Background Overlay Color Opacity","brad-framework"),
	"param_name" => "bg_overlay_opacity",
	"dependency" => Array('element' => "bg_overlay", "value" => array("yes"))
	)
);
	
vc_add_param( 'vc_column' , array(
	  "type" => "textfield",
	  "heading" => __("Padding Top","brad-framework"),
	  "value" => "0",
	  "param_name" => "p_top",
	  "description" => "Do't Include px ( in numbers only)"
));

vc_add_param( 'vc_column' , array(
	  "type" => "textfield",
	  "heading" => __("Padding Bottom","brad-framework"),
	  "value" => "0",
	  "param_name" => "p_bottom"
));
	
vc_add_param( 'vc_column' , array(
	  "type" => "textfield",
	  "heading" => __("Padding Left","brad-framework"),
	  "value" => "0",
	  "param_name" => "p_left"
));


vc_add_param( 'vc_column' , array(
	  "type" => "textfield",
	  "heading" => __("Padding Right","brad-framework"),
	  "value" => "0",
	  "param_name" => "p_right"
));
	

vc_add_param( 'vc_column' , array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => __("Background color","brad-framework"),
	"param_name" => "background_color"
));





	


vc_add_param( 'vc_column' , array(
      "type" => "dropdown",
      "heading" => __("Text color Scheme ?", "brad-framework"),
      "param_name" => "color_scheme",
	  "value" => array(
	               __('Default Text',"brad-framework") => '' , 
	               __('All text to White',"brad-framework") => 'scheme1' 
				   )			   
));

vc_add_param( 'vc_column' , array(
	"type" => "attach_image", 
	"class" => "background_image",
	"heading" => __("Background image","brad-framework"),
	"param_name" => "background_image"
));


vc_add_param( 'vc_column' , array(
	"type" => "checkbox",
	"value" => array(__("Yes","brad-framework") => "yes"),
	"heading" => __("Enable Background Overlay","brad-framework"),
	"param_name" => "bg_overlay") 
);

vc_add_param( 'vc_column' , array(
	"type" => "colorpicker",
	"value" => "",
	"heading" => __("Background Overlay Color","brad-framework"),
	"param_name" => "bg_overlay_color",
	"dependency" => Array('element' => "bg_overlay", "value" => array("yes"))
));
	
vc_add_param( 'vc_column' , array(
	"type" => "textfield",
	"value" => "0.4",
	"heading" => __("Background Overlay Color Opacity","brad-framework"),
	"param_name" => "bg_overlay_opacity",
	"dependency" => Array('element' => "bg_overlay", "value" => array("yes"))
	)
);
	
	
	
vc_add_param( 'vc_row' , array(
      "type" => "dropdown",
      "heading" => __("Background Overlay Dots","brad-framework"),
      "param_name" => "bg_overlay_dot",
	  "value" => Array(__('No Dots','brad-framework') => 'no' , __('1x1 px','brad-framework') => 'style1',__('3x3 px','brad-framework') => 'style2'  ,__('White 1x1 px','brad-framework') => 'style3',__('White 3x3 px','brad-framework') => 'style4' ),
      "description" => "",
	  "dependency" => Array('element' => "bg_overlay", "value" => array("yes"))
));

	
vc_add_param( 'vc_row' , array(
      "type" => "checkbox",
      "heading" => __("Enable Divider Triangle","brad-framework"),
      "param_name" => "enable_triangle",
	  "value" => Array(__("Yes","brad-framework") => 'yes')
    )
);
	
vc_add_param( 'vc_row' , array(
      "type" => "colorpicker",
      "heading" => __("Divider triangle color","brad-framework"),
      "param_name" => "triangle_color",
	  "dependency" => array("element" => "enable_triangle", "value" => array("yes")),
	  "value" => ''
    )	
);

vc_add_param( 'vc_row' , array(
      "type" => "dropdown",
      "heading" => __("Triangle Location","brad-framework"),
      "param_name" => "triangle_location",
	  "dependency" => array("element" => "enable_triangle", "value" => array("yes")),
	  "value" => array(
		__("Top","brad-framework") => "top",
		__("Bottom","brad-framework")  => "bottom",
	   )
    )
);	
 
 
 
 vc_map( array(
	"name" => __( "Column", "js_composer" ),
	"base" => "vc_column_inner",
	"class" => "",
	"icon" => "",
	"wrapper_class" => "",
	"controls" => "full",
	"allowed_container_element" => array("vc_feature_boxes","vc_food_menus") ,
	"content_element" => false,
	"is_container" => true,
	"params" => array(
		
		array(
			"type" => "textfield",
			"heading" => __( "Extra class name", "js_composer" ),
			"param_name" => "el_class",
			"value" => "",
			"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" )
		)
	),
	"js_view" => 'VcColumnView'
) );
 
 
 
 
 
 /* Brad Slider */
/*---------------------------------------------------------*/
 
class WPBakeryShortCode_Vc_Bradslider extends WPBakeryShortCode {}
 
vc_map( array(
  "name"  => __("Brad Slider", "brad-framework"),
  "base" => "vc_bradslider",
  "show_settings_on_create" => true ,
  "is_container" => false,
  "icon" => "vc_icon_bradslider",
  "class" => "vc_icon_bradslider",
  "category" => __('Content', "brad-framework"),
  "params" => array(
   
    array(
      "type" => "dropdown",
      "heading" => __("Slider Type ?", "brad-framework"),
      "param_name" => "type",
	  "value" => Array("Gallery Slider"=>'gallery' , 'Post Slider' => 'post')
	),
	
    array(
      "type" => "taxonomy",
      "heading" => __("Slider Locations", "brad-framework"),
      "param_name" => "category",
      "value" => "" ,
	  "taxonomy" => "bradslider-category" ,
	  "dependency" => array("element" => "type" , "value" => array("gallery") )
	  ),

  	  
	array(
      "type" => "taxonomy",
      "heading" => __("Post Categories", "brad-framework"),
      "param_name" => "post_category",
      "value" => "" ,
	  "taxonomy" => "category" ,
	  "dependency" => array("element" => "type" , "value" => array("post") )
	 ),
	 
	 array( 
		"type" => "dropdown",
		"heading" => __("Order by", "brad-framework"),
		"param_name" => "orderby",
		"value" => array(  __("Date", "brad-framework") => "date", __("ID", "brad-framework") => "ID",  __("Title", "brad-framework") => "title", __("Modified", "brad-framework") => "modified", __("Random", "brad-framework") => "rand", __("Menu order", "brad-framework") => "menu_order" ),
		"description" => sprintf(__('Select how to sort retrieved posts. More at %s.', 'brad-framework'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>'),
		"dependency" => array("element" => "type" , "value" => array("post") )
) ,

  array(
	   "type" => "dropdown",
	   "heading" => __("Order", "brad-framework"),
	   "param_name" => "order",
	   "dependency" => array("element" => "type" , "value" => array("post") ),
	   "value" => array( __("Descending", "brad-framework") => "DESC", __("Ascending", "brad-framework") => "ASC" ),
	   "description" => sprintf(__('Designates the ascending or descending order. More at %s.', 'brad-framework'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
) ,

  array(
      "type" => "dropdown",
      "heading" => __("Show Date ?", "brad-framework"),
      "param_name" => "show_date",
	  "value" => Array("Yes"=>'yes','No'=>'no'),
	  "dependency" => array("element" => "type" , "value" => array("post") )
	)
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Show Catrgories ?", "brad-framework"),
      "param_name" => "show_categories",
	  "value" => Array("Yes"=>'yes','No'=>'no'),
	  "dependency" => array("element" => "type" , "value" => array("post") )
	)
	,
	
  array(
      "type" => "dropdown",
      "heading" => __("Show Excerpt ?", "brad-framework"),
      "param_name" => "show_excerpt",
	  "value" => Array("Yes"=>'yes','No'=>'no'),
	  "dependency" => array("element" => "type" , "value" => array("post") )
	)
	,	
  
  array(
      "type" => "textfield",
      "class" => "",
	  "heading" => __("Excerpt Length","brad-framework"),
      "param_name" => "excerpt_length",
	  "value" => "35" ,
	  "dependency" => array("element" => "show_excerpt" , "value" => array("yes") )
	 ),
	 
  array(
      "type" => "textfield",
      "class" => "",
	  "heading" => __("Max. number of post to shoe","brad-framework"),
      "param_name" => "max",
	  "value" => "8" ,
	  "dependency" => array("element" => "type" , "value" => array("post") )
	 ),	 
	 	
  array(
      "type" => "dropdown",
      "heading" => __("Show Readmore ?", "brad-framework"),
      "param_name" => "show_readmore",
	  "value" => Array("Yes"=>'yes','No'=>'no'),
	  "dependency" => array("element" => "type" , "value" => array("post") )
	)
	,	
     
  array(
      "type" => "textfield",
      "heading" => __("Slider Height", "brad-framework"),
      "param_name" => "height",
      "value" => "500",
	  "description" => "Slider height in \"px\" . Do't included px just numbers."
    )  
   ,
   
   
   
    array(
      "type" => "checkbox",
      "heading" => __("Full Screen Height ?", "brad-framework"),
      "param_name" => "fullheight",
	  "value" => Array("Yes"=>'yes')
	)
   ,
   
   array(
      "type" => "textfield",
      "class" => "",
	  "heading" => __("Slider Max Width","brad-framework"),
      "param_name" => "max_width",
	  "description" => 'You can use values such as 800px , 80% etc' ,
	  "value" => "1210px"
	 ),	 
   
   
   array(
      "type" => "checkbox",
      "heading" => __("Enable Parallax ?", "brad-framework"),
      "param_name" => "parallax",
	  "description" => "Check this option if you want to enable parallax scrolling for this slider",
	  "value" => Array("Yes"=>'yes'),
	  "dependency" => array("element" => "height","is_empty" => true)
	)
	,
	
	
	array(
      "type" => "textfield",
      "heading" => __("Autoplay Interval ?", "brad-framework"),
      "param_name" => "interval",
	  "value" => "5000",
	  'descrpition' => 'Use the value 0 to stop autoplay'

    ),
	
	
	array(
      "type" => "dropdown",
      "heading" => __("Show Navigation ?", "brad-framework"),
      "param_name" => "navigation",
	  "value" => Array(
	       "Yes"=>'yes',
		   "No" => "no" ) ,
	)
  ,
   array(
      "type" => "dropdown",
      "heading" => __("Show Pagination ?", "brad-framework"),
      "param_name" => "pagination",
	  "value" => Array(
	       "Yes"=>'yes',
		   "No" => "no" ) 
	   )
    )
  )
);
  
 
 
 /* Vc icon */ 
 vc_map( array(
  "name"  => __("Icon", "brad-framework"),
  'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/css/brad-vc.css'),
  "add_title" => __("Add New Icon", "brad-framework") ,
  "base" => "vc_icon",
  "show_settings_on_create" => true ,
  "is_container" => false,
  "icon" => "vc_icon_star",
  "class" => "vc_icon_star",
  "category" => __('Content', "brad-framework"),
  "params" => array(
      array(
		'param_name' => 'icon',
		'type' => 'brad_iconpicker',
		'heading' => __('Icon', 'brad_framework'),
		"admin_label" => true
		)
	,
	
	array(
	'param_name' => 'alpha',
	'type'  => 'textfield' ,
	'value' => '',
	'heading' => 'Alphabet',
	'description' => 'Put any number or text if you want to use it in place of icon'
	)
	,
	 array(
		'type' => 'dropdown',
		'param_name' => 'size' ,
		'heading' => __('Icon Size', 'brad_framework'),
		'description' => __('Select the Icon size.', 'brad_framework'),
		'value' => array(
			'Normal' => 'normal',
			'Medium' => 'medium',
			'Large' => 'large' ,
			'Extra Large' => 'ex-large')
		),	
		   
	 array(
		'param_name' => 'align' ,
		'type' => 'dropdown',
		'heading' => __('Align', 'brad_framework'),
		'value' => array(
		  'Justify' => '' ,
		  'Center'  => 'center' )
		),
		
    array(
		  'param_name' => 'style',
		  'type' => 'dropdown',
		  'heading' => __('Style', 'brad_framework'),
		  'value' => array(
			  'Only Icon' => 'style1',
			  'Icon With Border' => 'style2',
			  'Icon With Background' => 'style3'
			  )
		),
		
	 array(
	    'param_name' => 'link' ,
	    'type' => 'textfield',
		'heading' => 'Icon Link',
		'description' => 'Leave blank if you do\'t want to have a link for icon',
	),
	
	 array(
	   'param_name' => 'lb' ,
	   'type' => 'checkbox',
	   'value' => Array(__('Yes please','brad-framework') => 'yes'),
	   'heading' => __('Open Above link in lightbox? ' , 'brad-framework')
    )
	,
		
	 array(
	   'param_name' => 'color' ,
	   'type' => 'colorpicker',
	   'heading' => __('icon Color','js_composer'),
	   'description' => __('Leave Blank for Default','brad-framework') ,
	   ),
		   
     array(
	   'param_name' => 'color_hover' ,
	   'type' => 'colorpicker',
	   'heading' => __('icon Color on hover','js_composer'),
	   'description' => __('Leave Blank for Default','brad-framework') ,
	   ),
		   	
	 array(
		'param_name' => 'border_color' ,
		'type' => 'colorpicker',
		'heading' => __('Icon Boder Color ', 'brad_framework'),
		'dependency' => array("element" => "style" , "value" => array("style2")) ,
		'description' => 'Leave blank for Default <strong>Note:</strong> This option work only for icons style2'
	),	
	
	 array(
		'param_name' => 'border_width' ,
		'type' => 'textfield',
		'heading' => __('Border Width ', 'brad_framework'),
		'value' => '1' ,
		'dependency' => array("element" => "style" , "value" => array("style2")) ,
		'description' => 'Default border width in px <strong>Note:</strong> This option work only for icons style2'
	),		
		
	 array(
		'param_name' => 'border_opacity' ,
		'type' => 'textfield',
		'value' => '1' ,
		'heading' => __('Icon Border Color opacity', 'brad_framework'),
		'dependency' => array("element" => "style" , "value" => array("style2")) ,
		'description' => 'Leave blank for Default <strong>Note:</strong> This option work only for icons style2'
	),				
		
					   	
	array(
		'param_name' => 'bg_color' ,
		'type' => 'colorpicker',
		'heading' => __('Icon Background Color', 'brad_framework'),
		'description' => 'Leave blank for Default <strong>Note:</strong> This option work only for icons style3',
		'dependency' => array("element" => "style" , "value" => array("style3")) ,
	),	
		
	 array(
		'param_name' => 'bg_opacity',
		'type' => 'textfield',
		'value' => '1' ,
		'heading' => __('Icon Background Color opacity ', 'brad_framework'),
		'dependency' => array("element" => "style" , "value" => array("style3")) ,
		'description' => 'Leave blank for Default <strong>Note:</strong> This option work only for icons style3'
	),	
		
   
	 array(
		'param_name' => 'bg_color_hover' ,
		'type' => 'colorpicker',
		'heading' => __('Icon Background Color on Hover', 'brad_framework'),
		'dependency' => array("element" => "style" , "value" => array("style3")) ,
		'description' => 'Leave blank for Default <strong>Note:</strong> This option work only for icons style2 and Icon Style 3'
	),	
		
	array(
		'param_name' => 'bg_opacity_hover' ,
		'type' => 'textfield',
		'value' => '1' ,
		'dependency' => array("element" => "style" , "value" => array("style3")) ,
		'heading' => __('Icon Background Color opacity on hover', 'brad_framework'),
		'description' => 'Leave blank for Default'
	),	
				
	 array(
	   'param_name' => 'enable_crease' ,
	   'type' => 'checkbox',
	   'value' => Array(__('Yes please','brad-framework') => 'yes'),
	   'heading' => __('Enable Crease Background ? ' , 'brad-framework'),
	   'description' => ' Check this if you want to enable a crease backgound for icon style 2 or icon style3 ') ,
  
    $add_css_animation,
    $add_css_animation_delay,
    $extra_class
  	   
  )
)
);


/* Testimonials
---------------------------------------------------------------*/
 class WPBakeryShortCode_Vc_Testimonials extends WPBakeryShortCode {}
 
vc_map( array(
  "name"  => __("Testimonials", "brad-framework"),
  "add_title" => __("Add New Testimonial", "brad-framework") ,
  "base" => "vc_testimonials",
  "show_settings_on_create" => true ,
  "is_container" => true,
  "icon" => "vc_icon_testimonials",
  "class" => "vc_icon_testimonials",
  "category" => __('Content', "brad-framework"),
  "params" => array(
  
   array(
      "type" => "taxonomy",
      "heading" => __("Testimonial Category", "brad-framework"),
      "param_name" => "categories",
      "value" => "" ,
	  "taxonomy" => "testimonials-category"
	),
	
	
    array(
      "type" => "dropdown",
      "heading" => __("Testimonials Appearance", "brad-framework"),
	  "param_name" => "appearance",
      "value" => Array ( __("Columns","brad-framework") => "columns"  ,__("Carousel") => "carousel")
    )
	,
	
	array(
      "type" => "checkbox",
      "heading" => __("Enable Masonry Layout", "brad-framework"),
	  'description' => 'To change the columns width for each testiomonial , Edit the testimonial and set the column width ' ,
      "param_name" => "masonry",
      "value" => array( __('Yes',"brad-framework") => 'yes'),
	  "dependency" => Array('element' => "appearance", 'value' => array('columns'))
    )  
   , 
   $add_box_padding,
   $add_box_vpadding,
	
    array(
      "type" => "dropdown",
      "heading" => __("Columns", "brad-framework"),
      "param_name" => "columns",
      "value" => array( 2 ,3 , 4 , 5 , 6 ),
      "description" => "Set the number of Columns.",
	  "dependency" => Array('element' => "appearance", 'value' => array('columns'))
	  )
	 ,
	 
	 array(
      "type" => "dropdown",
      "heading" => __("Testimonial Style", "brad-framework"),
      "param_name" => "bg_style",
      "value" => array(   __('With White Smoke Bg',"brad-framework") => 'appear1'  ,__('With White Bg',"brad-framework") => 'appear2' ,__('With 1px Stroke',"brad-framework") => 'appear3' , __('With Fancy Divider',"brad-framework") => 'style2' ),
	  "dependency" => Array('element' => "appearance", 'value' => array('columns'))
    )  
   , 
   
   
   array(
      "type" => "dropdown",
      "heading" => 'Fancy divider style',
      "param_name" => "fancy_di_style",
      "value" => array(  'solid' => 'solid'  , 'dashed' => 'dashed' ),
	  "dependency" => Array('element' => "bg_style", 'value' => array('style2'))
    )  
   , 
   
   array(
      "type" => "dropdown",
      "heading" => __("Testimonial Style", "brad-framework"),
      "param_name" => "bg_style_carousel",
      "value" => array(   __('With White Smoke Bg',"brad-framework") => 'appear1'  ,__('With White Bg',"brad-framework") => 'appear2' ,__('With 1px Stroke',"brad-framework") => 'appear3' , __('Transparent',"brad-framework") => 'appear4' ),
	  "dependency" => Array('element' => "appearance", 'value' => array('carousel'))
    )  
   , 
	
   /* 
   array(
      "type" => "dropdown",
      "heading" => __("Carousel Columns", "brad-framework"),
      "param_name" => "carousel_columns",
      "value" => array( 1 , 2 , 3 , 4 ),
      "description" => __("Set the number of Columns.", "brad-framework"),
	  "dependency" => Array('element' => "appearance", 'value' => array('carousel'))
	  )
	  , 
	 */  
   
   $add_autoplay_dependency 
   , 
   
   array(
      "type" => "textfield",
      "heading" => __("Delay/Autoplay Interval", "brad-framework"),
      "param_name" => "speed",
      "value" => "4000",
	  "dependency" => Array('element' => "appearance", 'value' => array('carousel'))
    )  
   , 
   
   array(
      "type" => "dropdown",
      "heading" => __("Display Navigation", "brad-framework"),
      "param_name" => "navigation",
      "value" => array(   __('No',"brad-framework") => 'no'  ,__('Yes',"brad-framework") => 'yes' ),
	  "dependency" => Array('element' => "appearance", 'value' => array('carousel'))
    )  
   , 
   
   
   array(
      "type" => "dropdown",
      "heading" => __("Display Pagination", "brad-framework"),
      "param_name" => "pagination",
      "value" => array(   __('No',"brad-framework") => 'no'  ,__('Yes',"brad-framework") => 'yes' ),
	  "dependency" => Array('element' => "appearance", 'value' => array('carousel'))
    )  
   , 
   
   array(
      "type" => "dropdown",
      "heading" => __("Navigation Align", "brad-framework"),
      "param_name" => "navigation_align",
      "value" => array( __('Side',"brad-framework") => '' , __('Bottom',"brad-framework") => 'bottom' ),
	  "dependency" => Array('element' => "navigation", 'value' => array('yes'))
    )  
   , 
   
	
   array(
      "type" => "checkbox",
	  "heading" => __("Rounded Image","brad-framework"),
	  "param_name" => "rounded_image",
	  "value" => array(__("Yes","brad-framework") => "yes")
	  ),
	  		
   $add_bottom_margin,
   $add_css_animation,
   $add_css_animation_delay,
   array(
      "type" => "dropdown",
      "heading" => __("Apply Css Animation to ?", "brad-framework"),
      "param_name" => "css_animation_type",
	  "value" => array(__('Whole Testimonial Content',"brad-framework") => 'box' , __('Only Testimonial Image',"brad-framework") => 'iconbox' ),
	  "dependency" => Array('element' => "appearance", 'value' => array('columns'))
  ),
    
  $add_order,
  $add_order_by,
	
	array(
      "type" => "textfield",
      "heading" => __("Testimonials Count", "brad-framework"),
	  "param_name" => "count",
      "value" => 5
    )
	,
   $extra_class	 
   
  )
 )
);



/* clients
---------------------------------------------------------------*/
class WPBakeryShortCode_VC_Clients extends WPBakeryShortCode {};

vc_map( array(
  "name"  => __("Clients", "brad-framework"),
  "base" => "vc_clients",
  "show_settings_on_create" => true ,
  "add_title" => __("Add New Client", "brad-framework") ,  
  "icon" => "vc_icon_clients",
  "category" => __('Content', "brad-framework"),
  "params" => array(
   array(
      "type" => "taxonomy",
      "heading" => __("Clients Category", "brad-framework"),
      "param_name" => "categories",
      "value" => "" ,
	  "taxonomy" => "clients-category",
	  "description" => "Narrow your output by selecting desired categories",
	),
	
	$add_order,
	$add_order_by,
	
	array(
      "type" => "textfield",
      "heading" => __("Clients Max Count", "brad-framework"),
	  "param_name" => "count",
      "value" => 5
    )
	,
	$add_img_size,
	$add_custom_img_size,
    array(
      "type" => "dropdown",
      "heading" => __("Clients Appearance", "brad-framework"),
	  "param_name" => "appearance",
      "value" => Array ( __("Columns","brad-framework") => "columns"  ,__("Carousel") => "carousel"),
	  "admin_label" => true
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Columns Count", "brad-framework"),
      "param_name" => "columns",
      "value" => array( 2 ,3 , 4 , 5 , 6 ),
      "description" => "Set the number of Columns.",
	  "admin_label" => true
	  )
	 ,
	 
	 array(
      "type" => "dropdown",
      "heading" => __("Container Style", "brad-framework"),
      "param_name" => "style",
      "value" => array('No divider' => 'style1','With Fancy Divider' => 'style2','Box Type' => 'style3'),
      "description" => "Default Style for Clients  Container",
    )  
  ,
  $add_box_bgcolor,
  $add_box_opacity,
  $add_box_bgcolor_hover,
  $add_box_opacity_hover,
  $add_box_radius,
  $add_box_stroke_color,
  $add_box_stroke_color_hover,
  $add_box_padding ,
  $add_box_vpadding,
  $add_inner_vpadding ,
  $add_inner_hpadding ,
  $add_autoplay_dependency 
  , 
  array(
      "type" => "checkbox",
      "heading" => __("Show Navigation Icons ?", "brad-framework"),
      "param_name" => "navigation",
	  "value" => Array( "Yes"=> 'yes' ),
	  "dependency" => Array('element' => "appearance", 'value' => array('carousel'))
  ),
  
  array(
      "type" => "checkbox",
      "heading" => __("Show Pagination ?", "brad-framework"),
      "param_name" => "pagination",
	  "value" => Array( "Yes"=> 'yes' ),
	  "dependency" => Array('element' => "appearance", 'value' => array('carousel'))
  ),
 
  $add_css_animation,
  $add_css_animation_delay ,
  $extra_class	 
 )
) );





class WPBakeryShortCode_VC_Box extends WPBakeryShortCodesContainer {
}
/* Vc Box view */
vc_map( array(
  "name" => __("Box", "brad-framework"),
  "base" => "vc_box",
  "is_container" => true,
  "class" => "vc_icon_box",
  "icon" => "vc_icon_box",
  "show_settings_on_create" => true ,
  "category" => __('Content', "brad-framework"),
  "params" => array(
   array(
      "type" => "colorpicker",
      "heading" => __("Box Background color", "brad-framework"),
      "param_name" => "bg_color",
	  "value" => "" ,
	  ),
	  
  array(
      "type" => "textfield",
      "heading" => __("Background Opacity", "brad-framework"),
      "param_name" => "opacity",
	  "value" => "1",
	  "description" => "The value should be in betweem 0 and 1 , for ex. 0.755"
	  ),	
	  
array(
      "type" => "colorpicker",
      "heading" => __("Box Border color", "brad-framework"),
      "param_name" => "br_color",
	  "value" => "" 
	  ),
	  
  
  array(
      "type" => "textfield",
      "heading" => __("Border Width", "brad-framework"),
      "param_name" => "br_width",
	  "value" => "1"
   ),	 	    

  array(
      "type" => "checkbox",
      "heading" => __("Enable Top Radius", "brad-framework"),
      "param_name" => "br_top",
	  "value" => array(__("Yes","brad-framework") => "yes" )
	  ),
	  
  array(
      "type" => "checkbox",
      "heading" => __("Enable Bottom Radius", "brad-framework"),
      "param_name" => "br_bottom",
	  "value" => array(__("Yes","brad-framework") => "yes" )
	  ),
	  
   array(
      "type" => "textfield",
      "heading" => __("Padding", "brad-framework"),
      "param_name" => "padding",
	  "value" => "20px" ,
	  "description" => "Default padding in px . You can put formats like '20px' or '10px 20px 10px' or any css padding pattern."
	  ),	  	  
	  	  
   array(
      "type" => "dropdown",
      "heading" => __("box Text color Scheme ?", "brad-framework"),
      "param_name" => "color_scheme",
	  "value" => array(
	               __('Default Text',"brad-framework") => '' , 
	               __('All text to White',"brad-framework") => 'scheme1' 
				   )			   
    ),
	$add_hidden_array,		
    $extra_class 
  ),
   "js_view" => 'VcColumnView'
) );



 
 /* Features Boxes
---------------------------------------------------*/
class WPBakeryShortCode_vc_Feature_Boxes extends WPBakeryShortCodesContainer {
}

class WPBakeryShortCode_vc_Feature_Box extends WPBakeryShortCode {
}

vc_map( array(
  "name"  => __("Feature Boxes", "brad-framework"),
  "base" => "vc_feature_boxes",
  "js_view" => 'VcColumnView',
  "as_parent" => array('only' => 'vc_feature_box'),
  "is_container" => true , 
  "show_settings_on_create" => true ,
  "add_title" => __("Add New Feature Box", "brad-framework") ,
  "icon" => "vc_icon_features",
  "class" => "vc_icon_features",
  "category" => __('Content', "brad-framework"),
  "params" => array(
    array(
      "type" => "dropdown",
      "heading" => __("Columns Count", "brad-framework"),
      "param_name" => "columns",
      "value" => array( "Default Two Columns" => 2 , " Single Column" => 1 , "Three columns" => 3 ,"Four Columns" => 4 ,"Five Columns" => 5 ,"Six Columns" => 6  ),
      "description" => "Set the number of Columns.",
    )
	,
	array(
      "type" => "dropdown",
      "heading" => __("Feature Box Container Style", "brad-framework"),
      "param_name" => "style",
      "value" => array( 'Style 1 (Default)' => 'style1' ,'Style 2 (Fancy Divider)' => 'style2' ,'Style 3 (Box Type)' => 'style3' ),
      "description" => "Default Style for Feature Box Container."
    ),
	
  $add_box_padding,
  $add_box_vpadding,
  $add_box_bgcolor,
  $add_box_bgcolor_hover,
  $add_box_opacity,
  $add_inner_hpadding,
  $add_inner_vpadding,
  $add_box_shadow,
  $add_box_radius,
  $add_box_stroke_color,
  $add_box_stroke_opacity,
 
  array(
      "type" => "dropdown",
      "heading" => __("Feature Box Style ", "brad-framework"),
      "param_name" => "box_style",
      "value" => array( 'Icon with Title' => 'style1' , 'Icon on Side' =>  'style2' , 'Icon on Top' => 'style3' )
    ),
	
  array(
      "type" => "dropdown",
      "heading" => __("Icon Side", "brad-framework"),
      "param_name" => "icon_side",
      "value" => array( __('Left',"brad-framework") => 'left' , __('Right',"brad-framework") =>  'right' ),
	  "dependency" => array("element" => "box_style" , "value" => array("style2") )
    ),
	
   array(
      "type" => "checkbox",
      "heading" => __("Align Feature Box Content to Center", "brad-framework"),
      "param_name" => "fc_align",
      "value" => array( __('Yes' , 'brad-framework') => 'yes'),
	  "dependency" => Array('element' => "box_style", 'value' => array('style3'))
   ),

   array(
      "type" => "checkbox",
      "heading" => __("Align Feature Box Icon to Center", "brad-framework"),
      "param_name" => "fi_align",
      "value" => array( __('Yes' , 'brad-framework') => 'yes'),
	  "dependency" => Array('element' => "box_style", 'value' => array('style3'))
    ),
	
	$add_divider,
	$add_divider_color,
	$add_divider_style,
	$add_divider_type,
	
   array(
        "type" => "dropdown",
        "heading" => __("Feature Box Icon Style", "brad-framework"),
        "param_name" => "icon_style",
        "value" => array( 'Simple Icon' => 'style1' , 'Icon with Border' =>  'style2' , 'Icon with Background' => 'style3')
	),
	 
   array(
      "type" => "dropdown",
      "heading" => __("Feature Box Icon Size", "brad-framework"),
      "param_name" => "icon_size",
      "value" => array( __('Normal',"brad-framework") => 'normal' , __('Large',"brad-framework") =>  'large' , __('Extra Large',"brad-framework") =>  'ex-large'  ,  __('Extra Large Alt',"brad-framework") =>  'extra-large' )
    ),
	
	array(
      "type" => "textfield",
      "heading" => __("Feature Box Icon Border Width", "brad-framework"),
      "param_name" => "icon_bw",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style2')),
      "value" => '1'
   ),	
	 	
	array(
      "type" => "textfield",
      "heading" => __("Feature Box Icon Border Radius", "brad-framework"),
      "param_name" => "icon_br",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style3','style2')),
      "value" => '50%',
	  'description' => 'You can use values such as "5o%" or 4px '
   ),	
   	   
   array(
      "type" => "colorpicker",
      "heading" => __("Feature Box Icon Color", "brad-framework"),
	  "description" => "Leave Blank for default color",
      "param_name" => "icon_c",
      "value" => ''
    ),
	  
   array(
      "type" => "textfield",
      "heading" => __("Feature Box Icon Color Opacity", "brad-framework"),
      "param_name" => "icon_c_opc",
      "value" => '1'
   ),  
     
  array(
      "type" => "colorpicker",
      "heading" => __("Feature Box Icon  Color on hover", "brad-framework"),
	  "description" => "Leave Blank for Same",
      "param_name" => "icon_c_hover",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style3','style2')) ,
      "value" => ''
   ),	

  array(
      "type" => "textfield",
      "heading" => __("Feature Box Icon Color Opacity on hover", "brad-framework"),
      "param_name" => "icon_c_hover_opc",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style3','style2')) ,
      "value" => '1'
    ),  
	
  array(
      "type" => "textfield",
      "heading" => __("Feature Box Icon Border Width", "brad-framework"),
      "param_name" => "icon_bw",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style2')),
      "value" => '1'
   ),	
	  	  	  
  array(
      "type" => "colorpicker",
      "heading" => __("Feature Box Icon Border Color", "brad-framework"),
	  "description" => "Leave Blank for default border color",
      "param_name" => "icon_bc",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style2')),
      "value" => ''
      ),
	  
 array(
      "type" => "textfield",
      "heading" => __("Feature Box Icon Border Opacity", "brad-framework"),
      "param_name" => "icon_bc_opacity",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style2')),
      "value" => '1'
      ),	  
	  	  	  
  array(
      "type" => "colorpicker",
      "heading" => __("Feature Box Icon Background Color", "brad-framework"),
	  "description" => "Leave Blank for default background color",
      "param_name" => "icon_bgc",
      "value" => '',
	  "dependency" => Array('element' => "icon_style", 'value' => array('style3'))
      ),
  
  array(
      "type" => "textfield",
      "heading" => __("Feature Box Icon Bg Color Opacity", "brad-framework"),
      "param_name" => "icon_bgc_opacity",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style3')),
      "value" => '1'
      ),
	  	  

  array(
      "type" => "colorpicker",
      "heading" => __("Feature Box Icon Background Color on hover", "brad-framework"),
	  "description" => "Leave Blank for Same",
      "param_name" => "icon_bgc_hover",
      "value" => '',
	  "dependency" => Array('element' => "icon_style", 'value' => array('style3','style2'))
      ),	
	  
 array(
      "type" => "textfield",
      "heading" => __("Feature Box Icon Bg Color Opacity on hover", "brad-framework"),
      "param_name" => "icon_bgc_opacity_hover",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style2','style3')),
      "value" => '1'
      ),	    	  
  
  $extra_class	 	    	  
  ) 
 )
);
  
  
 
  // Feature Box
  vc_map( array(
   "name"  => __("Feature Box", "brad-framework"),
   "base" => "vc_feature_box",
   "as_child" => array('only' => 'vc_feature_boxes'),
   "show_settings_on_create" => true ,
   "class" => "vc_icon_feature",
   "icon" => "vc_icon_feature",
   "category" => __('Content', "brad-framework"),
   "params" => array(
   
   array(
      "type" => "textfield",
      "heading" => __("Feature Link", "brad-framework"),
      "param_name" => "feature_link",
	  "description" => "Leave blank if you do't want to have a link for whole box.",
	),	
	
	array(
      "type" => "dropdown",
      "heading" => __("Link Target", "brad-framework"),
      "param_name" => "ftarget",
      "value" => $target_arr,
      "dependency" => Array('element' => "href", 'not_empty' => true)
    ),	
	
   array(
      "type" => "brad_iconpicker",
      "heading" => __("Featured Icon", "brad-framework"),
      "param_name" => "icon"  
    ),
	
  array(
      "type" => "textfield",
      "heading" => __("Icon Link", "brad-framework"),
      "param_name" => "icon_link",
	  "description" => "Leave blank if you do't want to have a link for icon",
	  "dependency" => array("element" => "feature_link" , "is_empty" => true )
	),	
	
  array(
      "type" => "textfield",
      "heading" => __("Feature Alphabet", "brad-framework"),
	  "description" => "Feature Alphabet text if you want display text inplace of icon. <strong>Note:</strong>If this field has some value then icon will not be display and also you should use max 2 or 3 Words.",
      "param_name" => "text" ,
   ),
   
  array(
      "type" => "attach_image",
      "heading" => __("Image", "brad-framework"),
      "param_name" => "image",
	  "descrpition" => 'This will replace both icon and alphabet text'
    ),	

  array(
      "type" => "textfield",
      "heading" => __("Sub Title", "brad-framework"),
      "param_name" => "sub_title"
	),	
 
  array(
      "type" => "textfield",
      "heading" => __("Title", "brad-framework"),
      "param_name" => "title",
	  "value" => __("Your Title Here ...","brad-framework"),
	  "admin_label" => true
	),

  array(
      "type" => "textfield",
      "heading" => __("Title Link", "brad-framework"),
      "param_name" => "title_link",
	  "dependency" => array("element" => "feature_link" , "is_empty" => true ),
	  "description" => "Leave blank if you do't want to have a link for icon",
	),		
		
 array(
      "type" => "dropdown",
      "heading" => __("Link Target", "brad-framework"),
      "param_name" => "ttarget",
      "value" => $target_arr,
      "dependency" => Array('element' => "href", 'not_empty' => true)
   ),		
	
  array(
      "type" => "dropdown",
      "heading" => __("Title Heading Type", "brad-framework"),
      "param_name" => "title_heading",
	  "value" => array(
	       __("h4 (Default)","brad-framework") => "h4" ,
		   __("h1","brad-framework") => "h1" ,
		   __("h2","brad-framework") => "h2" ,
		   __("h3","brad-framework") => "h3" ,
		   __("h5","brad-framework") => "h5" ,
		   __("h6","brad-framework") => "h6" 
		   )
	),	  
	  
   array(
      "type" => "textarea_html",
      "heading" => __("Content", "brad-framework"),
      "param_name" => "content",
	  "value" => ''
    )
  ,
  $add_css_animation, 
  $add_css_animation_delay, 
  array(
      "type" => "dropdown",
      "heading" => __("Apply Css Animation to ?", "brad-framework"),
      "param_name" => "css_animation_type",
	  "value" => array(__('Whole Box',"brad-framework") => 'box' , __('Only Icons and Images',"brad-framework") => 'iconbox' )
  )	
 )
	
 )
 );



class WPBakeryShortCode_Vc_Services_Box extends WPBakeryShortCode {
}

  // Service Box
  vc_map( array(
   "name"  => __("Services Box", "brad-framework"),
   "base" => "vc_services_box",
   "show_settings_on_create" => true ,
   "is_container" => false ,
   "icon" => "vc_icon_service",
   "class" => "vc_icon_service",
   "content_element" => true ,
   "category" => __('Content', "brad-framework"),
   "params" => array(
   
   
   array(
      "type" => "textfield",
      "heading" => __("Custom Link", "brad-framework"),
      "param_name" => "link" ,
	  "description" => __("Enter the  link. Do't forget to include http:// ", "brad-framework")
    ),
	
	
	array(
      "type" => "dropdown",
      "heading" => __("Target", "brad-framework"),
      "param_name" => "target",
      "value" => $target_arr,
      "dependency" => Array('element' => "link", 'not_empty' => true)
    ),
	
   array(
      "type" => "brad_iconpicker",
      "heading" => __("Service Icon", "brad-framework"),
      "param_name" => "icon" 
    ),
	
 	
  	
  array(
      "type" => "textfield",
      "heading" => __("Title", "brad-framework"),
      "param_name" => "title",
	  "value" => __("Your Title Here ...","brad-framework"),
	  "admin_label" => true 
     ),  
	  
   array(
      "type" => "textarea",
      "heading" => __("Description", "brad-framework"),
      "param_name" => "desc" 
    ),
	
  array(
      "type" => "textfield",
      "heading" => __("Title Over Flip", "brad-framework"),
      "param_name" => "title_flip",
	  "value" => __("Your Title Here ...","brad-framework")
	),  
	
   array(
      "type" => "textarea_html",
      "heading" => __("Content over Flip", "brad-framework"),
      "param_name" => "content",
	  "value" => "", 
    ),
  
  array(
      "type" => "textfield",
      "heading" => __("Min Height", "brad-framework"),
      "param_name" => "height",
	  "description" => 'Min height in px' ,
	  "value" => "" ,
	),  
	
   array(
        "type" => "dropdown",
        "heading" => __("Icon Style", "brad-framework"),
        "param_name" => "icon_style",
        "value" => array( 'Only Icon' => 'style1' , 'Icon with Border' =>  'style2' , 'Icon with Background' => 'style3')
	),
	
  array(
        "type" => "textfield",
        "heading" => __("Icon Border Radius", "brad-framework"),
        "param_name" => "icon_radius",
        "value" => "50%"
	),
	 
  array(
      "type" => "dropdown",
      "heading" => __("Icon Size", "brad-framework"),
      "param_name" => "icon_size",
      "value" => array(  __('Extra Large',"brad-framework") =>  'ex-large'  , __('Normal',"brad-framework") => 'normal' , __('Large',"brad-framework") =>  'large' )
    ),
	
  array(
      "type" => "colorpicker",
      "heading" => __("Icon Color", "brad-framework"),
	  "description" => "Leave Blank for default color",
      "param_name" => "icon_c",
      "value" => ''
    ),
	  
   
  array(
      "type" => "colorpicker",
      "heading" => __("Feature Box Icon Border Color", "brad-framework"),
	  "description" => "Leave Blank for default border color",
      "param_name" => "icon_bc",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style2')),
      "value" => ''
      ),

  
  array(
      "type" => "colorpicker",
      "heading" => __("Feature Box Icon Background Color", "brad-framework"),
	  "description" => "Leave Blank for default background color",
      "param_name" => "icon_bgc",
      "value" => '',
	  "dependency" => Array('element' => "icon_style", 'value' => array('style3'))
      ),

 
  array(
        "type" => "textfield",
        "heading" => __("Front & Flip Box Border Radius", "brad-framework"),
        "param_name" => "radius",
        "value" => "5px"
	),	
  
  array(
      "type" => "colorpicker",
      "heading" => __("Front Box Background", "brad-framework"),
      "param_name" => "bg_front",
      "value" => ''
    ),
	
  array(
      "type" => "colorpicker",
      "heading" => __("Front Box Border Color", "brad-framework"),
      "param_name" => "bc_front",
      "value" => ''
    ),
	
  array(
      "type" => "colorpicker",
      "heading" => __("Front Box Title text Color", "brad-framework"),
      "param_name" => "c_front",
      "value" => ''
    ),	

  array(
      "type" => "colorpicker",
      "heading" => __("Front Box Content text Color", "brad-framework"),
      "param_name" => "c_content",
      "value" => ''
    ),	
		
  array(
      "type" => "colorpicker",
      "heading" => __("Flip Box Background", "brad-framework"),
      "param_name" => "bg_flip",
      "value" => ''
    ),
	
  array(
      "type" => "colorpicker",
      "heading" => __("Flip Box Border Color", "brad-framework"),
      "param_name" => "bc_flip",
      "value" => ''
    ),	
	
   array(
      "type" => "colorpicker",
      "heading" => __("Flip Box Title text Color", "brad-framework"),
      "param_name" => "c_flip",
      "value" => ''
    ),	

  array(
      "type" => "colorpicker",
      "heading" => __("Flip Box Content text Color", "brad-framework"),
      "param_name" => "c_content_flip",
      "value" => ''
    )
 
  )	
 ));



/* Counters
---------------------------------------------------------------*/
class WPBakeryShortCode_vc_counters extends WPBakeryShortCodesContainer {
}

class WPBakeryShortCode_vc_counter extends WPBakeryShortCode {
}
	
vc_map( array(
  "name"  => __("Counters", "brad-framework"),
  "base" => "vc_counters",
  "js_view" => 'VcColumnView',
  
  "as_parent" => array('only' => 'vc_counter'), 
  "content_element" => true,
  "show_settings_on_create" => true, 
  "add_title" => __("Add New Counter", "brad-framework") ,  
  "icon" => "vc_icon_counters",
  "category" => __('Content', "brad-framework"),
  "params" => array(
   
    array(
      "type" => "dropdown",
      "heading" => __("Columns Count", "brad-framework"),
      "param_name" => "columns",
      "value" => array( "Two (Default)" => 2  , "One" => 1 , "Three" => 3 , "Four" => 4 , "Five" =>  5 , "Six" => 6 ),
      "description" => "Set the number of Columns.",
	  "admin_label" => true
	  )
	 ,
	 
	array(
      "type" => "dropdown",
      "heading" => __("Counter Box Container Style", "brad-framework"),
      "param_name" => "style",
      "value" => array( 'Style 1 (Default)' => 'style1' ,'Style 2 (Fancy Divider)' => 'style2' ),
      "description" => "Default Style for Counter Box Container.",
    ),
	
	array(
      "type" => "checkbox",
      "heading" => __("Align to Center", "brad-framework"),
      "param_name" => "center",
      "value" => array( __('Yes','brad-framework') => 'yes')
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Counter Box Text Size", "brad-framework"),
      "param_name" => "text_size",
      "value" => array( 'Normal' => 'normal' ,'Large' => 'large' )

    ),
	
	$add_divider,
	$add_divider_color,
	$add_divider_style,
	$add_divider_type,
	
	array(
      "type" => "textfield",
      "heading" => __("Counter Box Width", "brad-framework"),
      "param_name" => "width",
	  "description" => 'Width is also adjusted by parent column so it does not overlap.' ,
      "value" => ""
    ),
	
	array(
      "type" => "textfield",
      "heading" => __("Counter Box Height", "brad-framework"),
      "param_name" => "height",
      "value" => ""
    ),
	
    array(
      "type" => "colorpicker",
      "heading" => __("Counter Box icon Color", "brad-framework"),
      "param_name" => "icon_color",
      "value" => ""
    ),
	
	
	
	array(
      "type" => "colorpicker",
      "heading" => __("Counter Box Value Color", "brad-framework"),
      "param_name" => "value_color",
      "value" => ""
    ) ,
	
	array(
      "type" => "colorpicker",
      "heading" => __("Counter Box Title Color", "brad-framework"),
      "param_name" => "title_color",
      "value" => ""
    ) ,
	
  array(
      "type" => "colorpicker",
      "heading" => __("Background Color for box", "brad-framework"),
      "param_name" => "bg_color",
      "value" => ""
    ) ,
  
  array(
      "type" => "colorpicker",
      "heading" => __("Border Color for Box", "brad-framework"),
      "param_name" => "border_color",
      "value" => ""
    ) ,

 array(
      "type" => "textfield",
      "heading" => __("Border Width", "brad-framework"),
      "param_name" => "border_width",
      "value" => "1"
    ) ,		

  array(
      "type" => "textfield",
      "heading" => __("Border Radius of box", "brad-framework"),
      "param_name" => "border_radius",
      "value" => "50%"
    ) ,	
	
  $extra_class	 
  )
 ) 
);

vc_map( array(
  "name" => __("Counter", "brad-framework"),
  "base" => "vc_counter",
  "as_child" => array('only' => 'vc_counters'), 
  "class" => "vc_sc_counter vc_custom_content_element",
  "show_settings_on_create" => true,
  "icon" => "vc_icon_counter",
  "params" => array(
   
   array(
      "type" => "brad_iconpicker",
      "heading" => __("Counter Icon", "brad-framework"),
      "param_name" => "icon"
    )
  ,
  
  array(
      "type" => "textfield",
      "heading" => __("Value to Count", "brad-framework"),
      "param_name" => "value" ,
	  "description" => "This value must be an integer", 
	  "admin_label" => true
    ),
	
	 
    array(
      "type" => "textfield",
      "heading" => __("Unit", "brad-framework"),
      "param_name" => "unit",
	  "description" => 'You can use any text such as % , cm or any other . Leave Blank if you do not want to display any unit value'
    ),
	
    array(
      "type" => "textfield",
      "heading" => __("Counter Title", "brad-framework"),
      "param_name" => "title" ,
	  "value" => __("Your Title Goes Here...","brad-framework"),
    ),

	
	$add_css_animation,
	$add_css_animation_delay
  )

) );




/* Quotes Slider */
class WPBakeryShortCode_Vc_Quotes_Slider extends WPBakeryShortCodesContainer {
}

class WPBakeryShortCode_Vc_Quote extends WPBakeryShortCode {
}
vc_map( array(
  "name"  => __("Quotes Slider", "brad-framework"),
  "base" => "vc_quotes_slider",
  "show_settings_on_create" => true ,
  "is_container" => true ,
  "js_view" => 'VcColumnView',
  "as_parent" => array('only' => 'vc_quote'), 
  "class" => "vc_icon_quotes" ,
  "icon" => "vc_icon_quotes",
  "category" => __('Content', "brad-framework"),
  "params" => array(
    array(
      "type" => "dropdown",
      "heading" => __("Enable Navigation Icons ?", "brad-framework"),
      "param_name" => "navigation",
	  "value" => array( __('No','brad-framework') => 'no' , __('Yes','brad-framework') => 'yes') 
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Enable Pagination ?", "brad-framework"),
      "param_name" => "pagination",
	  "value" => array(__('No','brad-framework') => 'no' , __('Yes','brad-framework') => 'yes') ,

    ),
	
	array(
      "type" => "dropdown",
      "heading" => __(" Navigation Icons Align ?", "brad-framework"),
      "param_name" => "navigation_align",
	  "value" => array(__('Side','brad-framework') => 'side',__('Bottom','brad-framework') => 'bottom') ,

    ),
	
	
	array(
      "type" => "dropdown",
      "heading" => __("slider Effect ?", "brad-framework"),
      "param_name" => "effect",
	  "value" => array(__('Fade','brad-framework') => 'fade',__('Slide Horizontal','brad-framework') => 'horizontal' , __('Slide Vertical','brad-framework') => 'vertical') ,

    ),
	
	$add_autoplay,
	$add_autoplay_dependency,
    $extra_class
  )
  ) );


vc_map( array(
  "name" => __("Quote", "brad-framework"),
  "base" => "vc_quote",
  "as_child" => array('only' => 'vc_quotes_slider'), 
  "class" => "vc_icon_quote",
  "icon" => "vc_icon_quote",
  "params" => array(
	array(
      "type" => "attach_image",
      "heading" => __("Person or Company Logo ", "brad-framework"),
      "param_name" => "logo"
    ),
   $add_img_size,
   $add_custom_img_size,
	array(
      "type" => "textfield",
      "heading" => __("Person Name", "brad-framework"),
      "param_name" => "person_name",
	  "value" => 'john doe' ,
	  "admin_label" => true
    ),
	array(
      "type" => "textfield",
      "heading" => __("Person Description", "brad-framework"),
      "param_name" => "person_desc"
    ),
	
	array(
      "type" => "textarea_html",
      "heading" => __("Quote Content", "brad-framework"),
      "param_name" => "content",
	  "value" => __("Your Content Goes Here...","brad-framework")
    ),
    array(
      "type" => "tab_id",
      "heading" => __("Tab ID", "brad-framework"),
      "param_name" => "tab_id"
    )
  )
) );



class WPBakeryShortCode_Vc_Teaser_Box extends WPBakeryShortCode {
}

vc_map( array(
  "name" => __("Teaser Box", "brad-framework"),
  "base" => "vc_teaser_box",
  "class" => "vc_icon_teaser",
  "icon" => "vc_icon_teaser",
  "is_container" => false,
  "content_element" => true ,
  "params" => array(
  
   array(
      "type" => "attach_image",
      "heading" => __("Image", "brad-framework"),
      "param_name" => "image",
	  "holder" => "img"
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Text Scheme", "brad-framework"),
      "param_name" => "text_scheme" ,
	  "value" => array(
	       __("Default","brad-framework") => "default" ,
		   __("White","brad-framework") => "scheme1")
    ),
	
	array(
      "type" => "textfield",
      "heading" => __("Teaser Content Border Width", "brad-framework"),
      "param_name" => "bw",
	  "value" => "1"
    ),
	
	array(
      "type" => "colorpicker",
      "heading" => __("Teaser Content Border Color", "brad-framework"),
      "param_name" => "bc"
    ),
	
	array(
      "type" => "colorpicker",
      "heading" => __("Teaser Content BG Color", "brad-framework"),
      "param_name" => "bg"
    ),
	
	array(
      "type" => "textfield",
      "heading" => __("Teaser Content BG Opacity", "brad-framework"),
      "param_name" => "bo",
	  "value" => "1" 
    ),
	
	
	array(
      "type" => "dropdown",
      "heading" => __("Teaser Vertical Alignment", "brad-framework"),
      "param_name" => "ca",
	  "value" => array("center" =>"center" , "top" => "top" , "bottom" => "bottom" )
	 
    ),
	
	
    array(
      "type" => "textfield",
      "heading" => __("Teaser Main Heading", "brad-framework"),
      "param_name" => "title"
    ),
	
	array(
      "type" => "textarea_html",
      "heading" => __("Teaser Content", "brad-framework"),
      "param_name" => "content",
	  "value" => __('That Should be any Description',"brad-framework"),
	  "hover" => "div"
    )
  )

) );


class WPBakeryShortCode_Vc_Person extends WPBakeryShortCode {
}

/* Team member
-------------------------------------------------------------*/
vc_map( array(
  "name" => __("Person", "brad-framework"),
  "base" => "vc_person",
  "icon" => "vc_icon_person",
  "class" => "vc_icon_person",
  "is_container" => false ,
  "content_element" => true,
  "params" => array(
   
	array(
      "type" => "attach_image",
      "heading" => __("Person Image", "brad-framework"),
      "param_name" => "image" 
    ),
    array(
      "type" => "textfield",
      "heading" => __("Person name", "brad-framework"),
      "param_name" => "name",
	  "admin_label" => true
    ),
    array(
      "type" => "textfield",
      "heading" => __("Person Role", "brad-framework"),
      "param_name" => "role",
	  "admin_label" => true
    ),
    array(
      "type" => "exploded_textarea",
      "heading" => __("Biography", "brad-framework"),
      "param_name" => "bio",
	  "description" => 'Leave Blank if you do not want to display biography'
    ),
	
	array(
      "type" => "textarea_html",
      "heading" => __("Overlay Content", "brad-framework"),
      "param_name" => "content",
    ),
	
	
	array(
      "type" => "checkbox",
      "heading" => __("Social Links", "brad-framework"),
      "param_name" => "social_links" ,
	  "value" => Array('Twitter'=>'twitter' ,'Facebook'=>'facebook','Linkedin'=>'linkedin','Youtube'=>'youtube','Google plus'=>'google','Behance'=>'behance','Dribbble'=>'dribbble','Pinterest'=>'pinterest')
    ),
	array(
      "type" => "textfield",
      "heading" => __("Twitter link", "brad-framework"),
      "param_name" => "twitter"
    ),
	array(
      "type" => "textfield",
      "heading" => __("Facebook link", "brad-framework"),
      "param_name" => "facebook" 
    ),
	array(
      "type" => "textfield",
      "heading" => __("linkedin link", "brad-framework"),
      "param_name" => "linkedin" 
    ),
	array(
      "type" => "textfield",
      "heading" => __("youtube link", "brad-framework"),
      "param_name" => "youtube" 
    ),
	array(
      "type" => "textfield",
      "heading" => __("google link", "brad-framework"),
      "param_name" => "google"
    ),
	array(
      "type" => "textfield",
      "heading" => __("behance link", "brad-framework"),
      "param_name" => "behance"
    ),
	array(
      "type" => "textfield",
      "heading" => __("dribbble link", "brad-framework"),
      "param_name" => "dribbble"
    ),
	array(
      "type" => "textfield",
      "heading" => __("pinterest link", "brad-framework"),
      "param_name" => "pinterest" 
    )
	,
	array(
	  "type" => "colorpicker" ,
	  "heading" => "Team Member Bg Color",
	  "param_name" => "bg_color" 
	)
	,
	array(
	  "type" => "colorpicker" ,
	  "heading" => "Team Member Text Color",
	  "param_name" => "color" 
	)
	,
	
	array(
	  "type" => "colorpicker" ,
	  "heading" => "Team Member Heading Color",
	  "param_name" => "heading_color" 
	)
   ,
   
   array(
	  "type" => "colorpicker" ,
	  "heading" => "Team Member Icon Color",
	  "param_name" => "icon_color" 
	),
	
	array(
	  "type" => "colorpicker" ,
	  "heading" => "Team Member Icon Color:hover",
	  "param_name" => "icon_color_hover" 
	)
	,
	array(
	  "type" => "colorpicker" ,
	  "heading" => "Team Member overlay bg color",
	  "param_name" => "bg_color_overlay" 
	)
	,
	array(
	  "type" => "textfield" ,
	  "heading" => "Team Member Overlay Bg opacity",
	  "param_name" => "bg_overlay_opacity",
	  "description" => "Enter a value between 0 and 1" 
	)
   ,
	array(
	  "type" => "colorpicker" ,
	  "heading" => "Team Member Overlay Text Color",
	  "param_name" => "overlay_color" 
	),
	array(
	  "type" => "colorpicker" ,
	  "heading" => "Divider Color",
	  "param_name" => "di_color" 
	)
  )
) );



/* Separator (Divider)
---------------------------------------------------------- */

vc_map( array(
  "name"		=> __("Separator", "brad-framework"),
  "base"		=> "vc_separator",
  'icon'		=> 'icon-wpb-ui-separator',
  "show_settings_on_create" =>true,
  "category"    => __('Content', "brad-framework"),
  "params" => array(
	 array(
      "type" => "dropdown",
      "heading" => __( "Border Type" ,"brad-framework"),
      "param_name" => "type",
	  "value" => array(
	    "100% Border"        => "large",
		"Medium Border"      => "medium",
		"Small Border"       => "small",
		"Extra Small Border" => "tiny", )
	),
	
	array(
      "type" => "dropdown",
      "heading" => __( "Border Style" ,"brad-framework"),
      "param_name" => "style",
	  "value" => array(
	    "Normal Border" => "normal",
		"Thick Border"  => "double" )
	),
	
	array(
      "type" => "dropdown",
      "heading" => __( "Border Color" ,"brad-framework"),
      "param_name" => "color",
	  "value" => array(
	    "Light" => "light",
		"Dark"  => "dark" ,
		"Primary" => "primary" )
	),
	

	 array(
      "type" => "dropdown",
      "heading" => __('Separator Align', "brad-framework"),
      "param_name" => "align",
	  "value" => array(
		__("Align Center ( Default )", "brad-framework") => "center" ,
		__("Align Left", "brad-framework")   => "left",
		__("Align Right", "brad-framework")  => "right" ,
		 )
	),
	
	array(
      "type" => "brad_iconpicker",
      "heading" => __( "Icon" ,"brad-framework"),
      "param_name" => "icon",
	  "value" => ""
	),
	
	
    array(
      "type" => "textfield",
      "heading" => __("Margin Top","brad-framework"),
      "param_name" => "margin_top",
	  "value" =>  '5' ,
	),
	array(
      "type" => "textfield",
      "heading" => __("Margin Bottom","brad-framework"),
      "param_name" => "margin_bottom",
	  "value" =>  '25' ,
	  "description" => 'Default Bottom Margin in "px"'
	)	
   )	
 ) 
);

class WPBakeryShortCode_Vc_Gap extends WPBakeryShortCode {
}
	
/* Gap
--------------------------------------------*/
vc_map( array(
	"name" => __("Gap","brad-framework"),
	"base" => "vc_gap",
	'icon' => 'icon-wpb-ui-empty_space',
	"category" => __('Content',"brad-framework"),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Gap height","brad-framework"),
			"param_name" => "height",
			"value" => "20",
			"description" => __("In pixels.","brad-framework")
		),
		
		$add_hidden_array
	
	)
  ) 
);

class WPBakeryShortCode_Vc_Heading extends WPBakeryShortCode {
}
	
/* Special Title
-----------------------------------------------------------*/
vc_map( array(
  "name"		=> __("Special Heading", "brad-framework"),
  "base"		=> "vc_heading",
  'class'		=> 'vc_special_heading',
  'icon'		=> 'vc_special_heading',
  "show_settings_on_create" => true ,
  "category"  => __('Content', "brad-framework"),
  "params" => array(
   
   array(
      "type" => "textarea",
      "heading" => __("Title","brad-framework"),
      "param_name" => "title",
	  "value" =>  'Your Title Here' ,
	  "admin_label" => true
	),
	
	array(
      "type" => "brad_iconpicker",
      "heading" => __("Icon","brad-framework"),
      "param_name" => "icon",
	  "description" => 'Icon to show in the title'
	),
	
   array(
      "type" => "dropdown",
      "heading" => __( "Heading Type" ,"brad-framework"),
      "param_name" => "type",
	  "value" => array(
	    "heading 1" => "h1",
		"heading 2" => "h2",
		"heading 3" => "h3",
		"heading 4" => "h4",
		"heading 5" => "h5",
		"heading 6" => "h6",
		 )
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __( "Heading Divider" ,"brad-framework"),
      "param_name" => "style",
	  "value" => array(
	    __("No Divider" ,"brad-framework") => "default" ,
	    __("Divider at the bottom","brad-framework") => "style1",
		__("Divider in center","brad-framework") => "style2"
		)
	),
	
   
   array(
      "type" => "dropdown",
      "heading" => __( "Divider Width" ,"brad-framework"),
      "param_name" => "divider_width",
	  "dependency" => array("element" => "style" , "value" => array("style1","style2")),
	  "value" => array(
	    __("Default","brad-framework") => "default",
		__("Full","brad-framework") => "full" ,
		__("100% Width","brad-framework") => "parent" ,
		__("Medium","brad-framework") => "medium" )
	),
	
	array(
      "type" => "dropdown",
      "heading" => __( "Divider Color" ,"brad-framework"),
      "param_name" => "divider_color",
	  "dependency" => array("element" => "style" , "value" => array("style1","style2")),
	  "value" => array(
	    __("Dark","brad-framework") => "dark",
		__("Light","brad-framework") => "light" ,
		__("Primary","brad-framework") => "primary" )
	),
	
	

	array(
      "type" => "dropdown",
      "heading" => __( "Color" ,"brad-framework"),
      "param_name" => "color",
	  "value" => array(
	    "Default" => "default",
		"Primary Color" => "primary" )
	),
	
   array(
      "type" => "dropdown",
      "heading" => __('Heading Align', "brad-framework"),
      "param_name" => "align",
	  "value" => array(
		__("Align Left", "brad-framework") => "left",
		__("Align Center", "brad-framework") => "center" ,
		__("Align Right", "brad-framework") => "right" ,
		 ) 
	),
   
   array(
      "type" => "textfield",
      "heading" => __("Margin Bottom","brad-framework"),
      "param_name" => "margin_bottom",
	  "value" =>  '20' ,
	  "description" => "Default Margin From Bottom in px",
	 )	
   )
 ) 
);


/* Pie Chart */

vc_map( array(
    "name" => __("Pie chart", 'vc_extend'),
    "base" => "vc_pie",
    "class" => "vc_icon_pie",
    "icon" => "icon-wpb-vc_pie",
    "category" => __('Content', "brad-framework"),
    "params" => array(
       
        array(
            "type" => "textfield",
            "heading" => __("Pie value", "brad-framework"),
            "param_name" => "value",
            "description" => 'Input graph value here. Witihn a range 0-100.',
            "value" => "50",
 
        ),
		 array(
            "type" => "icon",
            "heading" => __("Pie Icon", "brad-framework"),
            "param_name" => "icon",
            "value" => ""
        ),
        array(
            "type" => "textfield",
            "heading" => __("Pie label value", "brad-framework"),
            "param_name" => "label_value",
  
            "value" => ""
        ),

        array(
            "type" => "checkbox",
            "heading" => __("Place in Center", "brad-framework"),
            "param_name" => "placeincenter",
            "value" => Array(__("Yes","brad-framework") => "yes")
			) ,
	   array(
            "type" => "colorpicker",
            "heading" => __("Track color", "brad-framework"),
            "param_name" => "track_color"
			),
		
	    array(
            "type" => "colorpicker",
            "heading" => __("Bar color", "brad-framework"),
            "param_name" => "bar_color"	
 
        ),	
        array(
            "type" => "dropdown",
            "heading" => __("Size", "brad-framework"),
            "param_name" => "size",
            "value" => Array(__('Standard',"brad-framework") => 'standard' , __('Medium',"brad-framework") => 'medium' , __('Large',"brad-framework") => 'large'),
       
        ),
        $extra_class 

    )
) );


/* Single Image
---------------------------------------------------------- */
vc_map( array(
  "name" => __("Single Image", "brad-framework"),
  "base" => "vc_single_image",
  "class" => "icon-wpb-single-image",
  "icon" => "icon-wpb-single-image",
  "category" => __('Content', "brad-framework"),
  "params" => array(
   
    array(
      "type" => "attach_image",
      "heading" => __("Image", "brad-framework"),
      "param_name" => "image",
      "value" => "",
      "description" => __("Select image from media library.", "brad-framework")
    ),
	
	$add_img_size,
	$add_custom_img_size,
	$add_css_animation ,
    $add_css_animation_delay,
	array(
      "type" => "dropdown",
      "heading" => __("Image Align", "brad-framework"),
      "param_name" => "img_align",
      "value" => array(__("None", "brad-framework") => 'none', __("Left", "brad-framework") => "left", __("Right", "brad-framework") => "right", __("Center", "brad-framework") => "center")
	),
	
	 array(
      "type" => "textfield",
      "heading" => __("Image Link", "brad-framework"),
      "param_name" => "img_link",
      "description" => "Enter url if you want this image to have link. You can also enter youtube or vimeo video link . Video will be shown in lightbox  , if  enabled.",
    ),
   
   
   array(
      "type" => 'dropdown',
      "heading" => __("Link to large image?", "brad-framework"),
      "param_name" => "img_link_large",
      "value" => Array(__("No","brad-framework") => "no" , __("Yes, please", "brad-framework") => 'yes'),
	  "dependency" => array("element" => "img_link" , "is_empty" => true )
    ),
   
   
   array(
      "type" => "dropdown",
      "heading" => __("Link Target", "brad-framework"),
      "param_name" => "target",
      "value" => $target_arr
    ),
   
   array(
      "type" => 'checkbox',
      "heading" => __("Open the above link in lightbox?", "brad-framework"),
      "param_name" => "img_lb"
    ),
	 
	array(
      "type" => 'checkbox',
      "heading" => __("Enable overlay icon", "brad-framework"),
      "param_name" => "img_lightbox",
      "description" => __("If selected there will be lightbox Icon", "brad-framework"),
      "value" => array(__("Yes, please", "brad-framework") => 'yes')
    ),
	
	 array(
      "type" => 'brad_iconpicker',
      "heading" => __("Icon?", "brad-framework"),
      "param_name" => "icon_lightbox",
      "value" => '',
	  "dependency" => array("element" => "img_lightbox" , "value" => array("yes") )
    ),
	
    
  
    array(
      "type" => "textfield",
      "heading" => __("Extra class name", "brad-framework"),
      "param_name" => "el_class",
      "description" =>"If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file."
    )
  )
));



/* Gallery/Slideshow
---------------------------------------------------------- */
vc_map( array(
  "name" => __("Image Gallery", "brad-framework"),
  "base" => "vc_gallery",
  "icon" => "icon-wpb-images-stack",
  "category" => __('Content', "brad-framework"),
  "params" => array(
  
    array(
      "type" => "dropdown",
      "heading" => __("Gallery type", "brad-framework"),
      "param_name" => "type",
      "value" => array( __("Slider", "brad-framework") => "slider", __("Grid", "brad-framework") => "grid" ),
   ),
   
   array(
      "type" => "dropdown",
      "heading" => __("Horizental Whitespace Between child elements /columns", "brad-framework"),
      "param_name" => "padding",
	  "dependency" => array("element" => "type" , "value" => array("grid") ) ,
	  "value" => Array(   
	     "Default (40px)" => "medium" ,
		 "60px" => "large" ,
		 "50px" => "large2" ,
		 "30px" => "medium2" ,
		 "20px" => "small" ,
		 "10px" => "small2" ,
		 "4px" => "narrow" ,
		 "0px" => "no" ) 	 
    ),

   array(
      "type" => "dropdown",
	  "dependency" => array("element" => "type" , "value" => array("grid") ) ,
      "heading" => __("Vertical Whitespace Between child elements /columns", "brad-framework"),
      "param_name" => "vpadding",
	  "value" => Array( 
	     "Default (40px)" => "medium" ,
		 "60px" => "large" ,
		 "50px" => "large2" ,
		 "30px" => "medium2" ,
		 "20px" => "small" ,
		 "10px" => "small2" ,
		 "4px" => "narrow" ,
		 "0px" => "no" ) 	 
   ),
   
 
	
	array(
      "type" => "dropdown",
      "heading" => __("Grid Columns ? ", "brad-framework"),
      "param_name" => "columns",
	  "value" => Array( 
	     __("Default (Six)","brad-framework") => "6" ,
		__("Two","brad-framework") => "2" ,
		 __("Three","brad-framework") => "3" ,
		 __("Four","brad-framework") => "4" ,
		 __("Five","brad-framework") => "5" ) ,
		 "dependency" => array("element" => "type" , "value" => array("grid"))	 
	),
	
	
    array(
      "type" => "checkbox",
      "heading" => __("Auto Play slides", "brad-framework"),
      "param_name" => "autoplay",
      "value" => array( __("Yes", "brad-framework") => 'yes'),
	  "dependency" => array("element" => "type" , "value" => array("slider"))
    ),
	
	array(
      "type" => "checkbox",
      "heading" => __("Enable Grey Filter for images", "brad-framework"),
      "param_name" => "grey",
      "value" => array( __("Yes", "brad-framework") => 'yes'),
	  "dependency" => array("element" => "type" , "value" => array("grid"))
    ),
	 
	
    array(
      "type" => "attach_images",
      "heading" => __("Images", "brad-framework"),
      "param_name" => "images",
      "value" => "",
      "description" => __("Select images from media library.", "brad-framework")
    ),
   $add_img_size,
   $add_custom_img_size ,
    array(
      "type" => "dropdown",
      "heading" => __("On click ", "brad-framework"),
      "param_name" => "onclick",
      "value" => array(__("Open prettyPhoto", "brad-framework") => "link_image", __("Do nothing", "brad-framework") => "link_no", __("Open custom link", "brad-framework") => "custom_link"),
      "description" => "What to do when slide is clicked?"
    ),
	array( 
	   "type" => "checkbox",
	   "heading" => __("Show Metadata","brad-framework"),
	   "param_name" => "show_metadata",
	   "value" => array(__("Yes","brad-framework") => "yes"),
	  
	   ),
    array(
      "type" => "exploded_textarea",
      "heading" => __("Custom links", "brad-framework"),
      "param_name" => "custom_links",
      "description" => 'Enter links for each slide here. Divide links with linebreaks (Enter).',
      "dependency" => Array('element' => "onclick", 'value' => array('custom_link'))
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Custom link target", "brad-framework"),
      "param_name" => "custom_links_target",
      "dependency" => Array('element' => "onclick", 'value' => array('custom_link')),
      'value' => $target_arr
    ),
    $extra_class
  )
) );




/* Progress Bar */
vc_map( array(
  "name" => __("Progress Bar", "brad-framework"),
  "base" => "vc_progress_bar",
  "icon" => "icon-wpb-graph",
  "class" => "vc_sc_progress",
  "category" => __('Content', "brad-framework"),
  "params" => array(
    
    array(
      "type" => "exploded_textarea",
      "heading" => __("Graphic values", "brad-framework"),
      "param_name" => "values",
      "description" => 'Input graph values here. Divide values with linebreaks (Enter). Example: 90|Development',
      "value" => "90|Development,80|Design,70|Marketing"
    ),
	
    array(
      "type" => "textfield",
      "heading" => __("Units", "brad-framework"),
      "param_name" => "units",
      "description" => "Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title."
    ),
	
    array(
      "type" => "dropdown",
      "heading" => __("Bar color", "brad-framework"),
      "param_name" => "bar_color",
      "value" => $colors_arr ,
    ),
	
    array(
      "type" => "checkbox",
      "heading" => __("Options", "brad-framework"),
      "param_name" => "options",
      "value" => array(__("Add Stripes?", "brad-framework") => "striped", __("Add animation? Will be visible with striped bars.", "brad-framework") => "animated")
    ),
    $extra_class
  )
) );



/* Google maps element
---------------------------------------------------------- */
vc_map( array(
  "name" => __("Google Maps", "brad-framework"),
  "base" => "vc_gmaps",
  "icon" => "icon-wpb-map-pin",
  "class" => "vc_sc_map",
  "category" => __('Content', "brad-framework"),
  "params" => array(
     array(
      "type" => "dropdown",
      "heading" => __("Style", "brad-framework"),
      "param_name" => "style",
	  "value" => array(__('Default','brad-framework') => 'default',__('Fully Saturated','brad-framework') => 'style1' , __('Dark Style','brad-framework') => 'style2' , __('Map Color Match with Primary Color','brad-framework') => 'style3')
     ),
	
	
	array(
      "type" => "textfield",
      "heading" => __("Latitude", "brad-framework"),
      "param_name" => "lat",
	  "description" => 'Use this <a href="http://www.latlong.net/" target="_blank">tool</a> to find your latitude',
	  "value" => '',
	  "admin_label" => true
    ),
	
	array(
      "type" => "textfield",
      "heading" => __("Latitude", "brad-framework"),
      "param_name" => "lon",
	  "description" => 'Use this <a href="http://www.latlong.net/" target="_blank">tool</a> to find your longitude',
	  "value" => '',
	  "admin_label" => true
    ),
	
	
	array(
      "type" => "textfield",
      "heading" => __("Address", "brad-framework"),
      "param_name" => "address",
	  "description" => 'If you are using latitude or longitude for google map then you do\'t need to use this field .<strong>Important Note:</strong>If you are suing this field then above lat & lon will be replace the this addess \'s locations',
	  "value" => ''
    ),
	
	array(
      "type" => "textfield",
      "heading" => __("Map Width", "brad-framework"),
      "param_name" => "width",
	  "value" => '100%' ,
      "description" => 'Enter map Width . Example: 500px or  50%.',
	  "admin_label" => true
    ),
	
    array(
      "type" => "textfield",
      "heading" => __("Map height", "brad-framework"),
      "param_name" => "height",
	  "value" => '300px' ,
      "description" => 'Enter map height in pixels. Example: 200px.',
	  "admin_label" => true
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Map Zoom", "brad-framework"),
      "param_name" => "zoom",
      "value" => array(__("14 - Default", "brad-framework") => 14 , 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20)
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Scrollwheel", "brad-framework"),
      "param_name" => "scrollwheel",
	  "value" => Array(__("Yes",'brad-framework') => 'true' ,  __("No",'brad-framework') => 'false'),
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Street View Control", "brad-framework"),
      "param_name" => "streetview",
	  "value" => Array( __("No",'brad-framework') => 'false' , __("Yes",'brad-framework') => 'true' ),
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Map Type Control", "brad-framework"),
      "param_name" => "maptypecontrol",
	  "value" =>Array( __("No",'brad-framework') => 'false' , __("Yes",'brad-framework') => 'true' ),
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Map Pan Control", "brad-framework"),
      "param_name" => "mappan",
	  "value" =>Array( __("No",'brad-framework') => 'false' , __("Yes",'brad-framework') => 'true' ),
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Zoom Control", "brad-framework"),
      "param_name" => "zoomcontrol",
	  "value" => Array( __("Yes",'brad-framework') => 'true' , __("No",'brad-framework') => 'false'  ),
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Zoom Size", "brad-framework"),
      "param_name" => "zoomsize",
	  "dependency" => array("element" => "zoomcontrol" , "value" => array("true")),
	  "value" => Array( __("Small",'brad-framework') => 'small' , __("Large",'brad-framework') => 'large' ),
    ),
	
	
    array(
      "type" => "dropdown",
      "heading" => __("Default Map type", "brad-framework"),
      "param_name" => "maptype",
      "value" => array(__("Map", "brad-framework") => "roadmap", __("Satellite", "brad-framework") => "satellite", __("Hybrid Map", "brad-framework") => "hybrid" , __("Map + Terrain", "brad-framework") => "terrain")
    ),
	
	array(
      "type" => "checkbox",
      "heading" => __("Show/Use Marker", "brad-framework"),
      "param_name" => "marker",
	  "value" => Array(__("Yes",'brad-framework') => 'yes' ),
    ),
	
	array(
      "type" => "checkbox",
      "heading" => __("Custom Infowindow", "brad-framework"),
      "param_name" => "custominfo",
	   "value" => Array(__("Yes",'brad-framework') => 'yes' ),
	  "dependency" => Array('element' => "marker", 'value' => array('yes'))
    ),
	
	array(
	  "type" => "colorpicker",
	  "value" => "",
	  "dependency" => Array('element' => "custominfo", 'value' => array('yes')),
	  "heading" => "Background color for info window",
	  "param_name" => "bg_color"),
	  
	array(
	  "type" => "colorpicker",
	  "dependency" => Array('element' => "custominfo", 'value' => array('yes')),
	  "heading" => "Text color for info window",
	  "param_name" => "txt_color"),  
	
	array(
      "type" => "attach_image",
      "heading" => __("Marker Image", "brad-framework"),
      "param_name" => "markerimage",
	  "dependency" => Array('element' => "marker", 'value' => array('yes'))
    ),
	
	array(
      "type" => "textarea",
      "heading" => __("Info window Text", "brad-framework"),
      "param_name" => "infowindow",
	  "value" => "",
	  "dependency" => Array("element" => "marker" , "value" => array("yes"))
    ),
	
	array(
      "type" => "checkbox",
      "heading" => __("Make Info window visible initial", "brad-framework"),
      "param_name" => "infovisible",
	  "value" => Array(__("Yes",'brad-framework') => 'yes' ),
	  "dependency" => Array('element' => "marker", 'value' => array('yes'))
    ),
	
	array(
      "type" => "textarea",
      "heading" => __("Additonal Markes", "brad-framework"),
      "param_name" => "markers",
	  "value" => "",
	  "description" => 'Place additional Markes for the map in the format like latitude|lonitude|Info Window Text|Marker image url/src|yes,no(for info window visible initial). Please add a line break for another marker.Use this <a href="http://www.latlong.net/" target="_blank">tool</a> to find your latitude and longitude',
	  "dependency" => Array("element" => "marker" , "value" => array("yes"))
    ),
	
    $extra_class
  )
) );


/* Contact Form
-----------------------------------------------------------*/
class WPBakeryShortCode_VC_Contact_Form extends WPBakeryShortCode {};

vc_map( array(
	"name" => __("Contact Form","brad-framework"),
	"base" => "vc_contact_form",
	"icon" => "vc_icon_contact_form",
	"class" => "vc_icon_contact_form",
	"category" => __('Content', "brad-framework"),
	"params" => array(
	   
		array( 
	       "type" => "dropdown",
		   "heading" => __("Email Address","brad-framework"),
		   "param_name" => "email",
		   "description" => "Email address where you want to send emails . You must need to fill your email address in Blandes Options -> General -> Email Address. If the given field is empty then contact form send all emails to your wordpress admin email ",
		   "value" => array(
		       __("Default Email Address","brad-framework" ) => '',
			   __("Alternate Email Address" , "brad-framework" ) => 'alternate')
			   ),
		
		/*
		array(
		    "type" => "dropdown",
			"class" => "",
			"heading" => __("Contact form style","brad-framework"),
			"param_name" => "style" ,
			"value" => array(
			     __("Custom Style","brad-framework") => "" ,
				 __("Align Messgae box on right Side","brad-framework") => "style2"
			   )
			),
		*/	
		   
	  array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Form fields","brad-framework"),
			"param_name" => "fields",
			"value" => array(
				"name" => "name",
				"email" => "email",
				"telephone" => "telephone",
				"website" => "website",
				"country" => "country",
				"city" => "city",
				"company" => "company",
				"message" => "message"
			),
			"description" => "At least One field  is required to show thw form ."
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Message textarea height","brad-framework"),
			"param_name" => "message_height",
			"value" => "6",
			"description" => __("Number of lines.","brad-framework"),
			"dependency" => array("element" => "fields","value" => array("message"))
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Required fields","brad-framework"),
			//"admin_label" => true,
			"param_name" => "required",
			"value" => array(
				"name" => "name",
				"email" => "email",
				"telephone" => "telephone",
				"website" => "website",
				"country" => "country",
				"city" => "city",
				"company" => "company",
				"message" => "message"
			)
		),
		

			
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Half width Fields","brad-framework"),
			//"admin_label" => true,
			"param_name" => "half_width",
			"description" => "If you want two form fields in a single row",
			"value" => array(
				"name" => "name",
				"email" => "email",
				"telephone" => "telephone",
				"website" => "website",
				"country" => "country",
				"city" => "city",
				"company" => "company",
				"message" => "message"
			)
		),
		
		
		array(
			"type" => "checkbox",
			"heading" => __('Show fancy icons ? ',"brad-framework"),
			"param_name" => "show_icons",
			"description" => "Enable this if you want to show fancy icons in different form fields",
			"value" => Array(__("Yes","brad-framework") => "yes" ),
		),
		
		
		array(
			"type" => "textfield",
			"heading" => __('Success Message',"brad-framework"),
			"param_name" => "success_message",
			"value" => __("Success! Your Message has been Sent","brad-framework"),
		),
		
		array(
			"type" => "textfield",
			"heading" => __('Error Message',"brad-framework"),
			"param_name" => "error_message",
			"value" => __("Error! An Error Occured While Sending your Message","brad-framework"),
		),
	
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Submit button text',"brad-framework"),
			"param_name" => "button_title",
			"value" => "Send message",
		),
		
		array(
		"type" => "dropdown",
		"param_name" => "style" ,
		"value" => 	$colors_arr,
		"heading" => __("Submit Button Style","brad-framework")
		)
		,
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Submit button size","brad-framework"),
			"param_name" => "button_size",
			"value" => array(
			    "Default" => "default",
				"Small" => "small",
				"Large" => "large",
			)
		)
	)
) );



/* Portfolio
-----------------------------------------------------------*/

class WPBakeryShortCode_VC_Portfolio extends WPBakeryShortCode {};

vc_map( array(
  "name"  => __("Portfolio", "brad-framework"),
  "base" => "vc_portfolio",
  "show_settings_on_create" => true ,
  "is_container" => true ,
  "icon" => "vc_icon_portfolio",
  "class" => "vc_icon_portfolio",
  "category" => __('Content', "brad-framework"),
  "params" => array(
   array(
      "type" => "taxonomy",
      "heading" => __("Portfolio Category", "brad-framework"),
      "param_name" => "categories",
      "value" => "" ,
	  "taxonomy" => "portfolio_category"
	),
	
    array(
      "type" => "dropdown",
      "heading" => __("Columns Count", "brad-framework"),
      "param_name" => "columns",
      "value" => array(
	               "Two" => 2 ,
				   "Three" => 3 ,
				   "Four" => 4 ,
				   "Five" => 5), 
      "description" => __("Set the number of Columns.", "brad-framework")
    ),
	array(
      "type" => "dropdown",
      "heading" => __("Portfolio Style", "brad-framework"),
      "param_name" => "portfolio_style",
      "value" => array(
	  		 'Simple Grid Style'   => 'style1',
			 'Box Style with Info' => 'style2'
			// 'Masonry Portfolios'  => 'style4'
			),
      "description" => "Default Style for Portfolio"
    )  
   ,
   
   array(
      "type" => "checkbox",
	  "param_name" => "masonry",
	  "heading" => "Enable Masonry Layout" ,
	  "value" => array( __("Yes",'brad-framework') => "yes" )
	  ),
		   
   
   $add_box_padding,
   $add_box_vpadding
   ,
  
  
  array(
      "type" => "dropdown",
      "heading" => __("Portfolio Item Background Style? ", "brad-framework"),
      "param_name" => "bg_style",
	  "value" => Array(
	               __("White", "brad-framework") => "white",
				   __("White Smoke", "brad-framework") => "white-smoke" ,
				   __("Transparent With Stroke", "brad-framework") => "stroke",
				   __("Transparent", "brad-framework") => "transparent"
				   ),
	  "dependency" => Array('element' => "portfolio_style", 'value' => array('style2'))
	)
   ,
   
   array(
      "type" => "dropdown",
      "heading" => __("Portfolio Image Size ? ", "brad-framework"),
      "param_name" => "img_size",
	  "value" => Array("Automatc ( Will get the best image size according to columns width)"=>"automatic",__("Custom Image Size","brad_framework") => "custom"),
	  "description" => "if you choose custom image size the portfolio image width will be still 100% to fill the container.",
	  "dependency" => array("element" => "portfolio_style" , "value" => array("style1","style2","style3"))
	)
   ,

  array(
      "type" => "textfield",
      "heading" => __("Custom Image Size", "brad-framework"),
      "param_name" => "custom_img_size",
	  "value" => "",
	  "description" => "Custom image size in width X Height. For ex. 570x400 <strong>note:</strong>Do't include px or any whitespace.",
	  "dependency" => array("element" => "img_size" , "value" => array("custom"))
	)
   ,   
   
   array(
      "type" => "dropdown",
      "heading" => __("Portfolio overlay content style? ", "brad-framework"),
      "param_name" => "info_style",
	  "value" => Array(
	               __("Content in Center", "brad-framework") => "center",
				   __("Content on left top", "brad-framework") => "left"
				   ),
	  "dependency" => Array('element' => "portfolio_style", 'value' => array('style1'))
	)
   ,
   
   
   array(
      "type" => "dropdown",
      "heading" => __("Info visiblity? ", "brad-framework"),
      "param_name" => "info_onhover",
	  "value" => Array(
	               __("Show on hover", "brad-framework") => "yes",
				   __("Show initial", "brad-framework") => "no"
				   ),
	  "dependency" => Array('element' => "portfolio_style", 'value' => array('style1'))
	)
   ,
   
   
   array(
      "type" => "checkbox",
      "heading" => __("Is Sortable ", "brad-framework"),
	  "description" => "Check this if you want to show sortable tabs for portfolio",
      "param_name" => "sortable",
	  "value" => Array("Yes"=>'yes')
	)
   ,
   
   array(
      "type" => "dropdown",
      "heading" => __("Sortable Tabs Align ? ", "brad-framework"),
      "param_name" => "sortable_align",
	  "value" => Array(
	               "Center (Default)" => "",
	               "Left" => "left",
				   "Right" => "right"
				   ),
	  "dependency" => Array('element' => "sortable", 'value' => array('yes') )
	)
   ,
   
   array(
      "type" => "dropdown",
      "heading" => __("Sortable Tabs Style ? ", "brad-framework"),
      "param_name" => "sortable_style",
	  "value" => Array(
	               "Default" => "",
	               "blackbox" => "box"
				   ),
	  "dependency" => Array('element' => "sortable", 'value' => array('yes') )
	)
   ,
   
   array(
      "type" => "checkbox",
      "heading" => __("Show Sortable Label ?", "brad-framework"),
      "param_name" => "sortable_label",
	  "description" => "check this if you want to have sortable tabs a label",
	  "value" => Array("Yes"=>'yes'),
	  "dependency" => Array('element' => "sortable", 'value' => array('yes') )
	)
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Portfolio Tabs Font Scheme", "brad-framework"),
      "param_name" => "tabs_scheme",
      "value" => array( 'Scheme1' => 'scheme1' , 'Scheme2' => 'scheme2' ),
      "dependency" => Array('element' => "sortable", 'value' => array('yes') )
    )  
   ,
	
	$add_divider,
	$add_divider_color,
	$add_divider_style,
	$add_divider_type,
  
    array(
      "type" => "checkbox",
      "heading" => __("Show Categories ?", "brad-framework"),
      "param_name" => "show_categories",
	  "value" => Array("Yes"=>'yes')
	)
	,
   array(
      "type" => "checkbox",
      "heading" => __("Show Lightbox icon ?", "brad-framework"),
      "param_name" => "show_lb_icon",
	  "value" => Array("Yes"=>'yes'),
	),
	
	array(
      "type" => "checkbox",
      "heading" => __("Show Link icon ?", "brad-framework"),
      "param_name" => "show_li_icon",
	  "value" => Array("Yes"=>'yes'),
	)
    ,
	
	array(
      "type" => "checkbox",
      "heading" => __("Enable love It ?", "brad-framework"),
      "param_name" => "en_loveit",
	  "value" => Array("Yes"=>'yes')
	)
    ,
	
	array(
      "type" => "checkbox",
      "heading" => __("Disable Link on Title ?", "brad-framework"),
      "param_name" => "disable_li_title",
	  "value" => Array("Yes"=>'yes'),
	)
    ,
	
   $add_css_animation ,
  $add_css_animation_delay ,
  array(
      "type" => "textfield",
      "heading" => "Maximun Number of Portfolio Items to Show",
      "param_name" => "max_items",
      "value" => 8 
    )
	,
	$add_order_by,
	$add_order,
	$add_bottom_margin
  ,
  
  array(
      "type" => "dropdown",
      "heading" => __("Pagination", "brad-framework"),
      "param_name" => "pagination",
      "value" => array( __('Standard Pagination','brad-framework') => 'default' ,
	                    __('Infinite Scroll','brad-framework') => 'ifscroll' ,
						__('Load More Button','brad-framework') => 'loadmore' ,
						__('No Pagination','brad-framework') => 'no' )
						)
   ,
   
     array(
      "type" => "dropdown",
      "heading" => __("Button Style", "brad-framework"),
      "param_name" => "button_style",
      "value" => $button_colors_arr,
	  'dependency' => array("element" => "pagination" , 'value' => array('loadmore'))
    ),
	/*
    array(
      "type" => "textfield",
      "heading" => __("Text on the button", "brad-framework"),
      "param_name" => "lm_title",
      "value" => __("Load More", "brad-framework"),
      "description" => __("Text on the load More button.", "brad-framework"),
	  'dependency' => array("element" => "pagination" , 'value' => array('loadmore'))
    ),
 */
   array(
      "type" => "brad_iconpicker",
      "heading" => __("Icon", "brad-framework"),
      "param_name" => "icon",
      "value" => "" ,
	  'dependency' => array("element" => "pagination" , 'value' => array('loadmore'))
    ),
   
   $extra_class		
   )
  )
 );


/* Portfolio Carousel
-----------------------------------------------------------*/
class WPBakeryShortCode_VC_Portfolio_Carousel extends WPBakeryShortCode {};
vc_map( array(
  "name"  => __("Portfolio Carousel", "brad-framework"),
  "base" => "vc_portfolio_carousel",
  "show_settings_on_create" => true ,
  "is_container" => true,
  "icon" => "vc_icon_portfolio_carousel",
  "class" => "vc_icon_portfolio_carousel",
  "category" => __('Content', "brad-framework"),
  "params" => array(
   array(
      "type" => "taxonomy",
      "heading" => __("Portfolio Category", "brad-framework"),
      "param_name" => "category",
      "value" => "" ,
	  "taxonomy" => "portfolio_category"
	  ),
    array(
      "type" => "dropdown",
      "heading" => __("Columns Count", "brad-framework"),
      "param_name" => "columns",
      "value" => array( "Two" => 2 ,"Three" => 3 ,"Four" => 4 , "Five" => 5 )
    ),
	
	array(
      "type" => "dropdown",
      "heading" => __("Portfolio Style", "brad-framework"),
      "param_name" => "portfolio_style",
      "value" => array( 'Style 1' => 'style1' , 'Style 2' => 'style2' ),
    )  
   ,
   
   array(
      "type" => "dropdown",
      "heading" => __("Portfolio Item Background Style? ", "brad-framework"),
      "param_name" => "bg_style",
	  "value" => Array(
	               __("White", "brad-framework") => "white",
				   __("White Smoke", "brad-framework") => "white-smoke" ,
				   __("Transparent With Stroke", "brad-framework") => "stroke",
				   __("Transparent", "brad-framework") => "transparent"
				   ),
	  "dependency" => Array('element' => "portfolio_style", 'value' => array('style2'))
	)
   ,
   
    array(
      "type" => "dropdown",
      "heading" => __("Portfolio Image Size ? ", "brad-framework"),
      "param_name" => "img_size",
	  "value" => Array("Automatc ( Will get the best image size according to columns width)"=>"automatic",__("Custom Image Size","brad_framework") => "custom"),
	  "description" =>"if you choose custom image size the portfolio image width will be still 100% to fill the container.",
	  "dependency" => array("element" => "portfolio_style" , "value" => array("style1","style2","style3"))
	)
   ,

   array(
      "type" => "textfield",
      "heading" => __("Custom Image Size", "brad-framework"),
      "param_name" => "custom_img_size",
	  "value" => "",
	  "description" => "Custom image size in width X Height. For ex. 570x400 <strong>note:</strong>Do't include px or any whitespace.",
	  "dependency" => array("element" => "img_size" , "value" => array("custom"))
	)
   ,
   
   array(
      "type" => "dropdown",
      "heading" => __("Portfolio overlay content style? ", "brad-framework"),
      "param_name" => "info_style",
	  "value" => Array(
	               __("Content in Center", "brad-framework") => "center",
				   __("Content on Left Top", "brad-framework") => "left"
				   ),
	  "dependency" => Array('element' => "portfolio_style", 'value' => array('style1'))
	)
   ,
   
   
   array(
      "type" => "dropdown",
      "heading" => __("Info visiblity? ", "brad-framework"),
      "param_name" => "info_onhover",
	  "value" => Array(
	               __("Show on hover", "brad-framework") => "yes",
				   __("Show initial", "brad-framework") => "no"
				   ),
	  "dependency" => Array('element' => "portfolio_style", 'value' => array('style1'))
	)
   ,
   
   $add_box_padding,
   
   $add_divider,
   $add_divider_color,
	$add_divider_style,
	$add_divider_type,
  
    array(
      "type" => "checkbox",
      "heading" => __("Show Categories in Info ?", "brad-framework"),
      "param_name" => "show_categories",
	  "value" => Array("Yes"=>'yes')
	)
	, 	
     array(
      "type" => "checkbox",
      "heading" => __("Show Lightbox icon ?", "brad-framework"),
      "param_name" => "show_lb_icon",
	  "value" => Array("Yes"=>'yes','no'=>'no'),

	),
	
	array(
      "type" => "checkbox",
      "heading" => __("Show Link icon ?", "brad-framework"),
      "param_name" => "show_li_icon",
	  "value" => Array("Yes"=>'yes'),
	)
    ,
	
	array(
      "type" => "checkbox",
      "heading" => __("Enable love It ?", "brad-framework"),
      "param_name" => "en_loveit",
	  "value" => Array("Yes"=>'yes')
	)
    ,
	
	array(
      "type" => "checkbox",
      "heading" => __("Disable Link on Title ?", "brad-framework"),
      "param_name" => "disable_li_title",
	  "value" => Array("Yes"=>'yes'),

	)
    ,

  array(
      "type" => "textfield",
      "heading" => __("Maximun Number of Portfolio Items to Show", "brad-framework"),
      "param_name" => "max_items",
      "value" => 8 ,

    )
  ,
    
  array(
      "type" => "checkbox",
      "heading" => __("Show Navigation Icons ?", "brad-framework"),
      "param_name" => "navigation",
	  "value" => Array( "Yes"=> 'yes' )
  ),
  
  array(
      "type" => "checkbox",
      "heading" => __("Show Pagination ?", "brad-framework"),
      "param_name" => "pagination",
	  "value" => Array( "Yes"=> 'yes' )
  ),
	
    $add_autoplay,
	
    $add_order_by,
	$add_order
   )
 )
);


/* blog
-----------------------------------------------------------*/
class WPBakeryShortCode_Vc_Blog extends WPBakeryShortCode {}

vc_map( array(
  "name"  => __("Blog", "brad-framework"),
  "base" => "vc_blog",
  "show_settings_on_create" => true ,
  "is_container" => true,
  "icon" => "vc_icon_blog",
  "class" => "vc_icon_blog",
  "category" => __('Content', "brad-framework"),
  "params" => array(
   array(
      "type" => "taxonomy",
      "heading" => __("Blog Category", "brad-framework"),
      "param_name" => "category",
      "value" => "" ,
	  "taxonomy" => "category"
	  ),
	  
	  array(
      "type" => "textfield",
      "heading" => __("Posts to Exclude", "brad-framework"),
      "param_name" => "ex_items",
      "value" => "" ,
	  "description" => "Please enter the id of the posts to exclude from list. for ex. 2,3,5" ,
	  ),
	    	
    $add_order_by,
	$add_order
  , 
	array(
      "type" => "dropdown",
      "heading" => __("Blog Type ?", "brad-framework"),
      "param_name" => "blog_type",
	  "value" => Array(
	       __( "Grid Blog" , "brad-framework" ) => "grid" ,
		   __( "Standard Blog" , "brad-framework" )  => "standard" ,
		   __( "List Type Blog" , "brad-framework" )  => "list" 
		   )
	)
	,
	
	 array(
      "type" => "dropdown",
      "heading" => __("Whitespace Between Grid Elements ? ", "brad-framework"),
      "param_name" => "padding",
	  "value" => Array( 
	     "Default (Medium)" => "medium" ,
		 "Narrow" => "narrow" ,
		 "Small" => "small" ,
		 "Large" => "large" ,
		 "Zero" => "no" ) 	 ,
	  "dependency" => array("element" => "blog_type", "value" => array("grid"))
	),
	
	array(
      "type" => "dropdown",
      "heading" => __("Blog Heading Alignment? ", "brad-framework"),
      "param_name" => "align",
	  "value" => Array( 
	     "Top of the Image" => "top" ,
		 "Bottom of the Image" => "bottom" 
		) 	 ,
	  "dependency" => array("element" => "blog_type", "value" => array("standard"))
	),
	
	array(
      "type" => "dropdown",
      "heading" => __("Blog Heading Text Alignment? ", "brad-framework"),
      "param_name" => "upper_align",
	  "value" => Array( 
	     "Center" => "center" ,
		 "Left" => "left" ,
		 "Right" => "right" 
		) 	 ,
	  "dependency" => array("element" => "blog_type", "value" => array("standard"))
	),
	
	 
	 array(
      "type" => "dropdown",
      "heading" => __("Columns Count", "brad-framework"),
      "param_name" => "columns",
      "value" => array( "Two" => 2 ,"Three" => 3 ,"Four" => 4 ),
	  "dependency" => array("element" => "blog_type", "value" => array("grid"))
    ),
	  
	  
   array(
      "type" => "dropdown",
      "heading" => __("Enable Masonry Layout", "brad-framework"),
      "param_name" => "masonry",
      "value" => array( __('Yes',"brad-framework") => 'yes' , 'No' => 'no'),
	  "dependency" => array("element" => "blog_type", "value" => array("grid"))	   
    ) ,
		  
   
   array(
      "type" => "dropdown",
      "heading" => __("Background Style ?", "brad-framework"),
      "param_name" => "bg_style",
	  "value" => Array(
	       __("Transparent" , "brad-framework" ) => "" ,
		   __("Transparent With Stroke" , "brad-framework" )  => "stroke",
		   __("White" , "brad-framework" )  => "white",
		   __("White Smoke" , "brad-framework") => "grey"),
	  "dependency" => array("element" => "blog_type", "value" => array("grid"))	   
	)
	,

    array(
      "type" => "dropdown",
      "heading" => __("Show Author Name ?", "brad-framework"),
      "param_name" => "show_author",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "1" ,
		   __( "No" , "brad-framework" )  => "0" )
	)
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Enable Like/Love This ?", "brad-framework"),
      "param_name" => "check_postlove",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "1" ,
		   __( "No" , "brad-framework" )  => "0" )
	)
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Show No of Comments ?", "brad-framework"),
      "param_name" => "show_comments",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "1" ,
		   __( "No" , "brad-framework" )  => "0" )
	)
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Show Date ?", "brad-framework"),
      "param_name" => "show_date",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "1" ,
		   __( "No" , "brad-framework" )  => "0" )
	)
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Show Categories ?", "brad-framework"),
      "param_name" => "show_categories",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "1" ,
		   __( "No" , "brad-framework" )  => "0" )
	)
 ,
 
	array(
      "type" => "checkbox",
      "heading" => __("Enable Sharebox?", "brad-framework"),
      "param_name" => "show_sharebox",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "1"
		   ),
	  "dependency" => array("element" => "blog_type" , "value" => array("grid","standard"))	   
		   
	)
	,
	

	array(
      "type" => "dropdown",
      "heading" => __("Enable Read More Button?", "brad-framework"),
      "param_name" => "en_readmore",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "1" ,
		   __( "No" , "brad-framework" )  => "0" )
	 )
	,
	
	
	
	/*
    array(
      "type" => "dropdown",
      "heading" => __("Show Excerpt ?", "brad-framework"),
      "param_name" => "show_excerpt",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "yes" ,
		   __( "No" , "brad-framework" ) => "no" )
	),
 */
    array(
      "type" => "textfield",
      "class" => "",
	  "heading" => __("Excerpt Length","brad-framework"),
      "param_name" => "excerpt_length",
	  "value" => "35"
	 ),
		  
  
  array(
      "type" => "textfield",
      "heading" => __("Maximun Number of Posts  to Show", "brad-framework"),
      "param_name" => "max_items",
      "value" => 8 
    ),

 
  
  array(
      "type" => "dropdown",
      "heading" => __("Pagination", "brad-framework"),
      "param_name" => "pagination",
      "value" => array( __('Standard Pagination','brad-framework') => 'default' ,
	                    __('Infinite Scroll','brad-framework') => 'ifscroll' ,
						__('Load More Button','brad-framework') => 'loadmore' ,
						__('No Pagination','brad-framework') => 'no' ) ,
	  "dependency" => array("element" => "blog_type", "value" => array("grid","list"))
	  )					
	 							
   ,
  
   $extra_class			
   )
 )
);





/* Posts Carousel
-----------------------------------------------------------*/
class WPBakeryShortCode_Vc_posts_carousel extends WPBakeryShortCode {}
vc_map( array(
  "name"  => __("Posts Carousel", "brad-framework"),
  "base" => "vc_posts_carousel",
  "show_settings_on_create" => true ,
  "is_container" => true,
  "icon" => "vc_icon_postcarousel",
  "class" => "vc_icon_postcarousel",
  "category" => __('Content', "brad-framework"),
  "params" => array(
   array(
      "type" => "taxonomy",
      "heading" => __("Posts Category", "brad-framework"),
      "param_name" => "category",
      "value" => "" ,
	  "taxonomy" => "category"
	  ),
	  
    array(
      "type" => "dropdown",
      "heading" => __("Columns Count", "brad-framework"),
      "param_name" => "columns",
      "value" => array( "Two" => 2 ,"Three" => 3 ,"Four" => 4 ),
      "description" => __("Set the number of Columns.", "brad-framework")
    ),
	
  
    array(
      "type" => "dropdown",
      "heading" => __("Show Author Name ?", "brad-framework"),
      "param_name" => "show_author",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "yes" ,
		   __( "No" , "brad-framework" )  => "no" )
	)
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Enable love it ?", "brad-framework"),
      "param_name" => "show_love",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "yes" ,
		   __( "No" , "brad-framework" )  => "no" )
	)
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Show Date ?", "brad-framework"),
      "param_name" => "show_date",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "yes" ,
		   __( "No" , "brad-framework" )  => "no" )
	)
	,
	

	array(
      "type" => "dropdown",
      "heading" => __("Show Categories ?", "brad-framework"),
      "param_name" => "show_categories",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "yes" ,
		   __( "No" , "brad-framework" )  => "no" )
	)
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Show No. of Comments ?", "brad-framework"),
      "param_name" => "show_comments",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "yes" ,
		   __( "No" , "brad-framework" )  => "no" )
	)
	,
	
	

    array(
      "type" => "dropdown",
      "heading" => __("Show Excerpt ?", "brad-framework"),
      "param_name" => "show_excerpt",
	  "value" => Array(
	       __( "Yes" , "brad-framework" ) => "yes" ,
		   __( "No" , "brad-framework" ) => "no" )
	),
 
    array(
      "type" => "textfield",
      "class" => "",
	  "heading" => __("Excerpt Length","brad-framework"),
      "param_name" => "excerpt_length",
	  "value" => "20"
	  ),
		   
   $add_autoplay
	, 
    array(
      "type" => "checkbox",
      "heading" => __("Show Navigation Icons ?", "brad-framework"),
      "param_name" => "navigation",
	  "value" => Array( "Yes"=>'yes' ),
	)
   ,
   array(
      "type" => "checkbox",
      "heading" => __("Show Pagination Icons ?", "brad-framework"),
      "param_name" => "pagination",
	  "value" => Array( "Yes"=>'yes' ),
	)
   ,
  
  array(
      "type" => "textfield",
      "heading" => __("Maximun Number of Posts  to Show", "brad-framework"),
      "param_name" => "max_items",
      "value" => 8 
    )
   )
 )
);


// ! Mini Blog
class WPBakeryShortCode_Vc_Blog_list extends WPBakeryShortCode {}

vc_map( array(
	"name" => __("Mini Blog","brad-framework"),
	"base" => "vc_blog_list",
	"icon" => "vc_icon_bloglist",
	"class" => "vc_sc_bloglist",
	"category" => __('Content',"brad-framework"),
	"params" => array(
		array(
			"type" => "taxonomy",
			"taxonomy" => "category",
			"class" => "",
			"heading" => __("Categories","brad-framework"),
			"param_name" => "category",
			"description" => "Note: By default, all your posts will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed."
		)
		,
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Layout Type","brad-framework"),
			"param_name" => "type",
			"value" => array(
				"With Images on Left Side" => "1",
				"With Fancy Date on Left" =>  "2"
			),
			"description" => ""
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Image Size","brad-framework"),
			"param_name" => "img_size",
			"value" => array(
				"Default ( Medium )" => "default",
				"Small" =>  "small",
				"Large" => "large"
			),
			"description" => "" ,
			"dependency" => array("element" => "type" , "value" => array("1") )
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Show Comments","brad-framework"),
			"param_name" => "show_comments",
			"value" => array(__("Yes","brad-framework") => "yes")
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Excerpt Length","brad-framework"),
			"param_name" => "excerpt_length",
			"value" => "20"
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Maxmium Number of posts to show","brad-framework"),
			"param_name" => "max_items",
			"value" => "6"
		),
		
	
		
	)
) );


/* Message box
---------------------------------------------------------- */
vc_map( array(
  "name" => __("Message Box", "brad-framework"),
  "base" => "vc_message",
  'icon' => 'icon-wpb-information-white',
  "wrapper_class" => "alert",
  "category" => __('Content', "brad-framework"),
  "params" => array(
    array(
      "type" => "dropdown",
      "heading" => __("Message box type", "brad-framework"),
      "param_name" => "color",
      "value" => array(__('Informational', "brad-framework") => "alert-info", __('Warning', "brad-framework") => "alert-block", __('Success', "brad-framework") => "alert-success", __('Error', "brad-framework") => "alert-error"),
      "description" => __("Select message type.", "brad-framework")
    ),
    array(
      "type" => "textarea_html",
      "holder" => "div",
      "class" => "messagebox_text",
      "heading" => __("Message Content", "brad-framework"),
      "param_name" => "content",
      "value" => __("I am message box. Click edit button to change this text.", "brad-framework")
    ),
	 array(
      "type" => "checkbox",
      "heading" => __("Close Icon ?", "brad-framework"),
      "param_name" => "close",
	  "value" => Array(__("Yes","brad-framework") => "yes"),
      "description" => __("Check this if you want to show close button to hide Message Box.", "brad-framework")
    ),
    $extra_class
  ),
  "js_view" => 'VcMessageView'
) );



/* Button
---------------------------------------------------------- */
vc_map( array(
  "name" => __("Button", "brad-framework"),
  "base" => "vc_button",
  "icon" => "vc_icon_box",
  "category" => __('Content', "brad-framework"),
  "params" => array(
   
   array(
      "type" => "dropdown",
      "heading" => __("Style", "brad-framework"),
      "param_name" => "style",
      "value" => $button_colors_arr,
      "description" => __("Select the default style for your button.", "brad-framework")
    ),
	
   array(
	  "type" => "dropdown",
	  "heading" => __("Align","brad-framework"),
	  "param_name" => "align" ,
	  "value" => array(
	              __("Justify","brad-framework") => "none" ,
				  __("Align Center","brad-framework") => "center"
	               )
	  ),
	  
    array(
      "type" => "textfield",
      "heading" => __("Text on the button", "brad-framework"),
      "holder" => "button",
      "class" => "wpb_button",
      "param_name" => "title",
      "value" => __("Text on the button", "brad-framework"),
      "description" => __("Text on the button.", "brad-framework")
    ),
	
   array(
      "type" => "textfield",
      "heading" => __("URL (Link)", "brad-framework"),
      "param_name" => "href",
      "description" => __("Enter the Button link. Do't forget to include http:// ", "brad-framework")
    ),
	
   array(
      "type" => "dropdown",
      "heading" => __("Target", "brad-framework"),
      "param_name" => "target",
      "value" => $target_arr,
      "dependency" => Array('element' => "href", 'not_empty' => true)
    ),
	
	 array(
	   'param_name' => 'lb' ,
	   'type' => 'checkbox',
	   'value' => Array(__('Yes please','brad-framework') => 'yes'),
	   'heading' => __('Open Above link in lightbox? ' , 'brad-framework')
    )
	,
	
   array(
      "type" => "brad_iconpicker",
      "heading" => __("Icon", "brad-framework"),
      "param_name" => "icon",
      "value" => "" ,
	  "description" => "Select the icon for your Button. Click an icon to select it and again click the same icon to deselecct it",
    ),
	
   array(
	  "type" => "dropdown",
	  "heading" => __("Icon Align","brad-framework"),
	  "param_name" => "icon_align" ,
	  "value" => array(
	              __("Align Right","brad-framework") => "right" ,
	              __("Align Left","brad-framework") => "left" ,
				 
				  )
   ),
   
   array(
	  "type" => "dropdown",
	  "heading" => __("Icon Visibilty","brad-framework"),
	  "param_name" => "icon_ds" ,
	  "value" => array(
	              __("Visible on hover","brad-framework") => "hover" ,
	              __("Initial Visible","brad-framework") => "initial" ,
				 
				  )
   ),
   
   array(
	  "type" => "dropdown",
	  "heading" => __("Icon Size","brad-framework"),
	  "param_name" => "icon_size" ,
	  "value" => array(
	              __("Normal","brad-framework") => "normal" ,
				  __("Medium","brad-framework") => "medium" 
				  ),
	 "dependency" => Array('element' => "style", 'value' => array('readmore'))			  			  
   ),
   
   
   array(
	  "type" => "dropdown",
	  "heading" => __("Icon Style","brad-framework"),
	  "param_name" => "icon_style" ,
	  "value" => array(
	              __("Default","brad-framework") => "" ,
				  __("With Border","brad-framework") => "style2",
				   __("With Background","brad-framework") => "style3"
				  ),
	"dependency" => Array('element' => "style", 'value' => array('readmore'))			  
	  ),  
   array(
      "type" => "colorpicker",
      "heading" => __("Button  Icon Color", "brad-framework"),
      "param_name" => "icon_c",
      "value" => '' ,
	  "dependency" => Array('element' => "style", 'value' => array('readmore')),
      ),
	  
	  array(
      "type" => "colorpicker",
      "heading" => __("Button Icon Color Hover", "brad-framework"),
      "param_name" => "icon_c_hover",
      "value" => '' ,
	  "dependency" => Array('element' => "style", 'value' => array('readmore')),
      ),  
   array(
      "type" => "colorpicker",
      "heading" => __("Button  Icon Border Color", "brad-framework"),
      "param_name" => "icon_bc",
	  "dependency" => Array('element' => "icon_style", 'value' => array('style2')),
      "value" => ''
      ),	  
   array(
      "type" => "colorpicker",
      "heading" => __("Button  Icon Background Color", "brad-framework"),
      "param_name" => "icon_bgc",
      "value" => '',
	  "dependency" => Array('element' => "icon_style", 'value' => array('style3'))
      ),
	  
    array(
      "type" => "colorpicker",
      "heading" => __(" Button Icon Background and border Color:hover", "brad-framework"),
      "param_name" => "icon_bgc_hover",
      "value" => '',
	  "dependency" => Array('element' => "icon_style", 'value' => array('style2','style3'))
      ),
	  	  	  
   array(
      "type" => "dropdown",
      "heading" => __("Size", "brad-framework"),
      "param_name" => "size",
      "value" => $size_arr,
      "description" => __("Select the Button size.", "brad-framework")
    )
  ),
  "js_view" => 'VcButtonView'
) );


/* Call to Action Button
---------------------------------------------------------- */
vc_map( array(
  "name" => __("Call to Action Button", "brad-framework"),
  "base" => "vc_cta_button",
  'icon' => 'icon-wpb-call-to-action',
  "category" => __('Content', "brad-framework"),
  "params" => array(
   
	array(
      "type" => "textarea",
      "heading" => __("Callout Heading", "brad-framework"),
      "param_name" => "call_text",
      "value" => "" ,
      "description" => __("Enter your content.", "brad-framework")
    ),
	
	
	 array(
      "type" => "textarea_html",
      "heading" => __("Content", "brad-framework"),
      "param_name" => "content",
	  "value" => ""
    )
	,
	
	array(
      "type" => "dropdown",
      "heading" => __("Call text and buttons align", "brad-framework"),
      "param_name" => "align",
      "value" => array(__("Align Center", "brad-framework") => "center" , __("Justify", "brad-framework") => "justify"),
    ),
	
    array(
      "type" => "textfield",
      "heading" => __("Text on the first button", "brad-framework"),
      "param_name" => "title",
      "value" => __("Text on the button", "brad-framework"),
    ),
	
    array(
      "type" => "textfield",
      "heading" => __("URL (Link)", "brad-framework"),
      "param_name" => "href",
      "description" => __("First button link.", "brad-framework")
    ),
	
    array(
      "type" => "dropdown",
      "heading" => __("First Button Target", "brad-framework"),
      "param_name" => "target",
      "value" => $target_arr,
      "dependency" => Array('element' => "href", 'not_empty' => true)
    ),
	
    array(
      "type" => "dropdown",
      "heading" => __(" First Button Color", "brad-framework"),
      "param_name" => "color",
      "value" => $button_colors_arr,
    ),
    array(
      "type" => "brad_iconpicker",
      "heading" => __("First Button Icon", "brad-framework"),
      "param_name" => "icon"
    ),
    array(
      "type" => "dropdown",
      "heading" => __("First Button Size", "brad-framework"),
      "param_name" => "size",
      "value" => $size_arr,
    ),
   
   
   array(
      "type" => "textfield",
      "heading" => __("Text on the second button", "brad-framework"),
      "param_name" => "second_title",
      "value" => "",
    ),
    array(
      "type" => "textfield",
      "heading" => __("Second Button URL (Link)", "brad-framework"),
      "param_name" => "second_href",
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Second Button Target", "brad-framework"),
      "param_name" => "second_target",
      "value" => $target_arr,
      "dependency" => Array('element' => "href", 'not_empty' => true)
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Second Button Color", "brad-framework"),
      "param_name" => "second_color",
      "value" => $button_colors_arr
    ),
    array(
      "type" => "brad_iconpicker",
      "heading" => __("Second Button Icon", "brad-framework"),
      "param_name" => "second_icon"
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Second Button Size", "brad-framework"),
      "param_name" => "second_size",
      "value" => $size_arr
    )
	,
    $extra_class
  ),
  "js_view" => 'VcCallToActionView'
)
);



/* Pricing box
---------------------------------------------------------- */

class WPBakeryShortCode_Vc_Price_Box extends WPBakeryShortCode {}

vc_map( array(
  "name" => __("Price Box", "brad-framework"),
  "base" => "vc_price_box",
  'icon' => 'vc_icon_pricebox',
  "category" => __('Content', "brad-framework"),
  "params" => array(
    
	array(
	  'type' => 'dropdown',
	  'heading' => __('Price Box Style','brad_framework'),
	  'param_name' => 'style',
	  'value' => array(__('Style1','brad-framework') => 'style1' , __('Style2','brad-framework') => 'style2' ,__('Style3','brad-framework') => 'style3'  , __('Style4','brad-framework') => 'style4' , __('Style5','brad-framework') => 'style5' ) 
	 ),
	 
	 array(
	  'type' => 'dropdown',
	  'heading' => __('Price Box Color Scheme','brad_framework'),
	  'param_name' => 'scheme',
	  'value' => array(__('Default','brad-framework') => 'default' , __('Custom','brad-framework') => 'custom') 
	 ),
	
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Background Color','brad_framework'),
	  'param_name' => 'bgcolor',
	  "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	 
	 array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Background Color:hover','brad_framework'),
	  'param_name' => 'bgcolor_hover',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	 
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Text Color','brad_framework'),
	  'param_name' => 'txtcolor',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	 
	 array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Text Color:hover','brad_framework'),
	  'param_name' => 'txtcolor_hover',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ), 
	  
	 
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Icon Color','brad_framework'),
	  'param_name' => 'icolor',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Icon Color:hover','brad_framework'),
	  'param_name' => 'icolor_hover',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ), 
	 
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Icon Background Color','brad_framework'),
	  'param_name' => 'ibgcolor',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Icon Background Color:hover','brad_framework'),
	  'param_name' => 'ibgcolor_hover',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ), 
	
	
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Title Background Color','brad_framework'),
	  'param_name' => 'tbgcolor',
	  'description' => 'This option will ony work for Price box Style4 and style5',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Title Background Color:hover','brad_framework'),
	  'param_name' => 'tbgcolor_hover',
	  'description' => 'This option will ony work for Price box Style4 and style5',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ), 
	 
	  
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Title Color','brad_framework'),
	  'param_name' => 'hcolor',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	 
	 array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Box Title Color:hover','brad_framework'),
	  'param_name' => 'hcolor_hover',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ), 
	 
	 
	 array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Amount Background Color','brad_framework'),
	  'param_name' => 'pbgcolor',
	  'description' => 'This option will ony work for Price box Style4 and Style5',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	
	array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Amount  Background Color:hover','brad_framework'),
	  'param_name' => 'pbgcolor_hover',
	  'description' => 'This option will ony work for Price box  style4 and Style5',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ), 
	 
	 
	 array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Amount text Color','brad_framework'),
	  'param_name' => 'pricecolor',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	 
	 array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Amount text Color:hover','brad_framework'),
	  'param_name' => 'pricecolor_hover',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	 
	 
	 array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Amount Info Color','brad_framework'),
	  'param_name' => 'infocolor',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
	 
	 array(
	  'type' => 'colorpicker',
	  'heading' => __('Price Amount Info Color:hover','brad_framework'),
	  'param_name' => 'infocolor_hover',
	   "dependency" => array("element" => "scheme" , "value" => array("custom")),
	  'value' => ''
	 ),
 
	
	array(
		'type' => 'textfield',
		'heading' => __('Price Box Heading', 'brad_framework'),
		'param_name' => 'title',
		'value' => 'Standard'
	),
	
	array(
      "type" => "dropdown",
      "heading" => __( "Price Box Heading Type" ,"brad-framework"),
      "param_name" => "htype",
	  "value" => array(
	   	"heading 3 ( Default)" => "h3", 
	    "heading 1" => "h1",
		"heading 2" => "h2",
		"heading 4" => "h4",
		"heading 5" => "h5",
		"heading 6" => "h6",
		 )
    ),
	
   array(
	  'type' => 'brad_iconpicker',
	  'heading' => __('Pricing Column Title Icon', 'brad_framework'),
	  'param_name' => 'icon'
	),
	
  array(
		'type' => 'textfield',
		'heading' => __('Price Box Subtitle Title', 'brad_framework'),
		'param_name' => 'subtitle',
		'std' => ''
	),		
	
  array(
	  'type' => 'textfield',
	  'heading' => __('Pricing Amount', 'brad_framework'),
	  'param_name' => 'price',
	  'value' => '10'
  ),	
				
  array(
	  'type' => 'textfield',
	  'heading' => __('Pricing Amount Top Left Text', 'brad_framework'),
	  'param_name' => 'price_top_left',
	  'value' => '$'
   ),	
			
			
  array(
	  'type' => 'textfield',
	  'heading' => __('Pricing Amount Bottom Right Text', 'brad_framework'),
	  'param_name' => 'price_bottom_right',
	  'value' => '/ Month'
  ),	
			
   array(
	  'type' => 'textfield',
	  'heading' => __('Pricing Description', 'brad_framework'),
	  'description' => __('A small Description about your price that will be shown at bottom of pricing columns','brad-framework'),
	  'value' => '',
	  'param_name' => 'price_subtext'
	),		
   
  array(
	  'value' => '<ul><li>Feature 1</li><li>Feature 2</li></ul>',
	  'type' => 'textarea_html',
	  'label' => __('Pricing Features', 'brad_framework'),
	  'desc' => __('Enter The  Pricing Features in a  list', 'brad_framework'),
	  "param_name" => "content"
  )	
 ,
  array(
      "type" => "textfield",
      "heading" => __("Signup button Text", "brad-framework"),
      "param_name" => "button_text",
      "value" => __("Sign Up", "brad-framework")
    ),


	
  array(
      "type" => "dropdown",
      "heading" => __("Button color", "brad-framework"),
      "param_name" => "bcolor",
      "value" =>   $colors_arr 
    ),
	
  
  array(
      "type" => "dropdown",
      "heading" => __("Button color on hover", "brad-framework"),
      "param_name" => "bcolor_hover",
      "value" =>   $colors_arr
    ),		
	
	
   array(
      "type" => "textfield",
      "heading" => __("URL (Link)", "brad-framework"),
      "param_name" => "href",
      "description" => __("Enter the Button link. Do't forget to include http:// ", "brad-framework")
    ),
	
   array(
      "type" => "dropdown",
      "heading" => __("Target", "brad-framework"),
      "param_name" => "target",
      "value" => $target_arr,
      "dependency" => Array('element' => "href", 'not_empty' => true)
    ) 
  )
  )
 );



/* restaurant menu
---------------------------------------------------------- */

class WPBakeryShortCode_Vc_Food_Menus extends WPBakeryShortCodesContainer {}

vc_map( 
  array(
  "name" => __("Food Menu", "brad-framework"),
  "base" => "vc_food_menus",
  'icon' => 'vc_icon_foodmenus',
  "as_parent" => array('only' => 'vc_food_menu'),
  "is_container" => true , 
  "js_view" => 'VcColumnView',
  "show_settings_on_create" => true ,
  "category" => __('Content', "brad-framework"),
  "params" => array(
  
    array(
	  "type" => "dropdown",
      "heading" => __("Text color Scheme?", "brad-framework"),
      "param_name" => "scheme",
	  "value" => array(
			   __('Default Text',"brad-framework") => '' , 
			   __('All text to White',"brad-framework") => 'scheme1' )
	 ),
	 
	array( 
	  "type" => "checkbox",
	  "heading" => __("Show Divider","brad-framework"),
	  "param_name" => "divider",
	  "value" => array(__("yes","brad-framework") => 'yes')
	),
	 
	array(
	    "param_name" => "bgcolor" ,
		"type" => "colorpicker",
		"value" => "" ,
		"heading" => __("Background Color","brad-framework")
	),
	

	array(
	    "param_name" => "bgcolor_hover" ,
		"type" => "colorpicker",
		"value" => "" ,
		"heading" => __("Background Color:hover","brad-framework")
	) ,
	
 )
)
);



class WPBakeryShortCode_Vc_Food_Menu extends WPBakeryShortCode {}

vc_map( array(
   "name" => __("Food Menu", "brad-framework"),
   "base" => "vc_food_menu",
   'icon' => 'vc_icon_foodmenu',
   "as_child" => array('only' => 'vc_food_menus'),
   "category" => __('Content', "brad-framework"),
   "params" =>  array( 
    
	 array(
      "type" => 'textfield',
      "heading" => __("Min. Height in px", "brad-framework"),
      "param_name" => "height",
	  "value" => "",
	  
	  ),
	  
    array(
	  "type" => "vc_link",
      "heading" => __("If you want to have link for menu?", "brad-framework"),
      "param_name" => "link",
	  "value" =>  "" ,
	 ),
	 
	 
	 array(
	  "type" => "attach_image",
      "heading" => __("Menu image?", "brad-framework"),
      "param_name" => "image" 
	  ),
	  
	  array(
      "type" => "dropdown",
      "heading" => __("Image Align", "brad-framework"),
      "param_name" => "img_align",
      "value" => array(__("Left", "brad-framework") => "left", __("Right", "brad-framework") => "right" )
	  ),
 
      
	  array(
      "type" => 'checkbox',
      "heading" => __("Lightbox Link to large image?", "brad-framework"),
      "param_name" => "img_lightbox",
	  'description' => __( 'If selected, image will be linked to the larger image.', 'brad-framework' ),
      "value" => Array(__("Yes, please", "brad-framework") => 'yes')
    ),
	
	array(
      "type" => 'checkbox',
      "heading" => __("Lightbox Link for menu?", "brad-framework"),
      "param_name" => "menu_lightbox",
	  'description' => __( 'If selected, menu will be linked to large image.', 'brad-framework' ),
      "value" => Array(__("Yes, please", "brad-framework") => 'yes')
	  ),
	     
	array(
      "type" => 'textfield',
      "heading" => __("Title", "brad-framework"),
      "param_name" => "title",
	  "value" => "" ,
	  "admin_label" => true
	  ),
	  
	 array(
      "type" => 'textarea_html',
      "heading" => __("Description", "brad-framework"),
      "param_name" => "content"
	  ) ,
	  
	  array(
      "type" => 'textfield',
      "heading" => __("Price", "brad-framework"),
      "param_name" => "price",
	  "value" => "",
	  "admin_label" => true
	  )
	  
	     
   )
 )
);



?>