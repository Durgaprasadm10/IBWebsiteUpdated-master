<link rel="stylesheet" href="<?php echo plugins_url(); ?>/javascripts/uijquery.css">
  <script src="<?php echo plugins_url(); ?>/javascripts/uijquery.js"></script>
  <script src="<?php echo plugins_url(); ?>/javascripts/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#start_date" ).datepicker({
dateFormat : 'yy-mm-dd',
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
//minDate : 0,
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


<?php
function apply_leave( $atts ) {
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
$assignmgr = $current_user->assign_mgr;
//echo $username;
?>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'subscriber' || $roll == 'author' || $roll == 'editor' || $roll == ''){

?>



<table style="background-color: #ffffff !important;border: none;width: 50%;margin: auto;">
<tr><td style="background-color: #ffffff !important;border: none;">

<form id="form_id" method="post" enctype="multipart/form-data">

<table><tr><td style='background-color: #242a30;color:#FFFFFF;' colSpan="5">
<strong>APPLY LEAVE</strong></td></tr><tr><td colSpan="5">
<?php 
  $user_id = $idu;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
  //echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 

$sqel = mysql_query("SELECT *FROM wp_users WHERE emp_code = '$assignmgr'");

//$countla = mysql_num_rows($sqel);

//echo $countla;

while($eekola = mysql_fetch_array($sqel)){

$stela = $eekola['user_email'];
echo 'Manager Email ID : '.$stela .'<br />';

}

$sqelemp = mysql_query("SELECT *FROM wp_attendance WHERE Ecode = '$rid'");

//$countla = mysql_num_rows($sqelemp);

//echo $countla;

while($eekolaemp = mysql_fetch_array($sqelemp)){

$stelaemp = $eekolaemp['Name'];
//echo 'Employee name : '.$stelaemp .'<br />';

}


?>
</td></tr><tr><td>
From Date : <br /><input type="text" class="custom_date" name="start_date" id="start_date" value="" required/>
</td><td>
To Date :<br /><input type="text" class="custom_date" name="to_date" id="to_date" value="" required/>
<!--<h2>Employees :</h2> --></td></tr><tr><td width="151px">

Leave Type* :<br />
CL : <input type="radio" name="type" value="CL" checked /><br />
SL : <input type="radio" name="type" value="SL" /><br />
EL : <input type="radio" name="type" value="EL" /><br />
Comp-Off : <input type="radio" name="type" value="Comp-Off" /><br />
Optional-leave : <input type="radio" name="type" value="Optional-leave" /><br />
</td><td>
Day* :<br />
<select name="day">
<option value="Full Day" selected>Full Day</option>
<option value="Half Day">Half Day</option>
</select><br />
</td></tr><tr><td colspan="5">
Reason *:<br />
<textarea name="reason" style="width: 100%;" required></textarea></td></tr>
<tr><td colspan="5" align="right">
<div style="float:right;"><input type="submit" name="submit" value="Apply" /></div>
</form>
</td></tr></table>


<br />

<?php

if(isset($_POST['submit'])){

//$emp = $_POST['emp'];
$sdat = $_POST['start_date'];
$tda = $_POST['to_date'];
$typ = $_POST['type'];
$stat = 'pending';
$reason = $_POST['reason'];
$day = $_POST['day'];
//$emp =  implode('',$_POST['emp']); 

$start = strtotime($_POST['start_date']);
$end = strtotime($_POST['to_date']);

$days_between = ceil(abs($end - $start) / 86400);

$between = $days_between + '1 ';


//$checkdate = ("SELECT *FROM wp_leave"); WHERE ecode = '$rid' AND from = '$sdat'
//$checkdate = ("SELECT * FROM wp_leave WHERE '$sdat' BETWEEN `from` and `to` AND ecode = '$rid'");
/*$checkdate = ("SELECT * FROM wp_leave WHERE ('$sdat' BETWEEN `from` and `to`) OR (`from` BETWEEN '$sdat' AND  '$tda') OR (`to` BETWEEN '$sdat' AND  '$tda') AND ecode = '$rid'");*/
$checkdate = ("SELECT * FROM `wp_leave` WHERE `ecode` = '$rid' AND ('$sdat' BETWEEN `from` AND `to`) AND ('$tda' BETWEEN `from` AND `to`)");
$checklist = $wpdb->get_results($checkdate);

foreach($checklist as $checklist) {

$ecode = $checklist->ecode;
$from = $checklist->from;

}

/*if(($ecode) == '$rid' && $from == '$sdat' ){

echo 'You already submitted leave request for the given dates.';

} else { echo 'Your leave request submitted successfully.'; }*/

if (empty($ecode)) {
    //echo "No description available";
$emp=$_POST["emp"];
//$search_string = implode(',', $emp);

$wpdb->insert('wp_leave', array(
    'ecode' => $rid,
'ename' => $stelaemp,
    'mgrid' => $user_last,
    'from' => $sdat, 
'to' => $tda, 
'noofdays' => $between,
'type' => $typ,
'day' => $day,

'reason' => $reason, 
'status' => 'pending', 
));


$seleusers = mysql_query("SELECT *FROM wp_users WHERE emp_code = '$user_last'");

while($usersele = mysql_fetch_array($seleusers)){

$mgri = $usersele['user_email'];

}


$headers = "From: $usermail" . "\r\n"; //."CC: hr@ideabytes.com"
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$to = $mgri;
$tousers = $usermail;
$onedesk = 'onedesk@ideabytes.com';
$ibhr = 'hr@ideabytes.com';
//echo $to;
//exit;
$approve = 'http://ideabytes.com/hrm/activate.php?ecode='.$rid.'&&from='.$sdat.'&&to='.$tda;
$reject = 'http://ideabytes.com/hrm/reject.php?ecode='.$rid.'&&from='.$sdat.'&&to='.$tda;
$updat = "http://hrm.ideabyte.net/";
$subject = 'Leave Request';
$message = 'Leave request from :'. $ename .' <br /> <table><tr><td>No of days </td><td>:</td><td>' .$between. '</td></tr><tr><td>From </td><td>:</td><td>' .$sdat. '</td></tr><tr><td> To </td><td>:</td><td>' .$tda. '</td></tr><tr><td>Type </td><td>:</td><td> '. $typ.'</td></tr><tr><td>Day </td><td>:</td><td> '. $day.'</td></tr><tr><td>Reason </td><td>:</td><td> '. $reason.'</td></tr></table>';
$message .= "To update leave status please <br /><a href ='$updat'>Login Here</a><br />";
//$message .= "<br /><a href ='$approve'>Approve Leave</a><br />";
//$message .= "<a href ='$reject'>Reject Leave </a>";

$messageuser = 'Leave request from : '. $ename .' <br /> <table><tr><td>No of days </td><td>:</td><td>' .$between. '</td></tr><tr><td>From </td><td>:</td><td>' .$sdat. '</td></tr><tr><td> To </td><td>:</td><td>' .$tda. '</td></tr><tr><td>Type </td><td>:</td><td> '. $typ.'</td></tr><tr><td>Day </td><td>:</td><td> '. $day.'</td></tr><tr><td>Reason </td><td>:</td><td> '. $reason.'</td></tr></table>';
$messageuser .= 'Your leave request successfully sent to your manager. Please wait for leave approval.';

$cgrg = 'george.kongalath@ideabytes.com';
$cgrg .= 'srinivas.katta@ideabytes.com';


mail($stela, $subject, $message, $headers);
//mail('sonarumi99@gmail.com', $subject, $message, $headers);
mail($usermail, $subject, $messageuser, $headers);
//mail($cgrg, $subject, $messageuser, $headers);
//mail($ibhr, $subject, $message, $headers);

echo '<h2>Your leave request successfully sent to your manager. Please wait for leave approval.</h2>';
//echo $mgri;
//echo $usermail;
} else {
    echo $ecode;
echo 'You already submitted leave request for the given dates.';
}


}



?>


<?php } else {

echo do_shortcode('[wp-members page=login]');

}

//echo do_shortcode("[tablemaster sql='SELECT * from wp_leave WHERE ecode = $rid' columns='ecode,from,to,type,status' class='black-header-gray-alternate-rows' ]");
} ?>
</td></tr></table>
<?php 
}
add_shortcode( 'applyleaves', 'apply_leave' );

?>
