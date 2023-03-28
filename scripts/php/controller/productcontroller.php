<?php
    require_once "C:\\xampp\htdocs\shortcode\Projects\Meta-Commerce\scripts\php\model\productmodel.php";
    class ProductController{
        static function select($whereClause){
            return Product::select($whereClause);
        }

        static function persist(Product $product){
            return Product::persist($product);
        }
    }
?>