<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    require_once '../../controller/marketcontroller.php';
    require_once '../../controller/usercontroller.php';
    require_once '../../controller/genericcontroller.php';

    session_start();
    /*echo $_SESSION['pk_id_user'];
    echo "<br>";
    echo $_SESSION['pk_id_market'];*/

    if(isset($_SESSION['pk_id_user']) && isset($_SESSION['pk_id_market'])){
        $columns = "*";
        $tables = "employer";
        $whereClause = "pk_id_user = " .  $_SESSION['pk_id_user'] . " and " . "pk_id_market = " . $_SESSION['pk_id_market'];

        $additionalEmployerData = GenericController::select($columns, $tables, $whereClause);

        if(!empty($additionalEmployerData)){
            //insane logics
        }
    }
?>
<!--
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Lobby</title>
</head>
<body>
    <a href="employers.php">Employers</a>
    <a href="products.php">Products</a>
    <a href="categories.php">Categories</a>
</body>
</html>
-->