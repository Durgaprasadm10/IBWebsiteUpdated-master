<?php

   $to = "Pradeep.Ganapathy111@ideabytes.com,mahendra15nov@gmail.com,mahendra.akula@ideabytes.com,mahendrall@gmail.com,Pradeep.Ganapathy@ideabytes.com"; //to address
//
//    $subject ="Testing Email";
// 
//    $message = "Testing whether the read receipt script works or not";
//    $message = "<img src=\"http://www.infofam.com/admin/cm/example.php?user_id=".$to." width=\"0\" height=\"0\" >";
//    $headers  = 'MIME-Version: 1.0' . "\r\n";
//    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//    $headers .= 'From: cmanager@cm.ideabytes.com' . "\r\n";

$from = 'cmanager@cm.ideabytes.com';
$replyTo = 'cmanager@cm.ideabytes.com';
$subject = "Testing mail";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "From: $from\r\n";
$headers .= "Reply-To: $replyTo\r\n";
$headers .= "Return-Path: $from\r\n" . "X-Mailer: php\r\n";
$headers .= "Return-Receipt-To: $from\r\n";
$headers .= "X-Confirm-Reading-To: $from\r\n";
$headers .= "Disposition-Notification-To:$from";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "X-Mailer: PHP/".phpversion();

//$to = "Pradeep.Ganapathy111@ideabytes.com";
$message = "Hai this is Testing Mail <br>";
$r = mail($to, $subject, $message, $headers);

if ($r == 1) {
    echo "Mail sent successfully";
} else {
    echo "failed to send mail";
}
?>