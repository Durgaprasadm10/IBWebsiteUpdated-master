<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Campaign Manager                                       *  
 * Modified by : Mahendra A    Date : 1/07/2014    Version : V1  *
 * Description : Header file - file includes,session, cookie
 * language selection, page content can be processed here         *
 * *************************************************************** */
header('Content-Type:text/html; charset=UTF-8');

/* For display error report  */
error_reporting(E_ALL);

/* For Seesion initialize  */
session_start();


/* check logged session */

@$logininfo = unserialize($_SESSION['logininfo']);
if($logininfo["username"]==""){
	if(basename($_SERVER['PHP_SELF']) != "login.php"){
		header("Location: ../login.php");
		exit;
	}
}


include("../includes/tables.php");
include("../includes/dbconfig.php");
include "includes/functions.php";

if(@$logininfo["admin_type"] == "1"){	
	if(@$_POST["admin_customer_id"]!=""){
		$logininfo["customer_id"] = $_POST["admin_customer_id"];
		@$_SESSION["admin_customer_id"] = @$_POST["admin_customer_id"];
	}else{
		$logininfo["customer_id"] = @$_SESSION["admin_customer_id"];
	}
}

define("CUSTOMER_LOGO_PATH","customer_logo/");
$cusInfo = getCustomerInfo(@$logininfo["customer_id"]);
$logoPath = "../".CUSTOMER_LOGO_PATH."/".$cusInfo["logo_image"];

$cSettings = getCmSettings($logininfo["customer_id"]); 
//echo "<pre>";
//print_r($cSettings);
$dbname = $cSettings["db_name"];
define("DBNAME",$dbname);
/* Includes config,db and table definitions and common functions files */
include("dbconfig1.php");   //Creates db connection
include("configuration.php");  //Default configurations
include("tables.php");   // Define table with global conrtants


include("classes/messages.class.php");
?>