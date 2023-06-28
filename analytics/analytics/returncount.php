<?php 
/*$dbconAnalytics = new PDO('mysql:host=198.12.159.153;port=3306;dbname=cmadmin_ib_analytics_new', 'cmadmin_dev', 'CmAdmin123', array( PDO::ATTR_PERSISTENT => false));*/

$mcon = mysql_connect('localhost', 'cmadmin_dev', 'CmAdmin123');

mysql_select_db('cmadmin_dgsms_analytics', $mcon);

$datetim = date('Y-m-d H:i:s');
echo $datetim;

$showd = date('Y-m-d H:i:s', strtotime("-1 day", strtotime($datetim)));
echo $showd;


$sele = mysql_query("SELECT COUNT(vi.ip_address) AS couip, vi.page_id, pa.id, pa.page_name FROM visitors_info AS vi LEFT JOIN page AS pa ON vi.page_id = pa.id WHERE datetime >= NOW() - INTERVAL 1 DAY GROUP BY vi.page_id ORDER BY ID DESC");

//$sele = mysql_query("SELECT COUNT(ip_address) AS couip, page_id FROM visitors_info GROUP BY ip_address ORDER BY ID DESC LIMIT 25");

echo "<table><th>Page Name</th><th>Return</th><th>NEW</th>";

while($reco = mysql_fetch_array($sele)){
$rcoun = $reco['couip'];


echo "<tr><td>";
echo $reco['page_name'];
echo "</td><td>";
if(($rcoun) > 1){

echo $reco['couip'];
echo "</td>";
}
if(($rcoun) == 1){
echo "<td>";
echo $reco['couip'];
echo "</td></tr>";
}


}
echo "</table><br /><br />";

echo "NEW USERS";

$selerow = mysql_query("SELECT COUNT(vi.ip_address) AS couip, vi.page_id, pa.id, pa.page_name FROM visitors_info AS vi LEFT JOIN page AS pa ON vi.page_id = pa.id WHERE datetime >= NOW() - INTERVAL 1 DAY GROUP BY vi.page_id ORDER BY ID DESC");

//$num_rows = mysql_num_rows($selerow);

//echo "$num_rows Rows\n";

echo "<table><th>Page Name</th><th>NEW</th>";

while($recorow = mysql_fetch_array($selerow)){
$rcoun = $recorow['couip'];

if(($rcoun) == 1){
echo "<tr><td>";
echo $recorow['page_name'];
echo "</td><td>";
echo $recorow['couip'];
echo "</td></tr>";
}


}
echo "</table>";


?>