<?php
/******************************************************************
* Ideabytes Software India Pvt Ltd.                              *
* 50 Jayabheri Enclave, Gachibowli, HYD                          *
* Created Date : 30/06/2014                                      *
* Created By : Gayathri D                                        *
* Vision : Project Streaming Analytics                           *
* Modified by : Gayathri D    Date : 30/06/2014    Version :     *
* Description : login page the template                          *
*****************************************************************/

include('includes/header.inc.php');



include("classes/activitylog.class.php");
$oLog = new ActivityLog();

include("classes/login_class.php");
$oLogin = new Login();

$module = "Login";

/* Values from the form*/
@$action = (isset($_GET['action']) && ($_GET['action'] != "")) ? trim($_GET['action']) : trim($_POST['action']);
$sMsg = "&nbsp;";

if(@$action != "logout"){
	if(isset($logininfo["name"])){
		header("Location: index.php");
		exit;
	}
}

switch($action){
	case "resetPassewordForm":
		/* Display the reset password popup */
		include("layouts/reset_password.html");
	    break;
	case "resetPasseword":
		$email = $_POST['femail'];
		if($email != ""){
			$result = $oLogin->resetPassword($email);
			$sMsg = $result;
			$inputData = serialize($_POST);
			$oLog->addLog($module,$aActionForActivityLog[$action],$inputData,$result);
			if($result == 1){
			}else if( ($result == 2) || ($result == 3)){
				$sMsg_for_error_box = ($result == 2) ? "error in reseting password, Please try again." : "No User found according to the given email id";
			}
		}
		include("layouts/login.html");
		break;
	case "login":
		$username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
		$password = trim(filter_input(INPUT_POST, 'userpass', FILTER_SANITIZE_STRING));
		$result = $oLogin->authendication($username,$password);
		if(($result == 2) || ($result == 3) || (($result == 4))){
			$sMsg = $result;
			$sMsg_for_error_box = $aUserLoginError[$result];
			if($result == 3){
				$getBlockedStatus = $oLogin->getBlockedStatus($username);
				$login_attempt = $getBlockedStatus['login_attempt'];
				$sMsg_for_error_box = $getBlockedStatus['login_attempt']." of 4 (account will be blocked out after 4 consicutive errors)<br> Password does not match.";
			}
			$inputData = serialize($_POST);
			$oLog->addLog($module,"Login Failed",$inputData,$result);
			include("layouts/login.html");
		}else if(count($result)>1){
			$logingData["id"] = $result["id"];
			$logingData["name"] = $result["name"];
			$logingData["email"] = $result["email"];
			$logingData["admin_type"] = @$result["admin_type"];
			$logingData["admin_logged_status"] = @$result["admin_logged_status"];
			$logingData["customer_id"] = @$result["customer_id"];
			
			$userInfo = serialize($logingData);
			$_SESSION[LOG_SESSION] = $userInfo;	
			
			$inputData = serialize($_POST);
			$oLog->addLog($module,$aActionForActivityLog[$action],$inputData,"1");
			header("Location:index.php");
            exit;
		}
	    break;
	case "logout":
		$inputData = serialize($_GET);
		$oLog->addLog($module,$aActionForActivityLog[$action],$inputData);
		unset($_SESSION[LOG_SESSION]);
	default:
		/* Display the login form*/
		$oLog->addLog($module,"Show Login form");
		include("layouts/login.html");
	    break;
}

?>