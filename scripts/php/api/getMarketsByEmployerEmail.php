<?php
    require_once "../controller/marketcontroller.php";
    require_once "../controller/usercontroller.php";

    function convertToJSONArray($markets){
        $marketsJSONFormat = array();

        for($index=0; $index<count($markets); $index++){
            $marketsJSONFormat[$index] = $markets[$index]->jsonSerialize();
        }
        
        return $marketsJSONFormat;
    }

    $ds_email = $_POST['email'];
    $cd_password = $_POST['password'];

    $relationColumns = array('ds_email', 'cd_password');
    $haveSingleQuoteBooleanArray = array(TRUE, TRUE);
    $logicOperators = array('and');
    $values = array($ds_email, $cd_password);

    $employers = UserController::findUsersByParameters(null, null, $relationColumns, $haveSingleQuoteBooleanArray, $logicOperators, $values);

    if (!empty($employers)) {
        $employer = $employers[0];

        $markets = MarketController::getEmployerMarkets($employer->getPkIdUser());

        //Transforma para um array na formatacao JSON correta
        $marketsJSONFormat = convertToJSONArray($markets);

        header('HTTP/1.1 200 Ok');
        echo json_encode($marketsJSONFormat);

        return $markets;
    } else {
        header('HTTP/1.1 200 Ok');
        echo json_encode(null);
        return null;
    }
?>