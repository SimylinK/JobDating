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


		if ($_SESSION['type_connexion'] == "admin") {
			$_SESSION['idUser'] = $id;
			$_SESSION['type_modification'] = $_GET['type'];
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
					<label for="numTelEtu"/> Téléphone
					<br/>
		 			<input required type="text" name="numTelEtu" value="'.$profil->getNumTelEtu().'" onblur="verifTelephone(this, \'messageTel\')"> </TD>
		 			<p id="messageTel" style="color:red"></p>
		 			<TD> 	<input type="submit" name="modification_etudiant_identite" value="confirmer"/> </TD>
			</TABLE>
			</form>

			<form action="index.php" method="post" >
			<TABLE id="tabModifEnt">
		  	<CAPTION> Modifier le mot de passe </CAPTION>
		  	<TR>
		 			<TD>
					<br/>
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
			<br/><br/><br/>';
			if ($_SESSION['type_connexion'] == "admin") {
				echo 'Liste des choix :<br/><br/>';
				$strChoix = $profil->getListeChoixEtu().explode(",");
				foreach ($strChoix as $choix) {
					$entreprise = $dao->getEnt();
					echo $entreprise->getNomEnt()+"<br/>";
				}
			}
		}
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
		<span class="categorie_profil">Nombre de stands en simultané :</span> '.$profil->getNbStands().'
		<br/><br/>
		';
    $dao = new Dao();
    $id = $profil->getID();

    if ($_SESSION['type_connexion'] == "admin") {
			$_SESSION['idUser'] = $id;
			$_SESSION['type_modification'] = $_GET['type'];
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

			$listeFormation = $dao -> getFormationsAffichage($id);
	    $formation = "Formation";
	    $formation::afficherForm($listeFormation);

			echo '<br></br></br></br>
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
					<select required name="disponibiliteSociete"/>';

						if ($profil->getTypeCreneau() == "matin") {
							echo '<option value="matin" selected >Matin</option>
							<option value="apres_midi">Après-midi</option>
							<option value="journee"> Journée</option>
							';
						}
						if ($profil->getTypeCreneau() == "apres_midi") {
							echo '<option value="matin">Matin</option>
							<option value="apres_midi" selected >Après-midi</option>
							<option value="journee"> Journée</option>
							';
						}
						if ($profil->getTypeCreneau() == "journee") {
							echo '<option value="matin">Matin</option>
							<option value="apres_midi">Après-midi</option>
							<option value="journee" selected> Journée</option>
							';
						}
					echo '</select>
					<br/><br/>
					<label for="nbRecruteursSociete"/> Nombre de recruteurs
					<br/>
					<input required type="number" name="nbRecruteursSociete" min="1" max="20" value="'.$profil->getNbRecruteurs().'" >
					<br/><br/>
					<label for="nbStandsSociete"/> Nombre de sessions en parallèle
					<br/>
					<input required type="number" name="nbStandsSociete" min="1" max="10" value="'.$profil->getNbStands().'" >
					<br/><br/>
					<label for="nbRepasSociete"/> Nombre de repas prévus
					<br/>
					<input required type="number" min="0" max="10" name="nbRepasSociete" value="'.$profil->getNbRepas().'" onblur="verifNombre(this, \'messageNbRepas\', 3)">
		 			<p id="messageNbRepas" style="color:red"></p>
		 			<TD> 	<input type="submit" name="modification_entreprise_organisation" value="confirmer"/> </TD>
			</TABLE>
			</form></br>

			<form action="index.php" method="post">
			<TABLE id="tabModifEnt">';
		 						$compteur = 0;
		 						$formationsRecherchees = explode(",",$profil->getFormationsRecherchees());
								$listeFormations = $dao->getListeFormations();
								$listeDepartements = array();
									echo '<CAPTION> Formations recherchées </CAPTION>
							  	<TR>
							 			<TD> ';
									foreach ($listeFormations as $formation) {
										if(!in_array($formation->getDepartement(), $listeDepartements)) {
											array_push($listeDepartements, $formation->getDepartement());
										}
									}
									foreach ($listeDepartements as $departement) {
										echo '<span><b>Département '.$departement.' :</b></span>
												<br/>';
										foreach ($listeFormations as $formation) {
											if($formation->getDepartement() == $departement) {
												echo '<input type="checkbox" name="formation['.$compteur.']" value="'.$formation->getInitiales().'" onClick="EnableSubmit(this)" ';
												if (in_array($formation->getInitiales(), $formationsRecherchees)) {
													echo 'checked ';
												}
												echo '><a id="lienFormation" href="'. $formation->getLien() .'" target="_blank">'.$formation->getDescription().' </a></option>
												<br/>';
												$compteur = $compteur + 1;
											}
										}
									}

			 		echo '<TD> 	<input type="submit" name="modification_entreprise_formations" value="confirmer"/> </TD>
				</TABLE>
				</form></br>';


			echo '<form action="index.php" method="post" >
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
		 			<TD>
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
			</form>';
		}
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
