<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 25/08/2014  Version : 2.0   	 *
 * Description : this page gives radar charts for the seven days  		 *
                   (week) before the selected date.                      *
 ************************************************************************/
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
		
		$date2 = date('Y-m-d',$get_date);
		$date1 = date('Y-m-d', strtotime("$date2 -6 days"));
		$get_date = $date2; //for displaying in input field
		 
	}else{
		include "includes/header.inc.php"; // with login check
		//setting default values for date and category
		$get_date = ($get_date == "") ? date('Y-m-d', strtotime("-1 days")) : $get_date;
		$get_category = ($get_category == "") ? "Country" : $get_category;
		
		$date2 = $get_date;
		$date1 = date('Y-m-d', strtotime("$date2 -6 days"));		
		
	}
	include "classes/WeeklyCharts.class.php";
	
	$today = $date1." to ".$date2;
	$searhCond = "";
	
	$wlycht = new WeeklyCharts();
	$wlycht->chartsweekly();
	
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


	if($get_category == 