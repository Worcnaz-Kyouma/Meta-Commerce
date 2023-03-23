<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    require_once '../../model/util.php';

    require_once '../../controller/marketcontroller.php';
    require_once '../../controller/usercontroller.php';
    require_once '../../controller/genericcontroller.php';

    session_start();

    if(isset($_SESSION['pk_id_user']) && isset($_SESSION['pk_id_market'])){
        $user = getSessionedUser($_SESSION['pk_id_user']);
        standardValidateForMarket($user);

        $market = getSessionedMarket($_SESSION['pk_id_market']);
        standardValidateForMarket($market);

        $additionalEmployerData = getEmployerData($_SESSION['pk_id_user'], $_SESSION['pk_id_market']);
        standardValidateForMarket($additionalEmployerData);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Lobby</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
</head>
<body>
    <?php 
    if($additionalEmployerData->ds_role == "Boss") 
        echo "<a href=\"employers.php\">Employers</a>"
    ?>
    <a href="products.php">Products</a>
    <a href="categories.php">Categories</a>
</body>
</html>
