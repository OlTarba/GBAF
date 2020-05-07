<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once 'include/head.php'; ?>
    <title>GBAF | Acteur</title>
</head>
<body>
    <?php include_once 'include/header.php'; ?>

    <div class="card">
        <img src="img/Dsa_france.png" class="logo-acteur" alt="DSA France">
        <h2>DSA France</h2>
        <p><a href="#" class="personal-link-acteur">DSA-France.fr</a></p>
        <p class="text-content">
            Dsa France accélère la croissance du territoire et s’engage avec les collectivités territoriales. <br>
            Nous accompagnons les entreprises dans les étapes clés de leur évolution. <br>
            Notre philosophie : s’adapter à chaque entreprise. <br>
            Nous les accompagnons pour voir plus grand et plus loin et proposons des solutions de financement adaptées à chaque étape de la vie des entreprises <br>
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