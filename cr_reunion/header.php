<?php   include("db.php");
if(session_status() == PHP_SESSION_NONE){

  session_start();

  //On génére un jeton totalement unique (c'est capital :D)
$token = uniqid(rand(), true);
//Et on le stocke
$_SESSION['token'] = $token;
//On enregistre aussi le timestamp correspondant au moment de la création du token
$_SESSION['token_time'] = time();





}

   ?>

<style>
    header h1{
    background-image: url('img/logo.png');
    background-repeat: no-repeat;
    background-position: 0 0;
    }
</style>
<header>
    <div class="container">
        <div class="row">
            <div class="col-xs-4">
                <h1>Mon Espace Salarié - Accueil</h1>
            </div>
            <div class="col-xs-8">
                <?php if(isset($_SESSION['Username'])){ ?>
                <div class="connexion">
                    <div class="connecte">
                      <?php


                      $selectadmin = $connexion->prepare("SELECT * FROM adminusers WHERE email=?");
                      $selectadmin->execute(array($_SESSION['Username']));
                      $administrateur = $selectadmin->fetch();

                      $selectmod = $connexion->prepare("SELECT * FROM moderateur WHERE actif =1 AND email=?");
                      $selectmod->execute(array($_SESSION['Username']));
                      $moderateur = $selectmod->fetch();

                      $selectcontri = $connexion->prepare("SELECT * FROM contributeur WHERE actif =1 AND email=?");
                      $selectcontri->execute(array($_SESSION['Username']));
                      $contributeur = $selectcontri->fetch();

                      $selectusers = $connexion->prepare("SELECT * FROM users WHERE actif =1 AND email=?");
      								$selectusers->execute(array($_SESSION['Username']));
      								$users = $selectusers->fetch();


                      if($users != null){
                      $usersphoto = $connexion->prepare("SELECT * FROM users WHERE photo = '".$users['photo']."'");
                      $usersphoto->execute();
                      $photoprofil = $usersphoto->fetch();

                      $updatdetoken = $connexion->prepare("UPDATE users SET token = ? WHERE email = ?");

                      if($photoprofil == null){
                       ?>
                        <div class="bulle" style="background-color:<?php echo $users['couleur']; ?>"><?php echo $users['prenom'][0]." ".$users['nom'][0]; ?></div>
                        <?php
          								}else
          								{ ?>
                            <img src="./admin/photo/<?php echo $users['photo']; ?>" class="bulle">
                          <?php } ?>
                        <div class="identite">
                            <h3><?php echo $users['prenom']." ".$users['nom']; ?></h3>
                            <a href="mon_espace.php">Mon Espace</a>
                        </div>
                      <?php } ?>

                      <?php
                      if($administrateur != null){
                      $adminphoto = $connexion->prepare("SELECT * FROM adminusers WHERE photo = '".$administrateur['photo']."'");
                      $adminphoto->execute();
                      $photoprofil = $adminphoto->fetch();

                      $updatdetoken = $connexion->prepare("UPDATE adminusers SET token = ? WHERE email = ?");

                      if($photoprofil == null){
                       ?>
                        <div class="bulle" style="background-color:<?php echo $administrateur['couleur']; ?>"><?php echo $administrateur['prenom'][0]." ".$administrateur['nom'][0]; ?></div>
                        <?php
          								}else
          								{ ?>
                            <img src="./admin/photo/<?php echo $administrateur['photo']; ?>" class="bulle">
                          <?php } ?>
                        <div class="identite">
                            <h3><?php echo $administrateur['prenom']." ".$administrateur['nom']; ?></h3>
                            <a href="mon_espace.php">Mon Espace</a>
                        </div>
                      <?php } ?>

                      <?php
                      if($moderateur != null){
                      $adminphoto = $connexion->prepare("SELECT * FROM moderateur WHERE photo = '".$moderateur['photo']."'");
                      $adminphoto->execute();
                      $photoprofil = $adminphoto->fetch();

                      $updatdetoken = $connexion->prepare("UPDATE moderateur SET token = ? WHERE email = ?");

                      if($photoprofil == null){
                       ?>
                        <div class="bulle" style="background-color:<?php echo $moderateur['couleur']; ?>"><?php echo $moderateur['prenom'][0]." ".$moderateur['nom'][0]; ?></div>
                        <?php
          								}else
          								{ ?>
                            <img src="./admin/photo/<?php echo $moderateur['photo']; ?>" class="bulle">
                          <?php } ?>
                        <div class="identite">
                            <h3><?php echo $moderateur['prenom']." ".$moderateur['nom']; ?></h3>
                            <a href="mon_espace.php">Mon Espace</a>
                        </div>
                      <?php } ?>

                      <?php
                      if($contributeur != null){
                      $contriphoto = $connexion->prepare("SELECT * FROM contributeur WHERE photo = '".$contributeur['photo']."'");
                      $contriphoto->execute();
                      $photoprofil = $contriphoto->fetch();

                      $updatdetoken = $connexion->prepare("UPDATE contributeur SET token = ? WHERE email = ?");

                      if($photoprofil == null){
                       ?>
                        <div class="bulle" style="background-color:<?php echo $contributeur['couleur']; ?>"><?php echo $contributeur['prenom'][0]." ".$contributeur['nom'][0]; ?></div>
                        <?php
          								}else
          								{ ?>
                            <img src="./admin/photo/<?php echo $contributeur['photo']; ?>" class="bulle">
                          <?php } ?>
                        <div class="identite">
                            <h3><?php echo $contributeur['prenom']." ".$contributeur['nom']; ?></h3>
                            <a href="mon_espace.php">Mon Espace</a>
                        </div>
                      <?php } ?>
                      <?php
                      $updatdetoken->execute([$_SESSION['token'], $_SESSION['Username']]);
                      ?>
                        <div class="deconnect">
                            <a href="deconnexion.php" title="Se déconnecter"><i class="fa-solid fa-power-off"></i></a>
                        </div>

                    </div>
                </div>
                <?php }else{  ?>
                    <div class="connexion">
                        <div class="connecte">


                            <i class="fa-duotone fa-users iconTitle"></i>
                            <div class="identite">
                            <h3>Espace&nbsp;membre</h3>
                            <a href="inscription.php">S'inscrire</a>
                            <a href="#" class="openSlide">S'identifier</a>
                            </div>

                        </div>

                        <div class="menuConnect">
                                <form action="" id="connectedForm" name="connectedForm" method="POST">
                                <div class="formField">
                                <label for="login">identifiant</label>
                                <input type="text" name="login" id="login" class="champs">
                                </div>
                                <div class="formField">
                                <label for="mdp">Mot de passe</label>
                                <input type="password" name="mdp" id="mdp" class="champs">
                                <a href="forgot_password.php">Mot de passe oublié ?</a>
                                </div>

                                <input type="submit" class="bouton" value="M'identifier" name="identifier">

                                <?php
                                if(isset($_POST['identifier']))
                                    {
                                      if (!isset($_SESSION)) {
                                        session_start();
                                      }
                                      $admin = $connexion->prepare("SELECT * FROM adminusers WHERE email=?");
                                      $admin->execute(array($_POST['login']));
                                      $login_admin = $admin->fetch();

                                      $modo = $connexion->prepare("SELECT * FROM moderateur WHERE actif =1 AND email=?");
                                      $modo->execute(array($_POST['login']));
                                      $login_modo = $modo->fetch();

                                      $conti = $connexion->prepare("SELECT * FROM contributeur WHERE actif =1 AND email=?");
                                      $conti->execute(array($_POST['login']));
                                      $login_contri = $conti->fetch();

                                      $query_rs_user = $connexion->prepare("SELECT * FROM users WHERE actif =1 AND email=?");
                                      $query_rs_user->execute(array($_POST['login']));
                                      $login_users = $query_rs_user->fetch();

                                      if($login_users == null && $login_admin == null && $login_modo == null && $login_contri == null){
                                        require ("session.class.php");

                                        $Session = new Session();
                                        $Session->setFlash('Identifiant ou mot de passe incorrect!', 'error');
                                        $Session->flash_danger();
                                      }

                                      if($login_users != null){
                                        // Comparaison du mdp envoyé via le formulaire avec la base
                                        $isPasswordCorrect = password_verify($_POST['mdp'], $login_users['passwords']);


                                        if ($login_users && $isPasswordCorrect)
                                        {
                                              $_SESSION['Username'] = $_POST['login'];
                                              $_SESSION['PrevUrl'] = '/cr_reunion/index.php';

                                              $url = "index.php";
                                              echo "<script>window.location.href='".$url."';</script>";




                                        }else
                                          {

                                            require ("session.class.php");

                                            $Session = new Session();
                                            $Session->setFlash('Identifiant ou mot de passe incorrect!', 'error');
                                            $Session->flash_danger();

                                          }
                                        }

                                        if($login_admin != null){
                                          // Comparaison du mdp envoyé via le formulaire avec la base
                                          $isPasswordCorrect = password_verify($_POST['mdp'], $login_admin['passwords']);


                                          if ($login_admin && $isPasswordCorrect)
                                          {
                                                $_SESSION['Username'] = $_POST['login'];
                                                $_SESSION['PrevUrl'] = '/cr_reunion/index.php';

                                                $url = "index.php";
                                                echo "<script>window.location.href='".$url."';</script>";




                                          }else
                                            {

                                              require ("session.class.php");

                                              $Session = new Session();
                                              $Session->setFlash('Identifiant ou mot de passe incorrect!', 'error');
                                              $Session->flash_danger();

                                            }
                                          }

                                          if($login_modo != null){
                                            // Comparaison du mdp envoyé via le formulaire avec la base
                                            $isPasswordCorrect = password_verify($_POST['mdp'], $login_modo['passwords']);


                                            if ($login_modo && $isPasswordCorrect)
                                            {
                                                  $_SESSION['Username'] = $_POST['login'];
                                                  $_SESSION['PrevUrl'] = '/cr_reunion/index.php';

                                                  $url = "index.php";
                                                  echo "<script>window.location.href='".$url."';</script>";




                                            }else
                                              {

                                                require ("session.class.php");

                                                $Session = new Session();
                                                $Session->setFlash('Identifiant ou mot de passe incorrect!', 'error');
                                                $Session->flash_danger();

                                              }
                                            }

                                            if($login_contri != null){
                                              // Comparaison du mdp envoyé via le formulaire avec la base
                                              $isPasswordCorrect = password_verify($_POST['mdp'], $login_contri['passwords']);


                                              if ($login_contri && $isPasswordCorrect)
                                              {
                                                    $_SESSION['Username'] = $_POST['login'];
                                                    $_SESSION['PrevUrl'] = '/cr_reunion/index.php';

                                                    $url = "index.php";
                                                    echo "<script>window.location.href='".$url."';</script>";




                                              }else
                                                {

                                                  require ("session.class.php");

                                                  $Session = new Session();
                                                  $Session->setFlash('Identifiant ou mot de passe incorrect!', 'error');
                                                  $Session->flash_danger();

                                                }
                                              }


                                    }
                                 ?>

                                </form>
                            </div>
                    </div>

                <?php } ?>

        </div>
    </div>
</header>
