<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 28/02/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project InfoFam                                       *  
 * Modified by : Gayathri     Date : 17/03/2014    Version : V1   *
 * Description : This class is used to manage slider              *
				                                                  *
 *****************************************************************/
Class CustomerUsers {

	function addCustomerUser($postarray){
	
		global $dbcon,$logininfo;
		$createdById = $logininfo["id"];
		$password = encrypt($postarray['password'], PASSWROD_SALT);
		
		$select_q_content = "SELECT id FROM ".CUSTOMER_USERS_INFO." WHERE (email = :email OR username = :username)";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":email",$postarray['email']);		
		$select_query->bindParam(":username",$postarray['username']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;
		}else{
					
			$cDate = date("Y-m-d H:i:s");			
			$createdBy = ($logininfo["admin_type"] == "1") ? "IBAdmin" : "Customer";
			$createdById = $logininfo["id"];
			$query = "INSERT INTO `".CUSTOMER_USERS_INFO."`(`name`, `customer_id`, `email`, `username`,`password`,`active_status`,`created_date`,`created_by`,`created_by_id`) VALUES (:name, :customer_id, :email, :username, :password, :active_status, :created_date, :created_by, :created_by_id)";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":name",$postarray['name']);
			$insert_query->bindParam(":email",$postarray['email']);
			$insert_query->bindParam(":username",$postarray['username']);
			$insert_query->bindParam(":password",$password);
			$insert_query->bindParam(":customer_id",$postarray['customer_id']);
			$insert_query->bindParam(":active_status",$postarray['active_status']);
			$insert_query->bindParam(":created_date",$cDate);
			$insert_query->bindParam(":created_by",$createdBy);
			$insert_query->bindParam(":created_by_id",$createdById);
			$msg =  ($insert_query->execute()) ? 1 : 0;
		}		
		return $msg;
	}
	function updateCustomerUser($aPostarray){
	
		global $dbcon;
		$select_q_content = "SELECT id FROM ".CUSTOMER_USERS_INFO." WHERE (email = :email OR username = :username) AND id != :id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":email",$aPostarray['email']);		
		$select_query->bindParam(":username",$aPostarray['username']);
		$select_query->bindParam(":id",$aPostarray['id']);
		$select_query->execute();
		$count = $select_query->rowCount();
		if($count > 0){
			$msg = 2;
		}else{
			
			$query = "UPDATE ".CUSTOMER_USERS_INFO." SET `name` = :name, `email` = :email,`username` = :username, `active_status` = :active_status WHERE id = :id";
			
			$update_query = $dbcon->prepare($query);
			$update_query->bindParam(":name",$aPostarray['name']);			
			$update_query->bindParam(":email",$aPostarray['email']);
			$update_query->bindParam(":username",$aPostarray['username']);
			$update_query->bindParam(":active_status",$aPostarray['active_status']);
			$update_query->bindParam(":id",$aPostarray['id']);
			$msg = ($update_query->execute()) ? 1 : 0;			
		}
		return $msg;
	}
	function getCustomerUsersCount($cid){
		
		global $dbcon;
		$customerId = $this->getCustomerIDById($cid);
		$sql = "SELECT count(id) as count FROM ".CUSTOMER_USERS_INFO." WHERE customer_id = :customer_id";
		try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->bindParam(":customer_id",$customerId);
            $stmt->execute();
            $ruserData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $ruserData['count'];
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getCustomerUsersList($cid){
		global $dbcon,$start_limit;
		$customerId = $this->getCustomerIDById($cid);
		$customerUsersData = "";
		$sql = "SELECT * FROM ".CUSTOMER_USERS_INFO." WHERE customer_id = :customer_id ORDER BY id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
		
        try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->bindParam(":customer_id",$customerId);
            $stmt->execute();
            return $customerUsersData = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getCustomerList(){
		global $dbcon,$start_limit;
		$customerData = "";
		$sql = "SELECT name,id,customer_id FROM ".CUSTOMER_INFO." WHERE delete_status = 0 ORDER BY id ASC";
        try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            return $customerData = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getDataById($id){
		global $dbcon;
		$sql = "SELECT * FROM `".CUSTOMER_USERS_INFO."` WHERE id = ?";
		try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute(array($id));
            $customerData = $stmt->fetch(PDO::FETCH_ASSOC);			
			return $customerData;
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
	}
	
	function getCustomerIDById($id){
		global $dbcon;
		$sql = "SELECT customer_id FROM `".CUSTOMER_INFO."` WHERE id = ?";
		try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute(array($id));
            $customerData = $stmt->fetch(PDO::FETCH_ASSOC);
			return $customerData['customer_id'];
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
	}
	
	function getCustomerInfoById($id){
		global $dbcon;
		$sql = "SELECT * FROM `".CUSTOMER_INFO."` WHERE id = ?";
		try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute(array($id));
            return $customerData = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
	}
	
	function getCustomerInfoByCustomerId($customer_id){
		global $dbcon;
		$sql = "SELECT * FROM `".CUSTOMER_INFO."` WHERE customer_id = ?";
		try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute(array($customer_id));
            return $customerData = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
	}
	
	function changeStatus($id,$status){
		global $dbcon,$moduleLabel;
		$update_q = "UPDATE ".CUSTOMER_USERS_INFO." SET active_status = :status WHERE id = :id";
		$update_query = $dbcon->prepare($update_q);
		$update_query->bindParam(":id",$id);
		$update_query->bindParam(":status",$status);
		$msg = ($update_query->execute()) ? 1 : 0;
		return $msg;
	}
	

	function deleteCustomerUser($id){
		global $dbcon;		
		$sql = "DELETE FROM ".CUSTOMER_USERS_INFO." WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}
	
	function updatePassword(){
		global $dbcon;		
		$password = encrypt($_GET['password'], PASSWROD_SALT);	
		$id = $_GET['id'];	
		
		$sql = "UPDATE ".CUSTOMER_USERS_INFO." SET password = :password WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		$sqlquery->bindParam(":password",$password);
		return $sqlquery->execute();
	}
}
