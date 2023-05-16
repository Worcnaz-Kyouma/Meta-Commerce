<?php
    require_once "C:\\xampp\htdocs\Projects\Meta-Commerce\scripts\php\model\usermodel.php";
    class UserController{
        static function select($whereClause){
            return User::select($whereClause);
        }

        static function persist(User $user){
            return User::persist($user);
        }
    }
?>