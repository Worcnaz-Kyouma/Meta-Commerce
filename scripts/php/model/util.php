<?php
function getSessionedUser($pk_id_user){
        $whereClause = "pk_id_user = " . $pk_id_user;
        $user = UserController::select($whereClause)[0];
        return $user;
    }
    function getSessionedMarket($pk_id_market){
        $whereClause = "pk_id_market = " . $pk_id_market;
        $market = MarketController::select($whereClause)[0];
        return $market;
    }
    function getEmployerData($fk_id_user, $fk_id_market){
        $column = "*";
        $table = "employer";
        $whereClause = "fk_id_user = " . $fk_id_user . " and " . "fk_id_market = " . $fk_id_market;
        $additionalEmployerData = GenericController::select($column, $table, $whereClause)[0];
        return $additionalEmployerData;
    }
    function standardValidateForMarket($var){
        if(empty($var)){
            session_destroy();
            header('Location: marketlogin.php');
            die();
        }
    }
?>