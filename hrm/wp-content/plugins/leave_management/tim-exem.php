<?php
ob_start();
function tim_exem( $atts ) {
global $wpdb; 

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
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'author'){

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

echo do_shortcode("[tablemaster default_sort='false' sql='SELECT * FROM wp_time_exemption ORDER BY epn_idno DESC' columns='epn_ecode,epn_name,epn_date,epn_time' class='black-header-gray-alternate-rows']");
 
}
?>


<?php } else {

echo do_shortcode('[wp-members page=login]');

} ?>


</div></div>
<?php
}
add_shortcode( 'exemtim', 'tim_exem' );

?>