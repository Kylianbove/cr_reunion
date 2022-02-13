
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
      margin-top:10%;
  }
  #inscription h1{
      width: 80%;
      margin: 0 auto;
      padding-bottom: 30px;
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
          <h1>Identification</h1>

          <!--
          <label><b>Nom</b></label>
          <input type="text" placeholder="Entrer votre nom" name="nom" required>

          <label><b>Prénom</b></label>
          <input type="text" placeholder="Entrer votre prénom" name="prenom" required>
        -->
          <label><b>Adresse mail</b></label>
          <input type="email" placeholder="Entrer votre adresse mail" name="mail" required>

          <label><b>Mot de passe</b></label>
          <input type="password" placeholder="Entrer le mot de passe" name="password" required>


          <input type="submit" id='submit' name="inscription" value="S'INSCRIRE" >


          <?php


          if(isset($_POST['inscription']))
              {

                  include("db.php");
                  require ("session.class.php");
                  $Session = new Session();
                  $Session->setFlash("Cet utilisateur n'existe pas, vérifier vos informations",'error');


                  $query_rs_user = $connexion->prepare("SELECT * FROM users WHERE email=?");
                  $query_rs_user->execute(array($_POST['mail']));
                  $resultat = $query_rs_user->fetch();

                  // Comparaison du mdp envoyé via le formulaire avec la base
                  $isPasswordCorrect = password_verify($_POST['password'], $resultat['passwords']);

                  if ($resultat && $isPasswordCorrect)
                  {




                                  header("Refresh:3; url=index.php");

                                  $Session2 = new Session();
                                  $Session2->setFlash('Vous venez de vous inscrire pour faire des contributions!', 'succes');
                                  $Session2->flash_success();

                                  exit();
                  }else
                    {
                      $Session->flash_danger();
                    }



              }
           ?>

      </form>
  </div>
</body>
