<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 13/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 01/09/2014  Version : 2.0   	 *
 * Description : Common functions                                 		 *
 * **********************************************************************/

function doPager($page_size, $thepage, $query_string, $total=0) {  
	//per page count  
	$index_limit = 5; 
 
  
	//set the query string to blank, then later attach it with $query_string  
	$query='';  
  
	if(strlen($query_string)>0){  
		$query = "&".$query_string;  
	}  
  
	//get the current page number example: 3, 4 etc: see above method description  
	$current = get_current_page();  
  
	$total_pages=ceil($total/$page_size);  
	$start=max($current-intval($index_limit/2), 1);  
	$end=$start+$index_limit-1;  
  
	$pagging = '<div class="pagination">';  
  
	if($current==1) {  
		$pagging .= '<span class="disabled">< </span> ';  
	} else {  
		$i = $current-1;  
		$pagging .= '<a class="disabled" title="go to page '.$i.'" rel="nofollow" href_="'.$thepage.'?page='.$i.$query.'" onclick="paging('.$i.')">< </a> ';  
		$pagging .= '<span class="disabled">...</span> ';  
	}  
  
	if($start > 1) {  
		$i = 1;  
		$pagging .= '<a title="go to page '.$i.'" href_="'.$thepage.'?page='.$i.$query.'" onclick="paging('.$i.')">'.$i.'</a> ';  
	} 
  
	for ($i = $start; $i <= $end && $i <= $total_pages; $i++){  
		if($i==$current) {  
			$pagging .= '<span class= "current">'.$i.'</span> ';  
		} else {  
			$pagging .= '<a title="go to page '.$i.'" href_="'.$thepage.'?page='.$i.$query.'" onclick="paging('.$i.')">'.$i.'</a> ';  
		}  
	}  
  
	if($total_pages > $end){  
		$i = $total_pages;  
		$pagging .= '<a title="go to page '.$i.'" href_="'.$thepage.'?page='.$i.$query.'" onclick="paging('.$i.')">'.$i.'</a> ';  
	}  
  
	if($current < $total_pages) {  
		$i = $current+1;  
		$pagging .= '<span class="disabled">...</span> ';  
		$pagging .= '<a class="disabled" title="go to page '.$i.'" rel="nofollow" href-="'.$thepage.'?page='.$i.$query.'" onclick="paging('.$i.')"> ></a> ';  
	} else {  
		$pagging .= '<span class="disabled"> ></span> ';  
	}  
  
	//if nothing passed to method or zero, then dont print result, else print the total count below:  
	if ($total != 0){  
		//prints the total result count just below the paging  
		$pagging .= '('.$total.' Records)';  
	}
	$pagging .= '</div>';

	return  $pagging;
  
}
/// commenting is start here (the below functions are already defined in functions_common page which is included in header.inc so  
//  these are commented, please uncomment when you need)
/*
function doPages($page_size, $thepage, $query_string, $total = 0) {
    //per page count
    $index_limit = 5;


    //set the query string to blank, then later attach it with $query_string
    $query = '';

    if (strlen($query_string) > 0) {
        $query = "&" . $query_string;
    }

    //get the current page number example: 3, 4 etc: see above method description
    $current = get_current_page();

    $total_pages = ceil($total / $page_size);
    $start = max($current - intval($index_limit / 2), 1);
    $end = $start + $index_limit - 1;

    $pagging = '<div class="paging">';

    if ($current == 1) {
        $pagging .= '<span class="prn">< Previous</span> ';
    } else {
        $i = $current - 1;
        $pagging .= '<a class="prn" title="go to page ' . $i . '" rel="nofollow" href="' . $thepage . '?page=' . $i . $query . '">< Previous</a> ';
        $pagging .= '<span class="prn">...</span> ';
    }

    if ($start > 1) {
        $i = 1;
        $pagging .= '<a title="go to page ' . $i . '" href="' . $thepage . '?page=' . $i . $query . '">' . $i . '</a> ';
    }

    for ($i = $start; $i <= $end && $i <= $total_pages; $i++) {
        if ($i == $current) {
            $pagging .= '<span>' . $i . '</span> ';
        } else {
            $pagging .= '<a title="go to page ' . $i . '" href="' . $thepage . '?page=' . $i . $query . '">' . $i . '</a> ';
        }
    }

    if ($total_pages > $end) {
        $i = $total_pages;
        $pagging .= '<a title="go to page ' . $i . '" href="' . $thepage . '?page=' . $i . $query . '">' . $i . '</a> ';
    }

    if ($current < $total_pages) {
        $i = $current + 1;
        $pagging .= '<span class="prn">...</span> ';
        $pagging .= '<a class="prn" title="go to page ' . $i . '" rel="nofollow" href="' . $thepage . '?page=' . $i . $query . '">Next ></a> ';
    } else {
        $pagging .= '<span class="prn">Next ></span> ';
    }

    //if nothing passed to method or zero, then dont print result, else print the total count below:
    if ($total != 0) {
        //prints the total result count just below the paging
        $pagging .= '(' . $total . ' Records)';
    }
    $pagging .= '</div>';

    return $pagging;
}

//end of method doPages()
//Both of the functions below required

function check_integer($which) {
    if (isset($_REQUEST[$which])) {
        if (intval($_REQUEST[$which]) > 0) {
            //check the paging variable was set or not,
            //if yes then return its number:
            //for example: ?page=5, then it will return 5 (integer)
            return intval($_REQUEST[$which]);
        } else {
            return false;
        }
    }
    return false;
}

//end of check_integer()

function get_current_page() {
    if (($var = check_integer('page'))) {
        //return value of 'page', in support to above method
        return $var;
    } else {
        //return 1, if it wasnt set before, page=1
        return 1;
    }
}

//end of method get_current_page()


/**
 * Returns an encrypted & utf8-encoded
 
function encrypt($pure_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}
 */
