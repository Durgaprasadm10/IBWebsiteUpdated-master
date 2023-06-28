<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 29/08/2014  Version : 2.0   	 *
 * Description : this page will produce excel that                		 *
                 contains analytics_bymonth page results.         		 *
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

$present_year = date('Y');
$mClickCount = array();

$selectedmonth = $_GET['selectedmonth'];
$selectedyear = $_GET['selectedyear'];

$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as datetime1, vi.*,p.* FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON vi.page_id = p.id WHERE vi.geo_info_status = 1 ".$deviceCond." AND (YEAR(CONVERT_TZ(datetime,'+00:00','".$coockie."')) = ".$selectedyear.") AND (MONTH(CONVERT_TZ(datetime,'+00:00','".$coockie."')) = ".$selectedmonth.") ".$friendlyIpsCond.$friendlyWebsites;

try {
		$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		$count = $stmt->rowCount();
		if($count > 0)
		{
			$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
		}

		}catch (PDOException $e){
			print $e->getMessage();
		}


$months_names = array(1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",7=>"Jul",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec");


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
   

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Vistortrackingreport_bymonth-' . date("Y-m-d-H-i-s") . '.xls"');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
