<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 18/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 18/08/2014  Version : 2.0   	 *
 * Description : this page contains all sql statements to display    	 *
				  no. of clicks per day's information within date range  *
 ************************************************************************/

class DateFilter
{
	function datepagewise()
	{
		global $analyticsDataP;
		global $dbcon;
		global $stmtP;
		
		$sqlP = "SELECT page_name,id FROM ".PAGE." WHERE 1";
		try {
			$stmtP = $dbcon->prepare($sqlP, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmtP->execute();	
			}
			catch (PDOException $e)
			{
				print $e->getMessage();
			}
			if($stmtP->rowCount() >0)
			{
				$analyticsDataP = $stmtP->fetchALL(PDO::FETCH_ASSOC);
			}
			return $analyticsDataP;
	}
	
	function countrywise()
	{
		global $analyticsDataC;
		global $dbcon;
		global $sqlC;
		global $stmtC;
		global $deviceCond;
		global $friendlyIpsCond;
		global $friendlyWebsites;
	
		$sqlC = "SELECT distinct(country) as country FROM ".VISITORS_INFO." as vi WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites;
		try 
		{
			$stmtC = $dbcon->prepare($sqlC, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmtC->execute();	
		}
		catch (PDOException $e)
		{
			print $e->getMessage();
		}

		if($stmtC->rowCount() >0)
		{
			$analyticsDataC = $stmtC->fetchALL(PDO::FETCH_ASSOC);
		}
		return $analyticsDataC;
	}
	
	function daterangewise()
	{
	
		global $analyticsData, $stmt, $dbcon, $coockie, $deviceCond, $friendlyIpsCond, $searhCond, $orderby, $count;
		$sql = "SELECT distinct(DATE(vi.datetime)) as dates,count(vi.id) AS clicks FROM visitors_info as vi WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$searhCond." GROUP BY DATE(vi.datetime) ".$orderby;
		
		//$sqlC = "SELECT distinct(YEAR(CONVERT_TZ(datetime,'+00:00','".$coockie."'))) as year FROM `visitors_info` as vi WHERE vi.geo_info_status = 1 ";
		
		try {
			$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();
		}
		catch (PDOException $e)
		{
			print $e->getMessage();
		}
		$count = $stmt->rowCount();
		if($count > 0)
		{
			$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
		}
		return $analyticsData;
	}
	
}
