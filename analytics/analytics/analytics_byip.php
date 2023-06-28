<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 13/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 13/08/2014  Version : 2.0   	 *
 * Description : this page is controller for all  ips analytics      	 *
 ************************************************************************/

include ("includes/header.inc.php");
include ("classes/IPFilter.class.php");
$searchstring = "";
$start_limit = 0;
@$country_name_input = isset($_POST['ip_address']) ? $_POST['ip_address'] : $_GET['ip_address'];


@$page = isset($_GET['page']) ? $_GET['page'] : $_POST['page']; 
if(!isset($page))
	$page = 1;    
if($page > 1)
	$start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
$byip = new IPFilter();
$event_tab_type_radio="";
@$action = $_GET['action'];
@$Ip_address = $_GET['ip_address'];
	if($action == "view_details"){
		$searchstring = "ip_address=".$Ip_address."&action=view_details";
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
		$analyticsData = $byip->ipwiseViewDetails($Ip_address);
		include ("layouts/ip_analytics.html");
	}
	else
	{
		$analyticsData = $byip->ipwise();
		include ("layouts/analytics_byip.html");
	}
?>