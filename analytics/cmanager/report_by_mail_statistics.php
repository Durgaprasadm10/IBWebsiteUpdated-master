<?php
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

//Mail Tracking Report
$sStartDate = date('Y-m-d', strtotime("-1 days"));
$sEndDate = date('Y-m-d', strtotime("-1 days"));

foreach ($objCList->getProcessCampaignListByDateRange($sStartDate, $sEndDate) as $aCM) {
// array_push($aCmList, $aCM['campaign_name'] . '(' . $aCM['pid'] . ')');
    array_push($aCmList, $aCM['campaign_name']);
    $iSentMails = $objCList->getMailCountByStatusByDateRange($aCM['pid'], '1', $sStartDate, $sEndDate);
    array_push($aSent, $iSentMails);
    $iReadRecepients = $objCList->getMailCountByStatusByDateRange($aCM['pid'], '3', $sStartDate, $sEndDate);
    array_push($aReadRecepients, $iReadRecepients);
    $iUndelivered = $objCList->getMailCountByStatusByDateRange($aCM['pid'], '4', $sStartDate, $sEndDate);
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
    $graph = new Graph(600, 400, 'auto');
    $graph->SetScale("textlin");

    $theme_class = new UniversalTheme;
    $graph->SetTheme($theme_class);

    $graph->yaxis->SetTickPositions($aTickPosition);
    $graph->SetBox(false);

    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($aCmList);
    $graph->xaxis->SetLabelAngle(15);
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
    $grapg_imagae = " <img src='" . $fileName . "'>";
    $count = sizeof($aCmList);
} catch (Exception $e) {
    //$fileName = "./layouts/images/nodata.png";
    $grapg_imagae = "";
}
$url = TRACKING_URL . '/mailstatistics_graph_ns.php';
?>

<!-- Visiter Tracking report !-->
<table>
    <tr>
        <td valign="top" style="padding-top:20px;padding-left:20px">
            <a href="<?php echo $url . '?customer_id=' . $logininfo["customer_id"] . '&sd=' . strtotime($sStartDate) . '&ed=' . strtotime($sEndDate); ?>">Click to view on web</a><br><br><br>
            <table cellpadding="5" style="border:1px solid black;border-collapse:collapse;margin-left:40px;">
                <thead><th style='border:1px solid black;'>Campaign Name</th><th style='border:1px solid black;'>Sent</th><th style='border:1px solid black;'>Read Recepients</th><th style='border:1px solid black;'>Undeliverable</th></thead>
                    <?php
                    if (sizeof($aCmList) > 0) {
                        for ($i = 0; $i < sizeof($aCmList); $i++) {
                            echo "<tr><td style='border:1px solid black;'>" . $aCmList[$i] . "</td><td style='border:1px solid black;'>" . $aSent[$i] . "</td><td style='border:1px solid black;'>" . $aReadRecepients[$i] . "</td><td style='border:1px solid black;'>" . $aUndelivered[$i] . "</td></tr>";
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