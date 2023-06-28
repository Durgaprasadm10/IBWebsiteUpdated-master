<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 18/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 18/08/2014  Version : 2.0   	 *
 * Description : this page contains all sql statements to display    	 *
				  Friendly IP's information 	                         *
 ************************************************************************/

class FriendlyIp
{
	function getFriendlyIP()
	{
		global $stmt;
		global $analyticsData;
		
		if ($stmt->rowCount() > 0) 
		{
			$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
		}
		return $analyticsData;
	}

}
?>