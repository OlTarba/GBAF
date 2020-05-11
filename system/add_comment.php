<?php 
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/functions.php';

    if(!isset($_SESSION['connect'])){
        header('Location: /GBAF/connexion.php');
    }

    $id = str_secur($_GET['id']);

    $reqActeur = $db->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
    $reqActeur->execute([$id]);

    $acteur = $reqActeur->fetch();

    if(!empty($_POST['comment'])){
        $comment = str_secur($_POST['comment']);

        $reqInsertComment = $db->prepare('INSERT INTO post(id_user, id_acteur, post) VALUES(?, ?, ?)');
        $reqInsertComment->execute([$_SESSION['id'], $id, $comment]);

        header('Location: /GBAF/acteur.php?id='.$id.'#comments');
        exit;
    }
    
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/head.php'; ?>
        <title>GBAF | Nouveau commentaire</title>
    </head>
    <body>
        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/header.php'; ?>

        <div class="card-form form add-comment">
            <h3><?= $acteur['acteur'] ?></h3>
            <form action="" method='POST'>
                <div>
                    <label for="comment">Commentaire <span class="required">*</span> :</label>
                    <textarea name="comment" required cols="30" rows="10" placeholder="Votre commentaire"></textarea>
                </div>
                <button type="submit">ENVOYER</button>
                <a href="/GBAF/acteur.php?id=<?= $id ?>" class="personal-link-acteur">Retour</a>
            </form>
        </div>

        <div class="fixed-footer">
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/footer.php'; ?>
        </div>
    </body>
</html>