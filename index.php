<?php 
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/GBAF/include/functions.php';

    require_once $absolute_path.'include/database.php';

    if(!isset($_SESSION['connect'])){
        header('Location: '.$simple_path.'connexion.php');
    }

    $reqActeur = $db->prepare('SELECT * FROM acteur');
    $reqActeur->execute([]);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require_once $absolute_path.'include/head.php'; ?>
    <title>GBAF | Accueil</title>
</head>
<body>
    <?php include_once $absolute_path.'include/header.php'; ?>

    <div class="description">
        <h1>Le Groupement Banque Assurance Français</h1>
        <p>Fédération représentant les 6 grands groupes français : 
            BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Général, La Banque Postale.
            <br>
            Représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation
            financière française. 
        </p>
    </div>

    <div class="card">
        <?php while($acteur = $reqActeur->fetch()){ ?>
            <div class="acteur">
                <img src="<?= $simple_path ?>img/<?= $acteur['logo'] ?>" alt="<?= $acteur['acteur'] ?>">
                <div class="content">
                    <h3><?= $acteur['acteur'] ?></h3>
                    <p>
                        <?= substr($acteur['description'], 0, 150).'...' ?>
                        <a href="#" class="personal-link-acteur"><?= $acteur['acteur'] ?>.fr</a>
                    </p>
                    <p class="link"><a href="<?= $simple_path ?>acteur.php?id=<?= $acteur['id_acteur'] ?>">Lire la suite</a>
                </div>
            </div>
        <?php } ?>
    </div>




    <?php include_once $absolute_path.'include/footer.php'; ?>
</body>
</html>