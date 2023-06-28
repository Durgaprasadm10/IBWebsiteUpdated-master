<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 03/04/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project Visitortracking                               *  
 * Modified by : Gayathri     Date : 12/05/2014   Version : 1.1.0 *
 * Description : this page will send daily reports mail.          *
 *****************************************************************/


$logininfo["customer_id"] = "IBCUS1435038168"; 
 
//include "../includes/header.inc1_crons.php";
include "/var/www/html/analytics/analytics/includes/header.inc1_crons.php";
include "/var/www/html/analytics/analytics/classes/DailyReports.class.php"; //--added


$date_in_subject = date('Y-m-d', strtotime("-1 days"));

$subject = "test mail daily  Analytics - ".SITENAME." | Daily report | ".$date_in_subject;


$today = date('Y-m-d', strtotime("-1 days"));
$today_in_legend = date('d-m-Y',strtotime($today));

$date_for_web = strtotime($today);

$presentdate =  date('d-m-Y');

$DlyRpt = new DailyReports();
$DlyRpt->countryCode();


	if($stmt->rowCount() > 0){
		
		// graph lib start here
		require_once ('/var/www/html/analytics/analytics/lib/jpgraph/src/jpgraph.php');
		require_once ('/var/www/html/analytics/analytics/lib/jpgraph/src/jpgraph_radar.php');

		// Create the basic radar graph
		$graph = new RadarGraph(700,600);

		// Set background color and shadow
		$graph->SetColor("white");
		$graph->SetShadow();

		// Position the graph
		$graph->SetCenter(0.4,0.55);

		// Setup the axis formatting     
		$graph->axis->SetFont(FF_FONT1,FS_BOLD);
		$graph->axis->SetWeight(2);

		// Setup the grid lines
		$graph->grid->SetLineStyle("longdashed");
		$graph->grid->SetColor("navy");
		$graph->grid->Show();
		$graph->HideTickMarks();

		// Setup graph titles
		$graph->title->Set("Analytics - ".SITENAME."               Country Based Reports                 ".$presentdate);
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->SetTitles($countryInfo);

		// Create the first radar plot        
		$plot = new RadarPlot($clicksInfo);
		$plot->SetLegend($today_in_legend);
		$plot->SetColor("red","lightred");
		$plot->SetFill(false);
		$plot->SetLineWeight(2);

		// Create the second radar plot
		$plot->SetFillColor('lightred');
		$graph->SetSize(0.6);
		$graph->SetPos(0.5,0.6);

		// Add the plots to the graph
		$graph->Add($plot);

		// And output the graph
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);

		// Default is PNG so use ".png" as suffix
		$fileName = "imagefile.png";
		$graph->img->Stream($fileName);
	}

	$DlyRpt->pageCode();
	if($stmt1->rowCount()>0)
	{
	
		// graph lib start here
		require_once ('/var/www/html/analytics/analytics/lib/jpgraph/src/jpgraph.php');
		require_once ('/var/www/html/analytics/analytics/lib/jpgraph/src/jpgraph_radar.php');

		// Create the basic radar graph
		$graph = new RadarGraph(700,600);

		// Set background color and shadow
		$graph->SetColor("white");
		$graph->SetShadow();

		// Position the graph
		$graph->SetCenter(0.4,0.55);

		// Setup the axis formatting     
		$graph->axis->SetFont(FF_FONT1,FS_BOLD);
		$graph->axis->SetWeight(2);

		// Setup the grid lines
		$graph->grid->SetLineStyle("longdashed");
		$graph->grid->SetColor("navy");
		$graph->grid->Show();
		$graph->HideTickMarks();

		// Setup graph titles
		$graph->title->Set("Analytics - ".SITENAME."             Page Based Reports                  ".$presentdate);
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->SetTitles($pageInfo);
		
		// Create the first radar plot        
		$plot = new RadarPlot($pclicksInfo);
		$plot->SetLegend($today_in_legend);
		$plot->SetColor("red","lightred");
		$plot->SetFill(false);
		$plot->SetLineWeight(2);

		// Create the second radar plot
		$plot->SetFillColor('lightred');
		$graph->SetSize(0.6);
		$graph->SetPos(0.5,0.6);

		// Add the plots to the graph
		$graph->Add($plot);

		// And output the graph
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);

		// Default is PNG so use ".png" as suffix
		$fileName1 = "imagefile1.png";
		$graph->img->Stream($fileName1);
	}
    $DlyRpt->countrycityCode();
	if($stmt->rowCount() > 0){
		
		// graph lib start here
		require_once ('/var/www/html/analytics/analytics/lib/jpgraph/src/jpgraph.php');
		require_once ('/var/www/html/analytics/analytics/lib/jpgraph/src/jpgraph_radar.php');

		// Create the basic radar graph
		$graph = new RadarGraph(700,600);

		// Set background color and shadow
		$graph->SetColor("white");
		$graph->SetShadow();

		// Position the graph
		$graph->SetCenter(0.4,0.55);

		// Setup the axis formatting     
		$graph->axis->SetFont(FF_FONT1,FS_BOLD);
		$graph->axis->SetWeight(2);

		// Setup the grid lines
		$graph->grid->SetLineStyle("longdashed");
		$graph->grid->SetColor("navy");
		$graph->grid->Show();
		$graph->HideTickMarks();

		// Setup graph titles
		$graph->title->Set("Analytics - ".SITENAME."               Country-City Based Reports                 ".$presentdate);
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		
		
		$graph->SetTitles($countrycityInfo);

		// Create the first radar plot        
		$plot = new RadarPlot($countrycityclicksInfo);
		$plot->SetLegend($today_in_legend);
		$plot->SetColor("red","lightred");
		$plot->SetFill(false);
		$plot->SetLineWeight(2);

		// Create the second radar plot
		$plot->SetFillColor('lightred');
		$graph->SetSize(0.6);
		$graph->SetPos(0.5,0.6);

		// Add the plots to the graph
		$graph->Add($plot);

		// And output the graph
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);

		// Default is PNG so use ".png" as suffix
		$fileName2 = "imagefile2.png";
		$graph->img->Stream($fileName2);
		
	}
	$htmlContent = '';
	if(($stmt->rowCount() > 0) && ($stmt1->rowCount() > 0)){
		$htmlContent .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				</head>
				<body>
				<table>
				<tbody>
				<tr> <td valign="top"> 
						<a href="'.MAIN_URL.'/charts_daily.php?date='.$date_for_web.'&category=Country&source=mail&customer_id='.$logininfo["customer_id"].'">Click to view on web</a><br>
						<img src="'.$fileName.'">
						</td>
		<td valign="top" style="padding-top:20px;padding-left:20px">
		<table cellpadding="5" style="border:1px solid black;border-collapse:collapse;">
		<tr><th style="order:1px solid black;">Code</th><th style="border:1px solid black;">Country</th><th style="border:1px solid black;">Clicks</th></tr>';
		foreach($country_code_display_array as $value){
    				$htmlContent .= '<tr><td style="border:1px solid black;">'.$value['country_code'].'</td><td style="border:1px solid black;">'.$value['country'].'</td><td style="border:1px solid black;">'.$value['clicks'].'</td></tr>';
    			}
				
		
		$htmlContent .= 		'</table></td></tr>
									<tr>
									<td colspan="2" height="50px">
									<td>
								</tr>';
		$htmlContent .= '</tbody><tbody><tr>
		
		<td valign="top">
			<a href="'.MAIN_URL.'/charts_daily.php?date='.$date_for_web.'&category=Page&source=mail&customer_id='.$logininfo["customer_id"].'">Click to view on web</a><br>
			
			<img src="'.$fileName1.'">
		</td>
		<td valign="top" style="padding-top:20px;padding-left:20px">
      
        <table cellpadding="5" style="border:1px solid black;border-collapse:collapse;">
		<tr><th style="border:1px solid black;">Code</th><th style="border:1px solid black;">Page Name</th>
		<th style="border:1px solid black;">Total <br />Clicks</th></tr>';
	     $morediff = 1;
		 
		foreach($page_code_display_array as $value){

			$moreone = $value['couip'];
			//$paip = $value['paip'];
			if($moreone  < 5 ){
				$recu = $value['couip'];
			}
			$allc = $value['clicks'];

    		$htmlContent .=  '<tr><td style="border:1px solid black;">'.$value['short_name'].'</td><td style="border:1px solid black;">'.$value['page_name'].'</td>';
			$htmlContent .= '<td style="border:1px solid black;">'.$allc.'</td></tr>';
		 }
		 
		$htmlContent .= '</table></td></tr> <tr><td colspan="2" height="50px"><td></tr></tbody>';
		
		$htmlContent .= '<tbody><tr><td valign="top">';
		
		$htmlContent .= '<a href="'.MAIN_URL.'/charts_daily.php?date='.$date_for_web.'&category=Country-City&source=mail&customer_id='.$logininfo["customer_id"].'">Click to view on web</a><br>';
		$htmlContent .= '<img src="'. $fileName2.'">';
		$htmlContent .= '</td>
		<td valign="top" style="padding-top:20px;padding-left:20px">
		<table cellpadding="5" style="border:1px solid black;border-collapse:collapse;">
          <tr><th style="border:1px solid black;">Code</th><th style="border:1px solid black;">Country</th><th style="border:1px solid black;">Clicks</th></tr>';
		  foreach($country_code_city_display_array as $value){
						$htmlContent .= '<tr><td style="border:1px solid black;">'.$value['country_code'].'</td><td style="border:1px solid black;">'.$value['country'];
						if(count($value['cityinfo']) > 0){
							$htmlContent .= '<table cellpadding="5" width="100%" style="border:1px solid black;border-collapse:collapse;"><tr><th style="border:1px solid black;">City</th><th style="border:1px solid black;">Clicks</th></tr>';
								foreach($value['cityinfo'] as $key1=>$value1){
									$htmlContent .= '<tr><td style="border:1px solid black;">'.$value1['city'].'</td><td style="border:1px solid black;">'.$value1['clicks'].'</td></tr>';
								}
							$htmlContent .= '</table>';
						}
						$htmlContent .= '</td><td style="border:1px solid black;">'.$value['clicks'].'</td></tr>';
						
					}
			$htmlContent .= '</table>      
								</td>
							</tr></tbody>
						</table></body></html>';		
	}else{
		$htmlContent = "No Reports for the date.";
	}
	
	//echo $htmlContent;
	
