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


@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
//@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];
//@$campaign_name = (isset($_GET['cm_id'])) ? $_GET['cm_id'] : $_POST['cm_id'];
//@$campaignId = (isset($_GET['cm_id'])) ? $_GET['cm_id'] : $_POST['cm_id'];

$sPid = (isset($_GET['pid'])) ? $_GET['pid'] : ((isset($_POST['pid']))?$_POST['pid']:'');
switch ($action) {

    default:
        $count = $objCList->getProcessCampaignMainListCount1();
        // echo "$count<br>";
        if ($count > 0) {
            // echo "<pre>";
            $aPMList = $objCList->getProcessCampaignMainListForSelect();
            // print_r($aPMList);      
            if (!empty($sPid)) {
                $aCMUserList = $objCList->getProcessUserDetailsByPid($sPid);
                $count = $objCList->countVisitorTrackDetailsByPid($sPid);
                if ($count > 0) {
                    $visitorDetails = $objCList->displayVisitorTrackDetailsPid($sPid);
                }
            } else {
                if (isset($aPMList)) {
                    $sPid = $aPMList[0]['pid'];
                    $aCMUserList = $objCList->getProcessUserDetailsByPid($sPid);
                    $count = $objCList->countVisitorTrackDetails();
                    if ($count > 0) {
                        $visitorDetails = $objCList->displayVisitorTrackDetails();
                    }
                }
            }

            foreach ($aPMList as $key => $value) {
                if ($value['pid'] == $sPid) {
                    $iCmID = $value['cm_id'];
                    break;
                }
            }
            if (isset($iCmID)) {
                $sCmName = $objCList->getCampaignNameByID($iCmID);
            }
        }
        include("layouts/statistics.html");
}
?>