<?php
/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 26/05/2014                                    	*
 * Created By : Mahaendra Akula                                	*
 * Vision : Campaign Manager                                       	*  
 * Modified by : Mahendra      Date : 24/08/2014    Version : I    	*
 * Description : create campaign                                  	*
 * ***************************************************************** */

//Added by pradeep - 18-7-14
$logininfo["customer_id"] = @$_GET["customer_id"];

include("includes/headerCM.inc.php");
include("classes/campaignlist.class.php");
include("classes/campaignmanagerbase.class.php");

@$userID = $_GET['uid'];
@$linkno = $_GET['lnm'];
@$cm_id = $_GET['cmid'];
@$table_id = $_GET['tid'];
$cManager = new CampaignManagerBase();
$objMessages = new Messages();
$objCList = new CList();
try {
    $linkDetails = $objCList->getMapDetailsBasedOnLink($cm_id, $linkno);
    @$new_link = $linkDetails[0]['map_value'];
    $userAgentDetails = $cManager->getBrowser();
    $userAgentName = $userAgentDetails['name'];
    $userAgentVersion = $userAgentDetails['version'];
    $userAgentPlatform = $userAgentDetails['platform'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $city = $cManager->getCity($ip);
    date_default_timezone_set('Asia/Kolkata');
    $createdate = date('Y-m-d H:i:s');
    $userDevice = $userAgentName . "," . $userAgentVersion . "," . $userAgentPlatform;
    $link_name = $new_link;
    $campaign_NameDetails = $objCList->getCampaignContent($cm_id);
    @$campaignName = $campaign_NameDetails[0]['campaign_name'];
    $tableDetails = $objCList->getProcessCampaignMainById($table_id);
    $tableName = $tableDetails['TableName'];
    $sPID = $tableDetails['pid'];
    //$userDetails = $objCList->getProcessUserDetailsByUserIDByTable($tableName, $userID);
    $userDetails = $objCList->getProcessUserDetailsByUserIDPID($sPID, $userID);
    @$userEmail = $userDetails['user_email'];
    @$sListId = $userDetails['list_id'];
    //  $visitorTrack['email'] = $userEmail;
    $visitorTrack['email'] = $userEmail;
    $visitorTrack['cm_name'] = $campaignName;
    $visitorTrack['link_name'] = $link_name;
    $visitorTrack['ip_add'] = $ip;
    $visitorTrack['visited_on'] = $createdate;
    $visitorTrack['visitor_location'] = $city;
    $visitorTrack['visitor_device'] = $userDevice;

    //Changes By Mahendra
    $visitorTrack['user_id'] = $userID;
    $visitorTrack['cm_id'] = $cm_id;
    $visitorTrack['process_id'] = $sPID;
    $visitorTrack['link_name'] = $link_name;
    $visitorTrack['ip_add'] = $ip;
    $visitorTrack['visited_on'] = $createdate;
    $visitorTrack['visitor_location'] = $city;
    $visitorTrack['visitor_device'] = $userDevice;

    if ($link_name != TRACKING_URL . "/unsubscribe.php") {
        $objCList->addVisitorTracking($visitorTrack);
    }
    echo $link_name;
    if ($link_name == TRACKING_URL . "/unsubscribe.php") {
       // $objCList->updateUnsubscripstion($sPID, $userID);
        //need to get the $sListId 
        $objCList->addUnsubscribedList($sPID, $userID, $sListId, $userEmail);
    }
} catch (Exception $e) {
    $new_link = '#';
}
?>
<script type="text/javascript">window.location = '<?php echo $new_link; ?>';</script>