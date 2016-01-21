<?php


require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/bean/Etudiant.php";
require_once __DIR__."/../modele/bean/Entreprise.php";

class VueMenu{

public function afficherPlanningEtu(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/>&nbsp;&nbsp;&nbsp;&nbsp;Bonjour,
		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Bienvenue sur votre espace utilisateur créé à l'occasion des rencontres alternances du 1 avril 2016.

		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Les emplois du temps relatifs à cet événement, le vôtre y compris, n'ont toujours pas été générés. Ceux-ci seront générés le 31 mars.
		L'administrateur vous en informera lorsque ceux-ci seront disponibles.
	</div>
		<?php
		//////////////////////////////////////ATTTENTION METTRE EN PLACE SYSTEME DATE POUR AFFICHER/////////////////////////////////////

		//On génére l'emploi du temps
    $dao = new Dao();
    $tabConfig = $dao -> getConfiguration();
    $tabForm = $dao -> getFormation();

		?>
    <!DOCTYPE html>
  	<html>
  	<head>
  		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
  		<title></title>
  		<meta charset="UTF-8">
  	</head>
  	<body>
  	<div id="main">
  	<br/>

    <table id="tabPlanningEnt">

		<tr>
			<td colspan="7"> Planning </td>
		</tr>
		<tr>
			<td colspan= <?php $tabConfig["nbCreneauxMatin"]?>> Matin </td>
			<td colspan=<?php $tabConfig["nbCreneauxAprem"]?>> Après-midi </td>
		</tr>

		<?php
			//Ici afficher table
		?>
		</table>

    <?php

		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}

public function afficherPlanningEnt(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/>&nbsp;&nbsp;&nbsp;&nbsp;Bonjour,
		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Bienvenue sur votre espace utilisateur créé à l'occasion des rencontres alternances du 1 avril 2016.

		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Les emplois du temps relatifs à cet événement, le vôtre y compris, n'ont toujours pas été générés. Ceux-ci seront générés le 31 mars.
		L'administrateur vous en informera lorsque ceux-ci seront disponibles.
	</div>
		<?php
		//////////////////////////////////////ATTTENTION METTRE EN PLACE SYSTEME DATE POUR AFFICHER/////////////////////////////////////

		//On génére l'emploi du temps
    $dao = new Dao();
    $tabConfig = $dao -> getConfiguration();
		//Le 1 doit être l'id de l'entreprise connecté
    $tabForm = $dao -> getFormationEntreprise(1);

		?>
    <!DOCTYPE html>
  	<html>
  	<head>
  		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
  		<title></title>
  		<meta charset="UTF-8">
  	</head>
  	<body>
  	<div id="main">
  	<br/>

    <table id="tabPlanningEnt">

		<tr>
			<td colspan="7"> Planning </td>
		</tr>
		<tr>
			<td colspan= <?php $tabConfig["nbCreneauxMatin"]?>> Matin </td>
			<td colspan=<?php $tabConfig["nbCreneauxAprem"]?>> Après-midi </td>
		</tr>

		<?php
			foreach ($tabForm as $formation) {
				echo '<tr>
					<td>'
					.$formation["IDformation"].
					'</td>
				</tr>';
			}
		?>
		</table>

    <?php

		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}

public function afficherPlanningAdmin(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/>&nbsp;&nbsp;&nbsp;&nbsp;Bonjour,
		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Bienvenue sur votre espace administrateur créé à l'occasion des rencontres alternances du 1 avril 2016.

		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Les emplois du temps relatifs à cet événement n'ont toujours pas été générés. Ceux-ci seront à générer le 31 mars.
	</div>
		<?php
    //////////////////////////////////////ATTTENTION METTRE EN PLACE SYSTEME DATE POUR AFFICHER/////////////////////////////////////



    //On génére l'emploi du temps
    $dao = new Dao();
    $tabConfig = $dao -> getConfiguration();
		$tabEnt = $dao -> getAllEntreprises();


    //Planning du point de vue des entreprises
    ?>
    <!DOCTYPE html>
  	<html>
  	<head>
  		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
  		<title></title>
  		<meta charset="UTF-8">
  	</head>
  	<body>
  	<div id="main">
  	<br/>
		<style>

		#tabPlanningEnt {
			background-color: #f2f2f2;
			margin-left: -40%;
			border-style : solid;
			border-width : 1 px;
			border-collapse: collapse;
			text-align: center;

		}
		#tabPlanningEnt tr td {
			border-style : solid;
			border-width : 1px;
			border-collapse: collapse;
		}

		</style>
    <table id="tabPlanningEnt">

		<tr>
				<?php
				$tmp = $tabConfig["nbCreneauxMatin"] + $tabConfig["nbCreneauxAprem"] + 2;
				echo'<td colspan= '.$tmp.'> Planning Entreprises </td>';
				?>
		</tr>
		<tr>
			<td colspan= 1> Entreprise </td>
			<?php
			echo'<td colspan= '.$tabConfig["nbCreneauxMatin"].'> Matin </td>';
			echo'<td colspan= 1> Pause midi </td>';
			echo'<td colspan= '.$tabConfig["nbCreneauxAprem"].'> Après-midi </td>';
			?>
		</tr>

		<?php
		//Les horaires
		echo'<tr>';
		$duree = $tabConfig["dureeCreneau"];
		$heureString = $tabConfig["heureDebutMatin"];
		$heureString = explode(':', $heureString);
		$heure = $heureString[0];
		$min = $heureString[1];
		echo'<td> Horaires</td>';
		for($i = 0; $i < 15; $i++) {
			if ($i == 6) {
				echo'<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</td>';
				$heureString = $tabConfig["heureDebutAprem"];
				$heureString = explode(':', $heureString);
				$heure = $heureString[0];
				$min = $heureString[1];
			} else {
				echo'<td>' . $heure . ' : ';
				if ($min == 0)
					echo '00';
				else
					echo $min;
				echo'</td>';

				$min += $duree;
				if($min == 60) {
					$min = 0;
					$heure++;
				}
			}


		}
		echo'</tr>';





		foreach ($tabEnt as $ent) {
			$tabForm = $dao -> getFormationsEntreprise($ent -> getID());



		foreach ($tabForm as $form) {
			echo '<tr>
			<td>'
			.$ent -> getnomEnt().
			'</td>';
			for($i = 0; $i < $tabConfig['nbCreneauxMatin'] + $tabConfig['nbCreneauxAprem']; $i++) {
				if ($i == 6) {
					echo'<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</td>';
				}
				echo '
				<td>'
				.
				$dao -> getNomEtudiant($dao -> getCreneau($i, $form['IDformation'])).
				'</td> ';
			}
		}
			echo '</tr>';
	}



		?>
		</table>

    <?php

    //Planning du point de vue des Etudiants





		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}

