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
      require_once('log.php');
      require_once('utilisateur.php');
      $utilisateur = New utilisateur();
      $utilisateur->pseudo = $_SESSION['pseudo'];
      $utilisateur->callpseudo();
      
      ?>
      <a id="deco" href="deconnexion.php"> Deconnexion </a> 
      <script src="index.js"></script>
    </body>
</html>