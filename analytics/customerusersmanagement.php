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

include("classes/customerusers.class.php");
$objMessages = new Messages();
$objCustomerUsers = new CustomerUsers();

$moduleLabel = "Customer User"; 
$searchstring = ""; $sMsg = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];

if(!isset($page))
    $page = 1;    
if($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
	
	
@$action =  (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id =  (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];
@$customerid =  (isset($_GET['customerid'])) ? $_GET['customerid'] : $_POST['customerid'];
$customer_id = "";

if($logininfo['admin_type'] != "1"){
	$cusData = getCustomerInfo($logininfo['customer_id']);
	$customerid = $cusData["id"];
}

if($customerid > 0){
	$searchstring .= "&customerid=".$customerid;
}
 
switch($action){
	case "Updatepassword":
		$objCustomerUsers->updatePassword();exit;
		break;
	case "Add":
	case "Edit":			
		/* Add and update customer users */ 				
		if($action=="Add"){				
			$sMsg1 = $objCustomerUsers->addCustomerUser($_POST);
		}else{
			$sMsg1 = $objCustomerUsers->updateCustomerUser($_POST);
		}
		
		if($sMsg1 == 1){
			$customerId = $_POST['customerid'];
			$sMsg = $objMessages->addupdatesucessIndication($moduleLabel,$action);
			$customerList = $objCustomerUsers->getCustomerList();	
			
			if($customerId > 0){	
				$count = $objCustomerUsers->getCustomerUsersCount($customerId);
				if($count>0){
					$customerUsersList = $objCustomerUsers->getCustomerUsersList($customerId);
				}
			}
            include("layouts/customerusers.html");  
		}else{
			
			if($sMsg1 == 0)
			   $sMsg = $objMessages->errorIndication($moduleLabel,$action);
			else if($sMsg1 == 2)
				$sMsg = $objMessages->duplicateIndication($moduleLabel);			
			
			if($id != "")					
				$customerUserData = $objCustomerUsers->getDataById($id);			
			
			include("layouts/forms/customerusers.html");
		}
		break;
    case "editForm":
		$customerUserData = $objCustomerUsers->getDataById($id);
	case "addForm":   		
		include("layouts/forms/customerusers.html");
		break;
    case "view":     
			/* View customer users data */  
			$customerUserData = $objCustomerUsers->getDataById($id);
			include("layouts/customerusers_view.html");          
			break; 
	case "changeStatus":  	 
	case "delete":
			if($action == "changeStatus"){
				/* Change status*/ 	
				$sMsg1 = $objCustomerUsers->changeStatus($id,$_GET["status"]);    
				if($sMsg1 == 1){
					$sMsg =  $objMessages->changestatusIndication($moduleLabel);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}else if($action == "delete"){	
				/* Delete record */ 
				$sMsg1 = $objCustomerUsers->deleteCustomerUser($id);  
				if($sMsg1 == 1){
					$sMsg =  $objMessages->addupdatesucessIndication($moduleLabel,$action);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}
	default:
    		/* List the customer users  */
			$customerList = $objCustomerUsers->getCustomerList();	
			if($customerid > 0){	
				$count = $objCustomerUsers->getCustomerUsersCount($customerid);
				if($count>0){
					$customerUsersList = $objCustomerUsers->getCustomerUsersList($customerid);
				}
			}
            include("layouts/customerusers.html");
               
}
 
?>