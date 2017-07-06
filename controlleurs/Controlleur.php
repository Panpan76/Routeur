<?php
/**
 * Controlleur général
 *
 * @author Panpan76
 * @version 1.0
 */
class Controlleur{

  #################
  ### Variables ###
  #################

  /**
   * @var array|null $data Les données liés à la reqûete
   */
  protected $data;


  ################
  ### Méthodes ###
  ################

  /**
   * Définit les données liées à la requête
   *
   * Les données peuvent être POST (validation de formulaire) ou GET
   *
   * @param array|null $data
   *
   * @return void
   */
  public function setData($data){
    $this->data = $data;
  }


  /**
   * Permet de charger un rendu de page
   *
   * @param string  $page     Vue à charger
   * @param string  $titre    Titre de la page
   * @param array   $params   Les différentes variables utilisées dans la vue
   *
   * @return void
   */
  public function render($page, $titre = '', $params = array()){
    foreach($params as $variable => $valeur){
      $$variable = $valeur;
    }
    unset($params);
    include DOSSIER_VUES.'/'.$page;
  }

}


?>
