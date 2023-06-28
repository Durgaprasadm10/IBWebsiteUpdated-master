<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 25/08/2014  Version : 2.0   	 *
 * Description : this page contains all sql statements to display    	 *
				  DailyChart's information	                             *
 ************************************************************************/


class DailyCharts
{
	function chartsdaily()
	{
		global $dbcon;
		global $get_category;
		global $friendlyWebsites;
		global $today;
		global $stmt;
		global $country_code_display_array;
		global $countryInfo;
		global $clicksInfo;
		global $pageInfo;
		global $page_code_display_array;
		global $sql;
		global $pageShortName;
		global $friendlyIpsCond;
		
		if($get_category == "Country")
		{
			
			$sql = "SELECT vi.country_code,vi.country,count(vi.id) AS clicks FROM visitors_info as vi WHERE vi.geo_info_status = 1 AND date(datetime) = '".$today."'".$friendlyIpsCond.$friendlyWebsites." GROUP BY vi.country ORDER BY clicks DESC";
		}
		else if($get_category == "Page")
		{
			
			$sql = "SELECT p.short_name,p.page_name, count(vi.id) AS clicks FROM visitors_info as vi  LEFT JOIN page as p ON p.id = vi.page_id WHERE  vi.geo_info_status = 1 AND date(datetime) = '".$today."'".$friendlyIpsCond.$friendlyWebsites." GROUP BY p.page_name ORDER BY clicks DESC";
		}
		try {
			$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();	
		}
		catch (PDOException $e)
		{
			print $e->getMessage();
		}
		
		if($get_category == "Country")
		{
			$country_code_display_array = array();
			if($stmt->rowCount() > 0)
			{
				$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
				$countryInfo = array();
				$clicksInfo = array();
				foreach($analyticsData as $aData)
				{
					$info_1 = array();
					$info_1['short_name'] = $aData['country_code'];
					$info_1['full_name'] = $aData['country'];
					$info_1['clicks'] = $aData['clicks'];
					$country_code_display_array[] = $info_1;
					$countryInfo[] = $aData['country_code']."(".$aData['clicks'].")";
					$clicksInfo[] = $aData['clicks'];
				}
			}
		}
		else if($get_category == "Page")
		{
			if($stmt->rowCount() > 0)
			{
				$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
				$pageInfo = array();
				$clicksInfo = array();
				$page_code_display_array = array();
				foreach($analyticsData as $aData)
				{
					$info_1 = array();
					$pageShortName = $aData['short_name'];
					$info_1['short_name'] = $pageShortName;
					$info_1['full_name'] = $aData['page_name'];
					$info_1['clicks'] = $aData['clicks'];
					$page_code_display_array[] = $info_1;
					$pageInfo[] = $pageShortName."(".$aData['clicks'].")";
					$clicksInfo[] = $aData['clicks'];
				}
			}
		}
	}

}
?>