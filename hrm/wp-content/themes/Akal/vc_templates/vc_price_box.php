<?php
		$pricing_cid  = rand() ;
		extract(shortcode_atts(array(
		   'style' => 'style1',
		   'title' => 'Standard' ,
		   'subtitle' => '',
		   'icon' => '' ,
		   'htype' => 'h3' ,
		   'title_bgcolor' => '',
		   'title_textcolor' => '',
		   'bgcolor' => '',
		   'bgcolor_hover' => '',
		   'hcolor' => '',
		   'hcolor_hover' => '',
		   'txtcolor' => '',
		   'txtcolor_hover' => '',
		   'pricecolor' => '',
		   'pricecolor_hover' => '' ,
		   'icolor' => '',
		   'icolor_hover' => '',
		   'ibgcolor' => '',
		   'ibgcolor_hover' => '', 
		   'scheme' => 'default' , 
		   'feature_bg_color' => '',
		   'featured' => 'no' ,
		   'feature_color' => '', 
		   'title_bc' => '',
       	   'price' => '10', 
		   'price_top_left' => '$',
		   'price_bottom_right' => '/Month',
		   'price_subtext' => '' ,
		   'bcolor' => 'default',
		   'bcolor_hover' => 'default',
		   'tbgcolor' => '',
		   'tbgcolor_hover' => '',
		   'pbgcolor' => '',
		   'pbgcolor_hover' => '',
		   'target' => '_self',
		   'infocolor' => '',
		   'infocolor_hover' => '',
		   'button_text' => 'Sign Up' ,
		   'href' => '' , 
		   'button_icon' => ''
    ), $atts));
	
	 
	 if( $scheme == 'custom'):
	 $output .= "<style type='text/css' scoped>#pricing_{$pricing_cid}{background-color:{$bgcolor};color:{$txtcolor}}#pricing_{$pricing_cid} .title-box{color:{$hcolor}}#pricing_{$pricing_cid}  .pricing-box > div {color:{$pricecolor}}#pricing_{$pricing_cid} .title-box .brad-icon{color:{$icolor}; background-color:{$ibgcolor};} #pricing_{$pricing_cid} .pricing-box .price-info{color:{$infocolor}}";
	 
	 if($infocolor_hover != '' || $icolor_hover != '' || $bgcolor_hover != '' || $pricecolor_hover != '' || $hcolor_hover != '' ){
		 $output .= "#pricing_{$pricing_cid}:hover{background-color:{$bgcolor_hover};color:{$txtcolor_hover}}#pricing_{$pricing_cid}:hover .pricing-box .price-info{color:{$infocolor_hover}}#pricing_{$pricing_cid}:hover .title-box .brad-icon{color:{$icolor_hover};background-color:{$ibgcolor_hover};}#pricing_{$pricing_cid}:hover  .pricing-box > div{color:{$pricecolor_hover}} #pricing_{$pricing_cid}:hover .title-box{color:{$hcolor_hover}}";
	 }
	 
	 if($style == "style4"){
		 $output .= "#pricing_{$pricing_cid} .title-box{background-color:{$tbgcolor}}#pricing_{$pricing_cid}:hover .title-box{background-color:{$tbgcolor_hover}}#pricing_{$pricing_cid} .pricing-box{background-color:{$pbgcolor}}#pricing_{$pricing_cid}:hover .pricing-box{background-color:{$pbgcolor_hover}}";
	 }
	 else if($style == "style5" ){
		 $output .= "#pricing_{$pricing_cid} .title-box{background-color:{$tbgcolor}}#pricing_{$pricing_cid}:hover .title-box{background-color:{$tbgcolor_hover}}#pricing_{$pricing_cid} .pricing-box .price-content{background-color:{$pbgcolor}}#pricing_{$pricing_cid}:hover .pricing-box .price-content{background-color:{$pbgcolor_hover}}";
	 }
	 else if($style == "style1" ){
		 $output .= "#pricing_{$pricing_cid} .title-box , #pricing_{$pricing_cid} .pricing-box{background-color:{$tbgcolor}}#pricing_{$pricing_cid}:hover .title-box , #pricing_{$pricing_cid}:hover .pricing-box{background-color:{$tbgcolor_hover}}";
	 }
	 $output .= "</style>";
	 endif;
	 
	  if($icon != '' ){ $icon = brad_icon($icon); }
	  $hoverbtn = $bcolor != $bcolor_hover ? 'yes' : 'no';
	  
	  
	  $output .= "\n\t".'<div id="pricing_'.$pricing_cid.'" class="price_box '.$style.' hover-button-'.$hoverbtn.'">';
	  $output .= "\n\t\t".'<div class="title-box">';
	  $output .= "\n\t\t\t".$icon.'<'.$htype.'>' .$title. '</'.$htype.'>';
	  if($subtitle != ''){
		   $output .= "\n\t\t\t".'<div class="subtitle">'. $subtitle .'</div>';
	  }
	  $output .= "\n\t\t".'</div>';
	  $output .= "\n\t\t".'<div class="pricing-box">';
	  $output .= "\n\t\t\t".'<div class="price-content"><span class="price"><span class="dollor">'.$price_top_left.'</span>'.$price.'</span><span class="month">'.$price_bottom_right.'</span></div>';
	  if($price_subtext != ''){
	      $output .= "\n\t\t\t".'<div class="price-info">'.$price_subtext.'</div>';
	  }
	  $output .= "\n\t\t".'</div>'; 
	  
	  $output .= "\n\t\t\t\t".'<div class="feature-list">' .wpb_js_remove_wpautop($content,true). '</div>';
      $output .= "\n\t\t\t\t\t".'<div class="pricing-signup"><div class="pricing-signup-button"><a class="button default-button button_'.$bcolor.'" target="'.$target.'" href="'.$href.'">'.$button_icon.$button_text.'</a><a class="button hover-button button_'.$bcolor_hover.'" target="'.$target.'" href="'.$href.'">'.$button_icon.$button_text.'</a></div></div>';
	  $output .= "\n\t".'</div>';
	  echo $output;