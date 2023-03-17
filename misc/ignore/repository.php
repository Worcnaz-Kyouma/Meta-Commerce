<?php
    try {
        $db = new PDO("mysql:host=localhost;port=3307;dbname=meta-commerce", "root", "pradopgworcnaz0");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
    function select($stringStatement, $values){
        global $db;
        $statement = $db->prepare($stringStatement);
        $statement->execute($values);
    }
?>