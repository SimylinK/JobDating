<?php
require_once __DIR__."/../vue/vueConfirmationInscription.php";


class ControleurConfirmationInscription{
 
 private $vue;
 
 public function __construct(){
 $this->vue=new VueConfirmationInscription();
 }
 

public function genereVueConfirmationInscription(){
$this->vue->genereVueConfirmationInscription();
}

}
