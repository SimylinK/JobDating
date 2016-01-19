<?php

class Entreprise {
	private $IDEnt;
	private	$nomEnt;
	private $mdpEnt;
	private $typeCreneau;
	private $formationsRecherchees;
	private $nbPlaces;
	private $nbRepas;
	private $mailEnt;
	private $nomContact;
	private $prenomContact;
	private $numTelContact;
	private $codePostal;
	private $villeEnt;
	private $adresseEnt;
	private $nbStands;

	public function getId() {
		return $this->IDEnt;
	}
	public function getNomEnt() {
		return $this->nomEnt;
	}
	public function getmdpEnt() {
		return $this->mdpEnt;
	}
	public function getTypeCreneau() {
		return $this->typeCreneau;
	}
	public function getFormationsRecherchees() {
		return $this->formationsRecherchees;
	}
	public function getNbPlaces() {
		return $this->nbPlaces;
	}
	public function getNbRepas() {
		return $this->nbRepas;
	}
	public function getMailEnt() {
		return $this->mailEnt;
	}
	public function getNomContact() {
		return $this->nomContact;
	}
	public function getPrenomContact() {
		return $this->prenomContact;
	}
	public function getNumTelContact() {
		return $this->numTelContact;
	}
	public function getCodePostal() {
		return $this->codePostal;
	}
	public function getVilleEnt() {
		return $this->villeEnt;
	}
	public function getAdresseEnt() {
		return $this->adresseEnt;
	}
	public function getNbStands() {
		return $this->nbStands;
	}
}

?>