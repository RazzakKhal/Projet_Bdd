<?php 

// on recupere mail et mot de passe

$mail = htmlspecialchars($_POST['mail']); // ajout evitement faille XSS avec htmlspecialchars
$pass = htmlspecialchars($_POST['pass']);   

// on les compare aux mail et pass de la bdd

$pdo = New PDO('mysql:dbname=Projet_Bdd;host=localhost', 'root', '');

$requete= $pdo->prepare('SELECT pass, id, pseudo FROM utilisateur WHERE mail=:mail');
$requete->bindValue(':mail', $mail);
$requete->execute();
$res = $requete->fetch(PDO::FETCH_NUM);

if($res){ // si la requête s'est bien passé
 // je compare le pass de la bdd hashé au pass fourni par l'utilisateur grace à password_verify
if(!password_verify($pass, $res[0])){    // si les mots de passes sont différents
    echo 'erreur dans le remplissage du mail ou du mot de passe';
}
else{
    
   
    session_start();  // si ok je demarre une session et intitialise les variables session de l'utilisateur
    $_SESSION['id'] = $res[1];
    $_SESSION['pseudo'] = $res[2];
    header('Location:http://localhost/Projet_bdd/index.php');

}
}
else{ // si la requête s'est mal passé
    echo 'compte inexistant';
}

// on ajoute une option de connexion automatique gràce aux cookies

