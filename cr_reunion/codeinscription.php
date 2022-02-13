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

</head>
<body>
<?php include('header.php'); ?>
<div class="container">
<?php include('nav.php'); ?>
<?php $code = $_GET['code']; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<div class="row rowContent">
  <div class="col-sm-7 col-md-7 col-lg-9 colCentre">
    <div class="row">
      <style>
      .contenu input[type=text]{
          width: 50%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
      }
      .contenu input[type=submit] {
          background-color: orange;
          color: white;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          cursor: pointer;
          width: 50%;
      }

      .contenu input[type=submit]:hover {
          background-color:#1b9bff;
          color: white;
          border: 1px solid orange;
      }
      .contenu{
        margin:0 auto;
        margin-top:4%;
          width: 500px;
          text-align: center;

      }
      #error{
        display: none;
      }
      </style>

      <div class="contenu">
      <form action="" method="POST">


      <h1>Code de Vérification</h1>
      <a href="affichagecode.php?code=<?php echo $code;?>" target="_blank">voir le code</a>
    <!--Timer inscription -->
      <div id="timer">30</div>


        <script>

    var secon=30 ;//initialise les secondes
    var minu=0; //initialise les minutes


    function chrono(){
      if (secon != 0 || minu != 0)// si on n'atteind pas 00:00
        {

          secon--;
          if (secon<0)
            {
              secon=59;
              if (minu >0)
                {
                  minu--;
                }else{
                  minu=0;
                  }
            }
            if (secon < 10 )
          {
            secondes = '0'+secon;
          }else
           {
             secondes = secon;
           }
        if (minu < 10 )
         {
           minutes = '0'+minu;
         }else
          {
            minutes = minu;
          }


      var timer = document.getElementById('timer').innerHTML = minutes+' : '+secondes;
      compte=setTimeout('chrono()',1000) //la fonction est relancée tous les secondes
    }else{
      var url = "inscription.php?error="+<?php echo $code; ?>;


       window.document.location.href=url;


    }

    }
    chrono();

        /*
          var timerElt = document.getElementById('timer');
          var counter = 30;

          var timer = setInterval(function(){
            timerElt.innerHTML = counter;
            counter--;
            if(counter === 0){
              setTimeout(function(){
                timerElt.innerHTML = "Temps écoulé";
                clearInterval(timer);
              }, 1000);
            };
          }, 1000);
    */
        </script>
        <div id="contenu"></div>
        <script>
        $contenuHTML ='<input type="text" placeholder="_ _ _ _ _ _" name="code" id="name" required><input type="submit" id="valider" name="validation" value="VALIDER" ><div id="error">Délais dépassé...</div>';
        $("#contenu").html($contenuHTML);
      </script>

        <noscript>
          Javascript doit être activé
        </noscript>

        <?php


          if(isset($_POST['validation']))
              {

                  include("db.php");
                  require ("session.class.php");
                  $Session = new Session();
                  $Session->setFlash('code incorrect','error');

                  $stmt = $connexion->prepare("SELECT code FROM users WHERE code=?");
                  $stmt->execute(array($code));
                  $resultat = $stmt->fetch();
                  if($_POST['code'] == $resultat['code'])
                  {


                      $stmt = $connexion->prepare("UPDATE users SET code = NULL WHERE code=:code");

                      $stmt -> bindParam(':code', $code);
                      $stmt->execute();
                      $url = "index.php";
                      echo "<script>setTimeout(function(){location.href='".$url."'}, 10000);</script>";

                      $Session2 = new Session();
                      $Session2->setFlash("Vous venez de vous inscrire, votre compte sera validé par un administrateur, vous recevrez un email vous confirmant l'acceptation de votre compte. Vous pourrez dès lors vous connecter à votre compte et profiter des contenus du site.", 'succes');
                      $Session2->flash_success();
                     exit;

                  }else
                      {
                          $Session->flash_danger();
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
