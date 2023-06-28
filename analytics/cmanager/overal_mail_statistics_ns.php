<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 25/08/2014                                     	*
 * Created By : Mahendra                               	*
 * Vision : Project Infofam                                       	*  
 * Modified by : Mahendra      Date : 27/08/2014    Version : I    	*
 * Description : View Statistics                                 	*
 * ***************************************************************** */
include("includes/headerCM.inc.php");
include("classes/campaignlist.class.php");
require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_bar.php');
require_once ('lib/jpgraph/src/jpgraph_line.php');
$moduleLabel = "Campaign ";

$searchstring = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);

@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
$sViewType = '';
@$sViewType = (isset($_GET['view_type'])) ? $_GET['view_type'] : $_POST['view_type'];
@$sStartDate = (isset($_GET['start_date'])) ? $_GET['start_date'] : $_POST['start_date'];
@$sEndDate = (isset($_GET['end_date'])) ? $_GET['end_date'] : $_POST['end_date'];
if ($sViewType == '') {
    $sViewType = 'DATE';
}
@$sSD = (isset($_GET['sd'])) ? $_GET['sd'] : $_POST['sd'];
@$sED = (isset($_GET['ed'])) ? $_GET['ed'] : $_POST['ed'];
//echo "<pre>";
//print_r($_POST);
if (isset($sSD) && @$sSD != '') {
    @$sStartDate = date('Y-m-d', $sSD);
}
if (isset($sED) && @$sED != '') {
    @$sEndDate = date('Y-m-d', $sED);
}

switch ($action) {
    //case "viewGraph":

    default:
        $objCList = new CList();
        $aStatistics = $objCList->getMailCountByStatusViewType($sViewType, $sStartDate, $sEndDate);
        $aMonth = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May',
            6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
        $aSent = array();
        $aReadRecepients = array();
        $aUndelivered = array();
        $aXaxisTicks = array();
        $aYaxisTicks = array();

        foreach ($aStatistics as $aData) {
            if ($sViewType == 'MONTH') {
                $date = $aMonth[$aData['date']] . '-' . $aData['year'];
            }
            if ($sViewType == 'DATE') {
                $date = $aData['date'];
            }
            if ($sViewType == 'WEEK') {
                $time = strtotime("1 January " . $aData['year'], time());
                $day = date('w', $time);
                $time += ((7 * $aData['date']) - $day) * 24 * 3600;
                $w1 = date('Y-n-j', $time);
                $time += 6 * 24 * 3600;
                $w2 = date('Y-n-j', $time);
                $date = $w1 . ' - ' . $w2;
            }
            if ($aData['status'] == 1) {
                $aSent[$date] = $aData['mailcount'];
            }
            if ($aData['status'] == 3) {
                $aReadRecepients[$date] = $aData['mailcount'];
            }
            if ($aData['status'] == 4) {
                $aUndelivered[$date] = $aData['mailcount'];
            }
            array_push($aXaxisTicks, $date);
            array_push($aYaxisTicks, $aData['mailcount']);
        }
        $sTickInt = 0;
        $interval = 0;
        if (isset($aYaxisTicks) && sizeof($aYaxisTicks) > 0) {
            $sTickInt = max($aYaxisTicks);
            $interval = round($sTickInt / 10);
        }
        $i = 0;
        unset($aYaxisTicks);
        $aYaxisTicks = array();
        if ($interval == 0)
            $interval = 1;
        while ($i <= ($sTickInt + $interval)) {
            array_push($aYaxisTicks, $i);
            $i += $interval;
        }
        $aXaxisTicks = array_unique($aXaxisTicks);
        sort($aXaxisTicks);
        foreach ($aXaxisTicks as $date) {
            if (!array_key_exists($date, $aSent)) {
                $aSent[$date] = 0;
            }
            if (!array_key_exists($date, $aReadRecepients)) {
                $aReadRecepients[$date] = 0;
            }
            if (!array_key_exists($date, $aUndelivered)) {
                $aUndelivered[$date] = 0;
            }
        }
        try {
            $graph = new Graph(1000, 600, 'auto');
            $graph->SetScale("textlin");

            $theme_class = new UniversalTheme;
            $graph->SetTheme($theme_class);

            $graph->yaxis->SetTickPositions($aYaxisTicks);
            $graph->SetBox(false);

            $graph->ygrid->SetFill(false);
            $graph->yaxis->HideLine(false);
            $graph->yaxis->HideTicks(false, false);
            // Setup month as labels on the X-axis
            $months = array('Jan-14', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            $graph->xaxis->SetTickLabels(array_values($aXaxisTicks));
            $graph->xaxis->SetLabelAngle(90);

            // Create the bar plots
            $b1plot = new BarPlot(array_values($aSent));
            $b2plot = new BarPlot(array_values($aReadRecepients));
            $b3plot = new BarPlot(array_values($aUndelivered));
            $gbplot = new GroupBarPlot(array($b1plot, $b2plot, $b3plot));

            // ...and add it to the graPH
            $graph->Add($gbplot);
            //$graph->AddY2($lplot);

            $b1plot->SetColor("#0000CD");
            $b1plot->SetFillColor("#0000CD");
            $b1plot->SetLegend("Sent");

            $b2plot->SetColor("#B0C4DE");
            $b2plot->SetFillColor("#66FF33");
            $b2plot->SetLegend("Read Recepients");

            $b3plot->SetColor("#cc1111");
            $b3plot->SetFillColor("#cc1111");
            $b3plot->SetLegend("Un Delivered");

            $graph->legend->SetFrameWeight(1);
            $graph->legend->SetColumns(3);
            $graph->legend->SetColor('#4E4E4E', '#00A78A');
            $graph->legend->Pos(0.005, 0.1, "right", "center");

            $graph->title->Set("Overal Mail Statistics");

            // Display the graph
            $gdImgHandler = $graph->Stroke(_IMG_HANDLER);

            $fileName = "imagefile.png";
            $graph->img->Stream($fileName);
            $count = sizeof($aXaxisTicks);
        } catch (Exception $e) {
            $fileName = "./layouts/images/nodata.png";
        }
        include("layouts/overal_mail_statistics_ns.html");
}
?>