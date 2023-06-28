<?php // Template Name: Fullwidth ?>
<?php  get_header(); ?>
  <?php  if (have_posts()) : while (have_posts()) : the_post(); ?>
   <div class="fullwidth">
    <?php the_content(); ?>  
   </div>
  <?php if(!$brad_data['check_disablecomments']): ?>
  <div class="section">
     <div class="container">
        <div class="row-fluid">
       	<?php wp_reset_query(); ?>
	    <?php comments_template(); ?>
        </div>
     </div>
  </div>      
 
 <?php endif; ?>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
