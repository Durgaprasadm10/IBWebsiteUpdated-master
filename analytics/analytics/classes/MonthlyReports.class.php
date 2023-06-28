<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 22/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 22/08/2014  Version : 2.0   	 *
 * Description : this page contains all sql statements to display    	 *
				  MonthlyReports's information	                         *
 ************************************************************************/

class MonthlyReports
{
	function citycode($countryCode)
	{
		
		global $dbcon;
		global $get_category;
		global $friendlyIpsCond;
		global $friendlyWebsites;
		global $date1;
		global $date2;
		global $stmt;
		global $country_city_code_display_array;
		global $country_cityInfo;
		global $clicksInfo;		
		   			
		 $sql = "SELECT vi.city,count(vi.id) AS clicks FROM visitors_info as vi WHERE vi.geo_info_status = 1 AND date(datetime) BETWEEN '".$date1."' AND '".$date2."'".$friendlyIpsCond.$friendlyWebsites." AND country_code = '".$countryCode."' GROUP BY vi.city ORDER BY clicks DESC";
		
		
		try {
			$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();			
		}
		catch (PDOException $e)
		{
			print $e->getMessage();
		}
		
		$country_city_code_display_array = array();
		if($stmt->rowCount() > 0)
		{
			$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
			$country_cityInfo = array();
			$clicksInfo = array();		
			/*echo "<pre>";
				print_r($analyticsData);*/
			foreach($analyticsData as $aData)
			{
				$info_1 = array();				
				$info_1['city'] = $aData['city'];				
				$info_1['clicks'] = $aData['clicks'];
				$country_city_code_display_array[] = $info_1;
				$country_cityInfo[] = $aData['city']."(".$aData['clicks'].")";
				$clicksInfo[] = $aData['clicks'];
				
			}
		}
		
		return $country_city_code_display_array;
		
	}	
	
	function countrycode()
	{
		global $dbcon;
		global $date1;
		global $date2;
		global $friendlyIpsCond;
		global $friendlyWebsites;
		global $country_code_display_array;
		global $analyticsData;
		global $countryInfo;
		global $clicksInfo;
		global $stmt;
		
		  $sql = "SELECT vi.country_code,vi.country,count(vi.id) AS clicks FROM visitors_info as vi WHERE vi.geo_info_status = 1 AND date(datetime) BETWEEN '".$date1."' AND '".$date2."'".$friendlyIpsCond.$friendlyWebsites." GROUP BY vi.country ORDER BY clicks DESC";
		try {
			$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();	
		}catch (PDOException $e){
			print $e->getMessage();
		}
		$country_code_display_array = array();
		if($stmt->rowCount() > 0){
			$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
			$countryInfo = array();
			$clicksInfo = array();			
			foreach($analyticsData as $aData){
				$info_1 = array();				
				$info_1['country_code'] = $aData['country_code'];
				$info_1['country'] = $aData['country'];				
				$info_1['clicks'] = $aData['clicks'];
				$country_code_display_array[] = $info_1;	
				$countryInfo[] = $aData['country_code']."(".$aData['clicks'].")";
				$clicksInfo[] = $aData['clicks'];
				
			}
			
			}
	}
	function pagecode()
	{
		global $dbcon;
		global $date1;
		global $date2;
		global $friendlyIpsCond;
		global $friendlyWebsites;
		global $page_code_display_array;
		global $panalyticsData;
		global $pageInfo;
		global $pclicksInfo;
		global $pageShortName;
		global $stmt1;
		$sql = "SELECT p.short_name,p.page_name, count(vi.id) AS clicks FROM visitors_info as vi  LEFT JOIN page as p ON p.id = vi.page_id WHERE vi.geo_info_status = 1 AND date(datetime) BETWEEN '".$date1."' AND '".$date2."'".$friendlyIpsCond.$friendlyWebsites." GROUP BY p.page_name ORDER BY clicks DESC";
		try {
			$stmt1 = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt1->execute();	
		}catch (PDOException $e){
			print $e->getMessage();
		}
		if($stmt1->rowCount() > 0){
			$panalyticsData = $stmt1->fetchALL(PDO::FETCH_ASSOC);
			$pageInfo = array();
			$pclicksInfo = array();
			$page_code_display_array = array();
			foreach($panalyticsData as $aData){
				$info_1 = array();
				$pageShortName = $aData['short_name'];
				$info_1['short_name'] = $pageShortName;
				$info_1['page_name'] = $aData['page_name'];
				$info_1['clicks'] = $aData['clicks'];
				$page_code_display_array[] = $info_1;
				$pageInfo[] = $pageShortName."(".$aData['clicks'].")";		
				$pclicksInfo[] = $aData['clicks'];	
			}
		}
	}
	function countrycityCode(){
		
		global $dbcon;
		global $date1;
		global $date2;
		global $friendlyIpsCond;
		global $friendlyWebsites;
		global $country_code_city_display_array;
		global $analyticsData;
		global $countrycityInfo;
		global $countrycityclicksInfo;
		global $stmt;
		
		  $sql = "SELECT vi.country_code,vi.country,count(vi.id) AS clicks FROM visitors_info as vi WHERE vi.geo_info_status = 1 AND date(datetime) BETWEEN '".$date1."' AND '".$date2."'".$friendlyIpsCond.$friendlyWebsites." GROUP BY vi.country ORDER BY clicks DESC";
		try {
			$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();	
		}catch (PDOException $e){
			print $e->getMessage();
		}

		$country_code_city_display_array = array();
		foreach($analyticsData as $aData)			{
			$info_1 = array();
			$info_1['country_code'] = $aData['country_code'];
			$info_1['country'] = $aData['country'];
			$cityInfo = self::citycode($aData['country_code']);				
			$info_1['cityinfo'] = $cityInfo;	
			$info_1['clicks'] = $aData['clicks'];
			$country_code_city_display_array[] = $info_1;				
			
			foreach($cityInfo as $city){								
				$countrycityInfo[] = $aData['country_code']."-".$city['city']."(".$city['clicks'].")";
				$countrycityclicksInfo[] = $city['clicks'];			
			}					
		}		
	}
}
?>