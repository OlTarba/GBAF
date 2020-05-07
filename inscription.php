<?php 
    session_start();

    if(isset($_SESSION['connect'])){
        header('Location: index.php');
    }

    require_once 'include/database.php';
    require_once 'include/functions.php';



    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['pseudo']) && !empty($_POST['password']) && !empty($_POST['question']) && !empty($_POST['reponse'])){

        $nom        = str_secur($_POST['nom']);
        $prenom     = str_secur($_POST['prenom']);
        $pseudo     = str_secur($_POST['pseudo']);
        $password   = str_secur($_POST['password']);
        $question   = str_secur($_POST['question']);
        $reponse    = str_secur($_POST['reponse']);

        $password   = "tbjda".sha1($password)."7a96";
        $reponse    = "acvp".sha1($reponse)."7m20";

        $reqPseudo = $db->prepare('SELECT COUNT(*) as countUsername FROM account WHERE username = ?');
        $reqPseudo->execute([$pseudo]);

        while($username = $reqPseudo->fetch()){
            if($username['countUsername'] != 0){
                header('Location: inscription.php?error=1&message=Le pseudonyme est déjà utilisé');
                exit;
            }else{
                $reqInsert = $db->prepare('INSERT INTO account(nom, prenom, username, password, question, reponse) VALUES(?, ?, ?, ?, ?, ?)');
                $reqInsert->execute([$nom, $prenom, $pseudo, $password, $question, $reponse]);

                header('Location: inscription.php?success=1&message=Bienvenue ! Vous pouvez maintenant vous connecter !');
                exit;
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once 'include/head.php'; ?>
        <title>GBAF | Inscription </title>
    </head>
    <body>
        <?php include_once 'include/header.php'; ?>

        <div class="card-form form">
            <h3>Inscription</h3>
            <form action="" method="POST">
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
            <p>Vous êtes déjà inscrit ? <a href="connexion.php" class="link-button">Se connecter</a></p>
            <br>
            <?php if(isset($_GET['error'])){ ?>
                <p class="error"><?= $_GET['message'] ?></p>
            <?php }else if(isset($_GET['success'])){ ?>
                <p class="success"><?= $_GET['message'] ?></p>
            <?php } ?>
                
        </div>

        <div class="fixed-footer">
            <?php include_once 'include/footer.php'; ?>
        </div>
    </body>
</html>