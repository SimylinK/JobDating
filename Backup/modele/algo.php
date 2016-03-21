<?php

/**
 * @author Jobdating
 * @version 1.0
 */
class JobMeeting {
  var $CASE_VIDE = 0; //constante qui represente une case vide pour l'echiquiers
  var $Gauss = '0';
  var $nbChoixASatisfaire = 5;// au max est egal a la moitie des creneauxs
  var $Echiquier;
  var $Formations;
  var $Etudiants;
  var $Choix;


  var $Entreprises;
  var $LiensEntrCren;
  var $Creneaux;
  var $nbCreneaux;

  var $satisfait = array();
  var $Max = 0;// un choix pour chaque ETUDIANT

  //Va peremttre de mémoriser si l'étudiant à déjà un entretient vace l'entreprise
  var $EntretiensEntrepriseEtudiant = array();

  function __construct($c_Etudiants, $c_Choix, $c_Entreprises, $c_Creneaux, $c_LiensEntrCren , $c_Formations, $c_nbCreneaux) {
    $this -> Etudiants = $c_Etudiants;
    $this -> Choix = $c_Choix;
    $this -> Entreprises = $c_Entreprises;
    $this -> Creneaux = $c_Creneaux;
    $this -> LiensEntrCren = $c_LiensEntrCren;
    $this -> Formations = $c_Formations;
    $this -> nbCreneaux = $c_nbCreneaux;
  }

  function appli() {
    $this -> initEchiquier();

    for ($l = 0; $l < $this -> nbChoixASatisfaire; $l++) {
      $this -> Max++;

      for ($etudiant = 1; $etudiant <= sizeof($this -> Etudiants); $etudiant++) {
        if (sizeof($this -> Choix[$etudiant-1]) >= $l+1) {
          $this -> placeETUDIANT($etudiant, $l);
          $this -> Gauss = '0';// un ecart de 2 choix peut se produire. Il faut trier par "Satisfait" pour etablir un equilibre
        }
      }
    }
    $this -> afficheEchiquier();
  }

  //Fonction qui va diviser les entreprises avec plusieurs créneaux simultané

  //Fonction qui va initialiser les tableaux Echiquier et Satisfait
  function initEchiquier(){
    //On regarde la taille que doit avoir l'échiquier
    $taille = 0;

    foreach ($this -> Entreprises as $IDent) {
      $taille += $this -> LiensEntrCren[$IDent][0];
      if ($this -> LiensEntrCren[$IDent][0] == 0)
        $taille++;
      for ($etudiant = 1; $etudiant <= sizeof($this -> Etudiants); $etudiant++) {
        $this -> EntretiensEntrepriseEtudiant[$IDent][$etudiant] = false;
      }
    }


    for($l = 0; $l < $taille; $l++) {
      for($c = 0; $c< $this -> nbCreneaux; $c++) {
        $this -> Echiquier[$l][$c] = $this -> CASE_VIDE;
      }
    }
    for($c = 0; $c < sizeof($this -> Etudiants); $c++) {
      $this -> satisfait[$c] = 0;
    }
  }

  /* Place la ETUDIANT sur la ligne l et les suivantes recursivement
  /Place un etudiant
  /
  */
  function placeEtudiant($etu, $l) {
    if ($l == $this -> Max) {
      $this -> Gauss = '1';
    } else {
      $c = 0;
      $l1 = $this -> Choix[$etu-1][$l];//Choix de l'etudiant

      if (in_array($l1, $this->Entreprises)) {//On vérifie que l'entreprise existe
        while($c < $this -> nbCreneaux && $this -> Gauss == '0'){
          //On regarde pour 1 heure tous les créneaux de l'entreprise
          $i = 1;
          $nonPlace = True;
          while($i <=  $this -> LiensEntrCren[$l1][0] && $nonPlace) {
            $numCreneau = $this -> LiensEntrCren[$l1][$i];

            if ($this -> bienPlace($etu, $numCreneau, $c, $l1)
            && $this -> Echiquier[$numCreneau][$c] == $this -> CASE_VIDE) {

                if ($this -> Creneaux[$numCreneau][$c] != $this -> CASE_VIDE) {
                  $this -> satisfait[$etu-1]++;
                  $this -> Echiquier[$numCreneau][$c] = $etu;
                  $this -> Creneaux[$numCreneau][$c] = $this -> CASE_VIDE;

                  $this -> placeEtudiant($etu, $l + 1);
                  $this -> EntretiensEntrepriseEtudiant[$l1][$etu] = true;
                  $nonPlace = False;

                  if ($this -> Gauss == '0') {
                    $this -> Echiquier[$numCreneau][$c] = $this -> CASE_VIDE;
                    $this -> satisfait[$etu-1]--;
                    $this -> Creneaux[$numCreneau][$c] = 1;
                    $nonPlace = True;
                    $this -> EntretiensEntrepriseEtudiant[$l1][$etu] = false;
                  }
                }

              }
            $i++;
            }
        $c++;
        }
      }
    }
  }

  // Verifie qu'une ETUDIANT placee en (l,c) n'est pas en prise avec une des
  // ETUDIANTs deja placees.
  function bienPlace($etu, $l, $c, $entreprise) {
    for($i = 0; $i < $l; $i++) {
      if($this -> Echiquier[$i][$c] == $etu // meme colonne  de 1 au choix de l'etudiant
      || ($c > 0 && $this -> Echiquier[$i][$c-1] == $etu) //m�me colonne c-1
      || ($c < 9 && $this -> Echiquier[$i][$c+1] == $etu)) { // m�me colonne c+1
        return False;
      }
    }
    $i = $l + 1;
    while ($i < sizeof($this->Entreprises)) {
      if($this -> Echiquier[$i][$c] == $etu  // m�me colonne du choix de l'etudiant a la fin
      || ($c > 0 && $this -> Echiquier[$i][$c-1] == $etu) // colonne c-1
      || ($c < 9 && $this -> Echiquier[$i][$c+1] == $etu)) { // colonne c+1
        return False;
      }
      $i++;
    }
    if($this -> EntretiensEntrepriseEtudiant[$entreprise][$etu] == true)
      return false;


    return True;
  }

  function afficheEchiquier() { //Affichage en html, tableau
    $dao=new dao();
    $dao->connexion();
    $cmp = 0;
    //for($l = 0; $l < sizeof($this -> Entreprises); $l++) {
    foreach ($this-> Entreprises as $IDent) {
      for ($e = 1; $e <= $this -> LiensEntrCren[$IDent][0]; $e++) {
        for($c = 0; $c < $this -> nbCreneaux; $c++) {

          $Etu = $this -> Echiquier[$this -> LiensEntrCren[$IDent][$e]][$c];
          if ($Etu != 0) { // nom de l'etudiant
            $dao -> ajoutCreneau($c, $this -> Formations[$cmp], $this -> Etudiants[$Etu]);
          }
        }
        $cmp++;
      }
    }
    $dao -> deconnexion();
  }
}

?>
