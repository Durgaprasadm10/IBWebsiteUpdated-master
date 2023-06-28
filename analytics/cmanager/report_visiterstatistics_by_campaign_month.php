<?php
$logininfo["customer_id"] = @$_GET["customer_id"];
include("includes/headerCM.inc.php");
include("classes/campaignlist.class.php");
require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_bar.php');

$objCList = new CList();
//Campiagn Details 
$aCmList = array();
$aSent = array();
$aReadRecepients = array();
$aUndelivered = array();
$aTickPosition = array();
$aHitCount = array();

//Mail Tracking Report
$sStartDate = date('Y-m-d', strtotime('first day of last month'));
$sEndDate = date('Y-m-d', strtotime('last day of last month'));

//$sStartDate = "";
//$sEndDate = "";

foreach ($objCList->getListWithHitCountByCampaign($sStartDate, $sEndDate) as $data) {
	$sCmName = $objCList->getCampaignNameByCmId($data['cm_id']);
	array_push($aCmList, $sCmName);
	array_push($aHitCount,$data['hit_count']);
	
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


//For Visiter Tracking 

$aTickPosition1 = array();

$iMaxCount = @max($aHitCount);
$iTick1 = round($iMaxCount / 10);

if ($iTick1 == 0) {
    $iTick1 = 1;
}
$i = 0;
while ($i <= ($iMaxCount + $iTick1)) {
    @array_push($aTickPosition, $i);
    $i += $iTick1;
}

// Create the graph. These two calls are always required
try {
    $graph = new Graph(600, 400, 'auto');
    $graph->SetScale("textlin");

    $theme_class = new UniversalTheme;
    $graph->SetTheme($theme_class);

    $graph->yaxis->SetTickPositions($aTickPosition1);
    $graph->SetBox(false);

    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($aCmList);
    $graph->xaxis->SetLabelAngle(30);
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

    $fileName1 = "imagefile1.png";

    $graph->img->Stream($fileName1);
    $grapg_imagae = " <img src='" . $fileName1 . "'>";
    $count = sizeof($aCmList);
} catch (Exception $e) {
    //$fileName = "./layouts/images/nodata.png";
    $grapg_imagae = "";
}
$url = TRACKING_URL . '/visitor_tracking_report_ns.php';
?>

<!-- Visiter Tracking report !-->
<table>

    <tr>
        <td valign="top" style="padding-top:20px;padding-left:20px">
            <a href="<?php echo $url . '?customer_id=' . $logininfo["customer_id"] . '&sd=' . strtotime($sStartDate) . '&ed=' . strtotime($sEndDate); ?>">Click to view on web</a><br><br><br>

            <table cellpadding="5" style="border:1px solid black;border-collapse:collapse;margin-left:40px;">
                <thead><th style='border:1px solid black;'>campaign Name</th><th style='border:1px solid black;'>Hit Count</th></thead>
                    <?php
                    if (sizeof($aCmList) > 0) {
                        for ($i = 0; $i < sizeof($aCmList); $i++) {
                            echo "<tr><td style='border:1px solid black;'>" . $aCmList[$i] . "</td><td style='border:1px solid black;'>" . $aHitCount[$i] . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td style='border:1px solid black;text-align:center;' colspan='4'>No record found</td></tr>";
                    }
                    ?>
            </table>

        </td>
    </tr>
    <tr>
        <td valign="top">
            <?php echo $grapg_imagae; ?>
        </td>

    </tr>

</table>