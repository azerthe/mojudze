



<?php
require_once('libs/Smarty.class.php');


//création d'un objet smarty d'une class Smarty
$smarty = new Smarty();


//chemin relatif au serveur web  repertoire ou vont être mis les repertoire template
$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');


$name= "gaetan";

 if (isset($_SESSION['statut_connexion'])){
$smarty->assign('statut_connexion',$_SESSION['statut_connexion']);

}
?>








<div class="span8">     
     
     
//Message pour avertir l'utilisateur que le fichier à bien etait envoyé
    if (isset($_SESSION['statut_connexion'])AND $_SESSION['statue_connexion']== FALSE)
     
    {* ceci est un commentaire smarty*}
    
        {if isset($statut_connexion) AND $statut_connexion == FALSE {
        <div class="alert-success" role="alert">
       
            <strong>Erreur</strong> Login et /ou mot de passe faux.
        </div>
       
        unset($_SESSION['statut_connexion']);
        }
 
     
     <!-- else 
     
     //création d'un objet smarty d'une class Smarty
$smarty = new Smarty();


//chemin relatif au serveur web  repertoire ou vont être mis les repertoire template
$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');

    <!-- Formulaire pour créer les articles -->
   
    
    <form action ="test.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article">
        
        
        
        <div class="clearfix">
            <label for ="email">email</label>
            <div class="input"><input type="text" name ="email" id="titre" value="email"></div> 
        </div>


        <div class="clearfix">
            <label for ="mdp">mdp</label>
            <div class="input"><textarea type="texte" name ="mdp"id="" value="$mdp "></textarea> 
            </div>
  
                        <!-- Créer Un bouton Ajouter -->
            <<div class="form-actions"> <!-- Bonton de modification ou d'ajout d'information dans la base de donnée -->
                <input type="submit" name ="ajouter" value="connexion" class="btn btn-large btn-primary">
            </div> 
        </div>
    </form>
</div>
