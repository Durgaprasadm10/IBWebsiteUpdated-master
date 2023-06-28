<?php /* Template Name: EMP LEAVE REPORT */ ?>
<?php
   global $wpdb;
get_header();
ob_start();
?>
<?php global $current_user;
      get_currentuserinfo();
$name = $current_user->user_firstname;
$username = $current_user->user_login;
$mgrcode = $current_user->mgr_code;
$idu = $current_user->ID;
$rid = $current_user->emp_code;
//echo $username;
?>

<div class="container">
<div class="row-fluid">
<table><th></th>
<tr><td>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'author' || $roll == ''){

?>

<?php wp_enqueue_script('jquery-ui-datepicker');

//wp_enqueue_style('jquery-ui-css', 'http://autotestscript.com/ETR/wp-content/themes/Akal/css/calen.css');
 ?>
<?php 
  $user_id = $idu;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>

<br />

<?php

echo do_shortcode("[tablemaster sql='SELECT *FROM wp_emp_leave_list ' columns='ecode,name,from,to,cl,sl,el,compoff' class='black-header-gray-alternate-rows']");
 
}
?>


<?php } else {

echo do_shortcode('[wp-members page=login]');

} ?>

</td><tr></table>
</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php get_footer(); ?>
