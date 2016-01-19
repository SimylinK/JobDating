<?php

    
require_once 'util/utilitairePageHtml.php';

class VueConfirmationInscription{



public function genereVueConfirmationInscription(){
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
	<div id="Lost">
	
		Votre inscription a été enregistrée.<br/>
		Elle sera prochainement traitée par l'administrateur<br/>
		qui vous enverra un e-mail de confirmation.

		<br/><br/><a href="index.php">Retour à l'accueil</a>
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