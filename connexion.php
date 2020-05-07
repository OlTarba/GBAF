<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once 'include/head.php'; ?>
        <title>GBAF | Connexion </title>
    </head>
    <body>
        <?php include_once 'include/header.php'; ?>

        <div class="card-form form connexion">
            <h3>Connexion</h3>
            <form action="">
                <div>
                    <label for="pseudo">Pseudonyme : </label>
                    <input type="text" required name="pseudo">
                </div>
                <div>
                    <label for="password">Mot de passe : </label>
                    <input type="password" required name="password">
                </div>

                <button type="submit">CONNEXION</button>
            </form>
            <br>
            <p>Pas encore inscrit ? <a href="inscription.php" class="link-button">S'inscrire</a></p>
        </div>

        <div class="fixed-footer">
            <?php include_once 'include/footer.php'; ?>
        </div>
    </body>
</html>