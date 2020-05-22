<?php 
    session_start();

    require_once '../include/functions.php';
    require_once '../include/database.php';
    
    checkConnect();

    $id = str_secur($_GET['id']);

    // Redirection si l'utilisateur à déjà commenter l'acteur
    $postUserCount = countWhereAnd('postUserCount', 'post', 'id_acteur', 'id_user', $id, $_SESSION['id']);
    if($postUserCount['postUserCount'] != 0){
        header('Location: ../acteur.php?id='.$id.'#comments');
        exit;
    }

    // Redirection si l'id en paramètre correspond à aucun acteur
    $acteur = selectAllWhere('acteur','id_acteur', $id);
    if($acteur === false){
        header('Location: error.php');
    }

    // Ajout du commentaire dans la base de donnée ainsi que la redirection vers celui-ci
    if(!empty($_POST['comment'])){
        $comment = str_secur($_POST['comment']);

        $reqInsertComment = $db->prepare('INSERT INTO post(id_user, id_acteur, post) VALUES(?, ?, ?)');
        $reqInsertComment->execute([$_SESSION['id'], $id, $comment]);

        header('Location: ../acteur.php?id='.$id.'#comments');
        exit;
    }
    
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once '../include/head.php'; ?>
        <title>GBAF | Nouveau commentaire</title>
    </head>
    <body>
        <?php include_once '../include/header.php'; ?>

        <div class="card-form form add-comment">
            <h3><?= $acteur['acteur'] ?></h3>
            <form action="" method='POST'>
                <div>
                    <label for="comment">Commentaire <span class="required">*</span> :</label>
                    <textarea name="comment" required cols="30" rows="10" placeholder="Votre commentaire"></textarea>
                </div>
                <button type="submit">ENVOYER</button>
                <a href="../acteur.php?id=<?= $id ?>" class="personal-link-acteur">Retour</a>
            </form>
        </div>

        <div class="fixed-footer">
            <?php include_once '../include/footer.php'; ?>
        </div>
    </body>
</html>