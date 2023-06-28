<?php 

/*
    Plugin Name: LEAVE MANAGEMENT
    Plugin URI: http://ideabytes.com/
    Description: LEAVE MANAGEMENT Developed by IB.
    Author: IB
    Version: 1.7.18
    Author URI: http://www.ideabytes.com
    Contributors: IB
        Requires at least: 3.5
    Tested up to: 4.4.2
    Text Domain: leave-management
    
    
 */
ob_start();
?>

<?php
function team_leaves( $atts ) {
global $wpdb; 

?>

<?php global $current_user;
      get_currentuserinfo();
$name = $current_user->user_firstname;
$username = $current_user->user_login;
$usermail = $current_user->user_email;
$ename = $current_user->user_nicename;
$mgrcode = $current_user->mgr_code;
$empname = $current_user->display_name;
$idu = $current_user->ID;
$rid = $current_user->emp_code;
//echo $username;
?>

<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'editor'){

?>

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
<table><th>TEAM LEAVE REPORT</th>
<tr><td>
<?php

$list_q = "select * from wp_users WHERE emp_code = $rid";
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


echo do_shortcode("[tablemaster default_sort='false' datatables='true' sql='SELECT * from wp_leave WHERE mgrid = $rid ORDER BY applied DESC' columns='ecode,ename,from,to,type,noofdays,status,applied' class='black-header-gray-alternate-rows']"); 

}
}
 ?>


</td></tr></table>
<?php

}
add_shortcode( 'team_leave_report', 'team_leaves' );
 ?>
<?php include('tim-exem.php'); ?>