<?php

require_once 'controleurAuthentification.php';
require_once 'controleurInscriptionEtu.php';
require_once 'controleurInscriptionEnt.php';
require_once 'controleurConfirmationInscription.php';
require_once 'controleurOubliMdp.php';
require_once 'controleurLost.php';
require_once 'controleurMenu.php';
require_once 'controleurProfil.php';
require_once __DIR__."/../modele/dao/dao.php";

class Routeur {

  private $ctrlAuthentification;
  private $ctrlInscriptionEtu;
  private $ctrlInscriptionEnt;
  private $ctrlConfirmationInscription;
  private $ctrlOubliMdp;
  private $ctrlLost;
  private $ctrlProfil;
  private $dao;

  public function __construct() {
    $this->ctrlAuthentification= new ControleurAuthentification();
    $this->ctrlInscriptionEnt= new ControleurInscriptionEnt();
    $this->ctrlInscriptionEtu= new ControleurInscriptionEtu();
    $this->ctrlConfirmationInscription= new ControleurConfirmationInscription();
    $this->ctrlOubliMdp= new ControleurOubliMdp();
    $this->ctrlMenu = new ControleurMenu();
    $this->ctrlLost = new ControleurLost();
    $this->ctrlProfil = new ControleurProfil();
    $this->dao = new Dao();
  }

