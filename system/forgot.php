<?php 
    session_start();

    require_once '../include/functions.php';
    require_once '../include/database.php';

    checkDisconnect('deconnexion', '../index');


    // Etape 1 : Récupère le pseudo, le sécurise et redirectionne vers l'étape suivant
    if(!empty($_POST['pseudo'])){
        $pseudo = str_secur($_POST['pseudo']);

        $reqUser = $db->prepare('SELECT * FROM account WHERE username = ?');
        $reqUser->execute([$pseudo]);
        $user = $reqUser->fetch();
        
        
        if(!$user){
            header('Location: forgot.php?error=Pseudonyme inconnu');
            exit;
        }
        
        header('Location: forgot.php?question='.$user['id_user']);
    }

    // Etape 2 : Récupère la réponse chiffré, chiffre le nouveau mot de passe et l'insert dans la base de donnée 
    if(isset($_GET['question'])){

        $user = selectAllWhere('account', 'id_user', $_GET['question']);

        if(!empty($_POST['reponse']) && !empty($_POST['password']) && !empty($_POST['confirm-password'])){
            $reponse            = str_secur($_POST['reponse']);
            $password           = str_secur($_POST['password']);
            $confirmPassword    = str_secur($_POST['confirm-password']);

            $reponse = sha1($reponse.'acvp');

            if($reponse === $user['reponse']){
                if($confirmPassword === $password){
                    $password = sha1($password.'tbjda');

                    $reqUpdatePass = $db->prepare('UPDATE account set password = ? WHERE id_user = ?');
                    $reqUpdatePass->execute([$password, $user['id_user']]);

                    header('Location: ../connexion.php?success=1&message=Votre mot de passe à bien été modifié.');
                    exit;

                }else{
                    header('Location: forgot.php?question='.$user['id_user'].'&error=Les mots de passe ne sont pas identique');
                    exit;
                }
            
            }else{
                header('Location: forgot.php?question='.$user['id_user'].'&error=Réponse incorrect');
                exit;
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php require_once '../include/head.php'; ?>
        <title>GBAF | Mot de passe oublié</title>
    </head>
    <body>
        <?php include_once '../include/header.php'; ?>

        <!-- Affichage en deux étapes (Etape 1 : Pseudo | Etape 2 : Question, réponse, nouveau mot de passe) -->
        <?php if(!isset($_GET['question'])){ ?>
            <div class="card-form form">
                <h3>Mot de passe oublié</h3>
                <form action="" method="POST">
                    <div>
                        <label for="pseudo">Pseudonyme <span class="required">*</span> :</label>
                        <input type="text" name="pseudo" required>
                    </div>
                    <button type="submit">VALIDER</button>
                    <br>
                    <?php if(isset($_GET['error'])){ ?> 
                        <p class="error"><?= $_GET['error'] ?></p>
                    <?php } ?>
                </form>
            </div>
        <?php } else if(isset($_GET['question'])){  ?>
            <div class="card-form form">
                <h3>Modifier votre mot de passe</h3>
                <form method="POST">
                    <div>
                        <label for="question">Question secrète :</label>
                        <span class="question" id="question"><?= $user['question'] ?></span>
                    </div>    
                    <div>
                        <label for="reponse">Réponse secrète <span class="required">*</span> : </label>
                        <input type="text" required id="reponse" name="reponse">
                    </div>
                    <div>
                        <label for="password">Nouveau mot de passe <span class="required">*</span> : </label>
                        <input type="password" required id="password" name="password">
                    </div>
                    <div>
                        <label for="confirm-password">Confirmer le mot de passe <span class="required">*</span> : </label>
                        <input type="password" required id="confirm-password" name="confirm-password">
                    </div>
                    <button type="submit">VALIDER</button>
                    <?php if(isset($_GET['error'])){ ?> 
                        <p class="error"><?= $_GET['error'] ?></p>
                    <?php } ?>
                </form>
            </div>
        <?php } ?>    
        
        <div class="fixed-footer">
            <?php include_once '../include/footer.php'; ?> 
        </div>
    </body>
</html>