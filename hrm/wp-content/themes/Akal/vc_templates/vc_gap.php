<?php 
   
   /* Vc Gap */
	$output = '';
	extract(shortcode_atts(array('height' => '20','hide_under' => ''),$atts));
	$hidden_class = '';
		if(!empty($hide_under)){
		  $hide_under = explode(",",$hide_under);
		  foreach($hide_under as $v){
			  $hidden_class .= ' hidden-'.$v;
		  }
		}
	$output .= "<div class=\"gap {$hidden_class}\" style=\"height:{$height}px;line-height:{$height}px;\" ></div>".$this->endBlockComment('.gap')."\n";
	echo $output;
  
  ?>
  