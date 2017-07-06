<?php/** * Classe GestionnaireEntite * * Permet de gérer les entités * * @author  Panpan76 * @version 1.0 */class GestionnaireEntite{  #################  ### Variables ###  #################  /**   * @var PDO|null $pdo   Instance de PDO   */  private $pdo;  /**   * @var GestionnaireEntite|null $instance   Instance de la classe GestionnaireEntite   */  private static $instance = null;

  /**
   * @var array|null $entites   Liste de toutes les entités ayant déjà été récupérées
   */
  private $entites;  /**   * @var array|null $requetes   Liste de toutes les requêtes ayant déjà été effectuées   */  private $requetes = array();  /**   * @var array|null  $correspondances     Correspondances entre Entite et table   */  private $correspondances;  ################  ### Méthodes ###  ################  /**   * Constructeur de la classe GestionnaireEntite   *   * Visibilité privée pour utilisation du patron de conception Singleton   *   * @return GestionnaireEntite   */  private function __construct(){    try{      $this->pdo = new PDO(BDD_SGBD.':'.BDD_HOST.';dbname='.BDD_BASE, BDD_USER, BDD_PASS);    }    catch(Exception $e){      die($e);    }    $this->setCorrespondances(FICHIER_ENTITES);  }  /**   * Permet de récupérer l'instance de GestionnaireEntite   *   * Cette méthode met en place le patron de conception Singleton   *   * @return GestionnaireEntite   */  public static function getInstance(){    if(is_null(self::$instance)){      try{        self::$instance = new self();      }      catch(Exception $e){        die($e);      }    }    return self::$instance;  }

  /**
   * Permet de récupérer la liste des requetes executées
   *
   * @return array
   */
  public function getRequetes(){    return $this->requetes;  }  /**   * Permet de récupérer le nombre de requetes executées   *   * @return int   */  public function getNbRequetes(){    return count($this->getRequetes());  }

  /**
   * Permet de récupérer une ou plusieurs entités dans la base de données
   *
   * @param string  $classe   Nom de l'entité voulu
   * @param array   $where    Tableau de correspondance pour la recherche (spécifier les attributs de classe et nom les colonnes de la base)
   *
   * @return array
   */
  public function select($entite, $where = array()){    if(in_array($entite, array_keys($this->correspondances))){      $infos = $this->correspondances[$entite];      $table = $infos['table'];      if(!empty($where)){        // On cherche un cas existant        $res = $this->dejaInstancie($classe, $where);        if(is_object($res)){          return array($res);        }        $recherche = array();        // On construit les paramètre de recherche        foreach($where as $attribut => $valeur){          $var = $infos['variables'][$attribut]['colonne'];          $recherche[] = "$var = '$valeur'";        }        $where = "WHERE ".implode(' AND ', $recherche);      }
      // La requête
      $requete = "SELECT * FROM $table $where";
      $sql = $this->pdo->prepare($requete);      // On mémorise la requête et si elle a réussi ou échoué      $this->requetes[] = array(        'succes' => $sql->execute(),        'requete' => $requete      );      $resultats = array();      while($res = $sql->fetch(PDO::FETCH_ASSOC)){        // On charge dynamiquement l'objet        $obj = $this->charger($entite, $res);        // On stock le résultat dans $this->entites pour éviter de le créer à nouveau        $resultats[] = $this->entites[$entite][$obj->id] = $obj;      }      return $resultats;    }    else{      $classe = get_class($entite);      die("La classe $classe n'a définie aucune correspondances");    }  }
  /**
   * Permet de faire persister (ajout ou modification) d'une entité dans la base de données
   *
   * @param Objet  $obj   Entité
   *
   * @return boolean
   */
  public function persist($obj){    $classe = get_class($obj);    if(in_array($classe, array_keys($this->correspondances))){      $infos = $this->correspondances[$classe];      $table = $infos['table'];
      $champs   = array();
      $valeurs  = array();
      foreach($infos['variables'] as $variable => $base){
        $var = $obj->$variable;
        $champs[] = $base['colonne'];
        switch($base['type']){
          case 'PK':
            if(isset($var)){
              $valeurs[] = $var;
            }
            else{
              array_pop($champs);
            }
            break;

          case 'string':
            $valeurs[] = "'$var'";
            break;

          case 'objet':
            if(is_object($obj->$variable)){
              $valeurs[] = $var->id;
            }
            else{
              $valeurs[] = $var; // L'id
            }
            break;

          default:
            $valeurs[] = $var;
            break;
        }
      }
      $champs   = '('.implode(', ', $champs).')';
      $valeurs  = '('.implode(', ', $valeurs).')';

      // La requête
      $requete = "REPLACE INTO $table $champs VALUES $valeurs";
      $sql = $this->pdo->prepare($requete);

      $succes = $sql->execute();

      // On mémorise la requête et si elle a réussi ou échoué
      $this->requetes[] = array(
        'succes' => $succes,
        'requete' => $requete
      );

      $obj->id = $this->pdo->lastInsertId();

      return $succes;
    }
    else{
      die("La classe $classe n'a définie aucune correspondances");
    }
  }  /**   * Permet de faire la correspondance entre les colonnes de la table en base, et les attributs de l'entité   *   * @param string  $classe           Entité   * @param array   $donnees          Données   *   * @return Object   */  private function charger($classe, $donnees){    $obj = new $classe();    // Pour chaque correspondaces    foreach($this->correspondances[$classe] as $attribut => $infos){      // Si on a une entrée pour le colonne correspondant à cet attribut      if(isset($donnees[$infos['colonne']])){        // On effectue un traitement selon le type de l'attribut        switch($infos['type']){          case 'objet':            // On charge dynamiquement le nouvel objet            $obj->$attribut = $this->select($infos['entite'], array('id' => $donnees[$infos['colonne']]));            break;
          case 'array':            // TODO
            break;
          default:            // Par défaut, on attribut simplement la valeur à l'attribut            $obj->$attribut = $donnees[$infos['colonne']];            break;        }      }    }    return $obj;  }  /**   * Cherche si une entité a déjà était instancié   *   * @param string  $classe Nom de la classe   * @param array   $where  Paramètres de la recherche   *   * @return Objet|false   */  private function dejaInstancie($classe, $where){    // Si on a aucune entrée pour cette classe, on stop    if(!isset($this->entites[$classe])){      return false;    }    $trouve = false;    // On parcourt les objets sauvegardés    foreach($this->entites[$classe] as $id => $obj){      // On parcourt les propriétés recherchées      foreach($where as $attribut => $valeur){        if($obj->$attribut != $valeur){          $trouve = false;          break;        }        $trouve = true;      }      if($trouve){        return $obj;      }    }    return false;  }  /**   * Permet de récupérer les correspondances depuis un fichier   *   * Charge les correspondances possibles pour le GestionnaireEntite à partir d'un fichier   *   * @param string  $fichier  Emplacement du fichier contenant les correspondances   *   * @return void   */  public function setCorrespondances($fichier){    // On vérifie que le fichier existe, sinon on stop    if(!file_exists($fichier)){      return false;    }    // On initialise les correspondances à null    $correspondances = array();    try{      // On récupère le type de fichier      $elements = explode('.', $fichier);      $type     = end($elements);      // On parse le fichier en entrée selon son type      switch($type){        case 'yml':          // TODO YAML file          break;        case 'php':          include $fichier;          break;      }    }    catch(Exception $e){      $f = __FILE__;      $l = __LINE__;      $m = __METHOD__;      $c = __CLASS__;      print("Une erreur est survenue dans $c::$m() ($f:$l) : $e\n");    }    $this->correspondances = $correspondances;  }}

?>