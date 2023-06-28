<?php
// Template Name: Side Navigation
?>
<?php  get_header(); ?>
<?php
global $brad_data ,$brad_sidebar , $brad_page_id;
$brad_sidebar = 'yes';
if(get_post_meta($brad_page_id, 'brad_sidenav_position', true) == 'left') {
		$content_css = 'content-right';
		$sidebar_css = 'sidebar-left';
	} else {
		$content_css = 'content-left';
		$sidebar_css = 'sidebar-right';
	}
?>

<section class="section-with-sidebar side-navigation-wrapper">
  <div class="container">
    <div class="row-fluid">
      <div class="row-fluid">
        <div id="sidebar" class="span3 sidebar <?php echo $sidebar_css; ?>" style="">
          <div class="inner-content">
            <ul class="side-navigation">
              <?php 	
				$post_ancestors = get_post_ancestors($post->ID);
				$post_parent = end($post_ancestors);
			?>
           
              <?php
			if($post_parent) {
				$children = wp_list_pages("title_li=&child_of=".$post_parent."&echo=0");
			} else {
				$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
			}
			
			if ($children) { echo $children;  } ?>
            </ul>
            
            <div class="side-navigation-mobile">
            <a href="#" class="current-page">Select</a>
            <ul>
              <?php 	
				$post_ancestors = get_post_ancestors($post->ID);
				$post_parent = end($post_ancestors);
			?>
           
              <?php
			if($post_parent) {
				$children = wp_list_pages("title_li=&child_of=".$post_parent."&echo=0");
			} else {
				$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
			}
			
			if ($children) { echo $children;  } ?>
            </ul>
           </div>
          </div>
        </div>
        <div id="content" class="span9 content <?php echo $content_css;?>">
          <div class="inner-content">
             <?php if (have_posts()) : while (have_posts()) : the_post();
			       the_content();
                   endwhile; endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php  get_footer(); ?>
