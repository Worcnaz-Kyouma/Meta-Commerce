<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE); 

    require_once '../../controller/usercontroller.php';

    if(isset($_POST['submit'])){
        $email      = $_POST['email'];
        $password   = $_POST['password'];

        $whereClause = "ds_email = " . "'" . $email . "'" . " and " . "cd_password = " . "'" .$password . "'" . " and " . "ie_deleted = 'NO'";

        $user = UserController::select($whereClause)[0];

        if(empty($user)){
            echo "<p id='error'>Cannot find an user with that email/password</p>";
        }
        else{
            session_start();
            $_SESSION['email'] = $user->getNmUser();
            header('Location: userlobby.php');
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
    <link rel="stylesheet" href="../../../../styles/button.css">
    <link rel="stylesheet" href="../../../../styles/input.css">
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/userlogin.css">
    <link rel="stylesheet" href="../../../../styles/forminput.css">

</head>

<body>
    <div class="login-box">
        <div class="login-header">
            <h1>User Login</h1>
        </div>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div class="input-wrapper">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email">
                </div>

                <div class="input-wrapper">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <input class="btn" type="submit" name="submit" value="Login">
            </form>
        <div class="login-footer">
            <span>Don't have an user account? Make right <a href="userregister.php">there!</a></span>
        </div>
    </div>
</body>

</html>