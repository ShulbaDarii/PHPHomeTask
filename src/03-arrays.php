<?php
/**
 * The $input variable contains an array of digits
 * Return an array which will contain the same digits but repetitive by its value
 * without changing the order.
 * Example: [1,3,2] => [1,3,3,3,2,2]
 *
 * @param  array  $input
 * @return array
 */
function repeatArrayValues(array $input)
{
    $arr=[];
    for($i=0;$i<count($input);$i++){
        for($j=0;$j<$input[$i];$j++){
            array_push($arr,$input[$i]);
        }
    }
    return $arr;
}

/**
 * The $input variable contains an array of digits
 * Return the lowest unique value or 0 if there is no unique values or array is empty.
 * Example: [1, 2, 3, 2, 1, 5, 6] => 3
 *
 * @param  array  $input
 * @return int
 */
function getUniqueValue(array $input)
{
    $arr=[];
    for($i=0;$i<count($input);$i++){
        $flag=true;
        for($j=0;$j<count($input);$j++){
            if($input[$i]==$input[$j]&&$i!=$j)
            {
                $flag=false;
            }
        }
        if($flag){
            array_push($arr,$input[$i]);
        }
    }
    if(count($arr)==0)
        return 0;
    else 
        return min($arr);

}

/**
 * The $input variable contains an array of arrays
 * Each sub array has keys: name (contains strings), tags (contains array of strings)
 * Return the list of names grouped by tags
 * !!! The 'names' in returned array must be sorted ascending.
 *
 * Example:
 * [
 *  ['name' => 'potato', 'tags' => ['vegetable', 'yellow']],
 *  ['name' => 'apple', 'tags' => ['fruit', 'green']],
 *  ['name' => 'orange', 'tags' => ['fruit', 'yellow']],
 * ]
 *
 * Should be transformed into:
 * [
 *  'fruit' => ['apple', 'orange'],
 *  'green' => ['apple'],
 *  'vegetable' => ['potato'],
 *  'yellow' => ['orange', 'potato'],
 * ]
 *
 * @param  array  $input
 * @return array
 */
function groupByTag(array $input)
{
    $arr=[];
    for($i=0;$i<count($input);$i++){
        for($j=0;$j<count($input[$i]['tags']);$j++){
            
            if(array_key_exists($input[$i]['tags'][$j],$arr)){         
                echo  "ADS";     
                array_push($arr[$input[$i]['tags'][$j]],$input[$i]['name']);
            }
            else{        
                $arr+=[$input[$i]['tags'][$j] => [$input[$i]['name']]];      
                // array_push($arr, [$input[$i]['tags'][$j] => [$input[$i]['name']]] );
            }
        }
    }
    ksort($arr);
    foreach($arr as $key=>$value){
        sort($arr[$key]);
    }
    return $arr;
}