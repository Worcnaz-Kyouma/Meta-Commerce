<?php

function manageImgFromForm($nm_product){
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
    $image_name="img" .$nm_product . substr($image_file["name"], strrpos($image_file["name"], '.'), strlen($image_file["name"]) - 1);

    // Move the file his correct place
    move_uploaded_file(
        $image_file["tmp_name"],
        __DIR__ . "/../../../../resources/productsimg/" . $image_name
    );

    return $image_name;
}
//Teremos que trazer um select generico, pois precisamos trazer o nm_category junto ja do objeto produto
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="../../../../styles/style.css">
</head>
<body>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
        <div id="image-container"></div>
        <label for="image">Image: </label>
        <input type="file" name="image" id="image" accept="image/*" 
        <?php if(isset($product)) echo "disabled";?>><br>

        <label for="nm_category">Category: </label>
        <input type="text" name="nm_category" id="nm_category" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->nm_category;
        }
        ?>><br>

        <label for="nm_product">Name: </label>
        <input type="text" name="nm_product" id="nm_product" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->nm_product;
        }
        ?>><br>

        <label for="ds_product">Description: </label>
        <input type="text" name="ds_product" id="ds_product" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->ds_product;
        }
        ?>><br>

        <label for="vl_price">Price: </label>
        <input type="number" name="vl_price" id="vl_price" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->vl_price;
        }
        ?>><br>

        <label for="ds_mark">Mark: </label>
        <input type="text" name="ds_mark" id="ds_mark" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->ds_mark;
        }
        ?>><br>

        <label for="dt_fabrication">Fabrication date: </label>
        <input type="date" name="dt_fabrication" id="dt_fabrication" <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->dt_fabrication;
        }
        ?>><br>

        <label for="ie_selled">Selled: </label>
        <input type="text" name="ie_selled" id="ie_selled" 
        <?php
        if(isset($product)){
            echo "value = " . $selectedProduct->ie_selled;
        }
        ?>><br>

        <?php
        if(!isset($product)){
            echo "<input type=\"submit\" name=\"submit\" value=\"Submit\"><br>";
        }
        else{
            echo "<input type=\"submit\" name=\"submit\" value=\"Update\"><br>";
            echo "<input type=\"submit\" name=\"submit\" value=\"Dismiss\"><br>";
        }
        ?>
    </form>
</body>
</html>