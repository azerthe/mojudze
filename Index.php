<?php
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/header.inc.php';
// j'inclue ma pagination
include_once 'pagination.php';
require_once 'libs/Smarty.class.php';




$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date,'%d/%m/%Y')as date_fr FROM articles WHERE publie = :publie LIMIT $debut, $nbArticlesParPage");
$sth->bindValue(':publie', 1, PDO::PARAM_INT);
$sth->execute();
//toujours utiliser le fectAll pour retourner toute la ligne d'une case
//fetch retourne un tableau avec assoc
$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);



?>


<div class="span8">
    <!-- notifications -->

    <!-- contenu -->           
<?php
///lire et afficher un tableau et permet de monter d'un niveau
//boucle foreach
//as alias
// /!\ Voir condition active
foreach ($tab_articles as $value) {
    ?>  
        <h2> <?php echo $value['titre']; ?></h2> 

        <img src="img/<?php echo $value['id']; ?>.jpg" width="100px" alt="titre"/>

        <h6><p style="text-align: justify;"><?php echo $value['texte']; ?></p></h6>

        <p> <em><u> Publié le :<?php echo $value['date_fr']; ?></u></em></p>
        
            <a href='commentaire.php?id=<?php echo $value['id']?>'><input type="submit" 
            accept="" name ="commentaire" value="commentaire" class="btn btn-small btn-info">
            </a>  

        
        <?php
        if(isset($_COOKIE['sid'])==TRUE)
            {
        ?>
            <a href='article.php'><input type="submit" 
                                         accept=""name ="ajouter" value="ajouter" class="btn btn-small btn-info">
            </a>
        
            <a href='article.php?id=<?php echo $value['id']?>'><input type="submit" 
            accept="" name ="modifier" value="modifier" class="btn btn-small btn-info">
            </a>       
            <a href='suprimer.php?id=<?php echo $value['id']?>'><input type="submit" 
            name ="suprimer" value="suprimer" class="btn btn-small btn-info">
            </a>   
    <?php
            }
}
?>
        <!-- Créer une pagination --> 
    <div class='pagination'>
        <ul>
            <li><a>Page : </a></li>
            <li class="disabled"><a href="#"><i class="icon icon-caret-left"></i></a></li>
<?php
for ($i = 1; $i <= $nbPages; $i++) { //commence à 1 
    ?>
            
                <li><a href="index.php?p=<?= $i; ?>"><?= $i ?> </a></li> 
                
        <?php
    }
    ?>
        </ul>
    </div>  

</div>


<?php
include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';
?>
