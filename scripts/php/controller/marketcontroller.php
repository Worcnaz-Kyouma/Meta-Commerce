<?php
    require_once "../model/marketmodel.php";

    class MarketController{
        static function select($whereClause){
            return Market::select($whereClause);
        }
        
        static function persist(Market $market){
            return Market::persist($market);
        }
    }
?>