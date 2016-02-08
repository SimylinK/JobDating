<?php

require_once("ConnexionException.php");
require_once("AccesTableException.php");
require_once(__DIR__."/../algo.php");
require_once(__DIR__."/../formationV2.php");

/* Dans un path, utiliser '\..'' remonte d'un dossier. Sous windows
*/
class Dao
{

  private $connexion;


        # # # # # # # # # # # # # #
        # SOMMAIRE  DES FONCTIONS #
        # # # # # # # # # # # # # #

  # connexion()
  # deconnexion()
  # getMotDePasse($login)
  # verifieMotDePasse($login, $password)
  # getTypeUtilisateur($login)
  # estInscrit($login)
  # ajoutEtudiant()
  # ajoutEntreprise()
  # getAllEtudiantsTemp()
  # getAllEtudiants()
  # getAllEntreprisesTemp()
  # getAllEntreprises()
  # validerEtudiant($id)
  # validerEntreprise($id)
  # gelerEtudiant($id)
  # gelerEntreprise($id)
  # supprimerEtu($id)
  # supprimerEtuTemp($id)
  # supprimerEnt($id)
  # supprimerEntTemp($id)
  # getEtu($id)
  # getTempEtu($id)
  # getEnt($id)
  # getTempEnt($id)
  # getConfiguration()
  # getNbCreneaux()
  # getNomEtudiant($IDEtu)
  # editHeureDebutMatin($new)
  # editHeureDebutAprem($new)
  # editNbCreneauxMatin($new)
  # editNbCreneauxAprem($new)
  # editDureeCreneau($new)
  # getEtudiants($formation)
  # getEntreprises()
  # getEntreprisesParFormation($formation)
  # getFormationEtudiant($id)
  # getEntreprisesEntreprise($formation) // depuis la table entreprise
  # getFormations($formation) // pour la table formation
  # getFormationsAffichage($entreprise)
  # getFormationsEntreprise($entreprise)
  # getIdEntreprise($entreprise)
  # getIDFormation($formation, $entreprise)
  # supprimerCreneau()
  # ajoutCreneau($numCreneau, $IDformation, $etudiant)
  # getCreneau($numeroCreneau, $idFormation)
  # ajoutFormation($typeFormation, $entPropose, $creneauDebut, $creneauFin)
  # getDetails()
  # getId($identifiant,$type)
  # generatePlanning()
  # editNomEntreprise($id,$new)
  # editVilleEntreprise($id,$new)
  # editCPEntreprise($id,$new)
  # editAdresseEntreprise($id,$new)
  # editNomContactEntreprise($id,$new)
  # editPrenomContactEntreprise($id,$new)
  # editMailEntreprise($id,$new)
  # editTelephoneEntreprise($id,$new)
  # editFormationsRechercheesEntreprise($id,$new)
  # editTypeCreneauEntreprise($id,$new)
  # editNbStandsEntreprise($id,$new)
  # editNbRepasEntreprise($id,$new)
  # editMdpEntreprise($id,$new,$old)
  # editNomEtudiant($id,$new)
  # editPrenomEtudiant($id,$new)
  # editMailEtudiant($id,$new)
  # editTelephoneEtudiant($id,$new)
  # editFormationEtudiant($id,$new)
  # editMdpEtudiant($id,$new,$old)
  # supprimerFormation($idEntreprise)



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

