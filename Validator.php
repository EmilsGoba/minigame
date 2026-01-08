<?php 
class Validator{
    public static function string($value, $min=1, $max = INF){
        $value = trim($value);

        return is_string($value)
        && strlen($value) >= $min
        && strlen($value) <= $max;
     }
}