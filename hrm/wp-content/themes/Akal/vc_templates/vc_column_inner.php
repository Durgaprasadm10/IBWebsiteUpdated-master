<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column_Inner
 */
$output = '';
extract(shortcode_atts(array(
         'el_class' => '',
         'width' => '1/1' ), $atts));


$width = str_replace('vc_col-sm-' , 'span' , wpb_translateColumnWidthToSpan($width));

$hidden_class = '';
  if(!empty($hide_under)){
	$hide_under = explode(",",$hide_under);
	foreach($hide_under as $v){
		$hidden_class .= ' hidden-'.$v;
	}
  }
  
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width.$el_class.$hidden_class, $this->settings['base']);
$output .= "\n\t".'<div class="'.$css_class.'">';

$output .= "\n\t\t".'<div class="inner-content">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t\t".'</div> ';
$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";
	
echo $output;