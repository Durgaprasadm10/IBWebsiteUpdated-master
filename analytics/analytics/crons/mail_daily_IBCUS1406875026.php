<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 03/04/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project Visitortracking                               *  
 * Modified by : Gayathri     Date : 12/05/2014   Version : 1.1.0 *
 * Description : this page will send daily reports mail.          *
 *****************************************************************/
error_reporting(0); 

$logininfo["customer_id"] = "IBCUS1406875026"; 
 
include "../includes/header.inc1_crons.php";



$date_in_subject = date('Y-m-d', strtotime("-1 days"));

$subject = "Analytics - ".SITENAME." | Daily report | ".$date_in_subject;


$url = MAIN_URL.'/crons/reports_daily.php?customer_id='.$logininfo["customer_id"];
 
//echo $url;
//exit;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_NOBODY, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$return = curl_exec($ch);

//echo $return;
//exit;

require_once('../lib/PHPMailer/class.phpmailer.php');


$body             = $return;

//$body             = " hi this is for testing mail with text.";
$mail             = new PHPMailer(); // defaults to using php "mail()"


//http://www.php.net/manual/en/function.preg-replace.php
//$body             = preg_replace("[\]",'',$body);

$mail->SetFrom(SENDER_MAIL_ID);

//$mail->AddReplyTo("gayathridec5@gmail.com");

foreach($aRecipient_mail_ids as $smailid_to_send){	
	$mail->AddAddress($smailid_to_send);
} 
 
if(count($aRecipient_cc_mail_ids) >= 1){
	foreach($aRecipient_cc_mail_ids as $smailid_cc_to_send){	
		$mail->AddCC($smailid_cc_to_send);
	} 
}

$mail->Subject    = $subject;

$mail->AltBody    = "Please check"; // optional, comment out and test

$mail->MsgHTML($body);

if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
	$message = date("d-m-Y H:i:s")."---->".$logininfo["customer_id"]."---->".$date_in_subject."---->".@implode($aRecipient_mail_ids)."---->".@implode($aRecipient_cc_mail_ids)."---->".$mail->ErrorInfo;
	@logging(MAIL_LOG_DAILY,$message);
} else {
	echo "Message sent!";
	$message = date("d-m-Y H:i:s")."---->".$logininfo["customer_id"]."---->".$date_in_subject."---->".@implode($aRecipient_mail_ids)."---->".@implode($aRecipient_cc_mail_ids)."---->Message sent";
	@logging(MAIL_LOG_DAILY,$message);
}
  
?>
