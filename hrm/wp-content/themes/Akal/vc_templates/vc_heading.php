<?php 

	extract(shortcode_atts(array('type' => 'h1' , 'icon' => '' , 'style'=>'' , 'color' => 'default'  , 'align' => 'left' , 'title' => 'Your title here' , 'margin_bottom' => '20px' , 'divider_color' => 'dark' , 'divider_width' => 'default'),$atts));
	$output = "\n\t".'<'.$type.' class="title text'.$align.' '.$style.' divider-'.$divider_color.' divider-'.$divider_width.' color-'.$color.'" style="margin-bottom:'.$margin_bottom.'px">';
	$output .= '<span>'.$title . brad_icon($icon , '' ,'',false) .'</span>';
	$output .= "\n\t".'</'.$type.'>'.$this->endBlockComment('heading')."\n";
	echo $output;
 
?>