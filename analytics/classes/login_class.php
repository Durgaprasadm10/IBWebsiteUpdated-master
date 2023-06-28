<?php
//error_reporting (E_ALL ^ E_NOTICE);
Class Login{
	
	function authendication($username,$password){ 
		global $dbcon;
		$newpassword = md5($password);	
		
		$query = "SELECT * FROM ".ADMIN_LOGIN." WHERE `username` = :username AND `password` = :password";
		$select_query = $dbcon->prepare($query);
        $select_query->bindParam(":username",$username);
		$select_query->bindParam(":password",$newpassword);
		$select_query->execute();		
		if($select_query->rowCount() > 0){
			return $select_query_result = $select_query->fetch();
		}else{
			$newpassword1 = encrypt($password, PASSWROD_SALT);	
			$query1 = "SELECT * FROM ".CUSTOMER_USERS_INFO." WHERE `username` = :username AND `password` = :password";
			$select_query1 = $dbcon->prepare($query1);
			$select_query1->bindParam(":username",$username);
			$select_query1->bindParam(":password",$newpassword1);
			$select_query1->execute();			
			if($select_query1->rowCount() > 0){
				return $select_query_result1 = $select_query1->fetch();
			}
		}
		return "";
	}	
	
	function checkCustomerStatus($customerid){ 
		global $dbcon;	
		$query1 = "SELECT id FROM ".CUSTOMER_INFO." WHERE `customer_id` = :customer_id AND delete_status = 0 AND active_status = 1";
		$select_query1 = $dbcon->prepare($query1);		
		$select_query1->bindParam(":customer_id",$customerid);
		$select_query1->execute();		
		return $select_query1->rowCount();
	}	
}
?>