<?php

$pattern = '/@+/';
$verifmail = htmlspecialchars($_POST['mail']); //htmlspecialchars pour eviter failles XSS
$verifpseudo = htmlspecialchars($_POST['pseudo']);
$vfpass = htmlspecialchars($_POST['pass']);
$vfpass2 = htmlspecialchars($_POST['pass2']);
$verifpass=password_hash($vfpass,PASSWORD_BCRYPT);

// On vérifie si les mots de passe entrées sont identiques et si le mail contient un @

if($vfpass === $vfpass2){
    if(preg_match($pattern, $verifmail)){
        //si c'est bon On vérifie que le login ou le mail n'existe pas deja dans la bdd

$pdo= New PDO('mysql:dbname=Projet_bdd;host=localhost', 'root', '');

$requête=$pdo->prepare('SELECT * FROM utilisateur WHERE pseudo=:pseudo'); // tentative de recup des infos via le pseudo
$requête->bindValue(':pseudo',$verifpseudo);
$requête->execute();
$res = $requête->fetch();


$requête2=$pdo->prepare('SELECT * FROM utilisateur WHERE mail=:mail');  // tentative de recup via le mail
$requête2->bindValue(':mail',$verifmail);
$requête2->execute();
$res2 = $requête2->fetch();


// on prépare chaque requête car cela empeche les injections SQL

// si les 2 requêtes renvoient false c'est que ni le pseudo ni le mail ne sont pris

if(!$res){
    if(!$res2){
    $requête3=$pdo->prepare('INSERT INTO utilisateur(pseudo, mail, pass, date_inscription) VALUES (:pseudo,:mail,:pass,:datee)');
    $requête3->bindValue(':pseudo', $verifpseudo);
    $requête3->bindValue(':mail', $verifmail);
    $requête3->bindValue(':pass', $verifpass);
    $requête3->bindValue(':datee', time());
    $requête3->execute();
// on a entré dans la bdd les valeurs fournies par l'utilisateur
    echo ' enregistrement réussi';
    header('Location:https://localhost/Projet_bdd/connexion.php');
}
else{
    echo 'mail déja existant dans notre base de données';
}
}
else{
    echo 'pseudo déjà existant dans notre base de donnée';
    var_dump($res2);
}


    } //sinon l'email est mauvais
    else{
        echo 'votre email semble erroné';
    }
    
    
}
else{
    echo ' vos mot de passes de sembles pas identiques';
}


