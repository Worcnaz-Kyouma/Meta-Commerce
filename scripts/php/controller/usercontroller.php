<?php
    require_once "../../model/usermodel.php";
    class UserController{
        static function findUsersByParameters($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values){
            return User::findUsersByParameters($showColumns, $tables, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values);
        }

        static function insertIntoUsersWithUserObject(User $user){
            return User::insertIntoUsersWithUserObject($user);
        }
    }
?>