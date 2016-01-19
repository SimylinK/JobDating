<?php
require_once __DIR__."/../vue/vueOubliMdp.php";


class ControleurOubliMdp{
 
 private $vue;
 
 public function __construct(){
 $this->vue=new VueOubliMdp();
 }
 

public function aideOubliMdp(){
$this->vue->genereVueOubliMdp();
}

}
