<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 30/01/2014                                      *
 * Created By : Haritha Rekapalli                                 *
 * Vision : CampaignManager                                       *  
 * Modified by : Mahendra Akula     Date : 27/5/2014          *
 * Version : II   												  *
 * Description : Header file                                      *
 *****************************************************************/ 
require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_line.php');
require_once ('lib/jpgraph/src/jpgraph_utils.inc.php');
require_once ('lib/jpgraph/src/jpgraph_date.php');
class HitRateGraph
{
	function hitRateNewLineGraph($cachefilename, $ydata, $xdata)
	{
		$graph = new Graph(600, 500);

		 // Check if the image already exists in the cache and is valid
		$valid = $graph -> cache -> IsValid($cachefilename);
		if ($valid)
		{
			// The cached file exists and has not expired, so we do not 
			// need to create a new one
			return;
		}
		else
		{
			$graph -> SetupCache($cachefilename, 60);
			//Set the scale to use DateScale
			$graph -> SetScale("datlin");
			//Set the text for the graph Title
			$graph -> title -> Set('Hits');
			//Enable clipping to prevent the line from extending
			// outside of the plot area
			$graph -> SetClipping(true);
			// Set the date format to use for the date labels
			$graph -> xaxis -> scale -> SetDateFormat('M-d');
			// Since we're taking in dates from MySQL, we need to
			// convert them to time
			$xDates = array ();
			for ($i = 0; $i < sizeof($xdata); $i++)
			{
				$time = strtotime($xdata[$i]);
				array_push($xDates, $time);
			}
			$dateUtils = new DateScaleUtils();
			$autoTicks = $dateUtils -> getAutoTicks($xDates[0],	$xDates[sizeof($xDates) - 1], 10);
			// Se the tick positions to the ones returned by getAutoTicks
			$graph -> xaxis -> SetTickPositions($autoTicks[1]);
			// Now we create the actual plot line
			$lineplot = new LinePlot($ydata, $xDates);
			$lineplot -> SetLegend('By Date');
			
			$lineplot->SetColor( 'blue' );
			$lineplot->SetWeight( 2 );   // Two pixel wide
			$lineplot->mark->SetType(MARK_UTRIANGLE);
			$lineplot->mark->SetColor('blue');
			$lineplot->mark->SetFillColor('red');
			 
			$lineplot->value->Show();
			
			// Add the plot line to the graph
			$graph -> Add($lineplot);
			$absolutePath = (CACHE_DIR . "" . $cachefilename);
			$graph -> Stroke($absolutePath);
		}
	}
}	
?>