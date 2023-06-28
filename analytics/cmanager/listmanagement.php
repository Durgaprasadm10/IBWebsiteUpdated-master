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
include("classes/list.class.php");
include("classes/listuser.class.php");

$objMessages = new Messages();
$objCList = new CList();
$objMList = new MList();

$searchstring = "";
$start_limit = 0;

$moduleLabel = "List";

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];

if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
else
    $page = 1;



@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];

switch ($action) {
    case "Add":
    case "Edit":
        /* Add and update page */
        if ($action == "Add") {
            @$csvFile = 'uploads/' . @$_FILES["userfile"]["name"];
            $aExten = explode('.', $csvFile);
            $sExten = $aExten[sizeof($aExten) - 1];

            if (@move_uploaded_file($_FILES['userfile']['tmp_name'], $csvFile)) {			
                if (in_array($sExten, array('csv', 'CSV'))) {
					
                    $file_handle = fopen($csvFile, 'r');
                    while (!feof($file_handle)) {
                        $data[] = fgetcsv($file_handle, 1024);
                    }

                    fclose($file_handle);
                    if (unlink(@$csvFile)) {
                        // echo "File Deleted Successfully<br>";
                    } 					
                    $sListName = $_POST['list_name'];
                    if (!$objCList->showTable($sListName)) {
                        $sMsg1 = $objCList->uploadfile($data, $sListName);
                        if ($sMsg1 == 1) {
                            $sMsg1 = $objMList->addList($_POST);
                        }						
                    } else {
                        $sMsg1 = 2;
                    }
                    // $sMsg1 = 1;
                } else {					
                    $sMsg1 = 0;
                }
            } else {
                // echo "Debug<br>";
                $sListName = $_POST['list_name'];
                //echo $sListName;
                if (!$objCList->showTable($sListName)) {
                    //cho "kdfjkgdf<br>";
                    $sMsg1 = $objCList->createListTable($sListName);
                } else {
                    //  echo "Duplicate<br>";
                    $sMsg1 = 2;
                }
                if ($sMsg1 == 1) {
                    $sMsg1 = $objMList->addList($_POST);
                }
            }
        } else {
            $sMsg1 = $objMList->updateList($_POST);
            $sNewName = $_POST['list_name'];
            $sOldName = $_POST['old_name'];
            if ($sMsg1 == 1) {
                $sMsg1 = $objCList->rename($sNewName, $sOldName);
            }
        }        
        if (@$sMsg1 == 1) {
            $sMsg = $objMessages->addupdatesucessIndication($moduleLabel, $action);
        } else {
            if (@$sMsg1 == 0)
                $sMsg = $objMessages->errorIndication($moduleLabel, $action);
            if (@$sMsg1 == 2)
                $sMsg = $objMessages->duplicateIndication($moduleLabel);
        }
        $count = $objMList->getListCount();
        if ($count > 0) {
            $eventList = $objMList->getList();
        }
        include("layouts/list.html");
        break;
    case "editForm":
        $eventData = $objMList->getListById($id);

    case "addForm":
        /* Showing form for Add Page */
        $count = $objMList->getListCount();
        if ($count > 0) {
            $eventList = $objMList->getList();
        }
        include("layouts/forms/list.html");
        break;
    case "delete":
        $action1 = "Delet";
        if (isset($id)) {
            $listname = $objMList->getListNameByID($id);
            // echo "Table na,e :$listname<br>";
            $objCList->dropTable($listname);
            $sMsg1 = $objMList->deleteList($id);
        }
        if ($sMsg1 == 1) {
            $sMsg = $objMessages->addupdatesucessIndication($moduleLabel, $action1);
        } else {
            if ($sMsg1 == 0)
                $sMsg = $objMessages->errorIndication($moduleLabel, $action1);
        }
        $count = $objMList->getListCount();
        if ($count > 0) {
            $eventList = $objMList->getList();
        }
        include("layouts/list.html");
        break;
    default:
        /* List the events  */
        $count = $objMList->getListCount();
        if ($count > 0) {
            $eventList = $objMList->getList();
        }
        include("layouts/list.html");
}
?>