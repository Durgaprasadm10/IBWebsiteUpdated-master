<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 14/04/2014                                     	*
 * Created By : Haritha Rekapalli                                 	*
 * Vision : Project CampaignManager                                       	*  
 * Modified by : Mahendra Akula      Date : 03/98/2014    Version : V2    	*
 * Description : create campaign                                  	*
 * ***************************************************************** */

include("includes/header.inc.php");
include("classes/campaignlist.class.php");
include("classes/campaignmanager.class.php");
include("classes/list.class.php");
$moduleLabel = "Campaign ";
$objMessages = new Messages();
$objCList = new CList();
$objCmanager = new CManager();
$objMList = new MList();
$searchstring = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);


@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];


switch ($action) {
    case "map":
        $PCMid = $_POST['process_id'];
        $aCampaignDetails = $objCList->getProcessCampaignMainByPId($PCMid);
        $cm_id = $aCampaignDetails['cm_id'];
		$cm_subject = $aCampaignDetails['mail_subject'];
        // echo "<pre>";
        //print_r($aCampaignDetails);
        //  echo "CM ud $cm_id<br>";
        $sMsg1 = $objCList->addMappingDetails($_POST, $cm_id);
        //$sMsg1 = 1;

        if ($sMsg1 == 1) {

            $sMsg = ($action == "map") ? $objMessages->addupdatesucessIndication($moduleLabel, $action) : $objMessages->changestatusIndication($moduleLabel);

            // echo "Debug<br>";
            $objCList->updateMappingStatus($PCMid);

            $sListID = $aCampaignDetails['list_id'];

            $aListId = explode(',', $sListID);
            /*             * ****************************************************************** */
            $sMergeTableName = $aCampaignDetails['TableName'];
            $aUserIDList = $objCList->getUserIDList($sMergeTableName);

            $sDG = DEFAULT_GROUP;
            if (!empty($sDG)) {
                $aDefaultGroup = explode(',', DEFAULT_GROUP);
                foreach ($aDefaultGroup as $sUserDetails) {
                    $aUserDetails = explode('#', $sUserDetails);
                    $aEmailId[] = $aUserDetails[1];
                }
            }
            $start = $aCampaignDetails['start_date'];
            $end = $aCampaignDetails['end_date'];
            $iWeekEnd = $aCampaignDetails['weekend'];

            //Getting the unsub users
            $aUSUsersMails = $objCList->getUnsubscribedList();


            //Inserting special Image
            if (sizeof($_FILES) > 0) {
                $sFileType = 'image/png';
                // echo $start.'<br>';
                $sPdate = $start;
                for ($k = 1; $k <= sizeof($_FILES); $k++) {
                    $sFilepath = TRACKING_URL . '/images/' . $_FILES[$k]["name"];
                    //echo $sFilepath;
                    if ($_FILES[$k]['type'] == $sFileType) {
                        $sFilep = './images/' . $_FILES[$k]["name"];
                        if (@move_uploaded_file($_FILES[$k]['tmp_name'], $sFilep)) {
                            $objCList->addFiledetails($PCMid, $cm_id, $sFilepath, $sPdate);
                            $sPdate = date('Y-m-d', strtotime('+1 day', strtotime($sPdate)));
                            //echo $sPdate.'<br>';
                        }
                    }
                }
            }

            if ($iWeekEnd == 0) {
                $datediff = strtotime($aCampaignDetails['end_date']) - strtotime($aCampaignDetails['start_date']);
                $iDays = floor($datediff / (60 * 60 * 24)) + 1;


                for ($k = 0; $k < $iDays; $k++) {

                    $sProcessDate = date('Y-m-d', strtotime($start . ' +' . $k . ' day'));

                    if ($sProcessDate == date('Y-m-d')) {
                        $aCMDetails = $objCList->getCampaignDetailsByID($cm_id);
                        $cm_name = $aCMDetails['campaign_name'];
                        $cm_content = $aCMDetails['campaign_content'];
                        $pid = $aCampaignDetails['pid'];
                        $pid_autoId = $aCampaignDetails['id'];
                        $MainMergeTableName = $aCampaignDetails['TableName'];
                        $mapDetails = $objCList->getMapDetailsByTable($cm_id, $MainMergeTableName);
                    }

                    foreach ($aUserIDList as $sUserID) {
                        $sUserID = $sUserID['ID'];
                        $aMail = $objCList->getEmailByUserID($sMergeTableName, $sUserID);
                        $sMail = $aMail['EmailID'];
                        // $sMobileNum = $aMail['MobileNo'];
                        if (!in_array(@$sMail, @$aEmailId)) {
                            foreach ($aListId as $sListID) {
                                $sListName = $objMList->getListNameByID($sListID);
                                //echo "List Name$sListName <br>";
                                $aAllDetails = $objCList->getAllDetails($sListName);
                                // print_r($aAllDetails);
                                foreach ($aAllDetails as $sDetail) {
                                    if ($sDetail == $sMail) {
                                        //  echo "Email exist in $sListName list and List id is $sListID<br>";
                                        $sListID1 = $sListID;
                                        break;
                                    }
                                }
                            }
                        } else {
                            $sListID1 = 0;
                        }
                        $aPCL = array();
                        $aPCL['cm_id'] = $aCampaignDetails['cm_id'];
                        @$aPCL['list_id'] = $sListID1;
                        $aPCL['process_date'] = $sProcessDate; /////////
                        $aPCL['process_id'] = $aCampaignDetails['pid'];
                        $aPCL['user_id'] = $sUserID;
                        $aPCL['user_email'] = $sMail;
                        $aPCL['mail_status'] = '0'; ////////////
                        $aPCL['mail_date'] = date('Y-m-d H:i:s'); /////////
                        //$aPCL['mobile'] = $sMobileNum;
                        //Getting the Unsubscribed Users list 
                        $UnSub = false;
                        foreach ($aUSUsersMails as $aEmail) {
                            if ($aEmail['mail_id'] == $sMail) {
                                $UnSub = true;
                                break;
                            }
                        }
                        if (!$UnSub) {

                            //Checks for Campaign Start date Vs Current date
                            //  echo $aCampaignDetails['start_date'] . '<br>';
                            // echo date('Y-m-d');

                            if ($sProcessDate == date('Y-m-d')) {
                                $user_id = $sUserID;
                                $to_mail = $sMail;
                                $userIndividual = $objCList->getUserDetailsByTable($to_mail, $MainMergeTableName);
                                $result = sendMailT($cm_name, $mapDetails, $pid, $pid_autoId, $cm_id, $cm_content, $user_id, $to_mail, $userIndividual,$cm_subject);
                                if ($result == 1) {
                                    $aPCL['mail_status'] = '1';
                                }
                            }
                            // exit;
                            // $aPCL['mail_status'] = '1';
                            $objCList->insertProccessCampaignList($aPCL);
                        }
                    }
                }
            } else {
                $aSaterDays = numWeekDays(strtotime($start), strtotime($end), 'saturday', TRUE);
                //echo "<pre>";
                // print_r($aSaterDays);
                $aSundays = numWeekDays(strtotime($start), strtotime($end), 'sunday', TRUE);
                // print_r($aSundays);
                $aSater_sun = array($aSaterDays, $aSundays);
                // print_r($aSater_sun);
                // exit;
                foreach ($aSater_sun as $aWeekEnd) {
                    $iDays = $aWeekEnd[0];
                    $aDate = $aWeekEnd[1];

                    for ($k = 0; $k < $iDays; $k++) {
                        // $sProcessDate = date('Y-m-d', strtotime($start . ' +' . $k . ' day'));
                        if ($$aDate[$k] == date('Y-m-d')) {
                            $aCMDetails = $objCList->getCampaignDetailsByID($cm_id);
                            $cm_name = $aCMDetails['campaign_name'];
                            $cm_content = $aCMDetails['campaign_content'];
                            $pid = $aCampaignDetails['pid'];
                            $pid_autoId = $aCampaignDetails['id'];
                            $MainMergeTableName = $aCampaignDetails['TableName'];
                            $mapDetails = $objCList->getMapDetailsByTable($cm_id, $MainMergeTableName);
                        }
                        foreach ($aUserIDList as $sUserID) {
                            $sUserID = $sUserID['ID'];
                            $aMail = $objCList->getEmailByUserID($sMergeTableName, $sUserID);
                            $sMail = $aMail['EmailID'];
                            // $sMobileNum = $aMail['MobileNo'];
                            if (!in_array(@$sMail, @$aEmailId)) {
                                foreach ($aListId as $sListID) {
                                    $sListName = $objMList->getListNameByID($sListID);
                                    //echo "List Name$sListName <br>";
                                    $aAllDetails = $objCList->getAllDetails($sListName);
                                    // print_r($aAllDetails);
                                    foreach ($aAllDetails as $sDetail) {
                                        if ($sDetail == $sMail) {
                                            //  echo "Email exist in $sListName list and List id is $sListID<br>";
                                            $sListID1 = $sListID;
                                            break;
                                        }
                                    }
                                }
                            } else {
                                $sListID1 = 0;
                            }
                            $aPCL = array();
                            $aPCL['cm_id'] = $aCampaignDetails['cm_id'];
                            @$aPCL['list_id'] = $sListID1;
                            $aPCL['process_date'] = $aDate[$k]; /////////
                            $aPCL['process_id'] = $aCampaignDetails['pid'];
                            $aPCL['user_id'] = $sUserID;
                            $aPCL['user_email'] = $sMail;
                            $aPCL['mail_status'] = '0'; ////////////
                            $aPCL['mail_date'] = date('Y-m-d H:i:s'); /////////
                            //$aPCL['mobile'] = $sMobileNum;
                            $UnSub = false;
                            foreach ($aUSUsersMails as $aEmail) {
                                if ($aEmail['mail_id'] == $sMail) {
                                    $UnSub = true;
                                    break;
                                }
                            }
                            if (!$UnSub) {
                                if ($aDate[$k] == date('Y-m-d')) {
                                    $user_id = $sUserID;
                                    $to_mail = $sMail;
                                    $userIndividual = $objCList->getUserDetailsByTable($to_mail, $MainMergeTableName);
                                    $result = sendMailT($cm_name, $mapDetails, $pid, $pid_autoId, $cm_id, $cm_content, $user_id, $to_mail, $userIndividual,$cm_subject);
                                    if ($result == 1) {
                                        $aPCL['mail_status'] = '1';
                                    }
                                }
                                $objCList->insertProccessCampaignList($aPCL);
                            }
                        }
                    }
                }
            }

            
        } else {
            $sMsg = $objMessages->errorIndication($moduleLabel, $action);
        }
        include("layouts/dashboard.html");
        break;
    default:
        $aCampaignDetails = $objCList->getProcessCampaignMainById($id);
        // echo "<pre>";
        // echo "ID is $id<br>";
        // print_r($aCampaignDetails);
        $tablename = $aCampaignDetails['TableName'];
        $mapping_status = $aCampaignDetails['mapping_status'];
        $sCamapignID = $aCampaignDetails['cm_id'];
        $columnNames = $objCList->getColumnNames($tablename);
        $campaignContent = $objCList->getCampaignContent($sCamapignID);
        $identifiersCM = $objCmanager->getIdentifiersFromTemplate($campaignContent);

        if (strpos(@$campaignContent[0]['campaign_content'], SPECIAL_IMAGE_CON) != false) {
            $datediff = strtotime($aCampaignDetails['end_date']) - strtotime($aCampaignDetails['start_date']);
            $iDays = floor($datediff / (60 * 60 * 24)) + 1;

            //  echo "efhejkf$iDays";
        }
        /* List the events  */
        include("layouts/mapcampaign.html");
}

