<header>
    <div class="container-logo">
        <a href="<?= $simple_path ?>index.php">
            <img src="<?= $simple_path ?>img/GBAF.png" alt="Groupe Bancaire Assurance Français" class="logo">
        </a>
    </div>
    <?php if(isset($_SESSION['connect'])){ ?>
        <div class="container-user">
            <a href="<?= $simple_path ?>system/deconnexion.php" class="personal-link-acteur">
                <img src="<?= $simple_path ?>img/disconnect.svg" class="user-picture" alt="">
                <p>Deconnexion</p>
            </a>
            <a href="<?= $simple_path ?>system/user_settings.php">
                <img src="<?= $simple_path ?>img/social.svg" alt="user" class="user-picture"> 
                <p class="user-info"><?= $_SESSION['nom'] ?> <?= $_SESSION['prenom'] ?></p>
            </a>
        </div>
    <?php }else{ ?>
        <h1 class="gbaf-title">Le Groupement Banque Assurance Français</h1>
    <?php } ?>
</header>