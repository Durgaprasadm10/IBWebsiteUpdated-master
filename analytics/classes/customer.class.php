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
Class Customer {

	function addCustomer($postarray,$filearray){
	
		global $dbcon,$logininfo;
		$select_q_content = "SELECT id FROM ".CUSTOMER_INFO." WHERE (email = :email OR name = :name)";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":email",$postarray['email']);		
		$select_query->bindParam(":name",$postarray['name']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		}else{
			$select_q_content1 = "SELECT id FROM ".CUSTOMER_USERS_INFO." WHERE (email = :email OR username = :username)";
			$select_query1 = $dbcon->prepare($select_q_content1);
			$select_query1->bindParam(":email",$postarray['email']);		
			$select_query1->bindParam(":username",$postarray['username']);
			$select_query1->execute();
			$count1 = $select_query1->rowCount();			
			if($count1 > 0){
				$msg = 3;
			}else{
			
				if ($filearray["customerlogo"]["error"] > 0){
					$sNewFileName = "";
				}else{
					$present_time = date("dmYHis");
					$image_extention = explode("/",$filearray["customerlogo"]["type"]);
					$sNewFileName = "logo_".$present_time.".".$image_extention[1];
					
					move_uploaded_file($filearray["customerlogo"]["tmp_name"],CUSTOMER_LOGO_PATH.$sNewFileName);
				}			
				$cDate = date("Y-m-d H:i:s");
				$analyticStatus = (isset($postarray['analytics'])) ? 1 : 0;
				$cmStatus = (isset($postarray['campaignmanager'])) ? 1 : 0;
				
				$query = "INSERT INTO `".CUSTOMER_INFO."`(`name`, `customer_id`, `email`, `logo_image`,`phone`,`active_status`,`created_date`,`analytics_status`,`campaignmanager_status`) VALUES (:name, :customer_id, :email, :logo_image, :phone, :active_status, :created_date, :analytics_status, :campaignmanager_status)";
				$insert_query = $dbcon->prepare($query);
				$insert_query->bindParam(":name",$postarray['name']);
				$insert_query->bindParam(":logo_image",$sNewFileName);
				$insert_query->bindParam(":email",$postarray['email']);
				$insert_query->bindParam(":phone",$postarray['phone']);
				$insert_query->bindParam(":customer_id",$postarray['customer_id']);
				$insert_query->bindParam(":active_status",$postarray['active_status']);
				$insert_query->bindParam(":analytics_status",$analyticStatus);
				$insert_query->bindParam(":campaignmanager_status",$cmStatus);
				$insert_query->bindParam(":created_date",$cDate);
				$msg =  ($insert_query->execute()) ? 1 : 0;
			
				
				$userName = "Admin - ".$postarray['name'];					
				$password = encrypt($postarray['password'], PASSWROD_SALT);	
				$createdBy = "IBAdmin"; $createdById = $logininfo["id"]; $defaultUser = '1';				
				$query1 = "INSERT INTO `".CUSTOMER_USERS_INFO."`(`name`, `customer_id`, `email`, `username`,`password`,`active_status`,`created_date`,`created_by`,`created_by_id`,`default_user`) VALUES (:name, :customer_id, :email, :username, :password, :active_status, :created_date, :created_by, :created_by_id, :default_user)";
				$insert_query1 = $dbcon->prepare($query1);
				$insert_query1->bindParam(":customer_id",$postarray['customer_id']);
				$insert_query1->bindParam(":name",$userName);
				$insert_query1->bindParam(":email",$postarray['email']);
				$insert_query1->bindParam(":username",$postarray['username']);
				$insert_query1->bindParam(":password",$password);
				$insert_query1->bindParam(":active_status",$postarray['active_status']);
				$insert_query1->bindParam(":created_date",$cDate);
				$insert_query1->bindParam(":created_by",$createdBy);	
				$insert_query1->bindParam(":created_by_id",$createdById);
				$insert_query1->bindParam(":default_user",$defaultUser);				
				$msg =  ($insert_query1->execute()) ? 1 : 0;	

				$query2 = "INSERT INTO `".CM_SETTINGS."`(`customer_id`) VALUES (:customer_id)";
				$insert_query2 = $dbcon->prepare($query2);
				$insert_query2->bindParam(":customer_id",$postarray['customer_id']);
				$msg =  ($insert_query2->execute()) ? 1 : 0;	
				
				$query3 = "INSERT INTO `".ANALYTICS_SETTINGS."`(`customer_id`) VALUES (:customer_id)";
				$insert_query3 = $dbcon->prepare($query3);
				$insert_query3->bindParam(":customer_id",$postarray['customer_id']);
				$msg =  ($insert_query3->execute()) ? 1 : 0;	
				
			}
		}
		return $msg;
	}
	function updateCustomer($aPostarray,$filearray){
	
		global $dbcon;
		$select_q_content = "SELECT id FROM ".CUSTOMER_INFO." WHERE (email = :email OR name = :name) AND id != :id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":email",$aPostarray['email']);		
		$select_query->bindParam(":name",$aPostarray['name']);
		$select_query->bindParam(":id",$aPostarray['id']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;
		}else{
			$select_q_content1 = "SELECT id FROM ".CUSTOMER_USERS_INFO." WHERE (email = :email OR username = :username) AND customer_id != :customer_id";
			$select_query1 = $dbcon->prepare($select_q_content1);
			$select_query1->bindParam(":email",$aPostarray['email']);		
			$select_query1->bindParam(":username",$aPostarray['username']);
			$select_query1->bindParam(":customer_id",$aPostarray['customer_id']);
			$select_query1->execute();
			$count1 = $select_query1->rowCount();						
			if($count1 > 0){
				$msg = 3;
			}else{
				if($filearray["customerlogo"]["name"]!=""){
				
					$eData = $this->getDataById($aPostarray['id']);
					if($eData["logo_image"]!=""){
						$req_image_path = CUSTOMER_LOGO_PATH.$eData["logo_image"];
						if (file_exists($req_image_path)){
							unlink($req_image_path);
						}
					}
					$present_time = date("dmYHis");
					$image_extention = explode("/",$filearray["customerlogo"]["type"]);
					$sNewFileName = "logo_".$present_time.".".$image_extention[1];
					move_uploaded_file($filearray["customerlogo"]["tmp_name"],CUSTOMER_LOGO_PATH.$sNewFileName);
					
					$query = "INSERT INTO `".CUSTOMER_INFO."`(`name`, `customer_id`, `email`, `logo_image`,`phone`,`active_status`,`created_date`) 
					VALUES (:name, :customer_id, :email, :logo_image, :phone, :active_status, :created_date)";
					$query = "UPDATE ".CUSTOMER_INFO." SET `name` = :name,`customer_id` = :customer_id, `email` = :email, `logo_image` = :logo_image,`phone` = :phone, `active_status` = :active_status, `analytics_status` = :analytics_status, `campaignmanager_status` = :campaignmanager_status WHERE id = :id";				
				}else{
					$query = "UPDATE ".CUSTOMER_INFO." SET `name` = :name, `customer_id` = :customer_id, `email` = :email,`phone` = :phone, `active_status` = :active_status, `analytics_status` = :analytics_status, `campaignmanager_status` = :campaignmanager_status WHERE id = :id";
				}
				
				$analyticStatus = (isset($aPostarray['analytics'])) ? 1 : 0;
				$cmStatus = (isset($aPostarray['campaignmanager'])) ? 1 : 0;
				$update_query = $dbcon->prepare($query);
				$update_query->bindParam(":name",$aPostarray['name']);
				if($filearray["customerlogo"]["name"]!=""){
					$update_query->bindParam(":logo_image",$sNewFileName);
				}
				$update_query->bindParam(":customer_id",$aPostarray['customer_id']);
				$update_query->bindParam(":email",$aPostarray['email']);
				$update_query->bindParam(":phone",$aPostarray['phone']);
				$update_query->bindParam(":active_status",$aPostarray['active_status']);
				$update_query->bindParam(":analytics_status",$analyticStatus);
				$update_query->bindParam(":campaignmanager_status",$cmStatus);
				$update_query->bindParam(":id",$aPostarray['id']);
				$msg = ($update_query->execute()) ? 1 : 0;				
				
				$query1 = "UPDATE ".CUSTOMER_USERS_INFO." SET `email` = :email,`username` = :username, `active_status` = :active_status WHERE `customer_id` = :customer_id AND default_user = 1";
				$update_query1 = $dbcon->prepare($query1);
				$update_query1->bindParam(":customer_id",$aPostarray['customer_id']);
				$update_query1->bindParam(":email",$aPostarray['email']);
				$update_query1->bindParam(":username",$aPostarray['username']);
				$update_query1->bindParam(":active_status",$aPostarray['active_status']);				
				$msg = ($update_query1->execute()) ? 1 : 0;
			}
		}
		return $msg;
	}
	
	function getCustomerCount(){
		global $dbcon;
		$sql = "SELECT count(id) as count FROM ".CUSTOMER_INFO." WHERE delete_status = 0";
		try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            $ruserData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $ruserData['count'];
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getCustomerList(){
		global $dbcon,$start_limit;
		$customerData = "";
		$sql = "SELECT * FROM ".CUSTOMER_INFO." WHERE delete_status = 0 ORDER BY id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
		
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
		$sql = "SELECT c.*,cu.username as cu_username FROM `".CUSTOMER_INFO."` as c LEFT JOIN `".CUSTOMER_USERS_INFO."` as cu ON (c.customer_id = cu.customer_id AND cu.default_user = 1) WHERE c.id = ?";		
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
	
	function changeStatus($id,$status){
		global $dbcon,$moduleLabel;
		$update_q = "UPDATE ".CUSTOMER_INFO." SET active_status = :status WHERE id = :id";
		$update_query = $dbcon->prepare($update_q);
		$update_query->bindParam(":id",$id);
		$update_query->bindParam(":status",$status);
		$msg = ($update_query->execute()) ? 1 : 0;
		return $msg;
	}
	

	function deleteCustomer($id){
		global $dbcon;		
		$sql = "UPDATE ".CUSTOMER_INFO." SET delete_status = 1 WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}
	
	function updatePassword(){
		global $dbcon;		
		$password = encrypt($_GET['password'], PASSWROD_SALT);	
		$customer_id = $_GET['customer_id'];	
		
		$sql = "UPDATE ".CUSTOMER_USERS_INFO." SET password = :password WHERE customer_id = :customer_id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":customer_id",$customer_id);
		$sqlquery->bindParam(":password",$password);
		return $sqlquery->execute();
	}
}