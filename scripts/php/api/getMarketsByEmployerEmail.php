<?php
    require_once "../controller/genericcontroller.php";
    require_once "../controller/usercontroller.php";
    require_once "../model/marketmodel.php";
    require_once "../model/usermodel.php";

    function convertToJSONArray($markets){
        $marketsJSONFormat = array();

        for($index=0; $index<count($markets); $index++){
            //aqui ta dando o erro
            $marketsJSONFormat[$index] = get_object_vars($markets[$index]);
        }
        
        return $marketsJSONFormat;
    }

    $ds_email = $_POST['email'];
    $cd_password = $_POST['password'];

    $whereClause = "ds_email = " . "'" . $ds_email . "'" . " and " . "cd_password = " . "'" . $cd_password . "'";

    $employers = UserController::select($whereClause);

    //$employer->getPkIdUser()
    if (!empty($employers)) {
        $employer = $employers[0];
        
        $whereClause = "m.pk_id_market = e.fk_id_market" . " and " . "e.fk_id_user = " . $employer->getPkIdUser(); 

        $markets = GenericController::select("m.*", array("market m", "employer e"), $whereClause);

        //Transforma para um array na formatacao JSON correta
        $marketsJSONFormat = convertToJSONArray($markets);

        header('HTTP/1.1 200 Ok');
        //echo json_encode(array("sus", "sus"));
        echo json_encode($marketsJSONFormat);

        return $markets;
    } else {
        header('HTTP/1.1 200 Ok');
        //echo json_encode(array("sus"));
        echo json_encode(null);
        return null;
    }
?>