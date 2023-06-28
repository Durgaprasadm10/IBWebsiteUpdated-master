<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 14/04/2014                                     	*
 * Created By : Haritha Rekapalli                                 	*
 * Vision : Project Infofam                                       	*  
 * Modified by : Haritha      Date : 14/04/2014    Version : I    	*
 * Description : create campaign                                  	*
 * ***************************************************************** */

include("includes/header.inc.php");
include("classes/campaignlist.class.php");

$objMessages = new Messages();
$objCList = new CList();

$moduleLabel = "Campaign";
$searchstring = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);

@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];
@$idVal = (isset($_GET['idVal'])) ? $_GET['idVal'] : $_POST['idVal'];
@$campaign_name = $_POST['campaign_name'];
@$campaign_shortDesc = $_POST['campaign_shortDesc'];
@$campaign_longDesc = $_POST['campaign_longDesc'];
@$create_new = $_POST['create_new'];
@$sPid = (isset($_GET['pid'])) ? $_GET['pid'] : $_POST['pid'];
switch ($action) {

    case "delete":
        /* Delete page */
        $sTableName = $objCList->getTableName($sPid);
        $sMsg1 = $objCList->deleteProcessByTable($id, $sPid);
        $sMsg2 = $objCList->deleteMapDetails($id, $sPid);
        $sMsg3 = $objCList->dropTable($sTableName['TableName']);
        if ($sMsg1 == 1 && $sMsg2 == 1 && $sMsg3 == 1) {
            $sMsg = ($action == "delete") ? $objMessages->addupdatesucessIndication($moduleLabel, $action) : $objMessages->changestatusIndication($moduleLabel);
        } else {
            $sMsg = $objMessages->errorIndication($moduleLabel, $action);
        }
        $count = $objCList->getProcessCampaignMainListCountALL();
        if ($count > 0) {
            $campaignList = $objCList->getProcessCampaignMainListAll();
            // echo "<pre>";
            //print_r($campaignList);
        }
       $aProcessedCm = $objCList->getPrcessedCampaignIds();
       //echo "<pre>";
       
       $aProcessedCampaigns = array();
       foreach($aProcessedCm as $aPCM){
           array_push($aProcessedCampaigns, $aPCM['pid']);
       }
        include("layouts/managecampaign.html");
        break;
    case "editForm":
        /* editForm page */
        $selectedCampaignList = $objCList->getCampaignContent($id);
        include("layouts/createcampaign.html");
        break;
    case "update":
        /* update page */
        $sMsg1 = $objCList->editCampaign($_POST, $idVal);
        if ($sMsg1 == 1) {
            $sMsg = ($action == "update") ? $objMessages->addupdatesucessIndication($moduleLabel, $action) : $objMessages->changestatusIndication($moduleLabel);
        } else {
            if ($sMsg1 == 0)
                $sMsg = $objMessages->errorIndication($moduleLabel, $action);
            if ($sMsg1 == 2)
                $sMsg = $objMessages->duplicateIndication($moduleLabel);
        }
    default:
        /* List the events  */

        $count = $objCList->getProcessCampaignMainListCountALL();
        if ($count > 0) {
            $campaignList = $objCList->getProcessCampaignMainListAll();
            // echo "<pre>";
            //print_r($campaignList);
        }
       $aProcessedCm = $objCList->getPrcessedCampaignIds();
       //echo "<pre>";
       
       $aProcessedCampaigns = array();
       foreach($aProcessedCm as $aPCM){
           array_push($aProcessedCampaigns, $aPCM['pid']);
       }
      // print_r($aProcessedCampaigns);
//        $count1 = $objCList->getProcessCampaignMainListCount1();
//        if ($count1 > 0) {
//            $campaignList1 = $objCList->getProcessCampaignMainList1();
//        }
//        $count = $count2 + $count1;
//        if ($count1 > $count) {
//            $count = $count1;
//        }
        // echo "<pre>";
        //print_r($campaignList);
        // print_r($campaignList1);
        include("layouts/managecampaign.html");
}
?>