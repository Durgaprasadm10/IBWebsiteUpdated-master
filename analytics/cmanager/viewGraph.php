<?php

include("includes/header.inc.php");
include("classes/campaignlist.class.php");
include("classes/campaignmanager.class.php");
//include("classes/HitRateGraph.php");



$moduleLabel = "Campaign ";
$objMessages = new Messages();
$objCList = new CList();
$objCmanager = new CManager();
//$hitRateGraph = new HitRateGraph();

$searchstring = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);


@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$pid = (isset($_GET['pid'])) ? $_GET['pid'] : $_POST['pid'];
//echo @$pid;
@$month = (isset($_GET['month'])) ? $_GET['month'] : $_POST['month'];
//echo @$month;
switch ($action) {
    //case "viewGraph":


    default:
        //echo 's,dvmn'.$pid;

        $count = $objCList->getProcessCampaignMainListCount1();
        // echo "$count<br>";
        if ($count > 0) {
            $aPMList = $objCList->getProcessCampaignMainList1();
        }
        include("layouts/viewgraph.html");
}
?>