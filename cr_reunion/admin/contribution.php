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
$query_rs_utiles = $connexion->prepare("SELECT * FROM contribution WHERE id_contribution=?");
$query_rs_utiles->execute(array($_GET['id']));
$row_rs_utiles = $query_rs_utiles->fetch();
}

require ("session.class.php");

$query_rs_content = $connexion->prepare("SELECT * FROM contribution ORDER BY id_contribution ASC");
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

<link rel="stylesheet" href="css/jquery.datetimepicker.css" type='text/css' />

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery.datetimepicker.js"></script>
<script src="js/amcharts.js"></script>
<script src="js/serial.js"></script>
<script src="js/light.js"></script>
<script src="js/radar.js"></script>
<link href="css/barChart.css" rel='stylesheet' type='text/css' />
<link href="css/fabochart.css" rel='stylesheet' type='text/css' />
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
                                      <h2 class="inner-tittle">Zone Contribution <a href="contribution.php?ajout" class="btn btn-warning"><i class="fa fa-plus"></i> Ajouter</a></h2>

                                      <form method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group2">
                                      <label>trier par validation:</label>
                                      <select id="validation" name="validation">
                                        <option value="0">Tout afficher</option>

                                        <option value="1">Afficher contributions validées</option>

                                        <option value="2">Afficher contributions non validées</option>

                                      </select>

                                      <label>trier par date:</label>
                                      <select id="order" name="order">
                                        <option value="0">Tout afficher</option>

                                        <option value="1">Date de validation de la plus récente à la plus ancienne</option>

                                        <option value="2">Date de validation de la plus ancienne à la plus récente</option>

                                      </select>

                                      <button type="submit" class="btn btn-default" name="filtrer">Appliquer Filtre </button>
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
                                    <th style="width: 120px;">Valider</th>
                                    <th style="width: 150px;">Utilisateur</th>
                                    <th style="width: 150px;">Titre</th>

                                    <th style="width: 200px;">Date Validation</th>
                                    <th>Valider Par</th>





                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    if(isset($_POST['filtrer']))
                                    {

                                      if($_POST['validation'] == 0)
                                      {
                                        $valider = "(valider = 1 OR valider = 0)";
                                      }

                                      if($_POST['validation'] == 1)
                                      {
                                        $valider = "valider = 1";
                                      }

                                      if($_POST['validation'] == 2)
                                      {
                                        $valider = "valider = 0";
                                      }

                                      if($_POST['order'] == 0)
                                      {
                                        $tri = $valider;

                                      }

                                      if($_POST['order'] == 1)
                                      {
                                        $tri = "(date_validation < NOW() OR NOW() < date_validation) ORDER BY date_validation DESC";

                                      }
                                      if($_POST['order'] == 2)
                                      {
                                        $tri = "(date_validation < NOW() OR date_validation > NOW()) ORDER BY date_validation ASC";
                                      }

                                      $query_rs_content2 = $connexion->prepare("SELECT * FROM contribution WHERE $valider AND $tri ");
                                      $query_rs_content2->execute();
                                      $row_rs_content2 = $query_rs_content2->fetch();

                                      if($row_rs_content2 == null){
                                        $Session15 = new Session();
                                        $Session15->setFlash("Aucune contribution correspond à votre recherche",'error');
                                        $Session15->flash_danger();
                                      }

                                      do{


                                    ?>
                                    <tr>
                                      <td><a href="contribution.php?id=<?php echo $row_rs_content2['id_contribution']; ?>"style="color: green;"><i class="fa fa-edit"></i>Modif.</a>  |
                                        <a href="contribution.php?supprimer=<?php echo $row_rs_content2['id_contribution']; ?>"style="color: red;"><i class="fa fa-trash-o"></i>Suppr.</a>
                                      </td>

                                      <td>
                                      <?php if($row_rs_content2['valider']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Non Validé </span><?php } ?>
                                      <?php if($row_rs_content2['valider']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Validé </span> <?php } ?></td>

                                        <?php
                                        $query_rs_idusers = $connexion->prepare("SELECT * FROM users WHERE actif = 1 AND id = '".$row_rs_content2['id_users']."'");
                                        $query_rs_idusers->execute();
                                        $row_rs_idusers = $query_rs_idusers->fetch();

                                        if ($row_rs_idusers == null)
                                        { ?>
                                          <td><strong><p style="color:red">!Aucun utilisateur ou utilisateur non actif</p></strong></td>
                                        <?php }else{ ?>

                                      <td><strong><?php echo $row_rs_idusers['nom']; ?><?php echo " ".$row_rs_idusers['prenom']; ?></strong></td>
                                        <?php } ?>
                                      <td><strong><?php echo $row_rs_content2['titre']; ?></strong></td>

                                        <td><strong><?php echo $row_rs_content2['date_validation']; ?></strong></td>

                                        <td><strong><?php echo $row_rs_content2['valider_par']; ?></strong></td>




                                    </tr>
                                  <?php }while($row_rs_content2 = $query_rs_content2->fetch());


                                  }else
                                  {
                                    do{ ?>

                                  <tr>
                                    <td><a href="contribution.php?id=<?php echo $row_rs_content['id_contribution']; ?>"style="color: green;"><i class="fa fa-edit"></i>Modif.</a>  |
                                      <a href="contribution.php?supprimer=<?php echo $row_rs_content['id_contribution']; ?>"style="color: red;"><i class="fa fa-trash-o"></i>Suppr.</a>
                                    </td>

                                    <td>
                                    <?php if($row_rs_content['valider']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Non Validé </span><?php } ?>
                                    <?php if($row_rs_content['valider']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Validé </span> <?php } ?></td>

                                      <?php
                                      $query_rs_idusers = $connexion->prepare("SELECT * FROM users WHERE actif = 1 AND id = '".$row_rs_content['id_users']."'");
                                      $query_rs_idusers->execute();
                                      $row_rs_idusers = $query_rs_idusers->fetch();

                                      if ($row_rs_idusers == null)
                                      { ?>
                                        <td><strong><p style="color:red">!Aucun utilisateur ou utilisateur non actif</p></strong></td>
                                      <?php }else{ ?>

                                    <td><strong><?php echo $row_rs_idusers['nom']; ?><?php echo " ".$row_rs_idusers['prenom']; ?></strong></td>
                                      <?php } ?>
                                    <td><strong><?php echo $row_rs_content['titre']; ?></strong></td>

                                      <td><strong><?php echo $row_rs_content['date_validation']; ?></strong></td>

                                      <td><strong><?php echo $row_rs_content['valider_par']; ?></strong></td>




                                  </tr>
                                <?php }while($row_rs_content = $query_rs_content->fetch());} ?>

                                  </tbody>
                                  </table>
                                <?php } ?>

                                  <?php
                                    if(isset($_GET['supprimer'])){

                                      $req = $connexion->prepare("DELETE FROM contribution WHERE id_contribution=?");
                                      $req->execute(array($_GET['supprimer']));
                                      $Session12 = new Session();
                                      $Session12->setFlash("Vous venez de supprimer une contribution",'error');
                                      $Session12->flash_danger();
                                      $insertGoTo = "contribution.php?OK";


                                    echo "<script> setTimeout(function(){location.href='".$insertGoTo."'} , 3000);</script>";



                                  }
                                     ?>
                                  <?php if(isset($_GET['id'])){ ?>
                                   <h3 class="inner-tittle">Modifier une Contribution</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="titre">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" value="<?php echo $row_rs_utiles['titre']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="details">Détails</label>
                                    <textarea class="form-control" id="details" name="details" placeholder="Détails" rows="8" cols="80" required><?php echo $row_rs_utiles['details']; ?></textarea>

                                    </div>




                                    <div class="form-group">
                                    <label for="id_users"  style="float:left;width:200px!important;">Utilisateur</label>
                                    <select id="id_users" name="id_users" required>

                                      <?php
                                        $query_rs_users = $connexion->prepare("SELECT * FROM users WHERE actif = 1 AND id = '".$row_rs_utiles['id_users']."'");
                                        $query_rs_users->execute();
                                        $row_rs_users = $query_rs_users->fetch();


                                           if ($row_rs_users > 0) {
                                          do{

                                      ?>

                                     <option value="<?php echo $row_rs_users['id']; ?>"><?php echo $row_rs_users['nom']; ?><?php echo " ".$row_rs_users['prenom']; ?></option>


                                      <?php

                                    }while($row_rs_users = $query_rs_users->fetch());
                                          }

                                       ?>
                                       <?php
                                         $query_rs_users2 = $connexion->prepare("SELECT * FROM users WHERE actif = 1 AND id != '".$row_rs_utiles['id_users']."'");
                                         $query_rs_users2->execute();
                                         $row_rs_users2 = $query_rs_users2->fetch();


                                            if ($row_rs_users2 > 0) {
                                           do{

                                       ?>

                                      <option value="<?php echo $row_rs_users2['id']; ?>"><?php echo $row_rs_users2['nom']; ?><?php echo " ".$row_rs_users2['prenom']; ?></option>


                                       <?php

                                     }while($row_rs_users2 = $query_rs_users2->fetch());
                                           }

                                        ?>

                                    </select>
                                  </div>

                                  <div class="form-group">
                                    <label for="valider"  style="float:left;width:200px!important;">Valider Contribution</label>
                                    <select id="valider" name="valider" required>
                                      <option value="">--</option>

                                      <option value="0" <?php if($row_rs_utiles['valider']=="0"){ ?>selected<?php } ?>>Non</option>

                                      <option value="1" <?php if($row_rs_utiles['valider']=="1"){ ?>selected<?php } ?>>OUI</option>

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

                                                  $daterequete = $connexion->prepare("SELECT * FROM contribution WHERE id_contribution='".$_GET['id']."'");
                                                  $daterequete->execute();
                                                  $date = $daterequete->fetch();

                                                   if($resultat !=null){
                                                      $valider_par = $resultat['nom']." ".$resultat['prenom'];
                                                   }
                                                   if($moderateur !=null){
                                                      $valider_par = $moderateur['nom']." ".$moderateur['prenom'];
                                                   }

                                                  if($date['date_validation'] == null){
                                                    if($_POST['valider'] == 1){
                                                      $updateSQL = $connexion->prepare("UPDATE contribution SET id_users=:id_users, titre=:titre, details=:details, valider=:valider, date_validation=NOW(), valider_par=:valider_par WHERE id_contribution='".$_GET['id']."'");

                                                      $updateSQL -> bindParam(':id_users', $_POST['id_users']);
                                                      $updateSQL -> bindParam(':titre', $_POST['titre']);
                                                      $updateSQL -> bindParam(':details', $_POST['details']);
                                                      $updateSQL -> bindParam(':valider', $_POST['valider']);
                                                      $updateSQL -> bindParam(':valider_par', $valider_par);


                                                      $updateSQL->execute();

                                                      $insertGoTo = "contribution.php?OK";

                                                      echo "<script>window.location.href='".$insertGoTo."';</script>";

                                                    }
                                                  }

                                                  $updateSQL = $connexion->prepare("UPDATE contribution SET id_users=:id_users, titre=:titre, details=:details, valider=:valider WHERE id_contribution='".$_GET['id']."'");

                                                  $updateSQL -> bindParam(':id_users', $_POST['id_users']);
                                                  $updateSQL -> bindParam(':titre', $_POST['titre']);
                                                  $updateSQL -> bindParam(':details', $_POST['details']);
                                                  $updateSQL -> bindParam(':valider', $_POST['valider']);


                                                  $updateSQL->execute();

                                                  $insertGoTo = "contribution.php?OK";

                                                  echo "<script>window.location.href='".$insertGoTo."';</script>";

                                      }
                                        ?>

                                     <a href="contribution.php" class="btn btn-warning">Retour à la liste</a>
                                   </form>
                                 </div>
                                      <?php } ?>

                                  <?php if(isset($_GET['ajout'])){ ?>
                                  <h3 class="inner-tittle">Ajouter une Contribution</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="titre">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="details">Détails</label>
                                    <textarea class="form-control" id="details" name="details" placeholder="Détails" rows="8" cols="80" required></textarea>
                                    </div>



                                    <div class="form-group">
                                    <label for="id_users"  style="float:left;width:200px!important;">Utilisateur</label>
                                    <select id="id_users" name="id_users" required>

                                      <?php
                                        $query_rs_users = $connexion->prepare("SELECT * FROM users WHERE actif = 1 ORDER BY id ASC");
                                        $query_rs_users->execute();
                                        $row_rs_users = $query_rs_users->fetch();


                                           if ($row_rs_users > 0) {
                                          do{

                                      ?>

                                     <option value="<?php echo $row_rs_users['id']; ?>"><?php echo $row_rs_users['nom']; ?><?php echo " ".$row_rs_users['prenom']; ?></option>


                                      <?php

                                    }while($row_rs_users = $query_rs_users->fetch());
                                          }

                                       ?>

                                    </select>
                                  </div>

                                  <div class="form-group">
                                    <label for="valider"  style="float:left;width:200px!important;">Valider Contribution</label>
                                    <select id="valider" name="valider" required>
                                      <option value="">--</option>

                                      <option value="0" >Non</option>

                                      <option value="1" >OUI</option>

                                    </select>
                                  </div>

                                  </div>






                                    <div class="col-md-6">








                                     </div>

                                     <div class="clearfix"></div>
                                     <input type="hidden" name="id" value="" />
                                     <input type="hidden" name="MM_update2" value="form1" />

                                      <button type="submit" class="btn btn-default" name="ajouter" style="background-color: #0bdb00;"><i class="fa fa-plus"></i> Ajouter</button> </form>
                                      <?php
                                      if(isset($_POST['ajouter']) && $_POST['valider'] == 1){
                                        $insertSQL = $connexion->prepare("INSERT INTO `contribution`(`id_contribution`, `id_users`, `titre`, `details`, `valider`, `date_validation`) VALUES (:id_contribution, :id_users, :titre, :details, :valider, NOW())");


                                        $insertSQL -> bindParam(':id_contribution', $id_contribution);
                                        $insertSQL -> bindParam(':id_users', $_POST['id_users']);
                                        $insertSQL -> bindParam(':titre', $_POST['titre']);
                                        $insertSQL -> bindParam(':details', $_POST['details']);
                                        $insertSQL -> bindParam(':valider', $_POST['valider']);

                                        $insertSQL->execute();
                                        $Result1 = $insertSQL->fetch();
                                        $insertGoTo = "contribution.php?OK";

                                        echo "<script>window.location.href='".$insertGoTo."';</script>";

                                      }
                                      elseif(isset($_POST['ajouter'])){


                                          $insertSQL = $connexion->prepare("INSERT INTO `contribution`(`id_contribution`, `id_users`, `titre`, `details`, `valider`) VALUES (:id_contribution, :id_users, :titre, :details, :valider)");


                                          $insertSQL -> bindParam(':id_contribution', $id_contribution);
                                          $insertSQL -> bindParam(':id_users', $_POST['id_users']);
                                          $insertSQL -> bindParam(':titre', $_POST['titre']);
                                          $insertSQL -> bindParam(':details', $_POST['details']);
                                          $insertSQL -> bindParam(':valider', $_POST['valider']);

                                          $insertSQL->execute();
                                          $Result1 = $insertSQL->fetch();
                                          $insertGoTo = "contribution.php?OK";

                                          echo "<script>window.location.href='".$insertGoTo."';</script>";

                                      }


                                       ?>
                                     <a href="contribution.php" class="btn btn-warning">Retour à la liste</a>

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

<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>
