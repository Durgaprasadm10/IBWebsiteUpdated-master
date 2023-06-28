#!/usr/bin/env php
<?php
/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 14/04/2014                                     	*
 * Created By : Haritha Rekapalli                                 	*
 * Vision : Project Infofam                                       	*  
 * Modified by : Mahendra Akula   Date : 04/06/2014    Version : I    	*
 * Description : create campaign                                  	*
 * ***************************************************************** */

@$logininfo["customer_id"] = "IBCUS1403765886";

error_reporting(E_ALL);
include "includes/headerCM.inc.php";
include "classes/campaignlist.class.php";
include "classes/list.class.php";


class SendEmails {

    function sendMails2() {

        global $objCList;

        $iProcessID = isset($_GET['pid']) ? $_GET['pid'] : '';
        if ($iProcessID != '') {
            $iUDMC = $objCList->getUndeliveredMailCount($iProcessID);
            //echo $iProcessID . '<br>';
            //echo "ffffffffffffffff$iUDMC<br>";
            if ($iUDMC > 0) {
                $aaUnDeliveredMails = $objCList->getUndeliveredMails($iProcessID);
                // echo "<pre>";
                //print_r($aaUnDeliveredMails);
                foreach ($aaUnDeliveredMails as $aUnDeliveredMails) {
                    $iCMID = $aUnDeliveredMails['cm_id'];
                    $aCMDetails = $objCList->getCampaignDetailsByID($iCMID);
                    $sCMName = $aCMDetails['campaign_name'];
                    $aPCmDetails = $objCList->getProcessCampaignMainByPId($iProcessID);
					$sCmSubject = $aPCmDetails['mail_subject'];
                    $sMergeTableName = $aPCmDetails['TableName'];
                    $mapDetails = $objCList->getMapDetailsByTable($iCMID, $sMergeTableName);
                    $iPID = $aPCmDetails['id'];
                    $process_id = $iPID;
                    $sCMContent = $aCMDetails['campaign_content'];
                    $iUID = $aUnDeliveredMails['user_id'];
                    $sEmail = $aUnDeliveredMails['user_email'];
                    $this->sendMailT($sCMName, $mapDetails, $iProcessID, $iPID, $iCMID, $sCMContent, $iUID, $sEmail, '',$sCmSubject);
                }

                //include("layouts/mailstatistics.html");
                header("Location: mailstatistics.php");
                exit();
            }
        }
        $count1 = $objCList->getPreviusDayUnsendMC();
        if (MAIL_LIMIT >= $count1 && $count1 > 0) {
            $RM = MAIL_LIMIT - $count1;
            $aUDetails1 = $objCList->getPreviusDayUnsendDetails();
            //echo "<pre>";
            // echo "sjdhvkjsdv<br>";
            // print_r($aUDetails1);
            foreach ($aUDetails1 as $aUDetails) {
                $cm_id = $aUDetails['cm_id'];

                $aCMDetails = $objCList->getCampaignDetailsByID($cm_id);

                $cm_name = $aCMDetails['campaign_name'];
                // print_r($aUDetails);
                $ID = $aUDetails['process_id'];

                $aPCmDetails = $objCList->getProcessCampaignMainByPId($ID);

                $sMergeTableName = $aPCmDetails['TableName'];

                $mapDetails = $objCList->getMapDetailsByTable($cm_id, $sMergeTableName);

                $pid1 = $aUDetails['process_id'];
                $pid = $aPCmDetails['id'];
				$sCmSubject = $aPCmDetails['mail_subject'];
                $cm_content = $aCMDetails['campaign_content'];

                $aListId = $aPCmDetails['list_id'];

                $aListIds = explode(',', $aListId);
                $user_id = $aUDetails['user_id'];
                $to_mail = $aUDetails['user_email'];
                // $userDetails = $objCList->getProcessUserDetailsByTable($sMergeTableName);
                $this->sendMailT($cm_name, $mapDetails, $pid1, $pid, $cm_id, $cm_content, $user_id, $to_mail, '',$sCmSubject);
                //$this->sendMails($c, $userDetails, $cm_name, $mapDetails, $pid1, $pid, $cm_id, $sMergeTableName, $cm_content, $aListIds);
            }
        } else {
            $RM = MAIL_LIMIT;
        }

        //Current mail process
        $iCM_R = 0;
        $iCM_S = 0;
        $aEmail = array();
        $count = $objCList->getProcessAndCampaignDetailsCount();
       // echo $count.'xdfvbj';
       // exit;
        if ($count > 0) {
            //echo "<pre>";
            //Email count for Capaign per day            
            $iCM_Email = floor($RM / $count);
            $campaignDetailsAll = $objCList->getProcessAndCampaignDetails();
            // print_r($campaignDetailsAll);
            foreach ($campaignDetailsAll as $campaignDetails) {
				
                $cm_id = $campaignDetails['cm_id'];
                $cm_name = $campaignDetails['campaign_name'];
                $cm_content = $campaignDetails['campaign_content'];
                $pid = $campaignDetails['id'];
                $pid1 = $campaignDetails['pid'];
                $sCmSubject = $campaignDetails['mail_subject'];
				
               // echo"<pre>";
                //echo $pid1;
                $userDetails = $objCList->getUserListToSendMail($pid1);
                // print_r($userDetails);
                // exit;
                $MainMergeTableName = $campaignDetails['TableName'];
                // $userDetails = $objCList->getProcessUserDetailsByTable($MainMergeTableName);
                //print_r($userDetails);
                $aListId = $campaignDetails['list_id'];
                //print_r($aListIds);
                $aListIds = explode(',', $aListId);
                $mapDetails = $objCList->getMapDetailsByTable($cm_id, $MainMergeTableName);
                //////////////////////////////
                //Deviding the Emails per day
                $iCM_Size = sizeof($userDetails);
                //echo "<pre>xfdjkg$iCM_Size<br>";
                //print_r($mapDetails);
                if ($iCM_Email > $iCM_Size) {
                    $c = $iCM_Size;
                    $iCM_R = $iCM_R + ($iCM_Email - $iCM_Size);
                    $aEmail[$pid1] = 0;
                } else {
                    if ($iCM_Email < $iCM_Size) {
                        $c = $iCM_Email;
                        $iCM_S = $iCM_S + ($iCM_Size - $iCM_Email);
                        $aEmail[$pid1] = ($iCM_Size - $iCM_Email);
                    } else {
                        $c = $iCM_Email;
                        $aEmail[$pid1] = 0;
                    }
                }

                $this->sendMails($c, $userDetails, $cm_name, $mapDetails, $pid1, $pid, $cm_id, $MainMergeTableName, $cm_content, $aListIds,$sCmSubject);
            }
            // echo $iCM_S . ' --- ' . $iCM_R . '<br>';
            while (true) {
                if ($iCM_S > 0 && $iCM_R > 0) {
                    // echo "Executing : secong time <br>";
                    //echo "Number of Remainig : $iCM_R and Number of Sending : $iCM_S<br>";
                    $aPids = array_keys($aEmail);
                    foreach ($aPids as $sPid) {
                        if ($aEmail[$sPid] == 0) {
                            unset($aEmail[$sPid]);
                        }
                    }

                    $iCM_Email = floor($iCM_R / sizeof($aEmail));
                    $iCM_R = 0;
                    $iCM_S = 0;
                    foreach ($campaignDetailsAll as $campaignDetails) {

                        $aEmail1 = array_keys($aEmail);
                        $pid1 = $campaignDetails['pid'];
                        foreach ($aEmail1 as $sPid) {
                            if ($pid1 == $sPid) {
                                $MainMergeTableName = $campaignDetails['TableName'];
                                //$userDetails = $objCList->getProcessUserDetailsByTable($MainMergeTableName);
                                $userDetails = $objCList->getUserListToSendMail($pid1);
                                $c = (sizeof($userDetails) - $aEmail[$sPid]);
                                for ($i = 0; $i < $c; $i++) {
                                    unset($userDetails[$i]);
                                }
                                $pid = $campaignDetails['id'];
                                $cm_id = $campaignDetails['cm_id'];
                                $aListId = $campaignDetails['list_id'];
								$sCmSubject = $campaignDetails['mail_subject'];
                                $mapDetails = $objCList->getMapDetailsByTable($campaignDetails['cm_id'], $MainMergeTableName);
                                $iCM_Size = sizeof($userDetails);
                                //echo "<pre>xfdjkg$iCM_Size<br>";
                                //print_r($mapDetails);
                                if ($iCM_Email > $iCM_Size) {
                                    $c = $iCM_Size;
                                    $iCM_R = $iCM_R + ($iCM_Email - $iCM_Size);
                                    $aEmail[$pid1] = 0;
                                } else {
                                    if ($iCM_Email < $iCM_Size) {
                                        $c = $iCM_Email;
                                        $iCM_S = $iCM_S + ($iCM_Size - $iCM_Email);
                                        $aEmail[$pid1] = ($iCM_Size - $iCM_Email);
                                    } else {
                                        $c = $iCM_Email;
                                        $aEmail[$pid1] = 0;
                                    }
                                }
                                $cm_content = $campaignDetails['campaign_content'];
                                $cm_name = $campaignDetails['campaign_name'];
                                $this->sendMails($c, $userDetails, $cm_name, $mapDetails, $pid1, $pid, $cm_id, $MainMergeTableName, $cm_content, $aListIds,$sCmSubject);
                            }
                        }
                    }
                } else {
                    break;
                }
            }
            if ($iCM_S > 0 && $iCM_R == 0) {
                $aPids = array_keys($aEmail);
                // echo "<pre>";
                // print_r($aEmail);
                // echo "**************<br>";
                //print_r($aPids);
                foreach ($aPids as $sPid) {
                    if ($aEmail[$sPid] == 0) {
                        unset($aEmail[$sPid]);
                    }
                }
                foreach ($campaignDetailsAll as $campaignDetails) {

                    $aPids = array_keys($aEmail);
                    $pid1 = $campaignDetails['pid'];

                    //print_r($aPids);
                    // echo $pid1 . '<br>';
                    foreach ($aPids as $sPid) {
                        if ($pid1 == $sPid) {
                            $MainMergeTableName = $campaignDetails['TableName'];
                            // $userDetails = $objCList->getProcessUserDetailsByTable($MainMergeTableName);
                            $userDetails = $objCList->getUserListToSendMail($pid1);
                            $c = (sizeof($userDetails) - $aEmail[$sPid]);
                            for ($i1 = 0; $i1 < $c; $i1++) {
                                unset($userDetails[$i1]);
                                // echo "8888888888888888<br>";
                            }
                            // print_r($userDetails);
                            foreach ($userDetails as $v) {
                                $sUID = $v['user_id'];
                                $sPriority = '1';
                                $sPDate = date('Y-m-d');
                                $objCList->updateMailPriority($sPriority, $sPid, $sUID, $sPDate);
                            }
                        }
                    }
                }
            }
        } else{
            echo "No campaign is scheduled on TODAY";
			}
    }

