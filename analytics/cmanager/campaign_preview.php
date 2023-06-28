<?php
/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 14/04/2014                                     	*
 * Created By : Mahendra Akula                                	*
 * Vision : Project Infofam                                       	*  
 * Modified by : Haritha      Date : 29/05/2014    Version : I    	*
 * Description : create campaign                                  	*
 * ******************************************************************/

include("includes/header.inc.php");
include("classes/campaignlist.class.php");

$moduleLabel = "Campaign ";
$objMessages = new Messages();
$objCList = new CList();

$searchstring = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);


@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];
@$cmid= $_GET['cmid'];
//echo "Campign ID is :$cmid<br>";
$campaignDetails = $objCList->getCampaignContent($cmid);
$i=0;
foreach($campaignDetails as $data)
{
	$content = html_entity_decode($data['campaign_content']);
	$content = str_replace("\\\"","",$content);
	echo $content;
	$i =1;
}
if($i == 0)
	echo "Please select Campaign";
?>