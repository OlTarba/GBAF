<?php  
    session_start();
    
    require_once 'include/database.php';
    require_once 'include/functions.php';

    if(!isset($_SESSION['connect'])){
        header('Location: connexion.php');
    }

    $id = str_secur($_GET['id']);

    $reqActeurPage = $db->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
    $reqActeurPage->execute([$id]);
    $acteur = $reqActeurPage->fetch();

    $reqPost = $db->prepare('SELECT * FROM post INNER JOIN account ON post.id_user = account.id_user WHERE post.id_acteur ');
    $reqPost->execute([$id]);

    // debug($reqPost->fetch());


    $reqPostCount = $db->prepare('SELECT COUNT(*) AS postCount FROM post WHERE id_acteur = ?');
    $reqPostCount->execute([$id]);
    $postCount = $reqPostCount->fetch();

    $reqPostUser = $db->prepare('SELECT COUNT(*) AS postUserCount FROM post WHERE id_acteur = ? AND id_user = ?');
    $reqPostUser->execute([$id, $_SESSION['id']]);

    $postUserCount = $reqPostUser->fetch();

    $buttonNewComment = '';

    if($postCount['postCount'] == 0 || $postUserCount['postUserCount'] == 0){
        $buttonNewComment = '<a href="add-comment.php?id='.$id.'" class="new-comment">Nouveau <br> commentaire</a>';
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once 'include/head.php'; ?>
    <title>GBAF | <?= $acteur['acteur'] ?></title>
</head>
<body>
    <?php include_once 'include/header.php'; ?>

    <div class="card">
        <img src="img/<?= $acteur['logo'] ?>" class="logo-acteur" alt="<?= $acteur['acteur'] ?>">
        <h2><?= $acteur['acteur'] ?></h2>
        <p><a href="#" class="personal-link-acteur"><?= $acteur['acteur'] ?>.fr</a></p>
        <p class="text-content">
            <?= $acteur['description'] ?>        
        </p>
    </div>

    <div class="card">
        <div class="comment-heading">
            <h5><?= $postCount['postCount'] ?> commentaires</h5>
            <div class="container-button-comment">
                <?= $buttonNewComment ?>
                <div class="like">
                    <a href=""><img src="img/like.svg" class="comment-like-dislike" alt="Like"></a>
                    5
                </div>
                <div class="dislike">
                    <a href=""><img src="img/dislike.svg" class="comment-like-dislike" alt="Dislike"></a>
                    2
                </div>
            </div>
        </div>
        <?php while($post = $reqPost->fetch()){ 
            if($post['id_acteur'] === $id){ ?>
            <div class="comment">
                <p class="comment-name"><?= $post['prenom'] ?> <?= $post['nom'] ?></p>
                <p class="comment-date"><?= substr($post['date_add'], 0, 16) ?></p>
                <p class="comment-message"><?= $post['post'] ?></p>
            </div>
        <?php }
        } ?> 
    </div>

    <?php include_once 'include/footer.php'; ?>    
</body>
</html>