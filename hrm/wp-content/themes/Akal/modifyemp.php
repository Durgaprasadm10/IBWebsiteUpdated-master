<?php /* Template Name: EMP AT MODIFY */ ?>
<?php
   global $wpdb;
get_header();
ob_start();
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
<table>
<th>MODIFY EMPLOYEE ATTENDANCE</th>
<tr><td>
<?php //echo get_calendar(); ?>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'author' ){

?>


<link rel="stylesheet" href="<?php echo plugins_url(); ?>/javascripts/uijquery.css">
  <script src="<?php echo plugins_url(); ?>/javascripts/uijquery.js"></script>
  <script src="<?php echo plugins_url(); ?>/javascripts/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#start_date" ).datepicker({
dateFormat : 'yy-mm-dd',
    //  defaultDate: "+1w",
defaultDate: "0",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to_date" ).datepicker({
dateFormat : 'yy-mm-dd',
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>



<form id="form_id" method="post" enctype="multipart/form-data">
<div width="800px">
Emp Code : <input type="text" class="custom_date" name="empcode" id="empcode" value=""/>

Date : <input type="text" class="custom_date" name="start_date" id="start_date" value=""/></div>

<!--To Date :<input type="text" class="custom_date" name="to_date" id="to_date" value=""/>
<h2>Employees :</h2> -->
<?php 
  $user_id = $idu;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
 // echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 
?>


<input type="submit" name="submit" value="Search" />
</form>



<br />

<?php

if(isset($_POST['submit'])){

$emp = $_POST['empcode'];
$sdat = $_POST['start_date'];
$tda = $_POST['to_date'];
$stat = 'WeeklyOff';
//$emp =  implode('',$_POST['emp']); 

//$emp=$_POST["emp"];
//$search_string = implode(',', $emp);


$thismon = date('m', strtotime($_POST['start_date']));

$thisyyy = date('Y', strtotime($_POST['start_date']));

//echo $thismon;

//echo $thisyyy;


$emp_aboveempntest = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' AND epn_ecode = '$emp' GROUP BY epn_ecode, epn_name");

$abovetestempn = $wpdb->get_results($emp_aboveempntest);

$empcempnexem = array();

foreach($abovetestempn as $abovetestempn):
echo '<br />';
$cnt = $abovetestempn->empcount;
$empcempnexem[] = $abovetestempn->epn_ecode;
$oufcowqweqw = $abovetestempn->epn_ecode;
$dateexem = $abovetestempn->epn_date;

$emnpname =  $abovetestempn->epn_name.'<br />';
//echo '<br />';
//echo $cnt+1;
//echo $emnpname;
$coun = $cnt;
//echo "<input type='hidden' name='tcou' value='$coun' />";

$oufcowqweqw = implode(',', $empcempnexem);




endforeach;


 
$list_q = mysql_query("SELECT *FROM wp_attendance WHERE ECode = '$emp' AND Date = '$sdat'");
//$list_r = $wpdb->get_results($list_q);

echo "<h2>Details</h2>";
//echo  $search_string;
echo "<form method='post' enctype='multipart/form-data'>";
echo "<table>";

/*
SELECT `idno`, `Date`, `SNo`, `ECode`, `Name`, `Shift`, `SInTime`, `SOutTime`, `AInTime`, `AOutTime`, `WorkDur`, `OT`, `TotDur`, `LateBy`, `EarlyGoingBy`, `Status`, `Punch`, `updated_on` FROM `wp_attendance` WHERE 1



*/



while($list_y = mysql_fetch_array($list_q)){

$stat = $list_y['Absent'];

$satd = $list_y['Date'];



$cour = $list_y->ID;


echo "<tr>";
echo "<td>";
echo 'Date :';
echo "<input type='text' name = 'edat' value='".$sdat."'/><br />";

echo 'ECode : <br />';
echo "<input type='text' name = 'ecode' value='".$list_y['ECode']."'/>";
echo 'Name : <br />';

echo "<input type='text' name = 'ename' value='".$list_y['Name']."'/>";
echo 'IN Time : <br />';
echo "<input type='text' name = 'atim' value='".$list_y['AInTime']."'/>";
echo 'Out Time : <br />';

echo "<input type='text' name = 'outi' value='".$list_y['AOutTime']."'/>";

echo 'Status : <br />';

echo "<input type='text' name = 'staq' value='".$list_y['Status']."'/>";
echo 'Duration : <br />';
echo "<input type='text' name = 'dura' value='".$list_y['WorkDur']."'/><br />";
echo "<input type='submit' name='updates' value='UPDATE' />";
echo "</td>";


echo "</tr>";

 


/*echo do_shortcode("[tablemaster sql='SELECT * from wp_attendance where Ecode IN ($search_string) AND DATE BETWEEN '$sdat' AND '$tda' AND Status = '$stat'  GROUP BY Date,ECode,Name LIMIT 1' columns='Date,ECode,Name,AInTime,AOutTime,WorkDur,Status' class='black-header-gray-alternate-rows' ]"); */
}
echo $enam .": <input type='hidden' name='empones' value='".$oufcowqweqw."'  />&nbsp;&nbsp;&nbsp;&nbsp;";
echo $enamcoun .": <input type='hidden' name='counones' value='".$coun."' />&nbsp;&nbsp;&nbsp;&nbsp;";
echo "</table>";
echo "</form>";


}



?>
<?php 

if(isset($_POST['updates'])){

$atim = $_POST['atim'];
$outi = $_POST['outi'];
$staq = $_POST['staq'];
$wodu = $_POST['dura'];

$ecod = $_POST['ecode'];
$ename = $_POST['ename'];
$edat = $_POST['edat'];

$todaytime = '09:35';

$tounc = $_POST['counones'];

$thismon = date('m', strtotime($_POST['edat']));

$thisyyy = date('Y', strtotime($_POST['edat']));

//echo $thismon;

//echo $thisyyy;

$updat = mysql_query("UPDATE wp_attendance SET  `AInTime` = '$atim', `AOutTime` = '$outi', `WorkDur` = '$wodu', `Status` = '$staq' WHERE `ECode` = '$ecod' AND `Name` = '$ename' AND  `Date` = '$edat'  ");

if(($atim) > '09:35'){
$sqlempn = mysql_query("INSERT INTO wp_time_exemption(`epn_ecode`, `epn_date`, `epn_name`, `epn_time`,`epn_coun`,`epn_status`) VALUES ('$ecod','$edat','$ename','$atim','1','yes')");

}

echo "<h2>DATA UPDATED SUCCESSFULLY</h2>";

$list_empn = ("SELECT *FROM wp_time_exemption WHERE epn_date = '$edat' AND epn_ecode = '$ecod' GROUP BY epn_ecode "); 
$list_rempn = $wpdb->get_results($list_empn);
foreach($list_rempn as $list_rempn){


$onesampn = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' AND epn_ecode = '$ecod' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) = 1 ");

$wueuywones = $wpdb->get_results($onesampn);


foreach($wueuywones as $wueuywones){
echo '<br />';
$cnt = $wueuywones->empcount;
$onempes = $wueuywones->epn_ecode;
$onempessr = $wueuywones->epn_ecode;
$dateexem = $wueuywones->epn_date;

$emptesones = ("SELECT * FROM wp_time_exemption WHERE epn_ecode = '$onempes' GROUP BY epn_ecode");
$onestwo = $wpdb->get_results($emptesones);

foreach($onestwo as $onestwo){

$empones = $onestwo->epn_ecode;
$emptimesones = $onestwo->epn_time;


$emp_onesusers = ("SELECT *FROM wp_users WHERE emp_code = '$empones'");
$emp_oneuver = $wpdb->get_results($emp_onesusers);
foreach($emp_oneuver as $emp_oneuver){

$oneemail = $emp_oneuver->user_email;
$onesname = $emp_oneuver->user_nicename;
echo $oneemail;
echo 'Your 1 exemption completed.';

$headers = "From: hr@ideabytes.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$subjectexem1att = "This is your $empcountones exemption for In-Punch timing. ";
$messageexem1mest = "Dear $onesname, <br /><br /> In-Punch time for $edat is $emptimesones and this has crossed 9:30AM. Please note this is 1st exemption.</b><br /><br />Thank you</br /> hr@ideabytes.com";



mail($oneemail, $subjectexem1att, $messageexem1mest, $headers);
}
}
}




//TWO COUNT


//echo $emptw;

$emptestwo = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' AND epn_ecode = '$ecod' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) = 2");
$abovetwo = $wpdb->get_results($emptestwo);

foreach($abovetwo as $abovetwo){

$emptwos = $abovetwo->epn_ecode;
$emptwotimes = $abovetwo->epn_time;

$emp_twosusers = ("SELECT *FROM wp_users WHERE emp_code = '$emptwos'");
$emp_owtsuver = $wpdb->get_results($emp_twosusers);
foreach($emp_owtsuver as $emp_owtsuver){
$twosemail = $emp_owtsuver->user_email;
$twosname = $emp_owtsuver->user_nicename;

echo $twosemail;
echo 'Your 2 exemptions completed.';



$headers = "From: hr@ideabytes.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$subjectexem2a = "This is your 2nd exemption for In-Punch timing.";
$messageexem2a = "Dear $twosname, <br /><br /> In-Punch time for $edat is $emptwotimes and this has crossed 9:30AM. Please note this is 2nd exemption.</b><br /><br />Thank you</br /> hr@ideabytes.com";


mail($twosemail, $subjectexem2a, $messageexem2a, $headers);
}
}


//THREE COUNT



$empthreet = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' AND epn_ecode = '$ecod' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) = 3");
$abovethreet = $wpdb->get_results($empthreet);

foreach($abovethreet as $abovethreet){

$empreeth = $abovethreet->epn_ecode;
$empthreetimes = $abovethreet->epn_time;

$emp_reethusers = ("SELECT *FROM wp_users WHERE emp_code = '$empreeth'");
$emp_reethuver = $wpdb->get_results($emp_reethusers);
foreach($emp_reethuver as $emp_reethuver){
$treethemail = $emp_reethuver->user_email;
$treethname = $emp_reethuver->user_nicename;

echo $treethemail;
echo 'Your 3 exemptions completed.';

$headers = "From: hr@ideabytes.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$subjectexem3t = "This is your 3rd exemption for In-Punch timing.";
$messageexem3t = "Dear $treethname, <br /><br /> In-Punch time for $edat is $empthreetimes and this has crossed 9:30AM. Please note this is 3rd exemption.</strong></b><br /><br />Thank you</br /> hr@ideabytes.com";


mail($treethemail, $subjectexem3t, $messageexem3t, $headers);
}
}



//FOUR COUNT


$emptestfour = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' AND epn_ecode = '$ecod' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) = 4");
$abovefour = $wpdb->get_results($emptestfour);

foreach($abovefour as $abovefour){

$emprufo = $abovefour->epn_ecode;
$empfourtimes = $abovefour->epn_time;

$emp_furousers = ("SELECT *FROM wp_users WHERE emp_code = '$emprufo'");
$emp_fouruver = $wpdb->get_results($emp_furousers);
foreach($emp_fouruver as $emp_fouruver){
$frouemail = $emp_fouruver->user_email;
$frouname = $emp_fouruver->user_nicename;

echo $frouemail;
echo 'Your 4 exemptions completed.';

$headers = "From: hr@ideabytes.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


$subjectexem4tt = "This is your 4th exemption for In-Punch timing.";
$messageexem4tt = "Dear $frouname, <br /><br /> In-Punch time for $edat is $empfourtimes and this has crossed 9:30AM. Please note this is 4th exemption.</b><br /><br />Thank you</br /> hr@ideabytes.com";


mail($frouemail, $subjectexem4tt, $messageexem4tt, $headers);

}
}


$thismonexem = date('F');
$thisyyymexe = date('Y');
$thismonexemonth = date('m');

//ABOVE FOUR


$emptest = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' AND epn_ecode = '$ecod' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) > 4");
$aboveover = $wpdb->get_results($emptest);

foreach($aboveover as $aboveover){

$empcods = $aboveover->epn_ecode;
$empovertimes = $aboveover->epn_time;

$emp_overusers = ("SELECT *FROM wp_users WHERE emp_code = '$empcods'");
$emp_uver = $wpdb->get_results($emp_overusers);
foreach($emp_uver as $emp_uver){
$overemail = $emp_uver->user_email;
$overname = $emp_uver->user_nicename;
echo $overemail;
echo 'Your exemptions completed.';

$ename =  $aboveover->epn_name.'<br />';
echo $ename;
echo 'Your exemptions completed.';

$headers = "From: hr@ideabytes.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


$subjectexemcomplete = "You have crossed 4 exemptions already. Half day leave will be deducted.";
$messageexemcomplete = "Dear $overname, <br /><br /> As allowed 4 exemptions for $thismonexem - $thisyyymexe, are completed and this is $empaovercounts th time. In-Punch time for $edat is  $empovertimes and this has crossed 9:30AM. Hence half day leave will be deducted.<br /><br />Thank you</br /> hr@ideabytes.com";


mail($overemail, $subjectexemcomplete, $messageexemcomplete, $headers);
}
}
}



}


?>

<?php } else {

echo do_shortcode('[wp-members page=login]');

} 
}

?>

</td></tr></table>
</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php get_footer(); ?>
