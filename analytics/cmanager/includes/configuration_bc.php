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

//define("SENDER_EMAIL", "mahendra.akula@ideabytes.com");
define("SENDER_EMAIL", "cmanager@cm.ideabytes.com");

define("REPLY_EMAIL", "training@ideabytes.com");

define("SITE_URL", "http://198.12.159.153");
//define("SITE_URL", "http://localhost");

define("TRACKING_URL", "http://198.12.159.153/cmanager");
//define("TRACKING_URL", "http://localhost/CM_Web_Analytics/cmanager");
//define("IMAP_URL",'{p3plcpnl0104.prod.phx3.secureserver.net:993/novalidate-cert/imap/ssl}');
define("IMAP_URL", "{ideabytes.secureserver.net:993/novalidate-cert/imap/ssl}");

define("IMAP_USERNAME", "cmanager@cm.ideabytes.com");

define("IMAP_PASSWORD", "cmanager");

define("MAIL_LIMIT", 100000);

define('SPECIAL_IMAGE_CON', "_CM_Special_Image");

define('DISCLAIMER_PS_CONTENT', '&lt;p&gt;&lt;span style=&quot;font-size:12px;&quot;&gt;&lt;em&gt;&lt;strong&gt;
    DISCLAIMER &lt;/strong&gt;-: P.S. This is an advertisement and a promotional mail strictly on the guidelines of CAN-SPAM act of 2003.
We have clearly mentioned the source mail-id of this mail, also clearly mentioned the subject lines and they
are in no way misleading in any form.We have found your mail address through our own efforts on the web
search and not through any illegal way.');

define("DISCLAIMER", DISCLAIMER_PS_CONTENT . "&lt;/em&gt;&lt;/span&gt;&lt;/p&gt;"
        . "&lt;p&gt;&lt;span style=&quot;font-size:12px;&quot;&gt;&lt;em&gt;&lt;span"
        . " style=&quot;color:#000000;&quot;&gt;You may send your feedback/ suggestions at"
        . " &lt;/span&gt;&lt;strong&gt;&lt;a body=&quot;%0A%0AThanks%2C%0A&quot;"
        . " href=&quot;mailto:" . REPLY_EMAIL . "?subject=Suggestions&quot;"
        . " or=&quot;&quot;&gt;&lt;span style=&quot;color:#000000;&quot;&gt;"
        . REPLY_EMAIL . "&lt;/span&gt;&lt;/a&gt;&lt;/strong&gt;&lt;/em&gt;&lt;strong&gt;&lt;em&gt;,"
        . "&lt;/em&gt;&lt;/strong&gt;&lt;span style=&quot;color:#000000;&quot;&gt;"
        . "You have received this mail as you are subscribed to our mailing list.If you do not wish to receive such mails,"
        . " Please &lt;/span&gt;&lt;strong&gt;&lt;a href=&quot;"
        . TRACKING_URL . "/unsubscribe.php&quot;&gt;&lt;span style=&quot;color:#000000;&quot;&gt;"
        . "Unsubscribe here&lt;/span&gt;&lt;/a&gt;&lt;span style=&quot;color:#000000;&quot;&gt;.&lt;/span&gt;&lt;"
        . "/strong&gt;&lt;/span&gt;&lt;/p&gt;");

define('DAILY_DIGEST', 'Daily Report');
define('WEEKLY_DIGEST', 'Weekly Report');
define('MONTHLY_DIGEST', 'Monthly Report');
?>