<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 03/04/2014                                      *
 * Created By : Vijaya                                            *
 * Vision : Project Visitortracking                               *  
 * Modified by : Vijaya     Date : 12/05/2014   Version : 1.1.0   *
 * Description : this is header.inc file that includes all        *
					required files.                               *
 *****************************************************************/
//session_start();
date_default_timezone_set('UTC');
/*
include("../../includes/tables.php");
include("../../includes/dbconfig.php");
include "../../includes/function_common.php";
*/

include("/var/www/html/analytics/includes/tables.php");
include("/var/www/html/analytics/includes/dbconfig.php");
include "/var/www/html/analytics/includes/function_common.php";

if(@$logininfo["admin_type"] == "1"){
	if(@$_POST["admin_customer_id"]!=""){
		$logininfo["customer_id"] = $_POST["admin_customer_id"];
		@$_SESSION["admin_customer_id"] = @$_POST["admin_customer_id"];
	}else{
		$logininfo["customer_id"] = @$_SESSION["admin_customer_id"];
	}
}

define("CUSTOMER_LOGO_PATH","customer_logo/");
$cusInfo = getCustomerInfo($logininfo["customer_id"]);
//$logoPath = "../".CUSTOMER_LOGO_PATH."/".$cusInfo["logo_image"];
$logoPath = "/var/www/html/analytics/analytics/".CUSTOMER_LOGO_PATH."/".$cusInfo["logo_image"];

$aSettings = getAnalyticsSettings($logininfo["customer_id"]); 

/*
include "../includes/configuration.php";
include "../includes/tables.php";
include("../includes/dbconfig1.php");
include "../includes/function_common.php";
*/
include "/var/www/html/analytics/analytics/includes/configuration.php";
include "/var/www/html/analytics/analytics/includes/tables.php";
include("/var/www/html/analytics/analytics/includes/dbconfig1.php");
include "/var/www/html/analytics/analytics/includes/function_common.php";

$timezone_array = array("-12.0"=>"-12:00","-11.0"=>"-11:00","-10.0"=>"-10:00","-9.0"=>"-09:00",
		"-8.0"=>"-08:00","-7.0"=>"-07:00","-6.0"=>"-06:00","-5.0"=>"-05:00",
		"-4.0"=>"-04:00","-3.5"=>"-03:30","-3.0"=>"-03:00","-2.0"=>"-02:00",
		"-1.0"=>"-01:00","0.0"=>"+00:00","1.0"=>"+01:00","2.0"=>"+02:00",
		"3.0"=>"+03:00","3.5"=>"+03:30","4.0"=>"+04:00","4.5"=>"+04:30",
		"5.0"=>"+05:00","5.5"=>"+05:30","5.75"=>"+05:45","6.0"=>"+06:00",
		"7.0"=>"+07:00","8.0"=>"+08:00","9.0"=>"+09:00","9.5"=>"+09:30",
		"10.0"=>"+10:00","11.0"=>"+11:00","12.0"=>"+12:00");

//echo 'Time zone is :'.$_GET['timezone'];
//Settig the TimeZone Coocki
$coockie = '';
if (!isset($_COOKIE['timezone'])) {
    if (isset($_GET['timezone'])) {
        //$coockie = $_GET['timezone'];
		$coockie = $timezone_array[$_GET['timezone']];
        setcookie('timezone', $coockie);        
    } else {
		//$visitorTimezone = getVisitorTimezone();
		//echo " ip   ".$_SERVER['REMOTE_ADDR'];
		$visitorTimezone = (isset($visitorTimezone) && ($visitorTimezone == "")) ? "+00:00" : @$visitorTimezone;
        setcookie('timezone', $visitorTimezone);
        $coockie = $visitorTimezone;
		
    }
     //echo ' Cocki not set , setting initially';
	 
} else {
    if (isset($_GET['timezone'])) {
        //$coockie = $_GET['timezone'];
		$coockie = $timezone_array[$_GET['timezone']];
        setcookie('timezone', $coockie);       
    } else {
        
        $coockie = $_COOKIE['timezone'];
    }
}

$device = '';
if (!isset($_COOKIE['device'])) {
    if (isset($_POST['device'])) {
        $device = $_POST['device'];
        setcookie('device', $device);        
    } else {
        setcookie('device', '0');
        $device = 0;
    }    
} else {	
    if (isset($_POST['device'])) {
        $device = $_POST['device'];
        setcookie('device', $device);        
    } else {
        
        $device = $_COOKIE['device'];
    }
}
$device;
//$viewDevice = ($device == 2) ? "Mobile" : ($device == 1) ?  "Personal Computer" : "";

if($device == 2){
	$viewDevice = "Mobile";
}elseif($device == 1){
	$viewDevice = "Personal Computer";
}else{
	$viewDevice = "";
}
if($device >0){
	$deviceCond = " AND vi.device = '".$viewDevice."' ";
}else{
	$deviceCond = "";
}

//echo 'sdfkjdhfvg';
//echo 'Time zone is :'.$_GET['timezone'];
//include("../includes/dbconfig.php");	 //
//$dbcon = new PDO('mysql:host=localhost;port=3306;dbname=visitortracking', 'root', 'root', array(PDO::ATTR_PERSISTENT => false));

$friendlyIps = getFriendlyIP();
if($friendlyIps != ""){
	$friendlyIpsCond = " AND vi.ip_address NOT IN (" . $friendlyIps . ") ";
}else{
	$friendlyIpsCond = "";
}

$friendlyWebsites_array = getFriendlyWebsite();
$friendlyWebsites = "";
if(count($friendlyWebsites_array ) > 0){
	
	foreach($friendlyWebsites_array as $sites){
		$site = $sites['site_name'];
		$friendlyWebsites .= " AND `page_referer` NOT LIKE '%$site%' ";
	}
	//$friendlyWebsites = substr($str, 0, strlen($str) - 4);
}

?>
