<?php
require_once 'settings/bdd.inc.php'; //
require_once 'settings/init.inc.php'; //Affiche une page en cas d'erreur
include_once 'includes/header.inc.php';//header de la page

// Préparation de la requete
$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date, '%d/%m/%Y') 
    as date_fr FROM articles WHERE publie = :publie;");
 
// Sécurisation de la variable
$sth->bindValue(':publie', 1, PDO::PARAM_INT);

//Execution de la requete
$sth->execute();

//$dernier_id = $sth->LastInsertId(); // retourner id qui vient d etre inserer

//Retourne un tableau
$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
        
// débloque un tableau et affiche le contenu 
//print_r($tab_articles);



?>
<div class="span8">
    <!-- notifications -->
<div class="alert alert-warning alert-dismissible" role="alert">
 
  <strong>Felicitations!</strong> Votre article a ete ajouté
</div>
    <!-- contenu -->

            <?php 
            foreach ($tab_articles as $value){
                ?>

    <h2><?php echo $value['titre'] ?>; </h2>
    <img src="img/<?php echo $value['id'] ?>.jpg" width="100px" alt="<?php echo $value['titre']; ?>"/>
    <p style="text-align: justify;"><?php echo $value['texte']; ?></p>
    <p><em><u> Publié le <?php echo $value['date_fr'];  ?></u></em></p>


<?php
}
            
           
            echo "hello world!"; ?>

</div>
<?php
include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';
?>
        



