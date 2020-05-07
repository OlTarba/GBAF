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
            <h5>2 commentaires</h5>
            <div class="container-button-comment">
                <a href="#" class="new-comment">Nouveau <br> commentaire</a>
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
        <div class="comment">
            <p class="comment-name">Thibault</p>
            <p class="comment-date">06/05/2020</p>
            <p class="comment-message">Sympathique votre organisme, je like direct wesh !</p>
        </div>
        <div class="comment">
            <p class="comment-name">Angélique</p>
            <p class="comment-date">07/05/2020</p>
            <p class="comment-message">Woaw ! T'avance super vite !</p>
        </div>
    </div>

    <?php include_once 'include/footer.php'; ?>    
</body>
</html>