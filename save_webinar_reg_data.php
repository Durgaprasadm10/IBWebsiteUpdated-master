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


switch ($_POST['action']) {
    case "test_auto":

        $contactName = filterpost('widget-contact-form-name');
        $contactEmail = filterpost('widget-contact-form-email');
        $contactCompanyName = filterpost('widget-contact-form-company');
        $contactDesignation = filterpost('widget-contact-form-designation');
        $contactCountry = filterpost('widget-contact-form-country');


        $messageToAdmin = "<p>Hi Admin, <br> The following data received from  Webinar Registration  page </p>
                          <p>Name: " . $contactName . "<br>
                            Email: " . $contactEmail . "<br>
                            Company Name:" . $contactCompanyName . " <br> 
                            Designation : " . $contactDesignation . " <br> 
                            Country : " . $contactCountry . "</p>";

        $webinar_date = "29th September 2021 at 11 AM (Eastern Time)";
        $webinar_name = "TEST AUTOMATION WEBINAR(SCRIPTLESS TEST AUTOMATION)";
        $query = "insert into webinar_reg_data (name,email,company_name,designation,country,webinar_name,webinar_date) values";
        $query .= " ( '" . $contactName . "', '" . $contactEmail . "','" . $contactCompanyName . "','" . $contactDesignation . "','" . $contactCountry . "','" . $webinar_name . "','" . $webinar_date . "')";
        $result = $db->executeQuery($query);

        $toemail = array(USER_EMAIL_WEBINAR);

        /* To Admin */
        if (sendemail_webinar($toemail, $webinar_name, $messageToAdmin)) {
            $toContactEmail = array($contactEmail);
            $toContactSubject = "TEST AUTOMATION WEBINAR(SCRIPTLESS TEST AUTOMATION)";
            $toContactMsg = "Hi " . $contactName . ",
            <br> <br> 
            Thank you for registering for the webinar on Scriptless test Automation.  <br>
            Please find the below given zoom link for the webinar which will be held on September 29nd 11.00 AM EST.
            <br><br>
            Click on the link to join the event via Zoom:
            <br> <br>
            <a href='https://ideabytes.zoom.us/j/81236137211'>Join the Webinar on September 29nd at 11 AM (EST)</a>
        
            <br> <br>
            
            Meeting ID: 812 3613 7211 <br>
        One tap mobile <br>
        +13017158592,,81236137211# US (Washington DC)<br>
        +13126266799,,81236137211# US (Chicago) <br>
        
        <br>  <br>
        
        Dial by your location<br>
        +1 301 715 8592 US (Washington DC)<br>
        +1 312 626 6799 US (Chicago)<br>
        +1 346 248 7799 US (Houston)<br>
        +1 646 876 9923 US (New York)<br>
        +1 669 900 6833 US (San Jose)<br>
        +1 253 215 8782 US (Tacoma)<br>
        +1 438 809 7799 Canada<br>
        +1 587 328 1099 Canada<br>
        +1 647 374 4685 Canada<br>
        +1 647 558 0588 Canada<br>
        +1 778 907 2071 Canada<br>
        +1 204 272 7920 Canada<br>
Meeting ID: 812 3613 7211 <br>
             
            <br> <br>
            Looking forward to seeing you!
            <br> <br>
            Best Regards, <br>
            Webinar Team";
            /* To Contact User*/
            if (sendemail_webinar($toContactEmail, $toContactSubject, $toContactMsg)) {
                echo "success";
            }
        } else {
            echo "failed";
        }

        break;
    default:
        break;
}

