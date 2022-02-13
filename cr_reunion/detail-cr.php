<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mon Espace Salarié - Réunions - Titre Compte-Rendu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <link rel="stylesheet" href="fa/fa6/css/all.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/gen.css">
  <link rel="stylesheet" href="css/monthly.css">
  <link rel="stylesheet" href="player/dist/skin/blue.monday/css/jplayer.blue.monday.min.css">
  <link rel="stylesheet" href="css/site.css">
  <meta http-equiv="refresh" content="60">
</head>
<body>
<?php include('header.php');
if(!empty($_SESSION['Username'])){
$id = $_GET['param']; }?>

<div class="container">
<?php include('nav.php'); ?>
<div class="row rowContent">
  <div class="col-sm-7 col-md-7 col-lg-9 colCentre">
    <?php

    if(!empty($contributeur) || !empty($moderateur) || !empty($administrateur) || !empty($users)){
      if($users['typeUser'] != 1){

    ?>
        <div class="row">
            <div class="col-sm-12">
              <?php
              $selectcr = $connexion->prepare("SELECT *, DATE_FORMAT(date_publication, \"%d/%m/%Y\") as date_publi FROM compte_rendu WHERE publier = 1 AND valider = 1 AND id_cr = '".$id."' ORDER BY date_publication DESC");
              $selectcr->execute();
              $compte_rendu = $selectcr->fetch();

                ?>
                <h2><i class="fa-duotone fa-handshake-simple"></i><?php echo $compte_rendu['titre']; ?></h2>
                <div class="actuLanceur detailArticle">
                    <p class="date">Réunion du <?php echo $compte_rendu['date_publi']; ?></p>
                    <div class="accrocheArt">

                        <?php echo $compte_rendu['accroche']; ?>
                    </div>
                    <div class="contentArt">
                        <div class="row">
                          <?php
                          $selectimg = $connexion->prepare("SELECT * FROM cr_image WHERE publier = 1 AND id_cr = '".$id."'");
                          $selectimg->execute();
                          $image = $selectimg->fetch();
                          if($image != null){
                          ?>
                            <div class="col-sm-7"><!-- Si pas d'images col-sm-12 -->

                                <?php echo $compte_rendu['texte']; ?>
                            </div>

                            <div class="col-sm-5 illustrations"><!-- Afficher si images existantes -->
                              <?php
                              do{
                                ?>
                                <img src="./admin/cr_fichiers/images/<?php echo $image['fichier']; ?>" alt="">
                              <?php }while($image = $selectimg->fetch());?>
                            </div>


                          <?php }else{
                              ?>
                            <div class="col-sm-12">
                              <?php echo $compte_rendu['texte']; ?>
                            </div>

                        <?php  } ?>

                    </div>

                    <?php
                    $selectvideo2 = $connexion->prepare("SELECT * FROM cr_video WHERE publier = 1 AND id_cr = '".$id."' ORDER BY id_video ASC");
                    $selectvideo2->execute();
                    $videos2 = $selectvideo2->fetch();

                    if($videos2 != null){
                    ?>
                    <div class="row">
                    <div class="col-12">
                              <!-- Video Player -->
                                <div id="jp_container_1" class="jp-video jp-video-270p" role="application" aria-label="media player">
                                    <div class="jp-type-playlist">
                                        <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                                        <div class="jp-gui">
                                            <div class="jp-video-play">
                                                <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                                            </div>
                                            <div class="jp-interface">
                                                <div class="jp-progress">
                                                    <div class="jp-seek-bar">
                                                        <div class="jp-play-bar"></div>
                                                    </div>
                                                </div>
                                                <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                                <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                                <div class="jp-controls-holder">
                                                    <div class="jp-controls">
                                                        <button class="jp-previous" role="button" tabindex="0">previous</button>
                                                        <button class="jp-play" role="button" tabindex="0">play</button>
                                                        <button class="jp-next" role="button" tabindex="0">next</button>
                                                        <button class="jp-stop" role="button" tabindex="0">stop</button>
                                                    </div>
                                                    <div class="jp-volume-controls">
                                                        <button class="jp-mute" role="button" tabindex="0">mute</button>
                                                        <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                                        <div class="jp-volume-bar">
                                                            <div class="jp-volume-bar-value"></div>
                                                        </div>
                                                    </div>
                                                    <div class="jp-toggles">
                                                        <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                                        <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                                                        <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                                    </div>
                                                </div>
                                                <div class="jp-details">
                                                    <div class="jp-title" aria-label="title">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="jp-playlist">
                                            <ul>
                                                <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                                                <li>&nbsp;</li>
                                            </ul>
                                        </div>
                                        <div class="jp-no-solution">
                                            <span>Update Required</span>
                                            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
      <?php }}else{
        require ("session.class.php");

        $Session8 = new Session();
        $Session8->setFlash("vous n'avez pas les droits d'utilisateurs nécessaire pour accéder à cette page!",'error');
        $Session8->flash_danger();



      } ?>
    </div>


    <div class="col-sm-5 col-md-5 col-lg-3 colDroite">

        <div class="droiteContent">
          <?php

          if(!empty($contributeur) || !empty($moderateur) || !empty($administrateur) || !empty($users)){
            if($users['typeUser'] != 1){

          ?>
          <?php
           if(isset($_SESSION['Username'])){
            $i = 0;
            if(isset($users)){

              if($users['typeUser'] == 2){
                $i = 2;
              }
            }
            if($i != 2){

          $selectpiecejointe = $connexion->prepare("SELECT * FROM cr_piecesjointes WHERE publier = 1 AND id_cr = '".$id."' ORDER BY id_piecejointe ASC");
          $selectpiecejointe->execute();
          $piecejointe = $selectpiecejointe->fetch();

          if($piecejointe != null){
          ?>
            <h4><i class="fa-duotone fa-download"></i> A télécharger</h4>
            <ul class="downloads">
              <?php
              do{
                if(isset($_SESSION['token']) && isset($_SESSION['token_time']))
                {



                  if(!empty($administrateur)){
                    $selecttoken = $connexion->prepare("SELECT * FROM adminusers WHERE token=?");
                  }
                  if(!empty($moderateur)){
                    $selecttoken = $connexion->prepare("SELECT * FROM moderateur WHERE actif =1 AND token=?");
                  }
                  $selecttoken = $connexion->prepare("SELECT * FROM contributeur WHERE actif =1 AND token=?");
                  if(!empty($contributeur)){
                    $selecttoken = $connexion->prepare("SELECT * FROM users WHERE actif =1 AND token=?");
                  }
                  $selecttoken->execute(array($_SESSION['token']));
                  $utilisateur = $selecttoken->fetch();


                  if(isset($utilisateur)){

                    $file = "./admin/cr_fichiers/piecesjointes/".$piecejointe['fichier'];

                    if(pathinfo($piecejointe['fichier'], PATHINFO_EXTENSION) == "pdf"){ ?>

                      <li><a href="./ouvrirfichier.php?dwn=<?php echo $file;  ?>&amp;token=<?php echo $token; ?>"><i class="fa-duotone fa-file-pdf"></i><span><?php echo $piecejointe['fichier']; ?></span></a></li>
                    <?php } ?>
                    <?php

                    if(pathinfo($piecejointe['fichier'], PATHINFO_EXTENSION) == "docx" || pathinfo($piecejointe['fichier'], PATHINFO_EXTENSION) == "doc"){ ?>
                      <li><a href="./ouvrirfichier.php?dwn=<?php echo $file;  ?>&amp;token=<?php echo $token; ?>"><i class="fa-duotone fa-file-word"></i><span><?php echo $piecejointe['fichier']; ?></span></a></li>
                    <?php } ?>
                    <?php

                    if(pathinfo($piecejointe['fichier'], PATHINFO_EXTENSION) == "xls" || pathinfo($piecejointe['fichier'], PATHINFO_EXTENSION) == "xlsx" ){ ?>
                      <li><a href="./ouvrirfichier.php?dwn=<?php echo $file;  ?>&amp;token=<?php echo $token; ?>"><i class="fa-duotone fa-file-excel"></i><span><?php echo $piecejointe['fichier']; ?></span></a></li>
                    <?php } ?>
                  <?php }}}while($piecejointe = $selectpiecejointe->fetch()); ?>
                </ul>
              <?php }}} ?>


            <?php
            $selectaudio = $connexion->prepare("SELECT * FROM cr_audio WHERE publier = 1 AND id_cr = '".$id."' ORDER BY id_audio ASC");
            $selectaudio->execute();
            $audio = $selectaudio->fetch();

            if($audio != null){
            ?>

            <h4><i class="fa-duotone fa-ear-listen"></i> A écouter</h4>
            <div id="jquery_jplayer_2" class="jp-jplayer"></div>
                <div id="jp_container_2" class="jp-audio" role="application" aria-label="media player">
                    <div class="jp-type-playlist">
                        <div class="jp-gui jp-interface">
                            <div class="jp-controls">
                                <button class="jp-previous" role="button" tabindex="0">previous</button>
                                <button class="jp-play" role="button" tabindex="0">play</button>
                                <button class="jp-next" role="button" tabindex="0">next</button>
                                <button class="jp-stop" role="button" tabindex="0">stop</button>
                            </div>
                            <div class="jp-progress">
                                <div class="jp-seek-bar">
                                    <div class="jp-play-bar"></div>
                                </div>
                            </div>
                            <div class="jp-volume-controls">
                                <button class="jp-mute" role="button" tabindex="0">mute</button>
                                <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                <div class="jp-volume-bar">
                                    <div class="jp-volume-bar-value"></div>
                                </div>
                            </div>
                            <div class="jp-time-holder">
                                <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                            </div>
                            <div class="jp-toggles">
                                <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                            </div>
                        </div>
                        <div class="jp-playlist">
                            <ul>
                                <li>&nbsp;</li>
                            </ul>
                        </div>
                        <div class="jp-no-solution">
                            <span>Update Required</span>
                            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                    </div>
                </div>
                  <?php } ?>

                  <?php }} ?>
        </div>

        <a href="liste-cr.php" class="linkBar">Accédez aux CR de réunions</a>

        <a href="contribution.php" class="linkBar">Laissez une contribution</a>

        <a href="contact.php" class="linkBar">Contactez-nous</a>

    </div>

</div>

<script src="js/jquery.js"></script>
<script src="js/monthly-1.0.0.js"></script>
<script src="js/site.js"></script>
<script src="player/dist/jplayer/jquery.jplayer.min.js"></script>
<script src="player/dist/add-on/jplayer.playlist.min.js"></script>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){

	new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#jp_container_1"
	}, [
    <?php
		$selectvideo = $connexion->prepare("SELECT * FROM cr_video WHERE publier = 1 AND id_cr = '".$id."' ORDER BY id_video ASC");
		$selectvideo->execute();
		$videos = $selectvideo->fetch();

		do{
		?>
		{
			title:"<?php echo $videos['titre']; ?>",
			free:true,
			m4v:"./admin/cr_fichiers/videos/<?php echo $videos['fichier']; ?>"
		}, <?php }while($videos = $selectvideo->fetch()); ?>
	], {
		swfPath: "player/dist/jplayer",
		supplied: "m4v",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true
	});

	new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_2",
		cssSelectorAncestor: "#jp_container_2"
	}, [
    <?php
		$selectaudio2 = $connexion->prepare("SELECT * FROM cr_audio WHERE publier = 1 AND id_cr = '".$id."' ORDER BY id_audio ASC");
		$selectaudio2->execute();
		$audio2 = $selectaudio2->fetch();

		do{
		?>
		{
			title:"<?php echo $audio2['titre']; ?>",
			mp3:"./admin/cr_fichiers/audios/<?php echo $audio2['fichier']; ?>"
		}, <?php }while($audio2 = $selectaudio2->fetch()); ?>

	], {
		swfPath: "player/dist/jplayer",
		supplied: "mp3",
		wmode: "window",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true
	});
});
//]]>
</script>

</body>
</html>
