
<!DOCTYPE HTML>
<html>
<head>
<title>Inscription des utlisateurs</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet">
</head>
<body>

  <!-- style formulaire -->
  <style>
  #inscription{
      width:500px;
      margin:0 auto;
      margin-top:4%;
  }
  #inscription h1{
      width: 38%;
      margin: 0 auto;
      padding-bottom: 10px;
  }

  #inscription input[type=text], input[type=tel], input[type=email], input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
  }

  #inscription input[type=submit] {
      background-color: orange;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
  }

  #inscription input[type=submit]:hover {
      background-color:#1b9bff;
      color: white;
      border: 1px solid orange;
  }

  </style>

<?php include("db.php");
require ("session.class.php");
if(isset($_GET['error'])){

  if(($_GET['error'] != NULL) && ($_GET['error']!='')){

  $req = $connexion->prepare("DELETE FROM users WHERE code=?");
  $req->execute(array($_GET['error']));
  }
  $Session10 = new Session();
  $Session10->setFlash("Votre inscription n'a pas pu être pris en compte",'error');
  $Session10->flash_danger();

}
?>

  <div id="inscription">
      <form action="" method="POST">
          <h1>Inscription</h1>

          <label><b>Nom</b></label>
          <input type="text" placeholder="Entrer votre nom" name="nom" required>

          <label><b>Prénom</b></label>
          <input type="text" placeholder="Entrer votre prénom" name="prenom" required>

          <label><b>Téléphone</b></label>
          <input type="tel" placeholder="Entrer votre numéro de téléphone" name="tel" required>

          <label><b>Adresse mail</b></label>
          <input type="email" placeholder="Entrer votre adresse mail" name="mail" required>

          <label><b>Mot de passe</b></label>
          <input type="password" placeholder="Entrer le mot de passe" name="password" required>

          <label><b>Confirmer votre Mot de passe</b></label>
          <input type="password" placeholder="Entrer le mot de passe" name="password2" required>

          <label><b>Adresse</b></label>
          <input type="text" placeholder="Entrer votre adresse" name="adresse" required>

          <label><b>Code postal</b></label>
          <input type="text" placeholder="Entrer votre code postal" name="cp" required>

          <label><b>Ville</b></label>
          <input type="text" placeholder="Entrer votre ville" name="ville" required>

          <label><b>Pays</b></label></br>
          <select id="pays" name="pays" required>

            <?php
              $query_rs_pays = $connexion->prepare("SELECT * FROM pays ORDER BY id ASC");
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

          </select>


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
                  $req = $connexion->prepare("SELECT * FROM users WHERE email=?");
                  $req->execute(array($_POST['mail']));
                  $resultat = $req->fetch();

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

                                  $url = "codeinscription.php?code=".$code;
                                  echo "<script>setTimeout(location.href='".$url."', 3000);</script>";
                                  /*
                                  header("Refresh:3; url=codeinscription.php?code=$code");*/

                                  $Session2 = new Session();
                                  $Session2->setFlash('Vous venez de vous inscrire !', 'succes');
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
                        $Session3 = new Session();
                        $Session3->setFlash('Adresse mail déjà utilisée','error');
                        $Session3->flash_danger();
                      }


              }
           ?>

      </form>
  </div>
</body>
