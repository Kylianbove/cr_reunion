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

    <div class="row">




            	<div class="col-sm-12">
                   <h2><i class="fa-duotone fa-envelopes-bulk"></i> Contactez-nous</h2>

                </div>

                 <div class="col-sm-12" id="inscription">

                 <form action="" method="POST">

                 	<div class="col-md-6">
                  		<label><b>Nom*</b></label>
                  		<input type="text" placeholder="Entrer votre nom" name="nom" required>

                 		<label><b>Prénom*</b></label>
                 		<input type="text" placeholder="Entrer votre prénom" name="prenom" required>
                 	</div>

                 	<div class="col-md-6">
                  		<label><b>Téléphone</b></label>
                  		<input type="tel" placeholder="Entrer votre numéro de téléphone" name="tel">

                  		<label><b>Adresse Mail*</b></label>
                  		<input type="email" placeholder="Saisissez votre adresse mail" name="email" required>
                  	</div>

                  <div class="col-md-12">

                  	<label><b>Message*</b></label>
                  	<textarea type="text" placeholder="Saisissez votre message" name="message" rows="10" cols="67"required></textarea>


                  	<img src="image.php" onclick="this.src='image.php?' + Math.random();" alt="captcha" style="cursor:pointer; width:150px;">
                  	<input type="text" placeholder="Saisissez le code" name="captcha" required />


                 	<input type="submit" id='submit' name="contact" value="ENVOYER" >


                <?php


                if(isset($_POST['contact']))
                    {
                      require ("session.class.php");

                      if($_POST['captcha']==$_SESSION['code']){

                      $stmt = $connexion->prepare("INSERT INTO `contact`(`id_contact`, `email`, `message`, `nom`, `prenom`, `tel`) VALUES (:id, :email, :message, :nom, :prenom, :tel)");


                      $stmt -> bindParam(':id', $id);
                      $stmt -> bindParam(':email', $_POST['email']);
                      $stmt -> bindParam(':message', $_POST['message']);
                      $stmt -> bindParam(':nom', $_POST['nom']);
                      $stmt -> bindParam(':prenom', $_POST['prenom']);
                      $stmt -> bindParam(':tel', $_POST['tel']);


                    $stmt->execute();

                      $url = "index.php";
                      echo "<script>setTimeout(function(){location.href='".$url."'}, 3000);</script>";






                    $Session2 = new Session();
                    $Session2->setFlash("Votre message a bien été envoyé !", 'succes');
                    $Session2->flash_success();


                  }else {
                    $Session3 = new Session();
                    $Session3->setFlash("Code incorrect !", 'error');
                    $Session3->flash_danger();
                  }
                  }
                 ?>
               </div>

            </form>

         </div>
    </div>

    <h4>Nous localiser</h4>
    <?php

    $query_rs_utiles = $connexion->prepare("SELECT * FROM infosutiles WHERE id='1'");
    $query_rs_utiles->execute();
    $row_rs_utiles = $query_rs_utiles->fetch();

    if (isset($row_rs_utiles['googlemap'])) { ?>

              <iframe src="<?php echo $row_rs_utiles['googlemap']; ?>" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
              <style>iframe{ width:100%!important; height:200px!important; }</style>
    <?php  } ?>
  </div>

  <div class="col-sm-5 col-md-5 col-lg-3 colDroite">

    <!-- info bandeau droit -->
    <?php  include('info_entreprise.php'); ?>
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
