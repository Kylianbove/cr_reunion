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
$query_rs_utiles = $connexion->prepare("SELECT * FROM cr_audio WHERE id_audio=?");
$query_rs_utiles->execute(array($_GET['id']));
$row_rs_utiles = $query_rs_utiles->fetch();
}



$query_rs_content = $connexion->prepare("SELECT * FROM cr_audio ORDER BY id_audio ASC");
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
    exit('Erreur : le r??pertoire cible ne peut-??tre cr???? ! V??rifiez que vous diposiez des droits suffisants pour le faire ou cr??ez le manuellement !');
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
  <?php if($resultat !=null || $moderateur !=null || $contributeur !=null){?>
  <?php require ("session.class.php"); ?>
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
                                      <h2 class="inner-tittle">Zone Audio <a href="cr_audio.php?ajout" class="btn btn-warning"><i class="fa fa-plus"></i> Ajouter</a></h2>

                                      <div class="form-group2" style="width: 20%;">
                                        <label>Pages li??es:</label>
                                        <select id="naviguation" name="naviguation" onchange="document.location.href=this.value">
                                          <option value="0">--</option>

                                          <option value="compte_rendu.php">Page des Comptes Rendus</option>
                                          <?php if($resultat != null || $moderateur != null){ ?>
                                          <option value="cr_categorie.php">Page des Cat??gories</option>
                                          <?php } ?>
                                          <option value="cr_image.php">Page des Images</option>

                                          <option value="cr_piecejointe.php">Page des Pieces Jointes</option>

                                          <option value="cr_video.php">Page des Vid??os</option>

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
                                   <th style="width: 150px;"></th>
                                   <th style="width: 120px">Publier</th>
                                   <th style="width: 150px">Compte Rendu</th>
                                   <th style="width: 120px;">Titre</th>
                                   <th>Extension</th>




                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php do{ ?>


                                  <tr>
                                    <td><a href="cr_audio.php?id=<?php echo $row_rs_content['id_audio']; ?>"style="color: green;"><i class="fa fa-edit"></i>Modif.</a>  |
                                      <a href="cr_audio.php?supprimer=<?php echo $row_rs_content['id_audio']; ?>"style="color: red;"><i class="fa fa-trash-o"></i>Suppr.</a>
                                    </td>


                                    <td>
                                    <?php if($row_rs_content['publier']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Non Publi?? </span><?php } ?>
                                    <?php if($row_rs_content['publier']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Publi?? </span> <?php } ?></td>

                                      <?php
                                      $query_rs_idcompterendu = $connexion->prepare("SELECT * FROM compte_rendu WHERE publier = 1 AND valider = 1 AND id_cr = '".$row_rs_content['id_cr']."'");
                                      $query_rs_idcompterendu->execute();
                                      $row_rs_idcompterendu = $query_rs_idcompterendu->fetch();

                                      if ($row_rs_idcompterendu == null)
                                      { ?>
                                        <td><strong><p style="color:red">!Aucun compte rendu ou compte rendu non publi??/non valid??</p></strong></td>
                                      <?php }else{ ?>

                                      <td><strong><a href="compte_rendu.php?id=<?php echo $row_rs_content['id_cr']; ?>"><?php  echo $row_rs_idcompterendu['titre']; ?></a></strong></td>
                                      <?php } ?>

                                    <td><strong><?php echo $row_rs_content['titre']; ?></strong></td>
                                    <td><strong><?php echo pathinfo($row_rs_content['fichier'], PATHINFO_EXTENSION); ?></strong></td>



                                  </tr>
                                  <?php }while($row_rs_content = $query_rs_content->fetch()); ?>

                                  </tbody>
                                  </table>
                                  <?php } ?>

                                  <?php
                                    if(isset($_GET['supprimer'])){

                                      $req = $connexion->prepare("DELETE FROM cr_audio WHERE id_audio=?");
                                      $req->execute(array($_GET['supprimer']));
                                      $Session12 = new Session();
                                      $Session12->setFlash("Vous venez de supprimer un audio",'error');
                                      $Session12->flash_danger();
                                      $insertGoTo = "cr_audio.php?OK";


                                    echo "<script> setTimeout(function(){location.href='".$insertGoTo."'} , 3000);</script>";



                                  }
                                     ?>
                                  <?php if(isset($_GET['id'])){ ?>
                                   <h3 class="inner-tittle">Modifier un Audio</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="titre">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" value="<?php echo $row_rs_utiles['titre']; ?>" required>
                                    </div>


                                    <div class="form-group">
                                    <label for="fichier">Audio (format autoris??: mp3)</label>
                                    <input type="file" id="fichier" name="fichier" value="<?php echo $row_rs_utiles['fichier']; ?>"></br>
                                    <audio src="./cr_fichiers/audios/<?php echo $row_rs_utiles['fichier']; ?>" controls width='320px' height='200px'>
                                    </div></br>

                                    <div class="form-group">
                                    <label for="id_cr"  style="float:left;width:200px!important;">Compte Rendu</label>
                                    <select id="id_cr" name="id_cr" required>

                                      <?php
                                        $query_rs_cr = $connexion->prepare("SELECT * FROM compte_rendu WHERE publier = 1 AND valider = 1 AND id_cr = '".$row_rs_utiles['id_cr']."'");
                                        $query_rs_cr->execute();
                                        $row_rs_cr = $query_rs_cr->fetch();


                                           if ($row_rs_cr > 0) {
                                          do{

                                      ?>

                                     <option value="<?php echo $row_rs_cr['id_cr']; ?>"><?php echo $row_rs_cr['titre']; ?></option>


                                      <?php

                                    }while($row_rs_cr = $query_rs_cr->fetch());
                                          }

                                       ?>
                                       <?php
                                         $query_rs_cr2 = $connexion->prepare("SELECT * FROM compte_rendu WHERE publier = 1 AND valider = 1 AND id_cr != '".$row_rs_utiles['id_cr']."'");
                                         $query_rs_cr2->execute();
                                         $row_rs_cr2 = $query_rs_cr2->fetch();


                                            if ($row_rs_cr2 > 0) {
                                           do{

                                       ?>

                                      <option value="<?php echo $row_rs_cr2['id_cr']; ?>"><?php echo $row_rs_cr2['titre']; ?></option>


                                       <?php

                                     }while($row_rs_cr2 = $query_rs_cr2->fetch());
                                           }

                                        ?>

                                    </select>
                                  </div>

                                    <div class="form-group">
                                      <label for="publier"  style="float:left;width:200px!important;">Publier Audio</label>
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
                                      <button type="submit" class="btn btn-default" name="modifier" style="background-color: #0bdb00;">Valider les modifications</button>
                                      <?php

                                      if(isset($_POST['modifier']))
                                          {

                                            if( !empty($_FILES['fichier']['name']) )
                                            {

                                            $maxsize = 419430400; // 50Mo

                                            $name = $_POST['id_cr'] ."-". $_FILES['fichier']['name'];
                                            $target_dir = "cr_fichiers/audios/";
                                            $target_file = $target_dir . $name;


                                            // Select file type
                                            $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                                            // Valid file extensions
                                            $extensions_arr = array("mp3");

                                            // Check extension
                                            if( in_array($videoFileType,$extensions_arr) ){

                                              // Check file size
                                              if(($_FILES['fichier']['size'] >= $maxsize || $_FILES["fichier"]["size"] == 0)) {
                                                $Session13 = new Session();
                                                $Session13->setFlash("Votre fichier doit faire moins de 50Mo ",'error');
                                                $Session13->flash_danger();
                                              }else{
                                                // Upload
                                                if(move_uploaded_file($_FILES['fichier']['tmp_name'],$target_file)){
                                                  // Update record

                                                  $updateSQL = $connexion->prepare("UPDATE cr_audio SET id_cr=:id_cr, titre=:titre, fichier=:fichier, publier=:publier WHERE id_audio='".$_GET['id']."'");

                                                  $updateSQL -> bindParam(':id_cr', $_POST['id_cr']);
                                                  $updateSQL -> bindParam(':titre', $_POST['titre']);
                                                  $updateSQL -> bindParam(':fichier', $name);
                                                  $updateSQL -> bindParam(':publier', $_POST['publier']);



                                                  $updateSQL->execute();

                                                  $insertGoTo = "cr_audio.php?OK";

                                                  echo "<script>window.location.href='".$insertGoTo."';</script>";
                                                }
                                              }

                                              }else{
                                                $Session14 = new Session();
                                                $Session14->setFlash("Extension du fichier invalide ",'error');
                                                $Session14->flash_danger();
                                              }

                                              }
                                              else{

                                                  $updateSQL = $connexion->prepare("UPDATE cr_audio SET id_cr=:id_cr, titre=:titre, publier=:publier WHERE id_audio='".$_GET['id']."'");

                                                  $updateSQL -> bindParam(':id_cr', $_POST['id_cr']);
                                                  $updateSQL -> bindParam(':titre', $_POST['titre']);
                                                  $updateSQL -> bindParam(':publier', $_POST['publier']);



                                                  $updateSQL->execute();

                                                  $insertGoTo = "cr_audio.php?OK";

                                                  echo "<script>window.location.href='".$insertGoTo."';</script>";
                                                }

                                      }
                                        ?>
                                        </form>
                                     <a href="cr_audio.php" class="btn btn-warning">Retour ?? la liste</a>

                                      <?php } ?>

                                  <?php if(isset($_GET['ajout'])){ ?>
                                  <h3 class="inner-tittle">Ajouter un Audio</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="titre">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" required>
                                    </div>


                                    <div class="form-group">
                                    <label for="fichier">Audio (format autoris??: mp3)</label>
                                    <input type="file" id="fichier" name="fichier" required>
                                  </div></br>

                                  <div class="form-group">
                                  <label for="id_cr"  style="float:left;width:200px!important;">Compte Rendu</label>
                                  <select id="id_cr" name="id_cr" required>

                                    <?php
                                      $query_rs_compterendu = $connexion->prepare("SELECT * FROM compte_rendu WHERE publier = 1 AND valider = 1 ORDER BY id_cr ASC");
                                      $query_rs_compterendu->execute();
                                      $row_rs_compterendu = $query_rs_compterendu->fetch();


                                         if ($row_rs_compterendu > 0) {
                                        do{

                                    ?>

                                   <option value="<?php echo $row_rs_compterendu['id_cr']; ?>"><?php echo $row_rs_compterendu['titre']; ?></option>


                                    <?php

                                  }while($row_rs_compterendu = $query_rs_compterendu->fetch());
                                        }

                                     ?>

                                  </select>
                                </div></br>

                                    <div class="form-group">
                                      <label for="publier"  style="float:left;width:200px!important;">Publier Audio</label>
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

                                      <button type="submit" class="btn btn-default" name="ajouter" value="ajouter" style="background-color: #0bdb00;"><i class="fa fa-plus"></i> Ajouter</button> </form>
                                      <?php

                                      if(isset($_POST['ajouter'])){
                                        $maxsize = 419430400; // 50Mo

                                        $name = $_POST['id_cr'] ."-". $_FILES['fichier']['name'];
                                        $target_dir = "cr_fichiers/audios/";
                                        $target_file = $target_dir . $name;


                                        // Select file type
                                        $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                                        // Valid file extensions
                                        $extensions_arr = array("mp3");

                                        // Check extension
                                        if( in_array($videoFileType,$extensions_arr) ){

                                          // Check file size
                                          if(($_FILES['fichier']['size'] >= $maxsize || $_FILES["fichier"]["size"] == 0)) {
                                            $Session13 = new Session();
                                            $Session13->setFlash("Votre fichier doit faire moins de 50Mo ",'error');
                                            $Session13->flash_danger();
                                          }else{
                                            // Upload
                                            if(move_uploaded_file($_FILES['fichier']['tmp_name'],$target_file)){
                                              // Insert record

                                              $insertSQL = $connexion->prepare("INSERT INTO `cr_audio`(`id_audio`, `id_cr`, `titre`, `fichier`, `publier`) VALUES (:id_audio, :id_cr, :titre, :fichier, :publier)");


                                              $insertSQL -> bindParam(':id_audio', $id_audio);
                                              $insertSQL -> bindParam(':id_cr', $_POST['id_cr']);
                                              $insertSQL -> bindParam(':titre', $_POST['titre']);
                                              $insertSQL -> bindParam(':fichier', $name);
                                              $insertSQL -> bindParam(':publier', $_POST['publier']);


                                              $insertSQL->execute();
                                              $Result1 = $insertSQL->fetch();
                                              $insertGoTo = "cr_audio.php?OK";

                                              echo "<script>window.location.href='".$insertGoTo."';</script>";
                                            }
                                          }

                                          }else{
                                            $Session14 = new Session();
                                            $Session14->setFlash("Extension du fichier invalide ",'error');
                                            $Session14->flash_danger();
                                          }




                                      }

                                       ?>
                                     <a href="cr_audio.php" class="btn btn-warning">Retour ?? la liste</a>

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
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>

<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>
