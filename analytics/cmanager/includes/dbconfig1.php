<?php

/* create connection */

$dbname = $cSettings["db_name"];

try{
    //$dbcon = new PDO("mysql:host=localhost;dbname=".$dbname."", "cmadmin_dev", "CmAdmin123");   
 $dbcon = new PDO("mysql:host=ideabytesdb.c6hujshgwzfd.us-east-1.rds.amazonaws.com;dbname=".$dbname."", "cmadmin_dev", "CmAdmin123");     
}
catch(PDOException $e){
    echo $e->getMessage();    
}


?>
