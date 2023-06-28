<?php

// content="text/plain; charset=utf-8"
include("includes/headerCM.inc.php");
include("classes/campaignlist.class.php");
require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_bar.php');

$objCList = new CList();
//Campiagn Details 
$aIpList = array();
$aHitCount = array();
$aTickPosition = array();

@$sStartDate = (isset($_GET['start_date'])) ? $_GET['start_date'] : $_POST['start_date'];
@$sEndDate = (isset($_GET['end_date'])) ? $_GET['end_date'] : $_POST['end_date'];
@$sSD = (isset($_GET['sd'])) ? $_GET['sd'] : $_POST['sd'];
@$sED = (isset($_GET['ed'])) ? $_GET['ed'] : $_POST['ed'];
if (isset($sSD) && @$sSD != '') {
    @$sStartDate = date('Y-m-d', $sSD);
}
if (isset($sED) && @$sED != '') {
    @$sEndDate = date('Y-m-d', $sED);
}
foreach ($objCList->getUniqIpList($sStartDate, $sEndDate) as $data) {
    array_push($aHitCount, $objCList->gethitCountByIp($data['ip_address'], $sStartDate, $sEndDate));
    array_push($aIpList, $data['ip_address']);
}
$iMaxSent = @max($aHitCount);
$iTick = round($iMaxSent / 10);

if ($iTick == 0) {
    $iTick = 1;
}
$i = 0;
while ($i <= ($iMaxSent + $iTick)) {
    @array_push($aTickPosition, $i);
    $i += $iTick;
}

// Create the graph. These two calls are always required
try {
    $x = 800;
    $y = 600;
    $graph = new Graph($x, $y, 'auto');
    $graph->SetScale("textlin");

    $theme_class = new UniversalTheme;
    $graph->SetTheme($theme_class);

    $graph->yaxis->SetTickPositions($aTickPosition);
    $graph->SetBox(false);

    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($aIpList);
    $graph->xaxis->SetLabelAngle(90);
//$graph->xaxis->SetTickLabels(array('Campaign 1', 'Campaign 2', 'Campaign 3', 'Campaign 4'));
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false, false);

// Create the bar plots
    $b1plot = new BarPlot($aHitCount);

// Create the grouped bar plot
    $gbplot = new GroupBarPlot(array($b1plot));
// ...and add it to the graPH
    $graph->Add($gbplot);

//Legend::SetPos($aX,$aY,$aHAlign='right',$aVAlign='top');
    $graph->legend->SetFrameWeight(1);
    $graph->legend->SetColumns(3);
    $graph->legend->SetColor('#4E4E4E', '#00A78A');
    $graph->legend->Pos(0.005, 0.1, "right", "center");

    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#cc1111");
    $b1plot->SetLegend("Visitors Count");

    $graph->title->Set("Visitor Statistics");

// Display the graph
    $gdImgHandler = $graph->Stroke(_IMG_HANDLER);

    $fileName = "imagefile.png";

    $graph->img->Stream($fileName);
    $count = sizeof($aIpList);
} catch (Exception $e) {
    $fileName = "./layouts/images/nodata.png";
}
include 'layouts/visitors_by_ip_ns.html';
?>