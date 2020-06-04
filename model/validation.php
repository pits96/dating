<?php
class validation
{

    function validName($text)
    {
        return ctype_alpha($text);
    }

    function validAge($num)
    {
        return is_numeric($num);
    }

    function validPhone($num)
    {
        return is_numeric($num) && strlen($num);
    }

    function validEmail($text)
    {
        $valid = strpos($text, '@');
        $valid2 = strpos($text, '.com');
        return $valid && $valid2;
    }

    function validInterest($selectedInterest, $array)
    {

//    print_r($selectedInterest);
//    print_r($array);

//    We need to check each condiment in our array
        if(!empty($selectedInterest)) {
            foreach ($selectedInterest as $selected) {
                if (!in_array($selected, $array)) {
                    return false;
                }
            }
        }
        return true;
    }
}