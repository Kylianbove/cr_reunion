<?php include("db.php");


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING']=="")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['connexion'])) {

  $loginUsername=$_POST['login_cmp'];
  $password=$_POST['pass_cmp'];

  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  /*$MM_redirectLoginFailed = "auth_index.php";
  $MM_redirecttoReferrer = true;*/


//  Récupération de l'utilisateur et de son pass hashé
  $query_rs_admin = $connexion->prepare("SELECT * FROM adminusers WHERE email=?");
  $query_rs_admin->execute(array($loginUsername));
  $resultat = $query_rs_admin->fetch();

  $query_rs_mod = $connexion->prepare("SELECT * FROM moderateur WHERE email=?");
  $query_rs_mod->execute(array($loginUsername));
  $moderateur = $query_rs_mod->fetch();

  $query_rs_contri = $connexion->prepare("SELECT * FROM contributeur WHERE email=?");
  $query_rs_contri->execute(array($loginUsername));
  $contributeur = $query_rs_contri->fetch();

  $query_rs_users = $connexion->prepare("SELECT * FROM users WHERE email=?");
  $query_rs_users->execute(array($loginUsername));
  $utilisateurs = $query_rs_users->fetch();

  if($utilisateurs != null){
    header("Location: accesusers.php");
  }

require ("session.class.php");

    // Comparaison du mdp envoyé via le formulaire avec la base
    if($resultat != null){
    $isPasswordCorrect = password_verify($password, $resultat['passwords']);




    if ($resultat && $isPasswordCorrect)
    {
      $loginStrGroup = "";
      //declare two session variables and assign them
      $_SESSION['MM_UsernameADM'] = $loginUsername;
      $_SESSION['MM_UserGroupADM'] = $loginStrGroup;

      if (isset($_SESSION['PrevUrl']) && true) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
      }

      header('Location: index.php');
      echo $MM_redirectLoginSuccess ;
    }
    else
    {

      $Session2 = new Session();
      $Session2->setFlash('Mauvais mot de passe ou mail !', 'error');
      $Session2->flash_danger();
    }
  }

  if($moderateur != null){
    $isPasswordCorrectmod = password_verify($password, $moderateur['passwords']);

    if ($moderateur && $isPasswordCorrectmod)
    {
      $loginStrGroup = "";
      //declare two session variables and assign them
      $_SESSION['MM_UsernameADM'] = $loginUsername;
      $_SESSION['MM_UserGroupADM'] = $loginStrGroup;

      if (isset($_SESSION['PrevUrl']) && true) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
      }

      header('Location: index.php');
      echo $MM_redirectLoginSuccess ;
    }
    else
    {
      $Session2 = new Session();
      $Session2->setFlash('Mauvais mot de passe ou mail !', 'error');
      $Session2->flash_danger();
    }
  }

  if($contributeur != null){
    $isPasswordCorrectcontri = password_verify($password, $contributeur['passwords']);

    if ($contributeur && $isPasswordCorrectcontri)
    {
      $loginStrGroup = "";
      //declare two session variables and assign them
      $_SESSION['MM_UsernameADM'] = $loginUsername;
      $_SESSION['MM_UserGroupADM'] = $loginStrGroup;

      if (isset($_SESSION['PrevUrl']) && true) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
      }

      header('Location: index.php');
      echo $MM_redirectLoginSuccess ;
    }
    else
    {
      $Session2 = new Session();
      $Session2->setFlash('Mauvais mot de passe ou mail !', 'error');
      $Session2->flash_danger();
    }
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
<!--clock init-->
</head>
<body>
								<!--/login-->

									   <div class="error_page">
												<!--/login-top-->

													<div class="error-top">
													<h2 class="inner-tittle page" style="text-align: center; color: #fff!important; line-height: 20px; color: #fff;"><small style="color: #fff;">O18 Market<br><span style="font-size: 16px;  color: #fff;">MarketPlace du Cher</span></small></h2>
													    <div class="login">
														<h3 class="inner-tittle t-inner">Accès  au module d'administration</h3>
                            <form method="post" action="auth_index.php">
                                  <input type="text" class="text" value="Identifiant" name="login_cmp" >
                                  <input type="password" value="Password" name="pass_cmp">
                                  <div class="submit"><input type="submit" value="M'identifier" name="connexion" ></div>
                                  <div class="clearfix"></div>

															<!--	<form method="post" action="auth_index.php">
																		<input type="text" class="text" value="Identifiant" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Identifiant';}" name="login_cmp" >
																		<input type="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" name="pass_cmp">
																		<div class="submit"><input type="submit" onclick="myFunction()" value="M'identifier" ></div>
																		<div class="clearfix"></div>


																	</form>-->
														</div>


													</div>


												<!--//login-top-->
										   </div>

										  	<!--//login-->
										    <!--footer section start-->
										<div class="footer">

										   <p>&copy 2021 Oslab Technologies. All Rights Reserved | Design by <a href="https://w3layouts.com/" target="_blank">W3layouts.</a></p>
										</div>
									<!--footer section end-->
									<!--/404-->
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>
