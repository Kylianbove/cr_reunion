<?php include("db.php");  ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mon Espace Salarié - Accueil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="fa/fa6/css/all.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/gen.css">
  <link rel="stylesheet" href="css/monthly.css">


  <link rel="stylesheet" href="css/site.css">

</head>
<body>
<?php include('header.php'); ?>
<div class="container">
<?php include('nav.php'); ?>
<div class="row rowContent">
  <div class="col-sm-7 col-md-7 col-lg-9 colCentre">
    <div class="row">

      <?php
      if(isset($_GET['code'])){
        $key = "stagededeuxiemeanneedebtssioaulyceedechartres";
  $text = $_GET['code'];
  $cipher = "AES-256-CBC";

  $ivlen = openssl_cipher_iv_length($cipher);
  $iv = '1234567891011121';

  $original_text = openssl_decrypt($text, $cipher, $key, $options=0, $iv);
  $code = $original_text;
        }



      $stmt = $connexion->prepare("SELECT code FROM users WHERE code=?");
      $stmt->execute(array($code));
      $resultat = $stmt->fetch();

      echo "voici le code de validation de votre inscription: ".$resultat['code'];
      ?>
      </br>
      <a href="codeinscription.php?code=<?php echo $code;?>">retourner sur la page de validation</a>
    </div>
  </div>
  <div class="col-sm-5 col-md-5 col-lg-3 colDroite">
    <!-- info bandeau droit -->
    <?php  include('derniere_reunion.php'); ?>
    <?php include('laisser_contribution.php'); ?>

  </div>
</div>
</div>

<script src="js/jquery.js"></script>
<script src="js/monthly-1.0.0.js"></script>
<script src="js/site.js"></script>
<script>
$('#calendar').monthly({
  mode:'event',
  xmlUrl:'events.xml'
});

</script>
<style>
.monthly-event-list{
  max-height: 75px!important;
}
.monthly-day-wrap{
  min-height: 395px;
}
</style>
</body>
</html>
