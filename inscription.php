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
      <div id="container1">
          <form id="formulaire" method="post" action="verifinscription.php">
              
                  <legend id="titre1">Information personnelles</legend><br><br>
              <label for="pseudo" id="pseudolabel"> Choisis ton pseudo </label>
              <input type="text" name="pseudo" id="pseudo1" required><br><br>
              <label for="mail" id="maillabel"> Entre ton mail (identifiant) </label>
              <input type="mail" name="mail" id="mail1" required><br><br>
              <label for="mdp" id="mdplabel"> Choisis ton mot de passe </label>
              <input type="password" name="pass" id="pass1" required><br><br>
              <label for="mdp" id="mdp2label"> Confirme ton mot de passe </label>
              <input type="password" name="pass2" id="pass2" required><br><br>
              <input type="submit" value="Envoyer">
            
          </form>
          <div class="drop drop1"></div>
          <div class="drop drop2"></div>
          <div class="drop drop3"></div>
          
      </div>
      <script src="index.js"></script>
    </body>
</html>