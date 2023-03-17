<?php
    require_once '../controller/usercontroller.php';
    require_once '../controller/marketcontroller.php';

    $arr = array(/*$_POST['email'], */'sugoma'); //etc

    /*$arr = array("nome_array"=>array(
        'message', 'sugoma'
    )); //etc*/

    $relationColumns = array('ds_email');
    $logicOperators = array();
    $values = array('suspas');

    $employers = UserController::findUsersByParametersImproved(null, null, $relationColumns, $logicOperators, $values);

    if(empty($employers)){
        echo 'sus';
    }
    else{
        echo var_dump($employer);

        //Retorna algo como = ["e-commerce", "sugomacommerce"]  tipo um json mesmo
        $markets = MarketController::getEmployerMarkets ($employer->getPkIdUser());

        //echo json_encode($arr);
        //echo json_encode($markets);
        //header('HTTP/1.1 201 Created');
        //echo json_encode($markets);
    }
?>