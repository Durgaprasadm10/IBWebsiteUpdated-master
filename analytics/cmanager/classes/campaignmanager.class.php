<?php
/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 14/04/2014                                     	*
 * Created By : Haritha Rekapalli                                 	*
 * Vision : Project Infofam                                       	*  
 * Modified by : Haritha      Date : 14/04/2014    Version : I    	*
 * Description : create campaign                                  	*
 * ******************************************************************/
Class CManager{
	function getIdentifiersFromTemplate($cmcontent)
	{
		$parsebleContent = @$cmcontent[0]['campaign_content'];
		$parsebleContent = html_entity_decode($parsebleContent);
		$pattern = "/_CM_\w+/";
		preg_match_all($pattern, $parsebleContent, $matches, PREG_SET_ORDER);
		$dom = new DOMDocument;
		@$dom->loadHTML($parsebleContent);
		$links = $dom->getElementsByTagName('a');	
		foreach ($links as $link)
		{ 
			$linkValue = (String)$link->getAttribute('href');
			$linkValue = str_replace("\\\"","",$linkValue);
			if($linkValue != "#" && !(strlen($linkValue)>12 && (substr_compare($linkValue,"http://_CM_",0,11) === 0)))
				$matches[][] = $linkValue;
		}
		return $matches;
	}
}