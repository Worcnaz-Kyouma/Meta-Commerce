<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once '../../model/util.php';

require_once '../../controller/marketcontroller.php';
require_once '../../controller/usercontroller.php';
require_once '../../controller/productcontroller.php';
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

}//Validating session

if(isset($_GET['id'])){
    $selectedProduct = getSelectedProduct($_GET['id'], $_SESSION['pk_id_market']);
    
    if(empty($selectedProduct)){
        header('Location: marketlobby.php');
        die();
    }
}//Get selected product

if (isset($_POST['submit'])) {
    if($_POST['submit'] == 'Submit'){
        $newProductArray = array();

        $newProductArray['pk_id_product'] = getNumOfProductsOfMarket($_SESSION['pk_id_market'])+1;
        $newProductArray['fk_id_market'] = $_SESSION['pk_id_market'];
        $newProductArray['fk_id_category'] = 1;
        //getCategoryPkByName($_POST['nm_category']) ainda nao temos nenhuma categoria criada! Ai dara erro aqui nos testes;

        $newPrnewProductArrayoduct['nm_product'] = $_POST['nm_product'];
        $newProductArray['nm_img'] = manageImgFromForm($newProductArray['pk_id_product']);
        $newProductArray['ds_product'] = $_POST['ds_product'];
        $newProductArray['vl_price'] = $_POST['vl_price'];
        $newProductArray['ds_mark'] = $_POST['ds_mark'];
        $newProductArray['dt_fabrication'] = $_POST['dt_fabrication'];
        $newProductArray['ie_selled'] = $_POST['ie_selled'];
        
        $newProductArray['dt_creation'] = date('Y-m-d');
        $newProductArray['dt_update'] = date('Y-m-d');
        $newProductArray['ie_deleted'] = "NO";

        $newProduct = new Product($newProductArray);

        ProductController::persist($newProduct);

        header('Location: products.php');
        die();
    }//New product
    else{
        if($_POST['submit'] == 'Update'){
            if(validateChangeProduct($_SESSION['pk_id_market'], $_GET['id'])){
                $updatedProductArray = array();

                $updatedProduct['fk_id_category'] = getCategoryPkByName($_POST['nm_category']);

                $updatedProduct['nm_product'] = "'" . $_POST['nm_product'] . "'";
                $updatedProduct['ds_product'] = "'" . $_POST['ds_product'] . "'";
                $updatedProduct['vl_price'] = "'" . $_POST['vl_price'] . "'";
                $updatedProduct['ds_mark'] = "'" . $_POST['ds_mark'] . "'";
                $updatedProduct['dt_fabrication'] = "'" . $_POST['dt_fabrication'] . "'";
                $updatedProduct['ie_selled'] = "'" . $_POST['ie_selled'] . "'";
        
                $updatedProduct['dt_update'] = "'" . date('Y-m-d') . "'";

                updateProduct($updatedProduct);
                header('Location: products.php');
                die();
            }
            else{
                echo "<p id=\"error\">Invalid change to product " . $_GET["id"] . "</p>";
            }
        }//Update employer
        else{
            if(validateChangeProduct($_SESSION['pk_id_market'], $_GET['id'])){
                $delete = array("ie_deleted" => "'YES'", "dt_update" => "'" . date('Y-m-d') . "'");
                updateProduct($delete);
                header('Location: products.php');
                die();
            }
            else{
                echo "<p id=\"error\">Invalid change to product " . $_GET["id"] . "</p>";
            }
        }//Delete employer
    }
}//Saving form

