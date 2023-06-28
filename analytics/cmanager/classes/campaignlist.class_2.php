<?php

/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              	*
 * 50 Jayabheri Enclave, Gachibowli, HYD                        	*
 * Created Date : 14/04/2014                                     	*
 * Created By : Haritha Rekapalli                                 	*
 * Vision : Project CampaignManager                                       	*  
 * Modified by : Mahendra  A    Date : 03/09/2014    Version : I    	*
 * Description : create campaign                                  	*
 * ***************************************************************** */

Class CList {

    function updateProcessCampaign($sID, $sTableName, $iEmailCount, $aPIDs) {
        global $dbcon;
        $query = "UPDATE " . CM_PROCESSLISTMAIN . " SET TableName= :TableName,email_count=:EmailCount,pid=:pid WHERE id=:id";
        $update_query = $dbcon->prepare($query);
        $update_query->bindParam(":TableName", $sTableName);
        $update_query->bindParam(":EmailCount", $iEmailCount);
        $update_query->bindParam(":pid", $aPIDs);
        $update_query->bindParam(":id", $sID);
        $msg = ($update_query->execute()) ? 1 : 0;
        return $msg;
    }

    function updateProcessCampaign_ListID($sID, $sListID) {
        global $dbcon;
        $query = "UPDATE " . CM_PROCESSLISTMAIN . " SET list_id= :list_id WHERE id=:id";
        $update_query = $dbcon->prepare($query);
        $update_query->bindParam(":list_id", $sListID);
        $update_query->bindParam(":id", $sID);
        $msg = ($update_query->execute()) ? 1 : 0;
        return $msg;
    }

    function getUsers() {
        global $dbcon, $start_limit;
        $select_q_content = "SELECT * FROM " . CM_LIST . " ORDER BY id ASC LIMIT " . $start_limit . "," . ROW_PER_PAGE;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getUsersForSelection() {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_LIST . "";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    /*
      function getList($sTableName) {
      global $dbcon;
      $select_q_content = "SELECT * FROM " . $sTableName;
      $select_query = $dbcon->prepare($select_q_content);
      $select_query->execute();
      $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
      return $select_query_result;
      }
     */
    /*
      function isMailAlreadySent($sProcessID, $sUserID) {
      global $dbcon;
      $sQuery = "SELECT mail_status FROM " . CM_PROCESSLIST . " WHERE process_id =:process_id AND user_id =:user_id";
      $sSQuery = $dbcon->prepare($sQuery);
      $sSQuery->bindParam(":process_id", $sProcessID);
      $sSQuery->bindParam(":user_id", $sUserID);
      $sSQuery->execute();
      $aResult = $sSQuery->fetch(PDO::FETCH_ASSOC);
      return $aResult;
      }
     */

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

    function getTableColumnSet($aTableC) {
        $set = '';
        foreach ($aTableC as $value) {
            $set .= $value . ",";
        }
        $set = substr($set, 0, strlen($set) - 1);
        return $set;
    }
	
    function showTable($sTableName) {
        global $dbcon;
        $sTableName = strtolower($sTableName);
        // echo "Checking for Table exist<br>";
        // echo "List of Tables<br>";
        $aTables = $dbcon->query('show tables')->fetchAll();
        //  print_r($aTables);
        foreach ($aTables as $aT) {
            $sTB = $aT[DB_NAME];
            // echo "Searching : $sTB and Actual : $sTableName <br>";
            if (strtolower($sTB) == $sTableName) {
                //  echo "Table Exist<br>";
                return TRUE;
            }
        }
        // echo "Table not Exist<br>";
        return false;
    }

    function alterTable($sTableName, $sFName) {
        global $dbcon;
        $sFName = preg_replace('/[^A-Za-z0-9\-]/', '', $sFName);
        $sQuery = "ALTER TABLE " . $sTableName . " ADD " . $sFName . " VARCHAR(255)";
        //  $sth = $dbcon->exec($sQuery);
        $delete_query = $dbcon->prepare($sQuery);
        $delete_query->execute();
        // return $sth;
    }

    /*
      public function insertTable1($aTable1, $sMainTableName, $sTable1) {
      global $dbcon;
      $T1Set = $this->getTableColumnSet($aTable1);
      $delete_q = "INSERT INTO " . $sMainTableName . " ( " . $T1Set . ") "
      . "SELECT " . $T1Set . " FROM " . $sTable1 . "";
      // echo " Merging Query is :" . $delete_q;
      $delete_query = $dbcon->prepare($delete_q);
      $msg = ($delete_query->execute()) ? 1 : 0;
      return $msg;
      }
     */
    /*
      public function insertTable2($aTable1, $aTable2, $sMainTableName, $sTable2) {
      global $dbcon;
      $T1Set = $this->getTableColumnSet($aTable1);
      $T2Set = $this->getTableColumnSet($aTable2);
      $delete_q = "INSERT INTO " . $sMainTableName . " ( " . $T1Set . ") "
      . "SELECT " . $T2Set . " FROM " . $sTable2 . "";
      //  echo " Merging Query is :" . $delete_q;
      $delete_query = $dbcon->prepare($delete_q);
      $msg = ($delete_query->execute()) ? 1 : 0;
      return $msg;
      }
     */

    public function insertTableSecond($aTable1, $sMainTableName, $aTable2, $sTable2) {
        global $dbcon;
        //echo "<pre>";
        // print_r($aTable1);
        // print_r($aTable2);
        $sEC = '';
        $i = 0;
        foreach ($aTable1 as $value) {
            if ("EmailID" == $value) {
                $sEC = @$aTable2[$i];
            }
//            if ($sEC == '') {
//                $aK = array_keys($aTable1, "EmailID");
//                $sEC = $aTable2[$aK[0]];
//            }
            $i++;
        }
        $T1Set = $this->getTableColumnSet($aTable1);
        $T2Set = $this->getTableColumnSet($aTable2);
        $delete_q = "INSERT INTO " . $sMainTableName . " ( " . $T1Set . ") "
                . "SELECT " . $T2Set . " FROM " . $sTable2 . "";
        if ($sEC != '') {
            $delete_q = "INSERT INTO " . $sMainTableName . " ( " . $T1Set . ") "
                    . "SELECT " . $T2Set . " FROM " . $sTable2 . " "
                    . "WHERE " . $sEC . " NOT IN (SELECT EmailID FROM " . $sMainTableName . ")";
        }
        // echo " Merging Query is :" . $delete_q;
        try {
            $delete_query = $dbcon->prepare($delete_q);
            $msg = ($delete_query->execute()) ? 1 : 0;
        } catch (Exception $e) {
            
        }
        return $msg;
    }

    /*
      public function mergingTables($aTable1, $aTable2, $sMainTableName, $sTable1, $sTable2) {
      global $dbcon;

      //print_r($aTable2);
      $T1Set = $this->getTableColumnSet($aTable1);
      //echo $T1Set;
      //$sTable2 = array_keys($aTable2);

      $T2Set = $this->getTableColumnSet($aTable2);
      // echo $T2Set;
      $delete_q = "INSERT INTO " . $sMainTableName . " ( " . $T1Set . ") "
      . "SELECT " . $T1Set . " FROM " . $sTable1 . ""
      . " UNION "
      . "SELECT " . $T2Set . " FROM " . $sTable2 . "";
      $delete_query = $dbcon->prepare($delete_q);
      $msg = ($delete_query->execute()) ? 1 : 0;
      return $msg;
      }
     */
    /*
      function createTableF($aTData, $tableName) {
      $table = '';
      global $dbcon;
      $table .= "CREATE TABLE " . $tableName . "(";
      $Keys = array_keys($aTData);
      foreach ($Keys as $sKey) {
      $value = $aTData[$sKey];
      $value = str_replace(' ', '', $value);
      $value = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
      $table .= $value . " varchar(255),";
      }
      $table = substr($table, 0, (strlen($table) - 1));
      $table .= ")";
      $insert_query = $dbcon->prepare($table);
      $insert_query->execute();
      }
     */

    function createTable($sTableName) {
        $table = '';
        global $dbcon;
        // echo "Table name : $tableName<br>";
        $table .= "CREATE TABLE " . $sTableName . "(";
//        $Keys = array_keys($aTData);
//        foreach ($Keys as $sKey) {
//            $value = $aTData[$sKey];
//            $value = str_replace(' ', '', $value);
//            $value = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
//            $table .= $value . " varchar(255),";
//        }
        $table .="ID MEDIUMINT NOT NULL AUTO_INCREMENT,primary key(ID),Title varchar(10) NOT NULL,FirstName varchar(50) NOT NULL,LastName varchar(50) NOT NULL,MobileNo varchar(50) NOT NULL,EmailID varchar(50) NOT NULL";
        // $table = substr($table, 0, (strlen($table) - 1));
        $table .= ")";
        //echo $table;
        $insert_query = $dbcon->prepare($table);
        $insert_query->execute();
    }

    function insertDafaultValues($sTableName, $sFName, $sEmailID) {
        global $dbcon;
        $sQuery = "INSERT INTO " . $sTableName . "(FirstName,EmailID)VALUES(:FirstName,:EmailID)";
        $sInsertQuery = $dbcon->prepare($sQuery);
        $sInsertQuery->bindParam(":FirstName", $sFName);
        $sInsertQuery->bindParam(":EmailID", $sEmailID);
        $sMsg = ($sInsertQuery->execute()) ? 1 : 0;
        return $sMsg;
    }

    /*
      function insertTableName($sValues) {
      global $dbcon;
      $insertProcessquery = "INSERT INTO " . CM_PROCESSLISTMAIN . " (TableName)VALUES(:TName)";
      $insert_query = $dbcon->prepare($insertProcessquery);
      $insert_query->bindParam(":TName", $sValues);
      $msg = ($insert_query->execute()) ? 1 : 0;
      }
     */

    function getEmailCount($sTableName) {
        global $dbcon;
        $select_q_content = "SELECT DISTINCT  EmailID FROM " . $sTableName . "";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $count = $select_query->rowCount();
        return $count;
    }

    function getUserIDList($sTableName) {
        global $dbcon;
        $select_q_content = "SELECT ID FROM " . $sTableName . "";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getEmailByUserID($sTableName, $sUserID) {
        global $dbcon;
        $select_q_content = "SELECT EmailID,MobileNo FROM " . $sTableName . " WHERE ID=:userid";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":userid", $sUserID);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getEmailBy_UID_PID($iUID, $iPID) {
        global $dbcon;
        $select_q_content = "SELECT user_email FROM " . CM_PROCESSLIST . " WHERE process_id=:process_id AND  user_id=:user_id";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":user_id", $iUID);
        $select_query->bindParam(":process_id", $iPID);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getTableName($sPid) {
        global $dbcon;
        $select_q_content = "SELECT TableName FROM " . CM_PROCESSLISTMAIN . " WHERE pid=:pid";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":pid", $sPid);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getCampaignNameByID($campaignID) {
        global $dbcon;
        $select_q = "SELECT campaign_name FROM " . CM_CAMPAIGNLIST . " WHERE id = :id";
        $select_query = $dbcon->prepare($select_q);
        $select_query->bindParam(":id", $campaignID);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getCampaignDetailsByID($campaignID) {
        global $dbcon;
        $select_q = "SELECT * FROM " . CM_CAMPAIGNLIST . " WHERE id = :id";
        $select_query = $dbcon->prepare($select_q);
        $select_query->bindParam(":id", $campaignID);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function validateEmails($sTableName) {
        global $dbcon;
        $query = "SELECT EmailID FROM " . $sTableName . " WHERE 1";
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        // echo "<pre>";
        // echo $sTableName.$query;
        //print_r($select_query_result);

        foreach ($select_query_result as $aEmail) {
            // echo $aEmail['EmailID'] . "<br>";
            //print_r($aEmail);

            if (filter_var($aEmail['EmailID'], FILTER_VALIDATE_EMAIL)) {
                //  echo "This " . $aEmail['EmailID'] . " email address is considered valid.";
            } else {
                // echo "This " . $aEmail['EmailID'] . " email address is not valid.";
                if ($this->deleteRowFromTable($sTableName, $aEmail['EmailID']) == 1) {
                    // echo "Deleted " . $aEmail['EmailID'] . "<br>";
                }
            }
        }
    }

    function deleteRowFromTable($sTableName, $sEmailID) {
        global $dbcon;
        $delete_q = "DELETE FROM " . $sTableName . " WHERE EmailID = :EmailID";
        $delete_query = $dbcon->prepare($delete_q);
        $delete_query->bindParam(":EmailID", $sEmailID);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

    /*
      function duplicateEmail($sTableName) {
      global $dbcon;
      $query = "SELECT EmailID,ID FROM " . $sTableName . " WHERE 1";
      $select_query = $dbcon->prepare($query);
      $select_query->execute();
      $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
      $aTemp = array();
      foreach ($select_query_result as $aEmail) {
      //  print_r($aEmail);
      $aTemp[$aEmail['ID']] = $aEmail['EmailID'];
      }
      // echo "Compete<br>";
      //print_r($aTemp);
      $aID = array_keys($aTemp);
      // print_r($aID);
      $aTemp1 = array();
      $aTemp1 = $aTemp;
      // echo "<br>";
      // print_r($aTemp1);
      //  echo "<br>";
      foreach ($aID as $iID) {
      $sT = $aTemp1[$iID];
      unset($aTemp1[$iID]);
      $K = array_search($sT, $aTemp1);

      if (sizeof($K) != 0) {
      // echo "<br>Keys<br>";
      // print_r($K);
      //  echo "Emaid ".$aTemp1[$K];
      //   echo "TN ".$sTableName;
      if (!empty($K))
      $this->deleteRowFromTable($sTableName, $aTemp1[$K]);
      }
      }
      }
     */

///Adding Haritha
    /*
      function getUserListCount() {
      global $dbcon;
      $select_q_content = "SELECT count(id) as count FROM " . CM_LISTUSER . " WHERE 1";
      $select_query = $dbcon->prepare($select_q_content);
      $select_query->execute();
      $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
      $count = $select_query_result['count'];
      return $count;
      }
     */
    /*
      function getUserListCountByID($listID) {
      global $dbcon;
      $select_q_content = "SELECT count(id) as count FROM " . CM_LISTUSER . " WHERE list_id = :id";
      $select_query = $dbcon->prepare($select_q_content);
      $select_query->bindParam(":id", $listID);
      $select_query->execute();
      $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
      $count = $select_query_result['count'];
      return $count;
      }
     */
    /*
      function getUserList() {
      global $dbcon, $start_limit;
      $select_q_content = "SELECT * FROM " . CM_LISTUSER . " ORDER BY id ASC LIMIT " . $start_limit . "," . ROW_PER_PAGE;
      $select_query = $dbcon->prepare($select_q_content);
      $select_query->execute();
      $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
      return $select_query_result;
      }
     */
    /*
      function getUserListByID($listID) {
      global $dbcon, $start_limit;
      $select_q_content = "SELECT * FROM " . CM_LISTUSER . " WHERE list_id = :id ORDER BY id ASC LIMIT " . $start_limit . "," . ROW_PER_PAGE;
      $select_query = $dbcon->prepare($select_q_content);
      $select_query->bindParam(":id", $listID);
      $select_query->execute();
      $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
      return $select_query_result;
      }
     */
    function getCampaignListCount() {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_CAMPAIGNLIST . " WHERE 1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getCampaignListCountUnMapped() {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_CAMPAIGNLIST . " WHERE id NOT IN(SELECT cm_id FROM " . CM_CAMPAIGNLIST . " a," . CM_PROCESSLISTMAIN . " b WHERE b.mapping_status=1 AND a.id=b.cm_id)";
        //$select_q_content = "SELECT count(a.id) as count FROM " . CM_CAMPAIGNLIST . " a,".CM_PROCESSLISTMAIN." b WHERE b.mapping_status=1 AND a.id=b.cm_id";
        // echo $select_q_content;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getUndeliveredMailCount($iProcessID) {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_PROCESSLIST . " WHERE mail_status=4 AND process_id=:pid";
        //echo $select_q_content;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":pid", $iProcessID);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getUndeliveredMails($iProcessID) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_PROCESSLIST . " WHERE process_id = :pid AND mail_status = 4";
        //echo $select_q_content;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":pid", $iProcessID);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getCampaignList() {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_CAMPAIGNLIST . "";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function addFiledetails($iPid, $iCmId, $sPath, $sPdate) {
        global $dbcon;
        $query = "INSERT INTO " . SPECIAL_IMAGES . "(pid,cmid,path,process_date)VALUES(:pid,:cmid,:path,:process_date)";
        $insert_query = $dbcon->prepare($query);
        $insert_query->bindParam(":pid", $iPid);
        $insert_query->bindParam(":cmid", $iCmId);
        $insert_query->bindParam(":path", $sPath);
        $insert_query->bindParam(":process_date", $sPdate);
        $msg = ($insert_query->execute()) ? 1 : 0;
        // print_r($insert_query->errorInfo());
    }

    function getCampaignListForSelection() {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_CAMPAIGNLIST . "";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getCampaignListUnMapped() {
        global $dbcon, $start_limit;
        $select_q_content = "SELECT * FROM " . CM_CAMPAIGNLIST . " WHERE id NOT IN(SELECT cm_id FROM " . CM_CAMPAIGNLIST . " a," . CM_PROCESSLISTMAIN . " b WHERE b.mapping_status=1 AND a.id=b.cm_id) ORDER BY id ASC LIMIT " . $start_limit . "," . ROW_PER_PAGE;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function deleteCampaign($campaignID) {
        global $dbcon;
        $delete_q = "DELETE FROM " . CM_CAMPAIGNLIST . " WHERE id = :id";
        $delete_query = $dbcon->prepare($delete_q);
        $delete_query->bindParam(":id", $campaignID);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

    function addCampaign($postarray, $cmUniqueID) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_CAMPAIGNLIST . " WHERE campaign_name = :name ";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":name", $postarray['campaign_name']);
        $select_query->execute();
        $count = $select_query->rowCount();
        $content = htmlentities($postarray['create_new']);
        if (strpos($postarray['create_new'], 'Unsubscribe here') == false) {
            $content .= DISCLAIMER;
        }
        //echo "<pre>";
        //echo "Content is :<br>";
        //echo $content."<br>";
        if ($count > 0) {

            $updatequery = "UPDATE " . CM_CAMPAIGNLIST . " SET short_description = :shortdescription,long_description = :longdescription,campaign_content = :campaigncontent WHERE campaign_name = :campaignname";
            $update_query = $dbcon->prepare($updatequery);
            $update_query->bindParam(":campaignname", $postarray['campaign_name']);
            $update_query->bindParam(":shortdescription", $postarray['campaign_shortDesc']);
            $update_query->bindParam(":longdescription", $postarray['campaign_longDesc']);
            $update_query->bindParam(":campaigncontent", $content);
            $msg = ($update_query->execute()) ? 1 : 0;
        } else {
            $query = "INSERT INTO " . CM_CAMPAIGNLIST . "(campaign_name,short_description,long_description,campaign_uniqueid,campaign_content)VALUES(:campaign_name,:short_description,:long_description,:campaign_uniqueid,:campaigncontent)";
            $insert_query = $dbcon->prepare($query);
            $insert_query->bindParam(":campaign_name", $postarray['campaign_name']);
            $insert_query->bindParam(":short_description", $postarray['campaign_shortDesc']);
            $insert_query->bindParam(":long_description", $postarray['campaign_longDesc']);
            $insert_query->bindParam(":campaign_uniqueid", $cmUniqueID);
            //   echo "<pre>";
            //  echo $content.'<br>';
            $insert_query->bindParam(":campaigncontent", $content);
            $msg = ($insert_query->execute()) ? 1 : 0;
            // print_r($msg);
            //exit;
        }
        return $msg;
    }

    /*
      function updateCampaign($postarray) {
      global $dbcon;
      $query = "UPDATE " . CM_CAMPAIGNLIST . " SET user_list_id= :user_list_id,start_date= :start_date WHERE id= :id";
      $update_query = $dbcon->prepare($query);
      $update_query->bindParam(":user_list_id", $postarray['user_list']);
      $update_query->bindParam(":start_date", $postarray['campaign_date']);
      $update_query->bindParam(":id", $postarray['campaign_list']);
      $msg = ($update_query->execute()) ? 1 : 0;
      return $msg;

      }
     */

//
//    function updateUnsubscripstion($sPID, $userID) {
//        global $dbcon;
//        $query = "UPDATE " . CM_PROCESSLIST . " SET Unsubscription = 1 WHERE process_id= :process_id AND user_id=:user_id";
//        $update_query = $dbcon->prepare($query);
//        $update_query->bindParam(":user_id", $userID);
//        $update_query->bindParam(":process_id", $sPID);
//        $msg = ($update_query->execute()) ? 1 : 0;
//        return $msg;
//    }

    function addUnsubscribedList($sPid, $sUserId, $sListId, $sUserEmail) {
        global $dbcon;
        // echo $sUserEmail;
        // exit;
        $sSelectQ = "SELECT mail_id FROM " . UNSUBSCRIBED_USERS . " WHERE mail_id = :mail_id";
        $oSelectQ = $dbcon->prepare($sSelectQ);
        $oSelectQ->bindParam(":mail_id", $sUserEmail);
        $oSelectQ->execute();
        // print_r($oSelectQ->errorInfo());
        $aEmail = $oSelectQ->fetch(PDO::FETCH_ASSOC);
        // print_r($aEmail);
//echo sizeof($aEmail);
//exit;
        if (@$aEmail['mail_id'] == $sUserEmail) {
            return 2;
        } else {
            $sInsertQ = "INSERT INTO " . UNSUBSCRIBED_USERS . "(mail_id,datetime,user_id,list_id,pid) VALUES (:mail_id,:datetime,:user_id,:list_id,:pid)";
            // exit;
            $oInsetQ = $dbcon->prepare($sInsertQ);
            $sDateTime = date('Y-m-d H:i:s');
            $oInsetQ->bindParam(':mail_id', $sUserEmail);
            $oInsetQ->bindParam(':datetime', $sDateTime);
            $oInsetQ->bindParam(':user_id', $sUserId);
            $oInsetQ->bindParam(':list_id', $sListId);
            $oInsetQ->bindParam(':pid', $sPid);
            return $oInsetQ->execute() ? 1 : 0;
        }
    }

    function addProcessCampaign($postarray) {
        global $dbcon;
        $iWeekEnd = 0;
        if (@$postarray['weekend'] == 1) {
            $iWeekEnd = 1;
        }
        $insertProcessquery = "INSERT INTO " . CM_PROCESSLISTMAIN . "(cm_id,start_date,end_date,weekend,mail_subject)VALUES(:cm_id,:start_date,:end_date,:weekend,:mail_subject)";
        $insert_query = $dbcon->prepare($insertProcessquery);
        $insert_query->bindParam(":cm_id", $postarray['campaign_list']);
        $insert_query->bindParam(":start_date", $postarray['campaign_from_date']);
        $insert_query->bindParam(":end_date", $postarray['campaign_to_date']);
        $insert_query->bindParam(":weekend", $iWeekEnd);
		$insert_query->bindParam(":mail_subject", $postarray['campaign_subject']);
        $msg = ($insert_query->execute()) ? 1 : 0;
        return $msg;
    }

    function getProcessCampaignMainID() {
        global $dbcon;
        $insertProcessquery = "SELECT LAST_INSERT_ID()";
        // $insertProcessquery = "SELECT id FROM " . CM_PROCESSLISTMAIN . " WHERE cm_id=:cm_id AND start_date=:start_date AND end_date=:end_date";
        $insert_query = $dbcon->prepare($insertProcessquery);
        // $insert_query->bindParam(":cm_id", $postarray['campaign_list']);
        // $insert_query->bindParam(":start_date", $postarray['campaign_from_date']);
        // $insert_query->bindParam(":end_date", $postarray['campaign_to_date']);
        $insert_query->execute();
        $sId = $insert_query->fetch(PDO::FETCH_ASSOC);
        // print_r($sId);
        return $sId;
    }

    function getCampaignContent($campaignId) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_CAMPAIGNLIST . " WHERE id=:id";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":id", $campaignId);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function editCampaign($postarray, $campaign_id) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_CAMPAIGNLIST . " WHERE campaign_name = :name AND id != :id";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":name", $postarray['campaign_name']);
        $select_query->bindParam(":id", $campaign_id);
        $select_query->execute();
        $count = $select_query->rowCount();
        if ($count > 0) {
            $msg = 2;
        } else {
            $query = "UPDATE " . CM_CAMPAIGNLIST . " SET  campaign_name = :campaignname,short_description = :shortdescription,long_description = :longdescription,campaign_content = :campaigncontent WHERE id= :id";
            $update_query = $dbcon->prepare($query);
            $update_query->bindParam(":campaignname", $postarray['campaign_name']);
            $update_query->bindParam(":shortdescription", $postarray['campaign_shortDesc']);
            $update_query->bindParam(":longdescription", $postarray['campaign_longDesc']);
            $update_query->bindParam(":campaigncontent", $postarray['create_new']);
            $update_query->bindParam(":id", $campaign_id);
            $msg = ($update_query->execute()) ? 1 : 0;
        }
        return $msg;
    }

    function getUsersCount() {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_LIST . " WHERE 1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getCampaignListCountByName($campaign_name) {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_CAMPAIGNLIST . " WHERE campaign_name = :campaign_name";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":campaign_name", $campaign_name);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getCampaignListByName($campaign_name) {
        global $dbcon, $start_limit;
        $select_q_content = "SELECT * FROM " . CM_CAMPAIGNLIST . " WHERE campaign_name = :campaign_name";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":campaign_name", $campaign_name);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    /*
      function getProcessCampaignListCount() {
      global $dbcon;
      $select_q_content = "SELECT count(id) as count FROM " . CM_PROCESSLISTMAIN . " WHERE 1";
      $select_query = $dbcon->prepare($select_q_content);
      $select_query->execute();
      $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
      $count = $select_query_result['count'];
      return $count;
      }
     */

    function getProcessCampaignMainListCount() {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_PROCESSLISTMAIN . " WHERE TableName != '' AND mapping_status=0";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getProcessCampaignMainListCountALL() {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_PROCESSLISTMAIN . " WHERE TableName != ''";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        // print_r($select_query->errorInfo());
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getProcessCampaignMainListCount1() {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_PROCESSLISTMAIN . " WHERE TableName != '' AND mapping_status=1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        // print_r($select_query->errorInfo());
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getMailCountByStatus($sPid, $sStatus) {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_PROCESSLIST . " WHERE process_id = :process_id AND mail_status = :mail_status";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":process_id", $sPid);
        $select_query->bindParam(":mail_status", $sStatus);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getMailCountByStatusByDateRange($sPid, $sStatus, $sStartDate, $sEndDate) {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . CM_PROCESSLIST . " WHERE process_id = :process_id AND mail_status = :mail_status";

        if ($sStartDate != '')
            $select_q_content .= " AND (DATE(`mail_date`) >= '" . $sStartDate . "')";

        if ($sEndDate != '')
            $select_q_content .= " AND (DATE(`mail_date`) <= '" . $sEndDate . "') ";

        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":process_id", $sPid);
        $select_query->bindParam(":mail_status", $sStatus);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getMailCountByStatusViewType($sViewType, $sStartDate, $sEndDate) {
        global $dbcon;
        // echo $sStartDate.'--'.$sEndDate;
        $sSelQ = "SELECT COUNT(id) as mailcount,"
                . "" . $sViewType . "(mail_date)  as date,"
                . "YEAR(mail_date)  as year,"
                . "mail_status as status"
                . " FROM " . CM_PROCESSLIST . " WHERE 1";

        if ($sStartDate != '')
            $sSelQ .= " AND (DATE(`mail_date`) >= '" . $sStartDate . "')";

        if ($sEndDate != '')
            $sSelQ .= " AND (DATE(`mail_date`) <= '" . $sEndDate . "') ";

        $sSelQ .= " GROUP BY mail_status,"
                . " " . $sViewType . "(mail_date),"
                . "YEAR(mail_date)";

        $oSelQ = $dbcon->prepare($sSelQ);
        $oSelQ->execute();
        return $oSelQ->fetchAll(PDO::FETCH_ASSOC);
    }

    function getProcessCampaignList() {
        global $dbcon;
        $select_q_content = "SELECT a.*,b.campaign_name FROM " . CM_PROCESSLISTMAIN . " a," . CM_CAMPAIGNLIST . " b WHERE a.cm_id = b.id";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }
	
	
    function getProcessCampaignListByDateRange($sStartDate, $sEndDate) {
        global $dbcon;
        $select_q_content = "SELECT a.*,b.campaign_name FROM " . CM_PROCESSLISTMAIN . " a," . CM_CAMPAIGNLIST . " b WHERE a.cm_id = b.id ";

        if ($sStartDate != '')
            $select_q_content .= " AND (DATE(a.start_date) >= '" . $sStartDate . "')";

        if ($sEndDate != '')
            $select_q_content .= " AND (DATE(a.start_date) <= '" . $sEndDate . "') ";
		
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
		//print_r($select_query_result);
		//exit;
        return $select_query_result;
    }
	
	
	
    function getProcessCampaignMainListAll() {
        global $dbcon, $start_limit;
        $select_q_content = "SELECT a.*,b.campaign_name FROM " . CM_PROCESSLISTMAIN . " a," . CM_CAMPAIGNLIST . " b WHERE a.cm_id = b.id and a.TableName != '' ORDER BY id ASC LIMIT " . $start_limit . "," . ROW_PER_PAGE;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getPrcessedCampaignIds() {
        global $dbcon;
        $select_q_content = "SELECT pid FROM " . CM_PROCESSLISTMAIN . " WHERE TableName != '' and mapping_status =1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessCampaignMainList1() {
        global $dbcon, $start_limit;
        $select_q_content = "SELECT a.*,b.campaign_name FROM " . CM_PROCESSLISTMAIN . " a," . CM_CAMPAIGNLIST . " b WHERE a.cm_id = b.id and a.TableName != '' and a.mapping_status != 0 ORDER BY id ASC LIMIT " . $start_limit . "," . ROW_PER_PAGE;
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessCampaignMainListForCmSelection() {
        global $dbcon;
        $select_q_content = "SELECT a.*,b.campaign_name FROM " . CM_PROCESSLISTMAIN . " a," . CM_CAMPAIGNLIST . " b WHERE a.cm_id = b.id and a.TableName != '' and a.mapping_status != 0";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getCampaigIdsFromCMList() {
        global $dbcon;
        $select_q_content = "SELECT id FROM " . CM_CAMPAIGNLIST . " WHERE 1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getCampaigIdsFromPCMMain() {
        global $dbcon;
        $select_q_content = "SELECT cm_id FROM " . CM_PROCESSLISTMAIN . " WHERE 1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

//
//    function getProcessCampaignMainByPId($PID) {
//        global $dbcon;
//        $select_q_content = "SELECT * FROM " . CM_PROCESSLISTMAIN . " WHERE pid = :pid";
//        $select_query = $dbcon->prepare($select_q_content);
//        $select_query->bindParam(":pid", $PID);
//        $select_query->execute();
//        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
//        return $select_query_result;
//    }

    function getProcessCampaignMainById($ID) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_PROCESSLISTMAIN . " WHERE id = :id";
        // echo "$select_q_content<br>";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":id", $ID);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getSpecialImageByPid($iPd, $sDate) {
        global $dbcon;
        //echo $iPd.$sDate;
        $select_q_content = "SELECT * FROM " . SPECIAL_IMAGES . " WHERE pid = :pid AND process_date = :process_date";
        // echo "$select_q_content<br>";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":pid", $iPd);
        $select_query->bindParam(":process_date", $sDate);
        $select_query->execute();
        // print_r($select_query->errorInfo());
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessCampaignMainByPId($ID) {
        global $dbcon;
        $select_q_content = "SELECT * FROM " . CM_PROCESSLISTMAIN . " WHERE pid = :pid";
        // echo "$select_q_content<br>";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->bindParam(":pid", $ID);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessCampaignPIds() {
        global $dbcon;
        $select_q_content = "SELECT pid FROM " . CM_PROCESSLISTMAIN . " WHERE 1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function deleteProcess($campaignID) {
        global $dbcon;
        $delete_q = "DELETE FROM " . CM_PROCESSLISTMAIN . " WHERE id = :id";
        $delete_query = $dbcon->prepare($delete_q);
        $delete_query->bindParam(":id", $campaignID);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

    function deleteProcessByTable($campaignID, $sPid) {
        global $dbcon;
        $delete_q = "DELETE FROM " . CM_PROCESSLISTMAIN . " WHERE id = :id AND pid=:pid";
        $delete_query = $dbcon->prepare($delete_q);
        $delete_query->bindParam(":id", $campaignID);
        $delete_query->bindParam(":pid", $sPid);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

    function deleteMapDetails($campaignID, $sPid) {
        global $dbcon;
        $delete_q = "DELETE FROM " . CM_MAPDETAILS . " WHERE cm_id = :id AND pid=:pid";
        $delete_query = $dbcon->prepare($delete_q);
        $delete_query->bindParam(":id", $campaignID);
        $delete_query->bindParam(":pid", $sPid);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

    function dropTable($sTableName) {
        global $dbcon;
        $delete_q = "DROP TABLE IF EXISTS " . $sTableName;
        $delete_query = $dbcon->prepare($delete_q);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

    function addMappingDetails($postarray, $cm_id) {
        global $dbcon;
        $i = 0;
        $j = 0;
        //echo "<pre>";
        // print_r($postarray);
        //echo $postarray['process_id'];
        // exit;
        foreach ($postarray['identifiers'] as $data) {
            $query = "INSERT INTO " . CM_MAPDETAILS . "(pid,cm_id,identifier,map_value,TableName)VALUES(:pid,:cm_id,:identifier,:map_value,:tablename)";
            $insert_query = $dbcon->prepare($query);
            $insert_query->bindParam(":pid", $postarray['process_id']);
            $insert_query->bindParam(":cm_id", $cm_id);
            if (substr_compare($data, "#", 0, 1) === 0) {
                $data = substr($data, 1);
                $insert_query->bindParam(":identifier", $data);
                $urlMapVal = $postarray['urlMapValues' . $j];
                $urlMapVal = substr($urlMapVal, 1);
                $insert_query->bindParam(":map_value", $urlMapVal);
                $j = $j + 1;
            } else {
                $data = $data;
                $insert_query->bindParam(":identifier", $data);
                $insert_query->bindParam(":map_value", $postarray['mapValues'][$i]);
            }
            $insert_query->bindParam(":tablename", $postarray['tn']);
            $msg = ($insert_query->execute()) ? 1 : 0;
            $i = $i + 1;
        }
        return $msg;
    }

    function updateMappingStatus($id) {
        global $dbcon;
        $updateID = 1;
        $query = "UPDATE " . CM_PROCESSLISTMAIN . " SET mapping_status= :mapping_status WHERE pid=:pid";
        $update_query = $dbcon->prepare($query);
        $update_query->bindParam(":mapping_status", $updateID);
        $update_query->bindParam(":pid", $id);
        $msg = ($update_query->execute()) ? 1 : 0;
        return $msg;
    }

    function insertProccessCampaignList($aPCL) {
        global $dbcon;
        // $query = "INSERT INTO " . CM_PROCESSLIST . "(cm_id,list_id,process_date,process_id,user_id,user_email,mail_status,mail_date,phone_number)VALUES(:cm_id,:list_id,:process_date,:process_id,:user_id,:user_email,:mail_status,:mail_date,:phone_number)";
        $query = "INSERT INTO " . CM_PROCESSLIST . "(cm_id,list_id,process_date,process_id,user_id,user_email,mail_status,mail_date)VALUES(:cm_id,:list_id,:process_date,:process_id,:user_id,:user_email,:mail_status,:mail_date)";
        $insert_query = $dbcon->prepare($query);
        $insert_query->bindParam(":cm_id", $aPCL['cm_id']);
        $insert_query->bindParam(":list_id", $aPCL['list_id']);
        $insert_query->bindParam(":process_date", $aPCL['process_date']);
        $insert_query->bindParam(":process_id", $aPCL['process_id']);
        $insert_query->bindParam(":user_id", $aPCL['user_id']);
        $insert_query->bindParam(":user_email", $aPCL['user_email']);
        $insert_query->bindParam(":mail_status", $aPCL['mail_status']);
        $insert_query->bindParam(":mail_date", $aPCL['mail_date']);
        //$insert_query->bindParam(":phone_number", $aPCL['mobile']);
        $msg = ($insert_query->execute()) ? 1 : 0;
        return $msg;
    }

    function getUnsubscribedListCount() {
        global $dbcon;
        $select_q_content = "SELECT count(id) as count FROM " . UNSUBSCRIBED_USERS . " WHERE 1";
        $select_query = $dbcon->prepare($select_q_content);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getUnsubscribedList() {
        global $dbcon, $start_limit;
        $query = "SELECT * FROM " . UNSUBSCRIBED_USERS . " WHERE 1 ORDER BY id ASC LIMIT " . $start_limit . "," . ROW_PER_PAGE;
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function deleteUnsubUser($id) {
        global $dbcon;
        $delete_q = "DELETE FROM " . UNSUBSCRIBED_USERS . " WHERE id = :id";
        $delete_query = $dbcon->prepare($delete_q);
        $delete_query->bindParam(":id", $id);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

    function getProcessAndCampaignDetails() {
        global $dbcon;
        $query = "SELECT a.*,b.* FROM `campaign_list` a, processcampaign_main b WHERE DATE(b.`start_date`)<= DATE(now()) and DATE(b.`end_date`)>= DATE(now()) and a.id = b.cm_id and mapping_status=1";
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessAndCampaignDetailsCount() {
        global $dbcon;
        $query = "SELECT count(*) as count FROM `campaign_list` a, processcampaign_main b WHERE DATE(b.`start_date`)<= DATE(now()) and DATE(b.`end_date`)>= DATE(now()) and a.id = b.cm_id  and mapping_status=1";
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        // print_r($select_query->errorInfo());
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        //echo "Count:  $count<br>";
        //exit;
        return $count;
    }

    function getPreviusDayUnsendMC() {
        global $dbcon;

        $query = "SELECT count(*) as count FROM " . CM_PROCESSLIST . " WHERE mail_priority=1";

        $select_query = $dbcon->prepare($query);
        $select_query->execute();

        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getPreviusDayUnsendDetails() {
        global $dbcon;
        $query = "SELECT * FROM " . CM_PROCESSLIST . " WHERE mail_priority=1";
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessUserDetails($cm_id) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_PROCESSLIST . " WHERE cm_id = :cm_id";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":cm_id", $cm_id);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessUserDetailsByPid($process_id) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_PROCESSLIST . " WHERE process_id = :process_id";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":process_id", $process_id);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function updateMailStatusByEmail($sMailStatus, $sMailDate, $sPid, $sEmail, $sPDate) {
        global $dbcon;
        // echo 'Executing ***<br>';
        //echo "Pid : $sPid and Email : $sEmail<br>"
        $updatequery = "UPDATE " . CM_PROCESSLIST . " SET mail_status = :mail_status,mail_date = :mail_date WHERE process_id = :process_id AND user_email = :user_email AND process_date = :process_date";
        $update_query = $dbcon->prepare($updatequery);
        $update_query->bindParam(":mail_status", $sMailStatus);
        $update_query->bindParam(":mail_date", $sMailDate);
        $update_query->bindParam(":process_id", $sPid);
        $update_query->bindParam(":user_email", $sEmail);
        $update_query->bindParam(":process_date", $sPDate);
        $msg = ($update_query->execute()) ? 1 : 0;
        return $msg;
    }

    function updateMailPriority($sPriority, $sPid, $sUID, $sPDate) {
        global $dbcon;
        // echo 'Executing ***<br>';
        //echo "Pid : $sPid and Email : $sEmail<br>"
        $updatequery = "UPDATE " . CM_PROCESSLIST . " SET mail_priority = :mail_priority WHERE process_id = :process_id AND user_id = :user_id AND process_date = :process_date";
        $update_query = $dbcon->prepare($updatequery);
        $update_query->bindParam(":mail_priority", $sPriority);
        $update_query->bindParam(":process_id", $sPid);
        $update_query->bindParam(":user_id", $sUID);
        $update_query->bindParam(":process_date", $sPDate);
        $msg = ($update_query->execute()) ? 1 : 0;
        return $msg;
    }

    function updateMailStatusByUID($sMailStatus, $sMailDate, $sPid, $iUid, $sPDate) {
        global $dbcon;

        // echo 'Executing ***<br>';
        //echo "Pid : $sPid and Email : $sEmail<br>";
        $updatequery = "UPDATE " . CM_PROCESSLIST . " SET mail_status = :mail_status,mail_date = :mail_date WHERE process_id = :process_id AND user_id = :user_id AND process_date = :process_date";
        $update_query = $dbcon->prepare($updatequery);
        $update_query->bindParam(":mail_status", $sMailStatus);
        $update_query->bindParam(":mail_date", $sMailDate);
        $update_query->bindParam(":process_id", $sPid);
        $update_query->bindParam(":process_date", $sPDate);
        $update_query->bindParam(":user_id", $iUid);
        $msg = ($update_query->execute()) ? 1 : 0;
        //echo "$msg";
        //  exit;
        return $msg;
    }

    function getProcessUserDetailsByDates($process_id, $sSDate) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_PROCESSLIST . " WHERE process_id = :process_id AND process_date = :start_date";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":process_id", $process_id);
        $select_query->bindParam(":start_date", $sSDate);
        //echo "$process_id---$sSDate<br>";
        //  echo "$query<br>";
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getUserListToSendMail($sProcessID) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_PROCESSLIST . " WHERE process_id =:process_id AND process_date=:process_date AND mail_status=0";
        $sSQuery = $dbcon->prepare($query);
        $sSQuery->bindParam(":process_id", $sProcessID);
        $sDate = date('Y-m-d');
        $sSQuery->bindParam(":process_date", $sDate);
        $sSQuery->execute();
        print_r($sSQuery->errorinfo());
        $select_query_result = $sSQuery->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    /*
      function getUserListToSendSMS($sProcessID) {
      global $dbcon;
      //  echo $sProcessID;
      $query = "SELECT * FROM " . CM_PROCESSLIST . " WHERE process_id =:process_id AND process_date=:process_date";
      $sSQuery = $dbcon->prepare($query);
      $sSQuery->bindParam(":process_id", $sProcessID);
      $sDate = date('Y-m-d');
      $sSQuery->bindParam(":process_date", $sDate);
      $sSQuery->execute();
      // print_r($sSQuery->errorinfo());
      $select_query_result = $sSQuery->fetchAll(PDO::FETCH_ASSOC);
      return $select_query_result;
      }
     */

    function getProcessUserDetailsByTable($tablename) {
        global $dbcon;
        $query = "SELECT * FROM " . $tablename . " WHERE Subscription=0 ";
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getMapDetails($cm_id) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_MAPDETAILS . " WHERE cm_id = :cm_id ";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":cm_id", $cm_id);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getMapDetailsByTable($cm_id, $tablename) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_MAPDETAILS . " WHERE cm_id = :cm_id AND TableName = :tablename";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":cm_id", $cm_id);
        $select_query->bindParam(":tablename", $tablename);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getUserDetailsByTable($to_mail, $tableName) {
        global $dbcon;
        $query = "SELECT * FROM " . $tableName . " WHERE EmailID = :email ";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":email", $to_mail);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getUserDetails($to_mail) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_LISTUSER . " WHERE email = :email ";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":email", $to_mail);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getMapDetailsBasedOnLink($cm_id, $linkNo) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_MAPDETAILS . " WHERE cm_id = :cm_id AND id = :lno";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":cm_id", $cm_id);
        $select_query->bindParam(":lno", $linkNo);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessUserDetailsByUserID($cm_id, $userid) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_PROCESSLIST . " WHERE cm_id = :cm_id AND user_id = :user_id";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":cm_id", $cm_id);
        $select_query->bindParam(":user_id", $userid);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessUserDetailsByUserIDPID($sPID, $sUID) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_PROCESSLIST . " WHERE process_id = :process_id AND user_id = :user_id";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":process_id", $sPID);
        $select_query->bindParam(":user_id", $sUID);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getProcessUserDetailsByUserIDByTable($table_id, $userid) {
        global $dbcon;
        $query = "SELECT * FROM " . $table_id . " WHERE ID = :user_id";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":user_id", $userid);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function addVisitorTracking($visitorTrack) {
        global $dbcon;
        $query = "INSERT INTO " . CM_VISITORTRACK . "(user_id,process_id,cm_id,link_name,ip_address,visited_on,visitor_location,visitor_device)VALUES(:user_id,:process_id,:cm_id,:link_name,:ip_address,:visited_on,:visitor_location,:visitor_device)";
        $insert_query = $dbcon->prepare($query);
        $insert_query->bindParam(":user_id", $visitorTrack['user_id']);
        $insert_query->bindParam(":process_id", $visitorTrack['process_id']);
        $insert_query->bindParam(":cm_id", $visitorTrack['cm_id']);
        $insert_query->bindParam(":link_name", $visitorTrack['link_name']);
        $insert_query->bindParam(":ip_address", $visitorTrack['ip_add']);
        $insert_query->bindParam(":visited_on", $visitorTrack['visited_on']);
        $insert_query->bindParam(":visitor_location", $visitorTrack['visitor_location']);
        $insert_query->bindParam(":visitor_device", $visitorTrack['visitor_device']);
        $msg = ($insert_query->execute()) ? 1 : 0;
        return $msg;
    }

    function displayVisitorTrackDetails() {
        global $dbcon;
        $query = "SELECT * FROM " . CM_VISITORTRACK;
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function displayVisitorTrackDetailsPid($iPid) {
        global $dbcon;
        $query = "SELECT * FROM " . CM_VISITORTRACK . " WHERE process_id = :process_id";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":process_id", $iPid);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function countVisitorTrackDetails() {
        global $dbcon;
        $query = "SELECT count(*) as count FROM " . CM_VISITORTRACK;
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function countVisitorTrackDetailsByPid($iPid) {
        global $dbcon;
        $query = "SELECT count(*) as count FROM " . CM_VISITORTRACK . " WHERE process_id = :process_id";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":process_id", $iPid);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function countVisitorTrackDetailsByPidByDateRange($iPid, $sStartDate, $sEndDate) {
        global $dbcon;
        $query = "SELECT count(*) as count FROM " . CM_VISITORTRACK . " WHERE process_id = :process_id";

        if ($sStartDate != '')
            $query .= " AND (DATE(`visited_on`) >= '" . $sStartDate . "')";

        if ($sEndDate != '')
            $query .= " AND (DATE(`visited_on`) <= '" . $sEndDate . "') ";

        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":process_id", $iPid);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getUniqIpList($sStartDate, $sEndDate) {
        global $dbcon;
        $query = "SELECT DISTINCT(ip_address) FROM " . CM_VISITORTRACK . " WHERE 1 ";

        if ($sStartDate != '')
            $query .= " AND (DATE(`visited_on`) >= '" . $sStartDate . "')";

        if ($sEndDate != '')
            $query .= " AND (DATE(`visited_on`) <= '" . $sEndDate . "') ";

        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        return $select_query->fetchAll(PDO::FETCH_ASSOC);
    }
	
	function getListWithHitCount($sStartDate, $sEndDate) {
        global $dbcon;
		
		$query = "SELECT cm_id,user_id,count(id) as hit_count FROM `visitor_tracking` ";
        
		if(($sStartDate != '') || $sEndDate != '') {
			$query .= " WHERE 1=1";
			
			if ($sStartDate != '')
				$query .= " AND (DATE(visited_on) >= '" . $sStartDate . "') ";

			if ($sEndDate != '')
				$query .= " AND (DATE(visited_on) <= '" . $sEndDate . "') ";
		}
		$query .= " group by user_id,cm_id "; 
		
		//echo $query;
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
		//print_r($select_query->errorInfo());
		
		//print_r($select_query->fetchAll(PDO::FETCH_ASSOC));
		//exit;
        return $select_query->fetchAll(PDO::FETCH_ASSOC);
    }
	
	function getEmaillIdByUserAndCmId($cm_id,$user_id) {
        global $dbcon;
		
		$query = "SELECT user_email FROM `processcampaign_list` WHERE cm_id = :cm_id AND user_id = :user_id";
        $select_query = $dbcon->prepare($query);
		$select_query->bindParam(":cm_id",$cm_id);
		$select_query->bindParam(":user_id",$user_id);
        $select_query->execute();
		
        $result = $select_query->fetch(PDO::FETCH_ASSOC);
		
		return $result['user_email'];
    }
	
	function getListWithHitCountByCampaign($sStartDate, $sEndDate){
		global $dbcon;
		$query = "SELECT cm_id,user_id,count(id) as hit_count FROM `visitor_tracking` ";
        
		if(($sStartDate != '') || $sEndDate != '') {
			$query .= " WHERE 1=1";
			
			if ($sStartDate != '')
				$query .= " AND (DATE(visited_on) >= '" . $sStartDate . "') ";

			if ($sEndDate != '')
				$query .= " AND (DATE(visited_on) <= '" . $sEndDate . "') ";
		}
		$query .= " group by cm_id "; 
		
		//echo $query;
		 
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
		//print_r($select_query->errorInfo());
		
		//print_r($select_query->fetchAll(PDO::FETCH_ASSOC));
		//exit;
        return $select_query->fetchAll(PDO::FETCH_ASSOC);
	
	}
	
	function getCampaignNameByCmId($cm_id){
		global $dbcon;
		$query = "SELECT campaign_name FROM " . CM_CAMPAIGNLIST . " WHERE Id = :id";
		$select_query = $dbcon->prepare($query);
		$select_query->bindParam(":id", $cm_id);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $sCName = $select_query_result['campaign_name'];
        return $sCName;
	}
	
    function gethitCountByIp($ip, $sStartDate, $sEndDate) {
        global $dbcon;
        $query = "SELECT count(*) as count FROM " . CM_VISITORTRACK . " WHERE ip_address = :ip_address";
        if ($sStartDate != '')
            $query .= " AND (DATE(`visited_on`) >= '" . $sStartDate . "')";

        if ($sEndDate != '')
            $query .= " AND (DATE(`visited_on`) <= '" . $sEndDate . "') ";

        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":ip_address", $ip);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function deleteUnupdatedMergeTN() {
        global $dbcon;
        $delete_q = "DELETE FROM " . CM_PROCESSLISTMAIN . " WHERE TableName=:tablename";
        $delete_query = $dbcon->prepare($delete_q);
        $a = "";
        $delete_query->bindParam(":tablename", $a);
        $msg = ($delete_query->execute()) ? 1 : 0;
        return $msg;
    }

    function getAllDetails($sTableName) {
        global $dbcon;
        $query = "SELECT * FROM $sTableName";
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result[0];
    }

    /*
      function displayVisitorTrackByCampaignName($campaign_name) {
      global $dbcon;
      $query = "SELECT campaign_name FROM " . CM_CAMPAIGNLIST . " WHERE Id = :id";
      $select_query = $dbcon->prepare($query);
      $select_query->bindParam(":id", $campaign_name);
      $select_query->execute();
      $Name = $select_query->fetch(PDO::FETCH_ASSOC);

      $query = "SELECT * FROM " . CM_VISITORTRACK . " WHERE campaign_name=:campaign_name";
      $select_query = $dbcon->prepare($query);
      $select_query->bindParam(":campaign_name", $Name['campaign_name']);
      $select_query->execute();
      $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
      return $select_query_result;
      }
     */
    /*
      function countVisitorTrackByCampaignName($campaign_name) {
      global $dbcon;
      $query = "SELECT campaign_name FROM " . CM_CAMPAIGNLIST . " WHERE Id = :id";
      $select_query = $dbcon->prepare($query);
      $select_query->bindParam(":id", $campaign_name);
      $select_query->execute();
      $Name = $select_query->fetch(PDO::FETCH_ASSOC);

      $query = "SELECT count(*) as count FROM " . CM_VISITORTRACK . " WHERE campaign_name=:campaign_name";
      $select_query = $dbcon->prepare($query);
      $select_query->bindParam(":campaign_name", $Name['campaign_name']);
      $select_query->execute();
      $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
      $count = $select_query_result['count'];
      return $count;
      }
     */

    function countVisitorTrackByPid($iPid) {
        global $dbcon;
        $query = "SELECT count(id) as count FROM " . CM_VISITORTRACK . " WHERE process_id=:process_id";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":process_id", $iPid);
        $select_query->execute();
        $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
        $count = $select_query_result['count'];
        return $count;
    }

    function getHitCount($iPid, $month) {
        global $dbcon;
        $query = "SELECT COUNT(DISTINCT (`user_id`)) as hitcount,DAY( (`visited_on`) ) as groupDate FROM " . CM_VISITORTRACK . " WHERE process_id=:process_id AND MONTH( `visited_on` ) =:monthNum group by date(`visited_on`);";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":process_id", $iPid);
        $select_query->bindParam(":monthNum", $month);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }

    function getHitCountAll($sPid) {
        global $dbcon;
        $query = "SELECT COUNT(DISTINCT (`user_id`)) as hitcount,month( (`visited_on`) ) as groupDate FROM " . CM_VISITORTRACK . " WHERE process_id=:process_id group by month(`visited_on`);";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":process_id", $sPid);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
        return $select_query_result;
    }
	
	function getUniqEmailListWithHitCount($sStartDate,$sEndDate) {
		global $dbcon;
		$query = "SELECT *,count(id) as hit_count FROM " . CM_VISITORTRACK;
		$query .= " WHERE 1=1";
		if ($sStartDate != '')
            $query .= " AND (DATE(`visited_on`) >= '" . $sStartDate . "')";

        if ($sEndDate != '')
            $query .= " AND (DATE(`visited_on`) <= '" . $sEndDate . "') ";

        $query .= " GROUP BY cm_id,user_id";
		
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
		return $select_query_result;
	}
	
	function getUniqLinkListWithHitCount($suserID,$scmID) {
		global $dbcon;
		$query = "SELECT *,count(id) as hit_count FROM " .CM_VISITORTRACK. " WHERE (`user_id`= ".$suserID." AND `cm_id` = ".$scmID.") GROUP BY `link_name`,`user_id`,`cm_id`";
        $select_query = $dbcon->prepare($query);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll(PDO::FETCH_ASSOC);
		return $select_query_result;
	}

}
