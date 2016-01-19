<?php
header("Content-type: text/html; charset=utf-8");
// vous ne devez rien modifier dans ce script qui vous permet de tester votre classe Dao

require "Dao.php";


try{
$dao=new Dao();
$dao->connexion();
echo "============================ getMotDePasse / verifieMotDePasse ============================<br/><br/>";
echo $dao->getMotDePasse('etudiant')."<br/>";
echo $dao->verifieMotDePasse('etudiant','etudiant');
echo "<br/><br/> ============================ getTypeUtilisateur ============================<br/><br/>";
echo $dao->getTypeUtilisateur('etudiant')."<br/>";
echo $dao->getTypeUtilisateur('entreprise')."<br/>";
}

catch (ConnexionException $e){
echo "problème de connexion";
}
catch (AccesTableException $e){
echo "problème de d'acces à une table";
}



?>

