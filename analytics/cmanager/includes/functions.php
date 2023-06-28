<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 01/01/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project Camapaign Manager                             *  
 * Modified by : Mahendra     Date : 1/07/2014   Version : 1.1.0 *
 * Description : this page contains common functions              *
 *****************************************************************/

function doPages($page_size, $thepage, $query_string, $total=0) {  
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
		$pagging .= '<span class="disabled">< Previous</span> ';  
	} else {  
		$i = $current-1;  
		$pagging .= '<a class="disabled" title="go to page '.$i.'" rel="nofollow" href="'.$thepage.'?page='.$i.$query.'">< Previous</a> ';  
		$pagging .= '<span class="disabled">...</span> ';  
	}  
  
	if($start > 1) {  
		$i = 1;  
		$pagging .= '<a title="go to page '.$i.'" href="'.$thepage.'?page='.$i.$query.'">'.$i.'</a> ';  
	} 
  
	for ($i = $start; $i <= $end && $i <= $total_pages; $i++){  
		if($i==$current) {  
			$pagging .= '<span class= "current">'.$i.'</span> ';  
		} else {  
			$pagging .= '<a title="go to page '.$i.'" href="'.$thepage.'?page='.$i.$query.'">'.$i.'</a> ';  
		}  
	}  
  
	if($total_pages > $end){  
		$i = $total_pages;  
		$pagging .= '<a title="go to page '.$i.'" href="'.$thepage.'?page='.$i.$query.'">'.$i.'</a> ';  
	}  
  
	if($current < $total_pages) {  
		$i = $current+1;  
		$pagging .= '<span class="disabled">...</span> ';  
		$pagging .= '<a class="disabled" title="go to page '.$i.'" rel="nofollow" href="'.$thepage.'?page='.$i.$query.'">Next ></a> ';  
	} else {  
		$pagging .= '<span class="disabled">Next ></span> ';  
	}  
  
	//if nothing passed to method or zero, then dont print result, else print the total count below:  
	if ($total != 0){  
		//prints the total result count just below the paging  
		$pagging .= '('.$total.' Records)';  
	}
	$pagging .= '</div>';

	return  $pagging;
  
}//end of method doPages()  
  
//Both of the functions below required  
  
function check_integer($which) {  
	if(isset($_REQUEST[$which])){  
		if (intval($_REQUEST[$which])>0) {  
			//check the paging variable was set or not,  
			//if yes then return its number:  
			//for example: ?page=5, then it will return 5 (integer)  
			return intval($_REQUEST[$which]);  
		} else {  
			return false;  
		}  
	}  
	return false;  
}//end of check_integer()  
  
function get_current_page() {  
	if(($var=check_integer('page'))) {  
		//return value of 'page', in support to above method  
		return $var;  
	} else {  
		//return 1, if it wasnt set before, page=1  
		return 1;  
	}  
}//end of method get_current_page()

function getCmSettings($customer_id){
	global $dbcon;		
	$sql = "SELECT * FROM ".CM_SETTINGS." WHERE customer_id = :customer_id";
	try {
		$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->bindParam(":customer_id",$customer_id);           
		$stmt->execute();
		$customerData = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt = null;
	}catch (PDOException $e){
		print $e->getMessage();
	}
        return $customerData;
}

function getCustomerInfo($customer_id){
	global $dbcon;			
	$sql = "SELECT * FROM ".CUSTOMER_INFO." WHERE customer_id = :customer_id";
	try {
		$stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->bindParam(":customer_id",$customer_id);           
		$stmt->execute();
		return $customerData = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt = null;
	}catch (PDOException $e){
		print $e->getMessage();
	}		
}
?>