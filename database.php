<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include './constants.php';

class Database {

    private $conn = NULL;

    public function __construct() {
        $this->conn = NULL;
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            return $this->conn;
        } catch (PDOException $e) {
            print_r($e);
        }
    }

    public function executeQuery($query) {

        try {
            $result = $this->conn->prepare($query);
            $result->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
//        print_r($result);
        return $result;
    }

    public function getResult($result) {
        $row = $result->fetchObject();
//        print_r($row);
        return $row;
    }

    public function getMultipleResult($result) {
        $row = $result->fetchAll(PDO::FETCH_OBJ);
//        print_r($row);
        return $row;
    }

    public function getRowCount($result) {
        $rcount = $result->rowCount();
        return $rcount;
    }

}
