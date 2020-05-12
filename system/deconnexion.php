<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/functions.php';

    session_start();
    session_unset();
    session_destroy();

    header('Location: '.$simple_path.'connexion.php');
?>