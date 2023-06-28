<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 08/05/2014                                      *
 * Created By : MahendraA                                          *
 * Vision : Project CampaignManager                                       *  
 * Modified by :     Version : V1   *
 * Description : login page  for admin                            *
 * *************************************************************** */

header("Location: ../login.php?btnlogout=logout");
exit;

/*
if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

include("classes/login_class.php");
$oLogin = new Login();

// Values from the form
@$action = (isset($_GET['action'])) ? trim($_GET['action']) : trim($_POST['action']);


switch ($action) {
    case "login":
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
        $password = trim(filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING));
        $result = $oLogin->authendication($username, $password);
        //$result = "success";
        if ($result == "success") {
            $_SESSION['login'] = "success";
            $_SESSION['loggeduser'] = $username;
            header("Location:dashboard.php");
            exit;
        } else {
            $sMsg = "<div class='error_box'>Login Failed, Please Try Again.</div>";
            include("layouts/login_view.html");
        }
        break;
    default:
        // Display the login form 
        include("layouts/login_view.html");
        break;
}

*/
?>