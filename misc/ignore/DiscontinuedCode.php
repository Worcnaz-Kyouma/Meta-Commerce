<?php
/*userregister
{
    echo serialize($user);

    echo '<br><br>';

    echo json_decode(json_encode($user), true);

    echo '<br><br>';

    $array = array(
        'first' => 1,
        'second' => 2);

    echo implode(",",$array);

    echo '<br><br>';

    echo implode("','", (array) $user);
}

*/

/*marketlogin
<!--<span id="blank-email-advice">Fill Email input first to see your markets</span>-->

function setNullIfEmailEmpty(){
    const marketFieldElement = document.getElementById("market");
    const emailFieldElement = document.getElementById("email");

    if(emailFieldElement.value == null || emailFieldElement.value == ''){
        marketFieldElement.value='';
    }
}

function showEmptyEmailAdvice(){
    const marketFieldElement = document.getElementById("market");
    const emailFieldElement = document.getElementById("email");

    if(emailFieldElement.value == null || emailFieldElement.value == ''){
        marketFieldElement.setCustomValidity('Fill email input first!');
        marketFieldElement.reportValidity();
    }
    else{
        marketFieldElement.setCustomValidity('');
        marketFieldElement.reportValidity();
    }

}

function manageMarketDisable(){
    var marketFieldElement = document.getElementById("market");
    var blankEmailSpanAdvice = document.getElementById("blank-email-advice");
    var emailFieldElement = document.getElementById("email");

    if(emailFieldElement.value == null || emailFieldElement.value == ''){
        marketFieldElement.disabled=true;
        blankEmailSpanAdvice.removeAttribute("hidden");
    }
    else{
        marketFieldElement.disabled=false;
        blankEmailSpanAdvice.setAttribute("hidden", "hidden");
    }

}

const validityState = emailInput.validity;
if (validityState.valueMissing) {
    emailInput.setCustomValidity("You gotta fill this out, yo!");
} else {
    emailInput.setCustomValidity("");
}

*/

/*marketcontroller

static function findMarketsByParameters($relationColumns, $logicOperators, $values){
            return Market::findMarketsByParameters($relationColumns, $logicOperators, $values);
}

*/

/*usercontroller

static function findUsersByParameters($relationColumns, $logicOperators, $values){
            return User::findUsersByParameters($relationColumns, $logicOperators, $values);
}

*/

/*marketmodel

private static function getMarketDynamicPreparetedSelect($relationColumns, $logicOperators){
    return parent::getGeneralDynamicPreparetedSelect('market', $relationColumns, $logicOperators);
}

static function findMarketsByParameters($relationColumns, $logicOperators, $values){
    $select = self::getMarketDynamicPreparetedSelect($relationColumns, $logicOperators);

    $statement = parent::executePreparetedQuery($select, $values);

    $usersArray = self::fetchInMarketObject($statement);

    return $usersArray;
}

*/

/*usermodel

{$count=0;
        $select=" " . $columns[$count] . " = ?";
        foreach($columns as $column){
            $count++;
            $select= $select . " and " . $column . " = ?";
        }//paramos aqui! Arrumar
}


static function findEmployerByParameters($columns, $values){
    //parent::$db;
}

private static function getUserDynamicPreparetedSelect($relationColumns, $logicOperators){
        return parent::getGeneralDynamicPreparetedSelect('user', $relationColumns, $logicOperators);
}

static function findUsersByParameters($relationColumns, $logicOperators, $values){
        $select = self::getUserDynamicPreparetedSelect($relationColumns, $logicOperators);

        $statement = parent::executePreparetedQuery($select, $values);

        $usersArray = self::fetchInUserObject($statement);

        return $usersArray;
}

*/

/*repository

static function getGeneralDynamicPreparetedSelect($table, $relationColumns, $logicOperators){
            $tables = array($table);
            return self::getGeneralDynamicPreparetedSelectImproved(null, $tables, $relationColumns, $logicOperators);
}

static function getGeneralDynamicPreparetedSelectImproved($showColumns, $tables, $relationColumns, $logicOperators){
            $selectClause = 'SELECT';

            $showColumnsString=' *';
            if($showColumns!=null){
                $showColumnsString = ' ' . self::getDynamicShowColumns($showColumns);
            }

            $fromClause = ' ' . self::getDynamicFromClause($tables);

            $whereClause = '';
            if($relationColumns!=null){
                $whereClause = ' ' . self::getDynamicWhereClause($relationColumns, $logicOperators);
            }

            return $selectClause . $showColumnsString . $fromClause . $whereClause;
}

static function getDynamicWhereClause(array $relationColumns, array $logicOperators){
            $whereClause = 'WHERE ' . $relationColumns[0] . " = ?";
            for($index=1; $index<count($relationColumns); $index++){
                $whereClause .= " " . $logicOperators[$index-1] . " " . $relationColumns[$index] . " = ?";
            }
            return $whereClause;
}

*/

?>