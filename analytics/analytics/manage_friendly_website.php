<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 18/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 18/08/2014  Version : 2.0   	 *
 * Description : This Page is to display friendly Website's Information	 *
 ************************************************************************/

	include ("includes/header.inc.php");
	include ("classes/FriendlyWebsite.class.php");
	
	@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
	switch ($action) 
	{
		case "delete":
			if (isset($_GET['id'])) 
			{
				$sql = "DELETE FROM `".FRIENDLYWEBSITE."` WHERE id = {$_GET['id']}";
				$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				$stmt->execute();
			}
			break;
			
		case "Change":
			if (isset($_GET['id'])) 
			{
				if (@$_GET['status'] == 1) 
				{
					$sql = "UPDATE `".FRIENDLYWEBSITE."` SET active_status=1 WHERE id = {$_GET['id']}";
				}
				else 
				{
					$sql = "UPDATE `".FRIENDLYWEBSITE."` SET active_status=0 WHERE id = {$_GET['id']}";
				}
				$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				$stmt->execute();
			}
			break;
			
		case "add":
			$strReplaceSiteName = str_replace("http://","",$_POST['site_name']);
			$strReplaceSiteName = str_replace("https://","",$strReplaceSiteName);
			$strReplaceSiteName = str_replace("www.","",$strReplaceSiteName);
			$sqlP = "SELECT site_name FROM `".FRIENDLYWEBSITE."` WHERE site_name = '" . @$strReplaceSiteName . "'";
			try
			{
				$stmtP = $dbcon->prepare($sqlP, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				$stmtP->execute();
			}
			catch (PDOException $e) 
			{
				print $e->getMessage();
			}
			if ($stmtP->rowCount() == 0) 
			{
				$sql = "INSERT INTO `".FRIENDLYWEBSITE."` (site_name) VALUES ('". @$strReplaceSiteName . "')";
				$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				$stmt->execute();
			} 
			else 
			{
				echo "<b><center> site name is already exist in friendly website list</b></center>";
			}
			break;
	}
	
	$sql = "SELECT * FROM ".FRIENDLYWEBSITE;		
	try 
	{
		$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
	}
	catch (PDOException $e) 
	{
		print $e->getMessage();
	}

	$frndlyweb = new FriendlyWebsite();
	$analyticsData = $frndlyweb->getFriendlyWebSite();

	include ("layouts/manage_friendly_website.html");
?>
