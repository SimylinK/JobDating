<?php

    
require_once 'util/utilitairePageHtml.php';

class VueInscriptionEtu{



public function afficherFormulaireEtu(){
	$util = new UtilitairePageHtml();
	echo $util->genereBandeauAvantConnexion();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="vue/css/general.css">
	<title></title>
	<meta charset="UTF-8">
</head>
<body>
<div id="corps">
	<div>
		<h1> Inscription Rencontres Alternance </h1>
		<span> Vous êtes candidat ou admis en Licence Pro, DUT ou DCG par alternance à l'IUT de Nantes.
			Le 3 avril 2015 à 9h00 à l'IUT (Campus la Fleuriaye à Carquefou), nous organisons des pré-entretiens de recrutement avec des entreprises qui recherchent des alternants de votre formation.
		</span>
		<p>
			* Obligatoire
		</p>
		<br/>
		<p>
			<form action="index.php" method="post" onSubmit="return VerifSubmit();">
				<!-- Prenom-->
				<label for="prenom"/> Prénom <span name="obligatoire">*</span>
				<br/>
				<input type="text" name="prenom" required/>
				<br/><br/>
				<!-- Nom -->
				<label for="nom"/> Nom <span name="obligatoire">*</span>
				<br/>
				<input type="text" name="nom" required/>
				<br/><br/>
				<!-- Telephone -->
				<label for="tel"/> Téléphone (portable de préférence, sans espace. Ex : 0610203040) <span name="obligatoire">*</span>
				<br/>
				<input type="text" name="tel" required/>
				<br/><br/>
				<!-- Engagement -->
				<label for="engagement"/> Obligatoire <span name="obligatoire">*</span>
				<br/>
				<input type="checkbox" name="engagement" required/><span>Je m'engage à me présenter à l'entretien de recrutement à l'heure fixée.</span>
				<br/><br/>
				<!-- Formation -->
				<label for="formation"/> Choix de votre formation en alternance <span name="obligatoire">*</span>
				<br/>
				<select name="formation" required>
					<option value=""/>
					<option value="DCG">DCG</option>
					<option value="DUT GEII">DUT GEII</option>
					<option value="DUT GMP">DUT GMP</option>
					<option value="DUT INFO">DUT INFO</option>
					<option value="DUT QLIO">DUT QLIO</option>
					<option value="DUT SGM">DUT SGM</option>
					<option value="LP EAS">LP EAS</option>
					<option value="LP FICA">LP FICA</option>
					<option value="LP I2P">LP I2P</option>
					<option value="LP IDEB">LP IDEB</option>
					<option value="LP IMOC">LP IMOC</option>
					<option value="LP LOGIQUAL">LP LOGIQUAL</option>
					<option value="LP SEICOM">LP SEICOM</option>
				</select>
				<br/><br/>

				<h2>Vos coordonnées</h2>
				<!--  Adresse email-->
				<label for="email"/> Adresse email (consultée régulièrement) <span name="obligatoire">*</span>
				<br/>
				<span name="detail">Elle servira à l'envoi d'informations relatives aux entretiens et à l'authentification</span>
				<br/>
				<input type="text" name="email" id="mail" required/>
				<br/><br/>
				<!--  Mdp -->
				<label for="password"/> Mot de passe (il sera utilité pour l'authentification sur le site)<span name="obligatoire">*</span>
				<br/>
				<input type="password" name="password" id="passw" required/>
				<br/><br/>
				<!--  Mdp bis-->
				<label for="passwordBis"/> Veuillez réécrire le mot de passe<span name="obligatoire">*</span>
				<br/>
				<input type="password" name="passwordBis" id="passwBis" equired/>
				<br/><br/>
				<input type="hidden" name="inscription" value="etudiant"/>
				<input type="submit" name="valid_inscription_etu"/>
			</form>
			<script type="text/javascript">
				VerifSubmit = function()
				{
				var passw = document.getElementById("passw");
				var passwBis = document.getElementById("passwBis");
					if (passw.value != passwBis.value) {
							alert('Les mots de passe ne coïncident pas.');
					        return false;
					}
					if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("mail")))  ;
					  {  
					    return true;
					  }  
					  alert("L\'adresse email n'est pas correcte !")  ;
					  return false;
				}
			</script>
		</p>
	</div>
	<div style="text-align: center;">
		<a href="index.php">Retour à la page d'accueil</a>
	</div>
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