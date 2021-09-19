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
   
    // Si post souvenir existe on créer cookie avec un uniqid qu'on hash avec une clé secrète

if(isset($_POST['souvenir'])){
    $uniqid = uniqid();
    $uniqid2 = sha1($uniqid);
    $id = $res[1];
    $ip = $_SERVER['REMOTE_ADDR'];
 
   // en parallèle j'ajoute l'uniqid crée dans ma base de donnée et l'adresse ip de l'utilisateur
    $requete2= $pdo->prepare('UPDATE utilisateur SET uniqid=:uniqid2, adresse_ip=:ip WHERE mail=:mail2');
    $requete2->bindValue(':uniqid2', $uniqid2);
    $requete2->bindValue(':mail2', $mail);
    $requete2->bindValue(':ip', $ip);
    $requete2->execute();


     // on creer les cookies souvenir et pseudo
     setcookie('souvenir', 'b6tg3frt54bbd' . $uniqid2 . 'tp43c', time() + 86400, '/', 'localhost', false, true);
     setcookie('id', $id, time() + 86400, '/', 'localhost', false, true);
    
}
    header('Location: https://localhost/Projet_bdd/index.php');

}
}
else{ // si la requête s'est mal passé
    echo 'compte inexistant';
    
}



