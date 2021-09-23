<?php

session_start();
$_SESSION = [];    // je declare de ma session ne comporte plus aucune information
session_destroy();   // je détruit ma session
// destruction des cookies
setcookie('souvenir', '', time() - 60, '/', 'localhost', false, true);
setcookie('id', '', time() - 60, '/', 'localhost', false, true);

header('Location: http://projetbdd1.herokuapp.com/connexion.php');