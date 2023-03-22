<?php
    require_once "C:\\xampp\htdocs\shortcode\Projects\Meta-Commerce\scripts\php\model\marketmodel.php";

    class MarketController{
        static function select($whereClause){
            return Market::select($whereClause);
        }
        
        static function persist(Market $market){
            return Market::persist($market);
        }
    }
?>