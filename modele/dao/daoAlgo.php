<?php

require_once("ConnexionException.php");
require_once("AccesTableException.php");

/* Dans un path, utiliser '\..'' remonte d'un dossier. Sous windows
 */
class DaoAlgo
{

  private $connexion;



 // 	permet d'ouvrir une connexion avec le sgbd

 // il suffit de remplacer x par les informations qui vous concernent.
  public function connexion()
  {
    try
      {
	//connection
	$this->connexion = new PDO('mysql:host=localhost;charset=UTF8;dbname=info2-2015-jobdating',"info2-2015-jobda","jobdating");	//on se connecte au sgbd
	$this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);	//on active la gestion des erreurs et d'exceptions
      }
    catch(PDOException $e)
      {
	throw new ConnexionException("Erreur de connection");
      }
    //connection reussie

  }

  //méthode permettant la deconnexion du sgbd
  public function deconnexion()
  {
   $this->connexion=null;
  }

  /* méthode qui permet d'obtenir la liste des étudiants pour une formation donnée

postconditions:
une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

si aucune exception n'est levée:
Une array avec l'identifiant des étudiants
*/
  public function getEtudiants($formation)  {

    try {
      $statement = $this->connexion->prepare('SELECT IDEtu, listeChoixEtu, nomEtu FROM etudiant WHERE formationEtu = "'.$formation.'";');
      $statement->execute();
      $tabResult = $statement->fetchAll();
      return $tabResult;
    } catch (TableAccesException $e) {
      print($e -> getMessage());
    }
  }

/* méthode qui permet d'obtenir la liste des entreprises

postconditions:
une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

si aucune exception n'est levée:
Une array avec l'identifiant des étudiants
*/
public function getEntreprises()  {

  try {
    $statement = $this->connexion->prepare('SELECT IDEnt, typeCreneau, formationsRecherchees, nbPlaces FROM entreprise;');
    $statement->execute();
    $tabResult = $statement->fetchAll();

    return $tabResult;
  } catch (TableAccesException $e) {
    print($e -> getMessage());
  }
}


  /* méthode qui permet d'obtenir la liste des entreprises pour une formation

postconditions:
une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

si aucune exception n'est levée:
Une array avec l'identifiant des étudiants
*/
/////////////////////ATTENTION depuis la table entreprise////////////////////
public function getEntreprisesEntreprise($formation)  {

  try {
    $statement = $this->connexion->prepare('SELECT IDEnt, nomEnt, typeCreneau, formationsRecherchees, nbPlaces FROM entreprise;');
    $statement->execute();
    $tabResult = $statement->fetchAll();

    $ret = array();
    foreach ($tabResult as $entreprise) {
      $form = explode ( "," , $entreprise["formationsRecherchees"]);
      if(in_array('Informatique', $form)) {
        $ret[] = $entreprise;
      }
    }
    return $ret;
  } catch (TableAccesException $e) {
    print($e -> getMessage());
  }
}

/* méthode qui permet d'obtenir la liste des formations pour une formation pour un type de formation

postconditions:
une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

si aucune exception n'est levée:
Une array avec l'identifiant des étudiants
*/
public function getFormations($formation)  {

  try {
    $statement = $this->connexion->prepare('SELECT IDformation, entPropose, disponibilite FROM formation where typeFormation = "'.$formation.'";');
    $statement->execute();
    $tabResult = $statement->fetchAll();

    return $tabResult;
  } catch (TableAccesException $e) {
    print($e -> getMessage());
  }
}


/* méthode qui permet de récupérer idFormation à partir d'une entreprise et d'un type de formation

postconditions:
une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

retourne un entier contenant l'id de la formation
*/
public function getIDFormation($formation, $entreprise)  {

  try {
    $statement = $this->connexion->prepare('SELECT IDformation FROM formation WHERE typeFormation = "'.$formation.'" AND entPropose = "'.$entreprise.'";');
    $statement->execute();
    $tabResult = $statement->fetch();

    $ret = $tabResult['IDformation'];

    return $ret;
  } catch (TableAccesException $e) {
    print($e -> getMessage());
  }
}

/* méthode qui permet de récupérer le nombre de créneaux le matin et l'après-midi

postconditions:
une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

retourne un tableau contenant en 0 le nombre de creneau du matin, et en 1 le nombre de creneau de l'aprem
*/
public function getNbCreneaux()  {

  try {
    $statement = $this->connexion->prepare('SELECT nbCreneauxMatin, nbCreneauxAprem FROM scriptconfig;');
    $statement->execute();
    $tabResult = $statement->fetch();

    $ret[0] = $tabResult['nbCreneauxMatin'];
    $ret[1] = $tabResult['nbCreneauxAprem'];

    return $ret;
  } catch (TableAccesException $e) {
    print($e -> getMessage());
  }
}




/* méthode qui permet d'ajouter l'entreprise et l'étudiant à un créneau

postconditions:
une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

retourne rien
*/
public function ajoutCreneau($numCreneau, $IDformation, $etudiant) {
  try {
    $statement = $this->connexion->prepare('INSERT INTO creneau VALUES ("'.$numCreneau.'", "00:00:00", "00:00:00", "'.$IDformation.'",  "'.$etudiant.'");');
    $statement->execute();

  } catch (TableAccesException $e) {
    print($e -> getMessage());
  }
}

/* méthode qui permet d'ajouter une formation

postconditions:
une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

retourne rien
*/
public function ajoutFormation($typeFormation, $entPropose, $disponibilite) {
  try {
    $statement = $this->connexion->prepare('INSERT INTO formation VALUES (NULL, "'.$typeFormation.'", "'.$entPropose.'", " ", "'.$disponibilite.'");');
    $statement->execute();

  } catch (TableAccesException $e) {
    print($e -> getMessage());
  }
}
}
?>
