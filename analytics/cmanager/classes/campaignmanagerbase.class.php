<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 30/01/2014                                      *
 * Created By : Haritha Rekapalli                                 *
 * Vision : CampaignManager                                       *  
 * Modified by : Haritha Rekapalli     Date : 30/01/2014          *
 * Version : I   												  *
 * Description : Header file                                      *
 *****************************************************************/ 
class CampaignManagerBase
{
	function isDomainValid($emailID)
	{
		$domain = explode('@',$emailID);
		$useremail = "www.".$domain[1];
		if(gethostbyname($useremail) == $useremail)
		{
			return false;			 
		} 
		return true;
	}
	function getCity($ip)
	{
		  $present_ip = $ip;
		  $geoinfo = "http://api.ipinfodb.com/v3/ip-city/?key=13ebc6d8740ab89e93e615530a59dd0f22df559274089129135f83188578f84d&ip=$present_ip&format=json";
		  $ch_geoinfo = curl_init($geoinfo); 
		  curl_setopt($ch_geoinfo, CURLOPT_HEADER, 0);    
		  curl_setopt($ch_geoinfo, CURLOPT_FOLLOWLOCATION, true);
		  curl_setopt($ch_geoinfo, CURLOPT_MAXREDIRS, 10);
		  curl_setopt($ch_geoinfo, CURLOPT_AUTOREFERER, true);
		  curl_setopt($ch_geoinfo, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch_geoinfo,CURLOPT_CONNECTTIMEOUT,60);
		  curl_setopt($ch_geoinfo, CURLOPT_FAILONERROR, 1);
		  $execute_geoinfo = curl_exec($ch_geoinfo);
		  if(!curl_errno($ch_geoinfo))
		  {
			   $json_geoinfo = str_replace('\\', '\\\\', $execute_geoinfo);
			   $json_decode_geoinfo = json_decode($json_geoinfo, true);
		  }
		  else
		  {
				  //echo "curl request error";
		  }
		  $country_name = $json_decode_geoinfo["countryName"];
		  $city_name = $json_decode_geoinfo["cityName"];
		  //$geo_details = $country_name.":::".$city_name;
		  return $city_name;
	}
	
	function getBrowser()
	{
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";

		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}

		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		}
		elseif(preg_match('/Firefox/i',$u_agent))
		{
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$bname = 'Google Chrome';
			$ub = "Chrome";
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			$bname = 'Apple Safari';
			$ub = "Safari";
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Opera';
			$ub = "Opera";
		}
		elseif(preg_match('/Netscape/i',$u_agent))
		{
			$bname = 'Netscape';
			$ub = "Netscape";
		}

		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}

		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}

		// check if we have a number
		if ($version==null || $version=="") {$version="?";}

		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
		);
	}
}
