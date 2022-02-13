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
$query_rs_utiles = $connexion->prepare("SELECT * FROM users WHERE id=?");
$query_rs_utiles->execute(array($_GET['id']));
$row_rs_utiles = $query_rs_utiles->fetch();
}

require ("session.class.php");

$query_rs_content = $connexion->prepare("SELECT * FROM users ORDER BY id DESC");
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
<script src="js/jscolor.js"></script>
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
    <?php if($resultat !=null){?>
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
                                      <h2 class="inner-tittle">Zone Utilisateur <a href="users.php?ajout" class="btn btn-warning">Ajouter</a></h2>

                                      <form method="post" action="" enctype="multipart/form-data">
                                      <div class="form-group2">
                                      <label>trier par état:</label>
                                      <select id="actif" name="actif">
                                        <option value="0">Tout afficher</option>

                                        <option value="1">Afficher utilisateurs actifs</option>

                                        <option value="2">Afficher utilisateurs inactifs</option>

                                      </select>

                                      <label>trier par nom:</label>
                                      <select id="nom" name="nom">
                                        <option value="0">Nom de A à Z</option>

                                        <option value="1">Nom de Z à A</option>

                                      </select>

                                      <label>trier par type d'utilisateur:</label>
                                      <select id="typeU" name="typeU">
                                        <option value="0">Tous</option>

                                        <option value="1">Utilisateur 1</option>

                                        <option value="2">Utilisateur 2</option>

                                        <option value="3">Utilisateur 3</option>

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
                                   <th style="width: 120px;"></th>
                                    <th>Initial</th>
                                    <th>Actif</th>
                                    <th>Type d'utilisateur</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Téléphone</th>
                                    <th>mail</th>
                                    <th>Adresse</th>
                                    <th>Pays</th>




                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    if(isset($_POST['filtrer']))
                                    {
                                      if($_POST['actif'] == 0)
                                      {
                                        $actif = "(actif = 1 OR actif = 0)";

                                      }
                                      if($_POST['actif'] == 1)
                                      {
                                        $actif = "actif = 1";

                                      }
                                      if($_POST['actif'] == 2)
                                      {
                                        $actif = "actif = 0";

                                      }
                                      if($_POST['typeU'] == 0)
                                      {
                                        $typeU = $actif;

                                      }
                                      if($_POST['typeU'] == 1)
                                      {
                                        $typeU = "typeUser = 1";

                                      }
                                      if($_POST['typeU'] == 2)
                                      {
                                        $typeU = "typeUser = 2";

                                      }
                                      if($_POST['typeU'] == 3)
                                      {
                                        $typeU = "typeUser = 3";

                                      }
                                      if($_POST['nom'] == 0)
                                      {
                                        $nom = "ORDER BY nom ASC";

                                      }
                                      if($_POST['nom'] == 1)
                                      {
                                        $nom = "ORDER BY nom DESC";

                                      }

                                      $query_rs_content2 = $connexion->prepare("SELECT * FROM users WHERE $actif AND $typeU $nom");
                                      $query_rs_content2->execute();
                                      $row_rs_content2 = $query_rs_content2->fetch();

                                      if($row_rs_content2 == null){
                                        $Session15 = new Session();
                                        $Session15->setFlash("Aucune actualité correspond à votre recherche",'error');
                                        $Session15->flash_danger();
                                      }
                                      do{ ?>

                                        <tr>
                                          <td><a href="users.php?id=<?php echo $row_rs_content2['id']; ?>">Modif.</a>  |
                                            <a href="users.php?supprimer=<?php echo $row_rs_content2['id']; ?>">Suppr.</a>
                                          </td>
                                          <style>
                                          .cercle{
                                            border: 1px solid black;
                                            border-radius: 50px;
                                            width: 30px;
                                            height: 30px;
                                            text-align:center;
                                            line-height: 30px;
                                            color: white;
                                            background-color: black;


                                          }
                                          </style>
                                          <?php
                                          $usersphoto = $connexion->prepare("SELECT * FROM users WHERE photo = '".$row_rs_content2['photo']."'");
                                          $usersphoto->execute();
                                          $photoprofil = $usersphoto->fetch();

                                          if($photoprofil == null){
                                          ?>
                                            <td><strong><div class="cercle" style="background-color:<?php echo $row_rs_content2['couleur']; ?>"><?php echo $row_rs_content2['prenom'][0];?><?php echo " ".$row_rs_content2['nom'][0]; ?>  </div></strong></td>
                                        <?php
                                          }else
                                          { ?>
                                            <td><strong><img src="./photo/<?php echo $row_rs_content2['photo']; ?>" class="cercle"></strong></td>
                                        <?php } ?>

                                          <td><strong><?php echo $row_rs_content2['prenom'][0];?><?php echo " ".$row_rs_content2['nom'][0]; ?></strong></td>
                                          <td>
                                          <?php if($row_rs_content2['actif']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Non Actif </span><?php } ?>
                                          <?php if($row_rs_content2['actif']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Actif </span> <?php } ?></td>
                                          <td><strong><?php echo $row_rs_content2['typeUser']; ?></strong></td>
                                          <td><strong><?php echo $row_rs_content2['nom']; ?></strong></td>
                                          <td><strong><?php echo $row_rs_content2['prenom']; ?></strong></td>
                                          <td><strong><?php echo $row_rs_content2['tel']; ?></strong></td>
                                          <td><strong><?php echo $row_rs_content2['email']; ?></strong></td>
                                          <td><strong><?php echo $row_rs_content2['adresse']; ?><?php echo " ".$row_rs_content2['cp']; ?><?php echo " ".$row_rs_content2['ville']; ?></strong></td>
                                          <td><strong><?php echo $row_rs_content2['pays']; ?></strong></td>


                                        </tr>
                                      <?php }while($row_rs_content2 = $query_rs_content2->fetch()); ?>



                                  <?php
                                }else
                                    {
                                      do{ ?>


                                  <tr>
                                    <td><a href="users.php?id=<?php echo $row_rs_content['id']; ?>">Modif.</a>  |
                                      <a href="users.php?supprimer=<?php echo $row_rs_content['id']; ?>">Suppr.</a>
                                    </td>
                                    <style>
                                    .cercle{
                                      border: 1px solid black;
                                      border-radius: 50px;
                                      width: 30px;
                                      height: 30px;
                                      text-align:center;
                                      line-height: 30px;
                                      color: white;
                                      background-color: black;


                                    }
                                    </style>
                                    <?php
                                    $usersphoto = $connexion->prepare("SELECT * FROM users WHERE photo = '".$row_rs_content['photo']."'");
                                    $usersphoto->execute();
                                    $photoprofil = $usersphoto->fetch();

                                    if($photoprofil == null){
                                    ?>
                                      <td><strong><div class="cercle" style="background-color:<?php echo $row_rs_content['couleur']; ?>"><?php echo $row_rs_content['prenom'][0];?><?php echo " ".$row_rs_content['nom'][0]; ?>  </div></strong></td>
                                  <?php
                                    }else
                                    { ?>
                                      <td><strong><img src="./photo/<?php echo $row_rs_content['photo']; ?>" class="cercle"></strong></td>
                                  <?php } ?>

                                    <td>
                                    <?php if($row_rs_content['actif']==0){ ?><span style="display:block; width; 150px;"><i class="fa fa-times-circle" style="color: red"></i> Non Actif </span><?php } ?>
                                    <?php if($row_rs_content['actif']==1){ ?><span style="display:block; width; 150px;"><i class="fa fa-check-circle" style="color: green"></i> Actif </span> <?php } ?></td>
                                    <td><strong><?php echo $row_rs_content['typeUser']; ?></strong></td>
                                    <td><strong><?php echo $row_rs_content['nom']; ?></strong></td>
                                    <td><strong><?php echo $row_rs_content['prenom']; ?></strong></td>
                                    <td><strong><?php echo $row_rs_content['tel']; ?></strong></td>
                                    <td><strong><?php echo $row_rs_content['email']; ?></strong></td>
                                    <td><strong><?php echo $row_rs_content['adresse']; ?><?php echo " ".$row_rs_content['cp']; ?><?php echo " ".$row_rs_content['ville']; ?></strong></td>
                                    <td><strong><?php echo $row_rs_content['pays']; ?></strong></td>


                                  </tr>
                                <?php }while($row_rs_content = $query_rs_content->fetch()); }?>

                                  </tbody>
                                  </table>
                                  <?php } ?>

                                  <?php
                                    if(isset($_GET['supprimer'])){

                                      $req = $connexion->prepare("DELETE FROM users WHERE id=?");
                                      $req->execute(array($_GET['supprimer']));
                                      $Session12 = new Session();
                                      $Session12->setFlash("Vous venez de supprimer un utlisateur",'error');
                                      $Session12->flash_danger();
                                      $insertGoTo = "users.php?OK";


                                    echo "<script> setTimeout(function(){location.href='".$insertGoTo."'} , 3000);</script>";



                                  }
                                     ?>
                                  <?php if(isset($_GET['id'])){ ?>
                                   <h3 class="inner-tittle">Modifier un compte Utilisateur</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php echo $row_rs_utiles['nom']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" value="<?php echo $row_rs_utiles['prenom']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="tel">Tel</label>
                                    <input type="tel" class="form-control" id="tel" name="tel" placeholder="Tel" value="<?php echo $row_rs_utiles['tel']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row_rs_utiles['email']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" value="<?php echo $row_rs_utiles['passwords']; ?>" required>
                                    </div>
                                    <!--
                                    <div class="form-group">
                                    <label for="typeUser">Type Utilisateur</label>
                                    <input type="hidden" class="form-control" id="tupeUser" name="typeUser" placeholder="nom" value="1" required> Administrateur
                                    </div>
                                  -->


                                    </div>
                                    <div class="col-md-6">

                                      <div class="form-group">
                                      <label for="adresse">Adresse</label>
                                      <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse" value="<?php echo $row_rs_utiles['adresse']; ?>" required>
                                      </div>

                                      <div class="form-group">
                                      <label for="cp">Code postal</label>
                                      <input type="text" class="form-control" id="cp" name="cp" placeholder="Code postal" value="<?php echo $row_rs_utiles['cp']; ?>" required>
                                      </div>

                                      <div class="form-group">
                                      <label for="ville">Ville</label>
                                      <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville" value="<?php echo $row_rs_utiles['ville']; ?>" required>
                                      </div>

                                      <div class="form-group">
                                      <label for="pays">Pays</label>
                                      <select id="pays" name="pays" required>

                                        <?php
                                          $query_rs_pays = $connexion->prepare("SELECT * FROM pays WHERE nom = '".$row_rs_utiles['pays']."'");
                                          $query_rs_pays->execute();
                                          $row_rs_pays = $query_rs_pays->fetch();


                                             if ($row_rs_pays > 0) {
                                            do{

                                        ?>

                                       <option value="<?php echo $row_rs_pays['id']; ?>"><?php echo $row_rs_pays['nom']; ?></option>


                                        <?php

                                      }while($row_rs_pays = $query_rs_pays->fetch());
                                            }

                                         ?>
                                         <?php
                                           $query_rs_pays2 = $connexion->prepare("SELECT * FROM pays WHERE nom != '".$row_rs_utiles['pays']."'");
                                           $query_rs_pays2->execute();
                                           $row_rs_pays2 = $query_rs_pays2->fetch();


                                              if ($row_rs_pays2 > 0) {
                                             do{

                                         ?>

                                        <option value="<?php echo $row_rs_pays2['id']; ?>"><?php echo $row_rs_pays2['nom']; ?></option>


                                         <?php

                                       }while($row_rs_pays2 = $query_rs_pays2->fetch());
                                             }

                                          ?>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="fichier">Photo profil</label>
                                      <input type="file" id="fichier" name="fichier" value="<?php echo $row_rs_utiles['photo'] ?>"></br>
                                      <?php if($row_rs_utiles['photo'] != null){ ?>
                                      <img src="./photo/<?php echo $row_rs_utiles['photo']; ?>" controls width='320px' height='200px' >
                                    <?php } ?>
                                      </div></br>

                                      <div class="form-group">
                                      <label for="couleur">Couleur</label>
                                      <?php if($row_rs_utiles['couleur'] != null){ ?>

                                          <input type="text" class="form-control" id="couleur" name="couleur" value="<?php echo $row_rs_utiles['couleur']; ?>" data-jscolor="{preset:'small dark', position:'right'}" required>

                                       <?php }else{ ?>
                                        <input type="text" class="form-control" id="couleur" name="couleur" value="#000000" data-jscolor="{preset:'small dark', position:'right'}" required>
                                        <?php } ?>
                                      </div>

                                      <div class="form-group">
                                      <label for="typeUser" style="float:left;width:200px!important;">Type d'utilisateur</label>
                                      <select id="typeUser" name="typeUser" required>
                                        <option value="">--</option>

                                        <option value="1" <?php if($row_rs_utiles['typeUser']=="1"){ ?>selected<?php } ?>>1</option>

                                        <option value="2" <?php if($row_rs_utiles['typeUser']=="2"){ ?>selected<?php } ?>>2</option>

                                        <option value="3" <?php if($row_rs_utiles['typeUser']=="3"){ ?>selected<?php } ?>>3</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                        <label for="actif"  style="float:left;width:200px!important;">Utilisateur Actif</label>
                                        <select id="actif" name="actif" required>
                                          <option value="">--</option>

                                          <option value="0" <?php if($row_rs_utiles['actif']=="0"){ ?>selected<?php } ?>>Non</option>

                                          <option value="1" <?php if($row_rs_utiles['actif']=="1"){ ?>selected<?php } ?>>OUI</option>

                                        </select>
                                      </div>

                                     </div>
                                     <div class="clearfix"></div>
                                     <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                     <input type="hidden" name="MM_update" value="form1" />
                                      <button type="submit" class="btn btn-default" name="modifier">Valider les modifications</button>
                                      <?php

                                      if(isset($_POST['modifier']))
                                          {
                                            $idpays = $connexion->prepare("SELECT nom FROM pays WHERE id = '".$_POST['pays']."'");
                                            $idpays->execute();
                                            $pays = $idpays->fetch();


                                      /*regex mot de passe */
                                      $uppercase = preg_match('@[A-Z]@', $_POST['password']);
                                      $lowercase = preg_match('@[a-z]@', $_POST['password']);
                                      $number = preg_match('@[0-9]@', $_POST['password']);
                                      $symbol = preg_match('@[\W]@', $_POST['password']);



                                        if($uppercase){
                                          if($lowercase){
                                            if($number){
                                              if($symbol){
                                                if(strlen($_POST['password']) > 8){
                                                  if($row_rs_utiles['photo'] != null){
                                                    if($_POST['couleur'] != $row_rs_utiles['couleur']){
                                                      $updatephoto = $connexion->prepare("UPDATE users SET photo = null WHERE id='".$_GET['id']."'");
                                                      $updatephoto->execute();
                                                    }
                                                  }
                                                  if( !empty($_FILES['fichier']['name']) )
                                                  {
                                                    $maxsize = 41943040; // 5Mo

                                                    $name = $_FILES['fichier']['name'];
                                                    $target_dir = "photo/";
                                                    $target_file = $target_dir . $name;


                                                    // Select file type
                                                    $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                                                    // Valid file extensions
                                                    $extensions_arr = array("jpg","png","jpeg");

                                                    // Check extension
                                                    if( in_array($videoFileType,$extensions_arr) ){

                                                      // Check file size
                                                      if(($_FILES['fichier']['size'] >= $maxsize || $_FILES["fichier"]["size"] == 0)) {
                                                        $Session13 = new Session();
                                                        $Session13->setFlash("Votre fichier doit faire moins de 5Mo ",'error');
                                                        $Session13->flash_danger();

                                                      }else{
                                                        // Upload
                                                        if(move_uploaded_file($_FILES['fichier']['tmp_name'],$target_file)){
                                                          $updateSQL = $connexion->prepare("UPDATE users SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, adresse=:adresse, cp=:cp, ville=:ville, pays=:pays, typeUser=:typeUser, photo=:photo, actif=:actif WHERE id='".$_GET['id']."'");
                                                          if($_POST['password'] != $row_rs_utiles['passwords']){
                                                          $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                                          }else{
                                                            $pass_hash = $_POST['password'];
                                                          }
                                                          $updateSQL -> bindParam(':nom', $_POST['nom']);
                                                          $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                                          $updateSQL -> bindParam(':tel', $_POST['tel']);
                                                          $updateSQL -> bindParam(':email', $_POST['email']);
                                                          $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                                          $updateSQL -> bindParam(':adresse', $_POST['adresse']);
                                                          $updateSQL -> bindParam(':cp', $_POST['cp']);
                                                          $updateSQL -> bindParam(':ville', $_POST['ville']);
                                                          $updateSQL -> bindParam(':pays', $pays['nom']);
                                                          $updateSQL -> bindParam(':typeUser', $_POST['typeUser']);
                                                          $updateSQL -> bindParam(':photo', $name);
                                                          $updateSQL -> bindParam(':actif', $_POST['actif']);


                                                          $updateSQL->execute();

                                                          $insertGoTo = "users.php?OK";

                                                          echo "<script>window.location.href='".$insertGoTo."';</script>";
                                                        }
                                                      }

                                                      }else{
                                                        $Session14 = new Session();
                                                        $Session14->setFlash("Extension du fichier invalide ",'error');
                                                        $Session14->flash_danger();
                                                      }
                                                    }else{
                                                      $updateSQL = $connexion->prepare("UPDATE users SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, adresse=:adresse, cp=:cp, ville=:ville, pays=:pays, typeUser=:typeUser, actif=:actif, couleur=:couleur WHERE id='".$_GET['id']."'");
                                                      if($_POST['password'] != $row_rs_utiles['passwords']){
                                                      $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                                      }else{
                                                        $pass_hash = $_POST['password'];
                                                      }
                                                      $updateSQL -> bindParam(':nom', $_POST['nom']);
                                                      $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                                      $updateSQL -> bindParam(':tel', $_POST['tel']);
                                                      $updateSQL -> bindParam(':email', $_POST['email']);
                                                      $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                                      $updateSQL -> bindParam(':adresse', $_POST['adresse']);
                                                      $updateSQL -> bindParam(':cp', $_POST['cp']);
                                                      $updateSQL -> bindParam(':ville', $_POST['ville']);
                                                      $updateSQL -> bindParam(':pays', $pays['nom']);
                                                      $updateSQL -> bindParam(':typeUser', $_POST['typeUser']);
                                                      $updateSQL -> bindParam(':actif', $_POST['actif']);
                                                      $updateSQL -> bindParam(':couleur', $_POST['couleur']);


                                                      $updateSQL->execute();

                                                      $insertGoTo = "users.php?OK";

                                                      echo "<script>window.location.href='".$insertGoTo."';</script>";

                                                    }
                                                }else
                                                  {
                                                    $Session8 = new Session();
                                                    $Session8->setFlash('Le mot de passe doit contenir au moins 8 caractères','error');
                                                    $Session8->flash_danger();
                                                  }
                                              }else
                                              {
                                                $Session7 = new Session();
                                                $Session7->setFlash('Le mot de passe doit contenir au moins 1 symbole','error');
                                                $Session7->flash_danger();
                                              }
                                            }else
                                            {
                                            $Session6 = new Session();
                                            $Session6->setFlash('Le mot de passe doit contenir au moins 1 chiffre','error');
                                            $Session6->flash_danger();
                                            }
                                          }else
                                          {
                                          $Session5 = new Session();
                                          $Session5->setFlash('Le mot de passe doit contenir au moins 1 minuscule','error');
                                          $Session5->flash_danger();
                                          }
                                        }else
                                        {
                                        $Session4 = new Session();
                                        $Session4->setFlash('Le mot de passe doit contenir au moins 1 majuscule','error');
                                        $Session4->flash_danger();
                                        }
                                      }
                                        ?>
                                        </form>
                                     <a href="users.php" class="btn btn-warning">Retour à la liste</a>

                                  <?php } ?>

                                  <?php if(isset($_GET['ajout'])){ ?>
                                  <h3 class="inner-tittle">Ajouter un utilisateur</h3>
                                    <div class="graph-form">

                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="tel">Tel</label>
                                    <input type="tel" class="form-control" id="tel" name="tel" placeholder="Tel" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                                    </div>
                                    <!--
                                    <div class="form-group">
                                    <label for="typeUser">Type Utilisateur</label>
                                    <input type="hidden" class="form-control" id="tupeUser" name="typeUser" placeholder="nom" value="1" required> Administrateur
                                    </div>
                                  -->


                                    </div>
                                    <div class="col-md-6">

                                      <div class="form-group">
                                      <label for="adresse">Adresse</label>
                                      <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse" required>
                                      </div>

                                      <div class="form-group">
                                      <label for="cp">Code postal</label>
                                      <input type="text" class="form-control" id="cp" name="cp" placeholder="Code postal" required>
                                      </div>

                                      <div class="form-group">
                                      <label for="ville">Ville</label>
                                      <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville" required>
                                      </div>

                                      <div class="form-group">
                                      <label for="pays">Pays</label>
                                      <select id="pays" name="pays" required>

                                        <?php
                                          $query_rs_pays = $connexion->prepare("SELECT * FROM pays ORDER BY id ASC");
                                          $query_rs_pays->execute();
                                          $row_rs_pays = $query_rs_pays->fetch();


                                             if ($row_rs_pays > 0) {
                                            do{

                                        ?>

                                       <option value="<?php echo $row_rs_pays['id']; ?>"><?php echo $row_rs_pays['nom']; ?></option>


                                        <?php

                                      }while($row_rs_pays = $query_rs_pays->fetch());
                                            }

                                         ?>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                      <label for="fichier">Photo profil</label>
                                      <input type="file" id="fichier" name="fichier">
                                      </div></br>

                                      <div class="form-group">
                                      <label for="couleur">Couleur Profil</label>

                                      <input type="text" class="form-control" id="couleur" name="couleur" value="#FFFFFF" data-jscolor="{preset:'small dark', position:'right'}" required>


                                      </div>

                                      <div class="form-group">
                                      <label for="typeUser">Type d'utilisateur</label>
                                      <select id="typeUser" name="typeUser" required>

                                        <option value="">--</option>

                                        <option value="1" >1</option>

                                        <option value="2" >2</option>

                                        <option value="3" >3</option>

                                      </select>
                                      </div>

                                      <div class="form-group">
                                        <label for="actif"  style="float:left;width:200px!important;">Utilisateur Actif</label>
                                        <select id="actif" name="actif" required>
                                          <option value="">--</option>

                                          <option value="0" >Non</option>

                                          <option value="1" >OUI</option>

                                        </select>
                                      </div>

                                     </div>

                                     <div class="clearfix"></div>
                                     <input type="hidden" name="id" value="" />
                                     <input type="hidden" name="MM_update2" value="form1" />

                                      <button type="submit" class="btn btn-default" name="ajouter">Ajouter</button> </form>
                                      <?php
                                      if(isset($_POST['ajouter']))
                                          {
                                            $idpays = $connexion->prepare("SELECT nom FROM pays WHERE id = '".$_POST['pays']."'");
                                            $idpays->execute();
                                            $pays = $idpays->fetch();
                                      /*email unique */
                                      $req = $connexion->prepare("SELECT * FROM adminusers WHERE email=?");
                                      $req->execute(array($_POST['email']));
                                      $resultat = $req->fetch();

                                      $req2 = $connexion->prepare("SELECT * FROM moderateur WHERE email=?");
                                      $req2->execute(array($_POST['email']));
                                      $resultat2 = $req2->fetch();

                                      $req3 = $connexion->prepare("SELECT * FROM contributeur WHERE email=?");
                                      $req3->execute(array($_POST['email']));
                                      $resultat3 = $req3->fetch();

                                      $req4 = $connexion->prepare("SELECT * FROM users WHERE email=?");
                                      $req4->execute(array($_POST['email']));
                                      $resultat4 = $req4->fetch();

                                      /*regex mot de passe */
                                      $uppercase = preg_match('@[A-Z]@', $_POST['password']);
                                      $lowercase = preg_match('@[a-z]@', $_POST['password']);
                                      $number = preg_match('@[0-9]@', $_POST['password']);
                                      $symbol = preg_match('@[\W]@', $_POST['password']);


                                      if($resultat == null ){
                                        if($resultat2 == null ){
                                          if($resultat3 == null ){
                                            if($resultat4 == null ){
                                              if($uppercase){
                                                if($lowercase){
                                                  if($number){
                                                    if($symbol){
                                                      if(strlen($_POST['password']) > 8){

                                                        if( !empty($_FILES['fichier']['name']) )
                                                        {
                                                        $maxsize = 41943040; // 5Mo

                                                        $name = $_FILES['fichier']['name'];
                                                        $target_dir = "photo/";
                                                        $target_file = $target_dir . $name;


                                                        // Select file type
                                                        $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                                                        // Valid file extensions
                                                        $extensions_arr = array("jpg","png","jpeg");

                                                        // Check extension
                                                        if( in_array($videoFileType,$extensions_arr) ){

                                                          // Check file size
                                                          if(($_FILES['fichier']['size'] >= $maxsize || $_FILES["fichier"]["size"] == 0)) {
                                                            $Session13 = new Session();
                                                            $Session13->setFlash("Votre fichier doit faire moins de 5Mo ",'error');
                                                            $Session13->flash_danger();

                                                          }else{
                                                            // Upload
                                                            if(move_uploaded_file($_FILES['fichier']['tmp_name'],$target_file)){

                                                              $insertSQL = $connexion->prepare("INSERT INTO `users`(`id`, `nom`, `prenom`, `tel`, `email`, `passwords`, `adresse`, `cp`, `ville`, `pays`, `typeUser`,`photo`, `actif`) VALUES (:id, :nom, :prenom, :tel, :email, :pass_hash, :adresse, :cp, :ville, :pays, :typeUser, :photo, :actif)");

                                                              $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp

                                                              $insertSQL -> bindParam(':id', $id);
                                                              $insertSQL -> bindParam(':nom', $_POST['nom']);
                                                              $insertSQL -> bindParam(':prenom', $_POST['prenom']);
                                                              $insertSQL -> bindParam(':tel', $_POST['tel']);
                                                              $insertSQL -> bindParam(':email', $_POST['email']);
                                                              $insertSQL -> bindParam(':pass_hash', $pass_hash);
                                                              $insertSQL -> bindParam(':adresse', $_POST['adresse']);
                                                              $insertSQL -> bindParam(':cp', $_POST['cp']);
                                                              $insertSQL -> bindParam(':ville', $_POST['ville']);
                                                              $insertSQL -> bindParam(':pays', $pays['nom']);
                                                              $insertSQL -> bindParam(':typeUser', $_POST['typeUser']);
                                                              $insertSQL -> bindParam(':photo', $name);
                                                              $insertSQL -> bindParam(':actif', $_POST['actif']);

                                                              $insertSQL->execute();
                                                              $Result1 = $insertSQL->fetch();
                                                              $insertGoTo = "users.php?OK";

                                                              echo "<script>window.location.href='".$insertGoTo."';</script>";
                                                            }
                                                          }

                                                          }else{
                                                            $Session14 = new Session();
                                                            $Session14->setFlash("Extension du fichier invalide ",'error');
                                                            $Session14->flash_danger();
                                                          }
                                                        }else{
                                                          $insertSQL = $connexion->prepare("INSERT INTO `users`(`id`, `nom`, `prenom`, `tel`, `email`, `passwords`, `adresse`, `cp`, `ville`, `pays`, `typeUser`, `actif`, `couleur`) VALUES (:id, :nom, :prenom, :tel, :email, :pass_hash, :adresse, :cp, :ville, :pays, :typeUser, :actif, :couleur)");

                                                          $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp

                                                          $insertSQL -> bindParam(':id', $id);
                                                          $insertSQL -> bindParam(':nom', $_POST['nom']);
                                                          $insertSQL -> bindParam(':prenom', $_POST['prenom']);
                                                          $insertSQL -> bindParam(':tel', $_POST['tel']);
                                                          $insertSQL -> bindParam(':email', $_POST['email']);
                                                          $insertSQL -> bindParam(':pass_hash', $pass_hash);
                                                          $insertSQL -> bindParam(':adresse', $_POST['adresse']);
                                                          $insertSQL -> bindParam(':cp', $_POST['cp']);
                                                          $insertSQL -> bindParam(':ville', $_POST['ville']);
                                                          $insertSQL -> bindParam(':pays', $pays['nom']);
                                                          $insertSQL -> bindParam(':typeUser', $_POST['typeUser']);
                                                          $insertSQL -> bindParam(':actif', $_POST['actif']);
                                                          $insertSQL -> bindParam(':couleur', $_POST['couleur']);

                                                          $insertSQL->execute();
                                                          $Result1 = $insertSQL->fetch();
                                                          $insertGoTo = "users.php?OK";

                                                          echo "<script>window.location.href='".$insertGoTo."';</script>";

                                                        }
                                                      }else
                                                      {
                                                        $Session8 = new Session();
                                                        $Session8->setFlash('Le mot de passe doit contenir au moins 8 caractères','error');
                                                        $Session8->flash_danger();
                                                      }
                                                    }else
                                                    {
                                                      $Session7 = new Session();
                                                      $Session7->setFlash('Le mot de passe doit contenir au moins 1 symbole','error');
                                                      $Session7->flash_danger();
                                                    }
                                                  }else
                                                  {
                                                    $Session6 = new Session();
                                                    $Session6->setFlash('Le mot de passe doit contenir au moins 1 chiffre','error');
                                                    $Session6->flash_danger();
                                                  }
                                                }else
                                                {
                                                  $Session5 = new Session();
                                                  $Session5->setFlash('Le mot de passe doit contenir au moins 1 minuscule','error');
                                                  $Session5->flash_danger();
                                                }
                                              }else
                                              {
                                                $Session4 = new Session();
                                                $Session4->setFlash('Le mot de passe doit contenir au moins 1 majuscule','error');
                                                $Session4->flash_danger();
                                              }
                                            }else
                                            {
                                              $Session13 = new Session();
                                              $Session13->setFlash("Adresse mail déjà utilisée en tant qu'utilisateur",'error');
                                              $Session13->flash_danger();
                                            }
                                          }else
                                          {
                                            $Session12 = new Session();
                                            $Session12->setFlash('Adresse mail déjà utilisée en tant que contributeur','error');
                                            $Session12->flash_danger();
                                          }
                                        }else
                                        {
                                          $Session11 = new Session();
                                          $Session11->setFlash('Adresse mail déjà utilisée en tant que modérateur','error');
                                          $Session11->flash_danger();
                                        }
                                      }else
                                      {
                                        $Session3 = new Session();
                                        $Session3->setFlash("Adresse mail déjà utilisée en tant qu'administrateur",'error');
                                        $Session3->flash_danger();
                                      }
                                      }

                                       ?>
                                     <a href="users.php" class="btn btn-warning">Retour à la liste</a>

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
<!--
<script src="js/jquery.nicescroll.js"></script>
-->
<script src="js/scripts.js"></script>

<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>
