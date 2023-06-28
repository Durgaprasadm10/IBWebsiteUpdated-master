<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 24/08/2014                                     	*
 * Created By : Mahendra Akula                                	*
 * Vision : Project Infofam                                       	*  
 * Modified by : Mahendra A    Date : 24/08/2014    Version : I    	*
 * Description : Unsubscribed Report                              	*
 * ***************************************************************** */

include("includes/header.inc.php");
include("classes/campaignlist.class.php");

$oCList = new CList();
$objMessages = new Messages();

$moduleLabel = "Unsubscribed User";
$searchstring = "";
$start_limit = 0;
//print_r($_POST);
@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];

if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
else
    $page = 1;
@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];

switch ($action) {
    case 'delete';
        $sMsg = $oCList->deleteUnsubUser($id);
        if ($sMsg == 1) {
            $msg = $objMessages->addupdatesucessIndication($moduleLabel, $action);
        } else {
            $msg = $objMessages->errorIndication($moduleLabel, $action);
        }
    default :
       
        $count = $oCList->getUnsubscribedListCount();
        if ($count > 0) {
            $aUnSubList = $oCList->getUnsubscribedList();
        }
}

include 'layouts/unsubscribed_report.html';
?>