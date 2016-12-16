<?php


//destruction du cookie par utilisation 'sid'
setcookie('sid', $sid, time() - 300); 
//passage de la session en déconnexion
unset($_SESSION['connexion']); 
//redirection vers la page d'acceuil
header('location: index.php');
?>
