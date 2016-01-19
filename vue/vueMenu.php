<?php

    
require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/bean/Etudiant.php";
require_once __DIR__."/../modele/bean/Entreprise.php";

class VueMenu{

public function afficherPlanning(){
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
		Cette fonctionnalité n'est pas encore implémentée. Veuillez faire preuve de patience.
	</div>
		<?php

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

}
?>