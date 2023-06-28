<?php
/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 14/04/2014                                     	*
 * Created By : Haritha Rekapalli                                 	*
 * Vision : Project Campaign Manager                                    	*  
 * Modified by : Mahendra A      Date : 10/06/2014    Version : I    	*
 * Description : create campaign                                  	*
 * ******************************************************************/

include("includes/headerCM.inc.php");
include("classes/campaignlist.class.php");


$moduleLabel = "Campaign ";
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
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];

@$campaign_name = $_POST['campaign_name'];
@$campaign_shortDesc = $_POST['campaign_shortDesc'];
@$campaign_longDesc = $_POST['campaign_longDesc'];
@$create_new = $_POST['create_new'];
$campaign_UniqID = "cmid".uniqid();
@$selectedID = $_POST['selectedID'];

switch($action)
{
	case "add": 
		/* addForm page */  
		$sMsg1 = $objCList->addCampaign($_POST,$campaign_UniqID);
		if($sMsg1 == 1)
		{
			$sMsg = ($action == "add") ? $objMessages->addupdatesucessIndication($moduleLabel,$action) : $objMessages->changestatusIndication($moduleLabel);
		}
		else
		{
			if ($sMsg1 == 0)
                $sMsg = $objMessages->errorIndication($moduleLabel, $action);
            if ($sMsg1 == 2)
                $sMsg = $objMessages->duplicateIndication($moduleLabel);
		} 
		include("layouts/dashboard.html");
		break;
	case "select": 
		/* addForm page */  
		$campaignDetails = $objCList->getCampaignContent($selectedID);
    default:
    		/* List the events  */
			$count = $objCList->getCampaignListCount();
			if($count>0){
				$campaignList = $objCList->getCampaignList();
			}
			include("layouts/createeditcampaign1.html");
}
?>