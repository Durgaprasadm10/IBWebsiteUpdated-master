<?php 

//$conn = mysql_connect('localhost', 'ibadmin_Employee', 'Tracking@$()');
//mysql_select_db('ibadmin_employee_tracking', $conn);

$conn = mysql_connect('ideabytesdb.c6hujshgwzfd.us-east-1.rds.amazonaws.com', 'ideabytes_wp', '&(wp_ideabytes)&');
mysql_select_db('ideabytes_hrm', $conn);

//http://autotestscript.com/ETR/activate.php?ecode=1072&&from='2016-05-28'&&to='2016-05-28'


$use = $_GET['ecode'];
$fro = $_GET['from'];
$to = $_GET['to'];
$toadd = $_GET['to'];

$updat = mysql_query("UPDATE wp_leave_compoff SET status = 'Approved' WHERE `ecode` = '$use' AND `from`= '$fro' AND `to` = '$to' AND `status` = 'pending'");

echo 'APPROVED';

/*$sele = mysql_query("SELECT *FROM wp_users");

while($rows = mysql_fetch_array($sele)){

echo $rows['user_login'];

}*/

$seleusers = mysql_query("SELECT *FROM wp_users WHERE emp_code = '$use'");

while($usersele = mysql_fetch_array($seleusers)){


$to = $usersele['user_email'];

//echo $to;
//exit;
$subject = 'Leave approved';
$message = 'Your request for leave has approved From : '.$fro. ' To :  '.$toadd;

$headers = "From: hr@ideabytes.com" . "\r\n" .
"CC: hr@ideabytes.com";

//mail($to, $subject, $message, $headers);

}

echo '<script type="text/javascript">'; 
echo 'alert("Successfully Approved.");'; 
echo 'window.location.href = "http://hrm.ideabyte.net/compoff-status/"';
echo '</script>';

?>
