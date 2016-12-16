<?php
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/header.inc.php';
// j'inclue ma pagination
include_once 'pagination.php';


//variable qui va contenir
//la requete sql va etre dans prepare
//préparation de la requete
//$sth = $bdd->prepare('SELECT * FROM articles WHERE publie = :publie;');
//modification de la requete pour avoir une date au format francais
$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date,'%d/%m/%Y')as date_fr FROM articles WHERE publie = :publie LIMIT $debut, $nbArticlesParPage");

//$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date,'%d/%m/%Y')as date_fr FROM articles WHERE publie = :publie LIMIT $index, $articlesParPage");
//associez une valeur à :publie
$sth->bindValue(':publie', 1, PDO::PARAM_INT);
//bindvalue sécurisation des donnnées (requiert 3 parametre)
// la relation :publie,la valeur qui va servir à remplacer ce pointeur, 
// pdo::PARAM sécurisation de type numérique ou caractere, dans le cas présent numérique
//exécution de la requete pour envoyer la requete SQL
$sth->execute();


//toujours utiliser le fectAll pour retourner toute la ligne d'une case
//fetch retourne un tableau avec assoc
$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);

//$dernier_id = $sth->lastInsertId();  donne le derniere ID inserer
//affichage 
//print_r($tab_articles);
?>


<div class="span8">
    <!-- notifications -->

    <!-- contenu -->           

///lire et afficher un tableau et permet de monter d'un niveau
//boucle foreach
//as alias
// /!\ Voir condition active
foreach ($tab_articles as $value) {
 
        <h2> <?php echo $value['titre']; ?></h2> 

        <img src="img/<?php echo $value['id']; ?>.jpg" width="100px" alt="titre"/>

        <h6><p style="text-align: justify;"><?php echo $value['texte']; ?></p></h6>

        <p> <em><u> Publié le :<?php echo $value['date_fr']; ?></u></em></p>

        
            <a href='article.php?id=<?php echo $value['id'] ?>'><input type="submit" 
            name ="modifier" value="modifier" class="btn btn-small btn-info">
            </a>
   
        <!-- Créer une pagination --> 
    <div class='pagination'>
        <ul>
            <li><a>Page : </a></li>

for ($i = 1; $i <= $nbPages; $i++) { //commence à 1 

                <li><a href="index.php?p=<?= $i; ?>"><?= $i ?></a></li> 
        <?php
    }
  
        </ul>
    </div>  

</div>



include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';

