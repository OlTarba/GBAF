<?php  
    session_start();

    require_once 'include/functions.php';
    require_once 'include/database.php';

    if(!isset($_SESSION['connect'])){
        header('Location: connexion.php');
    }

    $id = str_secur($_GET['id']);

    // Redirection si l'id de l'acteur est incorrect
    $acteur = selectAllWhere('acteur', 'id_acteur', $id);
    if($acteur === false){
        header('Location: system/error.php');
    }

    // Récupère les commentaires et les informations des utilisateurs qui ont commenté
    $reqPost = $db->prepare('SELECT * FROM post INNER JOIN account ON post.id_user = account.id_user WHERE post.id_acteur ');
    $reqPost->execute([$id]);

    // Compte le nombre de commentaire lié à l'acteur et modifie l'orthographe en fonction du nombre
    $reqPostCount = $db->prepare('SELECT COUNT(*) AS postCount FROM post WHERE id_acteur = ?');
    $reqPostCount->execute([$id]);
    $postCount = $reqPostCount->fetch();
    $postCount['postCount'] > 1 ? $commentaires = "Commentaires" : $commentaires = "Commentaire";

    // Compte et affiche ou non le bouton de nouveau commentaire si l'utilisateur n'a pas encore commenté l'acteur
    $postUserCount = countWhereAnd('postUserCount', 'post', 'id_acteur', 'id_user', $id, $_SESSION['id']);
    if($postUserCount['postUserCount'] == 0){
        $buttonNewComment = '<a href="system/add_comment.php?id='.$id.'" class="new-comment">Nouveau <br> commentaire</a>';
    }else{
        $buttonNewComment = '';
    }

    // Compte combien il y a de Like et des Dislike à l'acteur
    $like       = countWhereAnd('countLike', 'vote', 'id_acteur', 'vote', $id, 1);
    $dislike    = countWhereAnd('countDislike', 'vote', 'id_acteur', 'vote', $id, 2);

    // Compte combien de fois à voté l'utilisateur connecté pour activé ou non le bouton de Like / Dislike
    $voted      = countWhereAnd('countVote', 'vote', 'id_acteur', 'id_user', $id, $_SESSION['id']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once 'include/head.php'; ?>
    <title>GBAF | <?= $acteur['acteur'] ?></title>
</head>
<body>
    <?php include_once 'include/header.php'; ?>

    <!-- Affichage des données de l'acteur -->
    <div class="card">
        <img src="img/<?= $acteur['logo'] ?>" class="logo-acteur" alt="<?= $acteur['acteur'] ?>">
        <h2><?= $acteur['acteur'] ?></h2>
        <p><a href="#" class="personal-link-acteur"><?= $acteur['acteur'] ?>.fr</a></p>
        <p class="text-content">
            <?= $acteur['description'] ?>        
        </p>
    </div>

    <!-- Affichage de la partie commentaire -->
    <div class="card">

        <!-- En-tête des commentaires (Nombre de commentaire | Bouton commentaire | Like - Dislike) -->
        <div class="comment-heading" id="comments">
            <h5><?= $postCount['postCount'] ?> <?= $commentaires ?></h5>
            <div class="container-button-comment">
                <?= $buttonNewComment ?>
                <?php if($voted['countVote'] == 0){ ?>
                    <div class="like">
                        <a href="system/like_system.php?value=1&id=<?= $id ?>"><img src="img/like.svg" class="comment-like-dislike" alt="Like"></a>
                        <?= $like['countLike'] ?>
                    </div>
                    <div class="dislike">
                        <a href="system/like_system.php?value=2&id=<?= $id ?>"><img src="img/dislike.svg" class="comment-like-dislike" alt="Dislike"></a>
                        <?= $dislike['countDislike'] ?>
                    </div>
                <?php }else {  ?>
                    <div class="like voted">
                        <a><img src="img/like_voted.svg" class="comment-like-dislike" alt="Like"></a>
                        <?= $like['countLike'] ?>
                    </div>
                    <div class="dislike voted">
                        <a><img src="img/dislike_voted.svg" class="comment-like-dislike" alt="Dislike"></a>
                        <?= $dislike['countDislike'] ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Affichage dynamique des commentaires -->
        <?php while($post = $reqPost->fetch()){ 
            if($post['id_acteur'] === $id){ ?>
            <div class="comment">
                <p class="comment-name"><?= $post['prenom'].' '.$post['nom'] ?></p>
                <p class="comment-date"><?= substr($post['date_add'], 0, 16) ?></p>
                <p class="comment-message"><?= $post['post'] ?></p>
            </div>
        <?php }
        } ?> 
    </div>

    <?php include_once 'include/footer.php'; ?>    
</body>
</html>