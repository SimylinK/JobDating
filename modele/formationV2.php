<?php

require_once 'dao/dao.php';

class Formation {

  private $IDent;
  private $form = array();
  private $nbForm;
  private $nbSessions;
  private $periode;

  private $nbCreneauxMatin;
  private $nbCreneauxAprem;
  private $nbCreneaux;
  private $crenOrigin;


  private $ArrayForm = array();

  function __construct($IDentreprise, $formation, $nbSessions, $periode, $nbCreneauxMatin, $nbCreneauxAprem)
  {
    $this -> IDent = $IDentreprise;
    $this -> form = explode(",",$formation);
    $this -> nbForm = sizeof($this -> form);
    $this -> nbSessions = $nbSessions;
    $this -> periode = $periode;
    $this -> nbCreneauxMatin = $nbCreneauxMatin;
    $this -> nbCreneauxAprem = $nbCreneauxAprem;

    # calculnbCreneau #
    $this -> crenOrigin = 1;

    switch ($this -> periode) {
      case 'matin':
      $this -> nbCreneaux = $this -> nbCreneauxMatin;
      break;
      case 'apres_midi':
      $this -> nbCreneaux = $this -> nbCreneauxMatin + $this -> nbCreneauxAprem;
      $this -> crenOrigin = $this -> nbCreneauxMatin + 1;
      break;
      default:
      $this -> nbCreneaux = $this -> nbCreneauxMatin + $this -> nbCreneauxAprem;
      break;
    }
  }

  public function createForm(){
    $dao=new Dao();
    $dao->connexion();

    $dao -> supprimerFormation($this -> IDent);

    $crenAmD = $this -> crenOrigin; #debut matin
    $crenPmD = $this -> nbCreneauxMatin + 1; #debut aprem
    $crenAmF = $this -> nbCreneauxMatin; #fin matin
    $crenPmF = $this -> nbCreneaux; #fin aprem et journee

    # # # # # # # # # # # # # # # # # # # #
    #   Am -> matin et Pm -> apres_midi   #
    #   D -> debut et F -> fin            #
    #                                     #
    #   $crenAmD, $crenAmF = matin        #
    #   $crenPmD, $crenPmF = apres_midi   #
    #   $crenAmD, $crenPmF = journee      #
    # # # # # # # # # # # # # # # # # # # #

    # ajoutFormation(formation, IDentreprise, creneauDebut, creneauFin)

    #############################
    #          JOURNEE          #
    #############################
    #if($this -> periode == "journee") {
      // une personne pour une formation
      if($this -> nbForm == 1 && $this -> nbSessions == 1){
        #$dao -> ajoutFormation($this -> form[0], $this -> IDent, $crenAmD, $crenPmF);
        $this -> ArrayForm[] = array($this -> form[0], $this -> IDent, "", $crenAmD, $crenPmF);
      }
      // k*nbForm = k*nbSessions
      else if($this -> nbForm == $this -> nbSessions){
        foreach ($this -> form as $value) {
          #$dao -> ajoutFormation($value, $this -> IDent, $crenAmD, $crenPmF);
          $this -> ArrayForm[] = array($value, $this -> IDent, "", $crenAmD, $crenPmF);
        }
      }
      // si nbForm = 2*nbSessions
      else if(($this -> nbForm / $this -> nbSessions) == 2){
        $cpt = 0;
        echo "test";
        $this -> autreCas();
        /*for ($i=0; $i < $this -> nbSessions; $i++) {
          #$dao -> ajoutFormation($this -> form[$cpt], $this -> IDent, $crenAmD, $crenAmF);
          $this -> ArrayForm[] = array($this -> form[$cpt], $this -> IDent, "", $crenAmD, $crenAmF);
          #$dao -> ajoutFormation($this -> form[$cpt+1], $this -> IDent, $crenPmD, $crenPmF);
          $this -> ArrayForm[] = array($this -> form[$cpt+1], $this -> IDent, "", $crenPmD, $crenPmF);
          $cpt += 2;
        }*/
      }
      //si nbForm - 1 = nbSessions
      else if(($this -> nbForm - 1) == $this -> nbSessions){
        for ($i=0; $i < $this -> nbSessions; $i++) {
          #$dao -> ajoutFormation($this -> form[0], $this -> IDent, $crenAmD, $crenAmF);
          $this -> ArrayForm[] = array($this -> form[0], $this -> IDent, "", $crenAmD, $crenAmF);
          #$dao -> ajoutFormation($this -> form[$i+1], $this -> IDent, $crenPmD, $crenPmF);
          $this -> ArrayForm[] = array($this -> form[$i+1], $this -> IDent, "", $crenPmD, $crenPmF);
        }
      }
      // si nbForm = 2*nbSessions + k personne
      else if($this -> nbForm > $this -> nbSessions){
        $this -> autreCas();
      }
      // si nbSessions > nbForm
      else if(($this -> nbSessions > $this -> nbForm)){
        $cpt = $this -> nbSessions;
        for ($i=0; $i < ceil($this -> nbSessions/$this -> nbForm); $i++) {
          foreach ($this -> form as $value) {
            if($cpt > 0){
              #$dao -> ajoutFormation($value, $this -> IDent, $crenAmD, $crenPmF);
              $this -> ArrayForm[] = array($value, $this -> IDent, "", $crenAmD, $crenPmF);
            }
            $cpt --;
          }
        }

      }else{
        $this -> autreCas();
        // echo "erreur lors de la création des formations : données incorrectes";
        // return null;
      }
    #}
    #############################
    #         AUTRE CAS         #
    #############################
    #else {
      #$this -> autreCas();
    #}
    $dao-> deconnexion();

    foreach ($this -> ArrayForm as $formTest) {
      $dao -> ajoutFormation($formTest[0], $formTest[1], $formTest[3], $formTest[4]);
    }
  }

