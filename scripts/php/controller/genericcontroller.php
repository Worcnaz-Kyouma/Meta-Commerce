<?php
    require_once "C:\\xampp\htdocs\Projects\Meta-Commerce\scripts\php\model\genericmodel.php";

    class GenericController{
        static function select($columns, $tables, $whereClause){
            return Generic::select($columns, $tables, $whereClause);
        }
        
        static function persist($table, $values, $columns=null, $haveSingleQuotes=null){
            return Generic::persist($table, $values, $columns, $haveSingleQuotes);
        }

        static function update($table, $columns, $values, $whereClause=null){
            return Generic::update($table, $columns, $values, $whereClause);
        }
    }
?>