public function afficherComptes() {
	$util = new UtilitairePageHtml();
	 	$dao = new Dao();
		echo $util->genereBandeauApresConnexion();
		$tabEtuTemp = $dao->getAllEtudiantsTemp();
		$tabEtu = $dao->getAllEtudiants();
		$tabEntTemp = $dao->getAllEntreprisesTemp();
		$tabEnt = $dao->getAllEntreprises();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
	<br/>
		<table id="tabEtudiants">

		<tr>
			<td colspan="7"> Etudiants </td>
		</tr>
		<tr>
			<td colspan="5"> Données </td>
			<td colspan="2"> Actions </td>
		</tr>
		<tr>
			<td>
				Nom
			</td>
			<td>
				Prénom
			</td>
			<td>
				Email
			</td>
			<td>
				Téléphone
			</td>
			<td>
				Formation
			</td>
			<td>
				Etat
			</td>
			<td>
				Suppression
			</td>
		</tr>
		<?php
			foreach ($tabEtuTemp as $etuTemp) {
				echo '<tr>
					<td>
					<a href="index.php?profil='.$etuTemp->getID().'&type=tmpEtu">'.$etuTemp->getNomEtu().'</a>
					</td>
					<td>'
					.$etuTemp->getPrenomEtu().
					'</td>
					</td>
					<td>
					<a href="mailto:'.$etuTemp->getMailEtu().'">'.$etuTemp->getMailEtu().'</a>
					</td>
					<td>'
					.$etuTemp->getNumTelEtu().
					'</td>
					<td>'
					.$etuTemp->getFormationEtu().
					'</td>
					<td>
						<a href="index.php?validation=ok&id='.$etuTemp->getId().'&type=tmpEtu" onclick="return checkValidate()">Valider</a>
					</td>
					<td>
						<a href="index.php?suppression=ok&id='.$etuTemp->getId().'&type=tmpEtu" onclick="return checkDelete()">Supprimer</a>
					</td>
				</tr>';
			}

			foreach ($tabEtu as $etuTemp) {
				echo '<tr>
					<td>
					<a href="index.php?profil='.$etuTemp->getID().'&type=Etu">'.$etuTemp->getNomEtu().'</a>
					</td>
					<td>'
					.$etuTemp->getPrenomEtu().
					'</td>
					<td> <a href="mailto:'.$etuTemp->getMailEtu().'">'.$etuTemp->getMailEtu().'</a>
					</td>
					<td>'
					.$etuTemp->getNumtelEtu().
					'</td>
					<td>'
					.$etuTemp->getFormationEtu().
					'</td>
					<td>
						<a href="index.php?geler=ok&id='.$etuTemp->getId().'&type=Etu" onclick="return checkFreeze()">Geler</a>
					</td>
					<td>
						<a href="index.php?suppression=ok&id='.$etuTemp->getId().'&type=Etu" onclick="return checkDelete()">Supprimer</a>
					</td>
				</tr>';
			}
		?>
		</table>

		<br/><br/>

		<table id="tabEntreprises">

		<tr>
			<td colspan="7"> Entreprises </td>
		</tr>
		<tr>
			<td colspan="5"> Données </td>
			<td colspan="2"> Actions </td>
		</tr>
		<tr>
			<td>
				Entreprise
			</td>
			<td>
				Nom contact
			</td>
			<td>
				Prenom contact
			</td>
			<td>
				Téléphone
			</td>
			<td>
				Email
			</td>
			<td>
				Etat
			</td>
			<td>
				Suppression
			</td>
		</tr>
		<?php
			foreach ($tabEntTemp as $entTemp) {
				echo '<tr>
					<td>
					<a href="index.php?profil='.$entTemp->getID().'&type=tmpEnt">'.$entTemp->getNomEnt().'</a>
					</td>
					<td>'
					.$entTemp->getNomContact().
					'</td>
					<td>'
					.$entTemp->getPrenomContact().
					'</td>
					<td>'
					.$entTemp->getNumTelContact().
					'</td>
					<td>
					<a href="mailto:'.$entTemp->getMailEnt().'">'.$entTemp->getMailEnt().'</a>
					</td>
					<td>
						<a href="index.php?validation=ok&id='.$entTemp->getId().'&type=tmpEnt" onclick="return checkValidate()">Valider</a>
					</td>
					<td>
						<a href="index.php?suppression=ok&id='.$entTemp->getId().'&type=tmpEnt" onclick="return checkDelete()">Supprimer</a>
					</td>
				</tr>';
			}

			foreach ($tabEnt as $entTemp) {
				echo '<tr>
					<td>
					<a href="index.php?profil='.$entTemp->getID().'&type=Ent">'.$entTemp->getNomEnt().'</a>
					</td>
					<td>'
					.$entTemp->getNomContact().
					'</td>
					<td>'
					.$entTemp->getPrenomContact().
					'</td>
					<td>'
					.$entTemp->getNumTelContact().
					'</td>
					<td>
					<a href="mailto:'.$entTemp->getMailEnt().'">'.$entTemp->getMailEnt().'</a>
					</td>
					<td>
						<a href="index.php?geler=ok&id='.$entTemp->getId().'&type=Ent" onclick="return checkFreeze()">Geler</a>
					</td>
					<td>
						<a href="index.php?suppression=ok&id='.$entTemp->getId().'&type=Ent" onclick="return checkDelete()">Supprimer</a>
					</td>
				</tr>';
			}
		?>
		</table>

		<script>
		function checkDelete() {
			if (confirm('Êtes-vous sûr(e) de vouloir supprimer ce compte ? Cette action ne peut pas être annulée !')) {
   				return confirm('Veuillez confirmer une seconde fois la suppression irréversible de ce compte.');
			} else {
			    return false;
			}
		}
		function checkFreeze() {
			return confirm('Êtes-vous sûr(e) de vouloir geler ce compte ?');
		}
		function checkValidate() {
			return confirm('Êtes-vous sûr(e) de vouloir valider ce compte ?');
		}
		</script>

	</div>
		<?php

		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}

	public function afficherConfig() {

		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
		$dao = new Dao();
		$tabConfig = $dao->getConfiguration();
		$heureDebutMatin = $tabConfig['heureDebutMatin'];
		$heureDebutAprem = $tabConfig['heureDebutAprem'];
		$nbCreneauxMatin = $tabConfig['nbCreneauxMatin'];
		$nbCreneauxAprem = $tabConfig['nbCreneauxAprem'];
		$dureeCreneau = $tabConfig['dureeCreneau'];
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/><span class="categorie_profil">Configuration actuelle :</span>
		<br/><br/>
		<?php
			echo'

			Les emplois du temps débuteront le matin à : '.$heureDebutMatin.'.
			<br/><br/>Les emplois du temps débuteront l\'après-midi à : '.$heureDebutAprem.'.
			<br/><br/>Il y aura '.$nbCreneauxMatin.' créneau(x) le matin et '.$nbCreneauxAprem.' l\'après-midi.
			<br/><br/>Chaque créneau dure '.$dureeCreneau.' minutes.
			';
		?>

		<br/><br/><span class="categorie_profil">Nouvelle configuration :</span>
		<form action="index.php" method="POST">
			<br/>
			<label>Début de la matinée (format hh:mm) : </label><input type="text" name="heureDebutMatin"/>
			<br/><br/>
			<label>Nombre de créneaux dans la matinée : </label><input type="text" name="nbCreneauxMatin"/>
			<br/><br/>
			<label>Début de l'après-midi (format hh:mm) : </label><input type="text" name="heureDebutAprem"/>
			<br/><br/>
			<label>Nombre de créneaux dans l'après-midi : </label><input type="text" name="nbCreneauxAprem"/>
			<br/><br/>
			<label>Durée en minutes d'un créneau : </label><input type="text" name="dureeCreneau"/>
			<br/><br/>
			<input type="submit" name="changementConfig" value="Confirmer"/>
		</form>
	</div>
		<?php

		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}

	public function afficherChoix(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/>&nbsp;&nbsp;&nbsp;&nbsp;Bonjour,
		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Ici sera affichée la liste des entreprises proposant la formation de l'élève pour sélectionner des voeux. La sélection se fera par listes déroulantes.
	</div>
		<?php

		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}

	public function afficherEntreprises(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/>&nbsp;&nbsp;&nbsp;&nbsp;Bonjour,
		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Ici sera affichée la liste des entreprises proposant la formation de l'élève. Chaque nom affiché sera un lien menant au profil de l'entreprise.
	</div>
		<?php

		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}

	public function afficherCompteEtu(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/>&nbsp;&nbsp;&nbsp;&nbsp;Bonjour,
		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Ici seront affichées les données du compte étudiant. Celui-ci pourra les modifier.
	</div>
		<?php

		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}

	public function afficherFormations(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/>&nbsp;&nbsp;&nbsp;&nbsp;Bonjour,
		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Ici seront affichées les formations possibles de l'entreprise. Celle-ci pourra les modifier en respectant les contraintes de son compte.
	</div>
		<?php

		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}


	public function afficherCompteEnt(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/>&nbsp;&nbsp;&nbsp;&nbsp;Bonjour,
		<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Ici seront affichées les données du compte entreprise. Celle-ci pourra les modifier.
	</div>
		<?php

		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}

	public function afficherAutres(){
		$util = new UtilitairePageHtml();
		$dao = new Dao();
		$tabDetails = $dao->getDetails();
		echo $util->genereBandeauApresConnexion();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<body>
	<div id="main">
		<br/><br/>
		<table id="tabStatistiques">
		<tr>
			<td>Nombre total de participants</td>
			<td><?php echo ($tabDetails['nbEnt'] + $tabDetails['nbEtu']);?></td>
		</tr>
		<tr>
			<td>Nombre d'étudiants</td>
			<td><?php echo $tabDetails['nbEtu'];?></td>
		</tr>
		<tr>
			<td>Nombre d'entreprises</td>
			<td><?php echo $tabDetails['nbEnt'];?></td>
		</tr>
		<tr>
			<td>Nombre de repas à prévoir</td>
			<td><?php echo $tabDetails['nbRepas'];?></td>
		</tr>
		</table>
		<br/><br/>
		<!-- IMPORTANT : demande de génération des emplois du temps -->
		<?php
		$date = getdate();
		if ($date['mday'] > 30 && $date['mon'] >2) {
			echo '<form method="POST" action="index.php" onclick="return confirm("Attention ! Cette action utilisera les données courantes pour générer les emplois
				du temps ! Veuillez vérifier toutes vos données avant de continuer.");">
			<input type="submit" value="Générer les emplois du temps" name="startGeneration">
			</form>';
		}
		else {
			echo 'La génération des emplois du temps sera disponible à partir du 31 mars inclus.';
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
