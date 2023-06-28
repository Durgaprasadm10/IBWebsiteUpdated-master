<?php
$logininfo["customer_id"] = @$_GET["customer_id"];
include "../includes/CronHeaderCM.inc.php";
include("../classes/campaignlist.class.php");
require_once ('../lib/jpgraph/src/jpgraph.php');
require_once ('../lib/jpgraph/src/jpgraph_bar.php');
$objCList = new CList();
//Visiter by IP
$aEmailList = array();
$aHitCount2 = array();
$aTickPosition2 = array();
$aCMIDArray = array();
$aUserIDArray = array();

$sStartDate = date('Y-m-d', strtotime("-1 days"));
$sEndDate = date('Y-m-d', strtotime("-1 days"));
//$sStartDate = "";
//$sEndDate = "";

foreach ($objCList->getUniqEmailListWithHitCount($sStartDate, $sEndDate) as $data) {
	$email = $objCList->getEmaillIdByUserAndCmId($data['cm_id'],$data['user_id']);
	@array_push($aHitCount2, $data['hit_count']);
	array_push($aEmailList, $email);
	array_push($aCMIDArray, $data['cm_id']);
	array_push($aUserIDArray, $data['user_id']);
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
    $graph = new Graph(800, 600, 'auto');
    $graph->SetScale("textlin");

    $theme_class = new UniversalTheme;
    $graph->SetTheme($theme_class);

    $graph->yaxis->SetTickPositions($aTickPosition2);
    $graph->SetBox(false);

    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($aEmailList);
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

    $graph->title->Set("Visitor Statistics By Email");

// Display the graph
    $gdImgHandler = $graph->Stroke(_IMG_HANDLER);

    $fileName2 = "imagefile2.png";

    $graph->img->Stream($fileName2);
    $grapg_imagae = " <img src='" . $fileName2 . "'>";
    $count2 = sizeof($aEmailList);
} catch (Exception $e) {
    //$fileName = "./layouts/images/nodata.png";
    $grapg_imagae = "";
}
//$url = TRACKING_URL . '/visitors_by_email_ns.php';
$url = TRACKING_URL . '/visitors_by_email_ns.php';
?>

<!-- Visiter Tracking report !-->
<table>
    <tr>        
        <td valign="top" style="padding-top:20px;padding-left:20px">
            <a href="<?php echo $url . '?customer_id=' . $logininfo["customer_id"] . '&sd=' . strtotime($sStartDate) . '&ed=' . strtotime($sEndDate); ?>">Click to view on web</a><br><br><br>

            <table cellpadding="5" style="border:1px solid black;border-collapse:collapse;margin-left:40px;">
                <?php
                if (sizeof($aEmailList) > 0) {
                    $iT = sizeof($aEmailList) / 15;
                    $iT1 = sizeof($aEmailList) % 15;
					if($iT <= 15){
						$iTables = $iT;
					}else{
						if ($iT1 > 0) {
							$iTables = $iT + 1;
						} else {
							$iTables = abs($iT);
						}
					}
                    echo "<thead>";
                    if ($iTables > 0) {
                        for ($k = 0; $k < $iTables; $k++) {
                            echo "<th style='border:1px solid black;'>Email</th><th style='border:1px solid black;'>Hit Count</th><th>Link Count</th>";
                        }
                    } else {
                        echo "<th style='border:1px solid black;'>Email</th><th style='border:1px solid black;'>Hit Count</th><th>Link Count</th>";
                        echo "<tr><td style='border:1px solid black;text-align:center;' colspan='3'>No record found</td></tr>";
                    }
                    echo "</thead>";
                    $r = 1;
                    $i = 0;
                    while ($r <= 15) {
                        //for ($i = 0; $i < sizeof($aEmailList); $i++) {
                        echo "<tr>";
                        for ($k = 0; $k < $iTables; $k++) {
                            if ($i <= sizeof($aEmailList)) {
                                @ $ip = $aEmailList[$i];
                                @ $hc = $aHitCount2[$i];
								  $userId = $aUserIDArray[$i];
								  $cmId = $aCMIDArray[$i];
                            } else {
                                $ip = '';
                                $hc = '';
								$userId = '';
								$cmId = '';
                            }
                            echo "<td style='border:1px solid black;text-align:center;'>" . $ip . "</td><td style='border:1px solid black;'>" . $hc . "</td>";
							echo "<td align='center' valign='middle'style='border:1px solid black;'>";
							if($userId != '' && $cmId != ''){
								$aLinkListCount = $objCList->getUniqLinkListWithHitCount($userId,$cmId,$sStartDate, $sEndDate);
								echo "<table border='0'>";
								foreach($aLinkListCount as $aLink)
								{
									echo "<tr><td>".$aLink['link_name']."</td><td>".$aLink['hit_count']."</td></tr>";
								}
								echo "</table>";
							}
							echo "</td>";
                            $i++;
                        }
                        echo"</tr>";
                        if ($i >= sizeof($aEmailList)) {
                            break;
                        }
                        // }
                        $r++;
                    }
                } else {
                    echo "<thead>";
                    echo "<th style='border:1px solid black;'>Email</th><th style='border:1px solid black;'>Hit Count</th><th style='border:1px solid black;'>Link Count</th>";
                    echo "<tr><td style='border:1px solid black;text-align:center;' colspan='3'>No record found</td></tr>";
                    echo "</thead>";
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