<?php

session_start();
$_SESSION = [];    // je declare de ma session ne comporte plus aucune information
session_destroy();   // je détruit ma session

header('Location:http://localhost/Projet_bdd/index.php');