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
  <script src="js/jscolor.js"></script>
</head>
<body>
<?php include('header.php'); ?>
<div class="container">
<?php include('nav.php'); ?>
<div class="row rowContent">
  <div class="col-sm-7 col-md-7 col-lg-9 colCentre">
    <div class="row">
      <?php
      if(!empty($users)){
      $query_rs_utiles = $connexion->prepare("SELECT * FROM users WHERE id=?");
      $query_rs_utiles->execute(array($users['id']));
      $row_rs_utiles = $query_rs_utiles->fetch();
      }
      if(!empty($administrateur)){
      $query_rs_utiles = $connexion->prepare("SELECT * FROM adminusers WHERE id_admin=?");
      $query_rs_utiles->execute(array($administrateur['id_admin']));
      $row_rs_utiles = $query_rs_utiles->fetch();
      }
      if(!empty($moderateur)){
      $query_rs_utiles = $connexion->prepare("SELECT * FROM moderateur WHERE id_mod=?");
      $query_rs_utiles->execute(array($moderateur['id_mod']));
      $row_rs_utiles = $query_rs_utiles->fetch();
      }
      if(!empty($contributeur)){
      $query_rs_utiles = $connexion->prepare("SELECT * FROM contributeur WHERE id_contri=?");
      $query_rs_utiles->execute(array($contributeur['id_contri']));
      $row_rs_utiles = $query_rs_utiles->fetch();
      }
      ?>

      <div class="col-sm-12">
        <h2><i class="fa-duotone fa-users iconTitle"></i> Mon Espace</h2>
       </div>

       <div class="col-sm-12" id="inscription">

      <form action="" method="POST" enctype="multipart/form-data">
                <div class="col-md-6">
                  <label><b>Nom</b></label>
                  <input type="text" placeholder="Entrer votre nom" name="nom" value="<?php echo $row_rs_utiles['nom']; ?>" required>

                  <label><b>Prénom</b></label>
                  <input type="text" placeholder="Entrer votre prénom" name="prenom" value="<?php echo $row_rs_utiles['prenom']; ?>" required>

                  <label><b>Téléphone</b></label>
                  <input type="tel" placeholder="Entrer votre numéro de téléphone" name="tel" value="<?php echo $row_rs_utiles['tel']; ?>" required>

                  <label><b>Adresse mail</b></label>
                  <input type="email" placeholder="Entrer votre adresse mail" name="email" value="<?php echo $row_rs_utiles['email']; ?>" readonly>

                  <label><b>Mot de passe</b></label>
                  <input type="password" placeholder="Entrer le mot de passe" name="password" value="<?php echo $row_rs_utiles['passwords']; ?>" required>


                </div>

                <div class="col-md-6">

                  <?php
                  if(!empty($users)){ ?>
                  <label><b>Adresse</b></label>
                  <input type="text" placeholder="Entrer votre adresse" name="adresse" value="<?php echo $row_rs_utiles['adresse']; ?>" required>

                  <label><b>Code postal</b></label>
                  <input type="text" placeholder="Entrer votre code postal" name="cp" value="<?php echo $row_rs_utiles['cp']; ?>" required>

                  <label><b>Ville</b></label>
                  <input type="text" placeholder="Entrer votre ville" name="ville" value="<?php echo $row_rs_utiles['ville']; ?>" required>

                  <div class="form-group2">
                  <label><b>Pays</b></label></br>
                  <select id="pays" name="pays" required>

                    <?php
                      $query_rs_pays = $connexion->prepare("SELECT * FROM pays WHERE nom = '".$row_rs_utiles['pays']."'");
                      $query_rs_pays->execute();
                      $row_rs_pays = $query_rs_pays->fetch();


                         if ($row_rs_pays > 0) {
                        do{

                    ?>

                   <option value="<?php echo $row_rs_pays['id']; ?>"><?php echo $row_rs_pays['nom']; ?></option>


                    <?php

                  }while($row_rs_pays = $query_rs_pays->fetch());
                        }

                     ?>
                     <?php
                       $query_rs_pays2 = $connexion->prepare("SELECT * FROM pays WHERE nom != '".$row_rs_utiles['pays']."'");
                       $query_rs_pays2->execute();
                       $row_rs_pays2 = $query_rs_pays2->fetch();


                          if ($row_rs_pays2 > 0) {
                         do{

                     ?>

                    <option value="<?php echo $row_rs_pays2['id']; ?>"><?php echo $row_rs_pays2['nom']; ?></option>


                     <?php

                   }while($row_rs_pays2 = $query_rs_pays2->fetch());
                         }

                      ?>

                 </select>
                 </div>

               <?php } ?>
                 <label for="fichier">Photo profil</label>
                 <input type="file" id="fichier" name="fichier"></br>
                 <?php if($row_rs_utiles['photo'] != null){ ?>
                 <img src="./admin/photo/<?php echo $row_rs_utiles['photo']; ?>" controls width='320px' height='200px' >
               <?php } ?>

               <label for="couleur">Couleur</label>
               <input type="text" class="form-control" id="couleur" name="couleur" value="<?php echo $row_rs_utiles['couleur']; ?>" data-jscolor="{preset:'small dark', position:'right'}" required>
               </div>
                 <input type="submit" id='submit' name="modifier" value="VALIDER LES MODIFICATIONS" >


                <?php


                if(isset($_POST['modifier']))
                    {
                      require ("session.class.php");
                      if(!empty($users)){
                        $idpays = $connexion->prepare("SELECT nom FROM pays WHERE id = '".$_POST['pays']."'");
                        $idpays->execute();
                        $pays = $idpays->fetch();
                      }


                      if($_POST['email'] != $row_rs_utiles['email']){
                        /*email unique */
                        $req = $connexion->prepare("SELECT * FROM adminusers WHERE email=?");
                        $req->execute(array($_POST['email']));
                        $resultat = $req->fetch();

                        $req2 = $connexion->prepare("SELECT * FROM moderateur WHERE email=?");
                        $req2->execute(array($_POST['email']));
                        $resultat2 = $req2->fetch();

                        $req3 = $connexion->prepare("SELECT * FROM contributeur WHERE email=?");
                        $req3->execute(array($_POST['email']));
                        $resultat3 = $req3->fetch();

                        $req4 = $connexion->prepare("SELECT * FROM users WHERE email=?");
                        $req4->execute(array($_POST['email']));
                        $resultat4 = $req4->fetch();
                      }else{
                        $resultat = null;
                        $resultat2 = null;
                        $resultat3 = null;
                        $resultat4 = null;
                      }

                        /*regex mot de passe */
                        $uppercase = preg_match('@[A-Z]@', $_POST['password']);
                        $lowercase = preg_match('@[a-z]@', $_POST['password']);
                        $number = preg_match('@[0-9]@', $_POST['password']);
                        $symbol = preg_match('@[\W]@', $_POST['password']);


                        if($resultat == null ){
                          if($resultat2 == null ){
                            if($resultat3 == null ){
                              if($resultat4 == null ){
                                if($uppercase){
                                  if($lowercase){
                                    if($number){
                                      if($symbol){
                                        if(strlen($_POST['password']) > 8){
                                          if($row_rs_utiles['photo'] != null){
                                            if($_POST['couleur'] != $row_rs_utiles['couleur']){
                                              if(!empty($users)){
                                                $updatephoto = $connexion->prepare("UPDATE users SET photo = NULL WHERE id='".$row_rs_utiles['id']."'");
                                              }
                                              if(!empty($administrateur)){
                                                $updatephoto = $connexion->prepare("UPDATE adminusers SET photo = NULL WHERE id_admin='".$row_rs_utiles['id_admin']."'");
                                              }
                                              if(!empty($moderateur)){
                                                $updatephoto = $connexion->prepare("UPDATE moderateur SET photo = NULL WHERE id_mod='".$row_rs_utiles['id_mod']."'");
                                              }
                                              if(!empty($contributeur)){
                                                $updatephoto = $connexion->prepare("UPDATE contributeur SET photo = NULL WHERE id_contri='".$row_rs_utiles['id_contri']."'");
                                              }
                                              $updatephoto->execute();
                                            }
                                          }
                                          if(!empty($_FILES['fichier']['name']))
                                          {
                                            $maxsize = 41943040; // 5Mo

                                            $name = $_FILES['fichier']['name'];
                                            $target_dir = "./admin/photo/";
                                            $target_file = $target_dir . $name;


                                            // Select file type
                                            $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                                            // Valid file extensions
                                            $extensions_arr = array("jpg","png","jpeg");

                                            // Check extension
                                            if(in_array($videoFileType,$extensions_arr)){

                                              // Check file size
                                              if(($_FILES['fichier']['size'] >= $maxsize || $_FILES["fichier"]["size"] == 0)) {
                                                $Session13 = new Session();
                                                $Session13->setFlash("Votre fichier doit faire moins de 5Mo ",'error');
                                                $Session13->flash_danger();

                                              }else{
                                                // Upload
                                                if(move_uploaded_file($_FILES['fichier']['tmp_name'],$target_file)){

                                                  if(!empty($users)){
                                                    $updateSQL = $connexion->prepare("UPDATE users SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, adresse=:adresse, cp=:cp, ville=:ville, pays=:pays, photo=:photo WHERE id='".$row_rs_utiles['id']."'");
                                                    if($_POST['password'] != $row_rs_utiles['passwords']){
                                                      $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                                    }else{
                                                      $pass_hash = $_POST['password'];
                                                    }
                                                    $updateSQL -> bindParam(':nom', $_POST['nom']);
                                                    $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                                    $updateSQL -> bindParam(':tel', $_POST['tel']);
                                                    $updateSQL -> bindParam(':email', $_POST['email']);
                                                    $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                                    $updateSQL -> bindParam(':adresse', $_POST['adresse']);
                                                    $updateSQL -> bindParam(':cp', $_POST['cp']);
                                                    $updateSQL -> bindParam(':ville', $_POST['ville']);
                                                    $updateSQL -> bindParam(':pays', $pays['nom']);
                                                    $updateSQL -> bindParam(':photo', $name);

                                                  }

                                                if(!empty($administrateur)){
                                                  $updateSQL = $connexion->prepare("UPDATE adminusers SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, photo=:photo WHERE id_admin='".$row_rs_utiles['id_admin']."'");
                                                  if($_POST['password'] != $row_rs_utiles['passwords']){
                                                    $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                                  }else{
                                                    $pass_hash = $_POST['password'];
                                                  }
                                                  $updateSQL -> bindParam(':nom', $_POST['nom']);
                                                  $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                                  $updateSQL -> bindParam(':tel', $_POST['tel']);
                                                  $updateSQL -> bindParam(':email', $_POST['email']);
                                                  $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                                  $updateSQL -> bindParam(':photo', $name);

                                                }

                                              if(!empty($moderateur)){
                                                $updateSQL = $connexion->prepare("UPDATE moderateur SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, photo=:photo WHERE id_mod='".$row_rs_utiles['id_mod']."'");
                                                if($_POST['password'] != $row_rs_utiles['passwords']){
                                                  $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                                }else{
                                                  $pass_hash = $_POST['password'];
                                                }
                                                $updateSQL -> bindParam(':nom', $_POST['nom']);
                                                $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                                $updateSQL -> bindParam(':tel', $_POST['tel']);
                                                $updateSQL -> bindParam(':email', $_POST['email']);
                                                $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                                $updateSQL -> bindParam(':photo', $name);

                                              }

                                            if(!empty($contributeur)){
                                              $updateSQL = $connexion->prepare("UPDATE contributeur SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, photo=:photo WHERE id_contri='".$row_rs_utiles['id_contri']."'");
                                              if($_POST['password'] != $row_rs_utiles['passwords']){
                                                $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                              }else{
                                                $pass_hash = $_POST['password'];
                                              }
                                              $updateSQL -> bindParam(':nom', $_POST['nom']);
                                              $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                              $updateSQL -> bindParam(':tel', $_POST['tel']);
                                              $updateSQL -> bindParam(':email', $_POST['email']);
                                              $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                              $updateSQL -> bindParam(':photo', $name);

                                            }

                                                  $updateSQL->execute();

                                                  $url = "index.php";
                                                  echo "<script>setTimeout(function(){location.href='".$url."'}, 3000);</script>";


                                                  $Session2 = new Session();
                                                  $Session2->setFlash('Vos modifications ont bien été enregistrées!', 'succes');
                                                  $Session2->flash_success();


                                                }
                                              }

                                              }else{
                                                $Session14 = new Session();
                                                $Session14->setFlash("Extension du fichier invalide ",'error');
                                                $Session14->flash_danger();
                                              }
                                            }else{
                                              if(!empty($users)){
                                                $updateSQL = $connexion->prepare("UPDATE users SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, adresse=:adresse, cp=:cp, ville=:ville, pays=:pays, couleur=:couleur WHERE id='".$row_rs_utiles['id']."'");
                                                if($_POST['password'] != $row_rs_utiles['passwords']){
                                                  $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                                }else{
                                                  $pass_hash = $_POST['password'];
                                                }
                                                $updateSQL -> bindParam(':nom', $_POST['nom']);
                                                $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                                $updateSQL -> bindParam(':tel', $_POST['tel']);
                                                $updateSQL -> bindParam(':email', $_POST['email']);
                                                $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                                $updateSQL -> bindParam(':adresse', $_POST['adresse']);
                                                $updateSQL -> bindParam(':cp', $_POST['cp']);
                                                $updateSQL -> bindParam(':ville', $_POST['ville']);
                                                $updateSQL -> bindParam(':pays', $pays['nom']);
                                                $updateSQL -> bindParam(':couleur', $_POST['couleur']);

                                              }

                                              if(!empty($administrateur)){
                                                $updateSQL = $connexion->prepare("UPDATE adminusers SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, couleur=:couleur WHERE id_admin='".$row_rs_utiles['id_admin']."'");
                                                if($_POST['password'] != $row_rs_utiles['passwords']){
                                                  $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                                }else{
                                                  $pass_hash = $_POST['password'];
                                                }
                                                $updateSQL -> bindParam(':nom', $_POST['nom']);
                                                $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                                $updateSQL -> bindParam(':tel', $_POST['tel']);
                                                $updateSQL -> bindParam(':email', $_POST['email']);
                                                $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                                $updateSQL -> bindParam(':couleur', $_POST['couleur']);

                                              }

                                              if(!empty($moderateur)){
                                                $updateSQL = $connexion->prepare("UPDATE moderateur SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, couleur=:couleur WHERE id_mod='".$row_rs_utiles['id_mod']."'");
                                                if($_POST['password'] != $row_rs_utiles['passwords']){
                                                  $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                                }else{
                                                  $pass_hash = $_POST['password'];
                                                }
                                                $updateSQL -> bindParam(':nom', $_POST['nom']);
                                                $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                                $updateSQL -> bindParam(':tel', $_POST['tel']);
                                                $updateSQL -> bindParam(':email', $_POST['email']);
                                                $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                                $updateSQL -> bindParam(':couleur', $_POST['couleur']);

                                              }

                                              if(!empty($contributeur)){
                                                $updateSQL = $connexion->prepare("UPDATE contributeur SET nom=:nom, prenom=:prenom, tel=:tel, email=:email, passwords=:pass_hash, couleur=:couleur WHERE id_contri='".$row_rs_utiles['id_contri']."'");
                                                if($_POST['password'] != $row_rs_utiles['passwords']){
                                                  $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp
                                                }else{
                                                  $pass_hash = $_POST['password'];
                                                }
                                                $updateSQL -> bindParam(':nom', $_POST['nom']);
                                                $updateSQL -> bindParam(':prenom', $_POST['prenom']);
                                                $updateSQL -> bindParam(':tel', $_POST['tel']);
                                                $updateSQL -> bindParam(':email', $_POST['email']);
                                                $updateSQL -> bindParam(':pass_hash', $pass_hash);
                                                $updateSQL -> bindParam(':couleur', $_POST['couleur']);

                                              }


                                              $updateSQL->execute();

                                              $url = "index.php";
                                              echo "<script>setTimeout(function(){location.href='".$url."'}, 3000);</script>";


                                              $Session2 = new Session();
                                              $Session2->setFlash('Vos modifications ont bien été enregistrées!', 'succes');
                                              $Session2->flash_success();

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
