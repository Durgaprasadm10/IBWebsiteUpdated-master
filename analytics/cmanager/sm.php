<?php

include 'sendsms.php';
include("classes/campaignlist.class.php");
include("includes/header.inc.php");
class SendSMSSingle {

    function sendSMS($sPhone, $sSMSContent) {
        // $contactNumber = "9550639689";
        //$msg = "hi";
        $sendsms = new sendsms("http://alerts.sinfini.com/api/web2sms.php", "14135c6k7z832796cv9s", "QEZYTV");
        $s = $sendsms->send_sms($sPhone, $sSMSContent);


        /* sleep(10);
          //header('Location: http://alerts.sinfini.com/api/status.php?workingkey=14135c6k7z832796cv9s&messageid='.$msgId);
          $url = 'http://alerts.sinfini.com/api/status.php?workingkey=14135c6k7z832796cv9s&type=json
          &messageid='.$msgId;
          $out = file_get_contents($url);

          $reportArray = explode("\n",$out);

          //print_r($reportArray);

          echo "msg id=".$reportArray[0]."<br>";
          echo "mobile number=".$reportArray[1]."<br>";
          echo "status=".$reportArray[2];
          $objUser->downloadReport($pingip,"Power OK",$resetNumber,$reportArray[0],$reportArray[2],$imei,"R2RESET",$now); */
//http://alerts.sinfini.com/api/status.php?workingkey=14135c6k7z832796cv9s&messageid=597152322-1
        return $s;
    }

    function sendSMSs() {
        $objCList = new CList();
        $count = $objCList->getProcessAndCampaignDetailsCount();
       
        if ($count > 0) {
           
            $campaignDetailsAll = $objCList->getProcessAndCampaignDetails();
           // echo "<pre>";
           //  print_r($campaignDetailsAll);
            foreach ($campaignDetailsAll as $campaignDetails) {
                
                $sPID = $campaignDetails['pid'];
                $aUsersDetails = $objCList->getUserListToSendSMS($sPID);
               // print_r($aUsersDetails);
                foreach ($aUsersDetails as $aUserDetails) {
                     echo "<pre>";
                     print_r($aUserDetails);
                    $sMobileNum = $aUserDetails['phone_number'];

                    // Sending SMS for Single User
                    $sSMSContent = "Hai Mahendra";
                    echo "Mobile Number : $sMobileNum<br>";
                    $this->sendSMS($sMobileNum, $sSMSContent);
                }
            }
        }
    }

}

$oSMS = new SendSMSSingle();
$oSMS->sendSMSs();
?>
