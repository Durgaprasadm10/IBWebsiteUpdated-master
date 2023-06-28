<?php
include("includes/header.inc.php");
include("classes/campaignlist.class.php");


$moduleLabel = "Campaign ";
$objMessages = new Messages();
$objCList = new CList();

@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];

@$campaign_name = $_POST['campaign_name'];
@$campaign_shortDesc = $_POST['campaign_shortDesc'];
@$campaign_longDesc = $_POST['campaign_longDesc'];
@$create_new = $_POST['create_new'];
$campaign_UniqID = "cmid".uniqid();
@$selectedID = $_POST['selectedID'];

echo $action."===".$campaign_name."===".$campaign_shortDesc."===".$campaign_longDesc."===".$create_new;

$sMsg1 = $objCList->addCampaign($_POST,$campaign_UniqID);

echo $sMsg1;
if($sMsg1 == 1)
{
	$sMsg = ($action == "add") ? $objMessages->addupdatesucessIndication($moduleLabel,$action) : $objMessages->changestatusIndication($moduleLabel);
}
else
{
	if ($sMsg1 == 0)
		$sMsg = $objMessages->errorIndication($moduleLabel, $action);
	if ($sMsg1 == 2)
		$sMsg = $objMessages->duplicateIndication($moduleLabel);
} 
?>