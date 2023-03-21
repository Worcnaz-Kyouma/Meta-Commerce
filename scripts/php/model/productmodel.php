<?php
require_once "repository.php";
define("TABLE_NAME", "product");
define("PROPERTIES_NECESSITY_OF_SINGLE_QUOTES", array(
    FALSE,  //pk_id_product
    FALSE,  //fk_id_market
    FALSE,  //fk_id_category
    TRUE,   //nm_product
    TRUE,   //ds_product
    FALSE,  //vl_price
    TRUE,   //ds_mark
    TRUE,   //dt_fabrication
    TRUE,   //ie_selled
    TRUE,   //dt_creation
    TRUE,   //dt_update
    TRUE    //ie_deleted
));
class Market extends Repository
{
    private $pk_id_product;
    private $fk_id_market;
    private $fk_id_category;
    private $nm_product;
    private $ds_product;
    private $vl_price;
    private $ds_mark;
    private $dt_fabrication;
    private $ie_selled;
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

    //Getters and Setters

    /*DAO Methods*/

    //Select
    private static function getDynamicSelect($where){
        return parent::getTemplateDynamicSelect("*", TABLE_NAME, $where);
    }
    public static function select($where){
        $select = self::getDynamicSelect($where);

        $statement = parent::executeQuery($select);

        $productsArray = self::fetchInModelObjectArray($statement);

        return $productsArray;
    }   

    //Insert
    private static function getDynamicInsert($values){
        return parent::getTemplateDynamicInsert(TABLE_NAME, $values, PROPERTIES_NECESSITY_OF_SINGLE_QUOTES);
    }
    private static function persist($values){
        $insert = self::getDynamicInsert($values);

        parent::executeQuery($insert);
    }

    //Update
    private static function getDynamicUpdate($columns, $values, $whereClause){
        return parent::getTemplateDynamicUpdate(TABLE_NAME, $columns, $values, $whereClause);
    }
    private static function update($columns, $values, $whereClause=null){
        $update = self::getDynamicUpdate($columns, $values, $whereClause);

        parent::executeQuery($update);
    }

    //Misc
    private static function fetchInModelObjectArray($statement){
        return parent::fetchInAnyObjectArray($statement, TABLE_NAME);
    }

}

?>
