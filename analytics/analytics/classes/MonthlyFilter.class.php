<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 14/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 01/09/2014  Version : 2.0   	 *
 * Description : this page contains all sql statements to count and 	 *
				 display Monthly click's information                     *
 ************************************************************************/

class MonthlyFilter
{
	function yearwise()
	{
		global $analyticsDataC;
		global $dbcon;
		global $stmtC,$coockie;
		
		
		$sqlC = "SELECT distinct(YEAR(CONVERT_TZ(datetime,'+00:00','".$coockie."'))) as year FROM `visitors_info` as vi WHERE vi.geo_info_status = 1 ";
		
		try 
		{
			$stmtC = $dbcon->prepare($sqlC, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmtC->execute();
		}
		catch (PDOException $e)
		{
			print $e->getMessage();
		}
		if ($stmtC->rowCount() > 0)
		{
			$analyticsDataC = $stmtC->fetchALL(PDO::FETCH_ASSOC);
		}
		return $analyticsDataC;
	}
	
	function monthwise()
	{
		global $analyticsDataM;
		global $dbcon;
		global $monthsArray;
		global $searhCondM;
		global $sqlM, $coockie;
		$sqlM = "SELECT distinct(MONTH(CONVERT_TZ(datetime,'+00:00','".$coockie."'))) as month FROM `visitors_info` as vi WHERE vi.geo_info_status = 1 ".$searhCondM;
		
		try {
			$stmtM = $dbcon->prepare($sqlM, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmtM->execute();
		} catch (PDOException $e) {
			print $e->getMessage();
		}
		
		if ($stmtM->rowCount() > 0) 
		{
			$analyticsDataM = $stmtM->fetchALL(PDO::FETCH_ASSOC);
			
			$monthsArray = array();
			foreach ($analyticsDataM as $aData) 
			{
				$monthsArray[] = $aData["month"];
			}
					
			return $monthsArray;
		}
	}
	
	function liste()
	{
		global $coockie;
		global $deviceCond;
		global $selectedyear;
		global $selectedmonth;
		global $friendlyIpsCond;
		global $friendlyWebsites;
		global $analyticsData;
		global $stmt;
		global $dbcon;
		global $count;
		$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as datetime1, vi.*,p.* FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON vi.page_id = p.id WHERE vi.geo_info_status = 1 ".$deviceCond." AND (YEAR(CONVERT_TZ(datetime,'+00:00','".$coockie."')) = ".$selectedyear.") AND (MONTH(CONVERT_TZ(datetime,'+00:00','".$coockie."')) = ".$selectedmonth.")".$friendlyIpsCond.$friendlyWebsites;
			try {
				$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				$stmt->execute();
				$count = $stmt->rowCount();
				if($count > 0){
					$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
				}

			}catch (PDOException $e){
				print $e->getMessage();
			}
			return $analyticsData;
	
	}
}
?>