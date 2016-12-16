<?php
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/header.inc.php';

// Moteur de recherche (version fonctionnelle non optimisé)
// $recherche est fourni par le formulaire
// Le formulaire:
?> 
 <?php
      
?>
<form method="POST" action=""> 
    <div class="span8">
    Rechercher un mot : 
    <input type="text" name="recherche">
    <input type="SUBMIT" value="Recherche"> 
    </div>
    
    <?php include_once 'includes/menu.inc.php';?>
    
</form>

<?php 
if (!empty($_POST['recherche'])) {

    // Récupère la variable
    $recherche = isset($_POST['recherche']) ? $_POST['recherche'] : '';

    //prépartion de la requete SQL puis lancement de celle ci
    $sth = $bdd->prepare(
            "SELECT titre, texte FROM articles WHERE titre LIKE '%$recherche%'
    OR texte LIKE '%$recherche%'");
    $sth->execute();


    //boucle pour l'affichage des articles
    foreach ($sth as $value) {
        ?>  <div class="span8">
            <h2> <?php echo $value['titre']; ?></h2> 
            <h6><p style="text-align: justify;"><?php echo $value['texte']; ?></p></h6>
        </div>
        <?php
      
    }
}

  
?>