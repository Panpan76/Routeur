<?php
/**
 * Entité Mère
 *
 * Définie les getter et setter magique pour toutes les entités filles
 *
 * @author Panpan76
 * @version 1.0
 */
class EntiteMere{

  public function __get($attribut){
    $classe = get_class($this);
    if(property_exists($classe, $attribut)){
      return $this->$attribut;
    }
    else{
      die("L'attribut $attribut n'existe pas pour la classe $classe");
    }
  }

  public function __set($attribut, $valeur){
    $classe = get_class($this);
    if(property_exists($classe, $attribut)){
      $this->$attribut = $valeur;
    }
    else{
      die("L'attribut $attribut n'existe pas pour la classe $classe");
    }
  }
}

?>
