<?php
/**
 * Correspondances entre entités et tables
 *
 * Le tableau doit être formaté tel que :
 * <Entite> = array(
 *    'table'     => <table>,
 *    'variables' => array(
 *      <attribut> => array(
 *        'type'    => <type>[,
 *        'colonne' => <colonne>,
 *        'entite'  => <Entite cible>,
 *        'lien'    => <attribut cible>,
 *        'relation'=> <relation>]
 *      )
 *    )
 * )
 *
 *  Valeurs possibles :
 *    type      => PK|string|int|boolean|datetime|entite
 *    relation  => 1-1|1-n|n-1|n-n
 */
$correspondances = array();
$correspondances['Livre'] = array(
  'table'     => 'livre',
  'variables' => array(
    'id' => array(
      'type'    => 'PK',
      'colonne' => 'livre_ID'
    ),
    'titre' => array(
      'type'    => 'string',
      'colonne' => 'titre'
    ),
    'dateCreation' => array(
      'type'    => 'datetime',
      'colonne' => 'date_creation'
    ),
    'chapitres' => array(
      'type'    => 'objet',
      'entite'  => 'Chapitre',
      'lien'    => 'livre',
      'relation'=> '1-n'
    ),
  )
);
$correspondances['Chapitre'] = array(
  'table'     => 'chapitre',
  'variables' => array(
    'id' => array(
      'type'    => 'PK',
      'colonne' => 'chapitre_ID'
    ),
    'titre' => array(
      'type'    => 'string',
      'colonne' => 'titre'
    ),
    'livre' => array(
      'type'    => 'objet',
      'colonne' => 'livre_ID',
      'entite'  => 'Livre',
      'relation'=> 'n-1'
    ),
  )
);

?>
