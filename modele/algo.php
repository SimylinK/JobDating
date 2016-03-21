<?php

class JobMeeting {
  var $CASE_VIDE = 0; //constante qui represente une case vide pour l'echiquiers
  var $Gauss = '0';
  var $nbChoixASatisfaire = 5;// au max est egal a la moitie des creneauxs
  var $Echiquier = array();
  var $Formations = array();

  var $Etudiants = array('Bourreau  ',	'Cadeau     ',	'Nussbaum   ', 'STEPHAN    ', 'Didier     ','Ganivet    ',  'Chcouropat ','Blin       ', 'Gautier    ',
    'Gonnord    ',	'Dubois     ',	'Grailard   ',	'Chappron   ',	'Cadorel    ',	'Creach     ');
  var $Choix = array(array(1,5,2,7,3,4), array(6,5,7,3,4,1), array(6,3,5,1,4,7), array(6,1,5,3,4,7),
array(1,5,6,3,4,7), array(1,4,7,3,6),  array(1,6,5,7,3,4), array(6,3,5,1,7,4), array(1,6,3,7,4,5),
array(6,7,1,5,3,4), array(3,6,5,1,4,7), array(1,7,3,6,5,4),array(7,6,5,1,3,4),
array(1,5,7,3,6,4), array(6,1,7,5,4,3));


  var $Entreprises = array('Capgemini', 'Test', 'Immostore', 'Agena3000', 'Speachme', 'Moovtime', 'PanierLoc');
  var $LiensEntrCren; /*= array(array(2,0,1), array(0), array(1,2), array(1,3), array(1,4), array(1,5), array(1,6));*/
  var $Creneaux; /*= array(array(2,2,2,2,2,2,2,2,2,2), array(1,1,1,1,1,1,1,1,1,1),
array(1,1,1,1,1,1,1,1,1,1), array(1,1,1,1,1,1,1,1,1,1), array(1,1,1,1,1,1,1,1,1,1), array(1,1,1,1,1,1,1,1,1,1));*/
  var $nbCreneaux = 10;
  var $nbStands = 0;

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
    $this -> nbStands = $taille;
  }

  /* Place la ETUDIANT sur la ligne l et les suivantes recursivement
  /Place un etudiant
  /
  */
  function placeEtudiant($etu, $l) {
    $c = 0;
    $l1 = $this -> Choix[$etu-1][$l];//Choix de l'etudiant

    if (in_array($l1, $this->Entreprises)) {//On vérifie que l'entreprise existe
      $nonPlace = True;
      while($c < $this -> nbCreneaux && $this -> Gauss == '0'){
        //On regarde pour 1 heure tous les créneaux de l'entreprise
        $i = 1;

        while($i <=  $this -> LiensEntrCren[$l1][0] && $nonPlace) {
          $numCreneau = $this -> LiensEntrCren[$l1][$i];

          if ($this -> bienPlace($etu, $numCreneau, $c, $l1)
          && $this -> Echiquier[$numCreneau][$c] == $this -> CASE_VIDE) {

              if ($this -> Creneaux[$numCreneau][$c] != $this -> CASE_VIDE) {
                $this -> satisfait[$etu-1]++;
                $this -> Echiquier[$numCreneau][$c] = $etu;
                $this -> Creneaux[$numCreneau][$c] = $this -> CASE_VIDE;

                //$this -> placeEtudiant($etu, $l + 1);
                $this -> Gauss = '1';
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
      if ($nonPlace) {
        if (sizeof($this -> Choix[$etu-1]) >= $l+2) {
          $this -> placeETUDIANT($etu, $l+1);
        }
      }
    }
  }

  // Verifie qu'une ETUDIANT placee en (l,c) n'est pas en prise avec un des
  // ETUDIANTs deja placees.
  function bienPlace($etu, $l, $c, $entreprise) {
    //On vérifie que l'étudiant et libre, et qu'il a une pause avant ou après
    for($i = 0; $i < $this -> nbStands; $i++) {
      if(($c > 0 && $this -> Echiquier[$i][$c-1] == $etu)
      || ($this -> Echiquier[$i][$c] == $etu)
      || ($c < $this -> nbCreneaux-1 && $this -> Echiquier[$i][$c+1] == $etu)) {
        return False;
      }
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
            $dao -> ajoutCreneau($c, $this -> Formations[$IDent][$e-1], $this -> Etudiants[$Etu]);
          }
        }
        $cmp++;
      }
    }
    $dao -> deconnexion();
  }
}

?>
