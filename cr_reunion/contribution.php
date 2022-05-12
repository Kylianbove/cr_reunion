<?php include("db.php");  ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mon Espace Salarié - Contributions</title>
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
    <?php

    if(!empty($_SESSION['Username'])){

    ?>
    <div class="row">





                <div class="col-sm-12">
                   <h2><i class="fa-duotone fa-comment-lines"></i> Contribution</h2>

                </div>
                <div class="col-sm-12" id="inscription">

                <form action="" method="POST">

                  <label><b>Titre</b></label>
                  <input type="text" placeholder="Entrer l'objet de votre contribution" name="titre" required>

                  <label><b>Détails</b></label>
                  <textarea type="text" placeholder="Entrer votre contribution" name="details" rows="10" cols="67" required></textarea>


                 <input type="submit" id='submit' name="contribution" value="ENVOYER" >


                <?php


                if(isset($_POST['contribution']))
                    {

                      $stmt = $connexion->prepare("INSERT INTO `contribution`(`id_contribution`, `id_users`, `titre`, `details`) VALUES (:id, :id_users, :titre, :details)");


                      $stmt -> bindParam(':id', $id);
                      $stmt -> bindParam(':id_users', $users['id']);
                      $stmt -> bindParam(':titre', $_POST['titre']);
                      $stmt -> bindParam(':details', $_POST['details']);

                      $stmt->execute();

                      $url = "index.php";
                      echo "<script>setTimeout(function(){location.href='".$url."'}, 3000);</script>";



                    require ("session.class.php");

                    $Session2 = new Session();
                    $Session2->setFlash("Vous venez de d'envoyer une contribution !", 'succes');
                    $Session2->flash_success();

                  }
                 ?>
                  </form>
               </div>



    </div>
    <?php }else{
      require ("session.class.php");

      $Session8 = new Session();
      $Session8->setFlash("Pour pouvoir contribuer veuillez vous connecter ou vous inscrire!",'error');
      $Session8->flash_danger();


    } ?>
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