  // Traite une requête entrante
  public function routerRequete() {

    if (isset($_POST['submit_login'])) {
      $this->dao->connexion();
      if($this->dao->verifieMotDePasse($_POST['identifiant'],$_POST['password'])) {
         $_SESSION['type_connexion'] = $this->dao->getTypeUtilisateur($_POST['identifiant']);
         $_SESSION['idUser'] = $this->dao->getId($_POST['identifiant'],$_SESSION['type_connexion']);
         $this->ctrlMenu->afficherMenu(1);
         return;
      }
    }

    if(isset($_POST['startGeneration'])){
      $this->dao->generatePlanning();
      $this->ctrlMenu->afficherMenu(1);
      return;
    }

    if(isset($_POST['changementListeEtu'])) {
      $string1 = "";
      $string2 = "";
      $string3 = "";
      $string4 = "";
      if ($_POST['choix1'] != "Faire un choix...") {
        $string1 = $_POST['choix1'];
      }
      if ($_POST['choix2'] != "Faire un choix...") {
        $string2 = ','.$_POST['choix2'];
      }
      if ($_POST['choix3'] != "Faire un choix...") {
        $string3 = ','.$_POST['choix3'];
      }
      if ($_POST['choix4'] != "Faire un choix...") {
        $string4 = ','.$_POST['choix4'];
      }
      $newList = $string1.$string2.$string3.$string4;
      $this->dao->editChoixEtudiant($_SESSION['idUser'],$newList);
      $this->ctrlMenu->afficherMenu(2);
      return;
    }

    if (isset($_GET['profil']) && isset($_GET['type']) && isset($_SESSION['type_connexion'])) {
            if ($_GET['type'] == "tmpEnt") {
              $this->ctrlProfil->afficherProfil("entreprise",$this->dao->getTempEnt($_GET['profil']));
              return;
            }
            if ($_GET['type'] == "tmpEtu") {
            $this->ctrlProfil->afficherProfil("etudiant",$this->dao->getTempEtu($_GET['profil']));
            return;
         }
          if ($_GET['type'] == "Ent") {
            $this->ctrlProfil->afficherProfil("entreprise",$this->dao->getEnt($_GET['profil']));
            return;
          }
          if ($_GET['type'] == "Etu") {
            $this->ctrlProfil->afficherProfil("etudiant",$this->dao->getEtu($_GET['profil']));
            return;
          }
    }

    if (isset($_POST['changementConfig'])) {
      if ($_POST['heureDebutMatin'] != "") {
        $this->dao->editHeureDebutMatin($_POST['heureDebutMatin']);
      }
      if ($_POST['heureDebutAprem']  != "") {
        $this->dao->editHeureDebutAprem($_POST['heureDebutAprem']);
      }
      if ($_POST['nbCreneauxMatin'] != "") {
        $this->dao->editNbCreneauxMatin($_POST['nbCreneauxMatin']);
      }
      if ($_POST['nbCreneauxAprem'] != "") {
        $this->dao->editNbCreneauxAprem($_POST['nbCreneauxAprem']);
      }
      if ($_POST['dureeCreneau'] != "") {
        $this->dao->editDureeCreneau($_POST['dureeCreneau']);
      }
      $this->ctrlMenu->afficherMenu(3);
      return;
    }


    //Les modifications de compte de l'entreprise
    if (isset($_POST['modification_entreprise_organisation'])) {
      if ($_POST['disponibiliteSociete'] != "") {
        $this->dao->editTypeCreneauEntreprise(($_SESSION['idUser']), $_POST['disponibiliteSociete']);
      }
      if ($_POST['nbStandsSociete'] != 0) {
        $this->dao->editNbStandsEntreprise(($_SESSION['idUser']), $_POST['nbStandsSociete']);
      }
      if ($_POST['nbRepasSociete'] >= 0) {
        $this->dao->editNbRepasEntreprise(($_SESSION['idUser']), $_POST['nbRepasSociete']);
      }
      $this->ctrlMenu->afficherMenu(3);
      return;
    }
    if (isset($_POST['modification_entreprise_formations'])) {
      if(isset($_POST['formation'])) {
        $stringFormations = "";
        $forms = $_POST['formation'];
        foreach ($forms as $form){
          $stringFormations = $stringFormations . $form . ",";
        }
        $this->dao->editFormationsRechercheesEntreprise(($_SESSION['idUser']), $stringFormations);
      }
      $this->ctrlMenu->afficherMenu(3);
      return;
    }
    if (isset($_POST['modification_entreprise_informations'])) {
      if ($_POST['nomSociete'] != "") {
        $this->dao->editNomEntreprise(($_SESSION['idUser']), $_POST['nomSociete']);
      }
      if ($_POST['villeSociete'] != "") {
        $this->dao->editVilleEntreprise(($_SESSION['idUser']), $_POST['villeSociete']);
      }
      if ($_POST['codePostalSociete'] != 0) {
        $this->dao->editCPEntreprise(($_SESSION['idUser']), $_POST['codePostalSociete']);
      }
      if ($_POST['adresseSociete'] != "") {
        $this->dao->editAdresseEntreprise(($_SESSION['idUser']), $_POST['adresseSociete']);
      }
      $this->ctrlMenu->afficherMenu(3);
      return;
    }
    if (isset($_POST['modification_entreprise_contact'])) {
      if ($_POST['nomContactSociete'] != "") {
        $this->dao->editNomContactEntreprise(($_SESSION['idUser']), $_POST['nomContactSociete']);
      }
      if ($_POST['prenomContactSociete'] != "") {
        $this->dao->editPrenomContactEntreprise(($_SESSION['idUser']), $_POST['prenomContactSociete']);
      }
      if ($_POST['emailSociete'] != "") {
        $this->dao->editMailEntreprise(($_SESSION['idUser']), $_POST['emailSociete']);
      }
      if ($_POST['numTelSociete'] != 0) {
        $this->dao->editTelephoneEntreprise(($_SESSION['idUser']), $_POST['numTelSociete']);
      }
      $this->ctrlMenu->afficherMenu(3);
      return;
    }
    if (isset($_POST['modification_entreprise_motdepasse'])) {
      if ($_POST['mdpActuel'] != "" && $_POST['mdpNouveau1'] != "" && $_POST['mdpNouveau2'] != ""
        && $_POST['mdpNouveau1'] == $_POST['mdpNouveau2']) {
          $this->dao->editMdpEntreprise(($_SESSION['idUser']), $_POST['mdpNouveau1'], $_POST['mdpActuel']);
      }
      $this->ctrlMenu->afficherMenu(3);
      return;
    }

     //Les modifications de compte de l'étudiant
    if (isset($_POST['modification_etudiant_identite'])) {
      if ($_POST['nomEtu'] != "") {
        $this->dao->editNomEtudiant(($_SESSION['idUser']), $_POST['nomEtu']);
      }
      if ($_POST['prenomEtu'] != "") {
        $this->dao->editPrenomEtudiant(($_SESSION['idUser']), $_POST['prenomEtu']);
      }
      if ($_POST['email'] != "") {
        $this->dao->editMailEtudiant(($_SESSION['idUser']), $_POST['email']);
      }
      if ($_POST['numTelEtu'] > 0) {
        $this->dao->editTelephoneEtudiant(($_SESSION['idUser']), $_POST['numTelEtu']);
      }
      $this->ctrlMenu->afficherMenu(4);
      return;
    }
    if (isset($_POST['modification_etudiant_motdepasse'])) {
      if ($_POST['mdpActuel'] != "" && $_POST['mdpNouveau1'] != "" && $_POST['mdpNouveau2'] != ""
        && $_POST['mdpNouveau1'] == $_POST['mdpNouveau2']) {
          $this->dao->editMdpEtudiant(($_SESSION['idUser']), $_POST['mdpNouveau1'], $_POST['mdpActuel']);
      }
      $this->ctrlMenu->afficherMenu(4);
      return;
    }

    if (isset($_GET['error'])) {
      $_SESSION['fail'] = "Êtes-vous perdu(e) ? Il semblerait qu'un imprévu<br/>soit arrivé. Refaites donc votre choix pour retrouver<br/>vos marques.";
      $this->ctrlLost->genererLost();
      return;
    }

    if (isset($_POST['inscription'])) {
      $date = getdate();
      if ($_POST['inscription'] == "etudiant" && ($date['mday'] > 30 && $date['mon'] >2) || ($date['mday'] < 21 && $date['mon'] < 4)) {
        if ($this->dao->ajoutEtudiant()) {
        	$this->ctrlConfirmationInscription->genereVueConfirmationInscription();
        	return;
        }
        else {
        	$_SESSION['fail'] = "Une autre personne du même nom ou utilisant cette<br/>adresse email semble déjà inscrite.<br/>Veuillez réessayer avec une autre adresse ou<br/>vérifiez que vous n'êtes pas déjà inscrit.";
        	$this->ctrlLost->genererLost();
      		return;
        }
      }
      if ($_POST['inscription'] == "entreprise" && $date['mday'] > 21 && $date['mon'] >2) {
        if($this->dao->ajoutEntreprise()) {
        	$this->ctrlConfirmationInscription->genereVueConfirmationInscription();
        	return;
        }
       else {
       		$_SESSION['fail'] = "Cette adresse email a déjà été utilisée ou cette<br/>entreprise est déjà inscrite à l'événement.<br/>Veuillez vérifier que vous n'êtes pas déjà inscrit<br/>ou réessayez avec une autre adresse email.";
       		$this->ctrlLost->genererLost();
     		return;
       }
      }
    }

    if (isset($_GET['validation']) && isset($_GET['id']) && isset($_GET['type']) && isset($_SESSION['type_connexion'])) {
      if ($_SESSION['type_connexion'] == "admin") {
        if ($_GET['type'] == "tmpEtu") {
          $user = $this->dao->getTempEtu($_GET['id']);
          $mail = $user[0]->getMailEtu();
            $message = "Bonjour,<br/>";
            $message .= "Nous avons l'honneur de vous informer que votre compte sur le site http://jobmeeting.iut-nantes.univ-nantes.fr<br/>";
            $message .= "Vous pouvez dorénavant vous connecter sur le site internet et avoir accès à vos données.<br/><br/>";
            $message .= "Cordialement,<br/>";
            $message .= "Tifenn Corbel";
            $headers = "From: Tifenn Corbel <Tifenn.Corbel@univ-nantes.fr> <br/>";
            $headers .= "To-Sender: <br/>";
            $headers .= "X-Mailer: PHP<br/>";
            $headers .= "Reply-To: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Return-Path: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
            $subject = "[Activation de compte]";
            $sent = false;
            while($sent) {
              $sent = $sent = false;
            while($sent) {
              $sent = mail($mail,utf8_decode($subject),$message,$headers);
            }
            }

          $this->dao->validerEtudiant($_GET['id']);
        }
        if ($_GET['type'] == "tmpEnt") {

          $user = $this->dao->getTempEnt($_GET['id']);
          $mail = $user[0]->getMailEnt();

            $message = "Bonjour,<br/>";
            $message .= "Nous avons l'honneur de vous informer que votre compte sur le site http://jobmeeting.iut-nantes.univ-nantes.fr a été activé.<br/>";
            $message .= "Vous pouvez dorénavant vous connecter sur le site internet et avoir accès à vos données.<br/><br/>";
            $message .= "Cordialement,<br/>";
            $message .= "Tifenn Corbel";
            $headers = "From: Tifenn Corbel <Tifenn.Corbel@univ-nantes.fr> <br/>";
            $headers .= "To-Sender: <br/>";
            $headers .= "X-Mailer: PHP<br/>";
            $headers .= "Reply-To: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Return-Path: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
            $subject = "[Activation de compte]";
            $sent = false;
            while($sent) {
              $sent = mail($mail,utf8_decode($subject),$message,$headers);
            }

          $this->dao->validerEntreprise($_GET['id']);
        }
        $this->ctrlMenu->afficherMenu(2);
        return;
      }
    }

    if (isset($_GET['geler']) && isset($_GET['id']) && isset($_GET['type']) && isset($_SESSION['type_connexion'])) {
      if ($_SESSION['type_connexion'] == "admin") {
        if ($_GET['type'] == "Etu") {
          $user = $this->dao->getEtu($_GET['id']);
          $mail = $user[0]->getMailEtu();

            $message = "Bonjour,<br/>";
            $message .= "Nous avons le regret de vous informer que votre compte sur le site http://jobmeeting.iut-nantes.univ-nantes.fr a été gelé.<br/>";
            $message .= "Vous ne pouvez dorénavant plus vous connecter sur le site internet ni avoir accès à vos données.<br/><br/>";
            $message .= "Pour davantage d'informations, n'hésitez pas à nous contacter.<br/><br/>";
            $message .= "Cordialement,<br/>";
            $message .= "Tifenn Corbel";
            $headers = "From: Tifenn Corbel <Tifenn.Corbel@univ-nantes.fr> <br/>";
            $headers .= "To-Sender: <br/>";
            $headers .= "X-Mailer: PHP<br/>";
            $headers .= "Reply-To: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Return-Path: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
            $subject = "[Compte gelé]";
            @$sent = false;
            while($sent) {
              $sent = mail($mail,utf8_decode($subject),$message,$headers);
            }
          $this->dao->gelerEtudiant($_GET['id']);
        }
        if ($_GET['type'] == "Ent") {
          $user = $this->dao->getEnt($_GET['id']);
          $mail = $user[0]->getMailEnt();

            $message = "Bonjour,<br/>";
            $message .= "Nous avons le regret de vous informer que votre compte sur le site http://jobmeeting.iut-nantes.univ-nantes.fr a été gelé.<br/>";
            $message .= "Vous ne pouvez dorénavant plus vous connecter sur le site internet ni avoir accès à vos données.<br/><br/>";
            $message .= "Pour davantage d'informations, n'hésitez pas à nous contacter.<br/><br/>";
            $message .= "Cordialement,<br/>";
            $message .= "Tifenn Corbel";
            $headers = "From: Tifenn Corbel <Tifenn.Corbel@univ-nantes.fr> <br/>";
            $headers .= "To-Sender: <br/>";
            $headers .= "X-Mailer: PHP<br/>";
            $headers .= "Reply-To: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Return-Path: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
            $subject = "[Compte gelé]";
            @$sent = false;
            while($sent) {
              $sent = mail($mail,utf8_decode($subject),$message,$headers);
            }
          $this->dao->gelerEntreprise($_GET['id']);
        }
        $this->ctrlMenu->afficherMenu(2);
        return;
      }
    }

    if (isset($_GET['suppression']) && isset($_GET['id']) && isset($_GET['type']) && isset($_SESSION['type_connexion'])) {
      if ($_SESSION['type_connexion'] == "admin") {
        if ($_GET['type'] == "Etu") {
          $this->dao->supprimerEtu($_GET['id']);
          $this->ctrlMenu->afficherMenu(2);
          return;
        }
        if ($_GET['type'] == "tmpEtu") {
          $this->dao->supprimerEtuTemp($_GET['id']);
          $this->ctrlMenu->afficherMenu(2);
          return;
        }
        if ($_GET['type'] == "Ent") {
          $this->dao->supprimerEnt($_GET['id']);
          $this->ctrlMenu->afficherMenu(2);
          return;
        }
        if ($_GET['type'] == "tmpEnt") {
          $this->dao->supprimerEntTemp($_GET['id']);
          $this->ctrlMenu->afficherMenu(2);
          return;
        }
      }
      $this->ctrlMenu->afficherMenu(2);
      return;
    }

  	if (isset($_GET['oubliMdp'])) {
  		$this->ctrlOubliMdp->aideOubliMdp();
  		return;
  	}

  	if (isset($_GET['inscriptionEtu'])) {
      $date = getdate();
      if (($date['mday'] < 31 && $date['mon'] <4) && ($date['mday'] > 20 && $date['mon'] > 2)) {
        $this->ctrlInscriptionEtu->inscriptionEtu();
        return;
      }
  	}

  	if (isset($_GET['inscriptionEnt'])) {
      $date = getdate();
      if ($date['mday'] < 22 && $date['mon'] < 4) {
        $this->ctrlInscriptionEnt->inscriptionEnt();
        return;
      }
  	}

    if (isset($_GET['choix']) && isset($_SESSION['type_connexion']) && isset($_GET['menu'])) {
      if ($_SESSION['type_connexion'] == "entreprise" && ($_GET['menu'] > 3 || $_GET['menu'] < 1)) {
         $_SESSION['fail'] = "Êtes-vous perdu(e) ? Il semblerait qu'un imprévu<br/>soit arrivé. Refaites donc votre choix pour retrouver<br/>vos marques.";
         $this->ctrlLost->genererLost();
         return;
      }
      if ($_SESSION['type_connexion'] == "admin" && ($_GET['menu'] > 4 || $_GET['menu'] < 1)) {
         $_SESSION['fail'] = "Êtes-vous perdu(e) ? Il semblerait qu'un imprévu<br/>soit arrivé. Refaites donc votre choix pour retrouver<br/>vos marques.";
         $this->ctrlLost->genererLost();
         return;
      }
      $this->ctrlMenu->afficherMenu($_GET['menu']);
      return;
    }

  	if (isset($_GET['deconnexion'])) {

  		session_destroy();
      $this->ctrlAuthentification->authentification();
  		return;
  	}

    if (isset($_SESSION['type_connexion'])) {
      $this->ctrlMenu->afficherMenu(1);
      return;
    }

  	if (isset($_POST['submit_new_mdp'])) {
  		if($this->dao->estInscrit($_POST['mail_new_mdp'])) {
            $new_mdp = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
            $message = "Bonjour,<br/>";
            $message .= "Voici le nouveau mot de passe que vous avez demandé à réinitialiser :<br/>";
            $message .= "-----------------------<br/>";
            $message .= "$new_mdp<br/>";
            $message .= "-----------------------<br/>";
            $message .= "Si vous n'avez pas fait cette demande, veuillez en informer l'administrateur. Veuillez aussi manuellement modifier votre mot de passe en vous connectant au site JobMeeting de l'IUT de Nantes.<br/><br/>";
            $message .= "Cordialement,<br/>";
            $message .= "Tifenn Corbel";
            $headers = "From: Tifenn Corbel <Tifenn.Corbel@univ-nantes.fr> <br/>";
            $headers .= "To-Sender: <br/>";
            $headers .= "X-Mailer: PHP<br/>";
            $headers .= "Reply-To: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Return-Path: Tifenn.Corbel@univ-nantes.fr<br/>";
            $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
            $subject = "[Réinitialisation mot de passe]";
            @mail($_POST['mail_new_mdp'],utf8_decode($subject),$message,$headers);
            $_SESSION['fail'] = "Un email a été envoyé à l'adresse indiquée.";
            $this->dao->manualPasswdEdit($_POST['mail_new_mdp'],$new_mdp);
            $this->ctrlLost->genererLost();
            return;
      }
      else {
        $_SESSION['fail'] = "Cet email n'existe pas dans notre base de données ou n'a pas été validé. Si vous désirez être informé de l'état de cette validation, veuillez contacter l'administrateur.";
        $this->ctrlLost->genererLost();
        return;
      }
  	}

  	if (isset($_POST['submit_new_choix'])) {
  		/*
			TODO
			Accès à la BDD
			Modifier valeurs des choix de l'étudiant
			$this->ctrlMenu->afficherMenu(2);
  		*/
		$_SESSION['fail'] = "Cette fonctionnalité n'est pas encore<br/>implémentée. Nous nous excusons pour cela<br/>et vous demanderons de bien vouloir faire<br/>preuve de patience.";
        $this->ctrlLost->genererLost();
        return;
  	}

  	if (isset($_POST['edition_compte'])) {
  		/*
			TODO
			Si mdp correct
			Etablir modifications
  		*/
		$_SESSION['fail'] = "Cette fonctionnalité n'est pas encore<br/>implémentée. Nous nous excusons pour cela<br/>et vous demanderons de bien vouloir faire<br/>preuve de patience.";
        $this->ctrlLost->genererLost();
        return;
  	}


    $this->ctrlAuthentification->authentification();
  }

}

?>
