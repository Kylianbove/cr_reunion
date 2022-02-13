<?php include("db.php"); ?>
<?php

/*
inclus le dossier (db.php)
si (la valeurs $_session est déclaré et non-null)
     donc la session commence/reprend
*/

//initialize the session
if (!isset($_SESSION)) {
  @session_start();
}

/*
la variables est la valeurs (['php_self']du tableau $_server) ."?doLogout=true"
    si la valeur ((['query_string'] du tableau $_Server est declaré et non-null) et la (même) valeur egale a "") donc
    variable .="&". htlmentities** la valeur (['query_string'] du tableau $_Server)
*/

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


$query_rs_admin = $connexion->prepare("SELECT * FROM  adminusers WHERE email=?");
$query_rs_admin->execute(array($_SESSION['MM_UsernameADM']));
$resultat = $query_rs_admin->fetch();

$query_rs_mod = $connexion->prepare("SELECT * FROM moderateur WHERE email=?");
$query_rs_mod->execute(array($_SESSION['MM_UsernameADM']));
$moderateur = $query_rs_mod->fetch();

$query_rs_contri = $connexion->prepare("SELECT * FROM contributeur WHERE email=?");
$query_rs_contri->execute(array($_SESSION['MM_UsernameADM']));
$contributeur = $query_rs_contri->fetch();


$query_rs_utiles = $connexion->prepare("SELECT * FROM  infosutiles WHERE id='1'");
$query_rs_utiles->execute();
$row_rs_utiles = $query_rs_utiles->fetch();


$tg = $row_rs_utiles['logo'];


// Constantes
define('TARGET', 'uploads/vignettes/');    // Repertoire cible
define('MAX_SIZE', 100000);    // Taille max en octets du fichier
define('WIDTH_MAX', 800);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 800);    // Hauteur max de l'image en pixels

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

