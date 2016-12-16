<?php
session_start();
require_once 'settings/bdd.inc.php'; //Base de donnée
require_once 'settings/init.inc.php'; //Affiche une page en cas d'erreur
?>
   <?php ceil(3/2) ?>

<?php

$sql = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date,'%d/%m/%Y')as date_fr FROM articles WHERE publie = :publie");

//index de depart
$nbArticlesParPage = 2;

$pageCourante = isset($_GET['p']) ? $_GET['p'] : 1 ;

// variable qui contient la page courante
//$pageCourante = $_GET['p'];

//Calculer l'index de depart de la requete
$debut = ($pageCourante - 1) * $nbArticlesParPage; 
        

   $sql = "SELECT COUNT(*) as nbArticles FROM articles WHERE publie = :publie";     
   

        
        //Calculer le nombre message publies dans la table
        $sql = $bdd->prepare("SELECT COUNT(*) as nbArticles FROM articles WHERE publie = :publie");
        $sql->bindValue(':publie',1,PDO::PARAM_INT);
        
        $sql->execute();
        $tabResult = $sql->fetchAll(PDO::FETCH_ASSOC);
        
       $nbArticles = $tabResult[0]['nbArticles'];
       // calcule de l'index
       $nbPages = ceil($nbArticles / $nbArticlesParPage);
       
   
?>


