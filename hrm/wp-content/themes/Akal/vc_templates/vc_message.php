<?php


/* Message Box
-------------------------------------------------------*/


		$output = $color = $el_class = $css_animation = '';
        extract(shortcode_atts(array(
          'color' => 'alert-info',
		  'close' => '',
          'el_class' => '',
          'css_animation' => '',
		  'css_animation_delay' => ''), $atts));
       
	  $el_class = $this->getExtraClass($el_class);


      $color = ( $color != '' ) ? $color : '';
      $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'alert '.$color.$el_class, $this->settings['base']);
	  $css_class .= $this->getCSSAnimation($css_animation);
      $output .= "\n\t".'<div class="'.$css_class.'" data-animation-effect="'.$css_animation.'" data-animation-delay="'.$css_animation_delay.'">';
	  if( $close === 'yes') {
		  $output .= '<span class="close"><i class="icon-blandes-remove"></i></span>';
	  }
	  $output .= "\n\t\t".wpb_js_remove_wpautop($content);
	  $output .= "\n\t".'</div>'.$this->endBlockComment('alert box')."\n";
      echo $output;
