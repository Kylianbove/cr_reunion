<?php include("db.php");

?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  @session_start();
}


// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING']=="")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_UsernameADM'] = NULL;
  $_SESSION['MM_UserGroupADM'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_UsernameADM']);
  unset($_SESSION['MM_UserGroupADM']);
  unset($_SESSION['PrevUrl']);


  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";



// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
  // For security, start by assuming the visitor is NOT authorized.
  $isValid = False;

  // When a visitor has logged into this site, the Session variable MM_UsernameADM set equal to their username.
  // Therefore, we know that a user is NOT logged in if that Session variable is blank.
  if (!empty($UserName)) {
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
    // Parse the strings into arrays.
    $arrUsers = Explode(",", $strUsers);
    $arrGroups = Explode(",", $strGroups);
    if (in_array($UserName, $arrUsers)) {
      $isValid = true;
    }
    // Or, you may restrict access to only certain users based on their username.
    if (in_array($UserGroup, $arrGroups)) {
      $isValid = true;
    }
    if (($strUsers == "") && true) {
      $isValid = true;
    }
  }

  return $isValid;
}


$MM_restrictGoTo = "auth_index.php";
if (!((isset($_SESSION['MM_UsernameADM'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_UsernameADM'], $_SESSION['MM_UserGroupADM'])))) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo);
  exit;
}
?>
<?php


$query_rs_admin = $connexion->prepare("SELECT * FROM adminusers WHERE email=?");
$query_rs_admin->execute(array($_SESSION['MM_UsernameADM']));
$resultat = $query_rs_admin->fetch();

$query_rs_mod = $connexion->prepare("SELECT * FROM moderateur WHERE email=?");
$query_rs_mod->execute(array($_SESSION['MM_UsernameADM']));
$moderateur = $query_rs_mod->fetch();

$query_rs_contri = $connexion->prepare("SELECT * FROM contributeur WHERE email=?");
$query_rs_contri->execute(array($_SESSION['MM_UsernameADM']));
$contributeur = $query_rs_contri->fetch();


if(isset($_GET['id'])){
$query_rs_utiles = $connexion->prepare("SELECT * FROM planning WHERE id_planning=?");
$query_rs_utiles->execute(array($_GET['id']));
$row_rs_utiles = $query_rs_utiles->fetch();
}



$query_rs_content = $connexion->prepare("SELECT *, DATE_FORMAT(date_debut, \"%d/%m/%Y %H-%i\") as date_debut, DATE_FORMAT(date_fin, \"%d/%m/%Y %H-%i\") as date_fin FROM planning ORDER BY id_planning ASC");
$query_rs_content->execute();
$row_rs_content = $query_rs_content->fetch();

/*
$tg = $row_rs_content['illu'];
*/

// Constantes
define('TARGET', 'uploads/slides/');    // Repertoire cible
define('MAX_SIZE', 800000);    // Taille max en octets du fichier

if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}


require ("session.class.php");

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Administration de votre site internet | by Oslab Technologies</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet">
<!-- jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->

<link rel="stylesheet" href="css/jquery.datetimepicker.min.css" type='text/css' />


<script src="js/jscolor.js"></script>
<script src="js/jquery-1.10.2.min.js"></script>

<script src="js/amcharts.js"></script>
<script src="js/serial.js"></script>
<script src="js/light.js"></script>
<script src="js/radar.js"></script>
<link rel="stylesheet" href="css/monthly.css">
<link href="css/barChart.css" rel='stylesheet' type='text/css' />
<link href="css/fabochart.css" rel='stylesheet' type='text/css' />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/jquery.datetimepicker.full.js"></script>

<!--
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
-->
<!--clock init-->
<script src="js/css3clock.js"></script>
<!--Easy Pie Chart-->
<!--skycons-icons-->
<script src="js/skycons.js"></script>

<script src="js/jquery.easydropdown.js"></script>

<!--//skycons-icons-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script>
$(document).ready(function() {
  $('textarea').summernote();
});
</script>
<style>
.note-toolbar{ background:#ccc!important; }
.note-editor button.btn{ padding:0px!important; }
textarea{
  height:300px!important;
}
</style>
</head>
<body>
  <?php if($resultat !=null || $moderateur !=null){?>
   <div class="page-container">
   <!--/content-inner-->
  <div class="left-content">
     <div class="inner-content">
    <!-- header-starts -->
      <div class="header-section">
            <!--menu-right-->
            <div class="top_menu">

              <!--/profile_details-->

              <div class="clearfix"></div>
              <!--//profile_details-->
            </div>
            <!--//menu-right-->
          <div class="clearfix"></div>
        </div>
          <!-- //header-ends -->
            <div class="outter-wp">

                      <!--/sub-heard-part-->
                    <!--/tabs-->
                     <div class="tab-main">
                       <!--/tabs-inner-->
                        <div class="tab-inner">
                              <div id="tabs" class="tabs">
                            <?php if((!isset($_GET['id']))&&(!isset($_GET['ajout']))){ ?>
                                      <h2 class="inner-tittle">Zone Planning <a href="planning.php?ajout" class="btn btn-warning"><i class="fa fa-plus"></i> Ajouter</a>
                                        <form method="post" action="" enctype="multipart/form-data">
                                          <button type="submit" class="btn btn-default" name="generer" style="float: right; margin-right: 20%; font-size: 20px;">Générer fichier XML</button>
                                        </form>
                                        </h2>
                                   <?php
                                      if(isset($_POST['generer'])){
                                      $select = $connexion->query("SELECT *, DATE_FORMAT(date_debut, \"%Y-%m-%d\") as date_deb, DATE_FORMAT(date_fin, \"%Y-%m-%d\") as date_fin FROM planning WHERE publier = 1 AND annuler = 0");

                                      $xmlFile = new DOMDocument('1.0', 'utf-8');
                                      $xmlFile->appendChild($monthly = $xmlFile->createElement('monthly'));

                                      while($rs = $select->fetch(PDO::FETCH_ASSOC)){
                                        $monthly->appendChild($event = $xmlFile->createElement('event'));
                                        $event->appendChild($xmlFile->createElement('id', $rs['id_planning']));
                                        $event->appendChild($xmlFile->createElement('name', $rs['titre']));
                                        $event->appendChild($xmlFile->createElement('startdate', $rs['date_deb']));
                                        $event->appendChild($xmlFile->createElement('enddate', $rs['date_fin']));
                                        $event->appendChild($xmlFile->createElement('color', $rs['couleur']));
                                        $event->appendChild($xmlFile->createElement('affichage', $rs['affichage']));
                                      }

                                      $xmlFile->formatOutput = true;
                                      $xmlFile->save('events.xml');


                                    }
                                     ?>

                                      <form method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group2">
                                      <label>trier par publication:</label>
                                      <select id="publication" name="publication">
                                        <option value="0">Tout afficher</option>

                                        <option value="1">Afficher planning publié</option>

                                        <option value="2">Afficher planning non publié</option>

                                      </select>
                                      <label>trier par affichage:</label>
                                      <select id="affichage" name="affichage">
                                        <option value="0">Public</option>

                                        <option value="1">Pour tous les membres connectés</option>

                                        <option value="2">Pour les utilisateurs de type 2 minimum</option>

                                        <option value="3">Pour les utilisateurs de type 3 minimum</option>

                                        <option value="4">Pour les contributeurs, modérateurs et administrateurs</option>
                                      </select>
                                      <label>trier par annulation:</label>
                                      <select id="annulation" name="annulation">
                                        <option value="0">Tout afficher</option>

                                        <option value="1">Afficher planning annulé</option>

                                        <option value="2">Afficher planning non annulé</option>

                                      </select>
                                        <label>trier par date:</label>
                                        <select id="orderby" name="orderby">
                                          <option value="0">Date début de la plus récente à la plus ancienne</option>

                                          <option value="1">Date début de la plus ancienne à la plus récente</option>

                                          <option value="2">Date fin de la plus proche à la plus éloignée</option>

                                          <option value="3">Date fin de la plus éloignée à la plus proche</option>

                                          <option value="4">Date fin dépassée</option>
                                        </select>

                                        <button type="submit" class="btn btn-default" name="filtrer">Appliquer Filtre</button>
                                          </div>
                                      </form>


                              <div class="graph-form">

                                  <div class="form-body">
                                  <style>
                                    thead{ background: #eee; padding: 5px;}
                                    th{ padding: 5px; font-size: 16px!important; }
                                    td{ padding: 5px; font-size: 14px!important; }
                                    table tr td:first-child{background: #e5e5e5; }
                                    tr{ border-bottom: 2px solid #e5e5e5; }
                                    table tr:nth-child(odd){
                                        background-color:#f0f0f0;
                                      }
                                      table{
                                        width: 100%;
                                      }
                                  </style>
                                  <table id="myTable" class="tablesorter">
                                  <thead>
                                  <tr>
                                   <th style="width: 150px;"></th>
                                    <th style="width: 120px;">Publier</th>
                                    <th style="width: 150px;">Affichage</th>
                                    <th style="width: 120px;">Annuler</th>
                                    <th style="width: 120px;">Titre</th>
                                    <th style="width: 120px;">Description</th>
                                    <th style="width: 200px;">Date début</th>
                                    <th>Date Fin</th>




                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    if(isset($_POST['filtrer']))
                                    {
                                      if($_POST['publication'] == 0)
                                      {
                                        $publier = "(publier = 1 OR publier = 0)";

                                      }
                                      if($_POST['publication'] == 1)
                                      {
                                        $publier = "publier = 1";

                                      }
                                      if($_POST['publication'] == 2)
                                      {
                                        $publier = "publier = 0";

                                      }
                                      if($_POST['affichage'] == 0)
                                      {
                                        $affichage = $publier;

                                      }
                                      if($_POST['affichage'] == 1)
                                      {
                                        $affichage = "affichage = 1";

                                      }
                                      if($_POST['affichage'] == 2)
                                      {
                                        $affichage = "affichage = 2";

                                      }
                                      if($_POST['affichage'] == 3)
                                      {
                                        $affichage = "affichage = 3";

                                      }
                                      if($_POST['affichage'] == 4)
                                      {
                                        $affichage = "affichage = 4";

                                      }


                                      if($_POST['annulation'] == 0)
                                      {
                                        $annuler = $publier;

                                      }
                                      if($_POST['annulation'] == 1)
                                      {
                                        $annuler = "annuler = 1";

                                      }
                                      if($_POST['annulation'] == 2)
                                      {
                                        $annuler = "annuler = 0";

                                      }

                                      if($_POST['orderby'] == 0)
                                      {
                                        $tri = "(date_debut < NOW() OR NOW() < date_debut) ORDER BY date_debut DESC";

                                      }
                                      elseif($_POST['orderby'] == 1)
                                      {
                                        $tri = "(date_debut < NOW() OR date_debut > NOW()) ORDER BY date_debut ASC";

                                      }
                                      elseif($_POST['orderby'] == 2)
                                      {
                                        $tri = "date_fin > NOW() ORDER BY date_fin ASC";

                                      }
                                      elseif($_POST['orderby'] == 3)
                                      {
                                        $tri = "date_fin > NOW() ORDER BY date_fin DESC";

                                      }
                                      elseif($_POST['orderby'] == 4)
                                      {
                                        $tri = "date_fin < NOW() ORDER BY date_fin ASC";

                                      }

                                      $query_rs_content2 = $connexion->prepare("SELECT * FROM planning WHERE $publier AND $affichage AND $annuler AND $tri");
                                      $query_rs_content2->execute();
                                      $row_rs_content2 = $query_rs_content2->fetch();

                                      if($row_rs_content2 == null){
                                        $Session15 = new Session();
                                        $Session15->setFlash("Aucun planning correspond à votre recherche",'error');
                                        $Session15->flash_danger();
                                      }
                                      do{ ?>


                                    <tr>
                                      <td><a href="planning.php?id=<?php echo $row_rs_content2['id_planning']; ?>"style="color: green;"><i class="fa fa-edit"></i>Modif.</a>  |
                                        <a href="planning.php?supprimer=<?php echo $row_rs_content2['id_planning']; ?>"style="color: red;"><i class="fa fa-trash-o"></i>Suppr.</a>
                                      </td>


                                      <td>
                                      <?php if($row_rs_content2['publier']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Non Publié </span><?php } ?>
                                      <?php if($row_rs_content2['publier']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Publié </span> <?php } ?></td>
                                        <td><strong>
                                        <?php if($row_rs_content2['affichage']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-unlock" style="color: green"></i> Public </span><?php } ?>
                                        <?php if($row_rs_content2['affichage']==1){ ?><span style="display:block; width; 150px;"> Pour tous les membres connectés </span> <?php } ?>
                                        <?php if($row_rs_content2['affichage']==2){ ?><span style="display:block; width; 150px;"> Pour les utilisateurs de type 2 minimum </span> <?php } ?>
                                        <?php if($row_rs_content2['affichage']==3){ ?><span style="display:block; width; 150px;"> Pour les utilisateurs de type 3 minimum </span> <?php } ?>
                                        <?php if($row_rs_content2['affichage']==4){ ?><span style="display:block; width; 150px;"> Pour les contributeurs, modérateurs et administrateurs </span> <?php } ?>
                                      </strong>  </td>
                                      <td>
                                      <?php if($row_rs_content2['annuler']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Non Annulé </span><?php } ?>
                                      <?php if($row_rs_content2['annuler']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Annulé </span> <?php } ?></td>


                                      <td><strong><?php echo $row_rs_content2['titre']; ?></strong></td>
                                      <td><strong><?php echo $row_rs_content2['description']; ?></strong></td>
                                      <td><strong><?php echo $row_rs_content2['date_debut']; ?></strong></td>
                                      <td><strong><?php echo $row_rs_content2['date_fin']; ?></strong></td>




                                    </tr>
                                  <?php }while($row_rs_content2 = $query_rs_content2->fetch()); ?>

                                    <?php
                                  }else
                                      {
                                        do{ ?>


                                  <tr>
                                    <td><a href="planning.php?id=<?php echo $row_rs_content['id_planning']; ?>"style="color: green;"><i class="fa fa-edit"></i>Modif.</a>  |
                                      <a href="planning.php?supprimer=<?php echo $row_rs_content['id_planning']; ?>"style="color: red;"><i class="fa fa-trash-o"></i>Suppr.</a>
                                    </td>


                                    <td>
                                    <?php if($row_rs_content['publier']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Non Publié </span><?php } ?>
                                    <?php if($row_rs_content['publier']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Publié </span> <?php } ?></td>
                                      <td><strong>
                                      <?php if($row_rs_content['affichage']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-unlock" style="color: green"></i> Public </span><?php } ?>
                                      <?php if($row_rs_content['affichage']==1){ ?><span style="display:block; width; 150px;"> Pour tous les membres connectés </span> <?php } ?>
                                      <?php if($row_rs_content['affichage']==2){ ?><span style="display:block; width; 150px;"> Pour les utilisateurs de type 2 minimum </span> <?php } ?>
                                      <?php if($row_rs_content['affichage']==3){ ?><span style="display:block; width; 150px;"> Pour les utilisateurs de type 3 minimum </span> <?php } ?>
                                      <?php if($row_rs_content['affichage']==4){ ?><span style="display:block; width; 150px;"> Pour les contributeurs, modérateurs et administrateurs </span> <?php } ?>
                                      </strong></td>
                                    <td>
                                    <?php if($row_rs_content['annuler']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Non Annulé </span><?php } ?>
                                    <?php if($row_rs_content['annuler']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Annulé </span> <?php } ?></td>



                                    <td><strong><?php echo $row_rs_content['titre']; ?></strong></td>
                                    <td><strong><?php echo $row_rs_content['description']; ?></strong></td>
                                    <td><strong><?php echo $row_rs_content['date_debut']; ?></strong></td>
                                    <td><strong><?php echo $row_rs_content['date_fin']; ?></strong></td>




                                  </tr>
                                <?php }while($row_rs_content = $query_rs_content->fetch()); }?>

                                  </tbody>
                                  </table>
                                  <style>
                                  .monthly-event-list{
                                    max-height: 75px!important;
                                  }
                                  .monthly-day-wrap{
                                    min-height: 395px;
                                  }
                                  </style>
                                  <form method="post" action="" enctype="multipart/form-data">
                                    <button type="submit" class="btn btn-default" name="agenda" style="float: left; margin-top: 5%; font-size: 20px;"><i class="fa fa-eye"></i> Voir agenda</button>
                                  </form>
                                  <?php if(isset($_POST['agenda'])){?>

                                    <div class="monthly" id="calendar" style="width: 100%; margin-top: 10%; "></div>

                               <?php } ?>
                                <?php } ?>

                                  <?php
                                    if(isset($_GET['supprimer'])){

                                      $req = $connexion->prepare("DELETE FROM planning WHERE id_planning=?");
                                      $req->execute(array($_GET['supprimer']));
                                      $Session12 = new Session();
                                      $Session12->setFlash("Vous venez de supprimer un planning",'error');
                                      $Session12->flash_danger();
                                      $insertGoTo = "planning.php?OK";


                                    echo "<script> setTimeout(function(){location.href='".$insertGoTo."'} , 3000);</script>";



                                  }
                                     ?>
                                  <?php if(isset($_GET['id'])){ ?>
                                   <h3 class="inner-tittle">Modifier un Planning</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="titre">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" value="<?php echo $row_rs_utiles['titre']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description" rows="8" cols="80" required><?php echo $row_rs_utiles['description']; ?></textarea>

                                    </div>

                                    <div class="form-group">
                                    <label for="couleur">Couleur</label>
                                    <input type="text" class="form-control" id="couleur" name="couleur" value="<?php echo $row_rs_utiles['couleur']; ?>" data-jscolor="{preset:'small dark', position:'right'}" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="date_debut">Date Début</label>

                                    <input type="text" class="form-control" id="date_debut" name="date_debut" placeholder="Date Début" value="<?php echo $row_rs_utiles['date_debut']; ?>" required>
                                    </div>
                                    <script type="text/javascript">

                                       $('#date_debut').datetimepicker();


                                     </script>



                                    <div class="form-group">
                                    <label for="date_fin">Date Fin</label>
                                    <input type="text" class="form-control" id="date_fin" name="date_fin" placeholder="Date Fin" value="<?php echo $row_rs_utiles['date_fin']; ?>" required>
                                    </div>
                                    <script type="text/javascript">

                                       $('#date_fin').datetimepicker();


                                     </script>









                                    </div>
                                    <div class="col-md-6">



                                      <div class="form-group">
                                        <label for="annuler"  style="float:left;width:200px!important;">Annuler Planning</label>
                                        <select id="annuler" name="annuler" required>
                                          <option value="">--</option>

                                          <option value="0" <?php if($row_rs_utiles['annuler']=="0"){ ?>selected<?php } ?>>Non</option>

                                          <option value="1" <?php if($row_rs_utiles['annuler']=="1"){ ?>selected<?php } ?>>OUI</option>

                                        </select>
                                      </div></br>

                                    <div class="form-group">
                                      <label for="publier"  style="float:left;width:200px!important;">Publier Planning</label>
                                      <select id="publier" name="publier" required>
                                        <option value="">--</option>

                                        <option value="0" <?php if($row_rs_utiles['publier']=="0"){ ?>selected<?php } ?>>Non</option>

                                        <option value="1" <?php if($row_rs_utiles['publier']=="1"){ ?>selected<?php } ?>>OUI</option>

                                      </select>
                                    </div></br>

                                    <div class="form-group">
                                      <label for="affichage"  style="float:left;width:200px!important;">Affichage Planning</label>
                                      <select id="affichage" name="affichage" required>
                                        <option value="">--</option>

                                        <option value="0" <?php if($row_rs_utiles['affichage']=="0"){ ?>selected<?php } ?> >Public</option>

                                        <option value="1" <?php if($row_rs_utiles['affichage']=="1"){ ?>selected<?php } ?>>Pour tous les membres connectés</option>

                                        <option value="2" <?php if($row_rs_utiles['affichage']=="2"){ ?>selected<?php } ?>>Pour les utilisateurs de type 2 minimum</option>

                                        <option value="3" <?php if($row_rs_utiles['affichage']=="3"){ ?>selected<?php } ?>>Pour les utilisateurs de type 3 minimum</option>

                                        <option value="4" <?php if($row_rs_utiles['affichage']=="4"){ ?>selected<?php } ?>>Pour les contributeurs, modérateurs et administrateurs</option>

                                      </select>
                                    </div>

                                     </div>
                                     <div class="clearfix"></div>
                                     <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                     <input type="hidden" name="MM_update" value="form1" />
                                      <button type="submit" class="btn btn-default" name="modifier" style="background-color: #0bdb00;">Valider les modifications</button>
                                      <?php

                                      if(isset($_POST['modifier']))
                                          {



                                                  $updateSQL = $connexion->prepare("UPDATE planning SET titre=:titre, description=:description, couleur=:couleur, date_debut=:date_debut, date_fin=:date_fin, annuler=:annuler, publier=:publier, affichage=:affichage WHERE id_planning='".$_GET['id']."'");


                                                  $updateSQL -> bindParam(':titre', $_POST['titre']);
                                                  $updateSQL -> bindParam(':description', $_POST['description']);
                                                  $updateSQL -> bindParam(':couleur', $_POST['couleur']);
                                                  $updateSQL -> bindParam(':date_debut', $_POST['date_debut']);
                                                  $updateSQL -> bindParam(':date_fin', $_POST['date_fin']);
                                                  $updateSQL -> bindParam(':annuler', $_POST['annuler']);
                                                  $updateSQL -> bindParam(':publier', $_POST['publier']);
                                                  $updateSQL -> bindParam(':affichage', $_POST['affichage']);


                                                  $updateSQL->execute();

                                                  $insertGoTo = "planning.php?OK";

                                                  echo "<script>window.location.href='".$insertGoTo."';</script>";


                                      }
                                        ?>

                                     <a href="planning.php" class="btn btn-warning">Retour à la liste</a>
                                   </form>
                                 </div>
                                      <?php } ?>

                                  <?php if(isset($_GET['ajout'])){ ?>
                                  <h3 class="inner-tittle">Ajouter un Planning</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="titre">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description" rows="8" cols="80" required></textarea>
                                    </div>


                                    <div class="form-group">
                                    <label for="couleur">Couleur</label>

                                    <input type="text" class="form-control" id="couleur" name="couleur" value="FFA000" data-jscolor="{preset:'small dark', position:'right'}" required>


                                    </div>


                                    <div class="form-group">
                                      <label for="titre">Date de Début</label>
                                    <div class='input-group date' >

                                     <input type='text' class="form-control" id='date_debut' name='date_debut' placeholder="_ _ _ _/_ _/_ _" required>
                                     <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                    </div>
                                   </div>
                                   <script>
                                   $('#date_debut').datetimepicker();



                                 </script>



                                    <div class="form-group">
                                      <label for="titre">Date de Fin</label>
                                    <div class='input-group date' >

                                     <input type='text' class="form-control" value="" id='date_fin' name='date_fin' placeholder="_ _ _ _/_ _/_ _" required>
                                     <span class="input-group-addon">
                                     <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                    </div>
                                   </div>
                                   <script type="text/javascript">

                                      $('#date_fin').datetimepicker();

                                    </script>



                                  </div>






                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="publier"  style="float:left;width:200px!important;">Publier Planning</label>
                                        <select id="publier" name="publier" required>
                                          <option value="">--</option>

                                          <option value="0" >Non</option>

                                          <option value="1" >OUI</option>

                                        </select>
                                      </div></br>

                                      <div class="form-group">
                                        <label for="affichage"  style="float:left;width:200px!important;">Affichage Planning</label>
                                        <select id="affichage" name="affichage" required>
                                          <option value="">--</option>

                                          <option value="0" >Public</option>

                                          <option value="1" >Pour tous les membres connectés</option>

                                          <option value="2" >Pour les utilisateurs de type 2 minimum</option>

                                          <option value="3" >Pour les utilisateurs de type 3 minimum</option>

                                          <option value="4" >Pour les contributeurs, modérateurs et administrateurs</option>

                                        </select>
                                      </div>







                                     </div>

                                     <div class="clearfix"></div>
                                     <input type="hidden" name="id" value="" />
                                     <input type="hidden" name="MM_update2" value="form1" />

                                      <button type="submit" class="btn btn-default" name="ajouter" style="background-color: #0bdb00;"><i class="fa fa-plus"></i> Ajouter</button> </form>
                                      <?php
                                      if(isset($_POST['ajouter'])){


                                                        $insertSQL = $connexion->prepare("INSERT INTO `planning`(`id_planning`, `titre`, `description`,`couleur`, `date_debut`, `date_fin`, `publier`, `affichage`, `annuler`) VALUES (:id_planning, :titre, :description, :couleur, :date_debut, :date_fin, :publier, :affichage, 0)");


                                                        $insertSQL -> bindParam(':id_planning', $id_planning);
                                                        $insertSQL -> bindParam(':titre', $_POST['titre']);
                                                        $insertSQL -> bindParam(':description', $_POST['description']);
                                                        $insertSQL -> bindParam(':couleur', $_POST['couleur']);
                                                        $insertSQL -> bindParam(':date_debut', $_POST['date_debut']);
                                                        $insertSQL -> bindParam(':date_fin', $_POST['date_fin']);
                                                        $insertSQL -> bindParam(':publier', $_POST['publier']);
                                                        $insertSQL -> bindParam(':affichage', $_POST['affichage']);

                                                        $insertSQL->execute();
                                                        $Result1 = $insertSQL->fetch();
                                                        $insertGoTo = "planning.php?OK";

                                                        echo "<script>window.location.href='".$insertGoTo."';</script>";


                                      }

                                       ?>
                                     <a href="planning.php" class="btn btn-warning">Retour à la liste</a>

                                   <?php } ?>
                                  </div>

                              </div>
                        <!--//tabs-inner-->
                     </div>
                    <!--//outer-wp-->
                  </div>
                   <!--footer section start-->
                    <footer>
                       <p>&copy 2021 Oslab Technologies. All Rights Reserved</p>
                    </footer>
                  <!--footer section end-->
                </div>
              </div>
        <!--//content-inner-->
      <!--/sidebar-menu-->
                    <?php include("left.php"); ?>
                <div class="clearfix"></div>
              </div>
              <script>
              var toggle = true;

              $(".sidebar-icon").click(function() {
                if (toggle)
                {
                $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                $("#menu span").css({"position":"absolute"});
                }
                else
                {
                $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                setTimeout(function() {
                  $("#menu span").css({"position":"relative"});
                }, 400);
                }

                      toggle = !toggle;
                    });

                    $('#typeSlider').on('change', function() {
                       if($(this).val()==1){

                        $('.line4').show();
                        $('.line5').show();
                        }
                        if($(this).val()==2){

                        $('.line4').show();
                        $('.line5').hide();
                        }
                        if($(this).val()==3){
                        $('.line4').hide();
                        $('.line5').hide();
                        }
                      });
              </script>

              <script type="text/javascript">
              var d = new Date();

              var month = d.getMonth()+1;
              var day = d.getDate();

              var output = d.getFullYear() + '/' +
                (month<10 ? '0' : '') + month + '/' +
                (day<10 ? '0' : '') + day;


              $('#dateDebut').datetimepicker({ formatDate:'Y-m-d', minDate: output });
              $('#dateFin').datetimepicker({ formatDate:'Y-m-d', minDate: output });


              </script>

  <?php }else{
          $url = "acceserreur.php";
          echo "<script>setTimeout(function(){location.href='".$url."'}, 0);</script>";
      } ?>
<!--js -->
<link rel="stylesheet" href="css/vroom.css">
<script type="text/javascript" src="js/vroom.js"></script>
<script type="text/javascript" src="js/TweenLite.min.js"></script>
<script type="text/javascript" src="js/CSSPlugin.min.js"></script>
<!-- <script src="js/jquery.nicescroll.js"></script> -->
<script src="js/scripts.js"></script>
<script src="js/monthly-1.0.0.js"></script>
<script>
$('#calendar').monthly({
  mode:'event',
  xmlUrl:'events.xml'
});

</script>



<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>
