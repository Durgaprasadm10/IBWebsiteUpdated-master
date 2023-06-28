<?php
include("includes/header.inc_1.php");
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
//print_r($objCList->getProcessCampaignList());
foreach ($objCList->getProcessCampaignList() as $aCM) {
// array_push($aCmList, $aCM['campaign_name'] . '(' . $aCM['pid'] . ')');
    array_push($aCmList, $aCM['campaign_name']);
    $iSentMails = $objCList->getMailCountByStatus($aCM['pid'], '1');
    array_push($aSent, $iSentMails);
    $iReadRecepients = $objCList->getMailCountByStatus($aCM['pid'], '3');
    array_push($aReadRecepients, $iReadRecepients);
    $iUndelivered = $objCList->getMailCountByStatus($aCM['pid'], '4');
    array_push($aUndelivered, $iUndelivered);
    array_push($aHitCount, $objCList->countVisitorTrackDetailsByPid($aCM['pid']));
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
    $count = sizeof($aCmList);
} catch (Exception $e) {
    $fileName1 = "./layouts/images/nodata.png";
}

//Visiter by IP
$aIpList = array();
$aHitCount2 = array();
$aTickPosition2 = array();
foreach ($objCList->getUniqIpList() as $data) {
    array_push($aHitCount2, $objCList->gethitCountByIp($data['ip_address']));
    array_push($aIpList, $data['ip_address']);
}
$iMaxHitsbyIp = @max($aHitCount2);
$iTick2 = round($iMaxHitsbyIp / 10);

if ($iTick2 == 0) {
    $iTick2 = 1;
}
$i = 0;
while ($i <= ($iMaxHitsbyIp + $iTick2)) {
    @array_push($aTickPosition2, $i);
    $i += $iTick2;
}

// Create the graph. These two calls are always required
try {
    $graph = new Graph(600, 400, 'auto');
    $graph->SetScale("textlin");

    $theme_class = new UniversalTheme;
    $graph->SetTheme($theme_class);

    $graph->yaxis->SetTickPositions($aTickPosition2);
    $graph->SetBox(false);

    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($aIpList);
    $graph->xaxis->SetLabelAngle(90);
//$graph->xaxis->SetTickLabels(array('Campaign 1', 'Campaign 2', 'Campaign 3', 'Campaign 4'));
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false, false);

// Create the bar plots
    $b1plot = new BarPlot($aHitCount2);

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

    $graph->title->Set("Visitor Statistics By Ip");

// Display the graph
    $gdImgHandler = $graph->Stroke(_IMG_HANDLER);

    $fileName2 = "imagefile2.png";

    $graph->img->Stream($fileName2);
    $count2 = sizeof($aIpList);
} catch (Exception $e) {
    $fileName2 = "./layouts/images/nodata.png";
}
?>

<!-- Visiter Tracking report !-->
<table>
    <tr>

        <td valign="top">
<!--            <a href="<?php echo MAIN_URL; ?>/charts_daily.php?date=<?php echo $date_for_web; ?>&category=Country&source=mail&customer_id=<?php echo $logininfo["customer_id"]; ?>">Click to view on web</a><br>-->
            <img src="<?php echo $fileName; ?>">
        </td>
        <td valign="top" style="padding-top:20px;padding-left:20px">

            <table cellpadding="5" style="border:1px solid black;border-collapse:collapse;">
                <?php
                if (sizeof($aCmList) > 0) {
                    $iT = sizeof($aCmList) / 15;
                    $iT1 = sizeof($aCmList) % 15;
                    if ($iT > 0) {
                        $iTables = $iT + 1;
                    } else {
                        $iTables = abs($iT);
                    }
                    echo "<thead>";
                    for ($k = 0; $k < $iTables; $k++) {
                        echo "<th style='border:1px solid black;'>Campaign Name</th><th style='border:1px solid black;'>Sent</th><th style='border:1px solid black;'>Read Recepients</th><th style='border:1px solid black;'>Undelivarables</th>";
                    }
                    echo "</thead>";
                    $r = 1;
                    $i = 0;
                    while ($r <= 15) {
                        //for ($i = 0; $i < sizeof($aIpList); $i++) {
                        echo "<tr>";
                        for ($k = 0; $k < $iTables; $k++) {
                            if ($i <= sizeof($aCmList)) {
                                @ $cn = $aCmList[$i];
                                @ $s = $aSent[$i];
                                @ $r = $aReadRecepients[$i];
                                @ $u = $aUndelivered[$i];
                            } else {
                                $ip = '';
                                $hc = '';
                            }
                            echo "<td style='border:1px solid black;'>" . $cn . "</td><td style='border:1px solid black;'>" . $s . "</td><td style='border:1px solid black;'>" . $r . "</td><td style='border:1px solid black;'>" . $u . "</td>";
                            $i++;
                        }
                        echo"</tr>";
                        if ($i > sizeof($aCmList)) {
                            break;
                        }
                        // }
                        $r++;
                    }
                }
                ?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan='3' height="50px">
        <td>
    </tr>
    <tr>

        <td valign="top">
