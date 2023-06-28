<?php /* Template Name: AVERAGE */ ?>
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

if ( is_user_logged_in() ) { ?>
<?php 
  $user_id = $idu;
  $key = 'addr1';
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
$key = 'addr1';
}

//echo $idu;
 
//echo $rid;

//$sno = '36';

//echo $key;

echo do_shortcode("[tablemaster datatables='true' sql='SELECT ECode,Name,SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS work from wp_attendance where ECode __EQ__ $user_last' class='black-header-gray-alternate-rows' columns='ECode,Name,work']"); ?>
<!-- 
[tablemaster datatables='true' sql='SELECT Date,ECode,Name,AInTime,AOutTime,WorkDur,Status,AVG(WorkDur) from wp_attendance where WorkDur __GE__ 9 AND ECode IN ($user_last) GROUP BY Date,ECode,Name' class='black-header-gray-alternate-rows' columns='Date,ECode,Name,AInTime,AOutTime,WorkDur,Status']


[tablemaster sql='SELECT * from wp_attendance where ECode __EQ__ $user_last GROUP BY Date,ECode,Name' columns='Date,ECode,Name,AInTime,AOutTime,WorkDur,Status' class='black-header-gray-alternate-rows']-->

<?php } else {

echo do_shortcode('[wp-members page=login]');

} ?>



</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php 

get_footer(); ?>
