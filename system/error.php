<?php 
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/functions.php';

    if(!isset($_SESSION['connect'])){
        header('Location: '.$simple_path.'connexion.php');
        exit;
    }
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once $absolute_path.'include/head.php'; ?> 
        <title>GBAF | Erreur 404</title>
    </head>
    <body>
        <?php include_once $absolute_path.'include/header.php'; ?>

        <div class="card form">
            <h3>ERREUR 404</h3>
            <p>La page n'a pas pu être charger ou n'existe pas.</p>
        </div>

        <div class="fixed-footer">
            <?php include_once $absolute_path.'include/footer.php'; ?>
        </div>
    </body>
</html>