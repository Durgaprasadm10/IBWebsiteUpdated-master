<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project Blister                                       *  
 * Modified by : Gayathri     Date : 22/01/2014    Version : V1   *
 * Description : page management for admin                        *
 *****************************************************************/
 
include("includes/header.inc.php");

include("classes/user.class.php");
$objMessages = new Messages();
$objUser = new User();



$moduleLabel = "Member"; 
$searchstring = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];

if(!isset($page))
    $page = 1;    
if($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
	
@$action =  (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id =  (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];

 
 switch($action){
    
     
	  case "changeStatus":  
			 /* Delete page */ 
				
				$sMsg1 = $objUser->changeStatus($id,$_GET["status"]);    
			
			
			if($sMsg1 == 1){
				$sMsg =  $objMessages->changestatusIndication($moduleLabel);
			}else{
				$sMsg = $objMessages->errorIndication($moduleLabel,$action);
			} 
			$count = $objUser->getUserCount();
			if($count>0){
				$userList = $objUser->getUserList();
			}			
			include("layouts/user_list.html");
		  break;
		case "delete":
		/* Delete record */ 
			$objUser->deleteStatus($id);  
			$count = $objUser->getUserCount();
			if($count>0){
				$userList = $objUser->getUserList();
			}			
             include("layouts/user_list.html");
       
        break;
		 case "view":     
		/* View Page data */  
		$usermanagementData = $objUser->getDataById($id);
		include("layouts/user_management_view.html");          
		break;
		default:
    		/* List the sliders  */
			$count = $objUser->getUserCount();
			
			if($count>0){
				$userList = $objUser->getUserList();
			}
            include("layouts/user_list.html");
               
}
 
?>