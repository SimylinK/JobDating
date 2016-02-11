<?php


require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/formationV2.php";

class VueProfil{



public function afficherProfil($type,$profil){
	if (isset($_SESSION['type_connexion'])) {
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	}
	else {
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauAvantConnexion();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="vue/css/general.css">
	<title></title>
	<meta charset="UTF-8">
</head>
<body>
<?php
	if (isset($_SESSION['type_connexion'])) {
		echo '<div id="main">';
	}
	else {
		echo '<div id="login">';
	}
?>
	<br/><br/>


	<!-- Description profil -->
<?php
	if ($type=="etudiant") {
		echo '<div class="titre_profil">Profil Etudiant</div>
		<br/><br/>
		<span class="categorie_profil">Nom :</span> '.$profil->getNomEtu().'
		<br/><br/><span class="categorie_profil">Prénom :</span> '.$profil->getPrenomEtu().'
		<br/><br/><span class="categorie_profil">Email :</span> <a href="mailto:'.$profil->getMailEtu().'">'.$profil->getMailEtu().'</a>
		<br/><br/><span class="categorie_profil">Téléphone :</span> '.$profil->getNumTelEtu().'
		<br/><br/><span class="categorie_profil">Formation :</span> '.$profil->getFormationEtu().'

		';
	}
	if ($type=="entreprise") {
		$dispo = "";
		if ($profil->getTypeCreneau() == "journee") {
			$dispo = "Journée.";
		}
		if ($profil->getTypeCreneau() == "matin") {
			$dispo = "Matinée.";
		}
		if ($profil->getTypeCreneau() == "apres_midi") {
			$dispo = "Après-midi.";
		}
		echo '<div class="titre_profil">Profil Entreprise</div>
		<br/><br/>
		<span class="categorie_profil">Nom de l\'entreprise :</span> '.$profil->getNomEnt().'
		<br/><br/>
		<span class="categorie_profil">Ville de l\'entreprise :</span> '.$profil->getVilleEnt().'
		<br/><br/>
		<span class="categorie_profil">Code Postal :</span> '.$profil->getCodePostal().'
		<br/><br/>
		<span class="categorie_profil">Adresse :</span> '.$profil->getAdresseEnt().'
		<br/><br/>
		<span class="categorie_profil">Disponibilité :</span> '.$dispo.'
		<br/><br/>
		<span class="categorie_profil">Nom du contact :</span> '.$profil->getPrenomContact().' '.$profil->getNomContact().'
		<br/><br/>
		<span class="categorie_profil">Email :</span> <a href="mailto:'.$profil->getMailEnt().'">'.$profil->getMailEnt().'</a>
		<br/><br/>
		<span class="categorie_profil">Téléphone :</span> '.$profil->getNumTelContact().'
		<br/><br/>
		<span class="categorie_profil">Recherche :</span> '.$profil->getFormationsRecherchees().' pour '.$profil->getNbPlaces().' place(s) disponible(s).
		<br/><br/>
		<span class="categorie_profil">Nombre de sessions en parallèle :</span> '.$profil->getNbStands().'
		<br/><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;Une pause à midi est prévue pour les entretiens qui se déroulent toute la journée.
		';
    $dao = new Dao();
    $id = $profil->getID();

    $listeFormation = $dao -> getFormationsAffichage($id);
    $formation = "Formation";
    $formation::afficherForm($listeFormation);
	}

?>



</div>
	<?php

	echo $util->generePied();

	?>
</body>
</html>

<?php
}
}
?>
