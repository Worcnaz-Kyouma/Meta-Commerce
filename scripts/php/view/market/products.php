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

function getAllProducts($fk_id_market){
    $whereClause = 'fk_id_market = ' . $fk_id_market . ' and ' . "ie_deleted = 'NO'";

    return ProductController::select($whereClause);
}
//Teremos que trazer um select generico, pois precisamos trazer o nm_category junto ja do objeto produto
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/products.css">
</head>
<body>
    <a href="marketlobby.php">Back</a>
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
                <td>$product->fk_id_category</td>
                <td>$product->dt_fab</td>
                <td>$product->ie_selled</td>
                <td>$product->vl_price</td>
            </tr>
            ";
        }
        ?>
    </table>
    <div onclick="location.href = 'product.php';" id="end-of-table">+</div>

    <script src="../../../javascript/products.js"></script>
</body>
</html>