<?php 

//$conn = mysql_connect('localhost', 'ibadmin_Employee', 'Tracking@$()');
//mysql_select_db('ibadmin_employee_tracking', $conn);

$conn = mysql_connect('ideabytesdb.c6hujshgwzfd.us-east-1.rds.amazonaws.com', 'ideabytes_wp', '&(wp_ideabytes)&');
mysql_select_db('ideabytes_hrm', $conn);


//http://ideabytes.com/hrm/reject.php?ecode=1072&&from='2016-05-28'&&to='2016-05-28'

if(isset($_GET['reject'])){
$use = $_GET['ecode'];
$fro = $_GET['from'];
$to = $_GET['to'];
$toadd = $_GET['to'];
$reason = $_GET['reason'];

/*echo $use;
echo $fro;
echo $to;
echo $reason;
exit();*/
$updat = mysql_query("UPDATE wp_leave SET status = '$reason Rejected' WHERE `ecode` = '$use' AND `from`= '$fro' AND `to` = '$to'  AND `status` = 'pending' ");

echo 'REJECTED';


/*$sele = mysql_query("SELECT *FROM wp_users");

while($rows = mysql_fetch_array($sele)){

echo $rows['user_login'];

}*/

$seleusers = mysql_query("SELECT *FROM wp_users WHERE emp_code = '$use'");

while($usersele = mysql_fetch_array($seleusers)){


$to = $usersele['user_email'];

$headers = "From: hr@ideabytes.com" . "\r\n" .
"CC: hr@ideabytes.com";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

//echo $to;
//exit;
$subject = 'Leave Rejected';
$message = $reason.'<br />';
$message .= 'Your request for leave has rejected From :  '.$fro. ' To :  '.$toadd;




mail($to, $subject, $message, $headers);

}

echo '<script type="text/javascript">'; 
echo 'alert("Rejected.");'; 
echo 'window.location.href = "http://hrm.ideabyte.net/manager-leave-reports/"';
echo '</script>';
}
?>
