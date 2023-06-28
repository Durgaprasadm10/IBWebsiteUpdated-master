<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 15/04/2014                                      *
 * Created By : Mahendra Akula                                          *
 * Vision : Project Infofam                                       *  
 * Modified by : Mahendra A    Date : 09/2014    Version : V1   *
 * Description : Campaign management                                 *
 * *************************************************************** */

Class CList {

    function createTable($aTData, $tableName) {
//  $tableName = '';
        $table = '';
        $tableData = array();
        global $dbcon;
//$tableName = "List" . date("YmdHs");
        $tableName = $tableName;
        array_push($tableData, $tableName);
        $table .= "CREATE TABLE " . $tableName . "(UserID MEDIUMINT NOT NULL AUTO_INCREMENT,";
//print_r($aTData);
        for ($i = 0; $i < sizeof($aTData); $i++) {
            $value = $aTData[$i];
            $value = str_replace(' ', '', $value);
            $value = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
            array_push($tableData, $value);
            $table .= $value . " varchar(255),";
        }
        $table .= "primary key(UserID))";
        try {
            $insert_query = $dbcon->prepare($table);
            $insert_query->execute();
        } catch (Exception $e) {
            
        }	
        return $tableData;
    }

    function in_array_case_insensitive($needle, $haystack) {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }

    function showTable($sTableName) {
        global $dbcon;
        $sTableName = strtolower($sTableName);        
        $stmt = $dbcon->prepare("show tables");
		$stmt->execute();
		$aTables = $stmt->fetchALL(PDO::FETCH_ASSOC);
		if(count($aTables) > 0){
			foreach ($aTables as $aT) {
				$sTB = $aT[DB_NAME];
				if (strtolower($sTB) == $sTableName) {
					return TRUE;
				}
			}
		}
        return false;
    }

    function rename($sNewName, $sOldName) {
        global $dbcon;
        if ($this->showTable($sNewName)) {
            $msg = 2;
        } else {
            $sRenameQ = "RENAME TABLE " . $sOldName . " TO " . $sNewName . "";
            $rename = $dbcon->prepare($sRenameQ);
            $msg = ($rename->execute()) ? 1 : 0;
        }
        return $msg;
    }

    function dropTable($sTableName) {
        global $dbcon;
        //  echo "Table Name".$sTableName."<br>";
        if ($this->showTable($sTableName)) {
            //  echo "Table Name in show tavke ".$sTableName."<br>";
            $sDropQ = "DROP TABLE " . $sTableName . "";
            $drop = $dbcon->prepare($sDropQ);
            $msg = ($drop->execute()) ? 1 : 0;
        } else {
            $msg = 2;
        }
        return $msg;
    }

    function uploadfile($aUsersData, $sListName) {
        global $dbcon;
        if (!$this->showTable($sListName)) {	
            $tableData = $this->createTable($aUsersData[0], $sListName);
        }
		
        $query = "INSERT INTO " . $tableData[0] . "(UserID,";
        $value = " VALUES (:id,";
        // $aTemp = array();
        for ($i = 1; $i < sizeof($tableData); $i++) {
            $aTemp = $tableData;
            $query .= $tableData[$i];
            $value .= ":" . $tableData[$i];
            //  unset($aTemp[$i]);
            //   if()
            if ($i != (sizeof($tableData) - 1)) {
                $query .= ", ";
                $value .= ", ";
            } else {
                $query .= ")";
                $value .= ")";
            }
        }
        $query .= $value;
        // echo 'Quesry is : ' . $query;

        array_shift($tableData);
        //echo "Table Data";
        // print_r($tableData);
        //echo "<br>";
        // echo "Sixeis array " . sizeof($aUsersData);
        array_shift($aUsersData);
        // print_r($aUsersData);
        // echo "Sixeis array " . sizeof($aUsersData);
        for ($i = 0; $i < sizeof($aUsersData) - 1; $i++) {
            $value = $aUsersData[$i];
            try {				
                $insert_query = $dbcon->prepare($query);
                //echo "Quesry :$query<br>";
                $id = $i + 1;
                $insert_query->bindParam(":id", $id);
                for ($j = 0; $j < sizeof($tableData); $j++) {
                    // echo ":" . $tableData[$j] . " --" . $value[$j] . "<br>";
                    $insert_query->bindParam(":" . $tableData[$j], $value[$j]);
                }
                @$msg = ($insert_query->execute()) ? 1 : 0;
            } catch (Exception $e) {
                //  echo $e;
            }
        }		
        return @$msg;
    }

    function createListTable($tableName) {
        $table = '';
        global $dbcon;
        // echo "Table name : $tableName<br>";
        $table .= "CREATE TABLE " . $tableName . "(";

        $table .="UserID MEDIUMINT NOT NULL AUTO_INCREMENT,Title varchar(10),FirstName varchar(50),LastName varchar(50),MobileNo varchar(50) NOT NULL,EmailID varchar(50) NOT NULL, primary key(UserID)";
        $table .= ")";
        // echo $table;
        $insert_query = $dbcon->prepare($table);
        $msg = ($insert_query->execute()) ? 1 : 0;
        return $msg;
    }

    function addUser($postarray) {
        global $dbcon;

        //$listname = $postarray['listname'];
        $listid = $postarray['list'];
        if (isset($listid)) {
            $listname = $this->getListNameByID($listid);
            //  echo "List Name $listname<br>";
        }
        unset($postarray['id']);
        unset($postarray['list']);
        unset($postarray['action']);
        unset($postarray['page']);
        $aFields = array_keys($postarray);
        $aData = array();
        foreach ($aFields as $value) {
            array_push($aData, $postarray[$value]);
        }

        $query = "INSERT INTO " . $listname . " (";

        foreach ($aFields as $value) {
            $query .= " " . $value . ",";
        }
        $query = substr($query, 0, strlen($query) - 1);

        $query .= ") VALUES (";

        foreach ($aFields as $value) {
            $query .= ":" . $value . ",";
        }

        $query = substr($query, 0, strlen($query) - 1);

        $query .= ")";

        $insert_query = $dbcon->prepare($query);

        for ($i = 0; $i < sizeof($aFields); $i++) {
            $insert_query->bindParam(":" . $aFields[$i], $aData[$i]);
        }
        $msg = ($insert_query->execute()) ? 1 : 0;
        return $msg;
    }

    function getListNameByID($id) {
        global $dbcon;
        $select_q_content = "SELECT listname FROM " . CM_LIST . " WHERE id =:id";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":id", $id);
        $select_query->execute();
        $sListName = $select_query->fetch(PDO::FETCH_ASSOC);
        //echo '***********'.$id.$select_q_content;
        // print_r($sListName);
        return $sListName['listname'];
    }

    function updateUser($postarray) {
        // echo "<pre>";
        //print_r($postarray);
        global $dbcon;
        $id = $postarray['id'];
        $listid = $postarray['list'];
        if (isset($listid)) {
            $listname = $this->getListNameByID($listid);
            //  echo "List Name $listname<br>";
        }
        unset($postarray['id']);
        unset($postarray['list']);
        unset($postarray['action']);
        unset($postarray['page']);
        // echo "<pre>";
        //print_r($postarray);
        $aFields = array_keys($postarray);
        $aData = array();
        foreach ($aFields as $value) {
            array_push($aData, $postarray[$value]);
        }
        //exit();

        $query = "UPDATE " . $listname . " SET";

        foreach ($aFields as $value) {
            $query .= " " . $value . " = :" . $value . ",";
        }
        $query = substr($query, 0, strlen($query) - 1);
        $query .= " WHERE UserID = :id";
        $insert_query = $dbcon->prepare($query);
        for ($i = 0; $i < sizeof($aFields); $i++) {
            $insert_query->bindParam(":" . $aFields[$i], $aData[$i]);
        }
        $insert_query->bindParam(":id", $id);
        $msg = ($insert_query->execute()) ? 1 : 0;

        return $msg;
    }

    function getUserCount($listname) {
        //   echo "List name : $listname<br>";
        global $dbcon;
        $select_q_content = "SELECT count(UserID) as count FROM " . $listname . " WHERE 1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

//    function getUserList($listname) {
//        global $dbcon, $start_limit;
//        $select_q_content = "SELECT * FROM " . $listname . "";
//        $select_query = $dbcon->prepare($select_q_content);
//        $select_query->execute();
//        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
//        //  print_r($select_query_result);
//        return $select_query_result;
//    }
    function getUserList($listname) {
        global $dbcon, $start_limit;
        $select_q_content = "SELECT * FROM " . $listname . " ORDER BY UserID ASC LIMIT " . $start_limit . "," . ROW_PER_PAGE;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        //  print_r($select_query_result);
        return $select_query_result;
    }

    function getUserById($listname, $icmUserId) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . $listname . " WHERE UserID = :id";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":id", $icmUserId);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getUserByListId($listname, $iListId) {
        //  echo 'Enter GetDataList'.$listname;
        $select_query_result = array();
        global $dbcon;
        $select_q_content = "SELECT * FROM " . $listname . " WHERE list_id = :id";
        // echo $select_q_content;
        try {
            $select_query = $dbcon->prepare($select_q_content);
            $select_query->bindParam(":id", $iListId);
            $select_query->execute();
            $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
            //echo '***********';
            //print_r($select_query_result);
        } catch (Exception $e) {
            
        }
        return $select_query_result;
    }

    function deleteUser($listname, $id) {
        global $dbcon;
        $delete_q = "DELETE FROM " . $listname . " WHERE UserID = :id";
        $delete_query = $dbcon->prepare($delete_q);
        $delete_query->bindParam(":id", $id);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

    function getList($sTableName) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . $sTableName;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getTableFields($listname) {
        echo 'Table Nme' . $listname;
        global $dbcon;
        //  $delete_q = "DESCRIBE " . $listname;
        $delete_q = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS"
                . " WHERE TABLE_SCHEMA = 'campaignmanager' AND TABLE_NAME = '" . $listname . "';
";
        $delete_query = $dbcon->prepare($delete_q);
        $table = ($delete_query->execute()) ? 1 : 0;
        print_r($table);
        return $table;
    }

    public function getColumnNames($table) {
        global $dbcon;
         $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :table AND TABLE_SCHEMA=:db";
        //exit;
        try {
            // $core = Core::getInstance();
            $stmt = $dbcon->prepare($sql);
            $stmt->bindValue(':table', $table, PDO::PARAM_STR);
            $stmt->bindValue(':db', DBNAME, PDO::PARAM_STR);
            $stmt->execute();
            $output = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $output[] = $row['COLUMN_NAME'];
            }
            return $output;
        } catch (PDOException $pe) {
            trigger_error('Could not connect to MySQL database. ' . $pe->getMessage(), E_USER_ERROR);
        }
    }

    function getColumnNames1($table) {
        global $dbcon;
        $db = $dbcon->get_connection();
        $select = $db->query('SELECT * FROM '.$table);

        $total_column = $select->columnCount();
        var_dump($total_column);

        for ($counter = 0; $counter <= $total_column; $counter ++) {
            $meta = $select->getColumnMeta($counter);
            $column[] = $meta['name'];
        }
        echo "<pre>";
        echo "Debugsdjvbjsdvb<br>";
        print_r($column);
        return $column;
    }

    function getUser($listname) {
        global $dbcon, $start_limit;
        $select_q_content = "SELECT * FROM " . $listname . " ORDER BY id ASC LIMIT " . $start_limit . ", " . ROW_PER_PAGE;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        //  print_r($select_query_result);
        return $select_query_result;
    }

    function changeStatus($id, $status) {
        global $dbcon;
        $update_q = "UPDATE " . EVENTS_NAMES_TABLE . " SET active_status = :status WHERE id = :id";
        $update_query = $dbcon->prepare($update_q);
        $update_query->bindParam(":id", $id);
        $update_query->bindParam(":status", $status);
        $msg = ($update_query->execute()) ? 1 : 0;
        return $msg;
    }

    function getEventTabs() {
        global $dbcon;
        $query = "SELECT * FROM " . EVENTS_TABS_TABLE . " WHERE 1";
        try {
            $stmt = $dbcon->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
                $stmt = null;
            }
        } catch (PDOException $e) {
            print $e->getMessage();
        }
        return "";
    }

    function getEventTabNames() {
        global $dbcon;
        $sql1 = "SELECT group_concat(key_name) as keyName FROM " . EVENTS_TABS_TABLE . " WHERE 1";
        try {
            $stmt = $dbcon->prepare($sql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $tabsInfo = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt = null;
                $tabsInfo1 = explode(", ", $tabsInfo['keyName']);
                return $tabsInfo1;
            }
        } catch (PDOException $e) {
            print $e->getMessage();
        }
        return "";
    }

}
