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
        $_POST['ie_deleted'] = 'NO';

        unset($_POST['submit']);

        $user = new User($_POST);
        
        UserController::persist($user);

        header('Location: userlogin.php');
        die();
    }
    else{
        echo "<p id=\"error\">Invalid email or already in use!</p>";
    }

}

function findUserByEmail($email){
    $whereClause = "ds_email = " . "'" . $email . "'" . " and " . "ie_deleted = 'NO'";

    return UserController::select($whereClause);
}
function isValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL) && empty(findUserByEmail($email));
}
function manageImgFromForm($email){
    // Here we have an weakness for DoS attack, because i dont limit the size of archive sended from form

    // Exit if no file uploaded
    if ($_FILES['image']['name'][0] == "") {
        die('No file uploaded.');
    }

    // Get reference to uploaded image
    $image_file = $_FILES['image'];

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
    <link rel="stylesheet" href="../../../../styles/button.css">
    <link rel="stylesheet" href="../../../../styles/input.css">
    <link rel="stylesheet" href="../../../../styles/forminput.css">
    <link rel="stylesheet" href="../../../../styles/defaultimgpicker.css">
    <link rel="stylesheet" href="../../../../styles/userregister.css">
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="register-header">
            <p>User Register</p>
        </div>
        
        <div class="img-wrapper">
            <label class="image-choicer" for="image">
                <img src="" alt="">
                <p id="new-img">+</p>
            </label>
            <input type="file" name="image" id="image" accept="image/*" onchange="previewFile(this);">
        </div>

        <div class="user-inputs">
            <div class="input-wrapper">
                <label for="nm_user">Name: </label>
                <input type="text" name="nm_user" id="nm_user">
            </div>

            <div class="input-wrapper">
                <label for="cd_password">Password: </label>
                <input type="password" name="cd_password" id="cd_password">
            </div>

            <div class="input-wrapper">
                <label for="ds_email">Email: </label>
                <input type="text" name="ds_email" id="ds_email">
            </div>

            <div class="input-wrapper">
                <label for="dt_born">Birth date: </label>
                <input type="date" name="dt_born" id="dt_born">
            </div>
        </div>

        <div class="additional-location-inputs">
            <div class="input-wrapper">
                <label for="cd_cep">Cep: </label>
                <input type="text" name="cd_cep" id="cd_cep">
            </div>

            <div class="input-wrapper">
                <label for="ds_country">Country: </label>
                <input type="text" name="ds_country" id="ds_country">
            </div class="input-wrapper">

            <div class="input-wrapper">
                <label for="ds_state">State: </label>
                <input type="text" name="ds_state" id="ds_state">
            </div class="input-wrapper">

            <div class="input-wrapper">
                <label for="ds_city">City: </label>
                <input type="text" name="ds_city" id="ds_city">
            </div class="input-wrapper">

            <div class="input-wrapper ds_address-wrapper">
                <label for="ds_address">Address: </label>
                <input type="text" name="ds_address" id="ds_address">
            </div class="input-wrapper">

            <div class="input-wrapper">
                <label for="nr_address"></label>
                <input type="number" name="nr_address" id="nr_address">
            </div>
        </div>

        <div class="submit-wrapper">
            <input class="btn" type="submit" name="submit" value="Submit">
        </div>
    </form>
    <script src="../../../javascript/userregister.js"></script>
</body>

</html>