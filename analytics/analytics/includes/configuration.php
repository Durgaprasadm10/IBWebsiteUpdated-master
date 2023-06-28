<?php
/*************************************************************************
 * Ideabytes Software India Pvt Ltd.                        		     *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          		 *
 * Created Date : 13/08/2014                                      		 *
 * Created By : Sri Ravi Teja                                            *
 * Vision : Project Visitortracking MVC                              	 *  
 * Modified by : Sri Ravi Teja    Date : 13/08/2014  Version : 2.0   	 *
 * Description : configuration page                              		 *
 *************************************************************************/

define('SITENAME',$aSettings["site_name"]);
define('SITE_BASE_URL',$aSettings["site_url"]);

define('VERSION','V 2.0.0');


//$aRecipient_mail_ids = array("morgadocarlos52@gmail.com","coffeeberrysecrets@gmail.com","ibolab@outlook.com");
//$aRecipient_cc_mail_ids = array("pradeep.ganapathy@ideabytes.com","gayathri.dendukuri@ideabytes.com");

//$aRecipient_mail_ids = array("george.kongalath@ideabytes.com","srinivas.katta@ideabytes.com","raj.anthony@ideabytes.com");
$aRecipient_mail_ids = explode(",",$aSettings["receipient_to"]);

//$aRecipient_mail_ids = array("gayathri.dendukuri@ideabytes.com","raj.anthony@ideabytes.com","srinivas.katta@ideabytes.com","george.kongalath@ideabytes.com");
$aRecipient_cc_mail_ids = explode(",",$aSettings["receipient_cc"]);

//this is  to send  mail  (radar reports daily,weekly,monthly)
//define('MAIN_URL','http://cm.ideabytes.com/analytics');/analytics
define('MAIN_URL','http://ideabytes.com/analytics/analytics');



$colorDependsOnNumber = array("1"=>"yellow","2"=>"green","3"=>"blue","4"=>"red");


define('SENDER_MAIL_ID','analytics@cm.ideabytes.com');

define('REPLY_MAIL_ID','analytics@cm.ideabytes.com');

define('ROW_PER_PAGE','20');

define('MAIL_LOG_DAILY','../logs/mailLogDaily.txt');
define('MAIL_LOG_WEEKLY','../logs/mailLogWeekly.txt');
define('MAIL_LOG_MONTHLY','../logs/mailLogMonthly.txt');

define('DAILY_DIGEST','Daily Report');
define('WEEKLY_DIGEST','Weekly Report');
define('MONTHLY_DIGEST','Monthly Report');

define('PDF_IMAGE_PATH','layouts/images/logo.jpg');
?>
