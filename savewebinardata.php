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
//define("USER_EMAIL_WEBINAR", "stacy.johnson@ideabyte.net");
//define("USER_PASSWORD_WEBINAR", "ysqwztbvdyhwzjxg");
$db = new Database();

//$logoText = "ideabytes";
//$page = getfilter('page');
$to = USER_EMAIL_WEBINAR;
$contactName = filterpost('widget-contact-form-name');
$contactEmail = filterpost('widget-contact-form-email');

//if(isset($_POST['widget-contact-form-message'])){
//	$contactMessage = filterpost('widget-contact-form-message');
//}else{
//	$contactMessage = "";
//}
//if(isset($_POST['widget-contact-form-subject'])){
//	$contactSubject = filterpost('widget-contact-form-subject');
//}else{
//	$contactSubject = $contactName." is interested to Get limited free cybersecurity diagnostics";
//}
if (isset($_POST['widget-contact-form-company'])) {
    $companyname = filterpost('widget-contact-form-company');
} else {
    $companyname = "";
}

if (isset($_POST['widget-contact-form-designation'])) {
    $designation = filterpost('widget-contact-form-designation');
} else {
    $designation = "";
}

//if(isset($_POST['widget-contact-form-phone_number'])){
//	$phonenumber = filterpost('widget-contact-form-phone_number');
//}else{
//	$phonenumber = "";
//}

if (isset($_POST['widget-contact-form-country'])) {
    $countrycode = filterpost('widget-contact-form-country');
} else {
    $countrycode = "";
}






//$ipAddress = (@$_SERVER['REMOTE_ADDR'] != "") ? @$_SERVER['REMOTE_ADDR'] : "";

//$contactMessageToAdmin = "<p>Hi Admin, <br> The following data received from " . $logoText . " contact us page </p>
//                          <p>Name: ". $contactName ."<br>
//                            Email: ". $contactEmail ."<br>
//			    From ip: ". $ipAddress."<br>";
$contactMessageToAdmin = "<p>Hi Admin, <br> The following data received from  Webinar Registration  page </p>
                          <p>Name: " . $contactName . "<br>
                            Email: " . $contactEmail . "<br> ";



if ($companyname != "") {
    $contactMessageToAdmin .= "Company Name: " . $companyname . "<br>";
}

if ($designation != "") {
    $contactMessageToAdmin .= "Designation: " . $designation . "<br>";
}
if ($countrycode != "") {
    $contactMessageToAdmin .= "country code: " . $countrycode . "<br>";
}




$contactMessageToAdmin .= "</p>";

$page = "webinar_registration";
$today = gmdate('Y-m-d H:i:s');
$query = "insert into ".DB_TB_WEBINAR."(name,email,company_name,designation,toaddress,reg_date,page,subject,message) values";
$query .= " ( '".$contactName."', '".$contactEmail."','".$companyname."','".$designation."','".$countrycode."','".$today."','".$page."','','')";
$result = $db->executeQuery($query);
$contactSubject = "Webinar Registration Page";
$toemail = array($to);
if (sendemail_webinar($toemail, $contactSubject, $contactMessageToAdmin)) {
       $to_contactEmail = array($contactEmail);
    $contactSubject = "You are registered for the Cyber Security Webinar on September 22nd at 11:00 AM EST";
    $contactMessageToAdmin = "Hi " . $contactName . ",
    <br> <br> 
    Thank you for registering for the webinar on Security for the Docker Container.  <br>
    Please find the below given zoom link for the webinar which will be held on September 22nd 11.00 AM EST.
    <br><br>
    Click on the link to join the event via Zoom:
    <br> <br>
    <a href='https://ideabytes.zoom.us/j/89112808106'>Join the Webinar on September 22nd at 11 AM (EST)</a>

    <br> <br>
    
    Meeting ID: 891 1280 8106 <br>
One tap mobile <br>
+16468769923,,86030653334# US (New York) <br>
+16699006833,,86030653334# US (San Jose) <br>

<br>  <br>

Dial by your location  <br>
        +1 646 876 9923 US (New York)  <br>
        +1 669 900 6833 US (San Jose) <br>
        +1 253 215 8782 US (Tacoma) <br>
        +1 301 715 8592 US (Washington DC) <br>
        +1 312 626 6799 US (Chicago) <br>
        +1 346 248 7799 US (Houston) <br>
        +1 647 558 0588 Canada <br>
        +1 778 907 2071 Canada <br>
        +1 204 272 7920 Canada <br>
        +1 438 809 7799 Canada <br>
        +1 587 328 1099 Canada <br>
        +1 647 374 4685 Canada <br>
        Meeting ID: 891 1280 8106 <br>
     
    <br> <br>
    Looking forward to seeing you!
    <br> <br>
    Best Regards, <br>
    Webinar Team";
    if (sendemail_webinar($to_contactEmail, $contactSubject, $contactMessageToAdmin)) {

        echo "success";
    }
    
} else {
    echo "failed";
}
