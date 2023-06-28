<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("smtp_common_function.php");
require_once "database.php";
require_once("constants.php");

$db = new Database();

switch ($_POST['action']) {
    case "clicked":
        $unSubemail = $_POST['emailId'][0];
        $status = "clicked";
        /* Saving Data In DB */

        $query = "INSERT INTO unsubscribe_clicks (user_email,status) values";
        $query .= " ('" . $unSubemail . "' , '" . $status . "')";
        $result = $db->executeQuery($query);

        break;

    case "success":
        $email = $_POST['emailId'][0];
        $message_unsub = $_POST['msg'];
        $status = "Success";
        if (isset($email) && !empty($email)) {
            $toUnubscribeEmail = array(USER_EMAIL_WEBINAR);
            $subjectUnsub = "Unsubscribe from Ideabytes Email Updates";
            $messageUnsub = "Hi Admin, <b>" . $email . "</b> Wants To Unsubscribe from Ideabytes Email Updates.<br/>"
                    . "Reason: <b>" . $message_unsub . "</b>";
            $query = "INSERT INTO unsubscribe_clicks (user_email,status,message) values";
            $query .= " ('" . $email . "' , '" . $status . "' ,'" . $message_unsub . "')";
            $result = $db->executeQuery($query);

            if (sendemail_webinar($toUnubscribeEmail, $subjectUnsub, $messageUnsub)) {
                echo "success";
            } else {
                echo "failed";
            }
        }

        break;
}
?>