  /* méthode qui permet d'obtenir un mot de passe dans la base associé à un certain login
  il faut d'abord ouvrir une connexion au niveau du sgbd
  ensuite soumettre la requête adéquate
  fermer la connexion
  renvoyer le résultat obtenu

  postconditions:
  une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
  une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

  si aucune exception n'est levée:
  si le login est associé à un mot de passe dans la table une chaine de caractère contenant le mot de passe est renvoyé
  sinon null est renvoyé
  */
  public function getMotDePasse($login)  {

    $this->connexion();
    $statement = $this->connexion->prepare('SELECT mdpEtu FROM etudiant WHERE mailEtu="'.$login.'";');
    $statement->execute();
    $statementBis = $this->connexion->prepare('SELECT mdpEnt FROM entreprise WHERE mailEnt="'.$login.'";');
    $statementBis->execute();
    $statementTer = $this->connexion->prepare('SELECT * FROM identificationadmin WHERE emailadmin="'.$login.'";');
    $statementTer->execute();
    $this->deconnexion();
    $tabResult = $statement->fetch();
    $tabResultBis = $statementBis->fetch();
    $tabResultTer = $statementTer->fetch();
    if (!is_null($tabResult['mdpEtu'])) {
      return $tabResult['mdpEtu'];
    }
    elseif (!is_null($tabResultBis['mdpEnt'])) {
      return $tabResultBis['mdpEnt'];
    }
    elseif (!is_null($tabResultTer['mdpadmin'])) {
      return $tabResultTer['mdpadmin'];
    }
    return NULL;
  }



  /* méthode qui permet de vérifier si un login donné correspond bien au mot de passe passé en paramètre
  les mots de passe ont été cryptés dans la base avec crypt() en php.

  postconditions:

  une exception de type ConnexionException est levée s'il y a un problème lors de la connexion au sgbd
  une exception de type AccesTableException est levée s'il y a un problème lors de la soumission de la requête

  si aucune exception n'est levée,
  si le login est associé à un mot de passe dans la table la valeur true est renvoyée, false sinon
  */
  public function verifieMotDePasse($login, $password)  {
    $mdp_get = $this->getMotDePasse($login);
    $mdp_test = crypt($password,$mdp_get);
    if ($mdp_test == $mdp_get && strpos($login, '"') == FALSE) {
      return TRUE;
    }
    return FALSE;
  }

  public function getTypeUtilisateur($login) {
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT * FROM etudiant WHERE mailEtu="'.$login.'";');
    $statement->execute();
    $statementBis = $this->connexion->prepare('SELECT * FROM entreprise WHERE mailEnt="'.$login.'";');
    $statementBis->execute();
    $statementTer = $this->connexion->prepare('SELECT * FROM identificationadmin WHERE emailadmin="'.$login.'";');
    $statementTer->execute();
    $this->deconnexion();
    $tabResult = $statement->fetch();
    $tabResultBis = $statementBis->fetch();
    $tabResultTer = $statementTer->fetch();
    if (!is_null($tabResult['mdpEtu'])) {
      return "etudiant";
    }
    elseif (!is_null($tabResultBis['mdpEnt'])) {
      return "entreprise";
    }
    elseif (!is_null($tabResultTer['mdpadmin'])) {
      return "admin";
    }
  }

  public function estInscrit($login) {
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT * FROM etudiant WHERE mailEtu="'.$login.'";');
    $statement->execute();
    $statementBis = $this->connexion->prepare('SELECT * FROM entreprise WHERE mailEnt="'.$login.'";');
    $statementBis->execute();
    $statementTer = $this->connexion->prepare('SELECT * FROM identificationadmin WHERE emailadmin="'.$login.'";');
    $statementTer->execute();
    $this->deconnexion();
    $tabResult = $statement->fetch();
    $tabResultBis = $statementBis->fetch();
    $tabResultTer = $statementTer->fetch();
    if (!is_null($tabResult['mdpEtu'])) {
      return TRUE;
    }
    elseif (!is_null($tabResultBis['mdpEnt'])) {
      return TRUE;
    }
    elseif (!is_null($tabResultTer['mdpadmin'])) {
      return TRUE;
    }
    return FALSE;
  }


