<?php global $brad_data , $post , $brad_includes;
    $brad_includes["load_bxslider"] = true;	
?>
<section class="section" style="padding-top:80px; padding-bottom:20px;">
  <div class="container">
    <div class="row-fluid">
      <div class="row-fluid">
        <div class="span8">
          <div class="inner-content">
             <?php  $images =  rwmb_meta('brad_image_list', 'type=image&size=fullwidth'); ?>
            <?php if(!empty($images)  || get_post_meta(get_the_ID(),'brad_video_embed',true) != '' ): ?>
             <div class="flexible-slider-container">
              <div class="flexible-slider">
                <?php if( get_post_meta(get_the_ID(),'brad_video_embed',true) != ''):?>
                <div>
                  <div class="video"><?php echo get_post_meta(get_the_ID(),'brad_video_embed',true);?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($images)):
		            foreach($images as $image ){
			        $src = $image['url'];
			        $src2 = $image['full_url'];; ?>
                <li>
                  <div class="image hoverlay"><img src="<?php echo $src;?>" alt="<?php the_title();?>" />
                    <div class="overlay">
                      <div class="overlay-content"><a href="<?php echo $src2;?>" rel="prettyPhoto[projectSlides]" class="icon"><i class="fa-search"></i></a></div>
                    </div>
                  </div>
                </li>
                <?php } ?>
               <?php endif; ?> 
                <?php if(has_post_thumbnail()): ?>
                <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), ''); ?>
                <li>
                  <div class="image hoverlay">
                    <a  title="<?php the_title(); ?>"  href="<?php echo $full_image[0];?>" rel="prettyPhoto[projectSlides]"><?php the_post_thumbnail(''); ?></a>
                </div>
                </li>
                <?php endif; ?>
            </div>
            </div>
            <?php elseif(has_post_thumbnail() ) : ?>
            <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), ''); ?>
            <div class="image hoverlay">
                <a  title="<?php the_title(); ?>"  href="<?php echo $full_image[0];?>" rel="prettyPhoto[projectSlides]"><?php the_post_thumbnail(''); ?></a>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="span4">
          <div class="inner-content">
            <h3 class="portfolio-single-heading"><span><?php echo __('About the Project','brad');?></span></h3>
              <?php  $content = apply_filters('the_content', get_post_meta(get_the_ID(),'brad_excerpt',true));
			 echo $content;
			 ?>
            </div>
            <div class="gap" style="height:40px; line-height:40px;"></div>
            <h3 class="portfolio-single-heading"><span><?php echo __('Project Info','brad');?></span></h3>
            <div class="project-info">
              <?php if( get_post_meta(get_the_ID(),'brad_project_client',true) != '' ) :  ?>
              <div class="clearfix">
                <h4><?php echo __('Client :','brad');?></h4> 
                <span><?php echo  get_post_meta(get_the_ID(),'brad_project_client',true);?></span>
              </div>
              <?php endif; ?>
              
              <div class="clearfix">
                <h4><?php echo __('Categories :','brad');?></h4>
                <span><?php echo get_the_term_list($post->ID, 'portfolio_category', '', '</span> , <span>', ''); ?></span>
              </div>
              
              <?php if ( get_post_meta(get_the_ID(),'brad_portfolio-link',true) != '' ) : ?>
              <div class="clearfix">
                  <h4><?php echo __('Project Url :','brad');?></h4>
                  <span><a href="<?php echo get_post_meta(get_the_ID(),'brad_portfolio-link',true);?>"><?php  if( get_post_meta(get_the_ID(),'brad_portfolio-link-title',true) != '' ) { echo get_post_meta(get_the_ID(),'brad_portfolio-link-title',true); } else { echo get_post_meta(get_the_ID(),'brad_portfolio-link',true); } ?></a></span>
              </div>
              <?php endif; ?>
            </div>
            <?php if($brad_data['check_sharebox']): ?>
            <div class="post-share project-share clearfix"><h4 class="share-label"><?php echo __('Share : ','brad'); ?> </h4>
              <ul class="post-share-menu">
                <?php if($brad_data['check_sharingboxfacebook']): ?>
                <li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>"  class="facebook-share"><i class="fa-facebook"></i></a></li>
                <?php endif; ?>
                <?php if($brad_data['check_sharingboxtwitter']): ?>
                <li ><a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" class="twitter-share"><i class="fa-twitter"></i></a></li>
                <?php endif; ?>
                <?php if($brad_data['check_sharingboxlinkedin']): ?>
                <li><a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" class="linkedin-share"><i class="fa-linkedin"></i></a></li>
                <?php endif; ?>
                <?php if($brad_data['check_sharingboxpinterest']): ?>
                <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
                <li ><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?>&amp;media=<?php echo urlencode($full_image[0]); ?>" class="pinterest-share"><i class="fa-pinterest"></i></a></li>
                <?php endif; ?>
                <?php if($brad_data['check_sharingboxgoogle']): ?>
                <li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"  class="google-share"><i class="fa-google-plus"></i></a></li>
                <?php endif; ?>
              </ul>
             </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
