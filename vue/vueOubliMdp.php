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
					echo '
					<script>
					function checkMail(element) {
						if (/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(element).value)
							{
								element.style.borderColor = "none";
							}
						else {
							element.style.borderColor = "red";
						}
					}
					VerifSubmit = function()
					{
						html = html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
						if (/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(document.getElementById("mail").value))
							{
								alert("L\'adresse email n\'est pas correcte !");
								return true;
							}
						else {
							alert("L\'adresse email n\'est pas correcte !");
							return false;
						}
					}
				</script>


					<form method="POST" action="index.php" onsubmit="return VerifSubmit()"> 
				<table style="width: 60%">
					<tr style="width:50%">
						<td style="text-align: right"><label>E-mail utilisé : </label></td>
						<td>&nbsp;<input type="text" name="mail_new_mdp" id="mail" onchange="checkMail(this);" required/><br/></td>
					</tr>
					<tr>
						<th colspan="2">Un nouveau mot de passe vous sera envoyé à cette adresse par un administateur.</th>
					</tr>
					<tr>
						<th colspan="2"><br/><input type="submit" name="submit_new_mdp" value="Demander un nouveau MDP"></th>
					</tr>
				</table>
			</form>';
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