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
  <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include('header.php'); ?>
<div class="container">
<?php include('nav.php'); ?>
<div class="row rowContent">
  <div class="col-sm-7 col-md-7 col-lg-9 colCentre">
    <div class="row">

      <?php
      require ("session.class.php");
      if(isset($_GET['error'])){

        if(($_GET['error'] != NULL) && ($_GET['error']!='')){

        $req = $connexion->prepare("DELETE FROM users WHERE code=?");
        $req->execute(array($_GET['error']));
        }
        $Session10 = new Session();
        $Session10->setFlash("Votre inscription n'a pas pu être pris en compte",'error');
        $Session10->flash_danger();
        $url = "inscription.php";
        echo "<script>setTimeout(function(){location.href='".$url."'}, 10000);</script>";

      }
      ?>
      <style>


      </style>
      <div class="col-sm-12">
         <h2><i class="fa-duotone fa-users iconTitle"></i> Inscription</h2>

      </div>
      <div class="col-sm-12" id="inscription">

        <form action="" method="POST">
                <div class="col-md-6">
                  <label><b>Nom</b></label>
                  <input type="text" placeholder="Entrer votre nom" name="nom" value="<?php if(isset($_POST['nom'])){echo $_POST['nom'];} ?>" required>

                  <label><b>Prénom</b></label>
                  <input type="text" placeholder="Entrer votre prénom" name="prenom" value="<?php if(isset($_POST['prenom'])){echo $_POST['prenom'];} ?>" required>

                  <label><b>Adresse mail</b></label>
                  <input type="email" placeholder="Entrer votre adresse mail" name="mail" value="<?php if(isset($_POST['mail'])){echo $_POST['mail'];} ?>" required>

                  <label><b>Mot de passe</b></label>
                  <input type="password" placeholder="Entrer le mot de passe" name="password" required>

                  <label><b>Confirmer votre Mot de passe</b></label>
                  <input type="password" placeholder="Entrer le mot de passe" name="password2" required>
                </div>
                <div class="col-md-6">
                  <label><b>Téléphone</b></label>
                  <input type="tel" placeholder="Entrer votre numéro de téléphone" name="tel" value="<?php if(isset($_POST['tel'])){echo $_POST['tel'];} ?>" required>

                  <label><b>Adresse</b></label>
                  <input type="text" placeholder="Entrer votre adresse" name="adresse" value="<?php if(isset($_POST['adresse'])){echo $_POST['adresse'];} ?>" required>

                  <label><b>Code postal</b></label>
                  <input type="text" placeholder="Entrer votre code postal" name="cp" value="<?php if(isset($_POST['cp'])){echo $_POST['cp'];} ?>" required>

                  <label><b>Ville</b></label>
                  <input type="text" placeholder="Entrer votre ville" name="ville" value="<?php if(isset($_POST['ville'])){echo $_POST['ville'];} ?>" required>

                  <div class="form-group2">
                  <label><b>Pays</b></label></br>
                  <select id="pays" name="pays" required>

                  <?php
                    $query_rs_pays = $connexion->prepare("SELECT * FROM pays ORDER BY id ASC");
                    $query_rs_pays->execute();
                    $row_rs_pays = $query_rs_pays->fetch();


                       if ($row_rs_pays > 0) {
                      do{

                  ?>

                 <option value="<?php echo $row_rs_pays['id']; ?>"<?php if($row_rs_pays['nom'] == "France"){echo "selected";}  ?><?php if(isset($_POST['pays'])){if($row_rs_pays['id'] == $_POST['pays']){echo "selected";}}  ?>><?php echo $row_rs_pays['nom']; ?></option>


                  <?php

                }while($row_rs_pays = $query_rs_pays->fetch());
                      }

                   ?>

                 </select>
                 </div>
               </div>
                 <input type="submit" id='submit' name="inscription" value="S'INSCRIRE" >


                <?php


                if(isset($_POST['inscription']))
                    {
                      $idpays = $connexion->prepare("SELECT nom FROM pays WHERE id = '".$_POST['pays']."'");
                      $idpays->execute();
                      $pays = $idpays->fetch();

                        $Session = new Session();
                        $Session->setFlash('Les mots de passe sont différents','error');


                        /*email unique */
                        $req = $connexion->prepare("SELECT * FROM adminusers WHERE email=?");
                        $req->execute(array($_POST['mail']));
                        $resultat = $req->fetch();

                        $req2 = $connexion->prepare("SELECT * FROM moderateur WHERE email=?");
                        $req2->execute(array($_POST['mail']));
                        $resultat2 = $req2->fetch();

                        $req3 = $connexion->prepare("SELECT * FROM contributeur WHERE email=?");
                        $req3->execute(array($_POST['mail']));
                        $resultat3 = $req3->fetch();

                        $req4 = $connexion->prepare("SELECT * FROM users WHERE email=?");
                        $req4->execute(array($_POST['mail']));
                        $resultat4 = $req4->fetch();

                        /*regex mot de passe */
                        $uppercase = preg_match('@[A-Z]@', $_POST['password']);
                        $lowercase = preg_match('@[a-z]@', $_POST['password']);
                        $number = preg_match('@[0-9]@', $_POST['password']);
                        $symbol = preg_match('@[\W]@', $_POST['password']);

                        /*générateur de code de validation*/
                        $code = "";
                        for ($i=0; $i < 6 ; $i++) {
                          $code.=rand(0,9);
                        }
                        if($resultat == null ){
                          if($resultat2 == null ){
                            if($resultat3 == null ){
                              if($resultat4 == null ){
                                if($uppercase){
                                  if($lowercase){
                                    if($number){
                                      if($symbol){
                                        if(strlen($_POST['password']) > 8){
                                          if($_POST['password'] == $_POST['password2'])
                                          {
                                            $stmt = $connexion->prepare("INSERT INTO `users`(`id`, `nom`, `prenom`, `tel`, `email`, `passwords`, `adresse`, `cp`, `ville`, `pays`, `code`) VALUES (:id, :nom, :prenom, :tel, :mail, :pass_hash, :adresse, :cp, :ville, :pays, :code)");

                                            $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp

                                            $stmt -> bindParam(':id', $id);
                                            $stmt -> bindParam(':nom', $_POST['nom']);
                                            $stmt -> bindParam(':prenom', $_POST['prenom']);
                                            $stmt -> bindParam(':tel', $_POST['tel']);
                                            $stmt -> bindParam(':mail', $_POST['mail']);
                                            $stmt -> bindParam(':pass_hash', $pass_hash);
                                            $stmt -> bindParam(':adresse', $_POST['adresse']);
                                            $stmt -> bindParam(':cp', $_POST['cp']);
                                            $stmt -> bindParam(':ville', $_POST['ville']);
                                            $stmt -> bindParam(':pays', $pays['nom']);
                                            $stmt -> bindParam(':code', $code);
                                            $stmt->execute();

                                            $key = "stagededeuxiemeanneedebtssioaulyceedechartres";
                                            $text = $code;
                                            $cipher = "AES-256-CBC";


                                             $ivlen = openssl_cipher_iv_length($cipher);
                                             $iv = '1234567891011121';
                                            $crypter = openssl_encrypt($text, $cipher, $key, $options=0, $iv);

                                            $url = "codeinscription.php?code=".$crypter;
                                            echo "<script>setTimeout(function(){location.href='".$url."'}, 3000);</script>";


                                          $Session2 = new Session();
                                          $Session2->setFlash('Votre inscription est presque finie !', 'succes');
                                          $Session2->flash_success();

                                          exit();
                                        }else
                                          {
                                            $Session->flash_danger();
                                          }
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
                                }else
                                {
                                  $Session13 = new Session();
                                  $Session13->setFlash("Adresse mail déjà utilisée en tant qu'utilisateur",'error');
                                  $Session13->flash_danger();
                                }
                              }else
                              {
                                $Session12 = new Session();
                                $Session12->setFlash('Adresse mail déjà utilisée en tant que contributeur','error');
                                $Session12->flash_danger();
                              }
                            }else
                            {
                              $Session11 = new Session();
                              $Session11->setFlash('Adresse mail déjà utilisée en tant que modérateur','error');
                              $Session11->flash_danger();
                            }
                          }else
                          {
                            $Session3 = new Session();
                            $Session3->setFlash("Adresse mail déjà utilisée en tant qu'administrateur",'error');
                            $Session3->flash_danger();
                          }


                    }
                 ?>

            </form>
            </div>
          </div>
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
