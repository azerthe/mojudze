<?php
// Base de donnée
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/header.inc.php';


//si le bouton s'inscrire est appuyé alors on rentre dans la boucle
if (isset($_POST['forminscription'])) {

    
    //création de variable correspondant à chaque champs du formulaire (on récupére les champs qui ont été posté)
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $email2 = htmlspecialchars($_POST['email2']);
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];

    //si un des champs n'est pas remplie alors on affiche une erreur
    if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['email2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
        
        //on creer une variable permettant de savoir la longuer du prenom rentrer
        $prenom_longueur = strlen($prenom);
        
        //si le prenom est trop grand on affiche un message d'erreur
        if ($prenom_longueur <= 20) {
            
            //on vérifie que email et email2 sont identique 
            if ($email == $email2) {
                
                //on regarde si le mail donner et au format désiré
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    
                    //on prepare la requete permettant de voir si l'email est déja utilisé
                    $reqmail = $bdd->prepare("SELECT * FROM membres WHERE email = ?");
                    $reqmail->execute(array($email));
                    
                    //on compte le nombre de résultat 
                    $mailexist = $reqmail->rowCount();
                    
                    //si il n'y a pas de mail déja utilisé alors on passe a la suite
                    if ($mailexist == 0) {
                        
                        //on vérifie que le mdp et mdp2 correspondent
                        if ($mdp == $mdp2) {
                            
                            //on prépare la requete permettant de d'inscrire un nouvelle utilisateur à notre base de donnée
                            $insertmbr = $bdd->prepare("INSERT INTO utilisateurs( prenom,nom,email,mdp,sid) VALUES(?, ?, ?, ?,0)");
                            $insertmbr->execute(array($prenom, $nom, $email, $mdp));
                            $erreur = "Votre compte a bien été créé ! <a href=\"index.php\">Me connecter</a>";
                        } else {
                            $erreur = "Vos mots de passes ne correspondent pas !";
                        }
                    } else {
                        $erreur = "Adresse mail déjà utilisée !";
                    }
                } else {
                    $erreur = "Votre adresse mail n'est pas valide !";
                }
            } else {
                $erreur = "Vos adresses mail ne correspondent pas !";
            }
        } else {
            $erreur = "Votre Nom ou Prenom ne doit pas dépasser 20 caractères !";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}
?>
 <!-- Affichage du formulaire d'inscription-->
<div class="span8">
    <div align="center">
        <h2>Inscription</h2>
        <br /><br />
        <form method="POST" action="">
            <table> 
                <!-- Affichage du formulaire d'inscription-->
                <tr>   
                    <td align="right">
                        <label for="nom">Nom:</label>
                    </td>
                    <td>
                        <input type="text" placeholder="nom" id="prenom" name="nom" value="<?php if (isset($nom)) {echo $nom;} ?>" />
                    </td>    
                </tr>

                <tr>
                    <td align="right">
                        <label for="pseudo">Prenom:</label>
                    </td>
                    <td>
                        <input type="text" placeholder="prenom" id="prenom" name="prenom" value="<?php if (isset($prenom)) {echo $prenom;} ?>" />
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <label for="email">Email :</label>
                    </td>
                    <td>
                        <input type="email" placeholder="Votre email" id="mail" name="email" value="<?php if (isset($email)) {echo $email;} ?>" />
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <label for="email2">Confirmation de l'Email :</label>
                    </td>
                    <td>
                        <input type="email" placeholder="Confirmez votre email" id="mail2" name="email2" value="<?php if (isset($email2)) {echo $email2;} ?>" />
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <label for="mdp">Mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" Value="<?php if (isset($mdp)) {echo $mdp;} ?>"/>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <label for="mdp2">Confirmation du mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" Value="<?php if (isset($mdp2)) {echo $mdp2;} ?>" />
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td align="center">
                        <br />
                        <input type="submit" name="forminscription" value="Je m'inscris" />
                    </td>
                </tr>
            </table>
        </form>
<?php

//Si il y a une erreur on affiche l'erreur correspondant dans la boucle ci-dessus
if (isset($erreur)) {
    echo '<font color="red">' . $erreur . "</font>";
}
?>
    </div>
</div>
 
<?php
include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';
?>
