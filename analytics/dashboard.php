<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 23/01/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : IB Innovation                                         *
 * Modified by : Pradeep G     Date : 05/02/2014    Version : V1  *
 * Description : Home page (Defaut page of sparkle)               *
 *****************************************************************/

error_reporting(0);

/* Includes header file and class file*/
include('includes/header.inc.php');

include("classes/customerusers.class.php");
$objCustomerUsers = new CustomerUsers();

@$customer_id =  (isset($_GET['customer_id'])) ? $_GET['customer_id'] : $_POST['customer_id'];
@$customerid =  (isset($_GET['customerid'])) ? $_GET['customerid'] : $_POST['customerid'];

if($logininfo['admin_type'] != "1"){
	$customer_id = $logininfo['customer_id'];
}else{
	if($customerid!=""){
		$customer_id = $objCustomerUsers->getCustomerIDById($customerid);	
	}
}

$cData = $objCustomerUsers->getCustomerInfoByCustomerId($customer_id);
$customerList = $objCustomerUsers->getCustomerList();	
include("layouts/dashboard.html");
exit;
?>