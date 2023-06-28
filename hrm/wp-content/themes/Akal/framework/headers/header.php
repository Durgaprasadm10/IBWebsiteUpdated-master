<?php global $brad_data , $woocommerce , $header_class; ?>
                 
<div id="header_wrapper" class="<?php echo $header_class?>">
  <?php
if( @$brad_data['show_topbar'] == true ) :
    get_template_part('framework/headers/header-topbar');
endif;
?>
  <div class="header_container">
    <div id="header" class="header-v1 <?php if($brad_data['check_fixed_header'] == true){ echo ' sticky-nav'; } else if( $brad_data['show_second_nav'] == true){ echo ' second-nav';}?>" data-height="<?php echo $brad_data['header_height']?>" data-shrinked-height="<?php echo intval($brad_data['shrink_nav_height']);?>" data-auto-offset="<?php echo $brad_data['check_auto_offset'];?>" data-offset="<?php echo intval($brad_data['shrink_nav_offset'])?>" data-second-nav-offset="<?php echo intval($brad_data['second_nav_offset'])?>">
      <section id="main_navigation" class="header-nav shrinking-nav">
        <div class="container">
          <div id="main_navigation_container" class="row-fluid">
            <div class="row-fluid"> 
              <!-- logo -->
              <div class="logo-container">
                <a id="logo" href="<?php echo home_url(); ?>">
                  <?php if( isset($brad_data['media_logo']['url'])){ ?>
                  <img src="<?php echo $brad_data['media_logo']['url']; ?>" class="default-logo" alt="<?php bloginfo('name'); ?>">
                  <?php if( isset($brad_data['media_logo_white']['url']) ){ ?>
                  <img src="<?php echo $brad_data['media_logo_white']['url']; ?>" class="white-logo" alt="<?php bloginfo('name'); ?>">
                  <?php } else { ?>
                  <img src="<?php echo $brad_data['media_logo']['url']; ?>" class="white-logo" alt="<?php bloginfo('name'); ?>">
                  <?php }} else { echo bloginfo('name'); }?>
                  </a>
         
              </div>  
                
              <!-- Tooggle Menu will displace on mobile devices -->
              <div id="mobile-menu-container">
              <?php if($woocommerce && $brad_data['check_cartmobile'] == true):?>
                <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="carticon-mobile"><i class="fa-shopping-cart"></i></a>
                <?php endif; ?>
              <a class="toggle-menu" href="#"><i class="fa-navicon"></i></a>  
<!--<ul id="mobile_menu" class="mobile_menu">
<?php
if ( is_user_logged_in() ) {
$roll = get_user_role();

if(($roll) == 'editor'){

//echo '<li><a href="http://hrm.ideabytes.com/my-attendance/">MY ATTENDANCE</a></li>';
echo '<li><a href="http://hrm.ideabytes.com/reports-test/">REPORTS</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/profile-edit/">PROFILE</a></li>';

}
if(($roll) == 'author'){

echo '<li><a href="http://hrm.ideabytes.com/l-register/">REGISTER</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/my-attendance/">MY ATTENDANCE</a></li>';
echo '<li><a href="http://hrm.ideabytes.com/reports-test/">REPORTS</a></li>';
echo '<li><a href="http://hrm.ideabytes.com/csv-upload/">UPLOAD ATTENDANCE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/profile-edit/">PROFILE</a></li>';

}

if(($roll) == 'subscriber'){
//echo '<li><a href="http://hrm.ideabytes.com/my-attendance/">MY ATTENDANCE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/profile-edit/">PROFILE</a></li>';

}
if(($roll) == 'administrator'){

echo '<li><a href="http://hrm.ideabytes.com/employee-attendance/">MY ATTENDANCE</a></li>';
}
?>
<li><a href="http://hrm.ideabytes.com/forgot-password/">RESET PASSWORD</a></li>    
<li><a href="<?php echo wp_logout_url( home_url() ); ?>">LOGOUT</a></li>
<?php
} else {
    echo '<li><a href="http://hrm.ideabytes.com/login/">LOGIN</a></li>';
}
?></ul>-->

              </div>
              
              <nav class="nav-container">
                <ul id="main_menu" class="main_menu">
                <!-- Main Navigation Menu -->
                <?php get_template_part('framework/headers/nav-bar'); ?>
                             
                <?php if ($woocommerce && $brad_data['check_cartheader'] == true) { ?>
                <li class="cart-container"> 
                  <!-- Cart Icons --> 
                  <a class="cart-icon-wrapper" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"> <span class="cart-icon"><i class="fa-shopping-cart"></i></span><span class="count"><?php echo $woocommerce->cart->cart_contents_count; ?></span></a> 
                  <!-- Cart Menu Start -->
                  <?php
               // Check for WooCommerce 2.0 and display the cart widget
	          if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
	                the_widget( 'WC_Widget_Cart', 'title= ' );
	          } else {
		         the_widget( 'WooCommerce_Widget_Cart', 'title= ' );
	         }
	         ?>
                </li>
                <?php }  ?>
