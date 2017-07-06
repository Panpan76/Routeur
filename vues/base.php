<?php
$global = Glob::getInstance();
?>
<!doctype HTML>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel='stylesheet' href='css/couleurs.css' />
    <?php
    if(DEBUG){
      echo "<link rel='stylesheet' href='css/debug.css' />";
    }
    ?>
    <title><?= $titre; ?></title>
  </head>
  <body>


<?php
if(DEBUG){
?>
  <div id="debug">
    <div class="sql">
    </div>
    <div class="vitesse">
    <?= convertirSecondes(microtime(true)-$global->debutGenerationPage); ?>
    </div>
    <div class="route">
      Route
      <div class="routes">
        Pattern : <?php $global->route; ?><br />
        Controlleur : <?= $global->controlleur; ?><br />
        Méthode :
        <?php
          echo $global->methode.'('.implode(', ', $global->arguments).')';
        ?>
      </div>
    </div>
  </div>
<?php
}
?>
