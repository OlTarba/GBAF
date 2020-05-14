<?php 

    function str_secur($string){
        return trim(htmlspecialchars($string));
    }

    function debug($var){
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    
    function selectAllWhere($table, $where, $whereResult){
        $db = $GLOBALS['db'];
        $req = $db->prepare('SELECT * FROM '.$table.' WHERE '.$where.' = ?'); 
        $req->execute([$whereResult]);

        return $req->fetch();
    }

    function countWhereAnd($alias, $table, $where, $and, $whereResult, $andResult){
        $db = $GLOBALS['db'];
        $req = $db->prepare('SELECT COUNT(*) AS '.$alias.' FROM '.$table.' WHERE '.$where.' = ? AND '.$and.' = ?');
        $req->execute([$whereResult, $andResult]);

        return $req->fetch();
    }