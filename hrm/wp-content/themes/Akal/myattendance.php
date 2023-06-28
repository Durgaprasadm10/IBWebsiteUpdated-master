<?php /* Template Name: MY DETAILS */ ?>
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
<h3></h3>
<table>
<th>Note:You have Timesheet Attendance from 1st April 2016.</th>
<tr><td>
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

echo do_shortcode("[tablemaster default_sort='false' datatables='true' sql='SELECT (idno) AS ID, Date,ECode,Name,(AInTime) AS InTime,(AOutTime) AS OutTime,(WorkDur) AS Duration,Status from wp_attendance where ECode __EQ__ $user_last GROUP BY Date,ECode,Name ORDER BY Date DESC' columns='Date,ECode,Name,InTime,OutTime,Duration,Status' class='black-header-gray-alternate-rows']"); ?>

<?php } else {

echo do_shortcode('[wp-members page=login]');

} ?>


</td></tr></table>
</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php 

get_footer(); ?>
