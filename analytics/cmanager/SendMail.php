<?php
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/
 
require ('phpmailer.php');
 
try {
        $mail = new PHPMailer(true); //New instance, with exceptions enabled
 
        $body             = "Please return read receipt to me.";
        $body             = preg_replace('/\\\\/','', $body); //Strip backslashes
 
        $mail->IsSMTP();                           // tell the class to use SMTP
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->Port       = 25;                    // set the SMTP server port
        $mail->Host       = "smtp.office365.com"; // SMTP server
        $mail->Username   = "mahendra.akula@ideabytes.com";     // SMTP server username
        $mail->Password   = "Akula@123";            // SMTP server password
 
        $mail->IsSendmail();  // tell the class to use Sendmail

        $mail->AddReplyTo("mahendra.akula@ideabytes.com","Mahendra");

        $mail->From       = "mahendra.akula@ideabytes.com";
        $mail->FromName   = "Mahendra";
 
        $to = "mahendra.akula@ideabytes.com";
 
        $mail->AddAddress($to);
 
        $mail->Subject  = "First PHPMailer Message[Test Read Receipt]";
 
        $mail->ConfirmReadingTo = "mahendra.akula@ideabytes.com"; //this is the command to request for read receipt. The read receipt email will send to the email address.
 
        $mail->AltBody    = "Please return read receipt to me."; // optional, comment out and test
        $mail->WordWrap   = 80; // set word wrap
 
        $mail->MsgHTML($body);
 
        $mail->IsHTML(true); // send as HTML
        $mail->Send();
          
        echo 'Message has been sent.';
} catch (phpmailerException $e) {
        echo $e->errorMessage();
}
?>