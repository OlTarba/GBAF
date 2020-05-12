<?php 

    $absolute_path  = $_SERVER['DOCUMENT_ROOT'].'/GBAF/';
    $simple_path    = "/GBAF/";

    function str_secur($string){
        return trim(htmlspecialchars($string));
    }

    function debug($var){
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }