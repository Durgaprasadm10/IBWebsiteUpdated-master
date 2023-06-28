<?php global $brad_data , $brad_love; ?>
<?php  global $post; ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(' post-standard post-standard-no-border clearfix '); ?>>
<div class="post-format-container">
  <div class="post-format-blockquote"> <i class="fa-chain"></i>
    <blockquote>
      <?php the_content(); ?>
    </blockquote>
  </div>

    <div class="post-format-meta">
      <?php if( $brad_data['check_readmore'] ): ?>
      <a href="<?php the_permalink(); ?>#post_content" class="button button_alternate button_small"> <?php echo __('Read More','brad');?></a>
      <?php endif; ?>
      <div class="post-meta-data no-dash">
        <?php if($brad_data['check_author']){ ?>
        <span><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><i class="fa fa-user"></i>
        <?php the_author_meta( 'display_name' ); ?>
        </a></span>
        <?php } ?>
        <?php if($brad_data['check_blog_date']){ ?>
        <span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
        <?php } ?>
        <?php if($brad_data['check_blog_categories']){ ?>
        <span><i class="fa fa-pencil"></i>
        <?php the_category(' , '); ?>
        </span>
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
  </div>
</div>
