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
        $newEmployer = getEmployerByEmail($_POST['ds_email']);
        if(validateNewEmployer($_SESSION['pk_id_market'], $newEmployer->getPkIdUser())){
            $employerData = array();

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
        }
        else{
            echo "<p id=\"error\">Invalid new employer!</p>";
        }
    }//New employer
    else{
        if($_POST['submit'] == 'Update'){
            if(validateChangeEmployer($_SESSION['pk_id_market'], $_GET['id'])){
                $employerData = array();
                $employerData["ds_role"] = "'" . $_POST["ds_role"] . "'";
                $employerData["vl_salary"] = $_POST["vl_salary"];
                $employerData["dt_update"] = "'" . date('Y-m-d') . "'";
                updateEmployer($employerData);
                header('Location: employers.php');
                die();
            }
            else{
                echo "<p id=\"error\">Invalid change to employer " . $_GET["id"] . "</p>";
            }
        }//Update employer
        else{
            if(validateChangeEmployer($_SESSION['pk_id_market'], $_GET['id'])){
                $dismiss = array("ie_deleted" => "'YES'", "dt_update" => "'" . date('Y-m-d') . "'");
                updateEmployer($dismiss);
                header('Location: employers.php');
                die();
            }
            else{
                echo "<p id=\"error\">Invalid change to employer " . $_GET["id"] . "</p>";
            }
        }//Dismiss employer
    }
}//Saving form

function validateChangeEmployer($fk_id_market, $pk_id_employer){
    $valid = true;

    $column = "e.*";
    $table = "employer e";
    $whereClause = "e.fk_id_market = " . $fk_id_market . " and " . "e.pk_id_employer = ". $pk_id_employer . " and " . "e.ie_deleted = 'NO'"; 
    $oldEmployer = GenericController::select($column, $table, $whereClause)[0];
    if(empty($oldEmployer)){
        $valid = false;
    }

    if($oldEmployer->ds_role == "Boss" && ($_POST["ds_role"] == "Employer" || $_POST['submit'] == 'Dismiss')){
        $column = "e.pk_id_employer";
        $table = "employer e";
        $whereClause = "e.fk_id_market = " . $fk_id_market . " and " . "e.ds_role = 'Boss'" . " and " . "e.ie_deleted = 'NO'"; 
        $numOfBoss = GenericController::select($column, $table, $whereClause);
        if(count($numOfBoss)<2)
            $valid = false;
    }
    return $valid;
}
function validateNewEmployer($fk_id_market, $fk_id_user){
    $column = "e.pk_id_employer";
    $table = "employer e";
    $whereClause = "e.fk_id_market = " . $fk_id_market . " and " . "e.fk_id_user = ". $fk_id_user . " and " . "e.ie_deleted = 'NO'"; 
    $numOfEmployers = GenericController::select($column, $table, $whereClause);
    if(!empty($numOfEmployers))
        return false;
    else
        return true;
}
function getEmployerByPK($pk_id_user){
    $whereClause = "pk_id_user = " . $pk_id_user . " and " . "ie_deleted = 'NO'";
    return UserController::select($whereClause)[0];
}
function getEmployerAdditionalData($pk_id_employer, $fk_id_market){
    $columns = "*";
    $table = "employer";
    $whereClause = "pk_id_employer = " . $pk_id_employer . " and " . "fk_id_market = " . $fk_id_market . " and " . "ie_deleted = 'NO'"; 

    return GenericController::select($columns, $table, $whereClause)[0];
}
function getEmployerByEmail($ds_email){
    $whereClause = "ds_email = " . "'" . $ds_email . "'" . " and " . "ie_deleted = 'NO'";
    return UserController::select($whereClause)[0];
}
function updateEmployer($employerData){
    $whereClause = "pk_id_employer = " . $_GET['id'] . " and " . "ie_deleted = 'NO'";
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
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/input.css">
    <link rel="stylesheet" href="../../../../styles/forminput.css">
    <link rel="stylesheet" href="../../../../styles/register.css">
    <link rel="stylesheet" href="../../../../styles/employer.css">
</head>
<body>
    <main>
        <div class="register-header">
            <h1>Employer</h1>
        </div>

        <form id="myform" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <div class="employer-box">
                <div class="img-wrapper">
                    <img class="icon"
                    <?php
                    if(isset($employer))
                        echo "src = " . "../../../../resources/usersimg/" . $employer->getNmImg();
                    ?>>
                </div>

                <div class="employer-input-wrapper">
                    <label for="ds_email">Email </label>
                    <input list="employers" name="ds_email" id="ds_email"
                    onchange="manageLogoIcon(this)"
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
                </div>
            </div>

            <div class="input-wrapper">
                <label for="ds_role">Role: </label>
                <input type="text" name="ds_role" id="ds_role"
                <?php
                if(isset($employer)){
                    echo "value = " . $selectedEmployerAdditionalData->ds_role;
                }
                ?>
                >
            </div>

            <div class="input-wrapper">
                <label for="vl_salary">Salary: </label>
                <input type="number" name="vl_salary" id="vl_salary"
                <?php
                if(isset($employer)){
                    echo "value = " . $selectedEmployerAdditionalData->vl_salary;
                }
                ?>
                >
            </div>
        </form>

        <div class="register-footer">
        <?php
            if(!isset($employer)){
                echo "<input class=\"submit-btn\" id=\"btn-create\" form=\"myform\" type=\"submit\" name=\"submit\" value=\"Submit\">";
            }
            else{
                echo "<input class=\"submit-btn\" id=\"btn-edit\" form=\"myform\" type=\"submit\" name=\"submit\" value=\"Update\">";
                
                echo "<input class=\"submit-btn\" id=\"btn-delete\" form=\"myform\" type=\"submit\" name=\"submit\" value=\"Delete\">";
            }
        ?>
        </div>
    </main>

    <script src="../../../javascript/employer.js"></script>
</body>
</html>