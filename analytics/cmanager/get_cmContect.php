<?php

/* * **************************************************************** * Ideabytes Software India Pvt Ltd.                              	* * 50 Jayabheri Enclave, Gachibowli, HYD                        	* * Created Date : 14/04/2014                                     	* * Created By : Haritha Rekapalli                                 	* * Vision : Project Infofam                                       	*   * Modified by : Haritha      Date : 14/04/2014    Version : I    	* * Description : create campaign                                  	* * ***************************************************************** */include("includes/header.inc.php");
include("classes/campaignlist.class.php");
$moduleLabel = "Campaign ";
$objCList = new CList();
$cmid = $_POST['cm_id'];
if ($cmid != "Select Campaign") {
    $getResultSet = $objCList->getCampaignContent($cmid);
    $campaign_content = @$getResultSet[0]['campaign_content'];
    $campaign_content = html_entity_decode($campaign_content);
    $campaign_content = str_replace("\\\"", "", $campaign_content);
    echo $campaign_content;
} else
    echo "";?>