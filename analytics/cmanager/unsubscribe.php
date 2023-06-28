<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 06/05/2014                                      *
 * Created By : Mahendra A                                         *
 * Vision : Project Campaign manager                              *
 * Modified by :    Date :     Version : V1  *
 * Description : Home page - content area                         *
 * *************************************************************** */


include('includes/headerCM.inc.php');
include('classes/campaignlist.class.php');
$objMessages = new Messages();

$moduleLabel = "Mail ";
$action = "Un Subscrib";
$sMsg = $objMessages->addupdatesucessIndication($moduleLabel, $action);
include("layouts/unsubscribe.html");
?>