<?php

$logininfo["customer_id"] = "IBCUS1406875026";
include("classes/campaignlist.class.php");
include ("includes/headerCM.inc.php");

class MailTracking {

    function getAllMailsStatus($sPid) {
        // ini_set('max_execution_time', 300);
        //$mbox = imap_open("{pod51021.outlook.com}INBOX", "cmmanager@ideabytes.com", "Ideabytes1!")
        //        or die("Can't connect: " . imap_last_error());
        // echo "Executing the Mail Tracking ".  time()."<br>";
        //$mbox = imap_open("{p3plcpnl0104.prod.phx3.secureserver.net:993}INBOX", "cm@infofam.com", "Jump4Life!")
        //or die("Can't connect: " . imap_last_error());
        $mbox = imap_open(IMAP_URL, IMAP_USERNAME, IMAP_PASSWORD)or die("Can't connect: " . imap_last_error());
        // $mbox = imap_open("{ideabytes.secureserver.net:993/novalidate-cert/imap/ssl}", 'cmanager@cm.ideabytes.com', "cmanager")or die("Can't connect: " . imap_last_error());
        $c_total = imap_num_msg($mbox);
        $bouncedMails = array();
        $deliveredMails = array();
        $readreceiptMails = array();
        for ($x = 1; $x <= $c_total; $x++) {

            @$header = imap_header($mbox, $x);
            $subject = strip_tags(@$header->subject);
            @$body = imap_fetchbody($mbox, $x, "1");
            $mailC = "";

            $time = date("Y-m-d H:i:s", $header->udate);
            $sCmid = substr($subject, strpos($subject, "(") + 1, (strpos($subject, ")") - strpos($subject, "(")) - 1);
            if ($sPid == $sCmid) {
                // if (true) {
                // echo "Body $body<br>";
                if (strpos($subject, "Undeliverable:") !== false) {
                    //var_dump($header);
                    //  echo '<br>************<br>';
                    //$mailC = substr($body, strripos($body,'To: &lt;'),strlen($body));                    
                    $mailC = substr($body, strpos($body, 'To: &lt;'), strlen($body));

                    $mail = substr($mailC, (strpos($mailC, '&lt;') + 4), (strpos($mailC, '&gt;') - 8));
//                         echo $mailC.'<br>';
//                         exit;
//                    $mailC = substr($mailC, 0, strripos($mailC, 'Subject: '));
//                    // echo $mailC.'<br>';
//                    $mailC = substr($mailC, 0, strpos($mailC, '&gt;'));
//                    $mailC = htmlentities($mailC);
//                   
//                    $mailC = substr($mailC, 8);
//                   // echo $mailC.'<br>';
//                    $mail = substr($mailC, 0, strpos($mailC, '&'));
                    // echo $mail;
                   // echo $mail . ' Undelivers<br>';
                    array_push($bouncedMails, $mail . '::' . $time);
                    imap_delete($mbox, $x);
                    imap_expunge($mbox);
                }

                if (strpos($subject, "Delivered:") !== false) {
                    foreach ($header->to as $obj) {
                        $read_recepent = $obj->mailbox . '@' . $obj->host;
                    }
                    //echo $read_recepent . ' Del;ivered<br>';
                    array_push($deliveredMails, $read_recepent . '::' . $time);
                    imap_delete($mbox, $x);
                    imap_expunge($mbox);
                }

                if (strpos($subject, "Read:") !== false) {
                    foreach ($header->from as $obj) {
                        $read_recepent = $obj->mailbox . '@' . $obj->host;
                    }
                   // echo $read_recepent . ' Read Receipents<br>';
                    array_push($readreceiptMails, $read_recepent . '::' . $time);

                    imap_delete($mbox, $x);
                    imap_expunge($mbox);

                    //        if (strpos($body, "Sent:") != false) {
                    //            $x1 = strpos($body, "Sent:") + strlen("Sent:");
                    //            $y = strpos($body, "was read on");
                    //            $z = $y + strlen("was read on");
                    //             echo "Sent Time is : " . substr($body, $x1, $y - $x1) . "<br>";
                    //             echo "Read Time is : " . substr($body, $z) . "<br>";
                    //        }
                }
            }
            // imap_delete($mbox, $x);
        }
        imap_close($mbox);
        $aMailStatus = array('bounced' => $bouncedMails, 'delivered' => $deliveredMails, 'readreceipt' => $readreceiptMails);
        return $aMailStatus;
    }

    function update($aMails, $sStatus, $pid) {
        // print_r($aMails);
        $objCL = new CList();
        foreach ($aMails as $sValue) {
            //  echo "Executing<br>";
            $aT = explode("::", $sValue);
            $sEmail = $aT[0];
            $sTime = $aT[1];
            $sPDate = date('Y-m-d');
            $objCL->updateMailStatusByEmail($sStatus, $sTime, $pid, $sEmail, $sPDate);
        }
    }

    function updateMailStatus() {
        $objCL = new CList();

        $count = $objCL->getProcessCampaignMainListCount1();
        //  echo "<pre><br>Count $count<br>";
        // echo "Count is : $count<br>";
        if ($count > 0) {
            $Ids = $objCL->getProcessCampaignPIds();
            ///echo "<pre>";
            // print_r($Ids);
            // exit;
            foreach ($Ids as $iId) {
                $pid = $iId['pid'];
                $aMailStatus = $this->getAllMailsStatus($pid);
                $bouncedMails = $aMailStatus['bounced'];
                $deliveredMails = $aMailStatus['delivered'];
                $readreceiptMails = $aMailStatus['readreceipt'];
                // print_r($aMailStatus);
                // print_r($bouncedMails);
                // print_r($deliveredMails);
//                    print_r($readreceiptMails);
//                    exit;
                $sStatus = 2; //for Delivered mail
                $this->update($deliveredMails, $sStatus, $pid);
                $sStatus = 3; //for Read mail
                $this->update($readreceiptMails, $sStatus, $pid);
                $sStatus = 4; //for Bounsed mail
                $this->update($bouncedMails, $sStatus, $pid);
            }
        }
    }

}

$obj = new MailTracking();
$obj->updateMailStatus();
?>