<div class="sidebar-menu">
					<header class="logo">
					<a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="index.php"> <span id="logo"> <h1><small>MES</small></h1></span>
					<!--<img id="logo" src="" alt="Logo"/>-->
				  </a>
				</header>
			<div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
			<!--/down-->
							<div class="down">

								<style>
								.cerclemenu{
									border: 1px solid black;
									border-radius: 50px;
									width: 80px;
									height: 80px;
									text-align:center;
									line-height:80px;
									font-size: 30px;
									margin: auto;
									color: white;
									background-color: black;


								}
								</style>
								<?php
								$query_rs_admin = $connexion->prepare("SELECT * FROM adminusers WHERE email=?");
								$query_rs_admin->execute(array($_SESSION['MM_UsernameADM']));
								$resultat = $query_rs_admin->fetch();

								$query_rs_mod = $connexion->prepare("SELECT * FROM moderateur WHERE email=?");
								$query_rs_mod->execute(array($_SESSION['MM_UsernameADM']));
								$moderateur = $query_rs_mod->fetch();

								$query_rs_contri = $connexion->prepare("SELECT * FROM contributeur WHERE email=?");
								$query_rs_contri->execute(array($_SESSION['MM_UsernameADM']));
								$contributeur = $query_rs_contri->fetch();



								if($resultat != null){
								$usersphoto = $connexion->prepare("SELECT * FROM adminusers WHERE photo = '".$resultat['photo']."'");
								$usersphoto->execute();
								$photoprofil = $usersphoto->fetch();

								if($photoprofil == null){
								?>
								<a href="index.php"><div class="cerclemenu" style="background-color:<?php echo $resultat['couleur']; ?>"><?php echo $resultat['prenom'][0];?><?php echo " ".$resultat['nom'][0]; ?>  </div></a>
							<?php
								}else
								{ ?>
									<a href="index.php"><img src="./photo/<?php echo $resultat['photo']; ?>" class="cerclemenu"></a>
							<?php } ?>
										<!--
									  <a href="index.php"><img src="images/admin.jpg"></a> -->
									  <!--<a href="index.php"><span class=" name-caret">
										</span></a>
									 -->
								 </br>
									 <?php echo $resultat['prenom'].' '.$resultat['nom']; ?>
									 <p>Administrateur</p>
								 <?php } ?>


								 <?php
								 if($moderateur != null){
 								$usersphoto = $connexion->prepare("SELECT * FROM moderateur WHERE photo = '".$moderateur['photo']."'");
 								$usersphoto->execute();
 								$photoprofil = $usersphoto->fetch();

 								if($photoprofil == null){
 								?>
 								<a href="index.php"><div class="cerclemenu" style="background-color:<?php echo $moderateur['couleur']; ?>"><?php echo $moderateur['prenom'][0];?><?php echo " ".$moderateur['nom'][0]; ?>  </div></a>
 							<?php
 								}else
 								{ ?>
 									<a href="index.php"><img src="./photo/<?php echo $moderateur['photo']; ?>" class="cerclemenu"></a>
 							<?php } ?>
 										<!--
 									  <a href="index.php"><img src="images/admin.jpg"></a> -->
 									  <!--<a href="index.php"><span class=" name-caret">
 										</span></a>
 									 -->
 								 </br>
 									 <?php echo $moderateur['prenom'].' '.$moderateur['nom']; ?>
 									 <p>Modérateur</p>
 								 <?php } ?>


								 <?php
								if($contributeur != null){
								 $usersphoto = $connexion->prepare("SELECT * FROM contributeur WHERE photo = '".$contributeur['photo']."'");
								 $usersphoto->execute();
								 $photoprofil = $usersphoto->fetch();

								 if($photoprofil == null){
								 ?>
								 <a href="index.php"><div class="cerclemenu" style="background-color:<?php echo $contributeur['couleur']; ?>"><?php echo $contributeur['prenom'][0];?><?php echo " ".$contributeur['nom'][0]; ?>  </div></a>
							 <?php
								 }else
								 { ?>
									 <a href="index.php"><img src="./photo/<?php echo $contributeur['photo']; ?>" class="cerclemenu"></a>
							 <?php } ?>
										 <!--
										 <a href="index.php"><img src="images/admin.jpg"></a> -->
										 <!--<a href="index.php"><span class=" name-caret">
										 </span></a>
										-->
									</br>
										<?php echo $contributeur['prenom'].' '.$contributeur['nom']; ?>
										<p>Contributeur</p>
									<?php } ?>


									<ul>

										<li><a class="tooltips" href="<?php echo $logoutAction; ?>"><span>Déconnexion</span><i class="lnr lnr-power-switch"></i></a></li>
										</ul>
									</div>
							   <!--//down-->
							   <?php /*if(($row_rs_admin['typeUser']==1)||($row_rs_admin['typeUser']==3)){ */ ?>
                           <div class="menu">
									<ul id="menu" >
										<!--<li><a href="index.php"><i class="fa fa-tachometer"></i> <span>Accueil</span></a></li>-->
										<?php if($resultat !=null){ ?>
										<li><a href="utiles.php"><i class="fa fa-table"></i> <span> Informations utiles</span></a></li>
									<?php } ?>


									<?php if($resultat !=null){ ?>
									 <li id="menu-academico" ><a href="#"><i class="fa fa-tachometer"></i> <span>Gestion Utilisateurs</span> <span class="fa fa-angle-right" style="float: right"></span></a>
									 	<?php


											?>
										 <ul id="menu-academico-sub" >
											 <li id="menu-academico-avaliacoes" ><a href="adminusers.php">Administrateurs</a></li>
											 <li id="menu-academico-avaliacoes" ><a href="moderateurs.php">Modérateurs</a></li>
											 <li id="menu-academico-avaliacoes" ><a href="contributeur.php">Contributeurs</a></li>
											 <li id="menu-academico-avaliacoes" ><a href="users.php">Utilisateurs</a></li>
										 </ul>
									 </li>
									 	<?php } ?>


									 <li id="menu-academico" ><a href="#"><i class="lnr lnr-book"></i> <span>Gestion Actualités</span> <span class="fa fa-angle-right" style="float: right"></span></a>
										 <ul id="menu-academico-sub" >
											 <li id="menu-academico-avaliacoes" ><a href="actualite.php">Actualités</a></li>
											 <?php if($resultat !=null || $moderateur !=null){ ?>
											 <li id="menu-academico-avaliacoes" ><a href="categorie.php">Catégories</a></li>
											 	<?php } ?>
											 <li id="menu-academico-avaliacoes" ><a href="#"><span>Médias</span> <span class="fa fa-angle-right" style="float: right"></span></a>
												 <ul id="menu-academico-sub" style="width: 150px" >
													 <li id="menu-academico-avaliacoes" ><a href="image.php">Images</a></li>
													 <li id="menu-academico-avaliacoes" ><a href="piecejointe.php">Pieces Jointes</a></li>
													 <li id="menu-academico-avaliacoes" ><a href="audio.php">Audios</a></li>
													 <li id="menu-academico-avaliacoes" ><a href="video.php">Videos</a></li>
												 </ul>
											 </li>


										 </ul>
									 </li>

									 <li id="menu-academico" ><a href="#"><i class="lnr lnr-book"></i> <span>Gestion Compte Rendu</span> <span class="fa fa-angle-right" style="float: right"></span></a>
										<ul id="menu-academico-sub" >
											<li id="menu-academico-avaliacoes" ><a href="compte_rendu.php">Compte Rendu</a></li>
											<?php if($resultat !=null || $moderateur !=null){ ?>
											<li id="menu-academico-avaliacoes" ><a href="cr_categorie.php">Catégories</a></li>
												<?php } ?>
											<li id="menu-academico-avaliacoes" ><a href="#"><span>Médias</span> <span class="fa fa-angle-right" style="float: right"></span></a>
												<ul id="menu-academico-sub" style="width: 150px" >
													<li id="menu-academico-avaliacoes" ><a href="cr_image.php">Images</a></li>
													<li id="menu-academico-avaliacoes" ><a href="cr_piecejointe.php">Pieces Jointes</a></li>
													<li id="menu-academico-avaliacoes" ><a href="cr_audio.php">Audios</a></li>
													<li id="menu-academico-avaliacoes" ><a href="cr_video.php">Videos</a></li>
												</ul>
											</li>


										</ul>
									</li>
									<?php if($resultat !=null || $moderateur !=null){ ?>
									<li><a href="contribution.php"><i class="lnr lnr-book"></i> <span>Gestion Contributions</span></a></li>

									<li><a href="planning.php"><i class="lnr lnr-book"></i> <span>Gestion Planning</span></a></li>


										<li><a href="bloc_contri.php"><i class="lnr lnr-book"></i> <span>Bloc Contribution</span></a></li>
											<?php } ?>


								  </ul>
								</div>
							   <?php /* } */?>
							  </div>
