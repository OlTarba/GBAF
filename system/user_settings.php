<?php 
    session_start();

    require_once '../include/functions.php';
    require_once '../include/database.php';

    checkConnect();

    // Récupération des données de l'utilisateur connecté
    $user = selectAllWhere('account', 'id_user', $_SESSION['id']);

    // Définie le pseudo avant (éventuelle) modification dans la variable de session
    $_SESSION['username'] = $user['username'];

    // Traitement du formulaire
    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['question'])){
        $nom        = str_secur($_POST['nom']);
        $prenom     = str_secur($_POST['prenom']);
        $question   = str_secur($_POST['question']);

        // Par défault : les champs password et réponse ne changent pas
        $password   = $user['password'];
        $reponse    = $user['reponse'];
        
        // Modification du pseudo si le champ est rempli
        !empty($_POST['username']) ? $username = str_secur($_POST['username']) : $username = $user['username'];

        // Modification et chiffrage du mot de passe si le champ est rempli
        if(!empty($_POST['password'])){
            if(!empty($_POST['old-password'])){
                $oldPassword = str_secur($_POST['old-password']);
                $oldPassword = sha1($oldPassword.'tbjda');
                
                if($oldPassword === $user['password']){
                    if(!empty($_POST['confirm-password'])){
                        $confirmPassword = str_secur($_POST['confirm-password']);
                        $password = str_secur($_POST['password']);

                        if($confirmPassword === $password){
                            $password = sha1($password.'tbjda');
                        }else{
                            header('Location: user_settings.php?error=1&message=Le nouveau de mot de passe n\'est pas identique à sa confirmation');
                            exit;
                        }

                    }else{
                        header('Location: user_settings.php?error=1&message=Vous devez confirmer votre nouveau mot de passe');
                        exit;
                    }
                }else{
                    header('Location: user_settings.php?error=1&message=Votre mot de passe actuel est incorrect');
                    exit;
                }
            }else{
                header('Location: user_settings.php?error=1&message=Vous devez renseigner votre mot de passe actuel');
                exit;
            }
        }

        if(!empty($_POST['reponse'])){
            $reponse = str_secur($_POST['reponse']);
            $reponse = sha1($reponse.'acvp');
        }

        // Compte combien il y a d'utilisateur avec le pseudo souhaité
        $reqUsernameUsed = $db->prepare('SELECT COUNT(*) AS countUserUsed FROM account WHERE username = ?');
        $reqUsernameUsed->execute([$username]); 
        $userUsed = $reqUsernameUsed->fetch();

        // Ajout des modifications dans la base de donnée si le pseudo n'est pas utilisé ou qu'il n'a pas changé
        if($userUsed['countUserUsed'] == 0 || $_SESSION['username'] == $username){

            $reqUpdate = $db->prepare('UPDATE account SET nom = ?, prenom = ?, username = ?, password = ?, question = ?, reponse = ? WHERE id_user = ?');
            $reqUpdate->execute([$nom, $prenom, $username, $password, $question, $reponse, $_SESSION['id']]);

            // Mis à jour des nom et prénom pour l'affichage du header
            $_SESSION['nom']        = $nom;
            $_SESSION['prenom']     = $prenom;
            $_SESSION['key']        = sha1($password.'gbafwebsite');
                    
            header('Location: user_settings.php?success=1&message=Votre compte a bien été mis à jour.');
            exit;
                
        }else{
            header('Location: user_settings.php?error=1&message=Le pseudonyme est déjà utilisé.');
            exit;
        }
    }
?> 

<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once '../include/head.php'; ?> 
        <title>GBAF | <?= $user['prenom'].' '.$user['nom'] ?></title>
    </head>
    <body>
        <?php include_once '../include/header.php'; ?> 

        <div class="card-form form">
            <h3>Paramètre de compte</h3>
            <form method="POST">
                <div>
                    <label for="nom">Nom : </label>
                    <input type="text" required name="nom" id="nom" value="<?= $user['nom'] ?>">
                </div>
                <div>
                    <label for="prenom">Prénom : </label>
                    <input type="text" required name="prenom" id="prenom" value="<?= $user['prenom'] ?>">
                </div>
                <div>
                    <label for="pseudo">Pseudonyme : </label>
                    <input type="text" name="username" id="pseudo" placeholder="<?= $user['username'] ?>">
                </div>
                <div>
                    <label for="old-password">Mot de passe actuel : </label>
                    <input type="password" id="old-password" name="old-password" placeholder="Entrez votre mot de passe actuel">
                </div>
                <div>
                    <label for="password">Nouveau Mot de passe : </label>
                    <input type="password" name="password" id="password" placeholder="Entrez votre nouveau mot de passe">
                </div>
                <div>
                    <label for="confirm-password">Confirmer le mot de passe : </label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmer votre nouveau mot de passe">
                </div>
                <div>
                    <label for="question">Question secrête : </label>
                    <input type="text" required name="question" id="question" value="<?= $user['question'] ?>">
                </div>
                <div>
                    <label for="reponse">Réponse secrête : </label>
                    <input type="text" name="reponse" id="reponse" placeholder="Entrez votre nouvelle réponse">
                </div>
                <button type="submit">METTRE A JOUR</button>
            </form>
            <?php if(isset($_GET['error'])){ ?>
                <p class="error"><?= $_GET['message'] ?></p>
            <?php }else if(isset($_GET['success'])){ ?>
                <p class="success"><?= $_GET['message'] ?></p>
            <?php } ?>
        </div>

        <div class="fixed-footer">
            <?php include_once '../include/footer.php'; ?>
        </div>
    </body>
</html>