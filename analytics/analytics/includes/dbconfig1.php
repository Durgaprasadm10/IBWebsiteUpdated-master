<?php

/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Sparkle                                       *  
 * Modified by : Pradeep G     Date : 22/01/2014    Version : V1  *
 * Description : Make DB Connnection                              *
 *****************************************************************/


$dbname = "cmadmin_".$aSettings["db_name"];

/* create connection */
try{
    //$dbcon = new PDO("mysql:host=localhost;dbname=".$dbname."", "cmadmin_dev", "CmAdmin123");
$dbcon = new PDO("mysql:host=ideabytesdb.c6hujshgwzfd.us-east-1.rds.amazonaws.com;dbname=".$dbname."", "cmadmin_dev", "CmAdmin123");
}
catch(PDOException $e){
    echo $e->getMessage();    
}


?>
