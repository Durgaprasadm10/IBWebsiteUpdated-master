<?php /* Template Name: COMPOFF REPORT */ ?>
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
$rid = $current_user->emp_code;
//echo $username;
?>
<div class="container">
<div class="row-fluid">

<?php 
  $user_id = $idu;
//$user_id .= 4;
  $key = 'addr1';
//$key .= 'addr2';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>

<br />
<?php

$list_q = "select * from wp_usermeta WHERE user_id = $idu";
$list_q = $wpdb->get_results($list_q);

foreach($list_q as $list_q)
				{
$cour = $list_q->meta_value;
//$key = 'addr2';
}

//echo $idu;
 
//echo $rid;

$sno = 'Absent';

//echo $key;
// where ECode __EQ__ $user_last


echo do_shortcode("[tablemaster sql='SELECT * from wp_leave_compoff WHERE ecode = $rid' columns='ecode,ename,from,to,status,appliedon' class='black-header-gray-alternate-rows']"); 
 ?>
</div></div><br /><br /><br />
<?php get_footer(); ?>