<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 26/05/2014                                    	*
 * Created By : Mahaendra Akula                                	*
 * Vision : Campaign Manager                                       	*  
 * Modified by : Mahendra      Date : 27/08/2014    Version : I    	*
 * Description : create campaign                                  	*
 * ***************************************************************** */

include("includes/header.inc.php");
include("classes/campaignlist.class.php");
include("classes/campaignmanager.class.php");

$objMessages = new Messages();
$objCList = new CList();

$searchstring = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);


//@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
//@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];
//@$campaignId = (isset($_GET['cmid'])) ? $_GET['cmid'] : $_POST['cmid'];

@$process_id = (isset($_GET['pid'])) ? $_GET['pid'] : $_POST['pid'];
@$sSDate = (isset($_GET['campaign_date'])) ? $_GET['campaign_date'] : $_POST['campaign_date'];
//echo "Date is :$sSDate <br>";
if (isset($iPID)) {
    $process_id = $iPID;
}
//echo "P iD  --- $process_id";
switch ($action) {

    default:
        $count = $objCList->getProcessCampaignMainListCount1();
        // echo "$count<br>";
        if ($count > 0) {
            // echo "<pre>";
            $aPMList = $objCList->getProcessCampaignMainListForCmSelection();
            // print_r($aPMList);
        }
        // echo "<pre>";
        //print_r($_POST);
        if ($sSDate != '' && $process_id != '') {
            // echo "**********$sSDate<br>";
            //echo "**********$process_id<br>";
            $aCMUserList = $objCList->getProcessUserDetailsByDates($process_id, $sSDate);
            // echo "<pre>";
            // print_r($aCMUserList);
        } else {
            if ($process_id != '') {
                // echo "$process_id<br>";  
                // echo "Debug;";
                // echo "P iD  --- $process_id";
                $aCMUserList = $objCList->getProcessUserDetailsByPid($process_id);
                // echo "<pre>";
                //print_r($aCMUserList);
            } else {
                if (isset($aPMList)) {
                    $process_id = $aPMList[0]['pid'];
                    $aCMUserList = $objCList->getProcessUserDetailsByPid($process_id);
                }
            }
            //echo $process_id.'<br>';
            $iUDMC = $objCList->getUndeliveredMailCount($process_id);
        }
        // print_r($aCMUserList);
        if (isset($aPMList)) {
            foreach ($aPMList as $key => $value) {
                if ($value['pid'] == $process_id) {
                    $iCmID = $value['cm_id'];
                }
            }
        }
        if (isset($aPMList)) {
            // echo "P iD  --- $process_id".'<br>';
            //echo $aPMList[0]['cm_id'].'<br>';
            //echo "<pre>";
            // echo "CMID : $iCmID<br>";
            // print_r($aPMList);
            $sCmName = $objCList->getCampaignNameByID($iCmID);
        }
        // echo "<pre>";
        // print_r($sCmName);
        // print_r($aPMList);
        // exit;
        //print_r($sCmName);
        //$campaign_names = $objCList->getCampaignList();
        //echo "<pre>";
        // echo "CamapignID : $campaignId<br>";
        //    print_r($aCMUserList);
        // print_r($campaign_names);

        include("layouts/mailstatistics.html");
}
?>