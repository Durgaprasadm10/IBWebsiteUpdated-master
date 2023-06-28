<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 18/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 18/08/2014  Version : 2.0   	 *
 * Description : This Page is to display friendly_ip's Information		 *
 ************************************************************************/

include ("includes/header.inc.php");
include ("classes/FriendlyIp.class.php");

@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
switch ($action) {

    case "delete":
        if (isset($_GET['id'])) 
		{
            $sql = "DELETE FROM friendly_ip WHERE id = {$_GET['id']}";
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
        }
        break;
		
    case "Change":
        if (isset($_GET['id'])) 
		{
            if (@$_GET['status'] == 1) 
			{
                $sql = "UPDATE friendly_ip SET active_status=1 WHERE id = {$_GET['id']}";
            }
			else 
			{
                $sql = "UPDATE friendly_ip SET active_status=0 WHERE id = {$_GET['id']}";
            }
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
        }
        break;
		
    case "add":
        $sqlP = "SELECT ipaddress FROM friendly_ip WHERE ipaddress = '" . @$_POST['ipaddress'] . "'";
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
            $sql = "INSERT INTO friendly_ip (ipaddress) VALUES ('" . @$_POST['ipaddress'] . "')";
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
        }
		else 
		{
            echo "<b><center> IpAddress is already exist in friendly Ipaddress list</b></center>";
        }
        break;
}

$sql = "SELECT ipaddress,id,active_status FROM ".FRIENDLYIP;

try {
    $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
} catch (PDOException $e) {
    print $e->getMessage();
}

$frndlyip = new FriendlyIp();
$analyticsData = $frndlyip->getFriendlyIP();

include ("layouts/manage_friendly_ip.html");
?>