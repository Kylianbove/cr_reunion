<?php include("db.php");  ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mon Espace Salarié - Mot de passe oublié</title>
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

    <div class="row">



            
                
                  <div class="col-sm-12">
                   <h2>Mot de Passe Oublié</h2>

                </div>
                <div class="col-sm-12" id="inscription">

                  <form action="" method="POST">

                  <label><b>Adresse Mail</b></label>
                  <input type="email" placeholder="Saisissez votre adresse mail" name="email" required>




                 <input type="submit" id='submit' name="token" value="ENVOYER UN TOKEN" >


                <?php




                if (isset($_POST['token'])) {
                  require ("session.class.php");
                  $selectmail = $connexion->prepare("SELECT * FROM  infosutiles WHERE id='1'");
                  $selectmail->execute();
                  $mailutiles = $selectmail->fetch();
                  $token = uniqid();
                  $url = "https://altameos.com/mes/token.php?token=".$token;
                  $from = $mailutiles['email'];

                  $subject = 'Réinitialisation de votre mot de passe';
                  $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
                  $message = "Bonjour, voici le lien pour la réinitialisation de votre mot de passe : $url";
                  $headers = [

                     "Content-Type" => "text/plain; charset=UTF-8",
                     "From" => $from,

                  ];

                  

                  $selectuser = $connexion->prepare("SELECT email FROM users WHERE email = '".$_POST['email']."'");
                  $selectuser->execute();
                  $user = $selectuser->fetch();

                  $selectadminusers = $connexion->prepare("SELECT email FROM adminusers WHERE email = '".$_POST['email']."'");
                  $selectadminusers->execute();
                  $adminusers = $selectadminusers->fetch();

                  $selectmoderateur = $connexion->prepare("SELECT email FROM moderateur WHERE email = '".$_POST['email']."'");
                  $selectmoderateur->execute();
                  $moderateur = $selectmoderateur->fetch();

                  $selectcontributeur = $connexion->prepare("SELECT email FROM contributeur WHERE email = '".$_POST['email']."'");
                  $selectcontributeur->execute();
                  $contributeur = $selectcontributeur->fetch();

                  if($user != null || $adminusers != null || $moderateur != null || $contributeur != null){

                  if($user != null){
                    if (mail($_POST['email'], $subject, $message, $headers)) {
                      $stmt = $connexion->prepare("UPDATE users SET token = ? WHERE email = ?");
                    }
                  }
                  if($adminusers != null){
                    if (mail($_POST['email'], $subject, $message, $headers)) {
                      $stmt = $connexion->prepare("UPDATE adminusers SET token = ? WHERE email = ?");
                    }
                  }
                  if($moderateur != null){
                    if (mail($_POST['email'], $subject, $message, $headers)) {
                      $stmt = $connexion->prepare("UPDATE moderateur SET token = ? WHERE email = ?");
                    }
                  }
                  if($contributeur != null){
                    if (mail($_POST['email'], $subject, $message, $headers)) {
                     $stmt = $connexion->prepare("UPDATE contributeur SET token = ? WHERE email = ?");
                    }
                  }
                  $stmt->execute([$token, $_POST['email']]);

                  $Session2 = new Session();
                  $Session2->setFlash("Vous avez reçu un mail pour la réinitialisation de votre mot de passe !", 'succes');
                  $Session2->flash_success();

                }else{
                  $Session3 = new Session();
                  $Session3->setFlash('Adresse Mail incorrect!', 'error');
                  $Session3->flash_danger();
                }

              }
                  ?>
             </div>
            </form>

          
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
