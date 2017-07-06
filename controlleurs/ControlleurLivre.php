<?php
/**
 * Controlleur par défaut
 *
 * @see     Controlleur
 * @author  Panpan76
 * @version 1.0
 */
class ControlleurLivre extends Controlleur{

  ################
  ### Méthodes ###
  ################

  /**
   * Voir
   *
   * @return void
   */
  public function voir($id){
    $ge = GestionnaireEntite::getInstance();
    $livre = $ge->select('Livre', array('id' => $id))[0];
    
    $this->render('livre/voir.php', $livre->titre, array(
      'livre' => $livre
    ));
  }

}


?>
