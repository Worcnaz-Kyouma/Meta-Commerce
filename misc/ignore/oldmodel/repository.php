<?php
//CONSTANTS
define("HOST", "localhost");
define("PORT", 3307);
define("DBNAME", "meta_commerce");
define("USER", "root");
define("PASSWORD", "pradopgworcnaz0");
    class Repository{
        //DB contact
        private static function getDB(){
            return new PDO("mysql:" 
            . "host=" . HOST . ";"
            . "port=" . PORT . ";" 
            . "dbname=" . DBNAME . ";"

            , USER, PASSWORD);
        }
        static function executePreparetedQuery($query, $values){
            $db = self::getDB();
            
            $statement = $db->prepare($query);
            $statement->execute($values);
    
            return $statement;
        }
        static function executeQuery($query){
            $db = self::getDB();
            
            $result = $db->query($query);
    
            return $result;
        }

        //Dynamic Select Query
        private static function getDynamicShowColumns(array $showColumns){
            $showColumnsString = $showColumns[0];
            for($index=1; $index<count($showColumns); $index++){
                $showColumnsString.=', ';
                $showColumnsString.=$showColumns[$index];
            }
            return $showColumnsString;
        }
        private static function getDynamicFromClause(array $tables){
            $fromClause = 'FROM ' . $tables[0];
            for($index=1; $index<count($tables); $index++){
                $fromClause.=', ';
                $fromClause.=$tables[$index];
            }
            return $fromClause;
        }
        private static function addSingleQuotes(array & $values, array $haveSingleQuoteBooleanArray){
            for($index=0; $index<count($values); $index++){
                if($haveSingleQuoteBooleanArray[$index]){
                    $values[$index] = "'" . $values[$index] . "'";
                }
            }
        }
        private static function getDynamicWhereClause(array $relationColumns, array $logicOperators, array $values){
            $whereClause = 'WHERE ' . $relationColumns[0] . " = " . $values[0];
            for($index=1; $index<count($relationColumns); $index++){
                $whereClause .= " " . $logicOperators[$index-1] . " " . $relationColumns[$index] . 
                " = " . $values[$index];
            }
            return $whereClause;
        }
        static function getGeneralDynamicSelect($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values){
            $selectClause = 'SELECT';

            $showColumnsString=' *';
            if($showColumns!=null){
                $showColumnsString = ' ' . self::getDynamicShowColumns($showColumns);
            }

            $fromClause = ' ' . self::getDynamicFromClause($tables);

            self::addSingleQuotes($values, $haveSingleQuoteBooleanArray);

            $whereClause = '';
            if($relationColumns!=null){
                $whereClause = ' ' . self::getDynamicWhereClause($relationColumns, $logicOperators, $values);
            }

            return $selectClause . $showColumnsString . $fromClause . $whereClause;
        }

        //Dynamic Insert Query
        static function getDynamicGeneralInsert($table, $values){
            $insert = 'INSERT INTO ' . $table . " VALUES('" . $values . "')";
            return $insert;
        }

        //Misc
        static function fetchInObjectTemplateArray($statement, $class){
            $objectArray=array();
            while($row = $statement->fetchObject($class)){
                $objectArray[]=$row;
            }
            return $objectArray;
        }
        static function fetchInStringArray($statement, $column){
            $stringArray=array();
            while($row = $statement->fetch()){
                $stringArray[]=$row[$column];
            }
            return $stringArray;
        }
        static function castObjectIntoArrayOfValuesFormattedForQuery(Object $obj){
            $arrayObj = (array) $obj;
            $values = implode("','", $arrayObj);
            return $values;
        }
    }
?>
