<?php

// le but est que si l'uniqid est récup en base de données, si on le copie colle on ne puisse pas acceder à la session
//si l'uniqid hashé est copié dans le navigateur, l'utilisateur meme malveillant pourra accéder à la session de l'utilisateur,
// pour restreindre cela on utilisera une vérification de l'adresse IP

// si une session existe alors rien ne se passe, si aucune session existe mais le cookie souvenir existe alors on compare

if(isset($_SESSION['pseudo'])){

}
else if(isset($_COOKIE['souvenir'])){
    // je stock dans mes variables l'id et le cookie souvenir du client qui est sur ma page
    $idcompar = $_COOKIE['id'];
    $souvenircompar = $_COOKIE['souvenir'];

    $pdo = New PDO('mysql:dbname=Projet_Bdd;host=localhost', 'root', '');
    // je récupère l'uniqid dans ma bdd qui correspond à l'id que le client me présente
    $requete= $pdo->prepare('SELECT uniqid, pseudo, id, adresse_ip FROM utilisateur WHERE id=:id');
    $requete->bindValue(':id', $idcompar, PDO::PARAM_INT);
    $requete->execute();
    $res = $requete->fetch(PDO::FETCH_NUM);
    // AJOUTER LA COMPARAISON DE LIP DANS LE IF DU DESSOUS
    if(!$res){ // si ca renvoi false c'est que j'ai un problème avec le cookie id donc dans le doute je detruit les cookies
        setcookie('souvenir', '', time() - 60, '/', 'localhost', false, true);
        setcookie('id', '', time() - 60, '/', 'localhost', false, true);
        header('Location:https://localhost/Projet_bdd/connexion.php');
    }
    else{
        $protection1 = 'b6tg3frt54bbd'; // ce que j'ai ajouté devant l'uniqid envoyé dans le cookie souvenir
        $protection2 = 'tp43c'; // ce que j'ai ajouté derrière l'uniqid envoyé dans le cookie souvenir
        $uniqid2 = explode($protection1, $souvenircompar); 
        $uniqid3 = explode($protection2, $uniqid2[1]);
        $ip = $_SERVER['REMOTE_ADDR']; // récup l'ip du visiteur
        
        if($uniqid3[0] === $res[0] && $ip === $res[3]){ // si l'uniqid et l'ip récupérés correspondent à ceux de la bdd
        
            $_SESSION['pseudo'] = $res[1];
            $_SESSION['id'] = $res[2];

            // la reconnexion à la session est réussie
        }
        else{
            // les uniqid ne correspondent pas je detruit les cookies coté client et BDD vu que je connais l'id enregistré coté client
            
            $requete= $pdo->prepare('UPDATE utilisateur SET uniqid=:uniqid WHERE id=:id');
            $requete->bindValue(':id', $idcompar, PDO::PARAM_INT);
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
// le cookie avec l'uniqid en bdd, si c'est ok et que l'ip est la même on refait des variables session.
// si ni session ni cookie alors go se connecter