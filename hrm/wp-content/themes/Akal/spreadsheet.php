<?php /* Template Name: SPREADSHEET */ ?>
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
<div class="row-fluid" style="height:810px;">
<br />
<table><th>UPLOAD ATTENDANCE</th>
<tr><td>
<link rel="stylesheet" href="<?php echo plugins_url(); ?>/javascripts/uijquery.css">
  <script src="<?php echo plugins_url(); ?>/javascripts/uijquery.js"></script>
  <script src="<?php echo plugins_url(); ?>/javascripts/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#start_date" ).datepicker({
dateFormat : 'yy-mm-dd',
      //defaultDate: "+1w",
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
<form name="import" method="post" enctype="multipart/form-data">
    	<br /><input type="file" name="file" required /><br /><br />
<div width="800px">Select Date : <input type="text" class="custom_date" name="start_date" id="start_date" value="" required/><br />
<input type="submit" name="submit" value="Submit" />
<?php 
$thismon = date('m');
//echo date('F');
//echo $thismon;

//$thismon = '02';
$thisyyy = date('Y');


$emp_aboveempntest = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) = 1 ");

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


echo $enam ." <input type='hidden' name='empones' value='".$oufcowqweqw."'  />&nbsp;&nbsp;&nbsp;&nbsp;";
echo $enamcoun ." <input type='hidden' name='counones' value='".$coun."' />&nbsp;&nbsp;&nbsp;&nbsp;";

endforeach;

$threempntest = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) = 2 ");

$threeempn = $wpdb->get_results($threempntest);

$empreeth = array();

foreach($threeempn as $threeempn):
echo '<br />';
$cnt = $threeempn->empcount;
$empreeth[] = $threeempn->epn_ecode;
$dateexem = $threeempn->epn_date;

$emntwer =  $threeempn->epn_name.'<br />';
//echo '<br />';
//echo $cnt+1;
//echo $emntwer;
$cothr = $cnt;
//echo "<input type='hidden' name='tcou' value='$coun' />";

$uqwuq = implode(',', $empreeth);


echo $enam ." <input type='hidden' name='emptwos' value='".$uqwuq."'  />&nbsp;&nbsp;&nbsp;&nbsp;";
echo $enamcoun ." <input type='hidden' name='countwos' value='".$cothr."' />&nbsp;&nbsp;&nbsp;&nbsp;";

endforeach;

$fourmpn = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) = 3 ");

$foempnou = $wpdb->get_results($fourmpn);

$empreeth = array();

foreach($foempnou as $foempnou):
echo '<br />';
$cnt = $foempnou->empcount;
$empreeth[] = $foempnou->epn_ecode;
$dateexem = $foempnou->epn_date;

$emntwer =  $foempnou->epn_name.'<br />';
//echo '<br />';
//echo $cnt+1;
//echo $emntwer;
$cothr = $cnt;
//echo "<input type='hidden' name='tcou' value='$coun' />";

$thruqwuqee = implode(',', $empreeth);


echo $enam ." <input type='hidden' name='empthree' value='".$thruqwuqee."'  />&nbsp;&nbsp;&nbsp;&nbsp;";
echo $enamcoun ." <input type='hidden' name='counthree' value='".$cothr."' />&nbsp;&nbsp;&nbsp;&nbsp;";

endforeach;


$fourabovempn = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) = 4 ");

$foemabovepnou = $wpdb->get_results($fourabovempn);

$frempou = array();

foreach($foemabovepnou as $foemabovepnou):
echo '<br />';
$cnt = $foemabovepnou->empcount;
$frempou[] = $foemabovepnou->epn_ecode;
$dateexem = $foemabovepnou->epn_date;

$emntwer =  $foemabovepnou->epn_name.'<br />';
//echo '<br />';
//echo $cnt+1;
//echo $emntwer;
$cothr = $cnt;
//echo "<input type='hidden' name='tcou' value='$coun' />";

$fouuqwuqre = implode(',', $frempou);


echo $enam ."<input type='hidden' name='empabovefour' value='".$fouuqwuqre."'  />&nbsp;&nbsp;&nbsp;&nbsp;";
echo $enamcoun ."<input type='hidden' name='counabovefour' value='".$cothr."' />&nbsp;&nbsp;&nbsp;&nbsp;";

endforeach;

$fourgreater = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) > 4 ");

$greatfoemou = $wpdb->get_results($fourgreater);

$grtfrempou = array();

foreach($greatfoemou as $greatfoemou):
echo '<br />';
$grtcnt = $greatfoemou->empcount;
$grtfrempou[] = $greatfoemou->epn_ecode;
$grtdateexem = $greatfoemou->epn_date;

