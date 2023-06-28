<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 25/08/2014  Version : 2.0   	 *
 * Description : this page will produce pdf that                 		 *
                 contains analytics_bypage page results.         		 *
 ************************************************************************/

set_time_limit(300);
ini_set('memory_limit', '20000M');

include 'includes/header.inc.php';
$html= '';

$sql = "SELECT p.page_name,vi.page_id, count(vi.id) AS clicks FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id = vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites." GROUP BY p.id,vi.page_id";

try {
	$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	$count = $stmt->rowCount();
} catch (PDOException $e) {
	print $e->getMessage();
	$count = 0;
}
if($count > 0){
	$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
}  
error_reporting(1);
// Include the main TCPDF library (search for installation path).
require_once('lib/tcpdf/tcpdf.php');
class MYPDF extends TCPDF {
	// Page footer
	public function Footer() {
		$this->SetY(-10);
		// Set font
		$this->SetFont('helvetica', '', 10);
		// Page number
		$this->Cell(0, 10, 'Copy rights belongs to ideabytes'.'                                                                                                 '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, '', 0, '', 0, false, 'T', 'M');
		$this->Cell(0, 10,date("Y-m-d"), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}
$path = "visitors".date("Y-m-d-H-i-s");
// create new PDF document
if ($count > 0) {
	if(count($analyticsData)>= 500){
		mkdir($path);//Create directory
	}
	$noOfRows = 500;
	$no_of_iterations = "";
	$total = count($analyticsData);
	$tcount = 500;
	for($i=0;$i<$total;$i+=$tcount)
	{
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// create new PDF document
		$pdf->SetCreator(PDF_CREATOR);



		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING,array(70, 142, 'Green'), array(0,64,128));

		// set document information
		//$pdf->SetCreator(PDF_CREATOR);
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


		// ---------------------------------------------------------


					
		$pdf->AddPage('L', 'A4');

		$html .= '<table border="0" cellspacing="2" cellpadding="2">
			<b><tr>
					<th>PageName</th>
					<th>Clicks</th>
			</tr></b><hr width=10%>';

		 for($j=$i;($j<($tcount+$i) && $j<$total);$j++){ 
				 $html .= '<tr>
						<td>' . $analyticsData[$j]['page_name'] . '</td>
						<td>' . $analyticsData[$j]['clicks'] . '</td>
			</tr>';
			
		} 
		if(count($analyticsData)>= $tcount)
		{
						
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
			// ---------------------------------------------------------
			//Close and output PDF document
			$pdf->Output($path.'/Visitor Tracking-'.$i.'.pdf', 'F');
			$html ="";
						
						
						
		}else
		{
			$html .= "<table>";
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('visitors/Visitor Tracking-'.$i.'.pdf', 'I');
				
		}
	}
 }    	

if(count($analyticsData)>= $tcount){
	include 'myzip.php';
	include 'deletedirectory.php';
}	 



//============================================================+
// END OF FILE
//============================================================+
				
					