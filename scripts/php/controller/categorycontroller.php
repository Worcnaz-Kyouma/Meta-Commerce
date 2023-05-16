<?php
    require_once "C:\\xampp\htdocs\Projects\Meta-Commerce\scripts\php\model\categorymodel.php";
    class CategoryController{
        static function select($whereClause){
            return Category::select($whereClause);
        }

        static function persist(Category $product){
            return Category::persist($product);
        }
    }
?>