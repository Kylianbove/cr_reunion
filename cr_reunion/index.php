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
    <div class="col-sm-12">
      <?php include('generexml.php'); ?>
      <h2>Bienvenue sur MonEspaceSalarié</h2>

      <?php
      $query_rs_bienvenue = $connexion->prepare("SELECT * FROM infosutiles ");
      $query_rs_bienvenue->execute();
      $bienvenue = $query_rs_bienvenue->fetch(); ?>

      <div class="texte">
        <?php echo $bienvenue['info_bienvenue']; ?>

      </div>
    </div>

    <!-- bloc actualités -->
    <?php include('derniere_actualite.php'); ?>

    <div class="col-lg-6">
      <h2><i class="fa-duotone fa-calendar-clock"></i> Agenda</h2>
      <div class="agenda">
      <div class="monthly" id="calendar"></div>
      </div>

      <a href="agenda.php" class="linkBar">Agenda détaillé</a>
    </div>

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
