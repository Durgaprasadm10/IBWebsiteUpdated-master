<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 03/04/2014                                      *
 * Created By : Vijaya                                            *
 * Vision : Project Visitortracking                               *  
 * Modified by : Vijaya     Date : 12/05/2014   Version : 1.1.0   *
 * Description : this page will produce excel sheet that          *
                 contains analytics_byip page results.            *
 *****************************************************************/
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

$sql = "SELECT vi.ip_address,vi.country,vi.city,count(vi.id) AS clicks FROM ".VISITORS_INFO." as vi WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites." GROUP BY vi.ip_address ORDER BY clicks DESC";
try {
	$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	$count = $stmt->rowCount();
} catch (PDOException $e) {
	print $e->getMessage();
}
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Visitor Tracker');

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'IPAddress');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Country');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'City');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Clicks');


$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

$i = 2;
if ($count > 0) {
    $analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
    foreach ($analyticsData as $aData) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $aData['ip_address']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $aData['country']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $aData['city']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $aData['clicks']);
        $i = $i + 1;
    }
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Vistor Tracking Report_byip-' . date("Y-m-d-H-i-s") . '.xls"');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
