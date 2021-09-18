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
        header('Location:https://localhost/Projet_bdd/index.php');
       }
      ?>
      <div>
          <form id="formulaire" method="post" action="verifconnexion.php">
              <fieldset>
                  <legend>Information personnelles</legend><br><br>
              <label for="mail"> Entre ton mail (identifiant) </label>
              <input type="mail" name="mail" id="mail" required><br><br>
              <label for="pass"> Entre ton mot de passe </label>
              <input type="password" name="pass" id="pass" required><br><br>
              <label for="souvenir">Se souvenir de moi</label>
              <input type="checkbox" name="souvenir" id="souvenir">
              <input type="submit" value="Envoyer">
            </fieldset>
          </form>
          <a href='inscription.php'>S'inscrire</a>

      </div>
      <script src="index.js"></script>
    </body>
</html>