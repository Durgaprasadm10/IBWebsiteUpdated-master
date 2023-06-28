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

if($logininfo['admin_type']!="1"){
	header("Location: dashboard.php");
	exit;
}

include("classes/customer.class.php");
$objMessages = new Messages();
$objCustomer = new Customer();

$moduleLabel = "Customer"; 
$searchstring = ""; $sMsg = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];

if(!isset($page))
    $page = 1;    
if($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
	
@$action =  (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id =  (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];


switch($action){
	case "Updatepassword":
		$objCustomer->updatePassword();exit;
		break;
	case "Add":
	case "Edit":		
		/* Add and update customers */ 				
		if($action=="Add"){				
			$sMsg1 = $objCustomer->addCustomer($_POST,$_FILES);
		}else{		
			$sMsg1 = $objCustomer->updateCustomer($_POST,$_FILES);
		}
		
		if($sMsg1 == 1){
			$sMsg = $objMessages->addupdatesucessIndication($moduleLabel,$action);
			$count = $objCustomer->getCustomerCount();
			if($count>0){
				$customerList = $objCustomer->getCustomerList();
			}
            include("layouts/customer.html");  
		}else if($sMsg1 == 3){            
			$sMsg = $objMessages->error("Admin accounts already exist");
			
			if($id != "")					
				$customerData = $objCustomer->getDataById($id);			
						
			include("layouts/forms/customer.html");
		}else{
			
			if($sMsg1 == 0)
			   $sMsg = $objMessages->errorIndication($moduleLabel,$action);
			else if($sMsg1 == 2)
				$sMsg = $objMessages->duplicateIndication($moduleLabel);			
			
			if($id != "")					
				$customerData = $objCustomer->getDataById($id);			
						
			include("layouts/forms/customer.html");
		}
		break;
    case "editForm":
		$customerData = $objCustomer->getDataById($id);
	case "addForm":   		
		include("layouts/forms/customer.html");
		break;
    case "view":     
			/* View customer data */  
			$customerData = $objCustomer->getDataById($id);
			include("layouts/customer_view.html");          
			break; 
	case "changeStatus":  	 
	case "delete":
			if($action == "changeStatus"){
				/* Change status*/ 	
				$sMsg1 = $objCustomer->changeStatus($id,$_GET["status"]);    
				if($sMsg1 == 1){
					$sMsg =  $objMessages->changestatusIndication($moduleLabel);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}else if($action == "delete"){	
				/* Delete record */ 
				$sMsg1 = $objCustomer->deleteCustomer($id);  
				if($sMsg1 == 1){
					$sMsg =  $objMessages->addupdatesucessIndication($moduleLabel,$action);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}
	default:
    		/* List the customers  */
			$count = $objCustomer->getCustomerCount();
			if($count>0){
				$customerList = $objCustomer->getCustomerList();
			}
            include("layouts/customer.html");
               
}
 
?>