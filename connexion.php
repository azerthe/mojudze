<?php
require_once 'settings/bdd.inc.php';        //permet la connection à la base de données
require_once 'settings/init.inc.php';       //permet l'affichage des erreurs
include_once 'includes/header.inc.php';     //renvoi à la page PHP incluant le headers
?>

<div class="span8"> <!-- mise en page du formulaire par la grille Bootstrap-->
    
    <!-- Gestion des messages d'alerte de création de compte, d'erreur de connexion et de déconnexion-->
<?php
    if (isset($_COOKIE['sid']) == TRUE) {   //Si le cookie est présent et que la session connexion est valide --> on déconnecte
        ?>
        <div class="alert alert-error" role="alert">
            <strong>Déconnexion OK</strong> A une prochaine fois
        </div>
        <?php
        setcookie('sid', time() - 3000);    //destruction du cookie par utilisation d'un timelaps négatif
        $_SESSION['connexion'] = FALSE; //passage de la session en déconnexion
    }
    ?>
            
            
            

    <!-- Formulaire de connexion -->
    <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_article" name="connexion">

        <div class="clearfix">
            <label for="email">Email</label>
            <div class="email"><input type="email" name="email" id="email" placeholder="Votre Email"></div>
        </div>

        <div class="clearfix">
            <label for="mdp">Mot De Passe</label>
            <div class="input"><input type="password" name="mdp" id="mdp" placeholder="Votre Passe"></div>
        </div>

        <div class="clearfix">
            <input type="submit" name="connexion" value="connexion" class="btn btn-large btn-primary"></div>
        </br>
        <div><p>Inscrivez vous <a href="inscription.php">ici</a></p></div> <!-- Lien vers la page de création de compte -->

    </form>

</div>


<?php
//Controle de l'existance d'un compte avec les données saisies par l'utilisateur
if (isset($_POST['connexion']))  //Vérifie que le bouton Envoyer a été cliqué  
{       
    //Si l'un des champs est vide on affiche un message d'erreur par un javascript
    if($_POST['email'] == NULL || $_POST['mdp'] == NULL)
        {
        ?>
            <script type="text/javascript">
                    alert("Veuillez compléter tout les champs !");
            </script>
        <?php  
        }
    else 
        {
            //recherche dans la base de donnée si un utilisateurs un utilisateur qui a un email et mdp correspondant à la recherche
            $connexion = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mdp = :mdp");  
            $connexion->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);   //sécurise email et mdp
            $connexion->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $connexion->execute();  //Execute la requete
            $count = $connexion->rowCount();    //Compte le résultat d'une correspondance dans la base
            $tab_conex = $connexion->fetchAll(PDO::FETCH_ASSOC);
            

    
    
            //Vérification de l'email ainsi que du mot de passe 
            if ($_POST['email'] == $tab_conex[0]['email'] && $_POST['mdp'] == $tab_conex[0]['mdp'])
                {  
                
                    //vérifie la correspondance d'un mail et d'un mdp dans notre base
                    $email = $tab_conex[0]['email'];    //création variable email récupéré dans notre base
                    $sid = md5(time() . $email);    // création d'une variable sid unique à partir du mail et du temps par la fonction php md5
                    echo $sid;
                    $id = $tab_conex[0]['id'];
                    $connexion = $bdd->prepare("UPDATE utilisateurs SET sid='$sid' WHERE id='$id'");    //prépare une requete de mise à jour de la base
                    $connexion->execute();
                    setcookie('sid', $sid, time() + 1800);  //création d'un cookie d'une durée de vie de 30 minutes
                    header('Location: index.php');  //redirige vers l'index

                }
            else
                {
                    header('Location: connexion.php');  //redirige vers la page connexion
                }
        }
}

include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';

?>