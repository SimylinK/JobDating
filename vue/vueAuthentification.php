<?php


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
						<th colspan="3"><br/><input type="submit" name="submit_login" value="Connexion"></td>
					</tr>
				</table>
			</form>

			<p> Le 1 avril 2016, l'IUT de Nantes vous propose de rencontrer nos futurs étudiants en alternance (DUT, Licences Professionnelles et DCG).
				Si vous êtes intéressés, nous organiserons les entretiens sur inscription : vous avez donc l'assurance de rencontrer des candidats motivés et correspondant au profil que vous recherchez.
			</p>
			<br/>
			<table style="width: 80%; margin: auto; text-align: center;">
				<tr>
					<td><a href="index.php?oubliMdp=1">Mot de passe oublié ?</a></td>
					<td>
					<?php
						$date = getdate();
						if (($date['mday'] > 30 && $date['mon'] >2) || ($date['mday'] < 21 && $date['mon'] < 4)){
							//echo 'Inscription étudiant (bloquée)';
						}
						else {
							echo '<a href="index.php?inscriptionEtu=1">Inscription étudiant</a>';
						}
					?>
					<br/><br/>
					<?php
						$date = getdate();
						if ($date['mday'] > 21 && $date['mon'] >2) {
							//echo 'Inscription entreprise (bloquée)';
						}
						else {
							echo '<a href="index.php?inscriptionEnt=1">Inscription entreprise</a></td>';
						}
					?>
				</tr>
			</table>

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