$emntwer =  $greatfoemou->epn_name.'<br />';
//echo '<br />';
//echo $cnt+1;
//echo $emntwer;
$grtcothr = $grtcnt;
//echo "<input type='hidden' name='tcou' value='$coun' />";

$grtfouuqwuqre = implode(',', $grtfrempou);


echo $enam ."<input type='hidden' name='grtempabovefour' value='".$grtfouuqwuqre."'  />&nbsp;&nbsp;&nbsp;&nbsp;";
echo $enamcoun ."<input type='hidden' name='grtcounabovefour' value='".$grtcothr."' />&nbsp;&nbsp;&nbsp;&nbsp;";

endforeach;

?>

</div>
        
</form>

<?php
if(isset($_POST["submit"]))
{
//global $wpdb;

	$file = $_FILES['file']['tmp_name'];
	$handle = fopen($file, "r");


	$c = 0;
	while(($filesop = fgetcsv($handle, 10000, ",")) !== false)
	{
		$added = $filesop[0];
$date = date("Y-m-d", strtotime($added));
$daty = $_POST['start_date'];
		$sno = $filesop[1];
$ecode = $filesop[2];
$name = $filesop[3];
$shift = $filesop[4];
$sit = $filesop[5];
$sot = $filesop[6];
$ait = $filesop[7];
$aot = $filesop[8];
$wd = $filesop[9];
$ot = $filesop[10];
$totd = $filesop[11];
$lby = $filesop[12];
$early = $filesop[13];
$stat = $filesop[14];
$punch = $filesop[15];


$notpunch = 'Absent (No OutPunch)';
$todaytime = '09:35:00 AM';
		
		$sql = mysql_query("INSERT INTO wp_attendance (`Date`, `SNo`, `ECode`, `Name`, `Shift`, `SInTime`, `SOutTime`, `AInTime`, `AOutTime`, `WorkDur`, `OT`, `TotDur`, `LateBy`, `EarlyGoingBy`, `Status`, `Punch`) VALUES ('$daty','$sno','$ecode','$name','$shift','$sit','$sot','$ait','$aot','$wd','$ot','$totd','$lby','$early','$stat','$punch')");
	}
	
		if($sql){
			echo "You database has imported successfully";
//echo $stat.'<br />';
$list_q = ("SELECT *FROM wp_attendance WHERE Date = '$daty' AND Status = '$notpunch'");
$list_r = $wpdb->get_results($list_q);
foreach($list_r as $list_r){

//echo $list_r->Name.'<br />';

//echo $list_r->Status.'<br />';
$empc = $list_r->ECode;


$emp_users = ("SELECT *FROM wp_users WHERE emp_code = '$empc'");
$emp_r = $wpdb->get_results($emp_users);
foreach($emp_r as $emp_r){

//echo $emp_r->user_login.'<br />';

echo $emp_r->user_email.'<br />';

$headers = "From: hr@ideabytes.com" . "\r\n"; //."CC: hr@ideabytes.com"
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$email = $emp_r->user_email;
$name = $emp_r->user_nicename;
$subject = "Bio Metric In or Out punch is missed for $daty ";
$message = "Dear $name, <br /><br /> Your Bio Metric In or Out punch for date : $daty is missing. Please get the approval from your manager to update your attendance. <b><strong>Otherwise it will be considered as a leave.</strong></b><br /><br />Thank you</br /> hr@ideabytes.com";


mail($email, $subject, $message, $headers);
//mail($email, $subject, $messageuser, $headers);
}
$daty = $list_r->Date;
		$sno = $list_r->SNo;
$ecode = $list_r->ECode;
$name = $list_r->Name;
$shift = $list_r->Shift;
$sit = $list_r->SInTime;
$sot = $list_r->SOutTime;
$ait = $list_r->AInTime;
$aot = $list_r->AOutTime;
$wd = $list_r->WorkDur;
$ot = $list_r->OT;
$totd = $list_r->TotDur;
$lby = $list_r->LateBy;
$early = $list_r->EarlyGoingBy;
$stat = $list_r->Status;
$punch = $list_r->Punch;


$sqlnotpunce = mysql_query("INSERT INTO wp_attendance_notpunch (`Date`, `SNo`, `ECode`, `Name`, `Shift`, `SInTime`, `SOutTime`, `AInTime`, `AOutTime`, `WorkDur`, `OT`, `TotDur`, `LateBy`, `EarlyGoingBy`, `Status`, `Punch`) VALUES ('$daty', '$sno', '$ecode', '$name', '$shift', '$sit', '$sot', '$ait', '$aot', '$wd', '$ot','$totd','$lby','$early','$stat','$punch')");

}

$list_empn = ("SELECT *FROM wp_attendance WHERE Date = '$daty' AND AInTime > '$todaytime' AND Status = 'Present' ");
$list_rempn = $wpdb->get_results($list_empn);
foreach($list_rempn as $list_rempn){

$ecode = $list_rempn->ECode;
$name = $list_rempn->Name;
$ait = $list_rempn->AInTime;
$sqlempn = mysql_query("INSERT INTO wp_time_exemption(`epn_ecode`, `epn_date`, `epn_name`, `epn_time`,`epn_coun`, `epn_status`) VALUES ('$ecode','$daty','$name','$ait','1','yes')");

//echo $list_rempn->Name.'<br />';

//echo $list_rempn->Status.'<br />';
$empcempn = $list_rempn->ECode;



}
//$thismon = '02';
//$thisyyy = '2016';

$thismon = date('m');
$thisyyy = date('Y');

$emp_aboveempntest = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, COUNT(*) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' GROUP BY epn_ecode, epn_name");

//$num_rows = mysql_num_rows($emp_aboveempntest);

//echo "$num_rows Rows\n";


$abovetestempn = $wpdb->get_results($emp_aboveempntest);

foreach($abovetestempn as $abovetestempn):
echo '<br />';
$cnt = $abovetestempn->empcount;
$empcempnexem = $abovetestempn->epn_ecode;
$dateexem = $abovetestempn->epn_date;

$emnpname =  $abovetestempn->epn_name.'<br />';
//echo '<br />';
//echo $cnt;
//echo $emnpname;


endforeach;


//echo $daty;

$onesampn = ("SELECT MONTH(epn_date) as thismonth, YEAR(epn_date) as thisyear, SUM(epn_coun) as empcount, epn_ecode, epn_name, epn_date, epn_updated FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismon' AND YEAR(epn_date) = '$thisyyy' GROUP BY epn_ecode, epn_name HAVING SUM(epn_coun) = 1 ");

$wueuywones = $wpdb->get_results($onesampn);

$onempes = array();

foreach($wueuywones as $wueuywones):
echo '<br />';
$cnt = $wueuywones->empcount;
$onempes[] = $wueuywones->epn_ecode;
$onempesso = $wueuywones->epn_ecode;
$dateexem = $wueuywones->epn_date;

$emntwer =  $wueuywones->epn_name.'<br />';
//echo '<br />';
//echo $cnt+1;
//echo $emntwer;
$cothr = $cnt;
//echo "<input type='hidden' name='tcou' value='$coun' />";

$onesawewe = implode(',', $onempes);

$emptesones = ("SELECT * FROM wp_time_exemption WHERE epn_date = '$daty' AND epn_ecode = '$onempesso' GROUP BY epn_ecode");
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

$subjectexem1att = "This is your 1st exemption for In-Punch timing. ";
$messageexem1mest = "Dear $onesname, <br /><br /> In-Punch time for $daty is $emptimesones and this has crossed 9:30AM. Please note this is 1st exemption.</b><br /><br />Thank you</br /> hr@ideabytes.com";



mail($oneemail, $subjectexem1att, $messageexem1mest, $headers);
}
}
endforeach;


