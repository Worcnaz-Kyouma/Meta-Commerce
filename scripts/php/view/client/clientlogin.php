<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE); 

    require_once '../../model/usermodel.php';
    require_once '../../controller/usercontroller.php';

    if(isset($_POST['submit'])){
        $email      = $_POST['email'];
        $password   = $_POST['password'];

        $relationColumns = array('ds_email', 'cd_password');
        $haveSingleQuoteBooleanArray = array(TRUE, TRUE);
        $logicOperators = array('and');
        $values = array($email, $password);

        $selectedClient = UserController::findUsersByParameters(null, null, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values)[0];

        if(empty($selectedClient)){
            echo "<p id='error'>Cannot find an user with that email/password</p>";
        }
        else{
            session_start();
            $_SESSION['password'] = $selectedClient->getNmUser();
            header('Location: clientlobby.php');
            die();
        }
    } 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/clientlogin.css">

</head>

<body>
    <div class="login-box">
        <div class="login-content">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <label for="email">Email</label>
                <input type="text" name="email" id="email">
                <br>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <input type="submit" name="submit" value="Login">
            </form>
        </div>
        <div class="register-content">
            <p>Don't have an user account? Make right <a href="userregister.php">there!</a></p>
            <!--Coloca um botão ou hyper link no there-->
        </div>
    </div>
    <script src="../../../javascript/main.js"></script>
</body>

</html>