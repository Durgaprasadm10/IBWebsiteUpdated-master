<?php

include("includes/header.inc.php");
include("classes/campaignlist.class.php");
include("classes/campaignmanager.class.php");
include("classes/HitRateGraph.php");

$moduleLabel = "Campaign ";
$objMessages = new Messages();
$objCList = new CList();
$objCmanager = new CManager();
$hitRateGraph = new HitRateGraph();

$searchstring = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);


@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
//echo "Action is $action<br>";
@$cm_name = (isset($_GET['cm_name'])) ? $_GET['cm_name'] : $_POST['cm_name'];
//echo "CampaignName is $cm_name<br>";
@$month = (isset($_GET['month'])) ? $_GET['month'] : $_POST['month'];
$ydata = array();
$xdata = array();

switch ($action) {
    case "viewGraph":
        $count = $objCList->countVisitorTrackByCampaignName($cm_name);
        if ($count > 0) {
            if ($month == "SelectMonth" || $month == "All") {
                $HitCount = $objCList->getHitCountAll($cm_name);
				foreach($HitCount as $hit)
				{
					$xdata[] = @$hit['groupDate'];
					$ydata[] = @$hit['hitcount'];
				}
			} else {
                $HitCount = $objCList->getHitCount($cm_name, $month);
				foreach($HitCount as $hit)
				{
					$xdata[] = @$hit['groupDate'];
					$ydata[] = @$hit['hitcount'];
				}
            }
        }

    default:
        $campaign_names = $objCList->getCampaignList();
        include("layouts/viewgraph.html");
}
?>