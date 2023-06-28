<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 22/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 22/08/2014  Version : 2.0   	 *
 * Description : this page will produce radar charts which are   		 *
				 used by mail_daily.php page                    		 *
 ************************************************************************/
error_reporting(0); 
 
$logininfo["customer_id"] = @$_GET["customer_id"];

include "../includes/header.inc1_crons.php";
include "../classes/DailyReports.class.php";


//$today = date('Y-m-d');
$today = date('Y-m-d', strtotime("-1 days"));
$today = date('Y-m-d', strtotime(date("Y-m-d H:s:i")));
$today_in_legend = date('d-m-Y',strtotime($today));

$date_for_web = strtotime($today);

$presentdate =  date('d-m-Y');

$DlyRpt = new DailyReports();
$DlyRpt->channelBased();
$DlyRpt->pageBased();


	if($stmt2->rowCount() > 0){
		
		// graph lib start here
		require_once ('../lib/jpgraph/src/jpgraph.php');
		require_once ('../lib/jpgraph/src/jpgraph_radar.php');

		// Create the basic radar graph
		$graph = new RadarGraph(700,600);

		// Set background color and shadow
		$graph->SetColor("white");
		$graph->SetShadow();

		// Position the graph
		$graph->SetCenter(0.4,0.55);

		// Setup the axis formatting     
		$graph->axis->SetFont(FF_FONT1,FS_BOLD);
		$graph->axis->SetWeight(2);

		// Setup the grid lines
		$graph->grid->SetLineStyle("longdashed");
		$graph->grid->SetColor("navy");
		$graph->grid->Show();
		$graph->HideTickMarks();

		// Setup graph titles
		$graph->title->Set("Analytics - ".SITENAME."               Channel Based Duration Reports                 ".$presentdate);
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->SetTitles($channelInfo);

		// Create the first radar plot        
		$plot = new RadarPlot($durationInfo);
		$plot->SetLegend($today_in_legend);
		$plot->SetColor("red","lightred");
		$plot->SetFill(false);
		$plot->SetLineWeight(2);

		// Create the second radar plot
		$plot->SetFillColor('lightred');
		$graph->SetSize(0.6);
		$graph->SetPos(0.5,0.6);

		// Add the plots to the graph
		$graph->Add($plot);

		// And output the graph
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);

		// Default is PNG so use ".png" as suffix
		$fileName = "imagefile.png";
		$graph->img->Stream($fileName);
	}
	
	if($stmt3->rowCount() > 110){
		
		// graph lib start here
		require_once ('../lib/jpgraph/src/jpgraph.php');
		require_once ('../lib/jpgraph/src/jpgraph_radar.php');

		// Create the basic radar graph
		$graph = new RadarGraph(700,600);

		// Set background color and shadow
		$graph->SetColor("white");
		$graph->SetShadow();

		// Position the graph
		$graph->SetCenter(0.4,0.55);

		// Setup the axis formatting     
		$graph->axis->SetFont(FF_FONT1,FS_BOLD);
		$graph->axis->SetWeight(2);

		// Setup the grid lines
		$graph->grid->SetLineStyle("longdashed");
		$graph->grid->SetColor("navy");
		$graph->grid->Show();
		$graph->HideTickMarks();

		// Setup graph titles
		$graph->title->Set("Analytics - ".SITENAME."               Page Based Duration Reports                 ".$presentdate);
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->SetTitles($pageInfo);

		// Create the first radar plot        
		$plot = new RadarPlot($durationInfo);
		$plot->SetLegend($today_in_legend);
		$plot->SetColor("red","lightred");
		$plot->SetFill(false);
		$plot->SetLineWeight(2);

		// Create the second radar plot
		$plot->SetFillColor('lightred');
		$graph->SetSize(0.6);
		$graph->SetPos(0.5,0.6);

		// Add the plots to the graph
		$graph->Add($plot);

		// And output the graph
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);

		// Default is PNG so use ".png" as suffix
		$fileName = "imagefile.png";
		$graph->img->Stream($fileName);
	}
	
	include "../layouts/reports_daily_duration.html";
?>