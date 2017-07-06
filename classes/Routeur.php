<?php
/**
 * Classe Routeur
 *
 * Permet de gérer la routage de l'application
 *
 * @author  Panpan76
 * @version 1.0
 */
class Routeur{

  #################
  ### Variables ###
  #################

  /**
   * @var Routeur|null $instance   Instance de la classe Routeur
   */
  private static $instance = null;

  /**
   * @var string|null $url        URL demandé par l'utilisateur
   */
  private $url;


  ################
  ### Méthodes ###
  ################

  /**
   * Constructeur de la classe Routeur
   *
   * Visibilité privée pour utilisation du patron de conception Singleton
   *
   * @return Routeur
   */
  private function __construct(){
    return $this;
  }


  /**
   * Permet de récupérer l'instance de Routeur
   *
   * Cette méthode met en place le patron de conception Singleton
   *
   * @return Routeur
   */
  public static function getInstance(){
    // Si aucune instance n'existe
    if(is_null(self::$instance)){
      try{
        // On essaye de la créer
        self::$instance = new self();
      }
      catch(Exception $e){
        // On capture une éventuelle erreur
        die($e);
      }
    }
    // On retourne l'instance de Routeur
    return self::$instance;
  }


  /**
   * Permet d'effectuer une redirection
   *
   * @param string      $url    URL demandé par l'utilisateur
   * @param array|null  $data   Données liées à la requête
   *
   * @return void
   */
  public function redirect($url, $data = null){
    // On récupère les informations de la page
    $infos = $this->getPage($url);
  }


  /**
   * Permet de récupérer les routes
   *
   * @return array  Liste des routes possibles
   */
  private function getRoutes(){
    return null;
  }

  /**
   * Permet de récupéer les diverses informations nécessaires à la redirectino
   *
   * @return array|null   Liste des informations nécessaires à la redirection
   */
  private function getPage($url){
    // Pour chaque route
    foreach($this->getRoutes() as $route => $infos){
      // Si la route correspond à la requête de l'utilisateur
      if(preg_match("#^$route/?$#", $url, $matches)){
        // On pense à récupérer les paramètres de la route via $matches

        $infos['route'] = $route;
        $infos['params'] = array();
        // On ajoute les paramètres au retour
        for($i = 1; $i < count($matches); $i++){
          $infos['params'][] = $matches[$i];
        }
        return $infos;
      }
    }
    // TODO Aucune correspondance trouvé -> page 404
    return null;
  }


}

?>
