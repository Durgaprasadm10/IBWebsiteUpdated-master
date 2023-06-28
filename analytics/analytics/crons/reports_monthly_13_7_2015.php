<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 22/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 22/08/2014  Version : 2.0   	 *
 * Description : this page will produce radar charts which are    		 *
				 used by mail_monthly.php page                    		 *
 ************************************************************************/
 
$logininfo["customer_id"] = @$_GET["customer_id"];
include "../includes/header.inc1_crons.php";
include "../classes/MonthlyReports.class.php";

$presentdate =  date('d-m-Y');
 $date1 = date('Y-m-d', strtotime('first day of last month'));
 $date2 = date('Y-m-d', strtotime('last day of last month'));
$today = date('d-m-Y', strtotime($date1))." to ".date('d-m-Y', strtotime($date2));
$date_for_web1 = strtotime($date1);
$date_for_web2 = strtotime($date2);

	$MnRpt = new MonthlyReports();
	$MnRpt->countrycode();
	if($stmt->rowCount() > 0){
		
		// graph lib start here
		require_once ('../lib/jpgraph/src/jpgraph.php');
		require_once ('../lib/jpgraph/src/jpgraph_radar.php');

		// Create the basic radar graph
		$graph = new RadarGraph(900,900);

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
		$graph->title->Set("Analytics - ".SITENAME."                       Country Based Reports                             ".$presentdate);
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->SetTitles($countryInfo);

		// Create the first radar plot        
		$plot = new RadarPlot($clicksInfo);
		$plot->SetLegend($today);
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
	$MnRpt->pagecode();
	if($stmt1->rowCount() > 0){
		
		// graph lib start here
		require_once ('../lib/jpgraph/src/jpgraph.php');
		require_once ('../lib/jpgraph/src/jpgraph_radar.php');

		// Create the basic radar graph
		$graph = new RadarGraph(900,700);

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
		$graph->title->Set("Analytics - ".SITENAME."                       Page Based Reports                            ".$presentdate);
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->SetTitles($pageInfo);
		
		// Create the first radar plot        
		$plot = new RadarPlot($pclicksInfo);
		$plot->SetLegend($today);
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

		//$graph->Stroke();
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);

		// Default is PNG so use ".png" as suffix
		$fileName1 = "imagefile1.png";
		$graph->img->Stream($fileName1);
	}
	include "../layouts/reports_monthly.html";

?>