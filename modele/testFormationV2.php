<?php
  require 'formationV2.php';

  $IDentreprise = 1;
  $formation = "Informatique,GEA,GMP, GEII";
  $nbPersonne = 2;
  $periode = "journee";
  $nbCreneauxMatin = 10;
  $nbCreneauxAprem = 10;

  $formCreate = new Formation($IDentreprise, $formation, $nbPersonne, $periode, $nbCreneauxMatin, $nbCreneauxAprem);
  $formTest = new Formation($IDentreprise, $formation, $nbPersonne, $periode, $nbCreneauxMatin, $nbCreneauxAprem);

  echo "=====================================";
  echo "=         TEST CREATEFORM()         =";
  echo "=====================================";
  echo "<br/><br/>";

  $resultCreate = $formCreate -> createForm();
  $formCreate -> afficherForm();

  echo "<br/><br/><br/>";

  echo "=====================================";
  echo "=      COMPARAISON TESTFORM()       =";
  echo "=====================================";
  echo "<br/><br/>";

  $resultTest = $formTest -> testForm();
  $formTest -> afficherForm();

  echo "<br/><br/><br/>";
  echo "=====================================";
  echo "=         TEST CREATEFORM()         =";
  echo "=====================================";
  echo "<br/><br/>";
  var_dump($resultCreate);

  echo "=====================================";
  echo "=      COMPARAISON TESTFORM()       =";
  echo "=====================================";
  echo "<br/><br/>";
  var_dump($resultTest);

?>
