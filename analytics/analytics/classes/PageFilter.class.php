<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 13/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 13/08/2014  Version : 2.0   	 *
 * Description : this page contains all sql statements to count and 	 *
				 display visited page's information                      *
 ************************************************************************/

class PageFilter {

	function pagewise()
	{
		global $count;
		global $analyticsData;
		global $deviceCond;
		global $friendlyIpsCond;
		global $friendlyWebsites;
		global $dbcon;
		
			$sql = "SELECT p.page_name,vi.page_id, count(vi.id) AS clicks FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id = vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites." GROUP BY p.id,vi.page_id";

			try 
			{
				$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				$stmt->execute();
				$count = $stmt->rowCount();
			}
			catch (PDOException $e)
			{
				print $e->getMessage();
				$count = 0;
			}
		
			if($count > 0)
			{
				$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
				return $analyticsData;
			}
		

	}

	function pagewiseViewDetails($page_id)
	{
		global $coockie;
		global $page_id;
		global $count1;
		global $analyticsData;
		global $deviceCond;
		global $friendlyIpsCond;
		global $friendlyWebsites;
		global $dbcon;
		global $searhCond;
		global $orderField;
		global $start_limit;
		global $no_of_rows;
	
		$sql_for_total_count = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites." AND vi.page_id = '".$page_id."' ". $searhCond . " ORDER BY " . $orderField;
		try {
			$stmt1 = $dbcon->prepare($sql_for_total_count, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt1->execute();	
			$count1 = $stmt1->rowCount();
		}catch (PDOException $e){
			print $e->getMessage();
		}
		if($count1 > 0 ){
			$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites." AND vi.page_id = '".$page_id."' ". $searhCond . " ORDER BY " . $orderField ." LIMIT ".$start_limit.",".ROW_PER_PAGE;
			try {
			$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();	
			$no_of_rows = $stmt->rowCount();
			}catch (PDOException $e){
				print $e->getMessage();
			}
		}
		if($count1 > 0)
		{
			$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
			return $analyticsData;
		}
	}
	
	function getPageName($pid)
	{
		global $dbcon;
		$sql = "SELECT page_name FROM page WHERE id = '".$pid."'";
		try {
			$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();	
			$pageDaata = $stmt->fetch(PDO::FETCH_ASSOC);
			return $pageDaata['page_name'];
		}catch (PDOException $e){
			print $e->getMessage();
		}
}

}
?>