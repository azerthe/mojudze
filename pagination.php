<?php
session_start();
require_once 'settings/bdd.inc.php'; //Base de donnée
require_once 'settings/init.inc.php'; //Affiche une page en cas d'erreur
?>
   <?php
   //ceil sert à arrondir et de retourner l'entier supérieur
   ceil(3/2) 
   ?>

<?php

$sql = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date,'%d/%m/%Y')as date_fr FROM articles WHERE publie = :publie");

//création d'une variable permettant d'indiquer le nombre d'article utilise pour une page de navigation
$nbArticlesParPage = 2;

//la page_courante est celle indiqué dans l'url
$pageCourante = isset($_GET['p']) ? $_GET['p'] : 1 ;

//Calculer l'index de depart de la requete
$debut = ($pageCourante - 1) * $nbArticlesParPage; 


//Calculer le nombre message publies dans la table
$sql = $bdd->prepare("SELECT COUNT(*) as nbArticles FROM articles WHERE publie = :publie");
$sql->bindValue(':publie',1,PDO::PARAM_INT);     
$sql->execute();

//on récupére un tableau avec les données de la requete SQL
$tabResult = $sql->fetchAll(PDO::FETCH_ASSOC);

//on créer une variable qui va contenir le nombre d'article
$nbArticles = $tabResult[0]['nbArticles'];

// calcule de l'index
$nbPages = ceil($nbArticles / $nbArticlesParPage);
       
   
?>


