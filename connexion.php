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
       if(isset($_SESSION['pseudo']) || isset($_COOKIE['souvenir'])){   // si j'ai une session ou un cookie je vais direct sur index
        header('Location: http://projetbdd1.herokuapp.com/index.php');
       }
      ?>
      <div id="container">
          <form id="formulaire2" method="post" action="verifconnexion.php">
              <legend id="titre">Se connecter</legend><br>

              <label for="mail"> Identifiant </label>
              <input type="mail" name="mail" id="mail" placeholder="Entre ton mail" required><br><br>
              <label for="pass"> Mot de passe </label>
              <input type="password" name="pass" id="pass" placeholder="Entre ton mot de passe" required><br><br>
              <label id="souvenir" for="souvenir">Se souvenir de moi</label>
              <input type="checkbox" name="souvenir" id="souvenir">
              <input type="submit" value="Envoyer">
         
          </form>
          <a id="inscri" href="inscription.php">S'inscrire</a>
          <div class="drop drop1"></div>
          <div class="drop drop2"></div>
          <div class="drop drop3"></div>
          <div class="drop drop4"></div>
        

      </div>
      
      
      <script src="index.js"></script>
    </body>
</html>