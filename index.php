<?php
require_once "controleur/routeur.php";
session_start();
?>
<meta charset="UTF-8">
<?php

$routeur=new Routeur();

$routeur->routerRequete();
/*
BDD : info2-2015-jobdating
Utilisateur : info2-2015-jobda
Mdp : jobdating
Login admin : JobMeetAdmin
Mdp admin : OnqUJa4m2
*/
?>
