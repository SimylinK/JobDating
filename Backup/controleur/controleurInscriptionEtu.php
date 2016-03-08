<?php
require_once __DIR__."/../vue/vueInscriptionEtu.php";


class ControleurInscriptionEtu{
 
 private $vue;
 
 public function __construct(){
 $this->vue=new VueInscriptionEtu();
 }
 

public function inscriptionEtu(){
$this->vue->afficherFormulaireEtu();
}

}
