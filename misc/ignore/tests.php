<?php
    $db = new PDO("mysql:host=localhost;port=3307;dbname=meta_commerce;", "root", "pradopgworcnaz0");

    $table='user';

    $rawSelect="select * from " . $table . " where ";

    $columns = array('ds_email', 'cd_password');
    $logicOperators = array('and');

    $whereString = $columns[0] . " = ?";
    for($index=1; $index<count($columns); $index++){
        $whereString = $whereString . " " . $logicOperators[$index-1] . " " . $columns[$index] . " = ?";
    }

    $select = $rawSelect . $whereString;

    echo $select . '<br>';

    
    $statement = $db->prepare($select);
    $statement->execute(array('suspass', 'suspass'));

    $row=$statement->fetch();

    if(empty($row)){echo 'sus';}
    

    /*
    $statement = $db->prepare("select * from user where ds_email = 'suspass' and cd_password = 'suspass' ");
    $statement->execute();

    $row=$statement->fetch();

    echo empty($row);
    */

?>