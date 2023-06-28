
<?php/* * **************************************************************** * Ideabytes Software India Pvt 
Ltd.                              	* * 50 Jayabheri Enclave, Gachibowli, HYD                        	
* * Created Date : 14/04/2014                                     	* * Created By : Haritha 
Rekapalli                                 	* * Vision : Project 
Infofam                                       	*   * Modified by : Haritha      Date : 14/04/2014    
Version : I    	* * Description : create campaign                                  	* * 
******************************************************************/include("includes/header.inc.php");
include("classes/campaignlist.class.php");
@$cm_name = $_GET['campaign_name'];
$moduleLabel = "Campaign ";
$objMessages = new Messages();
$objCList = new CList();
$campaignCount = $objCList->getCampaignListCountByName($cm_name);
echo "hi";
echo $cm_name;
?>