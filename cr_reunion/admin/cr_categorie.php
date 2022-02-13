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
$query_rs_utiles = $connexion->prepare("SELECT * FROM cr_categorie WHERE id_cat=?");
$query_rs_utiles->execute(array($_GET['id']));
$row_rs_utiles = $query_rs_utiles->fetch();
}



$query_rs_content = $connexion->prepare("SELECT * FROM cr_categorie ORDER BY id_cat ASC");
$query_rs_content->execute();
$row_rs_content = $query_rs_content->fetch();

/*
$tg = $row_rs_content['illu'];
*/

// Constantes
define('TARGET', 'uploads/slides/');    // Repertoire cible
define('MAX_SIZE', 800000);    // Taille max en octets du fichier
define('WIDTH_MAX', 2000);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 2000);    // Hauteur max de l'image en pixels

// Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
$infosImg = array();

// Variables
$extension = '';
$message = '';
$nomImage = '';

/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/

if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}

//fin de transfert de donnée
if(isset($t1)){
if($t1==''){	$t1=$tg;}
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {// On verifie si le champ est rempli
  if( !empty($_FILES['fichier']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);

    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt))
    {
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);

      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
      {
        // On verifie les dimensions et taille de l'image
        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
        {
          // Parcours du tableau d'erreurs
          if(isset($_FILES['fichier']['error'])
            && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
          {
            // On renomme le fichier
            $nomImage = md5(uniqid()) .'.'. $extension;

            // Si c'est OK, on teste l'upload
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
            {
              $message = 'Upload réussi !';
            }
            else
            {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          }
          else
          {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $message = 'Erreur dans les dimensions de l\'image !';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  }
  else
  {
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
  }

$t1 = $nomImage;
if(isset($t1)&&(isset($tg))){
if($t1=='') { $t1 = $tg; }
}
/*
$date1 = str_replace('/', "-", $_POST['dateDebut']);
$date2 = str_replace('/', "-", $_POST['dateFin']);
*/


}

if ((isset($_POST["MM_update2"])) && ($_POST["MM_update2"] == "form1")) {// On verifie si le champ est

  if( !empty($_FILES['fichier']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);

    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt))
    {
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);

      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
      {
        // On verifie les dimensions et taille de l'image
        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
        {
          // Parcours du tableau d'erreurs
          if(isset($_FILES['fichier']['error'])
            && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
          {
            // On renomme le fichier
            $nomImage = md5(uniqid()) .'.'. $extension;

            // Si c'est OK, on teste l'upload
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
            {
              $message = 'Upload réussi !';
            }
            else
            {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          }
          else
          {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $message = 'Erreur dans les dimensions de l\'image !';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  }
  else
  {
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
  }

$t1 = $nomImage;
if(isset($t1)&&(isset($tg))){
if($t1=='') { $t1 = $tg; }
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
                                      <h2 class="inner-tittle">Zone Catégories <a href="cr_categorie.php?ajout" class="btn btn-warning">Ajouter</a></h2>

                                      <div class="form-group2" style="width: 20%;">
                                        <label>Pages liées aux catégories:</label>
                                        <select id="naviguation" name="naviguation" onchange="document.location.href=this.value">
                                          <option value="0">--</option>

                                          <option value="compte_rendu.php">Page des Comptes Rendus</option>

                                          <option value="cr_image.php">Page des Images</option>

                                          <option value="cr_piecejointe.php">Page des Pieces Jointes</option>

                                          <option value="cr_audio.php">Page des Audios</option>

                                          <option value="cr_video.php">Page des Vidéos</option>

                                        </select>
                                      </div></br></br>

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
                                   <th style="width: 120px;"></th>
                                    <th style="width: 120px">Publier</th>
                                    <th>Titre</th>




                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php do{ ?>


                                  <tr>
                                    <td><a href="cr_categorie.php?id=<?php echo $row_rs_content['id_cat']; ?>">Modif.</a>  |
                                      <a href="cr_categorie.php?supprimer=<?php echo $row_rs_content['id_cat']; ?>">Suppr.</a>
                                    </td>


                                    <td>
                                    <?php if($row_rs_content['publier']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Non Publié </span><?php } ?>
                                    <?php if($row_rs_content['publier']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Publié </span> <?php } ?></td>

                                    <td><strong><?php echo $row_rs_content['titre']; ?></strong></td>



                                  </tr>
                                  <?php }while($row_rs_content = $query_rs_content->fetch()); ?>

                                  </tbody>
                                  </table>
                                  <?php } ?>

                                  <?php
                                    if(isset($_GET['supprimer'])){

                                      $req = $connexion->prepare("DELETE FROM cr_categorie WHERE id_cat=?");
                                      $req->execute(array($_GET['supprimer']));
                                      $Session12 = new Session();
                                      $Session12->setFlash("Vous venez de supprimer une catégorie",'error');
                                      $Session12->flash_danger();
                                      $insertGoTo = "cr_categorie.php?OK";


                                    echo "<script> setTimeout(function(){location.href='".$insertGoTo."'} , 3000);</script>";



                                  }
                                     ?>
                                  <?php if(isset($_GET['id'])){ ?>
                                   <h3 class="inner-tittle">Modifier une Catégorie</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="titre">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" value="<?php echo $row_rs_utiles['titre']; ?>" required>
                                    </div>



                                  <div class="form-group">
                                    <label for="publier"  style="float:left;width:200px!important;">Publier Catégorie</label>
                                    <select id="publier" name="publier" required>
                                      <option value="">--</option>

                                      <option value="0" <?php if($row_rs_utiles['publier']=="0"){ ?>selected<?php } ?>>Non</option>

                                      <option value="1" <?php if($row_rs_utiles['publier']=="1"){ ?>selected<?php } ?>>OUI</option>

                                    </select>
                                  </div>



                                    </div>
                                    <div class="col-md-6">


                                     </div>
                                     <div class="clearfix"></div>
                                     <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                     <input type="hidden" name="MM_update" value="form1" />
                                      <button type="submit" class="btn btn-default" name="modifier">Valider les modifications</button>
                                      <?php

                                      if(isset($_POST['modifier']))
                                          {



                                                  $updateSQL = $connexion->prepare("UPDATE cr_categorie SET titre=:titre, publier=:publier WHERE id_cat='".$_GET['id']."'");

                                                  $updateSQL -> bindParam(':titre', $_POST['titre']);
                                                  $updateSQL -> bindParam(':publier', $_POST['publier']);


                                                  $updateSQL->execute();

                                                  $insertGoTo = "cr_categorie.php?OK";

                                                  echo "<script>window.location.href='".$insertGoTo."';</script>";

                                      }
                                        ?>
                                        </form>
                                     <a href="cr_categorie.php" class="btn btn-warning">Retour à la liste</a>

                                      <?php } ?>

                                  <?php if(isset($_GET['ajout'])){ ?>
                                  <h3 class="inner-tittle">Ajouter une Catégorie</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="titre">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" required>
                                    </div>



                                    <div class="form-group">
                                      <label for="publier"  style="float:left;width:200px!important;">Publier Catégorie</label>
                                      <select id="publier" name="publier" required>
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

                                      <button type="submit" class="btn btn-default" name="ajouter">Ajouter</button> </form>
                                      <?php
                                      if(isset($_POST['ajouter'])){


                                                        $insertSQL = $connexion->prepare("INSERT INTO `cr_categorie`(`id_cat`, `titre`, `publier`) VALUES (:id_cat, :titre, :publier)");


                                                        $insertSQL -> bindParam(':id_cat', $id_cat);
                                                        $insertSQL -> bindParam(':titre', $_POST['titre']);
                                                        $insertSQL -> bindParam(':publier', $_POST['publier']);

                                                        $insertSQL->execute();
                                                        $Result1 = $insertSQL->fetch();
                                                        $insertGoTo = "cr_categorie.php?OK";

                                                        echo "<script>window.location.href='".$insertGoTo."';</script>";

                                      }

                                       ?>
                                     <a href="cr_categorie.php" class="btn btn-warning">Retour à la liste</a>

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
          header('Location: acceserreur.php');
      } ?>
<!--js -->
<link rel="stylesheet" href="css/vroom.css">
<script type="text/javascript" src="js/vroom.js"></script>
<script type="text/javascript" src="js/TweenLite.min.js"></script>
<script type="text/javascript" src="js/CSSPlugin.min.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>

<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>
