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

}//Validating session

if(isset($_GET['id'])){
    $selectedCategory = getSelectedCategory($_GET['id'], $_SESSION['pk_id_market']);
    
    if(empty($selectedCategory)){
        header('Location: marketlobby.php');
        die();
    }
}//Get selected category

if (isset($_POST['submit'])) {
    if($_POST['submit'] == 'Submit'){
        $newCategoryArray = array();

        $newCategoryArray['pk_id_category'] = 0;
        $newCategoryArray['fk_id_market'] = $_SESSION['pk_id_market'];

        $newCategoryArray['nm_category'] = $_POST['nm_category'];
        $newCategoryArray['ds_category'] = $_POST['ds_category'];
        $newCategoryArray['cd_color'] = $_POST['cd_color'];
        
        $newCategoryArray['dt_creation'] = date('Y-m-d');
        $newCategoryArray['dt_update'] = date('Y-m-d');
        $newCategoryArray['ie_deleted'] = "NO";

        $newCategory = new Category($newCategoryArray);

        CategoryController::persist($newCategory);

        header('Location: categories.php');
        die();
    }//New category
    else{
        if($_POST['submit'] == 'Update'){
            if(validateChangeCategory($_SESSION['pk_id_market'], $_GET['id'])){
                $updatedCategoryArray = array();

                $updatedCategoryArray['nm_category'] = "'" . $_POST['nm_category'] . "'";
                $updatedCategoryArray['ds_category'] = "'" . $_POST['ds_category'] . "'";
                $updatedCategoryArray['cd_color'] = "'" . $_POST['cd_color'] . "'";
        
                $updatedProduct['dt_update'] = "'" . date('Y-m-d') . "'";

                updateCategory($updatedCategoryArray);
                header('Location: categories.php');
                die();
            }
            else{
                echo "<p id=\"error\">Invalid change to category " . $_GET["id"] . "</p>";
            }
        }//Update employer
        else{
            if(validateChangeCategory($_SESSION['pk_id_market'], $_GET['id'])){
                $delete = array("ie_deleted" => "'YES'", "dt_update" => "'" . date('Y-m-d') . "'");
                updateCategory($delete);
                
                header('Location: categories.php');
                die();
            }
            else{
                echo "<p id=\"error\">Invalid change to category " . $_GET["id"] . "</p>";
            }
        }//Dismiss employer
    }
}//Saving form

function getSelectedCategory($pk_id_category, $fk_id_market){
    $whereClause = 'pk_id_category = ' . $pk_id_category . ' and ' . 'fk_id_market = ' . $fk_id_market . ' and ' . "ie_deleted = 'NO'";

    return CategoryController::select($whereClause)[0];
}
function validateChangeCategory($fk_id_market, $pk_id_category){
    $valid = true;

    $whereClause = "fk_id_market = " . $fk_id_market . " and " . "pk_id_category = ". $pk_id_category . " and " . "ie_deleted = 'NO'"; 

    $oldProduct = CategoryController::select($whereClause)[0];
    if(empty($oldProduct)){
        $valid = false;
    }

    return $valid;
}
function updateCategory($updatedCategory){
    $whereClause = "pk_id_category = " . $_GET['id'] . " and " . "ie_deleted = 'NO'";
    //change the generic update to category update
    GenericController::update("category", array_keys($updatedCategory), array_values($updatedCategory), $whereClause);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/input.css">
    <link rel="stylesheet" href="../../../../styles/forminput.css">
    <link rel="stylesheet" href="../../../../styles/register.css">
    <link rel="stylesheet" href="../../../../styles/category.css">
</head>
<body>
    <main>
        <div class="register-header">
            <h1>Category</h1>
        </div>

        <form id="myform" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
            <div class="input-wrapper">
                <label for="nm_category">Category</label>
                <input type="text" name="nm_category" id="nm_category" 
                <?php
                if(isset($selectedCategory)){
                    echo "value = " . $selectedCategory->getNmCategory();
                }
                ?>>
            </div>

            <div class="input-wrapper description-wrapper">
                <label for="ds_category">Description: </label>
                <textarea name="ds_category" id="ds_category"><?php
                    if(isset($selectedCategory)){            
                        echo htmlspecialchars($selectedCategory->getDsCategory());
                    }
                ?></textarea>
            </div>

            <div class="input-wrapper color-wrapper">
                <label for="cd_color">Color: </label>
                <input type="color" name="cd_color" id="cd_color" 
                <?php
                if(isset($selectedCategory)){
                    echo "value = " . $selectedCategory->getCdColor();
                }
                ?>>
            </div>
        </form>

        <div class="register-footer">
        <?php
            if(!isset($selectedCategory)){
                echo "<input class=\"submit-btn\" id=\"btn-create\" form=\"myform\" type=\"submit\" name=\"submit\" value=\"Submit\">";
            }
            else{
                echo "<input class=\"submit-btn\" id=\"btn-edit\" form=\"myform\" type=\"submit\" name=\"submit\" value=\"Update\">";
                
                echo "<input class=\"submit-btn\" id=\"btn-delete\" form=\"myform\" type=\"submit\" name=\"submit\" value=\"Delete\">";
            }
            ?>
        </div>
    </main>
</body>
</html>