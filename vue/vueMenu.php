<?php


require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/dao/dao.php";
require_once __DIR__."/../modele/bean/Etudiant.php";
require_once __DIR__."/../modele/bean/Entreprise.php";
require_once __DIR__."/../modele/formationV2.php";

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
	    <table id="tabPlanningEnt">

			<tr>
					<?php
					$tmp = $tabConfig["nbCreneauxMatin"] + $tabConfig["nbCreneauxAprem"] + 3;
					echo'<td id="titre" colspan= '.$tmp.'> Planning Entreprises </td>';
					?>
			</tr>
			<tr>
				<td colspan= 1> Entreprise </td>
				<td colspan= 1> Formation </td>
				<?php
				echo'<td colspan= '.$tabConfig["nbCreneauxMatin"].'> Matin </td>';
				echo'<td colspan= 1> Pause midi </td>';
				echo'<td colspan= '.$tabConfig["nbCreneauxAprem"].'> Après-midi </td>';
				?>
			</tr>

			<?php
			echo'<tr>';
			echo'<td> </td>';
			echo'<td> </td>';
			//Les horaires
			$duree = $tabConfig["dureeCreneau"];
			$heureString = $tabConfig["heureDebutMatin"];
			$heureString = explode(':', $heureString);
			$heure = $heureString[0];
			$min = $heureString[1];
			for($i = 0; $i < 15; $i++) {
				if ($i == 6) {
					echo'<td id="pause_midi"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</td>';
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
				echo '<tr id="entreprise">
				<td>'
				.$ent -> getnomEnt().
				'</td>
				<td>'
				.$form['typeFormation'].
				'</td>';
				;
				for($i = 0; $i < $tabConfig['nbCreneauxMatin'] + $tabConfig['nbCreneauxAprem']; $i++) {
					if ($i == 6) {
						echo'<td id="pause_midi"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</td>';
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
			<p>
			</br>
			</p>
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
		$dao = new Dao();
		$etudiantCourant = $dao->getEtu($_SESSION['idUser'])[0];
		$listeEntreprises = $dao->getEntreprisesParFormation($etudiantCourant->getFormationEtu());
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

		<?php
			if ($etudiantCourant->getListeChoixEtu() == "") {
				echo "<br/>Vous n'avez pas encore fait de choix.";
			}
			else {
				echo "<br/>";
				$choix = explode(",",$etudiantCourant->getListeChoixEtu());
				$compteur = 1;
				$newList = $etudiantCourant->getListeChoixEtu();
				foreach ($choix as $entreprise) {
					$truc = $dao->getEnt(intval($entreprise));
					if (isset($truc[0])) {
						$objEnt = $truc[0];
						echo "Choix ".$compteur." : ";
						echo '<a href="index.php?profil='.$objEnt->getId().'&type=Ent">'.$objEnt->getNomEnt().'</a><br/><br/>';
						$compteur = $compteur + 1;
					}
					else {
						echo "Votre choix ".$compteur." n'existe plus. Il a été retiré de votre liste de choix.<br/><br/>";
						$compteur = $compteur + 1;
						if (strpos($newList, $entreprise.',') != false) {
							$newList = str_replace($entreprise.',', "", $newList);
						}
						else {
							$newList = str_replace($entreprise, "", $newList);
						}
						$dao->editChoixEtudiant($_SESSION['idUser'],$newList);
					}
				}
			}
		?>

		<br/><br/>

		Vous pouvez faire jusqu'à quatre choix. Le premier choix sera favorisé par rapport aux suivants. Les doublons ne permettront pas l'envoi du formulaire.

		<br/><br/>



		<form action="index.php" method="POST" onsubmit="return verifier();">

			<select id="ent1" name="choix1" onchange="Changement1()" >
				<option value="Faire un choix...">Faire un choix...</option>
				<?php
					foreach ($listeEntreprises as $entreprise) {
						echo '<option value="'.$entreprise->getId().'">'.$entreprise->getNomEnt().'</option>';
					}
				?>
			</select>
			<br/><br/>
			<select id="ent2" name="choix2" onchange="Changement2()" style="visibility:hidden;">
				<option value="Faire un choix...">Faire un choix...</option>
				<?php
					foreach ($listeEntreprises as $entreprise) {
						echo '<option value="'.$entreprise->getId().'">'.$entreprise->getNomEnt().'</option>';
					}
				?>
			</select>
			<br/><br/>
			<select id="ent3" name="choix3" onchange="Changement3()" style="visibility:hidden;">
				<option value="Faire un choix...">Faire un choix...</option>
				<?php
					foreach ($listeEntreprises as $entreprise) {
						echo '<option value="'.$entreprise->getId().'">'.$entreprise->getNomEnt().'</option>';
					}
				?>
			</select>
			<br/><br/>
			<select id="ent4" name="choix4" style="visibility:hidden;">
				<option value="Faire un choix...">Faire un choix...</option>
				<?php
					foreach ($listeEntreprises as $entreprise) {
						echo '<option value="'.$entreprise->getId().'">'.$entreprise->getNomEnt().'</option>';
					}
				?>
			</select>

			<br/><br/>
			<input type="submit" value="Valider les changements" name="changementListeEtu"/>

		</form>

		<script>

		function Changement1() {
			if (document.getElementById("ent1").value == "Faire un choix...") {
				document.getElementById("ent2").style.visibility = "hidden";
				document.getElementById("ent3").style.visibility = "hidden";
				document.getElementById("ent4").style.visibility = "hidden";
				document.getElementById("ent2").value = "Faire un choix...";
				document.getElementById("ent3").value = "Faire un choix...";
				document.getElementById("ent4").value = "Faire un choix...";
			}
			else {
				document.getElementById("ent2").style.visibility = "";
			}
		}

		function Changement2() {
			if (document.getElementById("ent2").value == "Faire un choix...") {
				document.getElementById("ent3").style.visibility = "hidden";
				document.getElementById("ent4").style.visibility = "hidden";
				document.getElementById("ent3").value = "Faire un choix...";
				document.getElementById("ent4").value = "Faire un choix...";
			}
			else {
				document.getElementById("ent3").style.visibility = "";
			}
		}

		function Changement3() {
			if (document.getElementById("ent3").value == "Faire un choix...") {
				document.getElementById("ent4").style.visibility = "hidden";
				document.getElementById("ent4").value = "Faire un choix...";
			}
			else {
				document.getElementById("ent4").style.visibility = "";
			}
		}

		function verifier() {
			var value1 = document.getElementById("ent1").value;
			var value2 = document.getElementById("ent2").value;
			var value3 = document.getElementById("ent3").value;
			var value4 = document.getElementById("ent4").value;
			if (value1 == "Faire un choix...") {
				return true;
			}
			if (value2 == "Faire un choix..." && value1 != "Faire un choix...") {
				return true;
			}
			if (value3 == "Faire un choix..." && value2 != value1) {
				return true;
			}
			if (value4 == "Faire un choix..." && value3 != value2 && value3 != value1 && value2 != value1) {
				return true;
			}
			if (value4 != value3 && value4 != value2 && value4 != value1 && value3 != value2 && value3 != value1 && value2 != value1) {
				return true;
			}
			return false;
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

	public function afficherEntreprises(){
		$dao = new Dao();
		$tabEntreprises = $dao->getEntreprisesParFormation($dao->getFormationEtudiant($_SESSION['idUser']));
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
		<br/><br/><span style="categorie_profil">Liste des entreprises recherchant votre formation :</span><br/><br/>

		<?php

			if (sizeof($tabEntreprises) > 0 && !is_bool($tabEntreprises)) {
				foreach ($tabEntreprises as $entreprise) {
					echo '<a href="index.php?profil='.$entreprise->getId().'&type=Ent">'.$entreprise->getNomEnt().'</a><br/><br/>';
				}
			}
			else {
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actuellement, aucune entreprise ne propose de formation correspondante à la votre.';
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

	public function afficherCompteEtu(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	$dao = new Dao();
	$id = $_SESSION['idUser'];
	$tabprofil = $dao->getEtu($id);
	$profil = $tabprofil[0];
	$util = new UtilitairePageHtml();

	echo '
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
	<br/><br/>
	<span class="categorie_profil">Nom et prénom de l\'étudiant :</span> '.$profil->getPrenomEtu().' '.$profil->getNomEtu().'
	<br/><br/>
	<span class="categorie_profil">Email :</span> <a href="mailto:'.$profil->getMailEtu().'">'.$profil->getMailEtu().'</a>
	<br/><br/>
	<span class="categorie_profil">Téléphone :</span> '.$profil->getNumTelEtu().'
	<br/><br/>
	<span class="categorie_profil">Formation :</span> '.$profil->getFormationEtu().'
	<br/><br/>';



		//<!-- Nom -->
		?>
		<script>
      //On surligne les cases non valides
      function surligne(champ, erreur) {
      if(erreur)
        champ.style.backgroundColor = "#fba";
      else
        champ.style.backgroundColor = "";
      }

      function verifString(champ, txt, longMax) {
        if(champ.value.length > longMax) {
          surligne(champ, true);
          document.getElementById(txt).innerHTML = longMax + " caractères maximum autorisé";
          return true;
        } else {
          surligne(champ, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }

      function verifNombre(champ, txt, longMax) {
        if(champ.value.length > longMax || (!/^\d+$/.test(champ.value) && champ.value.length != 0)) {
          surligne(champ, true);
          document.getElementById(txt).innerHTML = "Un nombre de taille maximum " + longMax + " est attendu";
          return true;
        } else {
          surligne(champ, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }

      function verifTelephone(champ, txt) {
        if(champ.value.length != 10 || !/^\d+$/.test(champ.value)) {
          surligne(champ, true);
          document.getElementById(txt).innerHTML = "Format invalide";
          return true;
        } else {
          surligne(champ, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }


      function verifEmail(champ, txt){
        var reg = new RegExp("^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$", "i");
        if(!reg.test(champ.value)) {
          surligne(champ, true);
          document.getElementById(txt).innerHTML = "L\'e-mail n\'est pas valide.";
          return true;
        } else {
          surligne(champ, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }

      function verifMdp(txt){
        var passw = document.getElementById("passw");
				var passwBis = document.getElementById("passwBis");
        if (passw.value != passwBis.value) {
          surligne(passw, true);
          surligne(passwBis, true);
          document.getElementById(txt).innerHTML = "Les 2 valeurs sont différentes";
          return true;
        } else if (passw.value.length > 20 || passw.value.length < 5) {
          surligne(passw, true);
          surligne(passwBis, true);
          document.getElementById(txt).innerHTML = "Le mot de passe doit faire 5 à 20 caractères";
          return true;
        } else {
          surligne(passw, false);
          surligne(passwBis, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }
      </script>


			<script type="text/javascript">
				EnableSubmit = function(val)
				{
				    var sbmt = document.getElementById("submit");

				    if (val.checked == true)
				    {
				        sbmt.disabled = false;
				    }
				    else
				    {
				        sbmt.disabled = true;
				    }
				}
			</script>
			<script>
			VerifSubmit = function()
				{
				html = html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
				var passw = document.getElementById("passw");
				var passwBis = document.getElementById("passwBis");
					if (passw.value != passwBis.value) {
							alert("Les mots de passe ne coïncident pas.");
					        return false;
					}
					if (/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(document.getElementById("mail").value))
					  {
					    return true;
					  }
					  else {
					  	alert("L\'adresse email n'est pas correcte !");
					 	return false;
					  }
				}
			</script>
		<?php
		echo'

		<!--Les scripts pour vérifier chaque case-->

		<br></br></br></br>
		----------------------------------------------------<br/><br/>

		<h2>Pour effectuer des changements : </h2>

		<style>
		#tabModifEnt tr td{
    padding: 15px;
    border: 1px solid navy;
		}
		</style>

		<form action="index.php" method="post" onSubmit="return VerifSubmit();">
		<TABLE id="tabModifEnt">
	  	<CAPTION> Identité </CAPTION>
	  	<TR>
	 			<TD> <label for="nomEtu"/> Nom
				<br/>
				<input required type="text" name="nomEtu" value="'.$profil->getNomEtu().'" onblur="verifString(this, \'messageNomEtu\', 20)">
				<p id="messageNomEtu" style="color:red"></p>
				<br/><br/>
				<label for="prenomEtu"/> Prénom
				<br/>
				<input required type="text" name="prenomEtu" value="'.$profil->getPrenomEtu().'" onblur="verifString(this, \'messagePrenomEtu\', 20)">
				<p id="messagePrenomEtu" style="color:red"></p>
				<br/><br/>
				<label for="email"/> Adresse e-mail
				<br/>
				<input required type="text" name="email" value="'.$profil->getMailEtu().'" onblur="verifEmail(this, \'messageEmail\')">
	 			<p id="messageEmail" style="color:red"></p>
				<br/><br/>
	 			<input required type="text" name="numTelEtu" value="'.$profil->getNumTelEtu().'" onblur="verifTelephone(this, \'messageTel\')"> </TD>
	 			<p id="messageTel" style="color:red"></p>
	 			<TD> 	<input type="submit" name="modification_etudiant_identite" value="confirmer"/> </TD>
		</TABLE>
		</form>

		<form action="index.php" method="post" >
		<TABLE id="tabModifEnt">
	  	<CAPTION> Modifier le mot de passe </CAPTION>
	  	<TR>
	 			<TD> <label for="mdpActuel"/> Mot de passe actuel
				<br/>
				<input required type="password" name="mdpActuel">
				<br/><br/>
				<label for="mdpNouveau1"/> Nouveau mot de passe
				<br/>
				<input required type="password" name="mdpNouveau1" id="passw">
				<br/><br/>
				<label for="mdpNouveau2"/> Confirmez
				<br/>
				<input required type="password" name="mdpNouveau2" onblur="verifMdp(\'messageMdp\')" id="passwBis"> </TD>
				<p id="messageMdp" style="color:red"></p>
	 			<TD> 	<input type="submit" name="modification_etudiant_motdepasse" value="confirmer"/> </TD>
		</TABLE>
		</form>
		<br/><br/><br/>
		</html></body>
</html>

		';

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
		$dao = new Dao();
		$id = $_SESSION['idUser'];

		$listeFormation = $dao -> getFormationsAffichage($id);
		$formation = "Formation";
		$formation::afficherForm($listeFormation);


		echo $util->generePied();

		?>
	</body>
	</html>

	<?php
	}


	public function afficherCompteEnt(){
		$util = new UtilitairePageHtml();
		echo $util->genereBandeauApresConnexion();
	/*?>
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



	<?php*/
	$dao = new Dao();
	$id = $_SESSION['idUser'];
	$tabprofil = $dao->getEnt($id);
	$profil = $tabprofil[0];
	$util = new UtilitairePageHtml();

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
	echo '
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="vue/css/general.css">
		<title></title>
		<meta charset="UTF-8">
	</head>
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
	<span class="categorie_profil">Recherche :</span> '.$profil->getFormationsRecherchees().' pour '.$profil->getNbPlaces().' recruteur(s) disponible(s).
	<br/><br/>
	<span class="categorie_profil">Nombre de stands en simultané :</span> '.$profil->getNbStands().'
	<br/><br/>
	<span class="categorie_profil">Nombre de repas prévus :</span> '.$profil->getNbRepas().'
	';



		//<!-- Nom -->
		?>
		<script>
      //On surligne les cases non valides
      function surligne(champ, erreur) {
      if(erreur)
        champ.style.backgroundColor = "#fba";
      else
        champ.style.backgroundColor = "";
      }

      function verifString(champ, txt, longMax) {
        if(champ.value.length > longMax) {
          surligne(champ, true);
					champ.value = "";
          document.getElementById(txt).innerHTML = longMax + " caractères maximum autorisé";
          return true;
        } else {
          surligne(champ, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }

      function verifNombre(champ, txt, longMax) {
        if(champ.value.length > longMax || (!/^\d+$/.test(champ.value) && champ.value.length != 0)) {
          surligne(champ, true);
          document.getElementById(txt).innerHTML = "Un nombre de taille maximum " + longMax + " est attendu";
					champ.value = "";
          return true;
        } else {
          surligne(champ, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }

      function verifCodePostal(champ, txt) {
        if(champ.value.length != 5 || !/^\d+$/.test(champ.value)) {
          surligne(champ, true);
          document.getElementById(txt).innerHTML = "Le code postal doit être rentré au format 44000";
					champ.value = "";
          return true;
        } else {
          surligne(champ, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }

      function verifTelephone(champ, txt) {
        if(champ.value.length != 10 || !/^\d+$/.test(champ.value)) {
          surligne(champ, true);
          document.getElementById(txt).innerHTML = "Format invalide";
          return true;
        } else {
          surligne(champ, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }


      function verifEmail(champ, txt){
        var reg = new RegExp("^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$", "i");
        if(!reg.test(champ.value)) {
          surligne(champ, true);
          document.getElementById(txt).innerHTML = "L\'e-mail n\'est pas valide.";
					champ.value = "";
          return true;
        } else {
          surligne(champ, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }

      function verifMdp(txt){
        var passw = document.getElementById("passw");
				var passwBis = document.getElementById("passwBis");
        if (passw.value != passwBis.value) {
          surligne(passw, true);
          surligne(passwBis, true);
					passw.value = "";
					passwBis.value = "";
          document.getElementById(txt).innerHTML = "Les 2 valeurs sont différentes";
          return true;
        } else if (passw.value.length > 20 || passw.value.length < 5) {
          surligne(passw, true);
          surligne(passwBis, true);
					passw.value = "";
					passwBis.value = "";
          document.getElementById(txt).innerHTML = "Le mot de passe doit faire 5 à 20 caractères";
          return true;
        } else {
          surligne(passw, false);
          surligne(passwBis, false);
          document.getElementById(txt).innerHTML = "";
          return false;
        }
      }
      </script>


			<script type="text/javascript">
				EnableSubmit = function(val)
				{
				    var sbmt = document.getElementById("submit");

				    if (val.checked == true)
				    {
				        sbmt.disabled = false;
				    }
				    else
				    {
				        sbmt.disabled = true;
				    }
				}
			</script>
			<script>
			VerifSubmit = function()
				{
				html = html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
				var nb_repas = document.getElementById("nb_repas");
				var checkboxRepas = document.getElementById("checkbox_repas");
				var passw = document.getElementById("passw");
				var passwBis = document.getElementById("passwBis");
					if (checkboxRepas.checked == true) {
					    if (nb_repas.value == "" || nb_repas.value == null)
					    {
					    	alert("Vous n\'avez pas précisé combien de repas seront à prévoir.");
					        return false;
					    }
					}
					if (passw.value != passwBis.value) {
							alert("Les mots de passe ne coïncident pas.");
					        return false;
					}
					if (/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(document.getElementById("mail").value))
					  {
					    return true;
					  }
					  else {
					  	alert("L\'adresse email n'est pas correcte !");
					 	return false;
					  }
				}
			</script>
		<?php
		echo'
			<!--Les scripts pour vérifier chaque case-->

		<br></br></br></br>
		----------------------------------------------------<br/><br/>

		<h2>Pour effectuer des changements : </h2>

		<style>
		#tabModifEnt tr td{
    padding: 15px;
    border: 1px solid navy;
		}
		</style>

		<form action="index.php" method="post" onSubmit="return VerifSubmit();">
		<TABLE id="tabModifEnt">
	  	<CAPTION> Organisation </CAPTION>
	  	<TR>
	 			<TD> <label for="disponibiliteSociete"/> Disponibilité
				<br/>
				<select required name="disponibiliteSociete"/>
					<option value=""disabled selected>Sélectionnez un horaire</option>
					<option value="matin">Matin</option>
					<option value="apres_midi">Après-midi</option>
					<option value="journee">Journée</option>
				</select>
				<br/><br/>
				<label for="nbStandsSociete"/> Nombre d\'entretiens en simultanés
				<br/>
				<input required type="number" name="nbStandsSociete" min="1" max="10" value="'.$profil->getNbStands().'" >
				<br/><br/>
				<label for="nbRepasSociete"/> Nombre de repas prévus
				<br/>
				<input required type="text" name="nbRepasSociete" value="'.$profil->getNbRepas().'" onblur="verifNombre(this, \'messageNbRepas\', 3)">
	 			<p id="messageNbRepas" style="color:red"></p>
	 			<TD> 	<input type="submit" name="modification_entreprise_organisation" value="confirmer"/> </TD>
		</TABLE>
		</form></br>

		<form action="index.php" method="post" >
		<TABLE id="tabModifEnt">
	  	<CAPTION> Formations recherchées </CAPTION>
	  	<TR>
	 			<TD> <input type="checkbox" name="formation[]" id="formation" value="LP I2P" onClick="EnableSubmit(this)">
				 LP Innovations Produits Process (I2P)<br/>
    		<input type="checkbox" name="formation[]" id="formation" value="LP LOGIQUAL" onClick="EnableSubmit(this)">
				LP Industrialisation et Mise en Oeuvre des matériaux composites (IMOC)<br/>
    		<input type="checkbox" name="formation[]" id="formation" value="LP LOGIQUAL" onClick="EnableSubmit(this)">
				LP Logistique et qualité (LOGIQUAL)<br/>
    		<input type="checkbox" name="formation[]" id="formation" value="LP EAS" onClick="EnableSubmit(this)">
				LP Electrohydraulique mobile et automatismes associés (EAS)<br/>
    		<input type="checkbox" name="formation[]" id="formation" value="LP SEICOM" onClick="EnableSubmit(this)">
				LP Systèmes Electroniques et Informatiques Communicants (SEICOM)<br/>
    		<input type="checkbox" name="formation[]" id="formation" value="LP IDEB" onClick="EnableSubmit(this)">
				LP Intelligence et Distribution Electrique du Bâtiment (IDEB)<br/>
    		<input type="checkbox" name="formation[]" id="formation" value="LP FICA" onClick="EnableSubmit(this)">
				LP Froid Industriel et Conditionnement d\'Air (FICA)<br/>
				<input type="checkbox" name="formation[]" id="formation" value="DUT GEII" onClick="EnableSubmit(this)">
				DUT 2ème année GEII : Génie Électrique et Informatique Industrielle<br/>
				<input type="checkbox" name="formation[]" id="formation" value="DUT INFO" onClick="EnableSubmit(this)">
				DUT 2ème année Informatique<br/>
				<input type="checkbox" name="formation[]" id="formation" value="DUT GMP" onClick="EnableSubmit(this)">
				DUT 2ème année Génie Mécanique et Productique<br/>
				<input type="checkbox" name="formation[]" id="formation" value="DUT SGM" onClick="EnableSubmit(this)">
				DUT 2ème année Science et Génie des Matériaux<br/>
	 			<TD> 	<input type="submit" name="modification_entreprise_formations" value="confirmer"/> </TD>
		</TABLE>
		</form></br>

		<form action="index.php" method="post" >
		<TABLE id="tabModifEnt">
	  	<CAPTION> Informations sur la société </CAPTION>
	  	<TR>
	 			<TD> <label for="nomSociete"/> Nom
				<br/>
				<input required type="text" name="nomSociete" value="'.$profil->getNomEnt().'" onblur="verifString(this, \'messageNom\', 20)">
				<p id="messageNom" style="color:red"></p>
				<label for="villeSociete"/> Ville
				<br/>
				<input required type="text" name="villeSociete" value="'.$profil->getVilleEnt().'" onblur="verifString(this, \'messageVille\', 20)">
				<p id="messageVille" style="color:red"></p>
				<label for="codePostalSociete"/> Code postal
				<br/>
				<input required type="text" name="codePostalSociete" value="'.$profil->getCodePostal().'" onblur="verifCodePostal(this, \'messageCP\')">
				<p id="messageCP" style="color:red"></p>
				<label for="adresseSociete"/> Adresse
				<br/>
				<input required type="text" name="adresseSociete" value="'.$profil->getAdresseEnt().'" onblur="verifString(this, \'messageAdresse\', 30)"> </TD>
	 			<p id="messageAdresse" style="color:red"></p>
	 			<TD> 	<input type="submit" name="modification_entreprise_informations" value="confirmer"/> </TD>
		</TABLE>
		</form>
		<br/>

		<form action="index.php" method="post" >
		<TABLE id="tabModifEnt">
	  	<CAPTION> Contact </CAPTION>
	  	<TR>
	 			<TD> <label for="nomContactSociete"/> Nom du contact
				<br/>
				<input required type="text" name="nomContactSociete" value="'.$profil->getNomContact().'" onblur="verifString(this, \'messageNomContact\', 20)">
				<p id="messageNomContact" style="color:red"></p>
				<label for="prenomContactSociete"/> Prénom du contact
				<br/>
				<input required type="text" name="prenomContactSociete" value="'.$profil->getPrenomContact().'" onblur="verifString(this, \'messagePrenomContact\', 20)" >
				<p id="messagePrenomContact" style="color:red"></p>
				<label for="emailSociete"/> Email
				<br/>
				<input required type="text" name="emailSociete" value="'.$profil->getMailEnt().'" onblur="verifEmail(this, \'messageEmail\')">
				<p id="messageEmail" style="color:red"></p>
				<label for="numTelSociete"/> Téléphone
				<br/>
				<input required type="text" name="numTelSociete" value="'.$profil->getNumTelContact().'" onblur="verifTelephone(this, \'messageTel\')"> </TD>
	 			<p id="messageTel" style="color:red"></p>
	 			<TD> 	<input type="submit" name="modification_entreprise_contact" value="confirmer"/> </TD>
		</TABLE>
		</form>
		<br/>

		<form action="index.php" method="post" >
		<TABLE id="tabModifEnt">
	  	<CAPTION> Modifier le mot de passe </CAPTION>
	  	<TR>
	 			<TD> <label for="mdpActuel"/> Mot de passe actuel
				<br/>
				<input required type="password" name="mdpActuel" onblur="verifString(this, \'messageMdpAncien\', 20)">
				<p id="messageMdpAncien" style="color:red"></p>
				<label for="mdpNouveau1"/> Nouveau mot de passe
				<br/>
				<input required type="password" name="mdpNouveau1" id="passw">
				<br/><br/>
				<label for="mdpNouveau2"/> Confirmez
				<br/>
				<input required type="password" name="mdpNouveau2" onblur="verifMdp(\'messageMdp\')" id="passwBis"> </TD>
				<p id="messageMdp" style="color:red"></p>
	 			<TD> 	<input type="submit" name="modification_entreprise_motdepasse" value="confirmer"/> </TD>
		</TABLE>
		</form>
		<br/><br/><br/>
		</html></body>
</html>';

		echo $util->generePied();
}





	/////////////////////∕FINFINFINFINFINFIFNIFNIFNFINFINFINFINFINFINFIFNFNIFNIFINFINFINFINFIFNIFN///////////////////////////

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

		<?php

		$listeEntreprises = $dao->getAllEntreprises();

		if (sizeof($listeEntreprises) > 0) {
			echo '<tr>
			<td colspan="2">
			<a href="mailto:';

			foreach ($listeEntreprises as $ent) {
				echo $ent->getMailEnt().',';
			}

			echo '">Mail groupé aux entreprises</a>
			</td>
			</tr>
				';
		}

		$listeEtudiant = $dao->getAllEtudiants();

		if (sizeof($listeEtudiant) > 0) {
			echo '<tr>
			<td colspan="2">
			<a href="mailto:';

			foreach ($listeEtudiant as $etu) {
				echo $etu->getMailEtu().',';
			}

			echo '">Mail groupé aux étudiants</a>
			</td>
			</tr>
				';
		}

		?>

		</table>
		<br/><br/>
		<!-- IMPORTANT : demande de génération des emplois du temps -->
		<?php
		$date = getdate();
		// if ($date['mday'] > 30 && $date['mon'] >2) {
			?>
			<form method="POST" action="index.php" onsubmit="return ConfirmerGeneration();">
			<input type="submit" value="Générer les emplois du temps" name="startGeneration"/>
			</form>
			<script>
				function ConfirmerGeneration() {
					return confirm('Êtes-vous sûr(e) de vouloir générer les emplois du temps avec les données actuelles ?');
				}
			</script>
			<?php
		// }
		// else {
		// 	echo 'La génération des emplois du temps sera disponible à partir du 31 mars inclus.';
		// }
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
