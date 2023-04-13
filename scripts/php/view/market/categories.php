<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once '../../model/util.php';

require_once '../../controller/marketcontroller.php';
require_once '../../controller/usercontroller.php';
require_once '../../controller/categorycontroller.php';
require_once '../../controller/genericcontroller.php';

session_start();

if(isset($_SESSION['pk_id_user']) && isset($_SESSION['pk_id_market'])){
    $user = getSessionedUser($_SESSION['pk_id_user']);
    standardValidateForMarket($user);

    $market = getSessionedMarket($_SESSION['pk_id_market']);
    standardValidateForMarket($market);

    $additionalEmployerData = getEmployerData($_SESSION['pk_id_user'], $_SESSION['pk_id_market']);
    standardValidateForMarket($additionalEmployerData);

    $marketCategories = getAllCategories($_SESSION['pk_id_market']);
}//Session validation and getAllCategories
else{
    header('Location: marketlogin.php');
    die();
}

function getAllCategories($fk_id_market){
    $whereClause = 'fk_id_market = ' . $fk_id_market . ' and ' . "ie_deleted = 'NO'";

    return CategoryController::select($whereClause);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/button.css">
    <link rel="stylesheet" href="../../../../styles/table.css">
</head>
<body>
    <header>
        <div class="btn-options">
            <button class="btn-option" onclick="location.href = 'products.php'" >Products</button>
            <?php 
            if($additionalEmployerData->ds_role == "Boss") 
                echo "<button class=\"btn-option\" onclick=\"location.href = 'employers.php'\"> Employers</button>"
            ?>
            <button class="btn-option" onclick="location.href = 'categories.php'" disabled>Categories</button>
        </div>
        <button id="logout-btn" class="btn" type="button" onclick="logout()">Log-out</button>
    </header>

    <table>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Desc</th>
            <th>Color</th>
            <th>Creation date</th>
        </tr>
        <?php
        foreach($marketCategories as $category){
            echo "
            <tr onclick='location.href = \"category.php?id=" . $category->getPkIdCategory() . "\";'>
                <td>" . $category->getPkIdCategory() . "</td>
                <td>" . $category->getNmCategory() . "</td>
                <td>" . $category->getDsCategory() . "</td>
                <td>" . $category->getCdColor() . "</td>
                <td>" . $category->getDtCreation() . "</td>
            </tr>
            ";
        }
        ?>
        <tr>
            <td onclick="location.href = 'product.php';" colspan="100%">+</td>
        </tr>
    </table>
    
    <script src="../../../javascript/market.js"></script>
</body>
</html>