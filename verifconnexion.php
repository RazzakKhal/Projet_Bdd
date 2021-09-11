<?php 

// on recupere mail et mot de passe

$mail = $_POST['mail'];
$pass = $_POST['pass'];   

// on les compare aux mail et pass de la bdd

$pdo = New PDO('mysql:dbname=Projet_Bdd;host=localhost', 'root', '');

$requete= $pdo->prepare('SELECT id, pass, pseudo FROM utilisateur WHERE mail=:mail');
$requete->bindValue(':mail', $mail);
$requete->execute();
$res = $requete->fetch(PDO::FETCH_NUM);


if(password_verify($pass, $res[1])){    // je compare le pass de la bdd hashé au pass fourni par l'utilisateur grace à password_verify
    session_start();  // si ok je demarre une session et intitialise les variables session de l'utilisateur
    $_SESSION['id'] = $res[0];
    $_SESSION['pseudo'] = $res[2];
    header('Location:http://localhost/Projet_bdd/index.php');
}
else{
    echo 'erreur dans le remplissage du mail ou du mot de passe';
}



// si c'est bon on crée les variables sessions de l'utilisateur

// on ajoute une option de connexion automatique gràce aux cookies

