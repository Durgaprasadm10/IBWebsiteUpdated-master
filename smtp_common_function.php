<?php
define("USER_EMAIL_WEBINAR", "annie.tylor@ideabyte.net");
define('USER_PASSWORD_WEBINAR', 'anNbyteS2k21^$');

define("DB_TB_WEBINAR", "contact_form1");
 function sendemail_webinar($to, $subject, $message) {
        require_once './class-phpmailer.php';
        require_once './class-smtp.php';
        $mail = new PHPMailer();

        $mail->IsSMTP(); // send via SMTP
        $mail->Host = "smtp.office365.com"; // SMTP servers
        $mail->Port = 587; // SMTP servers
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPDebug = 0;
        $mail->Username = USER_EMAIL_WEBINAR; // SMTP username
        $mail->Password = USER_PASSWORD_WEBINAR; // SMTP password
        $mail->SMTPSecure = 'starttls';
        $mail->From = USER_EMAIL_WEBINAR;
        $mail->FromName = "Ideabytes Contact Us";
        foreach ($to as $key => $val)
            $mail->AddAddress($val);
        $mail->IsHTML(true); // send as HTML
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = "This is the plain text version of the email content";

        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
?>