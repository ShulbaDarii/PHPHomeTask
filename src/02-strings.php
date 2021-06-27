<?php
/**
 * The $input variable contains text in snake case (i.e. hello_world or this_is_home_task)
 * Transform it into a camel-cased string and return (i.e. helloWorld or thisIsHomeTask)
 * @see http://xahlee.info/comp/camelCase_vs_snake_case.html
 *
 * @param  string  $input
 * @return string
 */

function snakeCaseToCamelCase(string $input)
{
    $pieces = explode("_", $input);
    $input='';
    for($i=0;$i<count($pieces);$i++){
        if($i!=0)
            $input.=ucfirst($pieces[$i]);
        else
            $input.=$pieces[$i];
    }
    return $input;

}

/**
 * The $input variable contains multibyte text like 'ФЫВА олдж'
 * Mirror each word individually and return transformed text (i.e. 'АВЫФ ждло')
 * !!! do not change words order
 *
 * @param  string  $input
 * @return string
 */
function mirrorMultibyteString(string $input)
{
    $pieces = explode(" ", $input);
    $input='';
    for($i=0;$i<count($pieces);$i++){
        //$input.=strrev($pieces[$i]) . " ";
            $input.=join('', array_reverse(preg_split('//u', $pieces[$i], -1, PREG_SPLIT_NO_EMPTY))) . " ";
    }
    $input = substr($input,0,-1);
    return $input;
}

/**
 * My friend wants a new band name for her band.
 * She likes bands that use the formula: 'The' + a noun with the first letter capitalized.
 * However, when a noun STARTS and ENDS with the same letter,
 * she likes to repeat the noun twice and connect them together with the first and last letter,
 * combined into one word like so (WITHOUT a 'The' in front):
 * dolphin -> The Dolphin
 * alaska -> Alaskalaska
 * europe -> Europeurope
 * Implement this logic.
 *
 * @param  string  $noun
 * @return string
 */
function getBrandName(string $noun)
{
    $ret="";
    if($noun[0]==$noun[strlen($noun)-1]){
        $ret.=ucfirst($noun) . substr($noun,1);
    }else{
        $ret.="The ".ucfirst($noun);
    }
    return $ret;
}