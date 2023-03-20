<?php
require_once "repository.php";
define("TABLE_NAME", "user");
define("PROPERTIES_NECESSITY_OF_SINGLE_QUOTES", array(
    FALSE,  //pk_id_user
    TRUE,   //nm_user
    TRUE,   //cd_password
    TRUE,   //ds_email
    TRUE,   //dt_born
    TRUE,   //nm_img
    TRUE,   //cd_cep
    TRUE,   //ds_country
    TRUE,   //ds_state
    TRUE,   //ds_city
    TRUE,   //ds_address
    FALSE,  //nr_address
    TRUE,   //dt_creation
    TRUE    //dt_update
));
class User extends Repository{
    private $pk_id_user;
    private $nm_user;
    private $cd_password;
    private $ds_email;
    private $dt_born;
    private $nm_img;
    private $cd_cep;
    private $ds_country;
    private $ds_state;
    private $ds_city;
    private $ds_address;
    private $nr_address;
    private $dt_creation;
    private $dt_update;
    
    //Contructors
    function __construct(array $array = null) {
        if($array != null){
            foreach($array as $key => $value){
            $this->{$key} = $value;
            }
        }
    }

    //Getters and Setters
    public function getPkIdUser(){
        return $this->pk_id_user;
    }
    public function getNmUser(){
        return $this->nm_user;
    } 
    public function getPassword(){
        return $this->cd_password;
    } 


    /*DAO Methods*/

    //Select
    private static function getDynamicSelect($where){
        return parent::getTemplateDynamicSelect("*", TABLE_NAME, $where);
    }
    public static function getUsersByParameters($where){
        $select = self::getDynamicSelect($where);

        $statement = parent::executeQuery($select);

        $usersArray = self::fetchInUserObjectArray($statement);

        return $usersArray;
    }   

    //Insert
    private static function getDynamicInsert($values){
        return parent::getTemplateDynamicInsert(TABLE_NAME, $values, PROPERTIES_NECESSITY_OF_SINGLE_QUOTES);
    }
    private static function insertIntoUsersWithValues($values){
        $insert = self::getDynamicInsert($values);

        parent::executeQuery($insert);
    }

    //Update
    private static function getDynamicUpdate($columns, $values, $whereClause){
        return parent::getTemplateDynamicUpdate(TABLE_NAME, $columns, $values, $whereClause);
    }
    private static function updateUsersWithParameters($columns, $values, $whereClause=null){
        $update = self::getDynamicUpdate($columns, $values, $whereClause);

        parent::executeQuery($update);
    }

    //Misc
    private static function fetchInUserObjectArray($statement){
        return parent::fetchInAnyObjectArray($statement, TABLE_NAME);
    }
}

?>