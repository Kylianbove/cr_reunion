<?php
include('db.php');


if(isset($_GET['token'])){


  $selecttokenadmin = $connexion->prepare("SELECT * FROM adminusers WHERE token=?");
  $selecttokenadmin->execute(array($_GET['token']));
  $admin = $selecttokenadmin->fetch();

  $selecttokenmod = $connexion->prepare("SELECT * FROM moderateur WHERE actif =1 AND token=?");
  $selecttokenmod->execute(array($_GET['token']));
  $mod = $selecttokenmod->fetch();

  $selecttokencontri = $connexion->prepare("SELECT * FROM contributeur WHERE actif =1 AND token=?");
  $selecttokencontri->execute(array($_GET['token']));
  $contri = $selecttokencontri->fetch();

  $selecttoken = $connexion->prepare("SELECT * FROM users WHERE actif =1 AND token=?");
  $selecttoken->execute(array($_GET['token']));
  $utilisateur = $selecttoken->fetch();

  if($admin != null || $mod != null || $contri != null || $utilisateur != null){
  if(isset($_GET["dwn"])) {


  // Entête pour Ouvrir avec MSExcel
  header("content-type: application/vnd.ms-excel");
  header("Content-type:   application/x-msexcel; charset=utf-8");
  header("content-type: application/msword");
  header("content-type: application/pdf");

  header("content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
  header("Content-Disposition: attachment; filename=".basename($_GET ["dwn"]));

  
  flush(); // Envoie le buffer
  readfile($_GET["dwn"]); // Envoie le fichier

  }
}

}

?>
