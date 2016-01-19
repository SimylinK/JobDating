<?php

    
require_once 'util/utilitairePageHtml.php';

class VueLost{



public function genereVueLost(){
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
	
		<?php
			echo $_SESSION['fail'];
		?>

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