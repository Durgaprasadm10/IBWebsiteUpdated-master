<?php /* Template Name: P M NOTICES */ ?>
<?php
   global $wpdb;
get_header();

?>
<?php global $current_user;
      get_currentuserinfo();
$name = $current_user->user_firstname;
$username = $current_user->user_login;
$mgrcode = $current_user->mgr_code;
$idu = $current_user->ID;
//$rid = $current_user->emp_code;
//echo $username;

?>
<div class="container">
<div class="row-fluid">


<?php 

if ( is_user_logged_in() ) {
$roll = get_user_role();

if(($roll) == 'author'){




echo do_shortcode("[tablemaster sql='SELECT * from wp_attendance_notpunch' columns='ECode,Name,Date,Status' class='black-header-gray-alternate-rows']"); 

}
}
 ?>
</div></div><br /><br /><br />
<?php get_footer(); ?>