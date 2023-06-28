<?php 
    
function brad_custom_js(){
    global $brad_data ,$google_fonts;
	
	echo $brad_data['fonts_js'];
    echo $brad_data['google_analytics'];
	
    $default_fonts = array( 'Custom Font One', 'Custom Font Two', 'Arial' , "'Arial Black'", "'Bookman Old Style'" , "'Comic Sans MS'" ,'Courier', 'Garamond' ,'Georgia' , 'Impact', "'Lucida Console'" , "'Lucida Sans Unicode'" , "'MS Sans Serif'" , 
"'MS Serif'", "'Palatino Linotype'" , "Tahoma" , "'Times New Roman'", "'Trebuchet MS'", 'Verdana' ,    
 );	
   
 
   $gfonts = array();   

   

	
	if($brad_data['load_gid'] == true){
		/* Now Load Google Fonts */
	   foreach($google_fonts as $google_font) {
	   //Remove the Backup font Family
	   $gfonts_array = explode(", ", $google_font );
	   $font = $gfonts_array[0];
	   //If not a Default Font
	   if( !empty($font) && !in_array($font , $default_fonts) ) {
		   wp_enqueue_style($font ,'http://fonts.googleapis.com/css?family=' . urlencode($font) . ':300,400,400italic,500,600,700,700italic&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese');
		
		}
	 }
 

		wp_enqueue_style('fontAwesome', get_template_directory_uri().'/css/icons.css');
		if(!empty($brad_data['custom_iconfont']['css-url'])){
			wp_enqueue_style('customFont', $brad_data['custom_iconfont']['css-url'] );
		}
	}
	
	else {
		
	   foreach($google_fonts as $google_font) {
		 //Remove the Backup font Family
		 $gfonts_array = explode(", ", $google_font );
		 $font = $gfonts_array[0];
		 //If not a Default Font
		 if( !empty($font) && !in_array($font , $default_fonts) ) {
			 $gfonts[urlencode($font)] = '"' . urlencode($font) . ':300,400,400italic,500,600,700,700italic:latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese"';
		 }
	}
	 $gfonts = implode($gfonts, ', ');
	?>
	<script type="text/javascript">
	WebFontConfig = {
		<?php if(!empty($gfonts)): ?>google: { families: [ <?php echo $gfonts; ?> ] } ,<?php endif; ?>
		custom: {
            families: [ 'fontAwesome' <?php if(!empty($brad_data['custom_iconfont']['name'])) echo ' , "'.$brad_data['custom_iconfont']['name'].'"';?> ],
             urls: ['<?php echo get_template_directory_uri();?>/css/icons.css'<?php if(!empty($brad_data['custom_iconfont']['css-url'])) echo ' , "'.$brad_data['custom_iconfont']['css-url'].'"';?>]
         }
	};
	(function() {
		var wf = document.createElement('script');
		wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
		  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(wf, s);
	})();
</script>

<?php
	}
  }	
	
  add_action( 'wp_enqueue_scripts', 'brad_custom_js' , 2 );
  
