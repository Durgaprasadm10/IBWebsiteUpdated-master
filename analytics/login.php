<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 20/02/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : IB Innovation                                         *
 * Modified by : Pradeep G     Date : 09/06/2014    Version : V1  *
 * Description : Login page                                       *
 *****************************************************************/

include('includes/header.inc.php');

if(isset($_SESSION['login'])){
    header("Location: dashboard.php");
    exit;
}

include("classes/login_class.php");
$oLogin = new Login();

/* Values from the form*/
@$action = (isset($_GET['action'])) ? trim($_GET['action']) : trim($_POST['action']);
$sMsg = "&nbsp;";

switch($action){
	case "login":
		$username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
		$password = trim(filter_input(INPUT_POST, 'userpass', FILTER_SANITIZE_STRING));
		$result = $oLogin->authendication($username,$password);

		if(count($result)>1){			
			$loingData["id"] = $result["id"];
			$loingData["username"] = $result["username"];
			$loingData["email"] = $result["email"];
			$loingData["admin_type"] = @$result["admin_type"];
			$loingData["default_user"] = @$result["default_user"];
			$loingData["customer_id"] = @$result["customer_id"];
			$loingData["name"] = @$result["name"];
			
			if($result["active_status"] == "1"){				
				$customerStatus = $oLogin->checkCustomerStatus($loingData["customer_id"]);
				if(($customerStatus > 0) OR ($result["admin_type"] == "1")){
					$userInfo = serialize($loingData);
					$_SESSION['logininfo'] = $userInfo;			
					header("Location:dashboard.php");
					exit;
				}else{
					$sMsg = "Customer blocked. Contact Admin";
					include("layouts/login.html");
				}
				
			}else{
				$sMsg = "User blocked. Contact Admin";
				include("layouts/login.html");
			}
		}else{
			$sMsg = "Login Failed, Please Try Again";
			include("layouts/login.html");
		}
	    break;
	default:
		/* Display the login form*/
		include("layouts/login.html");
	    break;
}

?>
