<?php
/**
 * Fichier de configuration de l'application
 *
 * @author  Panpan76
 * @version 1.0
 */

###############
### Routage ###
###############

define('FICHIER_ROUTES', realpath(__DIR__.'/routes.php'));
define('DOSSIER_VUES', realpath(__DIR__.'/../vues/'));


###############
### Entites ###
###############

define('FICHIER_ENTITES', realpath(__DIR__.'/entites.php'));


#######################
### Base de données ###
#######################

define('BDD_SGBD', 'mysql');
define('BDD_HOST', 'localhost');
define('BDD_BASE', 'routeur');
define('BDD_USER', 'root');
define('BDD_PASS', '');


############
### Vues ###
############


define('DEBUG', true);

?>
