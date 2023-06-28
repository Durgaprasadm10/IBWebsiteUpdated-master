<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 28/08/2014  Version : 2.0   	 *
 * Description : this page will produce excel sheet that         		 *
                 contains analytics_bydaterange page results.     		 *
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

$searhCond = $_POST['searhCond'];
$orderby = $_POST['orderby'];
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

/*$searhCond = "";
if(isset($_POST['page_id']) && (@$_POST['page_id']!="")){
		$searhCond .= " AND vi.page_id = ".$_POST['page_id'];
	}
	if(isset($_POST['country_name']) && (@$_POST['country_name']!="")){
		$searhCond .= " AND vi.country = '".$_POST['country_name']."'";
	}
	if(isset($_POST['fromdate']) && isset($_POST['todate']) && (@$_POST['fromdate']!="") && (@$_POST['todate']!="")){
		$searhCond .= " AND DATE(vi.datetime) BETWEEN '".$_POST['fromdate']."' AND '".$_POST['todate']."'";
	}
	
	$orderby = "ASC";
	if(isset($_POST['order']) && (@$_POST['order']!="")){
		$orderby = ($_POST['order'] == "Descending") ? "DESC" : "ASC";
	}*/
	
	$sql = "SELECT DATE(vi.datetime) as dates,count(vi.id) AS clicks FROM ".VISITORS_INFO." as vi WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites.$searhCond." GROUP BY DATE(vi.datetime) ".$orderby;
	
	try {
		$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
	} catch (PDOException $e) {
		print $e->getMessage();
	}


	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('Visitor Tracker');

	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Date');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Views');


	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);

	$i = 2;
	if($stmt->rowCount() > 0){
		$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
		foreach($analyticsData as $aData){
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $aData['dates']);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $aData['clicks']);
			$i = $i + 1;
		}
	}
   

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Vistortrackingreport_byDateRange-' . date("Y-m-d-H-i-s") . '.xls"');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
