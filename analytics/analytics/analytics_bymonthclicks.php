<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 15/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 01/09/2014  Version : 2.0   	 *
 * Description : this page gives analytics for  individual month.        *
 ************************************************************************/

include ("includes/header.inc.php");
include ("classes/MonthlyFilter.class.php");
$searchstring = "";
$start_limit = 0;
@$page = isset($_GET['page']) ? $_GET['page'] : $_POST['page']; 
if(!isset($page))
    $page = 1;    
if($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
$present_year = date('Y');
$present_month = date('F');
$mClickCount = array();

@$selectedyear = ($_POST['selectedyear'] == "") ? date('Y') : $_POST['selectedyear'];


$months_names = array(1=>"Jan",2=>"Feb",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec");


$bymonth = new MonthlyFilter();
$analyticsDataC = $bymonth->yearwise();

@$selectedmonth = ($_POST['selectedmonth'] == "") ? "" : $_POST['selectedmonth'];
				$searhCondM = "";
				if (@$selectedyear != "") 
				{
					$searhCondM .= " AND YEAR(vi.datetime) = " .$selectedyear;
				}
$monthsArray = $bymonth->monthwise();	
$iMonth = 1;
$months_count = count($monthsArray);
$last_month_in_months_array = $monthsArray[$months_count-1];
					foreach($monthsArray as $data){
						 if($iMonth == 1){
							$month = $data;
						 }
						 if(in_array($selectedmonth,$monthsArray)){
							$selectedmonth = $selectedmonth;
						 }else{
							$selectedmonth = $last_month_in_months_array;
						 /*
							if($selectedyear == date('Y')){
								$selectedmonth =  date('n');
							}else{
								$selectedmonth = $month;
							}
						*/
						 }
							$selectedM = ($data == $selectedmonth) ? "selected" : "";
							 "<option " . $selectedM . "  value='" . $data . "'>" . $months_names[$data] . "</option>";
							$iMonth++;
					}
				


$analyticsData = $bymonth->liste();

include ("layouts/analytics_bymonth.html");
?>