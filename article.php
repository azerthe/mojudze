<?php
session_start();
require_once 'settings/bdd.inc.php'; // Base de donnée
require_once 'settings/init.inc.php'; //Affiche une page en cas d'erreur
//
//
//
//
//
//Variable pour la modification d'une page
//Verification de l'ID
if (isset($_GET['id'])) {
$id = $_GET['id'];
//prepare la Requete pour la récupération de l'ID
$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date,'%d/%m/%Y')as date_fr FROM articles WHERE id=$id");
//securise la valeur
$sth->bindValue(':id', 1, PDO::PARAM_INT);
// exécution de la commande
$sth->execute();
// stock le resyktat
$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
//print_r($nb_articles);
//créer une variable  titre et texte qu'il recupere dans le tableau
$titre = $tab_articles[0]['titre'];
$article = $tab_articles[0]['texte'];

// modification du bouton pour l'ajout ou modification selon le cas
$bouton = "modifier";
$case = "valider";



} else {
//Si il n y a rien dans titre ou text area le bouton "Ajouter" apparait
$titre = "";
$article = "";
$bouton = "ajouter";
$case = "";
}




//si on appuie sur le bouton ajouter on rentre dans le if
if (isset($_POST['ajouter'])) 
    {

$date_ajout = date("Y-m-d"); // Afficher la date
$_POST['date'] = $date_ajout; // nouvelle clé
$_FILES['image']['error'];


///méthode pour identifier les erreurs et les afficher dans le tableau d'une image
if ($_FILES['image']['error'] == 0)
{

$_POST ['publie'] = isset($_POST['publie']) ? 1 : 0;

if (isset($_POST['ajouter']))
{
    
    //condition ternaire pour l'envoyer dans la base de données 
    $sth = $bdd->prepare("INSERT INTO articles (titre, texte, publie, date)VALUES (:titre, :texte, :publie, :date)");


    //bindvalue sécurise
    //associez une valeur à :publie
    $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
    //associez une valeur à :publie
    $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
    //associez une valeur à :publie
    $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_INT);
    //associez une valeur à :publie
    $sth->bindValue(':date', $_POST['date'], PDO::PARAM_STR);

    $sth->execute();
    //donne le derniere ID inserer

    $dernier_id = $bdd->lastInsertId();

    //Déplace l'image
    move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$dernier_id.jpg");
    $_SESSION['ajout_article'] = TRUE;
} 
else
{
    echo 'erreur image';
}   
}
//redirection de page
header("Location: article.php");
}

if (isset($_POST['Modifier'])) {    //si le bonton modifier a été cliqué
    $id_form = $_POST['id'];
    $sth = $bdd->prepare("UPDATE articles SET titre= :titre, texte=:texte WHERE id=$id_form");  //préparation de la requete de mise à jour
    $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR); //Sécurise les valeurs des variables qui peut être introduite dans la base. Cette valeur est forcement numerique du fait du PARAM_INT
    $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
    $sth->execute();
    $_SESSION['modif_article'] = TRUE; //session de modif d'article ouverte pour gestion message
    header('Location: index.php'); //retour a la page Article.php
} 


include_once 'includes/header.inc.php';
?>



<div class="span8"> <!-- Affichage -->
    <?php
//Message pour avertir l'utilisateur que le fichier à bien etait envoyé
    if (isset($_SESSION['ajout_article'])) {
    ?>
    <div class="alert-success" role="alert">

        <strong>Félicitation votre formulaire a été envoyé.</strong> Vous pouvez voir votre article.
    </div>
    <?php
    unset($_SESSION['ajout_article']);
    }
    ?>

    <!-- Formulaire pour créer les articles -->

    <form action ="article.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article">
        <input type="hidden" name="id" value="<?php if(isset($tab_articles)){echo $tab_articles[0]['id'];
    } ?>"/>


        <div class="clearfix">
            <label for ="titre">Titre</label>
            <div class="input"><input type="text" name ="titre" id="titre" value="<?php echo $titre ?>"></div> 
        </div>
   
        <div class="clearfix">
            <label for ="texte">Texte</label>
            <div class="input"><textarea type="texte" name ="texte"id="texte"><?php echo $article ?></textarea> 
        </div>

            <div class="clearfix">
                <label for ="image">Image</label>
                <div class="input"><input type="file" name ="image" id="image" ></div> 
            </div>

            <div class="clearfix">
                <label for ="publie">Publié
                    <div class="input"><input type="checkbox" <?php echo $case ?> name ="publie" id="publie" ></div> 
                </label>
            </div>
            <!-- Créer Un bouton Ajouter -->
            <div class="form-actions"> <!-- Bonton de modification ou d'ajout d'information dans la base de donnée -->
                <input type="submit" name ="ajouter" value="<?php echo $bouton ?>" class="btn btn-large btn-primary">
            </div> 
        </div>
    </form>
</div>


<?php
include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';
//}
?>