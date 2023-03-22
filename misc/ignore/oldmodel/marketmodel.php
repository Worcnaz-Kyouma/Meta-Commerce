<?php
require_once "repository.php";
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
    public function getNmUser(){
        return $this->nm_market;
    }
    public function getEmail(){
        return $this->ds_email;
    }

    /*DAO Methods*/

    //Select
    private static function getMarketDynamicSelect($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values){
        if ($tables == null) {
            $tables = array('market');
        }
        return parent::getGeneralDynamicSelect($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values);
    }
    static function findMarketsByParameters($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values){
        $select = self::getMarketDynamicSelect($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values);

        $statement = parent::executeQuery($select);

        $marketsArray = self::fetchInMarketObjectArray($statement);

        return $marketsArray;
    }
    static function getEmployerMarkets($id_user){
        $showColumns                    =   array('m.*');
        $tables                         =   array('market m', 'employer_relation er');
        $relationColumns                =   array('m.pk_id_market', 'er.fk_id_user');
        $haveSingleQuoteBooleanArray    =   array(FALSE, FALSE);
        $logicOperators                 =   array('and');
        $values                         =   array('er.fk_id_market', $id_user);

        $select = self::getMarketDynamicSelect($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values);

        $statement = parent::executeQuery($select);

        $marketsArray = self::fetchInMarketObjectArray($statement);

        return $marketsArray;
    }

    //Insert
    private static function getMarketDynamicInsert($values){
        return parent::getDynamicGeneralInsert('market', $values);
    }
    static function insertIntoMarketsWithMarketObject(Market $market){
        $values = parent::castObjectIntoArrayOfValuesFormattedForQuery($market);

        $insert = self::getMarketDynamicInsert($values);

        return parent::executeQuery($insert);
    }

    //Misc
    private static function fetchInMarketObjectArray($statement){
        return parent::fetchInObjectTemplateArray($statement, 'market');
    }
}

?>
