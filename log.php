<?php
// cette page contient la verification des variables sessions et dans le cas ou elles existent pas des variables cookies


if(isset($_SESSION['id'])){

}

else if(isset($_COOKIE['mail'],$_COOKIE['password'])){
$cookpass = htmlspecialchars($_COOKIE['password']);
$cookmail = htmlspecialchars($_COOKIE['mail']);
    // si existent et correspondent avec bdd alors j'initialise les variables sessions
$pdo = New PDO('mysql:dbname=Projet_Bdd;host=localhost', 'root', '');

$requete= $pdo->prepare('SELECT :pass, id, pseudo FROM utilisateur WHERE mail=:mail'); // on tente de selectionner le pass du cookie ou le mail est celui du cookie
$requete->bindValue(':mail', $cookmail);
$requete->bindValue(':pass', $cookpass);
$requete->execute();
$res = $requete->fetch(PDO::FETCH_NUM);

    if($res){ // si la requête est bonne
        $_SESSION['id'] = $res[1];
        $_SESSION['pseudo'] = $res[2];
    }
}
else{
    header('Location: http://localhost/Projet_bdd/connexion.php');
}


