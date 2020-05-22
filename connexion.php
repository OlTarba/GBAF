<?php 
    session_start();

    require_once 'include/functions.php';
    require_once 'include/database.php';

    checkDisconnect('system/deconnexion', 'index');

    // Traitement du formulaire
    if(!empty($_POST['pseudo']) && !empty($_POST['password'])){
        $pseudo     = str_secur($_POST['pseudo']);
        $password   = str_secur($_POST['password']);

        $password = sha1($password.'tbjda');

        $reqUser = $db->prepare('SELECT * FROM account WHERE username = ?');
        $reqUser->execute([$pseudo]);

        while($user = $reqUser->fetch()){
            // Définission des variables de session pour la connexion si le mot de passe entré est correct
            if($password === $user['password']){
                $_SESSION['id']             = $user['id_user'];
                $_SESSION['nom']            = $user['nom'];
                $_SESSION['prenom']         = $user['prenom'];
                $_SESSION['username']       = $user['username'];
                $_SESSION['key']            = sha1($user['password'].'gbafwebsite');
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
                    <input type="text" id="pseudo" required name="pseudo">
                </div>
                <div>
                    <label for="password">Mot de passe : </label>
                    <input type="password" id="password" required name="password">
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