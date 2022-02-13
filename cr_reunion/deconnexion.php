<?php
  include ("index.php");

if($users != null){
  $deletetoken = $connexion->prepare("UPDATE users SET token = NULL WHERE email = ?");
}
if($administrateur != null){
  $deletetoken = $connexion->prepare("UPDATE adminusers SET token = NULL WHERE email = ?");
}
if($moderateur != null){
  $deletetoken = $connexion->prepare("UPDATE moderateur SET token = NULL WHERE email = ?");
}
if($contributeur != null){
  $deletetoken = $connexion->prepare("UPDATE contributeur SET token = NULL WHERE email = ?");
}
$deletetoken->execute([$_SESSION['Username']]);
  unset($_SESSION['Username']);
  $url = "index.php";
  echo "<script>setTimeout(location.href='".$url."', 1000);</script>";

?>