function brad_custom_js2(){
    global $brad_data , $device ; 
	if(!is_admin()  && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ):?> 
<!-- Custom Scripts -->
<script type="text/javascript">
(function($){
    'use strict';
	jQuery(document).ready(function($){ 
	
	<?php if( $brad_data['check_loader'] == true): ?>
	
	//Leaving Page Fade Out Effect
	  jQuery('a.external').click(function(e){
		var url = jQuery(this).attr('href');		
		e.preventDefault();		
		if(url != '#'){
	         jQuery('body').append('<div class="brad-loader-overlay" style="display:none;opacity=0;filter:alpha(opacity=0)"><div class="bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div></div>');
			 jQuery('.brad-loader-overlay').fadeIn( 400 , "easeInOutExpo" , function(){		 			
			    document.location.href = url;
		  	});
		}
	});	
	
	<?php  if( $device->isMobile() || $device->isTablet() ) {	?>
	
	 window.addEventListener("DOMContentLoaded", function() {
	     $("body").queryLoader2({						
	       showbar: false ,		
		   backgroundColor: "transparent",			
		   completeAnimation: "fade",
		   minimumTime: 500,
		   onComplete : function() {
				$(".brad-loader-overlay").fadeOut( 300 , "easeInOutExpo" , function(){
					$(".brad-loader-overlay").remove();
				});
			}
		});
      });
							
	  
	  <?php } else { ?>
	  
	  $("body").queryLoader2({						
	        showbar: false ,		
		   backgroundColor: "transparent",	
		   completeAnimation: "fade",
		   minimumTime: 500,
		   onComplete : function() {
				$(".brad-loader-overlay").fadeOut( 300 , "easeInOutExpo" , function(){
					$(".brad-loader-overlay").remove(); 
				});
			}
		});
	  
	  <?php } ?>	
	  <?php endif; ?>
	  
	  var retina = window.devicePixelRatio > 1 ? true : false;
         <?php if($brad_data['media_logo_retina']['url'] && $brad_data['logo_width'] ): ?>
        if(retina) {
        	jQuery('#logo .default-logo').attr('src', '<?php echo $brad_data["media_logo_retina"]['url']; ?>');
        	jQuery('#logo img').css('max-width', '<?php echo intval($brad_data["logo_width"]); ?>px');
			<?php if($brad_data['media_logo_retina_white']['url']){ ?>
			jQuery('#logo .white-logo').attr('src', '<?php echo $brad_data["media_logo_retina_white"]['url']; ?>');
			<?php } else { ?>
			jQuery('#logo .white-logo').attr('src', '<?php echo $brad_data["media_logo_retina"]['url']; ?>');
			<?php } ?>
			<?php if( $brad_data['header_layout'] == 'type4' || $brad_data['header_layout'] == 'type5' ){ ?>
			jQuery('#side_logo .default-logo').attr('src', '<?php echo $brad_data["media_logo_retina"]['url']; ?>');
			jQuery('#side_logo img').css('max-width', '<?php echo intval($brad_data["logo_width"]); ?>px');
			<?php } ?>
        }
        <?php endif; ?>
        
		/* ------------------------------------------------------------------------ */
		/* Add PrettyPhoto */
		/* ------------------------------------------------------------------------ */
		
		var lightboxArgs = {			
			<?php if($brad_data["lightbox_animation_speed"]): ?>
			animation_speed: '<?php echo strtolower($brad_data["lightbox_animation_speed"]); ?>',
			<?php endif; ?>
			overlay_gallery: <?php if($brad_data["lightbox_gallery"]) { echo 'true'; } else { echo 'false'; } ?>,
			autoplay_slideshow: <?php if($brad_data["lightbox_autoplay"]) { echo 'true'; } else { echo 'false'; } ?>,
			<?php if($brad_data["lightbox_slideshow_speed"]): ?>
			slideshow: <?php echo $brad_data['lightbox_slideshow_speed']; ?>, /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			<?php endif; ?>
			<?php if($brad_data["lightbox_theme"]): ?>
			theme: '<?php echo $brad_data['lightbox_theme']; ?>', 
			<?php endif; ?>
			<?php if($brad_data["lightbox_opacity"]): ?>
			opacity: <?php echo $brad_data['lightbox_opacity']; ?>,
			<?php endif; ?>
			show_title: <?php if($brad_data["lightbox_title"]) { echo 'true'; } else { echo 'false'; } ?>,
			<?php if(!$brad_data["lightbox_social"]) { echo 'social_tools: "",'; } ?>
			deeplinking: false,
			allow_resize: true, 			/* Resize the photos bigger than viewport. true/false */
			counter_separator_label: '/', 	/* The separator for the gallery counter 1 "of" 2 */
			default_width: 1200,
			default_height:640
		};

		jQuery("a[rel^='prettyPhoto']").prettyPhoto(lightboxArgs);
	
	
		<?php if($brad_data["lightbox_smartphones"] == 1): ?>
		var windowWidth = 	window.screen.width < window.outerWidth ?
                  			window.screen.width : window.outerWidth;
        var mobile = windowWidth < 500;
        
        if(mobile){
	        jQuery("a[rel^='prettyPhoto']").unbind('click.prettyphoto');
        }
        <?php endif; ?>
	});
}(jQuery))	
</script>
        <?php
		endif;
	}
	
  add_action( 'wp_footer', 'brad_custom_js2' , 99 );
  
  
?>