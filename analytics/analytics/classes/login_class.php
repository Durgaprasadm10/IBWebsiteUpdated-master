<?php
//error_reporting (E_ALL ^ E_NOTICE);
Class Login{
	
	function authendication($username,$password){ 
		global $dbcon;
		
		$password = encrypt($password, PASSWROD_SALT);
		
		$query = "SELECT * FROM ".ADMIN_LOGIN." WHERE `email` = :email AND `delete_status` = 0";
		$select_query = $dbcon->prepare($query);
        $select_query->bindParam(":email",$username);
		$select_query->execute();
		$count = $select_query->rowCount();
		if($count > 0){
			$select_query_result = $select_query->fetch();
			$status = $select_query_result['active_status'];
			$password_from_db = $select_query_result['password'];
			$login_attempt_no_from_db = $select_query_result['login_attempt'];
			$login_attempt_increased = $login_attempt_no_from_db + 1;
			$update_q = "UPDATE `".ADMIN_LOGIN."` SET `login_attempt` = :login_attempt WHERE `email` = :email";
			$update_query = $dbcon->prepare($update_q);
			$update_query->bindParam(":email",$username);
			$update_query->bindParam(":login_attempt",$login_attempt_increased);
			if($password_from_db == $password){
				$login_attempt_increased = 0;
				$update_query->execute();
				if($status == 1){									
					$select_query_result['admin_logged_status']="1";
					$select_query_result['customer_id']="";
					return $select_query_result;
				}else{					
					return 4; ////user blocked
				}
			}else{
				$login_attempt_increased = $login_attempt_no_from_db + 1;
				$update_query->execute();
				if($login_attempt_increased >= 4){
					$this->blockAccount($username,ADMIN_LOGIN);
					return 4; ////user blocked
				}else{
					return 3; //invalid password
				}				
			}
		}
		else{
			$query1 = "SELECT * FROM ".CUSTOMER_USERS." WHERE `email` = :email AND `delete_status` = 0";
			
			$select_query1 = $dbcon->prepare($query1);
			$select_query1->bindParam(":email",$username);
			$select_query1->execute();			
			if($select_query1->rowCount() > 0){
				$select_query_result1 = $select_query1->fetch();
				$status = $select_query_result1['active_status'];
				$password_from_db = $select_query_result1['password'];
				$login_attempt_no_from_db = $select_query_result1['login_attempt'];
				$login_attempt_increased = $login_attempt_no_from_db + 1;
				$update_q = "UPDATE `".CUSTOMER_USERS."` SET `login_attempt` = :login_attempt WHERE `email` = :email";
				$update_query = $dbcon->prepare($update_q);
				$update_query->bindParam(":email",$username);
				$update_query->bindParam(":login_attempt",$login_attempt_increased);
				if($password_from_db == $password){
					$login_attempt_increased = 0;
					$update_query->execute();
					if($status == 1){									
						$select_query_result1['admin_logged_status']="0";
						return $select_query_result1;
					}else{					
						return 4; ////user blocked
					}
				}else{
					$login_attempt_increased = $login_attempt_no_from_db + 1;
					$update_query->execute();
					if($login_attempt_increased >= 4){
						$this->blockAccount($username,CUSTOMER_USERS);
						return 4; ////user blocked
					}else{
						return 3; //invalid password
					}
				}
			}else{
				return 2; // user not found
			}
		}
		return "";
	}
		
	function resetPassword($email){
		global $dbcon;
		$required_email = "";
		//$rand_for_password = rand();
		$rand_for_password = generatePassword();
		
		//$hashPassword = md5($rand_for_password);
		$hashPassword = encrypt($rand_for_password, PASSWROD_SALT);
		
		$query2 = "SELECT * FROM `".ADMIN_LOGIN."` WHERE email = :email";
		$select_query2 = $dbcon->prepare($query2);
		$select_query2->bindParam(":email",$email);
		$select_query2->execute();
		$count2 = $select_query2->rowCount();
		if($count2 > 0){
			$select_query_result = $select_query2->fetch();
			
			$required_email = $select_query_result['email'];
			//$required_first_name = $select_query_result['first_name'];
			//$required_last_name = $select_query_result['last_name'];
			$required_name = $select_query_result['name'];
			$required_id = $select_query_result['id'];
			$sql = "UPDATE `".ADMIN_LOGIN."` SET `active_status` = '1',`password` = :password WHERE id = :id";
			try {
				$stmt = $dbcon->prepare($sql);
				$stmt->bindParam(":password",$hashPassword);
				$stmt->bindParam(":id",$required_id);
				$stmt->execute();
				$stmt = null;
				$result = 1;
			}catch (PDOException $e){
				$result = 2;
				print $e->getMessage();
			}
		}else{
			$result = 3;
		}
		
		//mail new password
    
		if($required_email != ""){
			$subject = APPNAME."  | Successful Reset Password";
			 $message = CONST_MAIL_RESET_PSW_MSG;			
			$message = str_replace("{NAME}",$required_name,$message);
			$message = str_replace("{NEW_PSWD}",$rand_for_password,$message);
			sendMail($required_email,FROM_EMAIL,$subject,$message);
		}
		return $result;
	}
	
	function getBlockedStatus($email) {
		global $dbcon;
		$query = "SELECT * FROM ".ADMIN_LOGIN." WHERE `email` = :email";
		$select_query = $dbcon->prepare($query);
        $select_query->bindParam(":email",$email);
		$select_query->execute();
		$select_query->rowCount();
		if($select_query->rowCount() > 0){
			return $result = $select_query->fetch(PDO::FETCH_ASSOC);
		}else{
			$query1 = "SELECT * FROM ".CUSTOMER_USERS." WHERE `email` = :email";
			$select_query1 = $dbcon->prepare($query1);
			$select_query1->bindParam(":email",$email);
			$select_query1->execute();
			$select_query1->rowCount();
			if($select_query1->rowCount() > 0){
				return $result1 = $select_query1->fetch(PDO::FETCH_ASSOC);
			}
		}
		return "";
	}
	
	function blockAccount($email,$table) {
		global $dbcon;
		$update_q = "UPDATE `".$table."` SET `active_status` = '0', `login_attempt` = '0' WHERE `email` = :email";
		$update_query = $dbcon->prepare($update_q);
		$update_query->bindParam(":email",$email);
		$update_query->execute();
		
	}
}
?>