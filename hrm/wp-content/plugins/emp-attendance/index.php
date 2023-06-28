<?php 

/*
    Plugin Name: TOTAL EMP ATTENDANCE
    Plugin URI: ideabytes.com/
    Description: TOTAL EMP AVERAGE Developed by IB. Total Attendance [totalempatten]
    Author: IB
    Version: 1.7.18
    Author URI: www.ideabytes.com
    Contributors: IB
        Requires at least: 3.5
    Tested up to: 4.4.2
    Text Domain: total-emp-attendance
    
    
 */
ob_start();
?>

<?php
function t_emp_atten( $atts ) {
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



?>



<?php
//echo $rid;

$showleave = ("SELECT ECode, Name, COUNT(ECode) as ecod, COUNT(Status) as stat, SEC_TO_TIME(SUM(TIME_TO_SEC(`WorkDur`))) AS totwork, Status FROM wp_attendance WHERE ECode = '$rid' GROUP BY ECode, Name, Status ORDER BY ecod DESC"); 
echo "<table>
<tr><td style='background-color: #242a30;color:#FFFFFF;' colspan='4'><strong>ATTENDANCE</strong></td></tr>
<th style='text-align:right;'>TOTAL DAYS</th><th>STATUS</th><th>TOTAL WORKED HOURS</th>"; //<th>Ecode</th><th>Name</th>
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

$showtotal = ("SELECT ECode, Name, COUNT(ECode) as ecdo FROM wp_attendance WHERE ECode = '$rid' GROUP BY ECode");
$showtotallist = $wpdb->get_results($showtotal);
//echo "<table>";
echo "<tr>";
foreach($showtotallist as $showtotallist){

echo "<td style='text-align:right;'> TOTAL : ". $showtotallist->ecdo."</td><td></td>";
}
//SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS work

$averagetotal = ("SELECT ECode, Name, COUNT(ECode) as doec, SEC_TO_TIME(AVG(TIME_TO_SEC(`WorkDur`))) AS worktot, Status FROM wp_attendance WHERE ECode = '$rid' AND Status = 'Present' GROUP BY ECode");
$averagetotallist = $wpdb->get_results($averagetotal);
//echo "<table>";
//echo "<tr>";
foreach($averagetotallist as $averagetotallist){

$averaget = $averagetotallist->worktot / $averagetotallist->doec;
//echo number_format((float)$averaget, 2, '.', '');

echo "<td style='text-align:right;'> AVERAGE : ".$averagetotallist->worktot."</td>";
}
echo "</tr></table>";
?>

<br />



<?php


echo do_shortcode("[tablemaster default_sort='false' sql='SELECT (idno) AS ID, Date,ECode,Name,(AInTime) AS InTime,(AOutTime) AS OutTime,(WorkDur) AS Duration,Status from wp_attendance where ECode __EQ__ $rid GROUP BY Date,ECode,Name ORDER BY idno DESC' columns='Date,ECode,Name,InTime,OutTime,Duration,Status' class='black-header-gray-alternate-rows']"); ?>

<?php 


 }

else {

echo do_shortcode('[wp-members page=login]');

} ?>

</td></tr></table>

</div></div>

<br /><br />
<?php
}
add_shortcode( 'totalempatten', 't_emp_atten' );

?>