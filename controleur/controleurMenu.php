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
 		if ($_SESSION['type_connexion'] == "entreprise") {
 			$this->vue->afficherPlanningEnt();
 		}
 		if ($_SESSION['type_connexion'] == "etudiant") {
 			$this->vue->afficherPlanningEtu();
 		}
 		if ($_SESSION['type_connexion'] == "admin") {
 			$this->vue->afficherPlanningAdmin();
 		}
 	}
 	if ($pos == 2) {
 		if ($_SESSION['type_connexion'] == "entreprise") {
 			$this->vue->afficherFormations();
 		}
 		if ($_SESSION['type_connexion'] == "etudiant") {
 			$this->vue->afficherChoix();
 		}
 		if ($_SESSION['type_connexion'] == "admin") {
 			$this->vue->afficherComptes();
 		}
 	}
 	if ($pos == 3) {
 		if ($_SESSION['type_connexion'] == "entreprise") {
 			$this->vue->afficherCompteEnt();
 		}
 		if ($_SESSION['type_connexion'] == "etudiant") {
 			$this->vue->afficherEntreprises();
 		}
 		if ($_SESSION['type_connexion'] == "admin") {
 			$this->vue->afficherConfig();
 		}
 	}
 	if ($pos == 4) {
 		if ($_SESSION['type_connexion'] == "etudiant") {
 			$this->vue->afficherCompteEtu();
 		}
 		if ($_SESSION['type_connexion'] == "admin") {
 			$this->vue->afficherAutres();
 		}
 	}
 }

}
