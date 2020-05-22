<?php 
    session_start();

    // Inclus les functions et la connexion à la base de donnée
    require_once 'include/functions.php';
    require_once 'include/database.php';

    // Redirection si l'utilisateur n'est pas connecté
    checkConnect('system/deconnexion','connexion');

    // Récupère les données de tout les acteurs
    $reqActeur = $db->prepare('SELECT * FROM acteur');
    $reqActeur->execute([]);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once 'include/head.php'; ?>
    <title>GBAF | Accueil</title>
</head>
<body>
    <?php include_once 'include/header.php'; ?>

    <!-- Affichage de la description de GBAF -->
    <div class="description">
        <h1>Le Groupement Banque Assurance Français</h1>
        <p>Fédération représentant les 6 grands groupes français : 
            BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Général, La Banque Postale.
            <br>
            Représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation
            financière française. 
        </p>
    </div>
    <!-- Affichage des acteurs -->
    <div class="card listing">
        <?php while($acteur = $reqActeur->fetch()){ ?>
            <div class="acteur">
                <img src="img/<?= $acteur['logo'] ?>" alt="<?= $acteur['acteur'] ?>">
                <div class="content">
                    <h3><?= $acteur['acteur'] ?></h3>
                    <p>
                        <?= substr($acteur['description'], 0, 136).'...' ?>
                        <a href="#" class="personal-link-acteur"><?= $acteur['acteur'] ?>.fr</a>
                    </p>
                    <p class="link"><a href="acteur.php?id=<?= $acteur['id_acteur'] ?>">Lire la suite</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php include_once 'include/footer.php'; ?>
</body>
</html>