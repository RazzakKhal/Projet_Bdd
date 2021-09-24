<?php 
require_once('utilisateur.php');
$utilisateur= New utilisateur();
// on recupere mail et mot de passe

$utilisateur->mail = htmlspecialchars($_POST['mail']); // ajout evitement faille XSS avec htmlspecialchars
$utilisateur->pass = htmlspecialchars($_POST['pass']);   
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



// on les compare aux mail et pass de la bdd

$pdo = New PDO("mysql:dbname=$database;host=$hostname", $username, $password);

$requete= $pdo->prepare('SELECT pass, id, pseudo FROM utilisateur WHERE mail=:mail');
$requete->bindValue(':mail', $utilisateur->mail);
$requete->execute();
$res = $requete->fetch(PDO::FETCH_NUM);

if($res){ // si la requête s'est bien passé
 
    // je compare le pass de la bdd hashé au pass fourni par l'utilisateur grace à password_verify
if(!password_verify($utilisateur->pass, $res[0])){    // si les mots de passes sont différents
    echo 'erreur dans le remplissage du mail ou du mot de passe';
}
else{
    
   
    session_start();  // si ok je demarre une session et intitialise les variables session de l'utilisateur
    $_SESSION['id'] = $res[1];
    $_SESSION['pseudo'] = $res[2];
   
    // Si post souvenir existe on créer cookie avec un uniqid qu'on hash avec une clé secrète

if(isset($_POST['souvenir'])){
    $uniqid2 = uniqid();
    $utilisateur->uniqid = sha1($uniqid2);
    $utilisateur->id = $res[1];
    $utilisateur->ip = $_SERVER['REMOTE_ADDR'];
 
   // en parallèle j'ajoute l'uniqid crée dans ma base de donnée et l'adresse ip de l'utilisateur
    $requete2= $pdo->prepare('UPDATE utilisateur SET uniqid=:uniqid2, adresse_ip=:ip WHERE mail=:mail2');
    $requete2->bindValue(':uniqid2', $utilisateur->uniqid);
    $requete2->bindValue(':mail2', $utilisateur->mail);
    $requete2->bindValue(':ip', $utilisateur->ip);
    $requete2->execute();


     // on creer les cookies souvenir et pseudo
     setcookie('souvenir', 'b6tg3frt54bbd' . $utilisateur->uniqid . 'tp43c', time() + 86400*30*12, '/', $domainecookie, false, true);
     setcookie('id', $utilisateur->id, time() + 86400*30*12, '/', $domainecookie, false, true);
    
}
     
     header('Location: http://projetbdd1.herokuapp.com/index.php');

}
}
else{ // si la requête s'est mal passé
    echo 'compte inexistant';
    
}



