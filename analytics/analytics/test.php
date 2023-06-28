<?php 

$conn = mysql_connect('localhost', 'cmadmin_dev', 'CmAdmin123');//198.12.159.153
mysql_select_db('cmadmin_dgsms_analytics', $conn);

$yestr = mysql_query("SELECT * FROM `visitors_info` WHERE DATE(`datetime`) = CURDATE() - INTERVAL 1 DAY");

while($terd = mysql_fetch_array($yestr)){

$ipys = $terd['ip_address'] .'<br />';
$ystr = $terd['datetime'] .'<br />';
}

//echo $ipys;
$dayte = mysql_query("SELECT * FROM `visitors_info` WHERE DATE(`datetime`) < CURDATE() - INTERVAL 1 DAY AND ip_address NOT IN('$ipys') ORDER BY datetime DESC LIMIT 40");

while($ster = mysql_fetch_array($dayte)){

//echo $ster['datetime'] .'<br />';
//echo $ster['ip_address'] .'<br />';

}



?>