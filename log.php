<?php
require_once('utilisateur.php');
$utilisateur= New Utilisateur();
// le but est que si l'uniqid est récup en base de données, si on le copie colle on ne puisse pas acceder à la session
//si l'uniqid hashé est copié dans le navigateur, l'utilisateur meme malveillant pourra accéder à la session de l'utilisateur,
// pour restreindre cela on utilisera une vérification de l'adresse utilisateur->ip

// si une session existe alors rien ne se passe, si aucune session existe mais le cookie souvenir existe alors on compare

if(isset($_SESSION['pseudo'])){

}
else if(isset($_COOKIE['souvenir'])){
    // je stock dans mes variables l'id et le cookie souvenir du client qui est sur ma page
    $utilisateur->id = $_COOKIE['id'];
    $utilisateur->cookie = $_COOKIE['souvenir'];

    $pdo = New PDO('mysql:dbname=Projet_Bdd;host=localhost', 'root', '');
    // je récupère l'uniqid dans ma bdd qui correspond à l'id que le client me présente
    $requete= $pdo->prepare('SELECT uniqid, pseudo, id, adresse_ip FROM utilisateur WHERE id=:id');
    $requete->bindValue(':id', $utilisateur->id, PDO::PARAM_INT);
    $requete->execute();
    $res = $requete->fetch(PDO::FETCH_NUM);
    // AJOUTER LA COMPARAISON DE Lutilisateur->ip DANS LE IF DU DESSOUS
    if(!$res){ // si ca renvoi false c'est que j'ai un problème avec le cookie id donc dans le doute je detruit les cookies
        setcookie('souvenir', '', time() - 60, '/', 'localhost', false, true);
        setcookie('id', '', time() - 60, '/', 'localhost', false, true);
        header('Location:https://localhost/Projet_bdd/connexion.php');
    }
    else{
        $protection1 = 'b6tg3frt54bbd'; // ce que j'ai ajouté devant l'uniqid envoyé dans le cookie souvenir
        $protection2 = 'tp43c'; // ce que j'ai ajouté derrière l'uniqid envoyé dans le cookie souvenir
        $uniqid2 = explode($protection1, $utilisateur->cookie); 
        $uniqid = explode($protection2, $uniqid2[1]);
        $utilisateur->ip = $_SERVER['REMOTE_ADDR']; // récup l'utilisateur->ip du visiteur
        
        if($uniqid[0] === $res[0] && $utilisateur->ip === $res[3]){ // si l'uniqid et l'utilisateur->ip récupérés correspondent à ceux de la bdd
        
            $_SESSION['pseudo'] = $res[1];
            $_SESSION['id'] = $res[2];

            // la reconnexion à la session est réussie
        }
        else{
            // les uniqid ne correspondent pas je detruit les cookies coté client et BDD vu que je connais l'id enregistré coté client
            
            $requete= $pdo->prepare('UPDATE utilisateur SET uniqid=:uniqid WHERE id=:id');
            $requete->bindValue(':id', $utilisateur->id, PDO::PARAM_INT);
            $requete->bindValue(':uniqid', NULL);
            $requete->execute();
            setcookie('souvenir', '', time() - 60, '/', 'localhost', false, true);
            setcookie('id', '', time() - 60, '/', 'localhost', false, true);
            header('Location:https://localhost/Projet_bdd/connexion.php');
            
        }
    }


}
else{
    header('Location:https://localhost/Projet_bdd/connexion.php');
}
// le cookie avec l'uniqid en bdd, si c'est ok et que l'utilisateur->ip est la même on refait des variables session.
// si ni session ni cookie alors go se connecter