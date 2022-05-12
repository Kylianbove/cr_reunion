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
  <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>


  <link rel="stylesheet" href="css/site.css">
 

</head>
<body>
<?php include('header.php'); ?>
<div class="container">
<?php include('nav.php'); ?>
<div class="row rowContent">
  <div class="col-sm-7 col-md-7 col-lg-9 colCentre">
    <?php




    if (isset($_GET['token']) && $_GET['token'] != '') {

      $stmtusers = $connexion->prepare("SELECT email FROM users WHERE token = ?");
      $stmtusers->execute([$_GET['token']]);
      $emailuser = $stmtusers->fetchColumn();

      $stmtadminusers = $connexion->prepare("SELECT email FROM adminusers WHERE token = ?");
      $stmtadminusers->execute([$_GET['token']]);
      $emailadminusers = $stmtadminusers->fetchColumn();

      $stmtmoderateur = $connexion->prepare("SELECT email FROM moderateur WHERE token = ?");
      $stmtmoderateur->execute([$_GET['token']]);
      $emailmoderateur = $stmtmoderateur->fetchColumn();

      $stmtcontributeur = $connexion->prepare("SELECT email FROM contributeur WHERE token = ?");
      $stmtcontributeur->execute([$_GET['token']]);
      $emailcontributeur = $stmtcontributeur->fetchColumn();



      if($emailuser != null){
        $email = $emailuser;
      }

      if($emailadminusers != null){
        $email = $emailadminusers;
      }

      if($emailmoderateur != null){
        $email = $emailmoderateur;
      }

      if($emailcontributeur != null){
        $email = $emailcontributeur;
      }


      if($email){ ?>
        <div class="row">



              <div class="col-sm-12">
                   <h2>Mot de Passe Oublié</h2>

                </div>
                <div class="col-sm-12" id="inscription">

                  <form action="" method="POST">

                      <label><b>Nouveau mot de passe</b></label>
                      <input type="password" placeholder="Saisissez votre nouveau mot de passe" name="password" required>




                     <input type="submit" id='submit' name="newPassword" value="Confirmer" >


                     <?php

                     if(isset($_POST['newPassword'])){
                       require ("session.class.php");

                       /*regex mot de passe */
                       $uppercase = preg_match('@[A-Z]@', $_POST['password']);
                       $lowercase = preg_match('@[a-z]@', $_POST['password']);
                       $number = preg_match('@[0-9]@', $_POST['password']);
                       $symbol = preg_match('@[\W]@', $_POST['password']);



                      if($uppercase){
                       if($lowercase){
                         if($number){
                           if($symbol){
                             if(strlen($_POST['password']) > 8){
                               $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                               if($emailuser != null){
                                 $sql = $connexion->prepare("UPDATE users SET passwords = ?, token = NULL WHERE email = ?");
                               }

                               if($emailadminusers != null){
                                 $sql = $connexion->prepare("UPDATE adminusers SET passwords = ?, token = NULL WHERE email = ?");
                               }

                               if($emailmoderateur != null){
                                 $sql = $connexion->prepare("UPDATE moderateur SET passwords = ?, token = NULL WHERE email = ?");
                               }

                               if($emailcontributeur != null){
                                 $sql = $connexion->prepare("UPDATE contributeur SET passwords = ?, token = NULL WHERE email = ?");
                               }

                               $sql->execute([$pass_hash, $email]);

                               $url = "index.php";
                               echo "<script>setTimeout(function(){location.href='".$url."'}, 3000);</script>";



                               $Session2 = new Session();
                               $Session2->setFlash("Votre nouveau mot de passe a bien été enregistré!", 'succes');
                               $Session2->flash_success();
                             }else
                             {
                               $Session8 = new Session();
                               $Session8->setFlash('Le mot de passe doit contenir au moins 8 caractères','error');
                               $Session8->flash_danger();
                             }
                           }else
                           {
                             $Session7 = new Session();
                             $Session7->setFlash('Le mot de passe doit contenir au moins 1 symbole','error');
                             $Session7->flash_danger();
                           }
                         }else
                         {
                           $Session6 = new Session();
                           $Session6->setFlash('Le mot de passe doit contenir au moins 1 chiffre','error');
                           $Session6->flash_danger();
                         }
                       }else
                       {
                         $Session5 = new Session();
                         $Session5->setFlash('Le mot de passe doit contenir au moins 1 minuscule','error');
                           $Session5->flash_danger();
                         }
                       }else
                       {
                         $Session4 = new Session();
                         $Session4->setFlash('Le mot de passe doit contenir au moins 1 majuscule','error');
                         $Session4->flash_danger();
                       }
                    }

                     ?>
                     </div>
                </form>

              
        </div>
        <?php
      }


  }
      ?>




  </div>

  <div class="col-sm-5 col-md-5 col-lg-3 colDroite">

    <!-- info bandeau droit -->
    <?php  include('derniere_reunion.php'); ?>
    <?php include('laisser_contribution.php'); ?>
    <?php include('info_mdp.php'); ?>

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
