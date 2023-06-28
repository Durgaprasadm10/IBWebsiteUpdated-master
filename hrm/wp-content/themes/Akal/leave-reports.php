<?php /* Template Name: LEAVE REPORT MANAGER */ ?>
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
<br />
<table><th>LEAVE REQUESTS</th><tr><td>
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

echo "<div id='content'>";
$start=0;
$limit=7;

if(isset($_GET['id']))
{
$id=$_GET['id'];
$start=($id-1)*$limit;
}

$list_emp = ("SELECT * FROM wp_leave WHERE mgrid = '$rid' ORDER BY lidno DESC LIMIT $start, $limit");
$list_emp = $wpdb->get_results($list_emp);

echo "<h2>Leave Details</h2>";
//echo  $rid;
echo "<table><th>Ecode</th><th>Name</th><th>From</th><th>To</th><th>Type</th><th>No of<br />Days</th><th>Reason</th><th>Status</th><th>Approve/Reject</th>";

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
echo $list_emp->ename;
echo "</td>";

echo "<td>";
echo $list_emp->from;
echo "</td>";

echo "<td>";
echo $list_emp->to;
echo "</td>";

echo "<td>";
echo $list_emp->type;
echo "</td>";



echo "<td>";
$start = strtotime($list_emp->from);
$end = strtotime($list_emp->to);

$days_between = ceil(abs($end - $start) / 86400);





$hday = $list_emp->type;

if(($hday) == 'Half-Day'){ echo 'Half - Day'; } else { echo $days_between + '1 '; }

echo "</td>";
echo "<td>";
echo $list_emp->reason;
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
$approve = 'http://ideabytes.com/hrm/activate.php?ecode='.$ride.'&&from='.$sdat.'&&to='.$tda;

echo "<a href ='$approve'><img src='http://ideabytes.com/hrm/wp-content/uploads/2016/06/approve.png' /></a><br />";
//echo "Reason for rejection : <br /><input type='text' name='reason' value='' />";
//$reas = $_POST['reason'];

$reject = 'http://ideabytes.com/hrm/reject.php?ecode='.$ride.'&&from='.$sdat.'&&to='.$tda;
//echo"<a href ='$reject'>Reject Leave </a>";

echo "<form action='http://ideabytes.com/hrm/reject.php' method='GET'>";
echo "Reason for rejection : <br />";
echo "<input type='text' name='reason' value='' />";
echo "<input type='hidden' name='ecode' value='$ride' />";
echo "<input type='hidden' name='from' value='$sdat' />";
echo "<input type='hidden' name='to' value='$tda' />";
echo "<input type='submit' name='reject' value='Reject' />";

echo "</form>";



} else { echo 'Status Updated. For any queries contact : hr@ideabytes.com'; }
echo "</td>";
echo "</tr>";
}
echo "<tr><td colspan='9' style='text-align: -webkit-center;'>";
$rows=mysql_num_rows(mysql_query("SELECT * FROM wp_leave WHERE mgrid = '$rid'"));
$total=ceil($rows/$limit);

if($id>1)
{
echo "<a href='?id=".($id-1)."' class='buttons'>PREVIOUS</a>";
}
if($id!=$total)
{
echo "<a href='?id=".($id+1)."' class='buttons'>NEXT</a>";
}
echo "<ul class='pages'>";
for($i=1;$i<=$total;$i++)
{
if($i==$id) { echo "<li class='currents' style='list-style-type: none;'>".$i."</li>"; }

else { echo "<li style='list-style-type: none;'><a href='?id=".$i."'>".$i."</a></li>"; }
}
echo "</ul>";
echo "</td>";
echo "</tr>";



echo "</table>";

echo "</div>"






/*echo do_shortcode("[tablemaster sql='SELECT * from wp_leave WHERE ecode = $user_last' columns='ecode,from,to,status,applied' class='black-header-gray-alternate-rows']"); */
 ?>
<?php } } ?>
</td></tr></table>
</div></div><br /><br /><br />
<?php get_footer(); ?>
