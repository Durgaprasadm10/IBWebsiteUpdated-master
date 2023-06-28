<?php 
global $brad_menu_id , $post;



if(has_nav_menu('main_navigation')){
    wp_nav_menu(array('theme_location' => 'main_navigation' , 'menu' => $brad_menu_id , 'depth' => 3 , 'items_wrap' => '%3$s' , 'container' => false, 'walker' => new Brad_Megamenu_walker ,  'menu_id' => 'main_menu','menu_class' => 'main_menu'));
} 
?>