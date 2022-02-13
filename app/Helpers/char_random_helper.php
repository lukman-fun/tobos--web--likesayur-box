<?php
if(!function_exists('randomNumChar')){
    function randomNumChar($length = 5){
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
        $result = ""; 

        for ($i = 0; $i < $length; $i++) { 
            $index = rand(0, strlen($characters)-1); 
            $result .= $characters[$index]; 

        } 
        return $result;
    }
}

if(!function_exists('randomChar')){
    function randomChar($length = 5){
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
        $result = ""; 

        for ($i = 0; $i < $length; $i++) { 
            $index = rand(0, strlen($characters)-1); 
            $result .= $characters[$index]; 

        } 
        return $result;
    }
}

if(!function_exists('randomNum')){
    function randomNum($length = 5){
        $characters = "0123456789"; 
        $result = ""; 

        for ($i = 0; $i < $length; $i++) { 
            $index = rand(0, strlen($characters)-1); 
            $result .= $characters[$index]; 
        } 
        return $result;
    }
}
?>