function getNumOfProductsOfMarket($fk_id_market){
    $column = 'count(*) numOfProducts';
    $table = 'product';
    $whereClause = 'fk_id_market = ' . $fk_id_market . ' and ' . 'ie_deleted = "NO"';
    return GenericController::select($column, $table, $whereClause)[0]->numOfProducts;
}
function getCategoryPkByName($nm_category){
    $whereClause = 'nm_category = ' . "'" . $nm_category . "'";
    return CategoryController::select($whereClause)[0]->pk_id_category;
}
function manageImgFromForm($pk_id_product){
    // Here we have an weakness for DoS attack, because i dont limit the size of archive sended from form

    // Get reference to uploaded image
    $image_file = $_FILES['image'];

    // Exit if no file uploaded
    if (!isset($image_file)) {
        die('No file uploaded.');
    }

    // Exit if is not a valid image file
    $image_type = exif_imagetype($image_file["tmp_name"]);
    if (!$image_type) {
        die('Uploaded file is not an image.');
    }

    // Generate img name
    $image_name="img" .$pk_id_product . substr($image_file["name"], strrpos($image_file["name"], '.'), strlen($image_file["name"]) - 1);

    // Move the file his correct place
    move_uploaded_file(
        $image_file["tmp_name"],
        __DIR__ . "/../../../../resources/productsimg/" . $image_name
    );

    return $image_name;
}
function getSelectedProduct($pk_id_product, $fk_id_market){
    $columns = array('p.*', 'c.nm_category');

    $tables = array('product p', 'category c');
    
    $whereClause = 'p.fk_id_category = c.pk_id_category' . ' and ' . 'p.pk_id_product = ' . $pk_id_product . ' and ' . 'p.fk_id_market = ' . $fk_id_market . ' and ' . "p.ie_deleted = 'NO'";

    return GenericController::select($columns, $tables, $whereClause)[0];
}
function validateChangeProduct($fk_id_market, $pk_id_product){
    $valid = true;

    $column = "*";
    $table = "product";
    $whereClause = "fk_id_market = " . $fk_id_market . " and " . "pk_id_product = ". $pk_id_product . " and " . "ie_deleted = 'NO'"; 

    $oldProduct = GenericController::select($column, $table, $whereClause)[0];
    if(empty($oldProduct)){
        $valid = false;
    }

    return $valid;
}
function updateProduct($updatedProduct){
    $whereClause = "pk_id_product = " . $_GET['id'] . " and " . "ie_deleted = 'NO'";
    //change the generic update to product update
    GenericController::update("product", array_keys($updatedProduct), array_values($updatedProduct), $whereClause);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
</head>
<body>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
        <div id="image-container"></div>
        <label for="image">Image: </label>
        <input type="file" name="image" id="image" accept="image/*" 
        <?php if(isset($product)) echo "disabled";?>><br>

        <label for="nm_category">Category: </label>
        <input type="text" name="nm_category" id="nm_category" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->nm_category;
        }
        ?>><br>

        <label for="nm_product">Name: </label>
        <input type="text" name="nm_product" id="nm_product" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->nm_product;
        }
        ?>><br>

        <label for="ds_product">Description: </label>
        <input type="text" name="ds_product" id="ds_product" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->ds_product;
        }
        ?>><br>

        <label for="vl_price">Price: </label>
        <input type="number" name="vl_price" id="vl_price" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->vl_price;
        }
        ?>><br>

        <label for="ds_mark">Mark: </label>
        <input type="text" name="ds_mark" id="ds_mark" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->ds_mark;
        }
        ?>><br>

        <label for="dt_fabrication">Fabrication date: </label>
        <input type="date" name="dt_fabrication" id="dt_fabrication" <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->dt_fabrication;
        }
        ?>><br>

        <label for="ie_selled">Selled: </label>
        <input type="text" name="ie_selled" id="ie_selled" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->ie_selled;
        }
        ?>><br>

        <?php
        if(!isset($product)){
            echo "<input type=\"submit\" name=\"submit\" value=\"Submit\"><br>";
        }
        else{
            echo "<input type=\"submit\" name=\"submit\" value=\"Update\"><br>";
            echo "<input type=\"submit\" name=\"submit\" value=\"Delete\"><br>";
        }
        ?>
    </form>
</body>
</html>