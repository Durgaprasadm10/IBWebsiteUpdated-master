<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 26/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 01/09/2014  Version : 2.0   	 *
 * Description : this page produce given country analytics        		 *
 ************************************************************************/
include "header.php";
include "search_filters_country.php";

@$country_name_input = isset($_POST['country']) ? $_POST['country'] : $_GET['country'];


if(!isset($country_name_input) || ($country_name_input == "")){
?>
	<script>
		window.location = "analytics_bycountry.php";
	</script>
	
<?php
}

$sql_for_total_count = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond." AND vi.country = '".$country_name_input."' ".$friendlyIpsCond. $friendlyWebsites.$searhCond . " ORDER BY " . $orderField;

try {
		$stmt1 = $dbcon->prepare($sql_for_total_count, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt1->execute();	
		$no_of_rows_for_count = $stmt1->rowCount();
	}catch (PDOException $e){
		print $e->getMessage();
	}
if($no_of_rows_for_count > 0){
	$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond." AND vi.country = '".$country_name_input."' ".$friendlyIpsCond. $friendlyWebsites.$searhCond . " ORDER BY " . $orderField ." LIMIT ".$start_limit.",".ROW_PER_PAGE;
	try {
		$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();	
		$no_of_rows = $stmt->rowCount();
	}catch (PDOException $e){
		print $e->getMessage();
	}
}

?>
<style>
#example4_length,#example4_filter,#example4_processing{
	margin-bottom:20px;
}
#example4_paginate{
	margin-top:10px;
}
</style>



<div id="container">

	<div class="shell">

		

		
               <br />

		<!-- Main -->

		<div id="main">

			<div class="cl">&nbsp;</div> 
				

			<?php

  



echo "<h2 style='font-size:24px;'>Detailed Reports For Country <span style='color:red;'> $country_name_input</span></h2><br>";

echo "<span style='font-size:14px;'>( Total Visit Count for the Country = <span style='color:red;'> $no_of_rows_for_count </span>)</span><br><br>";

echo "<table  id='mytable' class='display'>";

 echo "<thead><tr><th>Date</th><th>Time</th><th>IP</th><th>Country</th><th>City</th><th>Visited Page</th><th>Referer</th></tr></thead><tbody>";
?>
			
<?php
if($no_of_rows_for_count > 0){

	$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
	foreach($analyticsData as $aData){
		$datetime = date("d-m-Y H:i:s", strtotime($aData['dtTimezone']));
		$date = html_escaped_output(date("d-m-Y", strtotime($datetime)));
		$time = html_escaped_output(date("H:i:s", strtotime($datetime)));
		echo "<tr><td>".$date."</td>";
		echo "<td>".$time."</td>";
		echo "<td>".$aData['ip_address']."</td>";
		echo "<td>".$aData['country']."</td>";
		echo "<td>".$aData['city']."</td>";
		echo "<td>".$aData['page_name']."</td>";
		if($aData['page_referer'] == ""){
			echo "<td>No Referrer/Direct Site Visitor</td>";
		}elseif($aData['page_referer'] != ""){
			echo "<td>".html_escaped_output($aData['page_referer'])."</td>";
		}
   
		echo "</tr>";
	}
}else{
	echo "<tr><td colspan='6' align='center'>No analytics found</td></tr>";
} 

echo "</tbody></table>";
echo "<br><br>";
//Display pagging
echo '<span style="float:right;padding-right:85px;">';

if($no_of_rows_for_count > 0){
	echo doPages(ROW_PER_PAGE, $pageName, $searchstring, $no_of_rows_for_count);
}
echo '</span>';
?>

<div class="cl">&nbsp;</div>			

		</div>

		<!-- Main -->

	</div>

</div>

<!-- End Container -->			



<?php
include "footer.php";


?>
<script>
 function exportExcel() {

        document.searchby.action = "country_analytics_excel.php";
        document.searchby.target = "_blank";
        document.searchby.submit();
        document.searchby.target = "";
        document.searchby.action = "country_analytics.php";
        return false;
    }
	 function makepdf() {
        document.searchby.action = "country_analytics_pdf.php";
        document.searchby.target = "_blank";
        document.searchby.submit();
		document.searchby.target = "";
		return false;
    }
	
</script>
<script>
$(document).ready(function() {
   $('#DropDownTimezone1').hide();
});
</script>
<?php
if (!($stmt->rowCount() > 0)){
?>
	<script>
	$(document).ready(function() {
	   $('#excelpdfDiv').hide();
	});
	</script>
<?php
}
?>
