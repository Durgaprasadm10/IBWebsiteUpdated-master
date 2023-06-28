<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 28/08/2014  Version : 2.0   	 *
 * Description : this page will produce pdf  that                 		 *
                 contains analytics_bydaterange page results.     		 *
 ************************************************************************/
 

include 'includes/header.inc.php';
$html= '';
//@$cn = $_POST['cn'];
//@$pid = $_POST['pid'];
//@$ptodate = $_POST['ptodate'];
//@$pfromdate = $_POST['pfromdate'];
//@$sbmt = $_POST['sbmt'];
$searhCond = $_POST['searhCond'];
$orderby = $_POST['orderby'];
	/*if(isset($_POST['page_id']) && (@$pid!="")){
		$searhCond .= " AND vi.page_id = ".$pid;
	}
	if(isset($_POST['country_name']) && (@$cn!="")){
		$searhCond .= " AND vi.country = '".$cn."'";
	}
	if(isset($_POST['fromdate']) && isset($_POST['todate']) && (@$pfromdate!="") && (@$ptodate!="")){
		$searhCond .= " AND DATE(vi.datetime) BETWEEN '".$pfromdate."' AND '".$ptodate."'";
	}
	$orderby = "ASC";
	if(isset($_POST['order']) && (@$_POST['order']!="")){
		$orderby = ($_POST['order'] == "Descending") ? "DESC" : "ASC";
	}*/
	$sql = "SELECT DATE(vi.datetime) as dates,count(vi.id) AS clicks FROM ".VISITORS_INFO." as vi WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond.$friendlyWebsites.$searhCond." GROUP BY DATE(vi.datetime) ".$orderby;
	
	try {
		$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		$count = $stmt->rowCount();
	} catch (PDOException $e) {
		print $e->getMessage();
		$count = 0;
	}   
error_reporting(1);
// Include the main TCPDF library (search for installation path).
require_once('lib/tcpdf/tcpdf.php'); //C:\xampp\htdocs\VisitorTracking\tcpdf\examples\tcpdf_include.php

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
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
            <th>Date</th>
            <th>Views</th>
	</tr></b><hr width=10%>';

if ($count > 0) {

    $analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
    
    foreach ($analyticsData as $aData) {
         $html .= '<tr>
                <td>' . $aData['dates'] . '</td>
                <td>' . $aData['clicks'] . '</td>
	</tr>';
    }
} 
$html .= '</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('Visitor Tracking Report_ByDateRange'.date("Y-m-d-H-i-s").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
