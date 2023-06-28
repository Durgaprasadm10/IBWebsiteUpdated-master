<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 26/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 01/09/2014  Version : 2.0   	 *
 * Description : this page will produce excel sheet of            		 *
                  view_details in analytics_byip page.            		 *
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


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$ip_address_input = $_POST['iphidden'];

$sql = "SELECT vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond." AND vi.ip_address = '".$ip_address_input."' ".$friendlyWebsites;

try {
    $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
	$count = $stmt->rowCount();
} catch (PDOException $e) {
    print $e->getMessage();
}


$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Visitor Tracker');


$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Date');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Time');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Country');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'City');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Ip Address');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Visited Page');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Page Referer');

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);

$i = 2;
if ($count > 0) {
    $analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);

    foreach ($analyticsData as $aData) {
		$key = array_search($coockie, $timezone_array);
		$tz = str_replace('-', '', $key );
		if ($tz == $key) {
			$time = date("d-m-Y H:i:s", strtotime($aData['datetime']) + ((int) $tz) * 60 * 60);
		} else {
			$time = date("d-m-Y H:i:s", strtotime($aData['datetime']) - ((int) $tz) * 60 * 60);
		}
		$aData[0] = (date("d-m-Y", strtotime($time)));
		$aData[1] = (date("H:i:s", strtotime($time)));
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $aData[0]);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $aData[1]);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $aData['country']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $aData['city']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $aData['ip_address']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $aData['page_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $aData['page_referer']);
        $i = $i + 1;
    }
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Ip-' . date("Y-m-d-H-i-s") . '.xls"');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
