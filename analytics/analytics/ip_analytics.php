<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 26/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 01/09/2014  Version : 2.0   	 *
 * Description : this page will give analytics when clicked on    		 *
                  view_details in analytics_byip page.           		 *
 ************************************************************************/
include "layouts/common/header.html";
include "search_filters_ipwise.php";

@$country_name_input = isset($_POST['ip_address']) ? $_POST['ip_address'] : $_GET['ip_address'];

@$ip_address_input = $_REQUEST['ip_address'];
if(!isset($ip_address_input) || ($ip_address_input == "")){
?>
	<script>
		window.location = "analytics_byip.php";
	</script>
	
<?php
}

$sql_for_total_count = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond." AND vi.ip_address = '".$ip_address_input."' ". $friendlyWebsites.$searhCond . " ORDER BY " . $orderField;
	

try {
	$stmt1 = $dbcon->prepare($sql_for_total_count, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt1->execute();	
	$no_of_rows_for_count = $stmt1->rowCount();
}catch (PDOException $e){
	print $e->getMessage();
}
if($no_of_rows_for_count > 0){	
	$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond." AND vi.ip_address = '".$ip_address_input."' ". $friendlyWebsites.$searhCond . " ORDER BY " . $orderField ." LIMIT ".$start_limit.",".ROW_PER_PAGE;
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
#example3_length,#example3_filter,#example3_processing{
	margin-bottom:20px;
}
#example3_paginate{
	margin-top:10px;
}
</style>
<script>

$(document).ready(function() {

	<?php if($no_of_rows > 0){ ?>
    $('#example3').dataTable( {

	     "bStateSave": true,

         "sPaginationType": "full_numbers"

    } );
	<?php } ?>    

} );

</script>

<div id="container">

	<div class="shell">

	

               <br />

		<!-- Main -->

		<div id="main">

			<div class="cl">&nbsp;</div> 
				
			<?php

echo "<h2 style='font-size:24px;'>Detailed Reports For <span style='color:red;'>$ip_address_input</span></h2><br>";

echo "<span style='font-size:14px;'>(Total Visit Count for the IP-Address =  <span style='color:red;'>$no_of_rows_for_count </span>) </span><br><br>";

echo "<table  id='mytable' class='display'>";

echo "<thead ><tr><th>Date</th><th>Time</th><th>Country</th><th>City</th><th>IP Address</th><th>Visited Page</th><th>Referer</th></tr></thead><tbody>";
?>

<?php
if($no_of_rows_for_count > 0){
	$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
	foreach($analyticsData as $aData){
		$key = array_search($coockie, $timezone_array);
		$tz = str_replace('-', '', $key );
		if ($tz == $key) {
			$time = date("d-m-Y H:i:s", strtotime($aData['datetime']) + ((int) $tz) * 60 * 60);
		} else {
			$time = date("d-m-Y H:i:s", strtotime($aData['datetime']) - ((int) $tz) * 60 * 60);
		}
		$aData[0] = html_escaped_output(date("d-m-Y", strtotime($time)));
		$aData[1] = html_escaped_output(date("H:i:s", strtotime($time)));
		echo "<tr><td>".$aData[0]."</td>";
		echo "<td>".$aData[1]."</td>";
		echo "<td>".$aData['country']."</td>";
		echo "<td>".$aData['city']."</td>";
		echo "<td>".$aData['ip_address']."</td>";
		echo "<td>".$aData['page_name']."</td>";
		
		if($aData['page_referer'] == ""){
			echo "<td>No Referrer/Direct Site Visitor</td>";
		}elseif($aData['page_referer'] != ""){
			echo "<td>".html_escaped_output($aData['page_referer'])."</td>";
		}
   
		echo "</tr>";
	}
}else{
	echo "<tr><td colspan='7' align='center'>No analytics found</td></tr>";
} 
echo "</tbody></table>";
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

        document.ipanalytics.action = "ip_analytics_excel.php";
        document.ipanalytics.target = "_blank";
        document.ipanalytics.submit();
      
    }
	 function makepdf() {
        document.ipanalytics.action = "ip_analytics_pdf.php";
        document.ipanalytics.target = "_blank";
        document.ipanalytics.submit();
    }
</script>
<script>
$(document).ready(function() {
   $('#DropDownTimezone1').hide();
});
</script>
<?php
if (!($no_of_rows > 0)){
?>
	<script>
	$(document).ready(function() {
	   $('#excelpdfDiv').hide();
	});
	</script>
<?php
}
?>

