<?php global $brad_data , $post , $brad_includes , $brad_love; ?>
<?php if (have_posts()) : 
$brad_includes['load_bxslider'] = true;
if( $brad_includes['load_infiniteScroll'] == true && ( $brad_data['blog_pagination'] == 'if_scroll' || $brad_data['blog_pagination'] == 'loadmore' )) {
	   $output .= '<p>'. __('Sorry You cannot create more than 1 infinite scroll or Load More Posts ( Portfolios ) per page . Please change this in page builder or blog settings ','brad') .'</p>';
	}
	else {
?>
<?php $ex_class = ($brad_data['blog_pagination'] == 'ifscroll' || $brad_data['blog_pagination'] == 'loadmore' ) ? 'posts-with-infinite' : '' ; ?>

<div class="blog-list <?php echo $ex_class;?>">
  <ul class="posts-list">
    <?php  while (have_posts()) : the_post(); ?>
    <?php  $img_list = get_post_meta( get_the_ID(), 'brad_image_list', false );
         if ( !is_array( $img_list ) )
			    	$img_list = ( array ) $img_list;
			    if ( !empty( $img_list ) ) {
			    	$img_list = implode( ',', $img_list );
			    	$images = $wpdb->get_col( "
			    	SELECT ID FROM $wpdb->posts
			    	WHERE post_type = 'attachment'
			    	AND ID IN ( $img_list )
			    	ORDER BY menu_order ASC
			    	" );
				}
				else{
					$images = false;
				}
        ?>
    <li id="post-<?php the_ID(); ?>" <?php post_class(' post-grid-item'); ?>>
      <div class="inner-content">
        <div class="post-list-item-wrap">
          <div class="post-text-container">
            <div class="row-fluid element-padding-large"> 
              <div class="span3 post-list-meta">
              <?php if($brad_data['check_author']  || (comments_open() && $brad_data['check_blog_comments'])  || $brad_data['check_blog_date'] ):?>
                <div class="post-meta-data no-dash clear-all"> 
               <?php if( comments_open() && $brad_data['check_blog_comments']): ?>
                  <span><?php comments_popup_link('<i class="fa fa-comment-o"></i>' . __('No Comment','brad') ,'<i class="fa fa-comment-o"></i> ' . __('1 Comment','brad') , '<i class="fa fa-comment-o"></i>' .  __('% Comments','brad') ); ?></span>
               <?php endif; ?>
               
               <?php if($brad_data['check_postlove']){
                  $love = $brad_love->add_love(true); 
		          echo '<span class="love-it">'. $love .'</span>';
                } ?>
               <?php if($brad_data['check_author']){ ?>
                  <span><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><i class="fa fa-user"></i><?php the_author_meta( 'display_name' ); ?></a></span>
               <?php } ?>
               </div>
              <?php endif; ?>
              </div>
              
              <div class="span3 post-list-image">
                <?php if( !empty($images)  || get_post_meta(get_the_ID(),'brad_video_embed',true) != '' ): ?>
                <div class="flexible-slider-container">
                  <div class="flexible-slider">
                    <?php if( get_post_meta(get_the_ID(),'brad_video_embed',true) != ''):?>
                    <div>
                      <div class="video"><?php echo get_post_meta(get_the_ID(),'brad_video_embed',true);?></div>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($images)):
                            foreach( $images as $image ){
                            $src = wp_get_attachment_image_src( $image , 'thumb-large');
                            $full_image = wp_get_attachment_image_src( $image , '');
                            $src_info = wp_get_attachment_metadata( $image );
                            if( is_array($src_info) && !empty($src_info)){
                                $metadata = ' width="'.$src_info['width'].'" height="'.$src_info['height'].'" ';
                            }
                            else{
                                $metadata = '';
                            }?>
                    <div>
                      <div class="image"> <a href="<?php the_permalink();?>" ><img src="<?php echo $src[0];?>" <?php echo $metadata;?> alt="<?php the_title();?>" /></a> </div>
                    </div>
                    <?php } endif; ?>
                    <?php if(has_post_thumbnail()): ?>
                    <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), ''); ?>
                    <div>
                      <div class="image"> <a href="<?php the_permalink();?>">
                        <?php the_post_thumbnail('thumb-medium'); ?>
                        </a> </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
                <?php elseif( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink();?>">
                <div class="image">
                  <?php the_post_thumbnail('thumb-medium'); ?>
                </div>
                </a>
                <?php endif; ?>
              </div>
              
              <div class="span6 post-list-content">
              <?php if( $brad_data['check_blog_categories'] || $brad_data['check_blog_date'] ):?>
                <div class="post-meta-data style2">
                  <span class="post-meta-cats">
                  <?php the_category(' , '); ?>
                  </span>
                  <?php if($brad_data['check_blog_date']){ ?>
                     <span><?php echo get_the_date('d.m.Y');?></span>
                  <?php } ?>
                </div>
                <?php endif; ?>
                <h1 class="post-list-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'brad'), the_title_attribute('echo=0') ); ?>">
                  <?php the_title(); ?>
                  </a></h1>
                <?php
				if( intval($brad_data['text_excerptlength']) > 0){ ?>
                <p class="excerpt"> <?php echo the_excerpt(); ?></p>
                <?php } ?>
                <?php if( $brad_data['check_readmore'] ) { echo '<a href="'. get_the_permalink() .'" class="button button_alternate button_small">'. __('Read More','brad').'</a>'; } ?>
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </li>
    <?php  endwhile; ?>
  </ul>
  <p class="hidden">
    <?php posts_nav_link(); ?>
  </p>
  <?php if( $brad_data['blog_pagination'] == 'ifscroll' || $brad_data['blog_pagination'] == 'loadmore'){
		echo '<div id="infinite_scroll_loading"></div>';
	    $brad_includes['load_infiniteScroll'] = true ;
     }
	 
     if( $brad_data['blog_pagination'] == 'default' || $brad_data['blog_pagination'] == 'ifscroll' || $brad_data['blog_pagination'] == 'loadmore'):
			   $p_class =  $brad_data['blog_pagination'] == 'default' ? '' : 'hidden';
               brad_pagination($pages = '' , $range = 2 , true , $p_class);
            endif;	 
 

     if( $brad_data['blog_pagination'] == 'loadmore' ):
                echo  '<p id="load_more" class="sp-container aligncenter"><a  href="#" class="button button_alternate icon-align-left" title="'.__('Load More Posts..','brad').'">'.__('Load More','brad').'</a></p>';
           endif;

?>
</div>
<?php } ?>
<?php endif; ?>
