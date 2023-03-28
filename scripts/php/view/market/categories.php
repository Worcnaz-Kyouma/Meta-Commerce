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
    <link rel="stylesheet" href="../../../../styles/categories.css">
</head>
<body>
    <a href="marketlobby.php">Back</a>
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
            <tr onclick='location.href = \"category.php?id=$category->pk_id_category\";'>
                <td>$category->pk_id_category</td>
                <td>$category->nm_category</td>
                <td>$category->ds_category</td>
                <td>$category->cd_color</td>
                <td>$category->dt_creation</td>
            </tr>
            ";
        }
        ?>
    </table>
    <div onclick="location.href = 'category.php';" id="end-of-table">+</div>
</body>
</html>