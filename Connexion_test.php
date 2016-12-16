<?php
require_once 'settings/bdd.inc.php';        //permet la connection à la base de données
require_once 'settings/init.inc.php';       //permet l'affichage des erreurs
include_once 'includes/header.inc.php';     //renvoi à la page PHP incluant le headers


if (isset($_POST['envoyer'])) {          //Vérifie que le bouton Envoyer a été cliqué
    
    $connexion = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mdp = :mdp");  //prépare la requete de comparaison dans la base 
    $connexion->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);                                  //sécurise email et mdp
    $connexion->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $connexion->execute();          //Execute la requete
    $count = $connexion->rowCount();    //Compte le résultat d'une correspondance dans la base
    $tab_connexion = $connexion->fetchAll(PDO::FETCH_ASSOC);
    
    if ($_POST['email'] == $tab_connexion[0]['email'] && $_POST['mdp'] == $tab_connexion[0]['mdp']) {    //vérifie la correspondance d'un mail et d'un mdp dans notre base
        $email = $tab_connexion[0]['email'];          //création variable email récupéré dans notre base
        $sid = md5(time().$email);            // création d'une variable sid unique à partir du mail et du temps par la fonction php md5
      

$id = $tab_connexion[0]['id'];
        $connexion = $bdd->prepare("UPDATE utilisateurs SET sid='$sid' WHERE id='$id'");  //prépare une requete de mise à jour de la base
        $connexion->execute();
        setcookie('sid', $sid, time() + 90); //création d'un cookie d'une durée de vie de 30 secondes
        header('Location: index.php');      //redirige vers l'index
        $_SESSION['connexion'] = TRUE;
    } 
else 
    {
        ?>
         <div class="alert alert-danger" role="alert">
            <strong> Erreur </strong>Mauvais Identifiants!
        </div>
        <?php
       header('refresh:3;connexion.php');        //redirige vers la page connexions
        
    }
}
?>
<div class="span8">                                 <!-- mise en page du formulaire par la grille Bootstrap-->
    
    <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_article" name="connexion">  <!-- Appel un formulaire pour créer se connecter-->

        <div class="clearfix">
            <label for="email">Email</label>
            <div class="email"><input type="email" name="email" id="email" value="Votre Email"></div>
        </div>

        <div class="clearfix">
            <label for="mdp">Mot De Passe</label>
            <div class="input"><input type="password" name="mdp" id="mdp" value="Votre Passe"></div>
        </div>

        <div class="clearfix">
            <input type="submit" name="envoyer" value="Envoyer" class="btn btn-large btn-primary"></div>
            

    </form>

</div>
<?php
include_once 'includes/footer.inc.php';

?>