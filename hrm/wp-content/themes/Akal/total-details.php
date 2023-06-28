<?php /* Template Name: TOTAL EMPLOYEE DETAILS */ ?>
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

if(($roll) == 'author'){

?>
<?php 
  $user_id = $idu;
  $key = 'addr1';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>

<br />
<table><tr><td>
<h3>Note:You have Timesheet Attendance from 1st April 2016.</h3>

<form id="form_id" method="post" enctype="multipart/form-data">

Emp Code : <input type="text" class="custom_date" name="empcode" id="empcode" value="" required/>


<br />
<input type="submit" name="submit" value="SEARCH" />
</form>

<?php 

if(isset($_POST['submit'])){
$ecod = $_POST['empcode'];

?>

<h2>ATTENDANCE</h2>

<?php
//echo $rid;

$showleave = ("SELECT ECode, Name, COUNT(ECode) as ecod, COUNT(Status) as stat, SEC_TO_TIME(SUM(TIME_TO_SEC(`WorkDur`))) AS totwork, Status FROM wp_attendance WHERE ECode = '$ecod' GROUP BY ECode, Name, Status ORDER BY ecod DESC"); 
echo "<table><th>TOTAL DAYS</th><th>STATUS</th><th>TOTAL WORKED HOURS</th>"; //<th>Ecode</th><th>Name</th>
$showleavelist = $wpdb->get_results($showleave); //<th>TYPE</th>

foreach($showleavelist as $showleavelist){

$showecode = $showleavelist->ECode;
$showname = $showleavelist->Name;
$showcl = $showleavelist->ecod;
$showsl = $showleavelist->stat;
$showel = $showleavelist->totwork;
$showcomp = $showleavelist->Status;
echo "<tr>";
//echo "<td>".$showecode."</td>";
//echo "<td>".$showname."</td>";
echo "<td style='text-align:right;'>".$showcl."</td>";
//echo "<td>".$showsl."</td>";
echo "<td>".$showcomp."</td>";
echo "<td>".$showel."</td></tr>";
}
//echo "</table>";
 ?>
<?php

$showtotal = ("SELECT ECode, Name, COUNT(ECode) as ecdo FROM wp_attendance WHERE ECode = '$ecod' GROUP BY ECode");
$showtotallist = $wpdb->get_results($showtotal);
//echo "<table>";
echo "<tr>";
foreach($showtotallist as $showtotallist){

echo "<td style='text-align:right;'> TOTAL : ". $showtotallist->ecdo."</td><td></td>";
}


$averagetotal = ("SELECT ECode, Name, COUNT(ECode) as doec, SEC_TO_TIME(SUM(TIME_TO_SEC(`WorkDur`))) AS worktot, Status FROM wp_attendance WHERE ECode = '$ecod' AND Status = 'Present' GROUP BY ECode");
$averagetotallist = $wpdb->get_results($averagetotal);
//echo "<table>";
//echo "<tr>";
foreach($averagetotallist as $averagetotallist){

$averaget = $averagetotallist->worktot / $averagetotallist->doec;
//echo number_format((float)$averaget, 2, '.', '');

echo "<td style='text-align:right;'> AVERAGE : ".number_format((float)$averaget, 2, '.', '')."</td>";
}
echo "</tr></table>";
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

echo do_shortcode("[tablemaster sql='SELECT (idno) AS ID, Date,ECode,Name,(AInTime) AS InTime,(AOutTime) AS OutTime,(WorkDur) AS Duration,Status from wp_attendance where ECode __EQ__ $ecod GROUP BY Date,ECode,Name ORDER BY idno DESC' columns='Date,ECode,Name,InTime,OutTime,Duration,Status' class='black-header-gray-alternate-rows']"); ?>

<?php 
}
} 

 }

else {

echo do_shortcode('[wp-members page=login]');

} ?>

</td></tr></table>

</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php 

get_footer(); ?>
