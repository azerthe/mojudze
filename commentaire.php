<?php
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/header.inc.php';
session_start();


//récupération de l'id de l'article dans l'url
$id = $_GET['id'];

//$article_commentaire =$bdd->prepare("SELECT articles.id,articles.titre, articles.texte,articles.date,commentaires.id_articles,commentaires.speudo,commentaires.email,commentaires.texte FROM articles INNER JOIN commentaires WHERE articles.id=54");

//préparation de la requete SQL permettant d'afficher l'article ayant pour id celui envoyer via l'url
$article_commentaire = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date,'%d/%m/%Y')as date_fr FROM articles WHERE id='$id'");

//sécurisation de l'id
$article_commentaire->bindValue(':id', 1, PDO::PARAM_INT);

//exécution de la requete SQL
$article_commentaire->execute();

//récupération dans un tableau des informations de la requete SQL
$tab_article = $article_commentaire->fetchAll(PDO::FETCH_ASSOC);
$article_commentaire->closecursor();

//assignation des valeurs dans des variables
$titre = $tab_article [0]['titre'];
$id_image = $tab_article[0]['id'];
$texte = $tab_article[0]['texte'];
$date_fr = $tab_article[0]['date_fr'];
?>  

<!-- Affichage des commentaires -->
<div class="span8">
    <h2> <?php echo $titre; ?></h2> 

    <img src="img/<?php echo $id_image; ?>.jpg" width="100px" alt="titre"/>

    <h6><p style="text-align: justify;"><?php echo $texte; ?></p></h6>

    <p> <em><u> Publié le :<?php echo $date_fr; ?></u></em></p>



    <?php
    
    //requete recuperant les commentaires selon l'id de l'article
    $req = $bdd->query("SELECT  COUNT(*) as NbCommentaires FROM commentaires WHERE id_articles=$id");
    
    //on récupére dans un tableau les données de la requete SQL
    $donnees = $req->fetch();
    $req->closeCursor();
    ?>
    
    <!-- affiche le nombre de commentaire déja envoyés -->
    <p class="text-success">Il a <?php echo $donnees['NbCommentaires']; ?> commentaires sur cet article</p></br> 
    <?php
    
    //Gestion de l'insertion de commentaires
    //si le bouton post commentaire a été cliqué alors on exécute la suite du code
    if (isset($_POST['post_commentaire'])) {        
        //Si l'un des champs est vide on affiche un message d'erreur par un javascript
        if ($_POST['speudo'] == NULL || $_POST['post_commentaire'] == NULL) {
            ?>
            <!-- Affichage d'un message alert en javascript -->
            <script type="text/javascript">
                alert("Veuillez compléter tout les champs !");
            </script>
            <?php
        } else {

            //$création d'une variable permettant de récuperer la date au format "Y-m-d"
            $date_ajout = date("Y-m-d");
            
            //on passe la variable au $_POST['date'] pour envoyer une date correcte à la base de donnée
            $_POST['date'] = $date_ajout;
            
            //requete permettant de d'ajouter un commentaire dans la base de donnée
            $form_commentaire = $bdd->prepare("INSERT INTO commentaires (id_articles, speudo,email,texte, date) VALUES(:id, :speudo,:email, :texte,:date)");
            
            //Sécurisation des valeurs des variables qui vont être introduites dans la base.
            $form_commentaire->bindValue(':id', $id, PDO::PARAM_INT);
            $form_commentaire->bindValue(':speudo', $_POST['speudo'], PDO::PARAM_STR);
            $form_commentaire->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $form_commentaire->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
            $form_commentaire->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
            
            //on  exécute la commande SQL
            $form_commentaire->execute();

            //recharge la page commentaire.php en reprenant l'id de l'article que l'on commente
            header('Location: commentaire.php?id=' . $id);
        }
    }

    //Requête Sql ainsi que son exécution pour récupérer les commentaires qui sont en lien avec l'article selectionner en modifiant la date pour avoir un format utilisable en base de donnée
    $sth = $bdd->prepare('SELECT speudo, email, texte,DATE_FORMAT(date, \'%d/%m/%Y\') AS date_fr FROM commentaires WHERE id_articles = ? ORDER BY id ASC');
    $sth->execute(array($_GET['id']));

//boucle permettant l'affichage des commentaires tant qu'il y en a dans le tableau fetch
    while ($donnees = $sth->fetch()) {
        ?>
        <br>
        <p>
            <strong class="text-info"><?php echo htmlspecialchars($donnees['speudo']); ?>
            </strong> le <?php echo $donnees['date_fr']; ?>
        </p>
        <p>
            <?php echo nl2br(htmlspecialchars($donnees['texte'])); ?>
        </p>

        <?php
    }
    ?>

    <!-- redirection fonction de l'id pour afficher de nouveau le même article que celui que l'on commente -->
    <form action="commentaire.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" id="post_commentaire" name="commentaire"> 
        <div class="clearfix">
            <br><label for="speudo">Speudo:</label>
            <div class="input">
                <!-- envoi du prénom -->
                <input type="text" name="speudo" id="speudo" placeholder="Votre speudo">
            </div>   
        </div>
        <div class="clearfix">
            <br><label for="email">email:</label>
            <div class="input">
                <!-- envoi du prénom -->
                <input type="email" name="email" id="email" placeholder="email">
            </div>   
        </div>

        <div class="clearfix">
            <label for="texte">Commentaire</label>
            <div class="input">
                <!-- envoi du commentaire -->
                <textarea type="text" name="texte" id="texte" placeholder="Votre commentaire"> 
                </textarea>
            </div>   
        </div>

        <div class="clearfix">
            <div class="input">
                <!-- Champs caché utilisé pour affiché l'id de l'article (lorsque l'on recharge la page l'id transit dans l'URL) -->
                <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
            </div>  

            <div class="clearfix">
                <input type="submit" name="post_commentaire" value="Laisser un commentaire" class="btn btn-small btn-primary"><!-- bouton pour poster le commentaire -->
            </div>
        </div>
        </form>
</div>


<?php
include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';
?>
