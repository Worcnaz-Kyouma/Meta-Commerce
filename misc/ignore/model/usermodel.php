<?php
require_once "repository.php";
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
    private static function getUserDynamicSelect($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values){
        if($tables==null){
            $tables = array('user');
        }
        return parent::getGeneralDynamicSelect($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values);
    }
    static function findUsersByParameters($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values){
        $select = self::getUserDynamicSelect($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values);
    
        $statement = parent::executeQuery($select);
    
        $usersArray = self::fetchInUserObjectArray($statement);
    
        return $usersArray;
    }

    //Insert
    private static function getUserDynamicInsert($values){
        return parent::getDynamicGeneralInsert('user', $values);
    }
    static function insertIntoUsersWithUserObject(User $user){
        $values = parent::castObjectIntoArrayOfValuesFormattedForQuery($user);
        
        $insert = self::getUserDynamicInsert($values);

        return parent::executeQuery($insert);
    }

    //Misc
    private static function fetchInUserObjectArray($statement){
        return parent::fetchInObjectTemplateArray($statement, 'user');
    }
}

?>


