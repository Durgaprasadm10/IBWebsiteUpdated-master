<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 14/04/2014                                     	*
 * Created By : Haritha Rekapalli                                 	*
 * Vision : Project Infofam                                       	*  
 * Modified by : Mahendra A    Date : 19/05/2014    Version : I    	*
 * Description : create campaign                                  	*
 * ***************************************************************** */

include("includes/header.inc.php");
include("classes/campaignlist.class.php");
include("classes/list.class.php");
$objMessages = new Messages();
$objCList = new CList();
$objMList = new MList();
$moduleLabel = "Campaign Process";
$searchstring = "";
$start_limit = 0;
//print_r($_POST);
@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);


@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];

@$user_list = $_POST['user_list'];
@$campaign_list = $_POST['campaign_list'];
$sCampaignName = $objCList->getCampaignNameByID($campaign_list);
$campaign_name = $sCampaignName['campaign_name'];
@$campaign_from_date = $_POST['campaign_from_date'];
@$campaign_to_date = $_POST['campaign_to_date'];

switch ($action) {
    case "merge_tables":
        $aTemp = $_POST;
        $sTable1 = $aTemp['table1'];
        $sTable2 = $aTemp['table2'];
        unset($aTemp['action']);
        $aListName = NULL;
        $aListName = array();
        for ($i = 1; $i < sizeof($aTemp); $i++) {
            if ($i > 2) {
                if (@$aTemp['table' . $i] != "") {
                    array_push($aListName, @$aTemp['table' . $i]);
                }
            }
            unset($aTemp['table' . $i]);
        }
        $aTS = array_keys($aTemp);

        $aTable2 = array();
        $aTable1 = array();
        $aTable1_Extra = array();
        $b2 = false;
        $b1 = false;
        foreach ($aTS as $sT) {
            $b1 = strpos($sT, 'text');
            $b2 = strpos($sT, 'select');
            $aT = explode('_', $sT);
            if ($aT[0] == '') {
                $b = strpos($sT, 'text');
                if ($b != false) {
                    array_push($aTable1_Extra, $sT);
                }
            }
            if ($b1 != false) {
                $b1 = false;
                array_push($aTable1, $aTemp[$sT]);
            }
            if ($b2 != false) {
                $b2 = false;
                array_push($aTable2, $aTemp[$sT]);
            }
        }
        $aTable2Selected = array();
        foreach ($aTable2 as $value) {
            if ($value != "Select Field") {
                array_push($aTable2Selected, $value);
            }
        }
        $aTable2Unselected = array();
        $uns_keys = array_keys($aTable2, "Select Field");
        $sMainTableName = $_POST['tablename'];
        $bTExists = $objCList->showTable($sMainTableName);

        if ($bTExists) {

            $aMainList = $objCList->getColumnNames($sMainTableName);
            foreach ($aTable1 as $value) {
                if (!in_array($value, $aMainList)) {

                    $objCList->alterTable($sMainTableName, $value);
                }
            }

            if (sizeof($uns_keys) != 0) {
                $aTable2Fields = $objCList->getColumnNames($sTable2);
                $aMainList1 = $objCList->getColumnNames($sTable1);
                foreach ($uns_keys as $value) {
                    $sF = $aMainList1[$value];
                    unset($aMainList1[$value]);
                    unset($aTable2Fields[$value]);
                }
                if (sizeof($aMainList1) == sizeof($aTable2Selected)) {
                    if (sizeof($aMainList1) == 0 && sizeof($aTable2Fields) == 0) {
                        $sProcessCampaignMainID = $_POST['pm_id'];
                        $aTable2 = $objCList->getColumnNames($sTable2);
                        //  echo "Please select atleast one value<br>";
                        $sMsg = $objMessages->errorIndication(" Maping, Please Map atleast Email field", "");
                        include 'layouts/merge_tables.html';
                        break;
                    } else {
                        //echo "<pre>";
                       // print_r($aMainList1);
                       // echo $sMainTableName;
                       // print_r($aTable2Selected);
                        //echo $sTable2;
                        ///exit;
                        $objCList->insertTableSecond($aMainList1, $sMainTableName, $aTable2Selected, $sTable2);
                    }
                    // exit();
                } else {
                    if (sizeof($aMainList1) > sizeof($aTable2Fields)) {
                        $s = (sizeof($aMainList1) - sizeof($aTable2Fields));
                        for ($i = 0; $i < $s; $i++) {
                            $aMainList1 = array_reverse($aMainList1);
                            unset($aMainList1[$i]);
                        }
                        $aMainList1 = array_reverse($aMainList1);
                    }
                    $objCList->insertTableSecond($aMainList1, $sTable1, $aTable2Selected, $sTable2);
                }
            } else {
                $objCList->insertTableSecond($aTable1, $sMainTableName, $aTable2, $sTable2);
            }
        } else {
            echo "Table Not Exist<br>";
        }
        $aMainList = $objCList->getColumnNames($sMainTableName);
        $aTable1 = NULL;
        $aTable1 = array();
        $aTable1 = $aMainList;
        $sTable1 = $sMainTableName;

        if (sizeof($aListName) != 0) {
            $aTable2 = NULL;
            $sTable2 = $aListName[0];
            $aTable2 = $objCList->getColumnNames(@$aListName[0]);
            unset($aListName[0]);
            $sProcessCampaignMainID = $_POST['pm_id'];
            include 'layouts/merge_tables.html';
        } else {
            $sTableName = $_POST['tablename'];
            if (!empty($sTableName)) {
                $objCList->validateEmails($_POST['tablename']);
                $iEmailCount = $objCList->getEmailCount($sTableName);

                $aPIDs = $objCList->getProcessCampaignPIds();
                for ($i = 0; $i < 10; $i++) {

                    $PID = PROCESSID . mt_rand();
                    $b = false;
                    foreach ($aPIDs as $iId) {
                        $pid = $iId['pid'];
                        if ($PID == $pid) {
                            $b = true;
                        }
                    }
                    if ($b)
                        break;
                }
                $objCList->updateProcessCampaign($_POST['pm_id'], $sTableName, $iEmailCount, $PID);
            }
            include 'layouts/dashboard.html';
        }
        break;
    case "add":
        /* addForm page */
        $sMsg1 = $objCList->addProcessCampaign($_POST);
        @$aProcessCampaignMainID = $objCList->getProcessCampaignMainID($_POST);
        @$sProcessCampaignMainID = $aProcessCampaignMainID['id'];
        if ($sMsg1 != 1) {
            if ($sMsg1 != "") {
                $sMsg = $objMessages->errorIndication($moduleLabel, $action);
            }
        } else {
            
        }
    default:
        /* List the events  */
        @$aUsersList = $_REQUEST['user_list'];
        // @$sList = print_r($aUsersList, true);
        $sList = '';
        if (sizeof($aUsersList) >= 1) {
            foreach ($aUsersList as $sV) {
                // $sList .= $sV . ",";
                $sListId = $objMList->getIDByName($sV);
                // print_r($sListId);
                $sList .= $sListId['id'] . ",";
            }
        }
        $sList = substr($sList, 0, strlen($sList) - 1);
        if (!empty($sProcessCampaignMainID)) {
            $objCList->updateProcessCampaign_ListID($sProcessCampaignMainID, $sList);
        }
        if (!empty($aUsersList)) {
            $aFields = array();
            foreach ($aUsersList as $sListName) {

                $aFields[$sListName] = $objCList->getColumnNames($sListName);
            }
            $aListName = array_keys($aFields);
            $sMainTableName = '';
            if (!empty($campaign_name) && !empty($campaign_from_date) && !empty($campaign_to_date)) {
                $campaign_name = str_replace(' ', '', $campaign_name);
                $campaign_name = preg_replace('/[^A-Za-z0-9\-]/', '', $campaign_name);
                $sMainTableName = $campaign_name . '_' . $campaign_from_date . '_' . $campaign_to_date;
                $sMainTableName = str_replace("-", "", $sMainTableName);
            }
            if (sizeof(@$aUsersList) >= 1) {

                if ($objCList->showTable($sMainTableName)) {
                    $sMsg = $objMessages->duplicateIndication($moduleLabel);
                    $count = $objCList->getCampaignListCount();
                    if ($count > 0) {
                        $campaignList = $objCList->getCampaignListForSelection();
                    }
                    $usercount = $objCList->getUsersCount();
                    if ($usercount > 0) {
                        $userList = $objCList->getUsersForSelection();
                    }
                    include("layouts/processcampaign.html");
                } else {
                    if ($sMainTableName != '') {
                        $objCList->createTable($sMainTableName);
                        $sDg = DEFAULT_GROUP;
                        if(!empty($sDg)){
                        $aDefaultGroup = explode(',', DEFAULT_GROUP);
                        foreach ($aDefaultGroup as $sUserDetails) {
                            $aUserDetails = explode('#', $sUserDetails);
                            $sFname = $aUserDetails[0];
                            @$sEmailId = $aUserDetails[1];
                            $objCList->insertDafaultValues($sMainTableName, $sFname, $sEmailId);
                        }
                        }
                        $aTable1 = $objCList->getColumnNames($sMainTableName);
                        $sTable1 = $sMainTableName;
                        @$aTable2 = $aFields[$aListName[0]];
                        @$sTable2 = $aListName[0];
                        unset($aListName[0]);
                        include 'layouts/merge_tables.html';
                    } else {
                        $sMsg = $objMessages->errorIndication($moduleLabel, " Creating Merge Table ");
                        $count = $objCList->getCampaignListCount();
                        if ($count > 0) {
                            $campaignList = $objCList->getCampaignListForSelection();
                        }
                        $usercount = $objCList->getUsersCount();
                        if ($usercount > 0) {
                            $userList = $objCList->getUsersForSelection();
                        }
                        include("layouts/processcampaign.html");
                    }
                }
            } else {
                if ($objCList->showTable($sMainTableName)) {
                    $sMsg = $objMessages->duplicateIndication($moduleLabel);
                    $count = $objCList->getCampaignListCount();
                    if ($count > 0) {
                        $campaignList = $objCList->getCampaignListForSelection();
                    }
                    $usercount = $objCList->getUsersCount();
                    if ($usercount > 0) {
                        $userList = $objCList->getUsersForSelection();
                    }
                    include("layouts/processcampaign.html");
                } else {
                    $sMsg = $objMessages->errorIndication($moduleLabel, "Merging");
                    $count = $objCList->getCampaignListCount();
                    if ($count > 0) {
                        $campaignList = $objCList->getCampaignListForSelection();
                    }
                    $usercount = $objCList->getUsersCount();
                    if ($usercount > 0) {
                        $userList = $objCList->getUsersForSelection();
                    }
                    include("layouts/processcampaign.html");
                }
            }
        } else {
            $sMainTableName = @$_POST['tablename'];
            if (isset($sMainTableName)) {
                if ($objCList->showTable($sMainTableName)) {
                    $objCList->dropTable($sMainTableName);
                    $objCList->deleteUnupdatedMergeTN();
                }
            }
            $count = $objCList->getCampaignListCount();
            if ($count > 0) {
                $campaignList = $objCList->getCampaignListForSelection();
            }
            $usercount = $objCList->getUsersCount();
            if ($usercount > 0) {
                $userList = $objCList->getUsersForSelection();
            }
            include("layouts/processcampaign.html");
        }
}
?>