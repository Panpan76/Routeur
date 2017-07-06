<?php

/**
 * Fonction magique appelée lors d'un appèle à une classe pour charger dynamiquement le fichier la contenant
 *
 * @return boolean
 */
function __autoload($classe){
  $fichiers = array(
    'classes/'.$classe.'.php',
    'controlleurs/'.$classe.'.php',
    'entites/'.$classe.'.php',
  );
  foreach($fichiers as $fichier){
    if(file_exists($fichier)){
      require_once $fichier;
      return true;
    }
  }
  return false;
}


function convertirSecondes($sec){
  if($sec > 1){
    $unites = array('s', 'm', 'h');
    $res = array();
    $n = 0;
    while($sec / 60 >= 1){
      $res[$n] = $sec % 60;
      $sec = floor($sec / 60);
      $n++;
    }
    $str = '';
    for($i = $n; $i > 0; $i--){
      $str .= $res[$i].$unites[$i].' ';
    }
    return $str;
  }
  else{
    return round(($sec * 1000), 2).'ms';
  }
}


?>
