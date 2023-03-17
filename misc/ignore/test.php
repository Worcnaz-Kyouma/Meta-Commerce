<?php
    //--Insert
    function getDynamicTemplateSelect($columns, $table, $values, $needSingleQuotes){
        $select = 'INSERT ';

        $select .= getDynamicColumnsForInsert($columns);

        $select .= ' INTO ' . $table;

        $select .= ' VALUES ' . getDynamicValuesForInsert($values, $columns, $needSingleQuotes);

        return $select;
    }
    function getDynamicColumnsForInsert($columns){
        if($columns != null){
            $columns = '(' . implode(',', $columns) . ')';
            return $columns;
        }
        else
            return "";
    }
    function getDynamicValuesForInsert($values, $columns, $needSingleQuotes){
        if(is_object($values))
            $values = convertObjectToArrayOfValues($values);

        if(array_keys($needSingleQuotes) != null)
            $needSingleQuotes = mapNecessityOfSingleQuotes($needSingleQuotes,$columns);

        $values = addSingleQuotes($values, $needSingleQuotes);

        $values = implode(',', $values);

        return '(' . $values . ')';
    }
    //--

    //--Utils
    function mapNecessityOfSingleQuotes(array $needSingleQuotes, array $keys){
        $needSingleQuotesMapped = array();
        if($keys==null)
            $needSingleQuotesMapped = array_values($needSingleQuotes);
        else{
            for($index=0; $index<count($keys); $index++){
                $needSingleQuotesMapped[$index] = $needSingleQuotes[$keys[$index]];
            }
        }
        return $needSingleQuotesMapped;
    }
    function convertObjectToArrayOfValues($obj){
        $objArray = (array) $obj;
        $objArrayValues = array_values($objArray);
        return $objArrayValues;
    }
    function addSingleQuotes($array, $needSingleQuotes){
    for ($index = 0; $index<count($array); $index++){
        if ($needSingleQuotes[$index]){
            $array[$index] = "'" . $array[$index] . "'";
        }
    }
    return $array;
    }
    //--

    $columns = array('email');
    $table = 'user';
    $values = array('suspass');
    $needSingleQuotes = array(
        "email" => TRUE,
        "password" => FALSE,
        "ds_nm"   => TRUE
    );

    echo getDynamicTemplateSelect($columns, $table, $values, $needSingleQuotes);
?>