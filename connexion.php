<?php 
    session_start();

    require_once 'include/functions.php';
    require_once 'include/database.php';

    if(isset($_SESSION['connect'])){
        header('Location: index.php');
    }

    // Traitement du formulaire
    if(!empty($_POST['pseudo']) && !empty($_POST['password'])){
        $pseudo     = str_secur($_POST['pseudo']);
        $password   = str_secur($_POST['password']);

        $password = sha1($password.'tbjda');

        $reqUsername = $db->prepare('SELECT * FROM account WHERE username = ?');
        $reqUsername->execute([$pseudo]);

        while($username = $reqUsername->fetch()){
            // Définission des variables de session pour la connexion si le mot de passe entré est correct
            if($password === $username['password']){
                $_SESSION['id']             = $username['id_user'];
                $_SESSION['nom']            = $username['nom'];
                $_SESSION['prenom']         = $username['prenom'];
                $_SESSION['connect']        = 1;

                header('Location: index.php');
                exit;            
            }else{
                header('Location: connexion.php?error=1&message=Mot de passe incorrect');
                exit;
            }
        }

        header('Location: connexion.php?error=1&message=Pseudonyme incorrect');
        exit;
    }   

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once 'include/head.php'; ?>
        <title>GBAF | Connexion </title>
    </head>
    <body>
        <?php include_once 'include/header.php'; ?>
        
        <!-- Formulaire de connexion -->
        <div class="card-form form">
            <h3>Connexion</h3>
            <form action="" method="POST">
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
            <p><a href="system/forgot.php" class="link-button">Mot de passe oublié ?</a></p>
            <br>
            
            <!-- Affichage des exceptions (Erreur et succès) -->
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