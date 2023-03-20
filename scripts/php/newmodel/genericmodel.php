<?php
require_once "repository.php";

class Generic extends Repository
{
    /*DAO Methods*/
    //Select
    public static function getGenericsByParameters($select, $tables, $where){
        $select = parent::getTemplateDynamicSelect($select, $tables, $where);

        $statement = parent::executeQuery($select);

        $objArray = self::fetchInGenericObjectArray($statement);

        return;
    }   

    //Insert
    private static function insertIntoGenericWithValues($table, $values, $columns=null, $haveSingleQuotes=null){
        $insert = parent::getTemplateDynamicInsert($table, $values, $haveSingleQuotes, $columns);

        parent::executeQuery($insert);
    }

    //Update
    private static function updateGenericsWithParameters($table, $columns, $values, $whereClause=null){
        $update = parent::getTemplateDynamicUpdate($table, $columns, $values, $whereClause);

        parent::executeQuery($update);
    }

    //Misc
    private static function fetchInGenericObjectArray($statement){
        return parent::fetchInAnyObjectArray($statement, "stdClass");
    }

}

?>
