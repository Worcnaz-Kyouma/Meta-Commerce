<?php
require_once "repository.php";
define("TABLE_NAME", "category");
define("PROPERTIES_NECESSITY_OF_SINGLE_QUOTES", array(
    FALSE,  //pk_id_market
    TRUE,   //nm_market
    TRUE,   //ds_email
    TRUE,   //nm_img
    TRUE,   //dt_market_creation
    TRUE,   //ds_market
    TRUE,   //dt_creation
    TRUE,   //dt_update
    TRUE    //ie_deleted
));
class Category extends Repository
{
    private $pk_id_category;
    private $fk_market;
    private $nm_category;
    private $ds_category;
    private $cd_color;
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

        $categoriesArray = self::fetchInModelObjectArray($statement);

        return $categoriesArray;
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
