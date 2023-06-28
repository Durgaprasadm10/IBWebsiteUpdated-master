<?php
include 'dbconfig.php';
//SELECT COUNT(unnumber) AS count, unnumber FROM `erap` group by `unnumber`
//$sql = "SELECT COUNT(DISTINCT unnumber) AS count, unnumber  FROM `erap` ";
$sql = "SELECT COUNT(un_number) AS count, un_number  FROM `dangerous_goods` GROUP BY `un_number`";
	$stmt = $dbcon->prepare($sql);
	$stmt->bindParam(":unnumber", $notmatched);
	$stmt->execute();
	$stmtResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//echo "<pre>";
	//print_r($stmtResult);
	foreach($stmtResult as $data){
		echo $data["un_number"] . "------" . $data["count"]."<br>";
	}
?>