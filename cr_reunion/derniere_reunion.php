
  <?php

  if(isset($_SESSION['Username'])){
    $i = 0;
    if(isset($users)){
      if($users['typeUser'] == 1){
        $i = 1;
      }
    }
    if($i != 1){
  $selectcr = $connexion->prepare("SELECT id_cr, titre, accroche, texte, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM compte_rendu WHERE publier = 1 AND valider = 1 ORDER BY date_publication DESC");
  $selectcr->execute();
  $compte_rendu = $selectcr->fetch();
$valeur = $compte_rendu['id_cr'];
    ?>
  <div class="droiteContent">
  <h3>Dernière réunion</h3>
  <h4>Réunion du <?php echo $compte_rendu['date_publi']; ?></h4>
  <div class="accroche">
    <?php echo $compte_rendu['accroche']; ?>
   </div>
  <a href="detail-cr.php?param=<?php echo $valeur ;?>"><i class="fa-duotone fa-chevrons-right"></i> En savoir plus</a>

  </div>
  <a href="liste-cr.php" class="linkBar">Toutes les réunions</a>
<?php }} ?>
