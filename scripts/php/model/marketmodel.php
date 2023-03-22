<?php
require_once "repository.php";
class Market extends Repository implements \JsonSerializable
{
    const TABLE_NAME = "market";
    const PROPERTIES_NECESSITY_OF_SINGLE_QUOTES = array(
        FALSE,  //pk_id_market
        TRUE,   //nm_market
        TRUE,   //ds_email
        TRUE,   //nm_img
        TRUE,   //dt_market_creation
        TRUE,   //ds_market
        TRUE,   //dt_creation
        TRUE,   //dt_update
        TRUE    //ie_deleted
    );

    private $pk_id_market;
    private $nm_market;
    private $ds_email;
    private $nm_img;
    private $dt_market_creation;
    private $ds_market;
    private $ie_status;
    private $dt_creation;
    private $dt_update;
    private $ie_deleted;

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
        return parent::getTemplateDynamicSelect("*", self::TABLE_NAME, $where);
    }
    public static function select($where){
        $select = self::getDynamicSelect($where);

        $statement = parent::executeQuery($select);

        $marketsArray = self::fetchInModelObjectArray($statement);

        return $marketsArray;
    }   

    //Insert
    private static function getDynamicInsert($values){
        return parent::getTemplateDynamicInsert(self::TABLE_NAME, $values, self::PROPERTIES_NECESSITY_OF_SINGLE_QUOTES);
    }
    public static function persist($values){
        $insert = self::getDynamicInsert($values);

        parent::executeQuery($insert);
    }

    //Update
    private static function getDynamicUpdate($columns, $values, $whereClause){
        return parent::getTemplateDynamicUpdate(self::TABLE_NAME, $columns, $values, $whereClause);
    }
    private static function update($columns, $values, $whereClause=null){
        $update = self::getDynamicUpdate($columns, $values, $whereClause);

        parent::executeQuery($update);
    }

    //Misc
    private static function fetchInModelObjectArray($statement){
        return parent::fetchInAnyObjectArray($statement, self::TABLE_NAME);
    }

}

?>
