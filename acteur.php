<?php  
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/functions.php';
    require_once $absolute_path.'include/database.php';

    if(!isset($_SESSION['connect'])){
        header('Location: '.$simple_path.'connexion.php');
    }

    $id = str_secur($_GET['id']);

    $acteur = selectAllWhere('acteur', 'id_acteur', $id);
    if($acteur === false){
        header('Location: '.$simple_path.'system/error.php');
    }

    $reqPost = $db->prepare('SELECT * FROM post INNER JOIN account ON post.id_user = account.id_user WHERE post.id_acteur ');
    $reqPost->execute([$id]);

    $reqPostCount = $db->prepare('SELECT COUNT(*) AS postCount FROM post WHERE id_acteur = ?');
    $reqPostCount->execute([$id]);
    $postCount = $reqPostCount->fetch();
    $postCount['postCount'] > 1 ? $commentaires = "Commentaires" : $commentaires = "Commentaire";

    $postUserCount = countWhereAnd('postUserCount', 'post', 'id_acteur', 'id_user', $id, $_SESSION['id']);

    if($postUserCount['postUserCount'] == 0){
        $buttonNewComment = '<a href="'.$simple_path.'system/add_comment.php?id='.$id.'" class="new-comment">Nouveau <br> commentaire</a>';
    }else{
        $buttonNewComment = '';
    }

    $like       = countWhereAnd('countLike', 'vote', 'id_acteur', 'vote', $id, 1);
    $dislike    = countWhereAnd('countDislike', 'vote', 'id_acteur', 'vote', $id, 2);
    $voted      = countWhereAnd('countVote', 'vote', 'id_acteur', 'id_user', $id, $_SESSION['id']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once $absolute_path.'include/head.php'; ?>
    <title>GBAF | <?= $acteur['acteur'] ?></title>
</head>
<body>
    <?php include_once $absolute_path.'include/header.php'; ?>

    <div class="card">
        <img src="<?= $simple_path ?>img/<?= $acteur['logo'] ?>" class="logo-acteur" alt="<?= $acteur['acteur'] ?>">
        <h2><?= $acteur['acteur'] ?></h2>
        <p><a href="#" class="personal-link-acteur"><?= $acteur['acteur'] ?>.fr</a></p>
        <p class="text-content">
            <?= $acteur['description'] ?>        
        </p>
    </div>

    <div class="card">
        <div class="comment-heading" id="comments">
            <h5><?= $postCount['postCount'] ?> <?= $commentaires ?></h5>
            <div class="container-button-comment">
                <?= $buttonNewComment ?>
                <?php if($voted['countVote'] == 0){ ?>
                    <div class="like">
                        <a href="<?= $simple_path ?>system/like_system.php?value=1&id=<?= $id ?>"><img src="<?= $simple_path ?>img/like.svg" class="comment-like-dislike" alt="Like"></a>
                        <?= $like['countLike'] ?>
                    </div>
                    <div class="dislike">
                        <a href="<?= $simple_path ?>system/like_system.php?value=2&id=<?= $id ?>"><img src="<?= $simple_path ?>img/dislike.svg" class="comment-like-dislike" alt="Dislike"></a>
                        <?= $dislike['countDislike'] ?>
                    </div>
                <?php }else {  ?>
                    <div class="like voted">
                        <a><img src="<?= $simple_path ?>img/like_voted.svg" class="comment-like-dislike" alt="Like"></a>
                        <?= $like['countLike'] ?>
                    </div>
                    <div class="dislike voted">
                        <a><img src="<?= $simple_path ?>img/dislike_voted.svg" class="comment-like-dislike" alt="Dislike"></a>
                        <?= $dislike['countDislike'] ?>
                    </div>
                <?php } ?>
            </div>
        </div>
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

    <?php include_once $absolute_path.'include/footer.php'; ?>    
</body>
</html>