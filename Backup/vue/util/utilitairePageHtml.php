<?php

class UtilitairePageHtml{


private function itemsBandeauApresConnexion(){

        if($_SESSION['type_connexion'] == "etudiant") {
            $menu ='<div id="menu">
            <a href="index.php?choix=ok&menu=1">
            <div class="onglet">
                Planning
            </div>
            </a>
            <a href="index.php?choix=ok&menu=2">
            <div class="onglet">
                Choix
            </div>
            </a>
            <a href="index.php?choix=ok&menu=3">
            <div class="onglet">
                Entreprises
            </div>
            </a>
            <a href="index.php?choix=ok&menu=4">
            <div class="onglet">
                Compte
            </div>
            </a>
            <a href="index.php?deconnexion=ok">
            <div class="onglet">
                Déconnexion
            </div>
            </a>
            </div>';
        }
        elseif ($_SESSION['type_connexion'] == "entreprise") {
            $menu='<div id="menu">
        <a href="index.php?choix=ok&menu=1">
        <div class="onglet_ent">
            Planning
        </div>
        </a>
        <a href="index.php?choix=ok&menu=2">
        <div class="onglet_ent">
            Compte
        </div>
        </a>
        <a href="index.php?deconnexion=ok">
        <div class="onglet_ent">
            Déconnexion
        </div>
        </a>
    </div>';
        }
        else {
            $menu ='<div id="menu">
            <a href="index.php?choix=ok&menu=1">
            <div class="onglet">
                Planning
            </div>
            </a>
            <a href="index.php?choix=ok&menu=2">
            <div class="onglet">
                Comptes
            </div>
            </a>
            <a href="index.php?choix=ok&menu=3">
            <div class="onglet">
                Configuration
            </div>
            </a>
            <a href="index.php?choix=ok&menu=4">
            <div class="onglet">
                Autres
            </div>
            </a>
            <a href="index.php?deconnexion=ok">
            <div class="onglet">
                Déconnexion
            </div>
            </a>
            </div>';
        }
        return $menu;
    }



private function genereEnteteHtml(){
//header("Content-type: text/html; charset=utf-8");
$entete="<!DOCTYPE html>";
$entete.="<html>";
$entete.="<head>";
$entete.= "<link href=\"vue/css/general.css\" type=\"text/css\" rel=\"stylesheet\" /> ";
$entete.='</head>
<div id="haut_page">
        <a href="index.php"><img src="vue/img/bandeau-RAlt.png" style="width:100%;"/></a>
        <div id="date">
            Vendredi<br/><span style="color:#5882FA;">1</span> Avril 2016
        </div>
';
return $entete;
}

public function genereBandeauApresConnexion(){
$entete=$this->genereEnteteHtml();
$entete.$this->genereBandeauAvantConnexion();
return $entete.$this->itemsBandeauApresConnexion();
}


public function genereBandeauAvantConnexion() {
    return $entete=$this->genereEnteteHtml();
}


public function generePied(){
$pied= '</body>
<div id="bas_page">
        <table style="width: 80%; margin: auto; text-align: center;font-size: 11px;">
            <tr>
            <td>IUT de Nantes - Site de la Fleuriaye</td>
            <td>2 avenue du Prof Jean Rouxel - Carquefou</td>
            <td>Tel : 02 28 09 20 00</td>
            </tr>
    </div>';
$pied.= "</html>";
return $pied;
}


}

?>
