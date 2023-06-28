<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 13/08/2014                                      *
 * Created By : Sri Ravi Teja                                     *
 * Vision : Project Visitortracking                               *  
 * Modified by : Sri Ravi Teja  Date : 25/08/2014   Version : 2.0 *
 * Description : this page will give analytics for all  pages     *
 *****************************************************************/
include ("includes/header.inc.php");
include ("classes/PageFilter.class.php");
$searchstring = "";
$start_limit = 0;
@$page = isset($_GET['page']) ? $_GET['page'] : $_POST['page']; 
if(!isset($page))
	$page = 1;    
if($page > 1)
	$start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);

$bypage = new PageFilter();
$event_tab_type_radio="";
@$action = $_GET['action'];
@$page_id = $_GET['page_id'];


if($action == "view_details"){
	$searchstring = "page_id=".$page_id."&action=view_details";
	@$page_name_input = $_REQUEST['page_id'];
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
	$page_name = $bypage->getPageName($page_id);
	$analyticsData = $bypage->pagewiseViewDetails($page_id);
	include ("layouts/page_analytics.html");
}else{
	$analyticsData = $bypage->pagewise();
	include ("layouts/analytics_bypage.html");
}

?>