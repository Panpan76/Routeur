<?php

require_once 'includes/config.php';

/**
 * Fonction magique appelée lors d'un appèle à une classe pour charger dynamiquement le fichier la contenant
 *
 * @return boolean
 */
function __autoload($classe){
  $fichiers = array(
    'classes/'.$classe.'.php',
    'controlleurs/'.$classe.'.php'
  );
  // Si on a plusieurs emplacement de classe

  foreach($fichiers as $fichier){
    if(file_exists($fichier)){
      require_once $fichier;
      return true;
    }
  }
  return false;
}

// On récupère la page
$url = $_GET['page'];
// On la retire des super-variables get
unset($_GET['page']);

// On récupères les différentes données, POST ou GET
$parametres = array_merge($_GET, $_POST);

// On récupère une instance de Routeur
$routeur = Routeur::getInstance();

// On charge le fichier de routes
$routeur->setRoutes(FICHIER_ROUTES);

// On demande la page voulue avec les données de la requête
$routeur->redirect($url, $parametres);


?>
