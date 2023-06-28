<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 25/08/2014  Version : 2.0   	 *
 * Description : this page gives radar charts for the month       		 *
					in selected date                      			     *
 ************************************************************************/

	@$logininfo["customer_id"] = $_REQUEST["customer_id"];
	
	$presentdate =  date("d-m-Y");
	@$get_date = $_REQUEST['date'];
	@$get_category = $_REQUEST['category'];
	@$get_source = $_REQUEST['source'];

	if(isset($get_source) && ($get_source == "mail")){
		include "includes/header.inc1.php"; // without login check
		$get_date1 = $_GET['date1'];
		$get_date2 = $_GET['date2'];
		
		$date1 = date('Y-m-d', $get_date1);
		$date2 = date('Y-m-d', $get_date2);

		$get_category = ($get_category == "") ? "Country" : $get_category;
		$get_date = $date2; //for displaying in input field
		 
	}else{
		include "includes/header.inc.php"; // with login check
		//setting default values for date and category
		$get_date = ($get_date == "") ? date('Y-m-d') : $get_date;
		$get_category = ($get_category == "") ? "Country" : $get_category;
		
		$date2 = date('Y-m-t', strtotime($get_date));
		$date1 = date('Y-m-01', strtotime($get_date));
	}
	include "classes/MonthlyCharts.class.php";
	
	$today = $date1." to ".$date2;

	$searhCond = "";
	
	$mlycht = new MonthlyCharts();
	$mlycht->chartsmonthly();
	
	// graph lib start here

	require_once ('lib/jpgraph/src/jpgraph.php');
	require_once ('lib/jpgraph/src/jpgraph_radar.php');

	if($stmt->rowCount() > 0)
	{ 

		// Create the basic radar graph

		$graph = new RadarGraph(700,700);

		 

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

		$graph->title->Set("Analytics - ".SITENAME."               ".$get_category." Based Reports                 ".$presentdate);

		$graph->title->SetFont(FF_FONT1,FS_BOLD);


		if($get_category == "Country"){
			$graph->SetTitles($countryInfo);
			$code_display_array = $country_code_display_array;
		}else if($get_category == "Page"){
			$graph->SetTitles($pageInfo);
			$code_display_array = $page_code_display_array;
		}

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

		//$graph->Add($plot2);

		$graph->Add($plot);

		//$graph->Add($plot3); 

		// And output the graph

		//$graph->Stroke();

		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);


		$fileName = "imagefile.png";

		$graph->img->Stream($fileName);

	}
	
	include "layouts/charts_monthly.html";
?>