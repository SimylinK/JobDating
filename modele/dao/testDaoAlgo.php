<?php

require 'daoAlgo.php';

// test pour getEtudiants

$dao=new daoAlgo();
$dao->connexion();
$listeEtu=$dao->getEtudiants("Informatique");?>
<h1> Liste des etudiants dans la base </h1>
<?php
$Etudiants = array();

///////////////////////////////////$Choix contient les IDEnt, et il devra contenir leurs positions dans $Entreprises
$Choix = array();

foreach ($listeEtu as $etu){
  echo $etu["IDEtu"] . " veut travailler chez " . $etu["listeChoixEtu"];
  echo "<br/>";
  $Etudiants[] = $etu["IDEtu"];
  $Choix[] = explode ( "," , $etu["listeChoixEtu"]);
}
for ($i = 0; $i < sizeof($Etudiants); $i++) {
  echo $Etudiants[$i] . " veut travailler chez ";
  foreach($Choix[$i] as $entreprise) {
    echo $entreprise.", ";
  }
  echo "<br/>";
}

echo "<br/><br/><br/>";
echo "TEST ENTREPRISE<br/>";

$listeEnt = $dao -> getEntreprises("Informatique");
foreach ($listeEnt as $ent){
  $Entreprises[$ent["IDEnt"]] = $ent["nomEnt"];
}
print_r($Entreprises);

echo "<br/><br/><br/>";
echo "TEST AJOUT CRENEAU<br/>";

$IDformation = $dao -> getIDFormation('Informatique', 1);
echo "IDformation : " . $IDformation . "<br/>";

$dao -> ajoutCreneau(1, $IDformation, 1);

?>
