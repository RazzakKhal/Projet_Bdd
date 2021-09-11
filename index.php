<!DOCTYPE html>
<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scalre=1.0">
      <meta charset="utf-8">
      <link href="index.css" rel="stylesheet">
      <title>Projet 1 Back-end</title>
      <meta name="description" content="Mon premier projet perso Back-end, le but est d'apprendre à créer une interface de connexion et d'inscriton reliée à une BDD">
    </head>
    <body>
      <?php 
      session_start();
      if(isset($_SESSION['id'])){
        $pseudo = $_SESSION['pseudo'];
        echo 'Bienvenue ' . $pseudo;
      ?> 
      <a id="deco" href="deconnexion.php"> Deconnexion </a> 
      <?php    // le boutton deconnexion n'apparait que si j'ai pu me connecter
      }
      else{
        echo 'vous devez vous connecter ou vous inscrire';
      ?>
      <a id="co" href="connexion.php"> Connexion </a>
      <a id="inscri" href="inscription.php"> Inscription </a>
      <?php // le boutton connexion apparait uniquement si je suis déconnecté
      }
    
      ?>
      
      <script src="index.js"></script>
    </body>
</html>