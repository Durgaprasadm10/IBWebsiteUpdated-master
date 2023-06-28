<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 15/04/2014                                      *
 * Created By : Mahendra Akula                                          *
 * Vision : Project Infofam                                       *  
 * Modified by : Mahendra A    Date : 09/05/2014    Version : V1   *
 * Description : Campaign management                                 *
 * *************************************************************** */

include("includes/header.inc.php");
include("classes/listuser.class.php");
include("classes/list.class.php");
$objMessages = new Messages();
$objCList = new CList();
$objMList = new MList();

$searchstring = "";
$start_limit = 0;
$moduleLabel = "User";
@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];
    
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
else    $page = 1;



@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
//echo @$action;
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];
//@$listname = (isset($_GET['listname'])) ? $_GET['listname'] : $_POST['listname'];
//echo "List Name" . @$listname;
@$list_id = (isset($_GET['list'])) ? $_GET['list'] : $_POST['list'];
if (isset($list_id)) {
    // echo "ID id : $list_id<br>";
    $listname = $objMList->getListNameByID($list_id);
    // echo ":Lsitist $listname<br>";
}
@$user_type = (isset($_GET['hiddentype'])) ? $_GET['hiddentype'] : $_POST['hiddentype'];

$searchstring .= "action=view";
$searchstring .= "&list=" . @$list_id;

switch ($action) {

    case "Add":
    case "Edit":
        /* Add and update page */
        if ($action == "Add") {
            //  echo "<pre>";
            //   print_r($_POST);
            //   echo "Debug Add user<br>";
            //  echo "<pre>";
            // print_r($_POST);
            $sMsg1 = $objCList->addUser($_POST);
        } else {
            //  echo "<pre>";
            //  print_r($_POST);
            // exit();
            $sMsg1 = $objCList->updateUser($_POST);
        }
        if ($sMsg1 == 1) {
            $sMsg = $objMessages->addupdatesucessIndication($moduleLabel, $action);
            $count = $objCList->getUserCount($listname);
            if ($count > 0) {
                $aListFields = $objCList->getColumnNames($listname);
                $aList = $objCList->getUserList($listname);
            }
            include("layouts/listuser.html");
        } else {

            if ($sMsg1 == 0)
                $sMsg = $objMessages->errorIndication($moduleLabel, $action);
            if ($sMsg1 == 2)
                $sMsg = $objMessages->duplicateIndication($moduleLabel);

            if ($action == "Edit") {
                // echo $id;
                $aUserData = $objCList->getUserById($listname, $id);
                //  print_r($aUserData);
            }
            $count1 = $objMList->getListCount($listname);
            if ($count1 > 0) {
                $aListData = $objMList->getList($listname);
            }
            include("layouts/forms/listuser.html");
        }
        break;

    //echo "<pre>";
    // echo "  User Details <br>";
    // print_r($aFields);
    // print_r($aData);
    // exit();
    case "addForm":
        $aFields = $objCList->getColumnNames($listname);
        // echo "<pre>";
        // print_r($aFields);
        array_shift($aFields);
        // @$aFields = array_keys(@$aUserData);
        // print_r($aFields);
        $aData = array();
        foreach ($aFields as $value) {
            array_push($aData, "");
        }
        include("layouts/forms/listuser.html");
        break;
    case "editForm":
        $aUserData = $objCList->getUserById($listname, $id);
        array_shift($aUserData);
        $aFields = array_keys($aUserData);
        $aData = array();
        foreach ($aFields as $value) {
            array_push($aData, $aUserData[$value]);
        }
        include("layouts/forms/listuser.html");
        break;
    case "delete":
        // echo "Debug<br>";
        //echo "Listbaae ".$listname;
        //  echo "<brID ".$id;
        $sMsg1 = $objCList->deleteUser($listname, $id);
        if ($sMsg1 == 1) {
            $sMsg = $objMessages->addupdatesucessIndication($moduleLabel, "delet");
        } else {
            if ($sMsg1 == 0)
                $sMsg = $objMessages->errorIndication($moduleLabel, $action);
        }
    case "view":
    default:
        /* List the events  */
        $count = $objCList->getUserCount($listname);
        if ($count > 0) {
            $aListFields = $objCList->getColumnNames($listname);
            $aList = $objCList->getUserList($listname);
        }
        include("layouts/listuser.html");
}
?>