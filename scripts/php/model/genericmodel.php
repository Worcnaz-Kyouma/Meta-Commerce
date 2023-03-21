<?php
require_once "repository.php";

class Generic extends Repository
{
    /*DAO Methods*/
    //Select
    public static function select($columns, $tables, $whereClause){
        $select = parent::getTemplateDynamicSelect($columns, $tables, $whereClause);

        $statement = parent::executeQuery($select);

        $objArray = self::fetchInModelObjectArray($statement);

        return $objArray;
    }   

    //Insert
    public static function persist($table, $values, $columns=null, $haveSingleQuotes=null){
        $insert = parent::getTemplateDynamicInsert($table, $values, $haveSingleQuotes, $columns);

        parent::executeQuery($insert);
    }

    //Update
    private static function update($table, $columns, $values, $whereClause=null){
        $update = parent::getTemplateDynamicUpdate($table, $columns, $values, $whereClause);

        parent::executeQuery($update);
    }

    //Misc
    private static function fetchInModelObjectArray($statement){
        return parent::fetchInAnyObjectArray($statement, "stdClass");
    }

}

?>