require_once('/var/www/html/analytics/analytics/lib/PHPMailer/class.phpmailer.php');


$body             = $htmlContent;

//echo $body;
//exit;

//$body             = " hi this is for testing mail with text.";
$mail             = new PHPMailer(); // defaults to using php "mail()"


//http://www.php.net/manual/en/function.preg-replace.php
//$body             = preg_replace("[\]",'',$body);

$mail->SetFrom(SENDER_MAIL_ID);

$mail->AddAddress("gayathri.dendukuri@ideabytes.com");
$mail->AddAddress("gayathridec5@gmail.com");
$mail->AddAddress("philip.konduru@ideabytes.com");
$mail->AddAddress("maheswari.guntupalli@ideabytes.com");
/*
foreach($aRecipient_mail_ids as $smailid_to_send){	
	$mail->AddAddress($smailid_to_send);
} 
 
if(count($aRecipient_cc_mail_ids) >= 1){
	foreach($aRecipient_cc_mail_ids as $smailid_cc_to_send){	
		$mail->AddCC($smailid_cc_to_send);
	} 
}
*/
$mail->Subject    = $subject;

$mail->AltBody    = "Please check"; // optional, comment out and test

$mail->MsgHTML($body);

if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
	$message = date("d-m-Y H:i:s")."---->".$logininfo["customer_id"]."---->".$date_in_subject."---->".@implode($aRecipient_mail_ids)."---->".@implode($aRecipient_cc_mail_ids)."---->".$mail->ErrorInfo;
	@logging(MAIL_LOG_DAILY,$message);
} else {
	echo "Message sent!";
	$message = date("d-m-Y H:i:s")."---->".$logininfo["customer_id"]."---->".$date_in_subject."---->".@implode($aRecipient_mail_ids)."---->".@implode($aRecipient_cc_mail_ids)."---->Message sent";
	@logging(MAIL_LOG_DAILY,$message);
}
  
?>
