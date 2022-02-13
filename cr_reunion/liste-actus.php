<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mon Espace Salarié - Actualités - Liste de toutes les actualités</title>
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
    <h2><i class="fa-duotone fa-rss"></i> Actualités</h2>

    </div>
</div>
<div class="row">
  <?php
  @$categorie=$_GET["categorie"];

  //moteur de recherche
  @$rechercher = $_POST['rechercher'];
  @$valider = $_POST['valider'];


  if(!isset($_SESSION['Username'])){
    $affichage = "affichage = 0";
  }

  if(!empty($users)){

    if($users['typeUser'] == 1){
    $affichage = "(affichage = 0 OR affichage = 1)";
    }
    if($users['typeUser'] == 2){
    $affichage = "(affichage = 0 OR affichage = 1 OR affichage = 2)";
    }
    if($users['typeUser'] == 3){
    $affichage = "(affichage = 0 OR affichage = 1 OR affichage = 2 OR affichage = 3)";
    }
  }
  if(!empty($contributeur) || !empty($moderateur) || !empty($administrateur)){
    $affichage = "(affichage = 0 OR affichage = 1 OR affichage = 2 OR affichage = 3 OR affichage = 4)";
  }

  if(empty($categorie) || $categorie == 0){
    if(isset($valider) && !empty(trim($rechercher))){
      $countactu = $connexion->prepare("SELECT COUNT(id_actu) as nb FROM actualite WHERE publier = 1 AND valider = 1 AND $affichage AND (accroche LIKE '%$rechercher%' OR titre LIKE '%$rechercher%')");
    }else{
      $countactu = $connexion->prepare("SELECT COUNT(id_actu) as nb FROM actualite WHERE publier = 1 AND valider = 1 AND $affichage");
    }
  }else{
    if(isset($valider) && !empty(trim($rechercher))){
      $countactu = $connexion->prepare("SELECT COUNT(id_actu) as nb FROM actualite WHERE publier = 1 AND valider = 1 AND $affichage AND id_cat = $categorie AND (accroche LIKE '%$rechercher%' OR titre LIKE '%$rechercher%')");
    }else{
      $countactu = $connexion->prepare("SELECT COUNT(id_actu) as nb FROM actualite WHERE publier = 1 AND valider = 1 AND $affichage AND id_cat = $categorie");
    }
  }




  $countactu->execute();
  $count = $countactu->fetchAll();

  @$page=$_GET["page"];

  if(empty($page)){
    $page = 1;
  }
//pagination
  $nb_actu_par_page = 6;
  $nb_page = ceil($count[0]["nb"]/$nb_actu_par_page);
  $debut = ($page-1)*$nb_actu_par_page;





    if(empty($categorie)|| $categorie == 0){
      if(isset($valider) && !empty(trim($rechercher))){
        $selectactu = $connexion->prepare("SELECT id_actu, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM actualite WHERE publier = 1 AND valider = 1 AND $affichage AND (accroche LIKE '%$rechercher%' OR titre LIKE '%$rechercher%') ORDER BY date_publication DESC LIMIT $debut, $nb_actu_par_page");
      }else{
        $selectactu = $connexion->prepare("SELECT id_actu, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM actualite WHERE publier = 1 AND valider = 1 AND $affichage ORDER BY date_publication DESC LIMIT $debut, $nb_actu_par_page");
      }
    }else{
      if(isset($valider) && !empty(trim($rechercher))){
        $selectactu = $connexion->prepare("SELECT id_actu, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM actualite WHERE publier = 1 AND valider = 1 AND $affichage AND id_cat = $categorie AND (accroche LIKE '%$rechercher%' OR titre LIKE '%$rechercher%') ORDER BY date_publication DESC LIMIT $debut, $nb_actu_par_page");
      }else{
        $selectactu = $connexion->prepare("SELECT id_actu, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM actualite WHERE publier = 1 AND valider = 1 AND $affichage AND id_cat = $categorie ORDER BY date_publication DESC LIMIT $debut, $nb_actu_par_page");
      }
    }



  $selectactu->execute();
  $actualite = $selectactu->fetch();

  if($actualite != null){
  do{
    $valeur = $actualite['id_actu'];
    ?>
    <div class="col-md-6">


        <div class="actuLanceur">
        <h3><?php echo $actualite['date_publi']; ?><?php echo " - ".$actualite['titre']; ?></h3>
        <div class="accroche">
          <?php echo $actualite['accroche']; ?>
        </div>
        <a href="detail-actu.php?param=<?php echo $valeur ;?>"><i class="fa-duotone fa-chevrons-right"></i> En savoir plus</a>

        </div>

    </div>
  <?php }while($actualite = $selectactu->fetch());

} ?>

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
  </div>
  <div class="col-sm-5 col-md-5 col-lg-3 colDroite">
    <div class="droiteContent">
    <h3>Filtrer / Rechercher</h3>

    <label for="categorie">Catégories</label>
    <select class="form-control" id="categorie" onchange="document.location.href=this.value">
      <option value="">--</option>
      <option value="?categorie=0">Toutes les catégories</option>
      <?php



        $selectcategorie = $connexion->prepare("SELECT * FROM categorie WHERE publier = 1 ORDER BY id_cat ASC");
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

    <a href="liste-actus.php" class="linkBar">Accédez aux Actualités</a>


    <?php include('laisser_contribution.php'); ?>

  </div>
</div>
</div>

<script src="js/jquery.js"></script>
<script src="js/monthly-1.0.0.js"></script>
<script src="js/site.js"></script>

</body>
</html>
