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



/* create connection cmadmin_ibinnovation*/
try{
    //$dbcon = new PDO("mysql:host=localhost;dbname=cmadmin_ibinnovation", "cmadmin_dev", "CmAdmin123");
$dbcon = new PDO("mysql:host=ideabytesdb.c6hujshgwzfd.us-east-1.rds.amazonaws.com;dbname=cmadmin_ibinnovation", "cmadmin_dev", "CmAdmin123");
}
catch(PDOException $e){
    echo $e->getMessage();    
}


?>
