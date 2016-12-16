<?php


//le require doit être placé dans chaque fichier php
require_once 'libs/Smarty.class.php';


//création d'un objet smarty d'une class Smarty
$smarty = new Smarty();


//chemin relatif au serveur web  repertoire ou vont être mis les repertoire template
$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');


$name= "gaetan";
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

//sert a passer une variable php en smarty
$smarty->assign('name',$name);

//** un-comment the following line to show the debug console
$smarty->debugging = true;

//sert a smarty pour chercher le fichier tpl et l'afficher
$smarty->display('smarty-test.tpl');

?>