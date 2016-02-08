<?php

require 'dao/dao.php';

class Formation {

  private $IDent;
  private $form = array();
  private $nbForm;
  private $nbPers;
  private $periode;

  private $nbCreneauxMatin;
  private $nbCreneauxAprem;
  private $nbCreneaux;
  private $crenOrigin;


  private $ArrayForm = array();

  function __construct($IDentreprise, $formation, $nbPersonne, $periode, $nbCreneauxMatin, $nbCreneauxAprem)
  {
    $this -> IDent = $IDentreprise;
    $this -> form = explode(",",$formation);
    $this -> nbForm = sizeof($this -> form);
    $this -> nbPers = $nbPersonne;
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
        $this -> nbCreneaux = $this -> nbCreneauxAprem;
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

    $crenAmD = $this -> crenOrigin; #debut matin
    $crenPmD = $this -> nbCreneauxAprem + 1; #debut aprem
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
    if($this -> periode == "journee") {
      // une personne pour une formation
      if($this -> nbForm == 1 && $this -> nbPers == 1){
        $dao -> ajoutFormation($this -> form[0], $this -> IDent, $crenAmD, $crenPmF);
        $this -> ArrayForm[] = array($this -> form[0], $this -> IDent, "", $crenAmD, $crenPmF);
      }
      // k*nbForm = k*nbPers
      else if($this -> nbForm == $this -> nbPers){
        foreach ($this -> form as $value) {
          $dao -> ajoutFormation($value, $this -> IDent, $crenAmD, $crenPmF);
          $this -> ArrayForm[] = array($value, $this -> IDent, "", $crenAmD, $crenPmF);
        }
      }
      // si nbForm = 2*nbPers
      else if(($this -> nbForm / $this -> nbPers) == 2){
        $cpt = 0;
        for ($i=0; $i < $this -> nbPers; $i++) {
          $dao -> ajoutFormation($this -> form[$cpt], $this -> IDent, $crenAmD, $crenAmF);
          $this -> ArrayForm[] = array($this -> form[$cpt], $this -> IDent, "", $crenAmD, $crenAmF);
          $dao -> ajoutFormation($this -> form[$cpt+1], $this -> IDent, $crenPmD, $crenPmF);
          $this -> ArrayForm[] = array($this -> form[$cpt+1], $this -> IDent, "", $crenPmD, $crenPmF);
          $cpt += 2;
        }
      }
      //si nbForm - 1 = nbPers
      else if(($this -> nbForm - 1) == $this -> nbPers){
        for ($i=0; $i < $this -> nbPers; $i++) {
          $dao -> ajoutFormation($this -> form[0], $this -> IDent, $crenAmD, $crenAmF);
          $this -> ArrayForm[] = array($this -> form[0], $this -> IDent, "", $crenAmD, $crenAmF);
          $dao -> ajoutFormation($this -> form[$i+1], $this -> IDent, $crenPmD, $crenPmF);
          $this -> ArrayForm[] = array($this -> form[$i+1], $this -> IDent, "", $crenPmD, $crenPmF);
        }
      }
      // si nbForm = 2*nbPers + k personne
      else if($this -> nbForm > $this -> nbPers){
        $this -> autreCas();
      }
      // si nbPers > nbForm
      else if(($this -> nbPers > $this -> nbForm)){
        $cpt = $this -> nbPers;
        for ($i=0; $i < ceil($this -> nbPers/$this -> nbForm); $i++) {
          foreach ($this -> form as $value) {
            if($cpt > 0){
              $dao -> ajoutFormation($value, $this -> IDent, $crenAmD, $crenPmF);
              $this -> ArrayForm[] = array($value, $this -> IDent, "", $crenAmD, $crenPmF);
            }
            $cpt --;
          }
        }
      }
      else{
        echo "erreur lors de la création des formations : données incorrectes";
        return null;
      }
    }
    #############################
    #         AUTRE CAS         #
    #############################
    else {
      $this -> autreCas();
    }
    $dao-> deconnexion();
    return $this -> ArrayForm;
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

    $crenForm = floor(($nbCreneaux/$this -> nbForm)*$this -> nbPers);
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
      $dao -> ajoutFormation($value, $this -> IDent, $crenDebut, $crenFin);
      $this -> ArrayForm[] = array($value, $this -> IDent, "", $crenDebut, $crenFin);
      $crenDebut = $crenFin + 1;
      $crenRestant -= $crenForm;
    }
    $dao -> deconnexion();  
    return $this -> ArrayForm;
  }


  public static function afficherForm($listeFormations) { // array[nomFormation, creneauDebut, creneauFin]
    echo "<table border=1px >
    <tr>
      <td style='text-align:center' colspan=3>
        Formation
      </td>
    </tr>
    <tr>
      <td>
        Nom de la formation
      </td>
      <td>
        Debut periode
      </td>
      <td>
        Fin periode
      </td>
    </tr>";
    foreach ($listeFormations as $formation) {
      echo "<tr>";
        echo "<td>";
          echo $formation[0]; //nom formation
        echo "</td>";
        echo "<td>";
          echo $formation[1]; //creneau debut
        echo "</td>";
        echo "<td>";
          echo $formation[2]; //creneau fin
        echo "</td>";
      echo "</tr>";
    }
    echo "</table>";
  }
}
?>
