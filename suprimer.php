<?php
require_once 'settings/bdd.inc.php';
require_once 'settings/init.inc.php';


 if(isset($_COOKIE['sid'])==TRUE)
{
    $id_a_suprimer=$_GET['id'];
    $sth = $bdd->prepare("DELETE FROM articles WHERE id=$id_a_suprimer");
    $sth->execute();
    header('Location: Index.php');
}
 else 
{
    header('Location: Index.php');
}
?>


