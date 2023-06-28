<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 14/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 14/08/2014  Version : 2.0   	 *
 * Description : this page contains all sql statements to count and 	 *
				 display visited IP's information                        *
 ************************************************************************/

class IPFilter {

	function ipwise()
	{
		global $dbcon;
		global $count;
		global $analyticsData;
		global $deviceCond;
		global $friendlyIpsCond;
		global $friendlyWebsites;

		$sql = "SELECT vi.ip_address,vi.country,vi.city,count(vi.id) AS clicks FROM ".VISITORS_INFO." as vi WHERE vi.geo_info_status = 1 ".$deviceCond . $friendlyIpsCond . $friendlyWebsites." GROUP BY vi.ip_address ORDER BY clicks DESC";
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
		}
		return $analyticsData;		
	}
	
	function ipwiseViewDetails($Ip_address)
	{
		global $coockie;
		global $deviceCond;
		global $Ip_address;
		global $friendlyWebsites;
		global $searhCond;
		global $orderField;
		global $start_limit;
		global $dbcon;
		global $no_of_rows_for_count;
		global $analyticsData;
	
		$sql_for_total_count = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond." AND vi.ip_address = '".$Ip_address."' ". $friendlyWebsites.$searhCond . " ORDER BY " . $orderField;
		try {
			$stmt1 = $dbcon->prepare($sql_for_total_count, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt1->execute();	
			$no_of_rows_for_count = $stmt1->rowCount();
		}catch (PDOException $e){
			print $e->getMessage();
		}
		if($no_of_rows_for_count > 0){	
			$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond." AND vi.ip_address = '".$Ip_address."' ". $friendlyWebsites.$searhCond . " ORDER BY " . $orderField ." LIMIT ".$start_limit.",".ROW_PER_PAGE;
			try {
				$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				$stmt->execute();	
				$no_of_rows = $stmt->rowCount();
			}
			catch (PDOException $e){
				print $e->getMessage();
			}
		}
		if($no_of_rows_for_count > 0){
			$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
			return $analyticsData;
		}
	}
}
?>