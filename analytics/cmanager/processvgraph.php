<?php

require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_line.php');
include("classes/campaignlist.class.php");
include("includes/header.inc.php");

@$pid = (isset($_GET['pid'])) ? $_GET['pid'] : $_POST['pid'];

@$sMonth = (isset($_GET['month'])) ? $_GET['month'] : $_POST['month'];

//$sMonth = $_GET['month'];

if ($sMonth == "")
    $sMonth = "All";

$iNoData = 0;
$aMonth = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

$objCList = new CList();
$count = $objCList->countVisitorTrackByPid($pid);
$aHits = array(); //Hits
$bGraphp = false;
if ($count > 0) {
    if ($sMonth == "SelectMonth" || $sMonth == "All") {

        $HitCount = $objCList->getHitCountAll($pid);
        if (sizeof($HitCount) > 0) {
            $bGraphp = true;
            $aHitsMonths = array();
            foreach ($HitCount as $value) {
                $aHitsMonths[$value['groupDate']] = $value['hitcount'];
            }
            //exit;
            $aMonths = array_keys($aHitsMonths);
            // print_r($aMonths);
            for ($i = 1; $i <= 12; $i++) {
                if (in_array($i, $aMonths)) {
                    array_push($aHits, $aHitsMonths[$i]);
                } else {
                    array_push($aHits, 0);
                }
            }
        }   // print_r($aHits);
        //exit;
    } else {
        $HitCount = $objCList->getHitCount($pid, $sMonth);
        if (sizeof($HitCount) > 0) {
            $bGraphp = true;
            $aHitsDays = array();
            $aMonth1 = array();
            $aHits = array();
            foreach ($HitCount as $value) {
                // $aHitsDays[$value['groupDate']] = $value['hitcount'];
                array_push($aMonth1, $aMonth[$sMonth - 1] . '-' . $value['groupDate']);
                array_push($aHits, $value['hitcount']);
            }
            $aMonth = $aMonth1;
        }
    }
}
if ($bGraphp) {

    $graph = new Graph(550, 430);
    $graph->SetScale("textlin");

    $theme_class = new UniversalTheme;
    $graph->SetTheme($theme_class);
    if ($sMonth == 'All' || $count == 0) {
        $sT = 'Yearly';
    } else {
        $sT = 'Monthly';
    }
    $graph->title->Set('Visitors Tracking Statistics for ' . $sT);
    $graph->SetBox(false);

    $graph->yaxis->HideZeroLabel();
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false, false);
    $graph->xaxis->SetTickLabels($aMonth);
    $graph->ygrid->SetFill(false);
    //$graph->SetBackgroundImage("tiger_bkg.png",BGIMG_FILLFRAME);

    $p1 = new LinePlot($aHits);
    $graph->Add($p1);



    $p1->SetColor("#55bbdd");
    //$p1->SetLegend('Line 1');
    $p1->mark->SetType(MARK_FILLEDCIRCLE, '', 1.0);
    $p1->mark->SetColor('#55bbdd');
    $p1->mark->SetFillColor('#55bbdd');
    $p1->SetCenter();


    // Output line
    $graph->Stroke();
}
?>

