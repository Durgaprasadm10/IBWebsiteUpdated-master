<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : IB Innovation                                         *
 * Modified by : Gayathri     Date : 22/01/2014    Version : V1   *
 * Description : page management for admin                        *
 *****************************************************************/
 
include("includes/header.inc.php");

include("classes/settings.class.php");
$objMessages = new Messages();
$settings = new Settings();
$moduleLabel = "Settings"; 


include("classes/customerusers.class.php");
$objCustomerUsers = new CustomerUsers();
	
@$action =  (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$customer_id =  (isset($_GET['customer_id'])) ? $_GET['customer_id'] : $_POST['customer_id'];
@$customerid =  (isset($_GET['customerid'])) ? $_GET['customerid'] : $_POST['customerid'];

if($logininfo['admin_type'] != "1"){
	$customer_id = $logininfo['customer_id'];
}else{
	if($customerid!=""){
		$customer_id = $objCustomerUsers->getCustomerIDById($customerid);		
	}
}
$sMsg = "";
 
switch($action){	
	case "UpdateCm":
	case "UpdateAnalytics":			
		/* Add and update customer users */ 				
		if($action=="UpdateAnalytics"){				
			$sMsg1 = $settings->updateAnalyticsData($_POST);
			if($sMsg1 == 1)
				$sMsg = $objMessages->success("Analytics Settings sucessfully updated");
			else
				$sMsg = $objMessages->error("Analytics Settings not updated");
		}else{
			$sMsg1 = $settings->updateCMData($_POST);
			if($sMsg1 == 1)
				$sMsg = $objMessages->success("Campaing Manager Settings sucessfully updated");
			else
				$sMsg = $objMessages->error("Campaing Manager Settings not updated");
		}			
	default:
    		/* List the customer users  */
			$customerList = $objCustomerUsers->getCustomerList();	
			$analyticsData = $settings->getAnalyticsData($customer_id);	
			$cmData = $settings->getCMData($customer_id);	
            include("layouts/settings.html");
               
}
 
?>