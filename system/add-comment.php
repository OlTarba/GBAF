<?php 
    session_start();

    require_once '../include/database.php';
    require_once '../include/functions.php';

    if(!isset($_SESSION['connect'])){
        header('Location: ../connexion.php');
    }

    $id = str_secur($_GET['id']);

    $reqActeur = $db->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
    $reqActeur->execute([$id]);

    $acteur = $reqActeur->fetch();

    if(!empty($_POST['comment'])){
        $comment = str_secur($_POST['comment']);

        $reqInsertComment = $db->prepare('INSERT INTO post(id_user, id_acteur, post) VALUES(?, ?, ?)');
        $reqInsertComment->execute([$_SESSION['id'], $id, $comment]);

        header('Location: ../acteur.php?id='.$id);
        exit;
    }
    
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once 'include/head.php'; ?>
        <title>GBAF | Nouveau commentaire</title>
    </head>
    <body>
        <?php include_once 'include/header.php'; ?>

        <div class="card-form form add-comment">
            <h3><?= $acteur['acteur'] ?></h3>
            <form action="" method='POST'>
                <div>
                    <label for="comment">Commentaire <span class="required">*</span> :</label>
                    <textarea name="comment" required cols="30" rows="10" placeholder="Votre commentaire"></textarea>
                </div>
                <button type="submit">ENVOYER</button>
            </form>
        </div>

        <div class="fixed-footer">
            <?php include_once '../include/footer.php'; ?>
        </div>
    </body>
</html>