<?php /* Template Name: REPORTS */ ?>
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
<br />
<table><th>TEAM ATTENDANCE</th><tr><td>
<?php 
  $user_id = $idu;
//$user_id .= 4;
  $key = 'mgrid';
//$key .= 'addr2';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>

<br />
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'editor'){

?>
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

//$sno = '36';

//echo $key;
// where ECode __EQ__ $user_last
echo do_shortcode("[tablemaster default_sort='false' datatables='true' sql='SELECT * from wp_attendance WHERE ECode IN ($user_last) GROUP BY Date,ECode,Name ORDER BY Date DESC ' columns='Date,ECode,Name,AInTime,AOutTime,WorkDur,Status' class='black-header-gray-alternate-rows']"); 
} else {
echo '<h2>This data restricted for only Team Managers</h2>';

}
}
?>
</td></tr></table>
</div></div><br /><br /><br />
<?php 

get_footer(); ?>