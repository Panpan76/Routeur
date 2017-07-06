<?php
/**
 * Controlleur par défaut
 *
 * @see     Controlleur
 * @author  Panpan76
 * @version 1.0
 */
class ControlleurDefaut extends Controlleur{

  ################
  ### Méthodes ###
  ################

  /**
   * Index
   *
   * @return void
   */
  public function index(){
    $this->render('index.php', 'Accueil');
  }

}


?>
