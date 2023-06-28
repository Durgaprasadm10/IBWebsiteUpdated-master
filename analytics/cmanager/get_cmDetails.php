<?php 
include("includes/header.inc.php");
include("classes/campaignlist.class.php");
@$cm_name = $_POST['campaign_name'];
$objCList = new CList();
$campaignCount = $objCList->getCampaignListCountByName($cm_name);

if($campaignCount>0)
{	
	$campaignList = $objCList->getCampaignListByName($cm_name);	
	echo $campaignList[0]['short_description']."##".$campaignList[0]['long_description'];
}
else
{	
	echo "N";
}
?>