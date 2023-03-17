<?php
    require_once "../model/repository.php";

    class RepositoryController{
        static function insertIntoTableWithObject($table, $obj){
            Repository::insertIntoTableWithObject($table, $obj);
        }
    }
?>