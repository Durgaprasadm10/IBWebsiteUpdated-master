<?php global $brad_data , $brad_page_id , $brad_love; ?>
<?php  global $post; ?>
<?php  $img_size = 'fullwidth'; $ex_class = ''; 
       if( $brad_data['blog_align'] == "bottom"){
		   $ex_class .= ' post-alignment-bottom';
	   }?>

<div id="post-<?php the_ID(); ?>" <?php post_class(' post-standard post-single '.$ex_class.' clearfix '); ?>>
  <?php  $images =  rwmb_meta('brad_image_list', "type=image&size={$img_size}"); ?>
  
  <?php if(  $brad_data['blog_align'] != 'bottom' && $brad_data['blog_align'] == 'top') :?>
  <div class="post-upper text<?php echo $brad_data['blog_upper_align'];?>">
    <?php if($brad_data['check_blog_date'] ||  $brad_data['check_blog_categories'] ):?>
    <div class="post-meta-data style2">
      <?php if($brad_data['check_blog_categories']){ ?>
      <span class="post-meta-cats">
      <?php the_category(' , '); ?>
      </span>
      <?php } ?>
      <?php if($brad_data['check_blog_date']){?>
      <span class="post-meta-date"><?php echo get_the_date('d.m.y');?></span>
      <?php } ?>
    </div>
    <?php endif; ?>
    
    <!--post meta info -->
    <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'brad'), the_title_attribute('echo=0') ); ?>">
      <?php the_title(); ?>
      </a></h1>
  </div>
  <?php endif ; ?>
  
  
  <?php if(get_post_meta($brad_page_id,'brad_blog-featured',true) != true ) : ?>
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
        <div class="image hoverlay"> <a href="<?php the_permalink();?>">
          <?php the_post_thumbnail($img_size); ?>
          </a> </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php } else if( has_post_thumbnail() ) { ?>
  <div class="image hoverlay"> <a href="<?php the_permalink();?>" >
    <?php the_post_thumbnail($img_size); ?>
    </a> </div>
  <?php } ?>
 <?php endif ; ?>
  
  <?php if(  $brad_data['blog_align'] == 'bottom' &&  $brad_data['blog_align'] == 'bottom') :?>
  <div class="post-upper text<?php echo $brad_data['blog_upper_align'];?>">
    <?php if($brad_data['check_blog_date'] ||  $brad_data['check_blog_categories'] ):?>
    <div class="post-meta-data style2">
      <?php if($brad_data['check_blog_categories']){ ?>
      <span class="post-meta-cats">
      <?php the_category(' , '); ?>
      </span>
      <?php } ?>
      <?php if($brad_data['check_blog_date']){?>
      <span class="post-meta-date"><?php echo get_the_date('d.m.y');?></span>
      <?php } ?>
    </div>
    <?php endif; ?>
    
     <!--post meta info -->
    <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'brad'), the_title_attribute('echo=0') ); ?>">
      <?php the_title(); ?>
      </a></h1>
     </div> 
      
    <?php endif; ?>
    
   
 
  
  <!-- post excerpt -->
  <div class="excerpt">
    <?php the_content(); ?>
  </div>
  
    <?php if($brad_data['check_author']  || $brad_data['check_postlove'] ||  (comments_open() && $brad_data['check_blog_comments'])  ):?>
  <div class="post-bottom">
    <div class="post-meta-data no-dash">
      <?php if($brad_data['check_author']){ ?>
      <span><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><i class="fa fa-user"></i>
      <?php the_author_meta( 'display_name' ); ?>
      </a></span>
      <?php } ?>
      <?php if( comments_open() && $brad_data['check_blog_comments']): ?>
      <span>
      <?php comments_popup_link('<i class="fa fa-comment-o"></i>' . __('No Comment','brad') ,'<i class="fa fa-comment-o"></i> ' . __('1 Comment','brad') , '<i class="fa fa-comment-o"></i>' .  __('% Comments','brad') ); ?>
      </span>
      <?php endif; ?>
      <?php if($brad_data['check_postlove']){
                  $love = $brad_love->add_love(true); 
		          echo '<span class="love-it">'. $love .'</span>';
                } ?>
    </div>
  </div>
  <?php endif; ?>
  
</div>