if($t1=='') { $t1 = $tg; }

}
if(isset($_POST['modifier']))
    {

      if( !empty($_FILES['fichier']['name']) )
      {


      $maxsize = 41943040; // 5Mo

      $name = $_FILES['fichier']['name'];
      $target_dir = "uploads/vignettes/";
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
            $updateSQL = $connexion->prepare("UPDATE infosutiles SET nom=:nom, adresse=:adresse, cp=:cp, ville=:ville,  tel=:tel, email=:email,
              facebook=:facebook, twitter=:twitter, youtube=:youtube, pinterest=:pinterest, instagram=:instagram, rss=:rss, googlemap=:googlemap, accroche=:accroche, seoDescription=:seoDescription, seoKeywords=:seoKeywords, logo=:logo, info_bienvenue=:info_bienvenue WHERE id=:id");

              $updateSQL -> bindParam(':nom', $_POST['nom']);
              $updateSQL -> bindParam(':adresse', $_POST['adresse']);
              $updateSQL -> bindParam(':cp', $_POST['zip']);
              $updateSQL -> bindParam(':ville', $_POST['ville']);
              $updateSQL -> bindParam(':tel', $_POST['tel']);
              $updateSQL -> bindParam(':email', $_POST['email']);
              $updateSQL -> bindParam(':facebook', $_POST['facebook']);
              $updateSQL -> bindParam(':twitter', $_POST['twitter']);
              $updateSQL -> bindParam(':youtube', $_POST['youtube']);
              $updateSQL -> bindParam(':pinterest', $_POST['pinterest']);
              $updateSQL -> bindParam(':instagram', $_POST['instagram']);
              $updateSQL -> bindParam(':rss', $_POST['rss']);
              $updateSQL -> bindParam(':googlemap', $_POST['gmap']);
              $updateSQL -> bindParam(':accroche', $_POST['accroche']);
              $updateSQL -> bindParam(':seoDescription', $_POST['seo1']);
              $updateSQL -> bindParam(':seoKeywords', $_POST['seo2']);
              $updateSQL -> bindParam(':logo', $name);
              $updateSQL -> bindParam(':info_bienvenue', $_POST['info_bienvenue']);
              $updateSQL -> bindParam(':id', $_POST['id']);


              $updateSQL->execute();
              $Result1 = $updateSQL->fetch();



              $insertGoTo = "utiles.php";

              echo "<script>window.location.href='".$insertGoTo."';</script>";
            }
          }

          }else{
            $Session14 = new Session();
            $Session14->setFlash("Extension du fichier invalide ",'error');
            $Session14->flash_danger();
          }

        }else{
          $updateSQL = $connexion->prepare("UPDATE infosutiles SET nom=:nom, adresse=:adresse, cp=:cp, ville=:ville,  tel=:tel, email=:email,
            facebook=:facebook, twitter=:twitter, youtube=:youtube, pinterest=:pinterest, instagram=:instagram, rss=:rss, googlemap=:googlemap, accroche=:accroche, seoDescription=:seoDescription, seoKeywords=:seoKeywords, info_bienvenue=:info_bienvenue WHERE id=:id");

            $updateSQL -> bindParam(':nom', $_POST['nom']);
            $updateSQL -> bindParam(':adresse', $_POST['adresse']);
            $updateSQL -> bindParam(':cp', $_POST['zip']);
            $updateSQL -> bindParam(':ville', $_POST['ville']);
            $updateSQL -> bindParam(':tel', $_POST['tel']);
            $updateSQL -> bindParam(':email', $_POST['email']);
            $updateSQL -> bindParam(':facebook', $_POST['facebook']);
            $updateSQL -> bindParam(':twitter', $_POST['twitter']);
            $updateSQL -> bindParam(':youtube', $_POST['youtube']);
            $updateSQL -> bindParam(':pinterest', $_POST['pinterest']);
            $updateSQL -> bindParam(':instagram', $_POST['instagram']);
            $updateSQL -> bindParam(':rss', $_POST['rss']);
            $updateSQL -> bindParam(':googlemap', $_POST['gmap']);
            $updateSQL -> bindParam(':accroche', $_POST['accroche']);
            $updateSQL -> bindParam(':seoDescription', $_POST['seo1']);
            $updateSQL -> bindParam(':seoKeywords', $_POST['seo2']);

            $updateSQL -> bindParam(':info_bienvenue', $_POST['info_bienvenue']);
            $updateSQL -> bindParam(':id', $_POST['id']);


            $updateSQL->execute();
            $Result1 = $updateSQL->fetch();



            $insertGoTo = "utiles.php";

            echo "<script>window.location.href='".$insertGoTo."';</script>";
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
<script src="js/jquery-1.10.2.min.js"></script>
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
													            <h2 class="inner-tittle">Informations utiles</h2>
															<div class="graph-form">
																	<div class="form-body">
																		<form method="post" action="" enctype="multipart/form-data">
																		<div class="col-md-6">
																		<div class="form-group">
																		<label for="nom">Nom de la société</label>
																		<input type="text" class="form-control" id="nom" name="nom" placeholder="Nom de la société" value="<?php echo $row_rs_utiles['nom']; ?>" required>
																		</div>
																		<div class="form-group">
																		<label for="adresse">Adresse</label>
																		<input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse postale"  value="<?php echo $row_rs_utiles['adresse']; ?>" required>
																		</div>
																		<div class="form-group">
																		<label for="zip">Code postal</label>
																		<input type="text" class="form-control" id="zip" name="zip" placeholder="Code postal"  value="<?php echo $row_rs_utiles['cp']; ?>" required pattern="[0-9]{5}">
																		</div>
																		<div class="form-group">
																		<label for="ville">Ville</label>
																		<input type="text" class="form-control" id="ville" name="ville" placeholder="Ville"  value="<?php echo $row_rs_utiles['ville']; ?>" required>
																		</div>
																		<div class="form-group">
																		<label for="tel">Téléphone</label>
																		<input type="tel" class="form-control" id="tel" name="tel" placeholder="Téléphone"  value="<?php echo $row_rs_utiles['tel']; ?>" required pattern="0[1-9][0-9]{8}">
																		</div>
																		<div class="form-group">
																		<label for="email">Adresse Email</label>
																		<input type="email" class="form-control" id="email" name="email" placeholder="Email"  value="<?php echo $row_rs_utiles['email']; ?>" required>
																		</div>

																			<h4>Réseaux sociaux</h4>
																		 <div class="form-group">
																		<label for="facebook">Facebook</label>
																		<input type="url" class="form-control" id="facebook" name="facebook" placeholder="Facebook"  value="<?php echo $row_rs_utiles['facebook']; ?>" >
																		</div>

																		<div class="form-group">
																		<label for="twitter">Twitter</label>
																		<input type="url" class="form-control" id="twitter" name="twitter" placeholder="Twitter"  value="<?php echo $row_rs_utiles['twitter']; ?>" >
																		</div>

																		<div class="form-group">
																		<label for="youtube">Youtube</label>
																		<input type="url" class="form-control" id="youtube" name="youtube" placeholder="youtube"  value="<?php echo $row_rs_utiles['youtube']; ?>" >
																		</div>

																		<div class="form-group">
																		<label for="pinterest">Pinterest</label>
																		<input type="url" class="form-control" id="pinterest" name="pinterest" placeholder="pinterest"  value="<?php echo $row_rs_utiles['pinterest']; ?>" >
																		</div>

																		<div class="form-group">
																		<label for="instagram">Instagram</label>
																		<input type="url" class="form-control" id="instagram" name="instagram" placeholder="instagram"  value="<?php echo $row_rs_utiles['instagram']; ?>" >
																		</div>



																		<div class="form-group">
																		<label for="gplus">RSS</label>
																		<input type="url" class="form-control" id="rss" name="rss" placeholder="RSS"  value="<?php echo $row_rs_utiles['rss']; ?>" >
																		</div>

																		</div>
																		<div class="col-md-6">

																		<div class="form-group">
																		<label for="Logo">Logo</label>
																		<input type="file" id="Logo" name="fichier" accept="image/*">
                                      <?php if($row_rs_utiles['logo'] != null){ ?>
																	   <img src="./uploads/vignettes/<?php echo $row_rs_utiles['logo']; ?>" controls width='320px' height='200px' >
                                       <?php } ?>
																		 </div>

																		<h4>Nous localiser & accroche</h4>
																		<?php if (isset($row_rs_utiles['googlemap'])) { ?>

																		        	<iframe src="<?php echo $row_rs_utiles['googlemap']; ?>" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
																		        	<style>iframe{ width:100%!important; height:200px!important; }</style>
																		<?php  } ?>
																		<div class="form-group">
																		<label for="gmap">Google Map</label>
																		<textarea class="form-control" id="gmap" name="gmap" placeholder="Google Map"><?php echo $row_rs_utiles['googlemap']; ?></textarea>
																		</div>

																		<div class="form-group">
																		<label for="accroche">Accroche</label>
																		<input type="text" class="form-control" id="accroche" name="accroche" placeholder="Accroche"  value="<?php echo $row_rs_utiles['accroche']; ?>" required>
																		</div>

																		<h4>Référencement</h4>

																		<div class="form-group">
																		<label for="seo1">Description</label>
																		<input type="text" class="form-control" id="seo1" name="seo1" placeholder="Meta Description"  value="<?php echo $row_rs_utiles['seoDescription']; ?>" required>
																		</div>

                                    <div class="form-group">
																		<label for="info_bienvenue">Informations Bienvenue</label>
																		<input type="text" class="form-control" id="info_bienvenue" name="info_bienvenue" placeholder="Informations"  value="<?php echo $row_rs_utiles['info_bienvenue']; ?>" required>
																		</div>

																		<div class="form-group">
																		<label for="seo2">Mots-clés</label>
																		<input type="text" class="form-control" id="seo2" name="seo2" placeholder="Meta Keywords"  value="<?php echo $row_rs_utiles['seoKeywords']; ?>" required>
																		</div>

																		 </div>
																		 <div class="clearfix"></div>
																		 <input type="hidden" name="id" value="1" />
																		 <input type="hidden" name="MM_update" value="form1" />
																		  <button type="submit" class="btn btn-default" name="modifier">Valider les modifications</button> </form>
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
