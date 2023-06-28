<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 13/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 13/08/2014  Version : 2.0   	 *
 * Description : this page contains all sql statements to count and 	 *
				 display visitor's information                           *
 ************************************************************************/

class Filter {
	function visitorCount() {
		global $dbcon;
		global $deviceCond;
		global $friendlyIpsCond;
		global $friendlyWebsites;
		global $searhCond;
		global $orderField;
		$count = 0;
		$sql_for_total_count = "SELECT count(vi.id) as count FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON vi.page_id = p.id WHERE vi.geo_info_status = 1 ".$deviceCond . $friendlyIpsCond . $friendlyWebsites . $searhCond . " ORDER BY " . $orderField;
			try {
				$stmt1 = $dbcon->prepare($sql_for_total_count, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				$stmt1->execute();
				//$count = $stmt1->rowCount();
				if($stmt1->rowCount() > 0 ){
					$result = $stmt1->fetch();
					$count = $result['count'];
				}
			} catch (PDOException $e) {
				print $e->getMessage();
				$count = 0;
			}
			return $count;
	}

	function visitorList() {
		global $dbcon;
		global $coockie;
		global $deviceCond;
		global $friendlyIpsCond;
		global $friendlyWebsites;
		global $searhCond;
		global $orderField;
		global $start_limit;
		
		$analyticsData = array();
		$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON vi.page_id = p.id WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond. $friendlyWebsites  . $searhCond . " ORDER BY " . $orderField ." LIMIT ".$start_limit.",".ROW_PER_PAGE;
		try {
			$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();
			$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			print $e->getMessage();
		}
		return $analyticsData;
	}
	
	function pageSearch(){
		global $searhCondP;
		global $analyticsDataP;
		global $friendlyIpsCond;
		global $dbcon;
		$searhCondP = "";
		$sqlP = "SELECT p.page_name,p.id FROM page as p LEFT JOIN visitors_info as vi ON p.id = vi.page_id WHERE 1 ".$friendlyIpsCond. $searhCondP . " group by p.id";
		try {
			$stmtP = $dbcon->prepare($sqlP, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmtP->execute();
		} catch (PDOException $e) {
			print $e->getMessage();
		}

		if ($stmtP->rowCount() > 0)
		{
			$analyticsDataP = $stmtP->fetchALL(PDO::FETCH_ASSOC);
		}
			return $analyticsDataP;
	}
	
	function countrySearch()
	{
		global $searhCondC;
		global $analyticsDataC;
		global $dbcon;
		$searhCondC = "";
	
		$sqlC = "SELECT distinct(vi.country) as country FROM visitors_info as vi WHERE vi.geo_info_status = 1 " . $searhCondC ." ORDER BY country ASC";

		try {
			$stmtC = $dbcon->prepare($sqlC, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmtC->execute();
		} 	catch (PDOException $e) {
				print $e->getMessage();
			}
	
	
		if ($stmtC->rowCount() > 0) {
			$analyticsDataC = $stmtC->fetchALL(PDO::FETCH_ASSOC);
			
		}
		return $analyticsDataC;
	
	}
	
	function citySearch()
	{
	
			global $searhCondCi;
			global $analyticsDataCi;
			global $dbcon;
			$searhCondCi = "";
			if(@$_POST['country_name'] != ""){
				$searhCondCi .= " AND country = '".$_POST['country_name']."'";
			}

			$sqlC = "SELECT distinct(city) as city FROM visitors_info as vi WHERE vi.geo_info_status = 1 " . $searhCondCi ." ORDER BY city ASC";
			try {
				$stmtC = $dbcon->prepare($sqlC, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				$stmtC->execute();
			}
			catch (PDOException $e) {
				print $e->getMessage();
			}
			
			if ($stmtC->rowCount() > 0)
			{
				$analyticsDataCi = $stmtC->fetchALL(PDO::FETCH_ASSOC);
				
			}
			return $analyticsDataCi;
	}
	
	function IpSearch()
	{
			global $searhCondIP;
			global $analyticsDataip;
			global $dbcon;
			global $friendlyIpsCond;
	
		$searhCondIP = "";
		$sqlC = "SELECT distinct(vi.ip_address) as ip_address FROM visitors_info as vi WHERE vi.geo_info_status = 1" . $searhCondIP . $friendlyIpsCond;

		try {
			$stmtC = $dbcon->prepare($sqlC, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmtC->execute();
		}
		catch (PDOException $e) 
		{
			print $e->getMessage();
		}
	
		if ($stmtC->rowCount() > 0) 
		{
			$analyticsDataip = $stmtC->fetchALL(PDO::FETCH_ASSOC);
			
		}
		return $analyticsDataip;
	}
	
	
}
?>