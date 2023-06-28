<?php /* Template Name: STATUS UPDATE COMPOFF */ ?>
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
<?php

$list_emp = ("SELECT * FROM wp_leave_compoff WHERE mgrid = '$rid' ORDER BY compindo DESC");
$list_emp = $wpdb->get_results($list_emp);

echo "<h2>Compoff Details</h2>";
//echo  $rid;
echo "<table><th>Ecode</th><th>Name</th><th>From</th><th>To</th><th>Day<br />Type</th><th>No of<br />Days</th><th>Compoff<br />Details</th><th>Status</th><th>Approve/Reject</th>";

foreach($list_emp as $list_emp)
				{
//$cour = $list_emp->meta_value;
//$key = 'addr2';
//echo $list_emp->ename;
$cour = $list_emp->ID;


echo "<tr>";
echo "<td>";
echo $list_emp->ecode;
echo "</td>";

echo "<td>";
echo $list_emp->name;
echo "</td>";

echo "<td>";
echo $list_emp->from;
echo "</td>";

echo "<td>";
echo $list_emp->to;
echo "</td>";

echo "<td>";
echo $list_emp->day;
echo "</td>";



echo "<td>";
$start = strtotime($list_emp->from);
$end = strtotime($list_emp->to);

$days_between = ceil(abs($end - $start) / 86400);





$hday = $list_emp->type;

if(($hday) == 'Half-Day'){ echo 'Half - Day'; } else { echo $days_between + '1 '; }

echo "</td>";


echo "<td>";
echo $list_emp->compoff_details;
echo "</td>";

echo "<td>";
echo $list_emp->status;
echo "</td>";

echo "<td>";
$statemp = $list_emp->status;
if(($statemp) == 'pending'){
$sdat = $list_emp->from;
$tda = $list_emp->to;
$ride = $list_emp->ecode;
$approve = 'http://ideabytes.com/hrm/compoff-activate.php?ecode='.$ride.'&&from='.$sdat.'&&to='.$tda;

echo "<a href ='$approve'><img src='http://ideabytes.com/hrm/wp-content/uploads/2016/06/approve.png' /></a><br />";
//echo "Reason for rejection : <br /><input type='text' name='reason' value='' />";
//$reas = $_POST['reason'];

$reject = 'http://ideabytes.com/hrm/compoff-reject.php?ecode='.$ride.'&&from='.$sdat.'&&to='.$tda;
//echo"<a href ='$reject'>Reject Leave </a>";

echo "<form action='http://ideabytes.com/hrm/compoff-reject.php' method='GET'>";
echo "Reason for rejection : <br />";
echo "<input type='text' name='reason' value='' required/>";
echo "<input type='hidden' name='ecode' value='$ride' />";
echo "<input type='hidden' name='from' value='$sdat' />";
echo "<input type='hidden' name='to' value='$tda' />";
echo "<input type='submit' name='reject' value='Reject' />";

echo "</form>";



} else { echo 'Status Updated. For any queries contact : hr@ideabytes.com'; }
echo "</td>";
echo "</tr>";
}




echo "</table>";







/*echo do_shortcode("[tablemaster sql='SELECT * from wp_leave WHERE ecode = $user_last' columns='ecode,from,to,status,applied' class='black-header-gray-alternate-rows']"); */
 ?>
<?php } } ?>
</div></div><br /><br /><br />
<?php get_footer(); ?>