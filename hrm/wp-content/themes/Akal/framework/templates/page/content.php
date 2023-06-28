<?php global $brad_data;  ?>
   <?php  if (have_posts()) : while (have_posts()) : the_post(); ?>
   <div id="section_0" class="section post-content">
    <div class="container">
     <div class="row-fluid"> 
    <?php the_content(); ?>  
       </div>
     </div>
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
   
  
