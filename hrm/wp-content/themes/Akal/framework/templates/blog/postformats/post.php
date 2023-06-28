<?php global $brad_data , $brad_includes , $brad_love; ?>
<?php  global $post; ?>
<?php  $img_size = 'fullwidth';
       $brad_includes['load_bxslider'] = true;
	   $ex_class = ($brad_data['check_blogshare'] == true) ? 'hide-border' : ''; 
	   if( $brad_data['blog_align'] == "bottom"){
		   $ex_class .= ' post-alignment-bottom';
	   }?>

<div id="post-<?php the_ID(); ?>" <?php post_class(' post-standard post-entries '.$ex_class.' clearfix '); ?>>
  <?php  $images =  rwmb_meta('brad_image_list', "type=image&size={$img_size}"); ?>
  <?php if( $brad_data['blog_align'] == 'top') :?>
  <div class="post-upper text<?php echo $brad_data['blog_upper_align'];?>">
	<?php if($brad_data['check_blog_date'] ||  $brad_data['check_blog_categories'] || is_sticky($post->ID) ):?>
    <div class="post-meta-data style2">
      
      <?php if( is_sticky($post->ID) ){ echo '<span class="sticky-post">'. __('Sticky Post','brad') .'</span>'; }?>
      <?php if($brad_data['check_blog_categories']){ ?>
        <span class="post-meta-cats"><?php the_category(' , '); ?></span>
      <?php } ?>
      <?php if($brad_data['check_blog_date']){?>
        <span class="post-meta-date"><?php echo get_the_date('d.m.y');?></span>
      <?php } ?>
    </div>
    <?php endif; ?>

    <!--post meta info -->
    <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'brad'), the_title_attribute('echo=0') ); ?>"><?php the_title(); ?></a></h1>
  </div>
      <?php endif ; ?>
      
  <?php if( !empty($images) || get_post_meta(get_the_ID(),'brad_video_embed',true) != ''  ) { ?>
  <div class="flexible-slider-container">
    <div class="flexible-slider" data-effect="fade" data-navigation="yes" data-pagination="yes">
      <?php if( get_post_meta(get_the_ID(),'brad_video_embed',true) != ''):?>
      <div>
          <div class="video"><?php echo get_post_meta(get_the_ID(),'brad_video_embed',true);?></div>
      </div>
    <?php endif; ?>
    <?php if(!empty($images)):
		 foreach($images as $image ){
			$src = $image['url']; 
		?>
    <div>
      <div class="image hoverlay"> <a  href="<?php the_permalink();?>"><img src="<?php echo $src;?>" alt="<?php the_title();?>" /></a> </div>
    </div>
    <?php } endif; ?>
    <?php if(has_post_thumbnail()): ?>
    <div>
      <div class="image hoverlay">
        <a href="<?php the_permalink();?>">
        <?php the_post_thumbnail($img_size); ?>
        </a> </div>
    </div>
    <?php endif; ?>
  </div>
  </div>
  <?php } else if( has_post_thumbnail() ) { ?>
  <div class="image hoverlay"><a href="<?php the_permalink();?>" >
    <?php the_post_thumbnail($img_size); ?>
    </a> </div>
  <?php } ?>
  
  <?php if( $brad_data['blog_align'] == 'bottom') :?>
  <div class="post-upper text<?php echo $brad_data['blog_upper_align'];?>">
	<?php if($brad_data['check_blog_date'] ||  $brad_data['check_blog_categories'] || is_sticky($post->ID) ):?>
    <div class="post-meta-data style2">
      <?php if( is_sticky($post->ID) ){ echo '<span class="sticky-post">'. __('Sticky Post','brad') .'</span>'; }?>
      <?php if($brad_data['check_blog_categories']){ ?>
        <span class="post-meta-cats"><?php the_category(' , '); ?></span>
      <?php } ?>
      <?php if($brad_data['check_blog_date']){?>
        <span class="post-meta-date"><?php echo get_the_date('d.m.y');?></span>
      <?php } ?>
    </div>
    <?php endif; ?>
     <!--post meta info -->
    <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'brad'), the_title_attribute('echo=0') ); ?>"><?php the_title(); ?></a></h1>
    </div>
    <?php endif ; ?>
    
    
  <!-- post excerpt -->
  <?php if(empty( $post->post_excerpt ) && $brad_data['check_excerpts'] != true ) { ?>
  <div class="post-content">
    <?php the_content('<span class="button button_small button_alternateprimary">'. __("Read More", 'brad') . '</span>'); ?>
  </div>
  <?php } else { ?>
  <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
  <?php } ?>
  
  <?php if($brad_data['check_author'] || ( $brad_data['check_excerpts'] == true && $brad_data['check_readmore'] ) || (comments_open() && $brad_data['check_blog_comments'])  ):?>
            <div class="post-bottom">
			   <?php if( $brad_data['check_excerpts'] == true && $brad_data['check_readmore'] ) { echo '<a href="'. get_the_permalink() .'" class="button button_alternateprimary button_small">'. __('Read More','brad').'</a>'; } ?>
               <div class="post-meta-data no-dash">
               <?php if($brad_data['check_author']){ ?>
                  <span><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><i class="fa fa-user"></i><?php the_author_meta( 'display_name' ); ?></a></span>
               <?php } ?>
               <?php if( comments_open() && $brad_data['check_blog_comments']): ?>
                  <span><?php comments_popup_link('<i class="fa fa-comment-o"></i>' . __('No Comment','brad') ,'<i class="fa fa-comment-o"></i> ' . __('1 Comment','brad') , '<i class="fa fa-comment-o"></i>' .  __('% Comments','brad') ); ?></span>
               <?php endif; ?>
               
               <?php if($brad_data['check_postlove']){
                  $love = $brad_love->add_love(true); 
		          echo '<span class="love-it">'. $love .'</span>';
                } ?>
               
               </div>
             </div>
    <?php endif; ?>
             

  
  <?php if($brad_data['check_blogshare'] == true): ?>
  <div class="post-share clearfix">
    <ul class="post-share-menu">
      <?php if($brad_data['check_sharingboxfacebook']): ?>
      <li><a href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>&amp;t=<?php echo get_the_title(); ?>"  class="facebook-share"><i class="fa-facebook"></i></a></li>
      <?php endif; ?>
      <?php if($brad_data['check_sharingboxtwitter']): ?>
      <li ><a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" class="twitter-share"><i class="fa-twitter"></i></a></li>
      <?php endif; ?>
      <?php if($brad_data['check_sharingboxlinkedin']): ?>
      <li><a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" class="linkedin-share"><i class="fa-linkedin"></i></a></li>
      <?php endif; ?>
      <?php if($brad_data['check_sharingboxpinterest']): ?>
      <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
      <li><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?>&amp;media=<?php echo urlencode($full_image[0]); ?>" class="pinterest-share"><i class="fa-pinterest"></i></a></li>
      <?php endif; ?>
      <?php if($brad_data['check_sharingboxgoogle']): ?>
      <li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"  class="google-share"><i class="fa-google-plus"></i></a></li>
      <?php endif; ?>
    </ul>
  </div>
  <?php endif; ?>
</div>
