<?php
/**
 */


	$output = $title = $interval = $el_class = '';
     extract(shortcode_atts(array(
        'el_class' => '' ), $atts));
   
    $el_class = $this->getExtraClass($el_class);
    $element = 'horizental-tabset';
    if ( 'vc_tour' == $this->shortcode) $element = 'vertical-tabset';

    // Extract tab titles
     preg_match_all( '/vc_tab title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );
     $tab_titles = array();
     if ( isset($matches[0]) ) { $tab_titles = $matches[0]; }
     $tabs_nav = '';
     $tabs_nav .= '<ul class="tabs clearfix">';
     foreach ( $tab_titles as $tab ) {
     preg_match('/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
    if(isset($tab_matches[1][0])) {
        $tabs_nav .= '<li class="tab"><a href="#tab-'. (isset($tab_matches[3][0]) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) .'">' . $tab_matches[1][0] . '</a></li>';

    }
   }
    $tabs_nav .= '</ul>'."\n";

    $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim('tabset '.$element.' '.$el_class), $this->settings['base']);
    $output .= "\n\t".'<div class="'.$css_class.'">';
    $output .= "\n\t\t".$tabs_nav;
    $output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
    $output .= "\n\t".'</div> '.$this->endBlockComment('.tabset');

    echo $output;	

      