<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE); 

    require_once '../../controller/marketcontroller.php';
    require_once '../../controller/usercontroller.php';
    require_once '../../controller/genericcontroller.php';

    $error=false;

    if(isset($_POST['submit'])){
        $user = getUser($_POST['email'], $_POST['password']);
        $error=validate($user);

        $market = getMarket($_POST['market']);
        $error=validate($market);

        if(!$error){
            $idEmployer = getEmployerId($user->getPkIdUser(), $market->getPkIdMarket());
            $error=validate($idEmployer);
        }

        if($error){
        }
        else{
            session_start();
            $_SESSION['pk_id_user'] = $user->getPkIdUser();
            $_SESSION['pk_id_market'] = $market->getPkIdMarket();
            header('Location: products.php');
            die();
        }
    } 

    function getUser($ds_email, $cd_password){
        $whereClause = "ds_email = " . "'" . $ds_email . "'" . " and " . "cd_password = " . "'" . $cd_password . "'" . " and " . "ie_deleted = 'NO'";
        $user = UserController::select($whereClause)[0];
        return $user;
    }
    function getMarket($nm_market){
        $whereClause = "nm_market = " . "'" . $nm_market . "'" . " and " . "ie_deleted = 'NO'";
        $market = MarketController::select($whereClause)[0];
        return $market;
    }
    function getEmployerId($fk_id_user, $fk_id_market){
        $column = "pk_id_employer";
        $table = "employer";
        $whereClause = "fk_id_user = " . $fk_id_user . " and " . "fk_id_market = " . $fk_id_market . " and " . "ie_deleted = 'NO'";
        $idEmployer = GenericController::select($column, $table, $whereClause)[0]->pk_id_employer;
        return $idEmployer;
    }
    function validate($var){
        return empty($var);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Login</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/button.css">
    <link rel="stylesheet" href="../../../../styles/input.css">
    <link rel="stylesheet" href="../../../../styles/forminput.css">
    <link rel="stylesheet" href="../../../../styles/login.css">
    <link rel="stylesheet" href="../../../../styles/marketlogin.css">

</head>

<body>
    <?php
        if($error){
        echo "<span id='error'>Cannot find an employer with that email/password in this market</span>";
        }
    ?>

    <div class="login-box">
        <div class="login-header">
            <h1>Market Login</h1>
        </div>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="market-selector">
                <div class="img-wrapper">
                    <img class="icon">
                </div>
                
                <div class="market-input-wrapper">
                    <label for="market">Market </label>
                    <input list="markets" name="market" id="market" onchange="manageLogoIcon(this)" disabled>
                    <datalist id="markets">
                    </datalist>
                </div>
            </div>
            <div class="user-selector">
                <div class="input-wrapper">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" onchange="getEmployerMarkets()">
                </div>
            

                <div class="input-wrapper">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" onchange="getEmployerMarkets()"><br>
                </div>
            </div>

            <input class="btn" type="submit" name="submit" value="Login">
        </form>
        
        <div class="login-footer">
            <span>Don't have an e-commerce? Make right <a href="marketregister.php">there!</a></span>
        </div>
    </div>

    <script src="../../../javascript/main.js"></script>
    <script src="../../../javascript/marketlogin.js"></script>
</body>

</html>