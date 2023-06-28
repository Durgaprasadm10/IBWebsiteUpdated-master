   <?php global $post , $brad_page_id; ?>
   <?php if( get_post_meta($brad_page_id,'brad_portfolio-fullwidth',true) == true ) : ?>
   <div class="fullwidth"><?php the_content(); ?>  </div>
   <?php else : ?>
   <div id="section_0" class="section post-content">
    <div class="container">
     <div class="row-fluid"> 
    <?php the_content(); ?>  
       </div>
     </div>
  </div>
  <?php endif; ?>