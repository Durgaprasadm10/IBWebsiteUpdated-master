<?php
include ("includes/header.inc.php");

include ("classes/admin_class.php");
$objMessages = new Messages();
$oRegister = new Admin();

$moduleLabel = "Admin";
$searchstring = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page']; 
if(!isset($page))
    $page = 1;    
if($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
	
	
@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id']; 



switch($action){
	case "register":
		$result = $oRegister->registration($_POST);
		if($result == "success"){
		$sMsg = $objMessages->success("Registration Success.");
		$count = $oRegister->getAdminCount();
			if($count>0){
				$adminList = $oRegister->getAdminList();
			}
			include("layouts/admin_list.html");
			exit;
		}
		if($result == 4){
			$sMsg = "<div class='error_box'>Password and confirm password are not equal</div>";	
		}else if($result == 1){
			$sMsg = "<div class='error_box'>Registration Success.</div>";
			
		}else if($result == 3){
				$sMsg = "<div class='error_box'>Email and Username alredy exists, Please Try Again</div>";
			}else if($result == 6){
				$sMsg = "<div class='error_box'>Username alredy exists, Please Try Again</div>";
			}elseif($result == 5){
				$sMsg = "<div class='error_box'>Email alredy exists, Please Try Again</div>";
			}
			include("layouts/forms/admin.html");
			//exit;
		
	    break;
		  case "changeStatus":  
		 /* Delete page */ 
				
			$sMsg1 = $oRegister->changeAdminStatus($id,$_GET["status"]);    
	
			if($sMsg1 == 1){
				$sMsg =  $objMessages->changestatusIndication($moduleLabel);
			}else{
				$sMsg = $objMessages->errorIndication($moduleLabel,$action);
			} 
		$count = $oRegister->getAdminCount();
			if($count>0){
				$adminList = $oRegister->getAdminList();
			}		
			include("layouts/admin_list.html");
		  break;
		case "addForm":   
		 /* Showing form for Add Page */
		
		include("layouts/forms/admin.html");
		break;
		case "resetPwd":
		case "view":     
		/* View Page data */  
			$Data = $oRegister->getDataById($id);
			include("layouts/admin_details_view.html");          
		break;
		case "reset":     
		/* reset password */ 
			$result = $oRegister->resetPwd($_POST);
			if($result == 1){
				$msg = $objMessages->success("Password Reset is Successful");
			}else if($result == 2){
				$msg = $objMessages->error("Password Reset is Un Successful");
			}else{
				$msg = $objMessages->warning("password, confirm password not matching, please try again.");
			}
			$Data = $oRegister->getDataById($_POST['reset_id']);
			include("layouts/admin_details_view.html");          
		break;
		case "delete":     
		/* delete account */ 
			$result = $oRegister->delete($id);
			if($result == 1){
				$sMsg = $objMessages->success("Admin User Deleted Successfully");
			}else if($result == 2){
				$sMsg = $objMessages->error("Admin User Deletion Un Successful");
			}else if($result == 3){
				$sMsg = $objMessages->warning("You Cannot delete Super Admin");
			}
	default:
		/* Display the login form*/
		$count = $oRegister->getAdminCount();
			if($count>0){
				$adminList = $oRegister->getAdminList();
			}
		include("layouts/admin_list.html");
	    break;
}

?>
