<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'include/head.php'; ?>
    <title>GBAF | Inscription </title>
</head>
<body>
    <?php include_once 'include/header.php'; ?>

    <div class="card-form form">
        <form action="">
            <div>
                <label for="nom">Nom <span class="required">*</span>  : </label>
                <input type="text" required name="nom">
            </div>
            <div>
                <label for="prenom">Prénom <span class="required">*</span>  : </label>
                <input type="text" required name="prenom">
            </div>
            <div>
                <label for="pseudo">Pseudonyme <span class="required">*</span>  : </label>
                <input type="text" required name="pseudo">
            </div>
            <div>
                <label for="password">Mot de passe <span class="required">*</span>  : </label>
                <input type="password" required name="password">
            </div>
            <div>
                <label for="question">Question secrête <span class="required">*</span>  : </label>
                <input type="text" required name="question">
            </div>
            <div>
                <label for="reponse">Réponse secrête <span class="required">*</span>  : </label>
                <input type="text" required name="reponse">
            </div>
            <button type="submit">VALIDER</button>
        </form>
        <br>
        <p>Vous êtes déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
    </div>

    <?php include_once 'include/footer.php'; ?>
</body>
</html>