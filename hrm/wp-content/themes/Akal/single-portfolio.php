<?php global $brad_includes , $post; ?>
<?php get_header(); ?>
<?php while(have_posts()): the_post(); ?>
<?php 
     if( get_post_meta(get_the_ID(),'brad_portfolio-pagebuilder',true) == true ) : 
         get_template_part('framework/templates/single-portfolio/portfolio','builder') ;
     else :
         get_template_part('framework/templates/single-portfolio/portfolio',get_post_meta(get_the_ID(),'brad_project_type',true)) ;
	 endif;
?>
<?php $relatedProjects = brad_get_related_projects(get_the_ID()); ?>
<?php if ( get_post_meta(get_the_ID(),'brad_portfolio-relatedposts',true) && $relatedProjects->have_posts() ) : ?>
<?php $brad_includes['load_caroufred'] = true; ?>

<section class="section" style="padding-top:0; padding-bottom:40px;">
  <div class="container">
    <div class="row-fluid">
      <h3 style="margin-bottom:40px;"><span><?php echo __('Related Projects','brad');?></span></h3>
      <div class="carousel-container">
        <div class="carousel-wrapper carousel-padding-<?php echo $brad_data['portfolio_padding']?>">
          <div class="row carousel-items portfolio-items portfolio-<?php echo $brad_data['portfolio_style'];?> columns-<?php echo $brad_data['portfolio_rcolumns'];?> bg-style-<?php echo $brad_data['portfolio_bg_style']?> enable-hr-<?php echo $brad_data['divider']?> hr-type-<?php echo $brad_data['di_type']?> hr-color-<?php echo $brad_data['di_color']?> hr-style-<?php echo $brad_data['di_style']?> element-padding-<?php echo $brad_data['portfolio_padding']?> info-style-<?php echo $brad_data['info_style']?> info-onhover-<?php echo $brad_data['info_onhover']?>" data-columns="<?php echo $brad_data['portfolio_rcolumns'];?>">
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
	        while($relatedProjects->have_posts()): $relatedProjects->the_post();
                echo brad_portfolio_loop_style1( $relatedProjects , $args);
            endwhile ; ?>
            <?php wp_reset_postdata(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
<?php if(!$brad_data['check_disablecomments']): ?>
<div class="gap" style="height:50px;line-height:50px;">&nbsp;</div>
<?php comments_template(); ?>
<?php endif; ?>
<?php if(get_post_meta(get_the_ID(),'brad_portfolio-shownav' , true) == true ) : ?>
<section class="section" style="padding-top:0; padding-bottom:80px;">
  <div class="container">
    <div class="row-fluid page-nav-container">
      <div class="row-fluid">
        <div class="page-nav-prev">
          <?php previous_post_link('%link' ,'<i class="fa-angle-left"></i><h4>'. __('Previous Post','brad') .'</h4><p>%title</p>'); ?>
        </div>
        <div class="page-nav-next">
          <?php next_post_link('%link' , '<i class="fa-angle-right"></i><h4>'. __('Next Post','brad') .'</h4><p>%title</p>'); ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
<?php endwhile; ?>
<?php get_footer(); ?>
