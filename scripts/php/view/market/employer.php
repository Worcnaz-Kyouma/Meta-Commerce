<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

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

    if($additionalEmployerData->ds_role != "Boss"){
        header('Location: marketlobby.php');
        die();
    }
}//Validating session

if(isset($_GET['id'])){
    $selectedEmployerAdditionalData = getEmployerAdditionalData($_GET['id'], $_SESSION['pk_id_market']);

    $employer = getEmployerByPK($selectedEmployerAdditionalData->fk_id_user);
    
    if(empty($selectedEmployerAdditionalData) || empty($employer)){
        header('Location: marketlobby.php');
        die();
    }
}//Get selected employer

if (isset($_POST['submit'])) {
    if($_POST['submit'] == 'Submit'){
        $employerData = array();

        $newEmployer = getEmployerByEmail($_POST['ds_email']);
        if(empty($newEmployer)){
            header('Location: employers.php');
            die();
        }

        $employerData['pk_id_employer'] = 0;

        $employerData['fk_id_user'] = $newEmployer->getPkIdUser();

        $employerData['fk_id_market'] = $market->getPkIdMarket();

        $employerData['ds_role'] = "'" . $_POST['ds_role'] . "'";

        $employerData['dt_hiring'] = "'" . date('Y-m-d') . "'";

        $employerData['vl_salary'] = $_POST['vl_salary'];

        $employerData['dt_creation'] = "'" . date('Y-m-d') . "'";
        $employerData['dt_update'] = "'" . date('Y-m-d') . "'";
        $employerData['ie_deleted'] =  "'NO'";

        GenericController::persist('employer', $employerData);

        header('Location: employers.php');
        die();
    }//New employer
    else{
        if($_POST['submit'] == 'Update'){
            $employerData = array();
            $employerData["ds_role"] = "'" . $_POST["ds_role"] . "'";
            $employerData["vl_salary"] = $_POST["vl_salary"];
            updateEmployer($employerData);
            header('Location: employers.php');
            die();
        }//Update employer
        else{
            $dismiss = array("ie_deleted" => "'YES'");
            updateEmployer($dismiss);
            header('Location: employers.php');
            die();
        }//Dismiss employer
    }
}//Saving form

function getEmployerByPK($pk_id_user){
    $whereClause = "pk_id_user = " . $pk_id_user;
    return UserController::select($whereClause)[0];
}
function getEmployerAdditionalData($pk_id_employer, $fk_id_market){
    $columns = "*";
    $table = "employer";
    $whereClause = "pk_id_employer = " . $pk_id_employer . " and " . "fk_id_market = " . $fk_id_market; 

    return GenericController::select($columns, $table, $whereClause)[0];
}
function getEmployerByEmail($ds_email){
    $whereClause = "ds_email = " . "'" . $ds_email . "'";
    return UserController::select($whereClause)[0];
}
function updateEmployer($employerData){
    $whereClause = "pk_id_employer = " . $_GET['id'];
    GenericController::update("employer", array_keys($employerData), array_values($employerData), $whereClause);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <div>
            <p>
                <?php
                if(isset($employer))
                    echo $employer->getNmImg();
                else
                    echo 'user_img';
                ?>
            </p>
        </div>

        <label for="ds_email">Name: </label>
        <input list="employers" name="ds_email" id="ds_email" 
        <?php
        if(isset($employer)){
            echo "value = " . $employer->getDsEmail() . " ";
            echo "readonly ";
            echo "disabled";
        }
        ?>
        >
        <datalist id="employers">
        </datalist>
        <br>

        <label for="ds_role">Role: </label>
        <input type="text" name="ds_role" id="ds_role"
        <?php
        if(isset($employer)){
            echo "value = " . $selectedEmployerAdditionalData->ds_role;
        }
        ?>
        ><br>

        <label for="vl_salary">Salary: </label>
        <input type="number" name="vl_salary" id="vl_salary"
        <?php
        if(isset($employer)){
            echo "value = " . $selectedEmployerAdditionalData->vl_salary;
        }
        ?>
        ><br>

        <?php
        if(!isset($employer)){
            echo "<input type=\"submit\" name=\"submit\" value=\"Submit\"><br>";
        }
        else{
            echo "<input type=\"submit\" name=\"submit\" value=\"Update\"><br>";
            echo "<input type=\"submit\" name=\"submit\" value=\"Dismiss\"><br>";
        }
        ?>
    </form>

    <script src="../../../javascript/employer.js"></script>
</body>
</html>