  public function autreCas() {
    $dao = new Dao();
    $dao->connexion();
    $crenOrigin = 1;
    # calculnbCreneau #
    switch ($this -> periode) {
      case 'matin':
      $nbCreneaux = $this -> nbCreneauxMatin;
      break;
      case 'apres_midi':
      $nbCreneaux = $this -> nbCreneauxAprem;
      $crenOrigin = $this -> nbCreneauxMatin + 1;
      break;
      default:
      $nbCreneaux = $this -> nbCreneauxMatin + $this -> nbCreneauxAprem;
      break;
    }

    $crenForm = floor(($nbCreneaux/$this -> nbForm)*$this -> nbSessions);
    $crenRestant = $nbCreneaux;
    $crenDebut = $crenOrigin;

    foreach ($this -> form as $value) {
      # RESET #
      if ($crenRestant < $crenForm) {
        $crenRestant = $nbCreneaux;
        $crenDebut = $crenOrigin;
      }
      # ADD #
      $crenFin = $crenDebut + $crenForm - 1;
      #$dao -> ajoutFormation($value, $this -> IDent, $crenDebut, $crenFin);
      $this -> ArrayForm[] = array($value, $this -> IDent, "", $crenDebut, $crenFin);
      $crenDebut = $crenFin + 1;
      $crenRestant -= $crenForm;
    }
    $dao -> deconnexion();
    return $this -> ArrayForm;
  }


  public static function afficherForm($listeFormations) { // array[nomFormation, creneauDebut, creneauFin]
    $dao = new Dao();
    $tabConfig = $dao -> getConfiguration();
    $classFormation = "Formation";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <link rel="stylesheet" type="text/css" href="vue/css/general.css">
      <title></title>
      <meta charset="UTF-8">
    </head>
    <body>
      <div id="main">
        <br/>
        <table id="tabFormation">
          <tr>
            <td colspan=4 id="titre"><b> Formations <b></td>
          </tr>
          <tr>
            <td colspan= 1> Nom de la formation </td>
            <td colspan= 1> Debut des entretiens</td>
            <td colspan= 1> Fin des entretiens</td>
            <td colspan= 1> Nombre d'entretiens </td>
          </tr>

          <?php
          //affichage formation + horaire
          foreach ($listeFormations as $formation) {
            echo "<tr id='formation'>";
            echo "<td>";
            echo $formation[0]; //nom formation
            echo "</td>";
            echo "<td>";
            echo $classFormation::calculHoraire($formation[1], $tabConfig, "debut"); //creneau debut
            echo "</td>";
            echo "<td>";
            echo $classFormation::calculHoraire($formation[2], $tabConfig, "fin"); //creneau fin
            echo "</td>";
            echo "<td>";
            $nbEntretiens = $formation[2] - $formation[1] +1;
            echo $nbEntretiens; // nb Entretiens
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </table>
        <?php
      }

      public static function calculHoraire($creneau, $tabConfig, $horaire){
        $duree = $tabConfig["dureeCreneau"];
        $start = 1;
        if($creneau <= $tabConfig["nbCreneauxMatin"]) { // si c'est le matin
          $heureString = $tabConfig["heureDebutMatin"];
        } else { //si c'est l'apres midi
          $heureString = $tabConfig["heureDebutAprem"];
          $start = $tabConfig["nbCreneauxMatin"] + 1;
        }
        $heureString = explode(':', $heureString);
        $heure = $heureString[0];
        $min = $heureString[1];

        if($horaire == "fin"){
          $start --;
        }

        for($i = $start; $i < $creneau; $i++){
          $min += $duree;
          if($min == 60) {
            $min = 0;
            $heure++;
          }
        }

        if($min == 0){
          $min = "00";
        }
        return $heure.':'.$min;
      }

      public static function updateFormation($idEnt){
        $dao=new dao();
        $dao->connexion();
        $entr=$dao->getEnt($idEnt)[0];
        $tabConfig = $dao -> getConfiguration();
        $dao->deconnexion();
        $formation = new formation($entr-> getId(), $entr-> getFormationsRecherchees(), $entr-> getNbStands(), $entr-> getTypeCreneau(), $tabConfig["nbCreneauxMatin"], $tabConfig["nbCreneauxAprem"]);
        $formation -> createForm();
      }

      public static function generateFormation(){
        $dao=new dao();
        $dao->connexion();
        $listeEnt=$dao->getEntreprises();
        $tabConfig = $dao -> getConfiguration();
        $dao->deconnexion();

        foreach ($listeEnt as $entr) {
          $formation = new formation($entr["IDEnt"], $entr["formationsRecherchees"], $entr["nbStands"], $entr["typeCreneau"], $tabConfig["nbCreneauxMatin"], $tabConfig["nbCreneauxAprem"]);
          $formation -> createForm();
        }
      }
    }
      ?>
