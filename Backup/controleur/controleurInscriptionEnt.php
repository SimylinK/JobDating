<?php
require_once __DIR__."/../vue/vueInscriptionEnt.php";


class ControleurInscriptionEnt {
 
 private $vue;
 
 public function __construct(){
 $this->vue=new VueInscriptionEnt();
 }
 

public function inscriptionEnt(){
$this->vue->afficherFormulaireEnt();
}

}