<?php

// content="text/plain; charset=utf-8"
include("includes/headerCM.inc.php");
include("classes/campaignlist.class.php");
require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_bar.php');

@$sStartDate = (isset($_GET['start_date'])) ? $_GET['start_date'] : $_POST['start_date'];
@$sEndDate = (isset($_GET['end_date'])) ? $_GET['end_date'] : $_POST['end_date'];
@$sSD = (isset($_GET['sd'])) ? $_GET['sd'] : $_POST['sd'];
@$sED = (isset($_GET['ed'])) ? $_GET['ed'] : $_POST['ed'];

$objCList = new CList();
//Campiagn Details 
$aCmList = array();
$aSent = array();
$aReadRecepients = array();
$aUndelivered = array();
$aTickPosition = array();
//echo "<pre>";
//print_r($_POST);
if (isset($sSD) && @$sSD != '') {
    @$sStartDate = date('Y-m-d', $sSD);
}
if (isset($sED) && @$sED != '') {
    @$sEndDate = date('Y-m-d', $sED);
}
foreach ($objCList->getProcessCampaignListByDateRange($sStartDate, $sEndDate) as $aCM) {
    // array_push($aCmList, $aCM['campaign_name'] . '(' . $aCM['pid'] . ')');
    array_push($aCmList, $aCM['campaign_name']);
    $iSentMails = $objCList->getMailCountByStatus($aCM['pid'], '1');
    array_push($aSent, $iSentMails);
    $iReadRecepients = $objCList->getMailCountByStatus($aCM['pid'], '3');
    array_push($aReadRecepients, $iReadRecepients);
    $iUndelivered = $objCList->getMailCountByStatus($aCM['pid'], '4');
    array_push($aUndelivered, $iUndelivered);
}

$iMaxSent = @max($aSent);
$iTick = round($iMaxSent / 10);
$i = 0;
if ($iTick == 0)
    $iTick = 1;

while ($i <= ($iMaxSent + $iTick)) {
    @array_push($aTickPosition, $i);
    $i += $iTick;
}

// Create the graph. These two calls are always required
try {
    $graph = new Graph(800, 600, 'auto');
    $graph->SetScale("textlin");

    $theme_class = new UniversalTheme;
    $graph->SetTheme($theme_class);

    $graph->yaxis->SetTickPositions($aTickPosition);
    $graph->SetBox(false);

    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($aCmList);
    $graph->xaxis->SetLabelAngle(30);
//$graph->xaxis->SetTickLabels(array('Campaign 1', 'Campaign 2', 'Campaign 3', 'Campaign 4'));
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false, false);

// Create the bar plots
    $b1plot = new BarPlot($aSent);
    $b2plot = new BarPlot($aReadRecepients);
    $b3plot = new BarPlot($aUndelivered);

// Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot, $b2plot, $b3plot));
// ...and add it to the graPH
    $graph->Add($gbplot);

//Legend::SetPos($aX,$aY,$aHAlign='right',$aVAlign='top');
    $graph->legend->SetFrameWeight(1);
    $graph->legend->SetColumns(3);
    $graph->legend->SetColor('#4E4E4E', '#00A78A');
    $graph->legend->Pos(0.005, 0.1, "right", "center");

    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#0000CD");
    $b1plot->SetLegend("Sent");

    $b2plot->SetColor("white");
    $b2plot->SetFillColor("#66FF33");
    $b2plot->SetLegend("Read Recipients");

    $b3plot->SetColor("white");
    $b3plot->SetFillColor("#cc1111");
    $b3plot->SetLegend("Un Delivered");

    $graph->title->Set("Mail Statistics");

// Display the graph
    $gdImgHandler = $graph->Stroke(_IMG_HANDLER);

    $fileName = "imagefile.png";

    $graph->img->Stream($fileName);
    $count = sizeof($aCmList);
} catch (Exception $e) {
    $fileName = "./layouts/images/nodata.png";
}
include 'layouts/mailstatistics_graph_ns.html';
?>