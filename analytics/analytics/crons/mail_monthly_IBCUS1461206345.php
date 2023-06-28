<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 03/04/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project Visitortracking                               *  
 * Modified by : Gayathri     Date : 12/05/2014   Version : 1.1.0 *
 * Description : this page will send monthly reports mail.          *
 *****************************************************************/
error_reporting(E_ALL);   
$logininfo["customer_id"] = "IBCUS1461206345"; 

include "../includes/header.inc1_crons.php";

$date_in_subject = date('F Y', strtotime('first day of last month'));

$subject = "Analytics - ".SITENAME." | Monthly report | ".$date_in_subject;

  
$url= MAIN_URL.'/crons/reports_monthly.php?customer_id='.$logininfo["customer_id"];    

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_NOBODY, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$return = curl_exec($ch);

require_once('../lib/PHPMailer/class.phpmailer.php');

$mail             = new PHPMailer(); // defaults to using php "mail()"

$body             = $return;


//http://www.php.net/manual/en/function.preg-replace.php
//$body             = preg_replace("[\]",'',$body);

$mail->SetFrom(SENDER_MAIL_ID);

//$mail->AddReplyTo(REPLY_MAIL_ID); 

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

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
	$message = date("d-m-Y H:i:s")."---->".$logininfo["customer_id"]."---->".$date_in_subject."---->".@implode($aRecipient_mail_ids)."---->".@implode($aRecipient_cc_mail_ids)."---->".$mail->ErrorInfo;
	logging(MAIL_LOG_MONTHLY,$message);
} else {
	echo "Message sent!";
	$message = date("d-m-Y H:i:s")."---->".$logininfo["customer_id"]."---->".$date_in_subject."---->".@implode(",",$aRecipient_mail_ids)."---->".@implode(",",$aRecipient_cc_mail_ids)."---->Message sent";
	logging(MAIL_LOG_MONTHLY,$message);
}

?>
