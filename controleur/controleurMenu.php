<?php
require_once __DIR__."/../vue/vueMenu.php";


class ControleurMenu{
 
 private $vue;
 private $dao;
 
 public function __construct(){
 $this->vue=new VueMenu();
 $this->dao = new Dao();
 }
 
// demandera à VueMenu de générer une vue correspondant au choix du menu selon le type de connexion
 public function afficherMenu($pos) {
 	if ($pos == 1) {
 		$this->vue->afficherPlanning();
 	}
 	if ($pos == 2) {
 		if ($_SESSION['type_connexion'] == "entreprise") {
 			
 		}
 		if ($_SESSION['type_connexion'] == "etudiant") {
 			
 		}
 		if ($_SESSION['type_connexion'] == "admin") {
 			$this->vue->afficherComptes();
 		}
 	}
 	if ($pos == 3) {
 		if ($_SESSION['type_connexion'] == "entreprise") {
 			
 		}
 		if ($_SESSION['type_connexion'] == "etudiant") {
 			
 		}
 		if ($_SESSION['type_connexion'] == "admin") {
 			
 		}
 	}
 	if ($pos == 4) {
 		if ($_SESSION['type_connexion'] == "etudiant") {
 			
 		}
 		if ($_SESSION['type_connexion'] == "admin") {
 			
 		}
 	}
 }

}
