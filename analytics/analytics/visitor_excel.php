<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 28/08/2014  Version : 2.0   	 *
 * Description : this page will produce Excel of analytics for   		 *
                Filter page.                                     		 *
 ************************************************************************/
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

include 'includes/header.inc.php';
	
/** Include PHPExcel */
require_once 'lib/excel/Classes/PHPExcel.php';

@$cn = $_POST['cn'];
@$cyn = $_POST['cyn'];
@$Ip = $_POST['Ip'];
@$pid = $_POST['pid'];
@$pdate = $_POST['pdate'];
@$ptodate = $_POST['ptodate'];
@$pfromdate = $_POST['pfromdate'];
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$searhCond = "";

if (@$cn != "" && ($cn != "All")) {
    $searhCond .= " AND vi.country='" . $cn . "'";
    $CountryName = @$cn;
} else {
    $CountryName = "All";
}
if (@$cyn != "") {
	$searhCond .= " AND vi.city='" . $cyn . "'";
    $City = @$cyn;
} else {
    $City = "All";
}
if (@$Ip != "") {
    $searhCond .= " AND vi.ip_address='" . $Ip . "'";
    $IpAddress = @$Ip;
} else {
    $IpAddress = "All";
}

if (@$pid != "") {
    $searhCond .= " AND vi.page_id='" . $pid . "'";
    try {

        $stmt = $dbcon->prepare("SELECT page_name FROM `page` WHERE id=" . $pid, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
            foreach ($analyticsData as $aData) {
                $Page = $aData['page_name'];
            }
        }
    } catch (PDOException $e) {
        print $e->getMessage();
    }
} else {
    $Page = 'ALL';
}
	$event_tab_type_radio = (@$_POST['event_tab_type'] != "") ? $_POST['event_tab_type'] : 1;
		if($event_tab_type_radio == 1){
				if (@$pfromdate != "") {
					$searhCond .= " AND date(vi.datetime)='" . $pfromdate . "'";
				}
			}else
			{
			
				if(isset($pdate) && isset($ptodate) && (@$pdate!="") && (@$ptodate!="")){
				$searhCond .= " AND DATE(vi.datetime) BETWEEN '".$pdate."' AND '".$ptodate."'";
				}
			}

 $orderField = "";

$i = 0;
if (count(@$_POST['order_type']) > 0) {
	
	foreach(@$_POST['order_type'] as $value){
	
		$orderField .= $value." ".$_POST['order_by'][$i] .",";
				
		$i=$i+1;					
	}
	$orderField = substr($orderField,0,(strlen($orderField) - 1));
	
}else{
	$orderField = 'vi.datetime DESC';
}			
			 
//$sql_for_total_count = "SELECT * FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON vi.page_id = p.id WHERE vi.geo_info_status = 1 ".$deviceCond." AND vi.ip_address NOT IN (" . $friendlyIps . ")" .$friendlyWebsites. $searhCond . " ORDER BY " . $orderField;

$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON vi.page_id = p.id WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites. $searhCond . " ORDER BY " . $orderField;

try {
    $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
	$count = $stmt->rowCount();
} catch (PDOException $e) {
    print $e->getMessage();
	$count = 0;
}
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Visitor Tracker');

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Country : ' . $CountryName);
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'City : ' . $City);
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Ip Address : ' . $IpAddress);
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Page : ' . $Page);

$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Date');
$objPHPExcel->getActiveSheet()->setCellValue('B7', 'Time');
$objPHPExcel->getActiveSheet()->setCellValue('C7', 'Country');
$objPHPExcel->getActiveSheet()->setCellValue('D7', 'City');
$objPHPExcel->getActiveSheet()->setCellValue('E7', 'Ip Address');
$objPHPExcel->getActiveSheet()->setCellValue('F7', 'Visited Page');
$objPHPExcel->getActiveSheet()->setCellValue('G7', 'Page Referer');

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G7')->getFont()->setBold(true);

$i = 8;
if ($count > 0) {
    $analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);

    foreach ($analyticsData as $aData) {
		$datetime = date("d-m-Y H:i:s", strtotime($aData['dtTimezone']));
		$date = html_escaped_output(date("d-m-Y", strtotime($datetime)));
		$time = html_escaped_output(date("H:i:s", strtotime($datetime)));
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $date);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $time);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $aData['country']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $aData['city']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $aData['ip_address']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $aData['page_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $aData['page_referer']);
        $i = $i + 1;
    }
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Vistortracking-' . date("Y-m-d-H-i-s") . '.xls"');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
