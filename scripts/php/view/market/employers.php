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
    else{
        $marketEmployers = getAllEmployers($_SESSION['pk_id_market']);
    }
}

function getAllEmployers($fk_id_market){
    $columns = array("e.*", "u.nm_user");
    $tables = array("employer e", "user u");
    $whereClause = "u.pk_id_user = e.fk_id_user" . " and " . "e.fk_id_market = " . $fk_id_market . " and " . "e.ie_deleted = 'NO'" . " and " . "e.ie_deleted = 'NO'";

    return GenericController::select($columns, $tables, $whereClause);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employers</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/employers.css">
</head>
<body>
    <a href="marketlobby.php">Back</a>
    <table>
        <tr>
          <th>ID</th>
          <th>Employer</th>
          <th>Role</th>
          <th>Salary</th>
        </tr>
        <?php
        foreach($marketEmployers as $employer){
            echo "
            <tr onclick='location.href = \"employer.php?id=$employer->pk_id_employer\";'>
                <td>$employer->pk_id_employer</td>
                <td>$employer->nm_user</td>
                <td>$employer->ds_role</td>
                <td>$employer->vl_salary</td>
            </tr>
            ";
        }
        ?>
    </table>
    <div onclick="location.href = 'employer.php'" class="end-of-table" style="text-align: center; border: 1px solid #000000; border-top: 0px;">+</div>

    <script src="../../../javascript/employers.js"></script>
</body>
</html>