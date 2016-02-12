<?php

require_once __DIR__."/../modele/dao/dao.php";
require_once 'util/utilitairePageHtml.php';

class VueAuthentification{



public function genereVueAuthentification(){
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
	<div id="login">
			<form method="POST" action="index.php">
				<table>
					<tr>
						<td><label>E-mail</label></td>
            <td>&nbsp; : &nbsp;</td>
						<td><input type="text" name="identifiant"/><br/></td>
					</tr>
					<tr>
						<td><label>Mot de passe</label></td>
            <td>&nbsp; : &nbsp;</td>
						<td><input type="password" name="password"/<br/></td>
					</tr>
					<tr>
						<td><a href="index.php?oubliMdp=1">Mot de passe oublié ?</a></td>
						<th colspan="2"><br/><input type="submit" name="submit_login" value="Connexion"></td>
					</tr>
				</table>
			</form>

			<p> Le 1 avril 2016, l'IUT de Nantes vous propose de rencontrer nos futurs étudiants en alternance (DUT, Licences Professionnelles et DCG).
				Si vous êtes intéressés, nous organiserons les entretiens sur inscription : vous avez donc l'assurance de rencontrer des candidats motivés et correspondant au profil que vous recherchez.
			</p>
			<br/>
			<table style="width: 80%; margin: auto; text-align: center;">
				<tr>
					<td>
					<?php
					$dao = new Dao();
					$dateNow = new DateTime("now");
		      $tabConfig = $dao->getConfiguration();
		      $dateDebutEnt = new DateTime((string)$tabConfig['dateDebutInscriptionEnt']);
		      $dateLimitEnt = new DateTime((string)$tabConfig['dateDebutInscriptionEtu']);
		      $dateDebutEtu = new DateTime((string)$tabConfig['dateDebutInscriptionEtu']);
		      $dateLimitEtu = new DateTime((string)$tabConfig['dateFinInscription']);

						if ($dateNow < $dateDebutEtu || $dateNow >= $dateLimitEtu){
							echo '<span style="opacity: 0.5">Inscription étudiant</span>';
						}
						else {
							echo '<a href="index.php?inscriptionEtu=1">Inscription étudiant</a>';
						}
					?>
					<br/><br/>
					<?php
						if ($dateNow >= $dateLimitEnt || $dateNow < $dateDebutEnt) {
							echo '<span style="opacity: 0.5">Inscription entreprise</span>';
						}
						else {
							echo '<a href="index.php?inscriptionEnt=1">Inscription entreprise</a></td>';
						}
					?>
				</tr>
			</table>
			<br/><br/><br/>
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
