<?php get_header(); 
 global $brad_data;
 
 if( get_post_meta(get_the_ID() , 'brad_blog-layout' , true ) != '' ){
	 $brad_data['blog_layout'] = get_post_meta(get_the_ID() , 'brad_blog-layout' , true );
 }
 
 if(  $brad_data['blog_layout'] == "sidebar") {
	$page_type = 'sidebar';
	} else {
	$page_type = '';
	}
	
 ?>
<?php get_template_part( 'framework/templates/singlepost/content', $page_type ); ?>
<?php get_footer(); ?>
