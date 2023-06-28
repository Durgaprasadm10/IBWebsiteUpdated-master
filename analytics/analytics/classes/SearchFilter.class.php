<?php
class SearchFilter
{
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