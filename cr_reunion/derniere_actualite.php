<div class="col-lg-6">
  <h2><i class="fa-duotone fa-rss"></i> Actualités</h2>

  <?php
  if(!isset($_SESSION['Username'])){
  $selectactu = $connexion->prepare("SELECT id_actu, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM actualite WHERE publier = 1 AND valider = 1 AND affichage = 0 ORDER BY date_publication DESC");
  }

  if(!empty($users)){

    if($users['typeUser'] == 1){
    $selectactu = $connexion->prepare("SELECT id_actu, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM actualite WHERE publier = 1 AND valider = 1 AND (affichage = 0 OR affichage = 1) ORDER BY date_publication DESC");
    }
    if($users['typeUser'] == 2){
    $selectactu = $connexion->prepare("SELECT id_actu, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM actualite WHERE publier = 1 AND valider = 1 AND (affichage = 0 OR affichage = 1 OR affichage = 2) ORDER BY date_publication DESC");
    }
    if($users['typeUser'] == 3){
    $selectactu = $connexion->prepare("SELECT id_actu, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM actualite WHERE publier = 1 AND valider = 1 AND (affichage = 0 OR affichage = 1 OR affichage = 2 OR affichage = 3) ORDER BY date_publication DESC");
    }
  }
  if(!empty($contributeur) || !empty($moderateur) || !empty($administrateur)){
    $selectactu = $connexion->prepare("SELECT id_actu, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM actualite WHERE publier = 1 AND valider = 1 AND (affichage = 0 OR affichage = 1 OR affichage = 2 OR affichage = 3 OR affichage = 4) ORDER BY date_publication DESC");
  }

  $selectactu->execute();
  $actualite = $selectactu->fetch();

    ?>
  <div class="actualites">
    <?php
    $i = 0;
    do{

      $i = $i+1;
      $valeur = $actualite['id_actu'];
      if($i<4){
        ?>
  <div class="actuLanceur">
    <h3><?php echo $actualite['date_publi']; ?><?php echo " - ".$actualite['titre']; ?></h3>
    <div class="accroche">
    <?php echo $actualite['accroche']; ?>
    </div>
    <a href="detail-actu.php?param=<?php echo $valeur ;?>"><i class="fa-duotone fa-chevrons-right"></i> En savoir plus</a>
  </div>
<?php }}while($actualite = $selectactu->fetch()); ?>

  </div>

            <a href="liste-actus.php" class="linkBar">Toutes les actualités</a>

</div>
