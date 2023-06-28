<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
include('includes/header.inc.php');

if(isset($_GET['option']))
{
    $option = $_GET['option'];
	if($option == "All"){
		$searchCon = "";
	}else{
		$searchCon  = " AND vi.country = '".$option."' ";
	}
	$sqlC = "SELECT distinct(city) as city FROM visitors_info as vi WHERE vi.geo_info_status = 1 ".$searchCon." ORDER BY city ASC";
	try {
		$stmtC = $dbcon->prepare($sqlC, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmtC->execute();
	} catch (PDOException $e) {
		print $e->getMessage();
	}
	$data  = array();
	if ($stmtC->rowCount() > 0) {
		$analyticsDataC = $stmtC->fetchALL(PDO::FETCH_ASSOC);
		foreach ($analyticsDataC as $aData) {
			$data[] = $aData["city"].":::".$aData["city"];
		}
	}
    $reply = array('data' => $data, 'error' => false);
}
else
{
    $reply = array('error' => true);
}

$json = json_encode($reply);    
echo $json; 
?>