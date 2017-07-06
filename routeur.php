<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

$global = Glob::getInstance();
$global->debutGenerationPage = microtime(true);

// On récupère la page
$url = $_GET['page'];
// On la retire des super-variables get
unset($_GET['page']);

// On récupères les différentes données, POST ou GET
$parametres = array_merge($_GET, $_POST);

// On récupère une instance de Routeur
$routeur = Routeur::getInstance();

// On demande la page voulue avec les données de la requête
$routeur->redirect($url, $parametres);


?>
