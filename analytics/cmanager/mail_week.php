<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 06/09/2014                                  *
 * Created By : Mahendra                                          *
 * Vision : Project Campaign manager                               *  
 * Modified by : Mahendra   Version : 2.0 *
 * Description : This page will create the mail reports by Weekly      *
 * *************************************************************** */

include "includes/headerCM.inc.php";

$date_in_subject = date('Y-m-d', strtotime("-1 days"));

$subject = "" . APPNAME . " | Weekly report(Mail Statistics by Campaign) | " . $date_in_subject;
// Mai Report for Mail Statistics

$url = TRACKING_URL . '/report_by_mail_statistics_week.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_NOBODY, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$return = curl_exec($ch);

require_once('lib/PHPMailer/class.phpmailer.php');


$body = $return;

$mail = new PHPMailer(); // defaults to using php "mail()"
//http://www.php.net/manual/en/function.preg-replace.php
//$body             = preg_replace("[\]",'',$body);

$mail->SetFrom(SENDER_EMAIL);
$mail->AddReplyTo(REPLY_EMAIL);

@$aMails = explode(',', @$cdefault_mail_ids);
if (sizeof($aMails) > 0) {
    foreach ($aMails as $smailid_to_send) {
        //echo $smailid_to_send.'<br>';
        $aMail = explode('#', $smailid_to_send);
        //if ($aMail[1] == 'mahendra.akula@ideabytes.com')
        $mail->AddAddress($aMail[1]);
    }
}
//if (count($aRecipient_cc_mail_ids) >= 1) {
//foreach ($aRecipient_cc_mail_ids as $smailid_cc_to_send) {
// $mail->AddCC($smailid_cc_to_send);
// }
//}
//$mail->AddAddress('mahendra.akula@ideabytes.com');
$mail->Subject = $subject;

$mail->AltBody = "Please check"; // optional, comment out and test

$mail->MsgHTML($body);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if (!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    // echo "Maail sent!";
}

// Reports for visiter statistics

$subject = "" . APPNAME . " | Weekly report(Visiter Statistics by Campaign) | " . $date_in_subject;
$url = TRACKING_URL . '/report_visiterstatistics_by_campaign_week.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_NOBODY, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$return = curl_exec($ch);

$body = $return;

$mail = new PHPMailer(); // defaults to using php "mail()"
//http://www.php.net/manual/en/function.preg-replace.php
//$body             = preg_replace("[\]",'',$body);

$mail->SetFrom(SENDER_EMAIL);

$mail->AddReplyTo(REPLY_EMAIL);

@$aMails = explode(',', @$cdefault_mail_ids);
if (sizeof($aMails) > 0) {
    foreach ($aMails as $smailid_to_send) {
        //echo $smailid_to_send.'<br>';
        $aMail = explode('#', $smailid_to_send);
       // if ($aMail[1] == 'mahendra.akula@ideabytes.com')
        $mail->AddAddress($aMail[1]);
    }
}

//$mail->AddAddress('mahendra.akula@ideabytes.com');

$mail->Subject = $subject;

$mail->AltBody = "Please check"; // optional, comment out and test

$mail->MsgHTML($body);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if (!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    // echo "Maail sent!";
}

//Report for Ip
$subject = "" . APPNAME . " | Weekly report(Visiter Statistics by Ip Address) | " . $date_in_subject;
$url = TRACKING_URL . '/report_visiter_by_Ip_week.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_NOBODY, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$return = curl_exec($ch);

$body = $return;
$mail = new PHPMailer(); // defaults to using php "mail()"
//http://www.php.net/manual/en/function.preg-replace.php
//$body             = preg_replace("[\]",'',$body);

$mail->SetFrom(SENDER_EMAIL);

$mail->AddReplyTo(REPLY_EMAILL);

@$aMails = explode(',', @$cdefault_mail_ids);
if (sizeof($aMails) > 0) {
    foreach ($aMails as $smailid_to_send) {
        //echo $smailid_to_send.'<br>';
        $aMail = explode('#', $smailid_to_send);
      //  if ($aMail[1] == 'mahendra.akula@ideabytes.com')
        $mail->AddAddress($aMail[1]);
    }
}
//$mail->AddAddress('mahendra.akula@ideabytes.com');

$mail->Subject = $subject;

$mail->AltBody = "Please check"; // optional, comment out and test

$mail->MsgHTML($body);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if (!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    // echo "Daily Mail sent!";
}
?>