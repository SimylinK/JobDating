<?php
require_once __DIR__."/../vue/vueProfil.php";


class ControleurProfil{
 
 private $vue;
 
 public function __construct(){
 $this->vue=new VueProfil();
 }
 
// demandera à VueMenu de générer une vue correspondant au choix du menu selon le type de connexion
 public function afficherProfil($type,$profil) {
 	if (isset($profil[0]))
 		$this->vue->afficherProfil($type,$profil[0]);
 	else
 		header('Location:index.php');
 }

}