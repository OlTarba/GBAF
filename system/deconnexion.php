<?php 
    require_once '../include/functions.php';

    // Suppression de la session
    session_start();
    session_unset();
    session_destroy();

    header('Location: ../connexion.php');
?>