    function sendMails($c, $userDetails, $cm_name, $mapDetails, $pid1, $pid, $cm_id, $MainMergeTableName, $cm_content, $aListIds,$sCmSubject) {
        global $objCList;
		
       // echo "$c";
        // foreach ($userDetails as $aUser) {
        for ($i = 0; $i < $c; $i++) {
            $aUser = $userDetails[$i];
            $user_id = $aUser['user_id'];
            $to_mail = $aUser['user_email'];
            $userIndividual = $objCList->getUserDetailsByTable($to_mail, $MainMergeTableName);
            $this->sendMailT($cm_name, $mapDetails, $pid1, $pid, $cm_id, $cm_content, $user_id, $to_mail, $userIndividual,$sCmSubject);
        }
    }

    function sendMailT($cm_name, $mapDetails, $pid1, $pid, $cm_id, $cm_content, $user_id, $to_mail, $userIndividual,$sCmSubject) {
	
        global $objCList, $logininfo;
        //echo "*888---------";
        $bodyOfHtml = html_entity_decode($cm_content);
         //getting the Image paath
                $sDate = date('Y-m-d');
                // echo $sDate;
                // echo $pid;
              
                $aSpecialImage = $objCList->getSpecialImageByPid($pid1, $sDate);
                // print_r($aSpecialImage);
                 //exit;
                if (@$aSpecialImage['path'] != '') {
                    $sImagePath = $aSpecialImage['path'];
                   // echo $sImagePath . '<br>';
                   // echo $bodyOfHtml . '<br>';
                    $sRp = "<img src='" . $sImagePath . "' alt='Special Image'>";
                    $bodyOfHtml = str_replace(SPECIAL_IMAGE_CON, $sRp, $bodyOfHtml);
                    //echo $bodyOfHtml . '<br>';
                }

        //////////////////////////////////////////////////////////////
        // $objCList->updateMailStatus('1', date("Y-m-d H:i:s"), $pid1, $user_id);
        foreach ($mapDetails as $map) {
            $identifier = $map['identifier'];
            $newMapValue = $map['map_value'];
            $linkNumber = $map['id'];
            // echo "<pre>";
            // echo "Length ofIdentifier  and Identifie ".strlen($identifier)." ** $identifier<br>";

            if (strlen($identifier) > 4 && (substr_compare($identifier, "http", 0, 4) === 0)) {
                $realvalue = TRACKING_URL . "/CampaignManager.php?uid=" . $user_id .
                        "&lnm=" . $linkNumber . "&customer_id=" . $logininfo["customer_id"] . "&cmid=" . $cm_id . "&tid=" . $pid;
            } else {
                // echo "<pre>";
                // print_r($userIndividual);
                // exit;
                //  echo $newMapValue.'<br>';
                // echo "Else :".$userIndividual[0][$newMapValue].'<br>';
                @$realvalue = $userIndividual[0][$newMapValue];
            }
//exit;

            $bodyOfHtml = stripcslashes($bodyOfHtml);
            //$bodyOfHtml = str_replace("\\\"", "", $bodyOfHtml);
            $bodyOfHtml = str_replace($identifier, $realvalue, $bodyOfHtml);
        }
        $bodyOfHtml = str_replace("/cmfiles_" . $logininfo["customer_id"] . "/", SITE_URL . "/cmfiles_" . $logininfo["customer_id"] . "/", $bodyOfHtml);

        $from = SENDER_EMAIL;
        $replyTo = REPLY_EMAIL;
       // $subject = SITE_NAME . " | CampaignManager | " . $cm_name . "(" . $pid1 . ")";
		$subject = SITE_NAME . " | ".$sCmSubject ."(".$pid1.")";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "From: $from\r\n";
        $headers .= "Reply-To: $replyTo\r\n";
        $headers .= "Return-Path: $from\r\n" . "X-Mailer: php\r\n";
        $headers .= "Return-Receipt-To: $from\r\n";
        $headers .= "X-Confirm-Reading-To: $from\r\n";
        $headers .= "X-MSMail-Priority: High\r\n";
        $headers .= "Importance: High\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "Disposition-Notification-To:$from";
        // echo "**************************************************************<br/>";
        // echo $bodyOfHtml . "<br/>";
        // echo $to_mail . "<br/>";
        // echo $subject . "<br/>";
        //  echo "**************************************************************<br/>";
        //echo $to_mail . '<br>';
       // $to_mail = 'mahendra.akula@ideabytes.com';
        $r = mail($to_mail, $subject, $bodyOfHtml, $headers);
        $sMailStatus = '1';
        $objCList->updateMailStatusByUID($sMailStatus, date('Y-m-d H:i:s'), $pid1, $user_id, date('Y-m-d'));
        $sPriority = '0';
        $sPDate = date('Y-m-d');
        //  echo "**************<br>";
        $objCList->updateMailPriority($sPriority, $pid1, $user_id, $sPDate);
    }

}

$objCList = new CList();
$objMList = new MList();
$objSendMail = new SendEmails();
$objSendMail->sendMails2();
?>