<?php

if (getenv('CLEARDB_DATABASE_URL') !== false){
    $clearbd_url = parse_url(getenv('CLEARDB_DATABASE_URL'));
    
    $hostname = $clearbd_url['host'];
    $username = $clearbd_url['user'];
    $password = $clearbd_url['pass'];
    $database = substr($clearbd_url['path'],1);
    $active_group = 'default';
    $query_builder = TRUE;
    $domainecookie = 'projetbdd1.herokuapp.com';

    
    }
else{
    $username = 'root';
    $password = '';
    $database = 'Projet_Bdd';
    $hostname = 'localhost';
    $domainecookie = 'localhost';
    }


session_start();
$_SESSION = [];    // je declare de ma session ne comporte plus aucune information
session_destroy();   // je détruit ma session
// destruction des cookies
setcookie('souvenir', '', time() - 60, '/', $domainecookie, false, true);
setcookie('id', '', time() - 60, '/', $domainecookie, false, true);

header('Location: http://projetbdd1.herokuapp.com/connexion.php');