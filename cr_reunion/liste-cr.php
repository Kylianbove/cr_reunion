<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mon Espace Salarié - Réunions - Liste de tous les comptes-rendus de réunions</title>
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
    <h2><i class="fa-duotone fa-handshake-simple"></i> Tous les comptes-rendus de réunions</h2>

    </div>
</div>
<?php

if(!empty($contributeur) || !empty($moderateur) || !empty($administrateur) || !empty($users)){
  if($users['typeUser'] != 1){

?>


<div class="row">
  <?php
  @$categorie=$_GET["categorie"];

  //moteur de recherche
  @$rechercher = $_POST['rechercher'];
  @$valider = $_POST['valider'];

  if(empty($categorie) || $categorie == 0){
    if(isset($valider) && !empty(trim($rechercher))){
      $count_cr = $connexion->prepare("SELECT COUNT(id_cr) as nb FROM compte_rendu WHERE publier = 1 AND valider = 1 AND (accroche LIKE '%$rechercher%' OR titre LIKE '%$rechercher%')");
    }else{
      $count_cr = $connexion->prepare("SELECT COUNT(id_cr) as nb FROM compte_rendu WHERE publier = 1 AND valider = 1");
    }
  }else{
    if(isset($valider) && !empty(trim($rechercher))){
      $count_cr = $connexion->prepare("SELECT COUNT(id_cr) as nb FROM compte_rendu WHERE publier = 1 AND valider = 1 AND id_cat = $categorie AND (accroche LIKE '%$rechercher%' OR titre LIKE '%$rechercher%')");
    }else{
      $count_cr = $connexion->prepare("SELECT COUNT(id_cr) as nb FROM compte_rendu WHERE publier = 1 AND valider = 1 AND id_cat = $categorie");
    }
  }

  $count_cr->execute();
  $count = $count_cr->fetchAll();

  @$page=$_GET["page"];

  if(empty($page)){
    $page = 1;
  }
//pagination
  $nb_cr_par_page = 6;
  $nb_page = ceil($count[0]["nb"]/$nb_cr_par_page);
  $debut = ($page-1)*$nb_cr_par_page;



  if(empty($categorie)|| $categorie == 0){
    if(isset($valider) && !empty(trim($rechercher))){
      $selectcr = $connexion->prepare("SELECT id_cr, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM compte_rendu WHERE publier = 1 AND valider = 1 AND (accroche LIKE '%$rechercher%' OR titre LIKE '%$rechercher%') ORDER BY date_publication DESC LIMIT $debut, $nb_cr_par_page");
    }else{
      $selectcr = $connexion->prepare("SELECT id_cr, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM compte_rendu WHERE publier = 1 AND valider = 1 ORDER BY date_publication DESC LIMIT $debut, $nb_cr_par_page");
    }
  }else{
    if(isset($valider) && !empty(trim($rechercher))){
      $selectcr = $connexion->prepare("SELECT id_cr, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM compte_rendu WHERE publier = 1 AND valider = 1 AND id_cat = $categorie AND (accroche LIKE '%$rechercher%' OR titre LIKE '%$rechercher%') ORDER BY date_publication DESC LIMIT $debut, $nb_cr_par_page");
    }else{
      $selectcr = $connexion->prepare("SELECT id_cr, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM compte_rendu WHERE publier = 1 AND valider = 1 AND id_cat = $categorie AND (accroche LIKE '%$rechercher%' OR titre LIKE '%$rechercher%') ORDER BY date_publication DESC LIMIT $debut, $nb_cr_par_page");
    }
  }

  $selectcr->execute();
  $compte_rendu = $selectcr->fetch();

  do{
    $valeur = $compte_rendu['id_cr'];
    ?>
    <div class="col-md-6">


        <div class="actuLanceur">
        <h3><?php echo $compte_rendu['date_publi']; ?><?php echo " - ".$compte_rendu['titre']; ?></h3>
        <div class="accroche">
          <?php echo $compte_rendu['accroche']; ?>
        </div>
        <a href="detail-cr.php?param=<?php echo $valeur ;?>"><i class="fa-duotone fa-chevrons-right"></i> En savoir plus</a>

        </div>

    </div>
  <?php }while($compte_rendu = $selectcr->fetch()); ?>
</div>
  <div class="row">
  <div class="col-12">
    <div class="navigationBar">
        <ul class="pagination">
          <?php for($i=1;$i<=$nb_page;$i++){
            if($page != $i){
              if(empty($categorie)){
              echo "<li><a href='?page=$i'>$i</a></li>";
              }else{
                echo "<li><a href='?categorie=$categorie&amp;page=$i'>$i</a></li>";
              }
            }else{
              echo "<li><a class='active'>$i</a></li>";
            }
          } ?>

        </ul>
    </div>

      </div>
    </div>
  <?php }}else{
    require ("session.class.php");

    $Session8 = new Session();
    $Session8->setFlash("vous n'avez pas les droits d'utilisateurs nécessaire pour accéder à cette page!",'error');
    $Session8->flash_danger();


  } ?>
  </div>

  <div class="col-sm-5 col-md-5 col-lg-3 colDroite">
    <?php

    if(!empty($contributeur) || !empty($moderateur) || !empty($administrateur) || !empty($users)){
      if($users['typeUser'] != 1){

    ?>

    <div class="droiteContent">
    <h3>Filtrer / Rechercher</h3>

    <label for="categorie">Catégories</label>
    <select class="form-control" id="categorie" onchange="document.location.href=this.value">
      <option value="">--</option>
      <option value="?categorie=0">Toutes les catégories</option>
      <?php



        $selectcategorie = $connexion->prepare("SELECT * FROM cr_categorie WHERE publier = 1 ORDER BY id_cat ASC");
        $selectcategorie->execute();
        $categorie = $selectcategorie->fetch();


           if ($categorie > 0) {
          do{

      ?>

     <option value="?categorie=<?php echo $categorie['id_cat']; ?>"><?php echo $categorie['titre']; ?></option>


      <?php

    }while($categorie = $selectcategorie->fetch());
          }

       ?>

    </select>
    <form method="POST" action="">
    <label for="recherche">Recherchez un article</label>
    <input type="text" class="form-control" id="recherche" name="rechercher" placeholder="Mot(s)-clé(s)">
    <input type="submit" value="OK" class="bouton" name="valider">
  </form>



    </div>

    <a href="liste-actus.php?" class="linkBar">Accédez aux Actualités</a>

  <?php }} ?>


    <?php include('laisser_contribution.php'); ?>





  </div>
</div>
</div>



<script src="js/jquery.js"></script>
<script src="js/monthly-1.0.0.js"></script>
<script src="js/site.js"></script>

</body>
</html>
