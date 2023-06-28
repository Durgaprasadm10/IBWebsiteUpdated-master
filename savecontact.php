<?php
//print_r($_POST);
error_reporting(E_ALL);
ini_set('display_errors',1);
include_once("commonfunction.php");
require_once "database.php";

$db = new Database();

$logoText = "ideabytes";

$page = getfilter('page');
$to = filterpost('toaddress');
$contactName = filterpost('widget-contact-form-name');
$contactEmail = filterpost('widget-contact-form-email');

if(isset($_POST['widget-contact-form-message'])){
	$contactMessage = filterpost('widget-contact-form-message');
}else{
	$contactMessage = "";
}

if(isset($_POST['widget-contact-form-subject'])){
	$contactSubject = filterpost('widget-contact-form-subject');
}else{
	$contactSubject = $contactName." is interested to Get limited free cybersecurity diagnostics";
}


if(isset($_POST['widget-contact-form-designation'])){
	$designation = filterpost('widget-contact-form-designation');
}else{
	$designation = "";
}

if(isset($_POST['widget-contact-form-phone_number'])){
	$phonenumber = filterpost('widget-contact-form-phone_number');
}else{
	$phonenumber = "";
}

if(isset($_POST['widget-contact-form-countrycode'])){
	$countrycode = filterpost('widget-contact-form-countrycode');
}else{
	$countrycode = "";
}

if(isset($_POST['widget-contact-form-company_name'])){
	$companyname = filterpost('widget-contact-form-company_name');
}else{
	$companyname = "";
}


$ipAddress = (@$_SERVER['REMOTE_ADDR'] != "") ? @$_SERVER['REMOTE_ADDR'] : "";

$contactMessageToAdmin = "<p>Hi Admin, <br> The following data received from " . $logoText . " contact us page </p>
                          <p>Name: ". $contactName ."<br>
                            Email: ". $contactEmail ."<br>
			    From ip: ". $ipAddress."<br>";

	if($contactMessage!=""){
                $contactMessageToAdmin .= "Message: ". $contactMessage ."<br>";
	}

	if($companyname!=""){
		$contactMessageToAdmin .= "Company Name: ".$companyname."<br>";
	}
	if($countrycode !=""){
		$contactMessageToAdmin .= "country code: ".$countrycode."<br>";
	}

	if($phonenumber!=""){
		$contactMessageToAdmin .= "Phone number : ".$phonenumber."<br>";
	}
	if($designation !=""){
		$contactMessageToAdmin .= "Designation: ".$designation."<br>";
	}

			  $contactMessageToAdmin .= "</p>";

$today = gmdate('Y-m-d H:i:s');
$query = "insert into contact_form(name,email,subject,message,page,ipaddress,reg_date) values";
$query .= " ( '".$contactName."', '".$contactEmail."','".$contactSubject."','".$contactMessage."','".$page."', '".$ipAddress."', '".$today."')";
$result = $db->executeQuery($query);

//$to = "kishore.putrevu@ideabytes.com";
$toemail = array($to);
if(sendemail($toemail, $contactSubject, $contactMessageToAdmin)){
	echo "success";
}else{
	echo "failed";
}