<!--            <a href="<?php echo MAIN_URL; ?>/charts_daily.php?date=<?php echo $date_for_web; ?>&category=Page&source=mail&customer_id=<?php echo $logininfo["customer_id"]; ?>">Click to view on web</a><br>-->
            <img src="<?php echo $fileName1; ?>">
        </td>
        <td valign="top" style="padding-top:20px;padding-left:20px">

            <table cellpadding="5" style="border:1px solid black;border-collapse:collapse;">
                <?php
                if (sizeof($aCmList) > 0) {
                    $iT = sizeof($aCmList) / 15;
                    $iT1 = sizeof($aCmList) % 15;
                    if ($iT > 0) {
                        $iTables = $iT + 1;
                    } else {
                        $iTables = abs($iT);
                    }
                    echo "<thead>";
                    for ($k = 0; $k < $iTables; $k++) {
                        echo "<th style='border:1px solid black;'>Campaign Name</th><th style='border:1px solid black;'>Hit Count</th>";
                    }
                    echo "</thead>";
                    $r = 1;
                    $i = 0;
                    while ($r <= 15) {
                        //for ($i = 0; $i < sizeof($aIpList); $i++) {
                        echo "<tr>";
                        for ($k = 0; $k < $iTables; $k++) {
                            if ($i <= sizeof($aCmList)) {
                                @ $ip = $aCmList[$i];
                                @ $hc = $aHitCount[$i];
                            } else {
                                $ip = '';
                                $hc = '';
                            }
                            echo "<td style='border:1px solid black;'>" . $ip . "</td><td style='border:1px solid black;'>" . $hc . "</td>";
                            $i++;
                        }
                        echo"</tr>";
                        if ($i > sizeof($aCmList)) {
                            break;
                        }
                        // }
                        $r++;
                    }
                }
                ?>
            </table>

        </td>
    </tr>
    <tr>

        <td valign="top">
<!--            <a href="<?php echo MAIN_URL; ?>/charts_daily.php?date=<?php echo $date_for_web; ?>&category=Page&source=mail&customer_id=<?php echo $logininfo["customer_id"]; ?>">Click to view on web</a><br>-->
            <img src="<?php echo $fileName2; ?>">
        </td>
        <td valign="top" style="padding-top:20px;padding-left:20px">

            <table cellpadding="5" style="border:1px solid black;border-collapse:collapse;">
                <?php
                if (sizeof($aIpList) > 0) {
                    $iT = sizeof($aIpList) / 15;
                    $iT1 = sizeof($aIpList) % 15;
                    if ($iT > 0) {
                        $iTables = $iT + 1;
                    } else {
                        $iTables = abs($iT);
                    }
                    echo "<thead>";
                    for ($k = 0; $k < $iTables; $k++) {
                        echo "<th style='border:1px solid black;'>Ip Address</th><th style='border:1px solid black;'>Hit Count</th>";
                    }
                    echo "</thead>";
                    $r = 1;
                    $i = 0;
                    while ($r <= 15) {
                        //for ($i = 0; $i < sizeof($aIpList); $i++) {
                        echo "<tr>";
                        for ($k = 0; $k < $iTables; $k++) {
                            if ($i <= sizeof($aIpList)) {
                                @ $ip = $aIpList[$i];
                                @ $hc = $aHitCount2[$i];
                            } else {
                                $ip = '';
                                $hc = '';
                            }
                            echo "<td style='border:1px solid black;'>" . $ip . "</td><td style='border:1px solid black;'>" . $hc . "</td>";
                            $i++;
                        }
                        echo"</tr>";
                        if ($i > sizeof($aIpList)) {
                            break;
                        }
                        // }
                        $r++;
                    }
                }
                ?>
            </table>

        </td>
    </tr>
</table>