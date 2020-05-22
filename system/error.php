<?php 
    session_start();

    require_once '../include/functions.php';

    checkConnect();
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once '../include/head.php'; ?> 
        <title>GBAF | Erreur 404</title>
    </head>
    <body>
        <?php include_once '../include/header.php'; ?>

        <div class="card form">
            <h3>ERREUR 404</h3>
            <p>La page n'a pas pu être charger ou n'existe pas.</p>
        </div>

        <div class="fixed-footer">
            <?php include_once '../include/footer.php'; ?>
        </div>
    </body>
</html>