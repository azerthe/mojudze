<?php
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';
include_once 'includes/header.inc.php';



//récupération de l'id de l'article dans l'url
$id = $_GET['id'];

//préparation de la requete SQL permettant d'afficher l'article ayant pour id celui envoyer via l'url
$article_commentaire = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date,'%d/%m/%Y')as date_fr FROM articles WHERE id='$id'");
$article_commentaire->bindValue(':id', 1, PDO::PARAM_INT);
$article_commentaire->execute();

//récupération dans un tableau des informations de la requete SQL
$tab_article = $article_commentaire->fetchAll(PDO::FETCH_ASSOC);
$article_commentaire->closecursor();

//assignation des valeurs dans des variables
$titre =$tab_article [0]['titre'];
$id_image =$tab_article[0]['id'];
$texte =$tab_article[0]['texte'];
$date_fr =$tab_article[0]['date_fr'];






?>  
<div class="span8">
        <h2> <?php echo $titre; ?></h2> 

        <img src="img/<?php echo $id_image; ?>.jpg" width="100px" alt="titre"/>

        <h6><p style="text-align: justify;"><?php echo $texte; ?></p></h6>

        <p> <em><u> Publié le :<?php echo $date_fr; ?></u></em></p>



<?php
 $req = $bdd->query("SELECT  COUNT(*) as NbCommentaires FROM commentaires WHERE id_articles=$id"); //requete recuperant les commentaires selon l'id de l'article
        $donnees = $req->fetch();
        $req->closeCursor();
        ?>
            <p class="text-success">Il a <?php echo $donnees['NbCommentaires']; ?> commentaires sur cet article</p></br> <!-- affiche le nombre de comm' déja envoyés -->
            <?php

//Gestion de l'insertion de commentaires
if (isset($_POST['post_commentaire'])) {    //Vérifie si le bouton post relatif au commentaire a été cliqué
    
    
    //Si l'un des champs est vide on affiche un message d'erreur par un javascript
    if($_POST['speudo'] == NULL || $_POST['commentaire'] == NULL){?>
            <script type="text/javascript">
                    alert("Veuillez compléter tout les champs !");
                </script>
        <?php
        
    }else{
    
    //Sinon on insert le commentaire
    $date_commentaire = date("Y-m-d");  //fonction affichant la date
    $sql_modifier = $bdd->prepare("INSERT INTO commentaires (id_article, speudo, commentaire, date) VALUES(:id_article, :speudo, :commentaire, $date_commentaire)");   //préparation de la requete d'insertion du commentaire avec les champs du formulaire commentaire
    $sql_modifier->bindValue(':id_article', $_POST['id'], PDO::PARAM_INT);    //Sécurisation des valeurs des variables qui vont être introduites dans la base.
   $sql_modifier->bindValue(':speudo', $_POST['speudo'], PDO::PARAM_STR);
   $sql_modifier->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
    $sql_modifier->bindValue(':date_commentaire', $date_commentaire, PDO::PARAM_STR);
      $sql_modifier=$bdd ->prepare("SELECT * FROM commentaires");
      $sql_modifier->execute();
      $data =  mysql_fetch_array($sql_modifier);
     

    
    header('Location: commentaire.php?id=' . $id);  //recharge la page commentaire.php en reprenant l'id de l'article que l'on commente
}  
} 
?>


<form action="commentaire.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" id="post_commentaire" name="commentaire"> <!-- redirection fonction de l'id pour afficher de nouveau le même article que celui que l'on commente -->

                <div class="clearfix">
                    <br><label for="prenom">Prénom :</label>
                    <div class="input"><input type="text" name="speudo" id="nom" placeholder="Votre Préno"></div>   <!-- envoi du prénom -->
                </div>

                <div class="clearfix">
                    <label for="commentaire">Commentaire</label>
                    <div class="input"><textarea name="commentaire" id="commentaire" placeholder="Votre commentaire"></textarea></div>   <!-- commentaire -->
                </div>

                <div class="clearfix">
                    <div class="input"><input type="hidden" name="id" id="id" value="<?php echo $id ?>"></div>  <!-- Champs caché permettant de poster l'id de l'article pour l'utiliser pour afficher le même article lors de la validation du formulaire (c.f balise form) -->

                    <div class="clearfix">
                        <input type="submit" name="post_commentaire" value="Laisser un commentaire" class="btn btn-small btn-primary"></div>


        
        
                </div>
</div>
    <?php
    include_once 'includes/menu.inc.php';
 
    //Requête Sql ainsi que son exécution pour récupérer les commentaires qui sont en lien avec l'article selectionner
    $sth = $bdd->prepare('SELECT speudo, email, texte,DATE_FORMAT(date, \'%d/%m/%Y\') AS date_fr FROM commentaires WHERE id_articles = ? ORDER BY id ASC');
    $sth->execute(array($_GET['id']));
    
    //boucle permettant l'affichage des commentaires tant qu'il y en a dans le tableau fetch
    while ($donnees = $sth->fetch()) { 
        ?>
        <br>
        <p><strong class="text-info"><?php echo htmlspecialchars($donnees['speudo']); ?></strong> le <?php echo $donnees['date_fr']; ?></p>
        <p><?php echo nl2br(htmlspecialchars($donnees['texte'])); ?></p>

    <?php
}


include_once 'includes/footer.inc.php';   
?>
