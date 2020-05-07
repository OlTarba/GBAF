<?php 

    const DATABASE_HOST = "localhost";                
    const DATABASE_NAME = "gbaf";       
    const DATABASE_USER = "root";                     
    const DATABASE_PASSWORD = "";                     

    try{
        $db = new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME.';charset=utf8', DATABASE_USER, DATABASE_PASSWORD);
    }catch(Exception $e){
        echo 'Erreur : '.$e->getMessage().'\n';
    }