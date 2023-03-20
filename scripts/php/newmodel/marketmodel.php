<?php
require_once "repository.php";
define("TABLE_NAME", "market");
define("PROPERTIES_NECESSITY_OF_SINGLE_QUOTES", array(
    FALSE,  //pk_id_market
    TRUE,   //nm_market
    TRUE,   //ds_email
    TRUE,   //nm_img
    TRUE,   //dt_market_creation
    TRUE,   //ds_market
    TRUE,   //dt_creation
    TRUE,   //dt_update
));
class Market extends Repository implements \JsonSerializable
{
    private $pk_id_market;
    private $nm_market;
    private $ds_email;
    private $nm_img;
    private $dt_market_creation;
    private $ds_market;
    private $ie_status;
    private $dt_creation;
    private $dt_update;

    //Contructors
    function __construct(array $array = null){
        if ($array != null) {
            foreach ($array as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    //JsonSerializable
    public function jsonSerialize(){
        $vars = get_object_vars($this);

        return $vars;
    }

    //Getters and Setters
    public function getPkIdMarket(){
        return $this->pk_id_market;
    }
    public function getNmMarket(){
        return $this->nm_market;
    }
    public function getEmail(){
        return $this->ds_email;
    }

    /*DAO Methods*/

    //Select
    private static function getDynamicSelect($where){
        return parent::getTemplateDynamicSelect("*", TABLE_NAME, $where);
    }
    public static function getMarketsByParameters($where){
        $select = self::getDynamicSelect($where);

        $statement = parent::executeQuery($select);

        $marketsArray = self::fetchInMarketObjectArray($statement);

        return $marketsArray;
    }   

    //Insert
    private static function getDynamicInsert($values){
        return parent::getTemplateDynamicInsert(TABLE_NAME, $values, PROPERTIES_NECESSITY_OF_SINGLE_QUOTES);
    }
    private static function insertIntoMarketsWithValues($values){
        $insert = self::getDynamicInsert($values);

        parent::executeQuery($insert);
    }

    //Update
    private static function getDynamicUpdate($columns, $values, $whereClause){
        return parent::getTemplateDynamicUpdate(TABLE_NAME, $columns, $values, $whereClause);
    }
    private static function updateMarketsWithParameters($columns, $values, $whereClause=null){
        $update = self::getDynamicUpdate($columns, $values, $whereClause);

        parent::executeQuery($update);
    }

    //Misc
    private static function fetchInMarketObjectArray($statement){
        return parent::fetchInAnyObjectArray($statement, TABLE_NAME);
    }

}

?>
