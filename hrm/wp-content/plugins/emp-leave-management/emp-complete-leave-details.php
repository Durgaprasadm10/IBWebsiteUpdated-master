<?php
function complete_details( $atts ) {
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

<?php 

echo do_shortcode("[tablemaster default_sort='false' sql='SELECT * from wp_leave WHERE ecode = $rid ORDER BY applied DESC' columns='ecode,from,to,type,noofdays,status,applied' class='black-header-gray-alternate-rows']"); 
echo "<br /><br /><br /><br />";
}
add_shortcode( 'complete_leave_details', 'complete_details' );

?>