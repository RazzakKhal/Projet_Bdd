<?php
require_once('utilisateur.php');
$utilisateur = New Utilisateur();
$pattern = "/@+/";
$utilisateur->mail = htmlspecialchars($_POST['mail']); //htmlspecialchars pour eviter failles XSS
$utilisateur->pseudo = htmlspecialchars($_POST['pseudo']);
$vfpass = htmlspecialchars($_POST['pass']);
$vfpass2 = htmlspecialchars($_POST['pass2']);
$utilisateur->pass=password_hash($vfpass,PASSWORD_BCRYPT);

// code pour futur application sur heroku et connexion bdd

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


// Je veux que mes mot de passe contiennent au moins 8 caractères dont 1 caractère special, 1 majuscule, 1 chiffre

$patt = "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/";

// \S pour enlever les espaces en debut et fin de mdp, ?= correspond au lookahead (suivie de)
//  ancré au début de la chaîne
//  tout ensemble de caractères
//  d'au moins 8
//  contenant au moins une lettre minuscule
//  et au moins une lettre majuscule
//  et au moins un chiffre
//  et au moins un caractère special
//  $: ancré à la fin de la chaîne



if(preg_match($patt, $_POST['pass'])){

if($vfpass === $vfpass2){ // On vérifie si les mots de passe entrées sont identiques et si le mail contient un @
    if(preg_match($pattern, $utilisateur->mail)){
        //si c'est bon On vérifie que le login ou le mail n'existe pas deja dans la bdd

$pdo= New PDO("mysql:dbname=$database;host=$hostname", $username, $password);

$requête=$pdo->prepare('SELECT * FROM utilisateur WHERE pseudo=:pseudo'); // tentative de recup des infos via le pseudo
$requête->bindValue(':pseudo',$utilisateur->pseudo);
$requête->execute();
$res = $requête->fetch();


$requête2=$pdo->prepare('SELECT * FROM utilisateur WHERE mail=:mail');  // tentative de recup via le mail
$requête2->bindValue(':mail',$utilisateur->mail);
$requête2->execute();
$res2 = $requête2->fetch();


// on prépare chaque requête car cela empeche les injections SQL

// si les 2 requêtes renvoient false c'est que ni le pseudo ni le mail ne sont pris

if(!$res){
    if(!$res2){
    $requête3=$pdo->prepare('INSERT INTO utilisateur(pseudo, mail, pass, date_inscription) VALUES (:pseudo,:mail,:pass,:datee)');
    $requête3->bindValue(':pseudo', $utilisateur->pseudo);
    $requête3->bindValue(':mail', $utilisateur->mail);
    $requête3->bindValue(':pass', $utilisateur->pass);
    $requête3->bindValue(':datee', time());
    $requête3->execute();
// on a entré dans la bdd les valeurs fournies par l'utilisateur
// on redirige vers la page de connexion

    header('Location: http://projetbdd1.herokuapp.com/connexion.php');
}
else{
    echo 'mail déja existant dans notre base de données';
}
}
else{
    echo 'pseudo déjà existant dans notre base de donnée';
    
}


    } //sinon l'email est mauvais
    else{
        echo 'votre email semble erroné';
    }
    
    
}
else{
    echo ' vos mot de passes de sembles pas identiques';
}

}
else{
    echo 'format du mot de passe incorrect, il doit contenir au moins 8 caractères dont 1 majuscule, 1 minuscule, un caractère special et 1 chiffre.';
}
