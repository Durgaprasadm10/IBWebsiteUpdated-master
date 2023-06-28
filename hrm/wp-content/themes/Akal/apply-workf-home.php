<?php /* Template Name: APPLY WORKF HOME */ ?>
<?php
   global $wpdb;
get_header();
ob_start();
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

<div class="container">
<div class="row-fluid">
<?php //echo get_calendar(); ?>
<?php if ( is_user_logged_in() ) { 

$roll = get_user_role();

if(($roll) == 'subscriber' || $roll == 'author' || $roll == 'editor' || $roll == ''){

?>
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




<form id="form_id" method="post" enctype="multipart/form-data">
<div width="800px">
<h3>Apply For Work From Home</h3>
Worked From Date : <input type="text" class="custom_date" name="start_date" id="start_date" value="" required/>

To Date :<input type="text" class="custom_date" name="to_date" id="to_date" value="" required/></div>
<!--<h2>Employees :</h2> -->
<?php 
  $user_id = $idu;
  $key = 'mgrid';
  $single = true;
  $user_last = get_user_meta( $user_id, $key, $single ); 
  //echo '<p>The '. $key . ' value for user id ' . $user_id . ' is: ' . $user_last . '</p>'; 

$sqel = mysql_query("SELECT *FROM wp_users WHERE emp_code = '$user_last'");

//$countla = mysql_num_rows($sqel);

//echo $countla;

while($eekola = mysql_fetch_array($sqel)){

$stela = $eekola['user_email'];
echo 'Manager Email ID : '.$stela .'<br />';

}

$sqelemp = mysql_query("SELECT *FROM wp_profile WHERE ecode = '$rid'");

//$countla = mysql_num_rows($sqelemp);

//echo $countla;

while($eekolaemp = mysql_fetch_array($sqelemp)){

$stelaemp = $eekolaemp['firstname'];
//echo 'Employee name : '.$stelaemp .'<br />';

}


?>
<br /><br />

<!--<h2>LEAVE TYPE</h2>-->

<!--CL : <input type="radio" name="type" value="CL" checked />
SL : <input type="radio" name="type" value="SL" />
EL : <input type="radio" name="type" value="EL" />
Comp-Off : <input type="radio" name="type" value="Comp-Off" checked /><br /><br />-->

<h2>Day</h2>
<select name="day">
<option value="Full Day" selected>Full Day</option>
<option value="Half Day">Half Day</option>
</select><br /><br />
<h2>Work from home details *:</h2> 
<textarea name="reason" required></textarea>
<input type="submit" name="submit" value="Apply" />
</form>


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


$checkdate = ("SELECT *FROM wp_workf_home  WHERE ecode = '$rid'"); // AND from = '$sdat'
$checklist = $wpdb->get_results($checkdate);

foreach($checklist as $checklist){

$ecode = $checklist->ecode;
$from = $checklist->from;
$to = $checklist->to;
}

if(($ecode) == $rid && $from == $sdat ||  $to == $sdat || $to == $tda ){

echo 'You already submitted leave request for the given dates.';

} else { //echo 'Your leave request submitted successfully.';

$emp=$_POST["emp"];
//$search_string = implode(',', $emp);

$wpdb->insert('wp_workf_home', array(
    'ecode' => $rid,
'name' => $stelaemp,
    'mgrid' => $user_last,
    'from' => $sdat, 
'to' => $tda, 
'noofdays' => $between,
'day' => $day,

'workfhome_details' => $reason, 
'status' => 'pending', 
));


$seleusers = mysql_query("SELECT *FROM wp_users WHERE emp_code = '$user_last'");

while($usersele = mysql_fetch_array($seleusers)){

$mgri = $usersele['user_email'];

}


$headers = "From: $usermail" . "\r\n" .
"CC: hr@ideabytes.com";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$to = $mgri;
$tousers = $usermail;
$onedesk = 'onedesk@ideabytes.com';
$ibhr = 'hr@ideabytes.com';
//echo $to;
//exit;
$approve = 'http://ideabytes.com/hrm/workfhome-activate.php?ecode='.$rid.'&&from='.$sdat.'&&to='.$tda;
$reject = 'http://ideabytes.com/hrm/workfhome-reject.php?ecode='.$rid.'&&from='.$sdat.'&&to='.$tda;
$updat = "http://ideabytes.com/hrm/";
$subject = 'work from home Request';
$message = 'work from home request from :'. $ename .' <br /> <table><tr><td>No of days </td><td>:</td><td>' .$between. '</td></tr><tr><td>From </td><td>:</td><td>' .$sdat. '</td></tr><tr><td> To </td><td>:</td><td>' .$tda. '</td></tr><tr><td>Type </td><td>:</td><td> '. $typ.'</td></tr><tr><td>Day </td><td>:</td><td> '. $day.'</td></tr><tr><td>Reason </td><td>:</td><td> '. $reason.'</td></tr></table>';
$message .= "To update work from home status please <br /><a href ='$updat'>Login Here</a><br />";
//$message .= "<br /><a href ='$approve'>Approve work from home</a><br />";
//$message .= "<a href ='$reject'>Reject work from home</a>";

$messageuser = 'work from home request from : '. $ename .' <br /> <table><tr><td>No of days </td><td>:</td><td>' .$between. '</td></tr><tr><td>From </td><td>:</td><td>' .$sdat. '</td></tr><tr><td> To </td><td>:</td><td>' .$tda. '</td></tr><tr><td>Type </td><td>:</td><td> '. $typ.'</td></tr><tr><td>Day </td><td>:</td><td> '. $day.'</td></tr><tr><td>Reason </td><td>:</td><td> '. $reason.'</td></tr></table>';
$messageuser .= 'Your work from home request successfully sent to your manager. Please wait for approval.';




//mail($stela, $subject, $message, $headers);
//mail('sonarumi99@gmail.com', $subject, $message, $headers);
//mail($usermail, $subject, $messageuser, $headers);

//mail($ibhr, $subject, $message, $headers);

echo '<h2>Your work from home request successfully sent to your manager. Please wait for approval.</h2>';
//echo $mgri;
//echo $usermail;
}

}
?>


<?php } else {

echo do_shortcode('[wp-members page=login]');

}  

//echo do_shortcode("[tablemaster sql='SELECT * from wp_leave WHERE ecode = $rid' columns='ecode,from,to,type,status' class='black-header-gray-alternate-rows' ]");
} ?>


</div></div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php get_footer(); ?>
