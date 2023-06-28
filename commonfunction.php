<?php
require_once("constants.php");
function sendemail($to, $subject, $message) {
        require_once './class-phpmailer.php';
        require_once './class-smtp.php';
        $mail = new PHPMailer();

        $mail->IsSMTP(); // send via SMTP
        $mail->Host = "smtp.office365.com"; // SMTP servers
        $mail->Port = 587; // SMTP servers
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPDebug = 0;
        $mail->Username = USER_EMAIL; // SMTP username
        $mail->Password = USER_PASSWORD; // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->From = USER_EMAIL;
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

    function filterpost($protocol) {
        return trim(filter_input(INPUT_POST, $protocol, FILTER_SANITIZE_STRING));
    }

    function getfilter($protocol) {
        return trim(filter_input(INPUT_GET, $protocol, FILTER_SANITIZE_STRING));
    }