<style>
.dropdown {
    position: relative;
    display: inline-block;
    margin-left: 18px;
color : #000000;
font-family: Raleway;
    text-transform: uppercase;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
font-family: Raleway;
    text-transform: uppercase;
}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>

<?php
if ( is_user_logged_in() ) {

//echo '<li><a href="http://hrm.ideabytes.com/my-attendance/">MY ATTENDANCE</a></li>';

//echo '<li><a href="http://hrm.ideabytes.com/profile-edit/">PROFILE</a></li>';

$roll = get_user_role();

if(($roll) == 'editor'){

//echo '<li><a href="http://hrm.ideabytes.com/my-attendance/">MY ATTENDANCE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/reports-test/">REPORTS</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/leave/">LEAVE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/average/">AVERAGE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/average-team/">TEAM AVERAGE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/profile-edit/">PROFILE</a></li>';

/*wp_nav_menu(array('theme_location' => 'main_navigation', 'menu' => $brad_menu_id ,'depth' => 3 , 'container' => false, 'menu_id' => 'editor_menu','menu_class' => 'editor_menu')); */

}
if(($roll) == 'author'){

//echo '<li><a href="http://hrm.ideabytes.com/l-register/">REGISTER</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/my-attendance/">MY ATTENDANCE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/reports/">REPORTS</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/csv-upload/">UPLOAD ATTENDANCE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/assign-employees/">ASSIGN</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/profile-edit/">PROFILE</a></li>';

}

if(($roll) == 'subscriber'){
//echo '<li><a href="http://hrm.ideabytes.com/my-attendance/">MY ATTENDANCE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/profile-edit/">PROFILE</a></li>';
//echo '<li><a href="http://hrm.ideabytes.com/average/">AVERAGE</a></li>';

}
if(($roll) == ''){
echo '<div class="dropdown">
  <span><a href="http://hrm.ideabyte.net/#">REPORTS</a></span>';
echo '<div class="dropdown-content">';
echo '<p><a href="http://hrm.ideabyte.net/my-attendance/">MY ATTENDANCE</a></p>';
echo '<p><a href="http://hrm.ideabyte.net/range-search/">MY RANGE</a></p>';
echo '<p><a href="http://hrm.ideabyte.net/average/">MY AVERAGE</a></p>';
echo '<p><a href="http://hrm.ideabyte.net/reports-test/">TEAM ATTENDANCE</a></p>';
echo '<p><a href="http://hrm.ideabyte.net/average-team/">TEAM AVERAGE</a></p>';
echo '</div></div>';
echo '<li><a href="http://hrm.ideabyte.net/profile-edit/">PROFILE</a></li>';
echo '<li><a href="http://hrm.ideabyte.net/change-password/">RESET PASSWORD</a></li>';
}
if(($roll) == 'administrator'){

echo '<li><a href="http://hrm.ideabyte.net/employee-attendance/">MY ATTENDANCE</a></li>';
}
?>
<!--<li><a href="http://hrm.ideabytes.com/change-password/">RESET PASSWORD</a></li>--> 
<li><a href="<?php echo wp_logout_url( home_url() ); ?>">LOGOUT</a></li>
<?php
} else {
    echo '<li><a href="http://hrm.ideabyte.net/login/">LOGIN</a></li>';
}
?>

                
                <?php  if($brad_data['check_searchform'] == true) : ?>
                <li id="header-search-button"> <a href="#"  class="search-button"><i class="fa-search" style="display:none;"></i></a> </li>
                <?php endif; ?>
  
				<?php if( $brad_data['check_searchicons_header'] ){ ?>
                 <li class="header-social-icons">
                      <?php get_template_part('framework/headers/social-icons'); ?>
                 </li>     
                 <?php } ?>
               
               </ul>
               </nav>
              </div>
            </div>
          </div>
      </section>
      <?php  if($brad_data['check_searchform'] == true) : 
            //get_template_part('framework/headers/header-search');
        endif; ?>
    </div>
  </div>
</div>

