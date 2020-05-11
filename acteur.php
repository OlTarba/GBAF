<?php  
    session_start();
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/functions.php';

    if(!isset($_SESSION['connect'])){
        header('Location: /GBAF/connexion.php');
    }

    $id = str_secur($_GET['id']);

    $reqActeurPage = $db->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
    $reqActeurPage->execute([$id]);
    $acteur = $reqActeurPage->fetch();

    if($acteur === false){
        header('Location: /GBAF/system/error.php');
    }

    $reqPost = $db->prepare('SELECT * FROM post INNER JOIN account ON post.id_user = account.id_user WHERE post.id_acteur ');
    $reqPost->execute([$id]);

    $reqPostCount = $db->prepare('SELECT COUNT(*) AS postCount FROM post WHERE id_acteur = ?');
    $reqPostCount->execute([$id]);
    $postCount = $reqPostCount->fetch();
    
    $postCount['postCount'] > 1 ? $commentaires = "Commentaires" : $commentaires = "Commentaire";


    $reqPostUser = $db->prepare('SELECT COUNT(*) AS postUserCount FROM post WHERE id_acteur = ? AND id_user = ?');
    $reqPostUser->execute([$id, $_SESSION['id']]);

    $postUserCount = $reqPostUser->fetch();

    $buttonNewComment = '';

    if($postCount['postCount'] == 0 || $postUserCount['postUserCount'] == 0){
        $buttonNewComment = '<a href="/GBAF/system/add_comment.php?id='.$id.'" class="new-comment">Nouveau <br> commentaire</a>';
    }

    $reqLike = $db->prepare('SELECT COUNT(*) AS countLike FROM vote WHERE id_acteur = ? AND vote = ?');
    $reqLike->execute([$id, 1]);
    $like = $reqLike->fetch();

    $reqDislike = $db->prepare('SELECT COUNT(*) AS countDislike FROM vote WHERE id_acteur = ? AND vote = ?');
    $reqDislike->execute([$id, 2]);
    $dislike = $reqDislike->fetch();

    $reqUserVote = $db->prepare('SELECT COUNT(*) AS countVote FROM vote WHERE id_acteur = ? AND id_user = ?');
    $reqUserVote->execute([$id, $_SESSION['id']]);
    $voted = $reqUserVote->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/head.php'; ?>
    <title>GBAF | <?= $acteur['acteur'] ?></title>
</head>
<body>
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/header.php'; ?>

    <div class="card">
        <img src="img/<?= $acteur['logo'] ?>" class="logo-acteur" alt="<?= $acteur['acteur'] ?>">
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
                        <a href="/GBAF/system/like_system.php?value=1&id=<?= $id ?>"><img src="/GBAF/img/like.svg" class="comment-like-dislike" alt="Like"></a>
                        <?= $like['countLike'] ?>
                    </div>
                    <div class="dislike">
                        <a href="/GBAF/system/like_system.php?value=2&id=<?= $id ?>"><img src="/GBAF/img/dislike.svg" class="comment-like-dislike" alt="Dislike"></a>
                        <?= $dislike['countDislike'] ?>
                    </div>
                <?php }else {  ?>
                    <div class="like voted">
                        <a><img src="/GBAF/img/like.svg" class="comment-like-dislike" alt="Like"></a>
                        <?= $like['countLike'] ?>
                    </div>
                    <div class="dislike voted">
                        <a><img src="/GBAF/img/dislike.svg" class="comment-like-dislike" alt="Dislike"></a>
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

    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/footer.php'; ?>    
</body>
</html>