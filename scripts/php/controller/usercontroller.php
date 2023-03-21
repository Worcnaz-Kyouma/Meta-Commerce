<?php
    require_once "../model/usermodel.php";
    class UserController{
        static function select($whereClause){
            return User::select($whereClause);
        }

        static function persist(User $user){
            return User::persist($user);
        }
    }
?>