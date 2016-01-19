<?php

require 'dao/daoAlgo.php';

class Formation {

  private $IDent;
  private $form = array();
  private $nbForm;
  private $nbPers;
  private $periode;

  private $ArrayForm = array();

  function __construct($IDentreprise, $formation, $nbPersonne, $periode)
  {
    $this -> IDent = $IDentreprise;
    $this -> form = explode(",",$formation);
    $this -> nbForm = sizeof($this -> form);
    $this -> nbPers = $nbPersonne;
    $this -> periode = $periode;
  }

  public function createForm(){
    $dao=new daoAlgo();
    $dao->connexion();
    #############################
    #          JOURNEE          #
    #############################
    if($this -> periode == "journee") {
      // une personne pour une formation
      if($this -> nbForm == 1 && $this -> nbPers == 1){
        echo"Test1";
        $dao -> ajoutFormation($this -> form[0], $this -> IDent, "journee");
        $this -> ArrayForm[] = array($this -> form[0], $this -> IDent, "", "journee");
      }
      // k*nbForm = k*nbPers
      else if($this -> nbForm == $this -> nbPers){
        foreach ($this -> form as $value) {
          echo"Test2";
          $dao -> ajoutFormation($value, $this -> IDent, "journee");
          $this -> ArrayForm[] = array($value, $this -> IDent, "", "journee");
        }
      }
      // si nbForm = 2*nbPers
      else if(($this -> nbForm / $this -> nbPers) == 2){
        $cpt = 0;
        for ($i=0; $i < $this -> nbPers; $i++) {
          echo"Test3";
          $dao -> ajoutFormation($this -> form[$cpt], $this -> IDent, "matin");
          $this -> ArrayForm[] = array($this -> form[$cpt], $this -> IDent, "", "matin");
          echo"Test4";
          $dao -> ajoutFormation($this -> form[$cpt+1], $this -> IDent, "apres_midi");
          $this -> ArrayForm[] = array($this -> form[$cpt+1], $this -> IDent, "", "apres_midi");
          $cpt += 2;
        }
      }
      // si nbForm = 2*nbPers + k personne
      else if($this -> nbForm > $this -> nbPers){
        $cpt = 0;
        for ($i=0; $i < ($this -> nbForm % $this -> nbPers); $i++) {
          $this -> ArrayForm[] = array($this -> form[$cpt], $this -> IDent, "", "matin");
          echo"Test4";
          $dao -> ajoutFormation($this -> form[$cpt], $this -> IDent, "matin");
          $this -> ArrayForm[] = array($this -> form[$cpt+1], $this -> IDent, "", "apres_midi");
          echo"Test5";
          $dao -> ajoutFormation($this -> form[$cpt+1], $this -> IDent, "apres_midi");
          $cpt += 2;
        }
        echo"Test6";
        $dao -> ajoutFormation($this -> form[$cpt], $this -> IDent, "journee");
        $this -> ArrayForm[] = array($this -> form[$cpt], $this -> IDent, "", "journee");
      }
      // si nbPers > nbForm
      else if(($this -> nbPers > $this -> nbForm)){
        $cpt = $this -> nbPers;
        for ($i=0; $i < ceil($this -> nbPers/$this -> nbForm); $i++) {
          foreach ($this -> form as $value) {
            if($cpt > 0){
              echo"Test7";
              $dao -> ajoutFormation($value, $this -> IDent, "journee");
              $this -> ArrayForm[] = array($value, $this -> IDent, "", "journee");
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
      $cpt = $this -> nbPers;
      for ($i=0; $i < ceil($this -> nbPers/$this -> nbForm); $i++) {
        foreach ($this -> form as $value) {
          if($cpt > 0){
            echo"Test8";
            $dao -> ajoutFormation($value, $this -> IDent, $this -> periode);
            $this -> ArrayForm[] = array($value, $this -> IDent, "", $this -> periode);
          }
          $cpt --;
        }
      }
    }
    $dao-> deconnexion();
    return $this -> ArrayForm;
  }
}
?>
