<?php global $brad_data , $woocommerce , $header_class , $post , $brad_menu_id; ?>
<?php $contact_info = ($brad_data['email_sidenav'] != '' || $brad_data['phone_sidenav'] != '' ) ? true : false; ?>

<div id="side_header" class="header-nav">
  <div class="logo-container">
    <div id="side_logo"><a href="<?php echo home_url(); ?>">
      <?php if( isset($brad_data['media_logo']['url'])){ ?>
      <img src="<?php echo $brad_data['media_logo']['url']; ?>" class="default-logo" alt="<?php bloginfo('name'); ?>">
      <?php } else { echo bloginfo('name'); }?>
      </a></div>
  </div>
  <!-- Main Navigation Menu -->
  <?php 
 if(has_nav_menu('main_navigation')){
    wp_nav_menu(array('theme_location' => 'main_navigation' , 'menu' => $brad_menu_id , 'depth' => 3 , 'container' => false ,  'menu_id' => 'side_menu','menu_class' => 'side_menu'));
} 
?>
  <!-- Social Icons -->
  <div class="side-nav-extra">
    <?php 
      if( $brad_data['check_searchicons_header'] ){
		   get_template_part('framework/headers/social-icons'); 
	  }
  ?>
    <?php if($contact_info): ?>
    <ul class="contact-info">
      <?php if ( $brad_data['phone_sidenav'] != '') : ?>
      <li><i class="fa-phone"></i><?php echo $brad_data['phone_topbar'];?></li>
      <?php endif; ?>
      <?php if ( $brad_data['email_sidenav'] != '') : ?>
      <li><i class="fa-envelope"></i><?php echo $brad_data['email_topbar'];?></li>
      <?php endif; ?>
    </ul>
    <?php endif; ?>
  </div>
</div>
<div id="header_wrapper" class="type1">
  <div class="header_container">
    <div id="header" class="<?php echo $header_class;?>" data-height="<?php echo $brad_data['header_height']?>">
      <section id="main_navigation" class="">
        <div class="container">
          <div id="main_navigation_container" class="row-fluid">
            <div class="row-fluid"> 
              
              <!-- logo -->
              <div class="logo-container">
                <div id="logo"><a href="<?php echo home_url(); ?>">
                  <?php if( isset($brad_data['media_logo']['url'])){ ?>
                  <img src="<?php echo $brad_data['media_logo']['url']; ?>" class="default-logo" alt="<?php bloginfo('name'); ?>">
                  <?php if( isset($brad_data['media_logo_white']['url']) ){ ?>
                  <img src="<?php echo $brad_data['media_logo_white']['url']; ?>" class="white-logo" alt="<?php bloginfo('name'); ?>">
                  <?php } else { ?>
                  <img src="<?php echo $brad_data['media_logo']['url']; ?>" class="white-logo" alt="<?php bloginfo('name'); ?>">
                  <?php }} else { echo bloginfo('name'); }?>
                  </a></div>
              </div>
              <!-- Tooggle Menu will displace on mobile devices -->
              <div id="mobile-menu-container">
              <?php if($woocommerce && $brad_data['check_cartmobile'] == true):?>
                <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="carticon-mobile"><i class="fa-shopping-cart"></i></a>
                <?php endif; ?>
              <a class="toggle-menu" href="#"><i class="fa-navicon"></i></a>  
              </div>
             
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
