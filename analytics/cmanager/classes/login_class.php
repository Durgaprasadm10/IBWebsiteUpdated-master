<?php

//error_reporting (E_ALL ^ E_NOTICE);
Class Login {

    function authendication($username, $password) {
        global $dbcon;
        $password = md5($password);

        $query = "SELECT * FROM " . ADMIN_LOGIN . " WHERE `username` = :username AND `password` = :password";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":username", $username);
        $select_query->bindParam(":password", $password);
        $select_query->execute();
        $select_query_result = $select_query->fetchAll();
        if (!$select_query_result) {
            $login_result = "failed";
        } else {
            $login_result = "success";
        }
        return $login_result;
    }

}

?>