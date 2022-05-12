<?php include("db.php"); ?>
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
<?php /* if(($row_rs_admin['typeUser']==1)||($row_rs_admin['typeUser']==3)){ */?>
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
													            <h2 class="inner-tittle">Bienvenue sur votre espace d'administration</h2>

															<div class="graph">
																					<nav>
																						<ul>
                                              <?php if($resultat != null){ ?>
																							<li><a href="#section-1" class="icon-cup"><i class="lnr lnr-briefcase"></i> <span>Gestion des Utilsateurs</span></a></li>
                                            <?php } ?>
																							<li><a href="#section-2" class="icon-cup"><i class="lnr lnr-briefcase"></i> <span>Gestion des Comptes Rendus</span></a></li>
																							<li><a href="#section-3" class="icon-cup"><i class="lnr lnr-briefcase"></i> <span>Gestion des Actualités</span></a></li>
                                              <?php if($resultat != null || $moderateur != null){ ?>
																							<li><a href="#section-4" class="icon-cup"><i class="lnr lnr-briefcase"></i> <span>Agenda</span></a></li>
                                              <?php } ?>
																						</ul>
																					</nav>
																					<div class="content tab">
                                              <?php if($resultat != null){ ?>
																						<section id="section-1">
																							<div class="mediabox">
																								<i class="fa fa-trophy"></i>
																								<h3>Administrateurs</h3>
																								<p><a href="adminusers.php">C'est par ici !</a></p>
																							</div>
																							<div class="mediabox">
																								<i class="fa fa-trophy"></i>
																								<h3>Modérateurs</h3>
																								<p><a href="moderateurs.php">C'est par ici !</a> </p>
																							</div>

																							<div class="mediabox">
																								<i class="fa fa-trophy"></i>
																								<h3>Contributeurs</h3>
																								<p><a href="contributeur.php">C'est par ici !</a> </p>
																							</div>

                                              <div class="mediabox">
																								<i class="fa fa-trophy"></i>
																								<h3>Utilisateurs</h3>
																								<p><a href="users.php">C'est par ici !</a> </p>
																							</div>

																						</section>
                                           											 <?php } ?>
																						<section id="section-2">
                                              										<?php if($resultat != null || $moderateur != null){ ?>
																							<div class="mediabox">
																								<i class="fa fa-trophy"></i>
																								<h3>Catégories</h3>
																								<p><a href="cr_categorie.php">Cliquez ici</a></p>
																							</div>
                                           											 <?php } ?>

																							<div class="mediabox">
																								<i class="fa fa-trophy"></i>
																								<h3>Compte Rendus</h3>
																								<p><a href="compte_rendu.php">Cliquez ici</a></p>
																							</div>


																							<div class="mediabox">
																								<i class="fa fa-trophy"></i>
																								<h3>Gestion des médias</h3>
																								<p><a href="cr_image.php">Images</a></p>
                                               											 <p><a href="cr_piecejointe.php">Pieces Jointes</a></p>
                                               											 <p><a href="cr_video.php">Vidéos</a></p>
                                              											  <p><a href="cr_audio.php">Audios</a></p>
																							</div>


																						</section>

																						<section id="section-3">
                                                <?php if($resultat != null || $moderateur != null){ ?>
                                              <div class="mediabox">
                                                <i class="fa fa-trophy"></i>
                                                <h3>Catégories</h3>
                                                <p><a href="categorie.php">Cliquez ici</a></p>
                                              </div>
                                              <?php } ?>

                                              <div class="mediabox">
                                                <i class="fa fa-trophy"></i>
                                                <h3>Actualités</h3>
                                                <p><a href="actualite.php">Cliquez ici</a></p>
                                              </div>


                                              <div class="mediabox">
                                                <i class="fa fa-trophy"></i>
                                                <h3>Gestion des médias</h3>
                                                <p><a href="image.php">Images</a></p>
                                                <p><a href="piecejointe.php">Pieces Jointes</a></p>
                                                <p><a href="video.php">Vidéos</a></p>
                                                <p><a href="audio.php">Audios</a></p>
                                              </div>






																						</section>
                                            <?php if($resultat != null || $moderateur != null){ ?>
																						<section id="section-4">
																							<div class="mediabox">
																								<i class="fa fa-trophy"></i>
																								<h3>Agenda</h3>
																								<p>Gestion des planning<br> <a href="planning.php">Cliquez ici</a></p>
																							</div>






																						</section>
                                            <?php } ?>

																					</div><!-- /content -->
																				</div>
																				<!-- /tabs -->

																			</div>
																			<script src="js/cbpFWTabs.js"></script>
																			<script>
																				new CBPFWTabs( document.getElementById( 'tabs' ) );
																			</script>

																 <div class="clearfix"> </div>
														</div>


											  <!--//tabs-inner-->

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
										<?php  include("left.php");  ?>
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
<!--js -->
<link rel="stylesheet" href="css/vroom.css">
<script type="text/javascript" src="js/vroom.js"></script>
<script type="text/javascript" src="js/TweenLite.min.js"></script>
<script type="text/javascript" src="js/CSSPlugin.min.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>

<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
<?php /* } */?>
</body>
</html>
