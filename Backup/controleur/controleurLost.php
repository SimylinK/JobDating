<?php
require_once __DIR__."/../vue/vueLost.php";


class ControleurLost{
 
 private $vue;
 
 public function __construct(){
 $this->vue=new VueLost();
 }
 

public function genererLost(){
$this->vue->genereVueLost();
}

}