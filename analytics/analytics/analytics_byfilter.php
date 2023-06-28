<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 13/08/2014                                      *
 * Created By : Sri Ravi Teja                                     *
 * Vision : Project Visitortracking MVC                           *  
 * Modified by : Sri Ravi Teja  Date : 27/08/2014   Version : 2.0 *
 * Description : this page contains all search filters to filter  *
				 the result set.                                  *
 *****************************************************************/

include ("includes/header.inc.php");
include ("classes/filter.class.php");
include ("classes/SearchFilter.class.php");

$pageName =  substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
$searchstring = "";
$start_limit = 0;
$event_tab_type_radio="";
@$cn =$_POST['country_name'];

@$page = isset($_GET['page']) ? $_GET['page'] : $_POST['page']; 
if(!isset($page))
	$page = 1;    
if($page > 1)
	$start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);

//search filters start_limit

$searhCond = "";
if (@$_POST['country_name'] != "" && ($_POST['country_name'] != "All")) {
	$searhCond .= " AND vi.country='" . $_POST['country_name'] . "'";
	//$searchstring .="country_name=".$cn;
}
if (@$_POST['city_name'] != "") {
	$searhCond .= " AND vi.city='" . $_POST['city_name'] . "'";
}
if (@$_POST['IpAddress'] != "") {
	$searhCond .= " AND vi.ip_address='" . $_POST['IpAddress'] . "'";
}

if (@$_POST['page_id'] != "") {
	$searhCond .= " AND vi.page_id='" . $_POST['page_id'] . "'";
}

else
{

	if(isset($_POST['date']) && isset($_POST['todate']) && (@$_POST['date']!="") && (@$_POST['todate']!="")){
		$searhCond .= " AND DATE(CONVERT_TZ(vi.datetime,'+00:00','".$coockie."')) BETWEEN '".$_POST['date']."' AND '".$_POST['todate']."'";
	}
	
}
$orderField = "";

$i = 0;
if (count(@$_POST['order_type']) > 0) {
	
	foreach(@$_POST['order_type'] as $value){
	
		$orderField .= $value." ".$_POST['order_by'][$i] .",";
				
		$i=$i+1;					
	}
	$orderField = substr($orderField,0,(strlen($orderField) - 1));
	
}else{
	$orderField = 'vi.datetime DESC';
}			
	

// search filters end
	
	
$objFilter = new Filter();
$count = $objFilter->visitorCount();
			if($count > 0){
				$analyticsData = $objFilter->visitorList();
			}
			
$srchFilter = new SearchFilter();
$searhCondP = $srchFilter->pageSearch();
$analyticsDataC = $srchFilter->countrySearch();		
$analyticsDataCi = $srchFilter->citySearch();
$analyticsDataip = $srchFilter->IpSearch();	
				
include ("layouts/analytics_byfilter.html");
?>