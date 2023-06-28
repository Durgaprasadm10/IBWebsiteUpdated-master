<?php  global $brad_data ,$brad_includes,$wp_query; ?>
<?php $brad_includes['load_bxslider'] = true; ?>
<?php 
if (have_posts()) : 
    while (have_posts()) : the_post(); 
        get_template_part('framework/templates/blog/postformats/post' , get_post_format());
    endwhile;
	$brad_includes["load_bxslider"] = true;	
endif; 
?>

<?php brad_pagination($wp_query->max_num_pages , 2 , true , '' , $wp_query->query_vars['paged']); ?>
<p class="hidden">
  <?php posts_nav_link(); ?>
</p>
