<?php

session_start();
//setcookie('mail', $mail, time() + -60);
//setcookie('password', $pass, time() + -60); // destruction des cookies d'authentification
$_SESSION = [];    // je declare de ma session ne comporte plus aucune information
session_destroy();   // je détruit ma session

header('Location:http://localhost/Projet_bdd/index.php');