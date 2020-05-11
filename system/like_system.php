<?php 
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/functions.php';

    if(!isset($_SESSION['connect'])){
        header('Location: /GBAF/connexion.php');

    }

    $id     = str_secur($_GET['id']);
    $value  = str_secur($_GET['value']);

    if($value < 3 && $value > 0){
        $insertValue = $db->prepare('INSERT INTO vote(id_user, id_acteur, vote) VALUES(?, ?, ?)');
        $insertValue->execute([$_SESSION['id'], $id, $value]);

        header('Location: /GBAF/acteur.php?id='.$id.'#comments');
        exit;
    }