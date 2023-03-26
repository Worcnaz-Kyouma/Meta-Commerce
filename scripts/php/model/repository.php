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
    //Documentation: Will receive columns, tables and the where clause to concatenate and return
    public static function getTemplateDynamicSelect($columns, $tables, $whereClause){
        $query = "SELECT ";

        $query .= is_array($columns) ? implode(', ', $columns) : $columns;

        $query .= ' FROM ';

        $query .= is_array($tables) ? implode(', ', $tables) : $tables;

        $query .= ' WHERE ';
        $query .= $whereClause;

        return $query;

    }

    //Dynamic Insert Query
    //Documentation: Will receive columns, table and the values to insert into table. If the values comes from an object so the function will convert the object to array and put single quotes in the necessary values to sql. The haveSingleQuotes will be an array of booleans, matching values ​​one by one in your single quote needs
    public static function getTemplateDynamicInsert($table, $values, $haveSingleQuotes=null, $columns=null){
        $query = "INSERT ";

        if($columns!=null)
            $query .= '(' . implode(', ', $columns) . ') ';

        $query .= "INTO " . $table . " ";

        if(is_object($values)){
            $values = self::convertObjectToArrayOfValues($values);
            $values = self::addSingleQuotesWithBooleans($values, $haveSingleQuotes);
        }

        $query .= "VALUES (" . implode(', ', $values) . ')';
        
        return $query;
    }
    
    //Dynamic Update Query
    public static function getTemplateDynamicUpdate($table, $columns, $values, $whereClause=null){
        $query = "UPDATE ";

        $query .= $table . " ";

        $query .= "SET " . self::concatenateColumnValue($columns, $values) . " ";

        if($whereClause!=null){
            $query .= "WHERE " . $whereClause;
        }
    
        return $query;
    }

    //Dynamic Delete Query
    public static function getTemplateDynamicDelete(){

    }

    //Dynamic Where Clause
    //Documentation: Create dynamic where with relationamlColumns, logic operators and values
    public static function getDynamicWhereClause($relationalColumns, $logicOperators, $relationalValues){
        $whereClause = self::concatenateColumnValue($relationalColumns, $relationalValues, $logicOperators);
        return $whereClause;
    }

    //Util functions

    //Documentation: Take a statement result of one query and fetch that into an object array based on certain clas
    //Input: Statement result from an query, class of the object array result
    static function fetchInAnyObjectArray($statement, $class){
        $objectArray=array();
        while($row = $statement->fetchObject($class)){
            $objectArray[]=$row;
        }
        return $objectArray;
    }
    //Output: Array of object in designed class

    //Documentation: Convert an object to array of his proporties values
    //Input: Object
    private static function convertObjectToArrayOfValues($object){
        $arrayObj = (array) $object;
        $arrayObjValues = array_values($arrayObj);
        return $arrayObjValues;
    }
    //Output: Array of an object values

    //Documentation: This function will serve to improve the haveSingleQuotes array, removing his keys and just outputting his boolean values. If theres no keys and haveSingleQuotes have keys then this function will just return his booleans ordenated
    //Input: Array of keys("key2", "key3"), Array of booleans("key1" => TRUE1, "key2" => FALSE2, "key3" => TRUE3).
    private static function mapHaveSingleQuotes(array $keys, array $haveSingleQuotesWithKeys){
        $haveSingleQuotesMapped = array();
        if($keys != null){
            for($index=0; $index<count($keys); $index++){
                $haveSingleQuotesMapped[$index] = $haveSingleQuotesWithKeys[$keys[$index]];
            }
        }
        else{
            $haveSingleQuotesMapped = $haveSingleQuotesWithKeys;
        }
        return $haveSingleQuotesMapped; 
    }
    //Output: Array of booleans(FALSE2, TRUE3)

    //Documentation: This function will serve to put single quotes in values of almost all sql of the repository. This is an necessity because varchar values need single quotes
    //Input: Simple array(value1, value2, value3...), Array of booleans(TRUE, FALSE, TRUE...)
    private static function addSingleQuotesWithBooleans(array $array, array $haveSingleQuotes){
        for($index=0; $index<count($array); $index++){
            if($haveSingleQuotes[$index])
                $array[$index] = "'" . $array[$index] . "'";
        }
        return $array;
    }
    //Output: Simple array with single quotes('value1', value2, 'value3')

    //Documentation: Put all columns, separators(almost all time will be logic operators) and values together, in an string to perform the sql queries. If separator is null then we assume the separators will be commas, commonly used in sqls
    //Input: Array of columns("key1", "key2", "key3"), Array of separators("and", "and"), Array of values(value1, value2, value3)
    private static function concatenateColumnValue(array $columns, array $values, array $separator=null){
        $concatenatedColumnValue = $columns[0] . " = " . $values[0];
        if($separator == null){
            for($index = 1; $index<count($columns); $index++){
                $concatenatedColumnValue .= ', ' .  $columns[$index] . " = " . $values[$index];
            }
        }
        else{
            for($index = 1; $index<count($columns); $index++){
                $concatenatedColumnValue .= ' ' . $separator[$index] . ' ' .  $columns[$index] . " = " . $values[$index];
            }
        }
        return $concatenatedColumnValue;
    }
    //Output: Concatenated string(key1 = value1 and key2 = value2 and key3 = value3)
    
}

//TESTS:
/*mapHaveSingleQuotes
$keys  = array("key2", "key1");
$haveSingleQuotesWithKeys   = array(
                                    "key1" => "value1",
                                    "key2" => "value2",
                                    "key3" => "value3"
);
echo var_dump(Repository::mapHaveSingleQuotes($keys, $haveSingleQuotesWithKeys));
*/
/*addSingleQuotesWithBooleans
$array              = array(0, "varchar value", 3);
$haveSingleQuotes   = array(FALSE, TRUE, FALSE);
echo implode(',', Repository::addSingleQuotesWithBooleans($array, $haveSingleQuotes));
*/
/*getDynamicSelect
$columns = array('*');
$tables = array('user');
//$whereClause = "nm_user = 'Subaru Natsuki'";
$relationalColumns = array('nm_user');
$logicOperators = array();
$relationalValues = array("'Subaru Natsuki'");

$whereClause = Repository::getDynamicWhereClause($relationalColumns, $logicOperators, $relationalValues);

echo Repository::getDynamicSelect($columns, $tables, $whereClause);
*/
/*getDynamicInsert
$columns = array();
$table = 'user';
$array = array(
    "pk_id_user"    => 0,
    "nm_user"       => 'sus',
    "cd_password"   => 'suspass',
    "ds_email"      => 'suspass',
    "dt_born"       => '2012-01-01',
    "nm_img"        => 'dsa',
    "cd_cep"        => 'dasd',
    "ds_country"    => 'dsa',
    "ds_state"      => 'dasd',
    "ds_city"       => 'dsa',
    "ds_address"    => 'dasd',
    "nr_address"    => 32,
    "dt_creation"   => '2012-01-01',
    "dt_update"     => '2012-01-01'
);
$values = new User($array);
$haveSingleQuotes = array(
    FALSE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    FALSE,
    TRUE,
    TRUE
);
echo Repository2::getDynamicInsert($columns, $table, $values, $haveSingleQuotes);
*/
?>