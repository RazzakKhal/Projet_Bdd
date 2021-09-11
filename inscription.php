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
      <div>
          <form id="formulaire" method="post" action="verifinscription.php">
              <fieldset>
                  <legend>Information personnelles</legend><br><br>
              <label for="pseudo"> Choisis ton pseudo </label>
              <input type="text" name="pseudo" id="pseudo" required><br><br>
              <label for="mail"> Entre ton mail (identifiant) </label>
              <input type="mail" name="mail" id="mail" required><br><br>
              <label for="mdp"> Choisis ton mot de passe </label>
              <input type="password" name="pass" id="pass" required><br><br>
              <label for="mdp"> Confirme ton mot de passe </label>
              <input type="password" name="pass2" id="pass2" required><br><br>
              <input type="submit" value="Envoyer">
            </fieldset>
          </form>

      </div>
      <script src="index.js"></script>
    </body>
</html>