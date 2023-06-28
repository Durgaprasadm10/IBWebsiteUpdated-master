<?php /* Template Name: LEAVE REPORT ALL */ ?>
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
<table>
<th>EMPLOYEE LEAVE REPORTS</th>
<tr><td>


<?php 

if ( is_user_logged_in() ) {
$roll = get_user_role();

if(($roll) == 'author'){




echo do_shortcode("[tablemaster default_sort='false' datatables='true' sql='SELECT * from wp_leave ORDER BY applied DESC' columns='ecode,ename,from,to,noofdays,type,status,reason,applied' class='black-header-gray-alternate-rows']"); 

}
}
 ?>
</td></tr></table>
</div></div><br /><br /><br />
<?php get_footer(); ?>