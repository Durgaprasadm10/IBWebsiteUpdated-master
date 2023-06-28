<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 26/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 01/09/2014  Version : 2.0   	 *
 * Description : this page will produce pdf of                    		 *
                  view_details in analytics_byip page.            		 *
 ************************************************************************/
set_time_limit(300);
ini_set('memory_limit', '20000M');
 
 include 'includes/header.inc.php';
$html= '';
$ip_address_input = $_POST['iphidden'];

$sql = "SELECT vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON p.id=vi.page_id WHERE vi.geo_info_status = 1 ".$deviceCond." AND vi.ip_address = '".$ip_address_input."' ".$friendlyWebsites;

$analyticsData = array();
try {
	$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	$count = $stmt->rowCount();
} catch (PDOException $e) {
	print $e->getMessage();
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

if ($count > 0) {
	$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC); 
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
								<th>Time</th>
								<th>Country</th>
								<th>City</th>
								<th>IP Address</th>
								<th>Visited Page</th>
								<th>Reference Page</th>
						</tr></b><hr width=10%>';

				 for($j=$i;($j<($tcount+$i) && $j<$total);$j++){ 
							$key = array_search($coockie, $timezone_array);
							$tz = str_replace('-', '', $key );
							if ($tz == $key) {
								$time = date("d-m-Y H:i:s", strtotime($analyticsData[$j]['datetime']) + ((int) $tz) * 60 * 60);
							} else {
								$time = date("d-m-Y H:i:s", strtotime($analyticsData[$j]['datetime']) - ((int) $tz) * 60 * 60);
							}
							$aData[0] = (date("d-m-Y", strtotime($time)));
							$aData[1] = (date("H:i:s", strtotime($time)));
							$html .= '<tr>
									
									<td>' . $aData[0] . '</td>
									<td>' . $aData[1] . '</td>
									<td>' . $analyticsData[$j]['country'] . '</td>
									<td>' . $analyticsData[$j]['city'] . '</td>
									<td>' . $analyticsData[$j]['ip_address'] . '</td>
									<td>' . $analyticsData[$j]['page_name'] . '</td>
									<td>' . $analyticsData[$j]['page_referer'] . '</td>
						</tr>';
					} if(count($analyticsData)>= $tcount)
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
				
					