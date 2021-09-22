<?php

session_start();
$_SESSION = [];    // je declare de ma session ne comporte plus aucune information
session_destroy();   // je détruit ma session
// destruction des cookies
setcookie('souvenir', '', time() - 60, '/', 'localhost', false, true);
setcookie('id', '', time() - 60, '/', 'localhost', false, true);

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'connexion.php';
header("Location: http://$host$uri/$extra");