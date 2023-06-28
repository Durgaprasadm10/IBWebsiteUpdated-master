<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 21/05/2014                                     	*
 * Created By : Mahendra Akula                               	*
 * Vision : Project CampaignManager                                       	*  
 * Modified by : Mahendra A    Date :    Version : I    	*
 * Description : create campaign                                  	*
 * ***************************************************************** */

include("includes/header.inc.php");
include("classes/campaignlist.class.php");
$objMessages = new Messages();
$objCList = new CList();

$moduleLabel = "Campaign ";
$searchstring = "";
$start_limit = 0;

@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];

if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
else
    $page = 1;


switch ($action) {
    case "delete":
        if (isset($id)) {
            $sMsg1 = $objCList->deleteCampaign($id);
            if ($sMsg1 == 1) {
                $sMsg = $objMessages->addupdatesucessIndication($moduleLabel, "Delet");
            } else {
                $sMsg = $objMessages->errorIndication($moduleLabel, "Delet");
            }
        }
      default :
      //  echo "<pre>";
        $aCmListID = array();
        $aPCmList = array();
        $aCmList = $objCList->getCampaigIdsFromCMList();
        $aPCmMList = $objCList->getCampaigIdsFromPCMMain();
       // print_r($aCmList);
       // print_r($aPCmMList);
        foreach ($aCmList as $value) {
            array_push($aCmListID, $value['id']);
        }
        foreach ($aPCmMList as $value) {
            array_push($aPCmList, $value['cm_id']);
        }
       // print_r($aCmListID);
      //  print_r($aPCmList);
        $count = $objCList->getCampaignListCountUnMapped();
       // echo "<pre>";
        //echo "Count is :$count<br>";
      //  exit;
        if ($count > 0) {
            $campaignList = $objCList->getCampaignListUnMapped();
           // print_r($campaignList);
        }
        include("layouts/unprocessedcampaigns.html");
        break;
}
?>