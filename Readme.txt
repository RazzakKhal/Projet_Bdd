
Ceci est mon 'plan' qui m'a permis de ne pas me perdre lors du projet.





-1ère etape : Creation de la table User
On va avoir : un id, un pseudo, un mail, un pass, une date d’inscription

Le mot de passe devra être hash

-2ème etape : Creation des pages inscription, connexion, deconnexion

Inscription : devra contenir les info de la table user, il faudra aussi demander à confirmer le mot de passe au cas ou erreur de frappe.
-vérif si le pseudo est libre
-verif si les 2 mdp sont identiques
-vérif format de l’email

Connexion : on demandera l’email et le mot de passe et on propose une option connexion automatique

-récupère mdp transmis en bdd et compare avec celui transmis grace à password_verify
-si c’est good on crée une session et les variables sessions de l’utilisateur
-on pourra mettre sur chaque page si ces variables existent alors on personnalise pour l’utilisateur
-Pour la connexion automatique on stock dans des cookies le nom d’utilisateur et le mot de passé hashé

Deconnexion : la page de deco devra simplement utiliser session_destroy() pour deconnecter l’utilisateur

3ème étape : ajout de la sécurité anti injection SQL et attaque XSS
