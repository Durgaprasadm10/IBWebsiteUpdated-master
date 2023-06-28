<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("smtp_common_function.php");
include_once("commonfunction.php");
require_once "database.php";
require_once("constants.php");
$db = new Database();

//Post Data From Forms

$teensName = isset($_POST['widget-contact-form-name']) ? filterpost('widget-contact-form-name') : '';
$teensEmail = isset($_POST['widget-contact-form-email']) ? filterpost('widget-contact-form-email') : '';
$teensAge = isset($_POST['widget-contact-form-age']) ? filterpost('widget-contact-form-age') : '';
$teensMsgToJoin = isset($_POST['widget-contact-form-joinMsg']) ? filterpost('widget-contact-form-joinMsg') : '';

/* Saving Data In DB */

$query = "INSERT INTO ideabytes_teens (teens_name,teens_email,teens_age,msg_to_join) values";
$query .= " ( '" . $teensName . "', '" . $teensEmail . "','" . $teensAge . "','" . $teensMsgToJoin . "')";
$result = $db->executeQuery($query);


/* Send Mails To Organisation */

$to = array();
$to[] = 'george.kongalath@ideabytes.com';
$to[] = 'anna.anthony@ideabytes.com';
$to[] = 'vera.galenko@ideabytes.com';
$to[] = 'balakishore.pendyala@ideabytes.com';

/*Details to Admin*/
$SubjectTeens = "Testing Subject Teens";
$teensMessageToAdmin = "<p>Hi, <br> The following data received from  Teens Registration  page </p>
                          <p>Name: " . $teensName . "<br>
                            Email: " . $teensEmail . "<br>
                            Age: " . $teensAge . "<br>
                            Message: " . $teensMsgToJoin . "<br>
                            </p>";

/* Thanks Email */
$teens_email = array($teensEmail);
$SubjectForTeens = "Thanks For Registartion For Teens";
$messageForTeens = "We Will Reach You with Big Surprise...";


if (sendemail($to, $SubjectTeens, $teensMessageToAdmin)) {
    if (sendemail($teens_email, $SubjectForTeens, $messageForTeens)) {
        echo "success_";
    } else {
        echo "failed";
    }
    echo "success";
} else {
    echo "failed";
}
    
      