  public function ajoutEtudiant() {
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT mailEtu from temp_etudiant WHERE mailEtu="'.$_POST['email'].'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT mailEtu from etudiant WHERE mailEtu="'.$_POST['email'].'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT mailEnt from temp_entreprise WHERE mailEnt="'.$_POST['email'].'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT mailEnt from entreprise WHERE mailEnt="'.$_POST['email'].'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT emailadmin from identificationadmin WHERE emailadmin="'.$_POST['email'].'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $prenomEtu = $_POST['prenom'];
    $nomEtu = $_POST['nom'];
    $numtelEtu = $_POST['tel'];
    $formationEtu = $_POST['formation'];
    $mailEtu = $_POST['email'];
    $mdpEtu = crypt($_POST['password']);
    $this->connexion();
    $statement = $this->connexion->prepare('INSERT INTO temp_etudiant (nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu)
    VALUES ("'.$nomEtu.'","'.$prenomEtu.'","'.$mailEtu.'","'.$mdpEtu.'","'.$numtelEtu.'","'.$formationEtu.'");');
    $statement->execute();
    $this->deconnexion();
    return true;
  }

  public function ajoutEntreprise() {
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT mailEtu from etudiant WHERE mailEtu="'.$_POST['email'].'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT mailEnt from temp_entreprise WHERE mailEnt="'.$_POST['email'].'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT mailEnt from entreprise WHERE mailEnt="'.$_POST['email'].'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT emailadmin from identificationadmin WHERE emailadmin="'.$_POST['email'].'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $this->connexion();
    $statement = $this->connexion->prepare('SELECT nomEnt from temp_entreprise WHERE nomEnt="'.strtoupper($_POST['nomSociete']).'";');
    $statement->execute();
    $this->deconnexion();
    $taille = $statement->rowCount();
    if ($taille!=0) {
      return false;
    }
    $nomEnt = strtoupper($_POST['nomSociete']);
    $mdpEnt = crypt($_POST['password']);
    $typeCreneau = $_POST['disponibilite'];
    $i = 0;
    $formationsRecherchees = "";
    $listeFormations = array('formation_LPI2P','formation_LPIMOC','formation_LPLOGICA','formation_LPEAS','formation_LPSEICOM','formation_LPIDEB',
    'formation_LPFICA','formation_DUTGEII','formation_DUTINFO','formation_DUTGMP','formation_DUTSGM','formation_DCG');
    while ($i < 12) {
      if (isset($_POST[$listeFormations[$i]])) {
        $formationsRecherchees = $formationsRecherchees.$_POST[$listeFormations[$i]];
        $i++;
        while ($i < 12) {
          if (isset($_POST[$listeFormations[$i]])) {
            $formationsRecherchees = $formationsRecherchees.",";
            $formationsRecherchees = $formationsRecherchees.$_POST[$listeFormations[$i]];
          }
          $i++;
        }
      }
      $i++;
    }
    $nbPlaces = -1;
    if (isset($_POST['NbAlternants'])) {
      if ($_POST['NbAlternants'] != "")
        $nbPlaces = $_POST['NbAlternants'];
    }

    if (isset($_POST['dejeuner'])) {
      if ($_POST['dejeuner'] == "dejeuner_ok") {
        $nbRepas = $_POST['NbRepas'];
      }
      else {
        $nbRepas = 0;
      }
    }
    else {
      $nbRepas = 0;
    }
    $mailEnt = $_POST['email'];
    $nomContact = $_POST['nom'];
    $prenomContact = $_POST['prenom'];
    $numTelEnt = $_POST['tel'];
    $codePostal = $_POST['codePostal'];
    $villeEnt = $_POST['ville'];
    $adresseEnt = $_POST['adresse'];
    $nbStands = $_POST['NbStand'];
    $this->connexion();
    $statement = $this->connexion->prepare('INSERT INTO temp_entreprise (nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbPlaces,nbRepas,nbStands,
      mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt) VALUES ("'.$nomEnt.'","'.$mdpEnt.'","'.$typeCreneau.'","'.$formationsRecherchees.'"
      ,'.$nbPlaces.','.$nbStands.','.$nbRepas.',"'.$mailEnt.'","'.$nomContact.'","'.$prenomContact.'","'.$numTelEnt.'","'.$codePostal.'","'.$villeEnt.'","'.$adresseEnt.'");');
      $statement->execute();
      $this->deconnexion();
      $idEnt = $this->getIdEntreprise($nomEnt);
      $tabConfig = $this->getConfiguration();
      $this->deconnexion();
      return true;
    }

    //Pour les tables etudiants et entreprises

    public function getAllEtudiantsTemp() {
      $this->connexion();
      $statement = $this->connexion->prepare('SELECT * from temp_etudiant order by nomEtu;');
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
    }

    public function getAllEtudiants() {
      $this->connexion();
      $statement = $this->connexion->prepare('SELECT * from etudiant order by nomEtu;');
      $statement->execute();
      $this->deconnexion();
      return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
    }

    public function getAllEntreprisesTemp() {
      $this->connexion();
      $statement = $this->connexion->prepare('SELECT * from temp_entreprise order by nomEnt;');
      $statement->execute();
      $this->deconnexion();
      return $statement->fetchAll(PDO::FETCH_CLASS, "Entreprise");
    }

    public function getAllEntreprises() {
      $this->connexion();
      $statement = $this->connexion->prepare('SELECT * from entreprise order by nomEnt;');
      $statement->execute();
      $this->deconnexion();
      return $statement->fetchAll(PDO::FETCH_CLASS, "Entreprise");
    }

    public function validerEtudiant($id) {
      $this->connexion();
      $statement = $this->connexion->prepare('INSERT INTO etudiant(nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu,listechoixEtu) SELECT nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu,listechoixEtu FROM temp_etudiant WHERE IDEtu = '.$id.';');
      $statement->execute();
      $this->deconnexion();
      $this->connexion();
      $statement = $this->connexion->prepare('DELETE FROM temp_etudiant WHERE IDEtu = '.$id.';');
      $statement ->execute();
      $this->deconnexion();
      return;
    }

    public function validerEntreprise($id) {
      $this->connexion();
      $statement = $this->connexion->prepare('INSERT INTO entreprise(nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbPlaces,nbRepas,nbStands,
        mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt) SELECT nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbPlaces,nbRepas,nbStands,
        mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt FROM temp_entreprise WHERE IDEnt = '.$id.';');
        $statement->execute();
        $statement = $this->connexion->prepare('DELETE FROM temp_entreprise WHERE IDEnt = '.$id.';');
        $statement->execute();
        $statement = $this->connexion->prepare('SELECT * FROM entreprise ORDER BY IDEnt DESC LIMIT 1;');
        $statement->execute();
        $ent = $statement->fetch();
        $this->deconnexion();
        $tabConfig = $this->getConfiguration();
        $idEnt = $ent['IDEnt'];
        $formationsRecherchees = $ent['formationsRecherchees'];
        $nbStands = $ent['nbStands'];
        $disponibilite = $ent['typeCreneau'];
        $creationFormation = new Formation($idEnt, $formationsRecherchees, $nbStands, $disponibilite, $tabConfig['nbCreneauxMatin'], $tabConfig['nbCreneauxAprem']);
        $creationFormation->createForm();
        return;
      }

      public function gelerEtudiant($id) {
        $this->connexion();
        $statement = $this->connexion->prepare('INSERT INTO temp_etudiant(nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu,listechoixEtu) SELECT nomEtu,prenomEtu,mailEtu,mdpEtu,numtelEtu,formationEtu,listechoixEtu FROM etudiant WHERE IDEtu = '.$id.';');
        $statement->execute();
        $this->deconnexion();
        $this->connexion();
        $statement = $this->connexion->prepare('DELETE FROM etudiant WHERE IDEtu = '.$id.';');
        $statement->execute();
        $this->deconnexion();
        return;
      }

      public function gelerEntreprise($id) {
        $this->connexion();
        $statement = $this->connexion->prepare('INSERT INTO temp_entreprise(nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbPlaces,nbRepas,nbStands,
          mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt) SELECT nomEnt,mdpEnt,typeCreneau,formationsRecherchees,nbPlaces,nbRepas,nbStands,
          mailEnt,nomContact,prenomContact,numTelEnt,codePostal,villeEnt,adresseEnt FROM entreprise WHERE IDEnt = '.$id.';');
          $statement->execute();
          $this->deconnexion();
          $this->connexion();
          $statement = $this->connexion->prepare('DELETE FROM entreprise WHERE IDEnt = '.$id.';');
          $statement->execute();
          $statement = $this->connexion->prepare('DELETE FROM formation WHERE entPropose = '.$id.';');
          $statement->execute();
          $this->deconnexion();
          return;
        }

        public function supprimerEtu($id) {
          $this->connexion();
          $statement = $this->connexion->prepare('DELETE FROM etudiant WHERE IDEtu = '.$id.';');
          $statement->execute();
          $this->deconnexion();
          return;
        }

        public function supprimerEtuTemp($id) {
          $this->connexion();
          $statement = $this->connexion->prepare('DELETE FROM temp_etudiant WHERE IDEtu = '.$id.';');
          $statement->execute();
          $this->deconnexion();
          return;
        }

        public function supprimerEnt($id) {
          $this->connexion();
          $statement = $this->connexion->prepare('DELETE FROM entreprise WHERE IDEnt = '.$id.';');
          $statement->execute();
          $this->deconnexion();
          return;
        }

        public function supprimerEntTemp($id) {
          $this->connexion();
          $statement = $this->connexion->prepare('DELETE FROM temp_entreprise WHERE IDEnt = '.$id.';');
          $statement->execute();
          $this->deconnexion();
          return;
        }

        public function getEtu($id) {
          $this->connexion();
          $statement = $this->connexion->prepare('SELECT * FROM etudiant WHERE IDEtu ='.$id.';');
          $statement->execute();
          $this->deconnexion();
          return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
        }

        public function getTempEtu($id) {
          $this->connexion();
          $statement = $this->connexion->prepare('SELECT * FROM temp_etudiant WHERE IDEtu ='.$id.';');
          $statement->execute();
          $this->deconnexion();
          return $statement->fetchAll(PDO::FETCH_CLASS, "Etudiant");
        }

        public function getEnt($id) {
          $this->connexion();
          $statement = $this->connexion->prepare('SELECT * FROM entreprise WHERE IDEnt ='.$id.';');
          $statement->execute();
          $this->deconnexion();
          return $statement->fetchAll(PDO::FETCH_CLASS, "Entreprise");
        }

        public function getTempEnt($id) {
          $this->connexion();
          $statement = $this->connexion->prepare('SELECT * FROM temp_entreprise WHERE IDEnt ='.$id.';');
          $statement->execute();
          $this->deconnexion();
          return $statement->fetchAll(PDO::FETCH_CLASS, "Entreprise");
        }

        //Pour la table scriptconfig

        public function getConfiguration() {
          $this->connexion();
          $statement = $this->connexion->prepare('SELECT * FROM scriptconfig;');
          $statement->execute();
          $this->deconnexion();
          return $statement->fetch();
        }

        public function getNbCreneaux()  {
          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT nbCreneauxMatin, nbCreneauxAprem FROM scriptconfig;');
            $statement->execute();
            $tabResult = $statement->fetch();
            $ret[0] = $tabResult['nbCreneauxMatin'];
            $ret[1] = $tabResult['nbCreneauxAprem'];
            $this->deconnexion();
            return $ret;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        public function getNomEtudiant($IDEtu)  {

          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT nomEtu FROM etudiant WHERE IDEtu = "'.$IDEtu.'";');
            $statement->execute();
            $this->deconnexion();
            if ($result = $statement->fetch()) {
              return $result['nomEtu'];
            } else {
              return "-----------";
            }
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        public function editHeureDebutMatin($new) {
          $this->connexion();
          $statement = $this->connexion->prepare("UPDATE scriptconfig SET heureDebutMatin='".$new."';");
          $statement->execute();
          $this->deconnexion();
          return;
        }

        public function editHeureDebutAprem($new) {
          $this->connexion();
          $statement = $this->connexion->prepare("UPDATE scriptconfig SET heureDebutAprem='".$new."';");
          $statement->execute();
          $this->deconnexion();
          return;
        }

        public function editNbCreneauxMatin($new) {
          $this->connexion();
          $statement = $this->connexion->prepare("UPDATE scriptconfig SET nbCreneauxMatin=".$new.";");
          $statement->execute();
          $this->deconnexion();
          return;
        }

        public function editNbCreneauxAprem($new) {
          $this->connexion();
          $statement = $this->connexion->prepare("UPDATE scriptconfig SET nbCreneauxAprem=".$new.";");
          $statement->execute();
          $this->deconnexion();
          return;
        }

        public function editDureeCreneau($new) {
          $this->connexion();
          $statement = $this->connexion->prepare("UPDATE scriptconfig SET dureeCreneau=".$new.";");
          $statement->execute();
          $this->deconnexion();

          return;
        }




        public function getEtudiants($formation)  {

          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT IDEtu, listeChoixEtu, nomEtu FROM etudiant WHERE formationEtu = "'.$formation.'";');
            $statement->execute();
            $tabResult = $statement->fetchAll();
            $this->deconnexion();
            return $tabResult;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        //Pour la table Entreprise

        public function getEntreprises()  {

          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT IDEnt, typeCreneau, formationsRecherchees, nbPlaces FROM entreprise;');
            $statement->execute();
            $tabResult = $statement->fetchAll();
            $this->deconnexion();
            return $tabResult;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        public function getEntreprisesParFormation($formation) {
          $this->connexion();
          $statement = $this->connexion->prepare('SELECT entPropose FROM formation WHERE typeFormation="'.$formation.'";');
          $statement->execute();
          $tabResult = $statement->fetchAll();
          $sortie = array();
          foreach ($tabResult as $id) {
            $statement = $this->connexion->prepare('SELECT * FROM entreprise WHERE IDEnt = '.$id['entreprisePropose'].';');
            $sortie = $statement->fetch();
          }
          $this->deconnexion();
          return $sortie;
        }

        public function getFormationEtudiant($id) {
          $this->connexion();
          $statement = $this->connexion->prepare('SELECT formationEtu FROM etudiant WHERE IDEtu ="'.$id.'";');
          $statement->execute();
          $result = $statement->fetch();
          $this->deconnexion();
          return $result['formationEtu'];
        }

        /////////////////////ATTENTION depuis la table entreprise////////////////////
        public function getEntreprisesEntreprise($formation)  {

          try {
            $this->connexion();
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
            $this->deconnexion();
            return $ret;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        //Pour la table fomration

        public function getFormations($formation)  {

          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT IDformation, entPropose, creneauDebut, creneauFin FROM formation where typeFormation = "'.$formation.'";');
            $statement->execute();
            $tabResult = $statement->fetchAll();
            $this->deconnexion();
            return $tabResult;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        public function getFormationsAffichage($entreprise) {
          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT typeFormation, creneauDebut, creneauFin FROM formation where entPropose = "'.$entreprise.'";');
            $statement->execute();
            $tabResult = $statement->fetchAll();
            $this->deconnexion();
            return $tabResult;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        public function getFormationsEntreprise($entreprise)  {
          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT IDformation, typeFormation FROM formation where entPropose = "'.$entreprise.'";');
            $statement->execute();
            $tabResult = $statement->fetchAll();
            $this->deconnexion();
            return $tabResult;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        public function getIdEntreprise($entreprise)  {

          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT IDEnt FROM entreprise where nomEnt = "'.$entreprise.'";');
            $statement->execute();
            $tabResult = $statement->fetch();
            $this->deconnexion();
            return $tabResult['idEnt'];
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        public function getIDFormation($formation, $entreprise)  {

          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT IDformation FROM formation WHERE typeFormation = "'.$formation.'" AND entPropose = "'.$entreprise.'";');
            $statement->execute();
            $tabResult = $statement->fetch();

            $ret = $tabResult['IDformation'];
            $this->deconnexion();
            return $ret;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        //Pour la table scriptconfig


        //Pour la table creneau
        public function supprimerCreneau() {
          try {
            $this->connexion();
            $statement = $this->connexion->prepare('DELETE FROM creneau;');
            $statement->execute();
            $this->deconnexion();

          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        public function ajoutCreneau($numCreneau, $IDformation, $etudiant) {
          try {
            $this->connexion();
            $statement = $this->connexion->prepare('INSERT INTO creneau VALUES ("'.$numCreneau.'", "00:00:00", "00:00:00", "'.$IDformation.'",  "'.$etudiant.'");');
            $statement->execute();
            $this->deconnexion();
            return;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        public function getCreneau($numeroCreneau, $idFormation)  {

          try {
            $this->connexion();
            $statement = $this->connexion->prepare('SELECT idEtudiant FROM creneau WHERE numeroCreneau = "'.$numeroCreneau.'" AND idFormation = "'.$idFormation.'";');
            $statement->execute();
            if ($tabResult = $statement->fetch()) {
              $ret = $tabResult['idEtudiant'];
            } else {
              $ret = False;
            }
            $this->deconnexion();
            return $ret;
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }

        //Pour la table formation
        public function ajoutFormation($typeFormation, $entPropose, $creneauDebut, $creneauFin) {
          try {
            $this->connexion();
            $statement = $this->connexion->prepare('INSERT INTO formation(typeFormation,entPropose, creneauDebut, creneauFin) VALUES ("'.$typeFormation.'", '.$entPropose.', '.$creneauDebut.', '.$creneauFin.');');
            $statement->execute();
            $this->deconnexion();
          } catch (TableAccesException $e) {
            print($e -> getMessage());
          }
        }



        public function getDetails() {
          $sortie = array('nbEtu' => 0, 'nbEnt' => 0, 'nbRepas' => 0);
          $this->connexion();
          $statement = $this->connexion->prepare("SELECT * FROM entreprise;");
          $statement->execute();
          $this->deconnexion();
          $tab_temp = $statement->fetchAll();
          $sortie['nbEnt'] = sizeof($tab_temp);
          $this->connexion();
          $statement = $this->connexion->prepare("SELECT * FROM etudiant;");
          $statement->execute();
          $this->deconnexion();
          $tab_temp = $statement->fetchAll();
          $sortie['nbEtu'] = sizeof($tab_temp);
          $this->connexion();
          $statement = $this->connexion->prepare("SELECT * FROM entreprise WHERE nbRepas > 0;");
          $statement->execute();
          $this->deconnexion();
          $tab_temp = $statement->fetchAll();
          $sortie['nbRepas'] = sizeof($tab_temp);
          return $sortie;
        }

        public function getId($identifiant,$type) {
          if ($type=="admin") {
            return 0;
          }
          if ($type=="entreprise") {
            $select = "IDEnt";
            $mail = "mailEnt";
          }
          else {
            $select = "IDEtu";
            $mail = "mailEtu";
          }
          $this->connexion();
          $statement = $this->connexion->prepare("SELECT ".$select." FROM ".$type." where ".$mail."='".$identifiant."';");
          $statement->execute();
          $this->deconnexion();
          $tab = $statement->fetch();
          if ($type=="entreprise") {
            return $tab['IDEnt'];
          }
          else {
            return $tab['IDEtu'];
          }
        }

        public function generatePlanning(){
          $this -> supprimerCreneau();
          $this -> connexion();

          $statement = $this->connexion->prepare("DELETE FROM creneau;");
          $statement->execute();

          $arrayNbCreneaux = $this -> getNbCreneaux();
          $creneauMatin = $arrayNbCreneaux[0];
          $creneauAprem = $arrayNbCreneaux[1];
          $nbCreneaux = $creneauMatin + $creneauAprem;

          $Etudiants = array();
          $Choix = array();
          $Entreprises = array();
          $Creneaux = array();
          $LiensEntrCren = array();
          $Formations = array();


          $listeEtu = $this->getEtudiants("Informatique");

          //On s'occupe de $Etudiants
          $cmp = 0;
          foreach ($listeEtu as $etu){
            $Etudiants[$cmp+1] = $etu["IDEtu"];
            $Choix[] = explode ( "," , $etu["listeChoixEtu"]);
            $cmp++;
          }

          //On s'occupe de $Entreprises, $Creneaux et $LiensEntrCren
          $listeEnt = $this -> getEntreprises();
          foreach ($listeEnt as $ent){
            $Entreprises[] = $ent["IDEnt"];
          }
          $listeFormation = $this -> getFormations("Informatique");

          foreach ($Entreprises as $IDent) {
            $LiensEntrCren[$IDent][0] = 0;
          }

          $cmp = 0;
          foreach ($listeFormation as $form){
            $Formations[] = $form["IDformation"];

            $LiensEntrCren[$form["entPropose"]][0]++;
            $LiensEntrCren[$form["entPropose"]][$LiensEntrCren[$form["entPropose"]][0]] = $cmp;

            for ($i = 0; $i < $nbCreneaux; $i++) {
              $tmp[] = 0;
            }
            for ($i = $creneauDebut; $i < $creneauFin; $i++) {
              $tmp[$i] = 1;
            }

            $Creneaux[] = $tmp;
            $cmp++;
          }


          $jobMeeting = new jobMeeting($Etudiants, $Choix, $Entreprises, $Creneaux, $LiensEntrCren, $Formations,  $nbCreneaux);
          $jobMeeting -> appli();

          $this -> deconnexion();
        }


        /*
          Nom entreprise
          Ville
          CP
          Adresse
          Dispo
          nom contact
          prenom contact
          email
          téléphone
          recherche
          nb stands
          nb repas
          mdp
        */
      public function editNomEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET nomEnt='".$new."' WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editVilleEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET villeEnt='".$new."' WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editCPEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET codePostal=".$new." WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editAdresseEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET adresseEnt='".$new."' WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editNomContactEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET nomContact='".$new."' WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editPrenomContactEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET prenomContact='".$new."' WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editMailEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET mailEnt='".$new."' WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editTelephoneEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET numTelEnt='".$new."' WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editFormationsRechercheesEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET formationsRecherchees='".$new."' WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editTypeCreneauEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET typeCreneau='".$new."' WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editNbStandsEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET nbStands=".$new." WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editNbRepasEntreprise($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE entreprise SET nbRepas=".$new." WHERE IDEnt = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editMdpEntreprise($id,$new,$old) {
        $this->connexion();
        $statement = $this->connexion->prepare('SELECT mailEnt FROM entreprise WHERE IDEnt ='.$id.';');
        $statement->execute();
        $this->deconnexion();
        $result = $statement->fetch();
        $login = $result['mailEnt'];
        if ($this -> verifieMotDePasse($login, $old)) {
          $this->connexion();
          $statement = $this->connexion->prepare("UPDATE entreprise SET mdpEnt='".crypt($new)."' WHERE IDEnt = ".$id.";");
          $statement->execute();
          $this->deconnexion();
          return;
        }
        else {
          echo '<script>alert("Attention votre mot de passe ne correspond pas : le changement n\'est pas pris en compte.");</script>';
          return;
        }
      }


      public function editNomEtudiant($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE etudiant SET nomEtu='".$new."' WHERE IDEtu = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editPrenomEtudiant($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE etudiant SET prenomEtu='".$new."' WHERE IDEtu = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editMailEtudiant($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE etudiant SET mailEtu='".$new."' WHERE IDEtu = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editTelephoneEtudiant($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE etudiant SET numtelEtu='".$new."' WHERE IDEtu = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }
      public function editFormationEtudiant($id,$new) {
        $this->connexion();
        $statement = $this->connexion->prepare("UPDATE etudiant SET formationEtu='".$new."' WHERE IDEtu = ".$id.";");
        $statement->execute();
        $this->deconnexion();
        return;
      }

      public function editMdpEtudiant($id,$new,$old) {
        $this->connexion();
        $statement = $this->connexion->prepare('SELECT mailEtu FROM etudiant WHERE IDEtu ='.$id.';');
        $statement->execute();
        $this->deconnexion();
        $result = $statement->fetch();
        $login = $result['mailEtu'];
        if ($this -> verifieMotDePasse($login, $old)) {
          $this->connexion();
          $statement = $this->connexion->prepare("UPDATE etudiant SET mdpEtu='".crypt($new)."' WHERE IDEtu = ".$id.";");
          $statement->execute();
          $this->deconnexion();
          return;
        }
        else {
          echo '<script>alert("Attention votre mot de passe ne correspond pas : le changement n\'est pas pris en compte.");</script>';
          return;
        }
      }

      public function supprimerFormation($idEntreprise){
        $this -> connexion();
        $statement = $this->connexion->prepare('DELETE FROM formation WHERE entPropose = '.$idEntreprise.';');
        $statement -> execute();
        $this -> deconnexion();
      }

      }
      ?>
