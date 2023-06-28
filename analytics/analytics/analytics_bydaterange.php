<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 13/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 13/08/2014  Version : 2.0   	 *
 * Description : this page will give analytics by given date range		 *
 ************************************************************************/

include ("includes/header.inc.php");
include ("classes/DateFilter.class.php");

$count = 0;
$bydate = new DateFilter();
$analyticsDataP = $bydate->datepagewise();
$analyticsDataC = $bydate->countrywise();

if(isset($_POST['sbtn'])){
	$searhCond = "";
	if(isset($_POST['page_id']) && (@$_POST['page_id']!=""))
	{
		$searhCond .= " AND vi.page_id = ".$_POST['page_id'];
	}
	if(isset($_POST['country_name']) && (@$_POST['country_name']!=""))
	{
		$searhCond .= " AND vi.country = '".$_POST['country_name']."'";
	}
	if(isset($_POST['fromdate']) && isset($_POST['todate']) && (@$_POST['fromdate']!="") && (@$_POST['todate']!=""))
	{
		$searhCond .= " AND DATE(CONVERT_TZ(datetime,'+00:00','".$coockie."')) BETWEEN '".$_POST['fromdate']."' AND '".$_POST['todate']."'";
	}
	$orderby = "ASC";
	if(isset($_POST['order']) && (@$_POST['order']!=""))
	{
		$orderby = ($_POST['order'] == "Descending") ? "DESC" : "ASC";
	}
	$analyticsData = $bydate->daterangewise();
}					
include ("layouts/analytics_bydate.html");
?>
