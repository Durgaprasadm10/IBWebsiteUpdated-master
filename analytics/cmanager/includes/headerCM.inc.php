<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Sparkle                                       *  
 * Modified by : Pradeep G     Date : 05/02/2014    Version : V1  *
 * Description : Header file - file includes,session, cookie
 * language selection, page content can be processed here         *
 * *************************************************************** */

/* For display error report  */
//error_reporting(E_ALL);
if(@$logininfo["customer_id"]==""){
	@$logininfo["customer_id"] = (isset($_GET['customer_id'])) ? $_GET['customer_id'] : $_POST['customer_id'];
}

//@$logininfo["customer_id"] = "IBCUS1406875026";
include("../includes/tables.php");
include("../includes/dbconfig.php");
include "includes/functions.php";
$cSettings = getCmSettings($logininfo["customer_id"]);

/* Includes config,db and table definitions and common functions files */
include("dbconfig1.php");   //Creates db connection
include("configuration.php");  //Default configurations
include("tables.php");   // Define table with global conrtants


include("classes/messages.class.php");
?>