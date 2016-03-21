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
		<p name="obligatoire">
			* Obligatoire
		</p>
		<br/>
		<p>
			<!--Les scripts pour vérifier chaque case-->
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
        var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
        if(!reg.test(champ.value)) {
          surligne(champ, true);
          document.getElementById(txt).innerHTML = "L'e-mail n'est pas valide.";
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
							alert('Les mots de passe ne coïncident pas.');
					        return false;
					}
					if (/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(document.getElementById("mail").value))
					  {
					    return true;
					  }
					  else {
					  	alert("L\'adresse email n'est pas correcte !")  ;
					 	return false;
					  }
				}
			</script>

			<form action="index.php" method="post" onSubmit="return VerifSubmit();">
				<!-- Prenom-->
				<label for="prenom"/> Prénom <span name="obligatoire">*</span>
				<br/>
				<input type="text" name="prenom" onblur="verifString(this,'messagePrenomContact','20')" required/>
				<span id="messagePrenomContact" style="color:red"></span>
				<br/><br/>
				<!-- Nom -->
				<label for="nom"/> Nom <span name="obligatoire">*</span>
				<br/>
				<input type="text" name="nom" onblur="verifString(this,'messageNomContact','20')" required/>
				<span id="messageNomContact" style="color:red"></span>
				<br/><br/>
				<!-- Telephone -->
				<label for="tel"/> Téléphone (portable de préférence, sans espace. Ex : 0610203040) <span name="obligatoire">*</span>
				<br/>
				<input type="text" name="tel" maxlength="10" onblur="verifTelephone(this, 'messageTel')" required/>
				<span id="messageTel" style="color:red"></span>
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
						<?php

							$dao = new Dao();
							$listeFormations = $dao->getListeFormations();
							foreach ($listeFormations as $formation) {
								echo '<option value="'.$formation->getInitiales().'"> '.$formation->getDescription().'</option>
								<br/>';
							}

						?>
				</select>
				<br/><br/>

				<h2>Vos coordonnées</h2>
				<!--  Adresse email-->
				<label for="email"/> Adresse email (consultée régulièrement) <span name="obligatoire">*</span>
				<br/>
				<span name="detail">Elle servira à l'envoi d'informations relatives aux entretiens et à l'authentification</span>
				<br/>
				<input type="text" name="email" id="mail" onblur="verifEmail(this, 'messageEmail')" required/>
				<span id="messageEmail" style="color:red"></span>
				<br/><br/>
				<!--  Mdp -->
				<label for="password"/> Mot de passe (il sera utilité pour l'authentification sur le site)<span name="obligatoire">*</span>
				<br/>
				<input type="password" name="password" id="passw" required/>
				<br/><br/>
				<!--  Mdp bis-->
				<label for="passwordBis"/> Veuillez réécrire le mot de passe<span name="obligatoire">*</span>
				<br/>
				<input type="password" name="passwordBis" id="passwBis" onblur="verifMdp('messageMdp')" equired/>
				<span id="messageMdp" style="color:red"></span>
				<br/><br/>
				<input type="hidden" name="inscription" value="etudiant"/>
				<input type="submit" name="valid_inscription_etu"/>
			</form>

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
