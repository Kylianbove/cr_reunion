<?php
$selectbloc_contri = $connexion->prepare("SELECT * FROM bloc_contri");
$selectbloc_contri->execute();
$bloc_contri = $selectbloc_contri->fetch();

  ?>

<div class="droiteContent">
<h3>Vous souhaitez contribuer ?</h3>
<div class="accroche">

<?php
 if(isset($_SESSION['Username'])){
   echo $bloc_contri['accroche'];
 }else{
   echo "Pour pouvoir contribuer veuillez vous connecter ou vous inscrire.";
 }
 ?>
</div>

</div>
<a href="contribution.php" class="linkBar">Laissez une contribution</a>

<a href="contact.php" class="linkBar">Contactez-nous</a>
