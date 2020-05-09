<?php 
    session_start();

    require_once 'include/database.php';
    require_once 'include/functions.php';

    if(!isset($_SESSION['connect'])){
        header('Location: connexion.php');

    }

    $id     = str_secur($_GET['id']);
    $value  = str_secur($_GET['value']);

    if($value < 3 && $value > 0){
        $insertValue = $db->prepare('INSERT INTO vote(id_user, id_acteur, vote) VALUES(?, ?, ?)');
        $insertValue->execute([$_SESSION['id'], $id, $value]);

        header('Location: acteur.php?id='.$id);
        exit;
    }