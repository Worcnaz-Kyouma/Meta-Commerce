<?php
    require_once "../model/genericmodel.php";

    class GenericController{
        static function select($columns, $tables, $where){
            return Generic::select($columns, $tables, $where);
        }
        
        static function persist($table, $values, $columns=null, $haveSingleQuotes=null){
            return Generic::persist($table, $values, $columns, $haveSingleQuotes);
        }
    }
?>