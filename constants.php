<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Servername for finding the host and keep credentials accordingly
 */

$servername = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING);
//if ($servername != "localhost") {
    define("DB_HOST", "ideabytesdb.c6hujshgwzfd.us-east-1.rds.amazonaws.com");
    define("DB_NAME", "ideabytes_webportal");
    define("DB_USER", "idea_database");
    define("DB_PASSWORD", "idea_database");
    define("USER_EMAIL", "contact@ideabytes.com");
    define("USER_PASSWORD", "cust4bYtes^$");
//}
