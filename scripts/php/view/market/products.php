<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once '../../model/util.php';

require_once '../../controller/marketcontroller.php';
require_once '../../controller/usercontroller.php';
require_once '../../controller/productcontroller.php';
require_once '../../controller/genericcontroller.php';

session_start();

if(isset($_SESSION['pk_id_user']) && isset($_SESSION['pk_id_market'])){
    $user = getSessionedUser($_SESSION['pk_id_user']);
    standardValidateForMarket($user);

    $market = getSessionedMarket($_SESSION['pk_id_market']);
    standardValidateForMarket($market);

    $additionalEmployerData = getEmployerData($_SESSION['pk_id_user'], $_SESSION['pk_id_market']);
    standardValidateForMarket($additionalEmployerData);

    $marketProducts = getAllProducts($_SESSION['pk_id_market']);
}//Session validation and getAllProducts
else{
    header('Location: marketlogin.php');
    die();
}

function getAllProducts($fk_id_market){
    $columns = array('p.*', 'c.nm_category');

    $tables = array('product p', 'category c');
    
    $whereClause = 'p.fk_id_category = c.pk_id_category' . ' and '. 'p.fk_id_market = ' . $fk_id_market . ' and ' . "p.ie_deleted = 'NO'";

    return GenericController::select($columns, $tables, $whereClause);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/button.css">
    <link rel="stylesheet" href="../../../../styles/table.css">
</head>
<body>
    <header>
        <div class="btn-options">
            <button class="btn-option" onclick="location.href = 'products.php'" disabled>Products</button>
            <?php 
            if($additionalEmployerData->ds_role == "Boss") 
                echo "<button class=\"btn-option\" onclick=\"location.href = 'employers.php'\"> Employers</button>"
            ?>
            <button class="btn-option" onclick="location.href = 'categories.php'">Categories</button>
        </div>
        <button id="logout-btn" class="btn" type="button" onclick="logout()">Log-out</button>
    </header>

    <table>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Category</th>
            <th>Fabric. date</th>
            <th>Selled</th>
            <th>Value</th>
        </tr>
        <?php
        foreach($marketProducts as $product){
            echo "
            <tr onclick='location.href = \"product.php?id=$product->pk_id_product\";'>
                <td>$product->pk_id_product</td>
                <td>$product->nm_product</td>
                <td>$product->nm_category</td>
                <td>$product->dt_fabrication</td>
                <td>$product->ie_selled</td>
                <td>$product->vl_price</td>
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