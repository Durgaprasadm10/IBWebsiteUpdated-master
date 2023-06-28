<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 14/08/2014                                      *
 * Created By : Sri Ravi Teja                                     *
 * Vision : Project Visitortracking MVC                           *  
 * Modified by : Sri Ravi Teja Date : 25/08/2014   Version : 2.0  *
 * Description : this page will give all country based analytics  *
 *****************************************************************/
include ("includes/header.inc.php");
include ("classes/CountryFilter.class.php");
$searchstring = "";
$start_limit = 0;

//	paging
@$page = isset($_GET['page']) ? $_GET['page'] : $_POST['page']; 
if(!isset($page))
	$page = 1;    
if($page > 1)
	$start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);

$bycon = new ConFilter();
@$action = $_GET['action'];
@$Country = $_GET['country'];
$event_tab_type_radio="";
	if($action == "view_details"){
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		//echo $actual_link;
		$searchstring = "country=".$Country."&action=view_details";
		$searhCond = "";
			
		$orderField = "";
		$i = 0;
		if (count(@$_POST['order_type']) > 0) 
		{		
			foreach(@$_POST['order_type'] as $value)
			{		
				$orderField .= $value." ".$_POST['order_by'][$i] .",";
				$i=$i+1;					
			}
			$orderField = substr($orderField,0,(strlen($orderField) - 1));	
		}
		else
		{
			$orderField = 'vi.datetime DESC';
		}	
		$analyticsData = $bycon->conwiseViewDetails($Country);
		include ("layouts/country_analytics.html");
	}else{
	$analyticsData = $bycon->conwise();
	include ("layouts/analytics_bycountry.html");
}
?>