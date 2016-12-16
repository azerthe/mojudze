<?php
require_once 'settings/bdd.inc.php';        //permet la connection à la base de données
require_once 'settings/init.inc.php';       //permet l'affichage des erreurs
include_once 'includes/header.inc.php';     //renvoi à la page PHP incluant le headers
session_start();
?>

<div class="span8"> <!-- mise en page du formulaire par la grille Bootstrap-->

    <!-- Gestion des messages d'alerte de création de compte, d'erreur de connexion et de déconnexion-->
    <?php
    if (isset($_COOKIE['sid']) AND isset($_SESSION['connexion']) == False) {   //Si le cookie est présent et que la session connexion est valide --> on déconnecte
        ?>
        <div class="alert alert-error" role="alert">
            <strong>Déconnexion OK</strong> A une prochaine fois
        </div>
        <?php
        //destruction du cookie par utilisation d'un timelaps négatif
        setcookie('sid', time() - 3000);    
      
    }
    ?>

    <!-- Formulaire de connexion -->
    <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_article" name="connexion">

        <div class="clearfix">
            <label for="email">Email</label>
            <div class="email">
                <input type="email" name="email" id="email" placeholder="Votre Email">
            </div>
        </div>

        <div class="clearfix">
            <label for="mdp">Mot De Passe</label>
            <div class="input">
                <input type="password" name="mdp" id="mdp" placeholder="Votre Passe">
            </div>
        </div>

        <div class="clearfix">
            <input type="submit" name="connexion" value="connexion" class="btn btn-large btn-primary">
        </div>
        </br>
        <div>
            <p>Inscrivez vous <a href="Inscription.php">ici</a></p> <!-- Lien vers la page d'inscription -->
        </div> 

    </form>

</div>

<?php
//Vérifie que le bouton Envoyer a été cliqué
if (isset($_POST['connexion'])) {

    //on donne FALSE à la session ['connexion']
    $_SESSION['connexion'] = FALSE;
    
    //Si l'un des champs est vide on affiche un message d'erreur par un javascript
    if ($_POST['email'] == NULL || $_POST['mdp'] == NULL) {
        ?>
        <script type="text/javascript">
            alert("Veuillez compléter tout les champs !");
        </script>
        <?php
    } else {
        //recherche dans la base de donnée si un utilisateurs un utilisateur qui a un email et mdp correspondant à la recherche
        $connexion = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mdp = :mdp");
        
        //sécurise email et mdp
        $connexion->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
        $connexion->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        
        //Execute la requete
        $connexion->execute();
        
        //Compte le résultat d'une correspondance dans la base
        $count = $connexion->rowCount();
        
        //récuperer dans un tableau les données de la requête SQL
        $tab_connexion = $connexion->fetchAll(PDO::FETCH_ASSOC);

        //Vérification de l'email ainsi que du mot de passe 
        if ($_POST['email'] == $tab_connexion[0]['email'] && $_POST['mdp'] == $tab_connexion[0]['mdp']) {

            //création variable email récupéré dans notre base
            $email = $tab_connexion[0]['email'];
            
            // création d'une variable sid unique à partir du mail et utilisation de md5 pour crypter le SID
            $sid = md5(time() . $email);
            echo $sid;
            
            //on assigne une variable $id qui récupére la valeur id dans le tableau
            $id = $tab_connexion[0]['id'];
            
            //prépare une requete de mise à jour de la base
            $connexion = $bdd->prepare("UPDATE utilisateurs SET sid='$sid' WHERE id='$id'");
            $connexion->execute();
            
            //création d'un cookie d'une durée de vie de 5 minutes qui va prendre pour variable le $sid
            setcookie('sid', $sid, time() + 300);
            
            //redirige vers l'index
            header('Location: index.php');
            
            //la session prend la valeur TRUE
            $_SESSION('connexion') == True;
        } else {
            
        }
    }
}

include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';
?>