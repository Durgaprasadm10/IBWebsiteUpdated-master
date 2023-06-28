<?php global $brad_data , $post , $brad_includes; 
      $ex_class = ($brad_data['portfolio_pagination'] == 'ifscroll' || $brad_data['portfolio_pagination'] == 'loadmore' ) ? 'posts-with-infinite' : '' ; ?>
<?php if (have_posts()) : ?>

<div class="portfolio <?php echo $ex_class;?>">
  <div class="row-fluid portfolio-items sortable-items portfolio-<?php echo $brad_data['portfolio_style'];?> columns-<?php echo $brad_data['portfolio_columns'];?> bg-style-<?php echo $brad_data['portfolio_bg_style']?> enable-hr-<?php echo $brad_data['divider']?> hr-type-<?php echo $brad_data['di_type']?> hr-color-<?php echo $brad_data['di_color']?> hr-style-<?php echo $brad_data['di_style']?> element-padding-<?php echo $brad_data['portfolio_padding']?> element-vpadding-<?php echo $brad_data['portfolio_vpadding']?> info-style-<?php echo $brad_data['info_style']?> info-onhover-<?php echo $brad_data['info_onhover']?> " data-columns="<?php echo $brad_data['portfolio_columns']; ?>"  data-animation-delay="" data-animation-effect="">
    <?php 
	   $args = array(
		 'portfolio_style' => $brad_data['portfolio_style'] ,
		 'class'  => 'span' ,
		 'img_size' => ($brad_data['img_size'] == 'custom' && $brad_data['custom_img_size'] != '' ) ? trim($brad_data['custom_img_size']) : brad_get_img_size($brad_data['portfolio_rcolumns'],'no') ,
		 'show_lb_icon' => $brad_data['portfolio_lightbox'] ,
		 'show_li_icon' => $brad_data['portfolio_linkicon'] ,
		 'en_loveit'    => $brad_data['portfolio_loveit'] ,
		 'disable_li_title' => $brad_data['disable_li_title'] ,
		 'show_categories' => $brad_data['portfolio_categories'] ,
		 'info_onhover' => $brad_data['info_onhover']
	   ); 
	while (have_posts()) : the_post();  
      echo brad_portfolio_loop_style1( $post , $args);
    endwhile; ?>
  </div>
</div>

<?php //only included script if portfolio post exists
  $brad_includes['load_isotope'] = true ;
  
  if( $brad_data['portfolio_pagination'] == 'ifscroll' || $brad_data['portfolio_pagination'] == 'loadmore'){
		echo '<div id="infinite_scroll_loading" class="clearfix margin-on-'.$brad_data['portfolio_vpadding'].' '.$brad_data['portfolio_style'].'"></div>';
		$brad_includes['load_infiniteScroll'] = true ;
   }

  
   if( $brad_data['portfolio_pagination'] == 'default' || $brad_data['portfolio_pagination'] == 'ifscroll' || $brad_data['portfolio_pagination'] == 'loadmore'):
       $p_class =  $brad_data['portfolio_pagination'] == 'default' ? '' : 'hidden';
	   brad_pagination( '' , $range = 2 , true , $p_class);
   endif;
  
   if( $brad_data['portfolio_pagination'] == 'loadmore' ):
       echo '<p id="load_more" class="sp-container aligncenter"><a  href="#" class="button button_'.$brad_data['portfolio_button_style'].'"><span>'.$brad_data['portfolio_lm_title'].'</span></a></p>';
    endif;
?>

<?php endif; ?>
 
