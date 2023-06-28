<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 28/02/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project InfoFam                                       *  
 * Modified by : Gayathri     Date : 17/03/2014    Version : V1   *
 * Description : This class is used to manage slider              *
				                                                  *
 *****************************************************************/
Class Settings {
	
	function getAnalyticsData($customer_id){
		global $dbcon;
		$analyticsData = "";
		$sql = "SELECT * FROM ".ANALYTICS_SETTINGS." WHERE customer_id = :customer_id";
        try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->bindParam(":customer_id",$customer_id);	
            $stmt->execute();			
            return $analyticsData = $stmt->fetch(PDO::FETCH_ASSOC);			
			
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getCMData($customer_id){
		global $dbcon;
		$cmData = "";
		$sql = "SELECT * FROM ".CM_SETTINGS." WHERE customer_id = :customer_id";
        try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->bindParam(":customer_id",$customer_id);	
            $stmt->execute();
            return $cmData = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	
	function updateAnalyticsData(){
		global $dbcon;		
		$customer_id = $_POST['customer_id'];			
		$sql = "UPDATE ".ANALYTICS_SETTINGS." SET site_name = :site_name,site_url = :site_url,receipient_to = :receipient_to,receipient_cc = :receipient_cc WHERE customer_id = :customer_id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":site_name",$_POST['site_name']);
		$sqlquery->bindParam(":site_url",$_POST['site_url']);
		$sqlquery->bindParam(":receipient_to",$_POST['receipient_to']);
		$sqlquery->bindParam(":receipient_cc",$_POST['receipient_cc']);
		$sqlquery->bindParam(":customer_id",$customer_id);
		return ($sqlquery->execute()) ? 1 : 0;	
	}
	
	function updateCMData(){
		global $dbcon;		
		$customer_id = $_POST['customer_id'];	
		$sql = "UPDATE ".CM_SETTINGS." SET default_receipient = :default_receipient,reply_email = :reply_email WHERE customer_id = :customer_id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":customer_id",$customer_id);
		$sqlquery->bindParam(":default_receipient",$_POST['default_receipient']);
		$sqlquery->bindParam(":reply_email",$_POST['reply_email']);
		return ($sqlquery->execute()) ? 1 : 0;	
	}
}