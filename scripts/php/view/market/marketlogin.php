<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Login</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/marketlogin.css">
</head>

<body>
    <div class="login-box">
        <div class="login-content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="email">Email: </label>
                <input type="text" name="email" id="email" onchange="getEmployerMarkets()">
                <br>

                <label for="password">Password: </label>
                <input type="password" name="password" id="password" onchange="getEmployerMarkets()"><br>

                <label for="market">Market: </label>
                <input list="markets" name="market" id="market" disabled>
                <datalist id="markets">
                </datalist>
                <br>

                <input type="submit" name="submit" value="Login">
            </form>
        </div>
        <div class="register-content">
            <p>Don't have an e-commerce? Make right <a href="marketregister.php">there!</a></p>
            <!--Coloca um botão ou hyper link no there-->
        </div>
    </div>

    <script src="../../../javascript/main.js"></script>
    <script src="../../../javascript/marketlogin.js"></script>
</body>

</html>