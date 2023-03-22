<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//CONSTANTS
define("USERS_IMG_LOCAL", "/../../../../resources/usersimg/");

require_once '../../controller/usercontroller.php';

if (isset($_POST['submit'])) {
    if(isValidEmail(htmlentities($_POST['ds_email']))){
        $imgName = manageImgFromForm($_POST['ds_email']);

        $_POST['pk_id_user'] = 0;

        $_POST['nm_img'] = $imgName;

        $_POST['dt_creation'] = date('Y-m-d');
        $_POST['dt_update'] = date('Y-m-d');

        unset($_POST['cd_password_repeat']);
        unset($_POST['submit']);

        $user = new User($_POST);
        
        UserController::persist($user);

        header('Location: clientlogin.php');
        die();
    }
    else{
        echo "<p id=\"error\">Invalid email or already in use!</p>";
    }

}

function findUserByEmail($email){
    $whereClause = "ds_email = " . "'" . $email . "'";

    return UserController::select($whereClause);
}
function isValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL) && empty(findUserByEmail($email));
}
function manageImgFromForm($email){
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
    $image_name="img" .$email . substr($image_file["name"], strrpos($image_file["name"], '.'), strlen($image_file["name"]) - 1);

    // Move the file his correct place
    move_uploaded_file(
        $image_file["tmp_name"],
        __DIR__ . USERS_IMG_LOCAL . $image_name
    );

    return $image_name;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div id="image-container"></div>
        <!--pk_id_user we fill in database with auto_increment-->
        <label for="image">Image: </label>
        <input type="file" name="image" id="image" accept="image/*"><br>

        <label for="nm_user">Name: </label>
        <input type="text" name="nm_user" id="nm_user"><br>

        <label for="cd_password">Password: </label>
        <input type="password" name="cd_password" id="cd_password"><br>

        <label for="cd_password_repeat">Repeat password: </label>
        <input type="password" name="cd_password_repeat" id="cd_password_repeat"><br>

        <label for="ds_email">Email: </label>
        <input type="text" name="ds_email" id="ds_email"><br>

        <label for="dt_born">Birth date: </label>
        <input type="date" name="dt_born" id="dt_born"><br>

        <!--nm_img we fill in the back-end-->

        <label for="cd_cep">Cep: </label>
        <input type="text" name="cd_cep" id="cd_cep"><br>

        <label for="ds_country">Country: </label>
        <input type="text" name="ds_country" id="ds_country"><br>

        <label for="ds_state">State: </label>
        <input type="text" name="ds_state" id="ds_state"><br>

        <label for="ds_city">City: </label>
        <input type="text" name="ds_city" id="ds_city"><br>

        <label for="ds_address">Address: </label>
        <input type="text" name="ds_address" id="ds_address"><br>

        <label for="nr_address">Address complement: </label>
        <input type="number" name="nr_address" id="nr_address"><br>

        <!--dt_creation we fill in the back-end-->
        <!--dt_update we fill in the back-end-->

        <input type="submit" name="submit" value="Submit">
    </form>
    <script src="../../../javascript/main.js"></script>
</body>

</html>