$emptw=$_POST["empones"];



//TWO COUNT
//$emptw=$_POST["empones"];
//$twco = implode(',', $emptw);

//$twcoun=$_POST["counones"];
//$owtcoun = implode(',', $twcoun);



//echo $emptw;

$emptestwo = ("SELECT * FROM wp_time_exemption WHERE epn_date = '$daty' AND epn_ecode IN ($emptw) GROUP BY epn_ecode");
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
$messageexem2a = "Dear $twosname, <br /><br /> In-Punch time for $daty is $emptwotimes and this has crossed 9:30AM. Please note this is 2nd exemption.</b><br /><br />Thank you</br /> hr@ideabytes.com";


mail($twosemail, $subjectexem2a, $messageexem2a, $headers);
}
}



//THREE COUNT

$threemp=$_POST["emptwos"];
//$empt = implode(',', $threemp);

$counthr=$_POST["countwos"];
//$reethco = implode(',', $counthr);


$empthreet = ("SELECT * FROM wp_time_exemption WHERE epn_date = '$daty' AND epn_ecode IN ($threemp) GROUP BY epn_ecode");
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
$messageexem3t = "Dear $treethname, <br /><br /> In-Punch time for $daty is $empthreetimes and this has crossed 9:30AM. Please note this is 3rd exemption.</strong></b><br /><br />Thank you</br /> hr@ideabytes.com";


mail($treethemail, $subjectexem3t, $messageexem3t, $headers);

}
}


//FOUR COUNT

$empruof=$_POST["empthree"];
//$oufco = implode(',', $empruof);

$fcour=$_POST["counthree"];
//$favo = implode(',', $fcour);



