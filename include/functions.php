<?php 
    
    // Sécurise une chaîne de caractère 
    function str_secur($string){
        return trim(htmlspecialchars($string));
    }

    // Affiche un var_dump de façons plus lisible
    function debug($var){
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    
    // Raccourcis une requête SQL ou l'on selectionne tout quand ... 
    function selectAllWhere($table, $where, $whereResult){
        $db = $GLOBALS['db'];
        $req = $db->prepare('SELECT * FROM '.$table.' WHERE '.$where.' = ?'); 
        $req->execute([$whereResult]);

        return $req->fetch();
    }

    // Raccourcis une requête SQL ou l'on compte tout quand ... et ... 
    function countWhereAnd($alias, $table, $where, $and, $whereResult, $andResult){
        $db = $GLOBALS['db'];
        $req = $db->prepare('SELECT COUNT(*) AS '.$alias.' FROM '.$table.' WHERE '.$where.' = ? AND '.$and.' = ?');
        $req->execute([$whereResult, $andResult]);

        return $req->fetch();
    }

    // Vérifie si l'utilisateur est connecté et si il est bien inscrit
    function checkConnect($pathDisconnect = 'deconnexion' ,$path = '../connexion'){
        if(isset($_SESSION['connect'])){
            $user = selectAllWhere('account', 'id_user', $_SESSION['id']);

            if($_SESSION['key'] != sha1($user['password'].'gbafwebsite')){

                header('Location: '.$pathDisconnect.'.php');
                exit;
            }
        }else{
            header('Location: '.$path.'.php');
            exit;
        }
    }

    // Vérifie si l'utilisateur est déconnecté et si il est bien inscrit
    function checkDisconnect($pathDisconnect, $path){
        if(isset($_SESSION['connect'])){
            $user = selectAllWhere('account', 'id_user', $_SESSION['id']);

            if($_SESSION['key'] != sha1($user['password'].'gbafwebsite')){

                header('Location: '.$pathDisconnect.'.php');
                exit;

            }else{
                header('Location: '.$path.'.php ');
                exit;
            }
        }
    }