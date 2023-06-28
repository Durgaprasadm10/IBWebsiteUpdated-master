<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 15/04/2014                                      *
 * Created By : Mahendra Akula                                          *
 * Vision : Project Infofam                                       *  
 * Modified by : Mahendra     Date : 17/04/2014    Version : V1   *
 * Description : Campaign management                                 *
 * *************************************************************** */

class MList {

    function getListCount() {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_LIST . " WHERE 1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getList() {
        global $dbcon, $start_limit;
        $select_q_content = "SELECT * FROM " . CM_LIST . " ORDER BY id ASC LIMIT " . $start_limit . "," . ROW_PER_PAGE;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        //  print_r($select_query_result);
        return $select_query_result;
    }

    function getListById($icmUserId) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_LIST . " WHERE id = :id";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":id", $icmUserId);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        //echo '***********';
        // print_r($select_query_result);
        return $select_query_result;
    }

    function getIDByName($sListName) {
        global $dbcon;
        $select_q_content = "SELECT id FROM " . CM_LIST . " WHERE listname = :name";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":name", $sListName);
        $select_query->execute();
        $sListName = $select_query->fetch(PDO::FETCH_ASSOC);
        //echo '***********';
        // print_r($select_query_result);
        return $sListName;
    }

    function getListNameByID($id) {
        global $dbcon;
        $select_q_content = "SELECT listname FROM " . CM_LIST . " WHERE id =:id";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":id", $id);
        $select_query->execute();
        $sListName = $select_query->fetch(PDO::FETCH_ASSOC);
        // echo "<br>";
       // echo '***********'.$id.$select_q_content;
       // echo "<br>";
       //  print_r($sListName);
        return $sListName['listname'];
    }

    function addList($postarray) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_LIST . " WHERE listname = :name ";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":name", $postarray['list_name']);
        $select_query->execute();
        $count = $select_query->rowCount();
        //echo " Count is ".$count;
        if ($count > 0) {
            $msg = 2;
        } else {
            //$this->createUserTable($postarray['list_name']);
            $query = "INSERT INTO " . CM_LIST . " (`listname`,`active_status`,`created_date`) VALUES (:listname, :active_status, :created_date)";
            $insert_query = $dbcon->prepare($query);
            $insert_query->bindParam(":listname", $postarray['list_name']);
            $insert_query->bindParam(":active_status", $postarray['status']);
            @$insert_query->bindParam(":created_date", date("Y-m-d H:i:s"));
            $msg = ($insert_query->execute()) ? 1 : 0;
        }
        return $msg;
    }

    function updateList($postarray) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_LIST . " WHERE listname = :name AND id != :id";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":name", $postarray['list_name']);
        $select_query->bindParam(":id", $postarray['id']);
        $select_query->execute();
        $count = $select_query->rowCount();
        //echo " Count is ".$count;
        if ($count > 0) {
            $msg = 2;
        } else {
            $query = "UPDATE " . CM_LIST . " SET listname = :listname,active_status = :active_status,created_date = :created_date WHERE id = :id";
            $insert_query = $dbcon->prepare($query);
            $insert_query->bindParam(":listname", $postarray['list_name']);
            $insert_query->bindParam(":id", $postarray['id']);
            $insert_query->bindParam(":active_status", $postarray['status']);
            @$insert_query->bindParam(":created_date", date("Y-m-d H:i:s"));
            $msg = ($insert_query->execute()) ? 1 : 0;
        }
        return $msg;
    }

    function deleteList($id) {
        global $dbcon;
        $delete_q = "DELETE FROM " . CM_LIST . " WHERE id = :id";
        $delete_query = $dbcon->prepare($delete_q);
        $delete_query->bindParam(":id", $id);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

}