//$start = strtotime('2014-08-01');
//$end = strtotime('2014-08-31');

function numWeekdays($start_ts, $end_ts, $day, $include_start_end = false) {
    $aDates = array();
    $days = 0;
    $day = strtolower($day);
    $current_ts = $start_ts;
    // loop next $day until timestamp past $end_ts
    while ($current_ts < $end_ts) {

        if (( $current_ts = strtotime('next ' . $day, $current_ts) ) < $end_ts) {
            array_push($aDates, date('Y-m-d', $current_ts));
            $days++;
        }
    }

    // include start/end days
    if ($include_start_end) {
        if (strtolower(date('l', $start_ts)) == $day) {
            array_push($aDates, date('Y-m-d', $start_ts));
            $days++;
        }
        if (strtolower(date('l', $end_ts)) == $day) {
            array_push($aDates, date('Y-m-d', $end_ts));
            $days++;
        }
    }
    $aResult = array($days, $aDates);
    return $aResult;
}

function sendMailT($cm_name, $mapDetails, $pid1, $pid, $cm_id, $cm_content, $user_id, $to_mail, $userIndividual,$cm_subject) {
    global $objCList, $logininfo;
   
    $bodyOfHtml = html_entity_decode($cm_content);
    //getting the Image paath
    $sDate = date('Y-m-d');
   

    $aSpecialImage = $objCList->getSpecialImageByPid($pid1, $sDate);

    if (@$aSpecialImage['path'] != '') {
        $sImagePath = $aSpecialImage['path'];
       
        $sRp = "<img src='" . $sImagePath . "' alt='Special Image'>";
        $bodyOfHtml = str_replace(SPECIAL_IMAGE_CON, $sRp, $bodyOfHtml);
       
    }

    //////////////////////////////////////////////////////////////
    // $objCList->updateMailStatus('1', date("Y-m-d H:i:s"), $pid1, $user_id);
    foreach ($mapDetails as $map) {
        $identifier = $map['identifier'];
        $newMapValue = $map['map_value'];
        $linkNumber = $map['id'];
       

        if (strlen($identifier) > 4 && (substr_compare($identifier, "http", 0, 4) === 0)) {
            $realvalue = TRACKING_URL . "/CampaignManager.php?uid=" . $user_id .
                    "&lnm=" . $linkNumber . "&customer_id=" . $logininfo["customer_id"] . "&cmid=" . $cm_id . "&tid=" . $pid;
        } else {
            @$realvalue = $userIndividual[0][$newMapValue];
        }


        $bodyOfHtml = stripcslashes($bodyOfHtml);
        //$bodyOfHtml = str_replace("\\\"", "", $bodyOfHtml);
        $bodyOfHtml = str_replace($identifier, $realvalue, $bodyOfHtml);
    }
    $bodyOfHtml = str_replace("/cmfiles_" . $logininfo["customer_id"] . "/", SITE_URL . "/cmfiles_" . $logininfo["customer_id"] . "/", $bodyOfHtml);

    $from = SENDER_EMAIL;
    $replyTo = REPLY_EMAIL;
   
    $subject = SITE_NAME . " | ".$cm_subject ."(".$pid1.")";    

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "From: $from\r\n";
    $headers .= "Reply-To: $replyTo\r\n";
    $headers .= "Return-Path: $from\r\n" . "X-Mailer: php\r\n";
    $headers .= "Return-Receipt-To: $from\r\n";
    $headers .= "X-Confirm-Reading-To: $from\r\n";
    //$headers .= "X-MSMail-Priority: High\r\n";
    //$headers .= "Importance: High\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "Disposition-Notification-To:$from";
   
    $r = mail($to_mail, $subject, $bodyOfHtml, $headers);
	
    $sMailStatus = '1';
    $objCList->updateMailStatusByUID($sMailStatus, date('Y-m-d H:i:s'), $pid1, $user_id, date('Y-m-d'));
    $sPriority = '0';
    $sPDate = date('Y-m-d');
   
    $objCList->updateMailPriority($sPriority, $pid1, $user_id, $sPDate);
    return $r;
}

?>