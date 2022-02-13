<!DOCTYPE HTML>
<html>
<head>
<title>Inscription des contributeurs</title>
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
      width: 100%;
      margin: 0 auto;
      padding-bottom: 20px;
  }

  input[type=text], input[type=tel], input[type=email], input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
  }

  input[type=submit] {
      background-color: orange;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
  }

  input[type=submit]:hover {
      background-color:#1b9bff;
      color: white;
      border: 1px solid orange;
  }

  </style>


  <div id="inscription">
      <form action="" method="POST">
          <h1>Inscription Contributeur</h1>

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

          <input type="submit" id='submit' name="inscription" value="S'INSCRIRE" >



          <?php


          if(isset($_POST['inscription']))
              {

                  include("db.php");
                  require ("session.class.php");
                  $Session = new Session();
                  $Session->setFlash('Les mots de passe sont différents','error');


                  /*email unique */
                  $req = $connexion->prepare("SELECT * FROM contributeur WHERE email=?");
                  $req->execute(array($_POST['mail']));
                  $resultat = $req->fetch();

                  /*regex mot de passe */
                  $uppercase = preg_match('@[A-Z]@', $_POST['password']);
                  $lowercase = preg_match('@[a-z]@', $_POST['password']);
                  $number = preg_match('@[0-9]@', $_POST['password']);
                  $symbol = preg_match('@[\W]@', $_POST['password']);


                  if($resultat == null ){
                    if($uppercase){
                      if($lowercase){
                        if($number){
                          if($symbol){
                            if(strlen($_POST['password']) > 8){
                              if($_POST['password'] == $_POST['password2'])
                              {
                                  $stmt = $connexion->prepare("INSERT INTO `contributeur`(`id_contri`, `nom`, `prenom`, `tel`, `email`, `passwords`) VALUES (:id, :nom, :prenom, :tel, :mail, :pass_hash)");

                                  $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash mdp

                                  $stmt -> bindParam(':id', $id);
                                  $stmt -> bindParam(':nom', $_POST['nom']);
                                  $stmt -> bindParam(':prenom', $_POST['prenom']);
                                  $stmt -> bindParam(':tel', $_POST['tel']);
                                  $stmt -> bindParam(':mail', $_POST['mail']);
                                  $stmt -> bindParam(':pass_hash', $pass_hash);

                                  $stmt->execute();


                                  header("Refresh:3; url=index.php");

                                  $Session2 = new Session();
                                  $Session2->setFlash("Vous venez de vous inscrire en tant que contributeur !", 'succes');
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