/**
 * Returns decrypted original string
 
function decrypt($encrypted_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}
*/
/// commenting is ended here

function getVisitorTimezone(){
	$present_ip = $_SERVER['REMOTE_ADDR'];
		
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
	
	if(!curl_errno($ch_geoinfo)){					
		$json_geoinfo = str_replace('\\', '\\\\', $execute_geoinfo);
		$json_decode_geoinfo = json_decode($json_geoinfo, true);   
		
		$country_name = $json_decode_geoinfo["countryName"];
		$city_name = $json_decode_geoinfo["cityName"];
		$timezone = $json_decode_geoinfo["timeZone"];
		
	}
	return $timezone;
}
function getFriendlyIP() {
    $temp = '';
    global $dbcon;
    
    $query = "SELECT `ipaddress` FROM `friendly_ip` WHERE `active_status` = 1";
    try {
        $stmtP = $dbcon->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmtP->execute();
    } catch (PDOException $e) {
        print $e->getMessage();
    }
    if ($stmtP->rowCount() > 0) {
        $freindly_ips = $stmtP->fetchALL(PDO::FETCH_ASSOC);
        foreach ($freindly_ips as $ip) {
            //print_r($ip);
            $temp .= "'" . $ip['ipaddress'] . "',";
            //  echo "<option " . $selectedP . "  value='" . $aData["id"] . "'>" . $aData["page_name"] . "</option>";
        }
        $temp = substr($temp, 0, strlen($temp) - 1);
    }
    return $temp;
}
function html_escaped_output($output_value) {
    $escaped_output = htmlspecialchars($output_value, ENT_QUOTES, "UTF-8");
    return $escaped_output;
}
function getFriendlyWebsite() {
    $temp = '';$freindly_websites = array();
    global $dbcon;
    
    @$query = "SELECT `site_name` FROM ".FRIENDLYWEBSITE." WHERE `active_status` = 1";
    try {
        $stmtP = $dbcon->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmtP->execute();
    } catch (PDOException $e) {
        print $e->getMessage();
    }
    if ($stmtP->rowCount() > 0) {
        $freindly_websites = $stmtP->fetchALL(PDO::FETCH_ASSOC);
        /*foreach ($freindly_websites as $website) {
           
            $temp .= "'" . $website['site_name'] . "',";
            
        }
        $temp = substr($temp, 0, strlen($temp) - 1);
		return $temp;
		*/
    }
    return $freindly_websites;
}        


function logging($file,$message){
	$fileData = (file_exists($file)) ? file_get_contents($file) : "";
	$content = $message."  \n". $fileData;
	file_put_contents($file,$content); 
}

function minifiedAnchor ($page_referrer) {
  $anchor_tag = "";
  if($page_referrer != ""){
    $href_string = $page_referrer;
  	$length = strlen($href_string);
  	$show_string = ($length >60) ? substr($href_string, 0, 50)."..." : $href_string;
  	$anchor_tag = "<a href='".$href_string."' target='_blank'>".$show_string."</a>";
  }
  return $anchor_tag;
}
?>