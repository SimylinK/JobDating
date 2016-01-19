<?php

    
require_once 'util/utilitairePageHtml.php';

class VueOubliMdp{



public function genereVueOubliMdp(){
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
	<div id="mail_new_mdp">
			<?php
				if (isset($_GET['envoi'])) {
					echo '<div style="width: 40%; margin-left: 28%; padding: 32px; font-size: 20px">La demande a bien été envoyée.</div>';
				}
				else {
					echo '<form method="POST" action="index.php?oubliMdp=1&envoi=ok">
				<table style="width: 60%">
					<tr style="width:50%">
						<td style="text-align: right"><label>E-mail utilisé : </label></td>
						<td>&nbsp;<input type="text" name="mail_new_mdp" required/><br/></td>
					</tr>
					<tr>
						<th colspan="2">Un nouveau mot de passe vous sera envoyé à cette adresse par un administateur.</th>
					</tr>
					<tr>
						<th colspan="2"><br/><input type="submit" name="submit_new_mdp" value="Demander un nouveau MDP"></th>
					</tr>
				</table>
			</form>';
				}
			?>
			
			
			<table style="width: 70%; margin: auto; text-align: center;">
				<tr>
					<td><a href="index.php">Retour à la page de connexion</a></td>
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