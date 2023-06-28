<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 25/08/2014  Version : 2.0   	 *
 * Description : this page gives radar charts for the selected date.     *
 ************************************************************************/
	//error_reporting(E_ALL);
error_reporting(0); 
	
	@$logininfo["customer_id"] = $_REQUEST["customer_id"];
	
	
	$presentdate =  date("d-m-Y");
	@$get_date = $_REQUEST['date'];
	@$get_category = $_REQUEST['category'];
	@$get_source = $_REQUEST['source'];
	
	if(isset($get_source) && ($get_source == "mail")){
		include "includes/header.inc1.php"; // without login check
		$get_date = ($get_date == "") ? strtotime("-1 days") : $get_date;
		$get_category = ($get_category == "") ? "Country" : $get_category;
		$today = date('Y-m-d', $get_date);
	}else{
		include "includes/header.inc.php"; // with login check
		//setting default values for date and category
		$get_date = ($get_date == "") ? date('Y-m-d', strtotime("-1 days")) : $get_date;
		$get_category = ($get_category == "") ? "Country" : $get_category;
		$today = $get_date;
	}
	include "classes/DailyCharts.class.php";
	$searhCond = "";
	/*if($device >0){
		$searhCond .= " AND vi.device = '".$viewDevice."' ";
	}*/
	$dlycht = new DailyCharts();
	$dlycht->chartsdaily();
	
	
// graph lib start here

require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_radar.php');

 if($stmt->rowCount() > 0){

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

	$graph->title->Set("Analytics - ".SITENAME."               ".$get_category." Based Reports                 ".$presentdate);

	$graph->title->SetFont(FF_FONT1,FS_BOLD);


	if($get_category == "Country"){
		$graph->SetTitles($countryInfo);
		$code_display_array = $country_code_display_array;
		$plot = new RadarPlot($clicksInfo);
		$fileName = "imagefile.png";
	}
	else if($get_category == "Page"){
		$graph->SetTitles($pageInfo);
		$code_display_array = $page_code_display_array;		
		$plot = new RadarPlot($clicksInfo);
		$fileName = "imagefile1.png";		
	}
	else if($get_category == "Country-City"){	
		
		$graph->SetTitles($countrycityInfo);
		$code_display_array = $country_code_city_display_array;
		
		// Create the first radar plot        
		$plot = new RadarPlot($countrycityclicksInfo);
		// Default is PNG so use ".png" as suffix
		$fileName = "imagefile2.png";		
	}
	// Create the first radar plot        	

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

	$graph->img->Stream($fileName);
}
include "layouts/charts_daily.html";
?>
