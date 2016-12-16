<?php

require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';



//si le cookie est égale à true on peut supprimer le 
if (isset($_COOKIE['sid']) == TRUE) {
    
    //on récupére l'id qui transit dans l'url
    $id_a_suprimer = $_GET['id'];
    
    //suppression avec Jointure ne fonctionne qui si il y a un article et un commentaires qui sont liés
    $sth = $bdd->prepare("DELETE articles, commentaires FROM articles INNER JOIN commentaires WHERE articles.id =$id_a_suprimer AND commentaires.id_articles =$id_a_suprimer");
   // $sth = $bdd->prepare("DELETE FROM articles WHERE id=$id_a_suprimer");
    $sth->execute();

    //si il faut supprimer un article sans commentaires on fait cette requete de suppression sur une seule table
    $sup = $bdd->prepare("DELETE FROM articles WHERE id=$id_a_suprimer");
    $sup->execute();
    header('Location: index.php');
} else {
    header('Location: index.php');
}
?>


