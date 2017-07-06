<?php

$routes = array(
  '' => array(
    'controlleur' => 'ControlleurDefaut',
    'methode'     => 'index'
  ),
  'livre\/([^\/]+)' => array(
    'controlleur' => 'ControlleurLivre',
    'methode'     => 'voir'
  )
);

?>
