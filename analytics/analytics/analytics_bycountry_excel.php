<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 25/08/2014  Version : 2.0   	 *
 * Description : this page will produce excel sheet that          		 *
                 contains all country based analytics             		 *
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


$sql = "SELECT vi.country,count(vi.id) AS clicks FROM ".VISITORS_INFO." as vi WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites." GROUP BY vi.country";
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

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Country');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Clicks');


$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);

$i = 2;
if ($count > 0) {
    $analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
    foreach ($analyticsData as $aData) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $aData['country']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $aData['clicks']);
        $i = $i + 1;
    }
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Vistor Tracking Report_ByCountry-' . date("Y-m-d-H-i-s") . '.xls"');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
