<?php
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/header.inc.php';
include_once 'pagination.php';
require_once 'libs/Smarty.class.php';


//requete sql permettant d'afficher les articles de la base de donnée trier du plus récent au plus vieux ainsi que d'indiquer une limite via des variables de la page pagination
$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date,'%d/%m/%Y')as date_fr FROM articles WHERE publie = :publie ORDER BY date DESC LIMIT $debut, $nbArticlesParPage ");

//sécurisation de :publie
$sth->bindValue(':publie', 1, PDO::PARAM_INT);

//exécution de la requete SQL
$sth->execute();

//on créer un tableau tab_articles récupérant les données de la requete SQL
$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="span8">
    <!-- contenu -->           
    <?php
    //boucle foreach permettant d'afficher les articles via les variables qui ont été récupérer dans un tableau
    foreach ($tab_articles as $value) {
        ?>  
        <h2> <?php echo $value['titre']; ?></h2> 

        <img src="img/<?php echo $value['id']; ?>.jpg" width="100px" alt="titre"/>

        <h6><p style="text-align: justify;"><?php echo $value['texte']; ?></p></h6>

        <p> <em>
                <u> Publié le :<?php echo $value['date_fr']; ?></u>
            </em>
        </p>

        <a href='commentaire.php?id=<?php echo $value['id'] ?>'>
            <input type="submit" accept="" name ="commentaire" value="commentaire" class="btn btn-small btn-info">
        </a>  

        <?php
        //si le cookie est égale a TRUE alors on affiche cette partie pour afficher les commentaires des articles
        //l'email n'est pas affiché pour raison de sécurité si une adresse email et réutilisé pour de la publicité ou autre
        if (isset($_COOKIE['sid']) == TRUE) {
            ?>      

            <a href='article.php?id=<?php echo $value['id'] ?>'>
                <input type="submit" accept="" name ="modifier" value="modifier" class="btn btn-small btn-info">
            </a>       
            <a href='suprimer.php?id=<?php echo $value['id'] ?>'>
                <input type="submit" name ="suprimer" value="suprimer" class="btn btn-small btn-info">
            </a>
            <?php
        }
    }
    ?>
    <!-- Créer une pagination --> 
    <!--Affichage de la pagination permettant la navigation sur les différentes pages (une page correspond à 2 articles) -->
    <!-- On affiche les variables de la page pagination pour affiché la page courante ainsi qu'une boucle permettant de récupérer le nombre de page par article-->
    <div class='pagination pagination-sm'>
        <ul>
            <li><a>Page : <?php echo $pageCourante; ?></a>
            </li>
            <li class="enable">
                <a href="#">
                    <i class="icon icon-caret-left"></i>
                </a>
            </li>
            <?php
            
            //Dans cette boucle on affiche la flèche de gauche permettant de naviguer sur les differents articles
            if ($pageCourante > 1) {
                ?> 

                <li><a href ="index.php?p=<?= $pageCourante - 1; ?>">&laquo;</a>
                </li>

                <?php
            }
            //boucle permettant de créer dynamiquement une pagination en fonction du nombre d'article à afficher

            for ($i = 1; $i <= $nbPages; $i++) {
                ?>
                <li class="active">
                    <a  href="index.php?p=<?= $i; ?>"><?= $i ?> </a>
                </li> 
                <?php
            }
            ?>

            <?php
            
            //Dans cette boucle on affiche la flèche de droite permettant de naviguer sur les differents articles
            if ($pageCourante < $nbPages) {
                ?>   

                <li class="active">
                    <a href ="index.php?p=<?= $pageCourante + 1; ?>">&raquo;</a>
                </li>

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