$emptestfour = ("SELECT * FROM wp_time_exemption WHERE epn_date = '$daty' AND epn_ecode IN ($empruof) GROUP BY epn_ecode");
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
$messageexem4tt = "Dear $frouname, <br /><br /> In-Punch time for $daty is $empfourtimes and this has crossed 9:30AM. Please note this is 4th exemption.</b><br /><br />Thank you</br /> hr@ideabytes.com";


mail($frouemail, $subjectexem4tt, $messageexem4tt, $headers);

}
}

//ABOVE FOUR

$grtemptw=$_POST["grtempabovefour"];
//$abovmpe = implode(',', $abovemptw);

$counabovefour=$_POST["grtcounabovefour"];
//$overexmp = implode(',', $counabovefour);

$thismonexem = date('F');
$thisyyymexe = date('Y');
$thismonexemonth = date('m');
//$thismonexemonth = date('02');

$grtemptest = ("SELECT * FROM wp_time_exemption WHERE epn_date = '$daty' AND epn_ecode IN ($grtemptw) GROUP BY epn_ecode");
$grtaboveover = $wpdb->get_results($grtemptest);

foreach($grtaboveover as $grtaboveover){

$grtempcods = $grtaboveover->epn_ecode;
$grtempovertimes = $grtaboveover->epn_time;

$empcountover = ("SELECT epn_date, epn_ecode, epn_time, SUM(epn_coun) as empcount FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismonexemonth' AND YEAR(epn_date) = '$thisyyymexe' AND epn_ecode = '$grtempcods' GROUP BY epn_ecode");
$aboveovercount = $wpdb->get_results($empcountover);

foreach($aboveovercount as $aboveovercount){

$empaovercounts = $aboveovercount->empcount;
$empaovercods = $aboveovercount->epn_ecode;


$grtremp_overusers = ("SELECT *FROM wp_users WHERE emp_code = '$grtempcods'");
$grtremp_uver = $wpdb->get_results($grtremp_overusers);
foreach($grtremp_uver as $grtremp_uver){
$grtroveremail = $grtremp_uver->user_email;
$grtrovername = $grtremp_uver->user_nicename;
echo $overemail;
echo 'Your exemptions completed.';

$grtrename =  $grtraboveover->epn_name.'<br />';
echo $grtrename;
echo 'Your exemptions completed.';

$headers = "From: hr@ideabytes.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


$grtrsubjectexemcomplete = "You have crossed 4 exemptions already. Half day leave will be deducted.";
$grtrmessageexemcomplete = "Dear $grtrovername, <br /><br /> As allowed 4 exemptions for $thismonexem - $thisyyymexe, are completed and this is $empaovercounts th time. In-Punch time for $daty is  $grtempovertimes and this has crossed 9:30AM. Hence half day leave will be deducted.<br /><br />Thank you</br /> hr@ideabytes.com";


mail($grtroveremail, $grtrsubjectexemcomplete, $grtrmessageexemcomplete, $headers);
}
}
}

//ABOVE FOUR

$abovemptw=$_POST["empabovefour"];
//$abovmpe = implode(',', $abovemptw);

$counabovefour=$_POST["counabovefour"];
//$overexmp = implode(',', $counabovefour);

$thismonexem = date('F');
$thisyyymexe = date('Y');
$thismonexemonth = date('m');
//$thismonexemonth = date('02');

$emptest = ("SELECT * FROM wp_time_exemption WHERE epn_date = '$daty' AND epn_ecode IN ($abovemptw) GROUP BY epn_ecode");
$aboveover = $wpdb->get_results($emptest);

foreach($aboveover as $aboveover){

$empcods = $aboveover->epn_ecode;
$empovertimes = $aboveover->epn_time;

$empcounttwot = ("SELECT epn_date, epn_ecode, epn_time, SUM(epn_coun) as empcount FROM wp_time_exemption WHERE MONTH(epn_date) = '$thismonexemonth' AND YEAR(epn_date) = '$thisyyymexe' AND epn_ecode = '$empcods' GROUP BY epn_ecode");
$abovecounttowt = $wpdb->get_results($empcounttwot);

foreach($abovecounttowt as $abovecounttowt){

$empthreecounts = $abovecounttowt->empcount;
$aovercods = $abovecounttowt->epn_ecode;

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
$messageexemcomplete = "Dear $overname, <br /><br /> As allowed 4 exemptions for $thismonexem - $thisyyymexe, are completed and this is $empthreecounts th time. In-Punch time for $daty is  $empovertimes and this has crossed 9:30AM. Hence half day leave will be deducted.<br /><br />Thank you</br /> hr@ideabytes.com";


mail($overemail, $subjectexemcomplete, $messageexemcomplete, $headers);
}
}
}





		}else{
			echo "Sorry! There is some problem.";
		}


}


?>
</td></tr></table>
</div></div>
<?php get_footer(); ?>
