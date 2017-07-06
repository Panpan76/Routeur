<?php
/**
 * Classe Glob
 *
 * Permet de gérer les variables globales de l'application. A ne pas confondre avec les variables de configuration !
 *
 * @author  Panpan76
 * @version 1.0
 */
class Glob{

  #################
  ### Variables ###
  #################

  /**
   * @var Glob|null $instance   Instance de la classe Glob
   */
  private static $instance = null;




  ################
  ### Méthodes ###
  ################

  /**
   * Constructeur de la classe Glob
   *
   * Visibilité privée pour utilisation du patron de conception Singleton
   *
   * @return Glob
   */
  private function __construct(){
    return $this;
  }


  /**
   * Permet de récupérer l'instance de Glob
   *
   * Cette méthode met en place le patron de conception Singleton
   *
   * @return Glob
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
    // On retourne l'instance de Glob
    return self::$instance;
  }


  /**
   * Magic setter
   *
   * Permet d'attribuer à la classe un attribut de manière dynamique
   * L'affectation n'a lui que si l'attribut n'existe pas où s'il est vide
   *
   * @param string $attribut
   * @param mixed $valeur
   *
   * @return void
   */
  public function __set($attribut, $valeur){
    if(!isset($this->$attribut) || empty($this->$attribut)){
      $this->$attribut = $valeur;
    }
  }


  /**
   * Magic getter
   *
   * Permet d'e récupérer un attribut de la classe de manière dynamique
   *
   * @param string $attribut
   *
   * @return mixed
   */
  public function __get($attribut){
    if(isset($this->$attribut)){
      return $this->$attribut;
    }
  }
}

?>
