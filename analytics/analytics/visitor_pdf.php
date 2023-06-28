<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 25/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 28/08/2014  Version : 2.0   	 *
 * Description : this page will produce pdf of analytics for      		 *
                Filter page.                            			     *
 ************************************************************************/
set_time_limit(300);
//ini_set('max_execution_time',300);
ini_set('memory_limit', '20000M');

include 'includes/header.inc.php';
//include 'deletefiles.php';
$path = "visitors".date("Y-m-d-H-i-s");
mkdir($path);
$html= '';


//-------------------teja--------------------
@$cn = $_POST['cn'];
@$cyn = $_POST['cyn'];
@$Ip = $_POST['Ip'];
@$pid = $_POST['pid'];
@$pdate = $_POST['pdate'];
@$ptodate = $_POST['ptodate'];
@$pfromdate = $_POST['pfromdate'];

$searhCond = "";
            if ($cn != "" && ($cn != "All")) 
			{
                $searhCond .= " AND vi.country='" . $cn . "'";
                $html .= '<b>Country : </b>'.$cn.'   ';
            }
			elseif($cn == "All")
			{
                $html .= '<b>Country :</b> ALL '.'   ';
            }
            if ($cyn != "") 
			{
                $searhCond .= " AND vi.city='" . $cyn . "'";
                $html .= '<b>City :</b> '.$cyn.'   ';
            }
			else
			{
                $html .= '<b>City :</b> ALL'.'   ';
            }
            if ($Ip != "") 
			{
                $searhCond .= " AND vi.ip_address='" . $Ip . "'";
                $html .= '<b>IP Addrress :</b> '.$Ip.'   ';
            }
			else
			{
                $html .= '<b>IP Address :</b> ALL'.'   ';
            }

            if ($pid != "") 
			{
                $searhCond .= " AND vi.page_id='" . $pid . "'";
                
				try 
				{                
					$stmt = $dbcon->prepare("SELECT page_name FROM `page` WHERE id=".$pid, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
					$stmt->execute();
					if ($stmt->rowCount() > 0) 
					{
						$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
						foreach ($analyticsData as $aData)
						{
							$html .= '<b>Page :</b> '.$aData['page_name'].'   ';
						}
					}
				} 
				catch (PDOException $e) 
				{
                print $e->getMessage();
				}
            }
			else
			{
                $html .= '<b>Page :</b> ALL'.'   ';
            }
			$event_tab_type_radio = (@$_POST['event_tab_type'] != "") ? $_POST['event_tab_type'] : 1;
			if($event_tab_type_radio == 1)
			{
				if (@$pfromdate != "") {
					$searhCond .= " AND date(vi.datetime)='" . $pfromdate . "'";
					$html .= '<b>Date :</b> '.$pfromdate.'   ';
				}
			}else
			{
			
				if(isset($pdate) && isset($ptodate) && (@$pdate!="") && (@$ptodate!="")){
					$searhCond .= " AND DATE(vi.datetime) BETWEEN '".$pdate."' AND '".$ptodate."'";
					$html .= '<b>From Date :</b> '.$pdate.'<b>To Date :</b> '.$pdate.' ';
				}
			}
            if (@$pfromdate != "") {
                $searhCond .= " AND date(vi.datetime)='" . $pfromdate . "'";
                $html .= '<b>Date :</b> '.$pfromdate.'<br><br><br>';
            }else{
                $html .= '<b>Date :</b> ALL'.'<br><br><br>';
            }	
		$orderField = "";

		$i = 0;
		if (count(@$_POST['order_type']) > 0) 
		{
			foreach(@$_POST['order_type'] as $value){
			
				$orderField .= $value." ".$_POST['order_by'][$i] .",";
						
				$i=$i+1;					
			}
			$orderField = substr($orderField,0,(strlen($orderField) - 1));
			
		}else{
			$orderField = 'vi.datetime DESC';
		}
        
		 error_reporting(1);
// Include the main TCPDF library (search for installation path).
include('lib/tcpdf/tcpdf.php'); 

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
        
				
//$sql_for_total_count = "SELECT * FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON vi.page_id = p.id WHERE vi.geo_info_status = 1 AND vi.ip_address NOT IN (" . $friendlyIps . ")" .$friendlyWebsites. $searhCond . " ORDER BY " . $orderField;
//$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON vi.page_id = p.id WHERE vi.geo_info_status = 1 ".$deviceCond.$friendlyIpsCond. $friendlyWebsites  . $searhCond . " ORDER BY " . $orderField ;		

//echo $searhCond;
//echo "<br>";
$sql = "SELECT CONVERT_TZ(datetime,'+00:00','".$coockie."') as dtTimezone,vi.*,p.page_name FROM ".VISITORS_INFO." as vi LEFT JOIN ".PAGE." as p ON vi.page_id = p.id WHERE vi.geo_info_status = 1 ".$friendlyIpsCond.$friendlyWebsites. $searhCond .$deviceCond. " ORDER BY " . $orderField;

$analyticsData = array();			
try {
	$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	$count = $stmt->rowCount();
} catch (PDOException $e) {
	print $e->getMessage();
}
 
//echo $count;
		
					
if ($count > 0) {
	$analyticsData = $stmt->fetchALL(PDO::FETCH_ASSOC);
	$noOfRows = 500;
	$no_of_iterations = "";
	
	
	$total = count($analyticsData);
	$tcount = 500;

	for($i=0;$i<$total;$i+=$tcount)
	{
				$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
			
	 $html .= '<table border="0" cellspacing="1" cellpadding="2">
			<b><tr>
					<th>Date</th>
					<th>Time</th>
					<th>Country</th>
					<th>City</th>
					<th>IP Address</th>
					<th>Visited Page</th>
					<th>Reference Page</th>
					
			</tr></b><hr width=40% >';
	 
	 
	 for($j=$i;($j<($tcount+$i) && $j<$total);$j++){
	  
	  $datetime = date("d-m-Y H:i:s", strtotime($analyticsData[$j]['dtTimezone']));
					$date = html_escaped_output(date("d-m-Y", strtotime($datetime)));
					$time = html_escaped_output(date("H:i:s", strtotime($datetime)));

					$html .= '<tr>
							
							<td>' . $date . '</td>
							<td>' . $time . '</td>
							<td>' . $analyticsData[$j]['country'] . '</td>
							<td>' . $analyticsData[$j]['city'] . '</td>
							<td>' . $analyticsData[$j]['ip_address'] . '</td>
							<td>' . $analyticsData[$j]['page_name'] . '</td>
							<td>' . $analyticsData[$j]['page_referer'] . '</td>
				</tr>';
	 }
	 // echo $html;
	  //echo "<br>------------------<br><br>";
		 
		 if(count($analyticsData)>= $tcount)
		 {
				
				$html .= "<table>";
				$pdf->writeHTML($html, true, false, true, false, '');
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
