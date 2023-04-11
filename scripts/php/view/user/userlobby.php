<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User lobby</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
    <link rel="stylesheet" href="../../../../styles/userlobby.css">
    <style>
        :root{
            --border-width: 15px;
            --border-color: conic-gradient(rgb(120, 37, 37) 20deg, transparent 120deg);
            --border-radius: 5px;
            --fill-border-color: rgb(47, 47, 47);
        }

        .animated-border{
            position: relative;
            overflow: hidden;
            padding: var(--border-width);
        }

        .animated-border::before{
            position: absolute;
            content: "";

            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            width: 10000%;
            height: 10000%;

            background: var(--border-color);

            z-index: -2;
            animation: rotate ;
            animation: border-rotate 1.5s linear infinite;
        }

        .animated-border::after{
            position: absolute;
            content: "";

            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            width: calc(100% - var(--border-width));
            height: calc(100% - var(--border-width));

            background-color: var(--fill-border-color);

            border-radius: var(--border-radius);

            z-index: -1;
        }

        @keyframes border-rotate {
            from{
                transform: translate(-50%, -50%) rotate(0deg);
            }
            to{
                transform: translate(-50%, -50%) rotate(-360deg);
            }
        }
    </style>
</head>
<body>
    <div class="animated-border">
        <h1>Sorry user <?php echo $_SESSION['email'];?>! This part of the project has been canceled</h1>
    </div>
</body>
</html>