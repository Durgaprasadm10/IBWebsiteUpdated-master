<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 07/02/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project CampaignManager                                       *  
 * Modified by : Gayathri     Date : 15/02/2014    Version : V1   *
 * Description : This class is used to add design messages        *
				                                                  *
 *****************************************************************/
Class Messages{
	
	public function success($sMsg){
		$smsg = "<div class='valid_box'>".$sMsg."</div>";
		return $smsg;
	}
	public function error($sMsg){
		$smsg = "<div class='error_box'>".$sMsg."</div>";
		return $smsg;
	}
	public function warning($sMsg){
		$smsg = "<div class='warning_box'>".$sMsg."</div>";
		return $smsg;
	}
	
	public function addupdatesucessIndication($process,$action){
		$smsg = "<div class='valid_box'> ".$process." ".$action."ed sucessfully</div>";
		return $smsg;
	}
	public function duplicateIndication($process){
		$smsg = "<div class='warning_box'> ".$process." already exists, Please try again.</div>";
		return $smsg;
	}
	public function errorIndication($process,$action){
		$smsg = "<div class='error_box'> Error on ".$action." ".$process.", Please try again.</div>";
		return $smsg;
	}
	public function changestatusIndication($process){
		$smsg = "<div class='valid_box'> ".$process." status changed sucessfully.</div>";
		return $smsg;
	}
}


?>