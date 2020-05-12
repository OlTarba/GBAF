<?php 
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/functions.php';

    require_once $absolute_path.'include/database.php';

    if(!isset($_SESSION['connect'])){
        header('Location: '.$simple_path.'connexion.php');

    }

    $id     = str_secur($_GET['id']);
    $value  = str_secur($_GET['value']);

    $reqUserVote = $db->prepare('SELECT COUNT(*) AS countVote FROM vote WHERE id_acteur = ? AND id_user = ?');
    $reqUserVote->execute([$id, $_SESSION['id']]);
    $voted = $reqUserVote->fetch();

    if($voted['countVote'] != 0){
        header('Location: '.$simple_path.'acteur.php?id='.$id.'#comments');
        exit;
    }
    
    $reqActeur = $db->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
    $reqActeur->execute([$id]);
    $acteur = $reqActeur->fetch();

    if($acteur === false){
        header('Location: '.$simple_path.'system/error.php');
    }

    if($value < 3 && $value > 0){
        $insertValue = $db->prepare('INSERT INTO vote(id_user, id_acteur, vote) VALUES(?, ?, ?)');
        $insertValue->execute([$_SESSION['id'], $id, $value]);

        header('Location: '.$simple_path.'acteur.php?id='.$id.'#comments');
        exit;
    }