<?php

$pattern = '/@+/';
$verifmail = $_POST['mail'];
$verifpseudo = $_POST['pseudo'];
$verifpass=password_hash($_POST['pass'],PASSWORD_BCRYPT);

// On vérifie si les mots de passe entrées sont identiques et si le mail contient un @

if($_POST['pass'] === $_POST['pass2']){
    if(preg_match($pattern, $verifmail)){
        //si c'est bon On vérifie que le login ou le mail n'existe pas deja dans la bdd

$pdo= New PDO('mysql:dbname=Projet_bdd;host=localhost', 'root', '');

$requête=$pdo->prepare('SELECT COUNT(*) FROM utilisateur WHERE pseudo=:pseudo'); // nombre de ligne qui existe avec comme pseudo celui de l'utilisateur
$requête->bindValue(':pseudo',$verifpseudo);
$requête->execute();

$requête2=$pdo->prepare('SELECT COUNT(*) FROM utilisateur WHERE mail=:mail');  // nombre de ligne qui existe avec comme mail celui de l'utilisateur
$requête2->bindValue(':mail',$verifmail);
$requête2->execute();


$nbpseudo= $requête->fetch(PDO::FETCH_NUM);
$nbmail= $requête2->fetch(PDO::FETCH_NUM);
// si on trouve 0 ou false en première valeur alors on peut inscrire les informations dans la bdd car aucune info sera remontée

if($nbpseudo[0] == false && $nbmail[0] == false){
    $requête3=$pdo->prepare('INSERT INTO utilisateur(pseudo, mail, pass, date_inscription) VALUES (:pseudo,:mail,:pass,:datee)');
    $requête3->bindValue(':pseudo', $verifpseudo);
    $requête3->bindValue(':mail', $verifmail);
    $requête3->bindValue(':pass', $verifpass);
    $requête3->bindValue(':datee', time());
    $requête3->execute();
// on a entré dans la bdd les valeurs fournies par l'utilisateur
    echo ' enregistrement réussi';
}
else{
    echo 'le mail ou le pseudo sont déjà existants dans notre base de donnée';
}


    } //sinon l'email est mauvais
    else{
        echo 'votre email semble erroné';
    }
    
    
}
else{
    echo ' vos mot de passes de sembles pas identiques';
}


