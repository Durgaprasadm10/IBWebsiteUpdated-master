<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Campaign Maneger                                     *  
 * Modified by : Mahendra A     Date : 24/08/2014    Version : V1  *
 * Description : Application config file                          *
 * *************************************************************** */


/* Define Meta informations  */
global $logininfo;
define("SITE_NAME", "Ideabytes Training");

define("VERSION", "V 2.0.0");

define("APPNAME", "Campaign Manager");


define("PROCESSID", $logininfo["customer_id"]);

define("ROW_PER_PAGE", "10");

//define("DEFAULT_GROUP", "Mahendra#mahendra.akula@ideabytes.com,George#george.kongalath@ideabytes.com,Raj#raj.anthony@ideabytes.com,Pradeep#Pradeep.Ganapathy@ideabytes.com,Kalidas#kalidas.tc@ideabytes.com","Katta#srinivas.katta@ideabytes.com");
$cdefault_mail_ids = $cSettings["default_receipient"];
define("DEFAULT_GROUP", $cdefault_mail_ids);

define("DB_NAME", "Tables_in_" . $cSettings["db_name"]);

define("SENDER_EMAIL", "cmanager@cm.ideabytes.com");

define("REPLY_EMAIL", $cSettings['reply_email']);

//define("SITE_URL", "http://198.12.159.153");
define("SITE_URL", "http://34.194.219.107/analytics");
//define("SITE_URL", "http://localhost");

//define("TRACKING_URL", "http://198.12.159.153/cmanager");
define("TRACKING_URL", "http://34.194.219.107/cmanager");
//define("TRACKING_URL", "http://localhost/CM_Web_Analytics/cmanager");
//define("IMAP_URL",'{p3plcpnl0104.prod.phx3.secureserver.net:993/novalidate-cert/imap/ssl}');
define("IMAP_URL", "{ideabytes.secureserver.net:993/novalidate-cert/imap/ssl}");

define("IMAP_USERNAME", "cmanager@cm.ideabytes.com");

define("IMAP_PASSWORD", "cmanager");

define("MAIL_LIMIT", 100000);

define('SPECIAL_IMAGE_CON', "_CM_Special_Image");
	
define("DISCLAIMER",$cSettings['disclaimer']);

define('DAILY_DIGEST', 'Daily Report');
define('WEEKLY_DIGEST', 'Weekly Report');
define('MONTHLY_DIGEST', 'Monthly Report');
?>
